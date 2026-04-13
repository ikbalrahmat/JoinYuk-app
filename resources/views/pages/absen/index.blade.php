<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ env('APP_NAME') }}</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">

  <style>
    body {
      background: linear-gradient(to bottom, #f5f7fa, #e2ecf8);
      font-family: 'Segoe UI', sans-serif;
      color: #34495e;
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

    .form-label {
      font-weight: 600;
      color: #2c3e50;
    }

    .form-control {
      border-radius: 8px;
    }

    .btn-primary {
      border-radius: 8px;
      background-color: #2e86de;
      border: none;
    }

    .btn-primary:hover {
      background-color: #2161b2;
    }

    .btn-outline-dark {
      border-radius: 8px;
    }

    .signature-pad {
      width: 100%;
      height: 160px;
      border: 2px dashed #ccc;
      border-radius: 10px;
      background-color: #fefefe;
    }

    .table th,
    .table td {
      vertical-align: middle;
      font-size: 0.93rem;
    }

    .alert-success {
      border-radius: 8px;
      background-color: #d1f2eb;
      color: #117a65;
      font-weight: 500;
      border: 1px solid #a3e4d7;
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
      <!-- Form Kehadiran -->
      <div class="col-12">
        <div class="card p-4">
          @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
          @endif

          <form id="form-absen" action="{{ route('absen.save', $presence->id) }}" method="POST">
            @csrf

            <div class="mb-3">
              <label for="nama" class="form-label">Nama</label>
              <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama lengkap">
              @error('nama')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label for="np" class="form-label">Nomor Pegawai (NP)</label>
              <input type="text" class="form-control" id="np" name="np" placeholder="Masukkan NP">
              @error('np')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label for="jabatan" class="form-label">Jabatan</label>
              <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Masukkan jabatan">
              @error('jabatan')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label for="asal_instansi" class="form-label">Unit Kerja / Instansi</label>
              <input type="text" class="form-control" id="asal_instansi" name="asal_instansi" placeholder="Masukkan unit kerja">
              @error('asal_instansi')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Tanda Tangan</label>
              <div class="form-control p-0 mb-2">
                <canvas id="signature-pad" class="signature-pad"></canvas>
              </div>
              <textarea name="signature" id="signature64" class="d-none"></textarea>
              @error('signature')<div class="text-danger small">{{ $message }}</div>@enderror
              <button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="clear">Hapus</button>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">
              Submit
            </button>
          </form>
        </div>
      </div>

      <!-- Tabel Kehadiran -->
      <div class="col-12">
        <div class="card p-3">
          <button class="btn btn-outline-dark w-100 mb-3" id="toggle-table">Lihat Daftar Kehadiran</button>
          <div class="d-none" id="table-container">
            <h6 class="fw-semibold mb-3">Daftar Kehadiran</h6>
            <div class="table-responsive">
              {{ $dataTable->table(['class' => 'table table-striped align-middle mb-0']) }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>



  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="{{ asset('js/signature.min.js') }}"></script>
  <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>

  <script>
    $(function () {
      let sigWidth = $('#signature-pad').parent().width();
      $('#signature-pad').attr('width', sigWidth);

      let signaturePad = new SignaturePad(document.getElementById('signature-pad'), {
        backgroundColor: 'rgba(255,255,255,0)',
        penColor: 'rgb(0,0,255)'
      });

      $('canvas').on('mouseup touchend', function () {
        $('#signature64').val(signaturePad.toDataURL());
      });

      $('#clear').on('click', function (e) {
        e.preventDefault();
        signaturePad.clear();
        $('#signature64').val('');
      });

      $('#toggle-table').on('click', function () {
        $('#table-container').toggleClass('d-none');
        $(this).text($('#table-container').hasClass('d-none') ? 'Lihat Daftar Kehadiran' : 'Sembunyikan Daftar Kehadiran');
      });

      $('#form-absen').on('submit', function () {
        $(this).find('button[type="submit"]').attr('disabled', true).text('Menyimpan...');
      });
    });
  </script>

  {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
</body>

</html>
