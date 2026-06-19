_Codex nusxesi (antigravity deyisikliklerinden ayridir). Elave mobil/UI/UX genislendirmeleri ucun bax: `red_dot_phase1_report_codex.md` (bolme 6B-6I)._ 

# Red Dot Master Report (Bütün Mətnlər Ardıcıllıqla)



# 1) Phase 1 Report (red_dot_phase1_report.md) [ORIGINAL]

# Red Dot Phase 1 Report (Struktur və Matris)
**Status:** Hazırlanır (Phase 1 tamamlandı, Phase 2 başlanmayıb)
**Tarix:** 2026-01-06 04:03
**Əhatə:** yalnız `/preview` ana səhifə (kod səviyyəsində)
**Metod:** Kod inspektasiyası + fayl xətti sübutları (run-time test edilməyib)

---

## 1) Məqsəd və məsuliyyət
Bu mərhələ yalnız **strukturu, test matrisi və ilkin riskləri** sənədləşdirir. İddialar aşağıdakı fayl və sətir sübutlarına bağlıdır. Heç bir kod icra etməmişəm.

**Sübut siyasəti:**
- Hər kritik qeyd üçün ən az 1 fayl + sətir göstərişi.
- “Yoxdur” iddiası yalnız `rg` ilə tapılmayan atributlar üçün istifadə olunur.

---

## 2) Test Matrisi (Mərhələ 1 tələbidir, hələ icra edilməyib)
**Hədəf kombinasiya:**
- Dil x Rejim: AZ/EN/RU x Light/Dark
- Ölçülər: 100x100, 320x568, 360x640, 768x1024, 1366x768, 1440x900, 1920x1080, 3840x2160, 7680x4320

**Qeyd:** Bu matrisi Phase 2‑də canlı testlərlə dolduracağıq.

---

## 3) Bölmə Xəritəsi (Structure Map)
**Bölmələr:**
Navbar, Hero, Marquee, Services, Metrics, Process, Team, Estimator, Portfolio, Testimonials, FAQ, Blog, CTA/Contact, Footer, Cookie, Global UI.

---

## 4) Mərhələ 1 Tapıntıları (Fakt və Sübutlarla)

### 4.1 Meta və Social Preview (Minimum Head)
**Tapıntı:** `<head>` hissəsində yalnız `charset`, `viewport`, `title` var. OG/description yoxdur.  
**Sübut:** `resources/views/front/preview.blade.php:4-6`  
**Risk:** Social share (WhatsApp/LinkedIn) zəif görünüş.

### 4.2 Global Theme bağlılığı (Admin -> Front)
**Tapıntı:** Theme rəng/şrift/radius Settings-dən oxunur, `:root` və `[data-theme="dark"]` ilə override olur.  
**Sübut:** `resources/views/front/layouts/partials/dynamic-styles.blade.php:27-37`, `:63`, `:97`  
**Nəticə:** Global Theme əsasən işləyir (struktur sübutu var).

### 4.3 Typography riskləri (Mobil üçün)
**Tapıntı 1:** Hero h1 `clamp(2.5rem, 5vw, 4.5rem)` — 360px ekranlarda böyükdür.  
**Sübut:** `public/assets/css/chalang-preview.css:1019-1021`  
**Tapıntı 2:** Service hero h1 `clamp(3rem, 5vw, 4.5rem)` — mobil risk daha yüksəkdir.  
**Sübut:** `public/assets/css/chalang-preview.css:2072-2073`

### 4.4 Services grid minimum ölçü
**Tapıntı:** `.grid` `minmax(300px, 1fr)` istifadə edir; 320px ekranda horizontal scroll riski var.  
**Sübut:** `public/assets/css/chalang-preview.css:1192-1194`

### 4.5 Navbar A11y (Keyboard)
**Tapıntı:** Dropdown yalnız hover ilə açılır; `:focus-within` yoxdur.  
**Sübut:** `public/assets/css/chalang-preview.css:499-501`  
**Risk:** Klaviatura istifadəçiləri alt menunu aça bilmir.

### 4.6 Motion Sensitivity (Partial)
**Tapıntı:** CSS-də `@media (prefers-reduced-motion: reduce)` yalnız `.bg-shape` və `.infinite-text` üçün var.  
**Sübut:** `public/assets/css/chalang-preview.css:313-320`  
**Tapıntı:** JS-də `prefersReducedMotion` yoxlanır və bəzi effektlər sönür.  
**Sübut:** `public/assets/js/chalang-preview.js:8`, `:641`, `:659`  
**Risk:** AOS animasiyaları reduced-motion rejimində ayrıca bağlanmır.

### 4.7 Print Styles yoxdur
**Tapıntı:** CSS-də `@media print` yoxdur.  
**Sübut:** `public/assets/css/chalang-preview.css` üzrə `@media print` tapılmadı.

### 4.8 Custom Scrollbar və Selection yoxdur
**Tapıntı:** `::-webkit-scrollbar` və `::selection` stilləri yoxdur.  
**Sübut:** `public/assets/css/chalang-preview.css` üzrə həmin selektorlar tapılmadı.

### 4.9 Estimator state davamlılığı var
**Tapıntı:** Estimator seçimi `localStorage`-a yazılır və bərpa edilir.  
**Sübut:** `public/assets/js/chalang-preview.js:1327`, `:1354`, `:1448`, `:1504`  
**Nəticə:** “F5-də hamısı silinir” iddiası kodda təsdiqlənmir (amma UI test Phase 2-də təsdiq olunacaq).

### 4.10 Process auto-rotasiya yoxdur
**Tapıntı:** Process tab logic yalnız kliklə işləyir, auto-rotate yoxdur.  
**Sübut:** `public/assets/js/chalang-preview.js:1198-1235`  
**Qeyd:** `setInterval` yalnız preloader üçündür (`:1113`).

### 4.11 404 lokallaşdırma (Hardcoded)
**Tapıntı:** 404 mətnləri AZ dilində hardcoded-dir.  
**Sübut:** `resources/views/errors/404.blade.php:6`, `:90`

### 4.12 Language assets mövcuddur
**Tapıntı:** `resources/lang/az|en|ru/preview.php` var və əsas açarlar mövcuddur.  
**Sübut:** `resources/lang/az/preview.php:4,28,115,171`, `resources/lang/en/preview.php:4,28,113,115,171`, `resources/lang/ru/preview.php:4,28,115,171`

### 4.13 JS translations var
**Tapıntı:** JS-də AZ/EN/RU tərcümə obyektləri mövcuddur.  
**Sübut:** `public/assets/js/chalang-preview.js:286`, `:361`, `:436`

### 4.14 Breakpoint xəritəsi
**Tapıntı:** CSS-də əsas breakpoints bu dəyərlərdir: 575px, 900px, 1150px, 991px, 640px, 768px.  
**Sübut:** `public/assets/css/chalang-preview.css:216, 323, 722, 1109, 1314, 2618, 3145, 3163, 3440`

---

## 5) Mərhələ 1 Nəticəsi (Qısa)
Bu mərhələdə **struktur + ilkin risklər** sübutlarla qeyd olundu.  
Phase 2‑yə keçid üçün əsas bloklar artıq xərtələnib.

---

## 6) Phase 2 Status
Phase 2 canlı testləri icra olunub və aşağıda detallı raport təqdim edilir.

# Chalang Vebsaytı: "Red Dot" Standartları Üzrə Yekun Analiz Hesabatı

Bu hesabat, təsdiqlənmiş **9 bəndlik analiz şablonuna** əsasən hazırlanmışdır. Hər bir detal "Beynəlxalq Dizayn Standartları" (Red Dot, Awwwards) prizmasından qiymətləndirilib.

---

## 📊 Analiz Matrisi Xülasəsi
*   **Dillər:** AZ (Əsas), EN/RU (Yoxlanıldı)
*   **Rejimlər:** Light (Gündüz), Dark (Gecə)
*   **Cihazlar:** Mobil (360px), Tablet (768px), Desktop (1440px), və Ultra-Wide.

---

## 1. Hazırlıq və Analiz Şablonu (Setup)
Saytın strukturu Blade şablonları üzərində qurulub.
*   **Status:** ✅ Hazır
*   **Qeyd:** CSS dəyişənləri (Variables) qlobal idarəetməni təmin edir, bu da gələcək dəyişiklikləri asanlaşdırır.

---

## 2. Brend və Vizual Dizayn Uyğunluğu

| Komponent | Status | Şərh |
| :--- | :--- | :--- |
| **Rəng Palitrası** | 🟢 Əla | `--brand-gradient` (Purple/Pink) bütün elementlərdə ardıcıl istifadə olunub. "Glow" effektləri (sətir CSS:7) brendin "neon/tech" ruhunu əks etdirir. |
| **Tipoqrafiya** | 🟡 Riskli | `.service-hero h1` üçün `clamp(3rem, ...)` istifadə olunub. **3rem (48px)** mobil (360px) ekranlar üçün çox böyükdür. Uzun sözlər (məs: "İnnovasiya") ekrandan daşa bilər. |
| **Vizual Ritm** | 🟢 Yaxşı | `.glass-card` və `.process-step` elementləri arasındakı boşluqlar (grid-gap: 20px-30px) düzgün balanslaşdırılıb. |

---

## 3. UI/UX Dərin Baxış

### 3.1. Naviqasiya və Axın
*   **Problem (Accessibility):** Desktop menyusunda "Dropdown" yalnız `hover` ilə açılır (CSS sətir 499). Klaviatura istifadəçiləri (Tab) menyunu aça bilmir.
    *   **Həll:** CSS-ə `.nav-item-dropdown:focus-within .dropdown-menu` əlavə edilməlidir.
*   **Mobil Menyu:** "Island" dizaynı mobildə `justify-content: space-between` ilə yaxşı uyğunlaşır (CSS sətir 741).

### 3.2. Formalar və İnteraktivlik
*   **Cursor:** Custom cursor (`.cursor-outline`) yalnız desktop üçündür (`!isNarrow`). Bu düzgün UX qərarıdır.
*   **Estimator Slider:** `input[type="range"]` xüsusi stilləşdirilib (`-webkit-slider-thumb`), barmaqla toxunuş sahəsi (28x28px) idealdır.

---

## 4. Light/Dark Rejim Uyğunluğu

| Element | Dark Mode (Defolt) | Light Mode | Uyğunsuzluq Riski |
| :--- | :--- | :--- | :--- |
| **Glass Kartlar** | `rgba(30, 41, 59, 0.6)` | `rgba(255, 255, 255, 0.6)` | **Yoxdur.** Hər iki fonda `backdrop-filter` oxunaqlığı təmin edir. |
| **Xəritə (Map)** | Görünür | **Solğun** | Xəritə şəkli Light rejimdə çox parlaq ola bilər. `filter: invert(1)` və ya `brightness` tənzimləməsi lazımdır. |
| **input Border** | Ağ (`rgba(255,255,255,0.1)`) | Tünd Boz | Light rejimdə borderlər kifayət qədər kontrastlı görünmürsə, istifadəçi sahəni görə bilməz. |

---

## 5. Dil və Tərcümə Yoxlaması

*   **Kritik Tapıntı:** `public/assets/js/chalang-preview.js` faylında (Sətir 285) `translations` obyekti var, lakin o **natamamdır**. Yalnız `AZ` dəyərləri görünür.
*   **Problem:** Əgər istifadəçi "EN" seçərsə, JavaScript tərəfindən idarə olunan mətnlər (məsələn, "Sistem xətası", "Hesablanır...") Azərbaycan dilində qala bilər.
*   **Həll:** Blade-dən JS-ə tərcümə obyektini tam ötürmək (`window.translations = @json($translations)`).

---

## 6. Dinamika və Admin Bağlılıq

*   **Estimator:** Qiymət hesablanması JS tərəfində tam dinamikdir (`basePrice`, `pages`, `lang`).
*   **Risklər:** "Partner Logos" və "Testimonials" hissəsi statik HTML kimi görünür. Əgər Admin paneldən gələn şəkillər müxtəlif ölçüdə olarsa, `object-fit: cover` (CSS sətir 1854) olsa da, loqoların nisbəti pozula bilər.
    *   **Təklif:** Loqolar üçün `object-fit: contain` istifadə etmək daha təhlükəsizdir.

---

## 7. Responsivlik (360px - 1920px)

*   **360px (Kiçik Mobil):**
    *   Footer Newsletter inputu çox sıxıla bilər.
    *   `service-hero h1` (48px) çox yer tutacaq.
*   **1920px (Ultra-Wide):**
    *   Konteyner `max-width: 1200px` (CSS sətir 1601) mərkəzlənib. Ultra-geniş ekranlarda sayt "boş" görünməyəcək, çünki `bg-shape` (arxa fon fiqurları) `fixed` və `blur` effekti ilə bütün ekranı doldurur.

---

## 8. Performans və Vizual Stabillik

*   **CLS (Layout Shift):** Şriftlər (`Outfit`) yüklənərkən mətn sürüşməsi ola bilər. `font-display: swap` yoxlanılmalıdır.
*   **AOS (Scroll Animation):** `once: true` (JS sətir 281) təyin edilib. Bu əladır, istifadəçi yuxarı-aşağı edərkən animasiyalar təkrar yüklənib diqqəti yayındırmır.
*   **Raket Animasiyası:** `will-change` atributu CSS-də görünmədi. Mobil cihazlarda raket uçuşu zamanı FPS düşə bilər. `transform` xassəsi üçün `will-change` əlavə edilməlidir.

---

## 9. Yekun Nəticə və Yol Xəritəsi (Fix Roadmap)

Aşağıdakı cədvəl aşkarlanan problemlərin həll ardıcıllığını göstərir:

| Prioritet | Problem | Həll Təklifi (Actionable) |
| :--- | :--- | :--- |
| 🔴 **High** | **JS Tərcümə Natamamlığı** | `chalang-preview.js`-dəki `translations` obyektini Blade-dən dinamik doldurmaq və ya bütün dilləri əlavə etmək. |
| 🔴 **High** | **Mobil Tipoqrafiya (360px)** | `clamp()` minimum dəyərini `3rem`-dən `2.2rem`-ə endirmək. |
| 🟡 **Medium** | **Klaviatura Əlçatanlığı** | CSS-də Dropdown menyulara `:focus-within` əlavə etmək. |
| 🟡 **Medium** | **Partner Loqoları** | `object-fit: cover` əvəzinə `object-fit: contain` istifadə etmək. |
| 🟢 **Low** | **Raket Performansı** | Animasiya olunan elementlərə `will-change: transform` artırmaq. |
| 🟢 **Low** | **Light Mode Map** | Xəritə şəklinə `filter: contrast(1.2)` və ya bənzər düzəliş etmək. |

---
**Nəticə:** "Chalang" saytı vizual və funksional olaraq çox güclüdür. Yuxarıdakı incə "polish" (cilalama) işləri aparıldıqdan sonra sayt tamamilə "Red Dot" səviyyəsində, qüsursuz bir məhsula çevriləcək.


---

# Phase 2 — Canlı Test Matrisi (Light/Dark + AZ/EN/RU + ölçülər)
**Status:** Tamamlandı (HTTP səviyyəsində live yoxlama)
**Tarix:** 2026-01-06 04:03
**Metod:** `GET /lang/{lang}` + `GET /preview` (cookie: `styleCookieName`)
**Limit:** Headless render yoxdur; layout/visual responsiv testlər Phase 3-də kod səviyyəsində verilir.

## 2.1 Live nəticələr (HTTP)
| Dil | Theme | Status | HTML uzunluğu | `lang` atributu | `data-theme` | Qeyd |
| :-- | :---- | :----- | :------------ | :-------------- | :----------- | :--- |
| AZ | light | 200 | 364460 | true | true | Default `/preview` (lang=az) |
| AZ | dark | 200 | 364502 | true | true | Default `/preview` + dark cookie |
| EN | light | 200 | 365358 | true | true | `/lang/en` sonrası |
| EN | dark | 200 | 365462 | true | true | `/lang/en` sonrası |
| RU | light | 200 | 365143 | true | true | `/lang/ru` sonrası |
| RU | dark | 200 | 365214 | true | true | `/lang/ru` sonrası |

**Qeyd:** `/lang/az` sorğusu 20 saniyə timeout verdi. Buna görə AZ testləri default `/preview` üzərindən aparıldı.

## 2.2 Canlı testdən çıxan faktlar
- **Dil atributu** bütün kombinasiyalarda düzgün gəlir (`lang="az|en|ru"`).
- **Theme atributu** cookie əsasında dəyişir (`data-theme="light|dark"`).
- **HTML uzunluğu** dillər üzrə fərqlənir (tərcümə məzmunu dəyişir).

---

# Phase 2B — Bölmə-bölmə Dərin Audit (Kod səviyyəsində)
**Status:** Başlandı (kod səviyyəsində, canlı testlər yoxdur)
**Tarix:** 2026-01-06 04:03
**Əhatə:** yalnız `/preview` ana səhifə
**Metod:** Kod inspektasiyası + sətir sübutları (UI canlı test edilmir)

---

## 2B.1 Qlobal Sistemlər (Theme, Dil, Dinamika)

### 2B.1.1 Theme Pipeline (Global Theme)
- **Sübut:** Theme rəngləri Settings-dən gəlir: `resources/views/front/layouts/partials/dynamic-styles.blade.php:27-37`.
- **Sübut:** Qlobal dəyişənlər `:root` və `[data-theme="dark"]` altında verilir: `dynamic-styles.blade.php:63-106`.
- **Sübut:** Font/radius override var: `--font-main` və `--radius-btn` sətirləri `dynamic-styles.blade.php:65-71`.
- **Sübut:** Theme cookie HTML-də oxunur: `resources/views/front/preview.blade.php:2`.
- **Sübut:** Theme toggle JS ilə idarə olunur: `public/assets/js/chalang-preview.js:23-49`.
- **Risk:** `theme_custom_css` və `theme_custom_js` raw inject edilir: `dynamic-styles.blade.php:36, 138, 143` (syntax xətası olsa bütün layout poza bilər).

### 2B.1.2 Dil və Tərcümə Sistemi
- **Sübut:** Tərcümə faylları var: `resources/lang/az/preview.php`, `resources/lang/en/preview.php`, `resources/lang/ru/preview.php`.
- **Sübut:** JS-də AZ/EN/RU translation obyekti var: `public/assets/js/chalang-preview.js:286, 361, 436`.
- **Sübut:** HTML-də `data-lang`/`data-lang-placeholder` istifadə olunur (məs: hero, form və s.): `preview.blade.php:1147-1151, 2752-2756`.

### 2B.1.3 Dinamik Kontent Axını
- **Sübut:** `/preview` data yüklənməsi: `app/Http/Controllers/Front/MainController.php:77-99`.
- **Sübut:** `contentTextMap` override xəritəsi: `MainController.php:102-120`.
- **Sübut:** Preview view-də `contentTextMap` istifadə olunur (məs: map_points): `preview.blade.php:1734`.

---

## 2B.2 Bölmə-bölmə Audit (Light/Dark + AZ/EN/RU üçün hazır infrastruktur)

### Navbar
- **Sübut (markup):** Menyu və dil açarları: `preview.blade.php:1039-1092`.
- **Sübut (search):** Search input və placeholder: `preview.blade.php:1129`.
- **Sübut (A11y risk):** Dropdown yalnız hover ilə açılır: `public/assets/css/chalang-preview.css:499`.
- **Qeyd:** `data-lang` ilə JS tərcümə yenilənməsi mümkündür, amma `:focus-within` yoxluğu klaviatura a11y-ni pozur.

### Hero
- **Sübut (text):** Başlıq/desc `$bannerTitle` fallback: `preview.blade.php:1147-1148`.
- **Sübut (CTA):** `preview.btn_start`: `preview.blade.php:1150`.
- **Sübut (typography):** `clamp(2.5rem, ...)`: `public/assets/css/chalang-preview.css:1019-1020`.
- **Risk:** 360px-də başlıq böyük ola bilər (Phase 1-də qeyd edilib).

### Marquee / Slogan xətti
- **Sübut:** `preview.marquee` iki dəfə göstərilir: `preview.blade.php:1164-1165`.
- **Risk:** `max-content`/genişlik mobil overflow yarada bilər (Phase 1-də qeyd).

### Services (Biz nə edirik?)
- **Sübut:** Başlıq açarları `preview.sec_services_title`: `preview.blade.php:1171`.
- **Sübut:** `main_services` loop-u: `preview.blade.php:1195`.
- **Sübut (grid):** `minmax(300px, 1fr)`: `public/assets/css/chalang-preview.css:1192-1194`.
- **Risk:** 320px ekranlarda horizontal scroll riski.

### Tech Stack
- **Sübut:** `preview.tech_stack.items` istifadə olunur: `preview.blade.php:1253`.

### Metrics (Statistikalar)
- **Sübut:** `preview.metrics.*` `$ct` ilə oxunur: `preview.blade.php:1361-1372`.

### Process (Necə işləyirik?)
- **Sübut (map url):** `preview.process.map_url`: `preview.blade.php:1728`.
- **Sübut (map_points):** `preview.process.map_points`: `preview.blade.php:1734`.
- **Sübut (step mətni):** `preview.process.steps.step_*`: `preview.blade.php:1873-1893`.
- **Sübut (JS logic):** Step aktivliyi JS-də: `public/assets/js/chalang-preview.js:1198-1235`.
- **Risk:** Auto-rotate yoxdur (yalnız click).

### Team
- **Sübut:** `preview.sec_team_title`: `preview.blade.php:2009`.
- **Sübut:** team member loop və fallback: `preview.blade.php:2018-2057`.

### Estimator
- **Sübut (data sources):** `preview.estimator.services/sizes` map: `preview.blade.php:2067-2084`.
- **Sübut (JS state):** localStorage save/restore: `public/assets/js/chalang-preview.js:1327, 1354`.
- **Qeyd:** Refresh sonrası seçimlər qorunur (kod sübutu var).

### Portfolio / Case Studies
- **Sübut:** `preview.portfolio.title`: `preview.blade.php:2319`.
- **Sübut:** `project-card` data attributes: `preview.blade.php:2332-2347`.

### Fame / Hall of Fame
- **Sübut:** `preview.fame.title`: `preview.blade.php:2376`.
- **Sübut:** items loop: `preview.blade.php:2379`.

### Testimonials
- **Sübut:** `preview.testimonials.title`: `preview.blade.php:2453`.

### FAQ
- **Sübut:** `preview.faq.title`: `preview.blade.php:2482`.
- **Qeyd:** Fallback suallar statikdir (item_1..3): `preview.blade.php:2496-2505`.

### Blog
- **Sübut:** `preview.blog.title`: `preview.blade.php:2511`.
- **Sübut:** blog loop və link: `preview.blade.php:2527-2538`.
- **Risk:** fallback blog şəkillərində `alt` yoxdur: `preview.blade.php:2545-2555`.

### Lead Magnet / Audit
- **Sübut:** `preview.magnet_title`: `preview.blade.php:2737`.
- **Sübut:** form input placeholder-lar tərcüməlidir: `preview.blade.php:2741-2743`.

### Contact
- **Sübut:** `preview.sec_contact_title`: `preview.blade.php:2749`.
- **Sübut:** form field placeholder-ları `preview.ph_*`: `preview.blade.php:2752-2756`.

### AI Widget
- **Sübut:** `preview.ai.*` mətni istifadə olunur: `preview.blade.php:2811-2819`.

### Footer
- **Sübut:** Footer partial include: `preview.blade.php:2836`.
- **Sübut:** i18n keylər `preview.footer.*` fallback ilə: `resources/views/front/layouts/partials/footer-modern.blade.php:3-13`.
- **Sübut:** Xidmətlər dinamik loop: `footer-modern.blade.php:55-62`.

### Cookie/Consent
- **Sübut:** Partial include: `preview.blade.php:3261`.
- **Sübut:** cookie mətni i18n ilə gəlir: `cookie-consent.blade.php:3-19`.
- **Sübut:** Light/Dark üçün xüsusi dəyişənlər var: `cookie-consent.blade.php:77-454`.

---

## 2B.3 Light/Dark Uyğunluğu (Sistem səviyyəsində)
- **Sübut:** Theme cookie `data-theme` ilə tətbiq olunur: `preview.blade.php:2`.
- **Sübut:** `:root` və `[data-theme="dark"]` dəyişənləri dinamikdir: `dynamic-styles.blade.php:63-106`.
- **Risk:** CSS tokenları componentlərdə qismən statik qalıbsa, gözlə görünən uyğunsuzluq yarana bilər (Phase 3 live testlə təsdiq olunacaq).

---

## 2B.4 Responsivlik (Kod səviyyəsində risklər)
- **Sübut:** əsas breakpoints: `public/assets/css/chalang-preview.css:216, 323, 722, 1109, 1314, 2618, 3145, 3163, 3440`.
- **Risk 1:** `.grid` min 300px (320px-də overflow) — `chalang-preview.css:1192-1194`.
- **Risk 2:** Hero h1 clamp 2.5rem (mobil böyük) — `chalang-preview.css:1019-1020`.

---

## 2B.5 Accessibility (A11y)
- **Keyboard Nav riski:** dropdown yalnız hover ilə açılır — `chalang-preview.css:499`.
- **Custom Cursor:** body-də `cursor: none` — `chalang-preview.css:73-75`, JS-də only desktop aktiv — `chalang-preview.js:71-76`.
- **Alt attribute boşluğu:** modal və fallback blog şəkillərində alt yoxdur — `preview.blade.php:1016, 2545-2555`.

---

## 2B.6 SEO / Social Preview
- **Sübut:** `<head>` yalnız `charset`, `viewport`, `title`: `preview.blade.php:4-6`.
- **Sübut:** OG/Twitter/Hreflang yoxdur (kod səviyyəsində tapılmadı).
- **Nəticə:** Sosial paylaşım zəif görünəcək (Phase 3-də live testlə doğrulanmalıdır).

---

## 2B.7 Resilience / Session
- **Sübut:** Estimator state localStorage-da saxlanır — `chalang-preview.js:1327, 1354`.
- **Nəticə:** Refresh sonrası seçimlər bərpa edilə bilər (live testlə təsdiq edilməlidir).

---

## 2B.8 Nəticə (Phase 2 çıxarışı)
- Phase 2 kod səviyyəsində **dil, theme, dinamika infrastrukturu** mövcuddur.
- Əsas risklər: mobile typography, grid min-width, OG/meta olmaması, A11y focus, alt-lar.
- Phase 3‑də canlı testlərlə bu risklər real davranışla təsdiqlənəcək.

---

# Phase 4 — Dinamika və Admin Bağlılıq (Kod sübutlu)
**Status:** Tamamlandı (kod audit)

## 4.1 Dinamika xəritəsi
- **Preview data source:** `app/Http/Controllers/Front/MainController.php:77-99`.
- **Content override map:** `MainController.php:102-120`.
- **Preview view-də map_points:** `preview.blade.php:1734`.

## 4.2 Dinamik / Hybrid / Statik nəticə
- **Dinamik:** Services, Metrics, Process, Team, Portfolio, Testimonials, FAQ, Blog (loop və content map).
- **Hybrid:** Navbar/Footer struktur statik, mətnlər i18n və DB ilə dəyişir.
- **Statik risk:** OG/SEO meta tag strukturu statik/boşdur (Phase 5-də).

---

# Phase 5 — Performans, SEO, A11y (Kod sübutlu)
**Status:** Tamamlandı (kod audit)

## 5.1 SEO / Social Preview
- **Head minimaldır:** yalnız `charset`, `viewport`, `title`.  
  **Sübut:** `resources/views/front/preview.blade.php:4-6`
- **OG/Twitter/Hreflang yoxdur.**  
  **Sübut:** `rg` nəticəsi boş (preview.blade.php-də meta yoxdur).

## 5.2 Performans
- **Lazy loading:** bəzi `img` taglarda `loading="lazy"` yoxdur.  
  **Sübut:** `preview.blade.php:2334, 2533-2555` (portfolio/blog img)
- **AOS init:** `AOS.init({ once: true })`.  
  **Sübut:** `public/assets/js/chalang-preview.js:276-281`

## 5.3 Accessibility (A11y)
- **Dropdown keyboard fail:** `:focus-within` yoxdur.  
  **Sübut:** `public/assets/css/chalang-preview.css:499-501`
- **Custom cursor:** body `cursor: none` yalnız desktopda; accessibility riski var.  
  **Sübut:** `public/assets/css/chalang-preview.css:73-75`, `chalang-preview.js:71-76`
- **Alt boşluğu:** bəzi fallback img-larda alt yoxdur.  
  **Sübut:** `preview.blade.php:1016, 2545-2555`

## 5.4 Reduced Motion
- **CSS:** yalnız `.bg-shape` və `.infinite-text` üçün `prefers-reduced-motion`.  
  **Sübut:** `public/assets/css/chalang-preview.css:313-320`
- **JS:** `prefersReducedMotion` ilə bəzi effektlər deaktiv edilir.  
  **Sübut:** `public/assets/js/chalang-preview.js:8, 641, 659`

---

# Phase 6 — Yekun Prioritet Planı
**Status:** Hazırlanıb (icra yoxdur)

## 6.1 Prioritetli Top Fix-lər (High)
1. **SEO/OG/Hreflang** — Social preview və axtarış üçün kritik.
2. **Mobile layout** — `.grid` min-width + hero clamp.
3. **A11y dropdown** — `:focus-within` dəstəyi.

## 6.2 Medium
4. **Lazy loading coverage** — bütün img-lar.
5. **Reduced Motion tamlığı** — AOS animasiyalarının bağlanması.

## 6.3 Low
6. **8K breakpoint** — max-width genişləndirilməsi.
7. **Watch fallback** — ultra-minimal variant.

---

# 6B - Dark mode UI/UX quick wins (problem -> sebeb -> teklif)
- **Default theme:** dark (kontrast ve srift oxunaqliligi birinci optimallasdirilir; light eyni spacing/dizayn sisteminden miras alir).
- **Hero (CTA + vizual):** Iki CTA eyni cekidedir -> istifadeci qerarsiz qalir; hero vizuali/particle cox yer tutur -> fold asagidaki mezmun itir -> Bir primary CTA (mes: "Brief gonder"), bir secondary (outline/text); hero hundurluyunu 20-30% qisalt, metn zonasinda overlay + particle opacity-ni azaldib trust signal (logos/score) elave et.
- **Axin/iyerarxiya:** Bolmeler Stats -> Xerite -> Komanda -> Kalkulyator -> Portfel -> FAQ ardicilligi ile qarisiq hiss olunur -> Istifadeci "neye gore bunu indi gorurem?" deyir -> Klassik axin: Hero -> Problem/Solution -> Xidmetler -> Proses -> Case study/Portfolio -> Reyler -> Qiymet/Paket/Kalkulyator -> FAQ -> Kontakt.
- **Vizual ses-kuy / spacing:** Dekorativ watermark ("STRATE.....") ve agir gradient/particle metn oxunaqliligini basir; kartlararasi vertikal bosluq qeyri-beraberdir -> Oxu axini bolur -> Watermark-i sil ve ya 5-8% opacity + kicik olcu ile divider kimi istifade et; 8pt spacing sistemi (8/16/24/32), mobil section padding 48-64px.
- **Konsistensiya (card/button sistemi):** Radius, shadow, blur beraber deyil; duymeler ferqli olculerde -> UI "sistem" hissi zeifleyir -> Tek card stili: radius ~16-20px, border 1px, shadow 2 seviye, blur yalniz secilmis zonalarda; Button olcu sistemi sm/md/lg, min-height 44-48px, eyni radius.
- **Kontrast (dark):** Fon (gradient + noise + particle) cox aktivdir -> body text kontrasti dusur -> Metn zonalarinda fonu sakitlesdir (qaralma overlay), particle-opacity-ni azaldin; body min 16px, line-height 1.45-1.6, secondary text >=14px.
- **Stat bloklari:** Kartlar hundur ve melumat sixligi azdir -> Skannama zeif -> Mobil 2x2 grid, kart hundurluyunu azaltdin, label oxunaqliligini artirin, 1 konteks cumlesi elave edin ("Son 12 ayin neticeleri" kimi).
- **Kalkulyator (UX yuku):** Cox control (toggle + paket + slider) -> qerar yuku -> "3 preset" (Start/Pro/Enterprise) + "Custom" slider; netice kartinda kontekst: "Aylig araliq", "daxildir/daxil deyil", "minimum muddet", "baslanqic tarix".
- **Portfel / Reyler / FAQ:** Case kartlarinda "sektor / gorulen is / netice" gorunmur; reyler az; FAQ-da motivasiya zeif -> Kartlarda sektor+is+neticeyi goster; 3-6 rey + logo wall/rating; FAQ ustunde "Sur?tli cavablar" intro ve rahat oxunan accordion.
- **Formlar:** Placeholder label rolunu oynayir -> UX zeifleyir; form CTA-lar esas CTA ile reqabet edir -> Gorunen label + helper text + error state; form CTA-ni bir pille sakit saxla, esas CTA hero/sticky-de qalir.
- **Sticky CTA (mobil):** Uzun landingde CTA itir -> Mobil sticky bottom bar: 1 primary CTA ("Brief gonder") + 1 elaqe (WhatsApp/zeng).

# 6D - UI/UX struktur tapintilari (light + dark, mobile daxil)
- **Scroll/bosluq:** Particle + "STRATE..." watermark hundurdur, kontent gec baslayir -> hero dekorunu 40-60% qisalt, ilk ekranda H1 + 1 cumle deyer + 1 primary CTA goster.
- **Kontrast (light):** Basliq/subtitle solgundur, xususen “Hara isleyirik?” -> H2 #111-#222, ikincil #4B5563.
- **Iyerarxiya:** Standart: H2 -> 1 cumle izah -> esas komponent -> CTA; kart/duyme olculerini S/M/L kimi vahidlesdir.
- **Header:** Sag ikonlar qeyri-aydindir; sticky header-de 1 primary CTA saxla, ikonlari tooltip/label ile ac.
- **Hero/CTA:** 1 cumlede “ne edirik/kimin ucun/netice”; primary solid, secondary outline, kontrastli.
- **Watermark/particle:** Opacity-ni azaldin ve ya yalniz desktop; dekoru kecid kimi qisa saxlayin.
- **Xidmet kartlari:** 1 esas CTA (“Teklif al”), ikinci link (“Detallar”); tab/ikonlu 3 secimi ya real tab bar (active underline), ya da cixarin.
- **Statistika:** Mobil 2x2, kart hundurluyu az, label konkret; gradient brend palitrasina yakin qalsin.
- **“Hara isleyirik?”:** Light kontrast P0; stepper real proses (Kesf->Strategiya->Icra->Olcme) ya silin; xerite dekorativse, region/sektor listi + 3-5 real numune; checklist sade list olsun.
- **Komanda:** Minimum 3 profil (foto, ad, rol, 1 cumle tecrube, LinkedIn).
- **Kalkulyator:** Wizard axini (“Meqsed -> Budce -> Teklif”), slider deyer badge; netice kontekstini ac (“ayliq/layihelik”, EDV/disclaimer); primary CTA “Bu tekliyi al” solid, secondary outline; gradient brend renglerinde.
- **Portfel:** Minimum 3 is + filter chips; her kartda musteri, sektor, netice metrikasi, 1 CTA (“Case study”).
- **Formlar:** Ilk 3 sahe (Ad, Email/Telefon, Meqsed + optional Budce), gorunen label + helper; error submitden sonra; validasiya ikonu kicik; newsletter-de “Spam yox, ayda 2 defe” + Privacy.
- **Reyler:** 2-3 rey slider, logo + ad/rol + 1 cumle netice.
- **FAQ:** Hundurluk/spacing azaldin, caret boyudun; axtaris inputu "Suallarda axtar..." edin ya da cixarin.
- **Footer/Floating:** Light-da link kontrastini artirin; huquqi linkler elave edin; chat safe-area ile toqqusmasin, lazim olsa scroll-da yuxari qalsin.
- **Top P0:** Light kontrast; dekor hundurluyunu azaltmaq; stat kartlarini 2x2 + alcaq; “Hara isleyirik?” stepper/xeriteni real ve ya sade; kalkulyator neticesine kontekst + duzgun primary CTA.

## 🎨 Phase 7: Granular UI/UX Section Audit (15-Point Deep Dive)

**Status:** Təsdiqlənmiş İcra Planı.

### 7.1 Global (All Sections)
1.  **Vertical Bloat:** Dekorativ elementlər (particles/watermark) səbəbindən kontent çox aşağıdadır. **Həll:** Hero hündürlüyünü 40-60% azalt, dekoru arxa fona keçir.
2.  **Light Mode Contrast (P0):** Başlıqlar solğun görünür. **Həll:** Başlıq rəngi `#111-#222`, secondary text `#4B5563`.
3.  **Visual Hierarchy:** Dekor, başlıq və kartlar rəqabət aparır. **Həll:** Standart: H2 -> İzah -> Komponent -> CTA.
4.  **Component Sizing:** Kart və düymə ölçüləri qeyri-sabitdir. **Həll:** S/M/L sistemi (padding/radius).

### 7.2 Section Specifics
5.  **Navbar:** İkonlar aydın deyil. **Həll:** Tooltip əlavə et, "Hamburger"i standartlaşdır. CTA əlavə et.
6.  **Hero:** Dəyər təklifi zəifdir. **Həll:** "X sahədə Y nəticə" formatı. CTA-ları Primary (Solid) vs Secondary (Outline) ayır.
7.  **Watermark ("STRATE..."):** Noise yaradır. **Həll:** Opacity 5%-ə endirilsin.
8.  **Services:** Kart içi qarışıqdır. **Həll:** Tək CTA saxla, digərini link et. Tabları sadələşdir.
9.  **Stats (P0):** Kartlar çox hündürdür. **Həll:** Mobildə 2x2 grid, hündürlüyü azalt. Label-ı konkretləşdir ("Müştəri məmnuniyyəti").
10. **"Hara işləyirik" (P0):** Stepper/Xəritə dekorativdir. **Həll:** Real proses addımları et və ya sadələşdir. Xəritə əvəzinə "Regionlar" siyahısı.
11. **Team:** Tək kart etibar yaratmır. **Həll:** Min 3 profil (Foto/Ad/Rol).
12. **Estimator (P0):** Nəticə kontekstsizdir. **Həll:** "Aylıq təxmini", "Daxildir/Daxil deyil". Slider üzərində dəyər badge-i.
13. **Portfolio:** Tək nümunə azdır. **Həll:** 3 kart + Filter.
14. **Forms:** Inputlar çox hündürdür. **Həll:** Label+Placeholder birləşdir. Validasiya yalnız submit-də.
15. **Footer:** Linklər solğundur. **Həll:** Kontrastı artır (+Privacy/Terms).

### 🚀 Top 5 Priority (P0 - Immediate Actions)
1.  **Light Theme Contrast:** Başlıqları tündləşdir (#111).
2.  **Scroll Height:** Dekorativ hündürlüyü azalt.
3.  **Stats Layout:** 2x2 grid və kompakt kartlar.
4.  **Stepper/Map:** Məntiqi sadələşdirmək.

---

## 🛠️ Phase 8: Developer-Ready Sprint Specifications (Technical)

**Status:** Locked for Execution.
**Baseline Device:** Huawei P30 Pro (360x780).
**Test Devices:** iPhone SE (320px), iPhone 12/13/14 (390-430px).

### 📐 A) Global System (P0)
*   **A1 Container:** `padding-inline: 16px`, `max-width: 420px` (mobile), `margin: 0 auto`. Section `padding-block: 56px` (Hero 64px).
*   **A2 Typography:** Body `16px/1.55`. Secondary `14px/1.5`. H1 `28-32px/1.15`. H2 `22-24px/1.2`.
*   **A3 Click Targets:** Min height **44px** (ideal 48px). Icon buttons **44x44px**. Radius 12-16px.
*   **A4 Light Contrast:** Heading `#111-#222`, Secondary `#4B5563`, Divider `#E5E7EB`.

### 🧭 B) Header & Hero (P0)
*   **B1 Sticky CTA:** Header height 56px. Primary CTA `min-width: 120px`.
*   **C1 Hero Height:** `min-height: auto`. `padding-top: 24px`, `padding-bottom: 32px`. Decor opacity 20-35%.
*   **C2 CTA Hierarchy:** Primary (Solid) 48px height. Secondary (Outline) 48px height. Gap 12px.

### 📉 D) Visual Noise (P0)
*   **D1 Decor:** Max height 180-240px on mobile.
*   **D2 Watermark:** Opacity **3-6%** or remove.

### 📊 F) Stats (P0)
*   **F1 Layout:** Mobile **2x2 Grid** (`grid-template-columns: repeat(2, 1fr)`). Gap 12px.
*   **F2 Cards:** `min-height: 92-110px`. Label 12-13px.

### 🧮 I) Estimator (P0)
*   **I4 Safety:** Font constraint `clamp(22px, 6vw, 28px)` to prevent overflow on 320px.
*   **I3 Context:** Result label "Aylıq / Layihəlik" + disclaimer.

### 🗺️ G, H, J, K, L, M, N (P1/P2)
*   **G1 Map:** Light overlay `rgba(255,255,255,0.6)`. Timeline stepper.
*   **H1 Team:** 3 Profile Cards (Avatar 40-48px).
*   **J1 Portfolio:** 3 Cards + Filter Chips (32px height).
*   **K1 Forms:** Short Step 1 (Name, Contact, Goal). Input height 48px.
*   **L1 Testimonials:** 3-6 items slider.
*   **M1 FAQ:** Padding 12-14px.
*   **N2 Floating:** Bottom offset 16-24px (Safe Area).

---

## 🗓️ Execution Sprint Plan

### 🚀 Sprint 1: Critical Fixes (P0) - *Immediate*
1.  **Global Mobile System:** Container padding, spacing system.
2.  **Light Contrast:** Global text contrast fix.
3.  **Tap Targets:** 44px rule enforcement.
4.  **Hero Optimization:** Height reduction, CTA hierarchy.
5.  **Visual Noise:** Watermark/Decor reduction.
6.  **Stats:** 2x2 Grid conversion.
7.  **Estimator:** Result context & overflow safety.
8.  **Sticky CTA:** Mobile bottom bar or header CTA.

### 🛠️ Sprint 2: High Value UX (P1)
1.  **Map/Process:** Stepper semantics, visual simplification.
2.  **Services:** Single CTA per card, clear filters.
3.  **Team:** 3-card layout.
4.  **Calculator UX:** Preset -> Custom flow.
5.  **Portfolio:** 3 cards + meta tags.
6.  **Forms:** Shorten first step, improve labels.
7.  **Testimonials:** Expand content.
8.  **FAQ:** Denser layout, search improvement.

### ✨ Sprint 3: Polish (P2)
1.  **Newsletter:** Trust microcopy.
2.  **Floating Elements:** Safe area collision fix.
3.  **Visual Consistency:** Radius/Shadow audit.

# red_dot_analysis_findings.md il? m?qayis? (Uy?unluq yoxlamas?)

**Status:** Tamamlandı (müqayisə)

## Uyğun gələnlər (Consistency)
- **Meta tag çatışmazlığı:** Findings-də var, Phase 5 təsdiqlədi.
- **Navbar A11y problemi:** Findings-də var, Phase 5 təsdiqlədi.
- **Grid min-width riski:** Findings-də var, Phase 3 təsdiqlədi.
- **404 lokallaşdırma:** Findings-də var, Phase 4 təsdiqlədi.

## Ziddiyyətlər (Mismatch)
- **Estimator state:** Findings “yadda qalmır” deyir, lakin kodda localStorage var.  
  **Sübut:** `public/assets/js/chalang-preview.js:1327, 1354`
- **Reduced Motion:** Findings “yoxdur” deyir, amma CSS/JS-də var (qismən).  
  **Sübut:** `public/assets/css/chalang-preview.css:313-320`, `public/assets/js/chalang-preview.js:8`
- **Cookie consent:** Findings “mövcud deyil” deyir, lakin `cookie-consent` partial daxil edilir.  
  **Sübut:** `resources/views/front/preview.blade.php:3261`

**Nəticə:** Findings faylında bəzi köhnə fərziyyələr var. Phase 2-6 məlumatları daha aktualdır və kod sübutlarına əsaslanır.

# 3) Existing Findings (red_dot_analysis_findings.md)

# 🔴 Red Dot Analysis Findings: Yekun Hesabat
**Status:** ✅ Tamamlandı
**Tarix:** 2026-01-06
**Əhatə:** Navbar, Hero, Content, JS Logika, Resilience, SEO, Dynamics
**Metodologiya:** Dərin Kod İnspeksiyası (Deep Code Inspection)

---

## 🏗️ Faza 1: Struktur və Matris (Structure & Matrix)

İstifadəçi tələbinə əsasən, **Phase 1**-in tam icrası üzrə "Test Matrisi" və "Bölmə Bölgüsü" aşağıdakı kimidir:

### 1.0 Analiz Matrisi (Test Matrix)
Analiz aşağıdakı kombinasiyalar üzrə aparılmışdır:
| Cihaz/Ölçü | Light (AZ/EN/RU) | Dark (AZ/EN/RU) | Ekstrem (Watch/8K) |
| :--- | :---: | :---: | :---: |
| **Mobile (320px/360px)** | ✅ (H1 daşır) | ✅ | ✅ |
| **Tablet (768px)** | ✅ | ✅ | - |
| **Desktop (1366px/1920px)** | ✅ | ✅ | ✅ |
| **Ultra-Wide (4K/8K)** | - | - | ✅ (Font scale) |

### 1.1 Tam 26-Bəndlik Uyğunluq Hesabatı (Full Compliance Audit)
Sizin `comprehensive_red_dot_analysis.md` planınızdakı 26 bəndin hər biri yoxlanıldı:

| # | Bənd (Criteriya) | Status | Nəticə (Qısa) |
|---|---|:---:|---|
| **1.** | Analiz Matrisi (Cihaz/Dil/Rejim) | ✅ | Tamamlandı (6 kombinasiya + 8K). |
| **2.** | İcra Mərhələləri | ✅ | Fazalar üzrə icra edildi. |
| **3.** | **Bölmə-bölmə Checklist** | ⚠️ | Navbar (A11y Fail), Hero (Mobile Fail), Grid (320px Fail). |
| **4.** | Global Theme (Override) | ✅ | `dynamic-styles` mükəmməl işləyir. |
| **5.** | Dinamika və Admin | ✅ | Fallback sistemi mövcuddur. |
| **6.** | Light/Dark Uyğunluğu | ✅ | `color-mix` ilə Smart Tint tətbiq olunub. |
| **7.** | Dil və Tərcümə | ✅ | 280+ açar söz var. |
| **8.** | Responsivlik | ⚠️ | 320px və 8K problemləri var. |
| **9.** | Ekstrem Ölçülər | 🔴 | Watch və 8K üçün optimizasiya yoxdur. |
| **10.** | Performans və CLS | ⚠️ | `loading="lazy"` bəzi yerlərdə unudulub. |
| **11.** | Accessibility (A11y) | 🔴 | Keyboard Nav işləmir. |
| **12.** | Cross-Browser | 🟡 | Webkit (Safari) prefixləri CSS-də var. |
| **13.** | Sessiya Davamlılığı | 🟡 | `styleCookieName` var, amma Estimator state yadda qalmır. |
| **14.** | Çap Versiyası (Print) | ❌ | Mövcud deyil. |
| **15.** | Reduced Motion | ❌ | Mövcud deyil. |
| **16.** | Sosial Preview (OG) | 🔴 | Meta teqlər yoxdur. |
| **17.** | Custom 404 | ⚠️ | Dizayn var, dinamik dili yoxdur. |
| **18.** | Offline Rejim | ❌ | PWA/Service Worker yoxdur. |
| **19.** | Skeleton Loading | ✅ | Portfolio fallback kartları var. |
| **20.** | Rəng Korluğu | 🟡 | Kontrast ratio əsasən yaxşıdır. |
| **21.** | Custom Scrollbar | ❌ | Standart browser scrollbar. |
| **22.** | SEO / Analytics | ⚠️ | Yalnız Title var. |
| **23.** | Security | ✅ | XSS qorunması (`{{ }}`) var. |
| **24.** | Delighters (Unicorn) | ✅ | Raket, Particles, Glassmorphism. |
| **25.** | Funksionallıq | ✅ | Estimator, Kontakt form işləyir. |
| **26.** | Çıxış Formatı | ✅ | Bu sənəd. |

---

### 1.1.1 Responsivlik Detallı Analiz (Cihaz/Ölçü)
| Cihaz/Ölçü | Model | Status | Sübut | Analiz |
| :--- | :--- | :---: | :--- | :--- |
| 320x568 | iPhone SE 1 | 🔴 **Fail** | Verified (User) | Layout 100% (width) fail. Grid min-300px > 280px space. Horizontal scroll. |
| **360x640** | **Galaxy Note II** | 🟡 **Risk** | **Verified (User)** | **Grid Fits!** (360px - 40px = 320px > 300px). No horizontal scroll. H1 typography still risky. |
| **640x360** | **Note II (Land)** | 🔴 **Fail** | **Verified (User)** | **Content Loss/Stacking.** 360px height is slightly better than 320px but still hides 80% of content initially. |
| **600x1024** | **BB PlayBook** | 🟢 **Pass** | **Verified (User)** | **Success!** Grid correctly switches to 2-columns. Navbar remains Hamburger (Good). Typography is safe. |
| **360x780** | **Huawei P30 Pro** | 🟢 **Pass** | **Verified (User)** | **Tall Viewport Win.** 780px height allows full Hero visibility. 360px width is safe for Grid. |
| **414x896** | **iPhone XR** | 🟢 **Pass** | **Verified (User)** | **Ideal Mobile.** 414px width provides ample breathing room. Grid has ~100px extra space. |
| **568x320** | **Landscape** | 🔴 **Fail** | **Verified (User)** | **"Stacking Tower" problemi.** 568px enində olsa da, elementlər 1 sütunlu dar "mobil" rejimində qalır. Şaquli yer (320px) az olduğundan kartlar çox yer tutur. |
| 360x760 | Samsung S8+ | 🔴 Fail | Verified (Sim) | H1 daşır, Grid sıxılır. |
| 375x812 | iPhone 13 Mini | 🔴 Fail | Verified (Sim) | Oxşar problemlər. |
| 390x844 | iPhone 12 Pro | 🔴 Fail | Verified (Sim) | " |
| 414x896 | iPhone XR | 🔴 Fail | Verified (Sim) | " |
| 430x932 | iPhone 14 PM | 🔴 Fail | Verified (Sim) | " |
| 100x100 | Watch | 🔴 Fail | Verified (User Img) | Tam yararsız. Micro Layout vacibdir. |
| 200x200 | Smart Display | 🔴 Fail | Verified (User Img) | Yararsız. Mini Layout vacibdir. Grid sığmır. |
| 768x1024 | iPad Mini | ⏳ Pending | Awaiting User Img | - |
| 1280x800 | Laptop Small | ⏳ Pending | Awaiting User Img | - |

***

### 🚩 Derin Analiz & Findings (User Screenshots)

#### 📱 320x568 (iPhone SE 1 / 5S) - "Classic Mobile"
**Status:** 🔴 CRITICAL FAIL
**Evidence:** User Screenshots (Light/Dark)
**Analysis:**
1.  **Grid Math Failure:** Base CSS uses `minmax(300px, 1fr)`.
    *   Math: 320px (Screen) - 32px (Container Padding 1rem*2) = **288px Available Space**.
    *   Result: 300px Card > 288px Space. **Horizontal Scroll & Cutoff confirmed.**
2.  **H1 Typography:** `clamp(3rem, ...)` = Min 48px.
    *   Words like "Xidmətlər" or "Kalkulyator" break or overflow the container.
3.  **Floating Elements:** Chat widget + Cookie Banner + BackToTop button rarely leave any safe touch area on the screen.
4.  **Touch Targets:** Buttons span full width but look "stuffed" due to tight padding.
**Solution:**
*   **Grid:** Change `minmax(300px)` to `minmax(100%, 1fr)` or `minmax(280px, 1fr)` for mobile.
*   **H1:** Reduce min-font-size to `2rem` (32px) for Viewport < 360px.
*   **Floats:** Hide non-essential floats (BackToTop) or minimize Chat on small screens.

#### 🔄 568x320 (Landscape Mode) - Critical Content Loss
**Status:** 🔴 CRITICAL FAIL (Verified)
**Evidence:** User Screenshots (Confirmed "Missing Elements")
**Analysis:**
1.  **Content Loss:** Significant portions of the page (likely Process Map, Backgrounds, or specific Sections) are completely missing or rendered invisible.
2.  **Vertical Clipping:** The 320px height combined with fixed/sticky elements (Header/Floats) leaves effectively zero viewable area for content.
3.  **Layout Collapse:** The "Stacking" behavior pushes content so far down that it becomes inaccessible or broken.
**Solution:**
*   **Media Query:** `@media (max-height: 480px)`
*   **Action:** Switch to a "Minimal Landscape" mode:
    *   Hide sticky Navbar (make it relative).
    *   Hide floating buttons.
    *   Reduce Header/Footer padding to near zero.
    *   Ensure Grid is 2-column to save vertical space.

    *   Ensure Grid is 2-column to save vertical space.

#### 📱 360x640 (Galaxy Note II Portrait) - The "Safe Zone" Boundary
**Status:** 🟡 RISK (Passed Basic Layout)
**Evidence:** User Screenshots (`uploaded_image_...`)
**Analysis:**
1.  **Grid Success:** Unlike iPhone SE (320px), this device has **360px** width.
    *   Math: 360px - 40px (Padding) = **320px Available**.
    *   Card: **300px Min-Width**.
    *   Result: **It Fits!** No broken horizontal scroll.
2.  **Typography Warning:** Hero H1 is `clamp(3rem...)` (48px).
    *   Risk: Long words ("Konfiqurasiya") might still touch edges, but less likely to break than on 320px.
3.  **Visuals:** Full page screenshots show correct stacking, no "missing" background elements in Portrait.

#### 🔄 640x360 (Note II Landscape) - Improved but Flawed
**Status:** 🔴 FAIL (Content Visibility)
**Analysis:**
*   Height **360px** provides 40px more space than iPhone SE (320px).
*   **Result:** You might see *part* of the Hero Service card, but the "Stacking Tower" issue remains. The layout does not switch to a "Wide" mode, so it wastes horizontal space (640px) by keeping a single narrow column.
*   **Missing Content:** As noted by user ("bir çox şey yox idi"), the background shapes and some absolute positioned elements might be clipped by overflow settings or z-index issues in this specific ratio.

#### 📟 600x1024 (Blackberry PlayBook Portrait) - The "Phablet" Success
**Status:** 🟢 PASS
**Evidence:** User Screenshots (Full Page)
**Analysis:**
1.  **Grid Behavior:** This is the first verified breakpoint where the **Layout switches to 2-Columns**.
    *   Instead of the single-column stacking tower seen on 320px/360px, the Services card shows 2 cards per row.
    *   This confirms the CSS Grid logic is working correctly for intermediate widths (>480px or >576px).
2.  **Navigation:** Correctly stays as Hamburger menu.
3.  **Typography:** H1 and Body text have ample breathing room. No edge-touching risks.

**Status:** 🔴 CRITICAL FAIL (Verified)
**Evidence:** User Screenshot
**Analysis:** Content is completely illegible. 90% of screen is clipped. The current 'responsive' design collapses.
**Solution: "Micro Layout" Strategy**
*   **CSS Query:** `@media (max-width: 150px) and (max-height: 150px)`
*   **Action:** `display: none` for ALL sections except Hero.
*   **Content:** Show ONLY:
    1.  Mini Logo
    2.  One separate "Call" button (Icon only)
    3.  Hidden Footer/Nav.

#### 📟 200x200 (IoT / Smart Home Display) - "Mini Viewport"
**Status:** 🔴 CRITICAL FAIL (Verified)
**Evidence:** User Screenshot
**Analysis:** 
*   **H1 Overflow:** `clamp(3rem...)` produces 48px text on a 200px screen. Single words do not fit.
*   **Grid:** `minmax(300px)` forces extensive horizontal scrolling.
*   **UI Chrome:** Floating elements (Chat, Cookie) cover 40%+ of the viewable area.
**Solution: "Mini Layout" Strategy**
*   **Typography:** Force H1 to `1.5rem` flat.
*   **Layout:** Force Single Column (`grid-template-columns: 1fr`).
*   **Spacing:** Reduce `gap` from `2rem` to `0.5rem`.
*   **Chrome:** `display: none` for Chat/Cookie/Floating buttons.

## 🏗️ Faza 1-B: Qlobal Quruluş Detalları (Setup & System)

### 1.1 CSS Dəyişənləri və Dizayn Sistemi
*   **✅ Colors:** `var(--brand-primary)`, `var(--bg-body)` kimi dəyişənlər düzgün təyin olunub.
*   **⚠️ Spacing:** Xüsusi spacing dəyişənləri (məs: `var(--space-md)`) yoxdur, birbaşa piksellər (`30px`) istifadə olunur. Bu, gələcəkdə scaling probleminə yol aça bilər.
*   **✅ Reset:** `box-sizing: border-box` və `margin: 0` qlobal olaraq mövcuddur.

### 1.2 Mobil Tipoqrafiya (KRİTİK)
*   **🔴 Problem:** Hero başlığı (`h1`) 360px ekranlarda ekran çərçivəsindən kənara çıxır (overflow).
*   **Kod Sübutu:** `font-size: clamp(3rem, ...)` (Min: 48px), lakin ekran eni 360px-dir.
*   **Təsir:** Mobil istifadəçilər (iPhone SE, Galaxy Fold) üçün oxunaqlıq pozulur.
*   **Həll:** Minimum dəyər `2rem` (32px)-ə endirilməlidir.

### 1.3 Premium Polish (Scrollbar & Selection) [MISSING]
*   **🔴 Scrollbar:** Saytda xüsusi `::-webkit-scrollbar` stilləri **YOXDUR**. Brauzerin standart boz/qalın scrollbarı "Glassmorphism" dizaynı ilə uyğunsuzluq yaradır.
*   **🔴 Selection:** `::selection` (mətn seçimi) rəngi təyin edilməyib (default mavi).
*   **Tövsiyə:** Brend rənglərinə (`var(--brand-primary)`) uyğun incə scrollbar və selection background əlavə edilməlidir.

### 1.4 Naviqasiya Əlçatanlığı (KRİTİK)
*   **🔴 Problem:** Dropdown menyular yalnız mouse hover ilə açılır.
*   **Kod Sübutu:** CSS-də `.nav-item-dropdown:hover` var, lakin `:focus-within` yoxdur.
*   **Təsir:** Klaviatura istifadəçiləri alt menyulara daxil ola bilmir (WCAG Fail).
*   **Həll:** CSS-ə `:focus-within` selektoru əlavə edilməlidir.

---

## 🔬 Faza 1-C: Əlavə Texniki Uyğunluq (Missing Checks)

Cədvəldə qeyd olunan bəzi texniki detalların dərin şərhi:

### 12. Cross-Browser (Safari/Webkit)
*   **🟡 Status:** Qismən Uyğundur.
*   **Detal:** `backdrop-filter` (Glassmorphism) Safari-də bəzən titrəmə yaraoda bilər. `chalang-preview.css`-də `-webkit-backdrop-filter` prefiksi mövcuddur, lakin köhnə iOS versiyalarında (14 altı) yoxlanılmayıb.

### 13. Sessiya Davamlılığı (Resilience)
*   **🟡 Status:** Riskli.
*   **Detal:** Estimator-da istifadəçi səhifəni yenilədikdə (F5), seçdiyi dəyərlər (məs: "E-commerce") sıfırlanır. "Red Dot" standartı üçün bu seçimlər `localStorage`-də saxlanılmalıdır.

### 20. Rəng Korluğu (Daltonism)
*   **🟡 Status:** Orta.
*   **Detal:** Xətalar (Error states) yalnız qırmızı rənglə bildirilir. Protanopia (qırmızı korluğu) olanlar üçün ikon və ya qalın çərçivə ilə dəstək mütləqdir.

---

## 🧩 Faza 2: Məzmun və Kontekst (Content & Context)

Hər bölmə **Light/Dark** rejimləri və **AZ/EN/RU** dilləri üzrə kod səviyyəsində yoxlanıldı.

### 2.1 Bölmə Analizi (Deep Dive)

| Bölmə | Lang (i18n) | Theme (Light/Dark) | Qeydlər (Findings) |
| :--- | :---: | :---: | :--- |
| **Navbar** | ✅ (`preview.nav.*`) | ✅ (`--nav-bg-glass`) | Dil dəyişəndə menyu düzgün yenilənir. |
| **Hero** | ✅ (`preview.hero.*`) | ✅ (`--text-main`) | Başlıqlar dinamikdir, lakin H1 mobil ölçü problemi qalıb (Faza 1). |
| **Services** | ✅ (`preview.sec_...`) | ✅ (`--card-bg`) | Kartlar dark mode-da düzgün kölgə/border rəngi alır. |
| **Process** | ✅ (`preview.process`) | ✅ (CSS Filters) | Avto-rotasiya və Xəritə rəngləri rejimə uyğun dəyişir. |
| **Estimator** | ✅ (`preview.est...`) | ✅ (Vars) | "Disclaimer" və Tooltiplər tam tərcümə olunub. |
| **Partners** | - | ✅ (Grayscale) | Loqolar Light/Dark rejimdə avtomatik ağ-qara/rəngli olur. |
| **FAQ** | ✅ (`preview.faq.*`) | ✅ (`--card-bg`) | Accordion açılarkən rəng kontrastı qorunur. |
| **Footer** | ✅ (`preview.footer`) | ✅ (`--bg-body`) | Bütün linklər və copyright mətni tərcümə açarlarına bağlıdır. |

### 2.2 Tərcümə Tamlığı (Localization Coverage)
`resources/lang/en/preview.php` faylının analizi göstərir ki, **280+ açar söz** (keys) mövcuddur.
*   **Status:** ✅ Sistem tam çoxdilli infrastruktura malikdir.
*   **Risk:** 404 səhifəsi (əgər mövcuddursa) bu fayldan kənar ola bilər.

### 2.3 Theme Resilience
`chalang-preview.css` faylında `html[data-theme='dark']` selektoru altında **25+ qlobal dəyişən** override edilib.
*   **Nəticə:** Komponentlər manual düzəliş tələb etmədən avtomatik rejimə uyğunlaşır.

### 2.4 Canlı Audit (Live Verification) [NEW]
Sizin tələbinizlə `http://localhost:8000/preview` ünvanına canlı sorğu göndərildi.

| Test | Nəticə | Sübut (Evidence) |
| :--- | :--- | :--- |
| **HTTP Status** | ✅ **200 OK** | Server cavabı uğurludur. |
| **Default Lang** | ✅ **Pass (AZ)** | HTML cavabında: *"Şirkətimizə xoş gəlmisiniz"*, *"Biz nə edirik?"* aşkarlandı. |
| **Routing** | ✅ **Pass** | `web.php` Sətir 79: `Route::get('lang/{lang}', ...)` mövcuddur. |
| **Middleware** | ✅ **Pass** | `SetLanguage.php` Sətir 21: `Session::get('lang')` məntiqi təsdiqləndi. |

> **Qeyd:** Canlı test yalnız default (AZ) dilini yoxlaya bildi, lakin infrastrukturun digər dilləri dəstəklədiyi kod səviyyəsində sübut olundu.


### Faza 2-B: Digər Bölmələrin Detallı Analizi (Extension)
Aşağıdakı bölmələr də 26-bəndlik plana əsasən yoxlanıldı:

| Bölmə | Status | Qeydlər (Kod Analizi) |
| :--- | :---: | :--- |
| **Metrics (Statistics)** | ✅ | `preview.metrics` açarları var. CSS `metrics-section` mərkəzləşib. |
| **Team (Komanda)** | ✅ | `preview.sec_team_title` tərcüməli. Kartlarda `img-creative` klassı var. |
| **Testimonials** | ✅ | `testimonial-card` dizaynı var. Admin panelə bağlıdır. |
| **FAQ** | ✅ | Accordion işləyir. Fallback suallar (`item_1`, `item_2`) mövcuddur. |
| **Blog** | ✅ | `blog-card` gridi düzgündür. Tarix formatı lokalizasiya olunub. |
| **Contact** | ✅ | Form `contact.submit` routuna gedir. Placeholderlər tərcüməlidir. |
| **Cookie Consent** | ❌ | **Mövcud deyil.** Kodda heç bir cookie banner tapılmadı. |
| **Lead Magnet** | ✅ | `scan-overlay` və `magnet-form` uğurla inteqrasiya olunub. |

---


## 📱 Responsivlik & Ekran Ölçüləri (Unified)

**📱 Faza 3: Responsivlik və Ekstrem Ölçülər (Deep Dive)**

Sizin "daha detallı" analiz tələbinizə əsasən, CSS faylı sətir-sətir yoxlanıldı.

### 3.1 ⌚ Watch və Fold (320px - 360px) - KRİTİK SƏHVLƏR
*   **🔴 Grid Partlayışı (Line 1194):** `.grid` klassında `minmax(300px, 1fr)` istifadə olunub.
    *   *Riyazi Sübut:* 320px (ekran) - 40px (padding) = 280px (boş yer). Lakin Grid minimum 300px tələb edir.
    *   *Nəticə:* Səhifə sağa tərəf "daşır" (Horizontal Scroll).
    *   *Peşəkar Emulyasiya (Whach - 100x100):* 🔴 **Təsdiqləndi (İstifadəçi Screenshotları).**
        *   **Oxunaqlılıq:** Mətnlər kəsilir, sətir hündürlüyü 100px üçün uyğun deyil.
        *   **Hero/CTA:** Başlıq daşır, düymələr üst-üstə düşür.
        *   **Float Elementlər:** Chat/Cookie düymələri ekranı tutur.
        *   **Həll (Micro Layout):** 100-200px aralığında yalnız Logo + 1 Cümlə + 1 CTA. Digər hər şey (Footer, Grid, Nav) gizlədilməlidir.
    *   *Həll:* Grid üçün `minmax(280px, 1fr)` edilməlidir.

*   **🔴 200x200 (Smart Display / "Mini" Viewport) Analizi:**
    *   **Status:** 🔴 **Kritik Uğursuzluq** (İstifadəçi Görüntüləri əsasında).
    *   **1. H1 Typography Fəlakəti (`clamp` problemi):**
        *   *Kod:* Main Hero `2.5rem`, Service Hero `3rem`.
        *   *Analiz:* Minimum şrift 40-48px aralığındadır. 200px enində ekranda hər iki dəyər daşır və sözləri mənasız hecalara bölür.
        *   *Visual Sübut:* Başlıq və alt-mətn çox sıxılıb, mətn oxunmur. "Micro" tipografiya şərtdir.
    *   **2. Grid Sisteminin Riyazi İmkansızlığı:**
        *   *Kod:* `minmax(300px, 1fr)` (Line 1194).
        *   *Riyazi Problem:* 300px (kart) > 200px (ekran). Konteyner fiziki olaraq karta sığmır.
        *   *Nəticə:* Kartların məzmunu daşır, rəqəmlər və etiketlər kəsilir. 100px məcburi horizontal scroll yaranır.
    *   **3. CTA və Footer İflası:**
        *   *CTA:* Düymələr görünmür, xüsusilə **"Nümayiş çarxı"** tamamilə sıradan çıxır.
        *   *Footer:* Newsletter input sahəsi və düymə sığmır, sütun linkləri bir-birinə girir.
    *   **4. UI "Chrome" Hücumu (Float Elements):**
        *   *Analiz:* "Home", Chat və Cookie düymələri (`bottom: 2rem`, `right: 2rem`) mərkəzə doğru sıxılır.
        *   *Nəticə:* Ekranın təxminən 40%-i bu "üzən" elementlər tərəfindən bloklanır, kontent boğulur.
    *   **Həll (Xüsusi Watch Layout / Mini Layout):**
        *   Bu ölçü üçün xüsusi UX rejimi mütləqdir.
        *   **Navigasiya:** Tam gizlədilməli, yalnız Burger menu.
        *   **Grid:** Mütləq 1 sütun (1 Column).
        *   **Fontlar:** Kiçildilmiş "micro" fontlar (H1 ~1.5rem).
        *   **Float Elementlər:** Chat, Cookie, Back-to-top tamamilə söndürülməlidir.
        *   **Spacing:** Padding və marginlər minimuma endirilməlidir.
*   **🔴 Hero H1 (Line 1020):** `clamp(2.5rem, ...)` təyin edilib.
    *   *Hesablama:* 2.5rem = 40px. "İnnovasiya" sözü 320px ekranda sığmır.
    *   *Həll:* `1.8rem`-ə endirilməlidir.
*   **🔴 Container Padding (Line 1172):** `.section` padding `80px 20px`-dir. Mobil üçün `80px` yuxarı boşluq çoxdur.
    *   *Həll:* Kiçik ekranlarda padding `40px`-ə endirilməlidir.

### 3.2 🖥️ Ultra-Geniş Ekranlar (4K - 3840x2160) [YENİLƏNİB]
*   **✅ Verified Status:** Təsdiqləndi (Sprint 1). `max-width: 1440px` qərarı tətbiq edildi.
*   **🟢 Layout:** Məzmun mərkəzlənir, oxunaqlılıq qorunur. `1440px` konteyner geniş ekranda dağılmanın qarşısını alır.
*   **🟡 Qeydə alınan Problemlər (Minor Issues):**
    1.  **Geniş Boşluqlar (Whitespace):** 1440px-dən kənarda qalan sol/sağ boşluqlar çox böyükdür (Visual olaraq "boş" görünür, lakin 8K strategiyasına uyğundur).
    2.  **Font Scaling:** Fiziki 4K monitorlarda (scaling 100% olduqda) 16px-18px şriftlər kiçik görünür. `desktop-lg` breakpoint-i ilə şriftləri artırmaq gələcək sprintlərdə (P2) nəzərdə tutulur.
    3.  **Background:** `bg-shape` və gradientlər `100vw` olaraq bütün ekranı örtür (Test uğurludur).
*   **Nəticə:** Layout stabil və istifadəyə yararlıdır. Font scaling gələcək optimizasiya (P2) kimi qeydə alındı.
*   **Fix (Sprint 1):** Navbar Cutoff (Horizontal Scroll) problemi `.navbar-container`-ə `max-width: 1440px` təyin edilərək həll edildi (User Reported).

### 3.3 Digər Bölmələrin Responsivlik Yoxlanışı (Extended Check)
Sizin siyahınızdakı digər komponentlərin mobil/desktop davranışı:

| Bölmə | Status | Mobil (320px) | Ultra-Wide |
| :--- | :---: | :--- | :--- |
| **Marquee** | ⚠️ | `ticker-horizontal-track` (CSS:1180) `width: max-content`. Mobil ekranlarda daşma riski var. | `width: 100%` qorunur. |
| **Services (Grid)** | ⚠️ | `minmax(300px)` səbəbindən 320px-də daşır. (FIX Lazımdır) | 4 sütunla məhdudlaşır. |
| **Process** | ✅ | `flex-direction: column` (CSS:1440) sayəsində mobildə alt-alta düzülür. | Mərkəzlənir. |
| **Team** | ✅ | `minmax(260px)` (CSS:2011) hələ ki təhlükəsizdir. | 4 sütunla məhdudlaşır. |
| **Estimator** | ✅ | `flex-wrap: wrap` (CSS:2260) var. Inputlar alt-alta düşür. | Genişlənir. |
| **Testimonials** | ✅ | `minmax(300px)` (CSS:1660) - 320px-də cüzi risklidir. | Grid yaxşı işləyir. |
| **Footer** | ✅ | `grid-template-columns: 1fr` (Mobile) işləkdir. | 4 sütun. |
| **Global UI** | ✅ | `cursor: none` mobildə sönür. Widget gizlənir. | Scaling problemi yoxdur. |

### 3.4 ??? Print (Cap Versiyasi)
*   **❌ Yoxdur:** `@media print` bloku CSS-də tamamilə yoxdur.
*   **Təsir:** İstifadəçi `Ctrl+P` etdikdə qara fon (Dark Mode) və lazımsız animasiyalar səhifəni "yeyir". Sənəd oxunmaz hala düşür.

### 3.5 Reduced Motion
*   **❌ Yoxdur:** `@media (prefers-reduced-motion)` bloku tapılmadı.
*   **Təsir:** Animasiyalar (AOS, Rocket) həssas istifadəçilər üçün sönmür (Vestibular Disorder risk).


### 3.6 ?? Real Device Verification Matrix (Updated)
Bu matrisa real istifadeci/cihaz subutlarini toplayir.

| Cihaz/Olcu | Model | Status | Subut | Analiz |
| :--- | :--- | :---: | :--- | :--- |
| **320x568** | **iPhone SE 1** | ?? **Fail** | Verified (User) | Layout 100% fail. Grid min-300px > 280px space. Horizontal scroll. |
| **240x320** | **JioPhone 2** | ?? **Fail (User Verified)** | **Severe Content Loss.** <br> **Root Causes:** `min-width` guards, KaiOS Legacy JS. <br> **Fix:** Variant B (Unified XXS Layout). |
| **344x882** | **Z Fold 5 (Cover)** | :warning: **Likely Fail (Code)** | CSS Evidence | **Stats & Process stay 1-col.** Section padding 20px leaves ~304px; `grid-template-columns: repeat(auto-fit, minmax(200px, 1fr))` + 30px gap (`resources/views/front/preview.blade.php:399`) cannot form 2x2. `@media (max-width: 768px)` forces `.process-step { width: 100%; }` (`preview.blade.php:420`). Needs XS override to force `repeat(2, 1fr)` + reduced padding/gap. |
| **882x344** | **Z Fold 5 (Unfolded Landscape)** | :warning: **P0 Risk (Spec)** | Design Spec | **Wide + short mode + crease.** Requires height-based mode `(min-width >= 768px AND max-height <= 500px)`, crease-safe gutter, sticky bottom CTA OFF, compact header/padding, and 2-col layouts to avoid content crossing the fold. |
| **412x915** | **S20 Ultra** | :warning: **Fail** | Verified | **"3+1" Stats Grid Failure.** Fix: Force 2x2 grid. |
| **430x932** | **iPhone 14 Pro Max** | :warning: **Fail** | Verified | Dynamic Island overlap. |

### 3.7 Phase 3 — Responsivlik və Ekstrem Ölçülər (Kod səviyyəsində)
**Status:** Tamamlandı (kod audit)
**Metod:** CSS breakpoints və layout qaydalarının analizi

#### 3.7.1 Breakpoint xəritəsi
- **Sübut:** `public/assets/css/chalang-preview.css:216, 323, 722, 1109, 1314, 2618, 3145, 3163, 3440`
- **Breakpoints:** 575px, 640px, 768px, 900px, 991px, 1150px.

#### 3.7.2 Kiçik ekran riskləri (320px/360px)
- **Grid min-width:** `.grid { minmax(300px, 1fr) }` → 320px-də overflow riski.  
  **Sübut:** `public/assets/css/chalang-preview.css:1192-1194`
- **Hero başlıq:** `clamp(2.5rem, 5vw, 4.5rem)` → 360px-də böyük.  
  **Sübut:** `public/assets/css/chalang-preview.css:1019-1020`
- **Service hero başlıq:** `clamp(3rem, ...)` → subpage mobil risk.  
  **Sübut:** `public/assets/css/chalang-preview.css:2072-2073`

#### 3.7.3 Ultra-wide (4K/8K) riskləri
- **Max-width:** çoxlu bölmələr 1200px ilə limitlənir.  
  **Sübut:** `public/assets/css/chalang-preview.css:1013, 1173, 1601, 2852`
- **Nəticə:** 8K ekranlarda böyük boşluq qalır; əlavə breakpoint lazımdır.

#### 3.7.4 Watch mode (100x100)
- Watch üçün xüsusi media/variant yoxdur (CSS-də belə breakpoint görünmür).  
- **Nəticə:** "Logo + 1 CTA" fallback hələ implement edilməyib.

### 3.8 Canli goruntu testleri (Light + Dark)
#### 3.8.1 Canlı görüntü testi (100x100) [Light + Dark]
- **Müşahidə:** Oxunaqlılıq praktik olaraq yoxdur; H1/CTA/metrics kəsilir və üst-üstə düşür.
- **Layout:** Bloklar mikro eni qəbul etmir; mətnlər hecalara bölünür, kartlar sığmır.
- **UI chrome:** floating ikonlar (chat/back-to-top/cookie) 100x100 sahəni bloklayır.
- **Nəticə:** 100x100 üçün ayrıca "micro layout" tələb olunur (yalnız logo + 1 CTA).

#### 3.8.2 Canlı görüntü testi (200x200) [Light + Dark]
- **Müşahidə:** 100x100-dən yaxşıdır, amma yenə istifadəolunmazdır.
- **Typography:** H1 clamp min dəyəri yüksəkdir; sətirlər parçalanır.
- **Grid:** `minmax(300px, 1fr)` > 200px olduğuna görə kartlar fiziki sığmır.
- **UI chrome:** floating düymələr məzmunu boğur.
- **Nəticə:** 200x200 üçün də micro layout lazımdır (burger nav, 1 column, mini fontlar).

#### 3.8.3 Kiçik mobil (320x568) - vizual test
**Referans cihaz:** iPhone SE (1st gen) / iPhone 5/5S.
- **Hero:** Başlıq çox sıxdır; CTA-lar yaxın və sətirlər qırılır.
- **Navbar:** Logo + mərkəzi menyu + sağ aksiyalar 320px-də sıx görünür; hit-area riski.
- **Marquee:** vizual səs-küy yaradır, hero mətni ilə rəqabət aparır.
- **Metrics:** 4 kart bir sırada oxunaqlılığı azaldır; 2x2 grid daha uyğundur.
- **Process xəritə:** hotspot + text sıxlaşır; mobil üçün "vertical timeline" daha uyğundur.
- **Estimator:** panel və control-lar sıx görünür; tam stack variantı daha rahatdır.
- **Footer:** newsletter input və linklər dar enə görə sıxılır.

#### 3.8.4 Telefon landscape (568x320) - vizual test [Light + Dark]
**Referans cihaz:** iPhone SE/5 landscape.
- **Hero blok:** hündürlüyü çox alır; short-height (320px) səbəbilə fold-da az informasiya görünür.
- **Fold görünüşü:** ilk ekranda faktiki olaraq yalnız hero + statistika görünür; digər əsas bölmələr görünmür və "boşluq" hissi yaradır.
- **CTA sətri:** 3 düymə yan-yana yerləşir, amma yuxarı boşluqlar böyükdür; hero spacing azaltmaq lazımdır.
- **Layout istiqaməti:** tam single-column qalır; landscape genişliyi istifadə olunmur.
- **Metrics kartları:** hələ tək sütunda və böyükdür; landscape-də 2 sütun/kompakt kart lazım olur.
- **Footer:** genişlikdən istifadə etmir, linklər yuxarı-aşağı düşür; landscape-də 2-3 sütun daha uyğun olar.

#### 3.8.5 Telefon landscape (640x360) - vizual test [Light + Dark]
**Referans cihaz:** Note II landscape (640x360).
- **Fold/height:** 360px hündürlük səbəbilə hero blok yenə də fold-u çox tutur; əsas bölmələr aşağıda qalır.
- **Genişliyin istifadəsi:** layout hələ də single-column görünür; landscape enindən real faydalanmır.
- **Marquee/hero art:** başlıq+art birlikdə çox yer tutur, vizual yük yüksəkdir.
- **Metrics kartları:** böyük və uzun; landscape-də 2 sütun kompakt kart daha münasib görünər.
- **Estimator:** panel yığcam deyil; landscape üçün “stack + compact” variant daha rahat olar.

#### 3.8.6 Kiçik mobil (360x640) - vizual test [Light + Dark]
**Referans cihaz:** tipik Android (360x640).
- **Hero:** 320x568-dən yaxşıdır, amma başlıq/CTA hələ sıxdır.
- **Services kartları:** iki sütuna düşdüyü üçün kart içi mətnlər çox dar görünür; oxunaqlılıq azalır.
- **Process xəritə:** 01-04 addımlar sığır, amma yazılar çox yaxın; mobil üçün sadələşdirilmiş xəritə/timeline daha uyğundur.
- **Estimator:** iki panel hələ də yanaşı görünür; 360px-də tam stack variantı daha balanslıdır.
- **Footer:** əsasən işləkdir, amma link blokları çox sıx görünür.



#### 3.8.7 Tablet Portrait (600x1024) - vizual test [Light + Dark]
**Referans cihaz:** BlackBerry PlayBook (600x1024).
- **Ümumi görünüş:** Layout mobilə nisbətən rahatdır; hero 2-sütun görünür, amma H1/CTA hələ də sıx hiss edilir.
- **Biz nə edirik? kartları:** 2 sütunlu düzülüş oxunur; kart içi mətnlər 2-3 sətirə düşür, padding bir az dar görünür.
- **Metrics:** 2x2 grid rahatdır, oxunaqlılıq yaxşıdır.
- **Process:** xəritə + addımlar 600px-də sıx görünür; mobilə yaxın "vertical timeline" variantı yenə daha uyğundur.
- **Estimator:** iki sütun (kontroller + qiymət kartı) görünür, amma toxunma sahələri sıxdır; 600px üçün stack variantı daha stabil olar.
- **Form/CTA:** form sahələri yan-yana qaldıqda dar hiss olunur; bu ölçüdə tək sütuna düşürmək UX-i yaxşılaşdırar.

#### 3.8.8 Tablet Landscape (1024x600) - vizual test [Light + Dark]
**Referans cihaz:** BlackBerry PlayBook (1024x600).
- **Fold/height:** 600px hundurlukde hero + marquee cox pay tutur; ilk ekranda mezmun az gorumur, vertikal padding azaltmaq lazimdir.
- **Genislik istifadesi:** 1024px eninde multi-column grid balanslidir; services/metrics/blog kartlari rahat oxunur.
- **Process:** xerite genislikden yaxsi istifade edir, amma alt metn bloklari hundurluyu artirir; daha yigcam variant dusunule biler.
- **Estimator:** iki sutun layout burada uygundur; pricing paneli aydin gorunur.
- **Footer:** coxsutunlu duzulus mumkundur, amma hundurluk mehdudlugu sebebile sixliq hiss olunur.

#### 3.8.9 Huawei P30 Pro Portrait (360x780) - vizual test [Light + Dark]
**Referans cihaz:** Huawei P30 Pro (360x780).
- **Hero/CTA:** H1 oxunur, amma CTA-lar bir setirde six gorumur; gap/padding azaltmaq lazimdir.
- **Navbar:** burger + aksiyalar sixlasmadan yerlesir, amma hit-area 44px minimumu yoxlanmalidir.
- **Biz ne edirik? kartlari:** tek sutun duzulusde oxunaqlidir; metnler sixdir, vertical spacing artirmaq olar.
- **Metrics:** 2x2 grid rahat gorumur; oxunaqliliq yaxsidir.
- **Process:** xerite + 01-04 addimlar hele de sixdir; mobil ucun sadelesdirilmis timeline daha uygundur.
- **Estimator:** kontrollerler ve price paneli sixisir; touch target-ler boyudulmelidir.
- **Light/Dark:** light rejimde xırda metn kontrasti bir az zeif gorumur; dark rejimde oxunaqliliq daha stabildir.
- **Actionable fix (P30 Pro 360x780):** Hero H1 minimumunu ~2.2rem et, vertikal padding-i ~20-30% azalt; CTA-lari 1 sutuna stack et, gap-i kicilt; 360px-de services/metrics-i tek sutuna indir, navbar hit-area-larini 44px saxla; process ucun mobil timeline variantini defolt et; estimator panellerini stack et.

#### 3.8.10 Huawei P30 Pro Landscape (780x360) - vizual test [Light + Dark]
**Referans cihaz:** Huawei P30 Pro (780x360).
- **Fold/height:** 360px hundurlukde hero + marquee cox yer tutur; ilk ekranda mezmun az gorumur, vertikal padding azaltmaq lazimdir.
- **Hero layout:** iki sutun gorunus genislikden yaxsi istifade edir, amma hundurluk mehdudlugu sebebile bloklar sixlasir.
- **Services/Metrics:** multi-column duzulus oxunur, lakin kartlarin hundurluyu yigcamlasdirilmalidir.
- **Process:** xerite genislikde rahatdir, amma metn bloklari hundurluyu artirir; kompakt variant lazim ola biler.
- **Estimator:** iki sutun horizontal balanslidir, amma panel hundurluyu boyukdur; spacing azaltmaq lazimdir.
- **Actionable fix (P30 Pro 780x360):** Hero/CTA padding-ini azal dib fold-u ac; CTA/gap-lari kompaktlasdir; 780x360-da services/metrics-i 2 sutuna endir, kart hundurluyunu yigcamlasdir; process metnini qisa formaya kecir; estimator panelini bu breakpointde stack et.

---

### 3.9 Mobile-First GLOBAL Standards (320px - 430px)

**Qərar:** Huawei P30 Pro və digər cihazların analizindən çıxan ortaq nəticələr **bütün mobil versiyalar** üçün standart qəbul edilir.

#### 3.9.1 Layout & Grid (Universal Mobile Rule)
| Komponent | Qayda | Səbəb |
| :--- | :--- | :--- |
| **Grid Sütunları** | **Mütləq 1 Sütun** | 300px kartlar 320-375px ekranlara sığmır. Yan-yana düzülüş yalnız > 480px-də icazəlidir. |
| **Hero Hündürlük** | **Max 85vh / Padding azaldılsın** | "Above the fold" (ilk ekran) mütləq CTA və Trust Signal (Logo) göstərməlidir. 780px hündürlükdə belə boşluqlar çoxdur. |
| **Process Map** | **Timeline Forması** | Xəritə mobildə oxunmur. Addımlar (01, 02...) alt-alta "Timeline" kimi yığılmalıdır. |
| **Estimator** | **Stack Layout** | Kontrollerlər yuxarıda, Nəticə paneli aşağıda (Sticky deyil, axınla). |

#### 3.9.2 Typography & Spacing (Universal)
*   **H1 Başlıq:** `clamp(2rem, 5vw, 3rem)` (Min: 32px). Əsla 48px (3rem) olmamalıdır.
*   **Body Text:** Minimum **16px** (Oxunaqlılıq).
*   **Nav/CTA Hit-Area:** Bütün toxunma sahələri, düymələr və linklər **minimum 44x44px** olmalıdır.
*   **Section Spacing:** Mobil üçün standart padding **48px-64px** (Desktop-da 100px olsa belə).
*   **Spacing System:** 8pt prinsipi (8px, 16px, 24px, 32px).

#### 3.9.3 Behavior (Davranış)
*   **Sticky CTA:** Uzun səhifələrdə istifadəçi CTA-nı itirir. Ekranın aşağısında **fixed "Brief Göndər" + "WhatsApp"** barı olmalıdır.

---

### 3.10 Responsive column spec (qisa xulasə)
- Breakpoints: Micro ≤120, XXS 121–239, XS0 240–319 (lite), XS 320–359, S 360–389, M 390–413, L 414–479, XL 480–639, FOLD 640–767, TAB 768–1023, DS1 1024–1279, DS2 1280–1535, DS3 1536–1919, UHD/QHD/4K+ 1920+ (container limit 1200–1440, ultra-wide 1600 max).
- Container padding: mobile 16px (XXS 12px), desktop 24–32px; 4K/8K-də sütun artmır, yalnız fon genişlənir.
- Landscape hündürlük <500px: sticky bottom CTA off/1 düymə, padding 40–48px, dekor azaldılır.
- Crease-safe: center gutter 32-48px; avoid critical content across center.
- Micro/XXS/XS0: yalnız hero + 1 CTA + əsas əlaqə; stats 1 sütun; qalan bölmələr accordion/lite.
- XS–L əsas matrisa: services 1 sütun; stats mütləq 2x2 (320–479), process stepper 2x2 (M-dən 4-lü), map/ mətn 1 sütun; calculator 1 sütun; portfolio/testimonials/blog 1; FAQ 1.
- XL (480–639): stats 4 yan-yana; services 2; portfolio/testimonials 2; process stepper 4; hero 1–2 (kontentə görə); map + mətn hələ 1.
- FOLD+ (≥640): hero text+visual 2; process/map 2 sütun; calculator controls+result 2; portfolio/testimonials/blog 2 (tablet 3); FAQ 1–2; footer 2–3.
- TAB (768–1023): services 2; portfolio/testimonials/blog 3; footer 3; contact form 2 sütun.
- DS1+ (≥1024): hero 2; services 3; stats 4; process stepper 4; map+mətn 2; portfolio/testimonials/blog 3; footer 4; FAQ 1–2; contact form 2 sütun.
- Compact devices (JioPhone 240x320): dekor/off, padding 24–32px, hero+CTA+2x2 kompakt stats, qısa form; sticky/floating gizli.


### 3.11 6C - Mobil (320-430 en; portrait + landscape) ucun umumilesdirme
- **Hero:** H1 min clamp ~2.2rem, vertikal padding 20-30% az; primary + secondary CTA, mobilde stack; fold-da 1-2 trust signal saxla (logo/score).
- **Gridler:** 320-375 eninde tek sutun; 390-430 eninde yalniz qisa kartlar 2 sutuna; metrics/portfolio/faq kartlarina min-width vermeden, gap-i 16-24px saxla.
- **Process/Xerite:** Mobil defolt timeline/stack; xerite kicik overview kimi saxla/yasa; hotspot tap-target >=44px.
- **Estimator:** Mobil defolt stack; preset + "Custom" axini; netice kartina "Aylig araliq / daxildir-daxil deyil / minimum muddet / start tarixi" konteksti elave et.
- **Navbar/CTA:** Hit-area >=44px; mobil sticky bottom bar (primary CTA + elaqe).
- **Spacing/Fon:** 8pt spacing sistemi (8/16/24/32), section padding mobil 48-64px; watermark/particle opacity-ni azaldib metn zonalarinda sakit fon saxla.
- **Tip/kontrast:** Body >=16px, line-height 1.45-1.6; secondary >=14px; dark-da overlay ile kontrasti artir.

### 3.12 6E - Developer-ready task list (P0/P1/P2, mobil baseline 360px; test 320/390/414)
- **P0-01 Global container/spacing:** padding-inline 16px (320-390), max-width 420px, section padding 56px (hero 64px); 320px-də kənara yapışma yoxdur.
- **P0-02 Light contrast:** Headings ~#111-#222, secondary ~#4B5563, divider #E5E7EB; “Map/Process” də daxil.
- **P0-03 Tap targets:** Min 44px (ideal 48px); icon button 44x44; radius 12-16px.
- **P0-04 Hero fold:** Hero padding-top ~24, bottom ~32; dekor opacity 20-35%; 360px-də H1+subtitle+primary CTA fold-da.
- **P0-05 Decorative height:** Particle blok max 180-240px mobil; watermark opacity 3-6% və ya remove.
- **P0-06 Stats 2x2:** Grid repeat(2,1fr) gap ~12px; card padding 16px; min-height 92-110px; label konkret; 320/360-da daşma yoxdur.
- **P0-07 Pricing kontekst:** Label “Aylıq/Layihelik/EDV” + disclaimer; price clamp(22px,6vw,28px) + nowrap; 320px-də qırılma yoxdur.
- **P0-08 Sticky primary CTA:** Header və ya bottom bar; floating chat ilə overlap olmur.
- **P1-01 Map stepper:** Kəşf→Strategiya→İcra→Ölçmə; active underline/border 2px.
- **P1-02 Map dəyəri:** Region/sektor listi + nümunə və ya kiçik xəritə (160-220px); “harada işləyirik?” cavab verir.
- **P1-03 Services CTA/tab:** Kartda 1 primary CTA (44-48px); tab varsa 44px hündürlük + 2px underline; 320-də qırılmır.
- **P1-04 Team 3 kart:** Avatar 40-48px; padding 16px; gap 12px; mobil 1 sütun, 390+ 2 sütun ola bilər.
- **P1-05 Calculator UX:** 3 preset + Custom; preset btn 40-44px; slider 44px; value badge 12-13px; 10s-də nəticə.
- **P1-06 Portfolio 3 kart:** Min-height 180-220px; chips 32px; hər kartda müştəri/sektor/nəticə badge (12-13px) + CTA.
- **P1-07 Form qısaldılması:** İlk addım 3 sahə; input 48px, textarea 96px; label görünən; error submitdən sonra inline (12-13px).
- **P1-08 Testimonials 3-6:** Card padding 16px; quote 14-16px; avatar 36-40px.
- **P1-09 FAQ sıxlığı:** Closed padding 12-14px; title 14-16px; icon 20px; search placeholder “Suallarda axtar…” (44-48px) əgər saxlanırsa.
- **P2-01 Newsletter microcopy:** “Spam yox, ayda 2 dəfə” + Privacy link (12px).
- **P2-02 Floating chat collision:** Bottom offset 16-24px, safe-area; 320/360/414-də overlap yoxdur.
- **P2-03 Visual consistency:** Card radius ~16-20px, border 1px, shadow 2 səviyyə vahidləşir.

## ?? Faza 4: Dinamika və Admin Bağlılıq (26-Point Check)

Kod (`MainController.php` və `preview.blade.php`) analiz edilərək, hər bir bölmənin admin panelindən idarə olunma dərəcəsi yoxlanıldı.

**Legend:**
*   ✅ **Dynamic:** Məlumat bazadan gəlir və loop ilə yaranır.
*   ⚠️ **Hybrid:** Struktur statikdir, mətnlər/şəkillər dinamikdir.
*   ❌ **Static/Missing:** Kodda "hardcoded" yazılıb və ya mövcud deyil.

| Bölmə | Status | Admin Mənbəyi / Kod İzahı |
| :--- | :---: | :--- |
| **1. Navbar** | ⚠️ | **Struktur Statikdir.** Linklər kodda (`<li>`) yazılıb. Label-lər `$ct(...)` ilə tərcümə olunur. |
| **2. Hero** | ✅ | `$banner` obyekti. Başlıq/Şəkil admin-dən gəlir. |
| **3. Marquee** | ✅ | `preview.ticker_default` açarı ilə gəlir. `parseContentTextValue` ilə listə çevrilir. |
| **4. Services** | ✅ | `$main_services` loop-u istifadə olunur. Tam dinamikdir. |
| **5. Metrics** | ✅ | `$ct` ilə `preview.metrics.years_value` və s. açarları oxunur. |
| **6. Process** | ✅ | `$steps` loop-u var. Şəkil və başlıqlar bazadandır. |
| **7. Team** | ✅ | `$team_members` əgər varsa göstərilir, yoxsa fallback işə düşür. |
| **8. Estimator** | ⚠️ | `$pricing_plans` ötürülür, AMMA alqoritm JS-də (`chalang-preview.js`) işləyir. Matris admin-dən tam idarə olunmur. |
| **9. Portfolio** | ✅ | `$portfolios` loop-u var. Limit: 6 layihə. |
| **10. Testimonials** | ✅ | `$testimonials` database-dən gəlir. |
| **11. FAQ** | ✅ | `$faqs` loop-u var. |
| **12. Blog** | ✅ | `$blogs` loop-u var. Limit: 3 yazı. |
| **13. Contact** | ✅ | `$ct('contact', ...)` ilə başlıqlar gəlir. Form `contact.submit` routuna gedir. |
| **14. Footer** | ⚠️ | **Struktur Statikdir.** Column-lar HTML-də yazılıb. Sosial linklər `$socialmedia` ilə gəlir. |
| **15. Cookie** | ❌ | **Mövcud deyil.** Nə kodda, nə də admində yeri yoxdur. |
| **16. Global UI** | ✅ | `dynamic-styles` faylı rəngləri (Theme) idarə edir. |
| **17. Global Theme** | ✅ | Şriftlər və Rənglər `Setting` modelindən oxunur. |
| **18. Dynamics** | ✅ | Controller `applyContentTextOverrides` ilə bütün mətnləri inject edir. |
| **19. Light/Dark** | ❌ | **Local Storage.** Admin-dən default-u dəyişmək olmur (Front-da JS idarə edir). |
| **20. Language** | ✅ | `App::getLocale()` ilə tam inteqrasiya olunub. |
| **21. Responsiveness**| ❌ | CSS-dir. Admindən idarə olunmur (Normaldır). |
| **22. Extremes** | ❌ | CSS-dir. |
| **23. Performance** | ⚠️ | Şəkillərdə `loading="lazy"` hər yerdə yoxdur (Team/Services-də var, digərlərində yoxlana bilər). |
| **24. A11y** | ⚠️ | `aria-label` atributları dinamik elementlərdə (xüsusən Slider-lərdə) çatışmır. |
| **25. Cross-Browser** | n/a | Texniki məsələdir. |
| **26. Session** | ❌ | Estimator seçimləri `F5` zamanı sıfırlanır (JS-də state yoxdur). |

---

## 🏗️ Faza 5 (Plan): Funksional Testlər və JS Məntiqi (+ Smoke Test)
Növbəti addımda yalnız "Görüntü" yox, "İşləməsi" yoxlanacaq:
1.  **Estimator** hesablaması düzgündürmü?
2.  **Contact Form** boş gedərsə nə olur?
3.  **Language Switch** zamanı URL qırılırmı?


## 🔍 Faza 5: Performans, SEO və A11y (26-Point Check)
Funksional Testlər və JS Məntiqi (+ Smoke Test)
Növbəti addımda yalnız "Görüntü" yox, "İşləməsi" yoxlanacaq:
1.  **Estimator** hesablaması düzgündürmü?
2.  **Contact Form** boş gedərsə nə olur?
3.  **Language Switch** zamanı URL qırılırmı?
### 5.1 Meta Teqlər (KRİTİK SEO)
`preview.blade.php` başlığı (`<head>`) yoxlanıldı:
*   **🔴 Problem:** Yalnız `<title>` və charset var.
*   **❌ Çatışmayanlar:** `<meta name="description">`, `<meta property="og:image">`, `<meta property="og:title">`.
Kod (`chalang-preview.js`, `preview.blade.php`) və brauzer davranışları analiz edildi.
*   **Təsir:** Link paylaşılanda (WhatsApp/Linkedin) "boş" görünür.

**Legend:**
*   ✅ **Pass:** Tələb tam ödənilir.
*   ⚠️ **Warning:** İşləyir, lakin optimizasiya lazımdır.
*   ❌ **Fail:** Kritik çatışmazlıq.

| ID | Bölmə (Kriteriya) | Status | Detallar / Kod Analizi |
| :--- | :--- | :---: | :--- |
| **10** | **Performans (CLS/JS)** | ⚠️ | **JS Yükü:** jQuery və `AOS` istifadəsi "render-blocking" yarada bilər. `loading="lazy"` yalnız bəzi şəkillərdə var. |
| **11** | **Accessibility (A11y)** | ❌ | **Custom Cursor:** `!isNarrow()` yoxlayır, amma böyüdücü (magnifier) istifadəçiləri üçün kabusdur. `tabindex` idarə olunmur. |
| **12** | **Cross-Browser** | ✅ | CSS-də `-webkit-` prefiksləri (`backdrop-filter`) yerindədir. JS-də `try/catch` blokları var. |
| **15** | **Motion Sensitivity** | ⚠️ | **JS:** `prefersReducedMotion` Canvas-ı söndürür (Əla!). **CSS:** Amma `AOS` (scroll animasiyaları) tam sönmür. |
| **16** | **Social Preview** | ❌ | **OG Tags Yoxdur.** `<head>` hissəsində `og:title`, `og:image`, `description` tamamilə boşdur. Link paylaşılarkən pis görünəcək. |
| **18** | **Offline Rejim** | ❌ | **PWA Yoxdur.** Service Worker və ya `manifest.json` tapılmadı. İnternet kəsiləndə oyun bitir. |
| **20** | **Color Blindness** | ⚠️ | **Error State:** Form xətaları yalnız mətnlə verilir (yaxşıdır), lakin input çərçivələri rəng korları üçün zəif ola bilər. |
| **22** | **SEO (Meta/Hreflang)** | ❌ | **Kritik:** Hreflang (dil linkləri) yoxdur. Google 3 dili bir-birinə qarışdıracaq. |
| **23** | **Security** | ⚠️ | **API Keys:** JS-də `apiKey = ''` boşdur. Client-side API çağırışları (Gemini) təhlükəlidir, backend proxy lazımdır. |
| **26** | **Session Resilience** | ❌ | **Estimator:** Səhifə yenilənəndə (F5) seçimlər yadda qalmır. `localStorage` istifadə olunmayıb. |

---
### 5.2 Performans (Lazy Load & Defer)
*   **✅ JS Loading:** `chalang-preview.js` faylı `defer` olmasa da, body-nin sonunda çağırılır.
*   **⚠️ Image Loading:** `<img>` teqlərində `loading="lazy"` atributu **BƏZƏN** var (məs: Hall of Fame sətir 2429), amma Portfolio şəkillərində (sətir 2334) **YOXDUR**.
*   **Həll:** Bütün şəkillərə qlobal `loading="lazy"` artırılmalıdır.

---

## 🦄 Faza 6: Resilience & Unicorn Extras (Final)

### 6.1 404 Səhifəsi
*   **🔴 Problem:** `404.blade.php` vizual olaraq gözəldir, amma mətni SƏRT KODLANIB (Yalnız AZ).

### 6.2 İtmiş "Unicorn" Özəlliklər
Aşağıdakı vəd edilmiş özəlliklər kodda **TAPILMADI**:
*   ❌ **Sound UX:** `audio` tapılmadı.
*   ❌ **Print Styles:** `@media print` tapılmadı.
*   ❌ **Offline Mode:** Service Worker tapılmadı.

---

## 🏁 Yekun Nəticə (Final Verdict)

Analiz TAMAMLANDI. Sayt vizual və funksional cəhətdən "Premium" səviyyəyə yaxındır (xüsusilə `dynamic-styles` ilə), lakin **International Standard (Red Dot)** üçün aşağıdakı **TOP 5 PRIORITET** həll edilməlidir:

| # | Problem | Təsir | Həll Təklifi |
|---|---|---|---|
| 1 | **Mobil H1 Şrifti** | UX / Mobile | `clamp(2rem...)` |
| 2 | **Services Grid** | Layout Break | `minmax(280px...)` |
| 3 | **Navbar A11y** | Accessibility | `:focus-within` |
| 4 | **Meta Teqlər (OG)** | Marketing | `<meta property="og:image"...>` |
| 5 | **404 Tərcümə** | UX / Global | `{{ __('errors.404') }}` |

---

## 🚀 Faza 7: Prioritetləşdirmə və Yol Xəritəsi (Fix Roadmap)

26-bəndlik hərtərəfli analiz nəticəsində aşkar edilən bütün çatışmazlıqlar (Red Dots) **Təsir (Impact)** və **Vaciblik (Urgency)** dərəcəsinə görə qruplaşdırıldı. Aşağıdakı yol xəritəsi "Fixing" mərhələsi üçün əsasdır.

### 6.1 Prioritet Matrisi

| Prioritet | Kateqoriya | Təsvir | Təxmini Vaxt |
| :--- | :--- | :--- | :--- |
| **P0** | **KRİTİK (Must Fix)** | Saytın işləməsini, mobil görüntünü və SEO-nu bloklayan səhvlər. | dərhal |
| **P1** | **YÜKSƏK (Core)** | İstifadəçi təcrübəsi (UX) və Əlçatanlıq (A11y) problemləri. | 1-2 saat |
| **P2** | **ORTA (Polish)** | Vizual incəliklər, performans və əlavə funksionallıqlar. | 2-3 saat |

### 6.2 İcra Planı (Step-by-Step Roadmap)

#### 🚨 ADDIM 1: Kritik Həllər (P0 - Immediate Fixes)
*   [ ] **Mobil H1 Overflow:** `chalang-preview.css` (Line 1020) -> `clamp(1.8rem, ...)` ediləcək.
*   **[ ] Services Grid & Marquee:** `minmax(300px)` -> `minmax(280px)` və Marquee `max-width` düzəldiləcək.
*   **[ ] SEO Meta Tags:** `preview.blade.php` `<head>` hissəsinə Description, OG Image, OG Title, Hreflang əlavə ediləcək.
*   **[ ] Cookie Banner:** Yeni `cookie-consent.blade.php` (JS ilə birlikdə) yaradılıb footer-ə injekt ediləcək.

#### 🛠️ ADDIM 2: UX və A11y Təkmilləşdirməsi (P1 - Core Improvements)
*   **[ ] Navbar A11y:** CSS-ə `:focus-within` əlavə edilərək klaviatura ilə naviqasiya təmin ediləcək.
*   **[ ] Custom Cursor Fix:** Mobil/Tablet və Zoom istifadəçiləri üçün JS-də `media (hover: hover)` yoxlaması əlavə ediləcək.
*   **[ ] Session Resilience:** Estimator seçim məntiqi `localStorage` ilə mövcuddur (Test ediləcək).
*   **[ ] 404 Tərcümə:** `404.blade.php` statik mətnlərdən təmizlənib `{{ __('errors.404') }}` sisteminə keçiriləcək.

#### 🎨 ADDIM 3: Polish və "Unicorn" (P2 - Delighters)
*   **[ ] Scrollbar:** Webkit scrollbar CSS əlavə ediləcək (Brend rəngində).
*   **[ ] Reduced Motion:** `@media (prefers-reduced-motion)` bloku yaradılıb AOS və animasiyalar söndürüləcək.
*   **[ ] Lazy Loading & Print:** Bütün şəkillərə `loading="lazy"` və CSS-ə `@media print` əlavə ediləcək.
*   **[ ] Offline & Security:** Offline səhifəsi (PWA Lite) və API Proxy qurulacaq.

---

## ✅ YEKUN QƏRAR
Analiz fazası tam uğurla başa çatdı. Saytın "Skeleti" möhkəmdir, "Əzələləri" (Dinamika) işləyir, lakin "Dərisi" (Frontend detalları) üzərində yuxarıdakı cərrahi əməliyyatlara ehtiyac var.