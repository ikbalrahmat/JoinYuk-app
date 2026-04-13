{{-- @extends('layouts.main')

@section('content')
<div class="bg-white rounded-xl shadow p-6">


    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-3">
        <h3 class="text-xl font-bold text-blue-600">Manajemen Anggaran</h3>
        <a href="{{ route('anggaran.create') }}"
           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-700 transition">
            <i class="fa fa-plus-circle mr-2"></i> Tambah Anggaran
        </a>
    </div>


    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300 text-sm">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-4 py-2 border border-gray-300 w-12 text-center">No</th>
                    <th class="px-4 py-2 border border-gray-300 text-left">Nama Unit Kerja</th>
                    <th class="px-4 py-2 border border-gray-300 text-left">Tahun Anggaran</th>
                    <th class="px-4 py-2 border border-gray-300 text-left">Total Anggaran</th>
                    <th class="px-4 py-2 border border-gray-300 text-left">Saldo Saat Ini</th>
                    <th class="px-4 py-2 border border-gray-300 text-left">Penggunaan</th>
                    <th class="px-4 py-2 border border-gray-300 text-left">Status</th>
                    <th class="px-4 py-2 border border-gray-300 text-center w-48">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($anggarans as $anggaran)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border border-gray-300 text-center">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 border border-gray-300 font-semibold">{{ $anggaran->nama_unit_kerja }}</td>
                    <td class="px-4 py-2 border border-gray-300">{{ $anggaran->tahun_anggaran }}</td>
                    <td class="px-4 py-2 border border-gray-300">Rp {{ number_format($anggaran->total_anggaran, 0, ',', '.') }}</td>
                    <td class="px-4 py-2 border border-gray-300">Rp {{ number_format($anggaran->saldo_saat_ini, 0, ',', '.') }}</td>
                    <td class="px-4 py-2 border border-gray-300">Rp {{ number_format($anggaran->total_anggaran - $anggaran->saldo_saat_ini, 0, ',', '.') }}</td>
                    <td class="px-4 py-2 border border-gray-300">
                        <span class="px-2 py-1 text-xs font-medium rounded-full
                            {{ $anggaran->saldo_saat_ini > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $anggaran->status }}
                        </span>
                    </td>
                    <td class="px-4 py-2 border border-gray-300">
                        <div class="flex flex-wrap justify-center gap-2">
                            <a href="{{ route('anggaran.edit', $anggaran->id) }}"
                               class="px-2 py-1 bg-yellow-500 hover:bg-yellow-600 text-white text-xs rounded" title="Edit">
                                <i class="fa fa-pen"></i>
                            </a>
                            <form action="{{ route('anggaran.destroy', $anggaran->id) }}" method="POST"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggaran ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-2 py-1 bg-red-500 hover:bg-red-600 text-white text-xs rounded" title="Hapus">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                            <button type="button"
                                    onclick="openModal('modal-{{ $anggaran->id }}')"
                                    class="px-2 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs rounded" title="Top-up">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </td>
                </tr>


                <div id="modal-{{ $anggaran->id }}" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                    <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
                        <form action="{{ route('anggaran.topup', $anggaran->id) }}" method="POST">
                            @csrf
                            <div class="px-6 py-4 border-b flex justify-between items-center">
                                <h5 class="font-semibold text-gray-800">Top-up Anggaran {{ $anggaran->nama_unit_kerja }}</h5>
                                <button type="button" onclick="closeModal('modal-{{ $anggaran->id }}')" class="text-gray-500 hover:text-gray-700">&times;</button>
                            </div>
                            <div class="px-6 py-4">
                                <label for="topup_amount" class="block text-sm font-medium text-gray-700">Jumlah Top-up</label>
                                <input type="number" name="topup_amount" id="topup_amount"
                                       class="mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                       required min="1">
                            </div>
                            <div class="px-6 py-4 border-t flex justify-end gap-2">
                                <button type="button" onclick="closeModal('modal-{{ $anggaran->id }}')"
                                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm rounded-lg">
                                    Tutup
                                </button>
                                <button type="submit"
                                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                @empty
                <tr>
                    <td colspan="8" class="px-4 py-3 text-center text-gray-500 border border-gray-300">Belum ada anggaran</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }
</script>
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
            Halaman <strong>Manajemen Anggaran</strong> saat ini masih dalam proses pengerjaan oleh tim developer.
        </p>


    </div>
</div>
@endsection
