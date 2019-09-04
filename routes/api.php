<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Programs and Code Mapping
Route::get('/programs', 'ProgramController@index');
Route::post('/programs', 'ProgramController@store');
Route::patch('/programs/{program}', 'ProgramController@update');