<x-app-layout> 
    <div class="px-6 py-6">

        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            Senarai Aset ICT
        </h1>

        {{-- BUTANG TAMBAH ASET --}}
        <div class="mb-4">
            <a href="{{ route('ict.assets.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 shadow">
                + Tambah Aset
            </a>
        </div>

        {{-- FILTER FORM --}}
        <form method="GET" class="mb-4 bg-white p-4 rounded-xl shadow flex flex-wrap gap-4">

            <div>
                <label class="text-sm text-gray-600">Kategori</label>
                <select name="kategori" class="border rounded px-2 py-1">
                    <option value="">Semua</option>
                    @foreach ($kategoris as $k)
                        <option value="{{ $k }}" {{ request('kategori') == $k ? 'selected' : '' }}>
                            {{ $k }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-sm text-gray-600">Bahagian</label>
                <select name="bahagian" class="border rounded px-2 py-1">
                    <option value="">Semua</option>
                    @foreach ($bahagians as $b)
                        <option value="{{ $b }}" {{ request('bahagian') == $b ? 'selected' : '' }}>
                            {{ $b }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-sm text-gray-600">Unit</label>
                <select name="unit" class="border rounded px-2 py-1">
                    <option value="">Semua</option>
                    @foreach ($units as $u)
                        <option value="{{ $u }}" {{ request('unit') == $u ? 'selected' : '' }}>
                            {{ $u }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-sm text-gray-600">Cari</label>
                <input type="text" name="q" placeholder="No siri / model / pengguna"
                       value="{{ request('q') }}"
                       class="border rounded px-2 py-1">
            </div>

            <div class="flex items-end">
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Carian
                </button>
            </div>

        </form>

        {{-- TABLE WRAPPER --}}
        <div class="bg-white rounded-xl shadow border overflow-hidden">

            <table class="min-w-full text-sm">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-left">Kategori</th>
                        <th class="px-4 py-3 text-left">Jenama</th>
                        <th class="px-4 py-3 text-left">Model</th>
                        <th class="px-4 py-3 text-left">Bahagian</th>
                        <th class="px-4 py-3 text-left">Unit</th>
                        <th class="px-4 py-3 text-left">Pengguna</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Tindakan</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @forelse ($assets as $a)
                        <tr class="hover:bg-gray-50">

                            <td class="px-4 py-3">{{ $a->kategori ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $a->jenama ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $a->model ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $a->bahagian ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $a->unit ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $a->nama_pengguna ?? '-' }}</td>

                            <td class="px-4 py-3">
                                @switch($a->status)
                                    @case('Aktif')
                                        <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-700">Aktif</span>
                                        @break

                                    @case('Rosak')
                                        <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-700">Rosak</span>
                                        @break

                                    @case('Untuk Dilupus')
                                        <span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-700">Untuk Dilupus</span>
                                        @break

                                    @case('Dilupus')
                                        <span class="px-2 py-1 rounded text-xs bg-gray-300 text-gray-800">Dilupus</span>
                                        @break

                                    @default
                                        <span class="px-2 py-1 rounded text-xs bg-gray-100 text-gray-700">-</span>
                                @endswitch
                            </td>

                            <td class="text-sm flex items-center gap-3">

                            <a href="{{ route('ict.assets.show', $a->id) }}" class="text-blue-600 text-xs">Lihat</a>

                            <a href="{{ route('ict.assets.edit', $a->id) }}" class="text-indigo-600 text-xs">
                                Edit
                            </a>

                            <form action="{{ route('ict.assets.destroy', $a->id) }}"
                                method="POST"
                                onsubmit="return confirm('Padam aset ini?');">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="text-red-600 hover:text-red-800 text-xs">
                                    Delete
                                </button>
                            </form>

                        </td>

                        </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-6 text-center text-gray-500 text-sm">
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
</x-app-layout>
