<x-app-layout>
    <div class="px-6 py-6">

        {{-- Tajuk --}}
        <h1 class="text-l font-bold text-gray-800 mb-6">
            DASHBOARD - PEGAWAI ICT
        </h1>  

             {{-- INSIGHT --}}
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white p-3 rounded-xl shadow mb-6">
            <h2 class="text-xl font-semibold mb-2">🔍 Insight Sistem</h2>
            <p class="text-sm opacity-90">
                Sistem mendapati <strong>{{ $lebih8 }}</strong> aset berumur lebih 8 tahun.
                Disyorkan dinilai untuk pelupusan. Terdapat <strong>{{ $tanpaPenempatan }}</strong> aset tanpa penempatan.
            </p>
        </div>

        {{-- ============================== --}}
        {{--      LAYOUT 2 KOLOM           --}}
        {{-- ============================== --}}
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">

            {{-- ============================== --}}
            {{--         LEFT CONTENT           --}}
            {{-- ============================== --}}
            <div class="col-span-9">

                {{-- STATISTIK KAD 4 --}}
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">

                    <div class="bg-white p-5 shadow rounded-xl">
                        <h3 class="text-sm text-gray-800">JUMLAH KESELURUHAN</h3>
                        <p class="text-3xl font-bold mt-2 text-blue-700">{{ $totalAset }}</p>
                    </div>

                    <div class="bg-white p-5 shadow rounded-xl">
                        <h3 class="text-sm text-gray-800">AKTIF DIGUNAKAN</h3>
                        <p class="text-3xl font-bold mt-2 text-green-600">{{ $digunakan }}</p>
                    </div>

                    <div class="bg-white p-5 shadow rounded-xl">
                        <h3 class="text-sm text-gray-800">ROSAK</h3>
                        <p class="text-3xl font-bold mt-2 text-red-600">{{ $rosak }}</p>
                    </div>

                    <div class="bg-white p-5 shadow rounded-xl">
                        <h3 class="text-sm text-gray-800">TANPA PENEMPATAN</h3>
                        <p class="text-3xl font-bold mt-2 text-orange-600">{{ $tanpaPenempatan }}</p>
                    </div>

                </div>
               
                {{-- UMUR ASET --}}
                <div class="bg-white p-6 rounded-xl shadow mb-6">
    <h2 class="text-lg font-bold mb-4">🕒 Umur Aset (Predictive Replacement)</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- > 5 Tahun --}}
        <a href="{{ route('ict.assets.index', ['usia' => 5]) }}" class="block">
            <div class="p-4 bg-yellow-100 rounded-lg shadow hover:bg-yellow-200 transition h-full">
                <h3 class="text-gray-700 text-sm font-semibold">Akan Usang ( > 5 tahun )</h3>
                <p class="text-2xl font-bold text-yellow-700 mt-2">{{ $lebih5 }}</p>
            </div>
        </a>

        {{-- > 7 Tahun --}}
        <a href="{{ route('ict.assets.index', ['usia' => 7]) }}" class="block">
            <div class="p-4 bg-orange-100 rounded-lg shadow hover:bg-orange-200 transition h-full">
                <h3 class="text-gray-700 text-sm font-semibold">Wajar Dinilai Pelupusan ( > 7 tahun )</h3>
                <p class="text-2xl font-bold text-orange-700 mt-2">{{ $lebih7 }}</p>
            </div>
        </a>

        {{-- > 8 Tahun --}}
        <a href="{{ route('ict.assets.index', ['usia' => 8]) }}" class="block">
            <div class="p-4 bg-red-100 rounded-lg shadow hover:bg-red-200 transition h-full">
                <h3 class="text-gray-700 text-sm font-semibold">Disyorkan Ganti Tahun Ini ( > 8 tahun )</h3>
                <p class="text-2xl font-bold text-red-700 mt-2">{{ $lebih8 }}</p>
            </div>
        </a>

    </div>
</div>

                {{-- CHART UTAMA --}}
                <div class="bg-white p-6 shadow rounded-xl mb-6">
                    <h2 class="font-bold text-lg mb-4">📊 Analisis Aset Berdasarkan Filter</h2>
                    <canvas id="mainChart" height="120"></canvas>
                </div>

            </div> {{-- END LEFT --}}

            {{-- ============================== --}}
            {{--        RIGHT SIDEBAR          --}}
            {{-- ============================== --}}
            <div class="col-span-3">

                <div class="bg-white p-6 rounded-xl shadow space-y-4">

                    <h2 class="font-bold mb-3">🔎 Filter</h2>

                    {{-- 1st row --}}
                    <div>
                        <label class="font-semibold text-sm">Bahagian</label>
                        <select id="filterBahagian" class="border p-2 rounded w-full">
                            <option value="">Semua Bahagian</option>
                            @foreach ($bahagianLabels as $b)
                                <option value="{{ $b }}">{{ $b }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="font-semibold text-sm">Unit</label>
                        <select id="filterUnit" class="border p-2 rounded w-full">
                            <option value="">Semua Unit</option>
                            @foreach ($units as $u)
                                <option value="{{ $u }}">{{ $u }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="font-semibold text-sm">Tahun Perolehan</label>
                        <select id="filterTahun" class="border p-2 rounded w-full">
                            <option value="">Semua Tahun</option>
                            @foreach ($tahunLabels as $t)
                                <option value="{{ $t }}">{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- 2nd row --}}
                    <div>
                        <label class="font-semibold text-sm">Jenama</label>
                        <select id="filterJenama" class="border p-2 rounded w-full">
                            <option value="">Semua Jenama</option>
                            @foreach ($jenamas as $j)
                                <option value="{{ $j }}">{{ $j }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="font-semibold text-sm">Pembekal</label>
                        <select id="filterPembekal" class="border p-2 rounded w-full">
                            <option value="">Semua Pembekal</option>
                            @foreach ($pembekals as $p)
                                <option value="{{ $p }}">{{ $p }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="font-semibold text-sm">Sumber</label>
                        <select id="filterSumber" class="border p-2 rounded w-full">
                            <option value="">Semua Sumber</option>
                            @foreach ($sumbers as $s)
                                <option value="{{ $s }}">{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

            </div>
        </div>

    </div>

    {{-- ========================== --}}
    {{--   SCRIPT MAIN CHART        --}}
    {{-- ========================== --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {

        // CREATE MAIN CHART
        let ctx = document.getElementById('mainChart').getContext('2d');

        let mainChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: "Jumlah Aset",
                    data: [],
                    backgroundColor: '#4F46E5'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // FUNCTION UPDATE CHART
        function updateMainChart() {

            let params = {
                bahagian: document.getElementById('filterBahagian').value,
                unit: document.getElementById('filterUnit').value,
                tahun: document.getElementById('filterTahun').value,
                jenama: document.getElementById('filterJenama').value,
                pembekal: document.getElementById('filterPembekal').value,
                sumber: document.getElementById('filterSumber').value,
            };

            fetch("{{ route('ict.dashboard.filter') }}?" + new URLSearchParams(params))
                .then(res => res.json())
                .then(data => {

                    // Backend must return:
                    // data.labels = [...]
                    // data.counts = [...]

                    mainChart.data.labels = data.labels;
                    mainChart.data.datasets[0].data = data.counts;
                    mainChart.update();
                });
        }

        // Update when filter changes
        document.querySelectorAll("select").forEach(sel => {
            sel.addEventListener("change", updateMainChart);
        });

        // First load
        updateMainChart();

    });
    </script>

</x-app-layout>
