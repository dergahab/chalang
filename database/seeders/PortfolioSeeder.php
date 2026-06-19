<?php
declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Portfolio;
use App\Models\PortfolioTranslation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PortfolioSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Portfolio::truncate();
        PortfolioTranslation::truncate();
        DB::table('pcategory_portfolio')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $projects = [
            // === CASE STUDY 1: Capital Fintech ===
            [
                'category_id' => 3,
                'image' => 'https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=800&q=80',
                'translations' => [
                    'az' => [
                        'title' => 'Capital Fintech — İnteraktiv Mobil Bankçılıq',
                        'short_description' => 'Fintech startapı üçün tam UX/UI dizayn sistemi',
                        'description' => 'Müasir fintech platforması üçün tam brend kimliyi və UX/UI dizayn sistemi. 320px iPhone SE ekranından 8K monitorlara qədər tam adaptiv interfeys.',
                        'problem' => 'Müştəriyə məxsus köhnə mobil tətbiq yüksək bounce rate (68%) və aşağı konversiya (1.2%) ilə qarşılaşırdı. İstifadəçi axını mürəkkəb, vizual identiklik isə rəqiblərlə müqayisədə zəif idi.',
                        'solution' => 'Tamamilə yeni dizayn sistemi quruldu — design tokens, micro-interactions, dark/light mode dəstəyi ilə. 320px-dən 4K-ya qədər responsive grid tətbiq edildi. Framer Motion ilə smooth page transitions əlavə olundu.',
                        'result' => 'Bounce rate 68% → 23% (3x yaxşılaşma). İstifadəçi məmnuniyyəti (NPS) 72 → 94. Mobil konversiya 1.2% → 4.7%. App store reytinqi 2.8 → 4.7 ulduz.',
                        'slug' => 'capital-fintech-mobile-banking',
                    ],
                    'en' => [
                        'title' => 'Capital Fintech — Interactive Mobile Banking',
                        'short_description' => 'Full UX/UI design system for a fintech startup',
                        'description' => 'Complete branding and UX/UI design system for a modern fintech platform, fully responsive from iPhone SE to 8K monitors.',
                        'problem' => 'The legacy mobile app suffered from 68% bounce rate and 1.2% conversion. User flows were convoluted, and visual identity lagged behind competitors.',
                        'solution' => 'Built a complete design system with tokens, micro-interactions, dark/light mode. Applied responsive grid from 320px to 4K. Added smooth page transitions via Framer Motion.',
                        'result' => 'Bounce rate dropped 68% → 23% (3x improvement). NPS increased 72 → 94. Mobile conversion 1.2% → 4.7%. App store rating 2.8 → 4.7 stars.',
                        'slug' => 'capital-fintech-mobile-banking-en',
                    ],
                    'ru' => [
                        'title' => 'Capital Fintech — Интерактивный мобильный банкинг',
                        'short_description' => 'Полный UX/UI дизайн для финтех стартапа',
                        'description' => 'Полный брендинг и дизайн-система UX/UI для современной финтех-платформы, полностью адаптированная под любые экраны.',
                        'problem' => 'Устаревшее мобильное приложение имело показатель отказов 68% и конверсию 1.2%. Пользовательские потоки были сложными, а визуальная идентичность слабой.',
                        'solution' => 'Создана новая дизайн-система с токенами, микро-анимациями, темной/светлой темой. Responsive сетка от 320px до 4K. Плавные переходы на Framer Motion.',
                        'result' => 'Показатель отказов снизился с 68% до 23% (улучшение в 3x). NPS вырос с 72 до 94. Конверсия 1.2% → 4.7%. Рейтинг в магазине 2.8 → 4.7 звезды.',
                        'slug' => 'capital-fintech-mobile-banking-ru',
                    ],
                ]
            ],
            // === CASE STUDY 2: Vision ERP ===
            [
                'category_id' => 1,
                'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=800&q=80',
                'translations' => [
                    'az' => [
                        'title' => 'Vision ERP — Buludlu İdarəetmə Sistemi',
                        'short_description' => 'Böyük data analitikası üçün SaaS portalı',
                        'description' => 'Böyük həcmli data analitikası və resurs planlaşdırılması üçün 3D Parallax zərifliyi ilə dizayn olunmuş CRM/SaaS portalı.',
                        'problem' => 'Müştərinin mövcud ERP sistemi sürət baxımından zəif idi — səhifə yüklənmə müddəti 8.5 saniyə idi. İdarə paneli mürəkkəb və intuitiv deyildi, yeni istifadəçilər üçün öyrənmə əyrisi çox uzun idi.',
                        'solution' => 'Laravel backend optimizasiyası (lazy loading, eager loading, Redis cache) ilə sorğu sürəti optimallaşdırıldı. React admin paneli tamamilə yenidən yazıldı, drag-drop dashboard və real-time notifications əlavə edildi.',
                        'result' => 'Səhifə yüklənmə müddəti 8.5s → 1.2s (7x sürət artımı). İstifadəçi onboarding müddəti 2 həftədən 2 günə endi. 3 ay ərzində 150+ yeni biznes müştəri qoşuldu.',
                        'slug' => 'vision-erp-cloud-management',
                    ],
                    'en' => [
                        'title' => 'Vision ERP — Cloud Management System',
                        'short_description' => 'SaaS portal for big data analytics',
                        'description' => 'A custom CRM/SaaS portal designed with 3D Parallax elegance for big data analytics and enterprise resource planning.',
                        'problem' => 'Existing ERP suffered from 8.5s page load times. Admin panel was complex with a steep learning curve, causing low user adoption.',
                        'solution' => 'Optimized Laravel backend (lazy/eager loading, Redis cache) for 7x speed gain. Rewrote React admin panel with drag-drop dashboard and real-time notifications.',
                        'result' => 'Page load 8.5s → 1.2s (7x improvement). Onboarding reduced from 2 weeks to 2 days. 150+ enterprise clients onboarded in 3 months.',
                        'slug' => 'vision-erp-cloud-management-en',
                    ],
                    'ru' => [
                        'title' => 'Vision ERP — Облачная система управления',
                        'short_description' => 'SaaS портал для аналитики больших данных',
                        'description' => 'Кастомный CRM/SaaS портал с 3D-параллаксом для аналитики больших данных и планирования ресурсов предприятия.',
                        'problem' => 'Существующая ERP система имела время загрузки 8.5 секунд. Панель управления была сложной с крутой кривой обучения.',
                        'solution' => 'Оптимизация Laravel (ленивая загрузка, Redis кэш) ускорила запросы в 7 раз. React панель переписана с drag-drop и real-time уведомлениями.',
                        'result' => 'Загрузка страниц 8.5s → 1.2s (7x ускорение). Время обучения сокращено с 2 недель до 2 дней. 150+ клиентов за 3 месяца.',
                        'slug' => 'vision-erp-cloud-management-ru',
                    ],
                ]
            ],
            // === CASE STUDY 3: Aura Luxury ===
            [
                'category_id' => 1,
                'image' => 'https://images.unsplash.com/photo-1472851294608-062f824d29cc?auto=format&fit=crop&w=800&q=80',
                'translations' => [
                    'az' => [
                        'title' => 'Aura Luxury — E-ticarət Platforması',
                        'short_description' => 'Premium brendlər üçün yüksək sürətli e-ticarət',
                        'description' => 'Premium moda və dizayn brendləri üçün xüsusi hazırlanmış, sürətli TanStack Query və API ilə təchiz olunmuş onlayn mağaza.',
                        'problem' => 'Müştərinin köhnə WooCommerce saytı yüksək trafikdə crash edir, səhifə yüklənmə müddəti 6+ saniyə idi. Mobil təcrübə zəif, checkout funnelində 73% tərk etmə nisbəti var idi.',
                        'solution' => 'Headless commerce arxitekturasına keçid edildi: Laravel backend + React frontend. TanStack Query ilə ağıllı caching, Lighthouse optimized code splitting, və bir kliklə checkout tətbiq edildi.',
                        'result' => 'Page speed 6s → 0.8s. Core Web Vitals-in hər 3 metriki (LCP, FID, CLS) keçdi. Checkout abandonment 73% → 32%. Aylıq gəlir $120K → $340K.',
                        'slug' => 'aura-luxury-ecommerce-platform',
                    ],
                    'en' => [
                        'title' => 'Aura Luxury — E-Commerce Platform',
                        'short_description' => 'High-speed e-commerce for premium brands',
                        'description' => 'A premium e-commerce experience built for luxury brands, powered by high-speed TanStack Query and decoupled API.',
                        'problem' => 'Legacy WooCommerce site crashed under high traffic, 6+ second page loads. Mobile experience was poor with 73% checkout abandonment.',
                        'solution' => 'Migrated to headless commerce: Laravel backend + React frontend. Smart caching with TanStack Query, Lighthouse-optimized code splitting, one-click checkout.',
                        'result' => 'Page speed 6s → 0.8s. Passed all 3 Core Web Vitals (LCP, FID, CLS). Checkout abandonment 73% → 32%. Monthly revenue $120K → $340K.',
                        'slug' => 'aura-luxury-ecommerce-platform-en',
                    ],
                    'ru' => [
                        'title' => 'Aura Luxury — Платформа электронной коммерции',
                        'short_description' => 'Быстрая e-commerce для премиальных брендов',
                        'description' => 'Премиальный интернет-магазин для люксовых брендов с использованием TanStack Query и быстрого API.',
                        'problem' => 'Старый WooCommerce сайт падал при высоком трафике, время загрузки 6+ секунд. 73% отказов в checkout.',
                        'solution' => 'Переход на headless commerce: Laravel backend + React frontend. Умное кэширование TanStack Query, code splitting, покупка в один клик.',
                        'result' => 'Скорость 6s → 0.8s. Все Core Web Vitals пройдены. Отказы в checkout 73% → 32%. Месячный доход $120K → $340K.',
                        'slug' => 'aura-luxury-ecommerce-platform-ru',
                    ],
                ]
            ],
            // === Regular items (non case study) ===
            [
                'category_id' => 2,
                'image' => 'https://images.unsplash.com/photo-1524758631624-e2822e304c36?auto=format&fit=crop&w=800&q=80',
                'translations' => [
                    'az' => ['title' => 'Helix Energy — Korporativ Brending və Loqo', 'short_description' => 'Yaşıl enerji şirkəti üçün minimalist brend kitabçası', 'description' => 'Sürətlə böyüyən yaşıl enerji şirkəti üçün minimalist loqo, brend kitabçası və tam qrafik dizayn ekosistemi.', 'slug' => 'helix-energy-corporate-branding'],
                    'en' => ['title' => 'Helix Energy — Corporate Branding & Logo', 'short_description' => 'Minimalist brand book for a green energy company', 'description' => 'A minimalist logo, brand book, and full graphic design ecosystem for a fast-growing green energy company.', 'slug' => 'helix-energy-corporate-branding-en'],
                    'ru' => ['title' => 'Helix Energy — Корпоративный брендинг и логотип', 'short_description' => 'Минималистичный брендбук для компании зеленой энергетики', 'description' => 'Минималистичный логотип, брендбук и полная дизайн-система для быстрорастущей компании зеленой энергетики.', 'slug' => 'helix-energy-corporate-branding-ru'],
                ]
            ],
            [
                'category_id' => 3,
                'image' => 'https://images.unsplash.com/photo-1531403009284-440f080d1e12?auto=format&fit=crop&w=800&q=80',
                'translations' => [
                    'az' => ['title' => 'Zenith HR — İşçi İdarəetmə Aləti', 'short_description' => 'İri şirkətlər üçün modern SaaS həlli', 'description' => 'İri şirkətlər üçün işçi qəbulu, KPI izlənməsi və daxili sosial şəbəkə funksiyaları təklif edən modern SaaS həlli.', 'slug' => 'zenith-hr-employee-management'],
                    'en' => ['title' => 'Zenith HR — Employee Management Tool', 'short_description' => 'Modern SaaS solution for enterprises', 'description' => 'A modern SaaS solution offering onboarding, KPI tracking, and internal networking features for large enterprises.', 'slug' => 'zenith-hr-employee-management-en'],
                    'ru' => ['title' => 'Zenith HR — Инструмент управления персоналом', 'short_description' => 'Современное SaaS-решение', 'description' => 'Современное SaaS-решение для подбора персонала, отслеживания KPI и внутренних коммуникаций.', 'slug' => 'zenith-hr-employee-management-ru'],
                ]
            ],
            [
                'category_id' => 4,
                'image' => 'https://images.unsplash.com/photo-1620641788421-7a1c342ea42e?auto=format&fit=crop&w=800&q=80',
                'translations' => [
                    'az' => ['title' => 'CyberVerse — Web3 və NFT Platforması', 'short_description' => 'Web3 layihələri üçün premium marketinq səhifəsi', 'description' => 'Gələcəyin Web3 layihələri və rəqəmsal incəsənət kolleksiyaları üçün premium neon qradientlərlə bəzədilmiş marketinq səhifəsi.', 'slug' => 'cyberverse-web3-nft-platform'],
                    'en' => ['title' => 'CyberVerse — Web3 & NFT Platform', 'short_description' => 'Premium marketing page for Web3 projects', 'description' => 'A web3 landing page decorated with premium neon gradients for futuristic art collections and decentralized ecosystems.', 'slug' => 'cyberverse-web3-nft-platform-en'],
                    'ru' => ['title' => 'CyberVerse — Web3 и NFT Платформа', 'short_description' => 'Премиум маркетинговая страница для Web3', 'description' => 'Лендинг для Web3 с премиальными неоновыми градиентами для футуристических коллекций цифрового искусства.', 'slug' => 'cyberverse-web3-nft-platform-ru'],
                ]
            ],
        ];

        foreach ($projects as $key => $p) {
            $portfolio = Portfolio::create([
                'company_id' => 1,
                'image' => $p['image'],
                'in_main' => 1,
                'posotion' => $key + 1,
                'status' => 1,
            ]);

            foreach ($p['translations'] as $locale => $tData) {
                $trans = new PortfolioTranslation();
                $trans->portfolio_id = $portfolio->id;
                $trans->locale = $locale;
                $trans->title = $tData['title'];
                $trans->short_description = $tData['short_description'] ?? null;
                $trans->description = $tData['description'];
                $trans->problem = $tData['problem'] ?? null;
                $trans->solution = $tData['solution'] ?? null;
                $trans->result = $tData['result'] ?? null;
                $trans->slug = $tData['slug'];
                $trans->save();
            }

            // Sync with category
            $portfolio->syncCategories([$p['category_id']]);
        }
    }
}
