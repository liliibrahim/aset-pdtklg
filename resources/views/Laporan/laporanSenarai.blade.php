{{-- LAPORAN SENARAI ASET ICT (PDF) --}}

<head>
    <meta charset="utf-8">
    <title>Laporan Senarai Aset ICT</title>

    {{-- Basic untuk cetakan PDF --}}
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; }
        table { border-collapse: collapse; width: 100%; }
        td, th { border: 1px solid #000; padding: 3px 4px; }
        th { background: #ddd; }
    </style>
</head>
<body>

    {{-- Tajuk laporan --}}
    <h3 style="text-align:center; margin-bottom:5px;">
        PEJABAT DAERAH DAN TANAH KLANG<br>
        LAPORAN SENARAI ASET ICT
    </h3>

    {{-- Ringkasan parameter filter laporan --}}
    <p style="font-size:9px;">
        Kategori: {{ $request->kategori ?: 'Semua' }} |
        Bahagian: {{ $request->bahagian ?: 'Semua' }} |
        Unit: {{ $request->unit ?: 'Semua' }} |
        Carian: {{ $request->q ?: '-' }}
    </p>

    {{-- Jadual senarai aset berdasarkan penapisan --}}
    <table>
        <tr>
            <th>Bil</th>
            <th>Kategori</th>
            <th>Jenama</th>
            <th>Model</th>
            <th>No Siri</th>
            <th>Bahagian</th>
            <th>Unit</th>
            <th>Pengguna</th>
            <th>Status</th>
            <th>Tarikh Perolehan</th>
        </tr>

        {{-- Papar senarai aset --}}
        @foreach ($assets as $i => $asset)
            <tr>
                <td style="text-align:center;">{{ $i + 1 }}</td>
                <td>{{ $asset->kategori }}</td>
                <td>{{ $asset->jenama }}</td>
                <td>{{ $asset->model }}</td>
                <td>{{ $asset->no_siri }}</td>
                <td>{{ $asset->bahagian }}</td>
                <td>{{ $asset->unit }}</td>
                <td>{{ $asset->nama_pengguna }}</td>

                {{-- Status aset (default Aktif jika tiada nilai) --}}
                <td>{{ $asset->status ?? 'Aktif' }}</td>

                {{-- Tarikh perolehan jika tersedia --}}
                <td>{{ optional($asset->tarikh_perolehan)->format('d-m-Y') }}</td>
            </tr>
        @endforeach
    </table>

</body>
</html>
