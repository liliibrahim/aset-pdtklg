{{-- resources/views/laporan/laporanB.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Aset ICT – Bahagian B</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; }
        table { border-collapse: collapse; width: 100%; }
        td, th { border: 1px solid #000; padding: 3px 4px; }
        th { background: #ddd; text-align:center; }
    </style>
</head>
<body>

    <h3 style="text-align:center; margin-bottom:10px;">
        BUTIR-BUTIR ASAL / PENAMBAHAN / NAIK TARAF / PENGGANTIAN<br>
        BAHAGIAN B – ASET: {{ $asset->jenama }} {{ $asset->model }} ({{ $asset->no_siri }})
    </h3>

    <table>
        <tr>
            <th>Bil.</th>
            <th>No. Siri Pendaftaran Komponen</th>
            <th>Jenis / Jenama / Model</th>
            <th>Kos (RM)</th>
            <th>Tempoh Jaminan</th>
            <th>Asal / Tambah / Naik Taraf / Penggantian</th>
            <th>Tarikh Dipasang</th>
            <th>Tarikh Dikeluarkan</th>
            <th>Tarikh Dilupus / Dihapus Kira</th>
            <th>Catatan</th>
            <th>Nama Pegawai</th>
        </tr>

        @forelse ($komponen as $index => $row)
            <tr>
                <td style="text-align:center;">{{ $index + 1 }}</td>
                <td>{{ $row->no_siri_komponen }}</td>
                <td>{{ $row->jenis_model }}</td>
                <td style="text-align:right;">{{ number_format($row->kos, 2) }}</td>
                <td>{{ $row->tempoh_jaminan }}</td>
                <td>{{ $row->jenis_perubahan }}</td>
                <td>{{ optional($row->tarikh_dipasang)->format('d-m-Y') }}</td>
                <td>{{ optional($row->tarikh_dikeluarkan)->format('d-m-Y') }}</td>
                <td>{{ optional($row->tarikh_dihapus)->format('d-m-Y') }}</td>
                <td>{{ $row->catatan }}</td>
                <td>{{ $row->nama_pegawai }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="11" style="text-align:center;">Tiada rekod komponen / naik taraf direkodkan.</td>
            </tr>
        @endforelse
    </table>

</body>
</html>
