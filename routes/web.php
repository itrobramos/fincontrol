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
Route::post('/stocks', 'App\Http\Controllers\StocksController@save');

Route::get('/fibras', 'App\Http\Controllers\FibrasController@index')->name('fibras');

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