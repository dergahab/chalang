<!-- documented by Codex 2025-12-22 -->
## DB Index Checklist (MVP Prioritet)

- Slug sütunları: unikal index (`slug`) – blog, xidmət, portfolio, kateqoriya, səhifələr.
- Status sütunları: (`status`, `is_active`, `in_main`) üçün kombinə olunmuş indexlər (status + created_at).
- Tarix sahələri: `created_at`, `published_at`, `date` – sıralama və filtr üçün index.
- Xarici açarlar: `service_id`, `category_id`, `user_id`, `lang_id` – mütləq index (ən azından non-unique).
- Axtarış/filtr: `type`, `parent_id`, `in_main` olan siyahılar üçün tərkib indeksləri (məs: `parent_id, in_main, status`).
- Unikal məntiq: email, slug, phone kimi sahələrdə unikal constraint-ləri təsdiqlə.
- Migration yoxlaması: `php artisan migrate --pretend` ilə index deklarasiyaları gözlənilən kimi görünür.
