# Red Dot Master Report — Merged & De-duplicated (.md)
**Layihə:** Chalang vebsaytı `/preview` (kod + real device müşahidələri)  
**Merged versiya tarixi:** 2026-01-08  
**Mənbələr (bu conversation-da verilən 2 əsas blok):**
1) **Red Dot Master Report** (Mobile-First Standards + UI/UX Audit + Sprint Specs + Sprint Plan)  
2) **Phase 1 Report + Existing Findings + Yekun Analiz Hesabatı** (Setup/Matrix + Code Evidence + 26-point audit + Responsiveness deep dive + Roadmaps)

**Birləşdirmə prinsipi (anti-loss):**
- Təkrarlanan fikirlər **tək instans** kimi saxlanıldı.
- Eyni mövzuda **fərqli əlavə detal / sübut / cihaz nümunəsi** varsa, **hamısı qorunub**.
- Ziddiyyətli bəndlər **silinmədi** — “Conflict / Phase 5 smoke-test” etiketi ilə qeyd olundu.

---

## 0) Source → Master Mapping Index (diff-style xəritə)
Aşağıda hər “orijinal böyük başlıq” üçün Master sənəddə yerləşdiyi yer göstərilir.

### A) “Red Dot Master Report (Phase 6/7/8 + Sprint Plan)” xəritəsi
- `Phase 6: Mobile-First GLOBAL Standards (320–430)` → **PHASE 3-C** (Mobile-First Global Standards)  
- `Phase 7: Granular UI/UX Section Audit (15-Point)` → **PHASE 2-B** (Granular UI/UX Audit)  
- `Phase 8: Developer-Ready Sprint Specifications` → **PHASE 6-A** (Developer-Ready Specs)  
- `Execution Sprint Plan (Sprint 1/2/3)` → **PHASE 6-B** (Execution Sprint Plan)  
- `6F Large Mobile & Landscape Optimizations` → **PHASE 3-D** (Large Mobile & Landscape)  
- `6G Global Grid & Column Strategy` → **PHASE 3-E** (Breakpoint Map + Column Matrix)

### B) “Yekun Analiz Hesabatı (1–9)” xəritəsi
- `1. Setup` → **PHASE 1**  
- `2. Brand & Visual` → **PHASE 2-A**  
- `3. UI/UX Deep Dive` → **PHASE 2** (A/B)  
- `4. Light/Dark` → **PHASE 2-C**  
- `5. Dil & Tərcümə` → **PHASE 2-D**  
- `6. Dinamika/Admin riskləri` → **PHASE 4**  
- `7. Responsivlik (360–1920)` → **PHASE 3**  
- `8. Performans & CLS` → **PHASE 5**  
- `9. Fix Roadmap cədvəli` → **APPENDIX B** + **PHASE 6-B**

### C) “Phase 1 Report (Struktur/Matris + Evidence)” xəritəsi
- `Test Matrisi + Bölmə xəritəsi` → **PHASE 1-A**  
- `4.1–4.14 tapıntılar (fayl/sətir sübutları)` → **PHASE 1-B** (Evidence Log)  
- `Phase 2-yə keçid şərti` → **PHASE 6-C** (Acceptance & Gate)

### D) “Existing Findings (26-point + Device Deep Dives + Admin table + Roadmaps)” xəritəsi
- `26-bəndlik audit cədvəli` → **APPENDIX A**  
- `Real Device Verification Matrix + Deep dives` → **PHASE 3-B** + **APPENDIX C**  
- `Admin/Dynamics table (1–26)` → **PHASE 4-A**  
- `Prioritetləşdirmə + Addım 1/2/3 Roadmap` → **PHASE 6-B** + **APPENDIX B**

---

# PHASE 1) Hazırlıq, Struktur və Test Matrisi (Setup & System)
**Əhatə:** `/preview` ana səhifə (kod inspektasiyası + real device müşahidələri)  
**Metod:** Deep code inspection + fayl/sətir sübutları + user-verified cihaz müşahidələri (run-time testlər Phase 5-də)

## PHASE 1-A) Test Matrisi (hələ tam icra edilməyib, amma xəritələnib)
**Dil x Rejim:** AZ/EN/RU × Light/Dark  
**Ölçülər:** 100×100, 320×568, 360×640, 768×1024, 1366×768, 1440×900, 1920×1080, 3840×2160, 7680×4320

> Qeyd: Bu matrisi Phase 5-də canlı test + screenshot evidence ilə dolduracağıq.

## PHASE 1-B) Bölmə Xəritəsi (Structure Map)
Navbar, Hero, Marquee, Services, Metrics/Stats, Process, Team, Estimator, Portfolio, Testimonials, FAQ, Blog, CTA/Contact, Footer, Cookie, Global UI.

## PHASE 1-C) Evidence Log (Fakt tapıntıları — fayl/sətir sübutları ilə)
> Qeyd: Buradakı bəndlər Phase 1 Report və digər hissələrdən **təkrarsız** yığılıb.

### 1) Meta və Social Preview (Minimum Head)
- **Tapıntı:** `<head>` hissəsində yalnız `charset`, `viewport`, `title` var. OG/description yoxdur.  
- **Sübut:** `resources/views/front/preview.blade.php:4-6`  
- **Risk:** WhatsApp/LinkedIn paylaşımında zəif preview.

### 2) Global Theme bağlılığı (Admin → Front)
- **Tapıntı:** Theme rəng/şrift/radius Settings-dən oxunur; `:root` və `[data-theme="dark"]` ilə override olunur.  
- **Sübut:** `resources/views/front/layouts/partials/dynamic-styles.blade.php:27-37`, `:63`, `:97`  
- **Nəticə:** Struktur baxımından düzgün qurulub.

### 3) Typography riskləri (mobil üçün)
- **Tapıntı 1:** Hero H1 `clamp(2.5rem, 5vw, 4.5rem)` — 360px üçün riskli.  
  - **Sübut:** `public/assets/css/chalang-preview.css:1019-1021`  
- **Tapıntı 2:** Service hero H1 `clamp(3rem, 5vw, 4.5rem)` — mobil üçün daha riskli.  
  - **Sübut:** `public/assets/css/chalang-preview.css:2072-2073`

### 4) Services grid min ölçü problemi
- **Tapıntı:** `.grid` `minmax(300px, 1fr)` istifadə edir; 320px-də horizontal scroll riski.  
- **Sübut:** `public/assets/css/chalang-preview.css:1192-1194`

### 5) Navbar A11y (Keyboard)
- **Tapıntı:** Dropdown yalnız hover ilə açılır; `:focus-within` yoxdur.  
- **Sübut:** `public/assets/css/chalang-preview.css:499-501`  
- **Risk:** WCAG fail — klaviatura ilə alt menyu açılmır.

### 6) Reduced Motion (partial)
- **Tapıntı (CSS):** `@media (prefers-reduced-motion: reduce)` yalnız `.bg-shape` və `.infinite-text` üçün var.  
  - **Sübut:** `public/assets/css/chalang-preview.css:313-320`  
- **Tapıntı (JS):** `prefersReducedMotion` yoxlanır və bəzi effektlər sönür.  
  - **Sübut:** `public/assets/js/chalang-preview.js:8`, `:641`, `:659`  
- **Risk:** AOS scroll animasiyaları reduced-motion rejimində ayrıca tam bağlanmır.

### 7) Print styles yoxdur
- **Tapıntı:** CSS-də `@media print` yoxdur.  
- **Sübut:** `public/assets/css/chalang-preview.css` üzrə `@media print` tapılmadı.

### 8) Custom Scrollbar və Selection yoxdur
- **Tapıntı:** `::-webkit-scrollbar` və `::selection` stilləri yoxdur.  
- **Sübut:** `public/assets/css/chalang-preview.css` üzrə selektorlar tapılmadı.

### 9) Estimator state davamlılığı (localStorage)
- **Tapıntı:** Estimator seçimi `localStorage`-a yazılır və bərpa edilir.  
- **Sübut:** `public/assets/js/chalang-preview.js:1327`, `:1354`, `:1448`, `:1504`  
- **Qeyd:** Bu, digər blokda deyilən “F5-də sıfırlanır” iddiası ilə ziddiyyət yaradır → **Conflict (Phase 5 smoke-test)**.

### 10) Process auto-rotasiya yoxdur
- **Tapıntı:** Process tab logic yalnız kliklə işləyir, auto-rotate yoxdur.  
- **Sübut:** `public/assets/js/chalang-preview.js:1198-1235`  
- **Qeyd:** `setInterval` yalnız preloader üçündür (`:1113`).

### 11) 404 lokallaşdırma (Hardcoded)
- **Tapıntı:** 404 mətnləri AZ dilində hardcoded-dir.  
- **Sübut:** `resources/views/errors/404.blade.php:6`, `:90`

### 12) Language assets mövcuddur
- **Tapıntı:** `resources/lang/az|en|ru/preview.php` var və əsas açarlar mövcuddur.  
- **Sübut:** `resources/lang/az/preview.php:4,28,115,171`, `resources/lang/en/preview.php:4,28,113,115,171`, `resources/lang/ru/preview.php:4,28,115,171`

### 13) JS translations mövcuddur
- **Tapıntı:** JS-də AZ/EN/RU tərcümə obyektləri mövcuddur.  
- **Sübut:** `public/assets/js/chalang-preview.js:286`, `:361`, `:436`

### 14) Breakpoint xəritəsi (koddan)
- **Tapıntı:** CSS-də əsas breakpoints: 575px, 900px, 1150px, 991px, 640px, 768px.  
- **Sübut:** `public/assets/css/chalang-preview.css:216, 323, 722, 1109, 1314, 2618, 3145, 3163, 3440`

---

# PHASE 2) Brend, Vizual Dizayn, UI/UX və Lokalizasiya (Content & Context)
Bu faza “Red Dot” prizmasında vizual uyğunluq, iyerarxiya, light/dark, i18n və UX axını birləşdirir.

## PHASE 2-A) Brend və Vizual Dizayn Uyğunluğu
| Komponent | Status | Şərh |
| :--- | :--- | :--- |
| **Rəng Palitrası** | 🟢 Əla | `--brand-gradient` (Purple/Pink) ardıcıl istifadə olunub. Glow effektləri brendin “neon/tech” ruhunu əks etdirir. |
| **Tipoqrafiya** | 🟡 Riskli | `.service-hero h1` üçün `clamp(3rem, ...)` (48px min) mobil üçün çox böyükdür; uzun sözlər daşa bilər. |
| **Vizual Ritm** | 🟢 Yaxşı | `.glass-card` və `.process-step` boşluqları (grid-gap 20–30px) balanslıdır. |

## PHASE 2-B) Granular UI/UX Section Audit (15-Point Deep Dive) — (Locked)
### 2-B.1 Global (All Sections)
1. **Vertical Bloat:** Dekorativ elementlər kontenti aşağı salır. **Həll:** Hero hündürlüyünü 40–60% azalt, dekoru arxa fona keçir.
2. **Light Mode Contrast (P0):** Başlıqlar solğundur. **Həll:** Heading `#111-#222`, secondary `#4B5563`.
3. **Visual Hierarchy:** Dekor, başlıq, kartlar rəqabət aparır. **Həll:** Standart: H2 → İzah → Komponent → CTA.
4. **Component Sizing:** Kart/düymə ölçüləri qeyri-sabit. **Həll:** S/M/L sistemi.

### 2-B.2 Section Specifics
5. **Navbar:** İkonlar aydın deyil. **Həll:** Tooltip, hamburger standartı, CTA.
5b. **Header CTA (P0):** Sticky header-də əsas CTA yoxdur. **Həll:** 1 primary CTA ("Təklif al") header-də saxla.
6. **Hero:** Dəyər təklifi zəif. **Həll:** “X sahədə Y nəticə”; Primary vs Secondary CTA ayrımı.
7. **Watermark (“STRATE…”):** Noise. **Həll:** Opacity 5%-ə endir.
8. **Services:** Kart içi qarışıq. **Həll:** Tək CTA saxla, digərini link et; tabları sadələşdir.
9. **Stats (P0):** Kartlar çox hündür. **Həll:** Mobildə 2×2 grid; label konkret (“Müştəri məmnuniyyəti”).
10. **“Hara işləyirik” (P0):** Stepper/xəritə dekorativdir. **Həll:** real proses addımları və ya region siyahısı.
11. **Team:** Tək kart etibar yaratmır. **Həll:** min 3 profil.
12. **Estimator (P0):** Nəticə kontekstsiz. **Həll:** “Aylıq təxmini”, “Daxildir/Daxil deyil”, slider dəyər badge.
13. **Portfolio:** Tək nümunə az. **Həll:** 3 kart + filter.
14. **Forms:** Inputlar çox hündür. **Həll:** Label+Placeholder birləşdir, validation submit-də.
15. **Footer:** Linklər solğun. **Həll:** Kontrast + Privacy/Terms.
16. **Testimonials:** 1 rəy bəs etmir. **Həll:** 3–6 rəy slider, şirkət loqosu, ad/rol, nəticə.
17. **Blog:** Tək kart bəs etmir. **Həll:** 2–3 kart + "hamısına bax" linki.
18. **Newsletter:** Etibar elementi çatmır. **Həll:** "Spam yox, ayda 2 dəfə" + Privacy link.

### 2-B.3 Top 5 Priority (P0)
1) Light Theme Contrast (Heading #111)  
2) Scroll Height (dekor bloat azaltmaq)  
3) Stats 2×2 kompakt  
4) Stepper/Map sadələşdirmə / reallıq

## PHASE 2-C) Light/Dark Rejim Uyğunluğu
| Element | Dark Mode (Defolt) | Light Mode | Uyğunsuzluq Riski |
| :--- | :--- | :--- | :--- |
| **Glass Kartlar** | `rgba(30,41,59,0.6)` | `rgba(255,255,255,0.6)` | Yoxdur — backdrop oxunaqlıq verir. |
| **Xəritə (Map)** | Görünür | Solğun | Light-da `filter`/`brightness` tənzimləmə lazım ola bilər. |
| **Input Border** | `rgba(255,255,255,0.1)` | Tünd boz | Light-da kontrast zəif ola bilər. |

## PHASE 2-D) Dil və Tərcümə (i18n) — vəziyyət + risk
- `resources/lang/az|en|ru/preview.php` mövcuddur (280+ açar) → **infrastruktur güclüdür**.  
- JS translations obyektləri mövcuddur (AZ/EN/RU).  
- **Risk (qeyd):** JS tərəfdə istifadə olunan bəzi dinamik mətnlər (error/loading) Blade-dən tam ötürülməsə, dil qarışıqlığı ola bilər.  
  - Təklif: `window.translations = @json($translations)` (və ya tam JS bundle coverage).

## PHASE 2-E) UI/UX Axın Ardıcılığı (Quick Wins — Dark Mode daxil)
- Default: dark optimallaşdır → light eyni spacing sistemini miras alsın.
- Axın: Hero → Problem/Solution → Services → Process → Portfolio → Testimonials → Pricing/Estimator → FAQ → Contact.
- CTA: Hero-da 1 primary (“Brief göndər”), 1 secondary (outline/text).
- Watermark/particles: ya desktop-only, ya opacity çox aşağı (5–8%).
- Kart/düymə sistemi: radius/shadow/blur vahidləşsin; min tap 44–48px.

---

# PHASE 3) Responsivlik, Ekstrem Ölçülər və Mobile-First Standartlar
Bu faza real device müşahidələrini, breakpoint strategiyasını və mobil dizayn “qaydalarını” birləşdirir.

## PHASE 3-A) Ümumi responsiv risklər (kod + müşahidə)
- 360px: H1 böyük, footer newsletter sıxıla bilər.
- 1920px+: container mərkəzlənib, bg-shape ekranı doldurduğu üçün “boşluq” hissi azaldılır.

## PHASE 3-B) Real Device Verification Matrix (Consolidated)
> Tam siyahı Appendix C-də saxlanılıb (təkrarsız, yekun). Burada “əsas qərar çıxaran” cihazlar:

- **320×568 (iPhone SE 1)** → 🔴 Fail: `minmax(300px)` > available width; H1 overflow; float elementlər safe area-ni yeyir.  
- **240×320 (JioPhone 2 / KaiOS)** → 🔴 Fail: content loss; legacy JS/CSS fallbacks; variant B lazımdır.  
- **412×915 (S20 Ultra)** → ⚠️ Fail: Stats “3+1 orphan bug”; 412px width israf olunur (2-col adapter lazımdır).  
- **430×932 (iPhone 14 Pro Max)** → ⚠️ Fail: safe-area/dynamic island overlap; `100vh` glitch risk.  
- **600×1024 (BB PlayBook)** → 🟢 Pass: 2-col grid aktiv; hamburger ok; typography rahat.  
- **360×780 (Huawei P30 Pro)** → 🟢 Pass: baseline device (360×780).

## PHASE 3-C) Mobile-First GLOBAL Standards (320–430) — (Verified Decision)
**Qərar:** Huawei P30 Pro və digər cihazların analizindən çıxan ortaq nəticələr bütün mobil versiyalar üçün standart qəbul edilir.

### 3-C.1 Layout & Grid (Universal Mobile Rule)
| Komponent | Qayda | Səbəb |
| :--- | :--- | :--- |
| **Grid Sütunları** | **Mütləq 1 sütun** (320–375) | 300px kartlar 320–375px ekranlara sığmır; yan-yana yalnız >480px. |
| **Hero Hündürlük** | **Max 85vh / padding azalsın** | First fold mütləq CTA + trust signal göstərməlidir. |
| **Process Map** | **Timeline forması** | Xəritə mobildə oxunmur; addımlar timeline olmalıdır. |
| **Estimator** | **Stack layout** | Kontrollerlər yuxarıda, nəticə aşağıda (sticky deyil, axınla). |

### 3-C.2 Typography & Spacing (Universal)
- H1: `clamp(2rem, 5vw, 3rem)` (min 32px) — mobil üçün 48px olmaz.
- Body text: min 16px.
- Hit-area: min 44×44px.
- Section padding mobile: 48–64px.
- Spacing: 8pt sistemi (8/16/24/32).

### 3-C.3 Behavior
- Mobil uzun səhifələr: **fixed bottom bar** (Primary “Brief göndər” + WhatsApp).

## PHASE 3-D) Large Mobile & Landscape Optimizations (Verified)
### 3-D.1 430px (iPhone Pro Max) & 412px (S20 Ultra)
- Container: `max-width: clamp(360px, 92vw, 480px)`
- 2-col adapters (min-width 390/400):
  - Stats: `repeat(2, 1fr)` (P0 “3+1” fix)
  - Portfolio/Testimonials: 2-col
  - Hero CTAs: `flex-direction: row`
- Safe area: `env(safe-area-inset-*)`
- Android bottom toolbar: dinamik padding hesablanmalıdır.

### 3-D.1b Universal Landscape Mode (All Devices)
**Tətbiq şərti:** `(orientation: landscape) AND (max-height: 500px)`
- **Sticky bottom CTA:** OFF (və ya 1 düyməyə endir)
- **Section padding:** 56px → 40-48px
- **Hero dekor:** opacity -40% və ya hündürlük -30%
- **Notch/safe-area:** `padding-left/right: max(16px, env(safe-area-inset-left/right))`
- **Grid:** Stats 4-lü bir sətir, Portfolio/Testimonials 2 sütun

### 3-D.2 Ultra-Low Width (240–319) — JioPhone 2 Strategy
- Variant B “Full Content (Compressed)”
- `@media (max-width: 319px)` overrides:
  - 1-col strict
  - H1 ~22px, P ~14px
  - Particles/decor/sticky bars OFF
  - Legacy polyfills (KaiOS üçün) — ES5/ES2017 fallback ehtimalı

## PHASE 3-E) Global Grid & Column Strategy (Verified Spec)
### 3-E.1 Breakpoint Map
| Tier | Range (px) | Device Examples |
| :--- | :--- | :--- |
| Micro | ≤120 | Micro-shell |
| XXS | 121–239 | Wearables/Legacy |
| XS0 | 240–319 | JioPhone 2, narrow cover |
| XS | 320–359 | iPhone SE, Fold cover |
| S | 360–389 | Android standard |
| M | 390–413 | iPhone Pro |
| L | 414–479 | Pro Max |
| XL | 480–639 | Mini tablet |
| FOLD | 640–767 | Fold open/land |
| TAB | 768–1023 | iPad Mini/Air |
| DS | 1024+ | Desktop |

### 3-E.2 Component Column Matrix
| Component | XS | S-M | L | XL | FOLD | TAB | DS |
| :--- | :---: | :---: | :---: | :---: | :---: | :---: | :---: |
| Hero (Text/CTA) | 1 | 1 | 1 (CTA 2) | 1–2 | 2 | 2 | 2 |
| Stats | **2 (2×2)** | **2 (2×2)** | **2 (2×2)** | 4 (1 row) | 4 | 4 | 4 |
| Services | 1 | 1 | 1 | 2 | 2 | 2 | 3 |
| Process (Step) | 2 (2×2) | 2 (2×2) | 4 (1 row) | 4 | 4 | 4 | 4 |
| Portfolio/Testim | 1 | 1 | 1 | 2 | 2 | 3 | 3 |
| Calculator | 1 | 1 | 1 | 1 | 2 (Split) | 2 | 2 |
| Footer Links | 1 | 1 | 2 | 2 | 2 | 3 | 4 |

### 3-E.3 Specific Logic Rules
- Stats (P0): 320–479 arası **mütləq** `repeat(2, 1fr)` (3+1 bug fix).
- Process stepper: 390px+ tək sıra (4 item).
- Calculator: 640px+ split (controls left / result right).
- Hero CTA: 390px+ və ya 414px+ iki düymə yan-yana.
- XS0: 1-col strict; heavy sections accordion; majorları “display:none” etmə.
- Max container: 1320–1440 cap; background expand; content center.

### 3-E.4 iPad Mini / Tablet 12-Point Checklist (768px+)
| # | Komponent | Qayda |
|---|---|---|
| 1 | **Stats** | 4 sütun 1 sırada (Strict). `repeat(4, 1fr)`. 3+1 stack qadağandır. |
| 2 | **Team** | 2-3 sütun. Tək kart tablet üçün qadağandır. |
| 3 | **Hero** | 2 sütun (Mətn/CTA sol, Vizual sağ). Dekor opacity -30%. |
| 4 | **Services** | 2×2 grid standart. **Kritik:** Bərabər hündürlük + alt-aligned CTAs. |
| 5 | **Process** | 2 sütun split: Kontent/Checklist (Sol) | Xəritə/Vizual (Sağ). |
| 6 | **Calculator** | 2 panel fixed: Controls (Sol, min 360px), Result (Sağ, min 320px). |
| 7 | **Portfolio** | 2 sütun list/cases. Tək sütun siyahı qadağandır. |
| 8 | **Testimonials** | 3 sütun (min 2). |
| 9 | **FAQ** | Max-width container (~880-960px) oxuma yorğunluğu qarşısını almaq üçün. |
| 10 | **Blog** | 3 sütun, fixed aspect ratio (16/9) şəkillər. |
| 11 | **Newsletter** | Horizontal Layout (Input + Button inline). |
| 12 | **Footer** | Multi-column (3 cols) link layout. Tək sütun yalnız mobil üçündür. |

### 3-E.5 Z Fold 5 Crease-Safe Spec (Dual-Pane Logic)
**Tətbiq şərti:** `min-width >= 768px AND max-height <= 500px` (Fold açıq landscape)

| Prioritet | Qayda | Detallar |
|---|---|---|
| **P0** | **Height-Based Mode** | En tablet kimidir, hündürlük çox qısadır (344px). Hündürlük breakpoint kimi yanaşın. |
| **P0** | **Crease-Safe Zone** | Kritik mətn, CTA, kart kənarı ekran mərkəzini keçməməlidir. **Həll:** 32-48px center gutter və ya dual-pane split. |
| **P0** | **Sticky Elements OFF** | Bottom CTA söndürülsün; floating/chat widgetlər söndürülsün və ya yerləşdirilsin. |
| **Global** | **Header Height** | 56px → 48px (optional). |
| **Global** | **Section Padding** | 56px → 40-48px. |
| **Global** | **Hero Decor** | Opacity ~40% azaldılsın və ya particles/watermarks gizlədilsin. |

**Component Layouts (882px Spanning Mode):**
- **Hero:** 2 sütun (Sol = mətn + CTA, Sağ = vizual). Max 2 düymə; 3-cü link kimi.
- **Services:** 2 sütun (Sol = mətn/bullets, Sağ = kart/CTA). Chips wrap və ya horizontal scroll.
- **Stats:** 4 sütun (1 sıra), heç bir stat mərkəz gutterı keçməsin.
- **Calculator:** 2 sütun (Sol = controls, Sağ = result). Result section-daxili sticky ola bilər (global deyil).
- **FAQ:** Default 1 sütun; 2 sütun yalnız qısa suallarda.

---

# PHASE 4) Dinamika və Admin Bağlılıq (Admin ↔ Front)
## PHASE 4-A) Bölmə üzrə dinamiklik cədvəli (Legend: ✅ Dynamic / ⚠️ Hybrid / ❌ Static/Missing)
| Bölmə | Status | Admin Mənbəyi / Kod İzahı |
| :--- | :---: | :--- |
| Navbar | ⚠️ | Struktur statik, label-lər tərcümə ilə |
| Hero | ✅ | `$banner` admin |
| Marquee | ✅ | `preview.ticker_default` + parse |
| Services | ✅ | `$main_services` loop |
| Metrics | ✅ | `preview.metrics.*` |
| Process | ✅ | `$steps` loop |
| Team | ✅ | `$team_members` / fallback |
| Estimator | ⚠️ | `$pricing_plans` var, alqoritm JS-də |
| Portfolio | ✅ | `$portfolios` loop (limit 6) |
| Testimonials | ✅ | DB |
| FAQ | ✅ | `$faqs` loop |
| Blog | ✅ | `$blogs` loop (limit 3) |
| Contact | ✅ | tərcümə + `contact.submit` |
| Footer | ⚠️ | struktur statik, sosial linklər dinamik |
| Cookie | ❌ | mövcud deyil |
| Global UI | ✅ | dynamic styles / vars |
| Light/Dark default | ❌ | Front JS/cookie — admin-dən dəyişmir |
| Session resilience | ❌/**Conflict** | Estimator localStorage var (Evidence) ↔ “F5 sıfırlanır” iddiası |

---

# PHASE 5) Performans, SEO, Accessibility (A11y) və Təhlükəsizlik
## PHASE 5-A) SEO / Social Preview (P0)
- `<meta name="description">`, `og:title`, `og:image` yoxdur → paylaşım preview zəif.
- `hreflang` yoxdur → 3 dil SEO qarışa bilər.

## PHASE 5-B) A11y (P0)
- Navbar dropdown hover-only → `:focus-within` tələb olunur.
- `aria-label` və fokus idarəsi dinamik komponentlərdə yoxlanmalıdır.
- Custom cursor: zoom/magnifier istifadəçiləri üçün risk (media query ilə məhdudlaşdırılmalıdır).

## PHASE 5-C) Motion Sensitivity
- JS reduced-motion bəzi effektləri söndürür (yaxşı), amma AOS/scroll animasiyalar tam bağlanmaya bilər.
- CSS `@media (prefers-reduced-motion)` genişləndirilməlidir.

## PHASE 5-D) Print Styles
- `@media print` yoxdur → Ctrl+P zamanı dark fon/animasiya problemi.

## PHASE 5-E) Performans (CLS/Lazy Load)
- Font yüklənməsi: `font-display: swap` yoxlanılmalıdır.
- `loading="lazy"` bəzi şəkillərdə unudulub.

## PHASE 5-F) Offline / PWA
- Service Worker / manifest yoxdur (offline rejim fail).

## PHASE 5-G) Security (client-side API risk)
- Client-side AI çağırışları (Gemini) üçün backend proxy tövsiyə olunur; API key exposure riski.

---

# PHASE 6) İcra Spesifikasiyası, Sprint Planı və Acceptance Gates
Bu faza artıq “developer-ready” spesifikasiyalar və sprint ardıcıllığını “Locked” formada verir.

## PHASE 6-A) Developer-Ready Sprint Specifications (P0) — (Locked)
**Baseline Device:** Huawei P30 Pro (360×780)  
**Test Devices:** iPhone SE (320), iPhone 12/13/14 (390–430)

### 6-A.1 Global System (P0)
- Container: `padding-inline: 16px`, `max-width: 420px` (mobile), `margin: 0 auto`; section `padding-block: 56px` (hero 64px)
- Typography: Body `16px/1.55`; Secondary `14px/1.5`; H1 `28–32px/1.15`; H2 `22–24px/1.2`
- Click targets: min-height 44px (ideal 48px); icon buttons 44×44; radius 12–16
- Light contrast: Heading `#111–#222`, Secondary `#4B5563`, Divider `#E5E7EB`

### 6-A.2 Header & Hero (P0)
- Sticky header: height 56px; primary CTA min-width 120px
- Hero: `min-height: auto`; `padding-top: 24px`; `padding-bottom: 32px`; decor opacity 20–35%
- CTA hierarchy: Primary solid 48px height; Secondary outline 48px height

### 6-A.3 Visual Noise (P0)
- Decor max-height 180–240px mobile
- Watermark opacity 3–6% və ya remove

### 6-A.4 Stats (P0)
- Layout: mobile 2×2 (`repeat(2, 1fr)`), gap 12px
- Cards: min-height 92–110px; label 12–13px

### 6-A.5 Estimator (P0)
- Font constraint: `clamp(22px, 6vw, 28px)` overflow prevention (320px)
- Context: “Aylıq/Layihəlik” + disclaimer; slider value badge

### 6-A.6 P1/P2 Bəndləri (qısa)
- Map: timeline stepper
- Team: 3 profile cards (avatar 40–48)
- Portfolio: 3 cards + filter chips (32px)
- Forms: input height 48px; step 1 qısa (name/contact/goal)
- Testimonials: 3–6 slider
- FAQ: padding 12–14
- Floating: bottom offset 16–24 + safe-area

## PHASE 6-B) Execution Sprint Plan
### Sprint 1 — Critical Fixes (P0)
1) Global mobile system: container padding + spacing  
2) Light contrast fix (#111)  
3) 44px tap targets  
4) Hero optimization (height + CTA hierarchy)  
5) Visual noise reduction  
6) Stats 2×2 grid  
7) Estimator context + overflow safety  
8) Sticky CTA bottom bar (Brief + WhatsApp)

### Sprint 2 — High Value UX (P1)
1) Map/Process: stepper semantics + simplify  
2) Services: single CTA/card + clear filters  
3) Team: 3-card layout  
4) Calculator: presets → custom  
5) Portfolio: 3 cards + meta tags  
6) Forms: shorten step 1 + labels  
7) Testimonials: expand content  
8) FAQ: denser + search improvement

### Sprint 3 — Polish (P2)
1) Newsletter trust microcopy  
2) Floating safe-area collision fix  
3) Radius/Shadow consistency audit

## PHASE 6-C) Phase Gate — Acceptance Criteria (Phase 2-yə keçid şərti analoqu)
**Phase 5 smoke-test keçid şərti (minimum):**
- 3 dil × 2 theme × əsas ölçülər (SE 320, 360, 390/414/430, 768, 1366, 1920) screenshot evidence
- P0-lar: (H1 overflow, services grid scroll, navbar focus-within, OG meta, stats 2×2) PASS
- Conflict bəndi (Estimator persistence) **run-time** ilə təsdiqlənir

---

# APPENDIX A) 26-Bəndlik Uyğunluq Audit Cədvəli (Full)
> Burada “Existing Findings”dəki 26-bəndlik cədvəl **təkrarsız** saxlanılıb.

| # | Bənd | Status | Qısa nəticə |
|---|---|:---:|---|
| 1 | Analiz Matrisi | ✅ | 6 kombinasiya + 8K xəritə |
| 2 | İcra Mərhələləri | ✅ | Fazalar üzrə |
| 3 | Bölmə Checklist | ⚠️ | Navbar/Hero/Grid risk |
| 4 | Global Theme | ✅ | dynamic-styles güclü |
| 5 | Dinamika/Admin | ✅ | fallback var |
| 6 | Light/Dark | ✅ | vars + uyğunlaşma |
| 7 | Dil/Tərcümə | ✅ | 280+ keys |
| 8 | Responsivlik | ⚠️ | 320px/8K problem |
| 9 | Ekstrem ölçülər | 🔴 | watch/8K optim yoxdur |
| 10 | Performans/CLS | ⚠️ | lazy load qismən |
| 11 | Accessibility | 🔴 | keyboard nav fail |
| 12 | Cross-browser | 🟡 | webkit qismən |
| 13 | Sessiya davamlılığı | 🟡/**Conflict** | localStorage var ↔ iddia |
| 14 | Print | ❌ | yoxdur |
| 15 | Reduced Motion | ❌/⚠️ | partial |
| 16 | Social preview | 🔴 | OG yox |
| 17 | Custom 404 | ⚠️ | var, amma i18n yox |
| 18 | Offline | ❌ | PWA yox |
| 19 | Skeleton loading | ✅ | portfolio fallback |
| 20 | Color blindness | 🟡 | error states genişləndir |
| 21 | Scrollbar | ❌ | default |
| 22 | SEO/Analytics | ⚠️/❌ | title var, hreflang yox |
| 23 | Security | ✅/⚠️ | XSS ok, API proxy risk |
| 24 | Delighters | ✅ | rocket/particles/glass |
| 25 | Funksionallıq | ✅ | estimator/form |
| 26 | Çıxış formatı | ✅ | bu sənəd |

---

# APPENDIX B) Prioritetlər və Fix Roadmap (Step-by-step)
## TOP 5 P0 (konsolidə)
1) Mobil H1 şrift clamp min ↓ (32px səviyyəsinə)  
2) Services grid `minmax(300px)` → mobile safe (`100%` və ya `280px`)  
3) Navbar A11y: `:focus-within`  
4) Meta/OG + description + hreflang  
5) 404 lokallaşdırma (`__('errors.404')`)

## Addım planı (P0/P1/P2)
### ADDIM 1 (P0)
- Mobil H1 overflow fix
- Services grid + marquee overflow fix
- SEO meta + OG + hreflang
- Cookie banner komponenti (mövcud deyil → əlavə)

### ADDIM 2 (P1)
- Navbar focus-within
- Cursor logic: `@media (hover: hover)` gate
- Session resilience: run-time təsdiq (Conflict resolve)
- 404 i18n

### ADDIM 3 (P2)
- Scrollbar + selection (brend)
- Reduced motion full coverage
- Lazy loading + print styles
- Offline (PWA lite) + API proxy

---

# APPENDIX C) Real Device Deep Dives (full, de-duplicated)
> Bu appendix-də cihazların “detallı analiz” hissələri **bir dəfə** saxlanılıb.

## 1) 320×568 (iPhone SE 1 / 5S) — CRITICAL FAIL
- Grid math: 320 - padding ≈ 288px; min 300px card → horizontal scroll/cutoff
- H1 clamp min 48px → sözlər daşır
- Floating: chat/cookie/back-to-top safe area-ni yeyir
- Fix: `minmax(100%, 1fr)` və ya `minmax(280px,1fr)`; H1 min 32px; floats minimize/off

## 2) 568×320 (Landscape) — CRITICAL FAIL (Verified)
- Content loss + vertical clipping
- `(max-height: 480px)` minimal landscape mode: sticky off, floats off, padding ↓, 2-col istifadə et

## 3) 200×200 (Mini smart display) — CRITICAL FAIL
- H1 40–48px → oxunmaz
- grid 300px → fiziki uyğunsuz
- floats ekranın 40%+ tutur
- Fix: micro layout, H1 1.5rem, floats OFF, gap/padding ↓

## 4) 100×100 (Watch) — CRITICAL FAIL
- Micro layout: yalnız logo + 1 cümlə + 1 CTA; qalan hər şey hide

## 5) 240×320 (JioPhone 2 / KaiOS) — FAIL
- Root causes: min-width guards, ES6 bundle/polyfills, clamp/flex-gap fallbacks
- Fix: XS0 overrides, compressed variant, legacy support

## 6) 412×915 (S20 Ultra) — P0 bug
- Stats 3+1 orphan → force 2×2
- 412px width unused → 2-col adapters
- Android toolbar dynamic → safe padding

## 7) 430×932 (iPhone 14 Pro Max) — P0 risk
- safe-area inset, dynamic island overlap, `100vh` glitch risk
- Fix: env(safe-area-*) + height strategy

## 8) 600×1024 (BB PlayBook) — PASS
- 2-col grid aktiv; hamburger ok; typography rahat

## 9) 360×780 (Huawei P30 Pro) — PASS (Baseline)
- Tall viewport win; 360px width grid üçün “safe boundary”

---

## Son qeyd (bu merged sənəd üçün “burda var hamsı?” cavabı)
Bəli — iki raportdakı bütün **unikal** bölmələr bu sənəddə saxlanıldı:
- Mobile-first qaydalar (Phase 6 blokunun hamısı) → PHASE 3-C/D/E
- 15-point UI/UX audit → PHASE 2-B (tam 1–15)
- Developer-ready sprint specs + sprint plan → PHASE 6-A/B
- Phase 1 kod evidence (fayl/sətir) → PHASE 1-C
- 26-point audit → Appendix A
- Real device deep dives → Appendix C
- Roadmap addım 1–3 → Appendix B
- Ziddiyyət (Estimator persistence) → “Conflict” etiketi ilə saxlanıldı, Phase 5 smoke-test ilə bağlanır
