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
    return View::make('test_harness');
});

// fetching all airports
Route::get('/airports', 'AirportsController@getAll');

// creating trip
Route::post('/trips', 'TripsController@create');

// fetching trip and associated flights
Route::get('/trips/{id}', 'TripsController@get')->where('id', '[a-z0-9]+');

// update a trip
Route::put('/trips/{id}', 'TripsController@update')->where('id', '[a-z0-9]+');

// adding a flight to a trip
Route::put('/trips/{id}/flights/{src},{trg}', 'FlightsController@create')
    ->where(['id' => '[a-z0-9]+', 'src' => '[A-Z]{3}', 'trg' => '[A-Z]{3}']);

// removing a flight from a trip
Route::delete('/trips/{id}/flights/{src},{trg}', 'FlightsController@delete')
    ->where(['id' => '[a-z0-9]+', 'src' => '[A-Z]{3}', 'trg' => '[A-Z]{3}']);