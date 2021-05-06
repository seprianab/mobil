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

Route::get('/', 'AuthController@showLogin')->name('login');
Route::post('/', 'AuthController@login');

Route::middleware('auth')->group(function(){
    Route::get('/dashboard', 'DashboardController@dashboard')->name('dashboard');
    Route::get('/logout', 'AuthController@logout')->name('logout');

    Route::prefix('/car')->name('car.')->group(function(){
        Route::get('/', 'CarController@index')->name('index');
        Route::get('/create', 'CarController@create')->name('create');
        Route::post('/create', 'CarController@store');
        Route::get('/edit/{id}', 'CarController@edit')->name('edit');
        Route::put('/edit/{id}', 'CarController@update');
        Route::delete('/{id}', 'CarController@delete')->name('delete');
    });

    Route::prefix('/customer')->name('customer.')->group(function(){
        Route::get('/', 'CustomerController@index')->name('index');
        Route::get('/create', 'CustomerController@create')->name('create');
        Route::post('/create', 'CustomerController@store');
        Route::get('/edit/{id}', 'CustomerController@edit')->name('edit');
        Route::put('/edit/{id}', 'CustomerController@update');
        Route::delete('/{id}', 'CustomerController@delete')->name('delete');
    });

    Route::prefix('/sale')->name('sale.')->group(function(){
        Route::get('/', 'SaleController@index')->name('index');
        Route::get('/create', 'SaleController@create')->name('create');
        Route::post('/create', 'SaleController@store');
        Route::put('/cancel/{id}', 'SaleController@cancel')->name('cancel');
    });
});