@extends('layouts.plain')

@section('content')
<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <a href="{{ route('welcome') }}">
                        <img src="{{ asset('assets/logo1.png') }}" alt="Logo" class="img-fluid" style="max-height: 80px;">
                    </a>
                </div>

                <h4 class="text-center mb-4 font-weight-bold">Pengaturan Password Baru</h4>

                @if(isset($message))
                    <div class="alert alert-warning text-center small mb-4">
                        <i class="fa fa-exclamation-triangle me-1"></i> {{ $message }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.setup.update') }}" autocomplete="off">
                    @csrf

                    {{-- Field tersembunyi untuk mencegah autofill browser --}}
                    <input type="text" name="username_fake" style="display:none" tabindex="-1" autocomplete="username">
                    <input type="password" name="password_fake" style="display:none" tabindex="-1" autocomplete="current-password">

                    {{-- Password Baru --}}
                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru <span class="text-danger">*</span></label>
                        <input id="password" type="password"
                            class="form-control form-control-lg @error('password') is-invalid @enderror"
                            name="password" required autocomplete="new-password" autofocus>
                        <div class="form-text small text-muted">Minimal 8 karakter. Pastikan menggunakan kombinasi yang aman.</div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                        <input id="password_confirmation" type="password"
                            class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror"
                            name="password_confirmation" required autocomplete="new-password">
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="d-grid gap-2 mb-3">
                        <button type="submit" class="btn btn-primary btn-lg">
                            Simpan & Lanjutkan
                        </button>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('logout') }}" class="text-decoration-none text-muted small" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Kembali ke Halaman Login
                        </a>
                    </div>
                </form>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
