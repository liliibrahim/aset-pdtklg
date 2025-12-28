{{-- LAPORAN ASET USANG ICT (PDF) --}}
<html lang="ms">
<head>
<meta charset="UTF-8">
<title>Laporan Aset Usang ICT</title>

{{-- Basic untuk cetakan PDF --}}
<style>
body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
table { width: 100%; border-collapse: collapse; }
th, td { border: 1px solid #000; padding: 4px; }
th { background: #f0f0f0; }
.text-center { text-align: center; }
</style>
</head>

<body>

{{-- Tajuk laporan --}}
<h3 style="text-align:center;margin-bottom:5px;">
PEJABAT DAERAH DAN TANAH KLANG
</h3>

<p style="text-align:center;margin-top:0;">
<strong>LAPORAN ASET USANG ICT</strong>
</p>

{{-- Maklumat ringkas laporan --}}
<p>
Tarikh Cetakan: {{ now()->format('d/m/Y') }}<br>

{{-- Kriteria filter umur aset --}}
Kriteria:
@if(request('tahap') == 5)
Aset 5–6 Tahun
@elseif(request('tahap') == 7)
Aset 7 Tahun
@elseif(request('tahap') >= 8)
Aset ≥ 8 Tahun
@else
Semua Aset ≥ 5 Tahun
@endif
<br>

{{-- Jumlah rekod dipaparkan --}}
Jumlah Rekod: {{ $assets->count() }}
</p>

{{-- Jumlah rekod dipaparkan --}}
<table>
<thead>
<tr>
    <th>Bil</th>
    <th>Kategori</th>
    <th>Jenama</th>
    <th>Model</th>
    <th>No Siri</th>
    <th>Tarikh Perolehan</th>
    <th>Umur (Tahun)</th>
    <th>Bahagian</th>
    <th>Unit</th>
</tr>
</thead>
<tbody>

{{-- Papar senarai aset mengikut kriteria umur --}}
@forelse($assets as $i => $a)
<tr>
    <td class="text-center">{{ $i+1 }}</td>
    <td>{{ $a->kategori }}</td>
    <td>{{ $a->jenama }}</td>
    <td>{{ $a->model }}</td>
    <td>{{ $a->no_siri }}</td>

    {{-- Tarikh perolehan aset --}}
    <td class="text-center">
        {{ \Carbon\Carbon::parse($a->tarikh_perolehan)->format('d/m/Y') }}
    </td>

    {{-- Pengiraan umur aset --}}
    <td class="text-center">
        {{ \Carbon\Carbon::parse($a->tarikh_perolehan)->diffInYears(now()) }}
    </td>
    <td>{{ $a->bahagian }}</td>
    <td>{{ $a->unit }}</td>
</tr>
@empty
<tr>
    <td colspan="9" class="text-center">Tiada rekod</td>
</tr>
@endforelse
</tbody>
</table>

{{-- Nota sistem --}}
<p style="font-size:10px;margin-top:15px;text-align:center;">
Dokumen ini dijana secara automatik oleh Sistem Pemantauan Aset ICT.
</p>

</body>
</html>
