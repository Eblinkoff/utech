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

Route::get('/', 'FieldController@index');


Route::post('/fields', 'FieldController@store')->name('fields');// получение подвьюхи со списком полей

Route::get('/fields/{id}', 'FieldController@show')->name('fields');// получение карточки поля

Route::get('/fields/{id}/edit', 'FieldController@edit')->name('fields');// получение формы редактирования поля

Route::post('/fields/{id}/update', 'FieldController@update')->name('fields');// редактирование поля

Route::get('/fields/{id}/delete', 'FieldController@destroy')->name('fields');// удаление поля

Route::get('/fields/{id}/new', 'FieldController@new')->name('fields');// отдаёт форму создания нового поля
