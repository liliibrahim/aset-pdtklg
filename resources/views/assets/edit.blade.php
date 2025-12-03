<x-app-layout>
    <div class="px-6 py-6">

        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            Kemaskini Aset ICT
        </h1>

        {{-- PAPAR ERROR --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc ms-6 text-sm">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- BORANG EDIT --}}
        <form id="formEditAset" action="{{ route('ict.assets.update', $asset->id) }}" method="POST">
            @csrf
            @method('PUT')


            {{-- =============================================== --}}
{{--                MAKLUMAT ASET ICT                --}}
{{-- =============================================== --}}
<div class="bg-white p-6 rounded-xl shadow mb-8">
    <h2 class="font-bold text-lg mb-4">Maklumat Aset ICT</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- No Siri Aset --}}
        <div>
            <label class="font-semibold text-sm">No Siri Aset</label>
            <input type="text" name="no_siri_aset"
                   class="mt-1 w-full border rounded px-3 py-2"
                   value="{{ old('no_siri_aset', $asset->no_siri_aset) }}">
        </div>

        {{-- Kategori --}}
        <div>
            <label class="font-semibold text-sm">Kategori *</label>
            <select name="kategori" required class="mt-1 w-full border rounded px-3 py-2">
                <option value="">-- Pilih --</option>

                @foreach([
                    'Komputer Desktop','Komputer Riba / Laptop','Monitor','Printer','Scanner',
                    'Tablet','Telefon IP','UPS','Switch','Router','Server','External Storage',
                    'Projector','CCTV Camera','Access Point / WiFi','Fax Machine','Smart TV'
                ] as $k)
                    <option value="{{ $k }}"
                        {{ old('kategori', $asset->kategori) == $k ? 'selected' : '' }}>
                        {{ $k }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- No Siri (Kategori) --}}
        <div>
            <label class="font-semibold text-sm">No Siri *</label>
            <input type="text" name="no_siri" required
                   class="mt-1 w-full border rounded px-3 py-2"
                   value="{{ old('no_siri', $asset->no_siri) }}">
        </div>

        {{-- Sub Kategori --}}
        <div>
            <label class="font-semibold text-sm">Sub Kategori</label>
            <input type="text" name="sub_kategori"
                   class="mt-1 w-full border rounded px-3 py-2"
                   value="{{ old('sub_kategori', $asset->sub_kategori) }}">
        </div>

        {{-- No Siri Sub --}}
        <div>
            <label class="font-semibold text-sm">No Siri Sub</label>
            <input type="text" name="no_siri_sub"
                   class="mt-1 w-full border rounded px-3 py-2"
                   value="{{ old('no_siri_sub', $asset->no_siri_sub) }}">
        </div>

        {{-- Jenama --}}
        <div>
            <label class="font-semibold text-sm">Jenama *</label>
            <select name="jenama" required class="mt-1 w-full border rounded px-3 py-2">
                @foreach([
                    'HP','Dell','Lenovo','Acer','Asus','Apple','Microsoft Surface',
                    'Brother','Canon','Epson','FujiFilm','Cisco','TP-Link','D-Link',
                    'Mikrotik','Aruba','APC','Eaton','Hikvision','Dahua'
                ] as $j)
                    <option value="{{ $j }}"
                        {{ old('jenama', $asset->jenama) == $j ? 'selected' : '' }}>
                        {{ $j }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Model --}}
        <div>
            <label class="font-semibold text-sm">Model</label>
            <input type="text" name="model"
                   class="mt-1 w-full border rounded px-3 py-2"
                   value="{{ old('model', $asset->model) }}">
        </div>

    </div>
</div>

            {{-- ===================================================== --}}
            {{--                      MAKLUMAT PEROLEHAN               --}}
            {{-- ===================================================== --}}
            <div class="bg-white p-6 rounded-xl shadow mb-8">
                <h2 class="font-bold text-lg mb-4">Maklumat Perolehan</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Tarikh Perolehan --}}
                    <div>
                        <label class="font-semibold text-sm">Tarikh Perolehan *</label>
                        <input type="date"
                               name="tarikh_perolehan"
                               class="form-input w-full"
                               value="{{ old('tarikh_perolehan', optional($asset->tarikh_perolehan)->format('Y-m-d')) }}">
                    </div>

                    {{-- Usia Aset --}}
                    <div>
                        <label class="font-semibold text-sm">Usia Aset</label>
                        <input type="text"
                               id="usia_aset"
                               class="form-input w-full bg-gray-100"
                               readonly
                               value="{{ old('usia_aset', $asset->tarikh_perolehan ? \Carbon\Carbon::parse($asset->tarikh_perolehan)->age . ' tahun' : '') }}">
                    </div>

                    {{-- Harga --}}
                    <div>
                        <label class="font-semibold text-sm">Harga (RM)</label>
                        <input type="number"
                               name="harga"
                               step="0.01"
                               class="mt-1 w-full border rounded px-3 py-2"
                               value="{{ old('harga', $asset->harga) }}">
                    </div>

                    {{-- Sumber Perolehan --}}
                    <div>
                        <label class="font-semibold text-sm">Sumber Perolehan *</label>
                        <select name="sumber_perolehan"
                                class="mt-1 w-full border rounded px-3 py-2">
                            @foreach([
                                'Pejabat SUK Selangor','Pejabat Tanah Galian Selangor','Perolehan Jabatan',
                                'Jabatan Ketua Pengarah Tanah dan Galian Persekutuan','Sumbangan'
                            ] as $s)
                                <option value="{{ $s }}"
                                    {{ old('sumber_perolehan', $asset->sumber_perolehan) == $s ? 'selected' : '' }}>
                                    {{ $s }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>


            {{-- ===================================================== --}}
            {{--                 MAKLUMAT PENEMPATAN                --}}
            {{-- ===================================================== --}}
            <div class="bg-white p-6 rounded-xl shadow mb-8">
                <h2 class="font-bold text-lg mb-4">Maklumat Penempatan</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Bahagian --}}
                    <div>
                        <label class="font-semibold text-sm">Lokasi / Bahagian</label>
                        <select name="bahagian" id="bahagian"
                                class="mt-1 w-full border rounded px-3 py-2">
                            <option value="">-- Pilih --</option>

                            @foreach([
                                'Bahagian Khidmat Pengurusan',
                                'Bahagian Pengurusan Tanah',
                                'Bahagian Pembangunan',
                                'Stor ICT','Stor Dewan','Stor LG','Stor Bilik DDOC',
                                'Bilik DDOC','Bilik Gerakan','Auditorium'
                            ] as $b)
                                <option value="{{ $b }}"
                                    {{ old('bahagian', $asset->bahagian) == $b ? 'selected' : '' }}>
                                    {{ $b }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Unit --}}
                    <div>
                        <label class="font-semibold text-sm">Unit</label>
                        <select name="unit" id="unit"
                                class="mt-1 w-full border rounded px-3 py-2">
                            <option value="">-- Pilih Unit --</option>
                        </select>
                    </div>

                    {{-- Nama Pengguna --}}
                    <div>
                        <label class="font-semibold text-sm">Nama Pengguna</label>
                        <input type="text"
                               name="nama_pengguna"
                               class="mt-1 w-full border rounded px-3 py-2"
                               value="{{ old('nama_pengguna', $asset->nama_pengguna) }}">
                    </div>

                   
{{-- Tarikh penempatan --}}
        <div>
            <label class="font-semibold text-sm">Tarikh Penempatan *</label>
            <input type="date"
                   name="tarikh_penempatan"
                   class="form-input w-full"
                   value="{{ old('tarikh_penempatan', optional($asset->penempatan)->format('Y-m-d')) }}">
        </div>

            </div>
            </div>


            {{-- ========================= --}}
            {{--       STATUS ASET         --}}
            {{-- ========================= --}}
            <div class="bg-white p-6 rounded-xl shadow mb-8">
                <h2 class="font-bold text-lg mb-4">Status Aset</h2>
                <select name="status"
                        class="mt-1 w-full border rounded px-3 py-2" required>
                    <option value="Aktif"       {{ old('status', $asset->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Rosak"       {{ old('status', $asset->status) == 'Rosak' ? 'selected' : '' }}>Rosak</option>
                    <option value="Dilupuskan"  {{ old('status', $asset->status) == 'Dilupuskan' ? 'selected' : '' }}>Dilupuskan</option>
                </select>
            </div>

            {{-- =============================================== --}}
{{--                MAKLUMAT PELUPUSAN               --}}
{{-- =============================================== --}}
<div class="bg-white p-6 rounded-xl shadow mb-8">
    <h2 class="font-bold text-lg mb-4">Maklumat Pelupusan</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Tarikh Pelupusan --}}
        <div>
            <label class="font-semibold text-sm">Tarikh Pelupusan</label>
            <input type="date"
                   name="tarikh_pelupusan"
                   class="form-input w-full"
                   value="{{ old('tarikh_pelupusan', optional($asset->tarikh_pelupusan)->format('Y-m-d')) }}">
        </div>

        {{-- Rujukan Pelupusan --}}
        <div>
            <label class="font-semibold text-sm">Rujukan Pelupusan</label>
            <input type="text"
                   name="rujukan_pelupusan"
                   class="mt-1 w-full border rounded px-3 py-2"
                   value="{{ old('rujukan_pelupusan', $asset->rujukan_pelupusan) }}">
        </div>

    </div>
</div>

            {{-- BUTTON --}}
            <div class="flex justify-end">
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>

    

    {{-- SCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // ===============================
            // Auto select UNIT ikut bahagian
            // ===============================
            const unitList = @json($unitsByBahagian ?? []);
            const bahagianSelect = document.getElementById('bahagian');
            const unitSelect = document.getElementById('unit');

            function populateUnits(bahagian, selectedUnit = null) {
                unitSelect.innerHTML = '<option value="">-- Pilih Unit --</option>';
                if (unitList[bahagian]) {
                    unitList[bahagian].forEach(u => {
                        const opt = document.createElement('option');
                        opt.value = u;
                        opt.textContent = u;
                        if (u === selectedUnit) opt.selected = true;
                        unitSelect.appendChild(opt);
                    });
                }
            }

            const initBahagian = @json(old('bahagian', $asset->bahagian));
            const initUnit     = @json(old('unit', $asset->unit));

            if (initBahagian) {
                populateUnits(initBahagian, initUnit);
            }
        });
    </script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const tarikhInput = document.querySelector('input[name="tarikh_perolehan"]');
    const usiaInput   = document.querySelector('input[name="usia_aset"]');

    function kiraUsia() {
        if (!tarikhInput.value) {
            usiaInput.value = "";
            return;
        }

        const tarikh = new Date(tarikhInput.value);
        const today = new Date();

        let usia = today.getFullYear() - tarikh.getFullYear();

        // Jika belum sampai ulang tahun tahun ini, tolak 1
        const belumSampaiBulan =
            today.getMonth() < tarikh.getMonth() ||
            (today.getMonth() === tarikh.getMonth() && today.getDate() < tarikh.getDate());

        if (belumSampaiBulan) usia--;

        usiaInput.value = usia + " tahun";
    }

    tarikhInput.addEventListener("change", kiraUsia);

    // Auto kira bila load page edit
    kiraUsia();
});
</script>
</x-app-layout>
