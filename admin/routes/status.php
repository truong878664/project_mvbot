<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StatusController;
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

    // Route of admin status
    Route::prefix('status')->name('status.')->group(function() {
        // Home status
        Route::get('/', [StatusController::class, 'index'])->name('index');
        
        //Add robot
        Route::get('/add-robot', [StatusController::class, 'addRobot'])->name('addRobot');
    });

});