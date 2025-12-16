<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Laporan Aduan ICT</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header h3 {
            margin: 0;
            font-size: 14px;
            text-transform: uppercase;
        }

        .header p {
            margin: 2px 0;
            font-size: 11px;
        }

        .meta {
            margin-bottom: 10px;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 4px;
            vertical-align: top;
        }

        th {
            background-color: #f0f0f0;
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .badge {
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9px;
            color: #fff;
            display: inline-block;
        }

        .baru { background: #2563eb; }          /* biru */
        .dalam_tindakan { background: #d97706; }/* oren */
        .selesai { background: #16a34a; }        /* hijau */

        .footer {
            margin-top: 15px;
            font-size: 10px;
        }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <div class="header">
        <h3>Pejabat Daerah dan Tanah Klang</h3>
        <p>Sistem Pemantauan Aset ICT</p>
        <p><strong>Laporan Aduan ICT</strong></p>
    </div>

    {{-- MAKLUMAT CETAK --}}
    <div class="meta">
        <p>Tarikh Cetakan: {{ now()->format('d/m/Y') }}</p>
        <p>Jumlah Aduan: {{ $aduans->count() }}</p>
    </div>

    {{-- JADUAL ADUAN --}}
    <table>
        <thead>
            <tr>
                <th class="text-center">Bil</th>
                <th>No Aduan</th>
                <th>Tarikh Aduan</th>
                <th>Peralatan</th>
                <th>Masalah</th>
                <th>Bahagian</th>
                <th>Unit</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($aduans as $i => $a)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $a->id }}</td>
                    <td class="text-center">
                        {{ $a->created_at
                            ? $a->created_at->format('d/m/Y')
                            : '-' }}
                    </td>
                    <td>
                        {{ $a->asset->kategori ?? '-' }}
                        <br>
                        <small>
                            {{ $a->asset->jenama ?? '' }}
                            {{ $a->asset->model ?? '' }}
                        </small>
                    </td>
                    <td>{{ $a->deskripsi_masalah ?? '-' }}</td>
                    <td>{{ $a->asset->bahagian ?? '-' }}</td>
                    <td>{{ $a->asset->unit ?? '-' }}</td>
                    <td class="text-center">
                        <span class="badge {{ $a->status }}">
                            {{ ucfirst(str_replace('_', ' ', $a->status)) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">
                        Tiada rekod aduan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- FOOTER --}}
    <div class="footer">
        <p>
            Dokumen ini dijana secara automatik oleh Sistem Pemantauan Aset ICT
            dan tidak memerlukan tandatangan.
        </p>
    </div>

</body>
</html>
