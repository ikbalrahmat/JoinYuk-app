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
      <div class="d-flex justify-content-between align-items-center title-divider">
        <img src="{{ asset('assets/bumn.png') }}" alt="Logo BUMN" class="header-logo">
        <h4 class="fw-bold text-center">DAFTAR HADIR KEGIATAN</h4>
        <img src="{{ asset('assets/logo.png') }}" alt="Logo PERURI" class="header-logo">
      </div>
      <table class="table table-borderless mt-2 mb-0">
        <tr><td width="160">Agenda</td><td>: {{ $presence->nama_kegiatan }}</td></tr>
        <tr><td>Tanggal</td><td>: {{ \Carbon\Carbon::parse($presence->tgl_kegiatan)->translatedFormat('l, d F Y') }}</td></tr>
        <tr><td>Waktu</td><td>: {{ \Carbon\Carbon::parse($presence->tgl_kegiatan)->format('H:i') }} - s.d Selesai</td></tr>
        <tr><td>Tempat</td><td>: {{ $presence->tempat }}</td></tr>
      </table>
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
