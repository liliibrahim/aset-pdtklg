<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Supplier;

class AssetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Senarai aset
     */
    public function index()
    {
        $assets = Asset::latest()->paginate(20);

        return view('assets.index', compact('assets'));
    }

    /**
     * Papar borang tambah aset
     */
    public function create()
    {
        return view('assets.create', [
            'suppliers' => Supplier::all(),
        ]);
    }

    /**
     * Simpan aset baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_peralatan' => 'required|unique:assets,no_peralatan',
            'nama'         => 'required',
            'sumber'       => 'required',
        ]);

        Asset::create([
            'no_peralatan'    => $request->no_peralatan,
            'no_aset_dalaman' => $request->no_aset_dalaman,
            'nama'            => $request->nama,
            'jenama'          => $request->jenama,
            'model'           => $request->model,
            'kategori'        => $request->kategori,
            'tahun_perolehan' => $request->tahun_perolehan,
            'harga'           => $request->harga,
            'sumber'          => $request->sumber,
            'pembekal_id'     => $request->pembekal_id,
            'status'          => $request->status ?? 'Aktif',
        ]);

        return redirect()->route('ict.assets.index')
                         ->with('success', 'Aset berjaya ditambah!');
    }
}
