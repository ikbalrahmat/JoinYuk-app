@extends('layouts.main')

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">
        Pertanyaan untuk Survey: {{ $survey->judul }}
    </h2>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-lg shadow">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form tambah pertanyaan -->
    <form action="{{ route('survey.questions.store', $survey->id) }}" method="POST" class="flex gap-3 mb-6">
        @csrf
        <input type="text" name="pertanyaan"
            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
            placeholder="Tulis pertanyaan baru..." required>
        <button
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            Tambah
        </button>
    </form>

    <!-- Tabel pertanyaan -->
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="w-full text-sm text-left border-collapse">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-2 border">No</th>
                    <th class="px-4 py-2 border">Pertanyaan</th>
                    <th class="px-4 py-2 border text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($survey->questions as $index => $q)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border">{{ $q->pertanyaan }}</td>
                        <td class="px-4 py-2 border text-center">
                            <form action="{{ route('survey.questions.destroy', $q->id ?? 0) }}" method="POST"
                                  onsubmit="return confirm('Hapus pertanyaan ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="px-3 py-1 bg-red-500 text-white text-sm rounded-lg hover:bg-red-600 transition">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                @if(count($survey->questions) == 0)
                    <tr>
                        <td colspan="3" class="px-4 py-3 text-center text-gray-500">
                            Belum ada pertanyaan
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Tombol kembali -->
    <a href="{{ route('survey.index') }}"
       class="inline-block mt-6 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
        Kembali ke Daftar Survey
    </a>
</div>
@endsection
