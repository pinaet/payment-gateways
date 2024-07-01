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
    return view('gate-index');
});

Route::get('/endpoint', 'OrdersController@endpoint');

Route::post('/order',             'OrdersController@genOrder');
Route::post('/order/source-type', 'OrdersController@updateSourceType');
Route::post('/order/notify'     , 'OrdersController@notify');
Route::post('/order/callback'   , 'OrdersController@callback');
Route::post('/order/t-callback' , 'OrdersController@t_callback');

Route::get( '/test/callback'    , 'OrdersController@testCallback');
