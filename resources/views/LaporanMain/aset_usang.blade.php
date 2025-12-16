<x-app-layout>
<div class="px-6 py-6">

    <h1 class="text-xl font-bold mb-4">Laporan Aset Usang</h1>

    {{-- FILTER + CETAK PDF --}}
    <div class="flex justify-between items-center mb-4">

        {{-- FILTER (KIRI) --}}
        <form method="GET" class="flex items-center gap-2">
            <select name="tahap" class="border rounded px-3 py-2 text-sm">
                <option value="">Semua</option>
                <option value="5" @selected(request('tahap') == 5)>5–6 Tahun</option>
                <option value="7" @selected(request('tahap') == 7)>7 Tahun</option>
                <option value="8" @selected(request('tahap') >= 8)>≥ 8 Tahun</option>
            </select>

            <button
                type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded text-sm">
                Tapis
            </button>
        </form>

        {{-- CETAK PDF (KANAN) --}}
        <a href="{{ route('ict.laporan.aset_usang.pdf', request()->query()) }}"
           target="_blank"
           class="px-4 py-2 bg-red-600 text-white rounded text-sm inline-flex items-center gap-2">
            Cetak PDF
        </a>

    </div>

    {{-- JADUAL --}}
    <table class="w-full border">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-2 py-1">Bil</th>
                <th class="border px-2 py-1">Kategori</th>
                <th class="border px-2 py-1">Jenama</th>
                <th class="border px-2 py-1">Model</th>
                <th class="border px-2 py-1">No Siri</th>
                <th class="border px-2 py-1">Bahagian</th>
                <th class="border px-2 py-1">Unit</th>
            </tr>
        </thead>
        <tbody>
            @forelse($assets as $i => $a)
                <tr>
                    <td class="border px-2 py-1">{{ $i + 1 }}</td>
                    <td class="border px-2 py-1">{{ $a->kategori ?? '-' }}</td>
                    <td class="border px-2 py-1">{{ $a->jenama ?? '-' }}</td>
                    <td class="border px-2 py-1">{{ $a->model ?? '-' }}</td>
                    <td class="border px-2 py-1">{{ $a->no_siri ?? '-' }}</td>
                    <td class="border px-2 py-1">{{ $a->bahagian ?? '-' }}</td>
                    <td class="border px-2 py-1">{{ $a->unit ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="border px-2 py-3 text-center">
                        Tiada rekod
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>
</x-app-layout>
