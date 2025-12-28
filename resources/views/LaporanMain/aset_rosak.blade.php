<x-app-layout>
    <div class="px-6 py-6">

        {{-- Tajuk laporan --}}
        <h1 class="text-lg font-bold text-gray-800 mb-2">Laporan Aset Rosak</h1>

        {{-- Ringkasan jumlah --}}
        <p class="text-sm text-gray-600 mb-4">Jumlah aset rosak: <b>{{ $jumlahRosak }}</b></p>
        
        {{-- Borang filter --}}
        <form method="GET" class="bg-white p-4 rounded-xl shadow mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">

            {{-- Filter bahagian --}}
            <div>
                <label class="text-xs font-semibold">Bahagian</label>
                <select name="bahagian" class="border p-2 rounded w-full text-sm">
                    <option value="">Semua</option>
                    @foreach($bahagianList as $b)
                        <option value="{{ $b }}" @selected($bahagian===$b)>
                            {{ $b }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filter unit --}}
            <div>
                <label class="text-xs font-semibold">Unit</label>
                <select name="unit" class="border p-2 rounded w-full text-sm">
                    <option value="">Semua</option>
                    @foreach($unitList as $u)
                        <option value="{{ $u }}" @selected($unit===$u)>
                            {{ $u }}
                        </option>
                    @endforeach
                </select>
            </div>

            <
            {{-- Butang tindakan --}}
            div class="flex gap-2">
                <button class="px-4 py-2 bg-blue-600 text-white rounded text-sm">
                    Tapis
                </button>
                <a href="{{ route('ict.laporan.aset_rosak') }}"
                class="px-4 py-2 bg-gray-200 rounded text-sm">
                    Reset
                </a>
            </div>

            {{-- Butang cetak pdf --}}
            <div class="flex justify-end">
                <a href="{{ route('ict.laporan.aset_rosak.pdf', request()->query()) }}"
                target="_blank"
                class="px-4 py-2 bg-red-600 text-white rounded text-sm hover:bg-red-700">
                    Cetak PDF
                </a>
            </div>

        </div>
    </form>

    {{-- Jadual senarai aset --}}
    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left">Bil.</th>
                    <th class="px-4 py-3 text-left">Kategori</th>
                    <th class="px-4 py-3 text-left">Jenama</th>
                    <th class="px-4 py-3 text-left">Model</th>
                    <th class="px-4 py-3 text-left">No Siri</th>
                    <th class="px-4 py-3 text-left">Bahagian</th>
                    <th class="px-4 py-3 text-left">Unit</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($assets as $a)
                    <tr class="hover:bg-gray-50">

                        {{-- Nombor bersiri ikut pagination --}}
                        <td class="px-4 py-3">
                            {{ ($assets->currentPage() - 1) * $assets->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-4 py-3">{{ $a->kategori ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $a->jenama ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $a->model ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $a->no_siri ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $a->bahagian ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $a->unit ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-gray-500">Tiada aset rosak.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{-- Pagination --}}
    <div class="mt-4">
        {{ $assets->links() }}
    </div>
</div>
</x-app-layout>
