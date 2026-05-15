<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME', 'JoinYuk') }}</title>

    <link rel="icon" href="{{ asset('assets/logo1.png') }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: { 50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd', 400: '#60a5fa', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 800: '#1e40af', 900: '#1e3a8a' }
                    }
                }
            }
        }
    </script>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    
    <!-- Libraries CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css">
    
    <!-- Tailwind Custom Classes via @layer -->
    <style type="text/tailwindcss">
        @layer components {
            .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_processing, .dataTables_wrapper .dataTables_paginate { @apply text-sm text-slate-500; }
            .dataTables_wrapper .dataTables_filter input { @apply shadow-sm appearance-none border border-slate-300 rounded-lg py-2 px-3 text-slate-700 leading-tight focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 ml-2; }
            .dataTables_wrapper .dataTables_paginate .paginate_button { @apply inline-flex items-center px-3 py-1 text-sm font-medium border border-transparent bg-transparent hover:bg-slate-100 text-slate-600 rounded-md transition-colors mx-0.5; }
            .dataTables_wrapper .dataTables_paginate .paginate_button.current { @apply z-10 bg-primary-50 text-primary-600 font-bold border-primary-200; }
            .dataTables_wrapper .dataTables_paginate .paginate_button.disabled { @apply text-slate-400 cursor-not-allowed hover:bg-transparent; }
            .dt-buttons { @apply my-4 flex flex-wrap gap-2; }
            .dt-buttons button { @apply inline-flex items-center gap-2 px-4 py-2 border border-slate-200 rounded-lg shadow-sm text-sm font-medium text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all; }
            
            /* Action Buttons Standardized */
            .btn-delete { @apply bg-red-50 text-red-600 border border-red-200 hover:bg-red-100 py-1.5 px-3 rounded-lg text-sm font-medium transition-colors inline-flex items-center gap-1.5 cursor-pointer; }
            .btn-warning { @apply bg-amber-50 text-amber-600 border border-amber-200 hover:bg-amber-100 py-1.5 px-3 rounded-lg text-sm font-medium transition-colors inline-flex items-center gap-1.5 cursor-pointer; }
            .btn-secondary { @apply bg-slate-50 text-slate-600 border border-slate-200 hover:bg-slate-100 py-1.5 px-3 rounded-lg text-sm font-medium transition-colors inline-flex items-center gap-1.5 cursor-pointer; }
            .btn-primary { @apply bg-primary-600 text-white border border-transparent hover:bg-primary-700 py-1.5 px-3 rounded-lg text-sm font-medium transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-sm shadow-primary-500/30; }
        }

        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(203, 213, 225, 0.5); border-radius: 4px; }
        .custom-scrollbar:hover::-webkit-scrollbar-thumb { background: rgba(148, 163, 184, 0.8); }
    </style>
</head>
<body class="bg-[#f0f4f8] text-slate-800 font-sans antialiased overflow-x-hidden relative min-h-screen">
    
    <!-- Decorative Background Elements -->
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <div class="absolute top-[-10%] right-[-5%] w-[500px] h-[500px] bg-primary-400/10 rounded-full mix-blend-multiply filter blur-[80px] opacity-70 animate-pulse"></div>
        <div class="absolute bottom-[-10%] left-[-5%] w-[600px] h-[600px] bg-indigo-400/10 rounded-full mix-blend-multiply filter blur-[100px] opacity-70"></div>
    </div>

    <!-- Mobile & Desktop Backdrop -->
    <div id="sidebar-backdrop" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 hidden transition-opacity duration-300 opacity-0 cursor-pointer"></div>

    <!-- Header (Right of Sidebar on Desktop) -->
    <header class="fixed top-0 right-0 left-0 lg:left-60 h-14 bg-white/90 backdrop-blur-xl border-b border-slate-200/60 flex items-center justify-between px-4 sm:px-6 z-40 shadow-[0_4px_30px_rgba(0,0,0,0.03)] transition-all duration-300">
        <div class="flex items-center gap-2 lg:gap-6">
            <!-- Universal Hamburger (Desktop & Mobile) -->
            <button id="toggle-sidebar" class="text-slate-500 hover:text-primary-600 transition-colors p-2 rounded-lg hover:bg-primary-50 focus:outline-none">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>
        </div>
        
        <!-- User Menu -->
        @auth
        <div class="relative inline-block text-left">
            <button id="user-menu" class="flex items-center space-x-3 focus:outline-none p-1 rounded-full hover:bg-slate-100/50 transition-colors">
                <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-primary-600 to-indigo-500 flex items-center justify-center text-white font-bold text-sm shadow-md ring-2 ring-white">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="hidden sm:flex flex-col items-start mr-1">
                    <span class="text-sm font-bold text-slate-800 leading-tight">{{ Auth::user()->name }}</span>
                    <span class="text-[10px] uppercase tracking-wider text-slate-500 font-bold">Menu Akun</span>
                </div>
                <i class="fa-solid fa-chevron-down text-slate-400 text-xs hidden sm:block mr-2"></i>
            </button>
            
            <!-- Dropdown Menu -->
            <div id="dropdown" class="hidden absolute right-0 mt-2 w-56 bg-white shadow-xl border border-slate-100 rounded-2xl overflow-hidden z-50 transform origin-top-right transition-all duration-200">
                <div class="px-4 py-3 bg-slate-50 border-b border-slate-100">
                    <p class="text-sm font-bold text-slate-800 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email ?? 'Administrator' }}</p>
                </div>
                <div class="py-1">
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 w-full text-left px-4 py-2.5 text-sm text-slate-600 hover:bg-primary-50 hover:text-primary-600 transition-colors font-medium">
                        <i class="fa-solid fa-user-gear w-4 text-center"></i> Pengaturan Profil
                    </a>
                </div>
                <div class="border-t border-slate-100"></div>
                <div class="py-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-3 w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors font-medium">
                            <i class="fa-solid fa-arrow-right-from-bracket w-4 text-center"></i> Keluar Aplikasi
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endauth
    </header>

    <div class="flex pt-14 min-h-screen relative z-10">
        <!-- Sidebar (Full Height) -->
        <aside id="sidebar" class="w-60 bg-[#111827] border-r-0 flex flex-col px-4 py-4 fixed top-0 bottom-0 left-0 z-50 transform -translate-x-full lg:translate-x-0 transition-all duration-300 ease-in-out shadow-2xl lg:shadow-none">
            
            <!-- Logo Section in Sidebar -->
            <div class="flex items-center justify-between mb-6 h-8 logo-container-outer transition-all duration-300">
                <a href="{{ route('home') }}" class="flex items-center space-x-2 group shrink-0 w-full">
                    <img src="{{ asset('assets/logo1.png') }}" alt="Logo" class="h-8 w-auto transition-transform group-hover:scale-105" onerror="this.outerHTML='<i class=\'fa-solid fa-layer-group text-white text-2xl\'></i>'">
                    <div class="logo-text-container">
                        <h1 class="font-extrabold text-xl text-white tracking-tight">JoinYuk</h1>
                    </div>
                </a>
            </div>
            <!-- Close Button (Mobile Only) -->
            <div class="flex items-center justify-end mb-2 transition-all duration-300 relative lg:hidden">
                <button id="close-sidebar" class="text-slate-400 hover:text-red-500 transition-colors p-1.5 rounded-lg hover:bg-red-50 focus:outline-none">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="space-y-1 flex flex-col flex-grow overflow-y-auto pr-2 custom-scrollbar">
                @if(auth()->user()->can('akses.dashboard'))
                <a href="{{ route('home') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('home') ? 'bg-[#263159] text-white shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-border-all w-5 text-center {{ request()->routeIs('home') ? 'text-indigo-400' : 'text-slate-400' }}"></i> <span>Dashboard</span>
                </a>
                @endif
                
                <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mt-6 mb-2 px-3 menu-header">Menu Utama</div>
                
                <ul class="space-y-1.5 text-sm">
                    @if(auth()->user()->can('akses.user'))
                    <li><a href="{{ route('users.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl font-medium transition-all duration-200 {{ request()->routeIs('users.*') ? 'bg-[#263159] text-white shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-users w-5 text-center {{ request()->routeIs('users.*') ? 'text-indigo-400' : 'text-slate-400' }}"></i><span>User Management</span></a>
                    </li>
                    @endif
                    @if(auth()->user()->can('akses.undangan'))
                    <li><a href="{{ route('undangan.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl font-medium transition-all duration-200 {{ request()->routeIs('undangan.*') ? 'bg-[#263159] text-white shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-envelope-open-text w-5 text-center {{ request()->routeIs('undangan.*') ? 'text-indigo-400' : 'text-slate-400' }}"></i><span>Undangan</span></a>
                    </li>
                    @endif
                    @if(auth()->user()->can('akses.agenda'))
                    <li><a href="{{ route('agenda.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl font-medium transition-all duration-200 {{ request()->routeIs('agenda.*') ? 'bg-[#263159] text-white shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-list-check w-5 text-center {{ request()->routeIs('agenda.*') ? 'text-indigo-400' : 'text-slate-400' }}"></i><span>Susunan Acara</span></a>
                    </li>
                    @endif
                    @if(auth()->user()->can('akses.rapat'))
                    <li><a href="{{ route('rapat.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl font-medium transition-all duration-200 {{ request()->routeIs('rapat.*') ? 'bg-[#263159] text-white shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-video w-5 text-center {{ request()->routeIs('rapat.*') ? 'text-indigo-400' : 'text-slate-400' }}"></i><span>Rapat Online</span></a>
                    </li>
                    @endif
                    @if(auth()->user()->can('akses.materi'))
                    <li><a href="{{ route('materi.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl font-medium transition-all duration-200 {{ request()->routeIs('materi.*') ? 'bg-[#263159] text-white shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-book-open w-5 text-center {{ request()->routeIs('materi.*') ? 'text-indigo-400' : 'text-slate-400' }}"></i><span>Materi</span></a>
                    </li>
                    @endif
                    @if(auth()->user()->can('akses.absensi'))
                    <li><a href="{{ route('presence.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl font-medium transition-all duration-200 {{ request()->routeIs('presence.*') ? 'bg-[#263159] text-white shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-calendar-check w-5 text-center {{ request()->routeIs('presence.*') ? 'text-indigo-400' : 'text-slate-400' }}"></i><span>Absensi</span></a>
                    </li>
                    @endif
                    @if(auth()->user()->can('akses.risalah'))
                    <li><a href="{{ route('risalah.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl font-medium transition-all duration-200 {{ request()->routeIs('risalah.*') ? 'bg-[#263159] text-white shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-file-signature w-5 text-center {{ request()->routeIs('risalah.*') ? 'text-indigo-400' : 'text-slate-400' }}"></i><span>Risalah</span></a>
                    </li>
                    @endif
                    @if(auth()->user()->can('akses.kuis'))
                    <li><a href="{{ route('kuis.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl font-medium transition-all duration-200 {{ request()->routeIs('kuis.*') ? 'bg-[#263159] text-white shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-clipboard-question w-5 text-center {{ request()->routeIs('kuis.*') ? 'text-indigo-400' : 'text-slate-400' }}"></i><span>Kuis</span></a>
                    </li>
                    @endif
                    @if(auth()->user()->can('akses.survey'))
                    <li><a href="{{ route('survey.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl font-medium transition-all duration-200 {{ request()->routeIs('survey.*') ? 'bg-[#263159] text-white shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-chart-simple w-5 text-center {{ request()->routeIs('survey.*') ? 'text-indigo-400' : 'text-slate-400' }}"></i><span>Survey</span></a>
                    </li>
                    @endif
                    @if(auth()->user()->can('akses.anggaran'))
                    <li><a href="{{ route('anggaran.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl font-medium transition-all duration-200 {{ request()->routeIs('anggaran.*') ? 'bg-[#263159] text-white shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-wallet w-5 text-center {{ request()->routeIs('anggaran.*') ? 'text-indigo-400' : 'text-slate-400' }}"></i><span>Anggaran</span></a>
                    </li>
                    @endif
                    @if(auth()->user()->can('akses.konsumsi'))
                    <li><a href="{{ route('konsumsi.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl font-medium transition-all duration-200 {{ request()->routeIs('konsumsi.*') ? 'bg-[#263159] text-white shadow-sm' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-utensils w-5 text-center {{ request()->routeIs('konsumsi.*') ? 'text-indigo-400' : 'text-slate-400' }}"></i><span>Konsumsi</span></a>
                    </li>
                    @endif
                </ul>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <div id="main-content" class="flex flex-col flex-grow w-full lg:ml-60 transition-all duration-300 min-h-[calc(100vh-3.5rem)]">

            <!-- Page Content -->
            <main class="flex-grow p-4 sm:p-6 lg:p-8 overflow-x-hidden relative z-10">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-white/40 backdrop-blur-md border-t border-white/40 px-6 py-4 mt-auto text-center sm:text-left flex flex-col sm:flex-row justify-between items-center text-xs font-medium text-slate-500">
                <p>&copy; {{ date('Y') }} JoinYuk. All rights reserved.</p>
                <p class="mt-2 sm:mt-0 flex items-center gap-1 font-bold">
                    Versi 2.0
                </p>
            </footer>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>

    <script>
        // Setup AJAX CSRF Token globally
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // User Menu Dropdown Toggle
        const btn = document.getElementById("user-menu");
        const dropdown = document.getElementById("dropdown");
        if(btn && dropdown){
            btn.addEventListener("click", (e) => {
                e.stopPropagation();
                dropdown.classList.toggle("hidden");
            });
            window.addEventListener("click", (e) => {
                if(!btn.contains(e.target) && !dropdown.contains(e.target)){
                    dropdown.classList.add("hidden");
                }
            });
        }

        // Sidebar Toggle Logic
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const toggleSidebarBtn = document.getElementById('toggle-sidebar');
        const toggleSidebarDesktopBtn = document.getElementById('toggle-sidebar-desktop');
        const closeSidebarBtn = document.getElementById('close-sidebar');
        const sidebarBackdrop = document.getElementById('sidebar-backdrop');

        function toggleSidebar() {
            if (window.innerWidth >= 1024) { // Desktop
                document.body.classList.toggle('sidebar-collapsed');
            } else { // Mobile
                sidebar.classList.remove('-translate-x-full');
                sidebarBackdrop.classList.remove('hidden');
                setTimeout(() => sidebarBackdrop.classList.remove('opacity-0'), 10);
                document.body.classList.add('overflow-hidden');
            }
        }

        function closeSidebar() {
            if (window.innerWidth < 1024) {
                sidebar.classList.add('-translate-x-full');
                sidebarBackdrop.classList.add('opacity-0');
                setTimeout(() => sidebarBackdrop.classList.add('hidden'), 300);
                document.body.classList.remove('overflow-hidden');
            }
        }

        if (toggleSidebarBtn) toggleSidebarBtn.addEventListener('click', toggleSidebar);
        if (toggleSidebarDesktopBtn) toggleSidebarDesktopBtn.addEventListener('click', toggleSidebar);
        if (closeSidebarBtn) closeSidebarBtn.addEventListener('click', closeSidebar);
        if (sidebarBackdrop) sidebarBackdrop.addEventListener('click', closeSidebar);
        
        // Handle window resize to prevent visual bugs
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) { 
                document.body.classList.remove('overflow-hidden');
                sidebarBackdrop.classList.add('hidden', 'opacity-0');
                
                // Keep the desktop toggle logic correct if resized
                if (document.body.classList.contains('sidebar-collapsed')) {
                    // Handled by CSS
                }
            }
        });
    </script>

    @stack('js')

    <style>
        /* Mini Sidebar Styles */
        @media (min-width: 1024px) {
            body.sidebar-collapsed #sidebar {
                width: 5.5rem !important; /* 88px */
            }
            body.sidebar-collapsed header {
                left: 5.5rem !important;
            }
            body.sidebar-collapsed #main-content {
                margin-left: 5.5rem !important;
            }
            body.sidebar-collapsed #sidebar .logo-text-container {
                display: none !important;
            }
            body.sidebar-collapsed #sidebar .logo-container-outer {
                flex-direction: column;
                justify-content: center;
                gap: 1.5rem;
            }
            body.sidebar-collapsed #sidebar .logo-container-outer > a {
                justify-content: center;
                margin-right: 0 !important;
            }
            body.sidebar-collapsed #sidebar .menu-header {
                display: none !important;
            }
            body.sidebar-collapsed #toggle-sidebar-desktop {
                margin: 0 auto;
            }
            body.sidebar-collapsed #sidebar nav a {
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding: 0.75rem 0.25rem;
                gap: 0.35rem;
            }
            body.sidebar-collapsed #sidebar nav a i {
                width: 100% !important;
                text-align: center !important;
                margin: 0 !important;
                font-size: 1.25rem;
            }
            body.sidebar-collapsed #sidebar nav a span {
                display: none !important;
            }
        }
    </style>
</body>
</html>