<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Models\User;
use App\Models\StatusRobots;

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

// Route::get('/', function () {
//     return view('auth.login');
// });

// Auth::routes(
//    ['register' => false]
// );

// Route of admin
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function() {

    Route::get('/', [DashboardController::class, 'index'])->name('index');

    // Route of admin setting
    Route::prefix('setting')->name('setting.')->group(function() {
        // Home setting
        Route::get('/', [SettingController::class, 'index'])->name('index');

        Route::prefix('wifi')->name('wifi.')->group(function() {
            
            Route::get('/', [SettingController::class, 'homeWifi'])->name('index');
            
            Route::get('/{robot}', [SettingController::class, 'getWifi'])->name('getWifi');

            Route::post('/{robot}/add', [SettingController::class, 'addWifi'])->name('addWifi');

            Route::get('/delete/{wifi}', [SettingController::class, 'deleteWifi'])->name('deleteWifi');
        });

        Route::prefix('users')->name('users.')->group(function() {
            
            Route::get('/', [SettingController::class, 'homeUsers'])->name('index');

            // Route::post('/{robot}/add', [SettingController::class, 'addWifi'])->name('addWifi');

            // Route::get('/delete/{wifi}', [SettingController::class, 'deleteWifi'])->name('deleteWifi');
        });

        Route::prefix('ethernet')->name('ethernet.')->group(function() {
            
            Route::get('/', [SettingController::class, 'homeEthernet'])->name('index');
            
            Route::post('/{robot}/send', [SettingController::class, 'userSendIp'])->name('userSendIp');

            // Route::post('/{robot}/add', [SettingController::class, 'addWifi'])->name('addWifi');

            // Route::get('/delete/{wifi}', [SettingController::class, 'deleteWifi'])->name('deleteWifi');
        });
    });

});