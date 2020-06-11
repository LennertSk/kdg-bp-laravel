<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// List all surveys
Route::get('surveys', 'SurveyController@index');

// List selected survey
Route::get('survey/{id}', 'SurveyController@show');

// List all questions for corresponding survey
Route::get('survey/{id}/questions', 'QuestionController@index');

// List selected question for corresponding survey
Route::get('survey/{id}/{qid}', 'QuestionController@show');

// Update selected survey rating
Route::put('survey/{id}/rate/{value}', 'SurveyController@rating');

// Update amount option is selected
Route::put('answer/{oid}', 'SurveyController@answer');
