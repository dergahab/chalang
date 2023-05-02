<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Api\DatatableController;
use App\Http\Controllers\Api\MainController;
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
Auth::routes();
Auth::routes(['register' => false]);
Route::get('/', function () {
    // return view('auth.login');
    return view('coming-soon');
})->name('/');

Route::get('blogs', function () {
    // return view('auth.login');
    return view('front.blog');
})->name('blogs');

Route::get('about-us', function () {
    // return view('auth.login');
    return view('front.blog');
})->name('about-us');

Route::get('cuntuct-us', function () {
    // return view('auth.login');
    return view('front.contuct-us');
})->name('cuntuct-us');

Route::get('services', function () {
    // return view('auth.login');
    return view('front.services');
})->name('services');



Route::get('portfolio', function () {
    // return view('auth.login');
    return view('front.portfolio');
})->name('portfolio');