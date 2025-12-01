<x-app-layout>
<div class="px-6 py-6">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">
        Dashboard — Pengguna
    </h1>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="px-4 py-3 border-b">
            <h2 class="text-sm font-semibold text-gray-600 uppercase">
                Aset di bawah jagaan anda
            </h2>
        </div>

        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase">
                <tr>
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">Jenama</th>
                    <th class="px-4 py-2">Status</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse ($asetSaya as $a)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $a->nama }}</td>
                    <td class="px-4 py-2">{{ $a->jenama ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $a->status }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-4 py-4 text-center text-gray-500">
                        Tiada aset.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
</x-app-layout>
