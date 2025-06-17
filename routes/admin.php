<?php

// use App\Http\Controllers\Admin\CompanyController;
// use App\Http\Controllers\Admin\ContenttextCortoller;

use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ContenttextCortoller;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\Portfolio\PortfolioController as PortfolioPortfolioController;
use App\Http\Controllers\Admin\Service\ServiceContentController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Api\DatatableController;
use App\Http\Controllers\Api\MainController;
// use App\Models\Pcategory;
use Illuminate\Support\Facades\Route;
use UniSharp\LaravelFilemanager\Lfm;

Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::resource('role', 'RoleController');

Route::get('datatable/{table}', [DatatableController::class, 'handle'])
    ->name('datatable.source');

Route::get('toggle-published-status', [MainController::class, 'togglePublish'])
    ->name('toggle_publish');

Route::resource('user', 'UserController');
Route::get('user-list', [UserController::class, 'list'])->name('user.list');
Route::get('account', [UserController::class, 'account'])->name('account');
Route::get('get-users', [UserController::class, 'getUsers'])->name('get.users');
Route::get('message', [MessageController::class, 'index'])->name('message');
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    Lfm::routes();
});

Route::resource('pcategory', 'Portfolio\PcategoryController');
Route::resource('portfolio', 'Portfolio\PortfolioController');

Route::resource('bcategory', 'Blog\BcategoryController');
Route::resource('blog', 'Blog\BlogController');

Route::resource('service', "Service\ServiceController");
Route::resource('social-media', 'SocialmediaController');
Route::resource('service-content', "Service\ServiceContentController");

Route::resource('contanct', ContactController::class);
Route::resource('tag', TagController::class);
Route::resource('content-text', ContenttextCortoller::class);
Route::resource('step', 'StepController');
Route::resource('banner', 'BannerController');

Route::resource('file', 'FileController')->except(['create', 'index', 'update']);
Route::post('order', 'FileController@order')->name('image.order');

//Admin routes

Route::get('index', 'AboutController@index')->name('about.index');
Route::put('udate/{id?}', 'AboutController@update')->name('about.update');

Route::resource('company', CompanyController::class);
