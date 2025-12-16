<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Barryvdh\DomPDF\Facade\Pdf;

class ActivityLogController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Paparan Senarai Semua Log Aktiviti (HTML)
     */
    public function index()
    {
        $logs = ActivityLog::with('user')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('activity_logs.index', compact('logs'));
    }

    /**
     * Cetak Laporan PDF Log Aktiviti
     */
    public function pdf()
    {
        $logs = ActivityLog::with('user')
            ->orderByDesc('created_at')
            ->get(); // 

        $pdf = Pdf::loadView('activity_logs.pdf', compact('logs'));

        return $pdf->stream('log-aktiviti-sistem.pdf');
    }
}
