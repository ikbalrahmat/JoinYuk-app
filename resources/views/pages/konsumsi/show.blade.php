@extends('layouts.main')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-8">
    <h2 class="text-3xl font-bold mb-8 text-gray-800 border-b pb-3">
        Detail Pemesanan Konsumsi
    </h2>

    <div class="bg-white shadow-lg rounded-xl p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8">
            <div>
                <p class="text-gray-500 text-sm">Nama Pemesan</p>
                <p class="font-semibold text-gray-800">{{ $konsumsi->nama_pemesan ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Jumlah Peserta</p>
                <p class="font-semibold text-gray-800">{{ $konsumsi->jumlah_peserta ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Layout Ruangan</p>
                <p class="font-semibold text-gray-800">{{ $konsumsi->layout_ruangan ?? '-' }}</p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">No. NDE</p>
                <p class="font-semibold text-gray-800">{{ $konsumsi->nomor_surat_nde }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Unit Kerja</p>
                <p class="font-semibold text-gray-800">{{ $konsumsi->unit_kerja }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Agenda Rapat</p>
                <p class="font-semibold text-gray-800">{{ $konsumsi->agenda_rapat }}</p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Tanggal Rapat</p>
                <p class="font-semibold text-gray-800">
                    {{ optional($konsumsi->tanggal_rapat)->format('d-m-Y') ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Jam Rapat</p>
                <p class="font-semibold text-gray-800">{{ $konsumsi->jam_rapat }}</p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Total Biaya</p>
                <p class="font-semibold
                    {{ $konsumsi->total_biaya || $konsumsi->total_biaya === 0 ? 'text-gray-800' : 'text-red-500' }}">
                    @if ($konsumsi->total_biaya || $konsumsi->total_biaya === 0)
                        Rp {{ number_format($konsumsi->total_biaya, 0, ',', '.') }}
                    @else
                        Belum Dikonfirmasi
                    @endif
                </p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Status</p>
                <span class="inline-block px-3 py-1 rounded-full text-sm font-medium
                    @if($konsumsi->status === 'Disetujui') bg-green-100 text-green-700
                    @elseif($konsumsi->status === 'Ditolak') bg-red-100 text-red-700
                    @else bg-yellow-100 text-yellow-700 @endif">
                    {{ $konsumsi->status }}
                </span>
            </div>
        </div>


        <div class="mt-8 border-t pt-6">
            <h3 class="text-xl font-bold mb-4 text-gray-700">Detail Menu Konsumsi</h3>
            <div class="space-y-4">
                @forelse ($konsumsi->menu_konsumsi as $menuItem)
                    <div class="flex items-center space-x-4 p-4 border rounded-lg bg-gray-50">
                        <div class="flex-grow">
                            <p class="font-medium text-lg">{{ $menuItem['menu'] }}</p>
                            @if(isset($menuItem['detail']))
                                <p class="text-gray-500 text-sm">{{ $menuItem['detail'] }}</p>
                            @endif
                        </div>
                        <div class="text-right">
                            <p class="text-gray-600">
                                <span class="font-bold text-gray-800">{{ $menuItem['jumlah'] }}</span> Pcs
                            </p>
                            @if(isset($menuItem['biaya']) && $menuItem['biaya'] > 0)
                                <p class="text-gray-600">Rp {{ number_format($menuItem['biaya'], 0, ',', '.') }}</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 italic">Tidak ada menu konsumsi yang tercatat.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="mt-6 flex justify-end">
        <a href="{{ route('konsumsi.index') }}"
           class="px-5 py-2 rounded-lg bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium transition">
            Kembali
        </a>
    </div>
</div>
@endsection
