<x-app-layout>
    <div class="px-6 py-6">

        <div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-bold">
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

        <a href="{{ route('ict.laporan.aduan.pdf', request()->query()) }}"
       target="_blank"
       class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium
              text-white bg-red-600 hover:bg-red-700 rounded-lg shadow">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 4v16m8-8H4" />
        </svg>
        Cetak PDF
    </a>
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
                    @foreach ($aduans as $index => $a)
                        <tr>
                            <td class="px-4 py-3">
                                {{ $aduans->firstItem() + $index }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $a->asset->no_siri ?? '-' }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $a->aduan }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded text-xs
                                    {{ $a->status === 'baru' ? 'bg-blue-100 text-blue-700' :
                                       ($a->status === 'dalam_tindakan' ? 'bg-orange-100 text-orange-700' :
                                       'bg-green-100 text-green-700') }}">
                                    {{ ucfirst(str_replace('_',' ',$a->status)) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                {{ $a->created_at->format('d/m/Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="p-4">
                {{ $aduans->links() }}
            </div>
        </div>

    </div>
</x-app-layout>
