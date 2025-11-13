# Chalang CMS - AI Coding Agent Instructions

## Architecture Overview

**Chalang** is a Laravel 8-based CMS with multi-language support and admin dashboard. The project follows a three-tier architecture:
- **Frontend Routes** (`routes/web.php`): Public-facing pages with language middleware
- **Admin Routes** (`routes/admin.php`): Protected admin resources with role-based access control
- **API Layer** (`routes/api.php`): DataTables and publishing endpoints

## Multi-Language Architecture (Critical)

This is a **translatable-first** codebase using `astrotomic/laravel-translatable`. Understand this before modifying models:

### Model Structure Pattern
- **Base Model** (e.g., `Blog`): Contains non-translatable fields and implements `TranslatableContract`
  ```php
  class Blog extends Model implements TranslatableContract {
      use Translatable;
      public $translatedAttributes = ['title', 'content'];
      protected $fillable = ['image', 'slug', 'user_id'];
  }
  ```
- **Translation Model** (e.g., `BlogTranslation`): Stores locale-specific content with `locale` field
- **Config**: `config/translatable.php` defines locales (en, fr, es variants) with fallback to 'en'

### When Adding Features
1. Split content into base + translation models
2. Always add `$translatedAttributes` to base model
3. Create migration with locale-aware fields
4. Use `$model->translate($lang)->attribute` syntax for access

## Admin Features Pattern

### DataTable System (`app/Datatable/`)
Custom DataTables implementation (not standard Yajra) that powers admin list views:
- Extend `BaseDatatable` and implement `query(): Builder`
- Override `setTableColumns()` with column definitions: `['field.name' => 'Display Title']`
- Handles search, sorting, date formatting automatically
- Example: `BlogDatatable` queries Blog model with translatable title/content
- **Important**: Date columns use `preDefinedDateColumns` array for auto-formatting

### Admin Controllers Pattern
All admin resource controllers follow REST conventions:
- Use `FileUploader` trait for image uploads to `storage/public/{resource}` dirs
- Handle transactions: `DB::beginTransaction()` for multi-step creates/updates
- Share languages via constructor: `$this->langs = Lang::all()`
- Create translations in loop: `foreach ($this->langs as $lang) { ... }`

### Service Layer (Emerging)
Implement `BaseService` interface for complex logic:
```php
interface BaseService {
    public function store($data);
    public function update(array $array, $model);
    public function saveTranslatable($data, $id);
}
```
Services exist for: Banners, Portfolio, Service Content, Tags, Steps.

## File Upload Conventions

**Trait**: `App\Traits\FileUploader`
- Method: `upload($request, name: 'field', dir: 'resource')`
- Stores to: `storage/app/public/{dir}/{filename}`
- Returns path string for DB storage
- Always store image + big_image variants when present

## Permission & Access Control

- **Spatie Permission**: `spatie/laravel-permission` for roles
- **Middleware**: `auth` (default web guard) protects admin routes
- **Config**: `config/cms_sidebar_menu.php` maps permissions to sidebar items
- **Pattern**: Check `can: 'permission.name'` in menu config before showing links

## View Sharing Pattern

`AppServiceProvider::boot()` auto-shares data to all admin views:
- `$sidebarItems`: From `CmsSidebar` singleton pattern
- `$languages`, `$langs`: All Lang models
- `$users`, `$contact`: Common resources
- Add new shares here, not in individual controllers

## Language Switching

- **Route**: `GET /lang/{lang}` via `LanguageController`
- **Middleware**: `SetLanguage` (web group) manages session locale
- **Config**: Supports nested locales (es-MX, es-CO)

## Database Key Patterns

- **Models with Translations**: Blog, Service, Portfolio, Step, Banner, Bcategory, Pcategory, etc.
- **ID Generation**: `haruncpi/laravel-id-generator` package installed
- **Slug Field**: Present in base model, generated from name via `Str::slug()`

## Frontend Routes Structure

- **Language Middleware**: All public routes wrapped in `['middleware' => 'language']`
- **Controllers**: `App\Http\Controllers\Front\{Resource}Controller`
- **Singular Routes**: Blog, About, Services, Portfolio load by `:slug` binding
- **List Routes**: `/blogs`, `/services`, `/portfolio` for index views

## Build & Development Commands

```bash
# PHP/Laravel
php artisan migrate              # Run pending migrations
php artisan db:seed              # Seed database
php artisan tinker               # Interactive shell
php artisan cache:clear          # Clear app cache
php artisan config:cache         # Rebuild config cache
php artisan route:list           # List all routes
./vendor/bin/phpunit             # Run tests (Feature + Unit)

# Frontend
npm run development              # Build assets (watch mode)
npm run production               # Minified production build
npm run watch                    # Watch for changes
npm run hot                      # Hot reload

# Docker (Laravel Sail)
./sail artisan {command}         # Run artisan in container
./sail npm {command}             # Run npm in container
```

## Critical Configuration Files

- `config/translatable.php`: Language locales and fallback behavior
- `config/cms_sidebar_menu.php`: Admin navigation structure and permissions
- `config/permission.php`: Role/permission setup
- `.env.example`: Database and service credentials

## Debugging Tips

- **Disable Query Log**: Set `DB::enableQueryLog()` manually in BaseDatatable if needed
- **Blade Debugging**: Use `@dd($variable)` in views
- **Route Issues**: Run `php artisan route:list` to verify binding model resolution
- **Test Support**: Both Feature and Unit tests in `tests/` directory with TestCase base

## Common Gotchas

1. **Translatable Models**: Must call `->translate($lang)` or use dot notation for custom locale access
2. **Slug Generation**: Always generate before creating model (used for route binding)
3. **File Uploads**: Two-step process—`upload()` returns path, then save to DB
4. **Admin Permissions**: Check menu config `can` field; missing permissions silently hide menu items
5. **Language Context**: Frontend always operates in session language; admin interfaces often need explicit language loop
