<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stat;

class StatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents(database_path() . '/seeders/data_source.json');
        $films = json_decode($json);

        //$films est l'objet json au complet représenté par la datasource.json

        //TODO : Mettre à jour les statistiques 
        //RAPPEL : Le seed donné n'insère pas de critiques, on a seulement les critiques de la data source pour le moment
        //         Ceci facilite le calcul
    }
}
