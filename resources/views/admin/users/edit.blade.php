<x-app-layout>
<div class="px-6 py-6 max-w-xl">

    {{-- Tajuk halaman --}}
    <h1 class="text-xl font-bold mb-4">
        Edit Pengguna (Pentadbir)
    </h1>

    {{-- Borang kemas kini peranan pengguna --}}
    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PUT')

        {{-- Papar nama pengguna --}}
        <div class="mb-4">
            <label class="block text-sm font-semibold">Nama</label>
            <input type="text"
                   value="{{ $user->name }}"
                   disabled
                   class="w-full border rounded px-3 py-2 bg-gray-100">
        </div>

        {{-- Pilih peranan pengguna --}}
        <div class="mb-4">
            <label class="block text-sm font-semibold">Peranan</label>
            <select name="role"
                    class="w-full border rounded px-3 py-2">
                <option value="user" @selected($user->role=='user')>Pengguna</option>
                <option value="ict" @selected($user->role=='ict')>Pegawai ICT</option>
                <option value="admin" @selected($user->role=='admin')>Pentadbir Sistem</option>
            </select>
        </div>

        {{-- Butang simpan dan kembali --}}
        <div class="flex gap-3">
            <button class="px-4 py-2 bg-blue-600 text-white rounded">
                Simpan
            </button>

            <a href="{{ route('admin.users.index') }}"
               class="px-4 py-2 bg-gray-300 rounded">
                Kembali
            </a>
        </div>

    </form>
</div>
</x-app-layout>
