{{-- <!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME', 'JoinYuk') }}</title>

    <link rel="icon" href="{{ asset('assets/logo1.png') }}" type="image/png">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />

    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css">
    <style>
        .scroll-smooth { scroll-behavior: smooth; }

        /* CSS Kustom untuk Tampilan DataTables dengan Tailwind */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_processing,
        .dataTables_wrapper .dataTables_paginate {
            @apply text-sm text-gray-600;
        }

        .dataTables_wrapper .dataTables_filter input {
            @apply shadow-sm appearance-none border border-gray-300 rounded-md py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-blue-500 focus:border-blue-500;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            @apply inline-flex items-center px-4 py-2 text-sm font-medium border border-gray-300 bg-white hover:bg-gray-100 text-gray-700;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            @apply z-10 bg-blue-50 border-blue-500 text-blue-600;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            @apply text-gray-400 cursor-not-allowed;
        }

        .dt-buttons {
            @apply my-2;
        }

        .dt-buttons button {
            @apply inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 mr-2;
        }

        /* Mengubah tampilan tombol action agar sesuai Tailwind */
        .btn-delete {
            @apply bg-red-600 text-white hover:bg-red-700 py-1 px-3 rounded text-sm;
        }
        .btn-warning {
            @apply bg-yellow-500 text-white hover:bg-yellow-600 py-1 px-3 rounded text-sm;
        }
        .btn-secondary {
            @apply bg-gray-500 text-white hover:bg-gray-600 py-1 px-3 rounded text-sm;
        }
    </style>
</head>
<body class="bg-[#f5f8fc] text-gray-900 font-sans">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col px-4 py-6 fixed inset-y-0 left-0 z-40">
            <div class="flex items-center space-x-3 mb-8">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <img src="{{ asset('assets/logo1.png') }}" alt="Logo JoinYuk" class="h-10 w-auto">
                    <div>
                        <h1 class="font-semibold text-lg">JoinYuk</h1>
                        <p class="text-xs text-gray-500">Digitalisasi Manajemen Rapat</p>
                    </div>
                </a>
            </div>

            <nav class="space-y-6 flex flex-col flex-grow">
                @if(auth()->user()->can('akses.dashboard'))
                <a href="{{ route('home') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('home') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                    <i class="fa fa-house"></i> <span>Dashboard</span>
                </a>
                @endif
                <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mt-4">Menu</div>
                <ul class="space-y-2 text-sm text-gray-700">
                    @if(auth()->user()->can('akses.user'))
                    <li><a href="{{ route('users.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg {{ request()->routeIs('user.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                        <i class="fa fa-users"></i><span>User Management</span></a>
                    </li>
                    @endif
                    @if(auth()->user()->can('akses.undangan'))
                    <li><a href="{{ route('undangan.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg {{ request()->routeIs('undangan.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                        <i class="fa fa-envelope"></i><span>Undangan</span></a>
                    </li>
                    @endif
                    @if(auth()->user()->can('akses.agenda'))
                    <li><a href="{{ route('agenda.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg {{ request()->routeIs('agenda.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                        <i class="fa fa-list"></i><span>Susunan Acara</span></a>
                    </li>
                    @endif
                    @if(auth()->user()->can('akses.rapat'))
                    <li><a href="{{ route('rapat.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg {{ request()->routeIs('rapat.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                        <i class="fa fa-video"></i><span>Rapat Online</span></a>
                    </li>
                    @endif
                    @if(auth()->user()->can('akses.materi'))
                    <li><a href="{{ route('materi.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg {{ request()->routeIs('materi.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                        <i class="fa fa-book"></i><span>Materi</span></a>
                    </li>
                    @endif
                    @if(auth()->user()->can('akses.absensi'))
                    <li><a href="{{ route('presence.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg {{ request()->routeIs('presence.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                        <i class="fa fa-calendar-check"></i><span>Absensi</span></a>
                    </li>
                    @endif
                    @if(auth()->user()->can('akses.risalah'))
                    <li><a href="{{ route('risalah.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg {{ request()->routeIs('risalah.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                        <i class="fa fa-file-alt"></i><span>Risalah</span></a>
                    </li>
                    @endif
                    @if(auth()->user()->can('akses.kuis'))
                    <li><a href="{{ route('kuis.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg {{ request()->routeIs('kuis.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                        <i class="fa fa-question-circle"></i><span>Kuis</span></a>
                    </li>
                    @endif
                    @if(auth()->user()->can('akses.survey'))
                    <li><a href="{{ route('survey.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg {{ request()->routeIs('survey.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                        <i class="fa fa-chart-line"></i><span>Survey</span></a>
                    </li>
                    @endif
                    @if(auth()->user()->can('akses.anggaran'))
                    <li><a href="{{ route('anggaran.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg {{ request()->routeIs('anggaran.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                        <i class="fa fa-dollar-sign"></i><span>Anggaran</span></a>
                    </li>
                    @endif
                    @if(auth()->user()->can('akses.konsumsi'))
                    <li><a href="{{ route('konsumsi.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg {{ request()->routeIs('konsumsi.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                        <i class="fa fa-utensils"></i><span>Konsumsi</span></a>
                    </li>
                    @endif
                </ul>
            </nav>
        </aside>

        <div class="flex flex-col flex-grow ml-64">
            <header class="flex items-center justify-between bg-white border-b border-gray-200 px-6 h-16 sticky top-0 z-30">
                <div></div>
                @auth
                <div class="relative inline-block text-left">
                    <button id="user-menu" class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
                        <i class="fa fa-chevron-down text-gray-600"></i>
                    </button>
                    <div id="dropdown" class="hidden absolute right-0 mt-2 w-36 bg-white shadow-lg rounded-md z-50">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">
                                <i class="fa fa-sign-out-alt mr-1"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
                @endauth
            </header>

            <main class="flex-grow p-6 overflow-auto">
                @yield('content')
            </main>

            <footer class="bg-white border-t border-gray-200 text-center py-3 text-sm text-gray-500">
                &copy; {{ date('Y') }} JoinYuk.
            </footer>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>

    <script>
        const btn = document.getElementById("user-menu");
        const dropdown = document.getElementById("dropdown");
        if(btn && dropdown){
            btn.addEventListener("click", () => {
                dropdown.classList.toggle("hidden");
            });
            window.addEventListener("click", (e) => {
                if(!btn.contains(e.target) && !dropdown.contains(e.target)){
                    dropdown.classList.add("hidden");
                }
            });
        }
    </script>

    @stack('js')
</body>
</html> --}}



<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME', 'JoinYuk') }}</title>

    <link rel="icon" href="{{ asset('assets/logo1.png') }}" type="image/png">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />

    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css">
    <style>
        .scroll-smooth { scroll-behavior: smooth; }

        /* CSS Kustom untuk Tampilan DataTables dengan Tailwind */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_processing,
        .dataTables_wrapper .dataTables_paginate {
            @apply text-sm text-gray-600;
        }

        .dataTables_wrapper .dataTables_filter input {
            @apply shadow-sm appearance-none border border-gray-300 rounded-md py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-blue-500 focus:border-blue-500;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            @apply inline-flex items-center px-4 py-2 text-sm font-medium border border-gray-300 bg-white hover:bg-gray-100 text-gray-700;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            @apply z-10 bg-blue-50 border-blue-500 text-blue-600;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            @apply text-gray-400 cursor-not-allowed;
        }

        .dt-buttons {
            @apply my-2;
        }

        .dt-buttons button {
            @apply inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 mr-2;
        }

        /* Mengubah tampilan tombol action agar sesuai Tailwind */
        .btn-delete {
            @apply bg-red-600 text-white hover:bg-red-700 py-1 px-3 rounded text-sm;
        }
        .btn-warning {
            @apply bg-yellow-500 text-white hover:bg-yellow-600 py-1 px-3 rounded text-sm;
        }
        .btn-secondary {
            @apply bg-gray-500 text-white hover:bg-gray-600 py-1 px-3 rounded text-sm;
        }
    </style>
</head>
<body class="bg-[#f5f8fc] text-gray-900 font-sans">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col px-4 py-6 fixed inset-y-0 left-0 z-40">
            <div class="flex items-center space-x-3 mb-8">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <img src="{{ asset('assets/logo1.png') }}" alt="Logo JoinYuk" class="h-10 w-auto">
                    <div>
                        <h1 class="font-semibold text-lg">JoinYuk</h1>
                        <p class="text-xs text-gray-500">Digitalisasi Manajemen Rapat</p>
                    </div>
                </a>
            </div>

            <nav class="space-y-6 flex flex-col flex-grow">
                @if(auth()->user()->can('akses.dashboard'))
                <a href="{{ route('home') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('home') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                    <i class="fa fa-house"></i> <span>Dashboard</span>
                </a>
                @endif
                <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mt-4">Menu</div>
                <ul class="space-y-2 text-sm text-gray-700">
                    @if(auth()->user()->can('akses.user'))
                    <li><a href="{{ route('users.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg {{ request()->routeIs('users.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                        <i class="fa fa-users"></i><span>User Management</span></a>
                    </li>
                    @endif
                    @if(auth()->user()->can('akses.undangan'))
                    <li><a href="{{ route('undangan.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg {{ request()->routeIs('undangan.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                        <i class="fa fa-envelope"></i><span>Undangan</span></a>
                    </li>
                    @endif
                    @if(auth()->user()->can('akses.agenda'))
                    <li><a href="{{ route('agenda.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg {{ request()->routeIs('agenda.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                        <i class="fa fa-list"></i><span>Susunan Acara</span></a>
                    </li>
                    @endif
                    @if(auth()->user()->can('akses.rapat'))
                    <li><a href="{{ route('rapat.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg {{ request()->routeIs('rapat.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                        <i class="fa fa-video"></i><span>Rapat Online</span></a>
                    </li>
                    @endif
                    @if(auth()->user()->can('akses.materi'))
                    <li><a href="{{ route('materi.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg {{ request()->routeIs('materi.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                        <i class="fa fa-book"></i><span>Materi</span></a>
                    </li>
                    @endif
                    @if(auth()->user()->can('akses.absensi'))
                    <li><a href="{{ route('presence.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg {{ request()->routeIs('presence.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                        <i class="fa fa-calendar-check"></i><span>Absensi</span></a>
                    </li>
                    @endif
                    @if(auth()->user()->can('akses.risalah'))
                    <li><a href="{{ route('risalah.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg {{ request()->routeIs('risalah.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                        <i class="fa fa-file-alt"></i><span>Risalah</span></a>
                    </li>
                    @endif
                    @if(auth()->user()->can('akses.kuis'))
                    <li><a href="{{ route('kuis.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg {{ request()->routeIs('kuis.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                        <i class="fa fa-question-circle"></i><span>Kuis</span></a>
                    </li>
                    @endif
                    @if(auth()->user()->can('akses.survey'))
                    <li><a href="{{ route('survey.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg {{ request()->routeIs('survey.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                        <i class="fa fa-chart-line"></i><span>Survey</span></a>
                    </li>
                    @endif
                    @if(auth()->user()->can('akses.anggaran'))
                    <li><a href="{{ route('anggaran.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg {{ request()->routeIs('anggaran.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                        <i class="fa fa-dollar-sign"></i><span>Anggaran</span></a>
                    </li>
                    @endif
                    @if(auth()->user()->can('akses.konsumsi'))
                    <li><a href="{{ route('konsumsi.index') }}" class="flex items-center space-x-3 px-4 py-2 rounded-lg {{ request()->routeIs('konsumsi.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                        <i class="fa fa-utensils"></i><span>Konsumsi</span></a>
                    </li>
                    @endif
                </ul>
            </nav>
        </aside>

        <div class="flex flex-col flex-grow ml-64">
            <header class="flex items-center justify-between bg-white border-b border-gray-200 px-6 h-16 sticky top-0 z-30">
                <div></div>
                @auth
                <div class="relative inline-block text-left">
                    <button id="user-menu" class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
                        <i class="fa fa-chevron-down text-gray-600"></i>
                    </button>
                    <div id="dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-md z-50">
                        {{-- TAMBAHKAN LINK PROFIL DI SINI --}}
                        <a href="{{ route('profile.edit') }}" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">
                            <i class="fa fa-user-cog mr-2"></i>Pengaturan Akun
                        </a>
                        <div class="border-t border-gray-100"></div>
                        {{-- BATAS TAMBAHAN --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">
                                <i class="fa fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
                @endauth
            </header>

            <main class="flex-grow p-6 overflow-auto">
                @yield('content')
            </main>

            <footer class="bg-white border-t border-gray-200 text-center py-3 text-sm text-gray-500">
                &copy; 2025 JoinYuk. All rights reserved.
            </footer>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>

    <script>
        const btn = document.getElementById("user-menu");
        const dropdown = document.getElementById("dropdown");
        if(btn && dropdown){
            btn.addEventListener("click", () => {
                dropdown.classList.toggle("hidden");
            });
            window.addEventListener("click", (e) => {
                if(!btn.contains(e.target) && !dropdown.contains(e.target)){
                    dropdown.classList.add("hidden");
                }
            });
        }
    </script>

    @stack('js')
</body>
</html>
