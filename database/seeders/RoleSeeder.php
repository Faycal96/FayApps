<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Admin']);
        $dafMinistere = Role::create(['name' => 'DAF MINISTERE']);
        $agenceVoyage = Role::create(['name' => 'Agence Voyage']);

        $admin->givePermissionTo([
            'create-role',
            'edit-role',
            'delete-role',
            'create-user',
            'edit-user',
            'delete-user'
           
        ]);

        $dafMinistere->givePermissionTo([
            'create-demande-billet',
            'edit-demande-billet',
           
            'rejetter-demande-billet',
            'valider-demande-billet'
        ]);
        $agenceVoyage->givePermissionTo([
            'propose-demande-billet'
        ]);
    }
}