<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 4px; }
        th { background: #eee; }
    </style>
</head>
<body>

<h3>Laporan Aset Rosak</h3>
<p>Jumlah Aset Rosak: {{ $jumlahRosak }}</p>

<table>
    <thead>
        <tr>
            <th>Bil</th>
            <th>Kategori</th>
            <th>Jenama</th>
            <th>Model</th>
            <th>No Siri</th>
            <th>Bahagian</th>
            <th>Unit</th>
        </tr>
    </thead>
    <tbody>
        @foreach($assets as $i => $a)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $a->kategori }}</td>
            <td>{{ $a->jenama }}</td>
            <td>{{ $a->model }}</td>
            <td>{{ $a->no_siri }}</td>
            <td>{{ $a->bahagian }}</td>
            <td>{{ $a->unit }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
