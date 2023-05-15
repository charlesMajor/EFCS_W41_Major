<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stat;
use Illuminate\Support\Facades\DB;

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
        $films = $films->data;

        foreach ($films as $film)
        {
            $totalVotes = 0;
            $totalScore = 0;
            $score = 0;
            $reviews = $film->reviews;
            foreach ($reviews as $review)
            {
                $totalVotes += $review->votes;
                $totalScore += ($review->score * $review->votes);
            }  
            if ($totalVotes != 0)
            {
                $score = $totalScore/$totalVotes;
            }

            $sql = 'INSERT INTO `stats` (`film_id`, `score`, `votes`) VALUES
            ('.$film->id.', '.$score.', '.$totalVotes.')';

            DB::statement($sql);
        }
        
    }
}
