@extends('layouts.main')

@section('content')
<div class="max-w-4xl mx-auto my-8">
    <div class="bg-white shadow rounded-2xl overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <h5 class="text-lg font-semibold text-gray-700 flex items-center">
                <i class="bi bi-calendar-plus mr-2"></i> Tambah Kegiatan
            </h5>
        </div>

        <!-- Body -->
        <div class="p-6">
            <form action="{{ route('presence.store') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Nama Kegiatan -->
                <div>
                    <label for="nama_kegiatan" class="block text-sm font-medium text-gray-700">Nama Agenda / Kegiatan</label>
                    <input type="text" id="nama_kegiatan" name="nama_kegiatan"
                        value="{{ old('nama_kegiatan') }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        placeholder="Masukkan nama kegiatan">
                    @error('nama_kegiatan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal & Waktu -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="tgl_kegiatan" class="block text-sm font-medium text-gray-700">Tanggal</label>
                        <input type="date" id="tgl_kegiatan" name="tgl_kegiatan"
                            value="{{ old('tgl_kegiatan') }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('tgl_kegiatan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="waktu_mulai" class="block text-sm font-medium text-gray-700">Waktu Mulai</label>
                        <input type="time" id="waktu_mulai" name="waktu_mulai"
                            value="{{ old('waktu_mulai') }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('waktu_mulai')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Tempat -->
                <div>
                    <label for="tempat" class="block text-sm font-medium text-gray-700">Tempat</label>
                    <input type="text" id="tempat" name="tempat"
                        value="{{ old('tempat') }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        placeholder="Masukkan tempat kegiatan">
                    @error('tempat')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol -->
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('presence.index') }}"
                        class="px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 flex items-center">
                        <i class="bi bi-x-circle mr-1"></i> Batal
                    </a>
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 shadow flex items-center">
                        <i class="bi bi-save mr-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
