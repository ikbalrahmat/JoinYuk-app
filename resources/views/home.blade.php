@extends('layouts.main')

@section('content')
<div class="p-4 lg:p-6 space-y-6">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-primary-600 via-primary-500 to-indigo-600 rounded-2xl p-8 relative overflow-hidden shadow-lg">
        <!-- Decorative Elements -->
        <div class="absolute top-[-40%] right-[-10%] w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-[-30%] left-[-5%] w-80 h-80 bg-white/5 rounded-full blur-2xl"></div>

        <div class="relative z-10">
            <div class="flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white text-xs w-max mb-4">
                <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                <span class="font-semibold">Selamat datang kembali</span>
            </div>

            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-2">{{ Auth::user()->name }}! 👋</h1>
            <p class="text-indigo-100 text-lg mb-6 max-w-xl">Manage rapat, absensi, dan kegiatan organisasi dengan mudah dari satu dashboard</p>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('rapat.index') }}" class="inline-flex items-center px-6 py-3 bg-white text-primary-600 font-semibold rounded-xl hover:shadow-lg hover:shadow-white/20 transition-all duration-300 transform hover:scale-105">
                    <i class="fa-solid fa-calendar-plus mr-2"></i> Buat Rapat Baru
                </a>
                <a href="{{ route('agenda.index') }}" class="inline-flex items-center px-6 py-3 bg-white/15 border border-white/30 text-white font-semibold rounded-xl hover:bg-white/25 backdrop-blur-sm transition-all duration-300">
                    <i class="fa-solid fa-list-check mr-2"></i> Lihat Agenda
                </a>
                <a href="{{ route('presence.index') }}" class="inline-flex items-center px-6 py-3 bg-white/15 border border-white/30 text-white font-semibold rounded-xl hover:bg-white/25 backdrop-blur-sm transition-all duration-300">
                    <i class="fa-solid fa-clipboard-user mr-2"></i> Absensi
                </a>
            </div>
        </div>
    </div>

    <!-- Main Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Anggota/Users -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl border border-slate-100/50 p-6 shadow-sm hover:shadow-md transition-all duration-300 group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-100 to-blue-50 text-blue-600 flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div class="px-3 py-1 rounded-lg bg-blue-50 text-blue-600 text-xs font-bold">
                    {{ $isSuperAdmin ? '+' . intval(rand(0, 20)) . '%' : 'Aktif' }}
                </div>
            </div>
            <h3 class="text-3xl font-bold text-slate-800">{{ $isSuperAdmin ? ($stats['total_users'] ?? 0) : ($stats['kehadiran_saya'] ?? 0) }}</h3>
            <p class="text-sm text-slate-500 mt-1">{{ $isSuperAdmin ? 'Total Anggota' : 'Kehadiran Saya' }}</p>
        </div>

        <!-- Rapat Bulan Ini -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl border border-slate-100/50 p-6 shadow-sm hover:shadow-md transition-all duration-300 group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-100 to-emerald-50 text-emerald-600 flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <div class="px-3 py-1 rounded-lg bg-emerald-50 text-emerald-600 text-xs font-bold">
                    Bulan Ini
                </div>
            </div>
            <h3 class="text-3xl font-bold text-slate-800">{{ $stats['rapat_bulan_ini'] ?? 0 }}</h3>
            <p class="text-sm text-slate-500 mt-1">Rapat Dijadwalkan</p>
        </div>

        <!-- Total Kegiatan/Absensi -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl border border-slate-100/50 p-6 shadow-sm hover:shadow-md transition-all duration-300 group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-100 to-purple-50 text-purple-600 flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-chart-bar"></i>
                </div>
                <div class="px-3 py-1 rounded-lg bg-purple-50 text-purple-600 text-xs font-bold">
                    {{ $isSuperAdmin ? 'Total' : 'Tingkat' }}
                </div>
            </div>
            <h3 class="text-3xl font-bold text-slate-800">{{ $isSuperAdmin ? ($stats['total_kegiatan'] ?? 0) : '-' }}</h3>
            <p class="text-sm text-slate-500 mt-1">{{ $isSuperAdmin ? 'Kegiatan Absensi' : 'Kehadiran Saya' }}</p>
        </div>

        <!-- Survey Aktif -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl border border-slate-100/50 p-6 shadow-sm hover:shadow-md transition-all duration-300 group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-100 to-orange-50 text-orange-600 flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-list-check"></i>
                </div>
                <div class="px-3 py-1 rounded-lg bg-orange-50 text-orange-600 text-xs font-bold">
                    Aktif
                </div>
            </div>
            <h3 class="text-3xl font-bold text-slate-800">{{ $stats['survey_aktif'] ?? 0 }}</h3>
            <p class="text-sm text-slate-500 mt-1">Survey Berjalan</p>
        </div>
    </div>

    <!-- Secondary Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Quick Actions -->
        <div class="lg:col-span-1 bg-white/80 backdrop-blur-sm rounded-2xl border border-slate-100/50 p-6 shadow-sm">
            <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-lightning text-amber-500"></i> Akses Cepat
            </h2>
            <div class="space-y-2">
                @if(auth()->user()->can('akses.agenda'))
                <a href="{{ route('agenda.index') }}" class="flex items-center gap-3 p-3 rounded-lg bg-gradient-to-r from-primary-50 to-primary-50/30 hover:from-primary-100 hover:to-primary-50 transition-colors group">
                    <div class="w-10 h-10 rounded-lg bg-primary-500 text-white flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-list"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-800 text-sm">Agenda Rapat</p>
                        <p class="text-xs text-slate-500">Kelola jadwal rapat</p>
                    </div>
                </a>
                @endif

                @if(auth()->user()->can('akses.undangan'))
                <a href="{{ route('undangan.index') }}" class="flex items-center gap-3 p-3 rounded-lg bg-gradient-to-r from-blue-50 to-blue-50/30 hover:from-blue-100 hover:to-blue-50 transition-colors group">
                    <div class="w-10 h-10 rounded-lg bg-blue-500 text-white flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-800 text-sm">Undangan</p>
                        <p class="text-xs text-slate-500">Kelola undangan rapat</p>
                    </div>
                </a>
                @endif

                @if(auth()->user()->can('akses.materi'))
                <a href="{{ route('materi.index') }}" class="flex items-center gap-3 p-3 rounded-lg bg-gradient-to-r from-purple-50 to-purple-50/30 hover:from-purple-100 hover:to-purple-50 transition-colors group">
                    <div class="w-10 h-10 rounded-lg bg-purple-500 text-white flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-book"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-800 text-sm">Materi</p>
                        <p class="text-xs text-slate-500">Kelola dokumen materi</p>
                    </div>
                </a>
                @endif

                @if(auth()->user()->can('akses.survey'))
                <a href="{{ route('survey.index') }}" class="flex items-center gap-3 p-3 rounded-lg bg-gradient-to-r from-cyan-50 to-cyan-50/30 hover:from-cyan-100 hover:to-cyan-50 transition-colors group">
                    <div class="w-10 h-10 rounded-lg bg-cyan-500 text-white flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-check-double"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-800 text-sm">Survey</p>
                        <p class="text-xs text-slate-500">Buat & kelola survey</p>
                    </div>
                </a>
                @endif
            </div>
        </div>

        <!-- System Info & Features -->
        <div class="lg:col-span-2 bg-white/80 backdrop-blur-sm rounded-2xl border border-slate-100/50 p-6 shadow-sm">
            <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-info-circle text-blue-500"></i> Informasi Sistem
            </h2>

            <div class="grid grid-cols-2 gap-4">
                <div class="p-4 rounded-xl bg-gradient-to-br from-slate-50 to-slate-100 border border-slate-200/50">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">Aplikasi</p>
                    <p class="text-lg font-bold text-slate-800">{{ env('APP_NAME', 'JoinYuk') }}</p>
                </div>

                <div class="p-4 rounded-xl bg-gradient-to-br from-slate-50 to-slate-100 border border-slate-200/50">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">Role Anda</p>
                    <div class="flex flex-wrap gap-1">
                        @foreach(auth()->user()->roles as $role)
                        <span class="px-2 py-1 text-xs rounded-lg bg-primary-100 text-primary-700 font-semibold">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="p-4 rounded-xl bg-gradient-to-br from-slate-50 to-slate-100 border border-slate-200/50">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">Unit Kerja</p>
                    <p class="text-lg font-bold text-slate-800">{{ auth()->user()->unit_kerja ?? 'Umum' }}</p>
                </div>

                <div class="p-4 rounded-xl bg-gradient-to-br from-slate-50 to-slate-100 border border-slate-200/50">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">Status</p>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                        <p class="text-sm font-bold text-emerald-600">Aktif</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Overview -->
    <div class="bg-gradient-to-r from-slate-50 to-slate-100 rounded-2xl border border-slate-200/50 p-8">
        <h2 class="text-2xl font-bold text-slate-800 mb-6">Fitur Utama Aplikasi</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="flex items-start gap-4 group">
                <div class="w-12 h-12 rounded-xl bg-primary-100 text-primary-600 flex items-center justify-center flex-shrink-0 text-xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-calendar-days"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800">Manajemen Rapat</h3>
                    <p class="text-sm text-slate-600 mt-1">Kelola agenda, undangan, dan materi rapat dengan mudah</p>
                </div>
            </div>

            <div class="flex items-start gap-4 group">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 text-xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-clipboard-check"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800">Sistem Absensi</h3>
                    <p class="text-sm text-slate-600 mt-1">Catat kehadiran peserta dengan tracking real-time</p>
                </div>
            </div>

            <div class="flex items-start gap-4 group">
                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0 text-xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-chart-pie"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800">Survei & Feedback</h3>
                    <p class="text-sm text-slate-600 mt-1">Kumpulkan feedback dan data dari peserta dengan survey</p>
                </div>
            </div>

            <div class="flex items-start gap-4 group">
                <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center flex-shrink-0 text-xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-file-lines"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800">Risalah Rapat</h3>
                    <p class="text-sm text-slate-600 mt-1">Catat hasil rapat dan follow-up dalam satu tempat</p>
                </div>
            </div>

            <div class="flex items-start gap-4 group">
                <div class="w-12 h-12 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center flex-shrink-0 text-xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-wallet"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800">Manajemen Anggaran</h3>
                    <p class="text-sm text-slate-600 mt-1">Kelola budget dan tracking pengeluaran kegiatan</p>
                </div>
            </div>

            <div class="flex items-start gap-4 group">
                <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center flex-shrink-0 text-xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-users-gear"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800">Manajemen User</h3>
                    <p class="text-sm text-slate-600 mt-1">Atur role dan permission pengguna sistem dengan fleksibel</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('css')
<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .bg-white\/80 {
        animation: fadeInUp 0.6s ease-out forwards;
    }

    .bg-white\/80:nth-child(n) {
        animation-delay: calc(var(--index, 0) * 0.1s);
    }
</style>
@endpush
@endsection
