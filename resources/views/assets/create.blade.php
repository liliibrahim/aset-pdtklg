<x-app-layout>
    <div class="px-6 py-6">

        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            Tambah Aset ICT
        </h1>

        {{-- ERROR MESSAGE --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc ms-6 text-sm">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('ict.assets.store') }}" method="POST">
            @csrf

            {{-- ===================================================== --}}
            {{--               KUMPULAN 1: MAKLUMAT ASET               --}}
            {{-- ===================================================== --}}
            <div class="bg-white p-6 rounded-xl shadow mb-8">
                <h2 class="font-bold text-lg mb-4">Maklumat Aset ICT</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- No Peralatan --}}
                    <div>
                        <label class="font-semibold text-sm">No. Peralatan ICT *</label>
                        <input type="text" name="no_peralatan" required class="mt-1 w-full border rounded px-3 py-2"
                               value="{{ old('no_peralatan') }}">
                    </div>

                    {{-- Nama Aset --}}
                    <div>
                        <label class="font-semibold text-sm">Nama Aset *</label>
                        <input type="text" name="nama" required class="mt-1 w-full border rounded px-3 py-2"
                               value="{{ old('nama') }}">
                    </div>

                    {{-- Jenama --}}
                    <div>
                        <label class="font-semibold text-sm">Jenama</label>
                        <input type="text" name="jenama" class="mt-1 w-full border rounded px-3 py-2"
                               value="{{ old('jenama') }}">
                    </div>

                    {{-- Model --}}
                    <div>
                        <label class="font-semibold text-sm">Model</label>
                        <input type="text" name="model" class="mt-1 w-full border rounded px-3 py-2"
                               value="{{ old('model') }}">
                    </div>

                    {{-- Kategori ICT --}}
                    <div>
                        <label class="font-semibold text-sm">Kategori ICT *</label>
                        <select name="kategori" class="mt-1 w-full border rounded px-3 py-2">
                            <option value="">-- Pilih --</option>
                            <option value="Komputer Desktop">Komputer Desktop</option>
                            <option value="Komputer Riba / Laptop">Komputer Riba / Laptop</option>
                            <option value="All-In-One PC">All-In-One PC</option>
                            <option value="Monitor">Monitor</option>
                            <option value="Printer">Printer</option>
                            <option value="Scanner">Scanner</option>
                            <option value="UPS">UPS</option>
                            <option value="Router">Router</option>
                            <option value="Switch">Switch</option>
                            <option value="Projector">Projector</option>
                            <option value="Tablet">Tablet</option>
                            <option value="Telefon IP">Telefon IP</option>
                            <option value="Lain-lain">Lain-lain</option>
                        </select>
                    </div>

                    {{-- Tahun Perolehan --}}
                    <div>
                        <label class="font-semibold text-sm">Tahun Perolehan</label>
                        <input type="number" name="tahun_perolehan" class="mt-1 w-full border rounded px-3 py-2"
                               min="2000" max="{{ date('Y') }}" value="{{ old('tahun_perolehan') }}">
                    </div>

                    {{-- Harga --}}
                    <div>
                        <label class="font-semibold text-sm">Harga (RM)</label>
                        <input type="number" step="0.01" name="harga" class="mt-1 w-full border rounded px-3 py-2"
                               value="{{ old('harga') }}">
                    </div>

                </div>
            </div>


            {{-- ===================================================== --}}
            {{--           KUMPULAN 2: SUMBER & PEMBEKAL              --}}
            {{-- ===================================================== --}}
            <div class="bg-white p-6 rounded-xl shadow mb-8">
                <h2 class="font-bold text-lg mb-4">Maklumat Perolehan</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Sumber Perolehan --}}
                    <div>
                        <label class="font-semibold text-sm">Sumber Perolehan *</label>
                        <select name="sumber_perolehan" required class="mt-1 w-full border rounded px-3 py-2">
                            <option value="">-- Pilih --</option>
                            <option value="Pejabat SUK Selangor">Pejabat SUK Selangor</option>
                            <option value="Pejabat Tanah Galian Selangor">Pejabat Tanah Galian Selangor</option>
                            <option value="Perolehan Jabatan">Perolehan Jabatan</option>
                            <option value="Jabatan Ketua Pengarah Tanah dan Galian Persekutuan">
                                JKPTG Persekutuan
                            </option>
                            <option value="Sumbangan">Sumbangan</option>
                        </select>
                    </div>

                    {{-- Pembekal --}}
                    <div>
                        <label class="font-semibold text-sm">Pembekal</label>
                        <select name="pembekal" class="mt-1 w-full border rounded px-3 py-2">
                            <option value="">-- Pilih --</option>
                            <option value="GLOBAL ELITE">GLOBAL ELITE</option>
                            <option value="S.I.PROTECT">S.I.PROTECT</option>
                            <option value="KONSORTIUM JAYA SDN. BHD">KONSORTIUM JAYA SDN. BHD</option>
                            <option value="BSO TECHNOLOGIES SDN. BHD.">BSO TECHNOLOGIES SDN. BHD.</option>
                            <option value="TELITI COMPUTERS SDN. BHD.">TELITI COMPUTERS SDN. BHD.</option>
                            <option value="SINAR RKK">SINAR RKK</option>
                            <option value="MAGECOM SOLUTION">MAGECOM SOLUTION</option>
                            <option value="HAYNIK">HAYNIK</option>
                            <option value="SUNDATA">SUNDATA</option>
                        </select>
                    </div>

                </div>
            </div>


            {{-- ===================================================== --}}
            {{--         KUMPULAN 3: PENEMPATAN & LOKASI              --}}
            {{-- ===================================================== --}}
            <div class="bg-white p-6 rounded-xl shadow mb-8">
                <h2 class="font-bold text-lg mb-4">Maklumat Penempatan</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Bahagian --}}
                    <div>
                        <label class="font-semibold text-sm">Bahagian</label>
                        <select name="bahagian" class="mt-1 w-full border rounded px-3 py-2">
                            <option value="">-- Pilih --</option>
                            <option value="Pejabat Pegawai Daerah">Pejabat Pegawai Daerah</option>
                            <option value="Unit Perundangan">Unit Perundangan</option>
                            <option value="Unit Integriti dan Perlesenan">Unit Integriti & Perlesenan</option>
                            <option value="Bahagian Khidmat Pengurusan">Bahagian Khidmat Pengurusan</option>
                            <option value="Bahagian Pengurusan Tanah">Bahagian Pengurusan Tanah</option>
                            <option value="Bahagian Pembangunan">Bahagian Pembangunan</option>
                            <option value="Lain-lain">Lain-lain</option>
                        </select>
                    </div>

                    {{-- Unit --}}
                    <div>
                        <label class="font-semibold text-sm">Unit</label>
                        <select name="unit" class="mt-1 w-full border rounded px-3 py-2">
                            <option value="">-- Pilih --</option>
                            <option value="Unit Pentadbiran Am">Unit Pentadbiran Am</option>
                            <option value="Unit ICT">Unit ICT</option>
                            <option value="Unit Sumber Manusia">Unit Sumber Manusia</option>
                            <option value="Unit Kewangan">Unit Kewangan</option>
                            <option value="Unit Aset & Stor">Unit Aset & Stor</option>
                            <option value="Unit Bencana">Unit Bencana</option>
                            <option value="Unit Majlis dan Keraian">Unit Majlis & Keraian</option>
                            <option value="Unit Pelupusan Tanah">Unit Pelupusan Tanah</option>
                            <option value="Unit Pembangunan Tanah">Unit Pembangunan Tanah</option>
                            <option value="Unit Hasil">Unit Hasil</option>
                            <option value="Unit Teknikal & Penguatkuasaan">Unit Teknikal & Penguatkuasaan</option>
                            <option value="Unit Pendaftaran">Unit Pendaftaran</option>
                            <option value="Unit Pindahmilik & Lelong">Unit Pindahmilik & Lelong</option>
                            <option value="Unit Pembangunan Masyarakat">Unit Pembangunan Masyarakat</option>
                            <option value="Unit Pembangunan Fizikal">Unit Pembangunan Fizikal</option>
                        </select>
                    </div>

                    {{-- Lokasi Lain --}}
                    <div>
                        <label class="font-semibold text-sm">Lokasi Lain</label>
                        <select name="lokasi_lain" class="mt-1 w-full border rounded px-3 py-2">
                            <option value="">-- Pilih --</option>
                            <option value="Stor ICT">Stor ICT</option>
                            <option value="Stor Dewan">Stor Dewan</option>
                            <option value="Stor LG">Stor LG</option>
                            <option value="Stor Bilik DDOC">Stor Bilik DDOC</option>
                            <option value="Bilik DDOC">Bilik DDOC</option>
                            <option value="Bilik">Bilik</option>
                            <option value="Gerakan">Gerakan</option>
                            <option value="Auditorium">Auditorium</option>
                        </select>
                    </div>

                    {{-- Nama Pengguna --}}
                    <div>
                        <label class="font-semibold text-sm">Nama Pengguna</label>
                        <input type="text" name="nama_pengguna" class="mt-1 w-full border rounded px-3 py-2"
                               value="{{ old('nama_pengguna') }}">
                    </div>

                </div>
            </div>


            {{-- ===================================================== --}}
            {{--                  KUMPULAN 4: CATATAN                  --}}
            {{-- ===================================================== --}}
            <div class="bg-white p-6 rounded-xl shadow mb-8">
                <h2 class="font-bold text-lg mb-4">Catatan</h2>
                <textarea name="catatan" class="w-full border rounded px-3 py-2" rows="3">{{ old('catatan') }}</textarea>
            </div>


            {{-- BUTTON --}}
            <div class="mt-8 flex space-x-3">
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>

                <button type="reset" class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400">
                    Clear
                </button>

                <a href="{{ route('ict.assets.index') }}" class="px-4 py-2 rounded border hover:bg-gray-100">
                    Kembali
                </a>
            </div>

        </form>

    </div>
</x-app-layout>
