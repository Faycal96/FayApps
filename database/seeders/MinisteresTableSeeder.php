<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MinisteresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $ministeres = [
            ['libelleLong' => 'Ministère de la Défense et des Anciens combattants', 'libelleCourt' => 'MDAC'],
            ['libelleLong' => 'Ministère de la fonction publique, du travail et de la protection sociale', 'libelleCourt' => 'MFPTP'],
            ['libelleLong' => 'Ministère de l\'Administration territoriale, de la Décentralisation et de la Sécurité', 'libelleCourt' => 'MATDS'],
            ['libelleLong' => 'Ministère de l\'Economie, des Finances et de la Prospective ', 'libelleCourt' => 'MEFP'],
            ['libelleLong' => 'Primature', 'libelleCourt' => 'PM'],
            ['libelleLong' => 'Ministère de la Transition digitale, des Postes et des Communications électroniques', 'libelleCourt' => 'MTDPCE'],
            ['libelleLong' => 'Ministère de l\'Éducation Nationale', 'libelleCourt' => 'MENA'],

        ];

        DB::table('ministeres')->insert($ministeres);
    }
};
