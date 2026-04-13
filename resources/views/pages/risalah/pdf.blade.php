<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Risalah Rapat</title>
    <style>
        * { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid black; padding: 6px; vertical-align: middle; }
        .page-break { page-break-before: always; }

        thead { display: table-header-group; }
        tfoot { display: table-footer-group; }
        tr, td, th { page-break-inside: avoid; }

        .no-split { page-break-inside: avoid; }

        /* Header */
        .header-logo-cell { width: 100px; text-align: center; padding: 6px; }
        .header-logo-cell img { width: 70px; object-fit: contain; display: block; margin: 0 auto; }
        .header-title-cell { text-align: center; font-weight: bold; font-size: 14px; }

        /* Section: Penjelasan + Kesimpulan */
        .section-header {
            background: #cfc9a5;
            font-weight: bold;
            padding: 6px;
            height: 24px;
            border: 1px solid black;
            border-bottom: none;
        }
        .section-content {
            border: 1px solid black;
            padding: 10px;
            border-top: none;   /* biar nyambung */
        }

        /* Checkbox */
        .checkbox { display: inline-block; width: 12px; height: 12px; border: 1px solid black; margin-right: 4px;
            vertical-align: middle; background: #f2f2f2; text-align: center; font-size: 11px; line-height: 12px; }
        .checkbox.checked::after { content: "X"; color: black; font-weight: bold; }

        /* Signature */
        .signature-block { margin-top: 40px; text-align: right; }
        .signature-name { text-decoration: underline; font-weight: bold; }

        /* Lampiran */
        .lampiran-title { text-align: center; font-weight: bold; margin-bottom: 6px; }

        .main-table { width: 100%; border-collapse: collapse; border: 1px solid black; margin-bottom: 10px; }
        .main-table td, .main-table th { border: 1px solid black; padding: 6px; vertical-align: middle; font-size: 12px; }
        .logo-cell { width: 120px; text-align: center; padding: 10px; }
        .logo-cell img { width: 90px; height: 90px; object-fit: contain; }
        .header-title { text-align: center; font-weight: bold; padding: 6px; font-size: 16px; text-transform: uppercase; }
        .info-label { width: 25%; text-align: left; font-weight: bold; white-space: nowrap; }
        .info-value { width: 65%; text-align: left; }
        .table-peserta { width: 100%; border-collapse: collapse; margin-top: 6px; }
        .table-peserta th, .table-peserta td { border: 1px solid black; padding: 6px; text-align: center; font-size: 12px; }
        .table-peserta td.text-left { text-align: left; }
    </style>
</head>
<body>
@php
    $path = public_path('assets/logo.png');
    $logo = null;
    if (file_exists($path)) {
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $logo = 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
@endphp

<!-- HEADER -->
<table>
    <tr>
        <td rowspan="4" class="header-logo-cell">
            @if ($logo)<img src="{{ $logo }}">@endif
        </td>
        <td colspan="2" class="header-title-cell">RISALAH RAPAT</td>
    </tr>
    <tr><td>Hari/Tanggal</td><td>: {{ \Carbon\Carbon::parse($risalah->tanggal)->translatedFormat('l, d F Y') }}</td></tr>
    <tr><td>Waktu</td><td>: {{ $risalah->waktu_mulai }} s.d Selesai</td></tr>
    <tr><td>Tempat</td><td>: {{ $risalah->tempat }}</td></tr>
</table>

<!-- INFO RAPAT -->
<table class="no-split">
    <tr><td>Agenda</td><td colspan="3">: {{ $risalah->agenda }}</td></tr>
    <tr><td>Pimpinan Rapat</td><td>: {{ $risalah->pimpinan }}</td><td>Pencatat Rapat</td><td>: {{ $risalah->pencatat }}</td></tr>
    <tr><td>Peserta Rapat</td><td colspan="3">: Daftar Hadir Terlampir</td></tr>
    <tr class="no-split">
        <td>Jenis Rapat</td>
        <td colspan="3" style="padding:0;">
            <table style="width:100%; border:none;">
                <tr>
                    <td style="border:none;"><span class="checkbox {{ $risalah->jenis_rapat == 'Entry Meeting' ? 'checked' : '' }}"></span> Entry Meeting</td>
                    <td style="border:none;"><span class="checkbox {{ $risalah->jenis_rapat == 'Expose Meeting' ? 'checked' : '' }}"></span> Expose Meeting</td>
                    <td style="border:none;"><span class="checkbox {{ $risalah->jenis_rapat == 'Exit Meeting' ? 'checked' : '' }}"></span> Exit Meeting</td>
                    <td style="border:none;"><span class="checkbox {{ $risalah->jenis_rapat == 'Lainnya' ? 'checked' : '' }}"></span> Lainnya</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<!-- PENJELASAN + KESIMPULAN -->
<div class="no-split">
    <div class="section-header">Penjelasan Rapat</div>
    <div class="section-content">
        {!! $risalah->penjelasan !!}
    </div>

    <div class="section-header" style="margin-top: 10px;">Kesimpulan</div>
    <div class="section-content">
        {!! $risalah->kesimpulan !!}
        <div class="signature-block">
            Jakarta, {{ \Carbon\Carbon::parse($risalah->tanggal)->translatedFormat('d F Y') }}<br>
            Pimpinan Rapat<br><br><br>
            <span class="signature-name">{{ $risalah->pimpinan }}</span><br>
            Ka SPI
        </div>
    </div>
</div>

<!-- PAGE BREAK -->
<div class="page-break"></div>

<!-- LAMPIRAN DAFTAR HADIR -->
<div class="no-split">
    <div class="lampiran-title">Lampiran : Daftar Hadir</div>

    <table class="main-table">
        <tr>
            <td class="logo-cell" rowspan="5">
                @if ($logo)<img src="{{ $logo }}">@endif
            </td>
            <td colspan="2" class="header-title">DAFTAR HADIR</td>
        </tr>
        <tr><td class="info-label">Agenda / Kegiatan :</td><td class="info-value">{{ $risalah->agenda }}</td></tr>
        <tr><td class="info-label">Hari / Tanggal :</td><td class="info-value">{{ \Carbon\Carbon::parse($risalah->tanggal)->translatedFormat('l, d F Y') }}</td></tr>
        <tr><td class="info-label">Waktu :</td><td class="info-value">{{ $risalah->waktu_mulai }} - Selesai</td></tr>
        <tr><td class="info-label">Tempat :</td><td class="info-value">{{ $risalah->tempat }}</td></tr>
    </table>

    <table class="table-peserta">
        <thead>
            <tr>
                <th width="30">No</th>
                <th>Nama</th>
                <th width="60">NP</th>
                <th>Jabatan</th>
                <th>Unit Kerja / Instansi</th>
                <th width="120">Tanda Tangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($presenceDetails as $detail)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-left">{{ $detail->nama }}</td>
                    <td>{{ $detail->np }}</td>
                    <td class="text-left">{{ $detail->jabatan }}</td>
                    <td class="text-left">{{ $detail->asal_instansi }}</td>
                    <td>
                        @if ($detail->tanda_tangan)
                            @php
                                $ttdPath = public_path('uploads/' . $detail->tanda_tangan);
                                $ttdBase64 = file_exists($ttdPath)
                                    ? 'data:image/' . pathinfo($ttdPath, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($ttdPath))
                                    : null;
                            @endphp
                            @if ($ttdBase64)<img src="{{ $ttdBase64 }}" style="max-width: 100%; max-height:40px;">@endif
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">Tidak ada data peserta.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

</body>
</html>
