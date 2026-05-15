<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'JoinYuk') }} - Kelola Rapat & Kehadiran</title>
    <meta name="description" content="JoinYuk - Platform digital untuk mengelola rapat, absensi, dan dokumentasi kegiatan perusahaan secara efisien dan terintegrasi.">

    <link rel="icon" href="{{ asset('assets/logo1.png') }}" type="image/png">

    <!-- Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            900: '#1e3a8a',
                            950: '#001A3B',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            opacity: 0;
            animation: fadeInUp 0.8s ease-out forwards;
        }
        .animation-delay-100 { animation-delay: 100ms; }
        .animation-delay-200 { animation-delay: 200ms; }
        .animation-delay-300 { animation-delay: 300ms; }
    </style>
</head>
<body class="font-sans text-slate-800 bg-slate-50 antialiased selection:bg-primary-500 selection:text-white overflow-x-hidden">

    <!-- Navbar -->
    <nav class="fixed w-full top-0 z-50 transition-all duration-300 bg-gradient-to-r from-blue-50/90 via-white/90 to-purple-50/90 backdrop-blur-lg border-b border-white/50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-2">
                    <a href="{{ route('welcome') }}">
                        <img src="{{ asset('assets/logo1.png') }}" alt="JoinYuk" class="h-10 transform hover:scale-105 transition duration-300">
                    </a>
                </div>
                
                <!-- Desktop Menu (Empty as requested) -->
                <div class="hidden md:flex space-x-8 items-center">
                </div>

                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <div class="relative group">
                            <button class="flex items-center gap-2 text-sm font-semibold text-slate-700 hover:text-primary-600 px-2 py-2">
                                <i class="fa-solid fa-circle-user text-lg text-primary-500"></i> {{ Auth::user()->name }}
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                                <a href="{{ route('home') }}" class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary-600 rounded-t-xl transition"><i class="fa-solid fa-gauge mr-2"></i> Dashboard</a>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-3 text-sm text-red-600 hover:bg-red-50 rounded-b-xl transition"><i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-700 hover:text-primary-600 px-4 py-2 border border-slate-200 rounded-full hover:bg-slate-50 transition">Masuk</a>
                        <a href="{{ route('login') }}" class="text-sm font-semibold bg-primary-600 text-white hover:bg-primary-700 px-5 py-2.5 rounded-full shadow-md shadow-primary-500/30 transition transform hover:-translate-y-0.5">Coba Gratis</a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn" class="text-slate-600 hover:text-slate-900 focus:outline-none p-2">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu Panel -->
        <div id="mobile-menu" class="hidden md:hidden bg-gradient-to-b from-blue-50/95 to-white/95 backdrop-blur-lg border-b border-slate-200 absolute w-full shadow-lg">
            <div class="px-4 pt-4 pb-6 space-y-2">
                @auth
                    <a href="{{ route('home') }}" class="block px-3 py-2 text-base font-medium text-primary-600 bg-primary-50 rounded-md">Dashboard</a>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();" class="block px-3 py-2 text-base font-medium text-red-600 hover:bg-red-50 rounded-md">Logout</a>
                    <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 text-base font-medium text-slate-700 hover:bg-slate-50 rounded-md">Masuk</a>
                    <a href="{{ route('login') }}" class="block px-3 py-2 text-base font-medium text-primary-600 hover:bg-primary-50 rounded-md">Coba Gratis</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden bg-gradient-to-br from-indigo-50 via-white to-cyan-50">
        <!-- Background decorative blobs -->
        <div class="absolute top-0 inset-x-0 h-full bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMCwwLDAsMC4wNCkiLz48L3N2Zz4=')] opacity-50"></div>
        <div class="absolute top-0 inset-x-0 h-[500px] bg-gradient-to-b from-blue-100/50 to-transparent"></div>
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob"></div>
        <div class="absolute top-12 -left-24 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-1/2 w-80 h-80 bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob" style="animation-delay: 4s;"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white border border-slate-200 shadow-sm text-primary-600 text-sm font-semibold mb-8 animate-fade-in-up">
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-primary-500"></span>
                    </span>
                    Solusi Manajemen Kehadiran & Rapat
                </div>
                
                <h1 class="text-4xl md:text-6xl font-extrabold text-slate-900 tracking-tight leading-tight mb-6 animate-fade-in-up animation-delay-100">
                    Kelola Rapat & Kehadiran dengan <br class="hidden md:block"/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-indigo-600">JoinYuk</span>
                </h1>
                
                <p class="text-lg md:text-xl text-slate-600 mb-10 max-w-2xl mx-auto leading-relaxed animate-fade-in-up animation-delay-200">
                    Satu platform inovatif untuk mengelola kehadiran dan dokumentasi dengan cara yang jauh lebih pintar, efisien, dan ramah lingkungan.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-in-up animation-delay-300">
                    @auth
                        <a href="{{ route('home') }}" class="inline-flex justify-center items-center gap-2 bg-primary-600 text-white font-semibold px-8 py-4 rounded-full shadow-lg shadow-primary-600/30 hover:bg-primary-700 transition transform hover:-translate-y-1">
                            Buka Dashboard <i class="fa-solid fa-arrow-right text-sm"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex justify-center items-center gap-2 bg-primary-600 text-white font-semibold px-8 py-4 rounded-full shadow-lg shadow-primary-600/30 hover:bg-primary-700 transition transform hover:-translate-y-1">
                            Mulai Sekarang <i class="fa-solid fa-arrow-right text-sm"></i>
                        </a>
                    @endauth
                    <a href="#fitur" class="inline-flex justify-center items-center gap-2 bg-white text-slate-700 border border-slate-200 font-semibold px-8 py-4 rounded-full hover:bg-slate-50 hover:text-slate-900 transition transform hover:-translate-y-1 shadow-sm">
                        Pelajari Fitur Kami
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <h2 class="text-3xl md:text-5xl font-extrabold text-slate-900 mb-6 tracking-tight">Lupakan Kertas—Kumpulkan Data Secara Online!</h2>
                <p class="text-lg text-slate-500 leading-relaxed">Platform yang dirancang khusus untuk memenuhi kebutuhan manajemen kehadiran dan rapat di perusahaan Anda secara efisien.</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="group bg-white rounded-3xl p-8 border border-slate-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-[0_20px_40px_-4px_rgba(59,130,246,0.1)] transition-all duration-500 hover:-translate-y-2 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-bl-full -mr-10 -mt-10 transition-transform duration-500 group-hover:scale-110"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl mb-6 shadow-sm transform group-hover:rotate-6 transition-transform duration-300">
                            <i class="fa-solid fa-leaf"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-4">Pengumpulan Data Tanpa Kertas</h3>
                        <p class="text-slate-500 text-base leading-relaxed">Tinggalkan kertas fisik, sambut efisiensi digital. JoinYuk memungkinkan Anda untuk mencatat kehadiran dengan mudah, minim kertas, serta minim kesalahan. Kumpulkan dan kelola informasi absensi secara online untuk alur kerja yang mulus.</p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="group bg-white rounded-3xl p-8 border border-slate-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-[0_20px_40px_-4px_rgba(59,130,246,0.1)] transition-all duration-500 hover:-translate-y-2 lg:translate-y-8 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-bl-full -mr-10 -mt-10 transition-transform duration-500 group-hover:scale-110"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-2xl mb-6 shadow-sm transform group-hover:-rotate-6 transition-transform duration-300">
                            <i class="fa-solid fa-bolt"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-4">Meningkatkan Efisiensi</h3>
                        <p class="text-slate-500 text-base leading-relaxed">Sederhanakan proses Anda dengan JoinYuk. Digitalisasikan pengumpulan data kehadiran, kurangi kerepotan pencatatan manual, dan percepat alur kerja Anda. Tingkatkan produktivitas tim dan fokus pada tugas penting dengan pengelolaan yang efisien.</p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="group bg-white rounded-3xl p-8 border border-slate-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-[0_20px_40px_-4px_rgba(59,130,246,0.1)] transition-all duration-500 hover:-translate-y-2 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-purple-50 rounded-bl-full -mr-10 -mt-10 transition-transform duration-500 group-hover:scale-110"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center text-2xl mb-6 shadow-sm transform group-hover:rotate-6 transition-transform duration-300">
                            <i class="fa-solid fa-wand-magic-sparkles"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-4">Mudah Digunakan</h3>
                        <p class="text-slate-500 text-base leading-relaxed">Pengelolaan rapat dan absensi kini lebih mudah. Antarmuka intuitif JoinYuk memastikan semua orang tanpa keahlian teknis dapat menggunakannya dengan cepat. Nikmati pengalaman dokumentasi kegiatan yang rapi dan tanpa repot.</p>
                    </div>
                </div>

                <!-- Feature 4 -->
                <div class="group bg-white rounded-3xl p-8 border border-slate-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-[0_20px_40px_-4px_rgba(59,130,246,0.1)] transition-all duration-500 hover:-translate-y-2 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-orange-50 rounded-bl-full -mr-10 -mt-10 transition-transform duration-500 group-hover:scale-110"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center text-2xl mb-6 shadow-sm transform group-hover:-rotate-6 transition-transform duration-300">
                            <i class="fa-solid fa-people-group"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-4">Kolaborasi Efektif</h3>
                        <p class="text-slate-500 text-base leading-relaxed">Optimalkan kerja sama dengan fitur JoinYuk. Bagikan informasi agenda dengan tim, kelola kehadiran, dan pantau partisipasi. Pastikan semua orang mendapat informasi yang sama dan perjelas upaya kolaborasi Anda.</p>
                    </div>
                </div>

                <!-- Feature 5 -->
                <div class="group bg-white rounded-3xl p-8 border border-slate-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-[0_20px_40px_-4px_rgba(59,130,246,0.1)] transition-all duration-500 hover:-translate-y-2 lg:translate-y-8 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-teal-50 rounded-bl-full -mr-10 -mt-10 transition-transform duration-500 group-hover:scale-110"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-teal-100 text-teal-600 rounded-2xl flex items-center justify-center text-2xl mb-6 shadow-sm transform group-hover:rotate-6 transition-transform duration-300">
                            <i class="fa-solid fa-share-nodes"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-4">Banyak Cara Mengisi Kehadiran</h3>
                        <p class="text-slate-500 text-base leading-relaxed">JoinYuk menawarkan banyak opsi absensi yang sesuai dengan kebutuhan Anda. Bagikan tautan kehadiran melalui pesan, atau gunakan Scan QR Code langsung di lokasi. Jangkau peserta Anda dengan praktis dan kumpulkan data dengan mudah.</p>
                    </div>
                </div>

                <!-- Feature 6 -->
                <div class="group bg-white rounded-3xl p-8 border border-slate-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-[0_20px_40px_-4px_rgba(59,130,246,0.1)] transition-all duration-500 hover:-translate-y-2 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-rose-50 rounded-bl-full -mr-10 -mt-10 transition-transform duration-500 group-hover:scale-110"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center text-2xl mb-6 shadow-sm transform group-hover:-rotate-6 transition-transform duration-300">
                            <i class="fa-solid fa-chart-pie"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-4">Laporan dan Analisis</h3>
                        <p class="text-slate-500 text-base leading-relaxed">Dapatkan informasi berharga dengan rekapitulasi kehadiran terperinci. Lacak partisipasi peserta, pantau riwayat kegiatan, dan ambil keputusan berbasis data. JoinYuk menyediakan alat yang dibutuhkan untuk memonitor absensi dan mengoptimalkan kegiatan Anda.</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-20 lg:mt-28 bg-slate-50 rounded-3xl p-8 lg:p-10 border border-slate-200 flex flex-col md:flex-row items-center justify-between gap-8">
                <div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-2">Siap Beralih ke Cara Kerja yang Lebih Cerdas?</h3>
                    <p class="text-slate-600 text-lg">Lihat bagaimana JoinYuk membantu tim Anda menyederhanakan dokumentasi.</p>
                </div>
                @auth
                    <a href="{{ route('home') }}" class="whitespace-nowrap inline-flex items-center gap-2 bg-slate-900 text-white font-semibold px-8 py-4 rounded-full hover:bg-primary-600 transition shadow-lg shadow-slate-900/20 transform hover:-translate-y-1">
                        Buka Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="whitespace-nowrap inline-flex items-center gap-2 bg-slate-900 text-white font-semibold px-8 py-4 rounded-full hover:bg-primary-600 transition shadow-lg shadow-slate-900/20 transform hover:-translate-y-1">
                        Daftar Gratis Sekarang
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <!-- Brand -->
                <div class="flex items-center gap-4">
                    <img src="{{ asset('assets/logo1.png') }}" alt="JoinYuk" class="h-10">
                    <span class="text-slate-500 font-medium">| Manajemen Rapat & Kehadiran</span>
                </div>

                <div class="flex space-x-6">
                    <p class="text-slate-500 text-sm">&copy; 2026 JoinYuk. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
