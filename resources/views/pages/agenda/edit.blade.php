@extends('layouts.main')

@section('content')
<div class="max-w-4xl mx-auto py-10">
    <div class="bg-white shadow-md rounded-2xl p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-indigo-600">Edit Rapat</h2>
            <a href="{{ route('agenda.index') }}"
               class="px-4 py-2 text-sm rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition">
                Kembali
            </a>
        </div>

        <!-- Form -->
        <form action="{{ route('agenda.update', $rapat->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="nama_rapat" class="block text-sm font-medium text-gray-700">Nama Rapat</label>
                <input type="text" id="nama_rapat" name="nama_rapat"
                       value="{{ old('nama_rapat', $rapat->nama_rapat) }}"
                       class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                       required>
            </div>

            <div>
                <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal"
                       value="{{ old('tanggal', $rapat->tanggal) }}"
                       class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                       required>
            </div>

            <div>
                <label for="tempat" class="block text-sm font-medium text-gray-700">Tempat</label>
                <input type="text" id="tempat" name="tempat"
                       value="{{ old('tempat', $rapat->tempat) }}"
                       class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                       required>
            </div>

            <div>
                <label for="pic_rapat" class="block text-sm font-medium text-gray-700">PIC Rapat</label>
                <input type="text" id="pic_rapat" name="pic_rapat"
                       value="{{ old('pic_rapat', $rapat->pic_rapat) }}"
                       class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                       required>
            </div>

            <div>
                <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan</label>
                <textarea id="catatan" name="catatan" rows="3"
                          class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">{{ old('catatan', $rapat->catatan) }}</textarea>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-center gap-3 pt-4">
                <button type="submit"
                        class="px-5 py-2 rounded-xl bg-indigo-600 text-white font-medium hover:bg-indigo-700 transition">
                    Update Rapat
                </button>
                <a href="{{ route('agenda.index') }}"
                   class="px-5 py-2 rounded-xl bg-gray-200 text-gray-700 font-medium hover:bg-gray-300 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
