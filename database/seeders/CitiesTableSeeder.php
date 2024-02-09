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
    
        // Lire chaque ligne du fichier CSV
        while (($row = fgetcsv($file)) !== FALSE) {
            // Insérer les données dans la base de données
            DB::table('cities')->insert([
                'city' => $row[0],
                'country' => $row[4],
                'capital' => $row[8] === 'primary' ? 'yes' : 'no', // Assumer 'yes' pour les capitales, 'no' sinon
            ]);
        }
    
        fclose($file);
    }
}
