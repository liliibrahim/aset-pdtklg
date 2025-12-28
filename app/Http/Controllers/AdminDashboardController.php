<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bahagian;
use App\Models\Unit;
use App\Models\ActivityLog;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    // Paparkan dashboard pentadbir sistem.
    public function index()
    {
        return view('dashboard.admin', [
    'totalUsers'    => User::count(),
    'totalAdmins'   => User::where('role', 'admin')->count(),
    'totalICT'      => User::where('role', 'ict')->count(),
    'totalBahagian' => Bahagian::count(),
    'totalUnit'     => Unit::count(),
    'aktivitiTerkini'  => ActivityLog::with('user')->latest()->take(5)->get(),
]);
    }
}
