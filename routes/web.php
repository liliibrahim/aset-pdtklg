<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetReportController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ICTAduanController;
use App\Http\Controllers\IctReportController;
use App\Http\Controllers\Auth\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/get-units/{bahagian}', [UserController::class, 'getUnitsByBahagian'])
    ->name('get-units');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | AUTO REDIRECT DASHBOARD IKUT ROLE
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', function () {
        return match (Auth::user()->role) {
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
    Route::middleware(['role:admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/dashboard', [AdminDashboardController::class, 'index'])
                ->name('dashboard');

            Route::get('/activity-logs', [ActivityLogController::class, 'index'])
                ->name('activity-logs.index');

            Route::get('/activity-logs/pdf', [ActivityLogController::class, 'pdf'])
                ->name('activity-logs.pdf');

            // Pengguna
            Route::get('/users', [UserController::class, 'index'])->name('users.index');
            Route::get('/users/admins', [UserController::class, 'admins'])->name('users.admins');
            Route::get('/users/ict', [UserController::class, 'ict'])->name('users.ict');

            Route::get('/users/{user}/edit', [UserController::class, 'edit'])
                ->name('users.edit');

            Route::put('/users/{user}', [UserController::class, 'update'])
                ->name('users.update');

            Route::get('/users/create', [RegisteredUserController::class, 'create'])
                ->name('users.create');

            Route::post('/users', [RegisteredUserController::class, 'store'])
                ->name('users.store');
        });

    /*
    |--------------------------------------------------------------------------
    | ICT ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:ict'])
        ->prefix('ict')
        ->name('ict.')
        ->group(function () {

            /*
            | DASHBOARD ICT
            */
            Route::get('/dashboard', [DashboardController::class, 'ict'])
                ->name('dashboard');

            Route::get('/dashboard/filter', [DashboardController::class, 'filter'])
                ->name('dashboard.filter');

            /*
            | ASSET MANAGEMENT LAPORAN A DAN B KEWPA
            */
            Route::resource('assets', AssetController::class)
                ->only(['index', 'create', 'store', 'edit', 'update', 'show']);

            Route::delete('/assets/{asset}', [AssetController::class, 'destroy'])
                ->name('assets.destroy');

            Route::get('/assets/{id}/laporan-a', [AssetReportController::class, 'laporanA'])
                ->name('assets.laporanA');

            Route::get('/assets/{id}/laporan-b', [AssetReportController::class, 'laporanB'])
                ->name('assets.laporanB');

            /*
            |--------------------------------------------------------------------------
            | ICT ADUAN (OPERASI HARIAN)
            | URL: /ict/aduan
            |--------------------------------------------------------------------------
            */
            Route::get('/aduan', [ICTAduanController::class, 'index'])
                ->name('aduan.index');

            Route::put('/aduan/{aduan}', [ICTAduanController::class, 'update'])
                ->name('aduan.update');

            /*
            |--------------------------------------------------------------------------
            | ICT LAPORAN (ADUAN, ASET ROSAK, ASET USANG)
            |--------------------------------------------------------------------------
            | URL:
            | /ict/laporan/aduan
            | /ict/laporan/aset-rosak
            | /ict/laporan/aset-usang
            |--------------------------------------------------------------------------
            */
            Route::prefix('laporan')
                ->name('laporan.')
                ->group(function () {

                    // Laporan Aduan
                    Route::get('/aduan', [ICTAduanController::class, 'laporan'])
                        ->name('aduan');

                    Route::get('/aduan/pdf', [ICTAduanController::class, 'laporanPdf'])
                        ->name('aduan.pdf');

                    // Laporan Aset Rosak
                    Route::get('/aset-rosak', [IctReportController::class, 'asetRosak'])
                        ->name('aset_rosak');
                    
                    Route::get('/aset-rosak/pdf', [IctReportController::class, 'asetRosakPdf'])
                        ->name('aset_rosak.pdf');

                    // Laporan Aset Usang
                    Route::get('/aset_usang', [IctReportController::class, 'asetUsang'])
                        ->name('aset_usang');                 
                   
                    Route::get('/aset-usang/pdf', [IctReportController::class, 'asetUsangPdf'])
                    ->name('aset_usang.pdf');
                                });

            /*
            | AJAX
            */
            Route::get('/get-units-by-bahagian',
                [DashboardController::class, 'getUnitsByBahagian']
            )->name('getUnitsByBahagian');
        });

    /*
    |--------------------------------------------------------------------------
    | USER ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:user'])
        ->prefix('user')
        ->name('user.')
        ->group(function () {

            Route::get('/dashboard', [DashboardController::class, 'user'])
                ->name('dashboard');

            Route::get('/aduan/{asset}', [ComplaintController::class, 'create'])
                ->name('aduan.create');

            Route::post('/aduan', [ComplaintController::class, 'store'])
                ->name('aduan.store');
        });

    /*
    |--------------------------------------------------------------------------
    | API
    |--------------------------------------------------------------------------
    */
    Route::get('/api/units/{bahagian}', function ($bahagianId) {
        return \App\Models\Unit::where('bahagian_id', $bahagianId)
            ->orderBy('nama')
            ->get();
    });
});
