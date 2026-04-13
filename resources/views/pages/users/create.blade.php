@extends('layouts.main')

@section('content')
<div class="p-6">
    <div class="bg-white p-6 rounded-2xl shadow">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-800">Tambah User</h3>
            <a href="{{ route('users.index') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded-lg shadow hover:bg-gray-600 transition">
                <i class="fa fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>

        <form action="{{ route('users.store') }}" method="POST" autocomplete="off" class="space-y-4">
            @csrf

            <input type="text" name="fakeusernameremembered" class="hidden">
            <input type="password" name="fakepasswordremembered" class="hidden">

            <div>
                <label for="name" class="block text-sm font-semibold mb-1">Nama</label>
                <input type="text" name="name" id="name" required
                       class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold mb-1">Email</label>
                <input type="email" name="email" id="email" required
                       class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold mb-1">Password</label>
                <input type="password" name="password" id="password" autocomplete="new-password" required
                       class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="unit_kerja" class="block text-sm font-semibold mb-1">Unit Kerja</label>
                <select name="unit_kerja" id="unitKerjaSelect"
                        class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Pilih Unit Kerja --</option>
                    @foreach ($unitKerjas as $uk)
                        <option value="{{ $uk }}">{{ $uk }}</option>
                    @endforeach
                    <option value="__other">Lainnya</option>
                </select>
                <input type="text" name="unit_kerja_manual" id="unitKerjaManual"
                       class="hidden mt-2 w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Isi Unit Kerja Manual">
            </div>

            <div>
                <label for="roleSelect" class="block text-sm font-semibold mb-1">Role</label>
                <select name="role" id="roleSelect" required
                        class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Pilih Role --</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                    @endforeach
                </select>
            </div>

            <div id="permissionGroup" class="hidden">
                <label class="block text-sm font-semibold mb-2">Akses Halaman</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2">
                    @foreach ($permissions as $perm)
                        @php
                            $permName = $perm->name;
                            if (str_starts_with($permName, 'akses.')) {
                                $label = 'Akses ' . ucfirst(str_replace('akses.', '', $permName));
                            } elseif (str_starts_with($permName, 'create.')) {
                                $label = 'Create ' . ucfirst(str_replace('create.', '', $permName));
                            } elseif (str_starts_with($permName, 'update.')) {
                                $label = 'Update ' . ucfirst(str_replace('update.', '', $permName));
                            } elseif (str_starts_with($permName, 'delete.')) {
                                $label = 'Delete ' . ucfirst(str_replace('delete.', '', $permName));
                            } elseif (str_starts_with($permName, 'export.')) {
                                $label = 'Export ' . ucfirst(str_replace('export.', '', $permName));
                            } else {
                                $label = ucfirst($permName);
                            }
                        @endphp

                        <div class="flex items-center">
                            <input type="checkbox" name="permissions[]" value="{{ $perm->name }}" id="perm_{{ $perm->id }}"
                                   class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="perm_{{ $perm->id }}" class="text-sm text-gray-700">
                                {{ $label }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="inline-flex items-center px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-700 transition">
                    <i class="fa fa-save mr-2"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const roleSelect = document.getElementById('roleSelect');
    const permissionGroup = document.getElementById('permissionGroup');
    const unitKerjaSelect = document.getElementById('unitKerjaSelect');
    const unitKerjaManual = document.getElementById('unitKerjaManual');

    function togglePermissions() {
        const roleValue = roleSelect.value.toLowerCase();
        if (!roleValue || roleValue === 'super_admin') {
            permissionGroup.classList.add('hidden');
        } else {
            permissionGroup.classList.remove('hidden');
        }
    }

    function toggleManualInput() {
        if (unitKerjaSelect.value === '__other') {
            unitKerjaManual.classList.remove('hidden');
            unitKerjaManual.name = 'unit_kerja';
        } else {
            unitKerjaManual.classList.add('hidden');
            unitKerjaManual.name = 'unit_kerja_manual';
        }
    }

    roleSelect.addEventListener('change', togglePermissions);
    unitKerjaSelect.addEventListener('change', toggleManualInput);

    togglePermissions();
    toggleManualInput();
});
</script>
@endpush
