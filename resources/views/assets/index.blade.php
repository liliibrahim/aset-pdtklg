<x-app-layout>
<div class="px-6 py-6">

    {{-- TAJUK --}}
    <h1 class="text-2xl font-bold text-gray-800 mb-6">
        Senarai Aset ICT
    </h1>

    {{-- BUTANG ATAS --}}
    <div class="flex justify-between items-center mb-4">
        <a href="{{ route('ict.assets.create') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            + Tambah Aset
        </a>

        {{-- CETAK LAPORAN PDF (IKUT USIA ASET) --}}
        @if (!empty($usia))
            <a href="{{ route('ict.laporan.aset_usang.pdf', ['tahap' => $usia]) }}"
            target="_blank"
            rel="noopener noreferrer"
            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                📄 {{ $labelLaporan }}
            </a>
        @endif
    </div>

    {{-- LABEL KATEGORI USIA (JIKA DATANG DARI DASHBOARD) --}}
@if(!empty($labelKategori))
    <div class="mb-3 text-sm font-semibold text-red-700">
        Kategori: {{ $labelKategori }}
    </div>
@endif

    <form method="GET" class="bg-white p-4 rounded-xl shadow mb-6">

    {{-- FILTER ASAS --}}
    <div class="flex flex-wrap items-end gap-4">

        {{-- KATEGORI --}}
<div>
    <label class="text-sm text-gray-600">Kategori</label>
    <select name="kategori"
        class="border rounded px-3 py-1 w-52">
        <option value="">Semua</option>

        @foreach($kategoriList as $kategori)
            <option value="{{ $kategori }}"
                {{ request('kategori') == $kategori ? 'selected' : '' }}>
                {{ $kategori }}
            </option>
        @endforeach

    </select>
</div>

        {{-- BAHAGIAN --}}
        <div>
            <label class="text-sm text-gray-600">Bahagian</label>
            <select name="bahagian" id="bahagian"
                class="border rounded px-3 py-1 w-56">
                <option value="">Semua</option>
                @foreach($bahagians as $bahagian)
                    <option value="{{ $bahagian->id }}"
                        {{ request('bahagian') == $bahagian->id ? 'selected' : '' }}>
                        {{ $bahagian->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- UNIT (BERGANTUNG BAHAGIAN) --}}
        <div>
            <label class="text-sm text-gray-600">Unit</label>
            <select name="unit" id="unit"
                class="border rounded px-3 py-1 w-56">
                <option value="">Semua</option>
                @if(isset($units))
                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}"
                            {{ request('unit') == $unit->id ? 'selected' : '' }}>
                            {{ $unit->nama }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>

        {{-- CARIAN TEKS --}}
        <div>
            <label class="text-sm text-gray-600">Cari</label>
            <input type="text"
                   name="q"
                   value="{{ request('q') }}"
                   placeholder="No siri / model / pengguna"
                   class="border rounded px-4 py-1 w-64">
        </div>

        <div class="flex items-end">
            <button
                class="bg-blue-600 text-white px-5 py-1 rounded hover:bg-blue-700">
                Cari
            </button>
        </div>
    </div>

    {{-- FILTER USIA ASET (KEKAL FUNGSI ASAL) --}}
    <div class="mt-5 border-t pt-4">
        <label class="text-sm text-gray-600">Usia Aset</label>
        <select name="usia"
            class="border rounded-lg px-4 py-1 w-56">
            <option value="" {{ request()->filled('usia') ? '' : 'selected' }}>
                Semua
            </option>
            <option value="5" {{ request('usia') == '5' ? 'selected' : '' }}>
                6–7 tahun (Akan Usang)
            </option>
            <option value="7" {{ request('usia') == '7' ? 'selected' : '' }}>
                8 tahun (Wajar Dinilai)
            </option>
            <option value="8" {{ request('usia') == '8' ? 'selected' : '' }}>
                ≥ 9 tahun (Disyorkan Ganti)
            </option>
        </select>
    </div>

</form>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow border overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-2">Bil</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Jenama</th>
                    <th class="px-4 py-3">Model</th>
                    <th class="px-4 py-2">No Siri</th>
                    <th class="px-4 py-2">Usia Aset</th>
                    <th class="px-4 py-3">Bahagian</th>
                    <th class="px-4 py-3">Unit</th>
                    <th class="px-4 py-3">Pengguna</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Tindakan</th>
                </tr>
            </thead>

            <tbody class="divide-y">
            @forelse ($assets as $a)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-center text-gray-500">
                        {{ ($assets->currentPage() - 1) * $assets->perPage() + $loop->iteration }}
                    </td>

                    <td class="px-4 py-3">{{ $a->kategori ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $a->jenama ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $a->model ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $a->no_siri ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $a->usia_aset ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $a->bahagian ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $a->unit ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $a->nama_pengguna ?? '-' }}</td>

                    <td class="px-4 py-3">
                        @switch($a->status)
                            @case('Aktif')
                                <span class="px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">Aktif</span>
                                @break
                            @case('Rosak')
                                <span class="px-2 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">Rosak</span>
                                @break
                            @case('Untuk Dilupus')
                                <span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">Untuk Dilupus</span>
                                @break
                            @case('Dilupus')
                                <span class="px-2 py-1 rounded-full bg-gray-300 text-gray-800 text-xs font-semibold">Dilupus</span>
                                @break
                            @default
                                <span class="px-2 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold">-</span>
                        @endswitch
                    </td>

                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3 text-xs">
                            <a href="{{ route('ict.assets.show', $a->id) }}" class="text-blue-600 hover:underline">Lihat</a>
                            <a href="{{ route('ict.assets.edit', $a->id) }}" class="text-indigo-600 hover:underline">Edit</a>
                            <form action="{{ route('ict.assets.destroy', $a->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Padam aset ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10"
                        class="px-4 py-6 text-center text-gray-500 text-sm">
                        Tiada rekod aset buat masa ini.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-4">
        {{ $assets->links() }}
    </div>

</div>

{{-- JS DEPENDENT DROPDOWN (KEKAL) --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const bahagianSelect = document.getElementById('bahagian');
    const unitSelect = document.getElementById('unit');

    if (!bahagianSelect || !unitSelect) return;

    bahagianSelect.addEventListener('change', function () {
        const bahagianId = this.value;
        unitSelect.innerHTML = '<option value="">Semua</option>';

        if (!bahagianId) return;

        fetch(`/api/units/${bahagianId}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(unit => {
                    const option = document.createElement('option');
                    option.value = unit.id;
                    option.textContent = unit.nama;
                    unitSelect.appendChild(option);
                });
            });
    });
});
</script>

</x-app-layout>
