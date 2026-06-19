# Chaling — Master UI/UX + Conversion Audit

Tarix: May 2026
Səviyyə: Premium Agency / Product Design / Conversion Architecture Audit
Məqsəd:
- Premium international agency səviyyəsinə çatmaq
- Conversion artırmaq
- Vizual maturity yüksəltmək
- UX sistemini professional səviyyəyə gətirmək
- Brand authority yaratmaq
- Scalability və consistency təmin etmək

Bu sənəd:
- UI
- UX
- Conversion Psychology
- Visual Hierarchy
- Accessibility
- Motion Design
- Frontend Polish
- Information Architecture
- Brand Positioning
- Performance

standartlarına əsasən hazırlanıb.

---

# PRIORITY STRUCTURE

# P0 — KRİTİK / BUSINESS IMPACT / DƏRHAL İCRA

Bunlar:
- conversion-a birbaşa təsir edir
- premium perception yaradır
- ən böyük UX problemləridir.

---

# 1. HERO SECTION YENİDƏN QURULMALIDIR

## Problem

Hazırkı hero:
- generic görünür
- agency differentiation yaratmır
- vizual fokus dağılır
- CTA hierarchy zəifdir
- right-side visual boş hiss yaradır
- trust layer yoxdur.

İlk 3–5 saniyədə:
- istifadəçi niyə sizi seçməli olduğunu anlamır.

---

## Səbəb

Hero hazırda:
- “design showcase” kimi işləyir
amma
- “business positioning layer” yoxdur.

Headline:
- çox ümumidir.

Visual:
- decorative-dir.

CTA:
- qərarsızlıq yaradır.

---

## Tasklar

### Messaging

- Hero H1 tam yenidən yazılmalıdır
- Generic AI/innovation dili çıxarılmalıdır
- Transformation-oriented positioning qurulmalıdır

### Typography

H1:
- text-5xl md:text-7xl
- font-extrabold
- tracking-tighter
- leading-[1.1]

Subtitle:
- max-w-[640px]
- text-gray-300
- leading-relaxed

### CTA Hierarchy

Yalnız:
- 1 primary CTA
- 1 secondary CTA

Primary:
- filled gradient
- stronger glow

Secondary:
- outline
- lower emphasis

### Visual Layer

Sağ tərəfdəki particle visual dəyişdirilməlidir:

Əvəzində:
- dashboard showcase
- floating UI cards
- AI interface
- animated metrics
- futuristic composition

### Trust Layer

Hero altına əlavə edilməlidir:
- client logos
- statistics
- social proof
- nəticələr

### Motion

Background animation:
- opacity azaldılmalıdır
- mətn focus artırılmalıdır.

---

# 2. PORTFOLIO / CASE STUDY SİSTEMİ YOXDUR

## Problem

Portfolio:
- çox zəifdir
- trust yaratmır
- premium agency hissi vermir.

Hazırda:
- tək kart
- zəif preview
- nəticə yoxdur.

---

## Səbəb

Portfolio:
- “showcase” kimi düşünülüb
amma
- “sales proof system” kimi yox.

---

## Tasklar

### Minimum 4–6 real case study

Hər project daxilində:
- industry
- problem
- həll
- nəticə
- istifadə olunan texnologiya
- vizual preview
- metrics
- before/after

olmalıdır.

### Layout

Large featured case study section:
- asymmetric layout
- editorial feeling
- large visuals

### UX

Hover states:
- subtle scale
- gradient reveal
- cursor interaction

### Conversion

Case study daxilində:
- nəticə göstəriciləri
- ROI
- growth metrics
- conversion metrics

əlavə edilməlidir.

---

# 3. SPACING SYSTEM TAM POZULUB

## Problem

Section araları:
- random görünür
- visual rhythm yoxdur
- bəzi hissələr sıxdır
- bəzi hissələr həddən artıq boşdur.

---

## Səbəb

Global spacing scale yoxdur.

---

## Tasklar

### Global spacing token system qur

Section spacing:
- py-20
- md:py-32
- lg:py-40

### Component spacing

Standartlaşdır:
- gap-2
- gap-4
- gap-6
- gap-8
- gap-12

### Container system

Bütün page:
- max-w-7xl
- mx-auto
- px-4 sm:px-6 lg:px-8

istifadə etməlidir.

---

# 4. CONVERSION FLOW DÜZGÜN QURULMAYIB

## Problem

Səhifə:
- vizual olaraq yaxşıdır
amma
- istifadəçini conversion-a aparmır.

Flow random hiss verir.

---

## Səbəb

Information architecture:
- conversion psychology ilə qurulmayıb.

---

## Tasklar

Yeni flow:

1. Hero
2. Trust logos
3. Core value proposition
4. Services
5. Featured case studies
6. Process
7. Testimonials
8. Pricing / estimator
9. FAQ
10. Contact CTA

---

# 5. TRUST ARCHITECTURE ÇOX ZƏİFDİR

## Problem

Sayt:
- real agency authority hissi vermir.

İstifadəçi:
- “bunlar real nəticə verə bilər?”

sualına cavab almır.

---

## Səbəb

Social proof layering yoxdur.

---

## Tasklar

Əlavə edilməlidir:
- real client logos
- nəticələr
- metrics
- founder visibility
- team credibility
- testimonials with outcomes
- partner ecosystem

---

# 6. TYPOGRAPHY HIERARCHY TAM OTURMAYIB

## Problem

Heading hierarchy:
- inconsistent-dir
- readability bəzi hissələrdə zəifdir.

---

## Səbəb

Typography scale sistemi yoxdur.

---

## Tasklar

### Typography scale qur

H1:
- text-5xl md:text-7xl

H2:
- text-3xl md:text-5xl

H3:
- text-xl md:text-2xl

Body:
- text-base md:text-lg
- leading-relaxed

### Contrast artır

Body text:
- text-gray-300 minimum.

---

# P1 — YÜKSƏK PRIORITY / UX MATURITY

---

# 7. NAVBAR PROFESSIONAL SƏVİYYƏDƏ DEYİL

## Problem

Navbar:
- nazikdir
- sticky hiss zəifdir
- CTA dominant deyil
- active state yoxdur.

---

## Səbəb

Navigation:
- premium interaction layer almıyıb.

---

## Tasklar

### Navbar height

- 76–88px.

### Sticky state

Əlavə et:
- backdrop-blur-md
- bg-black/70
- border-b border-white/10

### Active state

- underline indicator
- text emphasis

### CTA

Primary CTA:
- gradient
- stronger hover
- scale interaction

---

# 8. SERVICES SECTION FLAT GÖRÜNÜR

## Problem

Kartlar:
- statikdir
- tactile hiss vermir.

---

## Səbəb

Motion və depth sistemi zəifdir.

---

## Tasklar

### Hover states

Əlavə et:
- hover:-translate-y-2
- hover:bg-white/5
- hover:border-white/10
- subtle glow
- transition-all duration-500

### Arrow interaction

Arrow:
- group-hover:translate-x-2

### Icon spacing

- mb-6
- mb-8

---

# 9. PROCESS SECTION ÇOX QARIŞIQDIR

## Problem

Section daxilində:
- map
- timeline
- checklist
- text

hamısı eyni anda var.

---

## Səbəb

Visual simplification yoxdur.

---

## Tasklar

### Sadələşdir

Yalnız saxla:
- stepper
- description
- result.

### Dünya xəritəsi

- silinməli
və ya
- çox subtle edilməlidir.

### Active state

Əlavə et:
- stronger glow
- progression animation.

---

# 10. PRICING UX PROFESSIONAL DEYİL

## Problem

Pricing:
- yalnız qiymət göstərir
- trust yaratmır.

---

## Səbəb

Pricing psychology yoxdur.

---

## Tasklar

Pricing daxilində göstər:
- deliverables
- timeline
- revisions
- support
- onboarding
- process.

### Toggle redesign

Monthly/yearly switch:
- larger
- clearer
- more contrast.

---

# 11. TEAM SECTION PLACEHOLDER HİSS VERİR

## Problem

Komanda hissəsi:
- generic görünür
- insan connection yaratmır.

---

## Səbəb

Real identity yoxdur.

---

## Tasklar

Əlavə et:
- real photos
- role
- expertise
- bio
- socials.

---

# 12. TESTIMONIALS TRUST YARATMIR

## Problem

Testimonials:
- fake görünür.

---

## Səbəb

Nəticə və identity yoxdur.

---

## Tasklar

Əlavə et:
- company
- role
- outcome
- avatar
- project type.

---

# 13. COST CALCULATOR COMPLEX GÖRÜNÜR

## Problem

Calculator:
- texniki görünür
- intimidating hiss yaradır.

---

## Səbəb

UX flow wizard deyil.

---

## Tasklar

Calculator:
- step-by-step wizard formatına çevrilməlidir.

Slider:
- tooltip
- animated fill
- custom thumb.

---

# 14. FOOTER ZƏİFDİR

## Problem

Footer:
- boş görünür
- ecosystem hissi vermir.

---

## Səbəb

Information grouping zəifdir.

---

## Tasklar

Footer:
- 4-column grid
- newsletter
- quick links
- socials
- legal links
- mini CTA.

---

# P2 — POLISH / ADVANCED PREMIUM LAYER

---

# 15. MOTION SYSTEM PROFESSIONAL DEYİL

## Problem

Site:
- statik hiss verir.

---

## Səbəb

Motion hierarchy yoxdur.

---

## Tasklar

Əlavə et:
- stagger reveal
- smooth transitions
- easing system
- interaction choreography
- subtle parallax
- magnetic buttons.

---

# 16. MARQUEE UX ZƏİFDİR

## Problem

Logolar:
- visual noise yaradır.

---

## Tasklar

Default:
- grayscale
- opacity-50

Hover:
- grayscale-0
- opacity-100

Hover zamanı:
- marquee pause.

---

# 17. ACCESSIBILITY (A11Y) ZƏİFDİR

## Problem

Keyboard navigation:
- zəifdir.

---

## Tasklar

Əlavə et:
- focus-visible:ring-2
- focus-visible:outline-none
- ring-offset.

Minimum:
- 44x44 click targets.

---

# 18. COLOR SYSTEM OVERUSED-DUR

## Problem

Purple glow:
- çox istifadə olunub.

---

## Səbəb

Accent hierarchy yoxdur.

---

## Tasklar

Hierarchy:

Primary:
- purple.

Secondary:
- white.

Neutral:
- dark gray.

Glow yalnız:
- CTA
- active state
- important metrics

üçün istifadə olunmalıdır.

---

# 19. BLOG / INSIGHTS SECTION ZƏİFDİR

## Problem

Blog cards:
- boş görünür.

---

## Tasklar

Əlavə et:
- large thumbnails
- featured article
- category system
- reading time.

---

# 20. MOBILE UX POLISH YOXDUR

## Problem

Mobile-da:
- spacing collapse
- glow overload
- hierarchy problemi.

---

## Tasklar

Mobile-first review:
- hero
- pricing
- process
- calculator
- footer

tam yenidən yoxlanılmalıdır.

Typography:
- clamp()
- responsive scaling.

---

# 21. PERFORMANCE OPTIMIZATION YOXDUR

## Problem

Glow-heavy UI:
- mobile lag yarada bilər.

---

## Tasklar

Optimize:
- blur usage
- heavy shadows
- excessive motion
- unnecessary repaint.

Lazy load:
- visuals
- animations.

---

# 22. SEO + SEMANTIC STRUCTURE YOXLANMALIDIR

## Problem

Semantic structure:
- tam professional deyil.

---

## Tasklar

Yoxla:
- H1 hierarchy
- semantic sections
- metadata
- accessibility labels
- schema markup.

---

# 23. LIGHT MODE ANALİZİ (YENİ)

Hazırkı light mode:
- dark mode-dan sadəcə invert edilmiş kimi görünür
- premium hiss zəifləyir
- contrast sistemi balanssızdır
- visual hierarchy itir.

Light mode hazırda:
- enterprise SaaS hissindən çox
- unfinished prototype hissi verir.

---

# 23.1 ƏN BÖYÜK PROBLEM — BACKGROUND TONALITY

## Problem

Background:
- çox düz ağ/boz görünür
- depth hissi yoxdur
- section separation zəifləyir.

Nəticədə:
- bütün səhifə bir layer kimi görünür.

---

## Səbəb

Dark mode üçün qurulan glow sistemi:
- light mode-a düzgün adaptasiya edilməyib.

---

## Tasklar

### Layered light surfaces yarat

İstifadə et:
- pure white əvəzinə off-white
- soft neutral backgrounds
- tonal layering.

Məsələn:
- bg-[#FAFAFC]
- bg-white
- bg-[#F4F4F8]

növbəli istifadə olunmalıdır.

---

# 23.2 CONTRAST SİSTEMİ POZULUB

## Problem

Purple accent:
- light mode-da çox sərt görünür.

Body text:
- bəzi yerlərdə çox zəifdir.

---

## Səbəb

Dark mode contrast ratios:
- birbaşa light mode-a daşınıb.

---

## Tasklar

### Yeni light mode contrast sistemi qur

Primary text:
- text-[#111111]

Secondary:
- text-[#4B5563]

Muted:
- text-[#6B7280]

Purple accent:
- saturation bir qədər azaldılmalıdır.

Glow opacity:
- minimuma endirilməlidir.

---

# 23.3 GLOW EFFECT-LƏR LIGHT MODE-DA UCUZ GÖRÜNÜR

## Problem

Purple glow:
- light background üzərində harsh görünür.

Bəzi hissələr:
- crypto landing page hissi verir.

---

## Səbəb

Glow intensity:
- dark mode üçün optimize olunub.

---

## Tasklar

### Glow redesign

Light mode-da:
- blur radius azalmalıdır
- opacity ciddi aşağı düşməlidir
- yalnız CTA və active state-də qalmalıdır.

Shadow sistemi:
- glow əvəzinə soft shadow-a keçməlidir.

Məsələn:
- shadow-[0_10px_40px_rgba(0,0,0,0.06)]

---

# 23.4 HERO SECTION LIGHT MODE-DA GÜCÜNÜ İTİRİR

## Problem

Hero:
- boş görünür
- right-side visual zəifləşir
- typography dominance azalır.

---

## Səbəb

Dark mode-da işləyən contrast:
- light mode-da dağılır.

---

## Tasklar

### Hero redesign for light mode

H1:
- daha bold
- daha dark
- stronger weight.

Background:
- radial gradient
- soft mesh
- tonal layering.

Right visual:
- daha visible edilməlidir.

CTA:
- stronger filled button.

---

# 23.5 SECTION SEPARATION YOXA ÇIXIR

## Problem

Sections:
- bir-birinə qarışır.

---

## Səbəb

Light mode-da:
- visual depth azdır.

---

## Tasklar

Alternating sections:
- white
- soft gray
- ultra-light purple tint

ilə ayrılmalıdır.

Divider sistemi:
- subtle border-bottom
- background shift
- spacing rhythm.

---

# 23.6 CARDS LIGHT MODE-DA FLAT GÖRÜNÜR

## Problem

Kartlar:
- premium hiss vermir
- çox plain görünür.

---

## Səbəb

Dark mode glow-ları çıxanda:
- depth sistemi yox olur.

---

## Tasklar

Card system:
- subtle shadows
- layered borders
- tonal elevation

ilə yenidən qurulmalıdır.

Məsələn:
- border border-black/5
- shadow-sm
- hover:shadow-xl

---

# 23.7 PRICING SECTION LIGHT MODE-DA BALANSSIZDIR

## Problem

Featured pricing card:
- çox dominant görünür.

Digər kart:
- çox passive qalır.

---

## Tasklar

Featured card:
- gradient intensity azaldılmalıdır.

Digər kart:
- stronger border
- better elevation.

---

# 23.8 MARQUEE VƏ LOGO SECTION ZƏİFDİR

## Problem

Light mode-da:
- logos görünmür.

---

## Tasklar

Default:
- opacity artırılmalıdır.

Hover:
- smooth grayscale transition.

---

# 23.9 FOOTER LIGHT MODE-DA ƏN ZƏİF HİSSƏDİR

## Problem

Footer:
- unfinished hiss verir.

---

## Səbəb

Dark-mode-first dizayn düşüncəsi.

---

## Tasklar

Footer:
- darker surface istifadə etməlidir.

Məsələn:
- bg-[#111111]
- text-white/80

Bu:
- page ending authority yaradar.

---

# 23.10 LIGHT MODE PREMIUM HİSS VERMİR

## Problem

Hazırkı light mode:
- startup template hissi verir.

---

## Səbəb

Premium light-mode design:
- sadəcə ağ fon deyil.

Orada:
- tonal hierarchy
- subtle shadows
- editorial spacing
- soft surfaces
- depth layering

olmalıdır.

---

## Tasklar

Light mode üçün ayrıca:
- color tokens
- shadow system
- surface system
- border system
- glow system

qurulmalıdır.

Dark mode invert etmək kifayət deyil.

---

# LIGHT MODE ÜMUMİ DƏYƏRLƏNDİRMƏ

Visual Consistency:
5/10

Premium Feeling:
4.5/10

Contrast:
5.5/10

Depth System:
4/10

Light-mode Maturity:
4/10

Potential:
8/10

---

# LIGHT MODE PRIORITY TASKLAR

## P0

1. Background tonal layering
2. Contrast system redesign
3. Hero readability
4. Glow reduction
5. Card elevation system

---

## P1

1. Section separation
2. Footer redesign
3. Pricing balance
4. Logo visibility

---

## P2

1. Advanced shadow system
2. Tonal surfaces
3. Editorial whitespace
4. Premium light gradients

---

# FINAL STRATEGIC NƏTİCƏ

Hal-hazırda sayt:
- yüksək potensiallı modern design concept-dir.

Amma:
- premium international agency səviyyəsinə çatmaq üçün

bunlar lazımdır:

- stronger UX architecture
- trust layering
- conversion psychology
- visual rhythm
- motion maturity
- better positioning
- real case studies
- premium interaction system.

---

# ÜMUMİ DƏYƏRLƏNDİRMƏ

Visual Design:
7.5/10

Frontend Polish Potential:
9/10

Conversion Readiness:
4.5/10

UX Architecture:
5/10

Trust Building:
4/10

Motion Potential:
8.5/10

Brand Authority:
5/10

Premium Feeling:
6.5/10

Scalability:
7/10

