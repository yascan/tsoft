<?php

use \Tsoft\Core\Route;


Route::get('/',function (){


    $model = new \Tsoft\App\Models\User();
    echo $model->where(['id' => 5])->update(['point' => 50, 'drawn' => 3]);
});