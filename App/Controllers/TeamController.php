<?php

namespace Tsoft\App\Controllers;

use Tsoft\App\Models\Team;
use Tsoft\Core\Controller;
use Tsoft\Core\Helpers\Redirect;

class TeamController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new Team();
    }

    public function index()
    {
        $teams = $this->model->orderBy('point', 'DESC')->get();
        return view('index', ['teams' => $teams]);
    }

    public function destroy(int $id)
    {
        $destroy = $this->model->where(['id' => $id])->delete();
        if ($destroy) {
            return Redirect::to('/');
        }
    }

    public function scorboard()
    {
        $scorboard = $this->model->orderBy('point', 'DESC')->get();
        return view('scorboard', ['scorboard' => $scorboard]);
    }

    public function store()
    {
        $insertData = [
            "name" => $this->input('name', ''),
            "power" => $this->input('power', 0),
        ];
        $this->model->insert($insertData);
        Redirect::to('/');
    }
}