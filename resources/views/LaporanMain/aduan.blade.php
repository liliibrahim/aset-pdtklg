<x-app-layout>
    <div class="px-6 py-6">

        {{-- Tajuk Halaman --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl font-bold text-gray-800">
                Laporan Aduan
            </h1>
        </div>

        {{-- Ringkasan statistik aduan mengikut status --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

            {{-- Jumlah keseluruhan aduan --}}
            <div class="bg-white p-4 rounded-xl shadow">
                <div class="text-xs text-gray-500">Jumlah Aduan</div>
                <div class="text-2xl font-bold">
                    {{ $ringkasan['jumlah'] ?? 0 }}
                </div>
            </div>

            {{-- Aduan baharu --}}
            <div class="bg-white p-4 rounded-xl shadow">
                <div class="text-xs text-gray-500">Baru</div>
                <div class="text-2xl font-bold text-blue-600">
                    {{ $ringkasan['baru'] }}
                </div>
            </div>

            {{-- Aduan dalam tindakan --}}
            <div class="bg-white p-4 rounded-xl shadow">
                <div class="text-xs text-gray-500">Dalam Tindakan</div>
                <div class="text-2xl font-bold text-orange-600">
                    {{ $ringkasan['dalam_tindakan'] }}
                </div>
            </div>

            {{-- Aduan selesai --}}
            <div class="bg-white p-4 rounded-xl shadow">
                <div class="text-xs text-gray-500">Selesai</div>
                <div class="text-2xl font-bold text-green-600">
                    {{ $ringkasan['selesai'] }}
                </div>
            </div>

        </div>

        {{-- Butang cetak laporan aduan dalam format PDF (ikut filter semasa) --}}
        <div class="mb-4">
            <a href="{{ route('ict.laporan.aduan.pdf', request()->query()) }}"
               target="_blank"
               class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium
                      text-white bg-red-600 hover:bg-red-700 rounded-lg shadow">
                Cetak PDF
            </a>
        </div>

    {{-- Borang filter laporan aduan --}}
    <form method="GET"
        action="{{ route('ict.laporan.aduan') }}"
        class="flex flex-wrap gap-3 items-end mb-4">

    {{-- Filter mengikut pengadu --}}
    <select name="user_id" class="rounded-lg border-gray-300 text-sm">
        <option value="">Semua Pengadu</option>
        @foreach($users as $user)
            <option value="{{ $user->id }}"
                {{ request('user_id') == $user->id ? 'selected' : '' }}>
                {{ $user->name }}
            </option>
        @endforeach
    </select>

    {{-- Filter mengikut unit --}}
    <select name="unit_id" class="rounded-lg border-gray-300 text-sm">
        <option value="">Semua Unit</option>
        @foreach($units as $unit)
            <option value="{{ $unit->id }}"
                {{ request('unit_id') == $unit->id ? 'selected' : '' }}>
                {{ $unit->nama }}
            </option>
        @endforeach
    </select>

    {{-- Filter mengikut status aduan --}}
    <select name="status" class="rounded-lg border-gray-300 text-sm">
        <option value="">Semua Status</option>
        <option value="baru" @selected(request('status')=='baru')>Baru</option>
        <option value="dalam_tindakan" @selected(request('status')=='dalam_tindakan')>
            Dalam Tindakan
        </option>
        <option value="selesai" @selected(request('status')=='selesai')>
            Selesai
        </option>
    </select>

    {{-- Filter mengikut jenis aduan --}}
    <select name="jenis_aduan" class="rounded-lg border-gray-300 text-sm">
        <option value="">Semua Jenis Aduan</option>
        <option value="Prestasi Perlahan"
            @selected(request('jenis_aduan')=='Prestasi Perlahan')>
            Prestasi Perlahan
        </option>
        <option value="Tidak Berfungsi"
            @selected(request('jenis_aduan')=='Tidak Berfungsi')>
            Tidak Berfungsi
        </option>
    </select>

    {{-- Filter tarikh aduan (dari) --}}
    <input type="date"
           name="tarikh_dari"
           value="{{ request('tarikh_dari') }}"
           class="rounded-lg border-gray-300 text-sm">

    {{-- filter tarikh aduan (hingga) --}}
    <input type="date"
           name="tarikh_hingga"
           value="{{ request('tarikh_hingga') }}"
           class="rounded-lg border-gray-300 text-sm">

    {{-- Carian berdasarkan nombor siri aset --}}
    <input type="text"
           name="aset"
           value="{{ request('aset') }}"
           placeholder="No Siri Aset"
           class="rounded-lg border-gray-300 text-sm">

    {{-- Butang laksana filter --}}
    <button type="submit"
            class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm">
        Tapis
    </button>

</form>

        {{-- Senarai aduan berdasarkan filter --}}
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
                                {{ $loop->iteration }}
                            </td>

                            {{-- Papar nombor siri aset --}}
                            <td class="px-4 py-3">
                                {{ $a->asset->no_siri ?? '-' }}
                            </td>

                            {{-- Maklumat ringkas aduan --}}
                            <td class="px-4 py-3 align-top">
                                <div class="font-semibold text-gray-800">
                                    {{ $a->jenis_aduan ?? '-' }}
                                </div>
                                <div class="text-sm text-gray-600">
                                    {{ $a->keterangan ?? '-' }}
                                </div>
                            </td>

                            {{-- Paparan status aduan --}}
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

                            {{-- Tarikh aduan direkodkan --}}
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

            {{-- Navigasi halaman senarai aduan --}}
            <div class="p-4">
                {{ $aduans->links() }}
            </div>
        </div>

    </div>
</x-app-layout>
