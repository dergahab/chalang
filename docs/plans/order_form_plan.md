<!-- documented by Codex 2025-12-22 -->
## Sifariş Formu (MVP) Texniki Planı

- Sahələr: ad/soyad, email, telefon, xidmət seçimi (service_id), qeyd (message), mənbə (utm_source/medium/campaign optional).
- Validasiya: full_name required max255, email required email, phone required max50, service_id exists:services,id, message required.
- Anti-spam: mövcud honeypot `hp`, `throttle:10,1`, opsional captcha (feature flag).
- DB: `submissions` cədvəlində `type='order'` və ya ayrıca `orders` (status: new/in_progress/done). Minimalda `submissions` istifadə et.
- Controller: `OrderController` (store) JSON və ya flash success; adminə mail/db notification (queue).
- Admin: Orders siyahısı — Submission modulu reuse; filter `type='order'`.
- UI: Front `contact` bənzəri forma, xidmət drop-down (`services` aktivləri), success toast.
- Feature flag: `FEATURE_CRM_ORDERS` ilə route/form göstərilməsini idarə et.
- Audit: activity log event (`order.created`) ilə yazılsın.
