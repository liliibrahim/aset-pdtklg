<x-app-layout>
<div class="px-6 py-6">

    {{-- TAJUK KIRI + BUTANG PDF KANAN --}}
    <div class="flex items-center justify-between mb-4">
    <h1 class="text-xl font-bold">
        Log Aktiviti Sistem
    </h1>

    <a href="{{ route('admin.activity-logs.pdf') }}"
       target="_blank"
       class="px-4 py-2 bg-red-600 text-white text-sm rounded hover:bg-red-700">
        📄 Cetak Laporan PDF
    </a>
</div>

    <table class="min-w-full bg-white border rounded-lg overflow-hidden">
        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
            <tr>
                <th class="px-4 py-2">Tarikh</th>
                <th class="px-4 py-2">Pengguna</th>
                <th class="px-4 py-2">Aktiviti</th>
                <th class="px-4 py-2">Tindakan</th>
                <th class="px-4 py-2">Modul</th>
                <th class="px-4 py-2">Aset</th>
            </tr>
        </thead>

        <tbody class="divide-y text-sm">
            @forelse($logs as $log)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2">
                        {{ $log->created_at->format('d/m/Y H:i') }}
                    </td>

                    <td class="px-4 py-2">
                        {{ $log->user->name ?? '-' }}
                    </td>

                    <td class="px-4 py-2 font-medium">
                        {{ $log->aktiviti }}
                    </td>

                    <td class="px-4 py-2">
                        {{ $log->tindakan }}
                    </td>

                    <td class="px-4 py-2">
                        {{ $log->modul }}
                    </td>

                    <td class="px-4 py-2">
                        {{ $log->aset ?? '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                        Tiada rekod aktiviti.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $logs->links() }}
    </div>

</div>
</x-app-layout>
