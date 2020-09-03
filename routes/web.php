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

Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');
Route::get('/transaksi', 'TransaksiController@index')->name('transaksi.index');
Route::get('/transaksi/uploaded-bukti', 'TransaksiController@indexUploadedBukti')->name('transaksi.uploaded.bukti.index');
Route::get('/transaksi/ready', 'TransaksiController@indexReady')->name('transaksi.ready.index');
Route::get('/transaksi/done', 'TransaksiController@indexDone')->name('transaksi.done.index');
Route::get('/transaksi/data/{keyword}', 'TransaksiController@dataTransaksi')->name('transaksi.data');
Route::post('/transaksi/{id}/status/{status}', 'TransaksiController@updateStatusTransaksi')->name('transaksi.setStatus');
Route::get('/logout', 'AdminController@logout');
Route::get('/login','AdminController@login')->name('login-page');
Route::post('/loginPost', 'AdminController@loginPost')->name('login-post');
Route::get('/tes','AdminController@tes');
Route::post('/tespost','AdminController@tespost')->name('tespost');
