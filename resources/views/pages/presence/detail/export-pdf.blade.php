<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Daftar Hadir</title>
  <style>
    * {
      box-sizing: border-box;
      font-family: Arial, sans-serif;
      font-size: 15px;
    }

    @page {
      size: A4 portrait;
      margin: 1cm;
    }

    @media print {
      body {
        -webkit-print-color-adjust: exact;
      }
    }

    .main-table {
      width: 100%;
      border-collapse: collapse;
      border: 1px solid black;
      margin-bottom: 20px;
    }

    .main-table td,
    .main-table th {
      border: 1px solid black;
      padding: 6px;
      vertical-align: top;
    }

    .logo-cell {
      width: 150px;
      text-align: center;
      padding: 20px;
    }

    .logo-cell img {
      width: 150px;
      height: 150px;
      object-fit: contain;
      margin-top: 10px;
    }

    .header-title {
      text-align: center;
      font-weight: bold;
      padding: 6px;
      border-bottom: 1px solid black;
      font-size: 22px;
      text-transform: uppercase;
    }

    .info-label {
      width: 20%;
      text-align: left;
      font-weight: bold;
    }

    .info-value {
      width: 65%;
      text-align: left;
    }

    .table-peserta {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    .table-peserta th,
    .table-peserta td {
      border: 1px solid black;
      padding: 8px;
      text-align: center;
    }

    .table-peserta td.text-left {
      text-align: left;
    }

    .bukti-container {
      margin-top: 30px;
      text-align: center;
    }

    .bukti-container h4 {
      margin-bottom: 10px;
    }

    .bukti-container img {
      max-width: 100%;
      max-height: 600px;
    }
  </style>
</head>
<body>

  @php
    $path = public_path('assets/logo.png');
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $logo = 'data:image/' . $type . ';base64,' . base64_encode($data);
  @endphp

  <!-- HEADER -->
  <table class="main-table">
    <tr>
      <td class="logo-cell" rowspan="5">
        <img src="{{ $logo }}">
      </td>
      <td colspan="2" class="header-title">DAFTAR HADIR</td>
    </tr>
    <tr>
      <td class="info-label">Agenda / Kegiatan :</td>
      <td class="info-value">{{ $presence->nama_kegiatan ?? '' }}</td>
    </tr>
    <tr>
      <td class="info-label">Hari / Tanggal :</td>
      <td class="info-value">{{ \Carbon\Carbon::parse($presence->tgl_kegiatan)->translatedFormat('l, d F Y') }}</td>
    </tr>
    <tr>
      <td class="info-label">Waktu :</td>
      <td class="info-value">{{ date('H:i', strtotime($presence->tgl_kegiatan)) }} - s.d Selesai</td>
    </tr>
    <tr>
      <td class="info-label">Tempat :</td>
      <td class="info-value">{{ $presence->tempat ?? '-' }}</td>
    </tr>
  </table>

  <!-- TABEL PESERTA -->
  <table class="table-peserta">
    <thead>
      <tr>
        <th width="20">No</th>
        <th>Nama</th>
        <th width="30">NP</th>
        <th>Jabatan</th>
        <th>Unit Kerja / Instansi</th>
        <th width="120">Tanda Tangan</th>
      </tr>
    </thead>
    <tbody>
      @if ($presenceDetails->isEmpty())
        <tr>
          <td colspan="6">Tidak ada data</td>
        </tr>
      @endif

      @foreach ($presenceDetails as $detail)
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
                $ttdType = pathinfo($ttdPath, PATHINFO_EXTENSION);
                $ttdData = file_get_contents($ttdPath);
                $ttdBase64 = 'data:image/' . $ttdType . ';base64,' . base64_encode($ttdData);
              @endphp
              <img src="{{ $ttdBase64 }}" style="max-width: 100%; max-height:40px;">
            @endif
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <!-- GAMBAR BUKTI KEGIATAN -->
  @if ($buktiPath && file_exists($buktiPath))
    @php
      $buktiType = pathinfo($buktiPath, PATHINFO_EXTENSION);
      $buktiData = file_get_contents($buktiPath);
      $buktiBase64 = 'data:image/' . $buktiType . ';base64,' . base64_encode($buktiData);
    @endphp
    <div class="bukti-container">
      <h4>Bukti Kegiatan</h4>
      <img src="{{ $buktiBase64 }}">
    </div>
  @endif

</body>
</html>
