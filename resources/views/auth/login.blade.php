<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ config('app.name', 'JoinYuk') }}</title>
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
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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

    <!-- Right Side: Login Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 lg:p-16 xl:p-24 bg-white relative">
        
        <!-- Mobile Logo (only visible on mobile) -->
        <div class="absolute top-6 left-6 lg:hidden flex items-center">
            <a href="{{ route('welcome') }}" class="flex items-center gap-2">
                <img src="{{ asset('assets/logo1.png') }}" alt="JoinYuk" class="h-8 w-auto" onerror="this.outerHTML='<div class=\'bg-primary-600 p-2 rounded-lg\'><i class=\'fa-solid fa-layer-group text-white\'></i></div>'">
                <span class="font-bold text-xl text-slate-800">JoinYuk</span>
            </a>
        </div>

        <div class="w-full max-w-md mx-auto">
            <!-- Header section -->
            <div class="mb-10 text-center lg:text-left mt-8 lg:mt-0">
                <h2 class="text-3xl font-bold text-slate-900 mb-3 tracking-tight">Selamat Datang</h2>
                <p class="text-slate-500 text-base">Silakan masukkan email dan password Anda untuk masuk ke dashboard sistem.</p>
            </div>

            <!-- Security Warning -->
            <!-- <div class="bg-amber-50/80 border border-amber-200/60 rounded-2xl p-4 mb-8 flex gap-3.5 text-amber-800 text-sm shadow-sm">
                <div class="bg-amber-100/50 p-2 rounded-xl h-fit">
                    <i class="fa-solid fa-shield-halved text-amber-500 text-lg"></i>
                </div>
                <div>
                    <strong class="block mb-1 font-semibold text-amber-900">Peringatan Keamanan</strong>
                    <p class="text-amber-700/90 leading-relaxed">Sistem ini khusus pengguna berwenang. Segala percobaan akses tanpa izin akan dicatat dan ditindak.</p>
                </div>
            </div> -->

            <!-- Alerts -->
            @if (session('status'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3.5 rounded-2xl mb-8 text-sm flex justify-between items-center shadow-sm">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-500"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 transition">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3.5 rounded-2xl mb-8 text-sm flex justify-between items-center shadow-sm">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation text-red-500"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 transition">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Input -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-semibold text-slate-700">{{ __('Alamat Email') }}</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-primary-500 text-slate-400">
                            <i class="fa-regular fa-envelope"></i>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                            class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border @error('email') border-red-300 ring-4 ring-red-100 @else border-slate-200 focus:border-primary-500 focus:ring-4 focus:ring-primary-50 @enderror rounded-2xl text-sm transition-all outline-none font-medium text-slate-800 placeholder:text-slate-400 placeholder:font-normal"
                            placeholder="nama@perusahaan.com">
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 flex items-center gap-1.5"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-semibold text-slate-700">{{ __('Password') }}</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-primary-500 text-slate-400">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="block w-full pl-11 pr-12 py-3.5 bg-slate-50 border @error('password') border-red-300 ring-4 ring-red-100 @else border-slate-200 focus:border-primary-500 focus:ring-4 focus:ring-primary-50 @enderror rounded-2xl text-sm transition-all outline-none font-medium text-slate-800 placeholder:text-slate-400 placeholder:font-normal tracking-wide"
                            placeholder="••••••••">
                        <button type="button" tabindex="-1" class="absolute inset-y-0 right-0 pr-4 flex items-center cursor-pointer text-slate-400 hover:text-primary-500 transition-colors" 
                             onclick="const input = document.getElementById('password'); const icon = this.querySelector('i'); if (input.type === 'password') { input.type = 'text'; icon.classList.remove('fa-eye'); icon.classList.add('fa-eye-slash'); } else { input.type = 'password'; icon.classList.remove('fa-eye-slash'); icon.classList.add('fa-eye'); }">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 flex items-center gap-1.5"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me & Lupa Password -->
                <div class="flex items-center justify-between pt-2">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}
                            class="h-4.5 w-4.5 text-primary-600 focus:ring-primary-500 border-slate-300 rounded-md cursor-pointer transition-colors">
                        <label for="remember" class="ml-2.5 block text-sm font-medium text-slate-600 cursor-pointer select-none">
                            {{ __('Ingat Saya') }}
                        </label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm font-medium text-primary-600 hover:text-primary-700 transition-colors">
                            {{ __('Lupa Password?') }}
                        </a>
                    @endif
                </div>

                <!-- Google reCAPTCHA -->
                <div class="pt-5 flex flex-col items-center w-full justify-center">
                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                    @error('g-recaptcha-response')
                        <p class="mt-2 text-sm text-red-600 flex items-center gap-1.5"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full flex justify-center items-center gap-2 py-3.5 px-4 border border-transparent rounded-2xl shadow-lg shadow-primary-500/30 text-sm font-bold text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-200 transition-all transform hover:-translate-y-0.5 active:translate-y-0 active:shadow-md mt-6">
                    {{ __('Masuk') }}
                    <i class="fa-solid fa-arrow-right-to-bracket text-primary-100"></i>
                </button>
            </form>
            
            <!-- Optional Back to Home -->
            <div class="mt-10 text-center">
                <a href="{{ route('welcome') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors bg-slate-100 hover:bg-slate-200 px-4 py-2 rounded-full">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

</body>
</html>