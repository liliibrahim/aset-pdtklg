<x-app-layout>
<div class="px-6 py-6">

    <h1 class="text-xl font-bold mb-4">Laporan Aduan</h1>

    {{-- RINGKASAN --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

        <div class="bg-white p-4 rounded shadow">
            <div class="text-xs text-gray-500">Jumlah Aduan</div>
            <div class="text-2xl font-bold">{{ $ringkasan['jumlah'] }}</div>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <div class="text-xs text-gray-500">Baru</div>
            <div class="text-2xl font-bold text-blue-600">{{ $ringkasan['baru'] }}</div>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <div class="text-xs text-gray-500">Dalam Tindakan</div>
            <div class="text-2xl font-bold text-orange-600">
                {{ $ringkasan['dalam_tindakan'] }}
            </div>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <div class="text-xs text-gray-500">Selesai</div>
            <div class="text-2xl font-bold text-green-600">
                {{ $ringkasan['selesai'] }}
            </div>
        </div>

    </div>

    {{-- FILTER STATUS --}}
    <div class="flex gap-2 mb-4">
        <a href="{{ route('ict.laporan.aduan') }}"
           class="px-4 py-2 border rounded">Semua</a>

        <a href="{{ route('ict.laporan.aduan',['status'=>'baru']) }}"
           class="px-4 py-2 border rounded">Baru</a>

        <a href="{{ route('ict.laporan.aduan',['status'=>'dalam_tindakan']) }}"
           class="px-4 py-2 border rounded">Dalam Tindakan</a>

        <a href="{{ route('ict.laporan.aduan',['status'=>'selesai']) }}"
           class="px-4 py-2 border rounded">Selesai</a>

        <a href="{{ route('ict.laporan.aduan.pdf', request()->query()) }}"
           target="_blank"
           class="ml-auto px-4 py-2 bg-red-600 text-white rounded">
            Cetak PDF
        </a>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">Bil</th>
                    <th class="px-4 py-2">Aset</th>
                    <th class="px-4 py-2">Aduan</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Tarikh</th>
                </tr>
            </thead>
            <tbody>
                @forelse($aduans as $i => $a)
                <tr class="border-t">
                    <td class="px-4 py-2">
                        {{ $aduans->firstItem() + $i }}
                    </td>
                    <td class="px-4 py-2">
                        {{ $a->asset->no_siri ?? '-' }}
                    </td>
                    <td class="px-4 py-2">
                        {{ $a->deskripsi_masalah ?? '-' }}
                    </td>
                    <td class="px-4 py-2">
                        {{ $a->status }}
                    </td>
                    <td class="px-4 py-2">
                        {{ $a->created_at->format('d/m/Y') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4">
                        Tiada rekod aduan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $aduans->links() }}
        </div>
    </div>

</div>
</x-app-layout>
