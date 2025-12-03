<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\ActivityLogController;

/*
|--------------------------------------------------------------------------
| WELCOME PAGE
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| SEMUA ROUTE MESTI LOGIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | AUTO REDIRECT IKUT ROLE
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', function () {

        $role = Auth::user()->role;

        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'ict'   => redirect()->route('ict.dashboard'),
            'user'  => redirect()->route('user.dashboard'),
            default => abort(403),
        };

    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'role:admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/dashboard', [DashboardController::class, 'admin'])
                ->name('dashboard');

        });


    /*
    |--------------------------------------------------------------------------
    | ICT ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'role:ict'])
        ->prefix('ict')
        ->name('ict.')
        ->group(function () {

            // DASHBOARD ICT
            Route::get('/dashboard', [DashboardController::class, 'ict'])
                ->name('dashboard');

            // CHART FILTER (WAJIB UNTUK MAIN CHART BERFUNGSI)
            Route::get('/dashboard/filter', [DashboardController::class, 'filter'])
                ->name('dashboard.filter');

            // ROUTE ASET INDEX/CREATE/EDIT/UPDATE/SHOW
            Route::resource('assets', AssetController::class)
                ->only(['index', 'create', 'store', 'edit', 'update', 'show']);

            // DELETE ASET
            Route::delete('/assets/{asset}', [AssetController::class, 'destroy'])
                ->name('assets.destroy');
        });


    /*
    |--------------------------------------------------------------------------
    | USER ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'role:user'])
        ->prefix('user')
        ->name('user.')
        ->group(function () {

            Route::get('/dashboard', [DashboardController::class, 'user'])
                ->name('dashboard');

        });


    /*
    |--------------------------------------------------------------------------
    | ACTIVITY LOG
    |--------------------------------------------------------------------------
    */
    Route::get('/activity', [ActivityLogController::class, 'index'])
        ->name('activity.index');

});
