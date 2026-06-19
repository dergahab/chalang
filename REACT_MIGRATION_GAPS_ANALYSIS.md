# 🔄 CHALANG React Miqrasiyası — Vəziyyət və Boşluqlar Analizi

> **Tarix:** 2026-04-26
> **Kontekst:** Layihə Blade-dən React/Inertia/Tailwind-ə miqrasiya olunur.
> **Köhnə hədəf:** `http://localhost:8000/preview` (Blade — source of truth)
> **Yeni hədəf:** `http://localhost:8000/react-test` (React — 1:1 miqrasiya)

---

## 📊 Cari Status

| Sahə | Status | Detal |
|---|---|---|
| **Stack** | ✅ Quraşdırılıb | Laravel 8.83 + Inertia 1.3 + React 19 + TS strict + Vite 7 + Tailwind 3.4 |
| **Köhnə hədəf** | `/preview` (Blade) | Source of truth |
| **Yeni hədəf** | `/react-test` → `Pages/Home.tsx` (332 sətir) | Aktiv miqrasiya |
| **Component sayı** | 23 section + 10 core | Tam strukturlu |
| **Vizual paritet** | ~88% (B+) öz auditinə görə | Faza 5 əsasən bitib |
| **Səhifə miqrasiyası** | 1/9 (yalnız Home) | About, Services, Portfolio, Blog, Contact, Team, Case Studies, Packages — **hələ Blade** |

### Mövcud React Strukturu

```
resources/js/
├── Pages/
│   └── Home.tsx                    # YALNIZ BU
├── Components/
│   ├── Sections/                   # 23 section
│   │   ├── AIWidget, Blog, Contact, CTASection, CustomCursor,
│   │   ├── Estimator, Faq, HallOfFame, Hero, QuoteModal,
│   │   ├── LeadMagnet, Marquee, Metrics, MobileStickyCTA,
│   │   ├── Partners, Portfolio, Preloader, Pricing, Process,
│   │   └── ScrollProgress, Services, TeamGrid, TechStack, Testimonials
│   ├── Button, Card, CookieConsent, ErrorBoundary, Footer,
│   ├── MobileMenu, Navbar, SearchOverlay, ThemeProvider, Typography
├── Hooks/
│   ├── useMagneticHover, useNavPath, useScrollAnimation,
│   └── useSectionEnabled, useTheme
├── Layouts/
│   └── MainLayout.tsx
├── app.tsx                         # Inertia entry point
└── bootstrap.js
```

---

## 🚨 BOŞLUQLAR (React Miqrasiyası prizmasından)

### 1. 🔴 KRİTİK: Yalnız 1 səhifə miqrasiya olunub

`resources/js/Pages/` qovluğunda **yalnız `Home.tsx`** var. Plana görə miqrasiya olunmalı, amma hələ Blade-də qalan səhifələr:

| Səhifə | Hal-hazırda | Status |
|---|---|---|
| `/about-us` | `about_new.blade.php` | ❌ React-da yoxdur |
| `/team` | `TeamController@index` (Blade) | ❌ |
| `/services` | `services_new` (Blade) | ❌ |
| `/service-detail/{slug}` | Blade | ❌ |
| `/packages` | `PackageController@index` (Blade) | ❌ |
| `/portfolio` | `portfolio/index_new` | ❌ |
| `/portfolio-detail/{slug}` | Blade | ❌ |
| `/case-studies`, `/case-study/{slug}` | Blade | ❌ |
| `/blogs`, `/blog/{slug}` | Blade | ❌ |
| `/contact` | Blade | ❌ |

→ **8/9 səhifə miqrasiyaya hazır deyil** — yalnız Home tamamlanıb.

---

### 2. 🔴 Texniki Borc: Köhnə CSS-lər hələ yüklənir

`react_migration_plan.md` daxilində açıq qalan **KP-7 / Açıq sual**:
> *"Legacy CSS: `chalang-preview.css` React-da yüklənirmi yoxsa tamamilə Tailwind ilə əvəz olunacaq?"*

**Real:** `app.blade.php`-dən React səhifəsinə hələ `chalang-preview.css` + `chalang-core.css` yüklənir. Bu:
- Bundle-i ağırlaşdırır
- Tailwind utility-lərlə **conflict riski** yaradır
- Glassmorphism qlobal CSS override-ları (MainLayout-da inject olunan) `!important` müharibəsinə girir
- Plan §5 hədəfi pozulur: **"Layihədə heç bir `.css` faylı qalmır"**

---

### 3. 🟠 Navbar miqrasiyası 20% (10/51 problem həll olub)

`react_migration_plan.md` "Navbar Task List":

| Faza | Tamamlanıb | Qalan | Detal |
|---|---|---|---|
| Phase 1: Critical Functional | 4/4 ✅ | 0 | i18n, search toggle, logo redirect, careers |
| Phase 2: Important UX | 2/5 ⚠️ | 3 | language switcher polish, theme cookie, ESC, active state |
| Phase 3: Responsive | 1/8 ❌ | 7 | touch target, landscape, foldable, 8K cap, reduced motion, swipe-close, font size |
| Phase 4: Premium | 0/15 ❌ | 15 | Primary CTA, hover transition, React.memo, sticky perf, semantic HTML, ARIA, focus visible, error boundary, loading skeleton |
| Phase 5: Advanced | 0/6 ❌ | 6 | RTL, Safari blur fallback, dark mode flicker, analytics, skip-to-content, GDPR |
| Phase 6: Remaining | 3/13 ⚠️ | 10 | Sub-menu items, Data attributes, Icons |

→ Bu navbar həm köhnə Blade `/preview`-da, həm yeni React-da paralel qoşulmuşdur, lakin **tam paritet yoxdur**.

---

### 4. 🟠 SSR (Inertia Server-Side Rendering) qurulmayıb

Plan §10.1 (P0 SEO blocker):
- `php artisan inertia:start-ssr` aktiv deyil
- Vite SSR config yoxdur
- Google bot-ları React render-ini görmür → **multi-lang SEO ölü** (hreflang/JSON-LD-dən əvvəl bu blocker)
- `Home.tsx`-də `<Head>` meta tag var, amma server-side render olmadan crawler-lər bunu lazımi qədər götürmür

---

### 5. 🟠 Performance / Bundle audit yoxdur

- ❌ **Code splitting** yoxdur — `Home.tsx` 332 sətir + 23 section bir bundle-də (`React.lazy()` istifadə olunmur)
- ❌ **Bundle visualizer** yoxdur (`vite-plugin-visualizer`)
- ❌ **Initial bundle ≤200KB hədəfi** ölçülmür
- ❌ **Image optimization** (`.webp`, lazy load) audit edilməyib — `getImageUrl()` `/storage/` path-ı düzəldib amma format çevirməsi yoxdur
- ❌ **`font-display: swap`** Google Font-larda yoxlanılmayıb (CLS riski)
- ❌ **PageSpeed 100/100 hədəfi** real ölçülmür

---

### 6. 🟠 API Layer / Data Strategy

- `MainController@reactPreview` 12 prop ötürür (theme, banner, services, portfolio, testimonials, partners, team, faq, steps, blogs, content_text_map, translations) — **hamısı Inertia props-la**
- ❌ Plan §3.3 (`GET /api/preview-home` endpoint) yaradılmayıb
- ❌ React Query / SWR yoxdur
- → Hər səhifə yüklənməsində bütün datanı yenidən almaq Inertia üçün normaldır, amma **client-side caching strategy** yoxdur

---

### 7. 🟠 TypeScript Type Safety zəifdir

`Home.tsx`-də interface-lər çoxsaylı `[key: string]: any` ilə doludur:
```ts
interface Service {
    id: number; name: string; description?: string;
    icon?: string; childs?: Service[];
    [key: string]: any;  // ⚠️ tip qoruması itir
}
```
- Eyni problem `Banner`, `PortfolioItem`, `TeamMember`, `Testimonial`, `FaqItem`, `BlogItem` interface-lərində
- **Eloquent → TypeScript type generation** yoxdur (məs. `php artisan typescript:transformer` və ya `spatie/laravel-typescript-transformer`)
- `tsc_output.txt` faylı root-da var → TypeScript errorlar mövcuddur, amma izlənmir

---

### 8. 🟠 Tailwind Konfiqurasiyası natamam

`react_migration_plan.md` §2 hədəfi:
> *"`chalang-core.css` içindəki bütün dəyişənlər `tailwind.config.ts`-a köçürüləcək"*

**Real vəziyyət:**
- `tailwind.config.js` (`.ts` deyil) — 16 tier breakpoint sistemi qismən tətbiq olub
- Brand rənglər `theme.extend.colors`-da yoxdur — yalnız CSS variable kimi (`var(--brand-primary)`)
- → **Tailwind autocomplete brand rəngləri tanımır**, dev experience pisdir
- `chalang-core.css` hələ silinməyib (silinməsi planlanır §5 nəticəsində)

---

### 9. 🟠 Accessibility (a11y) auditı yoxdur

- ❌ **ARIA labels tam audit yoxdur** (Phase 4 problem 928)
- ❌ **Focus-visible style** custom deyil (problem 927)
- ❌ **Skip-to-content link** yoxdur (problem 937)
- ❌ **Tab order** problemi həll edilməyib (problem 926)
- ❌ **WCAG color contrast** yalnız sezgisel — automated audit yoxdur
- ❌ **`prefers-reduced-motion`** Hero canvas və parallax-da var, amma marquee + AIWidget-də yoxdur

---

### 10. 🟠 Form Validation Tam Deyil

| Form | React komponenti | Status |
|---|---|---|
| Contact (QuoteModal) | ✅ `fetch('/contact')` + CSRF + honeypot | ⚠️ Yalnız server-side error handling, **client-side validation yoxdur** |
| Newsletter (LeadMagnet) | ✅ `fetch('/subscribe')` | ⚠️ Eyni — client-side yoxdur |
| Footer Newsletter | ✅ Inertia useForm | ✅ Daha yaxşı |
| Estimator → Quote | ✅ İşləyir | ⚠️ Validation natamam |
| Order Form, Book-a-Call | Blade-də | ❌ Hələ React-də yoxdur |
| Package Inquiry | Blade-də | ❌ |

→ Plan §10.7: "React Hook Form + Laravel" hələ tətbiq olunmayıb (sadə `useState` istifadə edilir).

---

### 11. 🟡 Animasiya kitabxanası inteqrasiyası yarımçıqdır

`package.json`-da:
- ✅ `framer-motion@12.38` quraşdırılıb — istifadə qismən
- ✅ `react-parallax-tilt@1.7` istifadədə (Services + Portfolio)
- ✅ `swiper@12` Testimonials-da
- ❌ **AOS-ı tam əvəz edən system** yoxdur — `useScrollAnimation` hook quraşdırılıb amma legacy `.aos-init` class-lar Blade-dən gələn CSS-dən asılıdır
- ❌ **Magnetic hover** hook (`useMagneticHover`) yaradılıb amma **kifayət qədər tətbiq olunmayıb**

---

### 12. 🟡 i18n (Localization) Strategiyası

- ✅ `astrotomic/laravel-translatable` DB-dən düzgün gəlir
- ✅ `__('preview')` translations Inertia shared props ilə ötürülür
- ✅ Footer i18n keys 2026-04-21 əlavə olundu
- ❌ **Client-side `useTranslation()` hook** — sadədir, amma fallback chain (AZ→EN→key) tam standart deyil
- ❌ **Pluralization** (məs. "1 xidmət" / "5 xidmət") dəstəklənmir
- ❌ **Date formatting locale-aware** yalnız Blog-da var (`Intl.DateTimeFormat`) — digər yerlərdə yoxdur
- ❌ **Number/Currency formatting** yoxdur (Estimator-də manat ₼ hardcode)

---

### 13. 🟡 Dynamic Theme (Admin → React) tam test deyil

ThemeProvider 36 CSS variable dəstəkləyir, amma:
- ⚠️ Admin paneldən rəng dəyişdiriləndə React-də **canlı yenilənmə** yoxdur — page reload tələb olunur
- ⚠️ Custom CSS/JS inject **XSS riski** yarada bilər (Plan §8.2 — `dangerouslySetInnerHTML` qadağası ilə ziddiyət)
- ⚠️ `font_url` (Google Fonts dynamic) `font-display: swap` parametrini əlavə etmir → CLS

---

### 14. 🟡 Cutover Plan (Phase 9) hazırlığı yoxdur

Plan §9 hədəfi: `/react-test` → `/` ana səhifə olaraq dəyişməlidir. Amma:
- ❌ **301 Redirect strategiyası** yazılmayıb (köhnə URL-lər üçün)
- ❌ **Bütün daxili `<a href>` linkləri `<Link href>` (Inertia)** ilə əvəz olunmayıb (Blade səhifələrinə link gedəndə full reload baş verir)
- ❌ **A/B test / Feature flag** yoxdur — kütləvi keçid riski
- ❌ **Rollback prosedurası** sənədləşməyib

---

### 15. 🟡 Test infrastrukturu — React tərəfdə də yoxdur

- ❌ **Vitest / Jest** quraşdırılmayıb (Plan §10 — Faza 6 hədəfi)
- ❌ **React Testing Library** yoxdur
- ❌ **Cypress / Playwright** E2E yoxdur
- ❌ **Component snapshot testləri** yoxdur
- ❌ **Visual regression testləri** yoxdur (Plan §5.2.13 — Percy/Playwright)

---

### 16. 🟡 Error Handling

- ✅ `ErrorBoundary.tsx` mövcuddur, `Home.tsx`-da wrap edilib
- ❌ **Custom 404 / 500 React səhifələri** yoxdur (Plan §10.4) — Laravel-in default səhifələri
- ❌ **Sentry React inteqrasiyası** yoxdur — yalnız backend (`sentry/sentry-laravel`)
- ❌ **Network error retry** yoxdur (form submit failə düşəndə manual reload)

---

### 17. 🟡 Mobile / Responsive Real Test

`react_migration_plan.md` Architecture Manifesto §1.6 → "Real Device Test minimum seti" tələb edir:
- 320×568 iPhone SE
- 360×780 Android
- 390-430 iPhone Pro
- 768 iPad
- 1366+ Laptop

**Real:** Yalnız Chrome DevTools test olunub. Əsl cihazlarda audit yoxdur. `KP-24` açıq qalır: APP_URL XAMPP vs `127.0.0.1:8000` uyğunsuzluğu.

---

### 18. 🟡 Security Boşluqlar (React-spesifik)

- ❌ **CSP (Content Security Policy) whitelist** yoxdur (Plan §10.6)
- ⚠️ **`dangerouslySetInnerHTML`** Hero.tsx-də sanitize olunub, amma `ThemeProvider`-də custom CSS/JS inject **yoxlanılmır** → admin XSS açar yarada bilər
- ❌ **CSRF token rotation** strategiyası yoxdur — tək session token uzun yaşayır
- ❌ **Rate limiting** yalnız form-route-larda var — API endpoint-lər (gələcək) üçün hazırlıq yoxdur

---

## 📋 Real Roadmap (Prioritetə Görə)

### 🔴 P0 — Production Cutover Blockerlər
1. **Legacy CSS təmizliyi** — `chalang-preview.css` / `chalang-core.css` Tailwind tokenlərinə kiçirmək (KP-7 sualına cavab)
2. **Inertia SSR setup** — SEO multi-lang üçün məcburi
3. **Bütün 8 Blade səhifəsinin React-ə miqrasiyası** (About, Services, Service detail, Portfolio, Portfolio detail, Blog, Blog single, Contact, Team, Packages, Case Studies)
4. **Bütün daxili `<a>` → Inertia `<Link>`** keçid (yoxsa full reload baş verir)
5. **Cutover redirect strategiyası** + rollback prosedurası

### 🟠 P1 — Quality & Stability
6. **TypeScript type generation** — Eloquent modellərindən avtomatik (`spatie/laravel-typescript-transformer`)
7. **Form validation** — React Hook Form + Zod schema
8. **Code splitting** + bundle analizi (`React.lazy()`, vite-plugin-visualizer)
9. **Test infrastrukturu** — Vitest + RTL minimum (smoke testlər)
10. **Navbar Phase 2-6** tamamlanması (41/51 qalan problem)

### 🟡 P2 — Polish & Future
11. **Accessibility audit** (axe-core, WCAG AA)
12. **Performance budget** (Lighthouse CI, Core Web Vitals tracking)
13. **Image optimization pipeline** (`.webp`, blur placeholder)
14. **Sentry React** + custom 404/500 React səhifələri
15. **Real device testing matrix** (BrowserStack və ya əlçatan cihazlar)

---

## 🎯 Konkret Tövsiyələr

### TopThing #1: `_new.blade.php` switch-i ETMƏYİN
TODO 1.4.2.2.5 (`_new` → əsas faylların adının dəyişdirilməsi) **vaxt itkisidir**. Birbaşa React-ə miqrasiya edin. Yalnız 1 səhifə (`Home`) miqrasiya olunub deməkdir 8 səhifə qarşıda.

### TopThing #2: Növbəti miqrasiya səhifələrinin sıralanması

Tövsiyə olunan sıra:
1. **`Pages/About.tsx`** (sadə, az dinamik) → şablon kimi öyrənmək
2. **`Pages/Services.tsx`** (mərkəzi səhifə) → **biznes əhəmiyyəti yüksəkdir**
3. **`Pages/Contact.tsx`** (form-heavy) → React Hook Form pattern-i qurmaq
4. **`Pages/Portfolio.tsx`** + **`Pages/PortfolioSingle.tsx`**
5. **`Pages/Blog.tsx`** + **`Pages/BlogSingle.tsx`**
6. **`Pages/ServiceDetail.tsx`**
7. **`Pages/CaseStudies.tsx`** + **`Pages/CaseStudySingle.tsx`**
8. **`Pages/Team.tsx`**
9. **`Pages/Packages.tsx`**

### TopThing #3: Hər miqrasiya olunan səhifə üçün eyni paritet checklist
Home-dakı KP registry kimi hər səhifə üçün:
- [ ] Vizual paritet (`/preview/X` ↔ `/react-test/X`)
- [ ] Dark/Light mode test
- [ ] AZ/EN/RU dil dəstəyi
- [ ] Form CSRF + honeypot (varsa)
- [ ] Responsive (320px → 4K)
- [ ] Şəkil URL-ləri `getImageUrl()`
- [ ] Meta tags (`<Head>`)
- [ ] CSS tokens (hardcode yoxdur)

### TopThing #4: Plan sənədlərinin konsolidasiyası
Hal-hazırda paralel mövcuddur:
- `PLANS.md`
- `react_migration_plan.md`
- `new_tasks.md`
- `TODO.md`
- `task.md.part1...part5`
- `task_deprecated.md`

→ **Tək single source of truth** lazımdır (məs. `ROADMAP.md` + `MIGRATION.md`).

---

## 📅 Növbəti Addım Seçimləri

Aşağıdakı boşluqlardan birinə fokuslanmaq tövsiyə olunur:

1. **Növbəti səhifə miqrasiyası** (məs. `Pages/About.tsx` yaradılması) — biznes prioriteti
2. **Legacy CSS təmizliyi** (KP-7 həlli) — texniki borcun azaldılması
3. **TypeScript type generation setup** — DX iyileşdirmə
4. **Form validation refactor** (React Hook Form + Zod) — keyfiyyət
5. **Inertia SSR setup** — SEO blocker həlli
6. **Test infrastrukturu** (Vitest baseline) — regression qoruma

---

## 📚 Audit Mənbələri

Bu analiz aşağıdakı sənədlər və kod auditləri əsasında hazırlanıb:

| Mənbə | Nə verdi |
|---|---|
| `react_migration_plan.md` | Cari miqrasiya statusu, KP registry, qəbul kriteriyaları |
| `PLANS.md` | Master roadmap (Phase 0-12), Frontend Modernizasiyası |
| `TODO.md` | Footer parity tapşırıqları |
| `new_tasks.md` | Sprint icra planı, MVP blockerlər |
| `work_log.md` | Tamamlanmış işlər jurnalı |
| `resources/js/Pages/Home.tsx` | Tək mövcud React səhifəsi (332 sətir) |
| `resources/js/Components/Sections/` | 23 section komponenti |
| `routes/web.php` | Səhifə marshrutları |
| `app/Http/Controllers/Front/MainController.php` | `reactPreview()` metod |
| `package.json` + `composer.json` | Stack asılılıqları |
| `vite.config.js` + `tsconfig.json` | Build konfiqurasiyası |

---

> © 2026 Chalang React Migration Gaps Analysis
> Hazırlandı: 2026-04-26 | Versiya: 1.0
