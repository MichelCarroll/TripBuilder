<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
    return View::make('hello');
});

// fetching all airports
Route::get('/airports', 'AirportsController@getAll');

// fetching trip and associated flights
Route::get('/trips/{id}', function($id)
{
    var_dump('show trip');
    var_dump($id);
})->where('id', '[0-9]+');

Route::put('/trips/{id}', function($id)
{
    var_dump('put trip');
    var_dump($id);
})->where('id', '[0-9]+');

Route::get('/trips/{id}/flights/{src},{trg}', function($id, $src, $trg)
{
    var_dump('put flight');
    var_dump($id);
    var_dump($src);
    var_dump($trg);
})->where(['id' => '[0-9]+', 'src' => '[A-Z]+', 'trg' => '[A-Z]+']);

Route::delete('/trips/{id}/flights/{src},{trg}', function($id, $src, $trg)
{
    var_dump('delete flight');
    var_dump($id);
    var_dump($src);
    var_dump($trg);
})->where(['id' => '[0-9]+', 'src' => '[A-Z]+', 'trg' => '[A-Z]+']);