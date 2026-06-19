# Red Dot Master Report (Bütün Mətnlər Ardıcıllıqla)

Bu fayl **bütün mərhələlərin vahid qeydi** kimi istifadə olunur. Buradan sonra bütün əlavələr bu fayla yazılacaq.

---

# 1) Comprehensive Plan (comprehensive_red_dot_analysis.md)

# Chalang /preview: Red Dot Standartlarına Uyğun Yekun Analiz Planı

Bu sənəd **plan + əlavə hesabat mətnidir**. Hələlik heç bir kod icrası və dəyişiklik edilmir.

## 0. Məqsəd və Əhatə
- **Əhatə:** yalnız `/preview` ana səhifə.
- **Dil:** AZ, EN, RU ayrıca yoxlanır.
- **Rejim:** Light və Dark ayrıca yoxlanır.
- **Məqsəd:** dizayn bütövlüyü, brend uyğunluğu, UI/UX, dinamika, responsivlik, performans və yarış standartları.

## 1. Analiz Matrisi
- **Dil x Rejim:** 3 dil x 2 rejim = 6 əsas kombinasiya.
- **Ölçülər:** 100x100 (watch), 320x568, 360x640, 768x1024, 1366x768, 1440x900, 1920x1080, 3840x2160, 7680x4320 (8K).
- **Məqsəd:** hər kombinasiya üzrə "kritik" və "təhlükəli" qüsurların aşkarlanması.

## 2. İcra Mərhələləri (Analiz Prosesi)
- **Mərhələ 1:** Bölmələri siyahıya bölmək, test matrisi yaratmaq.
- **Mərhələ 2:** Hər bölməni Light/Dark + AZ/EN/RU ilə yoxlamaq.
- **Mərhələ 3:** Responsivlik və ekstrem ölçülər (watch/8K) üçün ayrıca baxış.
- **Mərhələ 4:** Dinamika və admin bağlılıq testi.
- **Mərhələ 5:** Performans, A11y, cross-browser, SEO, cookie/analytics audit.
- **Mərhələ 6:** Tapıntıları prioritetləşdirmək və düzəliş yol xəritəsi çıxarmaq.

## 3. Bölmə-bölmə Analiz Checklisti

### Navbar
- **Vizual:** rəng, glass görünüş, ikon ölçüsü, logo uyğunluğu.
- **UX:** klik hədəfləri, sticky davranışı, scroll zamanı sabitlik.
- **İnteraksiya:** hover/active state ardıcıllığı.
- **Dil:** menu label uzunluqları.
- **Rejim:** light/dark kontrast.
- **Responsiv:** mobil nav, overflow riski.

### Hero
- **Vizual:** başlıq ölçüsü, gradient, hero art balansı.
- **UX:** CTA prioriteti, baxış axını.
- **İnteraksiya:** button hover/focus/active.
- **Dil:** uzun başlıqların layout təsiri.
- **Rejim:** text contrast və glow balansı.
- **Responsiv:** 360px və 100x100 fallback.

### Marquee / Slogan xətti
- **Vizual:** opacity, contrast, ritm.
- **UX:** oxunurluq, diqqət yayındırma riski.
- **Dil:** mətnin təkrarı və qırılması.
- **Rejim:** light/dark visibility.
- **Responsiv:** mobil sıxlıq.

### Services (Biz nə edirik?)
- **Vizual:** kart radiusu, border, shadow uyğunluğu.
- **UX:** məlumat sıralaması, scanability.
- **İnteraksiya:** hover state, ikon animasiyası.
- **Dil:** başlıq/desc uzunluğu.
- **Rejim:** card contrast.
- **Dinamika:** admin-dən gələn kontent uyğunluğu.

### Metrics (Statistikalar)
- **Vizual:** rəqəm vurğusu, rəng balansı.
- **UX:** rəqəm + label oxunurluq.
- **Dil:** label uzunluğu.
- **Rejim:** text/number kontrastı.
- **Responsiv:** grid qırılması.
- **Dinamika:** admin dəyərləri düzgün düşürmü.

### Process (Necə işləyirik?)
- **Vizual:** xəritə tonu, hotspot görünüşü.
- **UX:** addım ardıcıllığı, anlaşılırlıq.
- **İnteraksiya:** step aktivliyi, tooltip.
- **Dil:** hər addımın mətni.
- **Rejim:** map fonu oxunurluğu.
- **Dinamika:** map_points və step data admin bağlılığı.
- **Responsiv:** hotspotlar sürüşmürmü.

### Team
- **Vizual:** foto crop, card hover.
- **UX:** rol və ad oxunurluğu.
- **Dil:** ad/rol uzunluğu.
- **Rejim:** contrast.
- **Responsiv:** grid sındırması.

### Estimator (Qiymət Hesablayıcı)
- **Vizual:** panel tonu, rəng ardıcıllığı.
- **UX:** slider, seçim feedback, nəticə aydınlığı.
- **Dil:** label və placeholder uzunluğu.
- **Rejim:** contrast.
- **Dinamika:** admin qiymət matrisinin işləməsi.

### Portfolio / Case Studies
- **Vizual:** şəkil ratio, overlay.
- **UX:** hover CTA, click area.
- **Dil:** title uzunluğu.
- **Rejim:** overlay contrast.
- **Responsiv:** grid sıxlığı.

### Testimonials
- **Vizual:** kart ölçüsü, avatar görünüşü.
- **UX:** slider behavior.
- **Dil:** mətn uzunluğu.
- **Rejim:** contrast.

### FAQ
- **Vizual:** accordion forması, divider.
- **UX:** açılma rahatlığı.
- **Dil:** sual/cavab uzunluğu.
- **Rejim:** focus state.

### Blog
- **Vizual:** cover ratio, meta data.
- **UX:** oxuma axını.
- **Dil:** title overflow.
- **Rejim:** contrast.

### CTA / Contact
- **Vizual:** input, button ardıcıllığı.
- **UX:** form flow, error state.
- **Dil:** placeholder və label düzgünlüyü.
- **Rejim:** input contrast.
- **Dinamika:** admin textləri.

### Footer
- **Vizual:** column balansı, link ardıcıllığı.
- **UX:** linklərin təkrarı.
- **Dil:** translation düzgünlüyü.
- **Rejim:** contrast.

### Cookie/Consent
- **Vizual:** modal/strip layout.
- **UX:** düymələrin toqquşmaması, seçim aydınlığı.
- **Dil:** AZ/EN/RU mətn uyğunluğu.
- **Rejim:** görünürlük.

### Global UI Elementlər
- **Vizual:** floating buttonlar, scroll-to-top, cursor.
- **UX:** click blocking riski.
- **Rejim:** görünürlük.
- **Responsiv:** mobil behavior.

## 4. Global Theme (Fərdi Dizayn Tənzimləmələri)
- **Rəng override:** bütün sectionlarda işləyirmi.
- **Font override:** heading/body tam tətbiq olunurmu.
- **Radius/glow:** komponentlərin hamısında vahiddirmi.
- **Admin dəyişimi:** dərhal frontda təsir edirmi.

## 5. Dinamika və Admin Bağlılıq
- **Contenttext key-lər:** hər section üçün tam dinamikdirmi.
- **Fallback:** boş data olduqda düzgün davranış.
- **Dil:** locale dəyişəndə mətn düzgün map olunurmu.

## 6. Light/Dark Uyğunluğu
- **Kontrast:** text/background, border visibility.
- **Effektlər:** glow/blur balansı.
- **Hover/Active:** eyni hissiyat varmı.

## 7. Dil və Tərcümə (AZ/EN/RU)
- **Bütün CTA, başlıq, placeholder:** tam tərcümə?
- **JS-də mətn:** locale üzrə dəyişirmi.
- **Uzun mətn riski:** layout pozulurmu.

## 8. Responsivlik
- **Mobil:** nav, card, form sıxlığı.
- **Tablet:** grid qırılması.
- **Desktop:** boşluq balansı.
- **Ultra-wide:** max-width və boşluqlar.

## 9. Ekstrem Ölçülər Planı
- **Watch mode (100x100):** ultra-minimal fallback (logo + 1 CTA).
- **8K:** font və spacing scale, max-width artırma, grid genişləndirmə.
- **Goal:** hər ölçüdə "pozulma yox, məqsədli fallback".

## 10. Performans və CLS
- **FOUT/FOIT:** font yükü.
- **AOS/JS:** render stabilik.
- **Ağır media:** lazyload ehtiyacı.

## 11. Accessibility (A11y)
- **Keyboard nav:** focus visible.
- **ARIA/alt:** uyğunluq.
- **Contrast ratio:** minimum standartlar.

## 12. Cross-Browser
- **Safari/Firefox:** blur/backdrop/sticky davranışı.
- **Mobile browsers:** iOS/Android fərqləri.
- **Font rendering:** fərqli anti-aliasing təsiri.

## 13. Sessiya Davamlılığı (Resilience)
- **Estimator seçimləri:** səhifə refresh (F5) olduqda localStorage ilə bərpa olunurmu.
- **UX təsiri:** seçimlərin qorunması premium hissiyat yaradır.

## 14. Çap Versiyası (Print Styles)
- **Print görünüşü:** Ctrl+P zamanı oxunaqlılıq və layout sabitliyi.
- **Dark mode riski:** qara fonlar çox mürəkkəb sərf edə bilər.

## 15. Motion Sensitivity (Reduced Motion)
- **prefers-reduced-motion:** animasiyalar avtomatik sönürmü.
- **A11y:** epilepsiya/baş gicəllənməsi risklərinə qarşı uyğunluq.

## 16. Sosial Paylaşım Görünüşü (Social Preview)
- **Open Graph:** WhatsApp/Telegram/LinkedIn üçün title/desc/hero düzgün çıxırmı.
- **Dinamiklik:** admin dəyişsə OG metadata yenilənirmi.

## 17. Xüsusi 404 Səhifəsi (Custom Error Page)
- **Brend uyğunluğu:** standart "Not Found" yox, branded 404 varmı.
- **UX detalı:** yaradıcı/interactive element münsiflər üçün üstünlükdür.

## 18. Offline Rejim (Network Resilience)
- **Offline mesaj:** internet kəsiləndə xüsusi bildiriş varmı.
- **PWA ehtimalı:** service worker və fallback page nəzərdən keçirilir.

## 19. Skeleton Loading (Sümüklər)
- **Loading state:** ağ ekran əvəzinə skelet placeholderlar.
- **Psixoloji sürət:** istifadəçi "tez yüklənir" hiss edir.

## 20. Rəng Korluğu Testi (Color Blindness)
- **Error states:** yalnız qırmızıya bağlı yox, ikon/tekst vurğusu var.
- **Contrast:** UI elementlər rəng korları üçün ayırd edilirmi.

## 21. Custom Scrollbar
- **Brand uyğunluğu:** scrollbar saytın purple/pink vizual dili ilə uyğundurmu.
- **Platform fərqi:** Windows/Chrome görünüşü ayrıca yoxlanır.

## 22. SEO / Analytics / Cookie
- **Meta/OG:** title/desc.
- **Hreflang:** 3 dil üçün.
- **Consent gating:** analytics bloklanması.

## 23. Security / Robustness
- **XSS:** rich-text render.
- **Error states:** form submit, boş data.

## 24. Delighters & Experiments (Task.md ID-ləri ilə)
- **Sound UX / Sonic Branding** (id: 225, id: 711): hover/klik/step dəyişimi üçün incə SFX, istifadəçi üçün mute toggle, default off.
- **Micro-interactions** (id: 361, id: 184): vahid animasiya kitabxanası + GSAP/Lottie mikro-jestlər (külək effekti, "liquid press" düymə reaksiyası).
- **Easter Egg Mode** (id: 714): gizli trigger (Konami kodu və ya logo 10 klik) + xüsusi vizual rejim.
- **Storytelling Scroll / Scrollytelling** (id: 184): scroll axını ilə hekayə, hero raketin bölmələr arasında vizual bələdçi kimi davranması.
- **Time-Aware Hero / Smart Personalization** (id: 712): timezone əsaslı salamlaşma ("Sabahın xeyir, [Şəhər]") və dinamik tema variantı.
- **PWA Offline Sync** (id: 217): oflayn davranış və data sinxronu.
- **Skeleton Loading** (id: 70): loading state skeletləri.
- **AI Persona & Empty State** (id: 534, id: 230): tone-of-voice və boş səhifə məzmunu.

## 25. Funksionallıq və Məzmun Dərinliyi
- **Lead Magnet Test** (id: 638): "Website Audit" düyməsi, animasiya müddəti və data ötürülməsi.
- **Exit-Intent** (id: 255): mouse yuxarı gedəndə popup/təklif çıxırmı.
- **Copywriting (AIDA)** (id: 179): mətnlər sadəcə doğru yox, həm də "satıcıdırmı".

## 26. Çıxış Formatı (Yekun Raport)
- **Bölmə -> Tapıntı -> Severity (High/Med/Low)**
- **Səbəb -> Təsir -> Təklif**
- **Light/Dark + AZ/EN/RU ayrı qeyd**

---

## Əlavə A - 9-bəndlik Analiz Hesabatı (sənin göndərdiyin mətn)

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

# 2) Phase 1 Report (red_dot_phase1_report.md) [ORIGINAL]

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

# Phase 3 — Responsivlik və Ekstrem Ölçülər (Kod səviyyəsində)
**Status:** Tamamlandı (kod audit)
**Metod:** CSS breakpoints və layout qaydalarının analizi

## 3.1 Breakpoint xəritəsi
- **Sübut:** `public/assets/css/chalang-preview.css:216, 323, 722, 1109, 1314, 2618, 3145, 3163, 3440`
- **Breakpoints:** 575px, 640px, 768px, 900px, 991px, 1150px.

## 3.2 Kiçik ekran riskləri (320px/360px)
- **Grid min-width:** `.grid { minmax(300px, 1fr) }` → 320px-də overflow riski.  
  **Sübut:** `public/assets/css/chalang-preview.css:1192-1194`
- **Hero başlıq:** `clamp(2.5rem, 5vw, 4.5rem)` → 360px-də böyük.  
  **Sübut:** `public/assets/css/chalang-preview.css:1019-1020`
- **Service hero başlıq:** `clamp(3rem, ...)` → subpage mobil risk.  
  **Sübut:** `public/assets/css/chalang-preview.css:2072-2073`

## 3.3 Ultra-wide (4K/8K) riskləri
- **Max-width:** çoxlu bölmələr 1200px ilə limitlənir.  
  **Sübut:** `public/assets/css/chalang-preview.css:1013, 1173, 1601, 2852`
- **Nəticə:** 8K ekranlarda böyük boşluq qalır; əlavə breakpoint lazımdır.

## 3.4 Watch mode (100x100)
- Watch üçün xüsusi media/variant yoxdur (CSS-də belə breakpoint görünmür).  
- **Nəticə:** "Logo + 1 CTA" fallback hələ implement edilməyib.

### 3.4.1 Canlı görüntü testi (100x100) [Light + Dark]
- **Müşahidə:** Oxunaqlılıq praktik olaraq yoxdur; H1/CTA/metrics kəsilir və üst-üstə düşür.
- **Layout:** Bloklar mikro eni qəbul etmir; mətnlər hecalara bölünür, kartlar sığmır.
- **UI chrome:** floating ikonlar (chat/back-to-top/cookie) 100x100 sahəni bloklayır.
- **Nəticə:** 100x100 üçün ayrıca "micro layout" tələb olunur (yalnız logo + 1 CTA).

### 3.4.2 Canlı görüntü testi (200x200) [Light + Dark]
- **Müşahidə:** 100x100-dən yaxşıdır, amma yenə istifadəolunmazdır.
- **Typography:** H1 clamp min dəyəri yüksəkdir; sətirlər parçalanır.
- **Grid:** `minmax(300px, 1fr)` > 200px olduğuna görə kartlar fiziki sığmır.
- **UI chrome:** floating düymələr məzmunu boğur.
- **Nəticə:** 200x200 üçün də micro layout lazımdır (burger nav, 1 column, mini fontlar).

## 3.5 Kiçik mobil (320x568) - vizual test
**Referans cihaz:** iPhone SE (1st gen) / iPhone 5/5S.
- **Hero:** Başlıq çox sıxdır; CTA-lar yaxın və sətirlər qırılır.
- **Navbar:** Logo + mərkəzi menyu + sağ aksiyalar 320px-də sıx görünür; hit-area riski.
- **Marquee:** vizual səs-küy yaradır, hero mətni ilə rəqabət aparır.
- **Metrics:** 4 kart bir sırada oxunaqlılığı azaldır; 2x2 grid daha uyğundur.
- **Process xəritə:** hotspot + text sıxlaşır; mobil üçün "vertical timeline" daha uyğundur.
- **Estimator:** panel və control-lar sıx görünür; tam stack variantı daha rahatdır.
- **Footer:** newsletter input və linklər dar enə görə sıxılır.

## 3.6 Telefon landscape (568x320) - vizual test [Light + Dark]
**Referans cihaz:** iPhone SE/5 landscape.
- **Hero blok:** hündürlüyü çox alır; short-height (320px) səbəbilə fold-da az informasiya görünür.
- **Fold görünüşü:** ilk ekranda faktiki olaraq yalnız hero + statistika görünür; digər əsas bölmələr görünmür və "boşluq" hissi yaradır.
- **CTA sətri:** 3 düymə yan-yana yerləşir, amma yuxarı boşluqlar böyükdür; hero spacing azaltmaq lazımdır.
- **Layout istiqaməti:** tam single-column qalır; landscape genişliyi istifadə olunmur.
- **Metrics kartları:** hələ tək sütunda və böyükdür; landscape-də 2 sütun/kompakt kart lazım olur.
- **Footer:** genişlikdən istifadə etmir, linklər yuxarı-aşağı düşür; landscape-də 2-3 sütun daha uyğun olar.

## 3.7 Telefon landscape (640x360) - vizual test [Light + Dark]
**Referans cihaz:** Note II landscape (640x360).
- **Fold/height:** 360px hündürlük səbəbilə hero blok yenə də fold-u çox tutur; əsas bölmələr aşağıda qalır.
- **Genişliyin istifadəsi:** layout hələ də single-column görünür; landscape enindən real faydalanmır.
- **Marquee/hero art:** başlıq+art birlikdə çox yer tutur, vizual yük yüksəkdir.
- **Metrics kartları:** böyük və uzun; landscape-də 2 sütun kompakt kart daha münasib görünər.
- **Estimator:** panel yığcam deyil; landscape üçün “stack + compact” variant daha rahat olar.

## 3.8 Kiçik mobil (360x640) - vizual test [Light + Dark]
**Referans cihaz:** tipik Android (360x640).
- **Hero:** 320x568-dən yaxşıdır, amma başlıq/CTA hələ sıxdır.
- **Services kartları:** iki sütuna düşdüyü üçün kart içi mətnlər çox dar görünür; oxunaqlılıq azalır.
- **Process xəritə:** 01-04 addımlar sığır, amma yazılar çox yaxın; mobil üçün sadələşdirilmiş xəritə/timeline daha uyğundur.
- **Estimator:** iki panel hələ də yanaşı görünür; 360px-də tam stack variantı daha balanslıdır.
- **Footer:** əsasən işləkdir, amma link blokları çox sıx görünür.



## 3.9 Tablet Portrait (600x1024) - vizual test [Light + Dark]
**Referans cihaz:** BlackBerry PlayBook (600x1024).
- **Ümumi görünüş:** Layout mobilə nisbətən rahatdır; hero 2-sütun görünür, amma H1/CTA hələ də sıx hiss edilir.
- **Biz nə edirik? kartları:** 2 sütunlu düzülüş oxunur; kart içi mətnlər 2-3 sətirə düşür, padding bir az dar görünür.
- **Metrics:** 2x2 grid rahatdır, oxunaqlılıq yaxşıdır.
- **Process:** xəritə + addımlar 600px-də sıx görünür; mobilə yaxın "vertical timeline" variantı yenə daha uyğundur.
- **Estimator:** iki sütun (kontroller + qiymət kartı) görünür, amma toxunma sahələri sıxdır; 600px üçün stack variantı daha stabil olar.
- **Form/CTA:** form sahələri yan-yana qaldıqda dar hiss olunur; bu ölçüdə tək sütuna düşürmək UX-i yaxşılaşdırar.

## 3.10 Tablet Landscape (1024x600) - vizual test [Light + Dark]
**Referans cihaz:** BlackBerry PlayBook (1024x600).
- **Fold/height:** 600px hundurlukde hero + marquee cox pay tutur; ilk ekranda mezmun az gorumur, vertikal padding azaltmaq lazimdir.
- **Genislik istifadesi:** 1024px eninde multi-column grid balanslidir; services/metrics/blog kartlari rahat oxunur.
- **Process:** xerite genislikden yaxsi istifade edir, amma alt metn bloklari hundurluyu artirir; daha yigcam variant dusunule biler.
- **Estimator:** iki sutun layout burada uygundur; pricing paneli aydin gorunur.
- **Footer:** coxsutunlu duzulus mumkundur, amma hundurluk mehdudlugu sebebile sixliq hiss olunur.

## 3.11 Huawei P30 Pro Portrait (360x780) - vizual test [Light + Dark]
**Referans cihaz:** Huawei P30 Pro (360x780).
- **Hero/CTA:** H1 oxunur, amma CTA-lar bir setirde six gorumur; gap/padding azaltmaq lazimdir.
- **Navbar:** burger + aksiyalar sixlasmadan yerlesir, amma hit-area 44px minimumu yoxlanmalidir.
- **Biz ne edirik? kartlari:** tek sutun duzulusde oxunaqlidir; metnler sixdir, vertical spacing artirmaq olar.
- **Metrics:** 2x2 grid rahat gorumur; oxunaqliliq yaxsidir.
- **Process:** xerite + 01-04 addimlar hele de sixdir; mobil ucun sadelesdirilmis timeline daha uygundur.
- **Estimator:** kontrollerler ve price paneli sixisir; touch target-ler boyudulmelidir.
- **Light/Dark:** light rejimde xırda metn kontrasti bir az zeif gorumur; dark rejimde oxunaqliliq daha stabildir.
- **Actionable fix (P30 Pro 360x780):** Hero H1 minimumunu ~2.2rem et, vertikal padding-i ~20-30% azalt; CTA-lari 1 sutuna stack et, gap-i kicilt; 360px-de services/metrics-i tek sutuna indir, navbar hit-area-larini 44px saxla; process ucun mobil timeline variantini defolt et; estimator panellerini stack et.

## 3.12 Huawei P30 Pro Landscape (780x360) - vizual test [Light + Dark]
**Referans cihaz:** Huawei P30 Pro (780x360).
- **Fold/height:** 360px hundurlukde hero + marquee cox yer tutur; ilk ekranda mezmun az gorumur, vertikal padding azaltmaq lazimdir.
- **Hero layout:** iki sutun gorunus genislikden yaxsi istifade edir, amma hundurluk mehdudlugu sebebile bloklar sixlasir.
- **Services/Metrics:** multi-column duzulus oxunur, lakin kartlarin hundurluyu yigcamlasdirilmalidir.
- **Process:** xerite genislikde rahatdir, amma metn bloklari hundurluyu artirir; kompakt variant lazim ola biler.
- **Estimator:** iki sutun horizontal balanslidir, amma panel hundurluyu boyukdur; spacing azaltmaq lazimdir.
- **Actionable fix (P30 Pro 780x360):** Hero/CTA padding-ini azal dib fold-u ac; CTA/gap-lari kompaktlasdir; 780x360-da services/metrics-i 2 sutuna endir, kart hundurluyunu yigcamlasdir; process metnini qisa formaya kecir; estimator panelini bu breakpointde stack et.

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

# 6C - Mobil (320-430 en; portrait + landscape) ucun umumilesdirme
- **Hero:** H1 min clamp ~2.2rem, vertikal padding 20-30% az; primary + secondary CTA, mobilde stack; fold-da 1-2 trust signal saxla (logo/score).
- **Gridler:** 320-375 eninde tek sutun; 390-430 eninde yalniz qisa kartlar 2 sutuna; metrics/portfolio/faq kartlarina min-width vermeden, gap-i 16-24px saxla.
- **Process/Xerite:** Mobil defolt timeline/stack; xerite kicik overview kimi saxla/yasa; hotspot tap-target >=44px.
- **Estimator:** Mobil defolt stack; preset + "Custom" axini; netice kartina "Aylig araliq / daxildir-daxil deyil / minimum muddet / start tarixi" konteksti elave et.
- **Navbar/CTA:** Hit-area >=44px; mobil sticky bottom bar (primary CTA + elaqe).
- **Spacing/Fon:** 8pt spacing sistemi (8/16/24/32), section padding mobil 48-64px; watermark/particle opacity-ni azaldib metn zonalarinda sakit fon saxla.
- **Tip/kontrast:** Body >=16px, line-height 1.45-1.6; secondary >=14px; dark-da overlay ile kontrasti artir.

# 6E - Developer-ready task list (P0/P1/P2, mobil baseline 360px; test 320/390/414)
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















