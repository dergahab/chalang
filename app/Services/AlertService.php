<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AlertService
{
    /**
     * Alert channels
     */
    public const CHANNEL_EMAIL = 'email';
    public const CHANNEL_SLACK = 'slack';
    public const CHANNEL_WEBHOOK = 'webhook';
    public const CHANNEL_LOG = 'log';

    /**
     * Alert types
     */
    public const TYPE_ERROR = 'error';
    public const TYPE_WARNING = 'warning';
    public const TYPE_INFO = 'info';
    public const TYPE_SUCCESS = 'success';
    public const TYPE_CRITICAL = 'critical';

    /**
     * Alert rules configuration
     */
    protected static array $rules = [];

    /**
     * Initialize default rules
     */
    public static function initRules(): void
    {
        self::$rules = [
            // High error rate
            [
                'name' => 'High Error Rate',
                'condition' => 'error_rate_above',
                'threshold' => 5, // 5%
                'period_minutes' => 5,
                'channel' => [self::CHANNEL_EMAIL, self::CHANNEL_SLACK],
                'enabled' => true,
            ],

            // Slow response time
            [
                'name' => 'Slow Response',
                'condition' => 'response_time_above',
                'threshold' => 3000, // 3 seconds
                'period_minutes' => 5,
                'channel' => [self::CHANNEL_LOG],
                'enabled' => true,
            ],

            // Failed login attempts
            [
                'name' => 'Failed Logins',
                'condition' => 'failed_logins_above',
                'threshold' => 10,
                'period_minutes' => 15,
                'channel' => [self::CHANNEL_EMAIL],
                'enabled' => true,
            ],

            // Low disk space
            [
                'name' => 'Low Disk Space',
                'condition' => 'disk_space_below',
                'threshold' => 10, // 10%
                'period_minutes' => 60,
                'channel' => [self::CHANNEL_EMAIL, self::CHANNEL_SLACK],
                'enabled' => true,
            ],

            // High memory usage
            [
                'name' => 'High Memory',
                'condition' => 'memory_usage_above',
                'threshold' => 80, // 80%
                'period_minutes' => 10,
                'channel' => [self::CHANNEL_SLACK],
                'enabled' => true,
            ],

            // Failed bulk operations
            [
                'name' => 'Bulk Operation Failed',
                'condition' => 'bulk_failures',
                'threshold' => 3,
                'period_minutes' => 30,
                'channel' => [self::CHANNEL_EMAIL, self::CHANNEL_SLACK],
                'enabled' => true,
            ],

            // Experiment completed (success)
            [
                'name' => 'Experiment Complete',
                'condition' => 'experiment_completed',
                'period_minutes' => 1,
                'channel' => [self::CHANNEL_EMAIL],
                'enabled' => false,
            ],
        ];
    }

    /**
     * Send alert notification
     */
    public static function alert(
        string $type,
        string $title,
        string $message,
        array $data = [],
        ?string $channel = null
    ): void {
        $channel = $channel ?? config('alert.default_channel', self::CHANNEL_LOG);

        $payload = [
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
            'timestamp' => now()->toIso8601String(),
            'environment' => app()->environment(),
            'url' => request()?->fullUrl() ?? null,
        ];

        match ($channel) {
            self::CHANNEL_EMAIL => self::sendEmail($payload),
            self::CHANNEL_SLACK => self::sendSlack($payload),
            self::CHANNEL_WEBHOOK => self::sendWebhook($payload),
            default => self::sendLog($payload),
        };
    }

    /**
     * Send error alert
     */
    public static function error(string $title, string $message, array $data = []): void
    {
        self::alert(self::TYPE_ERROR, $title, $message, $data);
    }

    /**
     * Send warning alert
     */
    public static function warning(string $title, string $message, array $data = []): void
    {
        self::alert(self::TYPE_WARNING, $title, $message, $data);
    }

    /**
     * Send critical alert
     */
    public static function critical(string $title, string $message, array $data = []): void
    {
        self::alert(self::TYPE_CRITICAL, $title, $message, $data);

        // Also send to all channels for critical
        foreach ([self::CHANNEL_EMAIL, self::CHANNEL_SLACK] as $channel) {
            self::alert(self::TYPE_CRITICAL, $title, $message, $data, $channel);
        }
    }

    /**
     * Send success alert
     */
    public static function success(string $title, string $message, array $data = []): void
    {
        self::alert(self::TYPE_SUCCESS, $title, $message, $data);
    }

    /**
     * Send info alert
     */
    public static function info(string $title, string $message, array $data = []): void
    {
        self::alert(self::TYPE_INFO, $title, $message, $data);
    }

    /**
     * Send email notification
     */
    protected static function sendEmail(array $payload): void
    {
        try {
            $emails = config('alert.emails', []);

            if (empty($emails)) {
                return;
            }

            // Queue email for sending
            foreach ($emails as $email) {
                Mail::raw($payload['message'], function ($message) use ($email, $payload) {
                    $message->to($email)
                        ->subject("[" . strtoupper($payload['type']) . "] {$payload['title']}");
                });
            }
        } catch (\Exception $e) {
            Log::error('Alert email failed: ' . $e->getMessage());
        }
    }

    /**
     * Send Slack notification
     */
    protected static function sendSlack(array $payload): void
    {
        try {
            $webhookUrl = config('alert.slack_webhook');

            if (!$webhookUrl) {
                return;
            }

            $color = match ($payload['type']) {
                self::TYPE_CRITICAL => '#ff0000',
                self::TYPE_ERROR => '#ff4444',
                self::TYPE_WARNING => '#ffaa00',
                self::TYPE_SUCCESS => '#00cc00',
                default => '#0099ff',
            };

            $fields = [];
            foreach ($payload['data'] ?? [] as $key => $value) {
                $fields[] = [
                    'title' => ucfirst($key),
                    'value' => is_array($value) ? json_encode($value) : $value,
                    'short' => true,
                ];
            }

            $message = [
                'attachments' => [
                    [
                        'color' => $color,
                        'title' => $payload['title'],
                        'text' => $payload['message'],
                        'fields' => $fields,
                        'footer' => 'Chalang CMS',
                        'ts' => time(),
                    ]
                ]
            ];

            Http::post($webhookUrl, $message);
        } catch (\Exception $e) {
            Log::error('Alert Slack failed: ' . $e->getMessage());
        }
    }

    /**
     * Send webhook notification
     */
    protected static function sendWebhook(array $payload): void
    {
        try {
            $webhookUrl = config('alert.webhook_url');

            if (!$webhookUrl) {
                return;
            }

            Http::post($webhookUrl, $payload);
        } catch (\Exception $e) {
            Log::error('Alert webhook failed: ' . $e->getMessage());
        }
    }

    /**
     * Log alert
     */
    protected static function sendLog(array $payload): void
    {
        $level = match ($payload['type']) {
            self::TYPE_CRITICAL => 'critical',
            self::TYPE_ERROR => 'error',
            self::TYPE_WARNING => 'warning',
            self::TYPE_SUCCESS => 'info',
            default => 'info',
        };

        Log::$level("[ALERT] {$payload['title']}: {$payload['message']}");
    }

    /**
     * Check all alert conditions
     */
    public static function checkConditions(): array
    {
        self::initRules();

        $triggered = [];

        foreach (self::$rules as $rule) {
            if (!($rule['enabled'] ?? false)) {
                continue;
            }

            if (self::evaluateRule($rule)) {
                $triggered[] = [
                    'rule' => $rule['name'],
                    'triggered_at' => now()->toIso8601String(),
                ];
            }
        }

        return $triggered;
    }

    /**
     * Evaluate single rule
     */
    protected static function evaluateRule(array $rule): bool
    {
        $condition = $rule['condition'] ?? null;
        $threshold = $rule['threshold'] ?? 0;
        $period = $rule['period_minutes'] ?? 5;

        return match ($condition) {
            'error_rate_above' => self::checkErrorRate($threshold, $period),
            'response_time_above' => self::checkResponseTime($threshold, $period),
            'failed_logins_above' => self::checkFailedLogins($threshold, $period),
            'disk_space_below' => self::checkDiskSpace($threshold),
            'memory_usage_above' => self::checkMemoryUsage($threshold),
            'bulk_failures' => self::checkBulkFailures($threshold, $period),
            default => false,
        };
    }

    /**
     * Check error rate
     */
    protected static function checkErrorRate(float $threshold, int $periodMinutes): bool
    {
        $from = now()->subMinutes($periodMinutes);

        $total = ActivityLog::where('created_at', '>=', $from)->count();
        $failed = ActivityLog::where('created_at', '>=', $from)
            ->where('status', 'failed')
            ->count();

        if ($total === 0) {
            return false;
        }

        $errorRate = ($failed / $total) * 100;

        if ($errorRate > $threshold) {
            self::warning(
                'High Error Rate',
                "Error rate is {$errorRate}% (threshold: {$threshold}%)",
                ['error_rate' => $errorRate, 'threshold' => $threshold]
            );
        }

        return $errorRate > $threshold;
    }

    /**
     * Check response time
     */
    protected static function checkResponseTime(int $thresholdMs, int $periodMinutes): bool
    {
        $from = now()->subMinutes($periodMinutes);

        $avgTime = ActivityLog::where('created_at', '>=', $from)
            ->whereNotNull('duration_ms')
            ->avg('duration_ms');

        if ($avgTime && $avgTime > $thresholdMs) {
            self::warning(
                'Slow Response Time',
                "Average response time is " . round($avgTime) . "ms",
                ['avg_response_time' => $avgTime, 'threshold' => $thresholdMs]
            );
        }

        return $avgTime > $thresholdMs;
    }

    /**
     * Check failed logins
     */
    protected static function checkFailedLogins(int $threshold, int $periodMinutes): bool
    {
        $from = now()->subMinutes($periodMinutes);

        $failed = ActivityLog::where('created_at', '>=', $from)
            ->where('action', 'login')
            ->where('status', 'failed')
            ->count();

        if ($failed > $threshold) {
            self::warning(
                'Multiple Failed Login Attempts',
                "{$failed} failed login attempts in {$periodMinutes} minutes",
                ['failed_attempts' => $failed, 'threshold' => $threshold]
            );
        }

        return $failed > $threshold;
    }

    /**
     * Check disk space
     */
    protected static function checkDiskSpace(float $thresholdPercent): bool
    {
        $free = disk_free_space(base_path());
        $total = disk_total_space(base_path());
        $percentFree = ($free / $total) * 100;

        if ($percentFree < $thresholdPercent) {
            self::critical(
                'Low Disk Space',
                "Only " . round($percentFree, 1) . "% disk space remaining",
                ['disk_free_percent' => $percentFree, 'threshold' => $thresholdPercent]
            );
        }

        return $percentFree < $thresholdPercent;
    }

    /**
     * Check memory usage
     */
    protected static function checkMemoryUsage(float $thresholdPercent): bool
    {
        $used = memory_get_usage(true);
        $limit = memory_limit();

        if ($limit <= 0) {
            return false;
        }

        $percentUsed = ($used / $limit) * 100;

        if ($percentUsed > $thresholdPercent) {
            self::warning(
                'High Memory Usage',
                "Memory usage at " . round($percentUsed, 1) . "%",
                ['memory_percent' => $percentUsed, 'threshold' => $thresholdPercent]
            );
        }

        return $percentUsed > $thresholdPercent;
    }

    /**
     * Check bulk operation failures
     */
    protected static function checkBulkFailures(int $threshold, int $periodMinutes): bool
    {
        $from = now()->subMinutes($periodMinutes);

        $failed = ActivityLog::where('created_at', '>=', $from)
            ->whereIn('action', ['bulk_delete', 'bulk_update', 'bulk_create'])
            ->where('status', 'failed')
            ->count();

        if ($failed > $threshold) {
            self::error(
                'Bulk Operations Failing',
                "{$failed} bulk operations failed in {$periodMinutes} minutes",
                ['failed_count' => $failed, 'threshold' => $threshold]
            );
        }

        return $failed > $threshold;
    }

    /**
     * Get alert configuration
     */
    public static function getConfig(): array
    {
        return [
            'channels' => [
                'email' => !empty(config('alert.emails', [])),
                'slack' => !empty(config('alert.slack_webhook')),
                'webhook' => !empty(config('alert.webhook_url')),
            ],
            'rules' => self::$rules,
        ];
    }
}