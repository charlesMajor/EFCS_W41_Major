<?php


namespace App\GraphQL\Mutations;
use Auth;
use App\Models\Film;
use App\Models\Stat;
use App\Models\Critic;

final class CreateCritic
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $filmId = $args["film"];
        $userId = Auth::User()->id;

        $content = [
            'score' => $args["score"],
            'comment' => $args["comment"],
            'user_id' => $userId,
            'film_id' => $filmId
        ];
        Critic::create($content);

        $stat = Stat::where('film_id', $filmId)->first();
        $stat->score = (($stat->score*$stat->votes)+$args["score"])/($stat->votes+1);
        $stat->votes += 1;
        $stat->save();

        return $stat;
    }
}
