<x-app-layout>

<div class="px-6 py-6">

    {{-- TAJUK --}}
    <h1 class="text-lg font-bold text-gray-800 mb-6">
        DASHBOARD – PEGAWAI ICT
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-stretch">

        {{-- ================= LEFT ================= --}}
        <div class="col-span-9">

            {{-- STATISTIK --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">

                <div class="bg-white p-5 shadow rounded-xl">
                    <h3 class="text-sm text-gray-700">JUMLAH KESELURUHAN</h3>
                    <p class="text-3xl font-bold mt-2 text-blue-700">{{ $totalAset }}</p>
                </div>

                <div class="bg-white p-5 shadow rounded-xl">
                    <h3 class="text-sm text-gray-700">AKTIF DIGUNAKAN</h3>
                    <p class="text-3xl font-bold mt-2 text-green-600">{{ $digunakan }}</p>
                </div>

                <div class="bg-white p-5 shadow rounded-xl">
                    <h3 class="text-sm text-gray-700">ROSAK</h3>
                    <p class="text-3xl font-bold mt-2 text-red-600">{{ $rosak }}</p>
                </div>

                <div class="bg-white p-5 shadow rounded-xl">
                    <h3 class="text-sm text-gray-700">TANPA PENEMPATAN</h3>
                    <p class="text-3xl font-bold mt-2 text-orange-600">{{ $tanpaPenempatan }}</p>
                </div>

            </div>

            {{-- FILTER + CHART --}}
            <div class="bg-white p-6 shadow rounded-xl">

                <h2 class="font-bold text-lg mb-2">
                    📊 Analisis Aset Berdasarkan Filter
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-6 gap-4 mb-6">
                    <div>
                        <label class="text-xs font-semibold">Bahagian</label>
                        <select id="filterBahagian" class="border p-2 rounded w-full text-xs">
                            <option value="">Semua</option>
                            @foreach ($bahagianLabels as $b)
                                <option value="{{ $b }}">{{ $b }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-xs font-semibold">Unit</label>
                        <select id="filterUnit" class="border p-2 rounded w-full text-xs" disabled>
                            <option value="">Semua</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-xs font-semibold">Tahun</label>
                        <select id="filterTahun" class="border p-2 rounded w-full text-xs">
                            <option value="">Semua</option>
                            @foreach ($tahunLabels as $t)
                                <option value="{{ $t }}">{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-xs font-semibold">Jenama</label>
                        <select id="filterJenama" class="border p-2 rounded w-full text-xs">
                            <option value="">Semua</option>
                            @foreach ($jenamas as $j)
                                <option value="{{ $j }}">{{ $j }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-xs font-semibold">Pembekal</label>
                        <select id="filterPembekal" class="border p-2 rounded w-full text-xs">
                            <option value="">Semua</option>
                            @foreach ($pembekals as $p)
                                <option value="{{ $p }}">{{ $p }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-xs font-semibold">Sumber</label>
                        <select id="filterSumber" class="border p-2 rounded w-full text-xs">
                            <option value="">Semua</option>
                            @foreach ($sumbers as $s)
                                <option value="{{ $s }}">{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <canvas id="mainChart" height="120"></canvas>
            </div>
        </div>

        {{-- ================= RIGHT ================= --}}
        <div class="col-span-3 flex">
            <div class="bg-white p-6 rounded-xl shadow w-full flex flex-col">

                {{-- INSIGHT --}}
                <div class="mb-4 p-4 rounded-lg border border-indigo-700
                            bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                    <h3 class="text-sm font-semibold mb-1">🔍 Insight Sistem</h3>
                    <p class="text-sm opacity-90">
                        Sistem mengenal pasti <strong>{{ $lebih8 }}</strong> aset
                        berusia <strong>9 tahun dan ke atas</strong> yang disyorkan
                        untuk penggantian atau pelupusan.
                        Terdapat juga <strong>{{ $tanpaPenempatan }}</strong>
                        aset tanpa penempatan aktif.
                    </p>
                </div>

                <hr class="my-4 border-gray-300">

                <div class="mb-4">
                    <h2 class="text-lg font-bold text-gray-800">
                        🕒 Umur Aset
                    </h2>
                    <p class="text-sm text-gray-500">
                        Predictive Replacement
                    </p>
                </div>

                <div class="space-y-8 mb-12">

    {{-- AKAN USANG --}}
    <a href="{{ route('ict.assets.index', ['usia' => 5]) }}" class="block">
    <div class="flex justify-between items-center bg-yellow-200 hover:bg-yellow-300 rounded-xl px-5 py-5 mb-4">
        <div class="text-sm font-semibold">
            Akan Usang<br>
            <span class="text-xs text-gray-600">(6–7 tahun)</span>
        </div>
        <div class="bg-white text-yellow-700 w-14 h-14 flex items-center justify-center rounded-lg font-bold">
            {{ $lebih5 }}
        </div>
    </div>
</a>


    {{-- WAJAR DINILAI --}}
    <a href="{{ route('ict.assets.index', ['usia' => 7]) }}" class="block">
    <div class="flex justify-between items-center bg-orange-200 hover:bg-orange-300 rounded-xl px-5 py-5 mb-4">
        <div class="text-sm font-semibold">
            Wajar Dinilai Pelupusan<br>
            <span class="text-xs text-gray-600">(8 tahun)</span>
        </div>
        <div class="bg-white text-orange-700 w-14 h-14 flex items-center justify-center rounded-lg font-bold">
            {{ $lebih7 }}
        </div>
    </div>
</a>

    {{-- DISYORKAN GANTI --}}
    <a href="{{ route('ict.assets.index', ['usia' => 8]) }}" class="block">
    <div class="flex justify-between items-center bg-red-200 hover:bg-red-300 rounded-xl px-5 py-5">
        <div class="text-sm font-semibold">
            Disyorkan Ganti Tahun Ini<br>
            <span class="text-xs text-gray-600">(≥ 9 tahun)</span>
        </div>
        <div class="bg-white text-red-700 w-14 h-14 flex items-center justify-center rounded-lg font-bold">
            {{ $lebih8 }}
        </div>
    </div>
</a>

</div>
            </div>
        </div>
    </div>
</div>

{{-- ================= SCRIPTS ================= --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

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
            scales: { y: { beginAtZero: true } }
        }
    });

    function updateMainChart() {

        let params = {
            bahagian: filterBahagian.value,
            unit: filterUnit.value,
            tahun: filterTahun.value,
            jenama: filterJenama.value,
            pembekal: filterPembekal.value,
            sumber: filterSumber.value,
        };

        fetch("{{ route('ict.dashboard.filter') }}?" + new URLSearchParams(params))
            .then(res => res.json())
            .then(data => {
                mainChart.data.labels = data.labels;
                mainChart.data.datasets[0].data = data.counts;
                mainChart.update();
            });
    }

    document.querySelectorAll("select").forEach(sel => {
        sel.addEventListener("change", updateMainChart);
    });

    updateMainChart();
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const filterBahagian = document.getElementById('filterBahagian');
    const filterUnit = document.getElementById('filterUnit');

    filterBahagian.addEventListener('change', function () {

        filterUnit.innerHTML = '<option value="">Semua Unit</option>';
        filterUnit.disabled = true;

        if (!this.value) return;

        fetch(@json(route('ict.getUnitsByBahagian')) + '?bahagian=' + this.value)
            .then(res => res.json())
            .then(units => {

                if (!units.length) return;

                units.forEach(unit => {
                    let opt = document.createElement('option');
                    opt.value = unit;
                    opt.textContent = unit;
                    filterUnit.appendChild(opt);
                });

                filterUnit.disabled = false;
            });
    });
});
</script>

</x-app-layout>
