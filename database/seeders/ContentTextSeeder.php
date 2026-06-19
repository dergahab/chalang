<?php
declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contenttext;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ContentTextSeeder extends Seeder
{
    public function run()
    {
        // Define all the keys we want to be dynamic
        $keys = [
            // Marquee
            [
                'key' => 'preview.marquee',
                'en' => 'Strategy • Design • Development • Marketing',
                'az' => 'Strategiya • Dizayn • İnkişaf • Marketinq',
                'ru' => 'Стратегия • Дизайн • Разработка • Маркетинг'
            ],
            // Tech Stack (JSON)
            [
                'key' => 'preview.tech_stack.items',
                'en' => json_encode([
                    ["icon" => "⚡", "label" => "Laravel"],
                    ["icon" => "⚛️", "label" => "React"],
                    ["icon" => "🎨", "label" => "Figma"],
                    ["icon" => "🚀", "label" => "Alpine.js"],
                    ["icon" => "💾", "label" => "MySQL"],
                    ["icon" => "☁️", "label" => "AWS"]
                ], JSON_UNESCAPED_UNICODE),
                'az' => json_encode([
                    ["icon" => "⚡", "label" => "Laravel"],
                    ["icon" => "⚛️", "label" => "React"],
                    ["icon" => "🎨", "label" => "Figma"],
                    ["icon" => "🚀", "label" => "Alpine.js"],
                    ["icon" => "💾", "label" => "MySQL"],
                    ["icon" => "☁️", "label" => "AWS"]
                ], JSON_UNESCAPED_UNICODE),
                'ru' => json_encode([
                    ["icon" => "⚡", "label" => "Laravel"],
                    ["icon" => "⚛️", "label" => "React"],
                    ["icon" => "🎨", "label" => "Figma"],
                    ["icon" => "🚀", "label" => "Alpine.js"],
                    ["icon" => "💾", "label" => "MySQL"],
                    ["icon" => "☁️", "label" => "AWS"]
                ], JSON_UNESCAPED_UNICODE)
            ],
            // Metrics
            [
                'key' => 'preview.metrics.years', 'en' => 'Years Experience', 'az' => 'İllik Təcrübə', 'ru' => 'Лет Опыта'
            ],
            [
                'key' => 'preview.metrics.years_value', 'en' => '10', 'az' => '10', 'ru' => '10'
            ],
            [
                'key' => 'preview.metrics.projects', 'en' => 'Projects Completed', 'az' => 'Tamamlanmış Layihələr', 'ru' => 'Завершенных Проектов'
            ],
            [
                'key' => 'preview.metrics.projects_value', 'en' => '150', 'az' => '150', 'ru' => '150'
            ],
            [
                'key' => 'preview.metrics.satisfaction', 'en' => 'Client Satisfaction', 'az' => 'Müştəri Məmnuniyyəti', 'ru' => 'Удовлетворенность'
            ],
            [
                'key' => 'preview.metrics.satisfaction_value', 'en' => '99', 'az' => '99', 'ru' => '99'
            ],
            [
                'key' => 'preview.metrics.awards', 'en' => 'Winning Awards', 'az' => 'Qazanılan Mükafatlar', 'ru' => 'Награды'
            ],
            [
                'key' => 'preview.metrics.awards_value', 'en' => '12', 'az' => '12', 'ru' => '12'
            ],
            // Estimator Options (JSON)
            [
                'key' => 'preview.estimator.services',
                'en' => json_encode([
                    ["label" => "Website", "value" => 2000, "default" => true],
                    ["label" => "Mobile App", "value" => 4500],
                    ["label" => "Branding", "value" => 1500],
                    ["label" => "Digital Marketing", "value" => 1000]
                ], JSON_UNESCAPED_UNICODE),
                'az' => json_encode([
                    ["label" => "Vebsayt", "value" => 2000, "default" => true],
                    ["label" => "Mobil Tətbiq", "value" => 4500],
                    ["label" => "Brendinq", "value" => 1500],
                    ["label" => "Rəqəmsal Marketinq", "value" => 1000]
                ], JSON_UNESCAPED_UNICODE),
                'ru' => json_encode([
                    ["label" => "Веб-сайт", "value" => 2000, "default" => true],
                    ["label" => "Мобильное ПО", "value" => 4500],
                    ["label" => "Брендинг", "value" => 1500],
                    ["label" => "Маркетинг", "value" => 1000]
                ], JSON_UNESCAPED_UNICODE)
            ],
            [
                'key' => 'preview.estimator.sizes',
                'en' => json_encode([
                    ["label" => "Small", "value" => 1],
                    ["label" => "Medium", "value" => 1.5, "default" => true],
                    ["label" => "Large", "value" => 2.5]
                ], JSON_UNESCAPED_UNICODE),
                'az' => json_encode([
                    ["label" => "Kiçik", "value" => 1],
                    ["label" => "Orta", "value" => 1.5, "default" => true],
                    ["label" => "Böyük", "value" => 2.5]
                ], JSON_UNESCAPED_UNICODE),
                'ru' => json_encode([
                    ["label" => "Малый", "value" => 1],
                    ["label" => "Средний", "value" => 1.5, "default" => true],
                    ["label" => "Крупный", "value" => 2.5]
                ], JSON_UNESCAPED_UNICODE)
            ],
             // Lead Magnet
            [
                'key' => 'preview.magnet_title', 'en' => 'Get a Free Audit', 'az' => 'Pulsuz Audit Əldə Edin', 'ru' => 'Получить Аудит'
            ],
            [
                'key' => 'preview.magnet_desc', 'en' => 'Find out how we can help you grow.', 'az' => 'Böyüməyinizə necə kömək edə biləcəyimizi öyrənin.', 'ru' => 'Узнайте, как мы можем помочь.'
            ],
             // CTA Portal
            [
                'key' => 'preview.cta.title', 'en' => 'Ready to define the future?', 'az' => 'Gələcəyi təyin etməyə hazırsınız?', 'ru' => 'Готовы определить будущее?'
            ],
            [
                'key' => 'preview.cta.button', 'en' => 'Start a Project', 'az' => 'Layihəyə Başla', 'ru' => 'Начать Проект'
            ]
        ];

        foreach ($keys as $data) {
            try {
                // Manually create or update to ensure control
                $model = Contenttext::where('key', $data['key'])->first();
                if (!$model) {
                    $model = new Contenttext();
                    $model->key = $data['key'];
                    $model->save();
                }

                foreach (['en', 'az', 'ru'] as $loc) {
                    if (isset($data[$loc])) {
                        $model->translateOrNew($loc)->title = $data[$loc];
                        $model->translateOrNew($loc)->content = $data[$loc];
                    }
                }
                $model->save();
                
                $this->command->info("Seeded: {$data['key']}");

            } catch (\Exception $e) {
                $this->command->error("Failed to seed {$data['key']}: " . $e->getMessage());
                Log::error("ContentTextSeeder Error for key {$data['key']}: " . $e->getMessage());
            }
        }
    }
}
