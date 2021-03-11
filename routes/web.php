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
Route::get('/stocks/add', 'App\Http\Controllers\StocksController@add')->name('stocks/add');
Route::get('/stocks/{id}/edit', "App\Http\Controllers\StocksController@edit");
Route::post('/stocks', 'App\Http\Controllers\StocksController@save');
Route::patch('/stocks/{id}','App\Http\Controllers\StocksController@update');
Route::get('/fibras', 'App\Http\Controllers\FibrasController@index')->name('fibras');
Route::get('/fibras/add', 'App\Http\Controllers\FibrasController@add')->name('fibras/add');
Route::get('/fibras/{id}/edit', "App\Http\Controllers\FibrasController@edit");
Route::post('/fibras', 'App\Http\Controllers\FibrasController@save');
Route::patch('/fibras/{id}','App\Http\Controllers\FibrasController@update');


Route::get('/cryptos', 'App\Http\Controllers\CryptosController@index')->name('cryptos');
Auth::routes();


/*
// Categories
Route::get('/categories', 'CategoryController@index');
Route::get('/categories/create',"CategoryController@create");
Route::get('/categories/{id}/edit', "CategoryController@edit");
Route::get('/categories/{id}/details', "CategoryController@details");
Route::post('/categories', 'CategoryController@store');
Route::patch('/categories/{id}','CategoryController@update');
Route::delete('/categories/{id}', 'CategoryController@destroy');

*/