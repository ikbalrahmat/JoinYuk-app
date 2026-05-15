<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $presence->nama_kegiatan ?? env('APP_NAME') }}</title>

    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: { 50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd', 400: '#60a5fa', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 800: '#1e40af', 900: '#1e3a8a' }
                    }
                }
            }
        }
    </script>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #f8fafc;
            background-image: radial-gradient(#e2e8f0 1px, transparent 1px);
            background-size: 20px 20px;
        }
        .signature-pad {
            touch-action: none;
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="min-h-screen text-slate-800 antialiased selection:bg-primary-200 selection:text-primary-900 flex flex-col">
    <div class="flex-grow flex flex-col items-center py-10 px-4 sm:px-6 w-full max-w-4xl mx-auto">
        
        <!-- Header Card -->
        <div class="w-full glass-panel rounded-3xl shadow-xl border border-white mb-6 overflow-hidden">
            <!-- Decorative Top Bar -->
            <div class="h-3 bg-gradient-to-r from-primary-600 via-indigo-500 to-purple-500"></div>
            
            <div class="p-6 sm:p-10">
                @php
                    $headerConfig = isset($presence->header_config) && is_string($presence->header_config) ? json_decode($presence->header_config, true) : $presence->header_config;
                    $logoLeft = !empty($headerConfig['logo_left']) ? asset('storage/' . $headerConfig['logo_left']) : null;
                    $logoRight = !empty($headerConfig['logo_right']) ? asset('storage/' . $headerConfig['logo_right']) : null;
                    
                    $showDate = isset($headerConfig['show_date']) ? $headerConfig['show_date'] : (!empty($presence->tgl_kegiatan));
                    $showTime = isset($headerConfig['show_time']) ? $headerConfig['show_time'] : (!empty($presence->tgl_kegiatan));
                    $showLocation = isset($headerConfig['show_location']) ? $headerConfig['show_location'] : (!empty($presence->tempat));
                @endphp
                
                <div class="flex items-center justify-between gap-4 mb-6 relative">
                    <div class="w-16 sm:w-24 shrink-0 flex justify-start">
                        @if($logoLeft)
                        <img src="{{ $logoLeft }}" alt="Logo Kiri" class="max-h-12 sm:max-h-16 object-contain drop-shadow-sm">
                        @endif
                    </div>
                    
                    <h1 class="text-xl sm:text-2xl font-extrabold text-slate-800 text-center leading-tight flex-grow uppercase tracking-wide">
                        {{ $presence->nama_kegiatan }}
                    </h1>
                    
                    <div class="w-16 sm:w-24 shrink-0 flex justify-end">
                        @if($logoRight)
                        <img src="{{ $logoRight }}" alt="Logo Kanan" class="max-h-12 sm:max-h-16 object-contain drop-shadow-sm">
                        @endif
                    </div>
                </div>
                
                @if($showDate || $showTime || $showLocation)
                <div class="bg-slate-50 rounded-2xl p-4 sm:p-5 border border-slate-100 shadow-inner">
                    <ul class="space-y-3">
                        @if($showDate && $presence->tgl_kegiatan)
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-calendar-day text-sm"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tanggal</p>
                                <p class="text-sm sm:text-base font-semibold text-slate-700">{{ \Carbon\Carbon::parse($presence->tgl_kegiatan)->translatedFormat('l, d F Y') }}</p>
                            </div>
                        </li>
                        @endif
                        
                        @if($showTime && $presence->tgl_kegiatan)
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-clock text-sm"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Waktu</p>
                                <p class="text-sm sm:text-base font-semibold text-slate-700">{{ \Carbon\Carbon::parse($presence->tgl_kegiatan)->format('H:i') }} - s.d Selesai WIB</p>
                            </div>
                        </li>
                        @endif
                        
                        @if($showLocation && $presence->tempat)
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-location-dot text-sm"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tempat</p>
                                <p class="text-sm sm:text-base font-semibold text-slate-700">{{ $presence->tempat }}</p>
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>
                @endif
            </div>
        </div>

        <!-- Form Card -->
        <div class="w-full glass-panel rounded-3xl shadow-xl border border-white p-6 sm:p-10 relative overflow-hidden">
            <!-- Background Decoration -->
            <div class="absolute -top-24 -right-24 w-48 h-48 bg-primary-100 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
            <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-indigo-100 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

            <form id="form-absen" action="{{ route('absen.save', $presence->id) }}" method="POST" class="relative z-10 space-y-6">
                @csrf

                @if(is_null($presence->custom_fields))
                    <!-- BACKWARD COMPATIBILITY: Hardcoded Fields -->
                    <div>
                        <label for="nama" class="block text-sm font-bold text-slate-700 mb-1">Nama <span class="text-red-500">*</span></label>
                        <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap" required class="w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition duration-200 shadow-sm px-4 py-2.5">
                        @error('nama')<p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="np" class="block text-sm font-bold text-slate-700 mb-1">Nomor Pegawai (NP)</label>
                        <input type="text" id="np" name="np" placeholder="Masukkan NP" class="w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition duration-200 shadow-sm px-4 py-2.5">
                        @error('np')<p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="jabatan" class="block text-sm font-bold text-slate-700 mb-1">Jabatan <span class="text-red-500">*</span></label>
                        <input type="text" id="jabatan" name="jabatan" placeholder="Masukkan jabatan" required class="w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition duration-200 shadow-sm px-4 py-2.5">
                        @error('jabatan')<p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="asal_instansi" class="block text-sm font-bold text-slate-700 mb-1">Unit Kerja / Instansi <span class="text-red-500">*</span></label>
                        <input type="text" id="asal_instansi" name="asal_instansi" placeholder="Masukkan unit kerja" required class="w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition duration-200 shadow-sm px-4 py-2.5">
                        @error('asal_instansi')<p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tanda Tangan <span class="text-red-500">*</span></label>
                        <div class="border-2 border-dashed border-slate-300 rounded-2xl bg-white overflow-hidden shadow-inner relative group">
                            <canvas id="signature-pad-legacy" class="signature-pad w-full h-40 cursor-crosshair"></canvas>
                            <button type="button" class="clear-sig-legacy absolute top-3 right-3 bg-white/80 backdrop-blur text-slate-500 hover:text-red-500 hover:bg-red-50 text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm border border-slate-200 transition opacity-0 group-hover:opacity-100 focus:opacity-100">
                                <i class="fa-solid fa-eraser mr-1"></i> Bersihkan
                            </button>
                        </div>
                        <textarea name="signature" id="signature64-legacy" class="hidden"></textarea>
                        @error('signature')<p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>@enderror
                    </div>
                @else
                    <!-- DYNAMIC FIELDS -->
                    @if(is_array($presence->custom_fields) && count($presence->custom_fields) === 0)
                        <div class="text-center p-8 bg-slate-50 rounded-xl border-2 border-dashed border-slate-200">
                            <div class="w-16 h-16 bg-white shadow-sm text-slate-400 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fa-solid fa-file-circle-question text-2xl"></i>
                            </div>
                            <h3 class="text-slate-600 font-bold mb-1">Formulir Kosong</h3>
                            <p class="text-sm text-slate-500">Belum ada kolom pertanyaan yang ditambahkan ke dalam form ini oleh pembuat.</p>
                        </div>
                    @else
                        @foreach($presence->custom_fields as $field)
                        <div class="mb-6">
                            <label for="{{ $field['id'] }}" class="block text-sm font-bold text-slate-700 mb-1">
                                {{ $field['label'] }} 
                                @if($field['required']) <span class="text-red-500">*</span> @endif
                            </label>
                            
                            @if(!empty($field['instructions']))
                                <p class="text-xs text-slate-500 mb-2">{{ $field['instructions'] }}</p>
                            @endif
                            
                            @if(in_array($field['type'], ['text', 'email', 'number', 'date', 'time']))
                                <input type="{{ $field['type'] }}" id="{{ $field['id'] }}" name="dynamic[{{ $field['id'] }}]" placeholder="Masukkan {{ strtolower($field['label']) }}" {{ $field['required'] ? 'required' : '' }} class="w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition duration-200 shadow-sm px-4 py-2.5">
                            
                            @elseif($field['type'] === 'select')
                                <div class="relative">
                                    <select id="{{ $field['id'] }}" name="dynamic[{{ $field['id'] }}]" {{ $field['required'] ? 'required' : '' }} class="w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition duration-200 shadow-sm px-4 py-2.5 appearance-none">
                                        <option value="">Pilih {{ $field['label'] }}</option>
                                        @foreach(explode(',', $field['options']) as $opt)
                                            <option value="{{ trim($opt) }}">{{ trim($opt) }}</option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                                        <i class="fa-solid fa-chevron-down text-xs"></i>
                                    </div>
                                </div>

                            @elseif($field['type'] === 'textarea')
                                <textarea id="{{ $field['id'] }}" name="dynamic[{{ $field['id'] }}]" placeholder="Masukkan {{ strtolower($field['label']) }}" rows="3" {{ $field['required'] ? 'required' : '' }} class="w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition duration-200 shadow-sm px-4 py-3"></textarea>

                            @elseif($field['type'] === 'radio')
                                <div class="space-y-2 mt-2">
                                    @foreach(explode(',', $field['options']) as $index => $opt)
                                        <label class="flex items-center gap-3 p-3 border border-slate-200 rounded-xl bg-slate-50 hover:bg-slate-100 cursor-pointer transition">
                                            <input type="radio" name="dynamic[{{ $field['id'] }}]" id="{{ $field['id'] }}_{{ $index }}" value="{{ trim($opt) }}" {{ $field['required'] ? 'required' : '' }} class="text-primary-600 focus:ring-primary-500 border-slate-300 w-4 h-4">
                                            <span class="text-sm font-medium text-slate-700">{{ trim($opt) }}</span>
                                        </label>
                                    @endforeach
                                </div>

                            @elseif($field['type'] === 'checkbox')
                                <div class="space-y-2 mt-2">
                                    @foreach(explode(',', $field['options']) as $index => $opt)
                                        <label class="flex items-center gap-3 p-3 border border-slate-200 rounded-xl bg-slate-50 hover:bg-slate-100 cursor-pointer transition">
                                            <input type="checkbox" name="dynamic[{{ $field['id'] }}][]" id="{{ $field['id'] }}_{{ $index }}" value="{{ trim($opt) }}" class="text-primary-600 focus:ring-primary-500 border-slate-300 rounded w-4 h-4">
                                            <span class="text-sm font-medium text-slate-700">{{ trim($opt) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            
                            @elseif($field['type'] === 'signature')
                                <div class="border-2 border-dashed border-slate-300 rounded-2xl bg-white overflow-hidden shadow-inner relative group mt-2">
                                    <canvas id="canvas_{{ $field['id'] }}" class="signature-pad dynamic-sig w-full h-40 cursor-crosshair"></canvas>
                                    <button type="button" class="clear-dynamic-sig absolute top-3 right-3 bg-white/80 backdrop-blur text-slate-500 hover:text-red-500 hover:bg-red-50 text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm border border-slate-200 transition opacity-0 group-hover:opacity-100 focus:opacity-100" data-target="canvas_{{ $field['id'] }}">
                                        <i class="fa-solid fa-eraser mr-1"></i> Bersihkan
                                    </button>
                                </div>
                                <textarea name="dynamic[{{ $field['id'] }}]" id="textarea_{{ $field['id'] }}" class="hidden" {{ $field['required'] ? 'required' : '' }}></textarea>
                            @endif
                            
                            @error('dynamic.'.$field['id'])<p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>@enderror
                        </div>
                        @endforeach
                    @endif
                @endif

                <div class="pt-6 border-t border-slate-100 mt-8">
                    <button type="submit" class="w-full py-3.5 px-4 bg-gradient-to-r from-primary-600 to-indigo-600 hover:from-primary-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-primary-500/30 transition-all duration-200 transform hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-primary-500/50 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i> Kirim Jawaban
                    </button>
                </div>
            </form>
        </div>
        
        <div class="mt-8 text-center text-slate-400 text-xs font-medium">
            &copy; {{ date('Y') }} Form Builder by JoinYuk
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="{{ asset('js/signature.min.js') }}"></script>

    <script>
        $(function () {
            // Resize canvas to be responsive
            function resizeCanvas(canvas) {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                // Save signature data before resize
                let sigPad = canvas.sigPadInstance;
                let data = null;
                if(sigPad && !sigPad.isEmpty()) {
                    data = sigPad.toData();
                }
                
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
                
                if(sigPad) {
                    sigPad.clear();
                    if(data) sigPad.fromData(data);
                }
            }

            // Legacy Signature (Backward Compatibility)
            if ($('#signature-pad-legacy').length > 0) {
                const canvas = document.getElementById('signature-pad-legacy');
                const signaturePad = new SignaturePad(canvas, {
                    backgroundColor: 'rgba(255,255,255,0)',
                    penColor: 'rgb(15, 23, 42)', // slate-900
                    minWidth: 1.5,
                    maxWidth: 3
                });
                canvas.sigPadInstance = signaturePad;
                resizeCanvas(canvas);
                window.addEventListener("resize", () => resizeCanvas(canvas));

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
                
                let pad = new SignaturePad(canvas, {
                    backgroundColor: 'rgba(255,255,255,0)',
                    penColor: 'rgb(15, 23, 42)',
                    minWidth: 1.5,
                    maxWidth: 3
                });
                canvas.sigPadInstance = pad;
                resizeCanvas(canvas);
                window.addEventListener("resize", () => resizeCanvas(canvas));
                
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
                const btn = $(this).find('button[type="submit"]');
                btn.attr('disabled', true);
                btn.html('<i class="fa-solid fa-circle-notch fa-spin"></i> Menyimpan...');
            });
        });
    </script>
</body>
</html>
