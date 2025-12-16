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
    |----------------------------------------------------------------------
    | AUTO REDIRECT DASHBOARD IKUT ROLE
    |----------------------------------------------------------------------
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
    |----------------------------------------------------------------------
    | ADMIN ROUTES (TAMBAHAN BARU – TIDAK GANGGU YANG LAMA)
    |----------------------------------------------------------------------
    */
    Route::middleware(['role:admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            // Dashboard Admin
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])
                ->name('dashboard');

            // Log Aktiviti Sistem
            Route::get('/activity-logs', [ActivityLogController::class, 'index'])
                ->name('activity-logs.index');

            Route::get('/activity-logs/pdf', [ActivityLogController::class, 'pdf'])
                ->name('activity-logs.pdf');

            // ================== PENGGUNA ==================

// Senarai semua pengguna
Route::get('/users', [UserController::class, 'index'])
    ->name('users.index');

// Senarai Pentadbir Sistem
Route::get('/users/admins', [UserController::class, 'admins'])
    ->name('users.admins');

// Senarai Pegawai ICT
Route::get('/users/ict', [UserController::class, 'ict'])
    ->name('users.ict');

// Edit & kemaskini pengguna
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
    |----------------------------------------------------------------------
    | ICT ROUTES (KEKAL – TIDAK DIUBAH)
    |----------------------------------------------------------------------
    */
    Route::middleware(['role:ict'])
        ->prefix('ict')
        ->name('ict.')
        ->group(function () {

            // Dashboard
            Route::get('/dashboard', [DashboardController::class, 'ict'])
                ->name('dashboard');

            Route::get('/dashboard/filter', [DashboardController::class, 'filter'])
                ->name('dashboard.filter');

            // Asset Management
            Route::resource('assets', AssetController::class)
                ->only(['index', 'create', 'store', 'edit', 'update', 'show']);

            Route::delete('/assets/{asset}', [AssetController::class, 'destroy'])
                ->name('assets.destroy');

            // Asset Reports (A & B)
            Route::get('/assets/{id}/laporan-a', [AssetReportController::class, 'laporanA'])
                ->name('assets.laporanA');

            Route::get('/assets/{id}/laporan-b', [AssetReportController::class, 'laporanB'])
                ->name('assets.laporanB');

            /*
            |--------------------------------------------------------------
            | ICT REPORTS (WEB + PDF)
            |--------------------------------------------------------------
            */
            Route::prefix('laporan')->name('laporan.')->group(function () {

                Route::get('/aduan', [IctReportController::class, 'aduan'])
                    ->name('aduan');

                Route::get('/aset-rosak', [IctReportController::class, 'asetRosak'])
                    ->name('aset_rosak');

                Route::get('/aset_usang', [IctReportController::class, 'asetUsang'])
                    ->name('aset_usang');

                // PDF
                Route::get('/aduan/pdf', [IctReportController::class, 'aduanPdf'])
                    ->name('aduan.pdf');

                Route::get('/aset-rosak/pdf', [IctReportController::class, 'asetRosakPdf'])
                    ->name('aset_rosak.pdf');

                Route::get('/aset_usang/pdf', [IctReportController::class, 'asetUsangPdf'])
                    ->name('aset_usang.pdf');
            });

            /*
            |--------------------------------------------------------------
            | ICT ADUAN MANAGEMENT
            |--------------------------------------------------------------
            */
            Route::get('/aduan', [ICTAduanController::class, 'index'])
                ->name('aduan.index');

            Route::get('/aduan/{aduan}', [ICTAduanController::class, 'show'])
                ->name('aduan.show');

            Route::put('/aduan/{aduan}', [ICTAduanController::class, 'update'])
                ->name('aduan.update');

            // AJAX
            Route::get('/get-units-by-bahagian',
                [DashboardController::class, 'getUnitsByBahagian']
            )->name('getUnitsByBahagian');
        });

    /*
    |----------------------------------------------------------------------
    | USER ROUTES (KEKAL – TIDAK DIUBAH)
    |----------------------------------------------------------------------
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
    |----------------------------------------------------------------------
    | API (KEKAL)
    |----------------------------------------------------------------------
    */
    Route::get('/api/units/{bahagian}', function ($bahagianId) {
        return \App\Models\Unit::where('bahagian_id', $bahagianId)
            ->orderBy('nama')
            ->get();
    });

});
