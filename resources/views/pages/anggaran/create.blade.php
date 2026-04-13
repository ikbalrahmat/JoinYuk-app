@extends('layouts.main')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-6">Tambah Anggaran</h2>
    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('anggaran.store') }}" method="POST" class="space-y-5">
            @csrf
            <!-- Nama Unit Kerja -->
            <div>
                <label for="nama_unit_kerja" class="block text-sm font-medium text-gray-700">Nama Unit Kerja</label>
                <input type="text" id="nama_unit_kerja" name="nama_unit_kerja" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <!-- Tahun Anggaran -->
            <div>
                <label for="tahun_anggaran" class="block text-sm font-medium text-gray-700">Tahun Anggaran</label>
                <input type="number" id="tahun_anggaran" name="tahun_anggaran" value="{{ date('Y') }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <!-- Total Anggaran -->
            <div>
                <label for="total_anggaran" class="block text-sm font-medium text-gray-700">Total Anggaran</label>
                <input type="number" id="total_anggaran" name="total_anggaran" required min="0"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <!-- Tombol -->
            <div class="flex items-center space-x-3">
                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md shadow-sm text-sm font-medium">
                    Simpan
                </button>
                <a href="{{ route('anggaran.index') }}"
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md shadow-sm text-sm font-medium">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
