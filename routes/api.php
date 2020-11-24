<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// /transaksi
Route::get('transaksi','Api\TransaksiController@index');
Route::get('transaksi/{id}','Api\TransaksiController@show');
Route::post('transaksi','Api\TransaksiController@store');
Route::put('transaksi/{id}','Api\TransaksiController@update');
Route::delete('transaksi/{id}','Api\TransaksiController@destroy');

// Pesan
Route::get('pesan','Api\PesanController@index');
Route::get('pesan/{id}','Api\PesanController@show');
Route::post('pesan','Api\PesanController@store');
Route::put('pesan/{id}','Api\PesanController@update');
Route::delete('pesan/{id}','Api\PesanController@destroy');
