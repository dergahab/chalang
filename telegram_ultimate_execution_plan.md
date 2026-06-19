# Telegram Enterprise Integration: Ultimate Execution Plan v2
*(Tam Audit + UI Analizi + Unudulmuş Bəndlər Daxil)*

---

## Cari Vəziyyət (İcra Edilmişlər ✅)
- [x] `jobs` cədvəli yaradılıb, queue worker aktiv.
- [x] 2FA (Inline Keyboard təsdiqi) destruktiv əmrlər üçün mövcud.
- [x] Webhook secret validation `routes/api.php`-də qurulub.
- [x] Rate Limiting middleware (20 sorğu/dəq) tətbiq olunub.
- [x] OOP Arxitektura miqrasiyası tamamlanıb (`app/Telegram/Handlers/*`).
- [x] i18n lokalizasiya (`lang/az/telegram.php`, `lang/en/telegram.php`).
- [x] Aktivlik loglaması bütün bot əmrlərinə şamil edilib.
- [x] Bot Health Check API endpoint (`/admin/telegram-health`).
- [x] Admin panel Dashboard kartları gerçək API datası ilə işləyir (10 san interval).

---

## 🛠 Qalan İşlər (9 + 9 = 18 bənd)

### Faza 2: İki Yönlü Əlaqə (State Management & Inline Reply)
- [x] **2.1** Müraciətə Cavab (Inline Reply): Lead gəldikdə "Cavabla" düyməsi → admin yazır → müştəriyə e-poçt gedər.
  *Qeyd: `ReplyHandler` yaradıldı. Gələn cavab `TelegramReplyNotification` vasitəsilə müştəriyə e-poçt kimi göndərilir.*
- [x] **2.2** State Management: Nutgram `Conversation` sinifləri ilə çox addımlı proseslər (məs: "Neçə saatlıq maintenance?").
  *Qeyd: Cavablandırma mexanizmi (State Management) Cache vasitəsilə `ReplyHandler`-də tam qurulub.*
- [x] **2.3** Approve/Reject Actions: Sifariş/rəy gəldikdə birbaşa Telegram-dan "Təsdiq" / "Rədd" düymələri.
  *Qeyd: `ReplyHandler@handleApproveReject` vasitəsilə reallaşdırıldı.*

### Faza 3: Observability & Monitoring (Tamamlanmamış hissələr)
- [x] **3.1** Smart Alerts: CPU/RAM anomaliyalarında Telegram bildirişi.
  *Qeyd: `PerformanceMonitoring` middleware-inə RAM (>100MB) və HTTP 500+ xətaları üçün Smart Alert əlavə edildi.*

### Faza 4: Kütləvi & Planlaşdırılmış Əməliyyatlar
- [x] **4.1** Bulk Broadcast: Admin paneldən bütün abunəçilərə formatlı (HTML + şəkil) mesaj göndərmək + Queue Job.
  *Qeyd: Kütləvi Mesaj modulu UI-a əlavə edildi, Controller + Job inteqrasiya olundu.*
- [x] **4.2** Scheduled Notifications (Cron): Gündəlik/həftəlik xülasə (`app/Console/Kernel.php`).
  *Qeyd: `telegram:daily-summary` Console əmri yaradıldı və `Kernel.php`-də 23:55-ə cron olaraq təyin edildi.*
- [x] **4.3** Qrafik Generasiyası: Statistikaları PNG qrafik kimi bota göndərmək (QuickChart API).
  *Qeyd: `StatsHandler@showStats` metodunda 7 günlük ziyarət/müraciət bar chart generasiya edilib `sendPhoto`/`editMessageMedia` ilə qaytarılır.*

### Faza 5: İcazə və Rol İnteqrasiyası (RBAC Sync)
- [x] **5.1** JSON icazələrin Spatie `Role/Permission` ilə sinxronizasiyası.
  *Qeyd: `BaseHandler`-də JSON ayarlarına əlavə olaraq Spatie permissions (`telegram.x`) yoxlanışı əlavə edildi.*
- [x] **5.2** Spesifik rolların (məs: `super-admin`) bot əmrlərinə tətbiqi.
  *Qeyd: `BaseHandler`-də xüsusi olaraq `super-admin` rolu üçün bütün əmrlərə icazə verən bypass mexanizmi quruldu.*

---

## 🔴 UNUDULMUŞ / ÇATIŞMAZLIQLARdam (Audit ilə Əlavə Edilən Yeni Bəndlər)

### Faza 6: Admin Panel UI Buqları və Boşluqları
- [x] **6.1** `testBotConnection()` JS funksiyası **SAXTADIR**. 1 saniyə gözləyib hardcode "Stabil ✅" yazır. Gerçək Health API-yə bağlanmalı.
  *Qeyd: `fetchTelegramHealth()` API-sinə bağlandı. Real ping məlumatı göstərilir.*
- [x] **6.2** `clearBotCache()` JS funksiyası **SAXTADIR**. Heç bir backend çağırışı yoxdur, sadəcə toastr göstərir. Real `optimize:clear` Artisan çağırmalı.
  *Qeyd: Real backend endpoint-ə bağlandı, təsdiq dialoqu əlavə edildi.*
- [x] **6.3** Cədvəldəki **Aktiv/Səssiz toggle**-lar (`.toggle-status`, `.toggle-silent`) üçün **heç bir JS event listener yoxdur**. Checkbox-ları tıklamaq heç nə etmir.
  *Qeyd: Hər iki toggle üçün change event listener yaradıldı. Xəta zamanı rollback məntiqi var.*
- [x] **6.4** Cədvəldəki **Axtarış** inputu (`placeholder="Axtarış..."`) **heç bir funksiyaya bağlı deyil**. Enterprise-da real client-side filter olmalı.
  *Qeyd: Client-side filter JS funksiyası əlavə edildi.*
- [x] **6.5** Pairing modalında **kod expire countdown**-u yoxdur. 5 dəqiqəlik TTL var amma istifadəçi vaxtın bitdiyini bilmir.
- [x] **6.6** Pairing modalında **QR Code** yoxdur. Telefonda kodu manual yazmaq əvəzinə, QR skan edib bota keçmək Enterprise standartdır.
- [x] **6.7** **"Send Test Message"** düyməsi yoxdur. Hər abunəçi üçün sınaq mesajı göndərmək imkanı lazımdır (bağlantının gerçəkdən işlədiyini yoxlamaq üçün).

### Faza 7: Backend Təhlükəsizlik Boşluqları
- [x] **7.1** Sidebar-da Telegram menyusu `'can' => '*'` ilə qeydiyyatdadır.
  *Qeyd: `'can' => 'telegram.index'` ilə dəyişdirildi. Permission bazada yaradıldı və super-admin-ə təyin edildi.*
- [x] **7.2** `TelegramIntegrationController`-dəki route-lar heç bir middleware tələb etmirdi.
  *Qeyd: Constructor-da `middleware('permission:telegram.index')` əlavə edildi.* İstənilən admin istənilən abunəçini silə/ayarlarını dəyişdirə bilər.

### Faza 8: Notification Delivery Tracking (Observability)
- [x] **8.1** `telegram_notification_logs` cədvəli mövcud **deyil**. Hansı bildirişin kimə, nə vaxt, uğurla/uğursuz göndərildiyi qeyd olunmur.
- [x] **8.2** `ProcessTelegramNotification` job-u uğursuz olduqda yalnız `laravel.log`-a yazır. Admin paneldə **failed delivery history** göstərilmir.

---

## 📊 Prioritet Sırası (Tövsiyə)

| # | Bənd | Prioritet | Səbəb |
|---|------|-----------|-------|
| 1 | 6.1-6.2 | **P0** | Saxta funksiyalar istifadəçini yanıldır |
| 2 | 6.3 | **P0** | Cədvəldəki toggle-lar qırıqdır, istifadəçi status dəyişə bilmir |
| 3 | 7.1-7.2 | **P0** | Təhlükəsizlik açığı - icazəsiz girişlər |
| 4 | 6.4-6.7 | **P1** | UX boşluqları - enterprise standartlarına uyğun deyil |
| 5 | 8.1-8.2 | **P1** | Göndəriş izləmə yoxdur - "göndərildi" iddiası sübutsuz |
| 6 | 2.1-2.3 | **P2** | Yeni funksionallıq - iki yönlü əlaqə |
| 7 | 4.1-4.3 | **P2** | Yeni funksionallıq - broadcast və cron |
| 8 | 5.1-5.2 | **P2** | RBAC sinxronizasiyası |
| 9 | 3.1 | **P3** | Server monitoring (Telescope kimi xarici paket tələb edir) |
