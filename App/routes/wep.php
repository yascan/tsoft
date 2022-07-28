<?php

use \Tsoft\Core\Route;


Route::get('/', 'TeamController@index')->name('index');
Route::get('/delete/{id}', 'TeamController@destroy')->name('delete');
Route::get('/scorboard', 'TeamController@scorboard')->name('scorboard');
Route::get('/fixture', 'FixtureController@index')->name('fixture');
Route::get('/createFixture', 'FixtureController@createFixture')->name('createFixture');
Route::post('/store','TeamController@store');
Route::get('/destroyAll', 'FixtureController@destroyAll')->name('destroyAll');


