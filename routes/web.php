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

Route::get('/', function () {
    return view('welcome');
});
Route::resource('daftarsiswa','DaftarSiswaController@baru');
Route::get('/','DaftarSiswaController@index');
Route::get('/json','DaftarSiswaController@json');

Route::post('store','DaftarSiswaController@store')->name('store');
Route::get('ajaxdata/removedata', 'DaftarSiswaController@removedata')->name('ajaxdata.removedata');
Route::get('ajaxdata/fetchdata', 'DaftarSiswaController@fetchdata')->name('ajaxdata.fetchdata');

Route::post('siswa/edit/{id}','DaftarSiswaController@update');
Route::get('siswa/getedit/{id}','DaftarSiswaController@edit');

