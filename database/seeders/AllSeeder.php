<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AllSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['super_admin', 'admin', 'penghuni', 'security'];
        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

        $super_admin = User::create([
            'name' => 'Super Admin',
            'username' => 'super_admin',
            'email' => 'super_admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $admin = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $penghuni = User::create([
            'name' => 'Tony',
            'username' => 'tony_stark',
            'nickname' => 'Bapak Tony',
            'email' => 'penghuni@example.com',
            'password' => Hash::make('password'),
        ]);

        $security = User::create([
            'name' => 'Security I',
            'username' => 'security',
            'email' => 'security@example.com',
            'password' => Hash::make('password'),
        ]);


        $super_admin->roles()->attach(Role::where('name', 'super_admin')->first());
        $admin->roles()->attach(Role::where('name', 'admin')->first());
        $penghuni->roles()->attach(Role::where('name', 'penghuni')->first());
        $security->roles()->attach(Role::where('name', 'security')->first());
    }
}
