<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomepageController@index');

/*
 * Get Survey details
 */

Route::get('/get-started', 'InputController@index');
Route::post('/get-started/set', 'InputController@set');

Route::get('/dashboard', 'DashboardController@index');
Route::post('/dashboard/login', 'DashboardController@login');

Route::get('/get-question/{id}', 'DashboardController@question');
Route::get('/remove-question/{id}', 'DashboardController@remove');

Route::get('/add-question', 'CreateQuestionController@index');
Route::post('add-question/question', 'CreateQuestionController@question');

Route::get('/add-question/info', 'CreateQuestionController@questionInfo');
Route::post('/add-question/info/set', 'CreateQuestionController@questionInfoSet');

Route::get('/add-question/{id}', 'CreateQuestionController@questionType');

Route::post('/add-question/post/select', 'CreateQuestionController@addSelect');
Route::post('/add-question/post/range', 'CreateQuestionController@addRange');

Route::view('/terms', 'terms');
Route::view('/privacy', 'privacy');