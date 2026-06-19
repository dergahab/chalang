# 🛡️ Chalang: Master İcra Planı (Vision 2026)

Bu sənəd 4 ayrı audit hesabatının (`stack-analysis`, `conversion-audit`, `design-ux-analysis`, `uiux-report`) sintezindən yaranmışdır. Bütün işlər **Senior System Architect** səviyyəsində, sərt qaydalara uyğun icra olunmalıdır.

---

## 🚫 DƏYİŞMƏZ QAYDALAR (IMMUTABLE RULES)

İcra zamanı aşağıdakı qaydalara əməl olunması MƏCBURİDİR:
1.  **NO HARDCODING (Sıfır Hardkod):** Heç bir mətn, rəng, şəkil və ya rəqəm kodda hardkod edilə bilməz.
2.  **ADMIN-DRIVEN:** Hər şey dinamik olaraq Admin Paneldən (Settings, ContentText, DB) idarə olunmalıdır.
3.  **DESIGN SYSTEM:** Yalnız CSS Variables (`var(--brand-primary)`) istifadə edilməlidir. HEX kod istifadəsi qadağandır.
4.  **OMNI-STATE AWARE:** Bütün komponentlər 3 dili (AZ, EN, RU) və 2 rejimi (Light/Dark) dəstəkləməlidir.
5.  **DATABASE SAFETY:** Mövcud DB sütunlarını silmək və ya tipini dəyişmək qadağandır.

---

## 🏗️ FAZA 1: Arxitektura və Dizayn Sistemi (Foundation)
*Məqsəd: Sistem daxili nizamsızlığı aradan qaldırmaq və dinamik idarəetməni bərpa etmək.*

### 1.1 Tailwind & CSS Variable Sync
- [ ] `tailwind.config.js` faylını admin panel dəyişənlərinə bağla.
- [ ] `resources/css/chalang-preview.css` daxilindəki təkrarçılığı aradan qaldır.
- [ ] `MainLayout.tsx` daxilindəki bütün inline `<style>` teqlərini təmizlə.

### 1.2 Atoms & UI Library (Dinamik Komponentlər)
- [ ] `components/ui/` qovluğunda admin-controlled komponentlər yarat:
    - `Button.tsx`: Admin rənglərinə və radiusuna bağlı.
    - `Card.tsx`: Glassmorphism effektləri mərkəzləşdirilmiş.
    - `Input.tsx`: Light/Dark mode uyumlu, sərhədləri (border) admin-driven olan.

### 1.3 Theme & Lang Persistence
- [ ] `useTheme` (Zustand) və `useLang` mağazalarının (store) 100% qüsursuz işləməsini təmin et.
- [ ] Server-side (Inertia) və Client-side (React) mövzu uyğunsuzluğunu (FOUC) tam aradan qaldır.

---

## 🚀 FAZA 2: Hero və Konversiya Fokuslu UI (Heart)
*Məqsəd: İlk 3 saniyədə agentliyin avtoritetini və dəyərini göstərmək.*

### 2.1 Hero Section 2.0 (Dinamik Dashboard)
- [ ] **Headline:** `ContentText`-dən gələn Transformation-oriented mesajlar.
- [ ] **Visual (Sağ tərəf):** Boşluğu doldurmaq üçün dinamik dashboard kartları (metrics, charts) əlavə et. Bu məlumatlar DB-dən çəkilməlidir.
- [ ] **Trust Layer:** Hero-nun altına müştəri loqoları marquee-sini yerləşdir.

### 2.2 Portfolio & Case Study Matrix
- [ ] Mövcud 1-kart limitini qaldır: Admin paneldə olan bütun seçilmiş işləri (4-6 ədəd) asimmetrik grid-də göstər.
- [ ] Layihələr üçün "Problem/Həll/Nəticə" metadata-larını (DB) UI-da premium şəkildə əks etdir.

### 2.3 Process Section Simplification
- [ ] Dünya xəritəsini sil və ya `opacity: 0.05` et.
- [ ] Addımlar arası animasiyalı "Connector" (birləşdirici) xətlər əlavə et.
- [ ] Light mode-da itən nömrə dairələrini (circles) CSS variables ilə bərpa et.

---

## 🤝 FAZA 3: Trust Layer və Funksional UI (Proof)
*Məqsəd: Müştəri etibarını artırmaq və UX-i peşəkarlaşdırmaq.*

### 3.1 Pricing & Estimator Wizard
- [ ] Pricing section-da 3-cü planı (Enterprise/Custom) aktivləşdir.
- [ ] Aylıq/İllik keçidini (toggle) daha görünən və kontrastlı et.
- [ ] "Ağıllı Hesablayıcı"nı (Estimator) qorxulu formadan, addım-addım "Wizard" flow-na keçir.

### 3.2 Real Identity Integration
- [ ] Komanda və Testimonial bölmələrindəki placeholder şəkilləri admin panel vasitəsilə real şəkillərə bağla.
- [ ] Testimonial-larda "Project Type" və "Outcome" (Nəticə) etiketlərini (badges) əlavə et.

### 3.3 Spacing & Rhythm Audit
- [ ] Bütün sectionlar üçün qlobal spacing tokenini (`py-24 md:py-32`) tətbiq et.
- [ ] Light mode-da görünməyən border və shadow-ları `var(--card-border)` ilə yenilə.

---

## ⚡ FAZA 4: Optimallaşdırma və Yekun Audit (Soul)
*Məqsəd: Performans və "God Mode" interaktivlik.*

### 4.1 Lazy Loading & Performance
- [ ] Bütün ağır sectionlar üçün `React.lazy` və `Suspense` (Skeleton ilə) tətbiq et.
- [ ] Vite build reportu analiz et və bundle ölçüsünü optimallaşdır.

### 4.2 Motion & Micro-interactions
- [ ] Gridlər üçün `StaggerReveal` animasiyası.
- [ ] Düymələr üçün "Magnetic" hover effekti.
- [ ] Form validation-lar üçün `Zod` inteqrasiyası (Admin-controlled error messages).

---

## ✅ TƏSDİQ VƏ İCRA
Bu plan təsdiq edildikdən sonra, hər bir bənd yuxarıdan aşağıya ardıcıllıqla icra olunacaq. Hər iş bitdikdə `work_log.md` yenilənəcək və sübut (proof) təqdim olunacaq.

**Lead Senior Architect:** Antigravity (Google Deepmind)
**Tarix:** 14 May 2026
