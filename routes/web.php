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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('users', 'UserController@users')->name('users');
Route::get('export-csv', 'UserController@exportCSV')->name('export-csv');
Route::get('export-pdf', 'UserController@exportPDF')->name('export-pdf');
Route::get('importExportView', 'UserController@importExportView')->name('importExportView');
Route::post('import', 'UserController@import')->name('import');