<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Password - {{ config('app.name', 'JoinYuk') }}</title>
    <!-- Fallback favicon if asset fails -->
    <link rel="icon" href="{{ asset('assets/logo1.png') }}" type="image/png">

    <!-- Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
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
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans text-slate-800 bg-slate-50 antialiased selection:bg-primary-500 selection:text-white flex min-h-screen">

    <!-- Left Side: Branding / Visual (Hidden on mobile) -->
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden flex-col justify-between p-14 2xl:p-20">
        <!-- Background Image -->
        <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" 
             alt="Tim Kolaborasi JoinYuk" 
             class="absolute inset-0 w-full h-full object-cover object-center" />
        
        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-primary-900/95 via-primary-800/90 to-indigo-900/95"></div>

        <!-- Decorative Blurs -->
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-primary-500/30 rounded-full mix-blend-screen filter blur-3xl opacity-70"></div>
        <div class="absolute bottom-12 -right-24 w-72 h-72 bg-indigo-400/30 rounded-full mix-blend-screen filter blur-3xl opacity-70"></div>

        <!-- Top Content: Logo -->
        <div class="relative z-10 flex items-center">
            <a href="{{ route('welcome') }}" class="inline-flex items-center gap-3 bg-white/10 backdrop-blur-md px-5 py-3 rounded-2xl border border-white/20 shadow-xl transition hover:bg-white/20">
                <img src="{{ asset('assets/logo1.png') }}" alt="JoinYuk Logo" class="h-8 w-auto" onerror="this.outerHTML='<i class=\'fa-solid fa-layer-group text-white text-2xl\'></i>'">
                <span class="text-white font-bold text-xl tracking-wide">JoinYuk</span>
            </a>
        </div>
        
        <!-- Middle Content: Typography -->
        <div class="relative z-10 mt-auto mb-16">
            <h1 class="text-4xl xl:text-5xl font-bold text-white mb-6 leading-[1.2]">
                Digitalisasi<br>Sistem Kehadiran<br>& Notulen Rapat
            </h1>
            <p class="text-primary-100 text-lg xl:text-xl max-w-lg leading-relaxed font-light">
                Platform inovatif untuk mengelola kehadiran dan dokumentasi kegiatan perusahaan dengan cara yang jauh lebih pintar, terintegrasi, dan efisien.
            </p>
        </div>
        
        <!-- Bottom Content: Footer -->
        <div class="relative z-10 flex items-center justify-between text-primary-200/80 text-sm border-t border-white/10 pt-6">
            <p>&copy; {{ date('Y') }} JoinYuk. All rights reserved.</p>
            <div class="inline-flex px-3 py-1 rounded-full bg-primary-500/20 border border-primary-400/30 text-primary-200 text-xs font-semibold backdrop-blur-sm">
                Versi 2.0
            </div>
        </div>
    </div>

    <!-- Right Side: Password Setup Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 lg:p-16 xl:p-24 bg-white relative">
        <div class="w-full max-w-md mx-auto">
            <!-- Header section -->
            <div class="mb-10 text-center lg:text-left mt-8 lg:mt-0">
                <h2 class="text-3xl font-bold text-slate-900 mb-3 tracking-tight">Pengaturan Password</h2>
                <p class="text-slate-500 text-base">Silakan atur password untuk akun Anda sebelum melanjutkan ke dalam sistem.</p>
            </div>

            @if(isset($message))
                <div class="bg-amber-50 border border-amber-200 text-amber-700 px-4 py-3.5 rounded-2xl mb-8 text-sm flex justify-between items-center shadow-sm">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation text-amber-500"></i>
                        <span>{{ $message }}</span>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('password.setup.update') }}" autocomplete="off" class="space-y-6">
                @csrf
                <input type="text" name="username_fake" style="display:none" tabindex="-1" autocomplete="username">
                <input type="password" name="password_fake" style="display:none" tabindex="-1" autocomplete="current-password">

                <!-- Password Input -->
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-semibold text-slate-700">{{ __('Password Baru') }}</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-primary-500 text-slate-400">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="new-password" autofocus
                            class="block w-full pl-11 pr-12 py-3.5 bg-slate-50 border @error('password') border-red-300 ring-4 ring-red-100 @else border-slate-200 focus:border-primary-500 focus:ring-4 focus:ring-primary-50 @enderror rounded-2xl text-sm transition-all outline-none font-medium text-slate-800 placeholder:text-slate-400 placeholder:font-normal tracking-wide"
                            placeholder="••••••••">
                        <button type="button" tabindex="-1" class="absolute inset-y-0 right-0 pr-4 flex items-center cursor-pointer text-slate-400 hover:text-primary-500 transition-colors" 
                             onclick="const input = document.getElementById('password'); const icon = this.querySelector('i'); if (input.type === 'password') { input.type = 'text'; icon.classList.remove('fa-eye'); icon.classList.add('fa-eye-slash'); } else { input.type = 'password'; icon.classList.remove('fa-eye-slash'); icon.classList.add('fa-eye'); }">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                    <div class="text-xs text-slate-500 mt-1">Minimal 8 karakter. Pastikan menggunakan kombinasi yang aman.</div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 flex items-center gap-1.5"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password Input -->
                <div class="space-y-2">
                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-700">{{ __('Konfirmasi Password Baru') }}</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-primary-500 text-slate-400">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                            class="block w-full pl-11 pr-12 py-3.5 bg-slate-50 border border-slate-200 focus:border-primary-500 focus:ring-4 focus:ring-primary-50 rounded-2xl text-sm transition-all outline-none font-medium text-slate-800 placeholder:text-slate-400 placeholder:font-normal tracking-wide"
                            placeholder="••••••••">
                        <button type="button" tabindex="-1" class="absolute inset-y-0 right-0 pr-4 flex items-center cursor-pointer text-slate-400 hover:text-primary-500 transition-colors" 
                             onclick="const input = document.getElementById('password_confirmation'); const icon = this.querySelector('i'); if (input.type === 'password') { input.type = 'text'; icon.classList.remove('fa-eye'); icon.classList.add('fa-eye-slash'); } else { input.type = 'password'; icon.classList.remove('fa-eye-slash'); icon.classList.add('fa-eye'); }">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full flex justify-center items-center gap-2 py-3.5 px-4 border border-transparent rounded-2xl shadow-lg shadow-primary-500/30 text-sm font-bold text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-200 transition-all transform hover:-translate-y-0.5 active:translate-y-0 active:shadow-md mt-6">
                    <i class="fa-solid fa-check text-primary-100"></i>
                    {{ __('Simpan & Lanjutkan') }}
                </button>
            </form>

            <div class="mt-8 text-center">
                <a href="{{ route('logout') }}" class="text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa-solid fa-arrow-right-from-bracket mr-1"></i> Kembali ke Halaman Login
                </a>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </div>

</body>
</html>
