<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;

class DashboardController extends Controller
{
    /**
     * Dashboard Admin Sistem
     */
    public function admin()
    {
        // jumlah keseluruhan aset
        $totalAset = Asset::count();

        // aset rosak
        $rosak = Asset::where('status', 'Rosak')->count();

        // aset untuk dilupus
        $hampirLupus = Asset::where('status', 'Untuk Dilupus')->count();

        // aset sudah dilupus
        $dilupus = Asset::where('status', 'Dilupus')->count();

        // 10 aset terkini
        $recentAsets = Asset::latest()->take(10)->get();

        return view('dashboards.admin', compact(
            'totalAset',
            'rosak',
            'hampirLupus',
            'dilupus',
            'recentAsets'
        ));
    }

    /**
     * Dashboard Pegawai ICT
     */
    public function ict()
    {
        // jumlah aset keseluruhan
        $totalAset = Asset::count();

        // aset rosak
        $rosak = Asset::where('status', 'Rosak')->count();

        // 10 aset terkini
        $recentAsets = Asset::latest()->take(10)->get();

        return view('dashboards.ict', compact(
            'totalAset',
            'rosak',
            'recentAsets'
        ));
    }
}
