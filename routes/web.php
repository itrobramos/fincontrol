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
Route::get('/stocks/{id}/editsimple', "App\Http\Controllers\StocksController@editsimple");
Route::post('/stocks', 'App\Http\Controllers\StocksController@save');
Route::patch('/stocks/{id}','App\Http\Controllers\StocksController@update');
Route::patch('/stockssimple/{id}','App\Http\Controllers\StocksController@updatesimple');
Route::delete('/stocks/{id}', 'App\Http\Controllers\StocksController@destroy');

Route::get('/fibras', 'App\Http\Controllers\FibrasController@index')->name('fibras');
Route::get('/fibras/add', 'App\Http\Controllers\FibrasController@add')->name('fibras/add');
Route::get('/fibras/{id}/edit', "App\Http\Controllers\FibrasController@edit");
Route::get('/fibras/{id}/editsimple', "App\Http\Controllers\FibrasController@editsimple");
Route::post('/fibras', 'App\Http\Controllers\FibrasController@save');
Route::patch('/fibras/{id}','App\Http\Controllers\FibrasController@update');
Route::patch('/fibras/{id}','App\Http\Controllers\FibrasController@updatesimple');
Route::delete('/fibras/{id}', 'App\Http\Controllers\FibrasController@destroy');

Route::get('/criptos', 'App\Http\Controllers\CriptosController@index')->name('criptos');
Route::get('/criptos/add', 'App\Http\Controllers\CriptosController@add')->name('criptos/add');
Route::get('/criptos/{id}/edit', "App\Http\Controllers\CriptosController@edit");
Route::get('/criptos/{id}/editsimple', "App\Http\Controllers\CriptosController@editsimple");
Route::post('/criptos', 'App\Http\Controllers\CriptosController@save');
Route::patch('/criptos/{id}','App\Http\Controllers\CriptosController@update');
Route::patch('/criptossimple/{id}','App\Http\Controllers\CriptosController@updatesimple');
Route::delete('/criptos/{id}', 'App\Http\Controllers\CriptosController@destroy');

Route::get('/fintech', 'App\Http\Controllers\FintechController@index')->name('fintech');

Route::get('/snowballprojects', 'App\Http\Controllers\SnowballProjectController@index')->name('snowballprojects');
Route::get('/snowballprojects/add', 'App\Http\Controllers\SnowballProjectController@add')->name('snowballprojects/add');
Route::get('/snowballprojects/{id}/edit', "App\Http\Controllers\SnowballProjectController@edit");
Route::post('/snowballprojects', 'App\Http\Controllers\SnowballProjectController@save');
Route::patch('/snowballprojects/{id}','App\Http\Controllers\SnowballProjectController@update');

Route::get('/snowball', 'App\Http\Controllers\SnowballController@index')->name('snowball');
Route::get('/snowball/add', 'App\Http\Controllers\SnowballController@add')->name('snowball/add');
Route::post('/snowball', 'App\Http\Controllers\SnowballController@save');
Route::get('/snowball/{id}', "App\Http\Controllers\SnowballController@show");

Route::get('/dividends', 'App\Http\Controllers\DividendsController@index')->name('dividends');
Route::get('/dividends/add', 'App\Http\Controllers\DividendsController@add')->name('dividends/add');
Route::post('/dividends', 'App\Http\Controllers\DividendsController@save');

Route::get('/rentafija', 'App\Http\Controllers\RentaFijaController@index')->name('rentafija');
Route::get('/rentafija/{id}', "App\Http\Controllers\RentaFijaController@show");
Route::get('/rentafija/{id}/add', "App\Http\Controllers\RentaFijaController@add");
Route::post('/rentafija', 'App\Http\Controllers\RentaFijaController@save');

Route::get('/cryptos', 'App\Http\Controllers\CryptosController@index')->name('cryptos');

Route::get('/accounts', 'App\Http\Controllers\AccountsController@index')->name('accounts');
Route::get('/accounts/configure', 'App\Http\Controllers\AccountsController@configure')->name('accounts/configure');
Route::post('/accounts/configure', 'App\Http\Controllers\AccountsController@saveconfiguration');

Route::get('/accounts/add', 'App\Http\Controllers\AccountsController@add')->name('accounts/add');
Route::get('/accounts/{id}/edit', "App\Http\Controllers\AccountsController@edit");
Route::post('/accounts', 'App\Http\Controllers\AccountsController@save');
Route::patch('/accounts/{id}','App\Http\Controllers\AccountsController@update');
Route::get('/accounts/{id}', "App\Http\Controllers\AccountsController@show");

Route::get('/accounts/{id}/register', "App\Http\Controllers\AccountsController@register");
Route::post('/accounts/register', 'App\Http\Controllers\AccountsController@savemovement');

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