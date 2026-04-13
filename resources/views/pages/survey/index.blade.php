@extends('layouts.main')

@section('content')
<div class="bg-white rounded-xl shadow p-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-3">
        <h3 class="text-xl font-bold text-blue-600">Daftar Survey</h3>
        <a href="{{ route('survey.create') }}"
           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-700 transition">
            <i class="fa fa-plus-circle mr-2"></i> Buat Survey
        </a>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300 text-sm">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-4 py-2 border border-gray-300 w-12 text-center">No</th>
                    <th class="px-4 py-2 border border-gray-300 text-left">Judul Survey</th>
                    <th class="px-4 py-2 border border-gray-300 text-left">Tanggal Dibuat</th>
                    <th class="px-4 py-2 border border-gray-300 text-left">Deadline</th>
                    <th class="px-4 py-2 border border-gray-300 text-left">Status</th>
                    <th class="px-4 py-2 border border-gray-300 text-center">Jumlah Responden</th>
                    <th class="px-4 py-2 border border-gray-300 text-center w-60">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($surveys as $survey)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border border-gray-300 text-center">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 border border-gray-300 font-semibold">{{ $survey->judul }}</td>
                    <td class="px-4 py-2 border border-gray-300">{{ $survey->created_at->format('d-m-Y') }}</td>
                    <td class="px-4 py-2 border border-gray-300">
                        {{ $survey->deadline ? \Carbon\Carbon::parse($survey->deadline)->format('d-m-Y') : '-' }}
                    </td>
                    <td class="px-4 py-2 border border-gray-300">
                        <span class="px-2 py-1 text-xs rounded-full
                            {{ $survey->status == 'Aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-700' }}">
                            {{ $survey->status }}
                        </span>
                    </td>
                    <td class="px-4 py-2 border border-gray-300 text-center">{{ $survey->respondents_count }}</td>
                    <td class="px-4 py-2 border border-gray-300">
                        <div class="flex flex-wrap justify-center gap-2">
                            <a href="{{ route('survey.edit', $survey->id) }}"
                               class="px-2 py-1 bg-yellow-500 hover:bg-yellow-600 text-white text-xs rounded" title="Edit">
                                <i class="fa fa-pen"></i>
                            </a>

                            <form action="{{ route('survey.destroy', $survey->id) }}" method="POST"
                                  onsubmit="return confirm('Hapus survey ini?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="px-2 py-1 bg-red-500 hover:bg-red-600 text-white text-xs rounded" title="Hapus">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>

                            <a href="{{ route('survey.questions.index', $survey->id) }}"
                               class="px-2 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs rounded" title="Pertanyaan">
                                <i class="fa fa-question-circle"></i>
                            </a>

                            @if($survey->status == 'Aktif')
                                @php
                                    $publicLink = route('survey.public.create', $survey->id);
                                @endphp
                                <a href="{{ $publicLink }}" target="_blank"
                                   class="px-2 py-1 bg-green-500 hover:bg-green-600 text-white text-xs rounded" title="Link Isi">
                                    <i class="fa fa-link"></i>
                                </a>
                                <button type="button"
                                        class="px-2 py-1 border border-gray-300 text-gray-600 text-xs rounded hover:bg-gray-100"
                                        onclick="navigator.clipboard.writeText('{{ $publicLink }}').then(() => {
                                            alert('Link survey disalin: {{ $publicLink }}');
                                        }).catch(err => { alert('Gagal menyalin link'); });" title="Copy Link">
                                    <i class="fa fa-copy"></i>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-3 text-center text-gray-500 border border-gray-300">Belum ada survey</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
