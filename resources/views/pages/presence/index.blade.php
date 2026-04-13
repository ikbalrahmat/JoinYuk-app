@extends('layouts.main')

@section('content')
<div class="p-6">
    <div class="bg-white shadow rounded-2xl p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Riwayat Agenda / Kegiatan</h3>
            <a href="{{ route('presence.create') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-xl shadow hover:bg-blue-700 transition">
                <i class="bi bi-calendar-plus mr-2"></i> Buat Absensi Baru
            </a>
        </div>

        <div class="overflow-x-auto">
            {{ $dataTable->table([
                'class' => 'min-w-full text-sm text-gray-700 border border-gray-200 rounded-lg'
            ]) }}
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    /* ====== DataTable Styling (Tailwind) ====== */
    table.dataTable {
        @apply min-w-full border border-gray-200 rounded-lg overflow-hidden;
    }
    table.dataTable thead tr {
        @apply bg-gray-100 text-gray-700 text-sm uppercase;
    }
    table.dataTable thead th {
        @apply px-4 py-3 text-left font-semibold border-b border-gray-200;
    }
    table.dataTable tbody tr {
        @apply hover:bg-gray-50 transition;
    }
    table.dataTable tbody td {
        @apply px-4 py-3 border-b border-gray-100 text-sm text-gray-700;
    }

    /* Pagination */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        @apply inline-flex items-center px-3 py-1 border border-gray-300 rounded-md text-sm text-gray-600 bg-white hover:bg-gray-100 mx-0.5;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        @apply bg-blue-600 text-white border-blue-600;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
        @apply text-gray-400 bg-gray-100 cursor-not-allowed;
    }

    /* Length & Filter */
    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        @apply border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500;
    }

    /* Info text */
    .dataTables_wrapper .dataTables_info {
        @apply text-sm text-gray-500 mt-2;
    }

    /* Buttons (Excel, Print, PDF dll) */
    .dt-buttons button {
        @apply inline-flex items-center px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 mr-2;
    }

    /* Action Buttons */
    .btn-delete {
        @apply bg-red-600 text-white hover:bg-red-700 px-3 py-1 rounded text-xs;
    }
    .btn-warning {
        @apply bg-yellow-500 text-white hover:bg-yellow-600 px-3 py-1 rounded text-xs;
    }
    .btn-secondary {
        @apply bg-gray-500 text-white hover:bg-gray-600 px-3 py-1 rounded text-xs;
    }
</style>
@endpush

@push('js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <script>
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');

            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                $.ajax({
                    type: 'DELETE',
                    url: url,
                    success: function() {
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            }
        });
    </script>
@endpush
