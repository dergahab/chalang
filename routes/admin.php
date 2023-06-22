<?php

// use App\Http\Controllers\Admin\CompanyController;
// use App\Http\Controllers\Admin\ContenttextCortoller;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Api\DatatableController;
use App\Http\Controllers\Api\MainController;
// use App\Models\Pcategory;
use Illuminate\Support\Facades\Route;
use \UniSharp\LaravelFilemanager\Lfm;



Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::resource('role', 'RoleController');

Route::get('datatable/{table}', [DatatableController::class, 'handle'])
->name('datatable.source');

Route::get('toggle-published-status', [MainController::class,'togglePublish'])
->name('toggle_publish');


Route::resource('user', 'UserController');
Route::get('user-list', [UserController::class, 'list'])->name('user.list');
Route::get('account',[UserController::class,'account'])->name('account');
Route::get('get-users', [UserController::class, 'getUsers'])->name('get.users');

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    Lfm::routes();
    // \UniSharp\LaravelFilemanager\Lfm::routes();
});


Route::resource('pcategory',"PcategoryController");
Route::resource('portfolio','PortfolioController');

Route::resource('bcategory',"BcategoryController");
Route::resource('blog','BlogController');

Route::resource('service','ServiceController');
Route::resource('social-media','SocialmediaController');
Route::resource('sp-content','SpcontentController');

Route::resource('contanct', ContactController::class);
Route::resource('content-text', ContenttextCortoller::class);

Route::get('service-in-main',[ServiceController::class,'in_main'])->name('service.in_main');
Route::get('portfolio-in-main',[PortfolioController::class,'in_main'])->name('portfolio.in_main');
//Admin routes

Route::resource('company',CompanyController::class);