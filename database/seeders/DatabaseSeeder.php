<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
        ]);

        $user = new User();
        $user->name = "Super Admin";
        $user->email = "superadmin@peruri.co.id";
        $user->password = Hash::make("P@ssword123!");
        $user->save();

        $user->assignRole('super_admin');
    }
}
