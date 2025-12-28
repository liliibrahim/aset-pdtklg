<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use Illuminate\Support\Facades\DB;
use App\Models\Bahagian;
use App\Models\Unit;
use Carbon\Carbon;
use App\Models\User;


class AssetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Papar senarai aset dengan fungsi carian dan filter.
     */
    public function index(Request $request)
    {
        // Query asas senarai aset
        $query = Asset::orderBy('created_at', 'desc');

        // Kiraan usia aset
        $assets = $query->get()->map(function ($asset) {
            $asset->usia_aset = $asset->tahun_perolehan
                ? Carbon::now()->year - $asset->tahun_perolehan
                : '-';
            return $asset;
    });

        // Carian umum
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('no_siri', 'like', "%{$request->q}%")
                ->orWhere('jenama', 'like', "%{$request->q}%")
                ->orWhere('model', 'like', "%{$request->q}%")
                ->orWhere('nama_pengguna', 'like', "%{$request->q}%");
            });
        }

        // Filter bahagian
        if ($request->filled('bahagian')) {

            $bahagianModel = Bahagian::find($request->bahagian);

            if ($bahagianModel) {
                $bahagianNama = preg_replace('/\s+/', ' ', trim($bahagianModel->nama));

                $query->whereRaw(
                    "REPLACE(REPLACE(TRIM(bahagian), '\n', ' '), '  ', ' ') = ?",
                    [$bahagianNama]
                );
            }
        }

        // Filter unit
        if ($request->filled('unit')) {

            $unitModel = Unit::find($request->unit);

            if ($unitModel) {
                $unitNama = preg_replace('/\s+/', ' ', trim($unitModel->nama));

                $query->whereRaw(
                    "REPLACE(REPLACE(TRIM(unit), '\n', ' '), '  ', ' ') = ?",
                    [$unitNama]
                );
            }
        }



        // Filter kategori 
        if ($request->filled('kategori') && !$request->filled('bahagian')) {
            $kategori = preg_replace('/\s+/', ' ', trim($request->kategori));

            $query->whereRaw(
                "REPLACE(REPLACE(TRIM(kategori), '\n', ' '), '  ', ' ') = ?",
                [$kategori]
            );
        }

        // Filter tarikh perolehan
        if ($request->filled('tarikh_dari')) {
            $query->whereDate('tarikh_perolehan', '>=', $request->tarikh_dari);
        }

        if ($request->filled('tarikh_hingga')) {
            $query->whereDate('tarikh_perolehan', '<=', $request->tarikh_hingga);
        }

        // Filter berdasarkan usia aset
        $usia = (int) $request->get('usia');
        $tahunSemasa = now()->year;

        if ($usia) {
            switch ($usia) {
                case 5:
                    $query->whereBetween(
                        DB::raw("YEAR(tarikh_perolehan)"),
                        [$tahunSemasa - 7, $tahunSemasa - 6]
                    );
                    break;

                case 7:
                    $query->whereYear('tarikh_perolehan', $tahunSemasa - 8);
                    break;

                case 8:
                    $query->whereYear('tarikh_perolehan', '<=', $tahunSemasa - 9);
                    break;
            }
        }

        // Data sokongan paparan
        $kategoriList = Asset::select('kategori')
            ->whereNotNull('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        $labelKategori = match ($usia) {
            5 => 'Akan Usang (6–7 Tahun)',
            7 => 'Wajar Dinilai Pelupusan (8 Tahun)',
            8 => 'Disyorkan Ganti Tahun Ini (≥ 9 Tahun)',
            default => null,
        };

        $labelLaporan = match ($usia) {
            5 => 'Cetak Aset Usang',
            7 => 'Cetak Aset Cadang Lupus',
            8 => 'Cetak Aset Disyorkan Ganti',
            default => 'Cetak Senarai Aset ICT',
        };

        $bahagians = Bahagian::orderBy('nama')->get();

        $units = collect();
        if ($request->filled('bahagian')) {
            $units = Unit::where('bahagian_id', $request->bahagian)
                ->orderBy('nama')
                ->get();
        }

        $assets = $query->paginate(20)->withQueryString();

        return view('assets.index', compact(
            'assets',
            'usia',
            'labelKategori',
            'labelLaporan',
            'bahagians',
            'units',
            'kategoriList',
        ));
    }

    /**
     * Papar borang tambah aset
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('assets.create', compact('users'));
    }

    /**
     * Simpan rekod aset baharu
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
            'tarikh_penempatan'  => 'nullable|date',
            'tarikh_pelupusan'   => 'nullable|date',
            'rujukan_pelupusan'  => 'nullable|string',
            'catatan'            => 'nullable|string',
            'user_id'            => 'required|exists:users,id',
        ]);

        // Tetapkan pengguna aset
        $user = User::findOrFail($request->user_id);
        $validated['user_id'] = $user->id;
        $validated['nama_pengguna'] = $user->name;
        $validated['status'] = 'Aktif';
        $validated['tarikh_penempatan'] = $validated['tarikh_penempatan'] ?? now();

        $asset = Asset::create($validated);

        // Rekod pergerakan dan log aktiviti
        $this->logMovement($asset, $validated, []);
        logActivity('Tambah Aset', $asset->id);

        return redirect()->route('ict.assets.index')
            ->with('success', 'Aset berjaya ditambah!');
    }
    /**
     * Kemas kini maklumat aset.
     */
    public function update(Request $request, Asset $asset)
    {
        // Validasi dan kemas kini aset
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
            'tarikh_penempatan' => 'nullable|date',
            'tarikh_pelupusan'  => 'nullable|date',
            'rujukan_pelupusan' => 'nullable|string',
            'catatan'           => 'nullable|string',
            'user_id'           => 'nullable|exists:users,id',
        ]);

        $original = $asset->getOriginal();

        if (!empty($validated['user_id']) && $validated['user_id'] != $asset->user_id) {
            $user = User::findOrFail($validated['user_id']);
            $validated['user_id'] = $user->id;
            $validated['nama_pengguna'] = $user->name;
            $validated['status'] = 'Aktif';
        } else {
            unset($validated['user_id'], $validated['nama_pengguna']);
        }

        $asset->update($validated);

        logActivity('Kemaskini Aset', $asset->id);
        $this->logMovement($asset, $validated, $original);

        return redirect()->route('ict.assets.index')
            ->with('success', 'Aset berjaya dikemaskini!');
    }
        /**
         * LOG PERGERAKAN ASET
         */
        private function logMovement(Asset $asset, array $validated, array $original)
        {
            if (($original['status'] ?? null) !== ($asset->status ?? null)
                && $asset->status === 'Rosak') {

                $asset->movements()->create([
                    'bahagian'      => $asset->bahagian,
                    'unit'          => $asset->unit,
                    'nama_pengguna' => $asset->nama_pengguna,
                    'tarikh_mula'   => $validated['tarikh_penempatan']
                                    ?? $asset->tarikh_penempatan
                                    ?? now(),
                    'catatan'       => 'Aset ditanda sebagai ROSAK',
                ]);
                return;
            }

            $fields = ['bahagian', 'unit', 'nama_pengguna'];
            $changed = false;

            foreach ($fields as $field) {
                if (($original[$field] ?? null) !== ($validated[$field] ?? null)) {
                    $changed = true;
                    break;
                }
            }

            if ($changed) {
                $last = $asset->movements()->whereNull('tarikh_tamat')->first();
                if ($last) {
                    $last->update(['tarikh_tamat' => now()]);
                }

                $asset->movements()->create([
                    'bahagian'      => $validated['bahagian'] ?? null,
                    'unit'          => $validated['unit'] ?? null,
                    'nama_pengguna' => $validated['nama_pengguna'] ?? null,
                    'tarikh_mula'   => $validated['tarikh_penempatan']
                                    ?? $asset->tarikh_penempatan
                                    ?? now(),
                    'catatan'       => 'Perubahan penempatan aset',
                ]);
            }
        }

        /**
         * Papar borang kemas kini aset
         */
                public function edit(Asset $asset)
            {
                $users = User::orderBy('name')->get();
                return view('assets.edit', compact('asset', 'users'));
            }

    /**
     * Papar maklumat aset & sejarah penempatan
     */
    public function show(Asset $asset)
    {
        $asset->load('movements');
        return view('assets.show', compact('asset'));
    }


    /**
     * PADAM RECORD ASET
     */
    public function destroy(Asset $asset)
    {
        $asset->delete();

            return redirect()->route('ict.assets.index')
                ->with('success', 'Aset berjaya dipadam.');
    }     
}
