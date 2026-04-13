@extends('layouts.main')

@section('content')
<div class="bg-white rounded-xl shadow p-6">


    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-3">
        <h3 class="text-xl font-bold text-blue-600">Daftar Materi Rapat</h3>
        <a href="{{ route('materi.create') }}"
           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-700 transition">
            <i class="fa fa-plus-circle mr-2"></i> Tambah Materi
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded relative mb-4">
            <i class="fa fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded relative mb-4">
            <i class="fa fa-exclamation-triangle mr-2"></i> {{ session('error') }}
        </div>
    @endif


    <div class="overflow-x-auto">
        <table id="materiTable" class="min-w-full border border-gray-300 text-sm">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-4 py-2 text-left w-12 border border-gray-300">No</th>
                    <th class="px-4 py-2 text-left border border-gray-300">Nama Rapat</th>
                    <th class="px-4 py-2 text-left border border-gray-300">Tanggal Rapat</th>
                    <th class="px-4 py-2 text-left border border-gray-300">Judul Materi</th>
                    <th class="px-4 py-2 text-left border border-gray-300">Dokumen</th>
                    <th class="px-4 py-2 text-center w-44 border border-gray-300">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($materis as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border border-gray-300 text-center">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 border border-gray-300 font-semibold">{{ $item->undangan->agenda ?? 'Undangan Tidak Ditemukan' }}</td>
                    <td class="px-4 py-2 border border-gray-300">
                        {{ $item->undangan ? \Carbon\Carbon::parse($item->undangan->tanggal)->translatedFormat('d F Y') : '-' }}
                    </td>
                    <td class="px-4 py-2 border border-gray-300">{{ $item->judul }}</td>
                    <td class="px-4 py-2 border border-gray-300">
                        @if($item->file_path)
                            <a href="{{ Storage::url($item->file_path) }}" target="_blank"
                               class="text-blue-600 hover:underline flex items-center">
                                <i class="fa fa-file-alt mr-1"></i> Lihat Dokumen
                            </a>
                        @else
                            <span class="italic text-gray-400">Tidak ada dokumen</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 border border-gray-300">
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('materi.download', $item->id) }}"
                               class="px-2 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded text-xs" title="Download">
                                <i class="fa fa-download"></i>
                            </a>
                            <a href="{{ route('materi.edit', $item->id) }}"
                               class="px-2 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded text-xs" title="Edit">
                                <i class="fa fa-pen"></i>
                            </a>
                            <form action="{{ route('materi.destroy', $item->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus materi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-2 py-1 bg-red-500 hover:bg-red-600 text-white rounded text-xs" title="Hapus">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-3 text-center text-gray-500 border border-gray-300">Belum ada materi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
