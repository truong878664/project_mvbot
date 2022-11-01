<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MissionsController;
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
    Route::prefix('misions')->name('missions.')->group(function() {
        // Home missions
        Route::get('/', [MissionsController::class, 'index'])->name('index');

        //Group points
        Route::prefix('points')->name('points.')->group(function() {
            //Home points
            Route::get('/', [MissionsController::class, 'points'])->name('index');

            //Create points
            Route::get('/{robot}/create-points', [MissionsController::class, 'createPoints'])->name('createPoints');

            //Save points
            Route::post('/{robot}/save-points', [MissionsController::class, 'savePoints'])->name('savePoints');

            //Delete points
            Route::get('/delete-points/{point}', [MissionsController::class, 'deletePoint'])->name('deletePoint');
        });

        //Group steps missions
        Route::prefix('steps')->name('steps.')->group(function() {
            Route::get('/', [MissionsController::class, 'steps'])->name('index');

            Route::post('/add-groups', [MissionsController::class, 'addGroups'])->name('addGroups');
            
            Route::post('/add-point-groups/{point}', [MissionsController::class, 'addPointGroups'])->name('addPointGroups');

            Route::post('/add-music-groups', [MissionsController::class, 'addMusicGroups'])->name('addMusicGroups');

            Route::post('/add-sleep-groups', [MissionsController::class, 'addSleepGroups'])->name('addSleepGroups');

            Route::post('/add-signal-groups', [MissionsController::class, 'addWarningGroups'])->name('addWarningGroups');

            Route::post('/add-number-groups', [MissionsController::class, 'addTimeoutGroups'])->name('addTimeoutGroups');

            Route::post('/add-if-groups', [MissionsController::class, 'addIfGroups'])->name('addIfGroups');

            Route::post('/add-else-groups', [MissionsController::class, 'addElseGroups'])->name('addElseGroups');

            Route::post('/add-endif-groups', [MissionsController::class, 'addEndIfGroups'])->name('addEndIfGroups');

            Route::post('/add-io-groups', [MissionsController::class, 'addIOGroups'])->name('addIOGroups');

            Route::post('/add-footprint-groups', [MissionsController::class, 'addFootPrintGroups'])->name('addFootPrintGroups');

            Route::post('/add-trycatch-groups', [MissionsController::class, 'addTryCatchGroups'])->name('addTryCatchGroups');

            Route::get('/delete/{group}', [MissionsController::class, 'deleteGroup'])->name('deleteGroup');

            Route::post('/send-mission/{group}', [MissionsController::class, 'sendMissionToRobot'])->name('sendMission');
        });

        //Tracking steps missions
        Route::prefix('tracking')->name('tracking.')->group(function() {
            Route::get('/', [MissionsController::class, 'trackingMission'])->name('index');

            Route::get('/{robot}/tracking-mission', [MissionsController::class, 'trackingStepMission'])->name('trackingStepMission');
        });
    });

});