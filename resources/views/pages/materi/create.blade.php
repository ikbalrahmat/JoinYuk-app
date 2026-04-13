@extends('layouts.main')

@section('content')
<div class="bg-white rounded-xl shadow p-6 max-w-3xl mx-auto">

    <h3 class="text-xl font-bold text-blue-600 mb-6">Tambah Materi Rapat Baru</h3>

    @if(session('error'))
        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('materi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <div>
            <label for="undangan_id" class="block font-medium text-gray-700 mb-1">Pilih Undangan Rapat</label>
            <select id="undangan_id" name="undangan_id" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                <option value="">-- Pilih Undangan --</option>
                @foreach($undangans as $undangan)
                    <option value="{{ $undangan->id }}" {{ old('undangan_id') == $undangan->id ? 'selected' : '' }}>
                        {{ $undangan->agenda }} ({{ \Carbon\Carbon::parse($undangan->tanggal)->translatedFormat('d F Y') }})
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="judul" class="block font-medium text-gray-700 mb-1">Judul Materi</label>
            <input type="text" id="judul" name="judul" value="{{ old('judul') }}" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label for="file_materi" class="block font-medium text-gray-700 mb-1">Upload Dokumen Materi</label>
            <input type="file" id="file_materi" name="file_materi" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white">
            <p class="text-sm text-gray-500 mt-1">Format: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX (Max: 10MB)</p>
        </div>

        <div class="flex gap-3">
            <button type="submit"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">
                Simpan Materi
            </button>
            <a href="{{ route('materi.index') }}"
               class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg shadow">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
