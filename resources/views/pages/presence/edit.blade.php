@extends('layouts.main')

@section('content')
<div class="max-w-3xl mx-auto my-8">
    <div class="bg-white shadow rounded-lg">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 flex items-center">
            <i class="bi bi-pencil-square text-blue-500 mr-2"></i>
            <h5 class="text-lg font-semibold text-gray-700">Edit Kegiatan</h5>
        </div>

        <!-- Body -->
        <div class="p-6">
            <form action="{{ route('presence.update', $presence->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- Nama Kegiatan -->
                <div>
                    <label for="nama_kegiatan" class="block text-sm font-medium text-gray-700 mb-1">Nama Agenda / Kegiatan</label>
                    <input type="text" id="nama_kegiatan" name="nama_kegiatan"
                        value="{{ old('nama_kegiatan', $presence->nama_kegiatan) }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200">
                    @error('nama_kegiatan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Row: Tanggal & Waktu -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="tgl_kegiatan" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                        <input type="date" id="tgl_kegiatan" name="tgl_kegiatan"
                            value="{{ old('tgl_kegiatan', date('Y-m-d', strtotime($presence->tgl_kegiatan))) }}"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200">
                        @error('tgl_kegiatan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="waktu_mulai" class="block text-sm font-medium text-gray-700 mb-1">Waktu Mulai</label>
                        <input type="time" id="waktu_mulai" name="waktu_mulai"
                            value="{{ old('waktu_mulai', date('H:i', strtotime($presence->tgl_kegiatan))) }}"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200">
                        @error('waktu_mulai')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Tempat -->
                <div>
                    <label for="tempat" class="block text-sm font-medium text-gray-700 mb-1">Tempat</label>
                    <input type="text" id="tempat" name="tempat"
                        value="{{ old('tempat', $presence->tempat ?? '') }}"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200">
                    @error('tempat')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('presence.index') }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100">
                        <i class="bi bi-x-circle mr-1"></i> Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                        <i class="bi bi-save mr-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
