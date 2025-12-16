<x-app-layout>
    <div class="px-6 py-6">

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                Tambah Aset ICT
            </h1>

            <a href="{{ route('ict.assets.index') }}"
               class="px-4 py-2 text-sm rounded-lg border border-gray-300 bg-white hover:bg-gray-50">
                ← Kembali
            </a>
        </div>
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

        <form id="formCreateAset" action="{{ route('ict.assets.store') }}" method="POST">
            @csrf

            {{-- ================================================================= --}}
            {{--                        MAKLUMAT ASET ICT                        --}}
            {{-- ================================================================= --}}
            <div class="bg-white p-6 rounded-xl shadow mb-8">
                <h2 class="font-bold text-lg mb-4">Maklumat Aset ICT</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- No Siri Aset (Tidak Wajib) --}}
                    <div class="md:col-span-2">
                        <label class="font-semibold text-sm">No Siri Aset (Tidak Wajib)</label>
                        <input type="text" name="no_siri_aset"
                            class="mt-1 w-full border rounded px-3 py-2"
                            value="{{ old('no_siri_aset') }}">
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label class="font-semibold text-sm">Kategori *</label>
                        <select name="kategori" required class="mt-1 w-full border rounded px-3 py-2">
                            <option value="">-- Pilih --</option>
                            <option>Komputer Desktop</option>
                            <option>Komputer Riba / Laptop</option>
                            <option>Monitor</option>
                            <option>Printer</option>
                            <option>Scanner</option>
                            <option>Tablet</option>
                            <option>Telefon IP</option>
                            <option>UPS</option>
                            <option>Switch</option>
                            <option>Router</option>
                            <option>Server</option>
                            <option>External Storage</option>
                            <option>Projector</option>
                            <option>CCTV Camera</option>
                            <option>Access Point / WiFi</option>
                            <option>Fax Machine</option>
                            <option>Smart TV</option>
                        </select>
                    </div>

                    {{-- No Siri --}}
                    <div>
                        <label class="font-semibold text-sm">No Siri *</label>
                        <input type="text" name="no_siri" required
                            class="mt-1 w-full border rounded px-3 py-2"
                            value="{{ old('no_siri') }}">
                    </div>

                    {{-- Sub Kategori --}}
                    <div>
                        <label class="font-semibold text-sm">Sub Kategori</label>
                        <input type="text" name="sub_kategori"
                            class="mt-1 w-full border rounded px-3 py-2"
                            value="{{ old('sub_kategori') }}">
                    </div>

                    {{-- No Siri Sub --}}
                    <div>
                        <label class="font-semibold text-sm">No Siri Sub</label>
                        <input type="text" name="no_siri_sub"
                            class="mt-1 w-full border rounded px-3 py-2"
                            value="{{ old('no_siri_sub') }}">
                    </div>

                    {{-- Jenama --}}
                    <div>
                        <label class="font-semibold text-sm">Jenama *</label>
                        <select name="jenama" required class="mt-1 w-full border rounded px-3 py-2">
                            <option value="">-- Pilih --</option>

                            {{-- Laptop / Desktop --}}
                            <option>HP</option>
                            <option>Dell</option>
                            <option>Lenovo</option>
                            <option>Acer</option>
                            <option>Asus</option>
                            <option>Apple</option>
                            <option>Microsoft Surface</option>

                            {{-- Printer --}}
                            <option>Brother</option>
                            <option>Canon</option>
                            <option>Epson</option>
                            <option>FujiFilm</option>

                            {{-- Network --}}
                            <option>Cisco</option>
                            <option>TP-Link</option>
                            <option>D-Link</option>
                            <option>Mikrotik</option>
                            <option>Aruba</option>

                            {{-- UPS --}}
                            <option>APC</option>
                            <option>Eaton</option>

                            {{-- CCTV --}}
                            <option>Hikvision</option>
                            <option>Dahua</option>
                        </select>
                    </div>

                    {{-- Model --}}
                    <div>
                        <label class="font-semibold text-sm">Model</label>
                        <input type="text" name="model"
                            class="mt-1 w-full border rounded px-3 py-2"
                            value="{{ old('model') }}">
                    </div>

                </div>
            </div>

            {{-- ================================================================= --}}
            {{--                        MAKLUMAT PEROLEHAN                        --}}
            {{-- ================================================================= --}}
            <div class="bg-white p-6 rounded-xl shadow mb-8">
                <h2 class="font-bold text-lg mb-4">Maklumat Perolehan</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- TARIKH PEROLEHAN: FULL DATE --}}
                    <div>
                        <label class="font-semibold text-sm">Tarikh Perolehan *</label>
                        <input type="date" id="tarikh_perolehan" name="tarikh_perolehan" required
                            class="mt-1 w-full border rounded px-3 py-2"
                            value="{{ old('tarikh_perolehan') }}">
                    </div>

                    {{-- USIA ASET AUTO --}}
                    <div>
                        <label class="font-semibold text-sm">Usia Aset (Auto)</label>
                        <input type="text" id="usia_aset" readonly
                            class="mt-1 w-full bg-gray-100 border rounded px-3 py-2">
                    </div>

                    {{-- Harga --}}
                    <div>
                        <label class="font-semibold text-sm">Harga Perolehan (RM)</label>
                        <input type="number" name="harga" step="0.01"
                            class="mt-1 w-full border rounded px-3 py-2"
                            value="{{ old('harga') }}">
                    </div>

                    {{-- Sumber Perolehan --}}
                    <div>
                        <label class="font-semibold text-sm">Sumber Perolehan *</label>
                        <select name="sumber_perolehan" required class="mt-1 w-full border rounded px-3 py-2">
                            <option value="">-- Pilih --</option>
                            <option>Pejabat SUK Selangor</option>
                            <option>Pejabat Tanah Galian Selangor</option>
                            <option>Perolehan Jabatan</option>
                            <option>Jabatan Ketua Pengarah Tanah dan Galian Persekutuan</option>
                            <option>Sumbangan</option>
                        </select>
                    </div>

                    {{-- Pembekal --}}
                    <div>
                        <label class="font-semibold text-sm">Pembekal</label>
                        <select name="pembekal" class="mt-1 w-full border rounded px-3 py-2">
                            <option value="">-- Tiada --</option>
                            <option>GLOBAL ELITE</option>
                            <option>S.I.PROTECT</option>
                            <option>KONSORTIUM JAYA SDN BHD</option>
                            <option>BSO TECHNOLOGIES</option>
                            <option>TELITI COMPUTERS SDN. BHD.</option>
                            <option>SINAR RKK</option>
                            <option>MAGECOM SOLUTION</option>
                            <option>HAYNIK</option>
                            <option>SUNDATA</option>
                            <option>JRC PRO TECHNOLOGY</option>
                            <option>KINRARA APLIKASI SDN BHD</option>
                            <option>MHS RESOURCES SDN BHD</option>
                            <option>TRI SYSTEM TECHNOLOGY</option>         
                        </select>
                    </div>

                </div>
            </div>

            {{-- ================================================================= --}}
            {{--                       MAKLUMAT PENEMPATAN                       --}}
            {{-- ================================================================= --}}
            <div class="bg-white p-6 rounded-xl shadow mb-8">
                <h2 class="font-bold text-lg mb-4">Maklumat Penempatan</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Bahagian --}}
                    <div>
                        <label class="font-semibold text-sm">Lokasi / Bahagian</label>
                        <select name="bahagian" id="bahagian"
                            class="mt-1 w-full border rounded px-3 py-2">

                            <option value="">-- Pilih --</option>
                            <option>Pejabat Pegawai Daerah</option>
                            <option>Unit Perundangan</option>
                            <option>Unit Integriti dan Perlesenan</option>

                            <option>Bahagian Khidmat Pengurusan</option>
                            <option>Bahagian Pengurusan Tanah</option>
                            <option>Bahagian Pembangunan</option>

                            <option>Stor ICT</option>
                            <option>Stor Dewan</option>
                            <option>Stor LG</option>
                            <option>Stor Bilik DDOC</option>
                            <option>Bilik DDOC</option>
                            <option>Bilik Gerakan</option>
                            <option>Auditorium</option>
                        </select>
                    </div>

                    {{-- Unit --}}
                    <div>
                        <label class="font-semibold text-sm">Unit</label>
                        <select name="unit" id="unit"
                            class="mt-1 w-full border rounded px-3 py-2" disabled>
                            <option value="">-- Pilih Unit --</option>
                        </select>
                    </div>

                    {{-- Nama Pengguna --}}
                    <div>
                        <label class="font-semibold text-sm">Nama Pengguna</label>
                        <input type="text" name="nama_pengguna"
                            class="mt-1 w-full border rounded px-3 py-2"
                            value="{{ old('nama_pengguna') }}">
                    </div>

                    {{-- Tarikh Penempatan --}}
                    <div>
                        <label class="font-semibold text-sm">Tarikh Penempatan *</label>
                        <input type="date" id="tarikh_penempatan" name="tarikh_penempatan" required
                            class="mt-1 w-full border rounded px-3 py-2"
                            value="{{ old('tarikh_penempatan') }}">
                    </div>
                </div>
            </div>
                    </div>
            {{-- ================================================================= --}}
            {{--                            CATATAN                               --}}
            {{-- ================================================================= --}}
            <div class="bg-white p-6 rounded-xl shadow mb-8">
                <h2 class="font-bold text-lg mb-4">Catatan</h2>

                <textarea name="catatan" rows="3"
                    class="w-full border rounded px-3 py-2">{{ old('catatan') }}</textarea>
            </div>

            {{-- BUTTON --}}
            <div class="flex justify-end gap-4 mt-6">
                <button type="button" onclick="document.getElementById('formCreateAset').reset();"
                    class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-black rounded">
                    Clear
                </button>

                <button type="submit"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                    Simpan
                </button>
            </div>

        </form>
    </div>

    {{-- SCRIPT: AUTO UNIT + AUTO USIA FULL --}}
    <script>
        // AUTO KIRA USIA MENGIKUT TARIKH PENUH
        const tarikhInput = document.getElementById('tarikh_perolehan');
        const usiaField = document.getElementById('usia_aset');

        tarikhInput.addEventListener('change', function () {
            if (!this.value) {
                usiaField.value = "";
                return;
            }

            const mula = new Date(this.value);
            const hariIni = new Date();

            let tahun = hariIni.getFullYear() - mula.getFullYear();
            let bulan = hariIni.getMonth() - mula.getMonth();
            let hari = hariIni.getDate() - mula.getDate();

            if (hari < 0) {
                bulan -= 1;
                hari += new Date(hariIni.getFullYear(), hariIni.getMonth(), 0).getDate();
            }

            if (bulan < 0) {
                tahun -= 1;
                bulan += 12;
            }

            usiaField.value = `${tahun} tahun ${bulan} bulan ${hari} hari`;
        });

        // AUTO UNIT DROPDOWN
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
        const unitDropdown = document.getElementById('unit');

        bahagianDropdown.addEventListener('change', function () {
            const selected = this.value;

            unitDropdown.innerHTML = '<option value="">-- Pilih Unit --</option>';
            unitDropdown.disabled = true;

            if (unitList[selected]) {
                unitDropdown.disabled = false;
                unitList[selected].forEach(u => {
                    unitDropdown.innerHTML += `<option value="${u}">${u}</option>`;
                });
            }
        });
    </script>

</x-app-layout>
