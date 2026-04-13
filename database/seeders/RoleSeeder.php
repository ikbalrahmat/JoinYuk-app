<?php

// namespace Database\Seeders;

// use Illuminate\Database\Seeder;
// use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;

// class RoleSeeder extends Seeder
// {

//     public function run(): void
//     {
//         $admin = Role::firstOrCreate(['name' => 'admin']);
//         $user = Role::firstOrCreate(['name' => 'user']);
//         $yanumKarawang = Role::firstOrCreate(['name' => 'yanum_karawang']);
//         $yanumJakarta = Role::firstOrCreate(['name' => 'yanum_jakarta']);

//         $permissions = [
//             'akses.dashboard',
//             'akses.user',
//             'akses.undangan',
//             'akses.agenda',
//             'akses.rapat',
//             'akses.materi',
//             'akses.absensi',
//             'akses.risalah',
//             'akses.kuis',
//             'akses.survey',
//             'akses.anggaran',
//             'akses.konsumsi',
//             'create.konsumsi',
//             'update.konsumsi',
//             'delete.konsumsi',
//             'export.konsumsi',
//         ];


//         foreach ($permissions as $permission) {
//             Permission::firstOrCreate(['name' => $permission]);
//         }

//         // Admin punya semua permission
//         $admin->syncPermissions($permissions);

//         // User default: kosong
//         // Yanum default: kosong juga
//     }
// }



namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat role yang diperlukan
        $super_admin = Role::firstOrCreate(['name' => 'super_admin']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $user = Role::firstOrCreate(['name' => 'user']);
        $yanum = Role::firstOrCreate(['name' => 'yanum']);

        // 2. Daftar semua permission
        $permissions = [
            'akses.dashboard',
            'akses.user',
            'akses.undangan',
            'akses.agenda',
            'akses.rapat',
            'akses.materi',
            'akses.absensi',
            'akses.risalah',
            'akses.kuis',
            'akses.survey',
            'akses.anggaran',
            'akses.konsumsi',
            'create.konsumsi',
            'update.konsumsi',
            'delete.konsumsi',
            'export.konsumsi',
        ];

        // 3. Buat permission satu per satu
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 4. Berikan semua permission ke role super_admin secara otomatis
        $super_admin->syncPermissions($permissions);

        // 5. Role lain tidak diberi permission awal. Permission akan diatur secara manual
        // pada saat pembuatan/pengeditan user di halaman User Management.
        $admin->syncPermissions([]);
        $user->syncPermissions([]);
        $yanum->syncPermissions([]);
    }
}
