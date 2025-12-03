<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        // Ambil semua log, terbaru dahulu
        $logs = ActivityLog::with(['user', 'asset'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('activity.index', compact('logs'));
    }
}
