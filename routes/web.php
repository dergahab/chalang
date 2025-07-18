<?php

use App\Http\Controllers\Front\MessageController;
use App\Http\Controllers\Front\AboutController;
use App\Http\Controllers\Front\BlogController;
use App\Http\Controllers\Front\MainController as FrontMainController;
use App\Http\Controllers\Front\PortfolioController;
use App\Http\Controllers\Front\ServiceController;
use App\Http\Controllers\LanguageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Auth::routes(['register' => false]);

Route::get('/', [FrontMainController::class, 'index'])->name('/');


Route::group(['middleware' => 'language'], function () {

    // Route::get('index', [FrontMainController::class, 'index'])->name('/');
    Route::get('blogs', [BlogController::class, 'index'])->name('blogs');
    Route::get('blog/{blog:slug}', [BlogController::class, 'single'])->name('blog');
    Route::get('about-us', AboutController::class)->name('about-us');
    Route::get('contact', function () {

        return view('front.contuct-us');
    })->name('cuntuct-us');

    Route::get('services', [ServiceController::class, 'index'])->name('services');
    Route::get('service-deatail/{service:slug}', [ServiceController::class, 'details'])->name('service.single');

    Route::get('portfolio', [PortfolioController::class, 'index'])->name('portfolio');
    Route::get('portfolio-deatail/{portfolio:slug}', [PortfolioController::class, 'details'])->name('portfolio.single');
});

Route::get('lang/{lang}', [LanguageController::class, 'changeLanguage'])->name('lang.change');
Route::post('contact', MessageController::class);
