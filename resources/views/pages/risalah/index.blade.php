@extends('layouts.main')

@section('content')
<div class="bg-white rounded-xl shadow p-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-3">
        <h3 class="text-xl font-bold text-blue-600">Daftar Risalah</h3>
        <a href="{{ route('risalah.create') }}"
           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-700 transition">
            <i class="fa fa-book mr-2"></i> Tambah Risalah Baru
        </a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded relative mb-4">
            <i class="fa fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300 text-sm">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-4 py-2 border border-gray-300 w-12 text-center">No</th>
                    <th class="px-4 py-2 border border-gray-300">Agenda Rapat</th>
                    <th class="px-4 py-2 border border-gray-300">Pimpinan</th>
                    <th class="px-4 py-2 border border-gray-300">Jenis Rapat</th>
                    <th class="px-4 py-2 border border-gray-300">Tanggal</th>
                    <th class="px-4 py-2 border border-gray-300 text-center w-56">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($risalahs as $index => $r)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border border-gray-300 text-center">{{ $index + 1 }}</td>
                    <td class="px-4 py-2 border border-gray-300 font-semibold">{{ $r->undangan->agenda ?? 'Undangan Tidak Ditemukan' }}</td>
                    <td class="px-4 py-2 border border-gray-300">{{ $r->pimpinan }}</td>
                    <td class="px-4 py-2 border border-gray-300">{{ $r->jenis_rapat }}</td>
                    <td class="px-4 py-2 border border-gray-300">
                        {{ $r->undangan ? \Carbon\Carbon::parse($r->undangan->tanggal)->translatedFormat('d F Y') : '-' }}
                    </td>
                    <td class="px-4 py-2 border border-gray-300">
                        <div class="flex justify-center space-x-2">
                            {{-- Preview --}}
                            <button onclick="openModal('modal-{{ $r->id }}')"
                                class="px-2 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded text-xs" title="Preview">
                                <i class="fa fa-eye"></i>
                            </button>
                            {{-- Edit --}}
                            <a href="{{ route('risalah.edit', $r->id) }}"
                               class="px-2 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded text-xs" title="Edit">
                                <i class="fa fa-pen"></i>
                            </a>
                            {{-- Hapus --}}
                            <form action="{{ route('risalah.destroy', $r->id) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Yakin hapus risalah ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-2 py-1 bg-red-500 hover:bg-red-600 text-white rounded text-xs" title="Hapus">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                            {{-- Export --}}
                            <a href="{{ route('risalah.export', $r->id) }}"
                               class="px-2 py-1 bg-green-500 hover:bg-green-600 text-white rounded text-xs" title="Export PDF">
                                <i class="fa fa-file-pdf"></i>
                            </a>
                        </div>
                    </td>
                </tr>

                {{-- Modal Preview --}}
                <div id="modal-{{ $r->id }}" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white w-11/12 lg:w-4/5 xl:w-3/4 h-[80vh] rounded-xl shadow-lg flex flex-col">
                        <div class="flex justify-between items-center border-b px-4 py-2">
                            <h5 class="font-semibold">Preview Risalah: {{ $r->undangan->agenda ?? '-' }}</h5>
                            <button onclick="closeModal('modal-{{ $r->id }}')" class="text-gray-500 hover:text-gray-800">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                        <div class="flex-grow">
                            <iframe src="{{ route('risalah.preview', $r->id) }}"
                                    class="w-full h-full rounded-b-xl" frameborder="0"></iframe>
                        </div>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-3 text-center text-gray-500 border border-gray-300">
                        Belum ada risalah.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('js')
<script>
    function openModal(id) {
        document.getElementById(id).classList.remove("hidden");
    }
    function closeModal(id) {
        document.getElementById(id).classList.add("hidden");
    }
</script>
@endpush
@endsection
