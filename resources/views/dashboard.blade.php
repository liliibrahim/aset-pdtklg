<x-app-layout>
    <div class="px-6 py-6">

        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            Dashboard — Pegawai ICT
        </h1>

    {{-- AI INSIGHT BOX --}}
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white p-6 rounded-xl shadow mb-6">
            <h2 class="text-xl font-semibold mb-2">🔍 Insight Sistem</h2>
            <p class="text-sm opacity-90">
                Sistem mendapati 
                <strong>{{ $lebih8 }}</strong> aset berumur lebih 8 tahun. 
                Disyorkan dinilai untuk pelupusan.
                <br>
                Terdapat <strong>{{ $tanpaPenempatan }}</strong> aset tanpa penempatan yang perlu disahkan lokasi.
            </p>
        </div>

        {{-- STATISTIK RINGKAS --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white p-6 shadow rounded-xl">
                <h3 class="text-sm text-gray-500">JUMLAH KESELURUHAN</h3>
                <p class="text-3xl font-bold mt-2 text-blue-700">{{ $totalAset }}</p>
            </div>

            <div class="bg-white p-6 shadow rounded-xl">
                <h3 class="text-sm text-gray-500">AKTIF DIGUNAKAN</h3>
                <p class="text-3xl font-bold mt-2 text-green-600">{{ $digunakan }}</p>
            </div>

            <div class="bg-white p-6 shadow rounded-xl">
                <h3 class="text-sm text-gray-500">ROSak</h3>
                <p class="text-3xl font-bold mt-2 text-red-600">{{ $rosak }}</p>
            </div>

            <div class="bg-white p-6 shadow rounded-xl">
                <h3 class="text-sm text-gray-500">TANPA PENEMPATAN</h3>
                <p class="text-3xl font-bold mt-2 text-orange-600">{{ $tanpaPenempatan }}</p>
            </div>
        </div>

        {{-- LEADERBOARD UMUR ASET --}}
        <div class="bg-white p-6 shadow rounded-xl mb-6">
            <h2 class="font-bold text-lg mb-4">⏳ Umur Aset (Predictive Replacement)</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-4 bg-yellow-100 rounded-lg">
                    <h3 class="text-gray-600 text-sm">Akan Usang ( > 5 tahun )</h3>
                    <p class="text-xl font-bold text-yellow-700">{{ $lebih5 }}</p>
                </div>

                <div class="p-4 bg-orange-100 rounded-lg">
                    <h3 class="text-gray-600 text-sm">Wajar Dinilai Pelupusan ( > 7 tahun )</h3>
                    <p class="text-xl font-bold text-orange-700">{{ $lebih7 }}</p>
                </div>

                <div class="p-4 bg-red-100 rounded-lg">
                    <h3 class="text-gray-600 text-sm">Disyorkan Ganti Tahun Ini ( > 8 tahun )</h3>
                    <p class="text-xl font-bold text-red-700">{{ $lebih8 }}</p>
                </div>
            </div>
        </div>

        {{-- GRAF STATUS ASET --}}
        <div class="bg-white p-6 shadow rounded-xl mb-6">
            <h2 class="font-bold text-lg mb-4">📊 Status Aset</h2>
            <canvas id="statusChart"></canvas>
        </div>

        {{-- GRAF BAHAGIAN --}}
        <div class="bg-white p-6 shadow rounded-xl mb-6">
            <h2 class="font-bold text-lg mb-4">🏢 Aset Mengikut Bahagian</h2>
            <canvas id="bahagianChart"></canvas>
        </div>

        {{-- GRAF TAHUN PEROLEHAN --}}
        <div class="bg-white p-6 shadow rounded-xl mb-6">
            <h2 class="font-bold text-lg mb-4">📅 Mengikut Tahun Perolehan</h2>
            <canvas id="tahunChart"></canvas>
        </div>

        {{-- SENARAI ASET TERKINI --}}
        <div class="bg-white p-6 shadow rounded-xl">
            <h2 class="font-bold text-lg mb-4">Senarai Aset ICT Terkini</h2>

            @if ($senaraiAset->count() > 0)
                <table class="table-auto w-full text-sm">
                    <thead class="border-b font-semibold bg-gray-50">
                        <tr>
                            <th class="py-2 text-left">No Siri</th>
                            <th class="py-2 text-left">Kategori</th>
                            <th class="py-2 text-left">Jenama</th>
                            <th class="py-2 text-left">Status</th>
                            <th class="py-2 text-left">Tindakan</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($senaraiAset as $a)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-2">{{ $a->no_siri }}</td>
                                <td>{{ $a->kategori }}</td>
                                <td>{{ $a->jenama }}</td>
                                <td>{{ $a->status }}</td>
                                <td>
                                    <a href="{{ route('ict.assets.show', $a->id) }}"
                                       class="text-blue-600 hover:underline">
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            @else
                <p class="text-gray-500">Tiada aset direkodkan.</p>
            @endif
        </div>

    </div>


<script>
    // Pie Chart
    new Chart(document.getElementById('statusChart'), {
        type: 'pie',
        data: {
            labels: ['Aktif', 'Rosak', 'Pelupusan'],
            datasets: [{
                data: [{{ $digunakan }}, {{ $rosak }}, {{ $pelupusan }}],
                backgroundColor: ['#1e90ff','#ff4d4d','#ffaa00']
            }]
        }
    });

    // Bar Chart Bahagian
    new Chart(document.getElementById('bahagianChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($bahagianLabels) !!},
            datasets: [{
                label: 'Bilangan Aset',
                data: {!! json_encode($bahagianCounts) !!},
                backgroundColor: '#6366F1'
            }]
        }
    });

    // Bar Chart Tahun Perolehan
    new Chart(document.getElementById('tahunChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($tahunLabels) !!},
            datasets: [{
                label: 'Jumlah Aset',
                data: {!! json_encode($tahunCounts) !!},
                backgroundColor: '#10B981'
            }]
        }
    });
</script>

</x-app-layout>
