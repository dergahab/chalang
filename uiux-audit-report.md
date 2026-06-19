# UI/UX Audit Hesabatı — Ana Səhifə
**Tarix:** 14 May 2026
**Analiz edilən:** Dark Mode + Light Mode
**Ümumi bölmə sayı:** 15
**Standart:** WCAG AA, Nielsen Norman Heuristics

---

## 📊 Ümumi Xülasə

| Kateqoriya | Dark Mode | Light Mode | Cəmi |
|---|---|---|---|
| 🔴 Kritik problem | 11 | 7 (əlavə) | 18 |
| 🟡 Tövsiyə | 19 | 9 (əlavə) | 28 |
| 🔵 Kiçik qeyd | 8 | 3 (əlavə) | 11 |
| ✅ Yaxşı | 2 bölmə | — | — |

---

## 🌑 DARK MODE ANALİZİ

---

### Bölmə 1 — Navbar / Header

**Qiymət:** Orta ⚠️

| # | Səviyyə | Problem | Tövsiyə |
|---|---|---|---|
| 1.1 | 🟡 | Mobil görünüşdə hamburger menyunun olub-olmadığı bilinmir | Responsive hamburger menyu əlavə et |
| 1.2 | 🔵 | Aktiv link hansı səhifədə olduğumuzu vurğulamır (active state yoxdur) | Active link üçün rəng/underline əlavə et |
| 1.3 | 🔵 | CTA düyməsinin navbardakı ölçüsü çox kiçik görünür | Vizual ağırlıq artırılmalıdır |

---

### Bölmə 2 — Hero Bölməsi

**Qiymət:** Kritik 🔴

| # | Səviyyə | Problem | Tövsiyə |
|---|---|---|---|
| 2.1 | 🔴 | **Sağ tərəf tamamilə boşdur.** Content yalnız sol tərəfin ~40%-ni tutur, sağda qaranlıq fon var | Sağa mock-up, 3D element ya animasiya yerləşdir |
| 2.2 | 🔴 | Başlıq sınması qeyri-naturaldır — "Və Süni Zəka" odd yerlərdə bölünür | `max-width` ilə başlığın bölünmə nöqtəsini idarə et |
| 2.3 | 🔴 | Subtext/açıqlama mətni çox kiçik və az kontrastlıdır | Font ≥16px et, kontrast artır |
| 2.4 | 🟡 | İki CTA düyməsi arasında vizual ierarxiya aydın deyil | Primary filled + Secondary outlined ayrımını gücləndir |
| 2.5 | 🟡 | Hero hündürlüyü viewport-un 100%-ni tutmur | `min-height: 100vh` tətbiq et |
| 2.6 | 🔵 | Fon texturu çox tutqundur, canlandırıcı effekt yoxdur | Particle / gradient animasiya əlavə et |

---

### Bölmə 3 — "Biz nə edirik?"

**Qiymət:** Orta ⚠️

| # | Səviyyə | Problem | Tövsiyə |
|---|---|---|---|
| 3.1 | 🔴 | Kartların hündürlüyü bərabər deyil, grid sınıb | `CSS Grid align-items: stretch + min-height` tətbiq et |
| 3.2 | 🟡 | "Ətraflı →" link kartın içindəki mətnlə qarışır | Link üçün `margin-top` artır, ayrı zona yarat |
| 3.3 | 🟡 | İkon ölçüləri standart deyil | Consistent 40–48px ikon ölçüsü istifadə et |
| 3.4 | 🔵 | Hover effektinin olub-olmadığı bilinmir | Kart hover state test et |

---

### Bölmə 4 — Pricing / "Sizə Uyğun Paketi Seçin"

**Qiymət:** Kritik 🔴

| # | Səviyyə | Problem | Tövsiyə |
|---|---|---|---|
| 4.1 | 🔴 | Yalnız 2 plan var (499₼ + 999₼) — best practice 3 plandır | 3. orta plan əlavə et (Starter / Pro / Enterprise) |
| 4.2 | 🔴 | Aylıq/İllik toggle çox kiçik, gözə dəymir | Toggle-ı böyüt, "20% qazanırsınız" label əlavə et |
| 4.3 | 🟡 | Feature siyahısı hər iki kartda fərqli sayda — vizual uyumsuzluq | Eyni sıra sayı olsun, eksikdir "—" ilə göstər |
| 4.4 | 🟡 | Qiymət formatı aydın deyil — aylıq mı, birdəfəlik mi? | "499₼/ay" formatında göstər |
| 4.5 | 🔵 | "Popular" badge daha diqqətçəkici ola bilər | Badge rəng/stili gücləndir |

---

### Bölmə 5 — Logo Marquee Şeridi

**Qiymət:** Orta ⚠️

| # | Səviyyə | Problem | Tövsiyə |
|---|---|---|---|
| 5.1 | 🔴 | **Yanlış yerləşdirmə** — Pricing ilə Stats arasına sıxışdırılıb | Hero altına ya "Nailiyyətlər" yanına apar |
| 5.2 | 🟡 | Loqoların ölçüləri bərabər deyil | `max-height: 32px + object-fit: contain` ilə normalize et |
| 5.3 | 🟡 | Şeridin başlığı yoxdur | "Güvənilən brendlər" / "Tərəfdaşlarımız" başlığı əlavə et |

---

### Bölmə 6 — Stats / Rəqəmlər

**Qiymət:** Yaxşı ✅

| # | Səviyyə | Problem | Tövsiyə |
|---|---|---|---|
| 6.1 | 🟡 | Rəqəmlərin altındakı açıqlama mətni çox kiçikdir | Font ≥13px et, opacity artır |
| 6.2 | 🔵 | Countup animasiyası yoxdur | Scroll trigger ilə countup əlavə et |
| 6.3 | ✅ | Ümumi quruluş yaxşıdır — sadə, oxunaqlı, inanandırıcı | — |

---

### Bölmə 7 — "Necə işləyirik?"

**Qiymət:** Kritik 🔴

| # | Səviyyə | Problem | Tövsiyə |
|---|---|---|---|
| 7.1 | 🔴 | **Addımlar arasında vizual connector yoxdur** — istifadəçi axışı anlamır | Addımları birləşdirən xətt/ox əlavə et |
| 7.2 | 🔴 | Fon xəritəsi bölmə mənası ilə heç bir əlaqəsi yoxdur, çaşdırır | Xəritəni sil ya da ayrı "Qlobal Çatış" bölməsinə apar |
| 7.3 | 🟡 | Aktiv addım (03) interaktiv mi, statik mi — aydın deyil | Ya hamısını eyni görünüşdə saxla, ya tam interaktiv et |
| 7.4 | 🟡 | Hər addımın mətni çox sıxılmışdır | Spacing artırılmalıdır |

---

### Bölmə 8 — "Komandamız"

**Qiymət:** Orta ⚠️

| # | Səviyyə | Problem | Tövsiyə |
|---|---|---|---|
| 8.1 | 🔴 | **Komanda üzvlərinin şəkilləri yoxdur (placeholder)** — ən güclü trust signal itirilir | Real foto mütləq əlavə et |
| 8.2 | 🟡 | Ad, vəzifə, LinkedIn linki görünmür | Hər üzvə: ad + vəzifə + LinkedIn ikon əlavə et |
| 8.3 | 🟡 | Kart ölçüləri bərabər deyil | Bütün kartları eyni min-height-da saxla |

---

### Bölmə 9 — "Ağıllı Qiymət Hesablayıcı"

**Qiymət:** Orta ⚠️

| # | Səviyyə | Problem | Tövsiyə |
|---|---|---|---|
| 9.1 | 🟡 | Qiymət USD ($) ilə göstərilir, sayt AZN (₼) ilə işləyir — ziddiyyət | Vahid valyuta istifadə et |
| 9.2 | 🟡 | Sol form input label-ları çox kiçikdir | Label font ölçüsünü artır |
| 9.3 | 🟡 | CTA düyməsinin funksiyası aydın deyil | "Qiymət hesabla" kimi açıq mətn yaz |
| 9.4 | 🔵 | Xüsusiyyət özlüyündə gözəldir, amma UI daha aydın olmalıdır | — |

---

### Bölmə 10 — Portfolio / "Seçilmiş İşlər"

**Qiymət:** Kritik 🔴

| # | Səviyyə | Problem | Tövsiyə |
|---|---|---|---|
| 10.1 | 🔴 | **Yalnız 1 iş görünür** — "Seçilmiş işlər" dedib 1 kart göstərmək | Min 4–6 iş göstər ya "Hamısına bax" linkini görünən et |
| 10.2 | 🔴 | Kart üzərindəki mətn oxunmur — qaranlıq fon üzərindəki qaranlıq şrift | Overlay gradient + ağ mətn istifadə et |
| 10.3 | 🟡 | Filter tab-larının nəyi filter etdiyi aydın deyil | Filter label-larını aydınlaşdır |
| 10.4 | 🟡 | Kart hover state-i yoxdur | Hover effekti əlavə et |

---

### Bölmə 11 — "Nailiyyətlərimiz"

**Qiymət:** Orta ⚠️

| # | Səviyyə | Problem | Tövsiyə |
|---|---|---|---|
| 11.1 | 🟡 | Bölmə mətni çox kiçikdir, oxunmur | Font ölçüsünü artır |
| 11.2 | 🟡 | Sertifikat/badge şəkilləri aydın görünmür | Badge-ları daha qabarıq et |
| 11.3 | 🔵 | Bu bölmə "Müştəri Rəyləri" ilə birlikdə güclü social proof yaradar | Bölmələri yanyana qoy |

---

### Bölmə 12 — "Müştəri Rəyləri" / Testimonials

**Qiymət:** Orta ⚠️

| # | Səviyyə | Problem | Tövsiyə |
|---|---|---|---|
| 12.1 | 🔴 | **Müştəri fotoları yoxdur** — fotosuz testimonial inandırıcı deyil, saxta görünür | Hər rəyə real şəxs fotosu + ad + şirkət əlavə et |
| 12.2 | 🟡 | Rəy mətni çox qısadır, konkret nəticə yoxdur | "X layihəmizdə Y% artım əldə etdik" tipli rəylər istifadə et |
| 12.3 | 🟡 | Ulduz reytinqinin rəngi qaranlıq fonda görünmür | Ulduz rəngi `#FFD700` ya daha parlaq ton et |

---

### Bölmə 13 — Blog / "İnsaytlar və Trendlər"

**Qiymət:** Orta ⚠️

| # | Səviyyə | Problem | Tövsiyə |
|---|---|---|---|
| 13.1 | 🔴 | **Kartlar boş/placeholder görünür** — real məzmun yoxdur | Real məqalə başlıqları, tarix, oxuma müddəti əlavə et |
| 13.2 | 🟡 | Kart şəkilləri yoxdur | Hər blog kartına cover image əlavə et |
| 13.3 | 🔵 | "Bütün məqalələr" düyməsi görünmür | Düyməni daha görünən yerə qoy |

---

### Bölmə 14 — CTA Forma / "Layihənizi bizimlə başladın"

**Qiymət:** Kritik 🔴

| # | Səviyyə | Problem | Tövsiyə |
|---|---|---|---|
| 14.1 | 🔴 | **Form field label-ları görünmür** — hansı xanaya nə yazılacağı aydın deyil | Hər input-a visible label əlavə et |
| 14.2 | 🔴 | Submit düyməsi mətni qeyri-spesifikdir | "Pulsuz məsləhət al" kimi fəaliyyət yönümlü CTA yaz |
| 14.3 | 🟡 | Forma yanında social proof yoxdur | "X+ müştəri bizimlə" kimi trust element əlavə et |
| 14.4 | 🟡 | Form validation hata mesajları test edilməyib | Boş göndərilmə ssenarisi test et |
| 14.5 | 🔵 | KVKK/GDPR qeydi yoxdur | Məlumat istifadəsi barədə qısa qeyd əlavə et |

---

### Bölmə 15 — Footer

**Qiymət:** Yaxşı ✅

| # | Səviyyə | Problem | Tövsiyə |
|---|---|---|---|
| 15.1 | 🟡 | Gizlilik siyasəti / İstifadə şərtləri linki görünmür | "Gizlilik Siyasəti" + "Şərtlər" linkini əlavə et |
| 15.2 | 🔵 | Sosial media ikonlarının hover state-i test edilməyib | Hover effektlərini test et |
| 15.3 | ✅ | Ümumi quruluş standartdır | — |

---

## 🌕 LIGHT MODE ANALİZİ

> **Əsas tapıntı:** Dark mode əsas dizayn kimi qurulub, light mode sonradan əlavə edilib lakin komponentlər tam uyğunlaşdırılmayıb. Bu sistem problemidir, individual komponent problemi deyil.

---

### LM-1 — Hero: Qarışıq Rəng Modu

**Səviyyə:** Kritik 🔴

| # | Problem | Tövsiyə |
|---|---|---|
| LM-1.1 | **Hero-nun sol tərəfi light modeda hələ QARANLIQDDIR** — açıq fonlu saytda hero yarısı dark/black olaraq qalır | Hero background-ı light modeda tam açıq/ağ gradient et |
| LM-1.2 | Sol–sağ keçid animansız, kəskin baş verir | Smooth `linear-gradient` fade-out əlavə et |
| LM-1.3 | Particle efekti gəlib (müsbət!) lakin sıxlıq çox yüksəkdir, başlıqdan diqqəti yayındırır | Particle opacity-ni ~0.4-ə endir |
| LM-1.4 | Subtext hələ çox açıq rəngdədir | Kontrastı `#4a4060`-a qaldır |

---

### LM-2 — Kart Kənarları: Görünməzlik

**Səviyyə:** Kritik 🔴

| # | Problem | Tövsiyə |
|---|---|---|
| LM-2.1 | **Kart border-ları ağ fonda yox olur** — kartlar bir-birindən seçilmir | `border: 1px solid #d0c8f0` ya `box-shadow: 0 2px 8px rgba(0,0,0,0.08)` əlavə et |
| LM-2.2 | İkon arxa planı çox solğundur, ikon görünmür | İkon background opacity-ni artır |
| LM-2.3 | "Ətraflı →" linkin hover state light modeda test edilməyib | Hover rəngini `#6c3eb8`-ə set et |

---

### LM-3 — Stats: Fon Rəngi Ziddiyyəti

**Səviyyə:** Orta ⚠️

| # | Problem | Tövsiyə |
|---|---|---|
| LM-3.1 | **Stats bölməsinin fonu açıq bənövşəyi/lavender** — əvvəl-sonra ağ fonlu bölmələrlə koordinasiyasız görünür | Ya fonu ağ et, ya da section keçişini smooth gradient-lə tamamla |
| LM-3.2 | Alt açıqlama mətninin kontrast nisbəti aşağıdır | Mətn rəngini `#4a4060`-a qaldır |

---

### LM-4 — "Necə işləyirik?": Addım Görünüşü İtirildi

**Səviyyə:** Kritik 🔴

| # | Problem | Tövsiyə |
|---|---|---|
| LM-4.1 | **Yalnız "01" addımı görünür** — digər 3 addımın numbered circles-ı light modeda yox olub | Hər addıma dairəvi nömrə badge əlavə et, bütün modlarda görünsün |
| LM-4.2 | Addımlar arasındakı connector/xətt hələ yoxdur | Horizontal dashed connector + arrow əlavə et |
| LM-4.3 | Fon xəritəsi light modeda ya çox solğun ya da broken görünür | Xəritəni tam göstər ya tamamilə sil |

---

### LM-5 — Portfolio: Light Modeda Daha Pis

**Səviyyə:** Kritik 🔴

| # | Problem | Tövsiyə |
|---|---|---|
| LM-5.1 | **Portfolio bölməsi light modeda demək olar tamamilə boşdur** — ağ fon üzərindəki açıq boz kartlar yox olur | Kart şəkilləri + tünd border + visible content mütləq əlavə et |
| LM-5.2 | "Bütün işlərə bax" düyməsi görünmür — invisible | Düyməni filled button et |
| LM-5.3 | Filter tab aktiv state light modeda görünmür | Aktiv tab üçün `background: #6c3eb8; color: #fff` tətbiq et |

---

### LM-6 — Nailiyyətlər: Görünməz İkonlar

**Səviyyə:** Kritik 🔴

| # | Problem | Tövsiyə |
|---|---|---|
| LM-6.1 | **Nailiyyət ikonları/badgeları açıq fonda yox olur** — dark modedə qabarıq olan elementlər light modeda invisible olur | İkon/badge rənglərini light mode üçün tünd versiyaya keç |
| LM-6.2 | Bölmə açıqlama mətni çox açıq rəngdədir, AA standartını ötürmür | Mətn rəngi `#4a4060` minimum |

---

### LM-7 — Testimoniallar: Qismən Düzəlmişdir

**Səviyyə:** Orta ⚠️

| # | Problem | Tövsiyə |
|---|---|---|
| LM-7.1 | ✅ Ulduz reytinqi light modeda görünür hala gəldi — müsbət inkişaf | — |
| LM-7.2 | Müştəri fotoları hər iki modedə yoxdur (hər iki mode kritik problemi) | Real foto mütləq əlavə et |
| LM-7.3 | Kart border-ları light modeda çox incədir | `border: 1px solid #d4c8f0` istifadə et |

---

### LM-8 — CTA Forma: Tamamilə Sınıb

**Səviyyə:** Kritik 🔴

| # | Problem | Tövsiyə |
|---|---|---|
| LM-8.1 | **Forma light modeda sadəcə bir mətn qutusu kimi görünür** — heç bir vizual struktur yoxdur | Forma bölməsinə `background: #f7f4ff` section fonu əlavə et |
| LM-8.2 | **Input field border-ları ağ fonda görünmür** — istifadəçi haraya yazacağını anlamır | `border: 1.5px solid #c0b0e0` tətbiq et |
| LM-8.3 | Submit düyməsi fona qarışır | Düyməni `background: #6c3eb8; color: #fff` filled style et |

---

### LM-9 — Footer: Dark Olaraq Qalıb

**Səviyyə:** Kritik 🔴

| # | Problem | Tövsiyə |
|---|---|---|
| LM-9.1 | **Footer light modeda hələ dark/tünd rəngdədir** — açıq saytda qara blok kimi durur. Ən aydın mode uyumsuzluğudur | Footer-ı light modeda açıq fona keçir, ya CSS variable sistemi qur |
| LM-9.2 | Footer linklər dark fon üzərindəki ağ mətnlə qalıb | Light modeda mətn rəngini tünd et |

---

## 🎨 Kontrast Test Nəticələri (Light Mode)

| Element | Fon | Mətn | Nisbət | WCAG AA | Status |
|---|---|---|---|---|---|
| Subtext (açıq bənövşəyi fon) | `#f5f4ff` | `#b0a0e0` | ~2.1:1 | ≥4.5:1 | ❌ UĞURSUZ |
| Link mətni | `#ffffff` | `#7c5cbf` | ~4.8:1 | ≥4.5:1 | ✅ KEÇİR |
| Açıqlama mətni | `#f5f4ff` | `#888` | ~3.2:1 | ≥3:1 (böyük) | ⚠️ QISMƏN |
| CTA düyməsi | `#6c3eb8` | `#ffffff` | ~7.2:1 | ≥4.5:1 | ✅ KEÇİR |
| Forma label | `#ffffff` | `#c0b0e0` | ~1.9:1 | ≥4.5:1 | ❌ UĞURSUZ |
| Bölmə başlığı | `#f0eeff` | `#1a0a3d` | ~9.4:1 | ≥4.5:1 | ✅ KEÇİR |

### Tövsiyə edilən Light Mode Rəng Dəyərləri

```css
:root {
  --bg-primary:     #ffffff;
  --bg-secondary:   #f7f4ff;
  --bg-section:     #f0eeff;

  --text-primary:   #1a0a3d;   /* Başlıqlar */
  --text-secondary: #4a4060;   /* Subtext, açıqlamalar */
  --text-muted:     #7a6e90;   /* Kiçik mətn */

  --accent:         #6c3eb8;   /* Əsas bənövşəyi */
  --accent-hover:   #5a2fa0;

  --card-border:    #d4c8f0;
  --input-border:   #c0b0e0;
  --section-divide: #e8e0f8;
}

[data-theme="dark"] {
  --bg-primary:     #0d0d14;
  --bg-secondary:   #12121e;
  --bg-section:     #0a0a12;

  --text-primary:   #ffffff;
  --text-secondary: #aeacc8;
  --text-muted:     #7a788e;

  --accent:         #9b8fff;
  --accent-hover:   #b5a8ff;

  --card-border:    #2a2a3e;
  --input-border:   #3a3a54;
  --section-divide: #1e1e2e;
}
```

---

## ⚖️ Dark vs Light Müqayisəsi

| Bölmə | Dark Mode | Light Mode | Nəticə |
|---|---|---|---|
| Hero | ⚠️ Boş sağ tərəf | 🔴 Sol hələ dark, particle çox sıx | Light daha pis |
| Kartlar | ✅ Dark fonda görünür | 🔴 Border ağ fonda yox olur | Dark daha yaxşı |
| Pricing | ⚠️ 2 plan, toggle kiçik | ⚠️ 2 plan, toggle kiçik | Eyni problem |
| Portfolio | 🔴 1 kart | 🔴 Demək olar boş | Light daha pis |
| Testimoniallar | ⚠️ Ulduz görünmür | ✅ Ulduz görünür | Light daha yaxşı |
| Forma | ⚠️ Label görünmür | 🔴 Bütün forma yox olur | Light çox daha pis |
| Footer | ✅ Dark modda uyğun | 🔴 Dark olaraq qalır | Light sınıb |
| Addım prosesi | ⚠️ Connector yox | 🔴 Nömrə circles yox olub | Light daha pis |

---

## 🔴 TOP Prioritet Siyahısı

### Dark Mode üçün TOP 3

1. **Hero sağ tərəfi doldurun** — mock-up, 3D element ya animasiya yerləşdirin. Bu birinci baxışda görünən ən böyük vizual qüsurdur.
2. **Portfolio-ya real iş əlavə edin** — minimum 4–6 kart göstərin.
3. **Testimoniallar + Komandaya real foto əlavə edin** — ən güclü trust signal.

### Light Mode üçün TOP 5

1. **CSS mode sistemi qurun** — `CSS custom properties` ilə hər komponentin avtomatik dəyişməsini təmin edin.
2. **Footer-ı light-a uyğunlaşdırın** — ən aşkar mode uyumsuzluğudur.
3. **Hero-nun sol dark fonunu aradan qaldırın** — light modeda dark background qalmamalıdır.
4. **Form input border-larını görünən edin** — ağ fonda input sahələri yox olur.
5. **Kart border + shadow əlavə edin** — ağ fon üzərindəki kartlar görünməlidir.

---

## 🛠 Texniki Tövsiyə: CSS Mode Sistemi

Light/dark switching üçün hər komponenti ayrı-ayrı fix etmək əvəzinə aşağıdakı sistemi qurun:

```css
/* 1. CSS Variables ilə mode sistemi */
[data-theme="light"] { /* yuxarıdakı :root dəyərləri */ }
[data-theme="dark"]  { /* yuxarıdakı dark dəyərləri */ }

/* 2. Toggle funksiyası */
function toggleTheme() {
  const root = document.documentElement;
  const current = root.getAttribute('data-theme');
  root.setAttribute('data-theme', current === 'dark' ? 'light' : 'dark');
  localStorage.setItem('theme', root.getAttribute('data-theme'));
}

/* 3. Sistem tərcifinə görə default */
const saved = localStorage.getItem('theme');
const preferred = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
document.documentElement.setAttribute('data-theme', saved || preferred);
```

Bu sistemlə istənilən yeni komponent əlavə edildikdə avtomatik olaraq hər iki modedə düzgün görünəcək.

---

*Hesabat hazırlandı: Claude Sonnet 4.6 · Tarix: 14 May 2026*
