<x-app-layout>
    <div class="px-6 py-6">

        <h1 class="text-2xl font-bold mb-6">Tambah Aset ICT</h1>

        @if ($errors->any())
            <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
                <strong>Ralat!</strong>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('ict.assets.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- No Siri (Aset) --}}
                <div>
                    <label class="font-medium">No Siri *</label>
                    <input name="no_siri" type="text" class="w-full form-input" required>
                </div>

                {{-- No Siri Sub --}}
                <div>
                    <label class="font-medium">No Siri Sub</label>
                    <input name="no_siri_sub" type="text" class="w-full form-input">
                </div>

                {{-- Jenama --}}
                <div>
                    <label class="font-medium">Jenama</label>
                    <input name="jenama" type="text" class="w-full form-input">
                </div>

                {{-- Model --}}
                <div>
                    <label class="font-medium">Model</label>
                    <input name="model" type="text" class="w-full form-input">
                </div>

                {{-- Kategori --}}
                <div>
                    <label class="font-medium">Kategori</label>
                    <input name="kategori" type="text" class="w-full form-input">
                </div>

                {{-- Sub Kategori --}}
                <div>
                    <label class="font-medium">Sub Kategori</label>
                    <input name="sub_kategori" type="text" class="w-full form-input">
                </div>

                {{-- Tahun Perolehan --}}
                <div>
                    <label class="font-medium">Tahun Perolehan</label>
                    <input name="tarikh_perolehan" type="number" min="1990" max="{{ date('Y') }}" class="w-full form-input">
                </div>

                {{-- Harga --}}
                <div>
                    <label class="font-medium">Harga (RM)</label>
                    <input name="harga" type="number" step="0.01" class="w-full form-input">
                </div>

                {{-- Sumber Perolehan --}}
                <div>
                    <label class="font-medium">Sumber Perolehan *</label>
                    <select name="sumber_perolehan" class="w-full form-select" required>
                        <option value="Pejabat SUK Selangor">Pejabat SUK Selangor</option>
                        <option value="Pejabat Tanah Galian">Pejabat Tanah Galian</option>
                        <option value="Unit ICT">Unit ICT</option>
                        <option value="Sumbangan">Sumbangan</option>
                    </select>
                </div>

                {{-- Pembekal (ENUM dalam DB) --}}
                <div>
                    <label class="font-medium">Pembekal</label>
                    <select name="pembekal" class="w-full form-select">
                        <option value="">-- Tiada --</option>
                        <option value="GLOBAL ELITE">GLOBAL ELITE</option>
                        <option value="S.I.PROTECT">S.I.PROTECT</option>
                        <option value="KONSORTIUM JA">KONSORTIUM JA</option>
                        {{-- Jika anda mahu dinamik, bagitahu saya --}}
                    </select>
                </div>

                {{-- Nama Pengguna --}}
                <div>
                    <label class="font-medium">Nama Pengguna</label>
                    <input name="nama_pengguna" type="text" class="w-full form-input">
                </div>

                {{-- Status --}}
                <div>
                    <label class="font-medium">Status *</label>
                    <select name="status" class="w-full form-select">
                        <option value="Aktif">Aktif</option>
                        <option value="Rosak">Rosak</option>
                        <option value="Untuk Dilupus">Untuk Dilupus</option>
                        <option value="Dilupus">Dilupus</option>
                    </select>
                </div>

                {{-- Lokasi / Bahagian --}}
                <div>
                    <label class="font-medium">Lokasi / Bahagian</label>
                    <input name="bahagian" type="text" class="w-full form-input">
                </div>

                {{-- Unit --}}
                <div>
                    <label class="font-medium">Unit</label>
                    <input name="unit" type="text" class="w-full form-input">
                </div>

                {{-- Tarikh Penempatan --}}
                <div>
                    <label class="font-medium">Tarikh Penempatan</label>
                    <input name="tarikh_penempatan" type="date" class="w-full form-input">
                </div>

                {{-- Tarikh Pelupusan --}}
                <div>
                    <label class="font-medium">Tarikh Pelupusan</label>
                    <input name="tarikh_pelupusan" type="date" class="w-full form-input">
                </div>

                {{-- Rujukan Pelupusan --}}
                <div>
                    <label class="font-medium">Rujukan Pelupusan</label>
                    <input name="rujukan_pelupusan" type="text" class="w-full form-input">
                </div>

                {{-- Catatan --}}
                <div class="md:col-span-2">
                    <label class="font-medium">Catatan</label>
                    <textarea name="catatan" class="w-full form-input"></textarea>
                </div>

            </div>

            <div class="mt-6 flex gap-3">
                <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded shadow">
                    Simpan Aset
                </button>

                <button type="button" id="clearForm" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded shadow">
                    Clear
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('clearForm').addEventListener('click', function () {
            document.querySelector('form').reset();
        });
    </script>

</x-app-layout>
