<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Absen Berhasil - {{ env('APP_NAME') }}</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    body {
      background: linear-gradient(to bottom, #f5f7fa, #e2ecf8);
      font-family: 'Segoe UI', sans-serif;
      color: #34495e;
      min-height: 100vh;
    }

    .content-wrapper {
      max-width: 860px;
      margin: 0 auto;
    }

    .card {
      border-radius: 14px;
      border: none;
      background-color: #ffffff;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .btn-outline-dark {
      border-radius: 8px;
    }

    .table th,
    .table td {
      vertical-align: middle;
      font-size: 0.93rem;
    }

    .success-icon {
      font-size: 4rem;
      color: #28a745;
      margin-bottom: 1rem;
    }

    .header-logo {
      height: 48px;
      object-fit: contain;
    }

    .title-divider {
      border-bottom: 2px solid #dee2e6;
      margin-bottom: 1rem;
      padding-bottom: 1rem;
    }

    @media (max-width: 768px) {
      .header-logo {
        height: 40px;
      }

      h4.fw-bold {
        font-size: 1.1rem;
      }
    }
  </style>
</head>

<body>
  <div class="container py-5 content-wrapper">
    <!-- Header Info -->
    <div class="card p-4 mb-4">
      @php
          $headerConfig = isset($presence->header_config) && is_string($presence->header_config) ? json_decode($presence->header_config, true) : $presence->header_config;
          $logoLeft = !empty($headerConfig['logo_left']) ? asset('storage/' . $headerConfig['logo_left']) : null;
          $logoRight = !empty($headerConfig['logo_right']) ? asset('storage/' . $headerConfig['logo_right']) : null;
          
          $showDate = isset($headerConfig['show_date']) ? $headerConfig['show_date'] : (!empty($presence->tgl_kegiatan));
          $showTime = isset($headerConfig['show_time']) ? $headerConfig['show_time'] : (!empty($presence->tgl_kegiatan));
          $showLocation = isset($headerConfig['show_location']) ? $headerConfig['show_location'] : (!empty($presence->tempat));
      @endphp
      <div class="position-relative d-flex justify-content-center align-items-center title-divider" style="min-height: 50px;">
        @if($logoLeft)
        <img src="{{ $logoLeft }}" alt="Logo Kiri" class="header-logo position-absolute start-0">
        @endif
        
        <h4 class="fw-bold text-center px-3 mb-0" style="max-width: 65%; margin: 0 auto; position: relative; z-index: 1;">{{ $presence->nama_kegiatan }}</h4>
        
        @if($logoRight)
        <img src="{{ $logoRight }}" alt="Logo Kanan" class="header-logo position-absolute end-0">
        @endif
      </div>
      
      @if($showDate || $showTime || $showLocation)
      <table class="table table-borderless mt-3 mb-0">
        @if($showDate && $presence->tgl_kegiatan)
        <tr><td width="160" class="fw-semibold text-muted">Tanggal</td><td class="fw-medium">: {{ \Carbon\Carbon::parse($presence->tgl_kegiatan)->translatedFormat('l, d F Y') }}</td></tr>
        @endif
        @if($showTime && $presence->tgl_kegiatan)
        <tr><td width="160" class="fw-semibold text-muted">Waktu</td><td class="fw-medium">: {{ \Carbon\Carbon::parse($presence->tgl_kegiatan)->format('H:i') }} - s.d Selesai WIB</td></tr>
        @endif
        @if($showLocation && $presence->tempat)
        <tr><td width="160" class="fw-semibold text-muted">Tempat</td><td class="fw-medium">: {{ $presence->tempat }}</td></tr>
        @endif
      </table>
      @endif
    </div>

    <div class="row g-4">
      <!-- Pesan Sukses -->
      <div class="col-12">
        <div class="card p-5 text-center">
          <i class="fa-solid fa-circle-check success-icon"></i>
          <h3 class="fw-bold mb-3">Terima Kasih!</h3>
          <p class="text-muted fs-5 mb-0">Absensi Anda berhasil disimpan ke dalam sistem.</p>
        </div>
      </div>

      <!-- Tabel Kehadiran -->
      <div class="col-12">
        <div class="card p-4">
          <button class="btn btn-outline-dark w-100 mb-3" id="toggle-table">Lihat Daftar Kehadiran</button>
          <div class="d-none" id="table-container">
            <h6 class="fw-semibold mb-3">Daftar Kehadiran Kegiatan</h6>
            <div class="table-responsive">
              {{ $dataTable->table(['class' => 'table table-striped align-middle mb-0 w-100']) }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>

  <script>
    $(function () {
      $('#toggle-table').on('click', function () {
        $('#table-container').toggleClass('d-none');
        $(this).text($('#table-container').hasClass('d-none') ? 'Lihat Daftar Kehadiran' : 'Sembunyikan Daftar Kehadiran');
      });
    });
  </script>

  {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
</body>

</html>
