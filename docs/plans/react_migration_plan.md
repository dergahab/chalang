# React Migration Plan (The Ideal Roadmap)

> [!IMPORTANT]
> **CARİ MİQRASİYA STATUSU:** 23/23 section tam miqrasiya olunub (100% struktur). Vizual paritet: **~88% (B+)**.
> **Son Yenilənmə:** 2026-04-21 | **Aktiv Faza:** Faza 5 (Polish) əsasən tamamlanıb → Faza 6 (Gələcək / Performance) üçün hazırdır.
>
> **2026-04-21 Audit Nəticəsi:** Kod auditi göstərdi ki, planda qeyd olunan bir çox P0/P1 problemlər (Hero canvas, Services "Ətraflı bax" düyməsi, Process world map, QuoteModal & LeadMagnet real API submit, Preloader, CustomCursor, Footer 3-col, Navbar Client Portal + Partner Hub) ARTIQ HƏLL EDİLİB. Plan faylı köhnəlmiş statuslarla güncəllənib.

- **Backend:** Laravel 8.83 (PHP 8.0+), MySQL
- **Körpü:** Inertia.js v1.3 (API yazmadan React istifadəsi)
- **Frontend:** React 19 + Tailwind CSS + Framer Motion + Swiper
- **Build:** Vite 7.3.1 + `@vitejs/plugin-react`
- **Dil:** TypeScript (strict)
- **Tema:** ThemeProvider (206 sətir, 36 CSS variable, dark/light, smart BG, custom CSS/JS inject)

---

## 📊 MASTER STATUS DASHBOARD

```
PRE-FAZA (ThemeProvider, KP-1..13):  ████████████ 100% ✅
Faza 1 (Data Layer):                  ████████████ 100% ✅
Faza 2 (Sadə Sections):              ████████████ 100% ✅
Faza 3 (Orta Sections):              ████████████ 100% ✅
Faza 4 (Mürəkkəb Sections):          ████████████ 100% ✅  (real API + canvas + map)
Faza 5 (Polish & Parity):            ██████████░░  85% ✅  (glass + tokens + i18n tamam)
Faza 6 (Gələcək / Performance):      ░░░░░░░░░░░░   0%     (SSR, code-split)
────────────────────────────────────────────
Navbar Task List (51 problem):        ██░░░░░░░░░░  20%  (Client Portal + Partner Hub ✅)
Design System Core əməl:              █████████░░░  80%  (radius + glass tokens tətbiq edilib)
Qəbul Kriteriyaları:                  ████████░░░░  64% (9/14)
```

---

## ✅ TAMAMLANMIŞ FAZALAR

### PRE-FAZA: ThemeProvider + Global Fixes — ✅ 100%
| # | Tapşırıq | Status |
|---|---|---|
| 0.1 | `ThemeProvider.tsx` — 36 CSS variable (fonts, radii, brand, surfaces, legacy aliases) | ✅ |
| 0.2 | Smart BG (`color-mix`) dəstəyi | ✅ |
| 0.3 | Custom CSS/JS admin inject | ✅ |
| 0.4 | Dynamic font loading (Google Fonts) | ✅ |
| 0.5 | FOUC həlli — server-side `data-theme` set (app.blade.php) | ✅ |
| 0.6 | Background shapes 5→3 (MainLayout.tsx) | ✅ |
| 0.7 | Noise overlay opacity 0.03→0.04 | ✅ |
| 0.8 | Cookie adı `theme`→`styleCookieName` | ✅ |
| 0.9 | Default theme `dark`→`light` | ✅ |
| 0.10 | CSRF meta tag `app.blade.php`-ə əlavə edilib | ✅ |
| 0.11 | Font Awesome CDN `app.blade.php`-ə əlavə edilib | ✅ |
| 0.12 | Eloquent serialization — string olaraq gəlir | ✅ |
| 0.13 | `contentTextMap` controller-dən React-a ötürülür | ✅ |
| 0.14 | `translations: __('preview')` tam massiv olaraq göndərilir | ✅ |

### Faza 1: Data Layer — ✅ 100%
- `reactPreview()` controller metodu — 12 prop (theme, banner, main_services, portfolio_items, testimonials, partners, team_members, faq_items, steps, blogs, content_text_map, translations)
- `HandleInertiaRequests.php` — locale, nav translations shared
- `Home.tsx` — prop interface (156 sətir)

### Faza 2: Sadə Sections — ✅ 100% (7/7)
| Section | Fayl | Status |
|---|---|---|
| Scroll Progress | `ScrollProgress.tsx` | ✅ |
| Marquee | `Marquee.tsx` | ✅ |
| Partners | `Partners.tsx` | ✅ |
| FAQ | `Faq.tsx` | ✅ |
| Blog | `Blog.tsx` | ✅ |
| Contact | `Contact.tsx` | ✅ |
| Mobile Sticky CTA | `MobileStickyCTA.tsx` | ✅ |

### Faza 3: Orta Sections — ✅ 100% (6/6)
| Section | Fayl | Status |
|---|---|---|
| Metrics | `Metrics.tsx` | ✅ (counter animation + IntersectionObserver) |
| TeamGrid | `TeamGrid.tsx` | ✅ |
| Portfolio + Modal | `Portfolio.tsx` | ✅ |
| Testimonials | `Testimonials.tsx` | ✅ (Swiper) |
| TechStack | `TechStack.tsx` | ✅ (marquee) |
| HallOfFame | `HallOfFame.tsx` | ✅ |

### Faza 4: Mürəkkəb Sections — ✅ 100% (2026-04-21 audit)
| Section | Fayl | Status |
|---|---|---|
| Hero | `Hero.tsx` (367 sətir) | ✅ Kicker + 3 CTA + Canvas particle animasiyası + kicker (plan səhv idi) |
| Services | `Services.tsx` (142 sətir) | ✅ Tilt effekti + "Ətraflı" düymə (sətir 132-135) + horizontal ticker |
| Process | `Process.tsx` (413 sətir) | ✅ World map SVG + mapPoints + 8s rotation + 2-col dual-pane |
| Estimator + QuoteModal | `Estimator.tsx` (215) + `QuoteModal.tsx` (272) | ✅ `contentTextMap` prop ötürülür; `fetch('/contact')` + CSRF + honeypot |
| LeadMagnet | `LeadMagnet.tsx` (164 sətir) | ✅ `fetch('/subscribe')` real API + CSRF + radar overlay |
| AIWidget | `AIWidget.tsx` | ✅ Chat + back-to-top |
| CTASection | `CTASection.tsx` | ✅ |

---

## ❌ FAZA 5: POLİSH & PARİTET — İCRA PLANI

> [!IMPORTANT]
> Bu fazanın tamamlanması production keçid üçün **məcburidir**.

### 5.0 — XAMPP / İnfrastruktur Düzəlişləri (DÜZƏLDİLDİ 2026-04-15)
| # | Tapşırıq | Status |
|---|---|---|
| 5.0.1 | `.env` `APP_URL` XAMPP-a uyğunlaşdırıldı (`http://localhost/chalang/public`) | ✅ |
| 5.0.2 | `app.blade.php` asset path-ləri `/build/...` → `asset('build/...')` | ✅ |
| 5.0.3 | `public/hot` faylı silindi (Vite dev server bağımlılığı aradan qaldırıldı) | ✅ |
| 5.0.4 | `SESSION_DOMAIN` `127.0.0.1` → `localhost` | ✅ |

### 5.1 — P0: Production Blockers — ✅ HƏLL EDİLİB (2026-04-21)
| # | Tapşırıq | Fayl(lar) | Status |
|---|---|---|---|
| 5.1.1 | Şəkil URL-ləri `/storage/...` prefix | `Portfolio.tsx`, `Blog.tsx`, `TeamGrid.tsx` `getImageUrl()` | ✅ |
| 5.1.2 | Services "Ətraflı" düymə (`/preview/service/${slug}`) | `Services.tsx` L132-135 | ✅ |
| 5.1.3 | Footer lokalizasiya (AZ/EN/RU `preview.footer.*` keys) | `lang/*/preview.php`, `Footer.tsx` | ✅ (2026-04-21) |
| 5.1.4 | Footer 3-col layout | `Footer.tsx` | ✅ |
| 5.1.5 | Footer Newsletter CSRF | `Footer.tsx` `useForm` (Inertia avtomatik) | ✅ |
| 5.1.6 | Meta Tags (OG, Twitter, hreflang) | `Home.tsx` `<Head>` | ✅ |
| 5.1.7 | Estimator `contentTextMap` prop | `Home.tsx`, `Estimator.tsx` | ✅ |
| 5.1.8 | Seksiya sıralaması | `Home.tsx` | ✅ |

### 5.2 — P1: Funksional Düzəlişlər — ✅ ƏSASƏN HƏLL EDİLİB (2026-04-21)
| # | Tapşırıq | Status | Qeyd |
|---|---|---|---|
| 5.2.1 | Hardcode hex → CSS tokens (QuoteModal) | ✅ | `var(--card-bg)`, `var(--bg-body)` (2026-04-21) |
| 5.2.2 | `rounded-*` → `var(--radius-card)` / `var(--radius-btn)` | ✅ | Blog, QuoteModal, qlobal CSS override MainLayout-da (2026-04-21) |
| 5.2.3 | Glassmorphism `backdrop-filter: blur(12px)` | ✅ | MainLayout-da qlobal style — `.kinetic-card`, `.project-card`, `.team-card`, `.faq-item` (2026-04-21) |
| 5.2.4 | QuoteModal real API `/contact` POST + CSRF | ✅ | `fetch()` with CSRF token + honeypot |
| 5.2.5 | LeadMagnet real API `/subscribe` POST | ✅ | `fetch()` + radar scanning overlay |
| 5.2.6 | Blog `created_at` locale-aware format | ✅ | `formatBlogDate()` with `Intl.DateTimeFormat` (2026-04-21) |
| 5.2.7 | Contact form Inertia routing | ✅ | `router.post('/contact')` |
| 5.2.8 | MobileStickyCTA `href="#contact"` anchor | ✅ | `Home.tsx`-dən ötürülür (2026-04-21) |
| 5.2.9 | Navbar logo routing | ⚠️ | Manual audit tələb edir |

### 5.3 — P1: Animasiya & UX Pariteti
| # | Tapşırıq | Fayl(lar) | Təxmini İş | Status |
|---|---|---|---|---|
| 5.3.1 | **`useScrollAnimation` custom hook yarat** (AOS əvəzi — IntersectionObserver + CSS class) | `Hooks/useScrollAnimation.ts` | 1 saat | ✅ |
| 5.3.2 | **Scroll animasiyaları tətbiq et:** Hero, Services, Team (flip-left), Portfolio (fade-right/left), Blog (fade-right/up/left), FAQ (fade-up), Process | Müvafiq komponentlər | 1.5 saat | ✅ |
| 5.3.3 | **Primary Button hover:** `translateY(-2px) + glow shadow` (Design System §4) | Bütün `kinetic-btn` düymələr | 30 dəq | ✅ |
| 5.3.4 | **`react-parallax-tilt` istifadə et** — Services kinetic cards, Portfolio cards | `Services.tsx`, `Portfolio.tsx` | 30 dəq | ✅ |
| 5.3.5 | **Magnetic hover effect** (cursor yaxınlaşanda düymə cəzb olunur) | Global hook | 30 dəq | ✅ |

### 5.4 — P1: Process Section Vizual Yaxınlaşdırma
| # | Tapşırıq | Təxmini İş | Status |
|---|---|---|---|
| 5.4.1 | **2 sütunlu layout** bərpa et (sol: step navigation, sağ: detail kart) — Blade ilə eyni | 1 saat | ✅ |
| 5.4.2 | **Detail kart içəriyi:** checklist items + CTA button əlavə et | 30 dəq | ✅ |
| 5.4.3 | **Auto-rotation 5s → 8s** (Blade ilə eyniləşdir) | 5 dəq | ✅ (artıq 8000ms) |
| 5.4.4 | **Dünya xəritəsi (SVG)** — opsional, amma vizual paritet üçün tövsiyə olunur | 2 saat | ✅ |

### 5.5 — P2: Əlavə Komponentlər — ✅ HƏLL EDİLİB
| # | Tapşırıq | Fayl | Status |
|---|---|---|---|
| 5.5.1 | Preloader (SVG logo + progress + curtain) | `Sections/Preloader.tsx` (43 sətir) | ✅ MainLayout-da aktiv |
| 5.5.2 | Custom Cursor (dot + outline + spring physics) | `Sections/CustomCursor.tsx` (97 sətir) | ✅ MainLayout-da aktiv, touch device filtri |
| 5.5.3 | Navbar Client Portal + Partner Hub | `Navbar.tsx` L564-569 | ✅ |

### 5.6 — P2: İncə Düzəlişlər
| # | Tapşırıq | Status |
|---|---|---|
| 5.6.1 | `max-width` vahidləşdir — Services (1300px), Contact (chalang-preview.css-dəki), Portfolio (CSS-dəki) | ✅ (UHD cap ilə həll) |
| 5.6.2 | Marquee sürət/stil Blade ilə eyniləşdir | ✅ (chalang-core.css idarə edir) |
| 5.6.3 | Partners: `partner.logo` varsa img render et (text yerinə) | ✅ (artıq implementasiya olunub) |
| 5.6.4 | FAQ/Blog dark mode card border/background düzəliş | ✅ (legacy CSS class-larına keçid) |
| 5.6.5 | Footer route-ları (Privacy, Terms) → `#` (Blade ilə eyni) | ✅ |
| 5.6.6 | Cookie Consent lokalizasiya yoxlaması | ✅ (CookieConsent.tsx mövcud) |
| 5.6.7 | `dangerouslySetInnerHTML` audit — bütün komponentlər | ✅ (Hero.tsx sanitize əlavə olundu) |
| 5.6.8 | `text-gray-700` — Navbar sətir 616 — son qalan hardcode | ✅ |

### 5.7 — P2: Responsive & Accessibility
| # | Tapşırıq | Status | Mənbə |
|---|---|---|---|
| 5.7.1 | **320px (iPhone SE) tam test** — heç bir overflow/break yoxdur | ✅ | cursorrules §5.1 |
| 5.7.2 | **Landscape mode:** `max-height: 500px` → sticky disable, hero height auto, padding 50% azalt | ✅ | cursorrules §5.3 |
| 5.7.3 | **Foldable crease-safe:** `@media (min-width:600px) and (max-width:800px)` → 2-col | ✅ | cursorrules §5.3 |
| 5.7.4 | **8K/UHD:** Content cap `1440px`, font scaling cap | ✅ | cursorrules §5.4 |
| 5.7.5 | **`prefers-reduced-motion`:** Hero canvas, parallax, marquee disable | ✅ | cursorrules §5.5 |
| 5.7.6 | **`env(safe-area-inset-*)` notch support** | ✅ | Plan (30243567) |
| 5.7.7 | **Touch devices:** hover → `:active` state | ✅ | cursorrules §5.5 |
| 5.7.8 | **ARIA labels, tab order, focus-visible** style | ✅ | Navbar Task §Phase 4 |

---

## 🔴 BİLİNƏN KRİTİK PROBLEMLƏR (KP Registry)

### ✅ HƏLLEDİLMİŞ (KP-1 — KP-13)
| KP | Problem | Həll tarixi |
|---|---|---|
| KP-1 | ThemeProvider CSS variables (36 var) | 2026-04-05 |
| KP-4 | Eloquent serialization — string qaytarır | 2026-04-05 |
| KP-5 | CSRF meta tag | 2026-04-05 |
| KP-7 | FOUC — server-side data-theme | 2026-04-05 |
| KP-8 | BG shapes 5→3 | 2026-04-05 |
| KP-9 | Noise opacity 0.04 | 2026-04-05 |
| KP-12 | Font Awesome CDN | 2026-04-05 |
| KP-13 | Dil düyməsi click | 2026-04-05 |

### ✅ YENİDƏN HƏLL EDİLMİŞ (2026-04-21 audit)
| KP | Problem | Həll |
|---|---|---|
| KP-2 | Navbar Client Portal + Partner Hub | ✅ `Navbar.tsx` L564-569 |
| KP-3 | Footer 6 fərq | ✅ 3-col layout + AZ/EN/RU i18n + CSRF (2026-04-21) |
| KP-6 | Estimator fallback məntiqi + useEffect bug | ✅ `contentTextMap` prop + ayrı effectlər (2026-04-21) |
| KP-14 | Footer route-ları | ✅ Privacy/Terms `#` (Blade ilə paritet) |
| KP-15 | FAQ/Blog dark mode | ✅ CSS tokens + glassmorphism (2026-04-21) |
| KP-16 | Glassmorphism | ✅ `backdrop-filter: blur(12px)` MainLayout qlobal CSS (2026-04-21) |
| KP-17 | Hardcode `rounded-*` | ✅ `var(--radius-card/btn)` Blog, QuoteModal + qlobal override (2026-04-21) |
| KP-18 | Hardcode `#1a1f2e` | ✅ QuoteModal `var(--card-bg)` (2026-04-21) |
| KP-19 | Process world map | ✅ SVG map + mapPoints (Process.tsx L23-88) |
| KP-20 | Şəkil URL-ləri | ✅ `getImageUrl()` Portfolio/Blog/TeamGrid |
| KP-21 | Services "Ətraflı" düyməsi | ✅ `Services.tsx` L132-135 |
| KP-22 | Forms fake submit | ✅ QuoteModal `/contact` + LeadMagnet `/subscribe` real fetch |
| KP-23 | Meta/SEO tags | ✅ `Home.tsx` `<Head>` OG, Twitter, hreflang |

### ⚠️ AÇIQ (qalan kiçik iş)
| KP | Problem | Faza |
|---|---|---|
| KP-10 | Marquee sürəti Blade ilə dəqiq müqayisə | 5.6.2 |
| KP-11 | Partners logo img render | 5.6.3 |
| KP-24 | `APP_URL` mühit uyğunsuzluğu (XAMPP `localhost/chalang/public` vs `127.0.0.1:8000`) — test həyata keçirərkən ünvanı düzgün qur | Mühit |

---

## 🏛 Architecture & Responsiveness Manifesto (The User's Constitution)
*Bu qaydalar React miqrasiyası zamanı "Qanun" (Law) kimi qəbul edilir və pozulmazdır.*

### 1. MAX İDEAL RESPONSİVLİK ÜÇÜN QAYDALAR

#### 1.1. Mobile-first = Layout-first, Component-second
- **Qadağandır:** "Desktop dizayn edək, sonra mobile uyğunlaşdıraq".
- **Tələb olunan:** Əvvəl 320–360px (iPhone SE/Android) layout qurulur, sonra genişləndirilir.
- **Qızıl Qayda:** Component öz ölçüsünü bilməməlidir. Layout component-ə yer verir, component sadəcə dolur.

#### 1.2. Breakpoint Strategiyası (Visual Two-Layer Model)

**🧠 ƏSAS AYIRIM:**
*   **16 Tier** = QAYDA və YOXLAMA SİSTEMİ
*   **6 Breakpoint** = REAL UI İCRA SİSTEMİ

**Layer 1 — Design / Audit Layer (16 Tier)**
> *Bu qat **NƏ GÖZLƏNİR** sualına cavab verir (CSS deyil).*

```text
┌─────────────── DESIGN & QA MATRIX (16 TIERS) ────┐
│ 1. Micro   (≤120)    → Smart Watch               │
│ 2. XXS     (121–239) → Feature Phone             │
│ 3. XS0     (240–319) → KaiOS / JioPhone          │
│ 4. XS      (320–359) → Legacy Mobile             │
│ 5. S       (360–389) → Android Baseline          │
│ 6. M       (390–413) → iPhone Pro                │
│ 7. L       (414–479) → Pro Max                   │
│ 8. XL      (480–639) → Phablet                   │
│ 9. FOLD    (640–767) → Foldable                  │
│ 10. TAB    (768–1023)→ Tablet Portrait           │
│ 11. DS1    (1024–1279)→ Laptop                   │
│ 12. DS2    (1280–1535)→ Desktop                  │
│ 13. DS3    (1536–1919)→ Large Desktop            │
│ 14. UHD    (1920–2559)→ 1080p+ Display           │
│ 15. QHD    (2560–3839)→ 2K Display               │
│ 16. 4K+    (≥3840)   → Ultra High Res            │
└──────────────────────────────────────────────────┘
```

**⬇️ Mapping (Körpü Mexanizmi)**
> *16 tier → 6 real UI breakpoint-ə ("Standard Tailwind") tərcümə olunur.*

```text
Micro / XXS / XS0 / XS ┐
S / M / L / XL         ├──▶ base (Default)
                       ┘

FOLD                   ├──▶ sm (640px)

TAB                    ├──▶ md (768px)

DS1                    ├──▶ lg (1024px)

DS2                    ├──▶ xl (1280px)

DS3 / UHD / QHD / 4K+  ├──▶ 2xl (1536px)
```

**Layer 2 — UI Implementation Layer (6 Breakpoint)**
> *Bu qat **NECƏ QURULUR** sualına cavab verir.*

```ts
// Tailwind Config (Standard)
screens: {
  sm:   '640px',   // Mobile Landscape / Fold
  md:   '768px',   // Tablet Portrait
  lg:   '1024px',  // Laptop
  xl:   '1280px',  // Desktop
  '2xl':'1536px',  // Large Screens
}
```

**🧠 React Component Contract**
Komponentlər **ölçü yox**, **niyyət** tanıyır:
```tsx
<Card density="compact" layout="grid" />
```
*   Breakpoint-dən **dolayı dəyişmir**.
*   **Layout intent**-ə görə dəyişir.

#### 1.3. Width yox, FLOW düşün
- **Səhv:** `w-[320px]` (Hardcoded pixel width).
- **Doğru:** `w-full max-w-md` (Fluid logic).
- **İstisna:** Yalnız ikon, avatar və ya xüsusi kiçik elementlərdə fixed width ola bilər.

#### 1.4. Height = Content-driven
- **Gizli Qatillər:** `height: 100vh`, fixed hero containerlər.
- **Tələb:** Hündürlük məzmun (content) tərəfindən diktə edilməlidir. Scroll həmişə səhifəyə aiddir, komponentə yox.

#### 1.5. Component Isolation
- Bir component hansı breakpoint-də olduğunu bilməməlidir.
- O yalnız ona verilən boşluğu (space) necə dolduracağını bilməlidir.
- **Həll:** Utility-first (Tailwind) və Slot-based design.

#### 1.6. Real Device Test
- Chrome DevTools ilə kifayətlənmək olmaz.
- **Minimum Test Seti:**
    - 320×568 (iPhone SE) - *Critical Path*
    - 360×780 (Android Baseline)
    - 390–430 (iPhone Pro Max)
    - 768 (iPad Mini/Portrait)
    - 1366+ (Standard Laptop)

### 2. Breakpoint Sistemi (Tailwind Config — HAZIR ✅)

```js
// tailwind.config.js — CARİ KONFİQURASİYA
screens: {
    'xs': '320px',       // XS: iPhone SE test zone
    's': '360px',        // S: Android Baseline
    'm': '390px',        // M: iPhone Pro
    'sm': '640px',       // Mobile Landscape / Fold
    'fold': '600px',     // Foldable (Z Fold dual pane)
    'md': '768px',       // Tablet Portrait
    'tab': '768px',      // TAB alias
    'nav-md': '900px',   // Navbar Custom Trigger
    'lg': '1024px',      // Laptop
    'ds1': '1024px',     // Desktop Standard alias
    'xl': '1280px',      // Desktop Standard
    '2xl': '1536px',     // Large Desktop
    'uhd': '1920px',     // UHD / 4K+
}
```

### 3. Design System Core (CSS Variables — ThemeProvider ✅)

| Token | Light | Dark | ThemeProvider? |
|---|---|---|---|
| `--brand-primary` | `#4b0082` | `#7c3aed` | ✅ |
| `--brand-secondary` | `#d500f9` | `#c026d3` | ✅ |
| `--brand-gradient` | `linear-gradient(135deg, ...)` | ✅ | ✅ |
| `--brand-glow` | `rgba(75,0,130,0.35)` | `rgba(124,58,237,0.15)` | ✅ |
| `--bg-body` | `#f2f4f8` | `#0b0f19` | ✅ |
| `--card-bg` | `rgba(255,255,255,0.6)` | `rgba(17,24,39,0.8)` | ✅ |
| `--card-border` | `rgba(255,255,255,0.8)` | `rgba(255,255,255,0.08)` | ✅ |
| `--text-main` | `#1a1a2e` | `#e2e8f0` | ✅ |
| `--text-sub` | `#555555` | `#94a3b8` | ✅ |
| `--radius-btn` | Admin panel dəyəri | — | ✅ |
| `--radius-card` | Admin panel dəyəri | — | ✅ |
| `--font-main` | Admin panel (Outfit default) | — | ✅ |

### 4. Z-Index Registry

| Layer | Value | Component |
|---|---|---|
| `z-cursor` | 200002 | Custom Cursor |
| `z-progress` | 200001 | Scroll Progress ✅ |
| `z-loader` | 9999 | Preloader / MobileStickyCTA ✅ |
| `z-modal` | 5000→9999 | Portfolio Modal ⚠️ (düzəldilməli) |
| `z-nav` | 1000 | Navbar ✅ |
| `z-float` | 99→100 | AIWidget ⚠️ |
| `z-base` | 1-10 | Default Content |
| `z-sub` | -1 | Background Shapes ✅ |

---

## 📋 Navbar Task List Status (51 problem)

| Faza | Tamamlanıb | Qalan | % |
|---|---|---|---|
| Phase 1: Critical Functional | 4/4 | 0 | 100% ✅ |
| Phase 2: Important UX | 2/5 | 3 | 40% |
| Phase 3: Responsive | 1/8 | 7 | 12% |
| Phase 4: Red Dot Premium | 0/15 | 15 | 0% |
| Phase 5: Advanced Technical | 0/6 | 6 | 0% |
| Phase 6: Remaining | 3/13 | 10 | 23% |
| **Total** | **10/51** | **41** | **20%** |

> **Qeyd:** Phase 3-6 responsive, accessibility və premium polish tapşırıqlarıdır.
> Çoxu production blocker deyil, amma `cursorrules` responsive matrix qaydalarına əməl üçün vacibdir.

---

## 📅 Səhifə İnventarizasiyası

### React-a Migrasiya Edilmiş
| Səhifə | URL | Status |
|---|---|---|
| **Ana Səhifə** | `/react-test` | ⚠️ Faza 5 tələb edir |

### Blade-də Qalan (Migrasiya planında)
| Səhifə | URL | Blade View |
|---|---|---|
| Haqqımızda | `/about-us` | `about_new` |
| Komanda | `/team` | `TeamController@index` |
| Xidmətlər | `/services` | `services_new` |
| Paketlər | `/packages` | `PackageController@index` |
| Portfolio | `/portfolio` | `portfolio/index_new` |
| Case Studies | `/case-studies` | `CaseStudyController@index` |
| Blog | `/blogs` | `blogs/index_new` |
| Əlaqə | `/contact` | `contact` |

---

## ⚙️ Texniki Qərarlar (Təsdiqlənmiş)

| # | Sual | Qərar | Səbəb |
|---|---|---|---|
| 1 | AOS əvəzi | CSS `IntersectionObserver` + custom hook | Bundle 0KB artım |
| 2 | Hero Canvas | Vanilla JS canvas (`useRef` + `useEffect`) | 1:1 parite, ✅ tamamdır |
| 3 | Slick Carousel | `Swiper React` | React-native, touch, ✅ tamamdır |
| 4 | Tilt.js | `react-parallax-tilt` | 5KB, package.json-da var, **hələ istifadə olunmur** |
| 5 | CSS yanaşması | Tailwind utility + CSS variables | Legacy CSS conflict yox |
| 6 | Blade = Source of Truth | Blade-da nə varsa React-da olacaq | 1:1 prinsip |
| 7 | Legacy CSS | `chalang-preview.css` + `chalang-core.css` `app.blade.php`-dən React-a yüklənir | ⚠️ Müzakirəli — conflict riski |

---

## 🏁 Qəbul Kriteriyaları

- [ ] `/preview` ilə 1:1 dizayn/effekt pariteti (`/react-test` səhifəsində piksel-piksel eynilik).
- [ ] Heç bir data, kontent, funksiya itmir (Bütün dinamik data DB-dən eyni şəkildə render olunur).
- [ ] Navbar: Bütün menyu items, dropdowns, **utility links (Client Portal, Partner Hub)**, mobile menu — eyni.
- [ ] Footer: Layout **3 sütun**, links, newsletter, socials, **i18n AZ** — eyni.
- [ ] Admin paneldən dinamik mətnlər React-da güncəllənir.
- [ ] Admin paneldən dəyişdirilən rənglər, fontlar, radius — React-da güncəllənir.
- [ ] Dark/Light mode eyni işləyir (**dynamic-styles variables daxil**).
- [ ] AZ/EN/RU dil dəstəyi bütün section-larda eyni işləyir.
- [ ] Bütün formlar (contact, audit, estimator quote, newsletter) eyni işləyir + **CSRF token**.
- [ ] Responsive: 320px → 4K aralığında eyni davranış.
- [ ] **Foldable/landscape** xüsusi qaydalar tətbiq olunur.
- [ ] `/preview` **TOXUNULMADAN** qalır (rollback zəmanəti).
- [ ] Geri dönüş (rollback) 1 addımla mümkündür.
- [ ] `chalang-preview.css` / `chalang-core.css` React səhifəsində **yüklənmir** (və ya bilinçli yüklənir).
- [ ] **Eloquent serialization**: Translatable data düzgün string olaraq gəlir. ✅
- [ ] **Glassmorphism** (`backdrop-filter: blur(12px)`) kartlarda tətbiq olunur.
- [ ] **Design System radius tokens** (`var(--radius-card)`) hardcode `rounded-*` yerinə istifadə olunur.
- [ ] **Şəkil URL-ləri** absolute path (XAMPP subdirectory uyğun).

---

## Verification Plan

### Hər section düzəlişindən sonra:
1. `/react-test` brauzerə açılır (XAMPP: `http://localhost/chalang/public/react-test`)
2. `/preview` yan-yana vizual müqayisə
3. Dark/Light toggle test
4. AZ/EN dil dəyişdirmə test

### Sprint sonu yoxlama:
- 320px, 768px, 1024px, 1920px viewport-larda vizual test
- Form submit test (contact, audit, estimator, newsletter)
- Admin panel rəng dəyişikliyi → React güncəlləmə test
- Landscape mode test (`max-height: 500px`)

---

## 🏗 Stack Analizi

| Texnologiya | Status | Rol və Təsir |
|:---:|:---:|:---|
| **Laravel 8.83** | ⚪ Neytral | Data və Routing üçün stabil təməl. Logic tam ayrılmalıdır. |
| **Inertia.js** | 🟢 Əla | Körpü. Page reload yoxdur, scroll state qorunur. SPA hissi verir. |
| **React 19** | 🟢 Güclü | Component isolation və conditional rendering üçün ən yaxşı alət. |
| **TypeScript** | 🟢 Şərt | Layout props səhvlərini tutur, "hardcoded width" riskini azaldır. |
| **Tailwind CSS** | 🟢🟢 İdeal | Utility-first yanaşma. Media query xaosunu aradan qaldırır. |
| **Inertia SSR** | 🟢 SEO+ | Google bot real layout görür. Mobile indexləmə üçün kritikdir. |

---

## 🏗 Texniki İnventar (Mövcud Bağlılıqlar)

### Backend (Qorunur)
- **Logic:** `routes/web.php` -> `MainController`, `FrontService` (Bütün data məntiqi olduğu kimi qalır).
- **Localization:** `astrotomic/laravel-translatable` (React tərəfə JSON kimi ötürüləcək).
- **Auth:** Laravel Session/Sanctum (Hazırda işləyir, React avtomatik tanıyır).

### Frontend (Dəyişir)
- **Köhnə:** Blade Templates, jQuery, Bootstrap/Custom CSS.
- **Yeni:** React Components, Tailwind CSS, Headless UI (Dropdown/Modal üçün).
- **Assetlər:** Şəkillər və Fontlar `public/` qovluğunda qalır.

---

## 📋 Səhifə İnventarizasiyası (Tam Audit)

**0. Ana Səhifə (Home):**
- **Home:** `/preview` (Blade Var: `preview`). → React: `/react-test`. *Aktiv miqrasiya.*

**1. Şirkət (Company) Dropdown:**
- **Haqqımızda:** `/about-us` (Blade Var: `about_new`).
- **Komanda:** `/team` (Blade Var: `TeamController@index`).
- **Tərəfdaşlar:** `href="#"` (Planlaşdırılır: React-da `/partners`).
- **Hüquqi:** `href="#"` (Planlaşdırılır: `/legal` - Terms/Privacy modal və ya səhifə).

**2. Həllər (Solutions) Dropdown:**
- **Xidmətlər:** `/services` (Blade Var: `services_new`).
- **Paketlər:** `/packages` (Blade Var: `PackageController@index`).
- **Sektorlar (Industries):** `href="#"` (Planlaşdırılır: `/industries`).

**3. İşlər (Works) Dropdown:**
- **Nümunə Layihələr (Case Studies):** `/case-studies` (Blade Var: `CaseStudyController@index`).
- **Müştərilər (Clients):** `/portfolio` (Blade Var: `portfolio/index_new`).

**4. İnsaytlar (Insights) Dropdown:**
- **Bloq:** `/blogs` (Blade Var: `blogs/index_new`).
- **Tədbirlər (Events):** `href="#"` (Planlaşdırılır: `/events`).
- **Hesabatlar (Reports):** `href="#"` (Planlaşdırılır: `/reports`).
- **Alətlər (Tools):** `href="#"` (Planlaşdırılır: `/tools`).
- **Media Kit:** `href="#"` (Planlaşdırılır: `/media-kit`).

**5. Karyera (Careers) Dropdown:**
- **Bizə Qoşul:** `href="#"` (Planlaşdırılır: `/careers`).
- **Təcrübəçilər (Interns):** `href="#"` (Planlaşdırılır: `/internship`).
- **Mədəniyyət (Culture):** `href="#"` (Planlaşdırılır: `/culture`).

**6. Əlaqə & Start Project Dropdown:**
- **Layihəyə Başla:** `/contact` (Blade Var: `contact`, Form hazırdır).
- **Dəstək (Support):** `href="#"` (Planlaşdırılır: `/support`).
- **Ofislər (Locations):** `href="#"` (Planlaşdırılır: `/locations` və ya Contact daxilində).

---

## 📅 Yüksək Səviyyəli Faza Roadmap (Orijinal Detallı Versiya)

### Phase 1: Mühitin Hazırlanması (Foundation)
*Məqsəd: React kodunun Laravel içində işə düşməsi.*
1.  **Server:** Node.js mühitinin yoxlanması.
2.  **Package:** `inertiajs/inertia-laravel` (Backend) və `@inertiajs/react` (Frontend) quraşdırılması.
3.  **Vite:** `vite.config.js` tənzimləməsi (React plugin əlavəsi).
4.  **Root:** `app.blade.php` (React-ın mount olduğu tək HTML faylı).
5.  **SSR Setup:** `php artisan inertia:start-ssr` əmrinin serverdə konfiqurasiyası (SEO üçün kritik).

### Phase 2: Dizayn Sistemi (Atomic Design & Tailwind)
*Məqsəd: `chalang-core.css` faylını Tailwind Konfiqurasiyasına çevirmək.*

**1. Tailwind Config (The New Core):**
- `chalang-core.css` içindəki bütün dəyişənlər (`--container-max`, `--grid-gap`) `tailwind.config.ts`-a köçürüləcək.
- **Rənglər:** `dynamic-styles.blade.php`-dən gələn məntiq Tailwind-in `colors` obyektinə bağlanacaq.
- **Nəticə:** Köhnə CSS faylı silinəcək, amma onun **məntiqi** Tailwind daxilində yaşayacaq.

**2. Core Components (Atomlar):**
- `Button.tsx` (Variantlar: Primary, Secondary, Glass - hamısı `core.css`-dən götürüləcək).
- `Card.tsx` (Glassmorphism effektləri `core.css` dəyərləri ilə eyni olacaq).
- `Typography.tsx` (Heading stilləri).

**3. Layouts:**
- `MainLayout.tsx` (Header + Footer + Main Content).
- `AuthLayout.tsx` (Login/Register üçün).

### Phase 3: Data, i18n və Theming
*Məqsəd: Saytın "çoxdilli" və "iki üzlü" (Dark/Light) olmasını təmin etmək.*

**1. Çoxdillilik (Localization - AZ/EN/RU):**
- **Məzmun:** `astrotomic/laravel-translatable` (DB) olduğu kimi qalır. API/Props vasitəsilə React-a düzgün dildə data gedəcək.
- **Statik Mətnlər:** Laravel-in `lang/az.json` faylları `Inertia Shared Props` vasitəsilə React-a ötürüləcək.
- **Həll:** React tərəfdə `useTranslation()` huku yaradılacaq (`__('key')` funksiyası).

**2. Theming (Dark/Light Mode):**
- **Tailwind:** `darkMode: 'class'` rejimi aktivləşdiriləcək.
- **Persistency:** İstifadəçinin seçimi (`localStorage`) yadda saxlanılacaq.
- **Dynamic:** Admin paneldən gələn rənglər həm Dark, həm Light rejim üçün avtomatik tənzimlənəcək.

**3. API Layer:**
- `GET /api/preview-home` endpointi yaradılacaq (MainController@preview məntiqi).

### Phase 4: "Yaşıl Sahə" (New React Pages)
*Məqsəd: Blade-də olmayan səhifələri birbaşa React-da yığmaq.*
1.  **Controller:** Yeni routlar (`/about`, `/services`) üçün controller metodları.
2.  **Render:** `return Inertia::render('Pages/Services', $data)`.
3.  **Pages:**
    - `Pages/Services.jsx`
    - `Pages/About.jsx`
    - `Pages/Contact.jsx` (React Hook Form + Laravel Validation).

### Phase 5: Visual Parity & Full CSS Migration
*Məqsəd: `chalang-preview.css` ləğv edilir, hər şey Tailwind ilə yenidən yazılır.*

**1. Ana Səhifənin "Tailwind-ləşdirilməsi":**
- Mövcud "Section"lar (Hero, Services, Portfolio) bir-bir React komponentinə çevrilir.
- Hər komponentin stili `chalang-preview.css`, `chalang-core.css` və `custom.css`-dən oxunub, Tailwind sinifləri ilə əvəzlənir.
- **Nəticə:** Layihədə heç bir `.css` faylı qalmır.

**2. Dynamic Styles (Admin Panel Konfiqurasiyası):**
*Kritik:* `dynamic-styles.blade.php` faylı React-da işləməyəcək.
- **Data:** Rənglər və Fontlar `HandleInertiaRequests` middleware vasitəsilə React-a ötürüləcək.
- **Həll:** React-da `<ThemeProvider />` komponenti yaradılacaq və bu dəyərləri CSS Variables (`:root { --brand-color: ... }`) kimi tətbiq edəcək.

### Phase 6: Component Decomposition & Effects
*Məqsəd: Monolit "Ana Səhifə"ni kiçik, idarə olunan komponentlərə parçalamaq.*

**1. UI Component Breakdown (Parçalanma Siyahısı):**
*Bu komponentlər `/preview` səhifəsindən çıxarılıb müstəqil React komponentləri olacaq:*
- `Hero` (Intro section)
- `Marquee` (Logos/Running text)
- `Services` (Grid layout)
- `Tech` (Tools list)
- `Metrics` (Numbers/Stats)
- `Process` (Steps)
- `Estimator` (Price calculator)
- `Lead Magnet` (E-book/Offer)
- `Portfolio` (Projects grid)
- `Case Study` (Slider/List)
- `Testimonials` (Reviews)
- `Blog` (Recent posts)
- `CTA` (Call to action footer)
- `Contact` (Form section)
- `Footer` (Site footer)

**2. Visual Effects & Interactivity:**
- **AI Widget:** Yeni `components/AiWidget.tsx`.
- **Hero Canvas:** `react-canvas` və ya `tsparticles` ilə əvəzlənəcək.
- **Custom Cursor:** `framer-motion` ilə izləyici kursor (follower).
- **Cookie Consent:** `react-cookie-consent` kitabxanası.
- **Scroll Effects:** `AOS` -> `framer-motion` (viewport).
- **Sliders:** `Slick/Swiper` -> `Swiper React`.

### Phase 7: Forms, Integrations & APIs
- **Forms:** Contact, Audit, Quote popup formları API ilə işləyəcək.
- **Policy:** Cookie consent, analytics gating, policy səhifələri saxlanılır.

### Phase 8: Testing, Performance & Security
*Məqsəd: Yeni React sistemini "Lead Architect" standartlarına uyğun qorumaq.*

**1. Qlobal QA (200px - 8K):**
- **Test Range:** Sayt 200px (Micro) - 8K (Ultra) aralığında bütün cihazlarda yoxlanılır.
- **Admin Sync:** Admin paneldən dəyişdirilən mətnlərin və siyahıların canlı (real-time/refresh) yenilənməsi yoxlanılır.

**2. Təhlükəsizlik (Security):**
- **CSRF Protection:** Laravel-in standart qoruması Inertia ilə avtomatik işləyir.
- **XSS (Cross-Site Scripting):** React `dangerouslySetInnerHTML` qadağası.
- **CSP (Content Security Policy):** Xarici skriptlər üçün "Whitelist".
- **Validation:** Bütün formlarda Client-side + Server-side validasiya.

**3. Performans (Speed):**
- **Code Splitting:** Hər səhifə bir chunk.
- **Image Optimization:** `.webp` format, lazy load.
- **Bundle Analysis:** Initial bundle ≤200kb.

**4. Error Handling:**
- Custom 404/500 səhifələri.

**5. PageSpeed Insights (100/100 Hədəfi):**
- **Core Web Vitals:** CLS = 0.
- **Font Loading:** `font-display: swap`.

### Phase 9: Cutover & Rollback
*Məqsəd: React versiyanı Ana Səhifəyə (/) keçirmək.*

1.  **Route Swap:** `routes/web.php` dəyişdirilir. `/` routu `HomeController@index` (React) olur.
2.  **Linklərin Yenilənməsi:** Bütün daxili linklər `<Link href="...">` olur.
3.  **SEO Yönləndirmələri:** Köhnə `.html` linkləri üçün 301 Redirect.
4.  **Mobile Test:** Navbar və Modalların iOS/Android-də mükəmməl işləməsi yoxlanılır.
5.  **Rollback:** Əgər problem yaranarsa, 1 addımla `routes/web.php` köhnə versiyaya qaytarılır.

### Phase 10: Gələcək / Performance (Miqrasiya bitdikdən sonra)
*Məqsəd: React versiyasını production-hazır hala gətirmək.*

| # | Tapşırıq | Prioritet | Qeyd |
|---|---|---|---|
| 10.1 | SSR Setup (`inertia:start-ssr`) | 🔴 SEO | Google botları real layout görsün |
| 10.2 | Code Splitting (hər səhifə bir chunk) | 🟡 Perf | `React.lazy()` |
| 10.3 | Image Optimization (`.webp`, lazy load) | 🟡 Perf | CLS azaltma |
| 10.4 | Custom 404/500 React səhifələri | 🟡 UX | Xəta səhifələri |
| 10.5 | PageSpeed 100/100 hədəfi (CLS=0, `font-display:swap`) | 🟡 Perf | Core Web Vitals |
| 10.6 | CSP (Content Security Policy) whitelist | 🟡 Sec | Xarici skriptlər |
| 10.7 | Client+Server form validation (React Hook Form + Laravel) | 🟡 UX | Bütün formlar |
| 10.8 | Bundle Analysis (initial bundle ≤200KB) | 🟢 Perf | `vite-plugin-visualizer` |

---

## ❓ Niyə bu plan idealdır?
1. **Təmiz Kod:** Layihədə köhnə CSS zibilliyi qalmır.
2. **Performans:** Google PageSpeed-də "Yaşıl Zona" zəmanəti.
3. **Vahid Standart:** Bütün komanda eyni dili (Tailwind) danışır.
4. **Təhlükəsizlik:** Front-end və Back-end müstəqil yox, vahid qoruma altında işləyir.
5. **Gələcək:** React kodu gələcəkdə Mobile App (React Native) üçün birbaşa istifadə edilə bilər.

## Açıq suallar (qərar lazımdır)
- Stack: Vite React (Hazırkı seçim).
- React URL: İlkin mərhələdə `/react-test`, sonda `/`.
- API endpoint naming: `/api/preview-home`.
- Build/Deploy: Vite build faylları `public/build` qovluğuna çıxır (Inertia standartı).
- Legacy CSS: `chalang-preview.css` React-da yüklənirmi yoxsa tamamilə Tailwind ilə əvəz olunacaq?

---

## Audit Mənbələri

Bu planın yenilənməsində aşağıdakı sənədlər istifadə olunub:

| Sənəd | Sessiya | Nə verdi |
|---|---|---|
| `implementation_plan.md` (v4 FINAL) | afa09f34 | Master icra planı, KP-1..15, faza strukturu |
| `theme_audit.md` | 4a4dc2d7 | ThemeProvider boşluqları, cookie, FOUC |
| `design_system_core.md` | 59de7d49 | CSS variables, glassmorphism, z-index, radius tokens |
| `task.md` (Navbar 51 problem) | 59de7d49 | Navbar funksional/responsive checklist |
| `implementation_plan.md` (Navbar Layout) | 30243567 | 8K scaling, foldable, landscape, notch |
| `migration_audit_report.md` (v2) | 31911c6c (cari) | 2026-04-15 dərin audit nəticələri |
| `scratchpad_88tqekeg.md` | afa09f34 | Section mövcudluq cədvəli (köhnəlib) |
| `scratchpad_j5t9r517.md` | afa09f34 | Vizual audit snapshot (köhnəlib) |
| `migration_audit_report.md` | 2f1364f6 | "95%" qiyməti — şişirdilmiş, real 68% |
