<?php

use App\Http\Controllers\SettingController;
use App\Http\Controllers\SettingValueController;
use App\Http\Controllers\StockReconciliationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RepositoryController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [App\Http\Controllers\AccessController::class, 'authenticate']);


Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::post('/top-cards', [DashboardController::class, 'index']);

    Route::post('/settings', [SettingController::class, 'index']);
    Route::post('settings/{id}', [SettingController::class, 'show']);
    Route::post('create-settings', [SettingController::class, 'store']);
    Route::patch('update-settings/{id}', [SettingController::class, 'update']);
    Route::post('fetch-setting/{key}', [SettingController::class, 'fetchByKey']);
    Route::post('search-settings', [SettingController::class, 'search']);
    
    Route::post('/setting-values', [SettingValueController::class, 'index']);
    Route::post('setting-values/{id}', [SettingValueController::class, 'show']);
    Route::post('create-setting-values', [SettingValueController::class, 'store']);
    Route::patch('update-setting-values/{id}', [SettingValueController::class, 'update']);
    
    Route::resource('repositories', RepositoryController::class)->only(['index', 'show']);
    Route::post('/repositories/sync', [RepositoryController::class, 'sync']);
});


Route::get('/{any}', function () { return view('app'); })->where('any', '.*');
