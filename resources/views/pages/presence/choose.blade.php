@extends('layouts.main')

@section('content')
<div class="min-h-[80vh] flex flex-col items-center justify-center p-6 bg-gray-50/50">
    <div class="text-center mb-10">
        <h2 class="text-3xl font-bold text-gray-800 mb-3">Choose how to create your form</h2>
        <p class="text-gray-500">Mulai dari form kosong atau gunakan form yang sudah ada.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-3xl w-full">
        <!-- Blank Form -->
        <button type="button" onclick="openSetupModal('')" class="group bg-white rounded-2xl p-8 border border-gray-200 hover:border-sky-300 hover:shadow-xl transition-all duration-300 text-center flex flex-col items-center justify-center">
            <div class="w-20 h-20 rounded-full bg-pink-50 text-pink-500 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                <i class="fa fa-plus text-3xl font-light"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-2">Blank Form</h3>
            <p class="text-sm text-gray-500">Create from scratch with an empty form.</p>
        </button>

        <!-- Form Templates -->
        <button type="button" onclick="openTemplatesModal()" class="group bg-white rounded-2xl p-8 border border-gray-200 hover:border-purple-300 hover:shadow-xl transition-all duration-300 text-center flex flex-col items-center justify-center w-full">
            <div class="w-20 h-20 rounded-full bg-purple-50 text-purple-500 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                <i class="fa fa-copy text-3xl font-light"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-2">Form Templates</h3>
            <p class="text-sm text-gray-500">Choose from your pre-built forms.</p>
        </button>
    </div>
</div>

<!-- Modal Form Templates -->
<div id="templatesModal" class="fixed inset-0 z-[100] bg-gray-900/70 backdrop-blur-sm hidden items-center justify-center transition-opacity duration-300 opacity-0">
    <div class="bg-white rounded-2xl shadow-2xl w-[800px] max-w-[95%] overflow-hidden flex flex-col max-h-[85vh] transform transition-all scale-95 opacity-0" id="templatesModalContent">
        
        <!-- Header Modal -->
        <div class="px-8 py-5 border-b border-gray-100 flex items-center justify-between bg-white sticky top-0 z-10">
            <h2 class="text-xl font-bold text-gray-800">Select a Template</h2>
            <button onclick="closeTemplatesModal()" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fa fa-times text-lg"></i>
            </button>
        </div>

        <!-- Body Modal -->
        <div class="p-8 overflow-y-auto custom-scrollbar bg-gray-50/30">
            @if($templates->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($templates as $template)
                    <button type="button" onclick="openSetupModal('{{ $template->id }}')" class="block w-full bg-white border border-gray-200 rounded-xl p-5 hover:border-sky-400 hover:shadow-md transition text-left group">
                        <div class="w-10 h-10 rounded bg-sky-50 text-sky-600 flex items-center justify-center mb-4 group-hover:bg-sky-500 group-hover:text-white transition">
                            <i class="fa fa-file-alt"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-1 line-clamp-2">{{ $template->nama_kegiatan }}</h4>
                        <p class="text-xs text-gray-500 mb-3"><i class="fa fa-calendar-alt mr-1"></i> {{ $template->created_at->format('d M Y') }}</p>
                        
                        <span class="text-xs font-semibold text-sky-600 group-hover:text-sky-700">Use Template &rarr;</span>
                    </button>
                    @endforeach
                </div>
            @else
                <div class="text-center py-10">
                    <div class="w-20 h-20 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center mx-auto mb-4">
                        <i class="fa fa-folder-open text-2xl"></i>
                    </div>
                    <h4 class="text-gray-700 font-bold mb-1">No Templates Found</h4>
                    <p class="text-sm text-gray-500">You haven't created any forms yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- ================= MODAL SETUP (CREATE FORM) ================= -->
<div id="setupModal" class="fixed inset-0 z-[100] bg-gray-900/70 backdrop-blur-sm hidden items-center justify-center transition-opacity duration-300 opacity-0">
    <div class="bg-white rounded-2xl shadow-2xl w-[600px] max-w-[95%] overflow-hidden flex flex-col transform transition-all scale-95 opacity-0" id="setupModalContent">
        
        <!-- Header Modal -->
        <div class="px-8 py-5 border-b border-gray-100 flex items-center justify-between bg-white">
            <h2 class="text-xl font-bold text-gray-800">Create From Scratch</h2>
            <button onclick="closeSetupModal()" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fa fa-times text-lg"></i>
            </button>
        </div>

        <!-- Body Modal -->
        <form action="{{ route('presence.create') }}" method="GET" class="flex flex-col h-full" id="setupForm">
            <input type="hidden" name="template_id" id="setup_template_id" value="">
            
            <div class="px-8 py-6 space-y-6 bg-gray-50/30 flex-1">
                <!-- Form Name -->
                <div>
                    <label class="block text-sm font-bold text-gray-800 mb-2">Form Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="setup_form_name" placeholder="Misal: Pendaftaran Seminar Nasional..." 
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-1 focus:ring-teal-500 px-4 py-3 text-sm transition" required>
                </div>

                <!-- Form Type (Card/Standard) -->
                <div>
                    <label class="block text-sm font-bold text-gray-800 mb-3">Choose a form type</label>
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Standard -->
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="type" value="standard" class="peer sr-only" checked>
                            <div class="border-2 border-gray-200 rounded-xl p-5 flex flex-col items-center justify-center text-center transition-all peer-checked:border-teal-500 peer-checked:bg-teal-50/50 group-hover:border-teal-300">
                                <div class="w-12 h-12 rounded bg-gray-100 text-gray-400 flex items-center justify-center mb-3 peer-checked:text-teal-600 peer-checked:bg-teal-100 transition">
                                    <i class="fa fa-align-justify text-xl"></i>
                                </div>
                                <h4 class="font-bold text-gray-800 text-sm mb-1">Standard</h4>
                                <p class="text-[11px] text-gray-500">Displays multiple fields on a page</p>
                            </div>
                            <div class="absolute top-3 right-3 opacity-0 peer-checked:opacity-100 text-teal-600 transition">
                                <i class="fa fa-check-circle"></i>
                            </div>
                        </label>

                        <!-- Card -->
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="type" value="card" class="peer sr-only">
                            <div class="border-2 border-gray-200 rounded-xl p-5 flex flex-col items-center justify-center text-center transition-all peer-checked:border-teal-500 peer-checked:bg-teal-50/50 group-hover:border-teal-300">
                                <div class="absolute -top-3 -right-2 bg-orange-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm transform rotate-12">New</div>
                                <div class="w-12 h-12 rounded bg-gray-100 text-gray-400 flex items-center justify-center mb-3 peer-checked:text-teal-600 peer-checked:bg-teal-100 transition">
                                    <i class="fa fa-pager text-xl"></i>
                                </div>
                                <h4 class="font-bold text-gray-800 text-sm mb-1">Card</h4>
                                <p class="text-[11px] text-gray-500">Displays one field per page</p>
                            </div>
                            <div class="absolute top-3 right-3 opacity-0 peer-checked:opacity-100 text-teal-600 transition">
                                <i class="fa fa-check-circle"></i>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Footer Modal -->
            <div class="px-8 py-4 border-t border-gray-100 bg-white flex justify-end gap-3">
                <button type="button" onclick="closeSetupModal()" class="px-5 py-2.5 text-sm font-semibold text-gray-600 bg-white border border-gray-300 hover:bg-gray-50 rounded-lg transition">
                    Cancel
                </button>
                <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-teal-600 hover:bg-teal-700 rounded-lg shadow-sm transition">
                    Create Form
                </button>
            </div>
        </form>
    </div>
</div>
<!-- ================= END MODAL SETUP ================= -->

@endsection

@push('js')
<script>
    function openTemplatesModal() {
        const modal = document.getElementById('templatesModal');
        const content = document.getElementById('templatesModalContent');
        
        modal.classList.remove('hidden');
        // Trigger reflow
        void modal.offsetWidth;
        
        modal.classList.remove('opacity-0');
        modal.classList.add('flex');
        
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }

    function closeTemplatesModal() {
        const modal = document.getElementById('templatesModal');
        const content = document.getElementById('templatesModalContent');
        
        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0');
        
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
    }

    function openSetupModal(templateId = '') {
        // If coming from templates modal, close it first
        if (templateId) {
            closeTemplatesModal();
        }
        
        document.getElementById('setup_template_id').value = templateId;
        document.getElementById('setup_form_name').value = '';
        
        const modal = document.getElementById('setupModal');
        const content = document.getElementById('setupModalContent');
        
        modal.classList.remove('hidden');
        // Trigger reflow
        void modal.offsetWidth;
        
        modal.classList.remove('opacity-0');
        modal.classList.add('flex');
        
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }

    function closeSetupModal() {
        const modal = document.getElementById('setupModal');
        const content = document.getElementById('setupModalContent');
        
        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0');
        
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
    }
</script>
@endpush
