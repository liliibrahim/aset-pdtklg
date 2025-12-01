<x-app-layout>
<div class="px-6 py-6">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">
        Dashboard — Pegawai ICT
    </h1>

       <a href="{{ route('ict.assets.create') }}"
       class="px-4 py-2 bg-blue-600 text-black rounded-lg text-sm hover:bg-blue-700">
        + Tambah Aset
    </a>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white shadow p-6 rounded-xl border">
            <h3 class="text-sm text-gray-500">Jumlah Aset ICT</h3>
            <div class="text-3xl font-bold text-blue-700 mt-2">{{ $totalAset }}</div>
        </div>

        <div class="bg-white shadow p-6 rounded-xl border">
            <h3 class="text-sm text-gray-500">Aset Rosak</h3>
            <div class="text-3xl font-bold text-red-600 mt-2">{{ $rosak }}</div>
        </div>
    </div>

    <div class="bg-white shadow rounded-xl overflow-hidden">
        <div class="px-4 py-3 border-b">
            <h2 class="text-sm font-semibold text-gray-600 uppercase">Aset Terkini</h2>
        </div>

        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase">
                <tr>
                    <th class="px-4 py-2 text-left">Nama</th>
                    <th class="px-4 py-2 text-left">Status</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @foreach ($recentAsets as $a)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $a->nama }}</td>
                    <td class="px-4 py-2">{{ $a->status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
</x-app-layout>
