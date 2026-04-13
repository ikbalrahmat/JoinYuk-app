@extends('layouts.main')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <div class="bg-white shadow-md rounded-2xl overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h5 class="text-lg font-semibold text-gray-700">Edit Item Agenda</h5>
        </div>

        <!-- Body -->
        <div class="px-6 py-6">
            <form action="{{ route('agenda.items.update', ['rapat' => $rapat->id, 'agenda' => $agenda->id]) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- Jam -->
                <div>
                    <label for="jam" class="block text-sm font-medium text-gray-700 mb-1">Jam</label>
                    <input type="text" id="jam" name="jam"
                        value="{{ old('jam', $agenda->jam) }}"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>

                <!-- Agenda -->
                <div>
                    <label for="agenda" class="block text-sm font-medium text-gray-700 mb-1">Agenda</label>
                    <input type="text" id="agenda" name="agenda"
                        value="{{ old('agenda', $agenda->agenda) }}"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>

                <!-- PIC -->
                <div>
                    <label for="pic" class="block text-sm font-medium text-gray-700 mb-1">PIC</label>
                    <input type="text" id="pic" name="pic"
                        value="{{ old('pic', $agenda->pic) }}"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-3 pt-4">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition">
                        Update Agenda
                    </button>
                    <a href="{{ route('agenda.show', $rapat->id) }}"
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg shadow-sm transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
