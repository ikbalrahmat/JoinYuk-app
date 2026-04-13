@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 my-6">
    <div class="bg-white p-6 rounded-2xl shadow border border-gray-200">
        <h3 class="text-xl font-bold text-gray-800 mb-6">Tambah Risalah Baru</h3>

        <form method="POST" action="{{ route('risalah.store') }}" class="space-y-5">
            @csrf

            <!-- Pilih Undangan -->
            <div>
                <label for="undangan_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Undangan Rapat</label>
                <select name="undangan_id" id="undangan_id"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm @error('undangan_id') border-red-500 @enderror"
                        required>
                    <option value="">-- Pilih Undangan --</option>
                    @foreach($undangans as $undangan)
                        <option value="{{ $undangan->id }}"
                                data-agenda="{{ $undangan->agenda }}"
                                data-tanggal="{{ $undangan->tanggal }}"
                                data-jam="{{ $undangan->jam }}"
                                data-tempat-link="{{ $undangan->tempat_link }}">
                            {{ $undangan->agenda }} ({{ \Carbon\Carbon::parse($undangan->tanggal)->format('d M Y') }})
                        </option>
                    @endforeach
                </select>
                @error('undangan_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Pilih Absensi -->
            <div>
                <label for="presence_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Absensi</label>
                <select name="presence_id" id="presence_id"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm @error('presence_id') border-red-500 @enderror"
                        required>
                    <option value="">-- Pilih Absensi --</option>
                    @foreach($presences as $p)
                        <option value="{{ $p->id }}">{{ $p->nama_kegiatan }} ({{ \Carbon\Carbon::parse($p->tgl_kegiatan)->format('d M Y') }})</option>
                    @endforeach
                </select>
                @error('presence_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Info Undangan -->
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Agenda Rapat</label>
                    <input type="text" id="agenda" class="w-full border-gray-300 rounded-lg shadow-sm text-sm" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Rapat</label>
                    <input type="date" id="tanggal" class="w-full border-gray-300 rounded-lg shadow-sm text-sm" readonly>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Mulai</label>
                    <input type="time" id="waktu_mulai" class="w-full border-gray-300 rounded-lg shadow-sm text-sm" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Selesai</label>
                    <input type="time" id="waktu_selesai" class="w-full border-gray-300 rounded-lg shadow-sm text-sm" readonly>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Rapat</label>
                <input type="text" id="tempat" class="w-full border-gray-300 rounded-lg shadow-sm text-sm" readonly>
            </div>

            <!-- Input Lain -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pimpinan Rapat</label>
                <input type="text" name="pimpinan" value="{{ old('pimpinan') }}"
                       class="w-full border-gray-300 rounded-lg shadow-sm text-sm @error('pimpinan') border-red-500 @enderror" required>
                @error('pimpinan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pencatat Rapat</label>
                <input type="text" name="pencatat" value="{{ old('pencatat') }}"
                       class="w-full border-gray-300 rounded-lg shadow-sm text-sm @error('pencatat') border-red-500 @enderror" required>
                @error('pencatat')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Rapat</label>
                <div class="flex flex-wrap gap-4 text-sm text-gray-700">
                    @php $jenisOptions = ['Entry Meeting','Expose Meeting','Exit Meeting','Lainnya']; @endphp
                    @foreach($jenisOptions as $jenis)
                        <label>
                            <input type="radio" name="jenis_rapat" value="{{ $jenis }}" class="mr-1"
                                   {{ old('jenis_rapat') === $jenis ? 'checked' : '' }}>
                            {{ $jenis }}
                        </label>
                    @endforeach
                </div>
                @error('jenis_rapat')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Penjelasan Rapat</label>
                <textarea name="penjelasan" id="penjelasan-editor" rows="5"
                          class="w-full border-gray-300 rounded-lg shadow-sm text-sm">{{ old('penjelasan') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kesimpulan</label>
                <textarea name="kesimpulan" id="kesimpulan-editor" rows="5"
                          class="w-full border-gray-300 rounded-lg shadow-sm text-sm">{{ old('kesimpulan') }}</textarea>
            </div>

            <!-- Tombol -->
            <div class="flex justify-between">
                <a href="{{ route('risalah.index') }}"
                   class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 text-sm font-medium hover:bg-gray-300">Kembali</a>
                <button type="submit"
                        class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700">
                    Simpan Risalah
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('undangan_id').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            document.getElementById('agenda').value = selectedOption.getAttribute('data-agenda');
            document.getElementById('tanggal').value = selectedOption.getAttribute('data-tanggal');
            document.getElementById('waktu_mulai').value = selectedOption.getAttribute('data-jam');
            document.getElementById('tempat').value = selectedOption.getAttribute('data-tempat-link');
        } else {
            document.getElementById('agenda').value = '';
            document.getElementById('tanggal').value = '';
            document.getElementById('waktu_mulai').value = '';
            document.getElementById('tempat').value = '';
        }
    });
</script>

<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
    ClassicEditor.create(document.querySelector('#penjelasan-editor')).catch(console.error);
    ClassicEditor.create(document.querySelector('#kesimpulan-editor')).catch(console.error);
</script>
@endsection
