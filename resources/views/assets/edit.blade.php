<x-app-layout>
    <div class="px-6 py-6">

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                Kemaskini Aset ICT
            </h1>

            <a href="{{ route('ict.assets.index') }}"
               class="px-4 py-2 text-sm rounded-lg border border-gray-300 bg-white hover:bg-gray-50">
                ← Kembali
            </a>
        </div>

        {{-- Papar ralat validasi --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc ms-6 text-sm">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Borang kemaskini aset --}}
        <form id="formEditAset" action="{{ route('ict.assets.update', $asset->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Maklumat aset --}}
            <div class="bg-white p-6 rounded-xl shadow mb-8">
                <h2 class="font-bold text-lg mb-4">Maklumat Aset ICT</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- MNo Siri Aset --}}
                    <div class="md:col-span-2">
                        <label class="font-semibold text-sm">No Siri Aset (Tidak Wajib)</label>
                        <input type="text" name="no_siri_aset"
                            class="mt-1 w-full border rounded px-3 py-2"
                            value="{{ old('no_siri_aset', $asset->no_siri_aset) }}">
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label class="font-semibold text-sm">Kategori *</label>
                        <select name="kategori" required class="mt-1 w-full border rounded px-3 py-2">
                            <option value="">-- Pilih --</option>
                            @php
                                $kategoriList = [
                                    'Komputer Desktop','Komputer Riba / Laptop','Monitor','Printer','Scanner',
                                    'Tablet','Telefon IP','UPS','Switch','Router','Server','External Storage',
                                    'Projector','CCTV Camera','Access Point / WiFi','Fax Machine','Smart TV'
                                ];
                            @endphp

                            @foreach ($kategoriList as $k)
                                <option value="{{ $k }}" {{ $asset->kategori == $k ? 'selected' : '' }}>{{ $k }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- No Siri --}}
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
                        @php
                            $jenamaList = [
                                'HP','Dell','Lenovo','Acer','Asus','Apple','Microsoft Surface',
                                'Brother','Canon','Epson','FujiFilm',
                                'Cisco','TP-Link','D-Link','Mikrotik','Aruba',
                                'APC','Eaton','Hikvision','Dahua'
                            ];
                        @endphp

                        <select name="jenama" required class="mt-1 w-full border rounded px-3 py-2">
                            <option value="">-- Pilih --</option>
                            @foreach ($jenamaList as $j)
                                <option value="{{ $j }}" {{ $asset->jenama == $j ? 'selected' : '' }}>{{ $j }}</option>
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

            {{-- Maklumat perolehan --}}
            <div class="bg-white p-6 rounded-xl shadow mb-8">
                <h2 class="font-bold text-lg mb-4">Maklumat Perolehan</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Tarikh Perolehan --}}
                    <div>
                    <label class="font-semibold text-sm">Tarikh Perolehan</label>
                    <input type="date"
                        class="mt-1 w-full border rounded px-3 py-2 bg-gray-100 cursor-not-allowed"
                        value="{{ optional($asset->tarikh_perolehan)->format('Y-m-d') }}"
                        readonly>
                        </div>

                    {{-- Usia Aset (Auto) --}}
                    <div>
                        <label class="font-semibold text-sm">Usia Aset (Auto)</label>
                        <input type="text"
                            class="mt-1 w-full border rounded px-3 py-2 bg-gray-100 cursor-not-allowed"
                            value="{{ old('usia_aset') }}"
                            readonly>
                    </div>

                    {{-- Harga --}}
                    <div>
                        <label class="font-semibold text-sm">Harga Perolehan (RM)</label>
                        <input type="number" name="harga" step="0.01"
                            class="mt-1 w-full border rounded px-3 py-2"
                            value="{{ old('harga', $asset->harga) }}">
                    </div>

                    {{-- Sumber Perolehan --}}
                    <div>
                        <label class="font-semibold text-sm">Sumber Perolehan *</label>
                        @php
                            $sumberList = [
                                'Pejabat SUK Selangor','Pejabat Tanah Galian Selangor',
                                'Perolehan Jabatan','Jabatan Ketua Pengarah Tanah dan Galian Persekutuan',
                                'Sumbangan'
                            ];
                        @endphp
                        <select name="sumber_perolehan" required class="mt-1 w-full border rounded px-3 py-2">
                            <option value="">-- Pilih --</option>
                            @foreach ($sumberList as $s)
                                <option value="{{ $s }}" {{ $asset->sumber_perolehan == $s ? 'selected' : '' }}>
                                    {{ $s }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Pembekal --}}
                    <div>
                        <label class="font-semibold text-sm">Pembekal</label>
                        @php
                            $pembekalList = [
                                "GLOBAL ELITE","S.I.PROTECT","KONSORTIUM JAYA SDN BHD","BSO TECHNOLOGIES",
                                "TELITI COMPUTERS SDN. BHD.","SINAR RKK","MAGECOM SOLUTION",
                                "HAYNIK","SUNDATA","JRC PRO TECHNOLOGY",
                                "KINRARA APLIKASI SDN BHD","MHS RESOURCES SDN BHD",
                                "TRI SYSTEM TECHNOLOGY"
                            ];
                        @endphp
                        <select name="pembekal" class="mt-1 w-full border rounded px-3 py-2">
                            <option value="">-- Tiada --</option>
                            @foreach ($pembekalList as $p)
                                <option value="{{ $p }}" {{ $asset->pembekal == $p ? 'selected' : '' }}>
                                    {{ $p }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>

            {{-- Maklumat penempatan --}}
            <div class="bg-white p-6 rounded-xl shadow mb-8">
                <h2 class="font-bold text-lg mb-4">Maklumat Penempatan</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Bahagian --}}
                    <div>
                        <label class="font-semibold text-sm">Lokasi / Bahagian</label>
                        <select name="bahagian" id="bahagian"
                            class="mt-1 w-full border rounded px-3 py-2">

                            <option value="">-- Pilih --</option>

                            @php
                                $bahagianList = [
                                    "Pejabat Pegawai Daerah","Unit Perundangan","Unit Integriti dan Perlesenan",
                                    "Bahagian Khidmat Pengurusan","Bahagian Pengurusan Tanah","Bahagian Pembangunan",
                                    "Stor ICT","Stor Dewan","Stor LG","Stor Bilik DDOC",
                                    "Bilik DDOC","Bilik Gerakan","Auditorium"
                                ];
                            @endphp

                            @foreach ($bahagianList as $b)
                                <option value="{{ $b }}" {{ $asset->bahagian == $b ? 'selected' : '' }}>{{ $b }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Unit --}}
                    <div>
                        <label class="font-semibold text-sm">Unit</label>
                        <select name="unit" id="unit"
                            class="mt-1 w-full border rounded px-3 py-2">
                            <option value="">-- Pilih Unit --</option>
                            @if ($asset->unit)
                                <option value="{{ $asset->unit }}" selected>{{ $asset->unit }}</option>
                            @endif
                        </select>
                    </div>

                    {{-- Nama Pengguna --}}
                    <div>
                        <label class="font-semibold text-sm">Nama Pengguna</label>

                        <select name="user_id"
                                class="mt-1 w-full border rounded px-3 py-2 form-control"
                                required>
                            <option value="">-- Pilih Pengguna --</option>

                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('user_id', $asset->user_id ?? '') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                   {{-- Tarikh Penempatan --}}
                    <div>
                        <label class="font-semibold text-sm">Tarikh Penempatan *</label>
                        <input type="date"
                            name="tarikh_penempatan"
                            class="mt-1 w-full border rounded px-3 py-2"
                            value="{{ old('tarikh_penempatan', optional($asset->tarikh_penempatan)->format('Y-m-d')) }}">
                    </div>

            </div>

            {{-- Catatan --}}
            <div class="bg-white p-6 rounded-xl shadow mb-8">
                <h2 class="font-bold text-lg mb-4">Catatan</h2>

                <textarea name="catatan" rows="3"
                    class="w-full border rounded px-3 py-2">{{ old('catatan', $asset->catatan) }}</textarea>
            </div>

            {{-- Simpan perubahan --}}
            <div class="flex justify-end gap-4 mt-6">

                 <button type="submit"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                    Kemaskini
                </button>
                <input type="hidden" name="status" value="{{ $asset->status }}">
            </div>

        </form>
    </div>

{{-- Skrip automasi --}}
<script>
    // Kira usia aset automatik
    const tarikhInput = document.getElementById('tarikh_perolehan');
    const usiaField   = document.getElementById('usia_aset');

    if (tarikhInput && usiaField) {
        tarikhInput.addEventListener('change', function () {
            let parts = this.value.split("-");
            if (parts.length !== 3) return;

            const mula  = new Date(parts[2], parts[1] - 1, parts[0]);
            const today = new Date();

            let tahun = today.getFullYear() - mula.getFullYear();
            let bulan = today.getMonth() - mula.getMonth();
            let hari  = today.getDate() - mula.getDate();

            if (hari < 0) {
                bulan--;
                hari += new Date(today.getFullYear(), today.getMonth(), 0).getDate();
            }
            if (bulan < 0) {
                tahun--;
                bulan += 12;
            }

            usiaField.value = `${tahun} tahun ${bulan} bulan ${hari} hari`;
        });
    }

    // Papar unit ikut bahagian
    const unitList = {
        "Bahagian Khidmat Pengurusan": [
            "Unit Pentadbiran Am",
            "Unit ICT",
            "Unit Sumber Manusia",
            "Unit Kewangan",
            "Unit Aset & Stor",
            "Unit Bencana",
            "Unit Majlis dan Keraian"
        ],
        "Bahagian Pengurusan Tanah": [
            "Unit Pelupusan Tanah",
            "Unit Pembangunan Tanah",
            "Unit Hasil",
            "Unit Teknikal & Penguatkuasaan",
            "Unit Pendaftaran",
            "Unit Pindahmilik & Lelong"
        ],
        "Bahagian Pembangunan": [
            "Unit Pembangunan Masyarakat",
            "Unit Pembangunan Fizikal"
        ]
    };

    const bahagianDropdown = document.getElementById('bahagian');
    const unitDropdown     = document.getElementById('unit');

    if (bahagianDropdown && unitDropdown) {

        bahagianDropdown.addEventListener('change', function () {
            const selectedBahagian = this.value;

            // Reset unit setiap kali bahagian ditukar
            unitDropdown.innerHTML = '<option value="">-- Pilih Unit --</option>';
            unitDropdown.disabled = true;

            // Jika bahagian ada unit → populate
            if (unitList.hasOwnProperty(selectedBahagian)) {
                unitList[selectedBahagian].forEach(unit => {
                    const option = document.createElement('option');
                    option.value = unit;
                    option.textContent = unit;
                    unitDropdown.appendChild(option);
                });

                unitDropdown.disabled = false;
            }
        });

    }
    document.addEventListener('DOMContentLoaded', populateUnit);
</script>

</x-app-layout>
