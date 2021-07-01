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
Route::get('/stocks/{id}', "App\Http\Controllers\StocksController@show");

Route::get('/fibras', 'App\Http\Controllers\FibrasController@index')->name('fibras');
Route::get('/fibras/add', 'App\Http\Controllers\FibrasController@add')->name('fibras/add');
Route::get('/fibras/{id}/edit', "App\Http\Controllers\FibrasController@edit");
Route::get('/fibras/{id}/editsimple', "App\Http\Controllers\FibrasController@editsimple");
Route::post('/fibras', 'App\Http\Controllers\FibrasController@save');
Route::patch('/fibras/{id}','App\Http\Controllers\FibrasController@update');
Route::patch('/fibras/{id}','App\Http\Controllers\FibrasController@updatesimple');
Route::delete('/fibras/{id}', 'App\Http\Controllers\FibrasController@destroy');
Route::get('/fibras/{id}', "App\Http\Controllers\FibrasController@show");

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
Route::get('/snowball/{id}/edit', 'App\Http\Controllers\SnowballController@edit')->name('snowball/edit');
Route::post('/snowball', 'App\Http\Controllers\SnowballController@save');
Route::get('/snowball/{id}', "App\Http\Controllers\SnowballController@show");
Route::delete('/snowball/{id}', 'App\Http\Controllers\SnowballController@destroy');
Route::patch('/snowball/{id}','App\Http\Controllers\SnowballController@update');


Route::get('/redgirasol', 'App\Http\Controllers\RedGirasolController@index')->name('redgirasol');
Route::get('/redgirasol/add', 'App\Http\Controllers\RedGirasolController@add')->name('redgirasol/add');
Route::get('/redgirasol/{id}/edit', 'App\Http\Controllers\RedGirasolController@edit')->name('redgirasol/edit');
Route::get('/redgirasol/{id}/payment', 'App\Http\Controllers\RedGirasolController@payment')->name('redgirasol/payment');
Route::post('/redgirasol/{id}/payment', 'App\Http\Controllers\RedGirasolController@savePayment');
Route::post('/redgirasol', 'App\Http\Controllers\RedGirasolController@save');
Route::get('/redgirasol/{id}', "App\Http\Controllers\RedGirasolController@show");
Route::delete('/redgirasol/{id}', 'App\Http\Controllers\RedGirasolController@destroy');
Route::patch('/redgirasol/{id}','App\Http\Controllers\RedGirasolController@update');


Route::get('/dividends', 'App\Http\Controllers\DividendsController@index')->name('dividends');
Route::get('/dividends/add', 'App\Http\Controllers\DividendsController@add')->name('dividends/add');
Route::post('/dividends', 'App\Http\Controllers\DividendsController@save');

Route::get('/incomes', 'App\Http\Controllers\FintechController@incomes')->name('incomes');


Route::get('/rentafija', 'App\Http\Controllers\RentaFijaController@index')->name('rentafija');
Route::get('/rentafija/calendar', 'App\Http\Controllers\RentaFijaController@calendar')->name('info/calendar');
Route::get('/rentafija/{id}', "App\Http\Controllers\RentaFijaController@show");
Route::get('/rentafija/{id}/add', "App\Http\Controllers\RentaFijaController@add");
Route::post('/rentafija', 'App\Http\Controllers\RentaFijaController@save');
Route::get('/rentafija/reinvest/{id}', 'App\Http\Controllers\RentaFijaController@reinvest')->name('rentafija/reinvest');
Route::get('/rentafija/close/{id}', 'App\Http\Controllers\RentaFijaController@close')->name('rentafija/close');
Route::post('/rentafija/close', 'App\Http\Controllers\RentaFijaController@saveclose');
Route::get('/rentafija/details/{id}', "App\Http\Controllers\RentaFijaController@details");


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

Route::get('/profile', 'App\Http\Controllers\ProfileController@index')->name('profile');
Route::patch('/profile/','App\Http\Controllers\ProfileController@update');

Route::get('/infoRentaFija', 'App\Http\Controllers\InformationController@rentaFija')->name('info/rentaFija');
Route::get('/infoRentaVariable', 'App\Http\Controllers\InformationController@rentaVariable')->name('info/rentaVariable');
Route::get('/infoEfectivo', 'App\Http\Controllers\InformationController@efectivo')->name('info/Efectivo');
Route::get('/infoPortafolio', 'App\Http\Controllers\InformationController@portafolio')->name('info/portafolio');



Route::get('/realestate/{name}', 'App\Http\Controllers\RealEstateController@index')->name('realestate');
Route::get('/realestate/{name}/add', 'App\Http\Controllers\RealEstateController@add')->name('realestate/add');
Route::post('/realestate/{name}', 'App\Http\Controllers\RealEstateController@save');
Route::get('/realestate/{id}/edit', 'App\Http\Controllers\RealEstateController@edit')->name('realestate/edit');
Route::patch('/realestate/{id}','App\Http\Controllers\RealEstateController@update');
Route::get('/realestate/{name}/{id}', "App\Http\Controllers\RealEstateController@show");
Route::get('/realestate/{name}/{id}/payment', 'App\Http\Controllers\RealEstateController@payment')->name('realestate/payment');
Route::post('/realestate/{id}/payment', 'App\Http\Controllers\RealEstateController@savePayment');


Route::get('/leasing/{name}', 'App\Http\Controllers\LeasingController@index')->name('leasing');
Route::get('/leasing/{name}/add', 'App\Http\Controllers\LeasingController@add')->name('leasing/add');
Route::post('/leasing/{name}', 'App\Http\Controllers\LeasingController@save');
Route::get('/leasing/{id}/edit', 'App\Http\Controllers\LeasingController@edit')->name('leasing/edit');
Route::patch('/leasing/{id}','App\Http\Controllers\LeasingController@update');
Route::get('/leasing/{name}/{id}', "App\Http\Controllers\LeasingController@show");
Route::get('/leasing/{name}/{id}/payment', 'App\Http\Controllers\LeasingController@payment')->name('leasing/payment');
Route::post('/leasing/{name}/{id}/payment', 'App\Http\Controllers\LeasingController@savePayment');


Route::get('/expenses/categories', 'App\Http\Controllers\ExpensesController@categories')->name('expenses/categories');
Route::get('/expenses/categoriesAdd', 'App\Http\Controllers\ExpensesController@categoriesAdd')->name('expenses/categoriesAdd');
Route::post('/expenses/categoriesAdd', 'App\Http\Controllers\ExpensesController@categoriesSave');

Route::get('/expenses/index', 'App\Http\Controllers\ExpensesController@expenses')->name('expenses/index');
Route::get('/expenses/Add', 'App\Http\Controllers\ExpensesController@expensesAdd')->name('expenses/Add');
Route::post('/expenses/Add', 'App\Http\Controllers\ExpensesController@expensesSave');


Auth::routes();

Route::get('/getAllPaidsDayFixedRent', 'App\Http\Controllers\RentaFijaController@saveAllPaids');

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