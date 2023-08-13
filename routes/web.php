<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\GuestController;
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

Route::get('/', [GuestController::class,'index']);

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/admin/commodities/upload', [App\Http\Controllers\Admin\CommodityController::class,'upload'])->name('commodities.upload');
Route::get('/admin/commodities/', [App\Http\Controllers\Admin\CommodityController::class, 'index'])->name('commodities.list');
Route::get('/admin/commodities/create', [App\Http\Controllers\Admin\CommodityController::class, 'index'])->name('commodities.create');
Route::get('/admin/commodities/upload', [App\Http\Controllers\Admin\CommodityController::class, 'uploadFile'])->name('commodities.uploadFile');
