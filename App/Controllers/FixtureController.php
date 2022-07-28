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
                "first_score" => 0,
                "second_score" => 0,
                "first_point" => 0,
                "second_point" => 0
            );
        }

        return $insertData;
    }

    public function destroyAll(){
        $this->model->truncate(['teams','matches']);
        return Redirect::to('/');
    }

}