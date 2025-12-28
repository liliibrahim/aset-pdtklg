{{-- LAPORAN ASET ICT – BAHAGIAN A (PDF) --}}

<head>
    <meta charset="utf-8">
    <title>Laporan Aset ICT – Bahagian A</title>
    
    {{-- Basic untuk cetakan PDF --}}
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        table { border-collapse: collapse; width: 100%; }
        td, th { border: 1px solid #000; padding: 3px 5px; vertical-align: top; }
        .no-border td { border: none; }
        .section-title { font-weight: bold; text-align: center; padding: 5px 0; }
    </style>
</head>
<body>

    {{-- Tajuk laporan rasmi --}}
    <h3 style="text-align:center; margin-bottom:10px;">
        PEJABAT DAERAH DAN TANAH KLANG<br>
        LAPORAN MAKLUMAT ASET ICT (BAHAGIAN A)
    </h3>

    {{-- Paparan maklumat utama aset --}}
    <table>
        <tr class="no-border">
            <td colspan="4"><strong>Bahagian / Cawangan:</strong> {{ $asset->bahagian }}</td>
        </tr>

        {{-- Penanda seksyen Bahagian A --}}
        <tr>
            <td colspan="4" class="section-title">BAHAGIAN A</td>
        </tr>

        {{-- Maklumat kategori dan pengenalan aset --}}
        <tr>
            <td style="width:25%;">Kategori Aset</td>
            <td style="width:25%;">{{ $asset->kategori }}</td>
            <td style="width:25%;">Kod Nasional</td>
            <td style="width:25%;"></td>
        </tr>

        {{-- Butiran jenama dan model --}}
        <tr>
            <td>Jenis / Jenama / Model</td>
            <td colspan="3">{{ $asset->jenama }} {{ $asset->model }}</td>
        </tr>

        {{-- Nombor siri aset --}}
        <tr>
            <td>No. Siri / No. Siri Pendaftaran</td>
            <td>{{ $asset->no_siri }}</td>
            <td>No. Siri Sub</td>
            <td>{{ $asset->no_siri_sub }}</td>
        </tr>

        {{-- Maklumat perolehan --}}
        <tr>
            <td>Harga Perolehan Asal (RM)</td>
            <td>{{ number_format($asset->harga, 2) }}</td>
            <td>Tarikh Perolehan</td>
            <td>{{ optional($asset->tarikh_perolehan)->format('d-m-Y') }}</td>
        </tr>

        {{-- Usia dan jaminan aset --}}
        <tr>
            <td>Usia Aset</td>
            <td>{{ $asset->usia_aset }}</td>
            <td>Tempoh Jaminan</td>
            <td></td>
        </tr>

        {{-- Sumber dan pembekal --}}
        <tr>
            <td>Sumber Perolehan</td>
            <td colspan="3">{{ $asset->sumber_perolehan }}</td>
        </tr>
        <tr>
            <td>Nama Pembekal / Alamat</td>
            <td colspan="3">{{ $asset->pembekal }}</td>
        </tr>

        {{-- Catatan tambahan aset --}}
        <tr>
            <td>Spesifikasi / Catatan</td>
            <td colspan="3">{{ $asset->catatan }}</td>
        </tr>
    </table>

    <br>

    {{-- Maklumat penempatan semasa aset --}}
    <table>
        <tr>
            <td colspan="4" class="section-title">PENEMPATAN</td>
        </tr>
        <tr>
            <td style="width:25%;">Lokasi</td>
            <td style="width:25%;">{{ $asset->bahagian }}</td>
            <td style="width:25%;">Unit</td>
            <td style="width:25%;">{{ $asset->unit }}</td>
        </tr>
        <tr>
            <td>Nama Pegawai</td>
            <td colspan="3">{{ $asset->nama_pengguna }}</td>
        </tr>
    </table>

    <br>

</body>
</html>
