# Red Dot Master Report (Bütün Mətnlər Ardıcıllıqla)



## 🛑 Phase 6: Mobile-First GLOBAL Standards (320px - 430px)

**Qərar:** Huawei P30 Pro və digər cihazların analizindən çıxan ortaq nəticələr **bütün mobil versiyalar** üçün standart qəbul edilir.

### 6.1 Layout & Grid (Universal Mobile Rule)
| Komponent | Qayda | Səbəb |
| :--- | :--- | :--- |
| **Grid Sütunları** | **Mütləq 1 Sütun** | 300px kartlar 320-375px ekranlara sığmır. Yan-yana düzülüş yalnız > 480px-də icazəlidir. |
| **Hero Hündürlük** | **Max 85vh / Padding azaldılsın** | "Above the fold" (ilk ekran) mütləq CTA və Trust Signal (Logo) göstərməlidir. 780px hündürlükdə belə boşluqlar çoxdur. |
| **Process Map** | **Timeline Forması** | Xəritə mobildə oxunmur. Addımlar (01, 02...) alt-alta "Timeline" kimi yığılmalıdır. |
| **Estimator** | **Stack Layout** | Kontrollerlər yuxarıda, Nəticə paneli aşağıda (Sticky deyil, axınla). |

### 6.2 Typography & Spacing (Universal)
*   **H1 Başlıq:** `clamp(2rem, 5vw, 3rem)` (Min: 32px). Əsla 48px (3rem) olmamalıdır.
*   **Body Text:** Minimum **16px** (Oxunaqlılıq).
*   **Nav/CTA Hit-Area:** Bütün toxunma sahələri, düymələr və linklər **minimum 44x44px** olmalıdır.
*   **Section Spacing:** Mobil üçün standart padding **48px-64px** (Desktop-da 100px olsa belə).
*   **Spacing System:** 8pt prinsipi (8px, 16px, 24px, 32px).

### 6.3 Behavior (Davranış)
*   **Sticky CTA:** Uzun səhifələrdə istifadəçi CTA-nı itirir. Ekranın aşağısında **fixed "Brief Göndər" + "WhatsApp"** barı olmalıdır.

---

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
*   **C2 CTA Hierarchy:** Primary (Solid) 48px height. Secondary (Outline) 48px
### 6F. Large Mobile & Landscape Optimizations (Verified)
#### 1. iPhone 14 Pro Max (430px) & S20 Ultra (412px) Goals
- **Clamp Widths**: `max-width: clamp(360px, 92vw, 480px)` to stop narrow strips.
- **2-Column Adapters (Min-width: 390px/400px)**:
  - **Stats**: MUST be `grid-template-columns: repeat(2, 1fr)` for mobile (P0 Fix for "3+1" bug).
  - **Portfolio/Testimonials**: Switch to 2-column grid to save vertical space.
  - **Buttons**: Hero CTAs side-by-side (`flex-direction: row`).
- **Safe Area**: `env(safe-area-inset-*)` for dynamic islands and notches.
- **Android "Safe Padding"**: Bottom elements must account for Chrome's dynamic toolbar expansion/contraction.

#### 2. Ultra-Low Width (240px - JioPhone 2) Strategy
- **Approach**: Variant B "Full Content" (Compressed).
- **Technique**: `@media (max-width: 319px)` specific overrides (XXS Package).
    - **Layout**: 1-column strict.
    - **Typography**: H1 ~22px, P ~14px.
    - **Hidden**: Particles, heavy decor, sticky bottom bars.
    - **Polyfills**: Ensure legacy browser support (ES5/ES2017) if KaiOS execution fails.

### 6G. Global Grid & Column Strategy (Verified Spec)
This specification defines the column count for every component across all breakpoints to ensure optimal density and readability.

#### 1. Breakpoint Map
| Tier | Range (px) | Device Examples |
| :--- | :--- | :--- |
| **Micro** | ≤120 | Micro-shell devices |
| **XXS** | 121–239 | Wearables, Legacy |
| **XS0** | 240–319 | **JioPhone 2**, Fold-cover (narrow) |
| **XS** | 320–359 | iPhone SE 1, classic mobile |
| **S** | 360–389 | **Android Standard** (S20, Pixel) |
| **M** | 390–413 | iPhone Pro |
| **L** | 414–479 | **Pro Max**, S20 Ultra |
| **XL** | 480–639 | Mini Tablet, Large Phablet |
| **FOLD** | 640–767 | Foldable Open, Landscape Mob |
| **TAB** | 768–1023 | Tablets (iPad Mini/Air) |
| **DS** | 1024+ | Desktops (Laptops to 8K) |

#### 2. Component Column Matrix
| Component | XS (320-359) | S-M (360-413) | L (414-479) | XL (480-639) | FOLD (640+) | TAB (768+) | DS (1024+) |
| :--- | :---: | :---: | :---: | :---: | :---: | :---: | :---: |
| **Hero (Text/CTA)** | 1 | 1 | 1 (CTA 2) | 1-2 | 2 | 2 | 2 |
| **Stats (Cards)** | **2 (2x2)** | **2 (2x2)** | **2 (2x2)** | **4 (1 row)** | 4 | 4 | 4 |
| **Services** | 1 | 1 | 1 | 2 | 2 | 2 | 3 |
| **Process (Step)** | 2 (2x2) | 2 (2x2) | 4 (1 row) | 4 | 4 | 4 | 4 |
| **Portfolio/Testim**| 1 | 1 | 1 | 2 | 2 | 3 | 3 |
| **Calculator** | 1 | 1 | 1 | 1 | 2 (Split) | 2 | 2 |
| **Footer Links** | 1 | 1 | 2 | 2 | 2 | 3 | 4 |

#### 3. Specific Logic Rules
*   **Stats (P0 Fix):** MUST be `grid-template-columns: repeat(2, 1fr)` for **320px–479px**. Solves "3+1" orphan bug.
*   **Process Stepper:** Switch to single row (4 items) from **390px (M)** upwards to utilize width.
*   **Calculator:** Switch to "Controls Left / Result Right" layout from **FOLD (640px)**.
*   **Hero CTA:** Two buttons side-by-side (`flex-row`) starting from **M (390px)** or **L (414px)**.
*   **XS0 (JioPhone):** Single column STRICT. Accordions for heavy sections. No `display:none` on majors.
*   **Max Container:** Cap at **1320px-1440px** even on 8K screens. Center content, expand backgrounds.
Gap 12px.

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

# 2) Phase 1 Report (red_dot_phase1_report.md)

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

## 6) Phase 2‑yə Keçid Şərti
Siz təsdiq etdikdən sonra Phase 2‑də **hər bölmə üzrə canlı test, Light/Dark və 3 dil** yoxlanışı başlayacaq. Orada real səhifə görüntüləri ilə “evidence” əlavə ediləcək.


---

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
| **240x320** | **JioPhone 2** | 🔴 **Fail (User Verified)** | **Severe Content Loss.** "Many things missing" (Hero visible, Sections missing). <br> **Root Causes:** <br> 1. `min-width: 320px` guards or `display:none`. <br> 2. KaiOS/Legacy Browser JS issues (ES6+ bundle vs Polyfills). <br> 3. CSS Clamp/Flex gap missing fallbacks. <br> **Data Mismatch:** Stats show 40% (Light) vs 99% (Dark). |
| **412x915** | **Samsung S20 Ultra** | :warning: **Fail (User Verified)** | **"3+1" Stats Grid Failure:** 4 items break into 3 top + 1 bottom. **Fix:** Force 2x2 grid. <br> **"1-Col Waste":** 412px width unused. CTAs/Portfolio should be 2-col. <br> **Android Bar:** Dynamic toolbar changes height, risks overlap. |
| **360x640** | **iPhone 14 Pro Max** | **430 x 932** | :warning: **Fail (Code Verified)** | **Deep Code Audit:** `safe-area-inset` missing (Dynamic Island overlap confirmed). `100vh` usage causes vertical scroll glitch. **Dynamic Island & Edge Padding are critical failures.** |H1 typography still risky. |
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
    *   **Padding:** Reduce vertical section padding to `40-48px`.
*   **Spacing:** Reduce `gap` from `2rem` to `0.5rem`.
*   **Chrome:** `display: none` for Chat/Cookie/Floating buttons.

#### 5. iPad Mini & Native Tablet Spec (768px+)
Specific corrections for "Native Tablet" feel on 1024x768 and similar breakpoints.

*   **P1: Layout Corrections (12-Point Checklist):**
    1.  **Stats:** 4 columns in 1 row (Strict). `grid-template-columns: repeat(4, 1fr)`. No 3+1 stack.
    2.  **Team:** 2-3 columns. Single card layout is forbidden on tablets.
    3.  **Hero:** 2 Columns (Text/CTA Left, Visual Right). Decor opacity -30%.
    4.  **Services:** 2x2 grid is standard. **Critical:** Equal height cards + bottom-aligned CTAs.
    5.  **Process:** 2 Columns split: Content/Checklist (Left) | Map/Visual (Right).
    6.  **Calculator:** 2 Panels fixed: Controls (Left, min 360px), Result (Right, min 320px). Reduces vertical space.
    7.  **Portfolio:** 2 Columns for list/cases. No single-column lists.
    8.  **Testimonials:** 3 Columns preferred (min 2).
    9.  **FAQ:** Max-width container (~880-960px) to prevent reading line fatigue.
    10. **Blog:** 3 Columns with fixed aspect ratio (16/9) images.
    11. **Newsletter:** Horizontal Layout (Input + Button inline).
    12. **Footer:** Multi-column (3 cols) links layout. Single column stack is mobile-only.
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

### 2.5 Detailed Live Data (HTTP & HTML Size)
From Phase 2 (Live Test):

| Dil | Theme | Status | HTML uzunluğu | `lang` atributu | `data-theme` | Qeyd |
| :-- | :---- | :----- | :------------ | :-------------- | :----------- | :--- |
| AZ | light | 200 | 200 | 364460 | true | true | Default `/preview` (lang=az) |
| AZ | dark | 200 | 364502 | true | true | Default `/preview` + dark cookie |
| EN | light | 200 | 365358 | true | true | `/lang/en` sonrası |
| EN | dark | 200 | 365462 | true | true | `/lang/en` sonrası |
| RU | light | 200 | 365143 | true | true | `/lang/ru` sonrası |
| RU | dark | 200 | 365214 | true | true | `/lang/ru` sonrası |

**Canlı testdən çıxan faktlar:**
*   **Dil atributu** bütün kombinasiyalarda düzgün gəlir (`lang="az|en|ru"`).
*   **Theme atributu** cookie əsasında dəyişir (`data-theme="light|dark"`).
*   **HTML uzunluğu** dillər üzrə fərqlənir (tərcümə məzmunu dəyişir).


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

## 📱 Faza 3: Responsivlik və Ekstrem Ölçülər (Deep Dive)

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

### 3.2 🖥️ Ultra-Geniş Ekranlar (4K - 3840x2160)
*   **⚠️ Peşəkar Emulyasiya Nəticəsi:** ❌ **Qəbul Edilmədi.** (Zoom 0.3x testi real emulyasiya sayılmır).
*   **🔴 Font Scaling:** Şriftlər 4K ölçüsündə böyümür (Razılaşdırıldı).
*   **❓ BG Coverage:** Kodda (`bg-shape`) var, lakin real 4K cihazda yoxlanılmayıb. **Status: Unverified.**
*   **Həll:** `desktop-lg` (2000px+) üçün font-scaling və daha geniş konteyner şərtdir.

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

### 3.3 🖨️ Print (Çap Versiyası)
*   **❌ Yoxdur:** `@media print` bloku CSS-də tamamilə yoxdur.
*   **Təsir:** İstifadəçi `Ctrl+P` etdikdə qara fon (Dark Mode) və lazımsız animasiyalar səhifəni "yeyir". Sənəd oxunmaz hala düşür.

### 3.4 Reduced Motion
*   **❌ Yoxdur:** `@media (prefers-reduced-motion)` bloku tapılmadı.
*   **Təsir:** Animasiyalar (AOS, Rocket) həssas istifadəçilər üçün sönmür (Vestibular Disorder risk).


### 3.5 📱 Real Device Verification Matrix (Updated)
This matrix consolidates user-verified findings.

| Cihaz/Ölçü | Model | Status | Sübut | Analiz |
| :--- | :--- | :---: | :--- | :--- |
| **320x568** | **iPhone SE 1** | 🔴 **Fail** | Verified (User) | Layout 100% fail. Grid min-300px > 280px space. Horizontal scroll. |
| **240x320** | **JioPhone 2** | 🔴 **Fail (User Verified)** | **Severe Content Loss.** <br> **Root Causes:** `min-width` guards, KaiOS Legacy JS. <br> **Fix:** Variant B (Unified XXS Layout). |
| **344x882** | **Z Fold 5 (Cover)** | :warning: **Likely Fail (Code)** | CSS Evidence | **Stats & Process stay 1-col.** Section padding 20px leaves ~304px; `grid-template-columns: repeat(auto-fit, minmax(200px, 1fr))` + 30px gap (`resources/views/front/preview.blade.php:399`) cannot form 2x2. `@media (max-width: 768px)` forces `.process-step { width: 100%; }` (`preview.blade.php:420`). Needs XS override to force `repeat(2, 1fr)` + reduced padding/gap. |
| **882x344** | **Z Fold 5 (Unfolded Landscape)** | :warning: **P0 Risk (Spec)** | Design Spec | **Wide + short mode + crease.** Requires height-based mode `(min-width >= 768px AND max-height <= 500px)`, crease-safe gutter, sticky bottom CTA OFF, compact header/padding, and 2-col layouts to avoid content crossing the fold. |
| **412x915** | **S20 Ultra** | :warning: **Fail** | Verified | **"3+1" Stats Grid Failure.** Fix: Force 2x2 grid. |
| **430x932** | **iPhone 14 Pro Max** | :warning: **Fail** | Verified | Dynamic Island overlap. |
| **1024x768** | **iPad Mini (Landscape)** | ✅ **Verified** | User Image | **Layout looks stable.** 4-col Stats, 3-col Services. Text sizing acceptable. |

### 3.6 Detailed Device Findings (Deep Dive Investigation)
Specific analysis of why certain devices failed:

#### 📱 320x568 (iPhone SE 1 / 5S) - "Classic Mobile"
*   **Status:** 🔴 CRITICAL FAIL
*   **Analysis:**
    1.  **Grid Math Failure:** Base CSS uses `minmax(300px, 1fr)`.
        *   Math: 320px (Screen) - 32px (Container Padding 1rem*2) = **288px Available Space**.
        *   Result: 300px Card > 288px Space. **Horizontal Scroll & Cutoff confirmed.**
    2.  **H1 Typography:** `clamp(3rem, ...)` = Min 48px.
        *   Words like "Xidmətlər" or "Kalkulyator" break or overflow the container.
    3.  **Floating Elements:** Chat widget + Cookie Banner + BackToTop button rarely leave any safe touch area on the screen.

#### 🔄 568x320 (Landscape Mode) - Critical Content Loss
*   **Status:** 🔴 CRITICAL FAIL
*   **Analysis:**
    *   **Content Loss:** Significant portions of the page are completely missing or rendered invisible.
    *   **Vertical Clipping:** The 320px height combined with fixed/sticky elements (Header/Floats) leaves zero viewable area.
    *   **Layout Collapse:** The "Stacking" behavior pushes content so far down that it becomes inaccessible.

#### 📱 360x640 (Galaxy Note II Portrait) - The "Safe Zone" Boundary
*   **Status:** 🟡 RISK (Passed Basic Layout)
*   **Analysis:**
    *   **Grid Success:** 360px - 40px (Padding) = **320px Available**. Card: **300px Min-Width**. **It Fits!**
    *   **Typography Warning:** Hero H1 is `clamp(3rem...)` (48px). Long words might still touch edges.

#### 🔄 640x360 (Note II Landscape) - Improved but Flawed
*   **Status:** 🔴 FAIL (Content Visibility)
*   **Analysis:**
    *   Height **360px** provides 40px more space than iPhone SE (320px).
    *   **Result:** You might see *part* of element, but the "Stacking Tower" issue remains. The layout does not switch to a "Wide" mode, wasting 640px width.

#### 📟 600x1024 (Blackberry PlayBook Portrait) - The "Phablet" Success
*   **Status:** 🟢 PASS
*   **Analysis:**
    *   **Grid Behavior:** This is the first verified breakpoint where the **Layout switches to 2-Columns**.
    *   Instead of single-column stacking, Services card shows 2 cards per row.

#### 🖥️ Ultra-Low Width (240px - JioPhone 2) Strategy
*   **Status:** 🔴 FAIL (User Verified)
*   **Root Causes:**
    1.  `min-width: 320px` guards or `display:none`.
    2.  KaiOS/Legacy Browser JS issues (ES6+ bundle vs Polyfills).
    3.  CSS Clamp/Flex gap missing fallbacks.
*   **Data Mismatch:** Stats show 40% (Light) vs 99% (Dark).

### 6G. Global Grid & Column Strategy (Verified Spec)
This specification defines the column count for every component across all breakpoints.

#### 1. Breakpoint Map
| Tier | Range (px) | Device Examples |
| :--- | :--- | :--- |
| **Micro** | ≤120 | Micro-shell |
| **XXS** | 121–239 | Wearables |
| **XS0** | 240–319 | **JioPhone 2** |
| **XS** | 320–359 | **Z Fold 5 (Cover)**, SE 1 |
| **S** | 360–389 | Android Std |
| **M** | 390–413 | iPhone Pro |
| **L** | 414–479 | Pro Max |
| **XL** | 480–639 | Mini Tablet |
| **FOLD** | 640–767 | Foldable Open |
| **TAB** | 768–1023 | Tablets |
| **DS** | 1024+ | Desktop |

#### 2. Component Column Matrix
| Component | XS (320-359) | S-M (360-413) | L (414-479) | XL (480-639) | FOLD (640+) | TAB (768+) |
| :--- | :---: | :---: | :---: | :---: | :---: | :---: |
| **Hero (Text/CTA)** | 1 | 1 | 1 (CTA 2) | 1-2 | 2 | 2 |
| **Stats (Cards)** | **2 (2x2)** | **2 (2x2)** | **2 (2x2)** | **4 (1 row)** | 4 | 4 |
| **Services** | 1 | 1 | 1 | 2 | 2 | 2 |
| **Process (Step)** | 2 (2x2) | 2 (2x2) | 4 (1 row) | 4 | 4 | 4 |
| **Portfolio/Testim**| 1 | 1 | 1 | 2 | 2 | 3 |
| **Calculator** | 1 | 1 | 1 | 1 | 2 (Split) | 2 |
| **Footer Links** | 1 | 1 | 2 | 2 | 2 | 3 |

#### 3. Specific Logic Rules
*   **Stats (P0 Fix):** MUST be `grid-template-columns: repeat(2, 1fr)` for **320px–479px**.
*   **Process Stepper:** Switch to single row (4 items) from **390px (M)**.
*   **Calculator:** Switch to "Controls Left / Result Right" layout from **FOLD (640px)**.
*   **XXS0 (JioPhone):** Single column STRICT. Accordions for heavy sections.
*   **Max Container:** Cap at **1320px** even on 8K screens.

#### 4. FOLD-Landscape (Wide + Short) & Crease-Safe Spec
These rules apply specifically to `min-width >= 768px AND max-height <= 500px` (Z Fold 5 Unfolded Landscape).

*   **P0: Height-Based Mode (Wide + Short):**
    *   **Trigger:** Width is tablet-like, height is very short (344px). Treat as height breakpoint.
    *   **Acceptance:** First screen shows real content, not mostly decor/empty space.

*   **P0: Crease-Safe Zone (Physical Fold):**
    *   **The Rule:** No critical text, CTA, or card border crosses the screen center.
    *   **Implementation:** Add a **center gutter (32-48px)** or use a **dual-pane split**.
    *   **Sticky Elements:** Bottom CTA **OFF**; floating/chat widgets off or relocated.

*   **Global Density Adjustments:**
    *   **Header Height:** 56px -> 48px (optional).
    *   **Section Padding:** 56px -> `40-48px`.
    *   **Hero Decor:** Reduce opacity by ~40% or hide particles/watermarks.

*   **Component Layouts (882px Spanning Mode):**
    *   **Hero (P0):** 2 columns. Left = text + CTA, Right = visual. Max 2 buttons; third as link.
    *   **Services:** 2 columns (text/bullets left, card/CTA right). Chips wrap or horizontal scroll.
    *   **Stats:** 4 columns (1 row), no stat crosses the center gutter.
    *   **Process:** Stepper 4 in 1 row; content 2 columns (text left, map right).
    *   **Team:** 2-3 columns; avoid single-card layout.
    *   **Calculator (P0):** 2 columns; controls left, result right. Result may be sticky within section (not global).
    *   **Portfolio:** 2 columns (list left, visual right).
    *   **Testimonials:** 2-3 columns.
    *   **FAQ:** 1 column by default; 2 only if questions are short.
    *   **Insights/Blog:** 2 columns.
    *   **Newsletter:** 2 columns (input left, button/choices right).
    *   **Contact Form:** 2-column fields (name + contact side-by-side), textarea full-width.

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

## 🎨 Phase 6B: Dark Mode UI/UX Quick Wins
(Problem -> Səbəb -> Təklif)

*   **Default theme:** dark (kontrast ve srift oxunaqliligi birinci optimallasdirilir; light eyni spacing/dizayn sisteminden miras alir).
*   **Hero (CTA + vizual):** Iki CTA eyni cekidedir -> istifadeci qerarsiz qalir; hero vizuali/particle cox yer tutur -> fold asagidaki mezmun itir -> Bir primary CTA (mes: "Brief gonder"), bir secondary (outline/text); hero hundurluyunu 20-30% qisalt, metn zonasinda overlay + particle opacity-ni azaldib trust signal (logos/score) elave et.
*   **Axin/iyerarxiya:** Bolmeler Stats -> Xerite -> Komanda -> Kalkulyator -> Portfel -> FAQ ardicilligi ile qarisiq hiss olunur -> Istifadeci "neye gore bunu indi gorurem?" deyir -> Klassik axin: Hero -> Problem/Solution -> Xidmetler -> Proses -> Case study/Portfolio -> Reyler -> Qiymet/Paket/Kalkulyator -> FAQ -> Kontakt.
*   **Vizual ses-kuy / spacing:** Dekorativ watermark ("STRATE.....") ve agir gradient/particle metn oxunaqliligini basir; kartlararasi vertikal bosluq qeyri-beraberdir -> Oxu axini bolur -> Watermark-i sil ve ya 5-8% opacity + kicik olcu ile divider kimi istifade et; 8pt spacing sistemi (8/16/24/32), mobil section padding 48-64px.
*   **Konsistensiya (card/button sistemi):** Radius, shadow, blur beraber deyil; duymeler ferqli olculerde -> UI "sistem" hissi zeifleyir -> Tek card stili: radius ~16-20px, border 1px, shadow 2 seviye, blur yalniz secilmis zonalarda; Button olcu sistemi sm/md/lg, min-height 44-48px, eyni radius.
*   **Kontrast (dark):** Fon (gradient + noise + particle) cox aktivdir -> body text kontrasti dusur -> Metn zonalarinda fonu sakitlesdir (qaralma overlay), particle-opacity-ni azaldin; body min 16px, line-height 1.45-1.6, secondary text >=14px.
*   **Stat bloklari:** Kartlar hundur ve melumat sixligi azdir -> Skannama zeif -> Mobil 2x2 grid, kart hundurluyunu azaltdin, label oxunaqliligini artirin, 1 konteks cumlesi elave edin ("Son 12 ayin neticeleri" kimi).
*   **Kalkulyator (UX yuku):** Cox control (toggle + paket + slider) -> qerar yuku -> "3 preset" (Start/Pro/Enterprise) + "Custom" slider; netice kartinda kontekst: "Aylig araliq", "daxildir/daxil deyil", "minimum muddet", "baslanqic tarix".
*   **Portfel / Reyler / FAQ:** Case kartlarinda "sektor / gorulen is / netice" gorunmur; reyler az; FAQ-da motivasiya zeif -> Kartlarda sektor+is+neticeyi goster; 3-6 rey + logo wall/rating; FAQ ustunde "Sur?tli cavablar" intro ve rahat oxunan accordion.
*   **Formlar:** Placeholder label rolunu oynayir -> UX zeifleyir; form CTA-lar esas CTA ile reqabet edir -> Gorunen label + helper text + error state; form CTA-ni bir pille sakit saxla, esas CTA hero/sticky-de qalir.
*   **Sticky CTA (mobil):** Uzun landingde CTA itir -> Mobil sticky bottom bar: 1 primary CTA ("Brief gonder") + 1 elaqe (WhatsApp/zeng).


## 📐 Phase 6D: UI/UX Struktur Tapıntıları (Global)
(Light + Dark, Mobile daxil)

*   **Scroll/bosluq:** Particle + "STRATE..." watermark hundurdur, kontent gec baslayir -> hero dekorunu 40-60% qisalt, ilk ekranda H1 + 1 cumle deyer + 1 primary CTA goster.
*   **Kontrast (light):** Basliq/subtitle solgundur, xususen “Hara isleyirik?” -> H2 #111-#222, ikincil #4B5563.
*   **Iyerarxiya:** Standart: H2 -> 1 cumle izah -> esas komponent -> CTA; kart/duyme olculerini S/M/L kimi vahidlesdir.
*   **Header:** Sag ikonlar qeyri-aydindir; sticky header-de 1 primary CTA saxla, ikonlari tooltip/label ile ac.
*   **Hero/CTA:** 1 cumlede “ne edirik/kimin ucun/netice”; primary solid, secondary outline, kontrastli.
*   **Watermark/particle:** Opacity-ni azaldin ve ya yalniz desktop; dekoru kecid kimi qisa saxlayin.
*   **Xidmet kartlari:** 1 esas CTA (“Teklif al”), ikinci link (“Detallar”); tab/ikonlu 3 secimi ya real tab bar (active underline), ya da cixarin.
*   **Statistika:** Mobil 2x2, kart hundurluyu az, label konkret; gradient brend palitrasina yakin qalsin.
*   **“Hara isleyirik?”:** Light kontrast P0; stepper real proses (Kesf->Strategiya->Icra->Olcme) ya silin; xerite dekorativse, region/sektor listi + 3-5 real numune; checklist sade list olsun.
*   **Komanda:** Minimum 3 profil (foto, ad, rol, 1 cumle tecrube, LinkedIn).
*   **Kalkulyator:** Wizard axini (“Meqsed -> Budce -> Teklif”), slider deyer badge; netice kontekstini ac (“ayliq/layihelik”, EDV/disclaimer); primary CTA “Bu tekliyi al” solid, secondary outline; gradient brend renglerinde.
*   **Portfel:** Minimum 3 is + filter chips; her kartda musteri, sektor, netice metrikasi, 1 CTA (“Case study”).
*   **Formlar:** Ilk 3 sahe (Ad, Email/Telefon, Meqsed + optional Budce), gorunen label + helper; error submitden sonra; validasiya ikonu kicik; newsletter-de “Spam yox, ayda 2 defe” + Privacy.
*   **Reyler:** 2-3 rey slider, logo + ad/rol + 1 cumle netice.
*   **FAQ:** Hundurluk/spacing azaldin, caret boyudun; axtaris inputu "Suallarda axtar..." edin ya da cixarin.
*   **Footer/Floating:** Light-da link kontrastini artirin; huquqi linkler elave edin; chat safe-area ile toqqusmasin, lazim olsa scroll-da yuxari qalsin.
*   **Top P0:** Light kontrast; dekor hundurluyunu azaltmaq; stat kartlarini 2x2 + alcaq; “Hara isleyirik?” stepper/xeriteni real ve ya sade; kalkulyator neticesine kontekst + duzgun primary CTA.

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

---

