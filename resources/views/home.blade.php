@extends('layouts.main')

@section('content')
<div class="py-10">
    <div class="text-center mb-10">
        <h2 class="text-2xl font-bold">Selamat Datang di Dashboard</h2>
        <p class="text-gray-500">Kamu berhasil login ke sistem <strong>JoinYuk</strong>.</p>
    </div>

    <div class="grid gap-6 md:grid-cols-3">
        <!-- Absensi -->
        <div class="bg-white rounded-2xl shadow p-6 text-center">
            <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full bg-blue-100 text-blue-600">
                <i class="fa fa-calendar-check text-2xl"></i>
            </div>
            <h5 class="text-lg font-semibold mb-2">Absensi</h5>
            <p class="text-gray-500 mb-4">Kelola daftar kehadiran peserta rapat dan agenda kegiatan.</p>
            <a href="{{ route('presence.index') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Lihat Absensi
            </a>
        </div>

        <!-- Materi -->
        <div class="bg-white rounded-2xl shadow p-6 text-center">
            <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full bg-green-100 text-green-600">
                <i class="fa fa-book text-2xl"></i>
            </div>
            <h5 class="text-lg font-semibold mb-2">Materi</h5>
            <p class="text-gray-500 mb-4">Upload dan lihat materi yang dibahas dalam rapat.</p>
            <a href="{{ route('materi.index') }}" class="inline-block px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                Lihat Materi
            </a>
        </div>

        <!-- Survey -->
        <div class="bg-white rounded-2xl shadow p-6 text-center">
            <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full bg-yellow-100 text-yellow-600">
                <i class="fa fa-chart-line text-2xl"></i>
            </div>
            <h5 class="text-lg font-semibold mb-2">Survey</h5>
            <p class="text-gray-500 mb-4">Cek dan isi survei terkait rapat dan evaluasi kegiatan.</p>
            <a href="{{ route('survey.index') }}" class="inline-block px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                Lihat Survey
            </a>
        </div>
    </div>
</div>
@endsection
