<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\GroupsController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(
   ['register' => false]
);

// Route of admin
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function() {

    Route::get('/', [DashboardController::class, 'index'])->name('index');

    // Route of admin userss
    Route::prefix('users')->name('users.')->middleware('can:users')->group(function() {
        Route::get('/', [UsersController::class, 'index'])->name('index');

        Route::post('/add', [UsersController::class, 'add'])->name('add')->can('users.add');

        Route::post('/edit', [UsersController::class, 'edit'])->name('edit')->can('users.edit');

        Route::get('/delete/{user}', [UsersController::class, 'delete'])->name('delete')->can('users.delete');
    });

    // Route of admin groups
    Route::prefix('groups')->name('groups.')->middleware('can:groups')->group(function() {
        Route::get('/', [GroupsController::class, 'index'])->name('index');

        Route::post('/add', [GroupsController::class, 'add'])->name('add')->can('groups.add');

        Route::post('/edit', [GroupsController::class, 'edit'])->name('edit')->can('groups.edit');

        Route::get('/delete/{group}', [GroupsController::class, 'delete'])->name('delete')->can('groups.delete');

        Route::get('/permission/{group}', [GroupsController::class, 'permission'])->name('permission')->can('groups.permission');

        Route::post('/permission/{group}', [GroupsController::class, 'postPermission'])->can('groups.permission');
    });
});