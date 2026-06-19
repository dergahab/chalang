<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contenttext;
use App\Models\ContenttextTranslation;
use App\Models\Lang;
use Illuminate\Http\Request;

class HomeSectionController extends Controller
{
    public function index()
    {
        $sections = $this->getSections();

        return view('admin.pages.home_sections.index', compact('sections'));
    }

    public function edit(string $section)
    {
        $langs = Lang::all();
        $sections = $this->getSections();
        $activeSection = $this->findSection($sections, $section);
        $keys = $this->collectKeys([$activeSection]);
        $enabledKey = $activeSection['enabled_key'] ?? null;
        $texts = Contenttext::with('translations')
            ->whereIn('key', $keys)
            ->get()
            ->keyBy('key');

        $sectionEnabled = true;
        if ($enabledKey) {
            $enabledContent = Contenttext::with('translations')
                ->where('key', $enabledKey)
                ->first();
            $sectionEnabled = $this->resolveEnabledValue($enabledContent, $langs, true);
        }

        $values = [];
        foreach ($langs as $lang) {
            foreach ($keys as $key) {
                // 1. Try DB
                $contentText = $texts->get($key);
                $translation = $contentText?->translations?->firstWhere('locale', $lang->lang);
                $content = $translation?->content;
                if (is_string($content)) {
                    $content = $this->maybeFormatJsonList($key, $content);
                }

                // 2. Fallback to Language File
                if (is_null($content) || $content === '' || $content === '[]') {
                    $transKey = $key; // e.g., 'preview.estimator.services'
                    // Ensure we are getting the translation for the specific locale
                    $default = trans($transKey, [], $lang->lang);
                    
                    if ($default !== $transKey && !empty($default)) {
                        if (is_array($default)) {
                            $content = $this->formatArrayValueForKey($key, $default);
                        } else {
                            $content = $default;
                        }
                    } else {
                        $content = '';
                    }
                }

                $values[$lang->lang][$key] = $content;
            }
        }

        return view('admin.pages.home_sections.edit', [
            'langs' => $langs,
            'sections' => $sections,
            'values' => $values,
            'activeSection' => $activeSection,
            'enabledKey' => $enabledKey,
            'sectionEnabled' => $sectionEnabled,
            'servicesList' => \App\Models\Service::with('translations')->get(),
        ]);
    }

    public function update(Request $request, string $section)
    {
        $langs = Lang::all();
        $sections = $this->getSections();
        $activeSection = $this->findSection($sections, $section);
        $keys = $this->collectKeys([$activeSection]);
        $enabledKey = $activeSection['enabled_key'] ?? null;
        $input = $request->input('content', []);

        foreach ($keys as $key) {
            $contentText = Contenttext::firstOrCreate(['key' => $key]);
            foreach ($langs as $lang) {
                $value = $input[$lang->lang][$key] ?? '';
                $value = is_string($value) ? trim($value) : '';

                ContenttextTranslation::updateOrCreate(
                    ['contenttext_id' => $contentText->id, 'locale' => $lang->lang],
                    ['title' => $key, 'content' => $value]
                );
            }
        }

        if ($enabledKey) {
            $isEnabled = $request->boolean('section_enabled') ? '1' : '0';
            $enabledContentText = Contenttext::firstOrCreate(['key' => $enabledKey]);
            foreach ($langs as $lang) {
                ContenttextTranslation::updateOrCreate(
                    ['contenttext_id' => $enabledContentText->id, 'locale' => $lang->lang],
                    ['title' => $enabledKey, 'content' => $isEnabled]
                );
            }
        }

        return redirect()
            ->route('admin.home-sections.edit', ['section' => $section])
            ->with('success', 'Home section updated.');
    }

    protected function collectKeys(array $sections): array
    {
        $keys = [];

        foreach ($sections as $section) {
            foreach ($section['fields'] as $field) {
                $keys[] = $field['key'];
            }
        }

        return array_values(array_unique($keys));
    }

    protected function getSections(): array
    {
        return [
            [
                'id' => 'estimator',
                'title' => 'Smart Estimator',
                'description' => 'Controls the pricing estimator section.',
                'enabled_key' => 'preview.sections.estimator.enabled',
                'fields' => [
                    ['key' => 'preview.est_title', 'label' => 'Title', 'type' => 'text'],
                    ['key' => 'preview.est_sub', 'label' => 'Subtitle', 'type' => 'text'],
                    ['key' => 'preview.estimator.service_type', 'label' => 'Service type label', 'type' => 'text'],
                    ['key' => 'preview.estimator.urgency', 'label' => 'Timeline label', 'type' => 'text'],
                    ['key' => 'preview.estimator.size', 'label' => 'Scope label', 'type' => 'text'],
                    ['key' => 'preview.estimator.investment', 'label' => 'Investment label', 'type' => 'text'],
                    ['key' => 'preview.estimator.range', 'label' => 'Default range', 'type' => 'text'],
                    ['key' => 'preview.estimator.cta', 'label' => 'CTA button', 'type' => 'text'],
                    [
                        'key' => 'preview.estimator.sizes',
                        'label' => 'Global Sizes (Defaults)',
                        'type' => 'key_value_list',
                        'help' => "Default size multipliers applied to all services unless overridden.",
                    ],
                    [
                        'key' => 'preview.estimator.urgencies',
                        'label' => 'Global Urgency Levels (Defaults)',
                        'type' => 'key_value_list',
                        'help' => "Default urgency levels applied to all services unless overridden.",
                    ],
                    [
                        'key' => 'preview.estimator.services_matrix',
                        'label' => 'Services Configuration (Matrix)',
                        'type' => 'estimator_matrix',
                        'help' => "Manage Services. Click 'Configure' to override Sizes/Urgency for a specific service.",
                    ],
                ],
            ],
            [
                'id' => 'fame',
                'title' => 'Achievements',
                'description' => 'Fallback items used when there are no case studies.',
                'enabled_key' => 'preview.sections.fame.enabled',
                'fields' => [
                    ['key' => 'preview.fame.title', 'label' => 'Section title', 'type' => 'text'],
                    [
                        'key' => 'preview.fame.items',
                        'label' => 'Items list (optional)',
                        'type' => 'textarea',
                        'help' => "One per line: Logo URL | Label, or text only.\nExample: https://example.com/logo.svg | Partner",
                        'picker' => true,
                    ],
                    ['key' => 'preview.fame.item_1', 'label' => 'Item 1', 'type' => 'text'],
                    ['key' => 'preview.fame.item_2', 'label' => 'Item 2', 'type' => 'text'],
                    ['key' => 'preview.fame.item_3', 'label' => 'Item 3', 'type' => 'text'],
                    ['key' => 'preview.fame.item_4', 'label' => 'Item 4', 'type' => 'text'],
                ],
            ],
            [
                'id' => 'lead_magnet',
                'title' => 'Lead Magnet',
                'description' => 'Free website audit block.',
                'enabled_key' => 'preview.sections.lead_magnet.enabled',
                'fields' => [
                    ['key' => 'preview.magnet_title', 'label' => 'Title', 'type' => 'text'],
                    ['key' => 'preview.magnet_desc', 'label' => 'Description', 'type' => 'textarea'],
                    ['key' => 'preview.magnet_url', 'label' => 'URL placeholder', 'type' => 'text'],
                    ['key' => 'preview.btn_audit', 'label' => 'Button label', 'type' => 'text'],
                ],
            ],
            [
                'id' => 'process',
                'title' => 'Process Section',
                'description' => 'Step titles/descriptions come from the Steps module. These are fallback details.',
                'enabled_key' => 'preview.sections.process.enabled',
                'fields' => [
                    ['key' => 'preview.sec_process_title', 'label' => 'Section title', 'type' => 'text'],
                    ['key' => 'preview.sec_process_sub', 'label' => 'Section subtitle', 'type' => 'text'],
                    [
                        'key' => 'preview.process.map_url',
                        'label' => 'Map background image (optional)',
                        'type' => 'image',
                        'help' => 'Upload a custom map background for the process section.',
                    ],
                    [
                        'key' => 'preview.process.map_points',
                        'label' => 'Map points (click to add on map)',
                        'type' => 'map_points',
                        'help' => 'Use the map editor to add and position points.',
                    ],
                    [
                        'key' => 'preview.process.map_styles',
                        'label' => 'Map Visual Styles',
                        'type' => 'map_styles',
                        'help' => 'Customize the colors, opacity, and neon glow of the background map.',
                    ],
                    ['key' => 'preview.process.details.step_1.title', 'label' => 'Step 1 detail title', 'type' => 'text'],
                    ['key' => 'preview.process.details.step_1.text', 'label' => 'Step 1 detail text', 'type' => 'textarea'],
                    ['key' => 'preview.process.details.step_1.items', 'label' => 'Step 1 items', 'type' => 'textarea', 'help' => 'One item per line.'],
                    ['key' => 'preview.process.details.step_2.title', 'label' => 'Step 2 detail title', 'type' => 'text'],
                    ['key' => 'preview.process.details.step_2.text', 'label' => 'Step 2 detail text', 'type' => 'textarea'],
                    ['key' => 'preview.process.details.step_2.items', 'label' => 'Step 2 items', 'type' => 'textarea', 'help' => 'One item per line.'],
                    ['key' => 'preview.process.details.step_3.title', 'label' => 'Step 3 detail title', 'type' => 'text'],
                    ['key' => 'preview.process.details.step_3.text', 'label' => 'Step 3 detail text', 'type' => 'textarea'],
                    ['key' => 'preview.process.details.step_3.items', 'label' => 'Step 3 items', 'type' => 'textarea', 'help' => 'One item per line.'],
                    ['key' => 'preview.process.details.step_4.title', 'label' => 'Step 4 detail title', 'type' => 'text'],
                    ['key' => 'preview.process.details.step_4.text', 'label' => 'Step 4 detail text', 'type' => 'textarea'],
                    ['key' => 'preview.process.details.step_4.items', 'label' => 'Step 4 items', 'type' => 'textarea', 'help' => 'One item per line.'],
                ],
            ],
            [
                'id' => 'metrics',
                'title' => 'Metrics',
                'description' => 'Statistic labels and values.',
                'enabled_key' => 'preview.sections.metrics.enabled',
                'fields' => [
                    ['key' => 'preview.metrics.years_value', 'label' => 'Years value', 'type' => 'text'],
                    ['key' => 'preview.metrics.projects_value', 'label' => 'Projects value', 'type' => 'text'],
                    ['key' => 'preview.metrics.satisfaction_value', 'label' => 'Satisfaction value', 'type' => 'text'],
                    ['key' => 'preview.metrics.awards_value', 'label' => 'Awards value', 'type' => 'text'],
                    ['key' => 'preview.metrics.years', 'label' => 'Years label', 'type' => 'text'],
                    ['key' => 'preview.metrics.projects', 'label' => 'Projects label', 'type' => 'text'],
                    ['key' => 'preview.metrics.satisfaction', 'label' => 'Satisfaction label', 'type' => 'text'],
                    ['key' => 'preview.metrics.awards', 'label' => 'Awards label', 'type' => 'text'],
                ],
            ],
            [
                'id' => 'who_we_are',
                'title' => 'Who We Are (About)',
                'description' => 'Controls the About section on the home page.',
                'enabled_key' => 'preview.sections.who_we_are.enabled',
                'fields' => [
                    ['key' => 'preview.about_title', 'label' => 'Title', 'type' => 'text'],
                    ['key' => 'preview.about_description', 'label' => 'Description', 'type' => 'textarea'],
                    ['key' => 'preview.about_image', 'label' => 'Main Image', 'type' => 'image'],
                ],
            ],
            [
                'id' => 'partners',
                'title' => 'Partners (Marquee)',
                'description' => 'Controls the Partners logo marquee.',
                'enabled_key' => 'preview.sections.partners.enabled',
                'fields' => [
                    ['key' => 'preview.partners_title', 'label' => 'Section Title', 'type' => 'text'],
                ],
            ],
            [
                'id' => 'tech_stack',
                'title' => 'Tech Stack',
                'description' => 'Scrolling tech bar items.',
                'enabled_key' => 'preview.sections.tech_stack.enabled',
                'fields' => [
                    [
                        'key' => 'preview.tech_stack.items',
                        'label' => 'Items',
                        'type' => 'textarea',
                        'help' => "One per line: Icon | Label. Icon can be a URL.\nExample: https://site/logo.svg | Figma",
                        'picker' => true,
                    ],
                ],
            ],
        ];
    }

    protected function findSection(array $sections, string $sectionId): array
    {
        foreach ($sections as $section) {
            if ($section['id'] === $sectionId) {
                return $section;
            }
        }

        abort(404);
    }

    protected function resolveEnabledValue(?Contenttext $contentText, $langs, bool $default): bool
    {
        if (!$contentText) {
            return $default;
        }

        foreach ($langs as $lang) {
            $translation = $contentText->translations?->firstWhere('locale', $lang->lang);
            $value = trim((string) ($translation?->content ?? ''));
            if ($value !== '') {
                return $this->normalizeEnabledValue($value);
            }
        }

        return $default;
    }

    protected function normalizeEnabledValue(string $value): bool
    {
        $value = strtolower(trim($value));
        return !in_array($value, ['0', 'false', 'off', 'no'], true);
    }

    protected function maybeFormatJsonList(string $key, string $content): string
    {
        $trimmed = trim($content);
        if ($trimmed === '' || ($trimmed[0] ?? '') === '' || (!str_starts_with($trimmed, '[') && !str_starts_with($trimmed, '{'))) {
            return $content;
        }

        $decoded = json_decode($trimmed, true);
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
            return $content;
        }

        return $this->formatArrayValueForKey($key, $decoded);
    }

    protected function formatArrayValueForKey(string $key, array $items): string
    {
        if (!$items) {
            return '';
        }

        if (str_ends_with($key, '.services') || str_ends_with($key, '.sizes') || str_ends_with($key, '.urgencies')) {
            $lines = [];
            foreach ($items as $item) {
                if (is_array($item)) {
                    $label = trim((string) ($item['label'] ?? $item['name'] ?? ''));
                    $value = $item['value'] ?? $item['val'] ?? null;
                    $isDefault = !empty($item['default']);
                } else {
                    $label = trim((string) $item);
                    $value = null;
                    $isDefault = false;
                }

                if ($label === '') {
                    continue;
                }

                $line = ($isDefault ? '* ' : '') . $label;
                if ($value !== null && $value !== '') {
                    $line .= ' | ' . $value;
                }
                $lines[] = $line;
            }

            return implode("\n", $lines);
        }

        if (str_ends_with($key, '.tech_stack.items')) {
            $lines = [];
            foreach ($items as $item) {
                if (is_array($item)) {
                    $icon = trim((string) ($item['icon'] ?? $item['emoji'] ?? ''));
                    $label = trim((string) ($item['label'] ?? $item['name'] ?? ''));
                } else {
                    $icon = '';
                    $label = trim((string) $item);
                }

                if ($label === '') {
                    continue;
                }

                $lines[] = $icon !== '' ? ($icon . ' | ' . $label) : $label;
            }

            return implode("\n", $lines);
        }

        if (str_ends_with($key, '.items') || str_ends_with($key, '.tags') || str_ends_with($key, '.ticker_default')) {
            $lines = [];
            foreach ($items as $item) {
                if (is_scalar($item)) {
                    $line = trim((string) $item);
                    if ($line !== '') {
                        $lines[] = $line;
                    }
                }
            }
            return implode("\n", $lines);
        }

        return json_encode($items, JSON_UNESCAPED_UNICODE);
    }
}
