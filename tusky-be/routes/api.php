<?php

use Illuminate\Http\Request;

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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth' // adds /auth prefix on routes
], function ($router) {
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});
Route::post('/auth/login', 'AuthController@login');


/**
 * Routes for user CRUD.
 */

//get specific user
Route::get('/user', 'UserController@index');
//update user
Route::put('/user', 'UserController@update');
//register user
Route::post('/user', 'UserController@create');


/**
 * Routes for topics CRUD
 */

//get all topics
Route::get('/topics', 'TopicController@index');

//get all topics for user
Route::get('/user/{user}/topics', 'TopicController@userIndex');

//add new topic for user
Route::post('/user/{user}/topics/{topic}', 'TopicController@store');

//delete topic with id for user
Route::delete('/user/{user}/topics/{topic}', 'TopicController@destroy');


//TODO tasks

/**
 * Routes for tasks CRUD
 */

//all tasks for user
Route::get('/user/{user}/tasks', 'TaskController@userIndex')->middleware('auth:api');

//add task for user
Route::post('/user/{user}/tasks/{task}', 'TaskController@store');

//update task for user
Route::put('/user/{user}/tasks/{task}','TaskController@update');

//all tasks for topic
Route::get('/topic/{topic}/tasks', 'TaskController@topicIndex');

//get specific task with subtasks for user
Route::get('/user/{user}/tasks/{task}', 'TaskController@show');

//delete task with id for user
Route::delete('/user/{user}/tasks/{task}', 'TaskController@destroy');

Route::get('/task/{task}', 'TaskController@getById')->middleware('auth:api');
