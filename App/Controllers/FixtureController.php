<?php

namespace Tsoft\App\Controllers;

use Tsoft\App\Models\Fixture;
use Tsoft\App\Models\Team;
use Tsoft\Core\Controller;
use Tsoft\Core\Helpers\Redirect;

class FixtureController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new Fixture();
    }

    public function index()
    {
        $matches = $this->model->select('matches.*, f.name as first_name, s.name as second_name')
            ->join('left join teams f on f.id=matches.first_team_id left join teams s on s.id=matches.second_team_id')
            ->get();
        $isFixture = $this->model->count();
        return view('fixture', compact('matches', 'isFixture'));
    }

    public function createFixture()
    {
        $this->model->insert($this->matchUp());
        return Redirect::to('/fixture');
    }

    private function matchUp()
    {
        $TeamModel = new Team();
        $teams = $TeamModel->select('id')->get();

        // gelen takımları karıştırır
        shuffle($teams);

        //takımları 2şer 2şer böler
        $matches = array_chunk($teams, 2);

        $insertData = [];
        foreach ($matches as $match) {
            $insertData[] = array(
                "first_team_id" => $match[0]->id,
                "second_team_id" => $match[1]->id,
                "first_score" => null,
                "second_score" => null,
                "first_point" => 0,
                "second_point" => 0
            );
        }

        return $insertData;
    }

    public function destroyAll()
    {
        $this->model->truncate(['matches']);
        return Redirect::to('/');
    }

    public function start()
    {
        $matches = $this->model->notPlayTeams();

        foreach ($matches as $match) {
            // 1. takım ve 2. takımın güç farkı alınır
            $powerDifference = $match->first_team_power - $match->second_team_power;

            // farkın yarısı %50 ye eklenir 1. takımın kazanma şansıdır. kalan %lik kısım ise 2. takımın kazanma şansındır.
            $firstTeamChanceToWin = 50 + ($powerDifference / 2);

            //random yası belirlenir 1. takmın kazanma yüzdeliğinden fazla sayı çıkarsa takım 2 kazanmış olur.
            // random sayı 100 üzeri gelirse berabere durumu ortaya çıkmaktadır.
            $random = rand(0, 125);

            $debug = array(
                "1. takım gücü" => "$match->first_team_power",
                "2. takım gücü" => $match->second_team_power,
                "1. takım kazanma şansı" => $firstTeamChanceToWin,
                "2. takım kazanma şansı" => 50 - ($powerDifference / 2),
                "güç farkı" => $powerDifference,
                "random gelen sayı" => $random,
            );

            if ($random <= 100) {
                $winningTeam = $firstTeamChanceToWin >= $random ? "first" : "second";
                $losingTeam = $winningTeam == "first" ? "second" : "first";


                // Maç skorunu belirlenir
                $winningTeamScore = rand(1, 5);
                $losingTeamScore = rand(0, $winningTeamScore - 1);

                //Takımlara verilecek puan değerleri
                $winningTeamPoint = 3;
                $losingTeamPoint = 0;

                // kazanan takımın gücü +1 ve puanı +3 artar. kaybeden takmın gücü -1 azalır.
                $winningTeamData = [
                    "power" => $match->{$winningTeam . '_team_power'} == 100 ? 100 : $match->{$winningTeam . '_team_power'} + 1,
                    "won" => $match->{$winningTeam . '_team_won'} + 1,
                    "point" => $match->{$winningTeam . '_team_point'} + $winningTeamPoint
                ];

                $losingTeamData = [
                    "power" => $match->{$losingTeam . '_team_power'} == 0 ? 0 : $match->{$losingTeam . '_team_power'} - 1,
                    "lost" => $match->{$winningTeam . '_team_lost'} + 1,
                    "point" => $match->{$losingTeam . '_team_point'}
                ];


                $debug = array_merge($debug, [
                    "kazanan takım id" => $match->{$winningTeam . '_team_id'},
                    "kaybeden takım id" => $match->{$losingTeam . '_team_id'},
                    "Maç durumu" => $winningTeam . " takım kazandı"
                ]);

            } else {
                //Random sayım 100 üzeri gelirse else durumuna düşer ve berabere durumu olur

                // Puan ve skor farkı olmadığı için sabit değer olarak atanmıştır.
                $winningTeam = "first";
                $losingTeam = "second";

                // Puan değeri ataması yapıldı
                $winningTeamPoint = 1;
                $losingTeamPoint = 1;

                //Beraberlik için maç skoru belirlenir
                $winningTeamScore = rand(0, 5);
                $losingTeamScore = $winningTeamScore;

                $winningTeamData = [
                    "drawn" => $match->first_team_power + 1,
                    "point" => $match->second_team_point + $winningTeamPoint
                ];

                $losingTeamData = [
                    "drawn" => $match->first_team_drawn + 1,
                    "point" => $match->second_team_point + $losingTeamPoint
                ];

                $debug['Maç durumu'] = "berabere";
            }

            $TeamModel = new Team();
            $TeamModel->where(['id' => $match->{$winningTeam . '_team_id'}])
                ->limit(1)
                ->update($winningTeamData);
            $TeamModel->where(['id' => $match->{$losingTeam . '_team_id'}])
                ->limit(1)
                ->update($losingTeamData);


            $this->model->where(["id" => $match->id])->limit(1)
                ->update([
                    $winningTeam . "_score" => $winningTeamScore,
                    $losingTeam . "_score" => $losingTeamScore,
                    $winningTeam . "_point" => $winningTeamPoint,
                    $losingTeam . "_point" => $losingTeamPoint,
                    "debug" => json_encode($debug, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
                ]);
        }

        Redirect::to('/fixture');

    }

}