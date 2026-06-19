# 🌐 Chalang (Antigravity Core) — Master UI/UX & Premium Experience Yol Xəritəsi (Plan II)

**Tarix:** 2026-05-18  
**Rol:** Lead Senior System Architect (Antigravity Core)  
**Mənbə:** Audit I, II, III sənədlərinin konsolidasiyası + 5 Əsas Kritik Düzəliş + Master Gap Fix Tasks  

---

## 🏛️ Əsas Memarlıq və İcra Qaydalarımız (Immutable Rules)

*   **Dil Prinsipləri:** Bütün sistem cavabları və qarşılıqlı əlaqə yalnız Azərbaycan dilində olmalıdır.
*   **Kod Standartı (Strict Types):** Bütün PHP backend fayllarında `declare(strict_types=1);` məcburidir.
*   **Memarlıq Bölünməsi:** Controller-lər yalnız orchestrator rolunu oynamalıdır, bütün biznes məntiqi **Services** qatında toplanmalıdır.
*   **API Response Standartı:** Bütün API cavabları `JsonResource` olmalıdır. Exception-lar hər zaman JSON qaytarmalıdır (`Accept: application/json` məcburidir).
*   **Verilənlər Bazası Təhlükəsizliyi:** Mövcud verilənlər bazası sütunlarını silmək və ya tipini dəyişmək **QADAĞANDIR**. Yalnız yeni sütunlar və ya yeni cədvəllər əlavə oluna bilər.
*   **Aktiv İş Zonası:** Bizim əsas ana səhifəmiz və aktiv iş zonamız `/react-test` marşrutu (və bu səhifəyə bağlı olan `/preview/*` React marşrutları) ilə əlaqəli React / Inertia / Tailwind / TypeScript komponentləridir. Bu səhifə sonradan `/` (Ana səhifə) marşrutuna köçürüləcəkdir. Mövcud köhnə legacy PHP Blade `/` marşrutuna və `index_new.blade.php` legacy faylına toxunmaq **QADAĞANDIR**.
*   **CSS və Rəng Arxitekturası:** Hər hansı CSS faylında HEX rəng kodunu birbaşa yazmaq (hardcode) qadağandır. Rənglər yalnız CSS Variables (məs: `var(--brand-primary)`) vasitəsilə tətbiq olunmalıdır.
*   **iPhone SE Standardı (320px Floor):** Bütün UI elementləri minimal 320px ekran enində mükəmməl görünməli və responsive daşması yaratmamalıdır.
*   **Hesabatlılıq Protokolu:** Hər hansı tapşırıq bitdikdən sonra mütləq `work_log.md` faylında hesabat yazılmalı (ardıcıl nömrə ilə, məsələn `[ID-163]`) və yalnız bundan sonra `new_tasks.md` üzərində tapşırıqlar işarələnməlidir.

---

## 📦 BATCH EXECUTION PLAN (MƏRHƏLƏLİ İCRA PLANI)

Layihənin React/Tailwind/TypeScript/Inertia miqrasiyasını premium səviyyəyə çatdırmaq üçün qalan bütün işlər 6 fərqli **Batch (Qrup)** üzrə bölünmüşdür. Hər bir qrup bitdikdən sonra növbəti qrupa keçid edilir.

### 🟢 BATCH 1: Core Adaptation & Code Splitting (Done - [ID-158] - [ID-162])
*   **Məzmun:** Fon növbələşməsi, dynamic wizard qiymət hesablama estimator, modalların responsive daşmaları, components split (lazy/eager), Sentry error boundary və TS type-safety.
*   **Status:** TAMAMLANIB ✅

### 🟢 BATCH 2: Social Proof & Metrics Counter (Done - [ID-163])
*   **Məzmun:** Stats (Metrics) counter animations, 6 premium localized projects seeding, Hero above-the-fold kicker badge & rating layer, CTA micro-trust checkmark, global trust logos row, inputs focus rings.
*   **Status:** TAMAMLANIB ✅

### 🟡 BATCH 3: Layout Alignment & Content Cleanup (ACTIVE BATCH 🚀)
*   **Məzmun:**
    - [ ] **1.1 Light Mode Hero Particles:** Partikl sıxlığını 40-a endirmək, opacity 0.05 etmək, rəngini zərif bənövşəyi etmək.
    - [ ] **1.4 Marquee Position Fix:** Marquee lentini səhifənin aşağısından birbaşa **Hero bölməsinin altına** daşımaq.
    - [ ] **1.6 Real Data Swap (Theodore Lowe):** "Theodore Lowe" və saxta Azusa ünvanlarını silmək, real Chalang əlaqə məlumatları ilə əvəz etmək.
    - [ ] **1.8 Left-Align Pricing Plan Details:** Tarif bəndlərini sol kənara sıxışdıraraq oxunmanı sürətləndirmək.
*   **Status:** AKTİV İCRADADIR 🚀

### 🟣 BATCH 4: Premium Header/Footer & Glassmorphism Depth
*   **Məzmun:**
    - [ ] **1.5 Footer Light Mode 4-Sütunlu Grid:** Footer gridini 4 sütunlu premium responsive etmək, light/dark rejimləri cilalamaq.
    - [ ] **2.1 Glass Card Borders & Shadows (Light Mode):** Ağ fon üzərində itən kartlara zərif `border-white/80` sərhəd və `shadow-xl shadow-black/[0.03]` kölgəsi əlavə etmək.
    - [ ] **2.3 Sticky & Blur Header (Navbar):** Navbar-ı `sticky top-0 z-50 backdrop-blur-md` etmək.
    - [ ] **2.4 Glass Card Contrast (Dark Mode):** Qaranlıq kartların qeyri-şəffaflığını `bg-brand-surface/90` səviyyəsinə qaldırıb blur effektini gücləndirmək.
*   **Status:** GÖZLƏYİR ⏳

### 🟣 BATCH 5: Ambient Lighting, Mockup Swap & Easing
*   **Məzmun:**
    - [ ] **2.2 Theme-sensitive Mockups Swapping:** Işıqlı və qaranlıq rejimlərə uyğun mockup panel təsvirlərinin swapped edilməsi.
    - [ ] **2.5 Image Brightness Overlay (Dark Mode):** Şəkillərə tünd örtük (`bg-black/15`) vermək, hover zamanı transit etmək.
    - [ ] **2.6 Text line-width constraint (`max-w-[65ch]`):** Mətn sətir genişliyini oxunaqlı limitlərdə məhdudlaşdırmaq.
    - [ ] **2.7 Section Transition Animations:** Bölmələr arası rəvan, zərif fade-in keçidləri.
*   **Status:** GÖZLƏYİR ⏳

### 🟣 BATCH 6: Interaction Depth & Proactive AI Chatbot
*   **Məzmun:**
    - [ ] **3.1 Map Geo-markers Interactive Tooltips:** Dünya xəritəsindəki coğrafi nöqtələrə hover zamanı açılan tooltip-lər.
    - [ ] **3.2 Testimonials Slider Navigation:** Slayderə desktop rejimdə aydın görünən premium ox düymələri və nöqtələr əlavə etmək.
    - [ ] **3.4/3.5 Cards Micro-interactions & Hover-Preview:** Xidmət və Portfolio kartlarına premium hover effektləri, glow beams, zoom-fade və overlay info əlavə etmək.
    - [ ] **4.1 Proactive Sales-First AI Chatbot:** Basic AIWidget-i ziyarətçini dərəcələndirən və QuoteModal-a yönləndirən aktiv sales agent widget-inə çevirmək.
*   **Status:** GÖZLƏYİR ⏳

---

## 🏛️ Memarlıq Qeydi və Təhlükəsizlik Prinsipləri

Bu sənəd **Chalang** layihəsinin React/Inertia platformasına miqrasiyasını mükəmməlləşdirmək, vizual estetikası ilə istifadəçini heyrətləndirmək və performansı qlobal standartlara (Lighthouse >= 95) çatdırmaq üçün hazırlanmışdır.

### ⚠️ MEMARLIQ XƏBƏRDARLIĞI: Kontekstə Həssas Scroll-Mövzu Dəyişməsi
Audit II - Bənd 3.1-də təklif olunan "İstifadəçi səhifəni sürüşdürdükcə mövzunun avtomatik və məcburi dəyişməsi" (məs. Texnologiya = Qaranlıq, HR = İşıqlı) **ciddi bir UX/UI xətası hesab olunur**. Bu yanaşma istifadəçidə visual disorientasiya və göz yorğunluğu yaradır. 

**Senior Architect Tövsiyəsi (Seçim 2 - İcra Olunacaq):**
Mövzu state-i (Light/Dark) istifadəçinin öz iradəsinə buraxılmalıdır. Lakin hər bölmənin daxili elementləri (kartlar, arxa plan gradient şəbəkələri və işıq effektləri) mövcud mövzunun daxilində elə premium dizayn edilməlidir ki, müvafiq biznes bölməsinin (məs. AI/Blokçeyn və ya Human Resources) ruhunu tam əks etdirsin.

---

## 📊 MÖVCUD VƏZİYYƏTİN VİZUAL STATİSTİKASI

```
[████████████████████] 100% — Tamamlanan Core Texniki Altyapı
[██████████░░░░░░░░░░] 50%  — UI/UX Cilalama və Premium Feel
[████░░░░░░░░░░░░░░░░] 20%  — Dinamik İnteraktivlik və Satış Alətləri
```

---

## 🛠️ ARTIQ TAMAMLANMIŞ VƏ QORUNACAQ ELEMENTLƏR
*   **Hissəcik (Particle) Loqo Optimizasiyası (Done - [ID-161]):** `IntersectionObserver` inteqrasiya edilib (səhifədən çıxanda loop dondurulur). Fitts Qanunu bounding hitbox (siçanın reaksiya zonası yalnız sağ panelə sıxışdırılıb, sol CTA-lar və navbar toxunulmazdır).
*   **Vestibulyar Problem Dəstəyi (Done - [ID-161]):** `prefers-reduced-motion` CSS/JS fallback-i yazılıb, animasiya hərəkətsiz rejimdə statik, yüksək keyfiyyətli loqo təsviri ilə əvəz olunur.
*   **Qaranlıq Mövzu Mətn Kontrastı (Done - [ID-160]):** Tünd boz mətnlər `#CCCCCC` səviyyəsinə qaldırılıb, oxunaqlı və tolerant kontrast təmin edilib.
*   **İkili Mövzu Fon Növbələşməsi (Done - [ID-162]):** Bütün bölmələrə premium ardıcıl fon sistemi (`bg-[var(--bg-primary)]` və `bg-[var(--bg-secondary)]`) tətbiq edilib.
*   **Ağıllı Qiymət Hesablayıcı (Done - [ID-158]):** `Estimator.tsx` tamamilə yenilənərək 5 addımlı premium interaktiv Wizard flow-na keçirilib (AZN/USD valyuta dəstəyi ilə).
*   **Təklif Alın Modalı (Done - [ID-159]):** Mobil overflow daşmaları ləğv edilib, close düyməsi toxunma standartlarına (44px) uyğun yerləşdirilib.

---

## 🚀 4 FAZALI TAMAMLAMA YOL XƏRİTƏSİ

### FAZA 1: Rəqəmsal Təmizlik, Əlçatanlıq (A11y) və Ən Kritik UI Fixlər (P0 - Kritik)
*Məqsəd: Brend imicini zədələyən şablon qüsurlarını və dağılmış strukturları dərhal bərpa etmək.*

#### ⚠️ 1.1 Hero Particle Sıxlığının Azaldılması (Light Mode)
*   **İzahı:** İşıqlı rejimdə partiklların sıxlığı və xətlərin kəskinliyi başlığın oxunmasına mane olur.
*   **Tədbir:** Light mode-da partikl sayını (`value: 40`), xətlərin şəffaflığını (`opacity: 0.05`) və rəngini açıq bənövşəyi/boz (`rgba(75, 0, 130, 0.08)`) etmək.
*   **Fayl:** `resources/js/Components/Sections/Hero.tsx`

#### [x] 1.2 Portfolio Grid Genişləndirilməsi (4-6 Layihə Kartı)
*   **İzahı:** Hazırda portfel yalnız 1 layihə göstərir ki, bu da səhifəni boş göstərir.
*   **Tədbir:** Həm backend-də seeds məlumatlarını artırmaq, həm də frontend portfolio grid-ini ən azı 4-6 ədəd dolğun premium kart ilə təmin etmək.
*   **Fayl:** `resources/js/Components/Sections/Portfolio.tsx`, `database/seeders/*`
*   **Nəticə:** `PortfolioSeeder.php` vasitəsilə 6 ədəd premium tam lokallaşdırılmış real-world layihə əlavə olundu və grid dolğunlaşdırıldı.

#### [x] 1.3 Stats (Metrics) CountUp Animasiyasının və Scroll Triggerinin Bərpası
*   **İzahı:** Rəqəmlər heç bir animasiya olmadan statik görünür.
*   **Tədbir:** `IntersectionObserver` triggerini və dynamic Counter məntiqini tam dayanıqlı edərək scroll zamanı rəqəmlərin rəvan şəkildə 0-dan hədəfə artmasını təmin etmək.
*   **Fayl:** `resources/js/Components/Sections/Metrics.tsx`
*   **Nəticə:** Mount, Observer və Scroll-fallback 3-təbəqəli zəmanətli dynamic counter sistemi tamamilə quruldu və bərpa edildi.

#### ⚠️ 1.4 Marquee (Sonsuz Mətn) Mövqeyinin Düzəldilməsi (Hero Altına Daşınması)
*   **İzahı:** Marquee lenti hazırda səhifənin aşağısında unudulub və ya yoxdur.
*   **Tədbir:** `Marquee` komponentini birbaşa **Hero bölməsinin altına** (Hero və Partners arasına) daşımaq və lokallaşdırılmış `marquee_text`-i ona ötürmək.
*   **Fayl:** `resources/js/Pages/Home.tsx`

#### ⚠️ 1.5 Footer Light Mode 4-Sütunlu Grid Strukturunun Bərpası
*   **İzahı:** İşıqlı rejimdə footer-in strukturu zəifdir və responsive grid dağılır.
*   **Tədbir:** Footer-in CSS siniflərini yenidən yazmaq, responsive 4 sütunlu grid qurmaq, şablon linkləri silmək və real şirkət ünvanlarını yerləşdirmək.
*   **Fayl:** `resources/js/Components/Footer.tsx`

#### 1.6 Şablon və Saxta Məlumatların Silinməsi (Theodore Lowe)
*   **İzahı:** Əlaqə və Footer bölmələrindəki "Theodore Lowe, Ap #867-859, Azusa New York" saxta məlumatlarının silinməsi.
*   **Tədbir:** Həmin mətnləri real Chalang məlumatları ilə əvəz etmək.
*   **Fayl:** `resources/js/Components/Sections/Contact.tsx`, `resources/js/Components/Footer.tsx`

#### [x] 1.7 Input Fokus Çərçivələri (Focus Rings)
*   **İzahı:** Səhifədə TAB ilə naviqasiya edən fiziki məhdudiyyətli şəxslər üçün input fokusunun görünməməsi.
*   **Tədbir:** Bütün form elementlərinə `focus-visible:ring-2 focus-visible:ring-brand-secondary` tətbiq etmək.
*   **Fayl:** `resources/js/Components/Sections/Contact.tsx`, `QuoteModal.tsx`
*   **Nəticə:** `QuoteModal.tsx` form daxilindəki bütün sahələrə fokus halqaları (focus rings) və hamar transition-lar tətbiq edildi.

#### 1.8 Tariflərin Sol Kənara Hizalanması
*   **İzahı:** Tarif bəndlərinin mərkəzə hizalanması gözün F-paterni üzrə sürətli oxumasını çətinləşdirir.
*   **Tədbir:** Siyahı bəndlərini sol kənara sıxışdırmaq.
*   **Fayl:** `resources/js/Components/Sections/Pricing.tsx`

---

### FAZA 2: Premium UI, Mövzu Həssaslığı və Vizual Cilalama (P1 - Yüksək)
*Məqsəd: İşıqlı və qaranlıq mövzulara heyrətamiz premium dərinlik və vizual kontrast qazandırmaq.*

#### 2.1 Şüşə Kart Dərinliyi (Borders & Shadows - Light Mode)
*   **İzahı:** İşıqlı rejimdə şüşə (glassmorphism) kartlar ağ fonun üzərində tamamilə itir.
*   **Tədbir:** İşıqlı rejimdə kartlara yüngül, geniş yayılan premium kölgə (`shadow-xl shadow-black/[0.03]`) və incə ağ/bənövşəyi sərhəd (`border-white/80`) vermək.
*   **Fayl:** `resources/js/Components/Sections/Services.tsx`, `WhoWeAre.tsx`

#### 2.2 Mövzuya Həssas Dinamik Mokaplar (Mockups picture swap)
*   **İzahı:** Light mode-da dark mockup görünməsi vizual harmoniyanı pozur.
*   **Tədbir:** HTML5 `<picture>` teqi və ya React daxili state-i ilə işıqlı mövzuda işıqlı dashboard panel təsvirinin, qaranlıqda tünd panel təsvirinin göstərilməsi.
*   **Fayl:** `resources/js/Components/Sections/Hero.tsx` (Dashboard Mockup hissəsi)

#### 2.3 Sticky & Blur Header (Navbar)
*   **İzahı:** Saytı sürüşdürərkən naviqasiya paneli yoxa çıxır və ya altından keçən yazılarla qarışır.
*   **Tədbir:** Navbar-ı `sticky top-0 z-50` etmək, arxa fonunu yarı şəffaf edib `backdrop-blur-md` əlavə etmək.
*   **Fayl:** `resources/js/Components/Navbar.tsx`

#### 2.4 Şüşə Kart Kontrastı (Dark Mode Opacity 85-90%)
*   **İzahı:** Qaranlıq mövzuda partikllar şüşə kartın daxilindəki mətnlərin arxasından keçərkən oxunuşu pozur.
*   **Tədbir:** Şüşə kartların qeyri-şəffaflığını `bg-brand-surface/90` səviyyəsinə qaldırmaq və bulanıqlığı (blur) gücləndirmək.
*   **Fayl:** `resources/js/Components/Sections/Services.tsx`

#### 2.5 Şəkillərə Parlaqlıq Örtüyü (Dark Mode Overlay)
*   **İzahı:** Qaranlıq mövzuda parlaq, ağ rəngli fotolar istifadəçinin gözünü qamaşdırır.
*   **Tədbir:** Şəkillərə default olaraq 10-15% qeyri-şəffaflığı olan tünd qat (`bg-black/15`) tətbiq etmək, hover edildikdə isə transition ilə şəklin əsl parlaqlığını bərpa etmək.
*   **Fayl:** `resources/js/Components/Sections/WhoWeAre.tsx`, `TeamGrid.tsx`

#### 2.6 Mətn Sətir Genişliyinin Məhdudlaşdırılması
*   **İzahı:** Xüsusilə "Niyə biz?" kartlarındakı uzun mətn sətirləri oxumanı çətinləşdirir.
*   **Tədbir:** Təsvir elementlərinə `max-w-[65ch]` tətbiq edərək sətirdə simvol sayını 45-75 aralığında saxlamaq.
*   **Fayl:** `resources/js/Components/Sections/WhoWeAre.tsx`

#### 2.7 Bölmələr Arası Səlis Keçid Animasiyaları (Section Transitions)
*   **İzahı:** Səhifəni sürüşdürdükcə bölmələrin qəflətən görünməsi.
*   **Tədbir:** `LazySection` elementlərinə AOS və ya custom CSS ilə zərif rəvan fade-in keçidləri təyin etmək.
*   **Fayl:** `resources/js/Components/ui/Layout.tsx`

---

### FAZA 3: İnteraktivlik, Məzmun və Konversiya (P2 - Orta)
*Məqsəd: Saytın dinamikliyini artırmaq və ziyarətçini cəlb edən interaktiv elementləri işə salmaq.*

#### 3.1 Dünya Xəritəsi Coğrafi Nöqtə Tooltip-ləri
*   **İzahı:** Xəritədəki regional nöqtələr (Baku, NY, Dubai, Swiss) statikdir və heç bir məlumat vermir.
*   **Tədbir:** Hər nöqtəyə hover zamanı açılan, həmin regiondakı fəaliyyətimiz və qazandığımız uğurlar barədə qısa, lokallaşdırılmış məlumat verən premium tooltip-lər tətbiq etmək.
*   **Fayl:** `resources/js/Components/Sections/Process.tsx`

#### 3.2 Testimonials Carousel Slayder Naviqasiyası (Oxlar & Nöqtələr)
*   **İzahı:** Rəylər bölməsi sürüşdürülə bilsə də, desktop ekranlarda naviqasiya oxları yoxdur.
*   **Tədbir:** Slayderə desktop rejimdə aydın görünən premium sağ/sol ox düymələri və aşağı paginasiya nöqtələri (dots) əlavə etmək.
*   **Fayl:** `resources/js/Components/Sections/Testimonials.tsx`

#### 3.3 Xidmət Mətnlərinin "AI-First" Kopiraytinqi
*   **İzahı:** Xidmət təsvirləri çox ümumidir və Chalang-ın AI/Data gücünü tam əks etdirir.
*   **Tədbir:** Mətnləri LLM, Prediktiv Analitika və Avtomatlaşdırma alətlərini vurğulayacaq şəkildə lokallaşdırılmış dildə yenidən redaktə etmək.
*   **Fayl:** `resources/lang/*`, `database/seeders/*`

#### 3.4 Xidmət Kartlarının premium micro-interactions ilə zənginləşdirilməsi
*   **İzahı:** Xidmət kartlarının hover effektləri sadədir.
*   **Tədbir:** Hover zamanı zərif kənar işıqlanması (glow border), daxili ikonun yüngülcə yuxarı sıçraması kimi micro-animations əlavə etmək.
*   **Fayl:** `resources/js/Components/Sections/Services.tsx`

#### 3.5 Portfolio Layihə Kartlarının Hover-Preview Effekti
*   **İzahı:** Layihə kartları statik şəkillərlə çox sadə görünür.
*   **Tədbir:** Hover zamanı şəklin zərif böyüməsi, layihə haqqında gizli overlay məlumatın rəvan açılması və vizual preview dəstəyi.
*   **Fayl:** `resources/js/Components/Sections/Portfolio.tsx`

---

### FAZA 4: Satış, SEO, Brendin Qorunması və Qlobal Hazırlıq (P3 - Strateji)
*Məqsəd: Vebsaytı fəal satış alətinə çevirmək və qlobal rəqabətdə brendi qabağa çıxarmaq.*

#### 4.1 İnteqrasiya Edilmiş Satış Yönümlü "Chalang AI Agenti" (Chatbot)
*   **İzahı:** Mövcud AIWidget sadə sual-cavab funksiyası daşıyır.
*   **Tədbir:** Ziyarətçinin biznes ehtiyaclarını sorğulayan, onları dərəcələndirən və birbaşa fərdi QuoteModal-a yönləndirən aktiv sales agent chatbot widget-inə çevrilməsi.
*   **Fayl:** `resources/js/Components/Sections/AIWidget.tsx`

#### 4.2 Tableau və Power BI Mini-Demoları
*   **İzahı:** Şirkətin data analitika gücünü potensial müştərilərə göstərəcək heç bir əyani sübut yoxdur.
*   **Tədbir:** Xüsusi bölmədə interaktiv mini data panellərinin (Mini Dashboards) vizual demolarını və ROI hesablama panellərini nümayiş etdirmək.
*   **Fayl:** `resources/js/Components/Sections/HallOfFame.tsx` və ya yeni xüsusi bölmə.

#### 4.3 Real, Detallı Biznes Keysləri (Case Studies)
*   **İzahı:** Portfolio-dakı layihələr sadəcə şəkillərdən ibarətdir, görülən işin mürəkkəbliyini göstərmir.
*   **Tədbir:** Minimum 3 ədəd real biznes keysini (müştəri problemi, Chalang AI həlli, ROI rəqəmləri) tam lokallaşdırılmış şəkildə portfelə daxil etmək.
*   **Fayl:** `database/seeders/*`

#### 4.4 Qlobal SEO & Long-Tail Açar Söz Strategiyası
*   **İzahı:** "Challenge Group" kimi qlobal nəhənglərlə rəqabət aparmaq üçün domen strategiyası zəifdir.
*   **Tədbir:** Saytın meta data və alt-teqlərinə "Chalang AI Solutions", "Chalang Creative Tech Agency", "Predictive Analytics Consulting Chalang" kimi daha niş açar sözlər yerləşdirmək.
*   **Fayl:** `resources/js/Pages/Home.tsx` (Meta Data sections)

#### 4.5 Çoxdilli İnteqrasiya və Keçidlərin Yoxlanılması
*   **İzahı:** Dil keçidlərində qırıq linklər və ya şablon qalan bölmələr ola bilər.
*   **Tədbir:** AZ, EN və RU arasındakı bütün marşrutları (routing) və translation fayllarını (transcreation daxil olmaqla) 100% yoxlamaq və təmizləmək.
*   **Fayl:** `resources/lang/*`, `routes/web.php`

---

# 📋 MASTER GAP FIX TASKS (İnteraktivlik, Motion və Psixologiya)

Aşağıdakı bölmə layihənin dizayn, motion, emosional və konversiya dərinliyini 100% bağlamaq üçün müəyyən edilmiş master tapşırıqlar siyahısıdır.

## 1. HERO — Conversion & Trust Layer

### Conversion Psychology
- [ ] Hero CTA hierarchy-ni conversion-first sistemə çevir.
- [ ] Primary CTA-nı vizual dominant et (`scale + glow + contrast`).
- [ ] Secondary CTA-nı passive visual state-ə sal.
- [ ] Hero altına trust logos marquee əlavə et.
- [ ] Hero daxilinə “social proof metrics” əlavə et.
- [ ] Hero üçün stronger positioning copy yaz.
- [ ] Hero subtitle-də nəticə yönümlü messaging istifadə et.
- [ ] CTA altında micro-trust text əlavə et.
- [ ] Above-the-fold hissədə “why choose us” signalı əlavə et.

### Hero Visual System
- [ ] Particle system-i branded visual language-a çevir.
- [ ] Particle motion üçün idle animation əlavə et.
- [ ] Mouse interaction smoothing əlavə et.
- [ ] Particle opacity randomization balanslaşdır.
- [ ] Hero sağ hissəsində empty space hissini azalt.
- [ ] Hero visual üçün ambient lighting layer əlavə et.
- [ ] Logo silhouette visibility artır.
- [ ] Particle animation üçün cinematic easing istifadə et.
- [ ] GPU accelerated render optimizasiyası et.

---

## 2. DARK MODE — Immersion Layer

### Premium Atmosphere
- [ ] Section-lar arasında ambient glow continuity yarat.
- [ ] Background gradient transitions unify et.
- [ ] Glow intensity system standardize et.
- [ ] Border opacity hierarchy qur.
- [ ] Section depth layering artır.
- [ ] Background noise texture əlavə et.
- [ ] Cinematic blur transitions əlavə et.
- [ ] Scroll zamanı ambient lighting dəyişiklikləri əlavə et.

### Interaction Polish
- [ ] Hover glow states bütün component-lərdə unify et.
- [ ] Dark surfaces üçün elevation hierarchy qur.
- [ ] Card hover depth effect əlavə et.
- [ ] Scroll reveal animation-larını synchronize et.
- [ ] Section entry motion-larını cinematic et.

---

## 3. LIGHT MODE — Premium Rebuild

### Visual Depth
- [ ] Flat white background-ları layered systemə çevir.
- [ ] Ambient purple gradient layer əlavə et.
- [ ] Glassmorphism blur surfaces əlavə et.
- [ ] Layered shadow hierarchy qur.
- [ ] Light mode üçün subtle texture overlay əlavə et.
- [ ] Section background separation artır.
- [ ] Card elevation system light mode üçün ayrıca balanslaşdır.
- [ ] Surface contrast hierarchy yarat.

### Premium Feel
- [ ] Light mode hover states gücləndir.
- [ ] White sections arasında visual depth yarat.
- [ ] Soft lighting system əlavə et.
- [ ] Gradient transition-ları light mode üçün ayrıca tune et.
- [ ] Generic template hissini azalt.
- [ ] Premium SaaS hissini light mode-da da qoruyub saxla.

---

## 4. NAVBAR — Premium Interface Layer

### Sticky Behavior
- [ ] Navbar scroll transition-larını cinematic et.
- [ ] Sticky navbar blur intensity artır.
- [ ] Scroll zamanı navbar shrink behavior əlavə et.
- [ ] Navbar opacity transitions optimize et.
- [ ] Active nav item üçün animated indicator əlavə et.
- [ ] Hover states unify et.
- [ ] Sticky navbar-a ambient border glow əlavə et.

### Navigation UX
- [ ] Navigation spacing ratios balanslaşdır.
- [ ] Mobile navbar interaction polish et.
- [ ] Navbar CTA visibility artır.
- [ ] Current section tracking sistemi əlavə et.
- [ ] Scroll spy sistemi əlavə et.

---

## 5. SERVICES SECTION — Interaction Depth

### Card System
- [ ] Service card-lara tactile hover interaction əlavə et.
- [ ] Hover zamanı elevation artır.
- [ ] Border glow animation əlavə et.
- [ ] Icon interaction states əlavə et.
- [ ] Card daxilində visual rhythm optimallaşdır.
- [ ] CTA hover micro-animation əlavə et.
- [ ] Service cards üçün subtle motion əlavə et.

### Storytelling
- [ ] Service descriptions daha outcome-focused et.
- [ ] Service hierarchy-ni stronger et.
- [ ] Service section intro messaging improve et.
- [ ] User journey flow ilə uyğunlaşdır.

---

## 6. PORTFOLIO — Premium Showcase Rebuild

### Immersive Presentation
- [ ] Portfolio section-i “project grid” yox, “experience showcase” formatına çevir.
- [ ] Hover preview sistemi əlavə et.
- [ ] Mouse-follow interaction əlavə et.
- [ ] Cinematic image transitions əlavə et.
- [ ] Portfolio overlay gradients əlavə et.
- [ ] Dynamic motion previews əlavə et.
- [ ] Video preview support əlavə et.
- [ ] Scroll-based reveal animations əlavə et.

### Case Study Layer
- [ ] Hər project üçün mini case-study flow əlavə et.
- [ ] Metrics/results showcase əlavə et.
- [ ] Emotional storytelling layer əlavə et.
- [ ] “Before / After” visual logic əlavə et.
- [ ] Project detail CTA-larını gücləndir.

---

## 7. PROCESS SECTION — Interactive Flow

### Scroll Experience
- [ ] Step progression animation əlavə et.
- [ ] Active step highlight sistemi qur.
- [ ] Scroll-linked connector animations əlavə et.
- [ ] Timeline interaction əlavə et.
- [ ] Section transition motion-larını cinematic et.

### Storytelling
- [ ] Hər step üçün clearer value messaging yaz.
- [ ] Process flow-u daha emotional et.
- [ ] “What happens next?” guidance əlavə et.

---

## 8. PRICING — Conversion Engine

### Pricing Psychology
- [ ] Pricing section-i decision-making sisteminə çevir.
- [ ] Recommended package dominance artır.
- [ ] Enterprise tier premium hissini gücləndir.
- [ ] Compare table əlavə et.
- [ ] Pricing reassurance text əlavə et.
- [ ] “Best for” labels əlavə et.
- [ ] Risk-reduction messaging əlavə et.
- [ ] Decision fatigue azalt.

### Interaction Layer
- [ ] Pricing card hover elevation artır.
- [ ] Feature reveal animations əlavə et.
- [ ] Billing toggle animation polish et.
- [ ] CTA hierarchy pricing daxilində optimallaşdır.

---

## 9. FORM SECTION — Smart Conversion UX

### Conversion Flow
- [ ] Multi-step form flow əlavə et.
- [ ] Progress indicator əlavə et.
- [ ] Real-time estimate logic əlavə et.
- [ ] Smart field suggestions əlavə et.
- [ ] Dynamic feedback system əlavə et.
- [ ] Emotional reassurance copy əlavə et.

### UX Polish
- [ ] Input focus states premium et.
- [ ] Success state redesign et.
- [ ] Form transitions smooth et.
- [ ] Mobile form spacing optimallaşdır.

---

## 10. STATS SECTION — Authority Layer

### Trust & Proof
- [ ] Stat cards üçün stronger hierarchy qur.
- [ ] Real client/company references əlavə et.
- [ ] Metrics yanında proof indicators əlavə et.
- [ ] Count-up timing polish et.
- [ ] Stats presentation-i cinematic et.

---

## 11. DESIGN SYSTEM — Consistency Rebuild

### Token System
- [ ] Unified spacing token sistemi qur.
- [ ] Glow system standardize et.
- [ ] Border language unify et.
- [ ] Radius hierarchy standardize et.
- [ ] Shadow hierarchy unify et.
- [ ] Typography scale system yarat.
- [ ] Motion timing system standardize et.

### Component Consistency
- [ ] Hover behavior-ları bütün saytda unify et.
- [ ] Transition durations standardize et.
- [ ] Button variants consistency audit et.
- [ ] Section container widths unify et.

---

## 12. MOTION SYSTEM — Experience Layer

### Cinematic Motion
- [ ] Scroll choreography sistemi qur.
- [ ] Section reveal timing-lərini cinematic et.
- [ ] Depth parallax sistemi əlavə et.
- [ ] Cursor-reactive ambient effects əlavə et.
- [ ] Motion easing system unify et.
- [ ] Motion rhythm consistency yarat.

### Advanced Interaction
- [ ] Hover → focus → active state transitions əlavə et.
- [ ] Magnetic button interactions əlavə et.
- [ ] Dynamic lighting motion əlavə et.
- [ ] Scroll-linked ambient animations əlavə et.
- [ ] Interactive depth system qur.

---

## 13. FINAL EXPERIENCE POLISH

### Premium Product Feel
- [ ] Agency website hissini azalt.
- [ ] Product experience hissini artır.
- [ ] Emotional interaction layer əlavə et.
- [ ] Interface-i daha tactile hiss etdir.
- [ ] User immersion depth artır.
- [ ] Scroll journey-ni cinematic experience et.
- [ ] Premium digital product aesthetic-i tamlaşdır.

---

## 📅 İCRA PROTOKOLU (Strictly Agentic Rules)

1.  **Ardıcıllıq Zəmanəti:** Yuxarıdan aşağıya doğru **Faza 1 (P0)** tapşırıqları tam bitmədən **Faza 2-yə keçmək qətiyyən qadağandır**.
2.  **Sıfır Xəta Prinsipləri:** Hər bir addımın icrasından sonra backend/frontend build integrity (`npm run build`) mütləq yoxlanılmalı və hesabat verilməlidir.
3.  **İş Hesabatı (Work Log):** Hər hansı bir tapşırıq qrupu icra edildikdən sonra mütləq `work_log.md` faylında növbəti ID ardıcıllığı ilə sübutlar (PROOF) göstərilməlidir.

---
**Lead Senior System Architect (Antigravity Core)**  
*Chalang Project Development Division*
