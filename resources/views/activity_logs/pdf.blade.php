<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        /* Tetapan asas PDF */
        body { font-family: DejaVu Sans; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 4px; }
        th { background: #eee; }
    </style>
</head>
<body>

<!-- Tajuk laporan -->
<h3>Log Aktiviti Sistem</h3>

<!-- Jadual log aktiviti -->
<table>
    <thead>
        <tr>
            <th>Tarikh</th>
            <th>Pengguna</th>
            <th>Aktiviti</th>
            <th>Tindakan</th>
            <th>Modul</th>
            <th>Aset</th>
        </tr>
    </thead>
    <tbody>
        <!-- Papar senarai log -->
        @foreach($logs as $log)
        <tr>
            <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
            <td>{{ $log->user->name ?? '-' }}</td>
            <td>{{ $log->aktiviti }}</td>
            <td>{{ $log->tindakan }}</td>
            <td>{{ $log->modul }}</td>
            <td>{{ $log->aset ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
