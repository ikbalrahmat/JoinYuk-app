@extends('layouts.main')

@section('content')
<div class="max-w-6xl mx-auto my-6 px-4">
    <div class="bg-gray-50 p-6 rounded-2xl shadow">

        <!-- Header & Tombol -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <h3 class="text-xl font-bold text-gray-800">Detail Absen</h3>

            <div class="flex flex-wrap gap-2 justify-end">

                <!-- Dropdown Bagikan -->
                <div class="relative">
                    <button id="dropdownShareBtn" type="button"
                        class="flex items-center bg-yellow-400 hover:bg-yellow-500 text-gray-800 px-4 py-2 rounded-full shadow text-sm font-medium">
                        <i class="bi bi-share-fill mr-1"></i> Bagikan
                    </button>
                    <ul id="dropdownShareMenu"
                        class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-md z-10">
                        <li>
                            <button onclick="copyLink()"
                                class="w-full text-left px-4 py-2 hover:bg-gray-100 text-sm flex items-center">
                                <i class="bi bi-clipboard mr-2"></i> Salin Link
                            </button>
                        </li>
                        <li>
                            <a href="{{ route('presence.qrcode.download', $presence->slug) }}"
                               class="block px-4 py-2 hover:bg-gray-100 text-sm flex items-center">
                                <i class="bi bi-qr-code mr-2"></i> Download QR
                            </a>
                        </li>
                        <li>
                            <a href="https://wa.me/?text={{ urlencode(route('absen.index', $presence->slug)) }}"
                               target="_blank"
                               class="block px-4 py-2 hover:bg-gray-100 text-sm flex items-center">
                                <i class="bi bi-whatsapp mr-2"></i> WhatsApp
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Tombol PDF & Kembali -->
                <button type="button" onclick="openExportModal()"
                   class="flex items-center bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-full shadow text-sm font-medium">
                    <i class="bi bi-file-earmark-pdf-fill mr-1"></i> Export PDF
                </button>
                <a href="{{ route('presence.index') }}"
                   class="flex items-center bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-full shadow text-sm font-medium">
                    <i class="bi bi-arrow-left-circle mr-1"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Info Kegiatan -->
        <div class="bg-white shadow rounded-xl mb-6">
            <div class="p-4">
                @php
                    $headerConfig = is_string($presence->header_config) ? json_decode($presence->header_config, true) : $presence->header_config;
                    $showDate = $headerConfig['show_date'] ?? true;
                    $showTime = $headerConfig['show_time'] ?? true;
                    $showLocation = $headerConfig['show_location'] ?? true;
                @endphp
                <table class="w-full text-sm text-gray-700">
                    <tr>
                        <td class="font-semibold w-44">Agenda/Kegiatan</td>
                        <td class="w-5">:</td>
                        <td>{{ $presence->nama_kegiatan }}</td>
                    </tr>
                    @if($showDate)
                    <tr>
                        <td class="font-semibold">Tanggal</td>
                        <td>:</td>
                        <td>{{ $presence->tgl_kegiatan ? date('d F Y', strtotime($presence->tgl_kegiatan)) : '-' }}</td>
                    </tr>
                    @endif
                    @if($showTime)
                    <tr>
                        <td class="font-semibold">Waktu</td>
                        <td>:</td>
                        <td>{{ $presence->tgl_kegiatan ? date('H:i', strtotime($presence->tgl_kegiatan)) . ' - s.d Selesai' : '-' }}</td>
                    </tr>
                    @endif
                    @if($showLocation)
                    <tr>
                        <td class="font-semibold">Tempat</td>
                        <td>:</td>
                        <td>{{ $presence->tempat ?? '-' }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        <!-- Upload Bukti -->
        <div class="bg-white shadow rounded-xl mb-6 p-4">
            @if (session('success'))
                <div class="mb-3 p-3 bg-green-100 border border-green-300 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (empty($presence->bukti_kegiatan))
                <form action="{{ route('presence.upload.bukti', $presence->id) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                    @csrf
                    <label for="bukti_kegiatan" class="block text-sm font-semibold text-gray-700">Upload Bukti Kegiatan (Gambar)</label>
                    <div class="flex flex-col sm:flex-row gap-2">
                        <input type="file" name="bukti_kegiatan" id="bukti_kegiatan" accept="image/*"
                               class="flex-1 border rounded-lg px-3 py-2 text-sm" required>
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center text-sm">
                            <i class="bi bi-upload mr-1"></i> Upload
                        </button>
                    </div>
                </form>
            @else
                <h5 class="font-bold text-gray-800 mb-3">Bukti Kegiatan</h5>
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/bukti/' . $presence->bukti_kegiatan) }}"
                         alt="Bukti Kegiatan"
                         class="mx-auto rounded-lg shadow max-h-80 object-contain">
                </div>

                <div class="flex flex-col md:flex-row gap-2 justify-center items-center">
                    <!-- Hapus -->
                    <form action="{{ route('presence.delete.bukti', $presence->id) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin hapus gambar ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="border border-red-500 text-red-600 hover:bg-red-50 px-3 py-2 rounded-lg flex items-center text-sm">
                            <i class="bi bi-trash-fill mr-1"></i> Hapus
                        </button>
                    </form>

                    <!-- Ganti -->
                    <form action="{{ route('presence.upload.bukti', $presence->id) }}" method="POST" enctype="multipart/form-data"
                          class="flex gap-2 items-center w-full md:w-auto">
                        @csrf
                        <input type="file" name="bukti_kegiatan" accept="image/*"
                               class="flex-1 border rounded-lg px-3 py-2 text-sm" required>
                        <button type="submit"
                                class="border border-blue-500 text-blue-600 hover:bg-blue-50 px-3 py-2 rounded-lg flex items-center text-sm">
                            <i class="bi bi-upload mr-1"></i> Upload
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <!-- DataTable Peserta -->
        <div class="bg-white shadow rounded-xl">
            <div class="p-4 overflow-x-auto">
                {{ $dataTable->table(['class' => 'min-w-full text-sm text-gray-700']) }}
            </div>
        </div>
    </div>
</div>

<!-- ================= MODAL EXPORT PDF ================= -->
<div id="exportModal" class="fixed inset-0 z-[100] bg-gray-900/70 backdrop-blur-sm hidden items-center justify-center transition-opacity duration-300 opacity-0">
    <div class="bg-white rounded-2xl shadow-2xl w-[400px] max-w-[95%] overflow-hidden flex flex-col transform transition-all scale-95 opacity-0" id="exportModalContent">
        
        <!-- Header Modal -->
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-white">
            <h2 class="text-lg font-bold text-gray-800">Pilih Logo Export PDF</h2>
            <button onclick="closeExportModal()" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fa fa-times text-lg"></i>
            </button>
        </div>

        <!-- Body Modal -->
        <form action="{{ route('presence-detail.export-pdf', $presence->id) }}" method="GET" target="_blank" onsubmit="closeExportModal()">
            <div class="px-6 py-5 bg-gray-50/30">
                <label class="block text-sm font-bold text-gray-700 mb-3">Logo mana yang ingin ditampilkan di PDF?</label>
                <div class="space-y-3">
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                        <input type="radio" name="logo_option" value="both" class="w-4 h-4 text-red-600 focus:ring-red-500" checked>
                        <span class="ml-3 text-sm font-medium text-gray-700">Gunakan Semua Logo (Sesuai Form)</span>
                    </label>
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                        <input type="radio" name="logo_option" value="left" class="w-4 h-4 text-red-600 focus:ring-red-500">
                        <span class="ml-3 text-sm font-medium text-gray-700">Logo Kiri Saja</span>
                    </label>
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                        <input type="radio" name="logo_option" value="right" class="w-4 h-4 text-red-600 focus:ring-red-500">
                        <span class="ml-3 text-sm font-medium text-gray-700">Logo Kanan Saja</span>
                    </label>
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                        <input type="radio" name="logo_option" value="none" class="w-4 h-4 text-red-600 focus:ring-red-500">
                        <span class="ml-3 text-sm font-medium text-gray-700">Tanpa Logo (Kosongkan)</span>
                    </label>
                </div>
            </div>

            <!-- Footer Modal -->
            <div class="px-6 py-4 border-t border-gray-100 bg-white flex justify-end gap-3">
                <button type="button" onclick="closeExportModal()" class="px-4 py-2 text-sm font-semibold text-gray-600 bg-white border border-gray-300 hover:bg-gray-50 rounded-lg transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 text-sm font-bold text-white bg-red-600 hover:bg-red-700 rounded-lg shadow-sm transition flex items-center">
                    <i class="bi bi-file-earmark-pdf-fill mr-2"></i> Export Sekarang
                </button>
            </div>
        </form>
    </div>
</div>
<!-- ================= END MODAL ================= -->

@endsection

@push('js')
<script>
    // Dropdown toggle
    document.getElementById('dropdownShareBtn').addEventListener('click', function () {
        document.getElementById('dropdownShareMenu').classList.toggle('hidden');
    });

    function copyLink() {
        navigator.clipboard.writeText("{{ route('absen.index', $presence->slug) }}");
        alert('Link berhasil disalin ke clipboard!');
    }

    // Modal Export PDF
    function openExportModal() {
        const modal = document.getElementById('exportModal');
        const content = document.getElementById('exportModalContent');
        
        modal.classList.remove('hidden');
        // Trigger reflow
        void modal.offsetWidth;
        
        modal.classList.remove('opacity-0');
        modal.classList.add('flex');
        
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }

    function closeExportModal() {
        const modal = document.getElementById('exportModal');
        const content = document.getElementById('exportModalContent');
        
        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0');
        
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
    }
</script>

{{ $dataTable->scripts(attributes: ['type' => 'module']) }}

<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();
            let url = $(this).data('url');
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                $.ajax({
                    type: 'DELETE',
                    url: url,
                    success: function () { 
                        window.LaravelDataTables['presencedetails-table'].ajax.reload(null, false); 
                    },
                    error: function (xhr) {
                        alert('Gagal menghapus data!');
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });
</script>
@endpush
