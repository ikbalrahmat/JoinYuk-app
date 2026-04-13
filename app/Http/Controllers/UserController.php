<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 5);

        $query = User::with(['roles', 'permissions']);

        if (Auth::user()->hasRole('super_admin')) {
        } elseif (Auth::user()->hasRole('admin')) {
            $query->where('created_by', Auth::id());
        } elseif (Auth::user()->hasRole('yanum')) {
            $query->where('unit_kerja', Auth::user()->unit_kerja);
        }

        $users = $query->when($search, function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('unit_kerja', 'like', "%{$search}%");
        })
        ->paginate($perPage)
        ->appends(['search' => $search, 'per_page' => $perPage]);

        return view('pages.users.index', compact('users', 'search', 'perPage'));
    }

    public function create()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $unitKerjas = User::select('unit_kerja')->distinct()->pluck('unit_kerja')->filter()->toArray();
        return view('pages.users.create', compact('roles', 'permissions', 'unitKerjas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required',
            'email'         => 'required|email|unique:users',
            'password'      => 'required|min:6',
            'role'          => 'required',
            'unit_kerja'    => 'required|string',
            'permissions'   => 'array'
        ]);

        $user = User::create([
            'name'          => $validated['name'],
            'email'         => $validated['email'],
            'password'      => Hash::make($validated['password']),
            'unit_kerja'    => $validated['unit_kerja'],
            'created_by'    => Auth::id(),
        ]);

        $user->assignRole($validated['role']);

        if ($validated['role'] !== 'super_admin' && isset($validated['permissions'])) {
            $user->syncPermissions($validated['permissions']);
        }

        return redirect()->route('users.index')->with('success', 'User berhasil dibuat.');
    }

    public function edit(User $user)
    {
        if (!Auth::user()->hasRole('super_admin') && $user->created_by !== Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit user ini.');
        }

        $roles = Role::all();
        $permissions = Permission::all();
        $userPermissions = $user->permissions->pluck('name')->toArray();
        $unitKerjas = User::select('unit_kerja')->distinct()->pluck('unit_kerja')->filter()->toArray();

        return view('pages.users.edit', compact('user', 'roles', 'permissions', 'userPermissions', 'unitKerjas'));
    }

    public function update(Request $request, User $user)
    {
        if (!Auth::user()->hasRole('super_admin') && $user->created_by !== Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk memperbarui user ini.');
        }

        $validated = $request->validate([
            'name'          => 'required',
            'email'         => 'required|email|unique:users,email,' . $user->id,
            'password'      => 'nullable|min:6',
            'role'          => 'required',
            'unit_kerja'    => 'required|string',
            'permissions'   => 'array'
        ]);

        $updateData = [
            'name'          => $validated['name'],
            'email'         => $validated['email'],
            'unit_kerja'    => $validated['unit_kerja'],
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        $user->syncRoles([$validated['role']]);

        if ($validated['role'] === 'super_admin') {
            $user->syncPermissions([]);
        } else {
            $user->syncPermissions($validated['permissions'] ?? []);
        }

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if (!Auth::user()->hasRole('super_admin') && $user->created_by !== Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus user ini.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
