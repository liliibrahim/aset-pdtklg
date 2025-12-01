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

                <div>
                    <label class="font-medium">No Peralatan *</label>
                    <input name="no_peralatan" type="text" class="w-full form-input" required>
                </div>

                <div>
                    <label class="font-medium">No Aset Dalaman</label>
                    <input name="no_aset_dalaman" type="text" class="w-full form-input">
                </div>

                <div>
                    <label class="font-medium">Nama Aset *</label>
                    <input name="nama" type="text" class="w-full form-input" required>
                </div>

                <div>
                    <label class="font-medium">Jenama</label>
                    <input name="jenama" type="text" class="w-full form-input">
                </div>

                <div>
                    <label class="font-medium">Model</label>
                    <input name="model" type="text" class="w-full form-input">
                </div>

                <div>
                    <label class="font-medium">Kategori</label>
                    <input name="kategori" type="text" class="w-full form-input">
                </div>

                <div>
                    <label class="font-medium">Tahun Perolehan</label>
                    <input name="tahun_perolehan" type="number" min="1990" max="{{ date('Y') }}" class="w-full form-input">
                </div>

                <div>
                    <label class="font-medium">Harga (RM)</label>
                    <input name="harga" type="number" step="0.01" class="w-full form-input">
                </div>

                <div>
                    <label class="font-medium">Sumber *</label>
                    <select name="sumber" class="w-full form-select" required>
                        <option value="SUK">SUK</option>
                        <option value="PTGS">PTGS</option>
                        <option value="Perolehan Jabatan">Perolehan Jabatan</option>
                        <option value="Sumbangan">Sumbangan</option>
                    </select>
                </div>

                <div>
                    <label class="font-medium">Pembekal</label>
                    <select name="pembekal_id" class="w-full form-select">
                        <option value="">-- Tiada --</option>
                        @foreach ($suppliers as $s)
                            <option value="{{ $s->id }}">{{ $s->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="font-medium">Status *</label>
                    <select name="status" class="w-full form-select">
                        <option value="Aktif">Aktif</option>
                        <option value="Rosak">Rosak</option>
                        <option value="Untuk Dilupus">Untuk Dilupus</option>
                        <option value="Dilupus">Dilupus</option>
                    </select>
                </div>

            </div>

            <div class="mt-6">
                <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded shadow">
                    Simpan Aset
                </button>
            </div>

        </form>
    </div>
</x-app-layout>
