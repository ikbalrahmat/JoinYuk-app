@extends('layouts.main')

@section('content')
<div class="py-6">
    <div class="bg-white shadow rounded-2xl p-6">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 mb-1">Susunan Acara Rapat</h1>
                <h3 class="text-lg font-semibold text-indigo-600">{{ $rapat->nama_rapat }}</h3>
                <p class="text-sm text-gray-600"><span class="font-medium">Tanggal:</span> {{ $rapat->tanggal }}</p>
                <p class="text-sm text-gray-600"><span class="font-medium">Tempat:</span> {{ $rapat->tempat }}</p>
                <p class="text-sm text-gray-600"><span class="font-medium">PIC:</span> {{ $rapat->pic_rapat }}</p>
                <p class="text-sm text-gray-600"><span class="font-medium">Catatan:</span> {{ $rapat->catatan }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('agenda.items.create', $rapat->id) }}"
                   class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg shadow">
                    <i class="bi bi-plus-circle mr-2"></i> Tambah Item Agenda
                </a>
                <a href="{{ route('agenda.export-pdf', $rapat->id) }}"
                   class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg shadow">
                    <i class="bi bi-file-pdf mr-2"></i> Export PDF
                </a>
            </div>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-700 text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700 text-sm font-medium">
                {{ session('error') }}
            </div>
        @endif

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">No</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Jam</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Agenda</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">PIC</th>
                        <th class="px-4 py-2 text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rapat->agendaRapat as $item)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $item->jam }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $item->agenda }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $item->pic }}</td>
                            <td class="px-4 py-2 text-sm flex gap-2">
                                <a href="{{ route('agenda.items.edit', ['rapat' => $rapat->id, 'agenda' => $item->id]) }}"
                                   class="inline-flex items-center px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md text-xs font-medium">
                                    <i class="bi bi-pencil mr-1"></i> Edit
                                </a>
                                <form action="{{ route('agenda.items.destroy', ['rapat' => $rapat->id, 'agenda' => $item->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus item agenda ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded-md text-xs font-medium">
                                        <i class="bi bi-trash mr-1"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-sm text-gray-500">Belum ada item agenda</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Back button --}}
        <div class="mt-6">
            <a href="{{ route('agenda.index') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-lg shadow">
                <i class="bi bi-arrow-left mr-2"></i> Kembali ke Daftar Rapat
            </a>
        </div>
    </div>
</div>
@endsection
