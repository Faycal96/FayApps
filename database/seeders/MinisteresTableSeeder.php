<?php

namespace Database\Seeders;

use App\Models\Ministere;
use App\Models\Structure;
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
        // Seed pour les ministères
        $ministeres = [
            ['libelleLong' => 'Ministère de la Défense et des Anciens combattants', 'libelleCourt' => 'MDAC'],
            ['libelleLong' => 'Ministère de la fonction publique, du travail et de la protection sociale', 'libelleCourt' => 'MFPTP'],
            ['libelleLong' => 'Ministère de l\'Administration territoriale, de la Décentralisation et de la Sécurité', 'libelleCourt' => 'MATDS'],
            ['libelleLong' => 'Ministère de l\'Economie, des Finances et de la Prospective ', 'libelleCourt' => 'MEFP'],
            ['libelleLong' => 'Primature', 'libelleCourt' => 'PM'],
            ['libelleLong' => 'Ministère de la Transition digitale, des Postes et des Communications électroniques', 'libelleCourt' => 'MTDPCE'],
            ['libelleLong' => 'Ministère de l\'Éducation Nationale', 'libelleCourt' => 'MENA'],
        ];

        foreach ($ministeres as $ministereData) {
            $ministere = Ministere::create($ministereData);

            // Seed pour les structures associées à chaque ministère
            $structures = [];

            switch ($ministere->libelleCourt) {
                case 'MDAC':
                    $structures[] = ['libelleLong' => 'Direction Générale du ' . $ministere->libelleLong, 'libelleCourt' => 'DG-' . $ministere->libelleCourt, 'ministere_id' => $ministere->id];
                    $structures[] = ['libelleLong' => 'Direction des Opérations du ' . $ministere->libelleLong, 'libelleCourt' => 'DO-' . $ministere->libelleCourt, 'ministere_id' => $ministere->id];
                    break;
                case 'MTPCE':
                        $structures[] = ['libelleLong' => 'Direction Générale du ' . $ministere->libelleLong, 'libelleCourt' => 'DG-' . $ministere->libelleCourt, 'ministere_id' => $ministere->id];
                        $structures[] = ['libelleLong' => 'Direction des Opérations du ' . $ministere->libelleLong, 'libelleCourt' => 'DO-' . $ministere->libelleCourt, 'ministere_id' => $ministere->id];
                        break;
                case 'MFPTP':
                    $structures[] = ['libelleLong' => 'Direction Générale du ' . $ministere->libelleLong, 'libelleCourt' => 'DG-' . $ministere->libelleCourt, 'ministere_id' => $ministere->id];
                    $structures[] = ['libelleLong' => 'Direction des Ressources Humaines du ' . $ministere->libelleLong, 'libelleCourt' => 'DRH-' . $ministere->libelleCourt, 'ministere_id' => $ministere->id];
                    break;
                // Ajoutez des cas pour d'autres ministères si nécessaire
                default:
                    // Aucune structure spécifique pour ce ministère
                    break;
            }

            foreach ($structures as $structureData) {
                Structure::create($structureData);
            }
        }
    }
}