@extends('layouts.main')

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">
        Isi Survey: {{ $survey->judul }}
    </h2>

    <form action="{{ route('survey.responses.store', $survey->id) }}" method="POST" class="space-y-6">
        @csrf
        @foreach ($survey->questions as $q)
            <div class="p-4 border rounded-lg shadow-sm bg-white">
                <label class="block text-gray-700 font-medium mb-2">
                    {{ $q->pertanyaan }}
                </label>
                <div class="flex gap-4">
                    @for ($i = 1; $i <= 5; $i++)
                        <label class="flex items-center gap-1 cursor-pointer">
                            <input type="radio" name="jawaban_{{ $q->id }}" value="{{ $i }}" class="text-blue-600" required>
                            <span class="text-gray-600">{{ $i }}</span>
                        </label>
                    @endfor
                </div>
            </div>
        @endforeach

        <button
            class="w-full py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition">
            Kirim Jawaban
        </button>
    </form>
</div>
@endsection
