{{-- @extends('layouts.main')

@section('content')
<div class="bg-white rounded-xl shadow p-6">


    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-3">
        <h3 class="text-xl font-bold text-blue-600">Daftar Pemesanan Konsumsi</h3>
        @if(!Auth::user()->hasAnyRole(['super_admin', 'admin', 'yanum']))
            <a href="{{ route('konsumsi.create') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-700 transition">
               <i class="fa fa-plus-circle mr-2"></i> Ajukan Pemesanan
            </a>
        @endif
    </div>


    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300 text-sm">
            <thead class="bg-blue-600 text-white text-xs uppercase">
                <tr>
                    <th class="px-4 py-2 border border-gray-300 w-12 text-center">No</th>
                    <th class="px-4 py-2 border border-gray-300 text-left">No. NDE</th>
                    <th class="px-4 py-2 border border-gray-300 text-left">Unit Kerja</th>
                    <th class="px-4 py-2 border border-gray-300 text-left">Agenda Rapat</th>
                    <th class="px-4 py-2 border border-gray-300 text-left">Tanggal & Jam</th>
                    <th class="px-4 py-2 border border-gray-300 text-left">Total Biaya</th>
                    <th class="px-4 py-2 border border-gray-300 text-left">Status</th>
                    <th class="px-4 py-2 border border-gray-300 text-center w-48">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($konsumsis as $konsumsi)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border border-gray-300 text-center">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $konsumsi->nomor_surat_nde }}</td>
                        <td class="px-4 py-2 border border-gray-300 font-semibold">{{ $konsumsi->unit_kerja }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $konsumsi->agenda_rapat }}</td>
                        <td class="px-4 py-2 border border-gray-300">
                            {{ optional($konsumsi->tanggal_rapat)->format('d-m-Y') ?? '-' }} <br>
                            <span class="text-gray-600 text-xs">{{ $konsumsi->jam_rapat }}</span>
                        </td>
                        <td class="px-4 py-2 border border-gray-300">
                            @if ($konsumsi->total_biaya || $konsumsi->total_biaya === 0)
                                Rp {{ number_format($konsumsi->total_biaya, 0, ',', '.') }}
                            @else
                                <span class="text-red-500 italic">Belum Dikonfirmasi</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 border border-gray-300">
                            @php
                                $statusColors = [
                                    'Menunggu' => 'bg-yellow-100 text-yellow-800',
                                    'Disetujui' => 'bg-green-100 text-green-800',
                                    'Selesai' => 'bg-blue-100 text-blue-800',
                                    'Ditolak' => 'bg-red-100 text-red-800'
                                ];
                            @endphp
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusColors[$konsumsi->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $konsumsi->status }}
                            </span>
                        </td>
                        <td class="px-4 py-2 border border-gray-300">
                            <div class="flex flex-wrap justify-center gap-2">
                                @if(Auth::user()->hasAnyRole(['super_admin', 'admin', 'yanum']))
                                    <a href="{{ route('konsumsi.edit', $konsumsi->id) }}"
                                       class="px-2 py-1 bg-yellow-500 hover:bg-yellow-600 text-white text-xs rounded" title="Edit">
                                       <i class="fa fa-pen"></i>
                                    </a>
                                    <a href="{{ route('konsumsi.export.pdf', $konsumsi->id) }}"
                                       class="px-2 py-1 bg-indigo-500 hover:bg-indigo-600 text-white text-xs rounded" title="Ekspor PDF">
                                       <i class="fa fa-file-pdf"></i>
                                    </a>
                                @else
                                    <a href="{{ route('konsumsi.show', $konsumsi->id) }}"
                                       class="px-2 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs rounded" title="Lihat">
                                       <i class="fa fa-eye"></i>
                                    </a>
                                    @if($konsumsi->status == 'Menunggu')
                                        <form action="{{ route('konsumsi.destroy', $konsumsi->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Yakin ingin menghapus?')"
                                                    class="px-2 py-1 bg-red-500 hover:bg-red-600 text-white text-xs rounded" title="Hapus">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-3 text-center text-gray-500 border border-gray-300">Belum ada pemesanan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection --}}


@extends('layouts.main')

@section('content')
<div class="flex items-center justify-center min-h-[400px]">
    <div class="text-center p-10 bg-white rounded-2xl shadow-sm border border-gray-100">


        <div class="mb-6">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-50 text-blue-600 rounded-full mb-4">
                <i class="fas fa-tools text-3xl animate-bounce"></i>
            </div>
        </div>

        <h1 class="text-2xl font-bold text-gray-800 mb-2">Fitur Sedang Dikembangkan</h1>
        <p class="text-gray-500 max-w-sm mx-auto mb-8">
            Halaman <strong>Fitur Konsumsi</strong> saat ini masih dalam proses pengerjaan oleh tim developer.
        </p>


    </div>
</div>
@endsection
