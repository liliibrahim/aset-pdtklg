<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Unit;

class UnitController extends Controller
{
    public function index($bahagian_id)
    {
        return Unit::where('bahagian_id', $bahagian_id)
            ->orderBy('nama')
            ->get(['id', 'nama']);
    }
}
