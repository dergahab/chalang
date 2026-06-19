<?php
declare(strict_types=1);

use App\Models\Contenttext;
use App\Models\ContenttextTranslation;
use App\Models\Lang;
use Illuminate\Contracts\Console\Kernel;

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$argv = $_SERVER['argv'] ?? [];
$force = in_array('--force', $argv, true);
$dryRun = in_array('--dry-run', $argv, true);
$previewOnly = in_array('--preview-only', $argv, true);
$frontOnly = in_array('--front-only', $argv, true);

$includePreview = !$frontOnly;
$includeFront = !$previewOnly;

if (!$includePreview && !$includeFront) {
    fwrite(STDERR, "Nothing to do. Use --preview-only or --front-only, not both.\n");
    exit(1);
}

function is_assoc(array $value): bool
{
    if ($value === []) {
        return false;
    }

    return array_keys($value) !== range(0, count($value) - 1);
}

function normalize_list(array $items, string $key): string
{
    $lines = [];

    if (str_ends_with($key, '.tech_stack.items')) {
        foreach ($items as $item) {
            if (is_array($item)) {
                $icon = trim((string) ($item['icon'] ?? $item['emoji'] ?? ''));
                $label = trim((string) ($item['label'] ?? $item['name'] ?? ''));
                if ($label === '') {
                    continue;
                }
                $lines[] = $icon !== '' ? $icon . ' | ' . $label : $label;
            } else {
                $label = trim((string) $item);
                if ($label !== '') {
                    $lines[] = $label;
                }
            }
        }

        return implode(PHP_EOL, $lines);
    }

    if (str_ends_with($key, '.services') || str_ends_with($key, '.sizes')) {
        foreach ($items as $item) {
            if (is_array($item)) {
                $label = trim((string) ($item['label'] ?? $item['name'] ?? ''));
                $value = trim((string) ($item['value'] ?? $item['val'] ?? ''));
                $isDefault = !empty($item['default']);

                if ($label === '') {
                    continue;
                }

                $line = ($isDefault ? '* ' : '') . $label;
                if ($value !== '') {
                    $line .= ' | ' . $value;
                }
                $lines[] = $line;
            } else {
                $label = trim((string) $item);
                if ($label !== '') {
                    $lines[] = $label;
                }
            }
        }

        return implode(PHP_EOL, $lines);
    }

    foreach ($items as $item) {
        if (is_array($item)) {
            $lines[] = json_encode($item, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        } else {
            $lines[] = trim((string) $item);
        }
    }

    $lines = array_values(array_filter($lines, static fn ($line) => $line !== ''));

    return implode(PHP_EOL, $lines);
}

function flatten_values($value, string $prefix, array &$out): void
{
    if (is_array($value)) {
        if (is_assoc($value)) {
            foreach ($value as $key => $child) {
                $next = $prefix === '' ? (string) $key : $prefix . '.' . $key;
                flatten_values($child, $next, $out);
            }
            return;
        }

        $out[$prefix] = normalize_list($value, $prefix);
        return;
    }

    if (is_bool($value)) {
        $out[$prefix] = $value ? '1' : '0';
        return;
    }

    $out[$prefix] = $value === null ? '' : (string) $value;
}

function load_lang_array(string $locale, string $file): ?array
{
    $path = resource_path('lang/' . $locale . '/' . $file . '.php');
    if (!is_file($path)) {
        return null;
    }

    $data = include $path;
    return is_array($data) ? $data : null;
}

function load_lang_json(string $locale): array
{
    $path = resource_path('lang/' . $locale . '.json');
    if (!is_file($path)) {
        return [];
    }

    $data = json_decode((string) file_get_contents($path), true);
    return is_array($data) ? $data : [];
}

$locales = Lang::query()->pluck('lang')->filter()->unique()->values()->all();
if (!$locales) {
    $langRoot = resource_path('lang');
    $entries = is_dir($langRoot) ? scandir($langRoot) : [];
    foreach ($entries as $entry) {
        if ($entry === '.' || $entry === '..') {
            continue;
        }
        $path = $langRoot . DIRECTORY_SEPARATOR . $entry;
        if (!is_dir($path)) {
            continue;
        }
        if (is_file($path . DIRECTORY_SEPARATOR . 'preview.php') || is_file($path . DIRECTORY_SEPARATOR . 'front.php')) {
            $locales[] = $entry;
        }
    }
}

if (!$locales) {
    $locales = ['en'];
}

$simpleKeys = ['services', 'portfolio', 'blog', 'contact', 'about'];
$localeMaps = [];
$allKeys = [];

foreach ($locales as $locale) {
    $map = [];

    if ($includePreview) {
        $preview = load_lang_array($locale, 'preview');
        if ($preview) {
            flatten_values($preview, 'preview', $map);
        }
    }

    if ($includeFront) {
        $front = load_lang_array($locale, 'front');
        if ($front) {
            flatten_values($front, 'front', $map);
        }
    }

    $json = load_lang_json($locale);
    foreach ($simpleKeys as $key) {
        if (isset($json[$key]) && is_string($json[$key]) && $json[$key] !== '') {
            $map[$key] = $json[$key];
        }
    }

    $localeMaps[$locale] = $map;
    $allKeys = array_merge($allKeys, array_keys($map));
}

$allKeys = array_values(array_unique($allKeys));
sort($allKeys);

echo "Locales: " . implode(', ', $locales) . PHP_EOL;
echo "Keys: " . count($allKeys) . PHP_EOL;
if ($dryRun) {
    echo "Mode: dry-run (no writes)\n";
}

$created = 0;
$updated = 0;
$skipped = 0;

foreach ($allKeys as $key) {
    if ($key === '') {
        continue;
    }

    if ($dryRun) {
        continue;
    }

    $contentText = Contenttext::firstOrCreate(['key' => $key]);

    foreach ($locales as $locale) {
        $value = $localeMaps[$locale][$key] ?? null;
        if ($value === null || trim($value) === '') {
            continue;
        }

        $translation = ContenttextTranslation::query()
            ->where('contenttext_id', $contentText->id)
            ->where('locale', $locale)
            ->first();

        if ($translation) {
            if (!$force && trim((string) $translation->content) !== '') {
                $skipped++;
                continue;
            }

            $translation->title = $key;
            $translation->content = $value;
            $translation->save();
            $updated++;
            continue;
        }

        ContenttextTranslation::create([
            'contenttext_id' => $contentText->id,
            'locale' => $locale,
            'title' => $key,
            'content' => $value,
        ]);
        $created++;
    }
}

echo "Created translations: {$created}\n";
echo "Updated translations: {$updated}\n";
echo "Skipped translations: {$skipped}\n";
echo "Done.\n";
