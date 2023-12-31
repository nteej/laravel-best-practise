<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\TaskController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('commodity-prices', [SiteController::class,'getLatestPrices'])->name('api.commodity_prices');
Route::get('best-price', [SiteController::class,'getLatestPrices'])->name('api.bestprice');
Route::get('locations', [SiteController::class,'getLocations'])->name('api.locations');
Route::post('location', [SiteController::class,'storeLocation'])->name('api.location');

//Route::post('finish-task/{task-id}', TaskController::class,'finishTask')->name('api.task.finish');
Route::resource('tasks', TaskController::class);
