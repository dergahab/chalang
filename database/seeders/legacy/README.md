# Legacy Seed Scripts

Bu qovluq **standalone** PHP skriptləridir — Laravel seeder formatında deyillər. Onlar əmr xəttindən birbaşa işlədilir.

## ⚠️ Vacib

Bu skriptlər **yalnız vaxtaşırı işlədilir** (məs. yeni server quraşdıranda, ya da data köhnəlmiş kateqoriyada bərpa olunmalıdırsa). **Production-da avtomatik işləməz**.

## Faylların İzahı

### `seed_preview_contenttexts.php`
Preview və front üçün `Contenttext` cədvəlini doldurur. AZ/EN/RU dillərində.

**İstifadə:**
```bash
# Bütün content text-ləri yarat
php database/seeders/legacy/seed_preview_contenttexts.php

# Yalnız preview-üçün
php database/seeders/legacy/seed_preview_contenttexts.php --preview-only

# Yalnız front-üçün
php database/seeders/legacy/seed_preview_contenttexts.php --front-only

# Mövcud rekordları yenidən yaz
php database/seeders/legacy/seed_preview_contenttexts.php --force

# Test rejimi (dəyişiklik etmir)
php database/seeders/legacy/seed_preview_contenttexts.php --dry-run
```

### `seed_service_data.php`
Mövcud `Service` modelləri üçün CaseStudy, Testimonial, FAQ relasiyalarını yaradır.

**İstifadə:**
```bash
php database/seeders/legacy/seed_service_data.php
```

### `test_seeder.php`
Test data yaradır: TeamMember, Partner, Blog, Faq.

**İstifadə:**
```bash
php database/seeders/legacy/test_seeder.php
```

## TODO: Laravel Seeder formatına çevirmə

Gələcəkdə bu skriptlər `Database\Seeders\` namespace-ə uyğun seeder class-larına çevrilməlidir:

- `seed_preview_contenttexts.php` → `PreviewContenttextsSeeder`
- `seed_service_data.php` → `ServiceDataSeeder`
- `test_seeder.php` → `DemoDataSeeder`

Sonra `php artisan db:seed --class=PreviewContenttextsSeeder` ilə işlədilə bilər.
