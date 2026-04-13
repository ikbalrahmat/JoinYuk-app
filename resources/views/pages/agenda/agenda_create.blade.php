@extends('layouts.main')

@section('content')
<div class="max-w-3xl mx-auto py-6">
    <!-- Header -->
    <div class="bg-white shadow rounded-xl border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">
                Tambah Item Agenda untuk Rapat:
                <span class="text-blue-600">{{ $rapat->nama_rapat }}</span>
            </h2>
        </div>

        <div class="p-6">

            @if(session('success'))
                <div class="mb-4 rounded-lg bg-green-100 border border-green-300 text-green-800 px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 rounded-lg bg-red-100 border border-red-300 text-red-800 px-4 py-3">
                    <strong class="font-semibold">Terjadi kesalahan:</strong>
                    <ul class="list-disc list-inside mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <form action="{{ route('agenda.items.store', $rapat->id) }}" method="POST" class="space-y-6">
                @csrf

                <div class="border-b border-gray-200 pb-4">
                    <label for="jam" class="block text-sm font-medium text-gray-700 mb-2">Jam</label>
                    <input type="text" name="jam" id="jam"
                        class="w-full rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2"
                        value="{{ old('jam') }}" required>
                </div>

                <div class="border-b border-gray-200 pb-4">
                    <label for="agenda" class="block text-sm font-medium text-gray-700 mb-2">Agenda</label>
                    <textarea name="agenda" id="agenda" rows="4"
                        class="w-full rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2"
                        required>{{ old('agenda') }}</textarea>
                </div>

                <div>
                    <label for="pic" class="block text-sm font-medium text-gray-700 mb-2">PIC</label>
                    <input type="text" name="pic" id="pic"
                        class="w-full rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 px-3 py-2"
                        value="{{ old('pic') }}" required>
                </div>

                <div class="flex items-center space-x-3 pt-6">
                    <button type="submit"
                        class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                        Simpan
                    </button>
                    <a href="{{ route('agenda.show', $rapat->id) }}"
                        class="bg-gray-300 text-gray-800 px-5 py-2 rounded-lg shadow hover:bg-gray-400 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
