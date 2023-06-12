<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Api\DatatableController;
use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Front\BlogController;
use App\Http\Controllers\Front\MainController as FrontMainController;
use App\Http\Controllers\Front\PortfolioController;
use App\Http\Controllers\Front\ServiceController;
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

if (env('APP_ENV') == 'local'){
    Route::get('/',[FrontMainController::class, 'index'])->name('/');
}else{
    Route::get('/', function () {
        // return view('auth.login');
        return view('coming-soon');
    });
    
    Route::get('index',[FrontMainController::class, 'index'])->name('/');
}


Route::get('blogs', [BlogController::class, 'index'])->name('blogs');
Route::get('blog/{blog:slug}', [BlogController::class, 'single'])->name('blog.single');

Route::get('about-us', function () {
    // return view('auth.login');
    return view('front.about');
})->name('about-us');

Route::get('contact', function () {
    // return view('auth.login');
    return view('front.contuct-us');
})->name('cuntuct-us');

Route::get('services',[ServiceController::class,'index'])->name('services');
Route::get('service-deatail/{service:slug}',[ServiceController::class,'details'])->name('service.single');

Route::get('portfolio',[PortfolioController::class,'index'])->name('portfolio');
Route::get('portfolio-deatail/{portfolio:slug}',[PortfolioController::class,'details'])->name('portfolio.single');