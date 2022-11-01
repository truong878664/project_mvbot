<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MapsController;
use App\Models\User;
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

    // Route of admin misions
    Route::prefix('maps')->name('maps.')->group(function() {
        // Home missions
        Route::get('/', [MapsController::class, 'index'])->name('index');

        //Group lists maps
        Route::prefix('list')->name('list.')->group(function() {
            Route::get('/', [MapsController::class, 'listMaps'])->name('index');

            Route::post('/send-robot/{map}', [MapsController::class, 'sendMapRobot'])->name('sendMapRobot');
        });

        //Group mapping AMR
        Route::prefix('mapping')->name('mapping.')->group(function() {
            Route::get('/', [MapsController::class, 'mapping'])->name('index');

            Route::get('/{robot}/controller-mapping', [MapsController::class, 'controllerMapping'])->name('controllerMapping');

            Route::post('/{robot}/save-mapping', [MapsController::class, 'saveMapping'])->name('saveMapping');
        });
    });

});