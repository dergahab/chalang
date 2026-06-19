<?php

use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\ContenttextController;
use App\Http\Controllers\Admin\HomeSectionController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\StepController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PcategoryController;
use App\Http\Controllers\Admin\BcategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\SocialmediaController;
use App\Http\Controllers\Admin\SpcontentController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\CaseStudyController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\PricingPlanController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\SubmissionController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Api\DatatableController;
use App\Http\Controllers\Api\MainController;
use Illuminate\Support\Facades\Route;
use UniSharp\LaravelFilemanager\Lfm;

Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('/global-search', [App\Http\Controllers\Admin\GlobalSearchController::class, 'search'])->name('global.search');
Route::post('dashboard/reorder', [DashboardController::class, 'updateLayout'])->name('dashboard.reorder');


// Moved ServiceController to top for debugging/priority
Route::resource('service', ServiceController::class);
Route::resource('role', RoleController::class);

Route::get('datatable/{table}', [DatatableController::class, 'handle'])
    ->name('datatable.source');

Route::post('toggle-published-status', [MainController::class, 'togglePublish'])
    ->name('toggle_publish');

Route::get('service-in-main', [ServiceController::class, 'in_main'])->name('service.in_main');
Route::get('portfolio-in-main', [PortfolioController::class, 'in_main'])->name('portfolio.in_main');

Route::get('about', [AboutController::class, 'index'])->name('about.index');
Route::put('update/{id?}', [AboutController::class, 'update'])->name('about.update');

Route::resource('step', StepController::class);

Route::resource('message', MessageController::class);
Route::resource('company', CompanyController::class);

Route::resource('contact', ContactController::class);
Route::get('case-study-in-main', [CaseStudyController::class, 'in_main'])->name('case-study.in_main');
Route::get('pricing-plan-is-active', [PricingPlanController::class, 'is_active'])->name('pricing-plan.is_active');


Route::resource('social-media', SocialmediaController::class);
Route::resource('sp-content', SpcontentController::class);

// Restoring missing routes
Route::resource('pcategory', PcategoryController::class);
Route::resource('portfolio', PortfolioController::class);
Route::resource('bcategory', BcategoryController::class);
Route::resource('blog', BlogController::class);
Route::resource('case-study', CaseStudyController::class);
Route::resource('testimonial', TestimonialController::class);
Route::resource('partner', PartnerController::class);
Route::resource('pricing-plan', PricingPlanController::class);
Route::resource('team-member', TeamMemberController::class);
Route::resource('faq', FaqController::class);
Route::get('faq-is-active', [FaqController::class, 'is_active'])->name('faq.is_active');
Route::resource('user', UserController::class);
Route::resource('tag', TagController::class);
Route::resource('content-text', ContenttextController::class);
Route::get('home-sections', [HomeSectionController::class, 'index'])->name('home-sections.index');
Route::get('home-sections/{section}', [HomeSectionController::class, 'edit'])->name('home-sections.edit');
Route::put('home-sections/{section}', [HomeSectionController::class, 'update'])->name('home-sections.update');
Route::resource('banner', BannerController::class);
Route::resource('submission', SubmissionController::class);
Route::resource('subscribe', App\Http\Controllers\Admin\SubscribeController::class);

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    Lfm::routes();
});

Route::get('settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
Route::put('settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

// Analytics & tracking settings
Route::get('analytics/settings', [AnalyticsController::class, 'edit'])->name('analytics.edit');
Route::put('analytics/settings', [AnalyticsController::class, 'update'])->name('analytics.update');

Route::post('bulk-delete', [App\Http\Controllers\Admin\BulkActionController::class, 'delete'])->name('bulk.delete');
Route::post('bulk-revert', [App\Http\Controllers\Admin\BulkActionController::class, 'revert'])->name('bulk.revert');
Route::post('bulk-export', [App\Http\Controllers\Admin\BulkActionController::class, 'export'])->name('bulk.export');

Route::get('activity-log/export', [App\Http\Controllers\Admin\ActivityLogController::class, 'export'])->name('activity-log.export');
Route::get('activity-log', [App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity-log.index');
Route::post('activity-log/{id}/revert', [App\Http\Controllers\Admin\ActivityLogController::class, 'revert'])->name('activity-log.revert');
Route::get('activity-log/history', [App\Http\Controllers\Admin\ActivityLogController::class, 'getHistory'])->name('activity-log.history');
Route::get('activity-log/{id}', [App\Http\Controllers\Admin\ActivityLogController::class, 'show'])->name('activity-log.show');
Route::post('activity-log/{id}/note', [App\Http\Controllers\Admin\ActivityLogController::class, 'updateNote'])->name('activity-log.note');
Route::get('api/ip-info/{ip}', [App\Http\Controllers\Admin\ActivityLogController::class, 'getIpInfo'])->name('api.ip-info');

// Notifications
Route::get('notifications', [App\Http\Controllers\Admin\NotificationController::class, 'list'])->name('notifications.index');
Route::get('notifications/latest', [App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.latest');
Route::post('notifications/{id}/read', [App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('notifications.read');
Route::post('notifications/read-all', [App\Http\Controllers\Admin\NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');

// Analytics
// Health & System
Route::get('health/status', [App\Http\Controllers\Admin\HealthController::class, 'status'])->name('health.status');

// Page Builder (Visual Editor)
Route::get('pages/{id}/builder', [App\Http\Controllers\Admin\PageController::class, 'builder'])->name('pages.builder');
Route::resource('pages', App\Http\Controllers\Admin\PageController::class);

// Telegram Integration
Route::prefix('telegram')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\TelegramIntegrationController::class, 'index'])->name('telegram.index');
    Route::post('generate-code', [App\Http\Controllers\Admin\TelegramIntegrationController::class, 'generateCode'])->name('telegram.generate-code');
    Route::put('{id}/settings', [App\Http\Controllers\Admin\TelegramIntegrationController::class, 'updateSettings'])->name('telegram.update-settings');
    Route::delete('{id}', [App\Http\Controllers\Admin\TelegramIntegrationController::class, 'destroy'])->name('telegram.destroy');
    Route::post('sync-commands', [App\Http\Controllers\Admin\TelegramIntegrationController::class, 'syncCommands'])->name('telegram.sync-commands');
    Route::post('{id}/test', [App\Http\Controllers\Admin\TelegramIntegrationController::class, 'sendTestMessage'])->name('telegram.test');
    Route::post('clear-cache', [App\Http\Controllers\Admin\TelegramIntegrationController::class, 'clearCache'])->name('telegram.clear-cache');
    Route::post('broadcast', [App\Http\Controllers\Admin\TelegramIntegrationController::class, 'broadcast'])->name('telegram.broadcast');
    Route::get('logs', [App\Http\Controllers\Admin\TelegramIntegrationController::class, 'getLogs'])->name('telegram.logs');
});

// Telegram Health
Route::get('telegram-health', [App\Http\Controllers\Admin\TelegramHealthController::class, 'status'])->name('telegram.health');

// Export
Route::prefix('export')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\ExportController::class, 'index'])->name('export.index');
    Route::any('run', [App\Http\Controllers\Admin\ExportController::class, 'export'])->name('export.run');
    Route::get('stream', [App\Http\Controllers\Admin\ExportController::class, 'streamExport'])->name('export.stream');
    Route::get('fields/{model}', [App\Http\Controllers\Admin\ExportController::class, 'getModelFields'])->name('export.fields');
    
    Route::get('history', [App\Http\Controllers\Admin\ExportHistoryController::class, 'index'])->name('export.history');
    Route::get('history/{id}/download', [App\Http\Controllers\Admin\ExportHistoryController::class, 'download'])->name('export.history.download');
    Route::delete('history/{id}', [App\Http\Controllers\Admin\ExportHistoryController::class, 'destroy'])->name('export.history.destroy');

    Route::get('schedules', [App\Http\Controllers\Admin\ExportScheduleController::class, 'index'])->name('export.schedules');
    Route::get('schedules/create', [App\Http\Controllers\Admin\ExportScheduleController::class, 'create'])->name('export.schedules.create');
    Route::post('schedules', [App\Http\Controllers\Admin\ExportScheduleController::class, 'store'])->name('export.schedules.store');
    Route::get('schedules/{schedule}/edit', [App\Http\Controllers\Admin\ExportScheduleController::class, 'edit'])->name('export.schedules.edit');
    Route::put('schedules/{schedule}', [App\Http\Controllers\Admin\ExportScheduleController::class, 'update'])->name('export.schedules.update');
    Route::delete('schedules/{schedule}', [App\Http\Controllers\Admin\ExportScheduleController::class, 'destroy'])->name('export.schedules.destroy');
    Route::post('schedules/{schedule}/toggle', [App\Http\Controllers\Admin\ExportScheduleController::class, 'toggle'])->name('export.schedules.toggle');
    Route::get('schedules/{schedule}/run', [App\Http\Controllers\Admin\ExportScheduleController::class, 'run'])->name('export.schedules.run');
});

// Import
Route::prefix('import')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\ImportController::class, 'index'])->name('import.index');
    Route::post('preview/{model}', [App\Http\Controllers\Admin\ImportController::class, 'preview'])->name('import.preview');
    Route::post('run/{model}', [App\Http\Controllers\Admin\ImportController::class, 'import'])->name('import.run');
    Route::get('progress/{historyId}', [App\Http\Controllers\Admin\ImportController::class, 'progress'])->name('import.progress');
    Route::get('status/{historyId}', [App\Http\Controllers\Admin\ImportController::class, 'status'])->name('import.status');
    Route::get('fields/{model}', [App\Http\Controllers\Admin\ImportController::class, 'getModelFields'])->name('import.fields');
    Route::get('template/{model}/{format}', [App\Http\Controllers\Admin\ImportController::class, 'downloadTemplate'])->name('import.template');
    
    Route::get('history', [App\Http\Controllers\Admin\ImportHistoryController::class, 'index'])->name('import.history');
    Route::get('history/{id}', [App\Http\Controllers\Admin\ImportHistoryController::class, 'show'])->name('import.history.show');
    Route::post('history/{id}/rollback', [App\Http\Controllers\Admin\ImportHistoryController::class, 'rollback'])->name('import.history.rollback');
    Route::delete('history/{id}', [App\Http\Controllers\Admin\ImportHistoryController::class, 'destroy'])->name('import.history.destroy');
    Route::get('history/{id}/retry', [App\Http\Controllers\Admin\ImportHistoryController::class, 'retry'])->name('import.history.retry');
});
