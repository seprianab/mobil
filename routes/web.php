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
});