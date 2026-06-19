# 🧹 CHALANG Cleanup Audit Report

> **Tarix:** 2026-04-26
> **Branch:** `JD/home` (React miqrasiyası — master toxunulmaz)
> **Sonuncu commit:** `fd34e21 fix: add subscribe translations and clean inline css`
> **Status:** ~700 uncommitted dəyişiklik (uzun müddətlik iş)
>
> **Məqsəd:** Hər faylı kateqoriyalaşdır → tövsiyə ver → istifadəçi təsdiqi gözlə → sonra commit/sil.

---

## 📊 Statistika

| Tip | Sayı | Açıqlama |
|---|---|---|
| `M` Modified | ~100 | Mövcud faylların dəyişiklikləri |
| `D` Deleted | ~600 | Köhnə admin theme asset-ləri (boxicons, crypto-icons, demo şablonlar) |
| `??` Untracked | ~200 | Yeni controller/model/React/plan faylları |
| **Cəmi** | **~900** | |

---

## 🗂️ Kateqoriyalar və Tövsiyələr

### 🟢 KATEQORİYA 1: SAXLA + COMMIT ET (Yeni iş — biznes dəyəri var)

#### 1.1. Yeni Controller-lər (Untracked) — **27 fayl**
Əhəmiyyətli yeni admin və front controllerlər:

```
app/Http/Controllers/Admin/
├── ActivityLogController.php          ← Activity log UI
├── AnalyticsController.php            ← GA4/Pixel/Yandex
├── BulkActionController.php           ← Toplu əməliyyatlar
├── CaseStudyController.php            ← Case Studies CRUD
├── ContenttextController.php          ← (Köhnə "Cortoller" əvəzi)
├── FaqController.php                  ← FAQ CRUD
├── GlobalSearchController.php         ← Admin global search
├── HealthController.php               ← Health/heartbeat endpoint
├── HomeSectionController.php          ← Home sections idarə
├── NotificationController.php         ← Bildirişlər
├── PageController.php                 ← Pages CMS
├── PartnerController.php              ← Partners CRUD
├── PricingPlanController.php          ← Pricing plans CRUD
├── SettingController.php              ← Tənzimləmələr
├── SubmissionController.php           ← Form submissions
├── SubscribeController.php            ← Newsletter abunəliklər
├── TeamMemberController.php           ← Team members CRUD
└── TestimonialController.php          ← Testimonials CRUD

app/Http/Controllers/Front/
├── CallRequestController.php          ← Book a Call form
├── CaseStudyController.php            ← Front case studies
├── OrderController.php                ← Sifariş formu
├── PackageController.php              ← Paketlər
├── PackageInquiryController.php       ← Paket sorğusu
├── SubscribeController.php            ← Newsletter
└── TeamController.php                 ← Front team page
```

> **Tövsiyə:** Bunların hamısı **lazımlıdır**. Amma 1-1 yoxlamaq lazım deyil — `git status`-də görünür və **yeni feature-lərdir**. **COMMIT 1**-də gedir.

---

#### 1.2. Yeni Model-lər (Untracked) — **15 fayl**

```
app/Models/
├── CaseStudy.php + CaseStudyTranslation.php
├── Faq.php + FaqTranslation.php
├── Page.php
├── Partner.php + PartnerTranslation.php
├── PricingPlan.php + PricingPlanTranslation.php
├── Setting.php
├── Submission.php
├── TeamMember.php + TeamMemberTranslation.php
└── Testimonial.php + TestimonialTranslation.php
```

> **Tövsiyə:** SAXLA. **COMMIT 2**-də gedir (controllerlər ilə əlaqəli).

---

#### 1.3. Yeni Migrations — **15 fayl**

```
database/migrations/
├── 2025_11_28_*  (case_studies, testimonials, partners, pricing_plans, team_members, faqs, submissions)
├── 2025_11_29_*  (settings, case_study_service, service relations, activity_log, status_column)
├── 2025_11_30_000000_create_notifications_table.php
├── 2025_12_22_200917_add_service_id_to_faqs_table.php
├── 2025_12_30_000000_migrate_slugs_to_translations.php
├── 2026_01_01_014240_add_website_to_subscribes_table.php
└── 2026_01_04_012744_create_pages_table.php
```

> **Tövsiyə:** SAXLA. **COMMIT 3**-də gedir.

---

#### 1.4. React Miqrasiya Fundamenti (Untracked) — **40+ fayl**

```
resources/js/
├── app.tsx                                    ← Inertia entry point
├── Pages/Home.tsx                             ← React Home səhifəsi
├── Layouts/MainLayout.tsx
├── Components/
│   ├── Button, Card, CookieConsent, ErrorBoundary,
│   ├── Footer, MobileMenu, Navbar, SearchOverlay,
│   ├── ThemeProvider, Typography
│   └── Sections/ (23 fayl: Hero, Services, Portfolio, etc.)
└── Hooks/
    ├── useMagneticHover, useNavPath, useScrollAnimation,
    └── useSectionEnabled, useTheme

resources/views/app.blade.php                 ← Inertia root template
app/Http/Middleware/HandleInertiaRequests.php ← Inertia shared props

vite.config.js                                ← Vite config (TypeScript + React)
tsconfig.json                                 ← TypeScript config
postcss.config.js, tailwind.config.js         ← Styling config
```

> **Tövsiyə:** SAXLA. **COMMIT 4**-də gedir (ən böyük commit — React stack-i).

---

#### 1.5. Yeni Service / Helper / Request Class-ları

```
app/Services/
├── FrontService.php           ← Front data hazırlama
└── NotificationRouter.php     ← Bildiriş routing

app/Helpers/
├── FeatureFlag.php            ← Feature toggle
└── SchemaHelper.php           ← JSON-LD generator

app/Http/Requests/
├── CallRequest.php
├── ContactRequest.php
├── OrderRequest.php
├── PackageInquiryRequest.php
├── ServiceRequest.php
└── SubscribeRequest.php

app/Console/Commands/
├── QueueHealthCheck.php
└── WarmCaches.php

app/ActivityLog/                ← Activity log custom logic
app/Datatable/                  ← Yeni datatable class-ları (CaseStudy, Faq, Partner, etc.)
app/Http/Middleware/CheckMaintenanceMode.php
app/Notifications/              ← Yeni notification class-ları
```

> **Tövsiyə:** SAXLA. **COMMIT 5**-də gedir.

---

#### 1.6. Modified — Mövcud Fayllarda Real İş (Sənin tərəfdən)

Bu fayllar **sənin işin nəticəsidir** — köhnə commitdən sonra dəyişdirilib:

```
M  app/Http/Controllers/Front/MainController.php   ← reactPreview() metodu əlavə
M  app/Http/Controllers/Admin/DashboardController.php
M  app/Http/Controllers/Admin/ServiceController.php
M  app/Http/Controllers/Admin/ProfileController.php
M  app/Http/Controllers/Admin/RoleController.php
M  app/Http/Controllers/Admin/FileController.php
M  app/Http/Controllers/Admin/BaseController.php
M  app/Http/Controllers/Front/AboutController.php  ← newVersion() metodu
M  app/Http/Controllers/Front/BlogController.php   ← newIndex(), newSingle()
M  app/Http/Controllers/Front/ServiceController.php ← newIndex(), newDetails()
M  app/Http/Controllers/Front/PortfolioController.php
M  app/Http/Controllers/Front/ContactController.php
M  app/Http/Controllers/Front/MessageController.php
M  app/Http/Controllers/LanguageController.php
M  app/Http/Kernel.php                              ← Inertia middleware qoşulması
M  app/Models/Service.php, Blog.php, Portfolio.php, User.php, Lang.php, etc.
M  app/Helpers/CmsSidebar.php                       ← Yeni menyu strukturu
M  app/Providers/AppServiceProvider.php
M  app/Providers/RouteServiceProvider.php
M  app/Traits/FileUploader.php
M  app/helpers.php
M  app/Console/Kernel.php                           ← Yeni komandalar qeydiyyatı
M  app/Datatable/BaseDatatable.php
M  composer.json + composer.lock                    ← Yeni packages (Inertia, Sentry, Activitylog, Permission)
M  package.json + package-lock.json                 ← React, TypeScript, Vite, Tailwind
M  config/cms_sidebar_menu.php                      ← Sidebar tam yeniləmə
M  config/lfm.php, debugbar.php
M  routes/web.php + routes/admin.php                ← Yeni routelar
M  database/seeders/DatabaseSeeder.php + UserSeeder.php
```

> **Tövsiyə:** SAXLA. **COMMIT 6**-da gedir (modified core fayllar).

---

#### 1.7. Yeni Blade Views (`_new` versiyalar)

```
resources/views/front/
├── about_new.blade.php                       ← Yeni About dizayn
├── contuct-us_new.blade.php
├── blogs/blog_new.blade.php + single_new.blade.php
├── portfolio/portfolio_new.blade.php + single_new.blade.php
├── services/services_new.blade.php + single_new.blade.php
├── index/index_new.blade.php
├── preview.blade.php                          ← Source of truth
├── cookie-policy.blade.php
└── layouts/
    ├── main_new.blade.php
    ├── abstrak.blade.php
    └── partials/
        ├── analytics.blade.php
        ├── breadcrumb.blade.php
        ├── cookie-consent.blade.php
        ├── dynamic-styles.blade.php
        ├── footer-modern.blade.php
        ├── header-preview.blade.php
        └── scroll_to_top.blade.php

resources/views/admin/  (yeni qovluqlar)
├── analytics/, notifications/
└── pages/
    ├── activity_log/, analytics/, builder/, case-study/,
    ├── faq/, home_sections/, partner/, pricing-plan/,
    ├── profile/, settings/, submission/, subscribe/,
    └── team-member/, testimonial/

resources/views/components/                   ← Reusable Blade components
resources/views/layouts/                      ← Main layouts
```

> **Tövsiyə:** SAXLA. **COMMIT 7**-də gedir.

---

#### 1.8. Translation Files (i18n)

```
M  resources/lang/az.json + en.json + ru.json
M  resources/lang/az/front.php + en/front.php + ru/front.php
?? resources/lang/az/admin.php + en/admin.php + ru/admin.php
?? resources/lang/az/preview.php + en/preview.php + ru/preview.php
```

> **Tövsiyə:** SAXLA. **COMMIT 6** ilə birlikdə gedir.

---

#### 1.9. Config Faylları

```
?? config/activitylog.php       ← Spatie Activity Log config
?? config/features.php          ← Feature flags
?? config/sentry.php            ← Sentry config
```

> **Tövsiyə:** SAXLA. **COMMIT 6** ilə birlikdə.

---

#### 1.10. Plan / Sənəd Faylları (30+) — **KONSOLİDƏ ET**

```
ADMIN_SITEMAP.md, IDEAL_SITEMAP.md, PLANS.md,
TODO.md, REACT_MIGRATION_GAPS_ANALYSIS.md,
SITE_BUILDER_SPEC.md, react_migration_plan.md,
new_tasks.md, work_log.md, task_deprecated.md,
book_a_call_plan.md, order_form_plan.md,
implementation_plan.md, implementation_plan_update.md,
error_tracking_plan.md, db_index_checklist.md,
performance_budgets.md, release_smoke_checklist.md,
frontend_sitemap.md, comprehensive_red_dot_analysis.md,
red_dot_master_report.md, red_dot_master_report_codex.md,
red_dot_phase1_report.md, red_dot_phase1_report_codex.md,
red_dot_consolidated_report.md, red_dot_analysis_findings.md,
.cursorrules, .blackboxrules
```

> **Tövsiyə:** SAXLA, lakin **konsolidə et**:
> - `ROADMAP.md` (PLANS.md + new_tasks.md + react_migration_plan.md birləşməsi)
> - `WORK_LOG.md` (work_log.md saxla)
> - `docs/` qovluğuna köçür: red_dot reportları, sitemap-lar, analiz sənədləri
> - **Sil:** `task_deprecated.md`
>
> **COMMIT 8**-də gedir.

---

#### 1.11. `.cursorrules` / `.blackboxrules` — IDE konfiqurasiyası
> **Tövsiyə:** SAXLA. AI editor agent-ləri üçün vacibdir.

---

#### 1.12. Public Build Folder

```
?? public/build/                ← Vite build output
?? public/assets/css/chalang-core.css        ← (yeni stylesheet)
?? public/assets/css/chalang-preview.css     ← (yeni stylesheet)
?? public/assets/js/chalang-preview.js       ← (yeni JS)
?? public/admin_assets/                       ← Yeni admin theme (Velzon?)
```

> **Tövsiyə:** SAXLA `chalang-*.css/js` (preview üçün lazımdır). `public/build/` zatən `.gitignore`-da olmalıdır (Vite output).

---

#### 1.13. Dizayn Referansı

```
?? abstrak/   (HTML/CSS şablonlar — index-1...5.html, service-*.html, etc.)
```

> **Tövsiyə:** SAXLA, amma **`docs/design-reference/abstrak/`** qovluğuna köçür və ya `.gitignore`-a əlavə et (əgər yalnız lokal referans üçündürsə). Repository ölçüsünü artırır.
>
> **Alternativ:** Bu **dizayn referansıdır** (Premium Abstrak teması — Phase 2.2.4 "Premium UI Suite"-də qeyd olunub). Saxlamaq dəyər verir.

---

### 🟡 KATEQORİYA 2: YOXLA (Qərarsız)

#### 2.1. Modified Public Assets — köhnə vendor JS/CSS

```
M  public/assets/js/vendor/bootstrap.min.js
M  public/assets/js/vendor/jquery-3.6.0.min.js
M  public/assets/js/vendor/slick.min.js
M  public/assets/js/vendor/sal.js + waypoints.min.js
M  public/assets/js/vendor/jquery.magnific-popup.min.js
M  public/assets/js/vendor/jquery.countdown.min.js
M  public/assets/js/vendor/jquery.style.switcher.js
M  public/assets/css/vendor/bootstrap.min.css + slick.css + slick-theme.css
M  public/assets/css/vendor/font-awesome.css
M  public/assets/css/vendor/sal.css + magnific-popup.css
M  public/assets/css/app.css + custom.css
M  public/assets/media/*.svg, *.png
M  public/assets/css/fonts/*.svg
```

> **Tövsiyə:** Bu fayllar `M` (modified) görünür, amma **ehtimal vendor library-lər**dir — sən onlara toxunmamısan, amma `git` line-ending fərqi və ya boşluq fərqlərini görür.
> **Yoxlama:** `git diff public/assets/js/vendor/jquery-3.6.0.min.js` — əgər real dəyişiklik yoxdursa, sadə `git checkout` ilə geri qaytarmaq olar.
> **Mənim tövsiyəm:** Saxla (commit et) — Blade `/preview` üçün hələ lazımdır.

---

#### 2.2. Modified Admin/Front Blade Views (~80 fayl)

Burada **çox iş edilib** — admin panel demək olar tam yenidən qurulub. Bunlar lazımdır.

> **Tövsiyə:** SAXLA. **COMMIT 7** ilə birlikdə (yeni view-lər ilə).

---

#### 2.3. Database SQL Dump

```
?? u463620882_db_chalang.sql        ← Sənin sözünlə: servis dataları
```

> **Tövsiyə:**
> - **Saxla** lokal disk-də (servis dataları əhəmiyyətlidir)
> - Amma **`.gitignore`-a əlavə et** — `*.sql` patterni
> - Yaxud xüsusi qovluğa köçür: `database/dumps/u463620882_db_chalang.sql` və qovluğu git-ignore et
>
> **Niyə git-də olmamalıdır?** SQL dump çox böyük fayldır, GitHub-a push olunduqda repo şişər. Production credentialləri yaza bilər.

---

#### 2.4. Seed Skriptləri

```
?? seed_preview_contenttexts.php   ← 262 sətir — content text seeder (--force, --dry-run dəstəyi)
?? seed_service_data.php           ← 105 sətir — service data populator
?? tmp_fill_missing_contenttexts.php
```

> **Tövsiyə:** Bunlar **dəyərli skriptlərdir** (database/seeders/-də olmalı idi).
> **Hərəkət:** `database/seeders/` altına köçür və ad dəyişdir:
> - `seed_preview_contenttexts.php` → `database/seeders/PreviewContenttextsSeeder.php` (Laravel seeder formatına salaraq)
> - `seed_service_data.php` → `database/seeders/ServiceDataSeeder.php`
> - `tmp_fill_missing_contenttexts.php` → SİL (artıqdır, eyni iş `seed_preview_contenttexts.php`-də var)

---

#### 2.5. Videos

```
?? videos/page@0d57ac9952e7cd8b7cd0111afd826257.webm
?? videos/page@2dee10a4bb4fa2fb76a26f165f223fb6.webm
```

> **Tövsiyə:** Bunlar ehtimalla **screen recording-lərdir** (test/audit zamanı çəkilmiş). Git-də olmamalıdır.
> **Hərəkət:** `.gitignore`-a `videos/` əlavə et və ya başqa yerə köçür.

---

#### 2.6. Demo Folder

```
demo/, project/, .blackbox/, .blackboxcli/
```

`.gitignore`-da `demo/`, `project/`, `.blackboxcli/` artıq var — yaxşı.

> **Tövsiyə:** Bütün bunlar `.gitignore`-da olduğundan rahatdır.

---

### 🔴 KATEQORİYA 3: SİL (Aşkar Zibil)

#### 3.1. Debug / Test / Repro PHP skriptləri — **20 fayl**

| Fayl | Məqsədi | Niyə artıqdır |
|---|---|---|
| `check_activity.php` | Son 10 activity log siyahısı | One-shot debug |
| `check_columns.php` | `activity_log` cədvəl sütunları | One-shot debug |
| `check_data.php` | Service-FAQ-CaseStudy əlaqələri | One-shot debug |
| `check_relations.php` | Service relations test | One-shot debug |
| `create_test_log.php` | Test activity log yaradır | One-shot test |
| `debug_last_log.php` | Sonuncu activity log göstərir | One-shot debug |
| `debug_log_50.php` | 50 log göstərir | One-shot debug |
| `debug_log_50_deep.php` | Eyni — daha dərin | One-shot debug |
| `fetch_html.php` | HTTP get test | One-shot test |
| `fix_cs_translation.php` | Case Study translation fixer | Bir dəfəlik düzəliş |
| `fix_data.php` | FAQ data fixer | Bir dəfəlik düzəliş |
| `fix_data_v2.php` | Eyni — yenilənmiş versiya | Bir dəfəlik düzəliş |
| `fix_images.php` | Image path fixer | Bir dəfəlik düzəliş |
| `fix_translations.php` | Translation fixer | Bir dəfəlik düzəliş |
| `list_services.php` | Servisləri sadalama | One-shot debug |
| `repro_500.php` | 500 error reprodüksiya | Debug |
| `repro_500_v2.php` | Eyni — yenilənmiş | Debug |
| `repro_500_v3.php` | Eyni — yenilənmiş | Debug |
| `stress_test_technical.php` | Maintenance mode test | One-shot test |
| `test_db.php` | DB connection test | One-shot test |
| `test_seeder.php` | TeamMember/Partner/Blog/Faq seeder | **YOXLA** — TestSeeder-i database/seeders/-ə köçürmək olar |
| `tmp_query.php` | reactPreview() debug | One-shot debug |
| `tmp_contenttext_missing_report.php` | Missing content text reporter | One-shot debug |
| `tmp_fill_missing_contenttexts.php` | Eyni — fixer | Already in seed_preview |
| `trigger_live_change.php` | Activity log triggering | One-shot test |
| `trigger_real_update.php` | Same | One-shot test |
| `trigger_service_update_placeholder.php` | Same | One-shot test |
| `audit_css.js` | CSS variable extractor | One-shot audit |

> **Tövsiyə:** **HAMISINI SİL** (test_seeder.php-i mümkün olarsa Laravel Seeder formatına çevir).

---

#### 3.2. Output / Log Faylları

| Fayl | Ölçü | Məzmun |
|---|---|---|
| `debug_output.txt` | ? | Debug runtime output |
| `error_log.txt` | ? | Error logları |
| `fetch_output.txt` | ? | HTTP fetch output |
| `tsc_output.txt` | ? | TypeScript compile output |
| `contenttext_missing_report.txt` | 157 B | Missing content text report |

> **Tövsiyə:** **HAMISINI SİL**. `.gitignore`-a `*.log`, `*_output.txt` əlavə et.

---

#### 3.3. Backup / .bak Faylları

```
public/assets/css/chalang-core.css.bak
public/assets/css/chalang-preview.css.bak
public/assets/css/temp_counter.css                  (929 B — temp counter style)
resources/views/front/preview.blade.php.bak
resources/views/front/index/index_backup.blade.php
```

> **Tövsiyə:** **HAMISINI SİL**. Versiya kontrolu git-dədir, .bak lazım deyil.

---

#### 3.4. PowerShell / JS Temp Skriptləri

```
tmp_analyze_sections.ps1
tmp_compare_classes.ps1
tmp_preview_script.js
tmp_preview_script_nocookie.js
tmp_preview_script_simpler.js
tmp_regex_test.js
```

> **Tövsiyə:** **HAMISINI SİL**.

---

#### 3.5. Task Faylları (Bölünmüş)

```
task.md.part1
task.md.part2
task.md.part3
task.md.part4
task.md.part5
```

> **Tövsiyə:** **HAMISINI SİL** (task_deprecated.md ilə birgə). Əgər content lazımdırsa, əvvəlcə oxu və yoxla — amma ehtimalla `new_tasks.md`-ə artıq köçürülüb.

---

#### 3.6. Köhnə Migration Tövsiyəsi

```
M  resources/views/home.blade.php  →  D  (deleted)
```

`home.blade.php` artıq silinmişdir, kommit zamanı bunu da daxil et.

---

### ⚫ KATEQORİYA 4: DELETED (Köhnə admin theme)

```
D  public/admin/assets/...  (~600 fayl)
   - boxicons fonts
   - crypto-icons (.svg) — 500+ SVG
   - demo şəkillər (NFT, ecommerce, profile)
   - köhnə JS pages (apexcharts, datatables, calendar, etc.)
   - libs (apexcharts, chart.js, fullcalendar, leaflet, glightbox, etc.)
   - plugins (ckeditor, datatables, select2)
```

> **Tövsiyə:** **COMMIT EDİLMƏLİDİR** (zatən silinmiş, sadəcə commit et). Yeni admin theme `public/admin_assets/`-də yerləşdirilib.
> **COMMIT 9**-da gedir: `chore: Remove deprecated admin theme assets (Velzon old version)`

---

### 📄 KATEQORİYA 5: PLAN SƏNƏDLƏRİ — KONSOLİDƏ ET

Hal-hazırda root-da **30+ markdown** sənədi var. Bu çoxdur. Tövsiyə:

#### Saxlanılacaqlar (root-da):
- `README.md`
- `ROADMAP.md` (yeni — birləşmiş)
- `WORK_LOG.md` (yeni ad ilə)
- `REACT_MIGRATION_GAPS_ANALYSIS.md` (cari analiz)
- `CLEANUP_AUDIT_REPORT.md` (bu sənəd)
- `.cursorrules`, `.blackboxrules`

#### `docs/` qovluğuna köçürüləcəklər:
```
docs/
├── design-reference/abstrak/                ← HTML şablonlar
├── plans/
│   ├── react_migration_plan.md
│   ├── implementation_plan.md
│   ├── implementation_plan_update.md
│   ├── book_a_call_plan.md
│   ├── order_form_plan.md
│   ├── error_tracking_plan.md
│   └── PLANS.md (köhnə master plan)
├── sitemap/
│   ├── ADMIN_SITEMAP.md
│   ├── IDEAL_SITEMAP.md
│   └── frontend_sitemap.md
├── audit/
│   ├── red_dot_master_report.md
│   ├── red_dot_master_report_codex.md
│   ├── red_dot_phase1_report.md
│   ├── red_dot_phase1_report_codex.md
│   ├── red_dot_consolidated_report.md
│   ├── red_dot_analysis_findings.md
│   └── comprehensive_red_dot_analysis.md
├── specs/
│   ├── SITE_BUILDER_SPEC.md
│   ├── db_index_checklist.md
│   ├── performance_budgets.md
│   └── release_smoke_checklist.md
└── checklists/
    └── TODO.md
```

#### Silinəcəklər:
- `task_deprecated.md`
- `task.md.part1...part5`
- `new_tasks.md` (məzmunu `ROADMAP.md`-ə köçür)

---

## 🎯 Tövsiyə Olunan Commit Strukturu

| # | Commit Mesajı | Faylların Sayı |
|---|---|---|
| **1** | `feat(admin): Add new admin controllers (analytics, activity log, case studies, FAQ, partners, etc.)` | 18 |
| **2** | `feat(models): Add new models for CMS modules (CaseStudy, Testimonial, Partner, FAQ, etc.)` | 15 |
| **3** | `feat(db): Add migrations for new CMS tables and Spatie Activity Log` | 15 |
| **4** | `feat(react): Initialize React + Inertia migration foundation (Pages, Components, Hooks)` | 40+ |
| **5** | `feat(app): Add services, helpers, requests, notifications, datatables, console commands` | 25+ |
| **6** | `feat(core): Update controllers, models, providers, helpers + add Inertia middleware + new packages` | ~100 (modified) |
| **7** | `feat(views): Add _new design system blade views + admin views for new modules` | ~80 |
| **8** | `docs: Consolidate roadmap and plan documents into docs/ structure` | ~30 |
| **9** | `chore: Remove deprecated admin theme assets (~600 files)` | ~600 (deleted) |
| **10** | `chore: Cleanup temp/debug/test scripts + update .gitignore` | ~35 (deleted) |

---

## 🛡️ `.gitignore` Yeni Əlavələr

Cari `.gitignore`-a əlavə olunmalı patternlər:

```gitignore
# Temp & Debug
debug_*.php
check_*.php
fix_*.php
repro_*.php
tmp_*.*
test_db.php
test_seeder.php
trigger_*.php
fetch_*.php
list_*.php
*_output.txt
*.bak
audit_css.js
stress_test_*.php

# Database dumps
*.sql
database/dumps/

# Videos & Recordings
videos/
*.webm
*.mp4

# Build artifacts
public/build/

# IDE
.cursor/
*.swp
```

---

## 🔴 KATEQORİYA 3 — DƏQİQ SİLMƏ SİYAHISI

Aşağıdakı **35 fayl** sənin təsdiqindən sonra siləcəyəm:

### Root-da Debug/Test PHP (28 fayl)
```
audit_css.js
check_activity.php
check_columns.php
check_data.php
check_relations.php
create_test_log.php
debug_last_log.php
debug_log_50.php
debug_log_50_deep.php
debug_output.txt
error_log.txt
fetch_html.php
fetch_output.txt
fix_cs_translation.php
fix_data.php
fix_data_v2.php
fix_images.php
fix_translations.php
list_services.php
repro_500.php
repro_500_v2.php
repro_500_v3.php
stress_test_technical.php
test_db.php
trigger_live_change.php
trigger_real_update.php
trigger_service_update_placeholder.php
tsc_output.txt
contenttext_missing_report.txt
```

### Tmp Skriptləri (8 fayl)
```
tmp_analyze_sections.ps1
tmp_compare_classes.ps1
tmp_contenttext_missing_report.php
tmp_fill_missing_contenttexts.php
tmp_preview_script.js
tmp_preview_script_nocookie.js
tmp_preview_script_simpler.js
tmp_query.php
tmp_regex_test.js
```

### Backup Faylları (5 fayl)
```
public/assets/css/chalang-core.css.bak
public/assets/css/chalang-preview.css.bak
public/assets/css/temp_counter.css
resources/views/front/preview.blade.php.bak
resources/views/front/index/index_backup.blade.php
```

### Task Bölmələri (6 fayl)
```
task.md.part1
task.md.part2
task.md.part3
task.md.part4
task.md.part5
task_deprecated.md
```

### **Cəmi: 48 fayl silinəcək**

### YOXLA + Köçür (3 fayl)
```
seed_preview_contenttexts.php  →  database/seeders/PreviewContenttextsSeeder.php
seed_service_data.php           →  database/seeders/ServiceDataSeeder.php
test_seeder.php                 →  database/seeders/DemoSeeder.php (yoxla, sonra)
```

### YOXLA + Hərəkət (1 fayl)
```
u463620882_db_chalang.sql      →  database/dumps/  (.gitignore-a əlavə)
```

### YOXLA + Hərəkət (1 qovluq)
```
videos/                         →  .gitignore-a əlavə (silmə, lokal qoy)
```

---

## ❓ Sənin Qərarın Lazımdır

### Sual 1: Yuxarıdakı **48 fayl silmə siyahısı** ilə razısan?
- 🅰️ Bəli, hamısını sil
- 🅱️ Bəzi fayllar haqqında şübhəm var, mənə də göstər (hansı?)
- 🅲️ Konkret bir fayl haqqında soruşmaq istəyirəm: ___

### Sual 2: **Commit strukturu** ilə razısan? (10 commit)
- 🅰️ Bəli, plana uyğun get
- 🅱️ Daha az/çox commit istəyirəm
- 🅲️ Tək commit ilə hamısını yığ ("WIP: massive update")

### Sual 3: **Plan sənədlərinin konsolidasiyası** (`docs/` qovluğuna köçürmə) razısan?
- 🅰️ Bəli, `docs/` strukturunu yarat
- 🅱️ Yox, hələlik root-da qalsın (sonra)
- 🅲️ Yalnız bəzilərini sil (məs. `task_deprecated.md`, `task.md.part*`)

### Sual 4: **DB SQL dump** (`u463620882_db_chalang.sql`) ilə nə edirik?
- 🅰️ `database/dumps/` qovluğuna köçür + `.gitignore`-a əlavə
- 🅱️ Sadəcə `.gitignore`-a əlavə et, yerində qoy
- 🅲️ Tamamilə sil (mənə məsləhət yoxdur — siz bilirsiniz)

### Sual 5: **`videos/` qovluğu** ilə nə edirik?
- 🅰️ `.gitignore`-a əlavə et, lokal qoy (silmə)
- 🅱️ Tamamilə sil

### Sual 6: **`abstrak/` qovluğu** (HTML dizayn referansları) ilə nə edirik?
- 🅰️ Saxla, `docs/design-reference/abstrak/` altına köçür
- 🅱️ `.gitignore`-a əlavə et, yerində qoy
- 🅲️ Sil

### Sual 7: **`seed_*.php`** fayllarını Laravel Seeder formatına çevirim?
- 🅰️ Bəli, `database/seeders/`-ə köçür və ad dəyişdir
- 🅱️ Hələlik yerində qoy, sonra
- 🅲️ Sil

---

## 📝 Yekun Cədvəl

| Hərəkət | Faylların Sayı | Hərəkət |
|---|---|---|
| 🟢 SAXLA + COMMIT | ~270 | 10 məntiqli commit |
| 🔴 SİL | 48 | Birbaşa silmə |
| 🟡 KÖÇÜR | 4 | seed_*.php → seeders/, .sql → dumps/ |
| 📁 RE-ORGANIZE | 30+ docs | `docs/` strukturuna |
| ⚫ DELETED COMMIT | ~600 | Köhnə admin theme |

---

> **Növbəti Addım:** Sənin yuxarıdakı 7 suala cavabını gözləyirəm. Cavablarına görə **dəqiq icra planı** hazırlayacağam.

---

> 🎯 **Mənim ümumi tövsiyəm:**
> - **Sual 1:** 🅰️ (hamısını sil — 48 fayl)
> - **Sual 2:** 🅰️ (10 məntiqli commit)
> - **Sual 3:** 🅰️ (`docs/` strukturu yarat)
> - **Sual 4:** 🅰️ (`database/dumps/` + `.gitignore`)
> - **Sual 5:** 🅰️ (`.gitignore`-a əlavə)
> - **Sual 6:** 🅰️ (`docs/design-reference/abstrak/` saxla)
> - **Sual 7:** 🅰️ (Laravel Seeder formatına çevir)

> © 2026 Chalang Cleanup Audit | Hazırlandı: 2026-04-26
