<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\DisposalController;
use App\Http\Controllers\ActivityLogController;

use App\Models\Unit;

/*
|--------------------------------------------------------------------------
| WELCOME PAGE
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| AJAX: Dapatkan senarai unit mengikut bahagian
|--------------------------------------------------------------------------
*/
Route::get('/get-units/{bahagian}', function ($bahagian) {
    return Unit::where('bahagian_id', $bahagian)->get();
});

/*
|--------------------------------------------------------------------------
| UNIVERSAL DASHBOARD REDIRECT
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {

    $user = Auth::user();
    if (!$user) return redirect()->route('welcome');

    if ($user->role === 'admin_system') {
        return redirect()->route('admin.dashboard');
    }

    if ($user->role === 'ict') {
        return redirect()->route('ict.dashboard');
    }

    return redirect()->route('welcome');

})->middleware(['auth'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| ADMIN SISTEM ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth'])   // REMOVE role:admin_system
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'admin'])
            ->name('dashboard');

        Route::resource('users', UserController::class);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('assets', AssetController::class);

        Route::get('/activity-logs', [ActivityLogController::class, 'index'])
            ->name('activity.logs');
    });

/*
|--------------------------------------------------------------------------
| PEGAWAI ICT ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('ict')
    ->name('ict.')
    ->middleware(['auth'])   // REMOVE role:ict
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'ict'])
            ->name('dashboard');

        Route::resource('assets', AssetController::class)
            ->only(['index','create','store','edit','update','show']);

        Route::resource('maintenance', MaintenanceController::class)
            ->only(['store','update','destroy']);

        Route::resource('disposals', DisposalController::class)
            ->only(['store','update','destroy']);

        Route::resource('suppliers', SupplierController::class)
            ->only(['index','create','store']);
    });
