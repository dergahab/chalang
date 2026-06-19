# Chalang /preview: Red Dot Standartlarına Uyğun Yekun Analiz Planı

Bu sənəd **plan + əlavə hesabat mətni**dir. Hələlik heç bir kod icrası və dəyişiklik edilmir.

## 0. Məqsəd və Əhatə
- **Əhatə:** yalnız `/preview` ana səhifə.
- **Dil:** AZ, EN, RU ayrıca yoxlanır.
- **Rejim:** Light və Dark ayrıca yoxlanır.
- **Məqsəd:** dizayn bütövlüyü, brend uyğunluğu, UI/UX, dinamika, responsivlik, performans və yarış standartları.

## 1. Analiz Matrisi
- **Dil × Rejim:** 3 dil × 2 rejim = 6 əsas kombinasiya.
- **Ölçülər:** 100×100 (watch), 320×568, 360×640, 768×1024, 1366×768, 1440×900, 1920×1080, 3840×2160, 7680×4320 (8K).
- **Məqsəd:** hər kombinasiya üzrə “kritik” və “təhlükəli” qüsurların aşkarlanması.

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
- **Responsiv:** 360px və 100×100 fallback.

### Marquee / Slogan xətti
- **Vizual:** opacity, contrast, ritm.
- **UX:** oxunurluq, diqqət yayındırma riski.
- **Dil:** mətinin təkrarı və qırılması.
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
- **UX:** addım ardıcıllığı, anlaşılma.
- **İnteraksiya:** step aktivliyi, tooltip.
- **Dil:** hər addımın mətni.
- **Rejim:** map fonu oxunurluğu.
- **Dinamika:** map_points və step data admin bağlılığı.
- **Responsiv:** hotspotlar sürüşürmü.

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
- **Watch mode (100×100):** ultra-minimal fallback (logo + 1 CTA).
- **8K:** font və spacing scale, max-width artırma, grid genişləndirmə.
- **Goal:** hər ölçüdə “pozulma yox, məqsədli fallback”.

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
- **Brend uyğunluğu:** standart “Not Found” yox, branded 404 varmı.
- **UX detali:** yaradıcı/interactive element münsiflər üçün üstünlükdür.

## 18. Offline Rejim (Network Resilience)
- **Offline mesaj:** internet kəsiləndə xüsusi bildiriş varmı.
- **PWA ehtimalı:** service worker və fallback page nəzərdən keçirilir.

## 19. Skeleton Loading (Sümüklər)
- **Loading state:** ağ ekran əvəzinə skelet placeholderlar.
- **Psixoloji sürət:** istifadəçi “tez yüklənir” hiss edir.

## 20. Rəng Korluğu Testi (Color Blindness)
- **Error states:** yalnız qırmızıya bağlı yox, ikon/tekst vurğusu var.
- **Contrast:** UI elementlər rəng korları üçün ayırd edilirmi.

## 21. Custom Scrollbar
- **Brand uyğunluğu:** scrollbar saytın purple/pink vizual dili ilə uyğunmu.
- **Platform fərqi:** Windows/Chrome görünüşü ayrıca yoxlanır.

## 22. SEO / Analytics / Cookie
- **Meta/OG:** title/desc.
- **Hreflang:** 3 dil üçün.
- **Consent gating:** analytics bloklanması.

## 23. Security / Robustness
- **XSS:** rich-text render.
- **Error states:** form submit, boş data.

## 24. Delighters & Experiments (Task.md ID-ləri ilə)
- **Sound UX / Sonic Branding** (id: 225, id: 711): hover/klik SFX + mute toggle (default off).
- **Micro-interactions** (id: 361, id: 184): vahid animasiya kitabxanası + GSAP/Lottie mikro-jestlər.
- **Easter Egg Mode** (id: 714): gizli trigger + xüsusi vizual rejim.
- **Time-Aware Hero** (id: 712): timezone əsaslı salamlaşma/tema variantı.
- **PWA Offline Sync** (id: 217): oflayn davranış və data sinxronu.
- **Skeleton Loading** (id: 70): loading state skeletləri.
- **AI Persona & Empty State** (id: 534, id: 230): tone-of-voice və boş səhifə məzmunu.

## 25. Funksionallıq və Məzmun Dərinliyi
- **Lead Magnet Test** (id: 638): “Website Audit” düyməsi, animasiya müddəti və data ötürülməsi.
- **Exit-Intent** (id: 255): mouse yuxarı gedəndə popup/təklif çıxırmı.
- **Copywriting (AIDA)** (id: 179): mətnlər sadəcə doğru yox, həm də “satıcı”dırmı.

## 26. Çıxış Formatı (Yekun Raport)
- **Bölmə → Tapıntı → Severity (High/Med/Low)**
- **Səbəb → Təsir → Təklif**
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