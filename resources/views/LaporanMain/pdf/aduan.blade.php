{{-- LAPORAN ADUAN ICT (PDF) --}}

<head>
    <meta charset="utf-8">
    <title>Laporan Aduan ICT</title>

    {{-- Basic untuk cetakan PDF --}}
    <style>
        body {font-family: DejaVu Sans, sans-serif;font-size: 11px;}
        h2 {margin-bottom: 6px;}
        .ringkasan {margin-bottom: 10px;}
        table {width: 100%;border-collapse: collapse;}
        th, td {border: 1px solid #000;padding: 6px;vertical-align: top;}
        th {background-color: #f0f0f0;text-align: left;}
    </style>
</head>
<body>

    {{-- Tajuk laporan --}}
    <h2>Laporan Aduan ICT</h2>

    {{-- Ringkasan jumlah aduan --}}
    <div class="ringkasan">
        <strong>Jumlah Aduan:</strong> {{ $ringkasan['jumlah'] }}
    </div>

    {{-- Jadual senarai aduan --}}
    <table>
        <thead>
            <tr>
                <th width="5%">Bil</th>
                <th width="15%">Aset</th>
                <th width="20%">Jenis Aduan</th>
                <th width="30%">Keterangan Aduan</th>
                <th width="15%">Status</th>
                <th width="15%">Tarikh</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($aduans as $a)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $a->asset->no_siri ?? '-' }}</td>
                    <td>{{ $a->jenis_aduan }}</td>
                    <td>{{ $a->keterangan }}</td>
                    <td>{{ $a->status }}</td>
                    <td>{{ $a->created_at?->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center">
                        Tiada rekod aduan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
