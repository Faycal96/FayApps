<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Ouvrir le fichier CSV
        $file = fopen(base_path('database/data/worldcities.csv'), 'r');
        fgetcsv($file); // Ignorer l'en-tête du CSV

        // Créer un tableau pour stocker les villes par pays
        $citiesByCountry = [];

        // Lire chaque ligne du fichier CSV
        while (($row = fgetcsv($file)) !== FALSE) {
            $country = $row[4];
            $population = (int)$row[9];
            $city = [
                'city' => $row[0],
                'capital' => $row[8] === 'primary' ? 'yes' : 'no',
                'population' => $population
            ];

            // Ajouter la ville au tableau des villes du pays
            if (!isset($citiesByCountry[$country])) {
                $citiesByCountry[$country] = [];
            }

            $citiesByCountry[$country][] = $city;
        }

        fclose($file);

        // Insérer les 3 villes les plus peuplées de chaque pays dans la base de données
        foreach ($citiesByCountry as $country => $cities) {
            // Trier les villes par population décroissante
            usort($cities, function ($a, $b) {
                return $b['population'] - $a['population'];
            });

            // Prendre uniquement les 3 premières villes
            $topThreeCities = array_slice($cities, 0, 10);

            // Insérer les villes dans la base de données
            foreach ($topThreeCities as $city) {
                DB::table('cities')->insert([
                    'city' => $city['city'],
                    'country' => $country,
                    'capital' => $city['capital']
                ]);
            }
        }
    }
}
