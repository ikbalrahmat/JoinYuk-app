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
      vertical-align: middle;
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
    $headerConfig = is_string($presence->header_config) ? json_decode($presence->header_config, true) : $presence->header_config;
    
    $showDate = $headerConfig['show_date'] ?? true;
    $showTime = $headerConfig['show_time'] ?? true;
    $showLocation = $headerConfig['show_location'] ?? true;
    
    // Default logoOption if not set
    $logoOpt = isset($logoOption) ? $logoOption : 'both';
    
    // Fetch base64 regardless of selection first to check availability
    $actualLogoLeft = null;
    if (!empty($headerConfig['logo_left'])) {
        $path = public_path('storage/' . $headerConfig['logo_left']);
        if (file_exists($path)) {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $actualLogoLeft = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
    }

    $actualLogoRight = null;
    if (!empty($headerConfig['logo_right'])) {
        $path = public_path('storage/' . $headerConfig['logo_right']);
        if (file_exists($path)) {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $actualLogoRight = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
    }

    // Filter based on user selection
    $logosToDisplay = [];
    if ($actualLogoLeft && in_array($logoOpt, ['both', 'left'])) {
        $logosToDisplay[] = $actualLogoLeft;
    }
    if ($actualLogoRight && in_array($logoOpt, ['both', 'right'])) {
        $logosToDisplay[] = $actualLogoRight;
    }

    // Always fill the left slot first!
    $displayLogoLeft = $logosToDisplay[0] ?? null;
    $displayLogoRight = $logosToDisplay[1] ?? null;

    // Calculate rowspan for logo cells
    $rowspan = 2 + ($showDate ? 1 : 0) + ($showTime ? 1 : 0) + ($showLocation ? 1 : 0);
  @endphp

  <!-- HEADER -->
  <table class="main-table">
    <tr>
      @if($displayLogoLeft)
      <td class="logo-cell" rowspan="{{ $rowspan }}">
        <img src="{{ $displayLogoLeft }}">
      </td>
      @endif

      <td colspan="2" class="header-title">DAFTAR HADIR</td>

      @if($displayLogoRight)
      <td class="logo-cell" rowspan="{{ $rowspan }}">
        <img src="{{ $displayLogoRight }}">
      </td>
      @endif
    </tr>
    <tr>
      <td class="info-label">Agenda / Kegiatan :</td>
      <td class="info-value">{{ $presence->nama_kegiatan ?? '' }}</td>
    </tr>
    @if($showDate)
    <tr>
      <td class="info-label">Hari / Tanggal :</td>
      <td class="info-value">{{ $presence->tgl_kegiatan ? \Carbon\Carbon::parse($presence->tgl_kegiatan)->translatedFormat('l, d F Y') : '-' }}</td>
    </tr>
    @endif
    @if($showTime)
    <tr>
      <td class="info-label">Waktu :</td>
      <td class="info-value">{{ $presence->tgl_kegiatan ? date('H:i', strtotime($presence->tgl_kegiatan)) . ' - s.d Selesai' : '-' }}</td>
    </tr>
    @endif
    @if($showLocation)
    <tr>
      <td class="info-label">Tempat :</td>
      <td class="info-value">{{ $presence->tempat ?? '-' }}</td>
    </tr>
    @endif
  </table>

  <!-- TABEL PESERTA -->
  <table class="table-peserta">
    <thead>
      @if (empty($presence->custom_fields))
        <tr>
          <th width="20">No</th>
          <th>Nama</th>
          <th width="30">NP</th>
          <th>Jabatan</th>
          <th>Unit Kerja / Instansi</th>
          <th width="120">Tanda Tangan</th>
        </tr>
      @else
        <tr>
          <th width="20">No</th>
          @foreach ($presence->custom_fields as $field)
             <th {!! $field['type'] === 'signature' ? 'width="120"' : '' !!}>{{ $field['label'] }}</th>
          @endforeach
        </tr>
      @endif
    </thead>
    <tbody>
      @if ($presenceDetails->isEmpty())
        <tr>
          <td colspan="{{ empty($presence->custom_fields) ? 6 : count($presence->custom_fields) + 1 }}">Tidak ada data</td>
        </tr>
      @endif

      @foreach ($presenceDetails as $detail)
        <tr>
          <td>{{ $loop->iteration }}</td>
          @if (empty($presence->custom_fields))
            <td class="text-left">{{ $detail->nama }}</td>
            <td>{{ $detail->np }}</td>
            <td class="text-left">{{ $detail->jabatan }}</td>
            <td class="text-left">{{ $detail->asal_instansi }}</td>
            <td>
              @if ($detail->tanda_tangan)
                @php
                  $ttdPath = public_path('uploads/' . $detail->tanda_tangan);
                  if(file_exists($ttdPath)) {
                      $ttdType = pathinfo($ttdPath, PATHINFO_EXTENSION);
                      $ttdData = file_get_contents($ttdPath);
                      $ttdBase64 = 'data:image/' . $ttdType . ';base64,' . base64_encode($ttdData);
                      echo '<img src="' . $ttdBase64 . '" style="max-width: 100%; max-height:40px;">';
                  }
                @endphp
              @endif
            </td>
          @else
            @foreach ($presence->custom_fields as $field)
              @php
                  $val = $detail->additional_data[$field['id']] ?? '';
              @endphp
              @if ($field['type'] === 'signature')
                  <td>
                    @if ($val)
                      @php
                        $ttdPath = public_path('uploads/' . $val);
                        if (file_exists($ttdPath)) {
                            $ttdType = pathinfo($ttdPath, PATHINFO_EXTENSION);
                            $ttdData = file_get_contents($ttdPath);
                            $ttdBase64 = 'data:image/' . $ttdType . ';base64,' . base64_encode($ttdData);
                            echo '<img src="' . $ttdBase64 . '" style="max-width: 100%; max-height:40px;">';
                        }
                      @endphp
                    @endif
                  </td>
              @else
                  <td class="text-left">{{ is_array($val) ? implode(', ', $val) : $val }}</td>
              @endif
            @endforeach
          @endif
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
