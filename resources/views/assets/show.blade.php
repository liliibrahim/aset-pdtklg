<x-app-layout>
    <div class="px-6 py-6">

        {{-- Tajuk --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                Maklumat Aset ICT
            </h1>

            <a href="{{ route('ict.assets.index') }}"
               class="px-4 py-2 text-sm rounded-lg border border-gray-300 bg-white hover:bg-gray-50">
                ← Kembali
            </a>
        </div>


        <div class="flex justify-end gap-2 mb-4">
    <a href="{{ route('ict.assets.laporanA', $asset->id) }}"
       class="px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
        Laporan A (Maklumat Aset)
    </a>

    <a href="{{ route('ict.assets.laporanB', $asset->id) }}"
       class="px-3 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm">
        Laporan B (Naik Taraf / Komponen)
    </a>
</div>

        {{-- ===================================================== --}}
        {{--               MAKLUMAT ASET ICT                     --}}
        {{-- ===================================================== --}}
        <div class="bg-white p-6 rounded-xl shadow mb-8">
            <h2 class="font-bold text-lg mb-4">Maklumat Aset</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">

                <div>
                    <div class="text-gray-600 font-semibold">Kategori</div>
                    <div>{{ $asset->kategori ?? '-' }}</div>
                </div>

                <div>
                    <div class="text-gray-600 font-semibold">Jenama</div>
                    <div>{{ $asset->jenama ?? '-' }}</div>
                </div>

                <div>
                    <div class="text-gray-600 font-semibold">Model</div>
                    <div>{{ $asset->model ?? '-' }}</div>
                </div>

                <div>
                    <div class="text-gray-600 font-semibold">No Siri</div>
                    <div>{{ $asset->no_siri ?? '-' }}</div>
                </div>

                <div>
                    <div class="text-gray-600 font-semibold">Bahagian Semasa</div>
                    <div>{{ $asset->bahagian ?? '-' }}</div>
                </div>

                <div>
                    <div class="text-gray-600 font-semibold">Unit Semasa</div>
                    <div>{{ $asset->unit ?? '-' }}</div>
                </div>

                <div>
                    <div class="text-gray-600 font-semibold">Tarikh Perolehan</div>
                    <div>
                        @if($asset->tarikh_perolehan)
                            {{ \Carbon\Carbon::parse($asset->tarikh_perolehan)->format('d.m.Y') }}
                        @else
                            -
                        @endif
                    </div>
                </div>

            </div>
        </div>

        {{-- ===================================================== --}}
        {{--               SEJARAH PENEMPATAN                    --}}
        {{-- ===================================================== --}}
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="font-bold text-lg mb-4">Sejarah Penempatan</h2>

            @if ($asset->movements->isEmpty())
                <p class="text-sm text-gray-600">Tiada rekod sejarah penempatan.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm border border-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 border-b text-left">#</th>
                                <th class="px-3 py-2 border-b text-left">Bahagian</th>
                                <th class="px-3 py-2 border-b text-left">Unit</th>
                                <th class="px-3 py-2 border-b text-left">Pengguna</th>
                                <th class="px-3 py-2 border-b text-left">Tarikh Mula</th>
                                                                <th class="px-3 py-2 border-b text-left">Catatan</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($asset->movements as $m)
                                <tr class="hover:bg-gray-50">

                                    {{-- Bil --}}
                                    <td class="px-3 py-2 border-b">{{ $loop->iteration }}</td>

                                    {{-- Bahagian --}}
                                    <td class="px-3 py-2 border-b">
                                        {{ $m->bahagian ?? '-' }}
                                    </td>

                                    {{-- Unit --}}
                                    <td class="px-3 py-2 border-b">
                                        {{ $m->unit ?? '-' }}
                                    </td>

                                    {{-- Pengguna --}}
                                    <td class="px-3 py-2 border-b">
                                        {{ $m->nama_pengguna ?? '-' }}
                                    </td>

                                    {{-- TARIKH MULA --}}
                                    <td class="px-3 py-2 border-b">
                                        @if(!empty($m->tarikh_mula) && $m->tarikh_mula != '0000-00-00')
                                            {{ \Carbon\Carbon::parse($m->tarikh_mula)->format('d.m.Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    {{-- Catatan --}}
                                    <td class="px-3 py-2 border-b">
                                        {{ $m->catatan ?? '-' }}
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
