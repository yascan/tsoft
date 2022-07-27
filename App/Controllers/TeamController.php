<?php

namespace Tsoft\App\Controllers;

use Tsoft\App\Models\Team;
use Tsoft\Core\Helpers\Redirect;

class TeamController
{
    protected $model;
    public function __construct(){
        $this->model = new Team();
    }

    public function index(){
        $teams = $this->model->select(['id', 'name', 'power'])->get();
        return view('index', ['teams' => $teams]);
    }

    public function destroy(int $id){
        $destroy = $this->model->where(['id' => $id])->delete();
        if ($destroy){
            return Redirect::to('/');
        }
    }

    public function scorboard(){
        $scorboard = $this->model->orderBy('point', 'DESC')->get();
        return view('scorboard', ['scorboard' => $scorboard]);
    }
}