<x-app-layout>
<div class="px-6 py-6">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">
        Dashboard — Admin Sistem
    </h1>

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        <div class="bg-white shadow rounded-xl p-6 border">
            <h3 class="text-gray-500 text-sm">Jumlah Aset</h3>
            <div class="text-3xl font-bold text-blue-700 mt-2">{{ $totalAset }}</div>
        </div>

        <div class="bg-white shadow rounded-xl p-6 border">
            <h3 class="text-gray-500 text-sm">Aset Rosak</h3>
            <div class="text-3xl font-bold text-red-600 mt-2">{{ $rosak }}</div>
        </div>

        <div class="bg-white shadow rounded-xl p-6 border">
            <h3 class="text-gray-500 text-sm">Untuk Dilupus</h3>
            <div class="text-3xl font-bold text-yellow-600 mt-2">{{ $hampirLupus }}</div>
        </div>

    </div>

    <div class="bg-white shadow rounded-xl overflow-hidden">
        <div class="px-4 py-3 border-b flex justify-between">
            <h2 class="text-sm font-semibold text-gray-600 uppercase">10 Aset Terkini</h2>
            <a href="#" class="text-blue-700 text-xs">Lihat Semua →</a>
        </div>

        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase">
                <tr>
                    <th class="px-4 py-2 text-left">Nama</th>
                    <th class="px-4 py-2 text-left">Jenama</th>
                    <th class="px-4 py-2 text-left">Model</th>
                    <th class="px-4 py-2 text-left">Status</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($recentAsets as $a)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $a->nama }}</td>
                    <td class="px-4 py-2">{{ $a->jenama ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $a->model ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $a->status }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-4 text-center text-gray-500">
                        Tiada rekod aset.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
</x-app-layout>
