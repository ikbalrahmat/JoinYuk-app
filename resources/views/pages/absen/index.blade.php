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
      <!-- Form Kehadiran -->
      <div class="col-12">
        <div class="card p-4">
          <form id="form-absen" action="{{ route('absen.save', $presence->id) }}" method="POST">
            @csrf

            @if(empty($presence->custom_fields))
              <!-- BACKWARD COMPATIBILITY: Hardcoded Fields -->
              <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama lengkap" required>
                @error('nama')<div class="text-danger small">{{ $message }}</div>@enderror
              </div>

              <div class="mb-3">
                <label for="np" class="form-label">Nomor Pegawai (NP)</label>
                <input type="text" class="form-control" id="np" name="np" placeholder="Masukkan NP">
                @error('np')<div class="text-danger small">{{ $message }}</div>@enderror
              </div>

              <div class="mb-3">
                <label for="jabatan" class="form-label">Jabatan</label>
                <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Masukkan jabatan" required>
                @error('jabatan')<div class="text-danger small">{{ $message }}</div>@enderror
              </div>

              <div class="mb-3">
                <label for="asal_instansi" class="form-label">Unit Kerja / Instansi</label>
                <input type="text" class="form-control" id="asal_instansi" name="asal_instansi" placeholder="Masukkan unit kerja" required>
                @error('asal_instansi')<div class="text-danger small">{{ $message }}</div>@enderror
              </div>

              <div class="mb-3">
                <label class="form-label">Tanda Tangan</label>
                <div class="form-control p-0 mb-2">
                  <canvas id="signature-pad-legacy" class="signature-pad"></canvas>
                </div>
                <textarea name="signature" id="signature64-legacy" class="d-none"></textarea>
                @error('signature')<div class="text-danger small">{{ $message }}</div>@enderror
                <button type="button" class="btn btn-sm btn-outline-secondary mt-2 clear-sig-legacy">Hapus</button>
              </div>
            @else
              <!-- DYNAMIC FIELDS -->
              @foreach($presence->custom_fields as $field)
                <div class="mb-3">
                  <label for="{{ $field['id'] }}" class="form-label mb-0">{{ $field['label'] }} {!! $field['required'] ? '<span class="text-danger">*</span>' : '' !!}</label>
                  @if(!empty($field['instructions']))
                    <div class="form-text text-muted mt-0 mb-2" style="font-size: 0.8rem;">{{ $field['instructions'] }}</div>
                  @endif
                  
                  @if($field['type'] === 'text' || $field['type'] === 'email' || $field['type'] === 'number' || $field['type'] === 'date' || $field['type'] === 'time')
                    <input type="{{ $field['type'] }}" class="form-control" id="{{ $field['id'] }}" name="dynamic[{{ $field['id'] }}]" placeholder="Masukkan {{ strtolower($field['label']) }}" {{ $field['required'] ? 'required' : '' }}>
                  
                  @elseif($field['type'] === 'select')
                    <select class="form-select form-control" id="{{ $field['id'] }}" name="dynamic[{{ $field['id'] }}]" {{ $field['required'] ? 'required' : '' }}>
                      <option value="">Pilih {{ $field['label'] }}</option>
                      @foreach(explode(',', $field['options']) as $opt)
                        <option value="{{ trim($opt) }}">{{ trim($opt) }}</option>
                      @endforeach
                    </select>

                  @elseif($field['type'] === 'textarea')
                    <textarea class="form-control" id="{{ $field['id'] }}" name="dynamic[{{ $field['id'] }}]" placeholder="Masukkan {{ strtolower($field['label']) }}" rows="3" {{ $field['required'] ? 'required' : '' }}></textarea>

                  @elseif($field['type'] === 'radio')
                    <div class="mt-2">
                      @foreach(explode(',', $field['options']) as $index => $opt)
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="dynamic[{{ $field['id'] }}]" id="{{ $field['id'] }}_{{ $index }}" value="{{ trim($opt) }}" {{ $field['required'] ? 'required' : '' }}>
                          <label class="form-check-label" for="{{ $field['id'] }}_{{ $index }}">
                            {{ trim($opt) }}
                          </label>
                        </div>
                      @endforeach
                    </div>

                  @elseif($field['type'] === 'checkbox')
                    <div class="mt-2">
                      @foreach(explode(',', $field['options']) as $index => $opt)
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" name="dynamic[{{ $field['id'] }}][]" id="{{ $field['id'] }}_{{ $index }}" value="{{ trim($opt) }}">
                          <label class="form-check-label" for="{{ $field['id'] }}_{{ $index }}">
                            {{ trim($opt) }}
                          </label>
                        </div>
                      @endforeach
                    </div>
                  
                  @elseif($field['type'] === 'signature')
                    <div class="form-control p-0 mb-2">
                      <canvas id="canvas_{{ $field['id'] }}" class="signature-pad dynamic-sig"></canvas>
                    </div>
                    <textarea name="dynamic[{{ $field['id'] }}]" id="textarea_{{ $field['id'] }}" class="d-none" {{ $field['required'] ? 'required' : '' }}></textarea>
                    <button type="button" class="btn btn-sm btn-outline-secondary mt-2 clear-dynamic-sig" data-target="canvas_{{ $field['id'] }}">Hapus</button>
                  @endif
                  
                  @error('dynamic.'.$field['id'])<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
              @endforeach
            @endif

            <button type="submit" class="btn btn-primary w-100 mt-4">
              Submit
            </button>
          </form>
        </div>
      </div>

    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="{{ asset('js/signature.min.js') }}"></script>

  <script>
    $(function () {
      // Legacy Signature (Backward Compatibility)
      if ($('#signature-pad-legacy').length > 0) {
        let sigWidth = $('#signature-pad-legacy').parent().width();
        $('#signature-pad-legacy').attr('width', sigWidth);

        let signaturePad = new SignaturePad(document.getElementById('signature-pad-legacy'), {
          backgroundColor: 'rgba(255,255,255,0)',
          penColor: 'rgb(0,0,255)'
        });

        $('#signature-pad-legacy').on('mouseup touchend', function () {
          $('#signature64-legacy').val(signaturePad.toDataURL());
        });

        $('.clear-sig-legacy').on('click', function (e) {
          e.preventDefault();
          signaturePad.clear();
          $('#signature64-legacy').val('');
        });
      }

      // Dynamic Signatures
      const dynamicPads = {};
      $('.dynamic-sig').each(function() {
        let canvas = $(this)[0];
        let id = $(this).attr('id');
        let textareaId = id.replace('canvas_', 'textarea_');
        
        let sigWidth = $(this).parent().width();
        $(this).attr('width', sigWidth);
        
        let pad = new SignaturePad(canvas, {
          backgroundColor: 'rgba(255,255,255,0)',
          penColor: 'rgb(0,0,255)'
        });
        
        dynamicPads[id] = { pad: pad, textareaId: textareaId };
        
        $(this).on('mouseup touchend', function () {
          $('#' + textareaId).val(pad.toDataURL());
        });
      });
      
      $('.clear-dynamic-sig').on('click', function(e) {
        e.preventDefault();
        let targetId = $(this).data('target');
        let sigObj = dynamicPads[targetId];
        if(sigObj) {
          sigObj.pad.clear();
          $('#' + sigObj.textareaId).val('');
        }
      });

      $('#form-absen').on('submit', function () {
        $(this).find('button[type="submit"]').attr('disabled', true).text('Menyimpan...');
      });
    });
  </script>
</body>

</html>
