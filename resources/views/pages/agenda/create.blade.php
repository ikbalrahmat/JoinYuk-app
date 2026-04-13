@extends('layouts.main')

@section('content')
<div class="container mx-auto py-8 px-4">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Agenda Rapat</h1>
        <a href="{{ route('agenda.index') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-lg shadow">
            <i class="bi bi-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <!-- Error -->
    @if ($errors->any())
        <div class="mb-4 p-4 rounded-lg bg-red-100 border border-red-400 text-red-700">
            <strong>Terjadi kesalahan!</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form -->
    <form action="{{ route('agenda.store') }}" method="POST" class="space-y-5 bg-white p-6 rounded-xl shadow">
        @csrf

        <!-- Pilih Undangan -->
        <div>
            <label for="undangan_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Undangan Rapat</label>
            <select id="undangan_id" name="undangan_id" required
                class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                <option value="">-- Pilih Undangan --</option>
                @foreach($undangan as $item)
                    <option value="{{ $item->id }}"
                            data-nama-rapat="{{ $item->agenda }}"
                            data-tanggal="{{ $item->tanggal }}"
                            data-tempat="{{ $item->tempat_link }}">
                        {{ $item->agenda }} - {{ \Carbon\Carbon::parse($item->tanggal)->format('d F Y') }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Hidden Inputs -->
        <input type="hidden" id="nama_rapat" name="nama_rapat" required>
        <input type="hidden" id="tanggal" name="tanggal" required>
        <input type="hidden" id="tempat" name="tempat" required>

        <!-- PIC Rapat -->
        <div>
            <label for="pic_rapat" class="block text-sm font-medium text-gray-700 mb-1">PIC Rapat</label>
            <input type="text" id="pic_rapat" name="pic_rapat" required
                class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
        </div>

        <!-- Catatan -->
        <div>
            <label for="catatan" class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
            <textarea id="catatan" name="catatan" rows="3"
                class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"></textarea>
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-3">
            <button type="submit"
                class="inline-flex items-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg shadow">
                <i class="bi bi-save mr-2"></i> Simpan Rapat
            </button>
            <a href="{{ route('agenda.index') }}"
               class="inline-flex items-center px-5 py-2.5 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-lg shadow">
                Batal
            </a>
        </div>
    </form>
</div>

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const undanganDropdown = document.getElementById('undangan_id');
    const namaRapatInput   = document.getElementById('nama_rapat');
    const tanggalInput     = document.getElementById('tanggal');
    const tempatInput      = document.getElementById('tempat');

    undanganDropdown.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];

        if (selectedOption.value !== "") {
            namaRapatInput.value = selectedOption.getAttribute('data-nama-rapat') || '';
            tanggalInput.value   = selectedOption.getAttribute('data-tanggal') || '';
            tempatInput.value    = selectedOption.getAttribute('data-tempat') || '';
        } else {
            namaRapatInput.value = '';
            tanggalInput.value   = '';
            tempatInput.value    = '';
        }
    });
});
</script>
@endpush
@endsection
