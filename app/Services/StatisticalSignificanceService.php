<?php

namespace App\Services;

use App\Models\Experiment;
use App\Models\ExperimentResult;
use App\Models\ExperimentVariant;
use Illuminate\Support\Facades\DB;

class StatisticalSignificanceService
{
    /**
     * Confidence levels
     */
    public const CONFIDENCE_90 = 0.90;
    public const CONFIDENCE_95 = 0.95;
    public const CONFIDENCE_99 = 0.99;

    /**
     * Calculate statistical significance for an experiment
     */
    public static function calculate(int $experimentId): array
    {
        $experiment = Experiment::with('variants', 'results')->findOrFail($experimentId);

        $variants = $experiment->variants;
        $controlVariant = $variants->where('is_control', true)->first();
        $treatmentVariants = $variants->where('is_control', false);

        if (!$controlVariant) {
            return ['error' => 'No control variant found'];
        }

        $results = [];

        foreach ($treatmentVariants as $variant) {
            $results[] = self::calculateVariantSignificance(
                $experiment,
                $controlVariant,
                $variant
            );
        }

        return [
            'experiment_id' => $experimentId,
            'experiment_name' => $experiment->name,
            'status' => $experiment->status,
            'control_variant' => [
                'id' => $controlVariant->id,
                'name' => $controlVariant->name,
                'traffic_weight' => $controlVariant->traffic_weight,
            ],
            'treatment_variants' => $results,
            'overall' => self::getOverallSignificance($results),
            'calculated_at' => now()->toIso8601String(),
        ];
    }

    /**
     * Calculate significance for a single variant vs control
     */
    public static function calculateVariantSignificance(
        Experiment $experiment,
        ExperimentVariant $control,
        ExperimentVariant $treatment
    ): array {
        // Get results for each variant
        $controlResults = ExperimentResult::where('variant_id', $control->id)->get();
        $treatmentResults = ExperimentResult::where('variant_id', $treatment->id)->get();

        $controlConversions = $controlResults->sum('conversions');
        $treatmentConversions = $treatmentResults->sum('conversions');
        $controlVisitors = $controlResults->sum('total_visitors') ?? self::estimateVisitors($control->id);
        $treatmentVisitors = $treatmentResults->sum('total_visitors') ?? self::estimateVisitors($treatment->id);

        // Calculate conversion rates
        $controlRate = $controlVisitors > 0 ? $controlConversions / $controlVisitors : 0;
        $treatmentRate = $treatmentVisitors > 0 ? $treatmentConversions / $treatmentVisitors : 0;

        // Calculate statistical significance (Z-test)
        $zScore = self::calculateZScore($controlRate, $treatmentRate, $controlVisitors, $treatmentVisitors);
        $pValue = self::calculatePValue($zScore);
        $confidence = 1 - $pValue;

        // Calculate relative improvement
        $improvement = $controlRate > 0
            ? (($treatmentRate - $controlRate) / $controlRate) * 100
            : 0;

        // Determine if result is significant
        $isSignificant = $confidence >= self::CONFIDENCE_95;
        $winner = $treatmentRate > $controlRate ? $treatment->id : ($controlRate > $treatmentRate ? $control->id : null);

        return [
            'variant_id' => $treatment->id,
            'variant_name' => $treatment->name,
            'is_control' => false,
            'visitors' => $treatmentVisitors,
            'conversions' => $treatmentConversions,
            'conversion_rate' => round($treatmentRate * 100, 2),
            'control_conversion_rate' => round($controlRate * 100, 2),
            'relative_improvement' => round($improvement, 2),
            'absolute_improvement' => round(($treatmentRate - $controlRate) * 100, 4),
            'z_score' => round($zScore, 4),
            'p_value' => round($pValue, 6),
            'confidence' => round($confidence * 100, 2),
            'is_significant' => $isSignificant,
            'significant_at_90' => $confidence >= self::CONFIDENCE_90,
            'significant_at_95' => $confidence >= self::CONFIDENCE_95,
            'significant_at_99' => $confidence >= self::CONFIDENCE_99,
            'recommended_action' => self::getRecommendation($isSignificant, $improvement, $treatmentRate > $controlRate),
            'winner' => $winner,
        ];
    }

    /**
     * Calculate Z-score for two proportions
     */
    protected static function calculateZScore(
        float $p1,
        float $p2,
        int $n1,
        int $n2
    ): float {
        if ($n1 === 0 || $n2 === 0) {
            return 0;
        }

        // Pooled proportion
        $pPooled = ($p1 * $n1 + $p2 * $n2) / ($n1 + $n2);

        if ($pPooled === 0 || $pPooled === 1) {
            return 0;
        }

        // Standard error
        $se = sqrt($pPooled * (1 - $pPooled) * (1 / $n1 + 1 / $n2));

        if ($se === 0) {
            return 0;
        }

        return ($p2 - $p1) / $se;
    }

    /**
     * Calculate p-value from Z-score
     */
    protected static function calculatePValue(float $zScore): float
    {
        // Approximation of cumulative normal distribution
        $z = abs($zScore);

        // Coefficients for approximation
        $a1 = 0.254829592;
        $a2 = -0.284496736;
        $a3 = 1.421413741;
        $a4 = -1.453152027;
        $a5 = 1.061405429;

        $p = 1 / (1 + 0.2316419 * $z);
        $y = 0.5 * exp(-$z * $z / 2);

        $cdf = $y * ($a1 * $p + $a2 * $p * $p + $a3 * pow($p, 3) + $a4 * pow($p, 4) + $a5 * pow($p, 5));

        return 2 * $cdf; // Two-tailed p-value
    }

    /**
     * Estimate total visitors for a variant
     */
    protected static function estimateVisitors(int $variantId): int
    {
        $count = ExperimentResult::where('variant_id', $variantId)->count();
        return $count * 100; // Rough estimate
    }

    /**
     * Get recommendation based on results
     */
    protected static function getRecommendation(
        bool $isSignificant,
        float $improvement,
        bool $treatmentIsBetter
    ): string {
        if (!$isSignificant) {
            return 'continue_testing';
        }

        if ($improvement > 10 && $treatmentIsBetter) {
            return 'declare_winner';
        }

        if ($improvement < -5 && !$treatmentIsBetter) {
            return 'stop_testing';
        }

        if ($treatmentIsBetter) {
            return 'consider_winner';
        }

        return 'keep_testing';
    }

    /**
     * Get overall significance across all variants
     */
    protected static function getOverallSignificance(array $results): array
    {
        if (empty($results)) {
            return ['has_significant' => false, 'average_confidence' => 0];
        }

        $significantCount = count(array_filter($results, fn($r) => $r['is_significant'] ?? false));
        $avgConfidence = array_sum(array_column($results, 'confidence')) / count($results);
        $hasWinner = count(array_filter($results, fn($r) => ($r['winner'] ?? null) !== null)) > 0;

        return [
            'has_significant' => $significantCount > 0,
            'significant_variants' => $significantCount,
            'total_variants' => count($results),
            'average_confidence' => round($avgConfidence, 2),
            'has_winner' => $hasWinner,
        ];
    }

    /**
     * Calculate sample size needed for significance
     */
    public static function calculateRequiredSampleSize(
        float $baselineRate,
        float $minimumDetectableEffect,
        float $confidence = self::CONFIDENCE_95,
        float $power = 0.80
    ): int {
        // Simplified sample size calculation
        $p1 = $baselineRate;
        $p2 = $baselineRate * (1 + $minimumDetectableEffect / 100);

        if ($p1 <= 0 || $p1 >= 1 || $p2 <= 0 || $p2 >= 1) {
            return 0;
        }

        $avgP = ($p1 + $p2) / 2;
        $effect = abs($p2 - $p1);

        // Z-scores for alpha and power
        $zAlpha = self::getZScoreForConfidence($confidence);
        $zBeta = self::getZScoreForPower($power);

        // Sample size formula
        $numerator = pow($zAlpha * sqrt(2 * $avgP * (1 - $avgP)) + $zBeta * sqrt($p1 * (1 - $p1) + $p2 * (1 - $p2)), 2);
        $sampleSize = $numerator / pow($effect, 2);

        return (int)ceil($sampleSize);
    }

    /**
     * Get Z-score for confidence level
     */
    protected static function getZScoreForConfidence(float $confidence): float
    {
        return match (true) {
            $confidence >= 0.99 => 2.576,
            $confidence >= 0.95 => 1.96,
            $confidence >= 0.90 => 1.645,
            default => 1.28,
        };
    }

    /**
     * Get Z-score for statistical power
     */
    protected static function getZScoreForPower(float $power): float
    {
        return match (true) {
            $power >= 0.90 => 1.28,
            $power >= 0.80 => 0.84,
            default => 0.5,
        };
    }

    /**
     * Get real-time metrics for an experiment
     */
    public static function getRealtimeMetrics(int $experimentId): array
    {
        $experiment = Experiment::with('variants')->findOrFail($experimentId);
        $metrics = [];

        foreach ($experiment->variants as $variant) {
            $results = ExperimentResult::where('variant_id', $variant->id)
                ->where('created_at', '>=', now()->subHours(24))
                ->get();

            $metrics[] = [
                'variant_id' => $variant->id,
                'variant_name' => $variant->name,
                'is_control' => $variant->is_control,
                'visitors' => $results->sum('total_visitors') ?? 0,
                'conversions' => $results->sum('conversions') ?? 0,
                'revenue' => $results->sum('revenue') ?? 0,
                'last_24h_visitors' => $results->sum('visitors_24h') ?? 0,
                'last_24h_conversions' => $results->sum('conversions_24h') ?? 0,
            ];
        }

        return $metrics;
    }

    /**
     * Calculate bayesian probability of being best
     */
    public static function calculateProbabilityBest(int $experimentId): array
    {
        $experiment = Experiment::with('variants')->findOrFail($experimentId);
        $variants = $experiment->variants;

        $totalRevenue = $variants->sum(fn($v) => ExperimentResult::where('variant_id', $v->id)->sum('revenue'));

        if ($totalRevenue === 0) {
            return $variants->map(fn($v) => [
                'variant_id' => $v->id,
                'variant_name' => $v->name,
                'probability_best' => 1 / count($variants),
            ])->toArray();
        }

        return $variants->map(function ($variant) use ($totalRevenue) {
            $variantRevenue = ExperimentResult::where('variant_id', $variant->id)->sum('revenue');
            $probability = $totalRevenue > 0 ? $variantRevenue / $totalRevenue : 0;

            return [
                'variant_id' => $variant->id,
                'variant_name' => $variant->name,
                'probability_best' => round($probability * 100, 2),
            ];
        })->toArray();
    }
}