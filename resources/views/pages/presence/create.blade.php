@extends('layouts.main')

@section('content')


<div class="-m-6 h-[calc(100vh-64px)] flex flex-col overflow-hidden bg-white font-sans border-0">
    
    <!-- Topbar Builder -->
    <div class="bg-white border-b border-gray-200 px-6 py-3 flex justify-between items-center z-20 shrink-0">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-teal-600 rounded text-white shadow-sm">
                <i class="fa fa-list-alt text-lg"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-800 leading-tight truncate max-w-sm" id="topbar_form_name">Untitled Form</h2>
                <p class="text-[11px] text-gray-500 uppercase tracking-wider font-bold" id="topbar_form_type">Standard Form</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button type="button" onclick="if(confirm('Form harus disimpan ke database dulu untuk melihat Preview. Simpan sekarang?')) submitForm()" class="px-4 py-2 text-sm font-bold text-primary-600 bg-primary-50 border border-primary-200 hover:bg-primary-100 hover:text-primary-700 rounded-lg shadow-sm transition flex items-center gap-2">
                <i class="fa-solid fa-eye"></i> Preview
            </button>
            <button type="button" onclick="if(confirm('Form harus disimpan ke database dulu untuk membuat link Akses Form. Simpan sekarang?')) submitForm()" class="px-5 py-2 text-sm font-bold text-white bg-slate-800 hover:bg-slate-900 rounded-lg shadow-sm transition flex items-center gap-2">
                <i class="fa-solid fa-link"></i> Akses Form
            </button>
        </div>
    </div>

    <!-- Main Workspace (3 Kolom) -->
    <div class="flex flex-1 overflow-hidden relative">
        
        <!-- KOLOM 1: FIELD PALETTE (KIRI) -->
        <div class="w-72 bg-[#f8fafc] border-r border-gray-200 flex flex-col shrink-0 z-10">
            <div class="p-4 border-b border-gray-200 bg-white">
                <h3 class="text-sm font-bold text-gray-700 mb-2">Fields</h3>
                <div class="relative">
                    <i class="fa fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="text" placeholder="Search..." class="w-full bg-gray-100 border-transparent text-sm rounded-md pl-8 pr-3 py-1.5 focus:bg-white focus:border-teal-500 focus:ring-1 focus:ring-teal-500 outline-none transition">
                </div>
            </div>

            <div class="flex-1 overflow-y-auto p-4 custom-scrollbar">
                
                <!-- Category: Basic Info -->
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-3 cursor-pointer">
                        <h6 class="text-xs font-bold text-gray-500 uppercase tracking-wider">Basic Info</h6>
                        <i class="fa fa-chevron-down text-gray-400 text-xs"></i>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <button type="button" onclick="addField('text', 'Name')" class="toolbox-btn flex-row justify-start pl-4 gap-3">
                            <i class="fa fa-user text-teal-600 text-lg mb-0"></i>
                            <span class="text-xs">Name</span>
                        </button>
                        <button type="button" onclick="addField('text', 'Address')" class="toolbox-btn flex-row justify-start pl-4 gap-3">
                            <i class="fa fa-address-book text-orange-500 text-lg mb-0"></i>
                            <span class="text-xs">Address</span>
                        </button>
                        <button type="button" onclick="addField('number', 'Phone')" class="toolbox-btn flex-row justify-start pl-4 gap-3">
                            <i class="fa fa-phone-alt text-green-500 text-lg mb-0"></i>
                            <span class="text-xs">Phone</span>
                        </button>
                        <button type="button" onclick="addField('email', 'Email')" class="toolbox-btn flex-row justify-start pl-4 gap-3">
                            <i class="fa fa-envelope text-blue-500 text-lg mb-0"></i>
                            <span class="text-xs">Email</span>
                        </button>
                        <button type="button" onclick="addField('date', 'Date')" class="toolbox-btn flex-row justify-start pl-4 gap-3">
                            <i class="fa fa-calendar-alt text-red-500 text-lg mb-0"></i>
                            <span class="text-xs">Date</span>
                        </button>
                        <button type="button" onclick="addField('time', 'Time')" class="toolbox-btn flex-row justify-start pl-4 gap-3">
                            <i class="fa fa-clock text-indigo-500 text-lg mb-0"></i>
                            <span class="text-xs">Time</span>
                        </button>
                    </div>
                </div>

                <!-- Category: Textbox -->
                <div class="mb-6">
                    <h6 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Textbox</h6>
                    <div class="grid grid-cols-2 gap-2">
                        <button type="button" onclick="addField('text', 'Teks Singkat')" class="toolbox-btn">
                            <i class="fa fa-minus text-blue-500"></i>
                            <span>Single Line</span>
                        </button>
                        <button type="button" onclick="addField('textarea', 'Teks Panjang')" class="toolbox-btn">
                            <i class="fa fa-align-justify text-blue-400"></i>
                            <span>Multi Line</span>
                        </button>
                    </div>
                </div>

                <!-- Category: Choices -->
                <div class="mb-6">
                    <h6 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Choices</h6>
                    <div class="grid grid-cols-2 gap-2">
                        <button type="button" onclick="addField('select', 'Dropdown')" class="toolbox-btn">
                            <i class="fa fa-caret-square-down text-indigo-500"></i>
                            <span>Dropdown</span>
                        </button>
                        <button type="button" onclick="addField('radio', 'Pilihan Ganda')" class="toolbox-btn">
                            <i class="fa fa-dot-circle text-sky-500"></i>
                            <span>Radio</span>
                        </button>
                        <button type="button" onclick="addField('checkbox', 'Kotak Centang')" class="toolbox-btn">
                            <i class="fa fa-check-square text-orange-400"></i>
                            <span>Checkbox</span>
                        </button>
                    </div>
                </div>

                <!-- Category: Legal & Consent -->
                <div class="mb-6">
                    <h6 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Legal & Consent</h6>
                    <div class="grid grid-cols-2 gap-2">
                        <button type="button" onclick="addField('signature', 'Tanda Tangan')" class="toolbox-btn col-span-2 flex-row justify-start pl-4 gap-3">
                            <i class="fa fa-signature text-purple-600 text-lg"></i>
                            <span class="text-xs">Signature</span>
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <!-- KOLOM 2: CANVAS FORM (TENGAH) -->
        <div class="flex-1 overflow-y-auto p-4 md:p-8 custom-scrollbar relative bg-[#eef2f6]" id="canvasScrollArea" onclick="closeProperties(event)">
            
            <form action="{{ route('presence.store') }}" method="POST" id="mainForm">
                @csrf
                <input type="hidden" name="nama_kegiatan" id="db_nama_kegiatan">
                <input type="hidden" name="tgl_kegiatan" id="db_tgl_kegiatan">
                <input type="hidden" name="waktu_mulai" id="db_waktu_mulai">
                <input type="hidden" name="tempat" id="db_tempat">
                <input type="hidden" name="header_config" id="header_config_input">
    <input type="hidden" name="custom_fields" id="custom_fields_input">
                <input type="hidden" name="form_type" id="db_form_type"> <!-- Buat nyimpen Standard/Card -->

                <!-- KERTAS A4 -->
                <div class="max-w-[750px] mx-auto bg-white shadow-sm border border-gray-200 min-h-[800px] transition-all duration-300 relative" id="paperCanvas" onclick="event.stopPropagation()">
                    
                    <!-- HEADER BLOCK KERTAS -->
                    <div id="headerBlock" class="relative group cursor-pointer border-b-2 border-transparent hover:border-gray-200 transition-colors" onclick="selectField('header')">
                        
                        <!-- Floating Toolbar untuk Header -->
                        <div id="headerToolbar" class="absolute -right-[46px] top-1/2 -translate-y-1/2 flex flex-col shadow-[0_4px_20px_rgba(0,0,0,0.15)] rounded-lg overflow-hidden border border-slate-700 bg-slate-900 z-10 opacity-0 group-hover:opacity-100 pointer-events-none group-hover:pointer-events-auto transition-all">
                            <button type="button" onclick="event.stopPropagation(); selectField('header')" class="w-[42px] h-[40px] flex items-center justify-center text-slate-300 hover:text-white hover:bg-slate-800 transition-colors" title="Properties">
                                <i class="fa-solid fa-gear text-sm"></i>
                            </button>
                        </div>

                        <div class="p-10 pb-8 border-2 border-transparent transition-colors" id="headerBorder">
                            <div class="flex justify-between items-center mb-6">
                                <div id="preview_logo_left_container" class="h-12 w-auto min-w-[48px] flex items-center justify-center bg-gray-50 border border-dashed border-gray-200 rounded text-xs text-gray-400 hidden">
                                    <img id="preview_logo_left" src="" class="h-12 object-contain hidden" alt="Logo Kiri">
                                </div>
                                <h1 id="preview_title" class="text-3xl font-extrabold text-gray-900 text-center flex-1 mx-4">Nama Form</h1>
                                <div id="preview_logo_right_container" class="h-12 w-auto min-w-[48px] flex items-center justify-center bg-gray-50 border border-dashed border-gray-200 rounded text-xs text-gray-400 hidden">
                                    <img id="preview_logo_right" src="" class="h-12 object-contain hidden" alt="Logo Kanan">
                                </div>
                            </div>
                            
                            <div id="preview_event_info" class="flex flex-col md:flex-row md:flex-wrap gap-4 text-sm font-medium text-gray-600 bg-gray-50 p-4 rounded-lg border border-gray-100 hidden">
                                <div id="preview_date_wrapper" class="flex items-center gap-3 hidden">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center"><i class="fa fa-calendar-alt"></i></div>
                                    <span id="preview_date">Atur Tanggal Kegiatan</span>
                                </div>
                                <div id="preview_time_wrapper" class="flex items-center gap-3 hidden">
                                    <div class="w-8 h-8 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center"><i class="fa fa-clock"></i></div>
                                    <span id="preview_time">Atur Waktu Kegiatan</span>
                                </div>
                                <div id="preview_location_wrapper" class="flex items-center gap-3 w-full hidden">
                                    <div class="w-8 h-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center"><i class="fa fa-map-marker-alt"></i></div>
                                    <span id="preview_location">Atur Tempat / Link Kegiatan</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- AREA DRAG & DROP CUSTOM FIELDS -->
                    <div id="formCanvas" class="px-10 py-6 space-y-2 min-h-[400px] relative">
                        <!-- Fields injected by JS -->
                    </div>

                    <!-- EMPTY STATE KANVAS -->
                    <div id="emptyState" class="absolute inset-0 top-[250px] hidden flex-col items-center justify-center pointer-events-none">
                        <div class="w-24 h-24 bg-gray-50 border-2 border-dashed border-gray-300 rounded-xl flex items-center justify-center mb-4">
                            <i class="fa fa-hand-pointer text-3xl text-gray-300"></i>
                        </div>
                        <p class="text-lg font-bold text-gray-400">Drag and drop fields here</p>
                        <p class="text-sm text-gray-400 font-medium">Click or drag a field from the left panel to begin.</p>
                    </div>
                </div>
            </form>
        </div>

        <!-- KOLOM 3: PROPERTIES PANEL (KANAN) -->
        <div id="propertiesPanel" class="w-[400px] bg-white border-l border-gray-200 flex flex-col shrink-0 shadow-[-10px_0_20px_rgba(0,0,0,0.04)] z-20 absolute right-0 top-0 bottom-0 transform translate-x-full transition-transform duration-300">
            <div class="flex justify-between items-center bg-slate-800 text-white px-5 py-4 shrink-0">
                <h3 class="text-sm font-bold tracking-wide">Properties</h3>
                <button type="button" onclick="closeProperties(event)" class="text-gray-400 hover:text-white transition">
                    <i class="fa fa-times text-lg"></i>
                </button>
            </div>
            
            <div id="propertiesContent" class="p-6 overflow-y-auto custom-scrollbar flex-1 bg-white pb-24">
                <!-- Konten properties disuntik ke sini -->
            </div>
            
            <!-- Footer Cancel & Save Form -->
            <div class="absolute bottom-0 left-0 w-full p-4 border-t border-gray-200 bg-white flex justify-end gap-3 shadow-[0_-4px_10px_rgba(0,0,0,0.02)]">
                <a href="{{ route('presence.index') }}" class="px-6 py-2 text-sm font-semibold text-gray-600 bg-white border border-gray-300 hover:bg-gray-50 rounded-full transition text-center">
                    Cancel
                </a>
                <button type="button" onclick="submitForm()" class="px-8 py-2 text-sm font-bold text-white bg-teal-600 hover:bg-teal-700 rounded-full shadow-sm transition">
                    Save
                </button>
            </div>
        </div>

    </div>
</div>
<!-- ================= END TAHAP 2 ================= -->

@endsection

@push('css')
<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 10px; }
    
    /* Left Palette Button Style */
    .toolbox-btn {
        @apply flex flex-col items-center justify-center py-4 px-2 border border-transparent rounded bg-white hover:border-gray-200 hover:shadow-sm transition-all cursor-pointer;
    }
    .toolbox-btn i { @apply text-2xl mb-2 opacity-80; }
    .toolbox-btn span { @apply text-[11px] font-bold text-gray-700 text-center leading-tight; }

    /* Drag & Drop Styles */
    .sortable-ghost {
        opacity: 0.4;
        background-color: #f8fafc;
    }
    .sortable-drag {
        cursor: grabbing !important;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        background: white;
    }
    
    /* Active Field Border Style (Zoho Green Dotted Effect) */
    .field-active {
        border-color: #0ea5e9 !important; /* Biru/Teal khas selection */
        border-style: dashed !important;
        background-color: rgba(14, 165, 233, 0.02);
    }

    /* Setup Modal Smooth Fade */
    #setupModal.hidden-modal {
        opacity: 0;
        pointer-events: none;
    }
    #setupModal.hidden-modal #setupModalContent {
        transform: scale(0.95) translateY(-20px);
    }
</style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

<script>
    @php
        $initialFields = [];
        $initialHeaderConfig = null;
        if (isset($templateData)) {
            $initialFields = is_string($templateData->custom_fields) ? json_decode($templateData->custom_fields, true) : $templateData->custom_fields;
            $initialHeaderConfig = is_string($templateData->header_config) ? json_decode($templateData->header_config, true) : $templateData->header_config;
            
            // Fallback for old templates without header_config
            if (!$initialHeaderConfig && $templateData) {
                $initialHeaderConfig = [
                    'show_date' => !empty($templateData->tgl_kegiatan),
                    'show_time' => !empty($templateData->tgl_kegiatan),
                    'show_location' => !empty($templateData->tempat),
                    'date' => $templateData->tgl_kegiatan ? \Carbon\Carbon::parse($templateData->tgl_kegiatan)->format('Y-m-d') : '',
                    'time' => $templateData->tgl_kegiatan ? \Carbon\Carbon::parse($templateData->tgl_kegiatan)->format('H:i') : '',
                    'location' => $templateData->tempat ?? ''
                ];
            }
        }
    @endphp

    // State Aplikasi
    let fields = {!! json_encode($initialFields ?: []) !!};
    let activeFieldId = null;
    let selectedFormType = '{{ $formType }}';
    
    // State Khusus Header
    const savedHeaderConfig = {!! json_encode($initialHeaderConfig) !!};
    
    let headerData = {
        title: '{{ $formName }}',
        show_date: savedHeaderConfig ? savedHeaderConfig.show_date : false,
        show_time: savedHeaderConfig ? savedHeaderConfig.show_time : false,
        show_location: savedHeaderConfig ? savedHeaderConfig.show_location : false,
        date: savedHeaderConfig && savedHeaderConfig.date ? savedHeaderConfig.date : '',
        time: savedHeaderConfig && savedHeaderConfig.time ? savedHeaderConfig.time : '',
        location: savedHeaderConfig && savedHeaderConfig.location ? savedHeaderConfig.location : '',
        logo_left: savedHeaderConfig && savedHeaderConfig.logo_left ? savedHeaderConfig.logo_left : '',
        logo_right: savedHeaderConfig && savedHeaderConfig.logo_right ? savedHeaderConfig.logo_right : ''
    };

    const canvas = document.getElementById('formCanvas');
    const propertiesPanel = document.getElementById('propertiesPanel');
    const propertiesContent = document.getElementById('propertiesContent');
    const emptyState = document.getElementById('emptyState');
    const paperCanvas = document.getElementById('paperCanvas');

    // ========== INITIALIZE BUILDER ==========
    window.onload = function() {
        document.getElementById('topbar_form_name').innerText = headerData.title;
        document.getElementById('topbar_form_type').innerText = selectedFormType + ' Form';
        document.getElementById('preview_title').innerText = headerData.title;
        document.getElementById('db_form_type').value = selectedFormType;

        if (savedHeaderConfig) {
            updateHeader('show_date', headerData.show_date);
            updateHeader('show_time', headerData.show_time);
            updateHeader('show_location', headerData.show_location);
            if (headerData.date) updateHeader('date', headerData.date);
            if (headerData.time) updateHeader('time', headerData.time);
            if (headerData.location) updateHeader('location', headerData.location);
        }

        renderCanvas();
        initSortable();
    };

    // ========== BUILDER LOGIC ==========
    function generateId() {
        return 'field_' + Math.random().toString(36).substr(2, 9);
    }
    
    function selectField(id) {
        activeFieldId = id;
        renderCanvas();
        renderProperties();
        
        // Slide in panel Kanan
        propertiesPanel.classList.remove('translate-x-full');
        paperCanvas.classList.remove('max-w-[750px]');
        paperCanvas.classList.add('max-w-[650px]'); // Kertas mengecil ngasih ruang
    }

    window.closeProperties = function(e) {
        if(e) e.stopPropagation();
        activeFieldId = null;
        renderCanvas();
        
        // Slide out panel
        propertiesPanel.classList.add('translate-x-full');
        paperCanvas.classList.remove('max-w-[650px]');
        paperCanvas.classList.add('max-w-[750px]'); // Kertas normal lagi
    }

    function addField(type, defaultLabel) {
        const newId = generateId();
        const newField = {
            id: newId,
            type: type,
            label: defaultLabel || 'New Question',
            instructions: '',
            size: 'large', // Default width 100%
            required: false,
            options: (type === 'select' || type === 'radio' || type === 'checkbox') ? 'First Choice, Second Choice' : '',
            event_date: '',
            event_time: '',
            event_location: ''
        };
        
        fields.push(newField);
        activeFieldId = newId; // Make active to show toolbar but don't open properties panel automatically
        renderCanvas();
        
        setTimeout(() => {
            const el = document.querySelector(`[data-id="${newId}"]`);
            if(el) el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 100);
    }

    function duplicateField(id) {
        const index = fields.findIndex(f => f.id === id);
        if (index > -1) {
            const original = fields[index];
            const newField = JSON.parse(JSON.stringify(original));
            newField.id = generateId();
            fields.splice(index + 1, 0, newField);
            activeFieldId = newField.id;
            renderCanvas();
        }
    }

    function deleteField(id) {
        fields = fields.filter(f => f.id !== id);
        if(activeFieldId === id) closeProperties();
        else renderCanvas();
    }

    window.updateHeader = function(key, value) {
        headerData[key] = value;
        if(key === 'title') {
            document.getElementById('preview_title').innerText = value || 'Judul Kegiatan / Rapat';
            document.getElementById('topbar_form_name').innerText = value || 'Untitled Form';
        }
        
        if(['show_date', 'show_time', 'show_location'].includes(key)) {
            const hasInfo = headerData.show_date || headerData.show_time || headerData.show_location;
            const container = document.getElementById('preview_event_info');
            if (hasInfo) container.classList.remove('hidden'); else container.classList.add('hidden');
            
            document.getElementById('preview_date_wrapper').classList.toggle('hidden', !headerData.show_date);
            document.getElementById('preview_time_wrapper').classList.toggle('hidden', !headerData.show_time);
            document.getElementById('preview_location_wrapper').classList.toggle('hidden', !headerData.show_location);
            
            renderProperties();
        }

        if(key === 'date') {
            const d = new Date(value);
            document.getElementById('preview_date').innerText = isNaN(d) ? 'Atur Tanggal Kegiatan' : d.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
        }
        if(key === 'time') document.getElementById('preview_time').innerText = value ? value + ' WIB' : 'Atur Waktu Kegiatan';
        if(key === 'location') document.getElementById('preview_location').innerText = value || 'Atur Tempat / Link Kegiatan';
    }
    
    window.handleLogoUpload = function(side, file) {
        if(!file) return;
        const reader = new FileReader();
        reader.onload = function(e) {
            headerData[`logo_${side}`] = e.target.result;
            
            const container = document.getElementById(`preview_logo_${side}_container`);
            const img = document.getElementById(`preview_logo_${side}`);
            container.classList.remove('hidden');
            img.classList.remove('hidden');
            img.src = e.target.result;
        }
        reader.readAsDataURL(file);
    }

    window.updateActiveField = function(key, value) {
        if(!activeFieldId || activeFieldId === 'header') return;
        const index = fields.findIndex(f => f.id === activeFieldId);
        if(index > -1) {
            fields[index][key] = value;
            if(key === 'type' && ['select','radio','checkbox'].includes(value) && !fields[index].options) {
                fields[index].options = 'First Choice, Second Choice';
                renderProperties();
            }
            renderCanvas();
        }
    }


    // ========== RENDER ENGINE ========== //

    function renderCanvas() {
        // 1. Header Box Styling
        const headerBorder = document.getElementById('headerBorder');
        const headerToolbar = document.getElementById('headerToolbar');
        if(activeFieldId === 'header') {
            headerBorder.className = 'border-2 border-dashed border-sky-400 bg-sky-50/10 p-10 pb-8 transition-colors rounded-t';
            if(headerToolbar) headerToolbar.className = 'absolute -right-[46px] top-1/2 -translate-y-1/2 flex flex-col shadow-[0_4px_20px_rgba(0,0,0,0.15)] rounded-lg overflow-hidden border border-slate-700 bg-slate-900 z-10 transition-all !opacity-100 !pointer-events-auto';
        } else {
            headerBorder.className = 'border-2 border-transparent hover:border-dashed hover:border-gray-300 p-10 pb-8 transition-colors rounded-t';
            if(headerToolbar) headerToolbar.className = 'absolute -right-[46px] top-1/2 -translate-y-1/2 flex flex-col shadow-[0_4px_20px_rgba(0,0,0,0.15)] rounded-lg overflow-hidden border border-slate-700 bg-slate-900 z-10 opacity-0 group-hover:opacity-100 pointer-events-none group-hover:pointer-events-auto transition-all';
        }

        // 2. Custom Fields
        canvas.innerHTML = '';
        if (fields.length === 0) {
            emptyState.classList.remove('hidden');
            emptyState.classList.add('flex');
        } else {
            emptyState.classList.add('hidden');
            emptyState.classList.remove('flex');
            
            fields.forEach((field) => {
                const isActive = (field.id === activeFieldId);
                const wrapper = document.createElement('div');
                wrapper.className = `p-5 relative transition-colors cursor-pointer border-2 rounded group ${isActive ? 'field-active' : 'border-transparent hover:border-gray-200 hover:bg-gray-50/50'}`;
                wrapper.setAttribute('data-id', field.id);
                wrapper.onclick = (e) => { e.stopPropagation(); selectField(field.id); };

                wrapper.innerHTML = buildPreviewCardHTML(field, isActive);
                canvas.appendChild(wrapper);
            });
        }
    }

    function buildPreviewCardHTML(field, isActive) {
        let inputPreviewHtml = '';
        
        // Translasi Ukuran Width
        let widthClass = 'w-full';
        if(field.size === 'small') widthClass = 'w-full md:w-1/3';
        if(field.size === 'medium') widthClass = 'w-full md:w-1/2';
        
        // Mockup Visual
        if(field.type === 'text' || field.type === 'number' || field.type === 'email') {
            inputPreviewHtml = `<div class="${widthClass} h-10 border border-gray-300 rounded bg-white mt-1 pointer-events-none"></div>`;
        } else if(field.type === 'textarea') {
            inputPreviewHtml = `<textarea class="w-full border-gray-300 border-b-2 bg-gray-50 focus:border-sky-500 focus:ring-0 p-2 text-sm pointer-events-none rounded-t" rows="3" placeholder="Masukkan ${field.label}..."></textarea>`;
        } else if (field.type === 'date') {
            inputPreviewHtml = `<input type="date" class="${widthClass} border-gray-300 border-b-2 bg-gray-50 focus:border-sky-500 focus:ring-0 p-2 text-sm pointer-events-none rounded-t">`;
        } else if (field.type === 'time') {
            inputPreviewHtml = `<input type="time" class="${widthClass} border-gray-300 border-b-2 bg-gray-50 focus:border-sky-500 focus:ring-0 p-2 text-sm pointer-events-none rounded-t">`;
        } else if (field.type === 'select') {
            inputPreviewHtml = `<div class="${widthClass} h-10 border border-gray-300 rounded bg-white mt-1 flex items-center justify-end px-3 pointer-events-none"><i class="fa fa-chevron-down text-gray-400 text-xs"></i></div>`;
        } else if (field.type === 'radio' || field.type === 'checkbox') {
            const opts = field.options ? field.options.split(',') : ['Opsi 1'];
            inputPreviewHtml = `<div class="flex flex-col gap-2 mt-2 pointer-events-none">`;
            opts.forEach(opt => {
                let icon = field.type === 'radio' ? 'fa-circle-o' : 'fa-square-o';
                inputPreviewHtml += `<div class="flex items-center gap-2"><i class="fa ${icon} text-gray-400 text-lg"></i><span class="text-sm text-gray-700">${opt.trim()}</span></div>`;
            });
            inputPreviewHtml += `</div>`;
        } else if (field.type === 'signature') {
            inputPreviewHtml = `<div class="${widthClass} h-28 border border-gray-300 rounded bg-white mt-1 flex items-end p-2 pointer-events-none"><div class="w-full border-b border-gray-300 border-dashed"></div></div>`;
        }

        // Tampilkan tombol drag & action (selalu ada, hide/show via hover)
        let actionTools = `
            <div class="absolute -left-5 top-1/2 -translate-y-1/2 text-gray-300 hover:text-sky-500 drag-handle cursor-grab p-2 text-xl opacity-0 group-hover:opacity-100 transition-opacity ${isActive ? '!opacity-100' : ''}" title="Move">
                <i class="fa fa-grip-vertical"></i>
            </div>
            <!-- Floating Toolbar on the Right -->
            <div class="absolute -right-[46px] top-1/2 -translate-y-1/2 flex flex-col shadow-[0_4px_20px_rgba(0,0,0,0.15)] rounded-lg overflow-hidden border border-slate-700 bg-slate-900 z-10 opacity-0 group-hover:opacity-100 pointer-events-none group-hover:pointer-events-auto transition-all ${isActive ? '!opacity-100 !pointer-events-auto' : ''}">
                <button type="button" onclick="event.stopPropagation(); selectField('${field.id}')" class="w-[42px] h-[40px] flex items-center justify-center text-slate-300 hover:text-white hover:bg-slate-800 transition-colors border-b border-slate-700" title="Properties">
                    <i class="fa-solid fa-gear text-sm"></i>
                </button>
                <button type="button" onclick="event.stopPropagation(); duplicateField('${field.id}')" class="w-[42px] h-[40px] flex items-center justify-center text-slate-300 hover:text-white hover:bg-slate-800 transition-colors border-b border-slate-700" title="Duplicate">
                    <i class="fa-regular fa-copy text-sm"></i>
                </button>
                <button type="button" onclick="event.stopPropagation(); deleteField('${field.id}')" class="w-[42px] h-[42px] flex items-center justify-center text-white bg-red-500 hover:bg-red-600 transition-colors" title="Delete">
                    <i class="fa-solid fa-trash-can text-sm"></i>
                </button>
            </div>
        `;

        return `
            ${actionTools}
            <div class="pl-2">
                <label class="block text-[15px] font-bold text-gray-800">
                    ${field.label} ${field.required ? '<span class="text-red-500 ml-1">*</span>' : ''}
                </label>
                ${field.instructions ? `<p class="text-xs text-gray-500 mt-1 mb-2">${field.instructions}</p>` : ''}
                ${inputPreviewHtml}
            </div>
        `;
    }

    // Properties Kanan
    function renderProperties() {
        if (!activeFieldId) return;
        let html = '';

        if (activeFieldId === 'header') {
            html = `
                <div class="space-y-6">
                    <h4 class="text-xs font-bold text-sky-600 uppercase tracking-wider border-b border-gray-100 pb-2">Properties: Header & Kop Surat</h4>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Form Name <span class="text-red-500">*</span></label>
                        <textarea rows="2" oninput="updateHeader('title', this.value)" class="w-full text-sm border-gray-300 rounded focus:border-sky-500 focus:ring-1 focus:ring-sky-500 shadow-sm p-2">${headerData.title || ''}</textarea>
                    </div>

                    <div class="pt-4 border-t border-gray-100">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Kop Surat Logos</label>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 mb-1">Logo Kiri</label>
                                <input type="file" accept="image/*" onchange="handleLogoUpload('left', this.files[0])" class="w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 mb-1">Logo Kanan</label>
                                <input type="file" accept="image/*" onchange="handleLogoUpload('right', this.files[0])" class="w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100">
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 space-y-4">
                        <!-- Tanggal -->
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-sm font-bold text-gray-700">Tampilkan Tanggal</label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" onchange="updateHeader('show_date', this.checked)" class="sr-only peer" ${headerData.show_date ? 'checked' : ''}>
                                    <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-sky-500"></div>
                                </label>
                            </div>
                            ${headerData.show_date ? `
                            <input type="date" value="${headerData.date || ''}" onchange="updateHeader('date', this.value)" class="w-full text-sm border-gray-300 rounded focus:border-sky-500 focus:ring-1 focus:ring-sky-500 shadow-sm p-2">
                            ` : ''}
                        </div>

                        <!-- Waktu -->
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-sm font-bold text-gray-700">Tampilkan Waktu</label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" onchange="updateHeader('show_time', this.checked)" class="sr-only peer" ${headerData.show_time ? 'checked' : ''}>
                                    <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-sky-500"></div>
                                </label>
                            </div>
                            ${headerData.show_time ? `
                            <input type="time" value="${headerData.time || ''}" onchange="updateHeader('time', this.value)" class="w-full text-sm border-gray-300 rounded focus:border-sky-500 focus:ring-1 focus:ring-sky-500 shadow-sm p-2">
                            ` : ''}
                        </div>

                        <!-- Tempat -->
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-sm font-bold text-gray-700">Tampilkan Tempat</label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" onchange="updateHeader('show_location', this.checked)" class="sr-only peer" ${headerData.show_location ? 'checked' : ''}>
                                    <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-sky-500"></div>
                                </label>
                            </div>
                            ${headerData.show_location ? `
                            <input type="text" value="${headerData.location || ''}" oninput="updateHeader('location', this.value)" placeholder="Nama Tempat / Link Meeting" class="w-full text-sm border-gray-300 rounded focus:border-sky-500 focus:ring-1 focus:ring-sky-500 shadow-sm p-2">
                            ` : ''}
                        </div>
                    </div>
                </div>
            `;
        } else {
            const field = fields.find(f => f.id === activeFieldId);
            if(!field) return;

            const needsOptions = ['select', 'radio', 'checkbox'].includes(field.type);

            html = `
                <div class="space-y-6">
                    <h4 class="text-xs font-bold text-sky-600 uppercase tracking-wider border-b border-gray-100 pb-2">Properties: Field</h4>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Field Label <span class="text-red-500">*</span></label>
                        <input type="text" value="${field.label}" oninput="updateActiveField('label', this.value)" 
                            class="w-full text-sm border-gray-300 rounded focus:border-sky-500 focus:ring-1 focus:ring-sky-500 p-2">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Instructions</label>
                        <textarea oninput="updateActiveField('instructions', this.value)" rows="2"
                            class="w-full text-sm border-gray-300 rounded focus:border-sky-500 focus:ring-1 focus:ring-sky-500 p-2" 
                            placeholder="Help text for users...">${field.instructions || ''}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Field Size</label>
                        <div class="flex rounded-md shadow-sm" role="group">
                            <button type="button" onclick="updateActiveField('size', 'small')" class="px-4 py-2 text-sm font-medium border border-gray-300 rounded-l-lg hover:bg-gray-50 focus:z-10 focus:ring-2 focus:ring-sky-500 ${field.size === 'small' ? 'bg-sky-50 text-sky-600 border-sky-300 z-10' : 'bg-white text-gray-900'}">Small</button>
                            <button type="button" onclick="updateActiveField('size', 'medium')" class="px-4 py-2 text-sm font-medium border-t border-b border-gray-300 hover:bg-gray-50 focus:z-10 focus:ring-2 focus:ring-sky-500 ${field.size === 'medium' ? 'bg-sky-50 text-sky-600 border-sky-300 z-10' : 'bg-white text-gray-900'}">Medium</button>
                            <button type="button" onclick="updateActiveField('size', 'large')" class="px-4 py-2 text-sm font-medium border border-gray-300 rounded-r-lg hover:bg-gray-50 focus:z-10 focus:ring-2 focus:ring-sky-500 ${field.size === 'large' ? 'bg-sky-50 text-sky-600 border-sky-300 z-10' : 'bg-white text-gray-900'}">Large</button>
                        </div>
                    </div>

                    <div class="pt-2 border-t border-gray-100">
                        <label class="block text-sm font-bold text-gray-700 mb-3">Validation</label>
                        <label class="flex items-center">
                            <input type="checkbox" class="w-4 h-4 text-sky-600 bg-gray-100 border-gray-300 rounded focus:ring-sky-500" 
                                ${field.required ? 'checked' : ''} onchange="updateActiveField('required', this.checked)">
                            <span class="ml-2 text-sm font-medium text-gray-900">Mandatory (Wajib Diisi)</span>
                        </label>
                    </div>

                    ${needsOptions ? `
                    <div class="pt-2 border-t border-gray-100">
                        <label class="block text-sm font-bold text-gray-700 mb-1">Choices</label>
                        <p class="text-[10px] text-gray-500 mb-2">Pisahkan tiap opsi dengan koma (,)</p>
                        <textarea oninput="updateActiveField('options', this.value)" rows="4"
                            class="w-full text-sm border-gray-300 rounded focus:border-sky-500 focus:ring-1 focus:ring-sky-500 p-2">${field.options || ''}</textarea>
                    </div>
                    ` : ''}
                </div>
            `;
        }

        propertiesContent.innerHTML = html;
    }

    function initSortable() {
        Sortable.create(canvas, {
            handle: '.drag-handle',
            animation: 200,
            ghostClass: 'sortable-ghost',
            dragClass: 'sortable-drag',
            onEnd: function (evt) {
                const movedItem = fields.splice(evt.oldIndex, 1)[0];
                fields.splice(evt.newIndex, 0, movedItem);
                renderCanvas();
            },
        });
    }

    // ========== SUBMIT KE BACKEND ==========
    function submitForm() {
        document.getElementById('db_nama_kegiatan').value = headerData.title;
        
        document.getElementById('db_tgl_kegiatan').value = headerData.show_date ? headerData.date : '';
        document.getElementById('db_waktu_mulai').value = headerData.show_time ? headerData.time : '';
        document.getElementById('db_tempat').value = headerData.show_location ? headerData.location : '';
        
        document.getElementById('header_config_input').value = JSON.stringify(headerData);
        document.getElementById('custom_fields_input').value = JSON.stringify(fields);
        
        document.getElementById('mainForm').submit();
    }
</script>
@endpush