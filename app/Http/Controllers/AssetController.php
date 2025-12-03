<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;


class AssetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * LIST / INDEX
     */
    public function index(Request $request)
    {
        $query = Asset::query();

        if ($request->q) {
            $query->where(function ($q) use ($request) {
                $q->where('no_siri', 'like', "%{$request->q}%")
                  ->orWhere('jenama', 'like', "%{$request->q}%")
                  ->orWhere('model', 'like', "%{$request->q}%")
                  ->orWhere('nama_pengguna', 'like', "%{$request->q}%");
            });
        }

        if ($request->kategori) $query->where('kategori', $request->kategori);
        if ($request->bahagian) $query->where('bahagian', $request->bahagian);
        if ($request->unit)     $query->where('unit', $request->unit);
        if ($request->status)   $query->where('status', $request->status);

        return view('assets.index', [
            'assets'    => $query->paginate(20),
            'kategoris' => Asset::select('kategori')->distinct()->pluck('kategori'),
            'bahagians' => Asset::select('bahagian')->distinct()->pluck('bahagian'),
            'units'     => Asset::select('unit')->distinct()->pluck('unit'),
        ]);
    }

    /**
     * CREATE
     */
    public function create()
    {
        return view('assets.create');
    }

     
    /**
     * STORE
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_siri_aset'       => 'nullable|string',
            'kategori'           => 'nullable|string',
            'sub_kategori'       => 'nullable|string',
            'jenama'             => 'nullable|string',
            'model'              => 'nullable|string',

            'no_siri'            => 'required|string|unique:assets,no_siri',
            'no_siri_sub'        => 'nullable|string',

            'tarikh_perolehan'   => 'nullable|date',
            'harga'              => 'nullable|numeric',

            'sumber_perolehan'   => 'required|string',
            'pembekal'           => 'nullable|string',

            'bahagian'           => 'nullable|string',
            'unit'               => 'nullable|string',
            'lokasi_lain'        => 'nullable|string',
            'nama_pengguna'      => 'nullable|string',

            'tarikh_penempatan'  => 'nullable|date',

            'tarikh_pelupusan'   => 'nullable|date',
            'rujukan_pelupusan'  => 'nullable|string',

            'catatan'            => 'nullable|string',
        ]);

        $validated['status'] = 'Aktif';

        /** @var \App\Models\Asset $asset */
        $asset = Asset::create($validated);

        
        return redirect()->route('ict.assets.index')->with('success', 'Aset berjaya ditambah!');
    }

    /**
     * SHOW
     */
    public function show($id)
    {
        $asset = Asset::with(['movements', 'currentMovement'])->findOrFail($id);
        return view('assets.show', compact('asset'));
    }

    /**
     * UPDATE
     */
    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'no_siri_aset'      => 'nullable|string',
            'kategori'          => 'nullable|string',
            'sub_kategori'      => 'nullable|string',
            'jenama'            => 'nullable|string',
            'model'             => 'nullable|string',

            'no_siri'           => 'required|string',
            'no_siri_sub'       => 'nullable|string',

            'tarikh_perolehan'  => 'nullable|date',
            'harga'             => 'nullable|numeric',
            'sumber_perolehan'  => 'required|string',

            'bahagian'          => 'nullable|string',
            'unit'              => 'nullable|string',
            'nama_pengguna'     => 'nullable|string',

            'status'            => 'required|string',

            'tarikh_pelupusan'  => 'nullable|date',
            'rujukan_pelupusan' => 'nullable|string',

            'catatan'           => 'nullable|string',
        ]);

        // dapatkan nilai lama sebelum update
        $original = $asset->getOriginal();

        $asset->update($validated);

                $this->logMovement($asset, $validated, $original);

        return redirect()->route('ict.assets.index')->with('success', 'Aset berjaya dikemaskini!');
    }

    /**
     * LOG MOVEMENT
     */
    private function logMovement(Asset $asset, array $validated, array $original)
    {
        $fields = ['bahagian', 'unit', 'nama_pengguna'];
        $changed = false;

        foreach ($fields as $field) {
            if (($original[$field] ?? null) !== ($validated[$field] ?? null)) {
                $changed = true;
                break;
            }
        }

        if ($changed) {
            // tamatkan rekod lama
            $last = $asset->movements()->whereNull('tarikh_tamat')->first();
            if ($last) {
                $last->update(['tarikh_tamat' => now()]);
            }

            // cipta rekod baru
            $asset->movements()->create([
                'bahagian'      => $validated['bahagian'] ?? null,
                'unit'          => $validated['unit'] ?? null,
                'nama_pengguna' => $validated['nama_pengguna'] ?? null,
                'tarikh_mula'   => now(),
                'catatan'       => 'Perubahan penempatan aset',
            ]);
        }
    }

    /**
     * EDIT
     */
    public function edit(Asset $asset)
    {
        $unitsByBahagian = [
            "Bahagian Khidmat Pengurusan" => [
                "Unit Pentadbiran Am",
                "Unit ICT",
                "Unit Sumber Manusia",
                "Unit Kewangan",
                "Unit Aset & Stor",
                "Unit Bencana",
                "Unit Majlis dan Keraian",
            ],
            "Bahagian Pengurusan Tanah" => [
                "Unit Pelupusan Tanah",
                "Unit Pembangunan Tanah",
                "Unit Hasil",
                "Unit Teknikal & Penguatkuasaan",
                "Unit Pendaftaran",
                "Unit Pindahmilik & Lelong",
            ],
            "Bahagian Pembangunan" => [
                "Unit Pembangunan Masyarakat",
                "Unit Pembangunan Fizikal",
            ],
        ];
{
    
}
        return view('assets.edit', [
            'asset'            => $asset,
            'unitsByBahagian'  => $unitsByBahagian,
        ]);
        

    }

    /**
     * DESTROY
     */
    public function destroy(Asset $asset)
    {
        $asset->delete();

        return redirect()->route('ict.assets.index')->with('success', 'Aset berjaya dipadam.');
    }
}
