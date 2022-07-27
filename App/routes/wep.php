<?php

use \Tsoft\Core\Route;


Route::get('/', 'TeamController@index')->name('index');
Route::get('/delete/{id}', 'TeamController@destroy')->name('delete');
Route::get('/scorboard', 'TeamController@scorboard')->name('scorboard');

