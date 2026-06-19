# Laravel 8 → Laravel 11 Upgrade Plan

**Hazırki vəziyyət:** Laravel 8.83.3 (EOL)  
**Hədəf:** Laravel 11.x  
**Tarix:** 30.04.2026

---

## 📊 Mövcud Stack

| Komponent | Hazırki versiya | Tələb olunan |
|----------|---------------|--------------|
| PHP | 8.0+ | 8.2+ |
| Laravel | 8.83.3 | 11.x |
| Database | MySQL | MySQL |

### Paketlər (require)

| Paket | Hazırki | Laravel 11 üçün təklif |
|------|---------|----------------------|
| laravel/framework | ^8.83.3 | ^11.0 |
| laravel/sanctum | ^2.11 | ^4.0 |
| laravel/ui | 3.4 | ❌ çıxarılır |
| inertiajs/inertia-laravel | ^1.3 | ^1.3 ✅ |
| spatie/laravel-permission | ^5.5 | ^6.0 |
| spatie/laravel-activitylog | ^4.10 | ^4.10 |
| astrotomic/laravel-translatable | ^11.12 | ^11.12 ✅ |
| guzzlehttp/guzzle | ^7.0.1 | ^7.8 |
| fruitcake/laravel-cors | ^2.0 | ❌ sildik (nativ) |
| unisharp/laravel-filemanager | ^2.6 | ^2.6 ✅ |
| yajra/laravel-datatables-oracle | ~9.0 | ^11.0 |
| jenssegers/agent | ^2.6 | ^3.0 |
| yoeunes/toastr | ^2.0 | ^2.0 ✅ |
| realrashid/sweet-alert | ^5.1 | ^7.2 |
| haruncpi/laravel-id-generator | ^1.1 | ^1.1 ✅ |
| pusher/pusher-php-server | ^7.2 | ^7.2 ✅ |
| sentry/sentry-laravel | ^4.20 | ^4.20 ✅ |
| maatwebsite/excel | ^3.1 | ^3.1.69 |

### Paketlər (require-dev)

| Paket | Hazırki | Laravel 11 üçün təklif |
|------|---------|----------------------|
| barryvdh/laravel-debugbar | ^3.7 | ^3.13 |
| facade/ignition | ^2.5 | spatie/laravel-ignition ^2.4 |
| nunomaduro/collision | ^5.10 | ^8.0 |
| phpunit/phpunit | ^9.5.10 | ^10.5 |
| fakerphp/faker | ^1.9.1 | ^1.23 |
| laravel/pint | ^1.10 | ^1.13 |
| laravel/sail | ^1.0.1 | ^1.26 |
| mockery/mockery | ^1.4.4 | ^1.6 |

---

## ⚠️ Əsas Dəyişikliklər

### 1. Laravel UI çıxarılıb
Laravel 11-də `laravel/ui` paketi yoxdur.
- **Həll:** Authentication manually qurulmalı ya da Breeze inertial istifadə edilməli

### 2. Sanctum API dəyişiklikləri
- `SANCTUM_STATEFUL_DOMAINS` → `SESSION_DOMAIN`
- SPA authentication eyni qalır

### 3. Exception Handler dəyişib
- `app/Exceptions/Handler.php` struktur dəyişib
- `register()` methodu instead of `report()` array

### 4. Route dəyişiklikləri
- `routes/web.php` və `api.php` eyni qalır
- Amma broadcast routes dəyişib

### 5. Middleware dəyişib
- Global middleware saytı azalıb
- Kernel files yoxdur - `bootstrap/app.php`-da təyin edilir

### 6. Console/Kernel Routes
- `app/Console/Kernel.php` → `routes/console.php`
- `app/Http/Kernel.php` → `bootstrap/app.php`

### 7. Validation
- `Illuminate\Validation\Rules\Password` - fluent API dəyişib

---

## 📋 Addım-addım Plan

### Phase 1: Hazırlıq (0-2 saat)

```
[x] Full backup (code + database)
[x] composer.lock backup
[ ] composer.json copy → composer.json.backup8
```

### Phase 2: PHP Upgrade (1 saat)

```bash
# PHP 8.2+ yoxla
php -v
# Əgər < 8.2, upgrade et
```

### Phase 3: composer.json düzəlişi

Dəyişikliklər:

```json
{
  "require": {
    "php": "^8.2",
    "laravel/framework": "^11.0",
    "laravel/sanctum": "^3.0",
    "barryvdh/laravel-debugbar": "^3.13",
    "facade/ignition": "^3.0",
    "nunomaduro/collision": "^8.0",
    "phpunit/phpunit": "^10.0",
    "fakerphp/faker": "^1.23"
  },
  "require-dev": {
    "laravel/ui": "^4.0"
  }
}
```

**Qeyd:** `laravel/ui` 4.0-dən sonra artıq framework-dən ayrılıb.

### Phase 4: Composer Update

```bash
composer update --prefer-stable --no-interaction
```

** gözlənilən xətalar:**
- Package conflict xətaları
- Version compatibility

**Həll strategies:**
```bash
# Bir-bir update et
composer update laravel/framework --prefer-stable
composer update nunomaduro/collision --prefer-stable
```

### Phase 5: Kod düzəlişləri

#### 5.1 app/Http/Kernel.php → bootstrap/app.php

Əvvəlki:
```php
// app/Http/Kernel.php
protected $middleware = [
    \Illuminate\Http\Middleware\HandleCors::class,
    // ...
];
```

Yeni (bootstrap/app.php):
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->api(prepend: [
        \Illuminate\Http\Middleware\HandleCors::class,
    ]);
})
```

#### 5.2 app/Exceptions/Handler.php

Əvvəlki:
```php
protected $dontReport = [];
```

Yeni:
```php
public function register(): void
{
    $this->reportable(function (Throwable $e) {
        //
    });
}
```

#### 5.3 app/Console/Kernel.php → routes/console.php

Əvvəlki:
```php
// app/Console/Kernel.php
protected function schedule($schedule)
{
    //
}
```

Yeni (routes/console.php):
```php
Schedule::command('inspire')->hourly();
```

#### 5.4 config/app.php dəyişiklikləri

Some providers moved to automatic discovery.

### Phase 6: Database migration (istəyə bağlı)

```bash
# Yeni migrationlar yoxlama
php artisan migrate --pretend
```

### Phase 7: Test

```bash
# Routes
php artisan route:list

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Test server
php artisan serve
```

### Phase 8: Troubleshooting

| Xəta | Həll |
|------|------|
| "Class not found" | `composer dump-autoload` |
| "Target class not found" | Provider yoxla, register edilibmi |
| "Method doesn't exist" | API dəyişiklikləri yoxla |
| "Middleware error" | bootstrap/app.php yoxla |

---

## 🔄 Rollback Plan

Əgər uğursuz olarsa:

```bash
# Geri qaytar
git checkout .
composer install --prefer-dist --no-dev
php artisan migrate:fresh --seed
```

---

## ⏱️ Gözlənilən vaxt

| Phase | Vaxt |
|------|------|
| Hazırlıq | 30 dəq |
| Backup | 30 dəq |
| composer.json | 1 saat |
| composer update | 1-2 saat |
| Kod düzəlişləri | 2-4 saat |
| Test | 1 saat |
| **Cəmi** | **6-9 saat** |

---

## ✅ Test checklist

- [ ] Home page (`/`)
- [ ] Admin panel (`/admin`)
- [ ] Auth (login/register)
- [ ] API endpoints (`/api/*`)
- [ ] Database CRUD əməliyyatları
- [ ] File upload
- [ ] Email
- [ ] Queue jobs
- [ ] Scheduled tasks

---

## 📦 Laravel 11 yenilikləri (bonus)

1. **Graceful shutdown** - requests tamamlanana gözləyir
2. **Resend rate limiting** - daha yaxşı rate limit
3. **Octane integration** - async support
4. **Improved error pages** - daha yaxşı debug
5. **Laravel Reverb** - real-time websockets

---

## ✍️ Qərar

[ ] Razıyam, başlayaq  
[ ] İstiyirəm, əvvəlcə test mühiti yaradaq  
[ ] Xeyr, hazırki vəziyyətlə davam edək