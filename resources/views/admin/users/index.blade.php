<x-app-layout>
<div class="px-6 py-6">

    <h1 class="text-xl font-bold mb-4">
        Senarai Pengguna
    </h1>

</div>
<div class="bg-white p-4 rounded-lg mb-4">
    <form method="GET" action="{{ route('admin.users.index') }}"
          class="flex items-center gap-3 max-w-xl">
        
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari nama / emel / peranan"
            class="flex-1 border rounded px-3 py-2"
        >

        <button
            type="submit"
            class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700">
            Cari
        </button>

        <a href="{{ route('admin.users.index') }}"
           class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
            Reset
        </a>
    </form>
</div>
    
    <table class="min-w-full bg-white border rounded">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-3 py-2">Bil.</th>
                <th class="border px-3 py-2">Nama</th>
                <th class="border px-3 py-2">Emel</th>
                <th class="border px-3 py-2">Peranan</th>
                <th class="border px-3 py-2">Tindakan</th>
            </tr>
        </thead>
        <tbody>
          @foreach ($users as $user)
<tr>
    <td class="px-3 py-2 text-center">
        {{ $loop->iteration }}
    </td>

    <td class="px-3 py-2">
        {{ $user->name }}
    </td>

    <td class="px-3 py-2">
        {{ $user->email }}
    </td>

    <td class="px-3 py-2">
        {{ $user->role }}
    </td>

    <td class="px-3 py-2">
        <a href="{{ route('admin.users.edit', $user) }}"
           class="text-blue-600 hover:underline">
            Edit
        </a>
    </td>
</tr>
@endforeach
        </tbody>
    </table>

</div>
</x-app-layout>
