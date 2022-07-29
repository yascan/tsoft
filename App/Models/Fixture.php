<?php

namespace Tsoft\App\Models;

use Tsoft\Core\Model;

class Fixture extends Model
{
    protected $table = 'matches';

    public function notPlayTeams()
    {
        return $this->select('matches.*, f.power as first_team_power, s.power as second_team_power, f.point as first_team_point, f.won as first_team_won, f.drawn as first_team_drawn, f.lost as first_team_lost, s.point as second_team_point, s.won as second_team_won, s.drawn as second_team_drawn, s.lost as second_team_lost')
            ->join('left join teams f on f.id=matches.first_team_id left join teams s on s.id=matches.second_team_id')
            ->where([["first_score", "is", NULL]])
            ->get();
    }


}