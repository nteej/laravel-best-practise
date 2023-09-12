<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', [SiteController::class, 'default']);
Route::get('/', [SiteController::class, 'index']);

Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
});
Route::get('services', [SiteController::class, 'services']);
Route::get('work', [SiteController::class, 'work']);
Route::get('company', [SiteController::class, 'company']);
Route::get('careers', [SiteController::class, 'careers']);
Route::get('careers/culture-handbook', [SiteController::class, 'cultureHandbook']);
Route::get('blog', [SiteController::class, 'blog']);
Route::get('contact', [SiteController::class, 'contact']);

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/admin/commodities/upload', [App\Http\Controllers\Admin\CommodityController::class, 'upload'])->name('commodities.upload');
Route::get('/admin/commodities/', [App\Http\Controllers\Admin\CommodityController::class, 'index'])->name('commodities.list');
Route::get('/admin/commodities/create', [App\Http\Controllers\Admin\CommodityController::class, 'index'])->name('commodities.create');
Route::get('/admin/commodities/upload', [App\Http\Controllers\Admin\CommodityController::class, 'uploadFile'])->name('commodities.uploadFile');
