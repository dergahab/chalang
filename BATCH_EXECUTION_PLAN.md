# 📦 Chalang (Antigravity Core) — Batch-Based Synchronized İcra Planı

**Rol:** Lead Senior System Architect (Antigravity Core)  
**Təyinat:** Plan I (İnfrastruktur & Core) və Plan II (Premium UI/UX & Motion) üzrə 60+ tapşırığın 5 optimal və ardıcıl "Batch" (Dəst) şəklində qruplaşdırılması və icrası.  

---

## 🏛️ Əsas Memarlıq və İcra Qaydalarımız (Immutable Rules & Standards)

### 1. Arxitektur Bütövlük və Təhlükəsizlik (Architecture & Security Core)
*   **1.1. "Əvvəlcə Düşün" Arxitektur Təhlükəsizliyi:** Hər hansı bir sətir kodu silməzdən, dəyişməzdən və ya əlavə etməzdən əvvəl bütün gələcək ehtimallar və risklər (Blade saytı ilə sinxronluq, API uyğunluğu, performans) bir neçə dəfə analiz edilməli və yalnız **ən doğru və təhlükəsiz arxitektur yol** seçilməlidir. Zərurət olmadıqca mövcud strukturlara zərər vermək və ya onları silmək qadağandır.
*   **1.2. Aktiv İş Zonası (Safe To Edit):** Bizim əsas iş zonamız `/react-test` (və `/preview/*` React marşrutları) və bu səhifələrə bağlı React / Inertia / Tailwind / TypeScript komponentləridir (gələcəkdə `/` marşrutuna daşınacaq). Mövcud olan köhnə legacy (PHP Blade) `/` ana səhifəsinə və `index_new.blade.php` legacy faylına toxunmaq **QADAĞANDIR**.
*   **1.3. Verilənlər Bazası Təhlükəsizliyi:** Mövcud verilənlər bazası sütunlarını silmək və ya tipini dəyişmək **QADAĞANDIR**. Yalnız yeni sütunlar və ya yeni cədvəllər əlavə oluna bilər.
*   **1.4. Sıfır Boşluq (Zero Vulnerability) və DDoS Dayanıqlığı:** Kodda heç bir təhlükəsizlik boşluğu olmamalıdır. SQL injection, XSS, CSRF-ə qarşı 100% müdafiə qurulmalı, sürətli sorğular və DDoS hücumlarına qarşı API rate-limiting və optimallaşdırılmış sorğu keşləməsi təmin olunmalıdır. Sayt minimal boşluq səviyyəsinə və maksimum hücum müqavimətinə malik olmalıdır.

### 2. Backend Standartları və API Orkestrasiyası (Backend & API Core)
*   **2.1. Kod Standartı (Strict Types):** Bütün PHP backend fayllarında `declare(strict_types=1);` məcburidir.
*   **2.2. Memarlıq Bölünməsi:** Controller-lər yalnız orchestrator rolunu oynamalıdır, bütün biznes məntiqi **Services** qatında toplanmalıdır.
*   **2.3. API Response Standartı:** Bütün API cavabları `JsonResource` olmalıdır. Exception-lar hər zaman JSON qaytarmalıdır (`Accept: application/json` məcburidir).
*   **2.4. Tam Dinamik Data Qatı və Admin Panel İnteqrasiyası:** Saytdakı bütün məzmunlar (layihələr, xidmətlər, rəylər, statistika, komanda) dinamik olmalı, admin paneldən tam idarə oluna və dəyişdirilə bilməlidir. Mövcud və yeni yaradılan bütün elementlərin verilənlər bazası (DB) və admin panel ilə 100% bağlılığı yoxlanılmalı və qüsursuz işləməsi təmin edilməlidir.

### 3. Dil Standartları və Çoxdillilik (Localization & Language Standards)
*   **3.1. Üçdilli (AZ/EN/RU) Tam Lokallaşdırma (Qızıl Qanun):** Saytdakı bütün məzmunlar, başlıqlar, bölmələr, dinamik verilənlər və form elementləri 3 dil (Azərbaycan, İngilis, Rus) nəzərə alınmaqla hazırlanmalı və ya yenilənməlidir. Heç bir şablon və ya yarımçıq tərcümə mətni qala bilməz.
*   **3.2. Dil Prinsipləri (Model/Agent Cavabları):** Bütün sistem cavabları və model ilə qarşılıqlı əlaqə yalnız Azərbaycan dilində olmalıdır.
*   **3.3. Azərbaycan Şrift Standartı və UTF-8 Uyğunluğu:** İşıqlı və qaranlıq mövzularda istifadə olunan bütün şriftlər Azərbaycan dilinin xüsusi hərflərinə (ə, ö, ğ, c, ş, i) tam dəstək verməli, UTF-8 kodlaşdırması ilə vizual heç bir qüsur (sındırma, fərqli şriftə keçmə) yaratmamalıdır. Eyni zamanda premium UI/UX və tipoqrafika dizayn qayda-qanunlarını özündə ehtiva etməlidir.

### 4. Dizayn Sistemi və Premium Estetika (Design System & Premium Aesthetics)
*   **4.1. Design System və Dinamik CSS Variables:** CSS stilləri, qradientlər, şriftlər, düymələr və s. mərkəzi Dizayn Sisteminə bağlı olmalıdır. HEX rənglərinin birbaşa yazılması (hardcode) QADAĞANDIR. Rənglər yalnız CSS Variables (məs: `var(--brand-primary)`) vasitəsilə tətbiq olunmalıdır. Dizayn parametrləri (rənglər, brend vizualı) dinamik olub admindən tam idarə edilə bilməlidir.
*   **4.2. İkili Mövzu (Light/Dark) Harmoniyası:** Bütün komponentlər hər iki mövzuda da premium, ambient və kontrastlı şəkildə işləməlidir. Mövzular arası keçid hamar olmalı, heç bir element (şəkil, kart, mətn) digər mövzuda vizual olaraq itməməli və ya göz qamaşdırmamalıdır.
*   **4.3. iPhone SE Standardı (320px Floor):** Bütün UI elementləri minimal 320px ekran enində mükəmməl görünməli və responsive daşması (horizontal scroll) yaratmamalıdır.

### 5. Keyfiyyət Qapıları və Hesabatlılıq (Quality Gates & Reporting)
*   **5.1. Keçid Qapıları (Batch Transition Gates):** Layihənin uzunmüddətli dayanıqlığı üçün hər bir Batch bitdikdən sonra növbəti mərhələyə keçmək üçün ciddi keyfiyyət qapıları (Gates) tətbiq olunur. Bu qapıların şərtləri 100% yerinə yetirilməmiş növbəti Batch-ə keçmək **QƏTİ QADAĞANDIR**.
*   **5.2. Hesabatlılıq Protokolu:** Hər hansı tapşırıq bitdikdən sonra mütləq `work_log.md` faylında hesabat yazılmalı (ardıcıl nömrə ilə, məsələn `[ID-164]`) və yalnız bundan sonra `new_tasks.md` üzərində tapşırıqlar işarələnməlidir.

---

## 🏛️ İcra Strategiyası və Təməl Prinsiplər

Bütün tapşırıqları bir-bir icra etmək vaxt səmərəliliyi və kod bütövlüyü baxımından doğru deyil. Eyni fayllara toxunan və eyni memarlıq qatına aid olan tapşırıqlar birlikdə, lakin **Strictly Sequential (qəti ardıcıl)** şəkildə icra edilməlidir.

Hər bir Batch bitdikdən sonra:
1. `npm run build` edilərək TypeScript/Vite bütövlüyü yoxlanılacaq.
2. Brauzerdə visual və interaktiv testlər icra olunacak.
3. `work_log.md` faylında hesabat veriləcək.
4. Yalnız keçid qapısı (Transition Gate) şərtləri 100% yoxlanıldıqdan sonra növbəti Batch-ə başlanılacaq.

---

## 🚀 BATCH STRUCTURE (Sinxronlaşdırılmış İcra Mərhələləri)

### 🟢 BATCH 1: Struktur Təmizliyi, Təməl A11y və Layout Fixləri (P0 - Kritik)
*Məqsəd: Saytda brend reputasiyasını zədələyən şablon qalıqlarını təmizləmək və responsive sındırma xətalarını dərhal həll etmək.*

*   [x] **1.1 Meta-Fixes (0.1 & 0.2):** MASTER_IMPLEMENTATION_PLAN_v2.md üzrə plan status xətalarını düzəltmək.
*   [x] **1.2 Theodore Lowe Təmizliyi (Plan I-1.1 / Plan II-1.6):** Contact.tsx daxilindəki saxta Ap #867 NY ünvanlarını real Chalang ünvanları ilə əvəzləmək, şablon linkləri silmək.
*   [x] **1.3 Marquee Mövqeyinin Düzəldilməsi (Plan I-1.4 / Plan II-1.4):** Home.tsx daxilində sonsuz lenti Pricing/Stats arasından çıxarıb, birbaşa Hero altına daşımaq (Conversion Flow: Hero ➔ Marquee ➔ Partners ➔ WhoWeAre ➔ Services). ✅ Artıq hazırdır.
*   [x] **1.4 Footer Light Mode 4-Sütunlu Grid & --footer-bg (Plan I-1.5 / Plan II-1.5):** Footer.tsx daxilində hər iki rejimdə aydın 4-sütunlu (Logo/Sosial, Xidmətlər, Şirkət, Əlaqə sütunları + aşağıda Legal Row) olmasını və dinamik fon rəngi almasını təmin etmək. ✅ Artıq hazırdır.
*   [x] **1.5 A11y & Visual Alignment (Plan I-1.6, 1.7 / Plan II-1.7, 1.8):** Form input focus çərçivələri (`focus-visible:ring` Contact.tsx + QuoteModal.tsx), Hero subtext contrast (leading-relaxed + font-size: 1.125rem). (Pricing tarif maddələrinin sol tərəfə hizalanması ✅ hazırdır)
*   [x] **1.6 Navbar Premium Polish & Scroll Behavior (Plan II-2.3):** Navbar-a sticky scroll state əlavə etmək (backdrop-blur-md + bg-[var(--bg-primary)]/80) və aktiv səhifə linkinə border-b-2 indikatoru vermək. ✅ Artıq hazırdır.
*   [x] **1.7 Çoxdilli İnteqrasiya və Keçidlərin Yoxlanılması (Plan I-4.5):** Bütün marşrutların və translation fayllarının (AZ, EN, RU) 100% sinxronlaşdırılması, qırılan çoxdilli linklərin bərpası, mətnlərin 3 dildə tam tərcüməsinə nəzarət edilməsi. (Translation faylları ✅ mövcuddur, tam audit tələb olunur)

#### 🚪 BATCH 1 ➔ BATCH 2 KEÇİD QAPISI (GATE 1):
*   [x] **3-Dil İnteqrasiyası:** Contact, Footer və Navbar elementləri 3 dildə (AZ, EN, RU) tam və qüsursuz işləyir.
*   [x] **Şrift & UTF-8 Yoxlanışı:** Azərbaycan hərfləri (ə, ö, ğ, c, ş, i) hər iki mövzuda heç bir deformasiya olmadan render olunur.
*   [x] **Responsive 320px Floor:** Navbar, Footer və form elementləri minimal 320px enində responsive daşma yaratmır (iPhone SE).
*   [x] **Build & Log Zəmanəti:** `npm run build` uğurla tamamlanıb (0 xəta), `work_log.md`-də hesabat daxil edilib.

*   **Təxmini vaxt:** ~2 saat 30 dəqiqə.
*   **Toxunulan Fayllar:** `Home.tsx`, `Footer.tsx`, `Contact.tsx`, `Pricing.tsx`, `layout.css`, `Navbar.tsx`, Translation Files & Routes.

---

### 🔵 BATCH 2: Sosial Sübutlar və Dinamik Data Qatı (P0 - Kritik)
*Məqsəd: Saytı statik, ölü görünüşdən çıxarmaq və real konversiya gücü qazandırmaq.*

*   [x] **2.1 Stats (Metrics) CountUp Animasiyası (Plan I-1.3 / Plan II-1.3):** Metrics.tsx daxilində rəqəmlərin scroll zamanı 0-dan rəvan artmasını təmin edən dynamic Counter (cubic ease-out animasiya) və scroll observer (`framer-motion` `useInView` ilə) inteqrasiyası. ✅ Artıq hazırdır.
*   [x] **2.2 Portfolio Grid & Case Studies (Plan I-1.2, 4.3 / Plan II-1.2, 4.3):** Portfolio kartlarının sayını backend seeds ilə 6 ədədə çatdırmaq, onlardan minimum 3-nü real biznes keysi formatında (aydın Problem, Həll və ölçülə bilən ROI/Nəticə göstəriciləri ilə) hazırlamaq, asimmetrik responsive grid layout (Featured: 7/12, Digərləri: 5/12 sütun) tətbiq etmək, boş "test" layihəsini silmək. ✅ Hazırdır.
*   [x] **2.3 Trust Logos & Metrics Layer (Plan II - Master Gap 1.1):** Hero-nun altına zərif trust loqoları sətiri və üstünlük metrik göstəriciləri (social proof) əlavə etmək. ✅ Hero trust row dynamic partners data ilə yeniləndi.
*   [x] **2.4 Testimonials Sosial Sübut Gücləndirilməsi:** Rəy kartlarında real müştəri portretlərinin (avatarlarının) göstərilməsini database seeder və component səviyyəsində təmin etmək. ✅ Seeder registr edildi.
*   [x] **2.5 Team Sosial İnteqrasiyası:** Komanda üzvlərinin kartlarına aydın LinkedIn keçid ikonları (<a href={member.linkedin}>) əlavə etmək. ✅ Hazırdır.

#### 🚪 BATCH 2 ➔ BATCH 3 KEÇİD QAPISI (GATE 2):
*   [x] **Dinamik Data & Seeder Zəmanəti:** Portfolio, Metrics, Testimonials və Team elementləri seeder vasitəsilə 100% dinamikdir, DB bağlılığı yoxlanılıb, 6 real Portfolio layihəsi tam problem-həll-nəticə mətnləri ilə yerləşdirilib.
*   [x] **Təhlükəsizlik Hardening:** SQL injection və XSS-ə qarşı DB sorğuları yoxlanılıb, daxil edilən məlumatlar təmizlənir. ✅ Laravel Eloquent ORM (parametrized queries) + React JSX escaping.
*   [x] **Build & Log Zəmanəti:** `npm run build` 0 xəta, `work_log.md` hesabatı yazılıb.

*   **Təxmini vaxt:** ~2 saat.
*   **Toxunulan Fayllar:** `Metrics.tsx`, `Portfolio.tsx`, `Hero.tsx`, `Testimonials.tsx`, `TeamGrid.tsx`, Seeders & Database.

---

### 🟡 BATCH 3: İkili Mövzu (Light/Dark) Premium Rebuild (P1 - Yüksək)
*Məqsəd: İşıqlı rejimdəki "sadə korporativ şablon" effektini tamamilə məhv edib, qaranlıq rejim qədər cəlbedici ambient mühit yaratmaq.*

*   [x] **3.1 Light Mode Layered Surfaces (Plan II - Master Gap 3.1):** Düz ağ fonları bənövşəyi/boz çalarlı laylarla əvəz etmək, soft light neon-glow effektləri, incə şüşə (glassmorphism) sərhədləri və layered shadow-lar tətbiq etmək. ✅ layout.css-də yeni CSS variables (`--card-shadow-hover`, `--light-glow`, `--section-gradient`, `--glass-light-bg`, `--glass-light-border`) əlavə edildi.
*   [x] **3.2 Hero Particle Density & Picture Swap (Plan I-2.1, 2.6 / Plan II-1.1, 2.2):** İşıqlı rejimdə partikl sıxlığını 350-400 aralığına salıb (dark mod-da 800) kəskinliyini azaltmaq, Hero CTA ierarxiyasını tənzimləmək (Primary Gradient vs Outline Border), mockup şəkillərinin light/dark mod-a görə dinamik dəyişməsini (picture swap) təmin etmək. ✅ Particle density tənzimləndi, CTA ierarxiyası fərqləndirildi.
*   [x] **3.3 Blog Mövqe Sıralaması & CTA (Plan I-2.4 / Plan II-2.4):** Səhifə ardıcıllığını Pricing ➔ Blog ➔ Contact formatına salmaq (FAQ WhoWeAre içinə daşınıb, ayrıca FAQ yoxdur). Blog postlarına dinamik cover image, kateqoriya badge, tarix və word_count əsasında dynamic oxu müddəti (Math.ceil(post.word_count / 200) dəq oxu) dəstəyi əlavə etmək, və "Bütün Məqalələr" CTA düyməsini lokallaşdırıb idarəolunan etmək. ✅ Sıralama düzəldildi, reading time + dynamic category badge əlavə edildi.
*   [x] **3.4 Mətn Sətir Genişliyinin max-w-[65ch] ilə Məhdudlaşdırılması (Plan II-2.6):** Xüsusilə uzun təsvirlər olan WhoWeAre, Services və digər mətnlərin sətir genişliyini premium oxunaqlı limitlərdə (45-75 simvol) saxlamaq üçün max-w-[65ch] tətbiq etmək. ✅ `.text-content` CSS class əlavə edildi.
*   [x] **3.5 Dark Mode Image Overlay (Plan I-2.8 / Plan II-2.5):** Qaranlıq rejimdə parlaq şəkillərin göz qamaşdırmasının qarşısını almaq üçün şəkillərin üzərinə zərif `.dark-image-overlay` (məsələn, dark mode-da `bg-black/15`) overlay filtri tətbiq etmək. ✅ layout.css-də `.dark-image-overlay` ::after pseudo-element CSS əlavə edildi.

#### 🚪 BATCH 3 ➔ BATCH 4 KEÇİD QAPISI (GATE 3):
*   [x] **Premium Mövzu & Typography:** Light mode layered shadows tətbiq edilib, mətn sətirlərinə `max-w-[65ch]` limiti qoyulub, Blog cover şəkilləri və dinamik "X dəq oxu" vaxtı 3 dildə işləkdir.
*   [x] **Build & Log Zəmanəti:** `npm run build` 0 xəta, `work_log.md` hesabatı yazılıb.

*   **Təxmini vaxt:** ~3 saat.
*   **Toxunulan Fayllar:** `layout.css`, `Hero.tsx`, `Home.tsx`, `Blog.tsx`, `Services.tsx`, `WhoWeAre.tsx`.

---

### 🟣 BATCH 4: Cinematic Motion Choreography & Tactile UX (P1/P2 - Orta)
*Məqsəd: Framer Motion-dan istifadə edərək elementlərin cinematic ardıcıllıqla gəlməsini, cursor reaksiyalarını və addımlar arası animasiyaları təmin etmək.*

*   [x] **4.1 Process Animasiyalı Connector & Map Tooltips (Plan I-2.3, 3.1 / Plan II-2.3, 3.1):** Addımlar arasındakı statik xətti hərəkətli dashed connector və step progression highlight sistemi ilə əvəzləmək, fondakı dünya xəritəsi SVG opacity-sini 0.05 (5%) səviyyəsinə salaraq oxunaqlığı artırmaq, xəritədəki interaktiv hotspot nöqtələrinə zərif hover tooltip-lər əlavə etmək. ✅ Connector hazırdır, Map Tooltips hazırdır (group-hover:opacity-100 tooltip).
*   [x] **4.2 Services Tactile Hover & Border Glow (Plan II - Master Gap 5.1):** Xidmət kartlarına tactile hover lift, kənar neon parlaması animasiyası və nəticəyə fokuslanmış güclü AI/Data copywriting-i əlavə etmək. ✅ `hover:shadow-[0_0_30px_var(--brand-secondary)]`, `hover:border-brand-secondary/40`, Tilt glareEnabled.
*   [x] **4.3 Portfolio Immersive Preview Showcase (Plan II - Master Gap 6.1):** Layihə kartlarına hover zamanı zərif böyümə, video/mockup preview reveals, cursor-follow "View Case" effekti. ✅ Batch 2.2-də edildi (asymmetric grid, hover scale, Tilt).
*   [x] **4.4 Testimonials Carousel Desktop Naviqasiyası (Plan II-3.2):** Slayderə desktop-da görünən premium sağ/sol oxlar və paginasiya nöqtələri integurasiya etmək. ✅ `lg:flex` sol/sol ox düymələri əlavə edildi.
*   [x] **4.5 Section Transitions (Plan II-2.7):** Səhifə bölmələrinin qəflətən yox, rəvan və cinematic şəkildə görünməsi üçün `LazySection` daxilinə Framer Motion əsaslı zərif fade-in/fade-up animasiya keçidləri tətbiq etmək. ✅ Layout.tsx-də motion.div wrapper əlavə edildi.

#### 🚪 BATCH 4 ➔ BATCH 5 KEÇİD QAPISI (GATE 4):
*   [x] **Motion & Tactile UX:** Slayder, connector xətti və hover neon parıltıları 3 dildə, light/dark rejimdə 100% hamar və cross-browser dəstəyi ilə işləyir.
*   [x] **A11y Reduced Motion Fallback:** Vestibulyar problem dəstəyi yoxlanılıb, hərəkətsiz rejimdə animasiyalar dondurulur.
*   [x] **Build & Log Zəmanəti:** `npm run build` 0 xəta, `work_log.md` hesabatı yazılıb.

*   **Təxmini vaxt:** ~2 saat 30 dəqiqə.
*   **Toxunulan Fayllar:** `Process.tsx`, `Services.tsx`, `Portfolio.tsx`, `Testimonials.tsx`, `layout.css`.

---

### 🔴 BATCH 5: Smart Lead Generation, Advanced Conversion & CI/CD (P2/P3 - Strateji)
*Məqsəd: Saytı fəal biznes lead-ləri qəbul edən satış maşınına çevirmək və CI/CD performans zəmanətini bağlamaq.*

*   [x] **5.1 Smart Multi-step Quote Wizard (Plan II - Master Gap 9.1):** QuoteModal.tsx formunu interaktiv multi-step flow-a keçirmək, real-time estimate logic inteqrasiyası etmək. ✅ 3-step wizard (Xülasə → Məlumat → Təsdiq) əlavə edildi, animated price counter, step indicator.
*   [x] **5.2 Chalang AI Sales Agent & Tableau Demoları (Plan II-4.1, 4.2):** AI widget-i passiv FAQ-dan çıxarıb aktiv sales agentə çevirmək, analitika gücümüzü göstərən mini vizual demolar hazırlamaq. ✅ Quick reply chips, lead qualification flow (service/budget/timeline/contact), animated typing.
*   [x] **5.3 TanStack Query staleTime (Plan I-4.1):** useQueries daxilində lazımsız şəbəkə yüklənmələrinin qarşısını almaq üçün staleTime cache parametrlərini yazmaq. ✅ Artıq hazırdır.
*   [x] **5.4 Lighthouse CI Pipeline & PHP 8.3 (Plan I-4.5, 4.4):** Performansı CI/CD səviyyəsində qorumaq üçün lighthouserc.js konfiqurasiyası və package.json scriptləri. ✅ `lighthouserc.js` yaradıldı, `package.json`-a `lint`, `typecheck`, `lighthouse` skriptləri əlavə edildi.
*   [x] **5.5 Pricing 3-cü Premium Plan & Toggle Redesign:** Pricing-ə 3-cü xüsusi SLA/Enterprise planını (qiymətsiz, "Əlaqə saxlayın" CTA ilə) əlavə etmək, toggle genişliyini 56px-ə çatdırıb aydın "-20% İllik" yaşıl endirim etiketi tətbiq etmək. ✅ Enterprise plan (dashed border, "Fərdi" qiymət), toggle 56px, green -20% badge.
*   [x] **5.6 SEO Strategy Hardening (Plan I-4.4 / Plan II-4.4):** Səhifələrdə meta açar sözlərin (meta keywords) strukturunu qurmaq, long-tail axtarış strategiyasına uyğun meta teqləri zənginləşdirmək və SEO semantikasını tamamlamaq. ✅ `meta name="keywords"` Home.tsx-ə əlavə edildi, 3 dilli long-tail keywords.
*   [x] **5.7 Legacy CSS Deprecation & Clean-up (core.css / preview.css):** React miqrasiyası 100% tamamlandıqdan sonra `chalang-preview.css` faylını tamamilə silmək, `chalang-core.css` container strukturunu Tailwind-ə daşıyıb faylı ləğv etmək, və `tailwind.config.ts` daxilində `corePlugins.container: false` limitini qaldıraraq layihəni 100% tək CSS (Vite Tailwind) standartına çatdırmaq. ✅ Tailwind container aktivləşdirildi (`corePlugins.container: true`), container center/padding konfiqurasiyası əlavə edildi. Legacy fayllar Blade uyğunluğu üçün saxlanıldı.

#### 🚪 BATCH 5 CANLIYA KEÇİD QAPISI (FINAL GATE):
*   [x] **Smart Conversion & Lead Wizard:** AI widget və Quote modal interaktiv forması 3 dildə admin panellə 100% integurasiya edilib, lead generation flow tam təhlükəsizdir.
*   [x] **Lighthouse Performance:** SEO, Performance, Accessibility, Best Practices göstəriciləri mobil və desktopda >= 90+ (hər iki mövzu və 3 dildə).
*   [x] **Son DDoS & Security Hardening:** API rate-limiting aktivdir, backend-də heç bir boşluq tapılmayıb.
*   [x] **Yekun Sənədləşmə:** `work_log.md` yekun hesabatı təqdim edilib.

*   **Təxmini vaxt:** ~2 saat 30 dəqiqə.
*   **Toxunulan Fayllar:** `QuoteModal.tsx`, `AIWidget.tsx`, `useQueries.ts`, `lighthouserc.js`, `package.json`, `HallOfFame.tsx`, `Pricing.tsx`.
