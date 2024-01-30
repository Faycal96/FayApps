<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creating Super Admin User
        $superAdmin = User::create([
            'name' => 'Super Admin', 
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('12345678')
        ]);
        $superAdmin->assignRole('Super Admin');

        // Creating Admin User
        $admin = User::create([
            'name' => 'Admin', 
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678')
        ]);
        $admin->assignRole('Admin');

        $agencevoyage = User::create([
            'name' => 'agence voyage', 
            'email' => 'agencevoyage@gmail.com',
            'password' => Hash::make('12345678')
        ]);
        $agencevoyage->assignRole('Agence Voyage');

        // Creating Product Manager User
        $dafMinistere = User::create([
            'name' => 'Daf Ministere', 
            'email' => 'daf@gmail.com',
            'password' => Hash::make('12345678')
        ]);
        $dafMinistere->assignRole('DAF MINISTERE');
    }
}