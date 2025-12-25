<x-app-layout>
    <div class="px-6 py-6">

        {{-- TAJUK --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl font-bold text-gray-800">
                Laporan Aduan
            </h1>
        </div>

        {{-- RINGKASAN --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

            <div class="bg-white p-4 rounded-xl shadow">
                <div class="text-xs text-gray-500">Jumlah Aduan</div>
                <div class="text-2xl font-bold">
                    {{ $ringkasan['jumlah'] }}
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl shadow">
                <div class="text-xs text-gray-500">Baru</div>
                <div class="text-2xl font-bold text-blue-600">
                    {{ $ringkasan['baru'] }}
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl shadow">
                <div class="text-xs text-gray-500">Dalam Tindakan</div>
                <div class="text-2xl font-bold text-orange-600">
                    {{ $ringkasan['dalam_tindakan'] }}
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl shadow">
                <div class="text-xs text-gray-500">Selesai</div>
                <div class="text-2xl font-bold text-green-600">
                    {{ $ringkasan['selesai'] }}
                </div>
            </div>

        </div>

        {{-- BUTANG PDF --}}
        <div class="mb-4">
            <a href="{{ route('ict.laporan.aduan.pdf', request()->query()) }}"
               target="_blank"
               class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium
                      text-white bg-red-600 hover:bg-red-700 rounded-lg shadow">
                Cetak PDF
            </a>
        </div>

        {{-- SENARAI ADUAN --}}
        <div class="bg-white rounded-xl shadow overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Aset</th>
                        <th class="px-4 py-3 text-left">Aduan</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Tarikh</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse ($aduans as $index => $a)
                        <tr>
                            <td class="px-4 py-3">
                                {{ $aduans->firstItem() + $index }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $a->asset->no_siri ?? '-' }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $a->aduan ?? '-' }}
                            </td>

                            {{-- STATUS (BETUL) --}}
                            <td class="px-4 py-3">
                                @if($a->status === 'Menunggu Tindakan ICT')
                                    <span class="px-2 py-1 rounded text-xs bg-blue-100 text-blue-700">
                                        Baru
                                    </span>
                                @elseif($a->status === 'Dalam Tindakan')
                                    <span class="px-2 py-1 rounded text-xs bg-orange-100 text-orange-700">
                                        Dalam Tindakan
                                    </span>
                                @elseif($a->status === 'Selesai')
                                    <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-700">
                                        Selesai
                                    </span>
                                @else
                                    <span class="px-2 py-1 rounded text-xs bg-gray-100 text-gray-600">
                                        Tidak Diketahui
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-3">
                                {{ $a->created_at?->format('d/m/Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                Tiada rekod aduan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- PAGINATION --}}
            <div class="p-4">
                {{ $aduans->links() }}
            </div>
        </div>

    </div>
</x-app-layout>
