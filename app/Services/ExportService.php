<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Models\ExportHistory;

class ExportService implements BaseService
{
    private const CHUNK_SIZE = 1000;
    private const SUPPORTED_LOCALES = ['az', 'en', 'ru'];

    public function store($data)
    {
        throw new \Exception('Not implemented');
    }

    public function update(array $array, $model)
    {
        throw new \Exception('Not implemented');
    }

    public function saveTranslatable($data, $id)
    {
        throw new \Exception('Not implemented');
    }

    public function validateImportData(array $data, string $modelKey): array
    {
        // Export doesn't need import validation
        return ['valid' => true, 'errors' => []];
    }

    public function processImportBatch(array $batch, string $modelKey, array $mapping = []): array
    {
        // Export doesn't process imports
        return [];
    }

    public function exportData(array $filters = [], array $fields = []): Collection
    {
        $modelKey = $filters['model'] ?? 'service';
        $modelClass = 'App\\Models\\' . Str::studly($modelKey);

        if (!class_exists($modelClass)) {
            Log::error("Export failed: Model {$modelClass} not found");
            return collect([]);
        }

        try {
            $query = $modelClass::query();

            // Apply filters
            $this->applyFilters($query, $filters);

            // Select specific fields or all
            if (!empty($fields)) {
                $query->select($fields);
            }

            // Handle translatable models
            $instance = new $modelClass;
            if (method_exists($instance, 'getTranslatedAttributes')) {
                $translatedAttrs = $instance->getTranslatedAttributes();
                $query->with('translations');
            }

            return $query->get();
        } catch (\Exception $e) {
            Log::error('Export data retrieval failed: ' . $e->getMessage());
            return collect([]);
        }
    }

    public function getImportValidationRules(string $modelKey): array
    {
        return [];
    }

    public function getExportFields(string $modelKey): array
    {
        $modelClass = 'App\\Models\\' . Str::studly($modelKey);
        if (!class_exists($modelClass)) {
            return [];
        }

        $instance = new $modelClass;
        $fields = $instance->getFillable();

        // Add translated fields
        $translatedAttrs = $this->getTranslatedAttributes($instance);
        foreach ($translatedAttrs as $attr) {
            foreach (self::SUPPORTED_LOCALES as $locale) {
                $fields[] = $attr . '_' . $locale;
            }
        }

        return array_merge(['id'], $fields);
    }

    private function applyFilters($query, array $filters): void
    {
        // Date range filters
        if (isset($filters['date_from'])) {
            $query->where('created_at', '>=', $filters['date_from']);
        }
        if (isset($filters['date_to'])) {
            $query->where('created_at', '<=', $filters['date_to']);
        }

        // Status filters
        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        // Search filter
        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%");

                // Add translatable search if model supports it
                if (method_exists($q->getModel(), 'getTranslatedAttributes')) {
                    foreach ($q->getModel()->getTranslatedAttributes() as $attr) {
                        $q->orWhereHas('translations', function ($tq) use ($attr, $search) {
                            $tq->where($attr, 'like', "%{$search}%");
                        });
                    }
                }
            });
        }

        // Custom filters based on model
        $this->applyModelSpecificFilters($query, $filters);
    }

    private function applyModelSpecificFilters($query, array $filters): void
    {
        $modelClass = get_class($query->getModel());

        switch ($modelClass) {
            case 'App\\Models\\Service':
                if (isset($filters['category_id'])) {
                    $query->where('category_id', $filters['category_id']);
                }
                if (isset($filters['is_featured'])) {
                    $query->where('is_featured', $filters['is_featured']);
                }
                break;

            case 'App\\Models\\Portfolio':
                if (isset($filters['category_id'])) {
                    $query->where('category_id', $filters['category_id']);
                }
                break;

            case 'App\\Models\\Blog':
                if (isset($filters['user_id'])) {
                    $query->where('user_id', $filters['user_id']);
                }
                break;
        }
    }

    private function getTranslatedAttributes($model): array
    {
        return method_exists($model, 'getTranslatedAttributes') ? $model->getTranslatedAttributes() : [];
    }

    // === EXPORT UTILITIES ===
    public function generateExportFile(Collection $data, string $format, array $fields = []): string
    {
        $filename = 'export_' . now()->format('Y-m-d_H-i-s') . '.' . $format;

        switch ($format) {
            case 'csv':
                return $this->generateCsv($data, $fields, $filename);
            case 'xlsx':
                return $this->generateExcel($data, $fields, $filename);
            case 'json':
                return $this->generateJson($data, $fields, $filename);
            default:
                throw new \InvalidArgumentException("Unsupported format: {$format}");
        }
    }

    private function generateCsv(Collection $data, array $fields, string $filename): string
    {
        $path = 'exports/' . $filename;
        $handle = fopen(storage_path('app/public/' . $path), 'w');

        // Write headers
        if (!empty($fields)) {
            fputcsv($handle, $fields);
        } else {
            fputcsv($handle, array_keys($data->first()->toArray()));
        }

        // Write data in chunks
        $data->chunk(self::CHUNK_SIZE)->each(function ($chunk) use ($handle, $fields) {
            foreach ($chunk as $row) {
                $rowData = $this->prepareRowData($row, $fields);
                fputcsv($handle, $rowData);
            }
        });

        fclose($handle);
        return $path;
    }

    private function generateExcel(Collection $data, array $fields, string $filename): string
    {
        // Use Laravel Excel package if available
        if (class_exists('\Maatwebsite\Excel\Facades\Excel')) {
            $path = 'exports/' . $filename;
            \Maatwebsite\Excel\Facades\Excel::store(
                new class($data, $fields) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
                    private $data;
                    private $fields;

                    public function __construct($data, $fields) {
                        $this->data = $data;
                        $this->fields = $fields;
                    }

                    public function collection() {
                        return $this->data->map(function ($row) {
                            return $this->prepareRowData($row, $this->fields);
                        });
                    }

                    public function headings(): array {
                        return $this->fields;
                    }

                    private function prepareRowData($row, $fields) {
                        if (empty($fields)) {
                            return $row->toArray();
                        }
                        return collect($fields)->mapWithKeys(function ($field) use ($row) {
                            return [$field => $row->$field ?? ''];
                        })->toArray();
                    }
                },
                $path,
                'public'
            );
            return $path;
        }

        // Fallback to CSV
        return $this->generateCsv($data, $fields, str_replace('.xlsx', '.csv', $filename));
    }

    private function generateJson(Collection $data, array $fields, string $filename): string
    {
        $path = 'exports/' . $filename;
        $jsonData = $data->map(function ($row) use ($fields) {
            return $this->prepareRowData($row, $fields);
        })->toJson(JSON_PRETTY_PRINT);

        \Illuminate\Support\Facades\Storage::disk('public')->put($path, $jsonData);
        return $path;
    }

    private function prepareRowData($row, array $fields = []): array
    {
        $rowArray = $row->toArray();

        // Handle translations
        if (isset($rowArray['translations']) && is_array($rowArray['translations'])) {
            foreach ($rowArray['translations'] as $translation) {
                $locale = $translation['locale'];
                foreach ($translation as $key => $value) {
                    if ($key !== 'locale' && $key !== 'id') {
                        $rowArray[$key . '_' . $locale] = $value;
                    }
                }
            }
            unset($rowArray['translations']);
        }

        if (!empty($fields)) {
            return collect($fields)->mapWithKeys(function ($field) use ($rowArray) {
                return [$field => $rowArray[$field] ?? ''];
            })->toArray();
        }

        return $rowArray;
    }

    // === UTILITY METHODS ===
    public static function getAllowedModels(): array
    {
        return [
            'service' => 'admin.service.create',
            'portfolio' => 'admin.portfolio.create',
            'blog' => 'admin.blog.create',
            'bcategory' => 'admin.bcategory.create',
            'pcategory' => 'admin.pcategory.create',
            'testimonial' => 'admin.testimonial.create',
            'partner' => 'admin.partner.create',
            'pricing-plan' => 'admin.pricing-plan.create',
            'team-member' => 'admin.team-member.create',
            'faq' => 'admin.faq.create',
            'tag' => 'admin.tag.create',
            'step' => 'admin.step.create',
            'sp-content' => 'admin.sp-content.create',
            'content-text' => 'admin.content-text.create',
            'social-media' => 'admin.social-media.create',
        ];
    }

    public static function isModelAllowed(string $model): bool
    {
        return isset(self::getAllowedModels()[Str::kebab($model)]);
    }
}