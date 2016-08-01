<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('_develop/createModels/{path?}', function ($path = null) {
    return (new \App\Http\Core\CreateModels())->run($path);
});

Route::get('_develop/addColumns/{table_id}', function ($table_id) {
    return (new \App\Http\Core\CreateModels())->createColumn($table_id);
});

Route::get('_develop/addFields/{tab_id}', function ($tab_id) {
    return (new \App\Http\Core\CreateModels())->createField($tab_id);
});

Route::get('_develop/showWindow/{window_id}', function ($window_id) {
    return (new \App\Http\Core\CreateModels())->showWindow($window_id);
});

Route::get('_develop/getTableDate/{tab_id}/{table_id}', function ($tab_id, $table_id) {
    return (new \App\Http\Core\CreateModels())->getTableDate($tab_id, $table_id);
});

Route::get('_develop/edit/{table_id}/{record_id?}', function ($table_id, $record_id=0) {
    return (new \App\Http\Core\CreateModels())->showEdit($table_id, $record_id);
});

Route::post('_develop/edit/save', function () {
    return (new \App\Http\Core\CreateModels())->saveEdit();
});
