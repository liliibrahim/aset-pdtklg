<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UnitController;

Route::get('/units/{bahagian_id}', [UnitController::class, 'index']);
