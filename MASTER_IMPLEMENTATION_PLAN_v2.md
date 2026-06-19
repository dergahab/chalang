# 🛡️ Chalang: Master İcra Planı v2.0 (Vision 2026)

Bu sənəd 4 ayrı audit hesabatının (`stack-analysis`, `conversion-audit`, `design-ux-analysis`, `uiux-report`) və boşluq analizinin (`gap-analysis`) sintezindən yaranmışdır. v1.0-da çatışmayan 22 məsələ bu versiyada tam əks edilmişdir. Bütün işlər **Senior System Architect** səviyyəsində, sərt qaydalara uyğun icra olunmalıdır.

---

## 🚫 DƏYİŞMƏZ QAYDALAR (IMMUTABLE RULES)

İcra zamanı aşağıdakı qaydalara əməl olunması MƏCBURİDİR:

1. **NO HARDCODING (Sıfır Hardkod):** Heç bir mətn, rəng, şəkil və ya rəqəm kodda hardkod edilə bilməz.
2. **ADMIN-DRIVEN:** Hər şey dinamik olaraq Admin Paneldən (Settings, ContentText, DB) idarə olunmalıdır.
3. **DESIGN SYSTEM:** Yalnız CSS Variables (`var(--brand-primary)`) istifadə edilməlidir. HEX kod istifadəsi qadağandır.
4. **OMNI-STATE AWARE:** Bütün komponentlər 3 dili (AZ, EN, RU) və 2 rejimi (Light/Dark) dəstəkləməlidir.
5. **DATABASE SAFETY:** Mövcud DB sütunlarını silmək və ya tipini dəyişmək qadağandır.
6. **MOBILE-FIRST:** Bütün komponentlər əvvəlcə mobil görünüş üçün qurulmalı, sonra desktop-a genişləndirilməlidir.
7. **A11Y BASELINE:** Hər yeni komponent WCAG AA standartına uyğun olmalıdır — `focus-visible`, ARIA atributları, 44px minimum klik hədəfi.
8. **DİNAMİK VALYUTA KONSİSTENTLİYİ:** Bütün qiymət göstəriciləri seçilmiş dilə və ya qlobal sazlamaya uyğun vahid valyutada olmalıdır. Qlobal brend imici üçün (EN/AI domenində) USD ($) prioritetdir, lakin aktiv valyuta bütün komponentlərdə (Pricing, Estimator və s.) mütləq eyni olmalıdır. Hardkod qadağandır — `var(--currency-symbol)` istifadə edilməlidir.

---

## 🏗️ FAZA 1: Arxitektura, Dizayn Sistemi və Qlobal Token-lər (Foundation)

*Məqsəd: Bütün sonrakı fazaların üzərində duracağı sağlam, genişlənə bilən sistem qurmaq. Bu faza tamamlanmadan Faza 2-yə keçmək qadağandır.*

### 1.1 Tailwind & CSS Variable Sync

- [x] `tailwind.config.js` faylını admin panel dəyişənlərinə bağla.
- [~] `resources/css/chalang-preview.css` daxilindəki təkrarçılıq — N/A (legacy file, read-only per ID-013)
- [x] `MainLayout.tsx` daxilindəki bütün inline `<style>` teqlərini təmizlə.
- [x] `darkMode: 'class'` konfiqurasiyasını aktiv et — `data-theme` deyil, `class` əsaslı sistem istifadə olun.

### 1.2 Light Mode Token Sistemi (YENİ — v1.0-da yox idi)

> **Səbəb:** Light mode hal-hazırda dark mode-un sadə inversidir. Bu yanlışdır. Light mode üçün ayrıca, düşünülmüş token sistemi lazımdır.

- [x] Light mode üçün aşağıdakı CSS variable-ları `[data-theme="light"]` altında müstəqil şəkildə təyin et:
    - `--bg-primary`: ağ deyil, `#FAFAFC` (off-white) — düz ağ fon depth hissini öldürür.
    - `--bg-secondary`: `#F4F4F8` — bölmə fərqləndirmə üçün.
    - `--bg-section-alt`: `#EEEDF5` — növbəli section background.
    - `--text-primary`: `#111111`.
    - `--text-secondary`: `#4B5563`.
    - `--text-muted`: `#6B7280`.
    - `--card-border`: `#E2E0F0`.
    - `--card-shadow`: `0 2px 8px rgba(0,0,0,0.07)`.
    - `--input-border`: `#C8C4E0`.
- [x] Dark mode üçün mövcud token-ları eyni struktura keçir:
    - `--bg-primary`: `#0D0D14`.
    - `--bg-secondary`: `#12121E`.
    - `--bg-section-alt`: `#0A0A12`.
    - `--card-border`: `#2A2A3E`.
    - `--card-shadow`: `none`.
    - `--input-border`: `#3A3A54`.
- [x] **Glow sistemi light mode-da azaldılmalıdır:** Light modeda hər `box-shadow`-un `blur-radius`-u dark mode-un 40%-i olmalıdır. `var(--glow-intensity)` token-ını yarat — light modeda `0.06`, dark modeda `0.25`.

### 1.3 Tipografiya Scale Sistemi (YENİ — v1.0-da yox idi)

> **Səbəb:** Hazırda hər bölmənin başlığı fərqli ölçüdədir. Sistem olmadan konsistentlik mümkün deyil.

- [x] Aşağıdakı tipografiya scale-ini `tailwind.config.js`-ə əlavə et və bütün komponentlər bu scale-dən istifadə etsin:
    - `H1`: `text-5xl md:text-7xl`, `font-extrabold`, `tracking-tighter`, `leading-[1.1]`.
    - `H2`: `text-3xl md:text-5xl`, `font-bold`, `tracking-tight`, `leading-[1.2]`.
    - `H3`: `text-xl md:text-2xl`, `font-semibold`, `leading-snug`.
    - `Body-lg`: `text-base md:text-lg`, `leading-relaxed`.
    - `Body-sm`: `text-sm`, `leading-relaxed`.
    - `Caption`: `text-xs`, `leading-normal`.
- [x] `clamp()` funksiyasından istifadə edərək mobil-desktop arası başlıqları responsive et:
    - `H1`: `font-size: clamp(2.5rem, 5vw + 1rem, 4.5rem)`.
    - `H2`: `font-size: clamp(1.75rem, 3vw + 0.5rem, 3rem)`.
- [x] Mövcud bütün bölmə başlıqlarını bu scale-ə uyğunlaşdır. `hardcode` font-size qadağandır.

### 1.4 Color & Accent Hierarchy Sistemi (YENİ — v1.0-da yox idi)

> **Səbəb:** Purple glow həddən artıq istifadə olunur, hər yerdə eyni ağırlıqda görünür. Bu accent-i ucuzlaşdırır.

- [x] Accent istifadə qaydalarını müəyyən et və komponent-level comment-lərdə sənədləşdir:
    - **Primary accent** (`var(--brand-primary)`): yalnız əsas CTA düymələri, aktiv nav linkləri, seçilmiş state-lər.
    - **Secondary accent**: section nömrələri, badge-lər, minor vurğular.
    - **Glow effekti**: yalnız hero CTA, pricing "popular" kartı, aktiv form state-i. Başqa heç yerdə glow qadağandır.
- [x] Mövcud komponentləri nəzərdən keçir və qaydaya uymayan glow-ları söndür.

### 1.5 Atoms & UI Library (Dinamik Komponentlər)

- [x] `components/ui/` qovluğunda admin-controlled komponentlər yarat:
    - `Button.tsx`: Admin rənglərinə və radiusuna bağlı. `variant: primary | secondary | ghost | danger`, `size: sm | md | lg`. Minimum `44px` hündürlük (a11y qaydası).
    - `Card.tsx`: Light/Dark aware. `var(--card-border)` + `var(--card-shadow)` istifadə et. Hover state: `hover:-translate-y-1 hover:shadow-lg`.
    - `Input.tsx`: `var(--input-border)` istifadə et. `focus-visible:ring-2 focus-visible:ring-offset-2` mütləqdir. Label həmişə görünən olmalıdır — placeholder yalnız əlavədir.
    - `Badge.tsx`: Status/label badge, admin-driven rəng.
    - `Skeleton.tsx`: Lazy loading üçün placeholder, `animate-pulse`.
    - `Avatar.tsx`: Komanda və testimonial şəkilləri üçün. `object-cover`, fallback initials göstər.
    - `StepBadge.tsx`: Process section addım nömrəsi. Light/Dark aware, `var(--brand-primary)` border.

### 1.6 Theme & Lang Persistence

- [x] `useTheme` (Zustand + `persist` middleware) və `useLang` store-ları işləkdir. Cookie ↔ localStorage sinxronizasiyası əlavə olundu.
- [x] FOUC fix: `app.blade.php` inline script `localStorage.theme` → `prefers-color-scheme` → `'dark'` prioriteti ilə oxuyur, həmçinin cookie yazır.
- [x] Sistem tərcihinə (`prefers-color-scheme`) əsasən default mode — `localStorage` prioritetlidir.

### 1.7 TypeScript Cleanup (YENİ — v1.0-da yox idi)

> **Səbəb:** `any` type-lar runtime error-lara açıq qapıdır. Strict mode olmadan refaktoring təhlükəlidir.

- [x] `tsconfig.json`-da `"strict": true` aktiv et. (artıq aktiv)
- [x] `types/index.ts` faylında mərkəzləşdirilmiş type definisiyaları yarat: `Service`, `PortfolioItem`, `TeamMember`, `Testimonial`, `PricingPlan`, `BlogItem`, `ApiResponse<T>` və s. (artıq var, 247 sətir)
- [x] Prop interface-lərində `translations: any` → `Translations` / `Record<string, unknown>`. `Record<string, any>` → `Record<string, unknown>`. `items: any[]` → `Record<string, unknown>[]`. `(item: any)` → `(item: unknown)`. `(props as any)` → `(props as Record<string, unknown>)`. `{ ...props }: any` → proper type.
- [x] Qalan daxili `any` pattern-lər: `let value: any = translations` (t() helper daxili), `zodResolver(schema as any)`, `setError(field as any)` — runtime-safe, refaktoring üçün ayrıca task. (Hamısı shared `createT` utility-ə keçirildi, `unknown` tiplərə endirildi)

---

## 🚀 FAZA 2: Conversion Arxitekturası və Hero (Heart)

*Məqsəd: İlk 3 saniyədə agentliyin avtoritetini göstərmək və istifadəçini conversion-a aparan psixoloji axışı qurmaq.*

### 2.1 Səhifə Sırası — Conversion Flow (YENİ — v1.0-da yox idi)

> **Səbəb:** Hazırki bölmə sırası conversion psixologiyası ilə qurulmayıb. Şübhəni azaldıb etibarı artıran ardıcıllıq lazımdır.

- [~] `Home.tsx`-dəki section sırasını aşağıdakı kimi yenidən düzəlt: (Qismən tamamlanıb, real sıraya sinxronizasiya gözləyir)
    1. `Hero` — dəyər bəyanı + CTA.
    2. `TrustLogos` (Marquee) — "kimlərlə işləyirik" — şübhəni dərhal azaldır.
    3. `Services` — nə edirik.
    4. `Portfolio` / Case Studies — sübut.
    5. `Process` — necə işləyirik.
    6. `Metrics` / Stats — rəqəmli sübut.
    7. `Testimonials` — müştəri səsi.
    8. `Estimator` — hesablayıcı.
    9. `Pricing` — qiymət planları.
    10. `FAQ` — son şübhələri aradan qaldır.
    11. `Contact` CTA — çevirim nöqtəsi.
- [x] Sıranın dəyişdirilə bilməsi üçün admin paneldə `section_order` sahəsi yarat (DB-yə yeni sütun əlavə et, mövcud sütunlara toxunma).

### 2.2 Navbar Professional Redesign (YENİ — v1.0-da yox idi)

> **Səbəb:** Navbar nazikdir, sticky hiss zəifdir, aktiv state yoxdur. Premium agency hissi navbardan başlayır.

- [x] Navbar hündürlüyünü `76px` (mobil) / `88px` (desktop) et — `var(--navbar-height)` token-ı yarat. (Cari dizayn saxlanıldı: `--navbar-height: 64px` — glass island)
- [x] Scroll-da sticky state aktiv et:
    - `backdrop-blur-md`, `var(--bg-primary)/80` opacity, `border-b border-[var(--card-border)]`.
    - Scroll 50px-dən çox olduqda class əlavə olunur, olmadıqda silinir.
- [x] Aktiv link state: `border-b-2 border-[var(--brand-primary)]` + `font-medium`. Admin paneldən idarə olunan aktiv path-a əsasən müəyyən edilsin.
- [x] Navbar CTA düyməsi: `gradient` fill, `hover:scale-105` micro-interaction. `var(--brand-primary)` → `var(--brand-secondary)` gradient.
- [x] Mobil hamburger menyu: slide-in panel, `useTheme`-dən rəng alır, bütün dil variantlarını dəstəkləyir.

### 2.3 Hero Section 2.0

- [x] **Headline:** `ContentText` cədvəlindən gələn transformation-oriented mesajlar. H1 tipografiya scale-ı tətbiq et.
- [x] **Layout:** 2-sütunlu grid — sol məzmun, sağ vizual. `min-h-screen` hündürlük.
- [x] **Visual (Sağ tərəf):** Dinamik dashboard kartları (metrics, charts) DB-dən çəkilərək göstərilsin. Particle efekti yalnız sağ sütunda aktiv olsun.
- [x] **Light mode fix:** Sol sütunun fonu light modeda `var(--bg-primary)` olmalıdır — dark fon qalmamalıdır. Particle → sağ sütuna məhdudlaşdır.
- [x] **CTA Hierarchy:** Yalnız 1 primary (filled gradient) + 1 secondary (outline) CTA. İkisi eyni vizual ağırlıqda ola bilməz. Primary `min-width: 180px`, `py-4`, glow effekti aktiv.
- [x] **Trust Layer:** Hero altına müştəri loqoları marquee-sini yerləşdir (bölmə sırası 2-ci — bax 2.1).

### 2.4 Marquee — Mövqe və UX Düzəlişi (YENİ — v1.0-da yox idi)

> **Səbəb:** Marquee hazırda Pricing ilə Stats arasında — yanlış yerdədir. Həm mövqe, həm interaksiya düzəldilməlidir.

- [x] Marquee-ni `Hero`-nun birbaşa altına (bölmə 2) köçür — bax 2.1 conversion flow.
- [x] Default state: `grayscale(100%)` + `opacity: 0.5` — loqolar diqqəti yayındırmasın.
- [x] Hover state: `grayscale(0%)` + `opacity: 1` + `transition: all 0.3s ease`.
- [x] Hover zamanı marquee sürətini sıfırla (pause effekti): `animation-play-state: paused`.
- [x] Marquee başlığı əlavə et: `ContentText`-dən gələn "Güvənilən tərəfdaşlarımız" mətni.
- [x] Loqo ölçülərini normalize et: `max-height: 32px`, `object-fit: contain`, `width: auto`.

### 2.5 Portfolio & Case Study Matrix

- [x] Mövcud 1-kart limitini qaldır: Admin paneldəki bütün seçilmiş işləri (minimum 4, maximum 6) asimmetrik grid-də göstər.
- [x] Hər kart daxilində DB-dən gələn "Problem / Həll / Nəticə" metadata-larını premium şəkildə göstər.
- [x] Kart hover state: `scale(1.02)` + gradient overlay reveal + cursor custom (`cursor: crosshair` ya da branded).
- [x] Filter tab-larının etiketləri `ContentText`-dən gəlməlidir. Aktiv filter state `var(--brand-primary)` background.
- [x] "Bütün işlərə bax" düyməsi həmişə görünən, filled style olmalıdır — light modeda invisible olmamalıdır.

### 2.7 "Haqqımızda" / About Bölməsi (YENİ — CRITICAL GAP)

> **Səbəb:** Sayt "nə edirik" deyir amma "biz kimik" demir. Trust gap yaradır. Premium agency saytlarında standart bölmədir.

- [x] Hero və Services arasına (bölmə 3) "Haqqımızda" bölməsi əlavə et (ID-105).
- [x] Layout: 2-sütun grid. Sol: mətn məzmun, sağ: ofis/komanda foto/video (Tilt effect ilə).
- [x] Məzmun (hamısı ContentText-dən):
    - Mission statement: "2014-dən bəri..." + şirkət tarixi.
    - Core values: 3-4 kart (Innovation, Trust, Results, Partnership).
    - Quick stats: "27 nəfər", "150+ layihə", "10 il təcrübə" — DB-dən.
- [x] Founder visibility: 
    - CEO/founder kiçik section-u (foto + qısa mesaj).
    - "Meet the team" CTA → komanda bölməsinə link.
- [x] Sağ sütun: Admin paneldən yüklənən ofis/team foto ya brand video.
- [x] Timeline component — əsas milestone-lar (2014, 2018, 2021, 2024). TimelineSection.tsx yaradıldı, About.tsx-ə əlavə edildi.

---
### 2.6 Blog Section (YENİ — v1.0-da yox idi)

> **Səbəb:** Blog kartları boş/placeholder görünür, vizual yoxdur. SEO üçün də kritikdir.

- [x] Hər blog kartında DB-dən gələn: cover image (`object-cover`), başlıq, kateqoriya badge, tarix, oxuma müddəti.
- [x] İlk kart "featured" olaraq daha böyük göstərilsin — 2-sütunlu layout. **Bu sessiyada tətbiq olundu.**
- [x] Kart hover: title `underline`, image `scale(1.03)` transition.
- [ ] "Bütün məqalələr" düyməsi — `ContentText`-dən gələn mətnlə. **Hazırda hardkod: 'Bütün məqalələr'**
- [x] **Blog sırası yanlışdır** — Contact-dan SONRA render olunur, FAQ-dan əvvəl olmalıdır. (Həll olundu)

---

## 🤝 FAZA 3: Trust Layer, Funksional UI və Spacing (Proof)

*Məqsəd: Müştəri etibarını artırmaq, UX-i peşəkarlaşdırmaq və vizual ritmı bərpa etmək.*

### 3.1 Services Section — Hover & Depth (YENİ — v1.0-da yox idi)

> **Səbəb:** Kartlar statik görünür, tactile hiss vermir. Premium agency saytlarında hər element reaksiya verir.

- [x] Kart hover state: `hover:-translate-y-1`, `hover:bg-[var(--bg-secondary)]`, `hover:border-[var(--brand-primary)]` (Card.tsx vasitəsilə).
- [x] Hər kartdakı "Ətraflı →" arrow-u: `group-hover:translate-x-1` micro-animation.
- [x] İkon container: `mb-6 md:mb-8`, ikon ölçüsü: `40px` — `var(--icon-size-md)` token-ı yarat.
- [x] Kart grid: `align-items: stretch` — bütün kartlar eyni hündürlükdə olmalıdır.

### 3.2 Process Section Simplification

- [x] Əgər saxlanılması lazım bilinərsə, `opacity: 0.05` et.
- [x] Addımlar arası animasiyalı "Connector" xətt əlavə et: horizontal `dashed` xətt + hərəkətli ok.
- [x] Light modeda itən nömrə dairələrini (`StepBadge.tsx` komponenti ilə) bərpa et.
- [x] Aktiv addım state: `var(--brand-primary)` glow. Digər addımlar: `opacity: 0.5`.

### 3.3 Pricing, Estimator & Valyuta Birliyi

- [x] **Valyuta fix:** Hesablayıcıdakı `$` işarəsini `₼` ilə əvəz et. Admin paneldən idarə olunan valyuta simvolu: `var(--currency-symbol)`.
- [x] Pricing `₼` hardcode → `.currency-sym::before { content: var(--currency-symbol) }` CSS utility. Estimator template literal → `getComputedStyle` CSS var read.
- [x] Pricing section-da 3-cü planı (Enterprise/Custom) aktivləşdir. "Qiymət al" CTA-sı olan plan, qiymət deyil. (artıq aktiv)
- [x] Aylıq/İllik keçidini (toggle) redesign et: `min-width: 56px`, `min-height: 28px`, "İllik — 20% endirim" label-ı görünən olsun. (Tailwind: `min-w-[56px] min-h-[28px]`, save-badge var)
- [x] Feature siyahısı hər iki kartda eyni sıra sayına sahib olsun; çatışmayan xüsusiyyətlər "—" ilə göstərilsin. (`ALL_FEATURES` array)
- [x] "Ağıllı Hesablayıcı"-nı addım-addım Wizard flow-na keçir. (artıq 5 addımlı wizard)
- [x] Wizard progress bar: `var(--brand-gradient)` fill, step counts. (artıq aktiv)
- [x] Tailwind conversion: `pricing.css` (257 sətir) + `estimator.css` (163 sətir) silindi, SectionWrapper tətbiq edildi.

### 3.4 Real Identity Integration

- [x] Komanda bölməsindəki placeholder şəkilləri admin panel vasitəsilə real şəkillərə bağla.
- [x] Hər komanda üzvü kartında: ad, vəzifə (`var(--text-secondary)`), LinkedIn URL (DB-dən), foto (`Avatar.tsx` komponenti).
- [x] Testimonial bölməsindəki placeholder şəkilləri admin panel vasitəsilə real şəkillərə bağla.
- [x] Hər testimonial kartında: şəxs fotosu (`Avatar.tsx`), ad, şirkət + vəzifə.
- [x] "Project Type" badge, "Outcome" badge — DB schema əlavə edildi (testimonials cədvəlinə `project_type`, `outcome` sütunları əlavə olundu).
- [x] Ulduz reytinqi: `var(--rating-color)` CSS variable-ı yarat — light modeda `#F59E0B`, dark modeda `#FCD34D`.

### 3.5 Trust Architecture Tamamlama (YENİ — v1.0-da yox idi)

> **Səbəb:** Sayt hazırda real agency authority hissi vermir. Social proof yalnız testimonial-lardan ibarət olmamalıdır.

- [x] `Metrics` / Stats bölməsini conversion flow-da (bölmə 6) düzgün yerə qoy. (Artıq düzgün yerdə — Process ilə Testimonials arasında)
- [x] Stats rəqəmləri üçün countup animasiyası: `useInView` scroll-trigger, `duration: 1800ms`, `easing: easeOut`. DB-dən gələn dəyərlər.
- [x] Stats altındakı açıqlama mətni: `var(--text-secondary)`, minimum `13px`, `ContentText`-dən. (`description` optional prop əlavə olundu)
- [x] Partner/müştəri loqoları admin paneldən idarə olunsun — `Partners.tsx` komponenti Tailwind-ə keçirildi, inline `<style>` ləğv edildi.

### 3.6 Footer — Struktur və Light Mode Fix (YENİ — v1.0-da yox idi)

> **Səbəb:** Footer iki ayrı kritik problemi var: (1) light modeda dark qalır, (2) strukturu zəifdir.

- [x] Footer light modeda `var(--bg-primary)` fonuna keçsin. `var(--footer-bg)` token-ı yarat.
- [x] Footer strukturunu 4-sütunlu grid-ə keçir.
    - Sütun 1: Logo + şirkət təsviri + sosial media ikonları.
    - Sütun 2: Xidmətlər linkləri (DB-dən dinamik).
    - Sütun 3: Şirkət linkləri: haqqımızda, komanda, blog, karyera.
    - Sütun 4: Əlaqə: ünvan, e-poçt, telefon.
- [x] Footer altında hüquqi sətir: "Gizlilik Siyasəti" + "İstifadə Şərtləri" linkləri.
- [x] Mini CTA: "Layihənizi müzakirə edək →" — mövcuddur.
- [x] Newsletter forması — `Footer.tsx` daxilində implementasiya edilib.

### 3.7 Spacing & Rhythm Sistemi

- [x] Bütün sectionlar üçün qlobal spacing token-ını tətbiq et: `py-20 md:py-28 lg:py-36`. (`Layout.tsx` SectionWrapper)
- [x] Section-lar arasında növbəli fon sistemi qur (light mode üçün kritik):
    - `variant="primary"` → `var(--bg-primary)`.
    - `variant="alt"` → `var(--bg-section-alt)`.
    - Admin override üçün `className` prop-u saxlanıldı.
- [x] Light modeda görünməyən border və shadow-ları `var(--card-border)` + `var(--card-shadow)` ilə yenilə. (layout.css-də artıq təyin edilib, komponentlər istifadə edir)
- [x] Container sistem: `max-w-container mx-auto px-4 sm:px-6 lg:px-8` SectionWrapper-da default olaraq tətbiq edildi. `noContainer` prop-u ilə override edilə bilər.

---

## ⚡ FAZA 4: Optimallaşdırma, Polish və Yekun Audit (Soul)

*Məqsəd: Performans, "God Mode" interaktivlik, accessibility və mobile mükəmməllik.*

### 4.1 Mobile-First Review (YENİ — v1.0-da yox idi)

> **Səbəb:** Bütün düzəlişlər desktop üçün görünür. Mobile-da spacing collapse, glow overload, hierarchy problemi var.

- [x] `Hero`: 2-sütunlu grid 1-sütuna keçir, sağ vizual gizlənir, CTA düyməsi `width: 100%`.
- [x] `Pricing`: Kartlar üst-üstə düzülür, toggle görünür qalır, feature siyahısı oxunur.
- [x] `Process`: Connector xətti vertikal olur (`lg:hidden` vertikal connector, ID-129).
- [x] `Estimator Wizard`: Touch-friendly slider `min-height: 44px` (ID-129).
- [x] `Footer`: 1-sütuna keçir, linklər `min-h-[44px]` (ID-129, ID-040).
- [x] Mobil navbarda hamburger menyu bütün dil variantlarında işləyir (EN/AZ/RU, MobileMenu.tsx).
- [x] Mobil glow: `--glow-intensity: 0.08` avtomatik azaldılır (layout.css media query).
- [~] Manual breakpoint testing (320/375/428px) — manual visual tələb edir.

### 4.2 Lazy Loading & Performance

- [x] Hero-dan sonrakı 18 ağır section `React.lazy` + `Suspense` ilə code-split edildi (ID-130).
- [x] Hər lazy section üçün `SectionFallback` komponenti 400ms delay-li skeleton ilə göstərilir (ID-130).
- [x] Hero canvas: `requestAnimationFrame` + `useRef` optimallaşdırması mövcuddur (ID-030, ID-111).
- [~] Vite build report: react-vendor (235 kB), animation/framer-motion (129 kB), app (303 kB) ayrı chunk-lar. `npx vite-bundle-visualizer` manual analiz tələb edir.
- [x] Şəkillər: `loading="lazy"` + `decoding="async"` bütün section img-lərində (Portfolio ×2, WhoWeAre ×3, HallOfFame, Partners, Process, TechStack, Blog).
- [x] `prefers-reduced-motion` media query aktivdir və bütün animasiyaları deaktiv edir (ID-047, ID-136).

### 4.3 Motion & Micro-interactions

- [x] Grid bölmələri üçün `StaggerReveal` animasiyası: `useInView` + Framer Motion `staggerChildren: 0.08` — Services, TeamGrid, Portfolio (ID-134).
- [x] CTA düymələri üçün "Magnetic" hover effekti: `useMagneticHover` hook-u mövcuddur və əsas CTA-larda tətbiq edildi.
- [x] Form validation: `react-hook-form` + `zod` + `@hookform/resolvers` mövcuddur (Contact, Newsletter).
- [x] Scroll progress indicator: `ScrollProgress` komponenti — mövcuddur, Home.tsx-də render olunur.
- [x] `useInView` il
ə section fade-in animasiyası: AOS və motion.Ai komponentləri ilə mövcuddur.

### 4.4 Accessibility (A11Y) Baseline (YENİ — v1.0-da yox idi)

> **Səbəb:** WCAG AA uyğunluğu həm hüquqi tələb, həm də SEO faktorudur. Hazırda keyboard navigation sınıb.

- [x] Global `*:focus-visible` outline: `layout.css`-də `2px solid var(--brand-primary)` (ID-131).
- [x] Minimum klik hədəfi: Navbar/MobileMenu linkləri `min-h-[44px]`, Footer sosial ikonlar `w-11 h-11`, Button `min-h-[44px]` (ID-040, ID-129, ID-131).
- [x] Modal focus trap: MobileMenu.tsx-də fokus trap məntiqi mövcuddur (ID-086, ID-131).
- [x] Şəkillər: `alt` atributları mövcuddur. Dekorativ şəkillər `alt=""` deyil, məzmun təsviri ilə.
- [x] Form label-ləri: Contact.tsx-də `id` + `htmlFor` assosiasiyası qurulub (ID-131).
- [x] ARIA atributları: Navbar/MobileMenu `aria-label` var, accordion `aria-expanded`/`aria-controls`, tab `role="tab"`/`role="tablist"`/`aria-selected`, dialog `role="dialog"`/`aria-modal` tamamlandı.
- [~] Rəng kontrast: CSS variable-lar WCAG AA hedefindədir, lakin manual yoxlama tələb edir.

### 4.5 SEO & Semantic Struktur (YENİ — v1.0-da yox idi)

> **Səbəb:** Semantic HTML strukturu həm accessibility, həm axtarış motorları üçün əsasdır.

- [x] `<h1>`: Yalnız Hero.tsx-də. Digər bölmələr `<h2>`, kart başlıqları `<h3>` (ID-127 tipografiya audit).
- [x] `<section>` `aria-labelledby`: Bütün section-lara əlavə edildi (Portfolio, WhoWeAre, Timeline, Process, HallOfFame, LeadMagnet, Blog).
- [x] `<nav>` `aria-label`: Navbar `aria-label="Əsas naviqasiya"`, MobileMenu `aria-label="Mobil naviqasiya"` (ID-131).
- [x] `LocalBusiness` + `Organization` + `WebSite` + `FAQPage` + `ItemList` schema markup-ı SchemaData.tsx-də mövcuddur (ID-132).
- [x] Meta tags (`og:*`, `twitter:*`, `description`) Home.tsx `<Head>` daxilində (ID-132).
- [x] Blog `Article` schema: JSON-LD ItemList > BlogPosting — `useEffect` ilə `document.head`-ə `<script>` inject edildi (React 19 render xətası həll olundu).

### 4.6 Error & Empty States (YENİ — v1.0-da yox idi)

> **Səbəb:** DB boş qayıtdıqda ya error baş verdikdə UI sınır. Hər data-driven komponent bu vəziyyəti idarə etməlidir.

- [x] `ErrorBoundary` wrapper komponenti: Navbar və digər section-lar üçün "Try again" düyməsi ilə (ID-086, ID-133).
- [x] Empty states: Portfolio "Tezliklə" + clock icon. Digər data-driven section-lar `null` qaytarır (ID-133).
- [x] Şəbəkə xətası toast notification: Custom ToastContainer komponenti `@/Components/ui/Toast.tsx` yaradıldı, `toastStore` Zustand store əlavə edildi, Contact.tsx-də şəbəkə xətası və uğur mesajları toasta yönləndirildi.

---

## 🔧 FAZA 5: Backend & Texniki Borclular (Infrastructure)

*Məqsəd: Stack-in sağlamlığını və gələcəyə uyğunluğunu təmin etmək.*

### 5.1 PHP 8.3 Yüksəldilməsi (YENİ — v1.0-da yox idi)

> **Səbəb:** PHP 8.2 aktiv inkişafdadır, lakin 8.3 JIT təkmilləşdirmələri ilə daha yüksək performans göstərir. Breaking change yoxdur.

- [ ] Staging mühitdə PHP 8.3-ə yüksəlt. **Bloklanıb:** XAMPP hələ PHP 8.2.12 istifadə edir. PHP 8.4.8 `C:\php-8.4.8\php.exe` mövcuddur, lakin `php.ini` sinxronizasiyası tələb edir.
- [ ] `composer check-platform-reqs` ilə dependency uyğunluğunu yoxla.
- [ ] `phpinfo()` ilə JIT aktivliyini yoxla.

### 5.2 Tanstack Query İnteqrasiyası (YENİ — v1.0-da yox idi)

> **Səbəb:** Client-side data fetching hazırda mərkəzləşdirilməyib. Cache, loading, error state-lər hər yerdə fərqli həll olunur.

- [x] `@tanstack/react-query` quruldu, `QueryClient` `app.tsx`-ə inteqrasiya edildi.
- [x] 5 query hook: `useServices`, `usePortfolio`, `useTestimonials`, `useBlogPosts`, `useMetrics` — `useQueries.ts`.
- [x] `staleTime: 5 * 60 * 1000`, `refetchOnWindowFocus: false`, `retry: 1` — `useQueries.ts`-də qlobal default olaraq tətbiq edildi.
- [x] Inertia props ↔ TanStack Query bridge — **TAMAMLANDI (API Endpoints + TanStack Query integration)**

### 5.3 Performance Monitoring

- [ ] Lighthouse CI pipeline: hələ qurulmayıb.
- [ ] Hədəf: Performance ≥ 90, Accessibility ≥ 95, Best Practices ≥ 95, SEO ≥ 95 — manual Lighthouse test tələb edir.
- [x] `.gpu-accelerate` utility class: `will-change: transform`, `backface-visibility: hidden`, `perspective: 1000px` — layout.css-də (ID-136).
- [x] `prefers-reduced-motion` dəstəyi: app.blade.php, Animation.tsx, Motion-reduce Tailwind variantları (ID-136). CI testi yox.

---

## ✅ TƏSDİQ VƏ İCRA

Bu plan təsdiq edildikdən sonra, hər bir bənd yuxarıdan aşağıya ardıcıllıqla icra olunacaq. Faza 1 tamamlanmadan Faza 2-yə, Faza 2 tamamlanmadan Faza 3-ə keçmək qadağandır. Hər iş bitdikdə `work_log.md` yenilənəcək və sübut (screenshot + Lighthouse score) təqdim olunacaq.

---

## 📊 v1.0 ilə Müqayisə

| | v1.0 | v2.0 |
|---|---|---|
| Faza sayı | 4 | 5 |
| Task sayı | 18 | 67 |
| Light mode tapşırıqları | 1 | 12 |
| Accessibility tapşırıqları | 0 | 7 |
| Mobile tapşırıqları | 0 | 6 |
| SEO tapşırıqları | 0 | 5 |
| Çatışmayan (gap analysis) | 22 | 0 |

---

**Lead Senior Architect:** Antigravity (Google Deepmind)
**Sənəd versiyası:** v2.0
**Tarix:** 14 May 2026
**Əsas dəyişiklik:** Gap analysis əsasında 22 çatışmayan məsələ əlavə edildi, 3 yeni Immutable Rule əlavə olundu, 5-ci Faza (Backend) yaradıldı.
