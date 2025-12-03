<x-app-layout>
    <div class="px-6 py-6">

        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            Log Aktiviti Sistem
        </h1>

        <div class="bg-white p-6 rounded-xl shadow">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100 border">
                        <th class="p-3 border text-left">Tarikh</th>
                        <th class="p-3 border text-left">Modul</th>
                        <th class="p-3 border text-left">Tindakan</th>
                        <th class="p-3 border text-left">Pengguna</th>
                        <th class="p-3 border text-left">Aset</th>
                        <th class="p-3 border text-left">Catatan</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($logs as $log)
                        <tr class="border">
                            <td class="p-3 border">
                                {{ $log->created_at->format('d/m/Y H:i') }}
                            </td>

                            <td class="p-3 border">
                                {{ $log->module }}
                            </td>

                            <td class="p-3 border">
                                {{ strtoupper($log->action) }}
                            </td>

                            <td class="p-3 border">
                                {{ $log->user->name ?? 'Tidak Diketahui' }}
                            </td>

                            <td class="p-3 border">
                                {{ $log->asset->no_siri_aset ?? '-' }}
                            </td>

                            <td class="p-3 border">
                                {{ $log->description ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-4 text-center text-gray-500">
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
    </div>
</x-app-layout>
