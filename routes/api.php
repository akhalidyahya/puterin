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


//user
Route::post('user/register','UserController@register');
Route::post('user/login', 'UserController@login')->name('login');

Route::group(['middleware'=>'auth:api'],function(){

    //user
    Route::get('user/details', 'UserController@details');
    Route::get('user/logout', 'UserController@logout');
    Route::post('user/update', 'UserController@update');

    //transaksi
    Route::get('transaksi/all','TransaksiController@getAll'); //semua transaksi
    Route::get('transaksi/user','TransaksiController@getByUser'); //semua transaksi per user
    Route::get('transaksi/{id}','TransaksiController@getById'); //transaksi tertentu
    Route::post('transaksi/store','TransaksiController@store')->name('transaksi.store'); //membuat transaksi
    Route::post('transaksi/{id}/bukti','TransaksiController@updateBukti'); //upload bukti
    Route::post('transaksi/{id}/status','TransaksiController@updateStatus'); //update status transaksi
});
