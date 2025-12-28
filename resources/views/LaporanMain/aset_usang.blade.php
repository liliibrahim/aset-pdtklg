<x-app-layout>
<div class="px-6 py-6">

    {{-- Tajuk laporan --}}
    <h1 class="text-xl font-bold mb-4">Laporan Aset Usang</h1>

    {{-- Filter + cetak pdf --}}
    <div class="flex justify-between items-center mb-4">

        {{-- Filter tahap usia aset --}}
        <form method="GET" class="flex items-center gap-2">

            {{-- Pilihan tahap usia aset --}}
            <select name="tahap" class="border rounded px-3 py-2 text-sm">
                <option value="">Semua</option>
                <option value="5" @selected(request('tahap') == 5)>5–6 Tahun</option>
                <option value="7" @selected(request('tahap') == 7)>7 Tahun</option>
                <option value="8" @selected(request('tahap') >= 8)>≥ 8 Tahun</option>
            </select>

            {{-- Hantar filter --}}
            <button
                type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded text-sm">
                Tapis
            </button>
        </form>

        {{-- Cetak pdf ikut filter semasa --}}
        <a href="{{ route('ict.laporan.aset_usang.pdf', request()->query()) }}"
           target="_blank"
           class="px-4 py-2 bg-red-600 text-white rounded text-sm inline-flex items-center gap-2">
            Cetak PDF
        </a>

    </div>

    {{-- Jadual senarai aset usang --}}
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

            {{-- Papar rekod aset --}}
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

            {{-- Jika tiada rekod --}}
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
