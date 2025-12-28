<x-app-layout>
<div class="px-6 py-6">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">
        Dashboard — Pengguna
    </h1>

    {{-- Ringkasan status aset milik pengguna --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-5 rounded-xl shadow border">
            <p class="text-sm text-gray-500">Jumlah Aset</p>
            <p class="text-3xl font-bold text-blue-700">{{ $totalAset }}</p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow border">
            <p class="text-sm text-gray-500">Aset Aktif</p>
            <p class="text-3xl font-bold text-green-600">{{ $asetAktif }}</p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow border">
            <p class="text-sm text-gray-500">Aset Rosak</p>
            <p class="text-3xl font-bold text-red-600">{{ $asetRosak }}</p>
        </div>
    </div>

    {{-- Senarai aset di bawah tanggungjawab pengguna --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="px-4 py-3 border-b">
            <h2 class="text-sm font-semibold text-gray-600 uppercase">
                Aset di bawah tanggungjawab anda
            </h2>
        </div>

        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase">
                <tr>
                    <th class="px-3 py-2">Kategori</th>
                    <th class="px-3 py-2">Jenama</th>
                    <th class="px-3 py-2">Model</th>
                    <th class="px-3 py-2">No Siri</th>
                    <th class="px-3 py-2">Tarikh Penempatan</th>
                    <th class="px-3 py-2">Status</th>
                    <th class="px-3 py-2 text-center">Laporan Kerosakan</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse ($asetSaya as $a)
                <tr class="hover:bg-gray-50">
                    <td class="px-3 py-2">{{ $a->kategori }}</td>
                    <td class="px-3 py-2">{{ $a->jenama }}</td>
                    <td class="px-3 py-2">{{ $a->model }}</td>
                    <td class="px-3 py-2">{{ $a->no_siri ?? '-' }}</td>
                    <td class="px-3 py-2">
                        {{ optional($a->tarikh_penempatan)->format('d/m/Y') }}
                    </td>

                    {{-- STATUS --}}
                    <td class="px-3 py-2">
                        @php
                            // Ambil aduan TERKINI bagi aset ini
                            $aduan = $a->complaints
                                ->sortByDesc('created_at')
                                ->first();
                        @endphp

                        @if(!$aduan)
                            <span class="inline-block px-2 py-1 text-xs rounded bg-gray-100 text-gray-600">
                                Tiada Aduan
                            </span>
                        @else
                            @switch($aduan->status)
                                @case('Menunggu Tindakan ICT')
                                    <span class="inline-block px-2 py-1 text-xs rounded bg-blue-100 text-blue-700">
                                        Baru
                                    </span>
                                    @break

                                @case('Dalam Tindakan')
                                    <span class="inline-block px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700">
                                        Dalam Tindakan
                                    </span>
                                    @break

                                @case('Selesai')
                                    <span class="inline-block px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                                        Selesai
                                    </span>
                                    @break

                                @default
                                    <span class="inline-block px-2 py-1 text-xs rounded bg-gray-100 text-gray-600">
                                        Tidak Diketahui
                                    </span>
                            @endswitch
                        @endif
                    </td>

                    {{-- LAPORAN KEROSAKAN --}}
                    <td class="px-3 py-2 text-center align-top">
                        @php
                            // Rujuk tindakan ICT daripada aduan terkini
                            $request = optional($aduan)->maintenanceRequest;
                        @endphp

                        @if(!$aduan)
                            {{-- Benarkan pengguna cipta aduan baharu --}}
                            <a href="{{ route('user.aduan.create', $a->id) }}"
                               class="px-3 py-1 text-xs text-white bg-blue-600 rounded hover:bg-blue-700">
                                Lapor Kerosakan
                            </a>
                        @else
                        {{-- Papar status aduan semasa --}}
                        @if($aduan->status === 'Menunggu Tindakan ICT')
                            <span class="inline-block px-2 py-1 text-xs rounded bg-blue-100 text-blue-700">
                                Baru
                            </span>
                        @elseif($aduan->status === 'Dalam Tindakan')
                            <span class="inline-block px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700">
                                Dalam Tindakan
                            </span>
                        @else
                            <span class="inline-block px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                                Selesai
                            </span>
                        @endif

                        @if($request && $request->tindakan_ict)
                            <div class="text-xs text-gray-500 mt-1">
                                {{ ucwords(str_replace('_',' ', $request->tindakan_ict)) }}
                            </div>
                        @endif
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center py-6 text-gray-500">
                    Tiada aset direkodkan di bawah tanggungjawab anda.
                </td>
            </tr>
            @endforelse
        </tbody>
        </table>
    </div>

</div>
</x-app-layout>
