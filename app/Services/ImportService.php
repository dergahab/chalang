<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Models\ImportHistory;
use App\Jobs\ProcessImportJob;

class ImportService implements BaseService
{
    public const BATCH_SIZE = 1000;
    public const MAX_FILE_SIZE = 51200;
    public const PREVIEW_ROWS = 10;
    private const SUPPORTED_LOCALES = ['az', 'en', 'ru'];

    private const VALIDATION_RULES = [
        'service' => [
            'title_az' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|regex:/^[a-z0-9-]+$/',
            'order' => 'nullable|integer|min:0',
            'is_featured' => 'nullable|boolean',
        ],
        'portfolio' => [
            'title_az' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|regex:/^[a-z0-9-]+$/',
            'order' => 'nullable|integer|min:0',
        ],
        'blog' => [
            'title_az' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|regex:/^[a-z0-9-]+$/',
        ],
        'default' => [
            'id' => 'nullable|integer',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ],
    ];

    public function store($data)
    {
        // Implement basic store if needed
        throw new \Exception('Not implemented');
    }

    public function update(array $array, $model)
    {
        // Implement basic update if needed
        throw new \Exception('Not implemented');
    }

    public function saveTranslatable($data, $id)
    {
        // Implement basic translatable save if needed
        throw new \Exception('Not implemented');
    }

    public function validateImportData(array $data, string $modelKey): array
    {
        $rules = $this->getImportValidationRules($modelKey);
        $validator = \Illuminate\Support\Facades\Validator::make($data, $rules);

        if ($validator->fails()) {
            return [
                'valid' => false,
                'errors' => $validator->errors()->toArray(),
                'critical_errors' => $this->getCriticalErrors($validator->errors(), $modelKey),
            ];
        }

        // Additional business logic validation
        $businessErrors = $this->validateBusinessLogic($data, $modelKey);

        if (!empty($businessErrors)) {
            return [
                'valid' => false,
                'errors' => $businessErrors,
                'critical_errors' => $businessErrors, // Business logic errors are critical
            ];
        }

        return ['valid' => true, 'errors' => [], 'critical_errors' => []];
    }

    private function getCriticalErrors(\Illuminate\Support\MessageBag $errors, string $modelKey): array
    {
        $criticalFields = [
            'service' => ['title_az', 'title_en'],
            'portfolio' => ['title_az', 'title_en'],
            'blog' => ['title_az'],
            'default' => ['id'],
        ];

        $critical = $criticalFields[$modelKey] ?? $criticalFields['default'];
        $criticalErrors = [];

        foreach ($critical as $field) {
            if ($errors->has($field)) {
                $criticalErrors[$field] = $errors->get($field);
            }
        }

        return $criticalErrors;
    }

    private function validateBusinessLogic(array $data, string $modelKey): array
    {
        $errors = [];

        // Slug uniqueness check
        if (isset($data['slug']) && !empty($data['slug'])) {
            $modelClass = 'App\\Models\\' . Str::studly($modelKey);
            $query = $modelClass::where('slug', $data['slug']);

            if (isset($data['id'])) {
                $query->where('id', '!=', $data['id']);
            }

            if ($query->exists()) {
                $errors['slug'] = ['Slug must be unique'];
            }
        }

        // Order validation
        if (isset($data['order']) && $data['order'] < 0) {
            $errors['order'] = ['Order must be non-negative'];
        }

        // URL validation for link fields
        $urlFields = ['website', 'url', 'link'];
        foreach ($urlFields as $field) {
            if (isset($data[$field]) && !empty($data[$field]) && !filter_var($data[$field], FILTER_VALIDATE_URL)) {
                $errors[$field] = ['Invalid URL format'];
            }
        }

        // Email validation
        if (isset($data['email']) && !empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = ['Invalid email format'];
        }

        return $errors;
    }

    public function processImportBatch(array $batch, string $modelKey, array $mapping = []): array
    {
        $modelClass = 'App\\Models\\' . Str::studly($modelKey);
        $results = [
            'created' => 0,
            'updated' => 0,
            'failed' => 0,
            'errors' => [],
            'created_ids' => [],
            'updated_snapshots' => [],
        ];

        DB::beginTransaction();
        try {
            foreach ($batch as $row) {
                $mappedData = $this->mapRowData($row, $mapping, $modelKey);

                $validation = $this->validateImportData($mappedData, $modelKey);
                if (!$validation['valid']) {
                    $results['failed']++;
                    $results['errors'][] = $validation['errors'];
                    continue;
                }

                $existing = null;
                if (isset($mappedData['id'])) {
                    $existing = $modelClass::find($mappedData['id']);
                }

                if ($existing) {
                    $results['updated']++;
                    $results['updated_snapshots'][$existing->id] = [
                        'before' => $existing->getOriginal(),
                    ];
                    $existing->update($mappedData);
                } else {
                    $created = $modelClass::create($mappedData);
                    $results['created']++;
                    $results['created_ids'][] = $created->id;
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Import batch failed: ' . $e->getMessage());
            $results['failed'] = count($batch);
            $results['errors'][] = $e->getMessage();
        }

        return $results;
    }

    public function exportData(array $filters = [], array $fields = []): \Illuminate\Support\Collection
    {
        // Generic export - override in specific services
        return collect([]);
    }

    public function getImportValidationRules(string $modelKey): array
    {
        return self::VALIDATION_RULES[$modelKey] ?? self::VALIDATION_RULES['default'];
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

    public function getImportFieldDefinitions(string $modelKey): array
    {
        $fields = $this->getExportFields($modelKey);

        return collect($fields)->mapWithKeys(function ($field) {
            $label = Str::title(str_replace(['_', '-'], ' ', $field));
            $required = in_array($field, ['title_az', 'title_en', 'slug']);
            return [$field => [
                'label' => $label,
                'required' => $required,
            ]];
        })->toArray();
    }

    public function generateImportTemplate(string $modelKey, string $format = 'csv'): string
    {
        $fields = array_keys($this->getImportFieldDefinitions($modelKey));
        $filename = sprintf('%s_import_template_%s.%s', $modelKey, now()->format('Ymd_His'), $format);
        $path = 'import-templates/' . $filename;

        if ($format === 'json') {
            $sample = [array_fill_keys($fields, '')];
            Storage::disk('public')->put($path, json_encode($sample, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            return $path;
        }

        if ($format === 'xlsx' && class_exists('PhpOffice\\PhpSpreadsheet\\Spreadsheet')) {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->fromArray([$fields], null, 'A1');
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            
            ob_start();
            $writer->save('php://output');
            $content = ob_get_clean();
            Storage::disk('public')->put($path, $content);
            return $path;
        }

        // CSV
        $handle = fopen('php://temp', 'r+');
        fwrite($handle, "\xEF\xBB\xBF");
        fputcsv($handle, $fields);
        rewind($handle);
        $csvContent = stream_get_contents($handle);
        fclose($handle);

        Storage::disk('public')->put($path, $csvContent);
        return $path;
    }

    public function parseUploadedFile(UploadedFile $file, int $limit = null): array
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $path = $file->getRealPath();

        switch ($extension) {
            case 'csv':
            case 'txt':
                return $this->parseCsv($path, $limit);
            case 'xlsx':
            case 'xls':
                return $this->parseExcel($path, $limit);
            default:
                throw new \Exception('Unsupported file format');
        }
    }

    public function parseFileFromPath(string $relativePath, int $limit = null): array
    {
        $path = storage_path('app/' . $relativePath);
        if (!file_exists($path)) {
            throw new \Exception('File not found: ' . $relativePath);
        }

        return $this->parseUploadedFile(new UploadedFile($path, basename($path), null, null, true), $limit);
    }

    private function parseCsv(string $path, $limit = null): array
    {
        $data = [];
        $handle = fopen($path, 'r');

        if ($handle === false) {
            throw new \Exception('Cannot open file');
        }

        $header = fgetcsv($handle);
        if (!$header) {
            fclose($handle);
            throw new \Exception('Empty or invalid CSV file');
        }

        $rowCount = 0;
        while (($row = fgetcsv($handle)) !== false) {
            if ($limit && $rowCount >= $limit) {
                break;
            }

            if (count($row) === count($header)) {
                $data[] = array_combine($header, $row);
                $rowCount++;
            }
        }

        fclose($handle);
        return $data;
    }

    private function parseExcel(string $path, $limit = null): array
    {
        if (!class_exists('PhpOffice\\PhpSpreadsheet\\IOFactory')) {
            throw new \Exception('Excel parsing not available - PhpSpreadsheet not installed');
        }

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        if (empty($rows)) {
            throw new \Exception('Empty Excel file');
        }

        $header = array_shift($rows);
        $data = [];

        foreach ($rows as $index => $row) {
            if ($limit && $index >= $limit) {
                break;
            }

            if (count($row) === count($header)) {
                $data[] = array_combine($header, $row);
            }
        }

        return $data;
    }

    private function mapRowData(array $row, array $mapping, string $modelKey): array
    {
        $mapped = [];
        foreach ($mapping as $csvField => $dbField) {
            if (isset($row[$csvField])) {
                $mapped[$dbField] = $row[$csvField];
            }
        }
        return $mapped;
    }

    public function getTranslatedAttributes($model): array
    {
        if (is_string($model)) {
            $modelClass = 'App\\Models\\' . Str::studly($model);
            if (!class_exists($modelClass)) {
                return [];
            }
            $model = new $modelClass;
        }

        return method_exists($model, 'getTranslatedAttributes') ? $model->getTranslatedAttributes() : [];
    }

// === PRE-CONFIGURED TEMPLATES ===
    /**
     * Get pre-configured template definitions
     */
    public static function getPreConfiguredTemplates(): array
    {
        return [
            'service' => [
                'name' => 'Xidmətlər (Services)',
                'description' => 'Tam xidmət məlumatları: title_az, title_en, description_az, description_en, slug, order, is_active, is_featured',
                'icon' => 'ri-customer-service-2-line',
                'color' => 'primary',
                'fields' => ['id', 'title_az', 'title_en', 'description_az', 'description_en', 'slug', 'order', 'is_active', 'is_featured'],
            ],
            'portfolio' => [
                'name' => 'Portfolio',
                'description' => 'Portfolio layihələri: title_az, title_en, slug, order, is_active',
                'icon' => 'ri-gallery-line',
                'color' => 'success',
                'fields' => ['id', 'title_az', 'title_en', 'description_az', 'description_en', 'slug', 'order', 'is_active'],
            ],
            'blog' => [
                'name' => 'Blog',
                'description' => 'Blog yazıları: title_az, title_en, slug, content_az, order, is_active',
                'icon' => 'ri-article-line',
                'color' => 'warning',
                'fields' => ['id', 'title_az', 'title_en', 'slug', 'content_az', 'content_en', 'order', 'is_active'],
            ],
            'bcategory' => [
                'name' => 'Blog Kateqoriyaları',
                'description' => 'Blog kateqoriyaları: name_az, name_en, slug, order',
                'icon' => 'ri-bookmark-line',
                'color' => 'info',
                'fields' => ['id', 'name_az', 'name_en', 'slug', 'order'],
            ],
            'pcategory' => [
                'name' => 'Portfolio Kateqoriyaları',
                'description' => 'Portfolio kateqoriyaları: name_az, name_en, slug, order',
                'icon' => 'ri-tags-line',
                'color' => 'purple',
                'fields' => ['id', 'name_az', 'name_en', 'slug', 'order'],
            ],
            'testimonial' => [
                'name' => 'Rəylər (Testimonials)',
                'description' => 'Müştəri rəyləri: name_az, name_en, content_az, content_en, order',
                'icon' => 'ri-chat-quote-line',
                'color' => 'danger',
                'fields' => ['id', 'name_az', 'name_en', 'content_az', 'content_en', 'order', 'is_active'],
            ],
            'partner' => [
                'name' => 'Partnyorlar',
                'description' => 'Partnyor şirkətlər: name_az, name_en, slug, order',
                'icon' => 'ri-handshake-line',
                'color' => 'warning',
                'fields' => ['id', 'name_az', 'name_en', 'slug', 'order', 'is_active'],
            ],
            'faq' => [
                'name' => 'FAQ (Tez-tez suallar)',
                'description' => 'Tez-tez verilən suallar: question_az, question_en, answer_az, answer_en, order',
                'icon' => 'ri-question-answer-line',
                'color' => 'info',
                'fields' => ['id', 'question_az', 'question_en', 'answer_az', 'answer_en', 'order', 'is_active'],
            ],
            'tag' => [
                'name' => 'Teqlər',
                'description' => 'Teqlər: name_az, name_en, slug',
                'icon' => 'ri-price-tag-line',
                'color' => 'primary',
                'fields' => ['id', 'name_az', 'name_en', 'slug'],
            ],
            'team-member' => [
                'name' => 'Komanda Üzvləri',
                'description' => 'Komanda üzvləri: name_az, name_en, position_az, position_en, order',
                'icon' => 'ri-team-line',
                'color' => 'purple',
                'fields' => ['id', 'name_az', 'name_en', 'position_az', 'position_en', 'order', 'is_active'],
            ],
            'pricing-plan' => [
                'name' => 'Qiymət Planları',
                'description' => 'Qiymət planları: title_az, title_en, price, order, is_featured',
                'icon' => 'ri-price-tag-3-line',
                'color' => 'success',
                'fields' => ['id', 'title_az', 'title_en', 'price', 'period', 'order', 'is_featured', 'is_active'],
            ],
        ];
    }

    /**
     * Get specific template by model key
     */
    public static function getTemplateDefinition(string $modelKey): ?array
    {
        $templates = self::getPreConfiguredTemplates();
        return $templates[$modelKey] ?? null;
    }

    /**
     * Generate pre-configured template file
     */
    public function generatePreConfiguredTemplate(string $modelKey, string $format = 'csv'): ?string
    {
        $template = self::getTemplateDefinition($modelKey);
        
        if (!$template) {
            return null;
        }

        $filename = sprintf('%s_template_%s.%s', $modelKey, now()->format('Ymd_His'), $format);
        $path = 'import-templates/' . $filename;

        if ($format === 'json') {
            $sampleData = array_fill_keys($template['fields'], 'nümunə');
            if (isset($sampleData['id'])) $sampleData['id'] = '';
            if (isset($sampleData['is_active'])) $sampleData['is_active'] = '1';
            
            $sample = [$sampleData];
            Storage::disk('public')->put($path, json_encode($sample, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            return $path;
        }

        if ($format === 'xlsx' && class_exists('PhpOffice\\PhpSpreadsheet\\Spreadsheet')) {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->fromArray([$template['fields']], null, 'A1');
            
            $sampleRow = array_map(fn($field) => match($field) {
                'id' => '',
                'is_active', 'status', 'in_main' => '1',
                'order' => '0',
                default => 'nümunə'
            }, $template['fields']);
            $sheet->fromArray([$sampleRow], null, 'A2');
            
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            ob_start();
            $writer->save('php://output');
            $content = ob_get_clean();
            Storage::disk('public')->put($path, $content);
            return $path;
        }

        // Default to CSV
        $handle = fopen('php://temp', 'r+');
        // Add UTF-8 BOM
        fwrite($handle, "\xEF\xBB\xBF");
        
        fputcsv($handle, $template['fields']);
        $sampleData = array_map(fn($field) => match($field) {
            'id' => '',
            'is_active', 'status', 'in_main' => '1',
            'order' => '0',
            default => 'nümunə'
        }, $template['fields']);
        fputcsv($handle, $sampleData);
        
        rewind($handle);
        $csvContent = stream_get_contents($handle);
        fclose($handle);
        
        Storage::disk('public')->put($path, $csvContent);
        return $path;
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