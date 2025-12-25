<x-app-layout>
<div class="px-6 py-6">

    <h1 class="text-2xl font-bold mb-4">Senarai Aduan</h1>

    @php
        $currentStatus = request('status');
    @endphp

    {{-- TAB STATUS --}}
    <div class="flex gap-3 mb-6">
        {{-- BARU --}}
        <a href="{{ route('ict.aduan.index', ['status' => 'baru']) }}"
           class="px-4 py-2 rounded-lg border
           {{ $currentStatus === 'baru'
                ? 'bg-blue-600 text-white border-blue-600'
                : 'bg-blue-50 text-blue-700 border-blue-200 hover:bg-blue-100' }}">
            Baru
        </a>

        {{-- DALAM TINDAKAN --}}
        <a href="{{ route('ict.aduan.index', ['status' => 'dalam_tindakan']) }}"
           class="px-4 py-2 rounded-lg border
           {{ $currentStatus === 'dalam_tindakan'
                ? 'bg-yellow-500 text-white border-yellow-500'
                : 'bg-yellow-50 text-yellow-700 border-yellow-200 hover:bg-yellow-100' }}">
            Dalam Tindakan
        </a>

        {{-- SELESAI --}}
        <a href="{{ route('ict.aduan.index', ['status' => 'selesai']) }}"
           class="px-4 py-2 rounded-lg border
           {{ $currentStatus === 'selesai'
                ? 'bg-green-600 text-white border-green-600'
                : 'bg-green-50 text-green-700 border-green-200 hover:bg-green-100' }}">
            Selesai
        </a>
    </div>

    {{-- TABLE --}}
    <div class="overflow-x-auto bg-white rounded-lg border">
        <table class="w-full border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-3 py-2 text-left">Bil</th>
                    <th class="px-3 py-2 text-left">Tarikh Aduan</th>
                    <th class="px-3 py-2 text-left">Pengadu</th>
                    <th class="px-3 py-2 text-left">Maklumat Aset</th>
                    <th class="px-3 py-2 text-left">Status</th>
                    <th class="px-3 py-2 text-left">Tindakan ICT</th>
                </tr>
            </thead>

            <tbody>
            @forelse($aduans as $aduan)

                @php
                    /*
                    |--------------------------------------------------------------------------
                    | NORMALISASI STATUS (PENTING)
                    |--------------------------------------------------------------------------
                    */
                    $statusUi = match (strtolower(trim($aduan->status))) {
                        'baru',
                        'menunggu tindakan ict' => 'baru',

                        'dalam tindakan',
                        'dalam_tindakan' => 'dalam_tindakan',

                        'selesai' => 'selesai',

                        default => 'baru',
                    };
                @endphp

                <tr class="border-t">
                    {{-- Bil --}}
                    <td class="px-3 py-2 align-top">
                        {{ $loop->iteration + ($aduans->currentPage() - 1) * $aduans->perPage() }}
                    </td>

                    {{-- Tarikh --}}
                    <td class="px-3 py-2 align-top">
                        {{ $aduan->created_at->format('d/m/Y') }}
                    </td>

                    {{-- Pengadu --}}
                    <td class="px-3 py-2 align-top">
                        {{ $aduan->user->name ?? '-' }}
                    </td>

                    {{-- Maklumat Aset --}}
                    <td class="px-3 py-2 align-top">
                        <div class="font-medium">
                            {{ $aduan->asset->kategori ?? '-' }}
                        </div>
                        <div class="text-sm text-gray-600">
                            Model: {{ $aduan->asset->model ?? '-' }}<br>
                            No Siri: {{ $aduan->asset->no_siri ?? '-' }}
                        </div>
                    </td>

                    {{-- Status --}}
                    <td class="px-3 py-2 align-top">
                        @if($statusUi === 'baru')
                            <span class="inline-block px-2 py-1 text-xs rounded bg-blue-100 text-blue-700">
                                Baru
                            </span>
                        @elseif($statusUi === 'dalam_tindakan')
                            <span class="inline-block px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700">
                                Dalam Tindakan
                            </span>
                        @else
                            <span class="inline-block px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                                Selesai
                            </span>
                        @endif
                    </td>

                    {{-- Tindakan ICT --}}
                    <td class="px-3 py-2 align-top">
                        <form method="POST"
                              action="{{ route('ict.aduan.update', $aduan) }}"
                              class="flex items-center gap-2">
                            @csrf
                            @method('PUT')

                            <select name="tindakan_ict"
                                    class="border rounded px-2 py-1 text-sm"
                                    {{ $statusUi === 'selesai' ? 'disabled' : '' }}>
                                <option value="">Pilih Tindakan</option>
                                <option value="sedang_disemak">Sedang Disemak</option>
                                <option value="pembaikan_sedang_dijalankan">Pembaikan Sedang Dijalankan</option>
                                <option value="menunggu_alat_ganti">Menunggu Alat Ganti</option>
                                <option value="menunggu_vendor">Menunggu Vendor</option>
                                <option value="tidak_dapat_dibaiki">Tidak Dapat Dibaiki</option>
                                <option value="selesai_dibaiki">Selesai Dibaiki</option>
                            </select>

                            @if($statusUi !== 'selesai')
                                <button type="submit"
                                        class="px-3 py-1 bg-blue-600 text-white rounded text-sm">
                                    Simpan
                                </button>
                            @endif
                        </form>

                        @if($aduan->tindakan_ict)
                            <div class="text-xs text-gray-500 mt-1">
                                {{ ucwords(str_replace('_',' ',$aduan->tindakan_ict)) }}
                            </div>
                        @endif
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                        Tiada rekod aduan.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-4">
        {{ $aduans->links() }}
    </div>

</div>
</x-app-layout>
