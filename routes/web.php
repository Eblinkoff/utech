<?php

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

// Route::get('/', function () {
    // return view('welcome');
// });
Route::get('/', 'FieldController@index');


Route::post('/fields', 'FieldController@store');// получение подвьюхи со списком полей

Route::get('/fields/{id}', 'FieldController@show');// получение карточки поля

Route::get('/fields/{id}/edit', 'FieldController@edit');// получение формы редактирования поля

Route::post('/fields/{id}/update', 'FieldController@update');// редактирование поля

Route::get('/fields/{id}/delete', 'FieldController@destroy');// удаление поля
