<?php

Route::redirect('admin', 'dashboard');
Route::redirect('admin/login', 'login');

use App\Http\Controllers\Front\AboutController;
use App\Http\Controllers\Front\BlogController;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\MainController as FrontMainController;
use App\Http\Controllers\Front\MessageController;
use App\Http\Controllers\Front\OrderController;
use App\Http\Controllers\Front\PackageController;
use App\Http\Controllers\Front\PackageInquiryController;
use App\Http\Controllers\Front\CallRequestController;
use App\Http\Controllers\Front\PortfolioController;
use App\Http\Controllers\Front\ServiceController;
use App\Http\Controllers\Front\SubscribeController;
use App\Http\Controllers\LanguageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Login Routes...
Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Password Reset Routes...
Route::get('password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email')->middleware('throttle:3,1');
Route::get('password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

// Password Confirmation Routes...
Route::get('password/confirm', [App\Http\Controllers\Auth\ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
Route::post('password/confirm', [App\Http\Controllers\Auth\ConfirmPasswordController::class, 'confirm']);

// Email Verification Routes...
Route::get('email/verify', [App\Http\Controllers\Auth\VerificationController::class, 'show'])->name('verification.notice');
Route::get('email/verify/{id}/{hash}', [App\Http\Controllers\Auth\VerificationController::class, 'verify'])->name('verification.verify');
Route::post('email/resend', [App\Http\Controllers\Auth\VerificationController::class, 'resend'])->name('verification.resend');

Route::get('/', [FrontMainController::class, 'reactPreview'])->name('/');
Route::get('/legacy', [FrontMainController::class, 'index'])->name('legacy');


Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
], function () {

    Route::get('preview', [FrontMainController::class, 'preview'])->name('preview');

    // Route::get('index', [FrontMainController::class, 'index'])->name('/');
    Route::get(LaravelLocalization::transRoute('routes.blogs'), [BlogController::class, 'newIndex'])->name('blogs');
    Route::get(LaravelLocalization::transRoute('routes.blog').'/{blog:slug}', [BlogController::class, 'newSingle'])->name('blog');
    Route::get(LaravelLocalization::transRoute('routes.about-us'), [AboutController::class, 'newVersion'])->name('about-us');
    // Contact page (new version)
    Route::get(LaravelLocalization::transRoute('routes.contact'), [ContactController::class, 'newVersion'])->name('contact');
    Route::view(LaravelLocalization::transRoute('routes.cookie-policy'), 'front.cookie-policy')->name('cookie-policy');

    Route::get(LaravelLocalization::transRoute('routes.services'), [ServiceController::class, 'newIndex'])->name('services');
    Route::get(LaravelLocalization::transRoute('routes.service-detail').'/{slug}', [ServiceController::class, 'newDetails'])->name('service.single');

    Route::get(LaravelLocalization::transRoute('routes.packages'), [PackageController::class, 'index'])->name('packages');

    Route::get(LaravelLocalization::transRoute('routes.portfolio'), [PortfolioController::class, 'newIndex'])->name('portfolio');
    Route::get(LaravelLocalization::transRoute('routes.portfolio-detail').'/{portfolio:slug}', [PortfolioController::class, 'newDetails'])->name('portfolio.single');

    Route::get(LaravelLocalization::transRoute('routes.case-studies'), [\App\Http\Controllers\Front\CaseStudyController::class, 'index'])->name('case-study.index');
    Route::get(LaravelLocalization::transRoute('routes.case-study').'/{slug}', [\App\Http\Controllers\Front\CaseStudyController::class, 'show'])->name('case-study.show');

    Route::get(LaravelLocalization::transRoute('routes.team'), [\App\Http\Controllers\Front\TeamController::class, 'index'])->name('team.index');
});

Route::group(['prefix' => 'preview', 'as' => 'preview.', 'middleware' => 'language'], function () {
    Route::get('about-us', [AboutController::class, 'newVersion'])->name('about-us');
    Route::get('services', [ServiceController::class, 'newIndex'])->name('services');
    Route::get('service-detail/{slug}', [ServiceController::class, 'newDetails'])->name('service.single');
    Route::get('packages', [PackageController::class, 'preview'])->name('packages');
    Route::get('portfolio', [PortfolioController::class, 'newIndex'])->name('portfolio');
    Route::get('portfolio-detail/{portfolio:slug}', [PortfolioController::class, 'newDetails'])->name('portfolio.single');
    Route::get('contact', [ContactController::class, 'newVersion'])->name('contact');
    Route::view('cookie-policy', 'front.cookie-policy')->name('cookie-policy');
    Route::get('case-studies', [\App\Http\Controllers\Front\CaseStudyController::class, 'index'])->name('case-study.index'); // Reusing existing for now if compatible
    Route::get('case-study/{slug}', [\App\Http\Controllers\Front\CaseStudyController::class, 'show'])->name('case-study.show'); // Reusing existing
    Route::get('team', [\App\Http\Controllers\Front\TeamController::class, 'index'])->name('team.index');
    Route::get('blogs', [BlogController::class, 'newIndex'])->name('blogs');
    Route::get('blog/{blog:slug}', [BlogController::class, 'newSingle'])->name('blog');
});

Route::get('lang/{lang}', [LanguageController::class, 'changeLanguage'])->name('lang.change');
Route::post('contact', MessageController::class)
    ->middleware('throttle:10,1') // basic rate-limit to reduce spam/burst
    ->name('contact.submit');
Route::post('subscribe', SubscribeController::class)
    ->middleware('throttle:10,1')
    ->name('subscribe');

Route::post('order', OrderController::class)
    ->middleware('throttle:10,1')
    ->name('order.submit');

Route::post('packages/request', PackageInquiryController::class)
    ->middleware('throttle:10,1')
    ->name('packages.submit');

Route::post('book-a-call', CallRequestController::class)
    ->middleware('throttle:10,1')
    ->name('call.submit');

// React Migration Test Route (Redirected to new production routes)
Route::redirect('/react-test', '/');
Route::redirect('/react-test/about', '/about-us');

// Decoupled Client API Endpoints (Faza 5 - TanStack Query - API-Ready Integration)
Route::group(['prefix' => 'api', 'middleware' => ['web', 'language']], function () {
    Route::get('services', [FrontMainController::class, 'apiServices']);
    Route::get('portfolio', [FrontMainController::class, 'apiPortfolio']);
    Route::get('testimonials', [FrontMainController::class, 'apiTestimonials']);
    Route::get('blog', [FrontMainController::class, 'apiBlog']);
    Route::get('metrics', [FrontMainController::class, 'apiMetrics']);
});

