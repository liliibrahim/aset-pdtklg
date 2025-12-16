<x-app-layout>
<div class="px-6 py-6">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">
        Dashboard — Admin Sistem
    </h1>

    {{-- STAT PENGGUNA --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    {{-- Jumlah Pengguna --}}
    <a href="{{ route('admin.users.index') }}"
       class="block bg-white shadow rounded-xl p-6 border
              hover:shadow-lg hover:bg-gray-50 transition cursor-pointer">

        <h3 class="text-gray-500 text-sm">Jumlah Keseluruhan Pengguna</h3>
        <div class="text-3xl font-bold text-blue-700 mt-2">
            {{ $totalUsers }}
        </div>
    </a>

    {{-- Pentadbir Sistem --}}
    <a href="{{ route('admin.users.admins') }}"
       class="block bg-white shadow rounded-xl p-6 border
              hover:shadow-lg hover:bg-gray-50 transition cursor-pointer">

        <h3 class="text-gray-500 text-sm">Pentadbir Sistem</h3>
        <div class="text-3xl font-bold text-green-700 mt-2">
            {{ $totalAdmins }}
        </div>
    </a>

    {{-- Pegawai ICT --}}
    <a href="{{ route('admin.users.ict') }}"
       class="block bg-white shadow rounded-xl p-6 border
              hover:shadow-lg hover:bg-gray-50 transition cursor-pointer">

        <h3 class="text-gray-500 text-sm">Pegawai ICT</h3>
        <div class="text-3xl font-bold text-purple-700 mt-2">
            {{ $totalICT }}
        </div>
    </a>

</div>

    {{-- KONFIGURASI SISTEM --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

    {{-- Jumlah Bahagian --}}
    <div class="block bg-white shadow rounded-xl p-6 border
            hover:shadow-lg hover:bg-gray-50 transition">

    <h3 class="text-gray-500 text-sm">Jumlah Bahagian</h3>
    <div class="text-3xl font-bold text-indigo-700 mt-2">
        {{ $totalBahagian }}
    </div>
</div>


    {{-- Jumlah Unit --}}
   
<div class="block bg-white shadow rounded-xl p-6 border
            hover:shadow-lg hover:bg-gray-50 transition">

    <h3 class="text-gray-500 text-sm">Jumlah Unit</h3>
    <div class="text-3xl font-bold text-indigo-700 mt-2">
        {{ $totalUnit }}
    </div>
</div>




</div>

    {{-- ACTIVITY LOGS --}}
    <div class="bg-white shadow rounded-xl overflow-hidden">
        <div class="px-4 py-3 border-b flex justify-between items-center">
            <h2 class="text-sm font-semibold text-gray-600 uppercase">
                Aktiviti Terkini Sistem
            </h2>

            <a href="{{ route('admin.activity-logs.index') }}"
               class="text-sm text-blue-600 hover:underline">
                Lihat Semua →
            </a>
        </div>

        <table class="w-full border text-sm">
    <thead class="bg-gray-100">
        <tr>
            <th class="border px-3 py-2">Tarikh</th>
            <th class="border px-3 py-2">Pengguna</th>
            <th class="border px-3 py-2">Aktiviti</th>
            <th class="border px-3 py-2">Tindakan</th>
            <th class="border px-3 py-2">Modul</th>
            <th class="border px-3 py-2">Aset</th>
        </tr>
    </thead>

<tbody>
    @foreach($aktivitiTerkini as $log)
    <tr>
        <td class="border px-3 py-2">
            {{ $log->created_at->format('d/m/Y H:i') }}
        </td>

        <td class="border px-3 py-2">
            {{ $log->user->name ?? '-' }}
        </td>

        <td class="border px-3 py-2">
            {{ $log->aktiviti }}
        </td>

        <td class="border px-3 py-2">
            {{ $log->tindakan }}
        </td>

        <td class="border px-3 py-2">
            {{ $log->modul }}
        </td>

        <td class="border px-3 py-2">
            {{ $log->aset ?? '-' }}
        </td>
    </tr>
    @endforeach
</tbody>
</table>
    </div>

</div>
</x-app-layout>
