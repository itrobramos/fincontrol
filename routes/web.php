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


Route::get('/', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::get('/stocks', 'App\Http\Controllers\StocksController@index')->name('stocks');

Route::get('/fibras', 'App\Http\Controllers\FibrasController@index')->name('fibras');

Route::get('/cryptos', 'App\Http\Controllers\CryptosController@index')->name('cryptos');
Auth::routes();


