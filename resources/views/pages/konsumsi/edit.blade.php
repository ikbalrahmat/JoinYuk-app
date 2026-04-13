@extends('layouts.main')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6">
    <div class="bg-white p-6 rounded-2xl shadow">
        <h3 class="text-xl font-bold mb-6">Edit Pemesanan Konsumsi</h3>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-md">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-md">{{ session('error') }}</div>
        @endif

        @if (Auth::user()->hasRole(['admin', 'yanum_karawang', 'yanum_jakarta']))
        <form action="{{ route('konsumsi.update', $konsumsi->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Data Pemesan dan Rapat --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Pemesan</label>
                    <input type="text" value="{{ $konsumsi->nama_pemesan ?? 'N/A' }}" readonly
                           class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Jumlah Peserta</label>
                    <input type="text" value="{{ $konsumsi->jumlah_peserta ?? 'N/A' }}" readonly
                           class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Layout Ruangan</label>
                    <input type="text" value="{{ $konsumsi->layout_ruangan ?? 'N/A' }}" readonly
                           class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nomor Surat NDE</label>
                    <input type="text" value="{{ $konsumsi->nomor_surat_nde }}" readonly
                           class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tahun Anggaran Rapat</label>
                    <input type="number" value="{{ $konsumsi->tahun_anggaran_rapat }}" readonly
                           class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Unit Kerja</label>
                    <input type="text" value="{{ $konsumsi->unit_kerja }}" readonly
                           class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Agenda Rapat</label>
                <input type="text" value="{{ $konsumsi->agenda_rapat }}" readonly
                       class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Rapat</label>
                    <input type="date" value="{{ $konsumsi->tanggal_rapat ? $konsumsi->tanggal_rapat->format('Y-m-d') : '' }}" readonly
                           class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Jam Rapat</label>
                    <input type="time" value="{{ $konsumsi->jam_rapat }}" readonly
                           class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Dokumen NDE</label>
                @if ($konsumsi->unggah_dokumen_nde)
                    <a href="{{ asset('storage/' . $konsumsi->unggah_dokumen_nde) }}" target="_blank"
                       class="inline-block px-3 py-2 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700">
                        Lihat Dokumen
                    </a>
                @else
                    <p class="text-gray-500">Tidak ada dokumen yang diunggah.</p>
                @endif
            </div>

            {{-- Menu Konsumsi --}}
            <hr class="my-6 border-gray-200">
            <h5 class="font-semibold text-lg">Menu Konsumsi</h5>
            <div class="space-y-4">
                @foreach ($konsumsi->menu_konsumsi as $index => $menuItem)
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
                        {{-- Nama & Detail Menu --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 sr-only">Menu</label>
                            <input type="text" value="{{ $menuItem['menu'] }} - {{ $menuItem['detail'] ?? '' }}" readonly
                                   class="w-full rounded-md border-gray-300 bg-gray-100 shadow-sm px-3 py-2">
                            <input type="hidden" name="menu_konsumsi[{{ $index }}][menu]" value="{{ $menuItem['menu'] }}">
                            <input type="hidden" name="menu_konsumsi[{{ $index }}][detail]" value="{{ $menuItem['detail'] ?? '' }}">
                        </div>

                        {{-- Jumlah (Pcs) --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 sr-only">Jumlah</label>
                            <input type="text" value="{{ $menuItem['jumlah'] }} Pcs" readonly
                                   class="w-full rounded-md border-gray-300 bg-gray-100 shadow-sm px-3 py-2">
                            <input type="hidden" name="menu_konsumsi[{{ $index }}][jumlah]" value="{{ $menuItem['jumlah'] }}">
                        </div>

                        {{-- Biaya per Item + Format Rupiah --}}
                        <div class="flex items-center gap-2">
                            <input type="number" name="menu_konsumsi[{{ $index }}][biaya]" id="biaya_{{ $index }}"
                                   value="{{ $menuItem['biaya'] ?? 0 }}"
                                   class="hidden">
                            <div class="w-full relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">Rp</span>
                                <input type="text" id="biaya_display_{{ $index }}"
                                       value="{{ number_format($menuItem['biaya'] ?? 0, 0, ',', '.') }}"
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 pl-9 pr-3">
                            </div>
                        </div>

                        {{-- Input File dan Tombol OCR --}}
                        <div class="md:col-span-4 flex items-center gap-2 mt-2">
                             <input type="file" id="file-input-{{ $index }}" accept="image/*" class="w-full border rounded-lg px-3 py-2 text-sm">
                             <button type="button" onclick="processImage({{ $index }})"
                                     class="px-3 py-2 bg-purple-600 text-white text-xs font-medium rounded-lg shadow hover:bg-purple-700 transition flex-shrink-0">
                                 <i class="fa fa-receipt mr-1"></i> Proses Nota
                             </button>
                        </div>

                        {{-- Loading Indicator --}}
                        <div id="loading-{{ $index }}" class="md:col-span-4 text-center text-gray-500 text-sm hidden">
                            <i class="fa fa-spinner fa-spin"></i> Memproses nota, tunggu sebentar...
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Distribusi & Catatan --}}
            <hr class="my-6 border-gray-200">
            <div>
                <label class="block text-sm font-medium text-gray-700">Distribusi Tujuan</label>
                <textarea rows="3" readonly
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">{{ $konsumsi->distribusi_tujuan }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Catatan</label>
                <textarea rows="3" readonly
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">{{ $konsumsi->catatan }}</textarea>
            </div>

            {{-- Persetujuan & Biaya (BARU) --}}
            <hr class="my-6 border-gray-200">
            <h5 class="font-semibold text-lg">Persetujuan & Biaya</h5>

            @if($anggaran)
            <div class="p-4 bg-blue-50 text-blue-800 rounded-md">
                <p class="text-sm font-medium">Saldo Anggaran Tersedia: <strong>Rp {{ number_format($anggaran->saldo_saat_ini, 0, ',', '.') }}</strong></p>
                <p class="text-sm font-medium mt-1">Total Biaya Pemesanan: <strong id="total_biaya_display" class="{{ $konsumsi->total_biaya > $anggaran->saldo_saat_ini ? 'text-red-600' : 'text-green-600' }}">Rp {{ number_format($konsumsi->total_biaya, 0, ',', '.') }}</strong></p>
                @if($konsumsi->total_biaya > $anggaran->saldo_saat_ini)
                    <p class="text-xs text-red-600 italic mt-1">Total biaya melebihi saldo anggaran yang tersedia.</p>
                @endif
            </div>
            @endif

            <input type="hidden" name="total_biaya" id="total_biaya_hidden" value="{{ $konsumsi->total_biaya }}">

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    <option value="Menunggu" {{ $konsumsi->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Disetujui" {{ $konsumsi->status == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="Selesai" {{ $konsumsi->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Ditolak" {{ $konsumsi->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <div class="flex justify-end mt-6">
                <button type="submit"
                    class="px-5 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                    Update Pemesanan
                </button>
            </div>
        </form>
        @else
        <div class="p-4 bg-red-100 text-red-700 rounded-md">
            <h4 class="font-bold">Akses Ditolak!</h4>
            <p>Anda tidak memiliki hak akses untuk mengubah pemesanan ini.</p>
        </div>
        @endif
    </div>
</div>

{{-- Script untuk Tesseract.js --}}
<script src='https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js'></script>
<script>
    function processImage(index) {
        const fileInput = document.getElementById(`file-input-${index}`);
        const loading = document.getElementById(`loading-${index}`);
        const menuBiayaInput = document.getElementById(`biaya_${index}`);
        const menuBiayaDisplay = document.getElementById(`biaya_display_${index}`);

        if (fileInput.files.length === 0) {
            alert('Silakan pilih file gambar nota terlebih dahulu.');
            return;
        }

        const imageFile = fileInput.files[0];
        loading.classList.remove('hidden');

        Tesseract.recognize(
            imageFile,
            'eng+ind',
            { logger: m => console.log(m) }
        ).then(({ data: { text } }) => {
            console.log(text);
            loading.classList.add('hidden');
            const total = extractTotalFromText(text);

            if (total) {
                // Isi input number hidden
                menuBiayaInput.value = total;
                // Isi input text display dengan format rupiah
                menuBiayaDisplay.value = new Intl.NumberFormat('id-ID').format(total);

                // Hitung ulang total biaya keseluruhan
                updateTotalBiaya();

                alert(`Total biaya ditemukan: Rp ${new Intl.NumberFormat('id-ID').format(total)}`);
            } else {
                alert('Total biaya tidak ditemukan. Silakan masukkan manual.');
            }
        }).catch(err => {
            console.error('OCR Error:', err);
            loading.classList.add('hidden');
            alert('Terjadi kesalahan saat memproses gambar. Silakan coba lagi atau masukkan biaya manual.');
        });
    }

    function extractTotalFromText(text) {
        // Regex untuk mencari kata "TOTAL" atau "JUMLAH" diikuti angka
        const regex = /(?:TOTAL|Total|total|JUMLAH|Jumlah|jumlah)\s*(?:Rp\.?|)\s*([\d\.,]+)/i;
        const match = text.match(regex);
        if (match) {
            // Bersihkan string dari non-angka (kecuali koma/titik)
            const cleanString = match[1].replace(/,/g, '').replace(/\./g, '');
            return parseInt(cleanString);
        }

        // Jika tidak ketemu, coba regex lain untuk mencari angka terbesar
        const allNumbers = text.match(/\d{3,}/g); // Cari angka dengan 3 digit atau lebih
        if (allNumbers && allNumbers.length > 0) {
            const largestNumber = Math.max(...allNumbers.map(n => parseInt(n)));
            return largestNumber;
        }
        return null;
    }

    // Fungsi untuk menghitung ulang total biaya keseluruhan
    function updateTotalBiaya() {
        let grandTotal = 0;
        document.querySelectorAll('input[name^="menu_konsumsi"][name$="[biaya]"]').forEach(input => {
            grandTotal += parseFloat(input.value) || 0;
        });

        // Update nilai total biaya di input hidden
        document.getElementById('total_biaya_hidden').value = grandTotal;
        // Update nilai total biaya di display
        document.getElementById('total_biaya_display').textContent = `Rp ${new Intl.NumberFormat('id-ID').format(grandTotal)}`;

        // Cek apakah total biaya melebihi saldo dan beri warna
        const saldoAwal = {{ $anggaran->saldo_saat_ini ?? 0 }};
        const totalBiayaDisplay = document.getElementById('total_biaya_display');
        if (grandTotal > saldoAwal) {
            totalBiayaDisplay.classList.add('text-red-600');
            totalBiayaDisplay.classList.remove('text-green-600');
        } else {
            totalBiayaDisplay.classList.add('text-green-600');
            totalBiayaDisplay.classList.remove('text-red-600');
        }
    }

    // Panggil fungsi updateTotalBiaya setiap kali ada perubahan di input biaya per menu
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('input[id^="biaya_display_"]').forEach(input => {
            input.addEventListener('input', function(e) {
                // Hapus karakter non-angka dan ubah ke input number hidden
                const numericValue = e.target.value.replace(/[^0-9]/g, '');
                const index = e.target.id.split('_').pop();
                document.getElementById(`biaya_${index}`).value = numericValue;

                // Format ulang tampilan input
                e.target.value = new Intl.NumberFormat('id-ID').format(numericValue);

                updateTotalBiaya();
            });
        });

        // Jalankan saat halaman pertama kali dimuat untuk memastikan semua sudah ter-update
        updateTotalBiaya();
    });
</script>
@endsection
