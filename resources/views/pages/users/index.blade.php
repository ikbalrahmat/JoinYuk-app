@extends('layouts.main')

@section('content')
<div class="p-6">
    <div class="bg-white p-6 rounded-2xl shadow">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-3 mb-6">
            <h3 class="text-xl font-bold text-gray-800">Daftar User</h3>
            <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-700 transition">
                <i class="fa fa-plus-circle mr-2"></i> Tambah User
            </a>
        </div>

        @if(session('success'))
        <div class="flex items-center p-3 mb-4 text-sm text-green-800 bg-green-100 border border-green-300 rounded-lg">
            <i class="fa fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
        @endif

        <div class="flex flex-col md:flex-row justify-between items-center gap-3 mb-4">
            <div class="flex items-center gap-2">
                <form id="perPageForm" method="GET" class="flex items-center gap-2">
                    <label for="per_page" class="text-sm text-gray-800">Show</label>
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <select name="per_page" id="per_page" class="text-sm border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" onchange="this.form.submit()">
                        @foreach([5, 10, 25, 50, 100] as $size)
                        <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>{{ $size }}</option>
                        @endforeach
                    </select>
                    <label class="text-sm text-gray-800">entries</label>
                </form>
            </div>

            <form method="GET" class="flex w-full md:w-auto">
                <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari user..." class="flex-grow md:flex-none border-gray-300 rounded-l-lg text-sm px-3 py-2">
                <button type="submit" class="px-3 py-2 border border-gray-300 rounded-r-lg bg-gray-50 hover:bg-gray-100">
                    <i class="fa fa-search text-gray-600"></i>
                </button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600 border border-gray-300 border-collapse">
                <thead class="bg-blue-600 text-white text-center">
                    <tr>
                        <th class="px-4 py-2 border border-gray-300">Nama</th>
                        <th class="px-4 py-2 border border-gray-300">Email</th>
                        <th class="px-4 py-2 border border-gray-300">Unit Kerja</th>
                        <th class="px-4 py-2 border border-gray-300">Role</th>
                        <th class="px-4 py-2 border border-gray-300">Akses Halaman</th>
                        <th class="px-4 py-2 border border-gray-300 w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border border-gray-300">{{ $user->name }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $user->email }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $user->unit_kerja }}</td>
                        <td class="px-4 py-2 border border-gray-300">
                            @foreach($user->roles as $role)
                            <span class="px-2 py-1 text-xs rounded
                                @if($role->name === 'super_admin') bg-purple-100 text-purple-700 @elseif($role->name === 'admin') bg-blue-100 text-blue-700 @else bg-gray-200 text-gray-700 @endif">
                                {{ ucfirst($role->name) }}
                            </span>
                            @endforeach
                        </td>
                        <td class="px-4 py-2 border border-gray-300">
                            @if($user->hasRole('super_admin'))
                            <span class="text-green-600 font-semibold">Semua akses</span>
                            @else
                                @if($user->getPermissionNames()->isEmpty())
                                <span class="text-red-600">Tidak ada akses</span>
                                @else
                                <ul class="list-disc list-inside text-gray-600">
                                    @foreach($user->getPermissionNames() as $perm)
                                    <li>{{ ucfirst(str_replace(['akses.', 'create.', 'update.', 'delete.', 'export.'], '', $perm)) }}</li>
                                    @endforeach
                                </ul>
                                @endif
                            @endif
                        </td>
                        <td class="px-4 py-2 text-center border border-gray-300">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('users.edit', $user->id) }}" class="p-2 text-yellow-600 hover:bg-yellow-100 rounded-full" title="Edit">
                                    <i class="fa fa-pen"></i>
                                </a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="p-2 text-red-600 hover:bg-red-100 rounded-full" title="Hapus">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 py-4 border border-gray-300">Belum ada user.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex justify-between items-center">
            <div class="text-sm text-gray-700">
                Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} results
            </div>
            <div class="flex items-center gap-1">
                @if ($users->onFirstPage())
                    <button class="px-3 py-1 text-gray-400 bg-gray-100 border border-gray-300 rounded cursor-not-allowed">«</button>
                    <button class="px-3 py-1 text-gray-400 bg-gray-100 border border-gray-300 rounded cursor-not-allowed">‹</button>
                @else
                    <a href="{{ $users->url(1) }}" class="px-3 py-1 text-gray-600 bg-white border border-gray-300 rounded hover:bg-gray-100">«</a>
                    <a href="{{ $users->previousPageUrl() }}" class="px-3 py-1 text-gray-600 bg-white border border-gray-300 rounded hover:bg-gray-100">‹</a>
                @endif

                @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                    @if ($page == $users->currentPage())
                        <span class="px-3 py-1 text-sm bg-blue-600 text-white border border-blue-600 rounded">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1 text-sm text-gray-600 bg-white border border-gray-300 rounded hover:bg-gray-100">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($users->hasMorePages())
                    <a href="{{ $users->nextPageUrl() }}" class="px-3 py-1 text-gray-600 bg-white border border-gray-300 rounded hover:bg-gray-100">›</a>
                    <a href="{{ $users->url($users->lastPage()) }}" class="px-3 py-1 text-gray-600 bg-white border border-gray-300 rounded hover:bg-gray-100">»</a>
                @else
                    <button class="px-3 py-1 text-gray-400 bg-gray-100 border border-gray-300 rounded cursor-not-allowed">›</button>
                    <button class="px-3 py-1 text-gray-400 bg-gray-100 border border-gray-300 rounded cursor-not-allowed">»</button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
