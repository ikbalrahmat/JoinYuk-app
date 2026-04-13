@extends('layouts.main')

@section('content')
<div class="max-w-6xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Pengaturan Akun</h2>
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-3">

            <div class="md:col-span-1 p-8 border-r border-gray-200 bg-gray-50">
                <div class="text-center">
                    <div class="relative w-24 h-24 mx-auto">
                        <div class="w-full h-full rounded-full bg-blue-600 flex items-center justify-center text-white text-4xl font-bold ring-4 ring-white shadow-md">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800 mt-4">{{ Auth::user()->name }}</h2>
                    <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                </div>
                <hr class="my-6 border-gray-200">
                <div>
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Detail Akun</h3>
                    <div class="mt-4 border border-gray-200 rounded-lg overflow-hidden">
                        <div class="divide-y divide-gray-200 text-sm">
                            <div class="grid grid-cols-[100px,auto,1fr] items-center p-3">
                                <span class="text-gray-500 font-medium">Nama</span>
                                <span class="text-gray-500 px-2">:</span>
                                <span class="text-gray-800 break-words">{{ $user->name }}</span>
                            </div>
                            <div class="grid grid-cols-[100px,auto,1fr] items-center p-3">
                                <span class="text-gray-500 font-medium">Email</span>
                                <span class="text-gray-500 px-2">:</span>
                                <span class="text-gray-800 break-words">{{ $user->email }}</span>
                            </div>
                            <div class="grid grid-cols-[100px,auto,1fr] items-center p-3">
                                <span class="text-gray-500 font-medium">Role</span>
                                <span class="text-gray-500 px-2">:</span>
                                <span class="text-gray-800 break-words">{{ ucfirst($user->role) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="md:col-span-2 p-8">
                @include('profile.partials.update-profile-information-form')

                <hr class="my-8 border-gray-200">

                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>
</div>
@endsection
