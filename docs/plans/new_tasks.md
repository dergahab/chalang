# 📘 HİSSƏ 1: CHALANG MASTER ROADMAP (PHASES 0-12)

Burada agentliyin bütün inkişaf mərhələləri ardıcıl, unikal nömrələnmiş şəkildə qeyd olunub.

---

## 🏗️ 1.0. Phase 0: Təcili Düzəlişlər (Immediate Tech Debt)

Texniki borcların təmizlənməsi və sistemin ilkin stabilizasiyası.

- **1.0.1. [x] P0: Analytics:** AnalyticsController-ə portfolios count əlavə etmək (qrafik xətası) <!-- id: 1 -->
- **1.0.2. [x] P0: Helpers:** helpers.php-də `wher` typosunu düzəltmək və null-safe etmək <!-- id: 2 -->
- **1.0.3. [x] P0: BaseController:** Namespace və extends düzəlişi <!-- id: 3 -->
- **1.0.4. [x] P0: Security:** Fayl yükləmə Limitləri (max size, mime types) <!-- id: 4 -->
- **1.0.5. [x] P0: Coming Soon:** MainController-də local/prod gate-ini DB toggle-a keçirmək <!-- id: 5 -->
- **1.0.6. [ ] P1: SEO Core:** Translatable Slugs (Çoxdilli URL-lər) və Breadcrumb sisteminin qurulması <!-- id: 539 -->
- **1.0.7. [x] P0: Critical Fixes (Phase 1 Blocking):**
  - 1.0.7.1. [x] P0: **Lang Model Fix**: Added `getCodeAttribute` accessor to `Lang` model to fix `code` vs `lang` mismatch <!-- completed 2025-12-23 -->
  - 1.0.7.2. [x] P0: **Admin Route Fix**: Added missing `faq.is_active` route to `routes/admin.php` <!-- completed 2025-12-23 -->
  - 1.0.7.3. [x] P0: **Service Page Parsing Fix**: Resolved `ParseError` in `single.blade.php` and cleaned up syntax <!-- completed 2025-12-27 -->
  - 1.0.7.4. [x] P0: **Admin Relationships**: Implemented Service <-> Case Study & Testimonial relations in Admin Panel <!-- completed 2025-12-29 -->
- **1.0.8. [x] P0: `.env.example` Təmizliyi**: Real Pusher kredensialları placeholder-la əvəz olundu, `BROADCAST_DRIVER=log` əlavə edildi <!-- id: 1000 -->
- **1.0.9. [x] P0: Duplicate Route-ların Təmizlənməsi**: `experiments.*` və `performance.*` route qrupları `routes/admin.php`-də 2 dəfə təyin olunub, biri silindi <!-- id: 1001 -->
- **1.0.10. [x] P0: Typo Class Adlarının Düzəldilməsi**:
  - 1.0.10.1. [x] P0: `StepSerive.php` silindi, `StepController` import-u `StepService`-ə düzəldildi <!-- id: 1002 -->
  - 1.0.10.2. [x] P0: `PortfolioSerice.php` → `PortfolioService.php` rename, class name + controller import düzəldildi <!-- id: 1003 -->
  - 1.0.10.3. [x] P0: `ContenttextController`-də `$contenttextserive` → `$contentTextService` düzəldildi <!-- id: 1004 -->
  - 1.0.10.4. [x] P0: `AboutController`-dən `Cassandra\Collection` import silindi <!-- id: 1005 -->
- **1.0.11. [x] P0: Ölü Kodun Təmizlənməsi**:
  - 1.0.11.1. [x] P0: `PsService::save()`-də `return $request->all()` sətri silindi, altındakı kod işlək hala gətirildi <!-- id: 1006 -->
  - 1.0.11.2. [x] P0: `PortfolioController.php:103` garbage flash mesajı düzəldildi <!-- id: 1007 -->
  - 1.0.11.3. [x] P0: `ContentTextService.php:60` reach olunmayan `return 'success'` silindi <!-- id: 1008 -->
  - 1.0.11.4. [x] P0: `AboutController.php:28-38` duplicate image upload bloku təmizləndi <!-- id: 1009 -->
- **1.0.12. [x] P0: Dead Code Fayllarının Təmizlənməsi**:
  - 1.0.12.1. [x] P0: `webpack.mix.js` - Vite-ə keçid tamamlandıqdan sonra silinməlidir <!-- id: 1010 -->
  - 1.0.12.2. [x] P0: `resources/js/Components/`-də duplikat komponentlərin təmizlənməsi (Button, Card, Skeleton, ScrollProgress, NewsletterPopup - `ui/` versiyaları saxlanmalı) <!-- id: 1011 -->
  - 1.0.12.3. [x] P0: `CTASection.tsx`, `BackToTop.tsx` - istifadə olunmayan fayllar silinməlidir <!-- id: 1012 -->

---

## 🧠 1.1. Phase 1: Məzmun və AI (AI & Content)

Agentliyin "Beyni" – Süni Zəka alətləri və kontent strategiyası.

- **1.1.1. [ ] AI Tools Integration**
  - **1.1.1.1. [ ] P2: Avtomatik tərcümə (AZ↔EN/RU) düyməsi** <!-- id: 6 -->
  - **1.1.1.2. [ ] P2: AI copywriter (SEO yönümlü mətn generasiya)** <!-- id: 7 -->
  - **1.1.1.3. [ ] P2: SEO meta təklifi (title/description/keywords)** <!-- id: 8 -->
  - **1.1.1.4. [ ] P1: AI "Chalang AI" Persona Setup: Mərkəzi AI asistentin səs tonu və şəxsiyyət ayarları** <!-- id: 534 -->
  - **1.1.1.5. [ ] P2: AI content QA (dil/stil/oxunaqlıq yoxlaması)** <!-- id: 9 -->
  - **1.1.1.6. [ ] P1: AI Project Brief Generator: Müştəri müraciəti əsasında avtomatik brif hazırlanması** <!-- id: 187 -->
  - **1.1.1.7. [ ] P2: AI Tone of Voice Audit: Mətnin brend stilinə uyğunluq yoxlaması** <!-- id: 179 -->
  - **1.1.1.8. [ ] P2: AI Global Brand Persona: Cavablar üçün vahid brend "səs tonu"** <!-- id: 193 -->
  - **1.1.1.9. [ ] P2: AI Semantic Content Mapping: Avtomatik "əlaqəli bloq" xəritəsi** <!-- id: 194 -->
  - **1.1.1.10. [ ] P3: AI Voiceover (Blog-to-Audio): Bloq yazılarını audio formata keçirmə** <!-- id: 195 -->
  - **1.1.1.11. [ ] P3: AI Meeting Notes Summarizer: Görüş qeydlərinin avto-xülasəsi** <!-- id: 196 -->
  - **1.1.1.12. [ ] P3: AI Proposal Generator: Brif əsasında PDF layihə təklifi bərpası** <!-- id: 197 -->
  - **1.1.1.13. [ ] P2: AI Social Caption Content: LinkedIn/X üçün avtomatik post hazırlayıcı** <!-- id: 180 -->
  - **1.1.1.14. [ ] P2: AI Intelligent Search: Xidmətlər daxilində "semantik" axtarış və yönləndirmə** <!-- id: 172 -->
  - **1.1.1.15. [ ] P1: AI Portfolio Training (RAG): AI asistentin keçmiş layihələri (Portfolio) "öyrənməsi"** <!-- id: 173 -->
  - **1.1.1.16. [ ] P3: AI Image Upscaling: Media şəkillərinin AI ilə böyüdülməsi** <!-- id: 228 -->
  - **1.1.1.17. [ ] P2: AI Auto-Alt Text: SEO üçün şəkillərə avtomatik alt-təsvir** <!-- id: 229 -->
  - **1.1.1.18. [ ] P2: AI Portfolio Mood & Pace Inference: Portfolio işləri üçün avtomatik aura və temp təyini** <!-- id: 535 -->
  - **1.1.1.19. [ ] P2: AI Empty State Content: Boş səhifələr üçün kreativ cavablar** <!-- id: 230 -->
  - **1.1.1.20. [ ] P2: AI Style Guide Enforcer: Dizayn uyğunluğunun avto-yoxlanışı** <!-- id: 231 -->
  - **1.1.1.21. [ ] P2: AI Chatbot Human Hand-off: AI-dan canlı dəstəyə keçid** <!-- id: 232 -->
  - **1.1.1.22. [ ] P3: AI Sentiment Email Reply: Mesajın tonuna görə cavab qaralaması** <!-- id: 233 -->
  - **1.1.1.23. [ ] P3: AI-based Content Cannibalization Check: SEO mətni təkrarlanma yoxlaması** <!-- id: 285 -->
  - **1.1.1.24. [ ] P3: AI-based Hallucination Check: AI kontentində yanlışlıq yoxlaması** <!-- id: 301 -->
  - **1.1.1.25. [ ] P3: Brand Voice Identity Guard: Brend səs tonunun qorunması** <!-- id: 302 -->
  - **1.1.1.26. [ ] P3: AI-powered Content Refresh: Köhnə kontenti yeniləmə təklifləri** <!-- id: 338 -->
  - **1.1.1.27. [ ] P3: AI Model Fine-tuning Pipeline: Brend dilinə uyğun model təlimi** <!-- id: 351 -->
  - **1.1.1.28. [ ] P3: AI Video Generation: Mətndən video/snippet yaradılması** <!-- id: 352 -->
  - **1.1.1.29. [ ] P3: AI Audio Dubbing: Çoxdilli audio səsləndirmə** <!-- id: 353 -->
  - **1.1.1.30. [ ] P3: AI Plagiarism & Style Checker: Özgünlük və stil yoxlaması** <!-- id: 354 -->
  - **1.1.1.31. [ ] P3: Podcast Hosting (Blog-to-Podcast): Bloqların audio yayımı mərkəzi** <!-- id: 321 -->
- **1.1.2. [/] Content Management**

---

## 📊 1.2. Phase 2: Analitika və Monitorinq (Analytics & Monitoring)

Agentliyin "Gözləri" – Data əsaslı idarəetmə.

- **1.2.1. [x] P1:** Analyze existing HTML structure and JS
- **1.2.2. [x] P1:** Implement "Smart" calculation logic based on inputs (Service, Size, Urgency)
- **1.2.3. [x] P1:** Update price display dynamically
- **1.2.4. [x] P1:** Ensure logic is appended to chalang-preview.js correctly
- **1.2.5. [x] P1:** Verify Admin Panel connection for dynamic content managements
- **1.2.6. [/] Analytics**
  - 1.2.6.1. [x] P1: **Dashboard Counts** (Services, Blogs, Messages, Users) <!-- id: 20 -->
  - 1.2.6.2. [x] P1: **Message Chart** (Last 7 days) <!-- id: 21 -->
  - 1.2.6.3. [x] P1: **Analytics Settings**: GA4, Meta Pixel, Yandex Metrica Config <!-- id: 22 -->
  - 1.2.6.4. [ ] P2: Canlı ziyarətçi xəritəsi (geo-IP real-time) <!-- id: 23 -->
  - 1.2.6.5. [ ] P2: Heatmap/klik izləmə və vizualizasiya <!-- id: 24 -->
- **1.2.7. [ ] Performance & Conversion**
  - **1.2.7.1. [ ] P2: Lead konversiya/funnel qrafikləri** <!-- id: 25 -->
  - **1.2.7.2. [ ] P2: Uptime/performance + tracing/observability** <!-- id: 26 -->
  - **1.2.7.3. [ ] P2: Anomaliya alertləri (trafik/error artımı)** <!-- id: 27 -->
  - **1.2.7.4. [ ] P2: DB/index və cache optimizasiyası, n+1 profilinqi (Redis strategiyası)** <!-- id: 28 -->
  - **1.2.7.5. [ ] P2: Service Profitability Analytics: Xidmət ROI hesabatları** <!-- id: 198 -->
  - **1.2.7.6. [ ] P1: Performance büdcələri (LCP/TTI/CLS) + ölçmə və alertlər** <!-- id: 29 -->
  - **1.2.7.7. [ ] P3: Page Speed Performance Regression: Sürət azalması zamanı alert** <!-- id: 287 -->
  - **1.2.7.8. [ ] P3: Database Deadlock Monitoring: Baza kilidlənmələrinin izlənməsi** <!-- id: 288 -->
  - **1.2.7.9. [ ] P3: Slow Query Log Analyzer: Zəif sorğuların AI analizi** <!-- id: 289 -->
  - **1.2.7.10. [ ] P3: Memory Leak Detection: Yaddaş sızmalarının tespiti** <!-- id: 290 -->
  - **1.2.7.11. [ ] P3: Automated Database Index Optimization: İndekslərin avto-tənzimlənməsi** <!-- id: 291 -->
  - **1.2.7.12. [ ] P3: AI-driven UX Heatmap: Klik və hərəkət istiliyinin AI analizi** <!-- id: 329 -->
  - **1.2.7.13. [ ] P3: Multi-channel Attribution Model: Reklam kanallarının effektivlik analizi** <!-- id: 349 -->
  - **1.2.7.14. [ ] P3: Performance Benchmarking vs Competitors: Rəqiblərlə müqayisəli analiz** <!-- id: 355 -->
  - **1.2.7.15. [ ] P3: User Journey Prediction: İstifadəçinin növbəti addım proqnozu** <!-- id: 356 -->

---

## 🤝 1.3. Phase 3: CRM və Bildirişlər (CRM/Lead & Notifications)

Agentliyin "Qəlbi" – Müştəri münasibətləri və satış axını.

- **1.3.1. [/] CRM Features**
  - 1.3.1.1. [x] P1: **Messages**: Table + Model + Admin View <!-- id: 30 -->
  - 1.3.1.2. [x] P1: **Submissions**: Table + Model + Admin View <!-- id: 31 -->
  - 1.3.1.3. [x] P1: **Task Helpers**: `task_count_by_status` (in helpers.php) <!-- id: 32 -->
  - 1.3.1.4. [x] P1: **Admin Global Search**: xidmət/portfolio/bloq üzrə tez tapma <!-- id: 33 -->
  - **1.3.1.4.1. [ ] P2: Categorical Grouping: Nəticələrin bölmələr üzrə qruplanması** <!-- id: 562 -->
  - **1.3.1.4.2. [ ] P2: Type Priority: Axtarışda "Type" sıralaması** <!-- id: 563 -->
  - 1.3.1.5. [x] P1: **Kontakt/Form əməliyyatı**: MessageController + adminlərə bildiriş <!-- id: 34 -->
  - 1.3.1.6. [x] P1: **Subscribe əməliyyatı**: SubscribeController flash success ilə <!-- id: 35 -->
  - 1.3.1.7. [ ] P1: Sifariş formu (MVP): xidmət seçimi + əlaqə məlumatı <!-- id: 166 -->
  - 1.3.1.8. [ ] P2: **Paket Konfiquratoru (Səbət)**: Paket + add-on seçimi, qısa brif <!-- id: 625 -->
  - **1.3.1.8.1. [ ] P2: Mərhələ 1: Paket seçimi + qısa izah blokları** <!-- id: 628 -->
  - **1.3.1.8.2. [ ] P2: Mərhələ 2: Add-on seçimi (multi-select) + xülasə paneli** <!-- id: 629 -->
  - **1.3.1.8.3. [ ] P2: Mərhələ 3: Chalang AI sual formu (5-7 əsas sual)** <!-- id: 630 -->
  - **1.3.1.8.4. [ ] P2: Mərhələ 4: Xülasə + “Təklif istə” göndərişi** <!-- id: 631 -->
  - **1.3.1.8.5. [ ] P2: Sorğu payload: paket + add-on + brif cavabları** <!-- id: 632 -->
  - **1.3.1.8.6. [ ] P2: Paket adlari: Start, Growth, Enterprise, Custom** <!-- id: 635 -->
  - **1.3.1.8.7. [ ] P2: Add-onlar: SEO Boost, Branding, Kontent Paketi, etc.** <!-- id: 636 -->
  - 1.3.1.9. [ ] P2: Paket Sorğu Paneli: Admin tərəfdə status izləmə <!-- id: 626 -->
  - 1.3.1.10. [ ] P2: **"Chalang AI" Brief Köməkçisi**: Sual‑cavabla brif toplasın <!-- id: 627 -->
  - **1.3.1.10.1. [ ] P2: Sual banki: məqsəd, deadline, büdcə, rəqiblər** <!-- id: 633 -->
  - **1.3.1.10.2. [ ] P2: Brif xülasəsi: 1 paraqraf xülasə** <!-- id: 634 -->
  - 1.3.1.11. [ ] P2: **AI Lead Scoring**: Müraciətlərin AI tərəfindən analizi <!-- id: 174 -->
  - 1.3.1.12. [ ] P2: Kanban lövhəsi (Yeni/Danışıqlar/Başlandı) <!-- id: 36 -->
  - 1.3.1.13. [ ] P2: Müştəri profili, AI təsnifat, ABM enrich <!-- id: 37 -->
  - 1.3.1.14. [ ] P3: Abandoned Form Recovery: Yarımçıq formlar üçün xatırlatma <!-- id: 234 -->
  - 1.3.1.15. [ ] P3: Dynamic UTM Landing Pages: Reklam qaynağına görə dinamik kontent <!-- id: 235 -->
  - 1.3.1.16. [ ] P3: Social Proof Ticker: Real-time sifariş bildirişləri <!-- id: 237 -->
  - 1.3.1.17. [ ] P3: Lead Probability Engine: Müraciətin bağlanma ehtimalı (AI) <!-- id: 238 -->
  - 1.3.1.18. [ ] P3: Referral Link Generator: Müştərilər üçün dəvət linkləri <!-- id: 239 -->
  - 1.3.1.19. [ ] P3: Sales Pipeline Automation: Satış qıfının avtomatlaşdırılması <!-- id: 307 -->
  - 1.3.1.20. [ ] P3: Customer Lifetime Value (CLV) Predictor <!-- id: 305 -->
  - 1.3.1.21. [ ] P3: Churn Risk Analyzer: Müştəri itirmə riski analizi (AI) <!-- id: 306 -->
  - 1.3.1.22. [ ] P3: Lead Re-engagement Bot: SMS/WA/Email geri qazanma <!-- id: 339 -->
  - 1.3.1.23. [ ] P3: Auto-Responder for Out-of-Office: AI avto-cavablandırıcı <!-- id: 357 -->
  - 1.3.1.24. [ ] P3: Unified Inbox: Bütün mesajların tək mərkəzdən idarəsi <!-- id: 358 -->
  - 1.3.1.25. [ ] P3: Customer Feedback Sentiment Graph <!-- id: 359 -->

### 🔔 1.3.2. [/] Notification System

- **1.3.2.1. [x] P1: Database Notifications (Migrations + Controller setup)** <!-- id: 38 -->
- **1.3.2.2. [x] P1: "Hamısını oxunmuş et" funksiyası (NotificationController::markAllAsRead)** <!-- id: 39 -->
- **1.3.2.3. [x] P1: Pusher Integration (Package installed + Configured)** <!-- id: 40 -->
- **1.3.2.4. [x] P1: Notification List Page: read/unread filter, mark single/read-all, source linklər** <!-- id: 41 -->
- **1.3.2.5. [ ] P1: Slack Integration** <!-- id: 42 -->
- **1.3.2.6. [ ] P2: WhatsApp & Telegram Bot UI: Lead bildirişlərinin telefona gəlməsi** <!-- id: 181 -->
- **1.3.2.7. [ ] P3: Automated Social Share: Bloq paylaşılan kimi avtomatik sosial media yayımı** <!-- id: 182 -->
- **1.3.2.8. [ ] P3: White-Label SMTP/Postmark: Brendləşdirilmiş email göndərim mərkəzi** <!-- id: 199 -->

---

## 🎨 1.4. Phase 4: UI/UX və Hədəfləmə (UI/UX & Targeting)

Agentliyin "Üzü" – Vizual kimlik və istifadəçi təcrübəsi.

### 🏠 1.4.1. Phase 4.1: MVP Redesign Sprint (Priority)

- **1.4.1.1. [ ] MVP scope lock** (critical pages + MVP flows) <!-- id: 601 -->
- **1.4.1.2. [ ] New design parity for MVP pages** (Home, Services, Portfolio, About, Contact, Blog list/single) <!-- id: 602 -->
- **1.4.1.3. [ ] Form flows parity** (contact/order/book-a-call) + validation + notifications <!-- id: 603 -->
- **1.4.1.4. [ ] Navigation & footer consistency** (menu, language, social, CTA) <!-- id: 604 -->
- **1.4.1.5. [ ] MVP QA:** responsive + cross-browser + content audit <!-- id: 605 -->
- **1.4.1.6. [ ] MVP performance/SEO baseline** (LCP/CLS, meta, schema) <!-- id: 606 -->
- **1.4.1.7. [ ] MVP cutover checklist** (use Feature Flags/Switching/Cleanup items below) <!-- id: 607 -->
- **1.4.1.8. [ ] Case Studies pages parity** (list/detail) + service linkage <!-- id: 608 -->
- **1.4.1.9. [ ] Testimonials module parity** (home/services/single) <!-- id: 609 -->
- **1.4.1.10. [ ] Pricing Plans page parity** (list/details) <!-- id: 610 -->
- **1.4.1.11. [ ] Team page parity** (list/details) <!-- id: 611 -->
- **1.4.1.12. [ ] FAQ page parity** (front display + service FAQ hook) <!-- id: 612 -->
- **1.4.1.13. [ ] Contact add-ons parity** (order/book-a-call blocks) <!-- id: 613 -->
- **1.4.1.14. [ ] MVP: "Chalang AI" AI assistant** (front) + paket konfiquratoruna inteqrasiya <!-- id: 637 -->
- **1.4.1.15. [ ] Chalang AI knowledge base**: əsas səhifələr/xidmətlər/portfolio/FAQ kontenti üzrə kontekst <!-- id: 638 -->
- **1.4.1.16. [ ] Chalang AI təhlükəsizlik**: rate-limit, PII xəbərdarlığı, fallback kontakt yönləndirməsi <!-- id: 639 -->
- **1.4.1.17. [ ] Chalang AI loglama**: sorğu/cavab qeydi + admin üçün icmal <!-- id: 640 -->
- **1.4.1.18. [x] Home hero CTAs link to live routes** (contact/portfolio) <!-- completed 2025-12-23 02:18:12 by Codex --> <!-- id: 614 -->
- **1.4.1.19. [x] Home Case Studies cards link to detail page** <!-- completed 2025-12-23 02:18:12 by Codex --> <!-- id: 615 -->
- **1.4.1.20. [x] Contact order form service dropdown shows parent + child services** <!-- completed 2025-12-23 02:18:12 by Codex --> <!-- id: 616 -->
- **1.4.1.21. [x] Home hero text pulls from Banner content** while keeping live logo canvas <!-- completed 2025-12-23 02:35:35 by Codex --> <!-- id: 618 -->
- **1.4.1.22. [x] Home missing blocks added** (About, Clients, Blog, Work Together CTA) <!-- completed 2025-12-23 02:45:02 by Codex --> <!-- id: 619 -->
- **1.4.1.23. [x] Home navbar center menu stabilized** (no left/right jumping) <!-- completed 2025-12-23 03:04:40 by Codex --> <!-- id: 620 -->
- **1.4.1.24. [x] Services (new) parity:** hero copy, localized labels <!-- completed 2025-12-23 03:53:55 by Codex --> <!-- id: 622 -->
- **1.4.1.25. [x] Service detail (new) parity:** glass form, content block, case study/testimonial styling <!-- completed 2025-12-23 04:14:40 by Codex --> <!-- id: 623 -->

### ⚙️ 1.4.2. [/] Customization

- **1.4.2.1. [x] General Settings** (Logo, Social Media, Contacts) <!-- id: 43 -->
- **1.4.2.2. [/] New Design System Migration (Glassmorphism):**
  - **1.4.2.2.1. [x] P1: Drafting: Created `_new.blade.php` versions** <!-- id: 44 -->
  - **1.4.2.2.2. [x] P1: Middleware: SetLanguage.php active** <!-- id: 45 -->
  - **1.4.2.2.3. [ ] P1: Feature Flags: Dizaynı toggle etmək üçün qısa yol (v2 launch logic)** <!-- id: 538 -->
  - **1.4.2.2.4. [ ] P1: Finalizing: Ensure all `_new` views are pixel-perfect and responsive** <!-- id: 46 -->
  - **1.4.2.2.5. [ ] P1: Switching: Rename `_new.blade.php` to main files** <!-- id: 47 -->
  - **1.4.2.2.6. [ ] P1: Cleanup: Remove unused CSS/JS assets from old design** <!-- id: 48 -->
  - 1.4.2.2.7. [x] P1: **Preview Routes**: `/preview/*` marşrutları ilə yeni dizaynın paralel göstərilməsi <!-- id: 49 -->
- **1.4.2.3. [x] Admin Menu Structure**: Fully defined in `config/cms_sidebar_menu.php` <!-- id: 50 -->
- **1.4.2.4. [ ] Entry points strategy** (Admin / Front / Preview) <!-- id: 5 -->
- **1.4.2.5. [ ] "What's New" Release UI**: İstifadəçilərə yeniliklər haqqında bildiriş <!-- id: 188 -->
- **1.4.2.6. [x] Admin Panel Routing & Missing Routes Debugging** <!-- id: 566 -->
  - 1.4.2.6.1. [x] P1: **Design Recovery**: Re-enabled admin-vision.css (removing floating effects)
  - 1.4.2.6.2. [x] P1: **Table Styling Standardization**: Match Pricing Plan table to Activity Log
  - 1.4.2.6.3. [x] P1: **Health Status Route Fix**: Dashboard health widget uses `admin.health.status` <!-- id: 617 -->
  - 1.4.2.6.4. [x] P1: **Health Widget Fail-safe**: prevents infinite loading <!-- id: 621 -->
  - 1.4.2.6.5. [x] P1: **Health Widget JS Guard**: Skip chart init if ApexCharts missing <!-- id: 624 -->
- **1.4.2.7. [x] Admin Menu Elite Restructure**: CRM, Marketing, Portfel Hub, Ops və Security ayrımı <!-- id: 550 -->
  - 1.4.2.7.1. [x] P2: **FeatureFlag Gating**: Hazır olmayan modulların gizlədilməsi <!-- id: 555 -->
  - 1.4.2.7.2. [x] P2: **Icon & Label Standardization**: Lucide/Remix iconlar <!-- id: 556 -->
  - 1.4.2.7.3. [/] P2: **Permission Matrix Verification**: Rollar üzrə görünürlük cədvəli <!-- id: 564 -->

### 🔍 1.4.3. [/] Phase 2: Audit Transparency (Activity Log UI) <!-- id: 559 -->

- **1.4.3.1. [x] P2: Activity Log "Visual Diff" Engine:** old vs new JSON dəyərlərinin müqayisəsi <!-- id: 560 -->
  - **1.4.3.1.1. [x] Logic: Recursive JSON comparison in `app/helpers.php`**
  - **1.4.3.1.2. [x] UI: Reusable Blade component `x-activity-log.diff-tree`**
  - **1.4.3.1.3. [x] Fixes: Resolved 'ghost diffs' and count inflation**
- **1.4.3.2. [x] P2: Filter & Search Optimization:** Subject və Causer üzrə dərin axtarış <!-- id: 561 -->
  - **1.4.3.2.1. [x] Backend Logic: ActivityLogController implemented date_from/to**
  - **1.4.3.2.2. [x] UI Polish: Expandable search input, fixed 'X' button logic**

### 💻 1.4.4. [ ] Administrative Excellence & AI Assistant

- **1.4.4.1. [ ] P2: Admin "Chalang AI" Sidebar:** AI yardımçı paneli (SEO/Copywriting) <!-- id: 545 -->
- **1.4.4.2. [ ] P2: Centralized Media Library:** Vahid və premium fayl meneceri <!-- id: 546 -->
- **1.4.4.3. [ ] P2: Real-time Executive Dashboard:** Canlı ziyarətçi, lead və sistem statusu <!-- id: 547 -->
- **1.4.4.4. [ ] P2: Admin Workflow Shortcuts:** Hotkeys (Klaviatura qısayolları) <!-- id: 548 -->
- **1.4.4.5. [ ] P3: Admin panelde Drag & Drop (Notion-tipli):** <!-- id: 570 -->
  - [ ] **1.4.4.5.1. Block Library:** Hero, Services, Stats, CTA, FAQ, Blog Grid, Contact, Footer
  - [ ] **1.4.4.5.2. Block Schema:** JSON structure for blocks (type, variant, props, style, layout)
  - [ ] **1.4.4.5.3. Drag & Drop:** block reorder + insert + duplicate + delete
  - [ ] **1.4.4.5.4. Inspector Panel:** edit text, media, links, spacing, colors, background
  - [ ] **1.4.4.5.5. Multi-language:** per-block translations (AZ/EN/RU) with fallback
  - [ ] **1.4.4.5.6. Draft/Publish:** preview link, version history, rollback
  - [ ] **1.4.4.5.7. Permissions:** super-admin full, client content-only
  - [ ] **1.4.4.5.8. Scope/Guardrails:** sadelestirilmis surukle-burax
  - [ ] **1.4.4.5.9. Variant A (teklif):** block siralama + basic blok field editleri
  - [ ] **1.4.4.5.10. Variant B (Notion-tipli):** nested bloklar, columns, inline blocks
  - [ ] **1.4.4.5.11. Tech Notes:** SortableJS (Blade) / React DnD (builder)
- **1.4.4.6. [ ] P2: Activity Timeline & Visual Diff:** Vizuallaşdırılmış zaman xətti <!-- id: 549 -->
- **1.4.4.7. [ ] P2: Security Settings Hub:** 2FA, SSO, IP Whitelist idarə paneli <!-- id: 551 -->
- **1.4.4.8. [ ] P2: Ops & System Health:** Cron/Queue status, Error rate və Feature Flags <!-- id: 552 -->
  - 1.4.4.8.1. [x] P1: **Health Endpoint**: Cron/Queue statusunu qaytaran API heartbeat <!-- id: 730 -->
  - 1.4.4.8.2. [x] P1: **External Links Panel**: Sentry/APM/GSC üçün xarici linklər <!-- id: 731 -->
  - 1.4.4.8.3. [ ] P2: **Business Event Alerting UI**: Sifariş/Ödəniş alertləri <!-- id: 565 -->
- **1.4.4.9. [ ] P3: Omnichannel Notification Settings:** Slack, Telegram, WhatsApp bot <!-- id: 553 -->
- **1.4.4.10. [ ] P2: Sales & Leads Intelligence:** Orders, Lead scoring modulu <!-- id: 554 -->

### 🚀 1.4.5. [ ] Conversion Tools

- **1.4.5.1. [ ] P2: Banner/Popup builder**, feature toggles <!-- id: 52 -->
- **1.4.5.2. [ ] P2: A/B test planlayıcı**, session replay <!-- id: 53 -->
- **1.4.5.3. [ ] P3: Segment targeting** (ölkə/cihaz/səhifə/UTM) <!-- id: 54 -->
- **1.4.5.4. [ ] P3: RTL (Right-to-Left) dəstəyi** (ərəb/Fars dilləri üçün UI) <!-- id: 55 -->
- **1.4.5.5. [ ] P3: Multi-timezone & Locale:** zaman, tarix və valyuta formatlaması <!-- id: 56 -->
- **1.4.5.6. [ ] P3: Multi-Currency Support:** USD/AZN/EUR valyuta çeviricisi <!-- id: 200 -->
- **1.4.5.7. [ ] P2: Dynamic Pricing Calculator:** İnteraktiv qiymət hesablama aləti <!-- id: 175 -->
- **1.4.5.8. [ ] P3: Agency White-label Master Switch:** Agentlik brendinqini gizlətmə <!-- id: 340 -->
- **1.4.5.9. [ ] P2: Dynamic Testimonial Carousel:** Region və sahəyə görə rəylər <!-- id: 345 -->
- **1.4.5.10. [ ] P3: Adaptive Loading Engine:** İnternet sürətinə görə adaptasiya <!-- id: 360 -->
- **1.4.5.11. [ ] P2: Micro-interaction Design Tokens:** Vahid animasiya kitabxanası <!-- id: 361 -->
- **1.4.5.12. [ ] P2: Theme Persistence:** Dark/Light mode seçiminin yadda saxlanılması <!-- id: 176 -->
- **1.4.5.13. [x] P1: Design Token Audit (Outfit):** Azərbaycan hərflərinin tam dəstəyi <!-- id: 536 -->
- **1.4.5.14. [ ] P2: Universal Search (Cmd + K):** Sürətli axtarış və komanda menyusu <!-- id: 183 -->
- **1.4.5.15. [ ] P2: GSAP & Lottie Animations:** Premium mikro-interaksiyalar <!-- id: 184 -->
- **1.4.5.16. [ ] P2: Glassmorphism Border-Beam Effects:** Premium parıltılar <!-- id: 537 -->
- **1.4.5.17. [ ] P3: Cursor Follower:** Brend kursor effekti <!-- id: 220 -->
- **1.4.5.18. [ ] P3: SVG Path Animations:** Scroll zamanı ikon cızılması <!-- id: 221 -->
- **1.4.5.19. [ ] P3: Variable Font Weight Scroll:** Dinamik şrift qalınlığı <!-- id: 222 -->
- **1.4.5.20. [ ] P3: Glassmorphism Backdrop Fallback:** Köhnə brauzer dəstəyi <!-- id: 223 -->
- **1.4.5.21. [ ] P3: Interactive 3D Elements:** Three.js/Spline inteqrasiyası <!-- id: 224 -->
- **1.4.5.22. [ ] P3: Sound UX:** Hover/Klik səs effektləri <!-- id: 225 -->
- **1.4.5.23. [ ] P3: Dynamic Progress Indicator:** Bloq oxuma tərəqqisi <!-- id: 226 -->
- **1.4.5.24. [ ] P3: Behavioral Targeting:** İstifadəçi rəftarına görə adaptasiya <!-- id: 256 -->
- **1.4.5.25. [ ] P3: Social Proof Live Stream:** Saytda olan istifadəçi sayısı <!-- id: 257 -->

---

## 📝 1.5. Phase 5: Form, Media və SEO

Agentliyin "Səsi" – Görünürlük, Əlaqə və Axtarış Sistemləri.

### 📁 1.5.1. [/] Form & Media

- **1.5.1.1. [x] P1: Laravel File Manager:** Installed (unisharp/laravel-filemanager) <!-- id: 57 -->
- **1.5.1.2. [ ] P3: Vizual form builder** + CSV/Excel export <!-- id: 58 -->
- **1.5.1.3. [ ] P2: Smart Image Crop:** AI ilə əsas obyektin tapılıb kəsilməsi <!-- id: 177 -->
- **1.5.1.4. [ ] P2: Admin Live Preview:** Məzmun yazılarkən anlıq önizləmə <!-- id: 178 -->
- **1.5.1.5. [ ] P2: Automated Binary Asset Optimization:** Şəkil/video avto-sıxılması <!-- id: 201 -->
- **1.5.1.6. [ ] P3: Smart Image Watermarking:** Şəkillərə avtomatik brend damğası <!-- id: 362 -->
- **1.5.1.7. [ ] P2: Auto-Tagging for Media Library:** Şəkillərin AI ilə avto-etiketlənməsi <!-- id: 363 -->
- **1.5.1.8. [ ] P2: Media Expire/Auto-delete:** Müvəqqəti faylların avtomatik silinməsi <!-- id: 364 -->
- **1.5.1.9. [ ] P1: Media optimizasiya** (compress/resize, alt-text check) <!-- id: 59 -->
- **1.5.1.10. [x] P1: Abstrak Demo Seed:** Case studies, testimonials, team, FAQ üçün demo kontent <!-- id: 60 -->
- **1.5.1.11. [x] P1: Form anti-spam & rate-limit:** honeypot + throttle <!-- id: 61 -->
- **1.5.1.12. [ ] P3: Video Transcription API:** Videolar üçün avtomatik subtitr <!-- id: 322 -->
- **1.5.1.13. [ ] P3: Interactive SVG Mapping:** SEO üçün interaktiv SVG xəritələr <!-- id: 377 -->

### 🔍 1.5.2. [/] SEO Tools

- **1.5.2.1. [x] P1: Basic Meta Tags** (in Models/Views) <!-- id: 62 -->
- **1.5.2.2. [ ] P2: SEO Performance Regression Alerts:** SEO reytinqi düşəndə xəbərdarlıq <!-- id: 378 -->
- **1.5.2.3. [ ] P1: XML sitemap generator** <!-- id: 63 -->
- **1.5.2.4. [ ] P2: 404/broken link skanı** <!-- id: 64 -->
- **1.5.2.5. [ ] P2: Dynamic OG Image Generator:** Bloq/Xidmət üçün avtomatik vizual <!-- id: 185 -->
- **1.5.2.6. [ ] P1: Hreflang/meta checker** (dillərə görə düzgün meta) <!-- id: 65 -->
- **1.5.2.7. [ ] P2: AI Chatbot (site QA):** çoxdilli cavab, fallback human handoff <!-- id: 721 -->
- **1.5.2.8. [ ] P1: JSON-LD/Schema:** Article/Service/Breadcrumb/Organization structured data <!-- id: 722 -->
- **1.5.2.9. [ ] P2: AI chatbot rate-limit/PII maskalama** + audit log tələbləri <!-- id: 723 -->
- **1.5.2.10. [ ] P2: Kontent indeksinin yenilənmə cədvəli (cron)** və dil uyğunluğu <!-- id: 724 -->
- **1.5.2.11. [ ] P2: FAQPage/HowTo/Event schema** (mövcud kontentə uyğun) <!-- id: 725 -->
- **1.5.2.12. [ ] P2: AI/Global Search suallarının anonimləşdirilmiş logu** <!-- id: 540 -->
- **1.5.2.13. [ ] P2: Visual regression (hero/OG) üçün Playwright/Percy planı** <!-- id: 541 -->
- **1.5.2.14. [ ] P1: Locale-specific sitemaps/cache key-ləri** <!-- id: 542 -->
- **1.5.2.15. [ ] P3: Edge-Side Pre-rendering:** Sürətli bot indekləməsi <!-- id: 250 -->
- **1.5.2.16. [ ] P3: Automated Internal Linking:** Daxili linklərin AI ilə verilməsi <!-- id: 251 -->
- **1.5.2.17. [ ] P3: Pre-fetching Strategy:** Səhifələrin qabaqcadan yüklənməsi <!-- id: 252 -->
- **1.5.2.18. [ ] P2: Search Console API integration:** Google axtarış datası admin paneldə <!-- id: 253 -->
- **1.5.2.19. [ ] P2: Sitemap Indexing API:** Avtomatik Google indekləmə <!-- id: 276 -->
- **1.5.2.20. [ ] P3: AI-based 404 Auto-Redirect Engine:** Ağıllı yönləndirmə <!-- id: 275 -->
- **1.5.2.21. [ ] P3: Automated Sitemap.xml Health Check:** Sitemap sağlamlıq yoxlaması <!-- id: 282 -->
- **1.5.2.22. [ ] P3: Dynamic Robots.txt Management:** Dinamik robots.txt idarəetməsi <!-- id: 283 -->
- **1.5.2.23. [ ] P3: Schema.org JSON-LD Auto-Generator:** Strukturlu data generatoru <!-- id: 284 -->
- **1.5.2.24. [ ] P2: Competitive SEO Tracking:** Rəqib SEO izləmə (Daxili) <!-- id: 286 -->

---

## 🛡️ 1.6. Phase 6: Təhlükəsizlik, Uyğunluq & Davamlılıq

Agentliyin "Qalxanı" – Təhlükəsizlik, Məxfilik və Dayanıqlılıq.

### 🔐 1.6.1. [/] Audit & Permissions

- **1.6.1.1. [x] P1: Activity Logs:** Installed (spatie/laravel-activitylog) <!-- id: 66 -->
- **1.6.1.2. [x] P1: Roles & Permissions:** Installed (spatie/laravel-permission) <!-- id: 67 -->
- **1.6.1.3. [x] P1: Translations Gate:** Defined in TranslationsServiceProvider <!-- id: 68 -->
- **1.6.1.4. [x] P1: Activity Log Export/Revert:** CSV/JSON/HTML export, history modal <!-- id: 69 -->

### 📈 1.6.2. [/] Enterprise Activity Log (Genişləndirilmiş Funksiyalar)

- **1.6.2.1. [x] P1: Layout:** Time Machine Layout, Smart Grouping <!-- id: 70 -->
- **1.6.2.2. [x] P1: Responsive:** Mobil uyğunluq təkrar yoxlanışı <!-- id: 71 -->
- **1.6.2.3. [x] P1: Vizual İntellekt:** Smart Diff, Impact Scores <!-- id: 72 -->
- **1.6.2.4. [x] P1: Kontekst:** Session Context, Geo-Location <!-- id: 73 -->
- **1.6.2.5. [x] P1: Interaksiyalar:** JSON Mode, Admin Annotations <!-- id: 74 -->
- **1.6.2.6. [ ] P2: İnkişaf:** Keyboard Navigation, Diff View Modes <!-- id: 75 -->
- **1.6.2.7. [ ] P2: Monitorinq:** Quick Actions, AI Summary <!-- id: 76 -->

### 🛡️ 1.6.3. [ ] Security & Identity

- **1.6.3.1. [ ] P2: SSO/SAML/OIDC** (Okta/AzureAD/Google) <!-- id: 77 -->
- **1.6.3.2. [ ] P2: Two-Factor Authentication (2FA)** <!-- id: 78 -->
- **1.6.3.3. [x] P0: Debug UI Elements** <!-- id: 4 -->
- **1.6.3.4. [x] P0: Investigate why chalang-preview.js is failing** <!-- id: 5 -->
- **1.6.3.5. [x] P0: Fix SyntaxError and execution freeze** <!-- id: 6 -->
- **1.6.3.6. [x] P0: Restore "Back to Top" arrow visibility** <!-- id: 7 -->
- **1.6.3.7. [x] P0: Verify Custom Cursor and Logo animation** <!-- id: 8 -->
- **1.6.3.8. [ ] P1: IP whitelisting for admin panel** <!-- id: 79 -->
- **1.6.3.9. [ ] P2: Password rotation policy** <!-- id: 80 -->
- **1.6.3.10. [ ] P1: Rate limiting & brute-force protection** <!-- id: 81 -->
- **1.6.3.11. [ ] P1: Secrets management** (vaulted/sealed secrets) <!-- id: 82 -->
- **1.6.3.12. [ ] P1: Security updates:** Dependabot & 3rd party monitoring <!-- id: 83 -->
- **1.6.3.13. [ ] P3: Zero Trust Architecture:** identifikasiya və kontekst <!-- id: 84 -->
- **1.6.3.14. [ ] P3: Supply Chain Security (SBOM):** asılılıqların auditi <!-- id: 85 -->
- **1.6.3.15. [ ] P3: SSPM:** konfiqurasiya səhvlərinin tespiti <!-- id: 86 -->
- **1.6.3.16. [ ] P3: Data Anonymization:** Staging üçün real datanın şifrələnməsi <!-- id: 87 -->
- **1.6.3.17. [ ] P3: Automated Vulnerability Scanning (SAST/DAST)** <!-- id: 88 -->
- **1.6.3.18. [ ] P3: Security SBOM Generator:** Sistem təhlükəsizlik hesabatı <!-- id: 202 -->
- **1.6.3.19. [ ] P3: Admin Session Replay (Visual Audit):** Video izləmə <!-- id: 265 -->
- **1.6.3.20. [ ] P3: Advanced SQL Injection Firewalls:** AI əsaslı qoruma <!-- id: 266 -->
- **1.6.3.21. [ ] P3: External API Whitelisting:** VPC-like qoruması <!-- id: 267 -->
- **1.6.3.22. [ ] P3: Audit Trail Visualization:** Qrafik vizual <!-- id: 310 -->
- **1.6.3.23. [ ] P3: API Key Lifecycle Management:** API açarlarının dövrü <!-- id: 347 -->
- **1.6.3.24. [ ] P3: AI-driven Security Anomaly Detection:** AI anomaliya tespiti <!-- id: 348 -->
- **1.6.3.25. [ ] P2: Public API Documentation:** Swagger/OpenAPI bələdçisi <!-- id: 89 -->
- **1.6.3.26. [ ] P1: HTTP təhlükəsizlik başlıqları** (CSP, HSTS, Secure Cookies) <!-- id: 520 -->
- **1.6.3.27. [ ] P2: Zero-trust access proxy / mTLS / firewall qaydaları** <!-- id: 521 -->
- **1.6.3.28. [ ] P2: İstifadəçi lifecycle:** onboarding/offboarding <!-- id: 522 -->
- **1.6.3.29. [ ] P2: API token rotation**, replay protection <!-- id: 523 -->
- **1.6.3.30. [ ] P3: Pen-test / bug bounty proqramı** <!-- id: 524 -->
- **1.6.3.31. [ ] P3: DDoS qoruma strategiyası** (scrubbing, WAF profilləri) <!-- id: 525 -->
- **1.6.3.32. [ ] P1: HTTP təhlükəsizlik başlıqları (Double-check)** <!-- id: 501 -->
- **1.6.3.33. [ ] P2: Zero-trust access proxy / mTLS (Strategy)** <!-- id: 502 -->
- **1.6.3.34. [ ] P2: İstifadəçi lifecycle (Standardization)** <!-- id: 503 -->
- **1.6.3.35. [ ] P2: API token rotation (Strategy)** <!-- id: 504 -->
- **1.6.3.36. [ ] P3: Pen-test / bug bounty proqramı (Plan)** <!-- id: 505 -->
- **1.6.3.37. [x] P0: Telegram webhook_secret fix** — `config/nutgram.php` webhook_secret artıq TELEGRAM_TOKEN fallback etmir. Əgər TELEGRAM_WEBHOOK_SECRET təyin olunmayıbsa, route 403 qaytarır <!-- id: 1102 -->

### 📋 1.6.4. [ ] Compliance & Privacy

- **1.6.4.1. [ ] P1: GDPR/cookie modulu** (banner, consent log) <!-- id: 90 -->
- **1.6.4.2. [ ] P2: GDPR Data Portability:** Məlumatların JSON ixracı <!-- id: 203 -->
- **1.6.4.3. [ ] P3: Privacy Impact Assessment (PIA) Tool:** Analiz aləti <!-- id: 337 -->
- **1.6.4.4. [ ] P2: Data Breach Notification Workflow:** Avtomatlaşdırılmış bildiriş <!-- id: 365 -->
- **1.6.4.5. [ ] P3: Multi-signature Admin Actions:** Çoxlu təsdiq <!-- id: 366 -->
- **1.6.4.6. [ ] P3: Automated Compliance Audit:** SOC2/ISO avto-audit <!-- id: 299 -->
- **1.6.4.7. [ ] P2: Advanced cookie consent** (category-based) <!-- id: 91 -->
- **1.6.4.8. [ ] P3: Data residency** (EU/US/Asia isolation) <!-- id: 92 -->
- **1.6.4.9. [ ] P2: Data retention siyasətləri** (arxivləmə, audit) <!-- id: 93 -->
- **1.6.4.10. [ ] P2: PII maskalama və log redaksiyası** <!-- id: 94 -->
- **1.6.4.11. [ ] P2: WAF / IDS inteqrasiyası** <!-- id: 95 -->
- **1.6.4.12. [ ] P2: DSAR axınları:** data export/delete sorğuları <!-- id: 96 -->
  - **1.6.4.12.1. [ ] P2: Data classification & DLP: PII/PHI təsnifatı** <!-- id: 526 -->
  - **1.6.4.12.2. [ ] P2: Outbound email/file DLP: watermark/expire link** <!-- id: 527 -->
  - **1.6.4.12.3. [ ] P3: PCI-DSS readiness (payments)** <!-- id: 528 -->
  - **1.6.4.12.4. [ ] P3: Vendor risk management** <!-- id: 529 -->

### 📊 1.6.5. [ ] Logging & Observability

- **1.6.5.1. [x] P1: Centralized logging** (ELK/SIEM friendly) <!-- id: 97 -->
- **1.6.5.2. [ ] P2: SIEM dostu loglama** (IP/UA/trace-id) <!-- id: 98 -->
- **1.6.5.3. [ ] P2: APM/tracing** (distributed traces) <!-- id: 99 -->
- **1.6.5.4. [ ] P2: Resource monitoring** (CPU/RAM/Disk alerts) <!-- id: 100 -->
- **1.6.5.5. [ ] P3: System Health Score (Live):** Canlı sağlamlıq rakamı <!-- id: 311 -->
- **1.6.5.6. [ ] P2: Telegram Alerts for Errors:** Texniki xəta bildirişləri <!-- id: 273 -->
- **1.6.5.7. [ ] P2: SLA/status monitoring** & public status page <!-- id: 101 -->
- **1.6.5.8. [ ] P2: Incident response runbook** + postmortem şablonu <!-- id: 102 -->
- **1.6.5.9. [ ] P3: Automated Post-Mortem Generator:** AI analizi <!-- id: 312 -->
- **1.6.5.10. [x] P1: Error tracking** (Sentry/Bugsnag) + release tagging — Sentry `app/Exceptions/Handler.php`-ə əlavə edildi, API JSON error formatting aktiv <!-- id: 103 -->
  - 1.6.5.10.1. [ ] P2: **Business event alerting**: payment/order drop <!-- id: 530 -->
- **1.6.5.11. [ ] P2: Error Impact Score:** Xətanın biznesə təsir balı <!-- id: 281 -->

### 🔄 1.6.6. [ ] Backup & Resilience

- **1.6.6.1. [ ] P1: Snapshot/backup** + rollback mexanizmi <!-- id: 104 -->
- **1.6.6.2. [ ] P3: Self-Healing Infrastructure:** Avtomatik bərpa <!-- id: 206 -->
- **1.6.6.3. [ ] P2: Cloud backups** (S3/Azure Blob) <!-- id: 105 -->
- **1.6.6.4. [ ] P2: Cold Storage Archiving:** Köhnə data arxivləmə <!-- id: 292 -->
- **1.6.6.5. [ ] P2: Multi-AZ/region DR planı** (RPO/RTO) <!-- id: 106 -->
- **1.6.6.6. [ ] P2: KMS/HSM açar rotasiyası**, şifrələmə <!-- id: 107 -->
- **1.6.6.7. [ ] P2: Database read/write separation** <!-- id: 108 -->
- **1.6.6.8. [ ] P2: Multi-CDN & Edge caching** <!-- id: 109 -->
  - **1.6.6.8.1. [ ] P2: Backup restore drill (bərpa testi)** <!-- id: 531 -->
- **1.6.6.9. [ ] P2: Multi-CDN Failover:** CDN-lər arası keçid <!-- id: 254 -->

### 🔌 1.6.7. [/] Integrations

- **1.6.7.1. [x] P1: DataTables:** Installed + CreateDatatableCommand <!-- id: 110 -->
- **1.6.7.2. [ ] P2: Zapier/Make.com Integration:** 5000+ tətbiq <!-- id: 204 -->
- **1.6.7.3. [ ] P2: Webhook Logging & Retries:** Xarici data tarixçəsi <!-- id: 205 -->
- **1.6.7.4. [ ] P2: LinkedIn Lead Gen Webhooks:** Lead-lərin ötürülməsi <!-- id: 320 -->
- **1.6.7.5. [ ] P1: CRM/webhook/ödəniş gateway <!-- id: 111 -->
- **1.6.7.6. [ ] P2: Custom Short-Link Generator (chalang.link)** <!-- id: 272 -->
- **1.6.7.7. [ ] P2: Arxivləmə:** Cold Storage, Immutable Logs <!-- id: 112 -->
- **1.6.7.8. [ ] P2: Config change audit/approval (4-eyes)** <!-- id: 113 -->
- **1.6.7.9. [x] P0: Import/Export API auth wrapped** — Import/Export route qrupları `auth:sanctum` middleware-i altına alındı <!-- id: 1100 -->
- **1.6.7.10. [x] P0: Orphaned export/stats route moved** — Analytics/stats route-ları `routes/admin.php`-yə daşındı <!-- id: 1101 -->

---

## 📲 1.7. Phase 7: PWA, Mobil və DevOps

Agentliyin "Əzələləri" – Mobil əlçatanlıq, sürət və çevik inkişaf.

### 🧪 1.7.1. [/] Testing

- **1.7.1.1. [x] P1: PHPUnit Installed <!-- id: 114 -->

### 📱 1.7.2. [ ] Mobile & PWA

- **1.7.2.1. [ ] P2: PWA manifest** + offline draft <!-- id: 115 -->
- **1.7.2.2. [ ] P2: Push bildirişlər** <!-- id: 116 -->
- **1.7.2.3. [ ] P1: Mobil optimizasiya** <!-- id: 117 -->
- **1.7.2.4. [ ] P1: 320x568 (iPhone SE 1)** - User Image Received
- **1.7.2.5. [ ] P1: 768x1024 (iPad Mini)** - Awaiting
- **1.7.2.6. [ ] P1: 4K (3840x2160)** - Awaiting
- **1.7.2.7. [ ] P3: PWA Offline Sync:** Avto-senxronizasiya <!-- id: 217 -->
- **1.7.2.8. [ ] P3: PWA Native-like Push:** Native bildiriş dəstəyi <!-- id: 218 -->

### 🏗️ 1.7.3. [ ] DevOps & Release

- **1.7.3.1. [ ] P1: Stage/prod ayırması**, feature flags <!-- id: 118 -->
- **1.7.3.2. [x] P1: Cache/CDN konfiqurasiyası** <!-- id: 119 -->
- **1.7.3.3. [ ] P2: S3/Cloudinary CDN integration:** Media buludda <!-- id: 245 -->
- **1.7.3.4. [ ] P2: Redis Multi-Node Session:** Klasterli sessiya <!-- id: 246 -->
- **1.7.3.5. [ ] P3: Database Sharding Readiness:** Milyonlarla dataya hazırlıq <!-- id: 247 -->
- **1.7.3.6. [ ] P2: Automated Certificate Management:** SSL avto-təsdiqi <!-- id: 248 -->
- **1.7.3.7. [ ] P2: Zero-Trust Admin Proxy:** VPN/Proxy girişi <!-- id: 249 -->
- **1.7.3.8. [ ] P1: Backup/restore prosedurları** <!-- id: 120 -->
- **1.7.3.9. [ ] P2: Changelog prosesi** (buraxılış qeydləri) <!-- id: 121 -->
- **1.7.3.10. [ ] P2: Admin bələdçisi** / əməliyyat təlimatı <!-- id: 122 -->
- **1.7.3.11. [ ] P3: Developer Documentation:** API bələdçisi <!-- id: 313 -->
- **1.7.3.12. [ ] P3: 1-Click Environment Cloning:** Sandbox mühiti <!-- id: 346 -->
- **1.7.3.13. [ ] P2: Canary/blue-green deployment** + rollback <!-- id: 123 -->
- **1.7.3.14. [ ] P3: Blue-Green Deployment Automation** <!-- id: 295 -->
- **1.7.3.15. [ ] P3: Canary Rollout Strategy** <!-- id: 296 -->
- **1.7.3.16. [ ] P3: Infrastructure-as-Code (Terraform)** <!-- id: 297 -->
- **1.7.3.17. [ ] P3: Chaos Engineering:** Failover drills <!-- id: 298 -->
- **1.7.3.18. [ ] P2: Load/perf test skriptləri** (stress, n+1) <!-- id: 124 -->
- **1.7.3.19. [ ] P3: 100k+ Concurrent User Simulated Testing** <!-- id: 367 -->
- **1.7.3.20. [ ] P2: Queue/worker monitorinqi**, DLQ <!-- id: 125 -->
- **1.7.3.21. [ ] P3: Distributed Task Scheduling** <!-- id: 294 -->
- **1.7.3.22. [ ] P3: Chaos/failover drill-ləri** (DR testləri) <!-- id: 126 -->
- **1.7.3.23. [ ] P2: Cost observability** (resurs kvotaları) <!-- id: 127 -->
- **1.7.3.24. [ ] P2: Secret scanning, branch protection** <!-- id: 532 -->
- **1.7.3.25. [ ] P2: Infra runbook və auto-scaling limitləri** <!-- id: 533 -->

### 🛠️ 1.7.4. [ ] CI/CD keyfiyyət qapıları

- **1.7.4.1. [ ] P2: WCAG 2.1 Automated Audit:** Əlçatanlıq yoxlanışı <!-- id: 336 -->
- **1.7.4.2. [ ] P2: Dependency Vulnerability Shield:** CI bloklama <!-- id: 368 -->
- **1.7.4.3. [ ] P2: Automatic Security Patching:** Avto-yamaqlama <!-- id: 268 -->
- **1.7.4.4. [ ] P1: Cron/heartbeat monitorinqi və queue lag alertləri** <!-- id: 129 -->

---

## 💼 1.8. Phase 8: Müştəri Portalı (Customer Portal)

Agentliyin "Əl sıxması" – Şəffaflıq və peşəkar əməkdaşlıq platforması.

### 🔑 1.8.1. [ ] Access & Projects

- **1.8.1.1. [ ] P2: Müştəri girişi** və layihələri görmə (rol əsaslı) <!-- id: 130 -->
- **1.8.1.2. [ ] P2: Layihə izləmə** (status, proqress, tarixçə) <!-- id: 131 -->
- **1.8.1.3. [ ] P3: Milestone Progress Visualization:** İşin tərəqqisi vizual qrafiklə <!-- id: 210 -->
- **1.8.1.4. [ ] P3: Customer Onboarding Gamification:** Oyunlaşdırma <!-- id: 344 -->
- **1.8.1.5. [ ] P3: Client Team Invites:** Müştərinin öz komandasını dəvət etməsi <!-- id: 331 -->
- **1.8.1.6. [ ] P3: Custom Domain for Clients:** Müştəri layihələrinə özəl sub-domain <!-- id: 332 -->

### 📂 1.8.2. [ ] Files & Feedback

- **1.8.2.1. [ ] P2: Fayl təsdiq axını** (preview/approve/reject) <!-- id: 132 -->
- **1.8.2.2. [ ] P3: Visual Annotations (Feedback):** Dizayn üzərində qeydlər <!-- id: 211 -->
- **1.8.2.3. [ ] P2: Şərh/feedback sistemi** (bilet, prioritet) <!-- id: 133 -->
- **1.8.2.4. [ ] P3: Project Feedback Sentiment Trigger:** Narazılıq alerti <!-- id: 369 -->

### 📅 1.8.3. [ ] Meeting & Reporting

- **1.8.3.1. [ ] P2: Toplantı/raportlar** (təqvim, qeydlər, PDF export) <!-- id: 134 -->
- **1.8.3.2. [ ] P3: AI-Generated Performance Reports:** Aylıq AI hesabatlar <!-- id: 191 -->
- **1.8.3.3. [ ] P2: Sənədlər və brend kit yükləmə** <!-- id: 135 -->
- **1.8.3.4. [ ] P3: Advanced PDF Export Engine:** Üslublu PDF hesabatlar <!-- id: 341 -->

### 💸 1.8.4. [ ] Finance & Legal

- **1.8.4.1. [ ] P2: Ödəniş/təklif sistemi** (invoice, e-imza) <!-- id: 136 -->
- **1.8.4.2. [ ] P3: Digital Signature (Web Crypto):** Sənədlərin daxili imzalanması <!-- id: 212 -->
- **1.8.4.3. [ ] P3: Milestone-based Automatic Invoicing:** Avtomatik f-faktura <!-- id: 213 -->
- **1.8.4.4. [ ] P3: White-Label Client Link:** Şifrəli iş təqdimat linkləri <!-- id: 186 -->
- **1.8.4.5. [ ] P3: One-Click Renewal (Upsell):** Xidmətin tək kliklə uzadılması <!-- id: 264 -->
- **1.8.4.6. [ ] P3: Internal Collaboration Hub:** Real-time daxili çat <!-- id: 260 -->
- **1.8.4.7. [ ] P3: Brand Asset Management (BAM):** Brendinq rəqəmsal anbarı <!-- id: 261 -->
- **1.8.4.8. [ ] P3: Automatic Project NDA:** Avtomatik məxfilik müqaviləsi axonal <!-- id: 262 -->
- **1.8.4.9. [ ] P3: Client Feedback Surveys (CSAT/NPS):** Məmnuniyyət sorğusu <!-- id: 263 -->
- **1.8.4.10. [ ] P3: Automated Customer Success Journey:** Rifahın avto-izlənilməsi <!-- id: 304 -->
- **1.8.4.11. [ ] P2: Məxfilik** (expire link, watermark, NDA) <!-- id: 137 -->
- **1.8.4.12. [ ] P3: Image Watermarking:** Portfolio şəkillərinin avto-damğalanması <!-- id: 277 -->
- **1.8.4.13. [ ] P3: White-label Portal for Resellers:** Satış tərəfdaşları üçün portal <!-- id: 370 -->
- **1.8.4.14. [ ] P3: Automated Refund/Credit Logic:** Geri ödəmə/kredit idarəsi <!-- id: 325 -->
- **1.8.4.15. [ ] P3: Customer Satisfaction Benchmarking:** Analiz <!-- id: 316 -->

### 🤝 1.8.5. [ ] Partner Portal

- **1.8.5.1. [ ] P3: Referral Portal:** Tərəfdaşlar üçün komissiya izləmə paneli <!-- id: 214 -->

### 🛍️ 1.8.6. [ ] Marketplace/Demo

- **1.8.6.1. [ ] P2: Hazır paketlərin siyahısı** (Starter/Pro/Enterprise) <!-- id: 168 -->
- **1.8.6.2. [ ] P2: Demo hesabı/preview linki** (read-only) <!-- id: 169 -->
- **1.8.6.3. [ ] P2: Orders/Leads admin siyahısı** <!-- id: 170 -->
- **1.8.6.4. [ ] P2: Demo data obfuscation/seed** + rate-limit/captcha <!-- id: 171 -->

---

## 🛠️ 1.9. Phase 9: Digər (Miscellaneous)

Agentliyin "Alətləri" – Kiçik amma həyati vacib funksiyalar.

- **1.9.1. [ ] P2: A/B test triggerləri** <!-- id: 138 -->
- **1.9.2. [ ] P2: Form tərk etmə xəbərdarlığı** <!-- id: 139 -->
- **1.9.3. [ ] P2: Uptime/error log paneli** <!-- id: 140 -->
- **1.9.4. [ ] P1: E-poçt bildirişləri** (form submission, kritik hadisələr) <!-- id: 141 -->
- **1.9.5. [ ] P3: Exit-Intent Pop-up Builder:** Səhifədən çıxmaq istəyənə özəl təklif <!-- id: 255 -->
- **1.9.6. [ ] P3: Scarcity Timers:** Kampaniyalar üçün geri sayım sayğacları <!-- id: 258 -->
- **1.9.7. [ ] P3: Newsletter Segmentation:** Marağa görə bülleten qrupları <!-- id: 259 -->
- **1.9.8. [ ] P3: Multi-channel Publishing:** Bloqların avto-yayınlanması <!-- id: 278 -->
- **1.9.9. [ ] P2: Demo/Marketplace:** hazır həll paketləri + preview səhifəsi <!-- id: 167 -->

---


---


## 🌍 1.10. Phase 10: Enterprise & Qlobal Əlavələr

Agentliyin "Kostyumu" – Böyük oyunçular üçün miqyaslanma.

### 🏢 1.10.1. [ ] Operation & Compliance (Global Standards)

- **1.10.1.1. [ ] P3: Automated compliance reports** (SOC2, GDPR, ISO 27001) <!-- id: 142 -->
- **1.10.1.2. [ ] P3: Department isolation / workspace isolation** <!-- id: 143 -->
- **1.10.1.3. [ ] P3: Approval workflows:** Draft -> Review -> Approve -> Publish <!-- id: 144 -->
- **1.10.1.4. [ ] P3: Internal AI Admin Guru:** Admin daxilində ağıllı köməkçi <!-- id: 192 -->
- **1.10.1.5. [ ] P3: TMS (Phrase/Lokalise) ilə tərcümə prosesi** <!-- id: 145 -->
- **1.10.1.6. [ ] P3: Privacy Policy / Terms of Service:** versiya izləmə <!-- id: 146 -->
- **1.10.1.7. [ ] P3: "Who Is Editing":** Admin redaktə qoruması <!-- id: 147 -->
- **1.10.1.8. [ ] P3: Bulk Data Processing & Export Engine** (Background jobs) <!-- id: 148 -->
- **1.10.1.9. [ ] P3: Multi-Tenant SaaS Foundation:** Filialların/Müştərilərin idarəsi <!-- id: 149 -->
- **1.10.1.10. [ ] P3: Data Sovereignty:** Fiziki məlumat izolasiyası <!-- id: 150 -->
- **1.10.1.11. [ ] P3: Multi-Tenant Data Isolation:** SaaS arxitekturası <!-- id: 293 -->
- **1.10.1.12. [ ] P3: Multi-tenant Admin Logs Isolation:** Tenant-lara görə log ayrımı <!-- id: 372 -->
- **1.10.1.13. [ ] P3: Just-in-Time Access:** Müvəqqəti admin icazəsi <!-- id: 151 -->
- **1.10.1.14. [ ] P3: Profit Margin Tracker:** ROI izləmə <!-- id: 240 -->
- **1.10.1.15. [ ] P3: Multi-Currency Accounting:** Çox valyutalı sistem <!-- id: 333 -->
- **1.10.1.16. [ ] P3: Automated Weekly Progress PDF:** Avtomatik PDF <!-- id: 241 -->
- **1.10.1.17. [ ] P3: Skill Matrix Management:** Heyətin bacarıq mərkəzi <!-- id: 242 -->
- **1.10.1.18. [ ] P3: Internal Gantt Chart:** Tapşırıqlardan asılılıq vizualizatoru <!-- id: 243 -->
- **1.10.1.19. [ ] P3: Resource Heatmap:** Komandanın iş yükü xəritəsi <!-- id: 216 -->
- **1.10.1.20. [ ] P3: Inter-company Resource Sharing:** Filiallar arası resurs paylaşımı <!-- id: 371 -->
- **1.10.1.21. [ ] P3: Auto-Translation for Admin Comments:** Avto-tərcümə <!-- id: 274 -->
- **1.10.1.22. [ ] P3: Internal SOP Wiki:** Agentliyin daxili SOP bələdçisi <!-- id: 334 -->
- **1.10.1.23. [ ] P3: Global Tax Calculator API:** Beynəlxalq vergi inteqrasiyası <!-- id: 342 -->
- **1.10.1.24. [ ] P3: Employee Milestone Celebration:** Uğurların qeyd olunması <!-- id: 343 -->
- **1.10.1.25. [ ] P3: Multi-level Permission Matrix:** Səlahiyyət matrisi <!-- id: 309 -->
- **1.10.1.26. [ ] P3: Custom Report Builder:** BI hesabat dashboardu <!-- id: 269 -->
- **1.10.1.27. [ ] P3: Industry Insights Reports:** Sənaye üzrə AI analiz hesabatları <!-- id: 317 -->

### 🤖 1.10.2. [ ] Advanced AI & Performance

- **1.10.2.1. [ ] P3: Predictive insights** (load/error forecast) <!-- id: 152 -->
- **1.10.2.2. [ ] P2: Media optimization** (WebP/AVIF, edge sizing) <!-- id: 153 -->
- **1.10.2.3. [ ] P3: Sentiment analysis for feedback/forms** <!-- id: 154 -->
- **1.10.2.4. [ ] P3: AI Governance & Ethics:** ISO 42001 uyğunluğu <!-- id: 155 -->
- **1.10.2.5. [ ] P3: Geolocation Geofencing:** Dinamik kontent <!-- id: 156 -->
- **1.10.2.6. [ ] P3: ESG Reporting:** Ekoloji və sosial təsir hesabatları <!-- id: 157 -->
- **1.10.2.7. [ ] P3: Personalized Recommendation Engine (AI):** Özəl təkliflər <!-- id: 324 -->
- **1.10.2.8. [ ] P3: Global Logistics Integration:** Fiziki materialların logistikası <!-- id: 326 -->
- **1.10.2.9. [ ] P3: Global Logistics Hub:** Status izləmə mərkəzi <!-- id: 373 -->

### 📈 1.10.3. [ ] Global Scaling

- **1.10.3.1. [ ] P3: Inter-Company Data Sync:** Real-time senxronizasiya <!-- id: 327 -->
- **1.10.3.2. [ ] P3: Cross-Border Tax Compliance:** Beynəlxalq vergi avtomatlaşdırılması <!-- id: 328 -->

---

## ⚛️ 1.11. Phase 11: Frontend Modernizasiyası (Inertia.js + React + TypeScript)

Agentliyin "Gələcəyi" – Tam interaktivlik və müasir stack.

### 🏛️ 1.11.1. [ ] Discovery & Architecture

- **1.11.1.1. [x] P0: Stack seçimi:** Inertia.js + React + TypeScript (Seçildi) <!-- id: 158 -->
- **1.11.1.2. [ ] P3: Design System Migration:** Shadcn/ui və ya Tailwind components <!-- id: 159 -->
- **1.11.1.3. [/] P1: React Navbar Migration & Red Dot Compliance** (51 Problems) <!-- id: 900 -->
  - **Phase 1: Critical Functional (4 problems)**
    - **[x] 1.11.1.3.1. Lokalizasiya sistemi** (Laravel translations → React props) <!-- id: 901 -->
    - **[x] 1.11.1.3.2. Search toggle işləməsi** (onClick handler əlavə et) <!-- id: 902 -->
    - **[x] 1.11.1.3.3. Logo smart link** (dinamik redirect məntiq) <!-- id: 903 -->
    - **[x] 1.11.1.3.4. Careers dropdown mutual exclusivity** (group-hover sil) <!-- id: 904 -->
  - **Phase 2: Important UX (5 problems)**
    - **[x] 1.11.1.3.5. Language switcher** (Click-based, Pill design, Center match, Subfolder Support) <!-- completed 2026-05-14 -->
    - **[x] 1.11.1.3.6. Theme cookie** (localStorage → Cookie) <!-- id: 906 -->
    - **[x] 1.11.1.3.7. Mobile ESC support** (Escape düyməsi dəstəyi) <!-- id: 907 -->
    - **[x] 1.11.1.3.8. Active state styling** (Blade CSS: dolu fon + shadow) <!-- id: 908 -->
    - **[x] 1.11.1.3.9. Dropdown glassmorphism** (Blade CSS: blur + border) <!-- id: 909 -->
  - **Phase 3: Responsive Design (8 problems)**
    - **[x] 1.11.1.3.10. Breakpoint standartlaşdırma** (900px → 768px/992px) <!-- id: 910 -->
    - **[x] 1.11.1.3.11. Touch target minimum** (44x44px WCAG) <!-- id: 911 -->
    - **[x] 1.11.1.3.12. Landscape mode CSS** (max-height yoxlaması) <!-- id: 912 -->
    - **[x] 1.11.1.3.13. Foldable crease-safe** (orta 20px zone) <!-- id: 913 -->
    - **[x] 1.11.1.3.14. 8K content cap** (max-width 1440px) <!-- id: 914 -->
    - **[x] 1.11.1.3.15. Reduced motion** (@media directive) <!-- id: 915 -->
    - **[x] 1.11.1.3.16. Swipe to close** (Mobile menu gesture) <!-- id: 916 -->
    - **[x] 1.11.1.3.17. Font size accessibility** (min 12px) <!-- id: 917 -->
  - **Phase 4: Red Dot Premium (15 problems)**
    - **[ ] 1.11.1.3.18. Primary CTA** (Start Project düyməsi) <!-- id: 918 -->
    - **[ ] 1.11.1.3.19. Hover transition quality** (350ms cubic-bezier) <!-- id: 919 -->
    - **[ ] 1.11.1.3.20. Hover feedback** (scale + shadow) <!-- id: 920 -->
    - **[ ] 1.11.1.3.21. Re-render optimization** (React.memo) <!-- id: 921 -->
    - **[ ] 1.11.1.3.22. Sticky performance** (will-change) <!-- id: 922 -->
    - **[ ] 1.11.1.3.23. Progressive enhancement** (noscript fallback) <!-- id: 923 -->
    - **[ ] 1.11.1.3.24. Semantic HTML** (<nav> tag) <!-- id: 924 -->
    - **[x] 1.11.1.3.25. Color contrast** (Light mode WCAG AA: Navbar, Dropdowns, Contact Inputs, Footer) <!-- completed 2026-05-14 -->
    - **[ ] 1.11.1.3.26. Tab order fix** (aria-hidden + tabIndex) <!-- id: 926 -->
    - **[ ] 1.11.1.3.27. Focus visible style** (outline custom) <!-- id: 927 -->
    - **[ ] 1.11.1.3.28. ARIA labels complete** (aria-label həmə yerə) <!-- id: 928 -->
    - **[ ] 1.11.1.3.29. Directional dropdown animation** (origin-top-right/left) <!-- id: 929 -->
    - **[ ] 1.11.1.3.30. Loading state** (skeleton UI) <!-- id: 930 -->
    - **[ ] 1.11.1.3.31. Error boundary** (NavbarErrorBoundary) <!-- id: 931 -->
    - **[ ] 1.11.1.3.32. Design system consistency** (rəng + spacing cleanup) <!-- id: 932 -->
  - **Phase 5: Advanced Technical (6 problems)**
    - **[ ] 1.11.1.3.33. RTL support** (Ərəb dili dir="rtl") <!-- id: 933 -->
    - **[ ] 1.11.1.3.34. Safari blur fallback** (@supports) <!-- id: 934 -->
    - **[ ] 1.11.1.3.35. Dark mode flicker fix** (SSR inline script) <!-- id: 935 -->
    - **[ ] 1.11.1.3.36. Analytics tracking** (gtag event-lər) <!-- id: 936 -->
    - **[x] 1.11.1.3.37. Skip to content** (accessibility link) <!-- id: 937 -->
    - **[ ] 1.11.1.3.38. GDPR cookie consent** (theme persistence şərtli) <!-- id: 938 -->
  - **Phase 6: Remaining (21 funksional problem)**
    - **[ ] 1.11.1.3.39-51. Sub-menu items, Data attributes, Icons** (və s.) <!-- id: 939 -->
- **1.11.1.4. [ ] P3: (Optional Future) Next.js Migration Evaluation** (Əgər lazım olarsa) <!-- id: 800 -->
  - **[ ] 1.11.1.4.1. Framework choice (Next.js App Router focus)** <!-- id: 801_dup -->
  - **[ ] 1.11.1.4.2. Data fetching strategy (Server Components vs SWR/React Query)** <!-- id: 802_dup -->
  - **[ ] 1.11.1.4.3. Auth migration (Laravel Sanctum/Fortify for SPA)** <!-- id: 803_dup -->
  - **[ ] 1.11.1.4.4. Component parity audit (Blade to React components)** <!-- id: 804_dup -->
- **1.11.1.5. [x] P0: React Code Quality & Type Safety**
  - **[x] 1.11.1.5.1. Inertia version fix:** `@inertiajs/inertia` v0.11.1 silindi, `@inertiajs/react` istifadə edilir <!-- id: 1103 -->
  - **[x] 1.11.1.5.2. TypeScript type safety:** Bütün `[key: string]: any` təmizləndi, duplicate interfaces silindi (`@/types`-dən import), `ID = number | string` → `ID = number`, PricingPlan tip düzəldi. `tsc` 0 xəta. <!-- id: 1104 -->
  - **[x] 1.11.1.5.3. XSS fix:** `About.tsx` sanitizeHtml() əlavə edildi (script, event handler, javascript: URL təmizliyi) <!-- id: 1105 -->
  - **[x] 1.11.1.5.4. useDebounce fix:** Stale closure düzəldildi (`useState` → `useRef` timeout ilə) <!-- id: 1106 -->
  - **[x] 1.11.1.5.5. Test coverage:** 4 Vitest test faylı (Hero, Services, Contact, Portfolio — 15 test, hamısı uğurlu) <!-- id: 1107 -->
  - **[x] 1.11.1.5.6. Navbar Skip Link + MobileMenu fix:** Skip link əlavə edildi, MobileMenu Display hidden düzəldildi — 33/33 test keçir <!-- id: 1108 -->
  - **[x] 1.11.1.5.7. ui/Skeleton.tsx named exports:** Skeleton üçün named export-lar (CardSkeleton, ImageSkeleton, AvatarSkeleton, ButtonSkeleton, TextSkeleton) əlavə edildi, Layout.tsx variant "rectangular" → "rect" düzəldildi <!-- id: 1109 -->
- **1.11.1.8. [x] P2: Code splitting** — `React.lazy()` + `Suspense` ilə bundle ölçüsünün azaldılması. 15 eager (SchemaData, ScrollProgress, Hero, Marquee, Services, Partners, TeamGrid, Portfolio, HallOfFame, Testimonials, Faq, Blog, Contact, MobileStickyCTA, AIWidget) + 8 lazy (Pricing, TechStack, Metrics, Process, Estimator, LeadMagnet, NewsletterPopup, QuoteModal). Visible SectionFallback spinner. Home chunk: 71.55 kB. <!-- id: 1061 -->

### ⚙️ 1.11.2. [ ] Backend Adaptation

- **1.11.2.1. [ ] P3: API Layer development:** JSON response dəstəyi <!-- id: 160 -->
- **1.11.2.2. [ ] P3: GraphQL API Port:** Data qapısı <!-- id: 219 -->
- **1.11.2.3. [ ] P3: State Management:** Redux Toolkit və ya React Query <!-- id: 161 -->
- **1.11.2.4. [ ] P3: Micro-frontend architecture POC:** Arxitektura sınağı <!-- id: 374 -->
- **1.11.2.5. [ ] P3: Serverless Function Adapter:** AWS/Azure/Google keçidləri <!-- id: 335 -->
- **1.11.2.6. [ ] P3: WebAssembly (Wasm) Integration:** WASM daxili hesablamalar <!-- id: 375 -->

### 🗺️ 1.11.3. [ ] Migration Strategy

- **1.11.3.1. [ ] P3: Admin Panel Hybrid:** mürəkkəb modulların React-ə keçirilməsi <!-- id: 162 -->
- **1.11.3.2. [ ] P3: Incremental Rollout:** Blade-dən React-ə miqrasiya <!-- id: 163 -->
- **1.11.3.3. [ ] P3: React Native / Flutter Blueprint:** Mobil tətbiq planı <!-- id: 376 -->

### ⚡ 1.11.4. [ ] Performance & DX

- **1.11.4.1. [ ] P3: SSR (SEO üçün server-side rendering)** <!-- id: 164 -->
- **1.11.4.2. [ ] P3: Testing:** Vitest/Cypress ilə component və E2E testləri <!-- id: 165 -->

---

## 🚀 HİSSƏ 2: TACTICAL EXECUTION (MVP SPRINTS)

Hal-hazırda aktiv olan və qısa müddətli "Red Dot" fokuslu icra planı.

### 🏁 2.1. Sprint 1 (MVP-1): Critical Fixes & Stability

**Goal:** 100% "Red Dot" Baseline (Zero Visual Bugs) & Critical Security/Ops.

#### 🔴 2.1.1. Red Dot Fixes (Step 1 - Immediate P0)

- **[x] P0: Verification Status (Mobile):**
- **[x] P0: 100x100 (Watch)** `User Image Verified`
- **[x] P0: 200x200 (IoT)** `User Image Verified`
- **[x] P0: 320x568 (iPhone SE Portrait)** `User Image Verified`
- **[x] P0: 568320 (iPhone SE Landscape)** `User Image Verified`
- **[x] P0: 360x640 (Note II Portrait)** `User Image Verified`
- **[x] P0: 640x360 (Note II Landscape)** `User Image Verified`
- **[x] P0: 360x780 (Huawei P30 Pro)** `User Image Verified`
- **[x] P0: 414x896 (iPhone XR)** `User Image Verified`
- **[x] P0: 600x1024 (BB PlayBook)** `User Image Verified`
- **[x] P0: 768x1024 (iPad Mini)** `User Image Verified`
- **[x] P0: 4K (Desktop)** `User Image Verified` <!-- completed: 2026-01-12 11:10 by Antigravity -->
- **[x] P0: Mobil H1 Overflow Fix** (chalang-preview.css) <!-- id: 801 | completed: 2026-01-12 10:15 by Antigravity -->
- **[x] P0: Services Grid & Marquee Overflow Fix** (chalang-preview.css) <!-- id: 802 | completed: 2026-01-12 10:30 by Antigravity -->
- **[x] P0: 4K Navbar Cutoff Fix** (chalang-preview.css) <!-- id: 803_4k | completed: 2026-01-12 11:35 by Antigravity -->
- **[x] P0: Global Footer Responsive Fix** (Stack columns on mobile) <!-- id: 806 -->
- **[x] P0: P0-01 Global Mobile System:** padding-inline: 16px, max-width: 420px <!-- id: 5 | completed: 2026-01-12 09:30 by Antigravity -->
- **[x] P0: P0-02 Light Theme Contrast:** Headings #111-#222 <!-- id: 6 | completed: 2026-01-12 09:35 by Antigravity -->
- **[x] P0: P0-03 Tap Targets:** Min 44px (ideal 48px) <!-- id: 7 | completed: 2026-01-12 09:40 by Antigravity -->
- **[x] P0: P0-04 Hero Fold:** padding-top: ~24px, decor opacity 20-35% <!-- id: 8 | completed: 2026-01-12 09:45 by Antigravity -->
- **[x] P0: P0-05 Visual Noise:** Particle max height 180-240px, Watermark opacity 3-6% <!-- id: 9 | completed: 2026-01-12 09:50 by Antigravity -->
- **[x] P0: P0-06 Stats Grid:** Mobile 2x2 grid, gap ~12px <!-- id: 10 | completed: 2026-01-12 09:55 by Antigravity -->
- **[x] P0: P0-07 Estimator Context:** Labels "Aylıq/Layihelik" <!-- id: 11 | completed: 2026-01-12 10:00 by Antigravity -->
- **[x] P0: P0-08 Sticky CTA:** Primary CTA sticky at bottom or header <!-- id: 12 | completed: 2026-01-12 10:05 by Antigravity -->
- **[x] P0: P0-09 Safe Area & Clamp:** env(safe-area-inset-bottom) <!-- id: 27 | completed: 2026-01-12 10:10 by Antigravity -->
- **[x] P0: P0-11 Stats Grid Fix:** Force 2x2 layout on mobile
- **[x] P0: P0-13 Z Fold 5 Optimization (Crease-Safe):**
  - **[x] Cover (344px): Verify 2x2 Stats, 1-col Hero, No horizontal scroll**
  - **[x] Landscape (882px): Implement Dual-Pane Layouts (50/50 split)**
  - **[x] Crease Logic: Ensure 32-48px center gutter**
  - **[x] Height Fix: Sticky Bottom OFF, Padding reduced (40px)**
- **[x] P0: Debug UI Elements** (Investigate why chalang-preview.js is failing) <!-- id: 4 -->
- **[x] P0: Fix SyntaxError and execution freeze** <!-- id: 6 -->
- **[x] P0: Restore "Back to Top" arrow visibility** <!-- id: 7 -->
- **[x] P0: Verify Custom Cursor and Logo animation** <!-- id: 8 -->
- **[x] P0: SEO Meta Tags Implementation** (preview.blade.php) <!-- id: 803 -->
- **[x] P0: Cookie Consent Banner** (Core Impl) <!-- id: 804 -->
- **[x] P1: Navbar Keyboard Nav** (:focus-within) <!-- id: 805 | completed 2026-06-14 by Antigravity -->
- **[x] P1: Custom Cursor Mobil/Tablet Guard** <!-- id: 806_cursor | completed 2026-06-14 by Antigravity -->
- **[x] P1: Session Resilience** (Verify Estimator state) <!-- id: 807 -->
- **[x] P1: 404 Translation** (Dynamic labels) <!-- id: 808 | completed 2026-06-14 by Antigravity -->
- [x] **P0: Navbar Architecture Overhaul (Ideal Sitemap)** <!-- id: 809 -->
- [x] **P0: Navbar Visual Refinement (Glassmorphism & Alignment)** <!-- id: 810 -->
- [x] **P0: Fix Blade Navbar Dropdowns (Missing CSS & Logic)** <!-- id: 811 -->
- [x] **P0: React Migration & Validation** (CURRENT PRIORITY) <!-- completed: 2026-05-30 by Antigravity -->
  - [x] Verify React Navbar functionality (`/react-test`)
  - [x] Port any missing design elements to React components
  - [x] **P1: Hero Visual Enhancement**: Fixed empty right side with decorative glow orbs and more particles <!-- completed 2026-05-14 -->
  - [x] Fix TypeScript type safety and build stability (33/33 tests pass)
  - [x] **P0: Partners Logo Fix**: Recovered and generated high quality minimalist partner logos <!-- completed 2026-06-14 by Antigravity -->
  - [x] **P0: Estimator Clean Up**: Removed duplicate EstimatorLegacy and EstimatorHybrid components from Home.tsx <!-- completed 2026-06-14 by Antigravity -->

#### 🔐 2.1.2. Auth & Security (P1)

- **[x] P1: Auth UI Modernization:** Login/Forgot Password pages glassmorphism <!-- completed 2025-12-28 -->
- **[x] P1: E-poçt bildirişləri** (id: 141) <!-- completed 2025-12-23 -->
- **[x] P1: Bildiriş routing** (event -> kanal/admin/email seçimi) <!-- id: 641 -->
- **[x] P1: Bildiriş routing rol seçimi** <!-- id: 642 -->
- **[x] P1: Form anti-spam & rate-limit** (id: 61) <!-- completed 2025-12-22 -->
- **[x] P1: Slack Integration** (id: 42) <!-- completed 2026-06-14 by Antigravity -->
- **[x] P1: Rate limiting & brute-force protection** (id: 81)
- **[x] P1: Secrets management + security updates** (id: 82/83)

#### 🎨 2.1.3. UI/SEO (Kritik - P1)

- **[x] P1: Home Page (index_new) yaradılması** (preview-dan) <!-- completed 2025-12-26 -->
- **[x] P1: 2x2 Kinetic Grid:** Restored richer styling <!-- completed 2025-12-26 -->
- **[x] P1: Preview preloader fail-safe** (load + timeout) <!-- id: 643 -->
- **[x] P1: Main layout preloader fail-safe** <!-- id: 644 -->
- **[/] P1: Preview responsive hardening** <!-- id: 748 -->
  - [x] **Mobile Nav Fix:** Visibility of Search, Language, and Menu buttons
  - [x] **Refactor Process Section:** Glassmorphism + Interactive <!-- id: 50 -->
  - [x] **Overflow Fix:** Solved scroll issues on 280px/320px devices
  - [x] **Footer Fix:** Resolved 404 errors for message icons
  - [x] **Logo Animation:** Fixed visibility on mobile
  - [x] **Menu Close Button:** Fixed 0x0 size issue
  - [x] **Network Access:** Resolved 403 Forbidden for mobile LAN
  - [x] **Padding Reduction:** Compressed section padding (80px -> 40px)
- **[x] P1: Preview large-screen scaling** (1600/2560/4K/8K) <!-- id: 749 -->
- **[x] P1: Mobile UX Enhancement:** Touch Carousel (Slick Slider) <!-- id: 750 -->
- **[x] P1: Preview JS stability cleanup** (Syntax fixes, null guards)
- **[x] P1: Navbar parity** (layouts + controls)
- **[x] P1: UI polish** (stats/team/tech spacing)
- **[x] P1: Homepage Fully Dynamic:** (Marquee, Tech, Metrics, Estimator) <!-- id: 751 -->
  - [x] P1: Estimator Logic: Inlined JS for price calculation
  - [x] P1: Estimator Layout: Fixed max-width (1000px), aligned labels
  - [x] P1: Price Formatting: Font size increase, '₼' symbol
  - [x] P1: Price Disclaimer: Added translations for AZ/EN/RU
  - [x] P1: Metrics Animation: IntersectionObserver for counter
  - [x] P1: Metrics Centering: Flexbox for perfect centering
  - [x] P1: Team Section: Centering of Team grid and card
  - [x] P1: Translation Fixes: added missing keys to json files
  - [x] P1: Translation Fallback: direct JSON key lookup
  - [x] P1: Free Website Audit: functional "Lead Magnet" form
  - [x] P1: Admin Audit Viewer: Audit Requests page with GSC
- **[x] P1: GDPR Cookie Consent UI** (localStorage + glassmorphism) <!-- id: 710 -->
- **[x] P1: SEO: Translatable Slugs** (id: 167) və Breadcrumb sistemi
- **[ ] P1: Design Tokens:** Rəng, tippo, spacing standartlaşdırma
- **[ ] P1: UI QA:** Responsivlik, A11y, Lazy-load audit
- **[ ] P1: Hreflang/meta checker və Schema/OG** (id: 65)
- **[ ] P1: GA/Pixel skriptlərinin env-gating** (yalnız prod)

#### ⚙️ 2.1.4. Ops & Performance (P1)

- **[x] P1: Prod-da queue worker** (Supervisor/Horizon) uptime monitor <!-- completed 2025-12-22 -->
- **[x] P1: Cache/CDN optimizasiya** (Cloudflare/CDN, Brotli/gzip) <!-- completed 2025-12-22 -->
- **[x] P1: Media/asset optimizasiya** (lazy-load, WebP/AVIF)
- **[x] P1: Error tracking** (Sentry/Bugsnag) + release tagging <!-- completed 2025-12-22 -->
- **[x] P1: A ağır işlərin queue-ya verilməsi** (email/notification) <!-- completed 2025-12-22 -->
- **[x] P1: Prod hygiene:** Debugbar off, log level=warning <!-- completed 2025-12-22 -->
- **[x] P1: DB indeks checklisti** (slug/status/date sahələri) <!-- completed 2025-12-22 -->
- **[x] P1: Release sonrası smoke test siyahısı** <!-- completed 2025-12-22 -->
- **[ ] P1: Performance büdcələri + ölçmə/alert** (id: 29)
- **[ ] P1: Deploy sonrası route:cache, config:cache, view:cache tətbiqi**
- **[ ] P1: CI/CD keyfiyyət qapıları** (id: 128)
- **[ ] P1: Cron/heartbeat & queue lag alertləri** (id: 129)
- **[ ] P1: Backup/restore prosedurları** (id: 120)

---

### 🛠️ 2.2. Sprint 2: High Value UX & Features

**Goal:** Complete Feature Set (Parity + Conversion) & Advanced UX.

#### 🔴 2.2.1. Red Dot UX (Step 2)

- **[ ] P1: P1-01 Map Stepper:** Labels Kəşf->Strategiya->İcra->Ölçmə <!-- id: 14 -->
- **[ ] P1: P1-02 Map Value:** Region/Sector list + 3-5 real examples <!-- id: 15 -->
- **[ ] P1: P1-03 Services Cards:** 1 Primary CTA (44-48px) <!-- id: 16 -->
- **[ ] P1: P1-04 Team Layout:** Avatar 40-48px, Mobile 1 column <!-- id: 17 -->
- **[ ] P1: P1-05 Calculator UX:** 3 Presets + Custom. Result <10s <!-- id: 18 -->
- **[ ] P1: P1-06 Portfolio Cards:** Min-height 180-220px, Badges + CTA <!-- id: 19 -->
- **[ ] P1: P1-07 Form Shortening:** 3 fields (Step 1), Visible labels <!-- id: 20 -->
- **[ ] P1: P1-08 Testimonials Expansion:** 3-6 rəy slider, ad/rol, nəticə <!-- id: 820 -->
- **[ ] P1: P1-11 Blog Section:** 2-3 kart + "hamısına bax" linki <!-- id: 821 -->
- **[ ] P2: P2-04 Dark Mode Polish:** Contrast checks for muted text <!-- id: 25_dup -->
- **[ ] P2: P2-05 Ultra-Low Width (240px):** Improve JioPhone 2 support
  - [ ] XXS CSS (Variant B): 1-col stats, tight padding, smaller fonts
- **[ ] P1: P1-09 FAQ Density:** Compact list, padding 12-14px <!-- id: 22_dup -->
- **[ ] P1: P1-10 Landscape Adapters:** 2-col Hero/Stats, Notch padding <!-- id: 28_dup -->
- **[ ] P1: P1-14 iPad Mini / Tablet Refinements:**
  - [ ] **Grid Fixes:** Stats (4-col), Team (3-col), Blog (3-col)
  - [ ] **Layout Split:** Hero (2-col), Process (Split), Calculator (Split)

#### 🧩 2.2.2. Page Switch (Parity)

- **[ ] P1: `_new` templatelərini finalize + switch** (id: 46/47)
- **Parity Check:** About, Contact, Portfolio, Blog (Content/Form/i18n)
- **Service Section Optimization:**
  - [x] **Hierarchy:** Parent/Child visualization frontend <!-- completed -->
  - [x] **Dynamic CTA:** Per-service buttons and links <!-- completed -->
  - [x] **Cross-Linking:** Service-related Case Study & Testimonials <!-- completed -->
  - [x] **Single View Details:** Features list and Related Services
  - [x] **Service-Specific FAQ:** Per-service Q&A <!-- completed -->
- **Sitemap Refactor (IDEAL_SITEMAP.md):**
  - **[ ] P1: Company (About, Team, Partners, Legal)**
  - **[ ] P1: Solutions (Services, Products, Industries)**
  - **[ ] P1: Insights (Blog, Events, Reports)**
  - **[ ] P1: Careers (Join Us, Interns, Culture)**
  - **[ ] P1: Mega-menu Layout Update**

#### 🛍️ 2.2.3. CRM/Orders & Conversion

- **[x] P1: Sifariş formu (MVP)** (id: 166) <!-- completed 2025-12-22 -->
- **[x] P1: "Book a Call" Təqvimi** (Calendly və ya daxili) <!-- completed 2025-12-22 -->
- **[ ] P2: Admin Orders/Leads modulu** (sifariş/demo submissions)
- **[ ] P2: Marketplace/Demo paketləri** (Starter/Pro/Enterprise)
- **[ ] P2: Feature flag idarəetməsi** (dizayn/demo toggles)

#### ✨ 2.2.4. Creative Wins

- **[x] P1: Warp Drive:** 'Scroll to Top' restyling (Rocket/Arrow) <!-- id: 705 -->
- **[ ] P1: Book a Meeting:** Calendly button/modal integration <!-- id: 706 -->
- **[x] P1: Showreel Modal:** Hero section video popup (Magnific) <!-- id: 707 -->
- **[x] P1: Live Project Status:** Footer status indicator <!-- id: 708 -->
- **[x] P1: Join the Force:** About page career CTA card <!-- id: 709 -->
- **[x] P1: Premium UI Suite (Abstrak Theme Features):** <!-- id: 720 -->
  - AOS, Curtain Preloader, Smart Cursor, Magnetic Buttons, Parallax, Smooth Scroll, Text Reveal, Alternating Grid, Blog Carousel, Counter-Up, Draggable Testimonials, Scroll Progress, Interactive Tabs (Done), Portfolio Quick View.

#### 🧠 2.2.5. High Value UX (New Additions)

- **[ ] P2: "Brand Health Check" Tool (Lead Magnet):** URL analiz edib 0-100 bal verən AI aləti <!-- id: 850 -->
- **[ ] P2: Interactive ROI Calculator:** Qazanc proqnozlaşdıran vizual qrafik <!-- id: 851 -->
- **[ ] P3: Audio Articles (Text-to-Speech):** Bloq yazıları üçün AI səsləndirmə pleyeri <!-- id: 852 -->

---

### ✨ 2.3. Sprint 3: Polish & Launch Prep

**Goal:** "Unicorn" Delighters, Deep Clean, and Post-Launch Ops.

#### 🔴 2.3.1. Red Dot Polish (Step 3)

- **[ ] P2: Newsletter Trust:** Microcopy "Spam yox", Privacy link <!-- id: 24_dup -->
- **[ ] P2: Floating Elements:** Bottom offset 16-24px, safe-area <!-- id: 25_tri -->
- **[ ] P2: Visual Consistency:** Radius 16-20px, Border 1px, Shadow 2 levels <!-- id: 26_dup -->
- **[ ] P3: Custom Branded Scrollbar** (::-webkit-scrollbar) <!-- id: 809 -->
- **[ ] P3: Text Selection Branding** (::selection rənglər) <!-- id: 814 -->
- **[ ] P3: Reduced Motion Support** (@media prefers-reduced-motion) <!-- id: 810 -->
- **[ ] P3: Global Lazy Loading** for Images (loading="lazy" audit) <!-- id: 811 -->
- **[ ] P3: Print Styles** (@media print - dark fon off) <!-- id: 812 -->
- **[ ] P3: Offline Mode (PWA Lite)** & API Security Proxy <!-- id: 813 -->
- **[ ] P3: Hreflang SEO Tags** (hreflang AZ/EN/RU + x-default) <!-- id: 815 -->
- **[ ] P2: 4K Desktop Font Scaling Optimization** (desktop-lg media query) <!-- id: 816 -->

#### 🧹 2.3.2. Cleanup & Ops (P2)

- **[ ] P2: Entry points strategy** (Admin / Front / Preview) <!-- id: 700_dup -->
- **[ ] P2: Core JS refactor** (inline scripts -> core.js) <!-- id: 701_dup -->
- **[ ] P2: Vendor optimization audit** (remove unused libs) <!-- id: 702_dup -->
- **[ ] P2: Unified theme prep** (single-source CSS tokens) <!-- id: 703_dup -->
- **[ ] P2: Layout merge plan** (abstrak vs preview) <!-- id: 704_dup -->
- **[ ] P2: DB/index & cache optimizasiya** (id: 28_tri)
- **[ ] P2: Incident response runbook/postmortem** (id: 102_dup)
- **[ ] P2: Canary/rollback ssenarisi** (id: 123_dup)
- **[ ] P2: Secret scanning/git leaks** (id: 532_dup)
- **[ ] P2: Infra runbook & auto-scaling limitləri** (id: 533_dup)

#### 🌿 2.3.3. Sustainability & Magic (New Additions)

- **[ ] P3: Eco-Mode Toggle:** Karbon izini azaltmaq üçün media/video keyfiyyətini idarə edən keçid <!-- id: 860 -->
- **[ ] P3: Digital Carbon Footprint Badge:** Canlı CO2 göstəricisi (Footer) <!-- id: 861 -->
- **[ ] P2: Client Login with Magic Link:** Parolsuz, email linki ilə giriş <!-- id: 862 -->

---

### 🔮 2.3.3. Future / Post-MVP

Agentliyin uzaqvuran hədəfləri və növbəti nəsıl texnologiyalar.

- **[x] P3: Admin Theme Settings (White-Label):** Color customization <!-- id: 51 -->
- **[ ] P3: Brand rəng palitrası dəyişdirici UI**
- **[ ] P3: Theme live preview / Reset / Presets**
- **[ ] P3: Sonic Branding / Time-Aware Hero / 3D Artifacts**
- **[ ] P3: Social Wall / Showreel Intro / Admin Orders Hub**
- **[ ] P3: Multi-region scaling / AI content generation**
- **[ ] P3: Industry Detector (IP-based UX):** Ziyarətçinin sektoruna uyğun Hero dəyişimi (Bank/Qida/Tech) <!-- id: 870 -->
- **[ ] P3: Voice Navigation:** Səsli komanda ilə sayt idarəsi ("Portfolionu göstər") <!-- id: 871 -->
- **[ ] P3: "Magic Button" (Generative UI):** Təsadüfi estetik rəng/layout dəyişimi <!-- id: 872 -->
- **[ ] P3: "Chalang Labs" Showcase Page:** Eksperimental 3D/AI layihələr səhifəsi <!-- id: 873 -->

#### ⚛️ Frontend Modernizasiyası (Next.js & React)

- **[ ] P4: Architecture Setup:** client (Next.js) ve api (Laravel) ayrımı <!-- id: 800 -->
- **[ ] P4: API Transformation:** Blade -> JSON Resource API <!-- id: 801 -->
- **[ ] P4: SEO Strategy:** Next.js SSR/SSG konfiqurasiyası <!-- id: 802 -->
- **[ ] P4: Design Port:** Glassmorphism -> React components <!-- id: 803 -->
- **[ ] P4: Auth Bridge:** Laravel Sanctum -> React Auth <!-- id: 804 -->

---

> [!IMPORTANT]
> **MVP HƏDƏFİ (Prioritet):** Bütün bu gələcək planlardan (React və s.) əvvəl, hazırkı Blade versiyası **MVP (Minimum Viable Product)** kimi tam qüsursuz işləməli və buraxılışa hazır olmalıdır. Sürət və SEO optimizasiyası indiki versiyada bitməlidir.

---
© 2026 Chalang Project Roadmap. Strict Content & ID Parity Version. Super-Hybrid Optimized.
