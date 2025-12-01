<x-app-layout>
    <div class="px-6 py-6">

        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            Senarai Aset ICT
        </h1>

        {{-- BUTANG TAMBAH ASET --}}
        <div class="mb-4">
            <a href="{{ route('ict.assets.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Tambah Aset
            </a>
        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-xl shadow border overflow-hidden">

            <table class="min-w-full text-sm">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-left">No. Peralatan</th>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-left">Jenama</th>
                        <th class="px-4 py-3 text-left">Model</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Tindakan</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @forelse ($assets as $a)
                        <tr class="hover:bg-gray-50">

                            <td class="px-4 py-3">{{ $a->no_peralatan }}</td>
                            <td class="px-4 py-3">{{ $a->nama }}</td>
                            <td class="px-4 py-3">{{ $a->jenama ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $a->model ?? '-' }}</td>

                            {{-- STATUS BADGE --}}
                            <td class="px-4 py-3">
                                @if ($a->status == 'Aktif')
                                    <span class="text-green-700 bg-green-100 px-2 py-1 rounded text-xs">Aktif</span>
                                @elseif ($a->status == 'Rosak')
                                    <span class="text-red-700 bg-red-100 px-2 py-1 rounded text-xs">Rosak</span>
                                @elseif ($a->status == 'Untuk Dilupus')
                                    <span class="text-yellow-700 bg-yellow-100 px-2 py-1 rounded text-xs">Untuk Dilupus</span>
                                @else
                                    <span class="text-gray-700 bg-gray-100 px-2 py-1 rounded text-xs">Dilupus</span>
                                @endif
                            </td>

                            {{-- BUTTON TINDAKAN --}}
                            <td class="px-4 py-3 flex space-x-2">

                                <a href="{{ route('ict.assets.show', $a->id) }}"
                                    class="text-blue-600 hover:underline text-xs">
                                    Lihat
                                </a>

                                <a href="{{ route('ict.assets.edit', $a->id) }}"
                                    class="text-indigo-600 hover:underline text-xs">
                                    Edit
                                </a>

                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                                Tiada rekod aset.
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
