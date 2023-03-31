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
Route::post('create', 'Api\KaryawanController@create');
Route::post('login', 'Api\KaryawanController@login');

Route::middleware('auth:api')->post('/logout', function (Request $request) {
    $request->user()->token()->delete();
    return response([
        'message' => 'Logged Out Successfully'
    ]);
});

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('karyawan', 'Api\KaryawanController@index');
    Route::get('karyawan/{id}', 'Api\KaryawanController@show');
    Route::post('karyawan', 'Api\KaryawanController@create');
    Route::put('karyawan/{id}', 'Api\KaryawanController@update');
    Route::delete('karyawan/{id}', 'Api\KaryawanController@destroy');

    Route::get('meja', 'Api\MejaController@index');
    Route::get('meja/{id}', 'Api\MejaController@show');
    Route::post('meja', 'Api\MejaController@store');
    Route::put('meja/{id}', 'Api\MejaController@update');
    Route::delete('meja/{id}', 'Api\MejaController@destroy');

    Route::get('customer', 'Api\CustomerController@index');
    Route::get('customer/{id}', 'Api\CustomerController@show');
    Route::post('customer', 'Api\CustomerController@store');
    Route::put('customer/{id}', 'Api\CustomerController@update');
    Route::delete('customer/{id}', 'Api\CustomerController@destroy');

    Route::get('bahan', 'Api\BahanController@index');
    Route::get('bahan/{id}', 'Api\BahanController@show');
    Route::post('bahan', 'Api\BahanController@store');
    Route::put('bahan/{id}', 'Api\BahanController@update');
    Route::delete('bahan/{id}', 'Api\BahanController@destroy');

    Route::get('menu', 'Api\MenuController@index');
    Route::get('menu/{id}', 'Api\MenuController@show');
    Route::post('menu', 'Api\MenuController@store');
    Route::put('menu/{id}', 'Api\MenuController@update');
    Route::delete('menu/{id}', 'Api\MenuController@destroy');

    Route::get('reservasi', 'Api\ReservasiController@index');
    Route::get('reservasi/{id}', 'Api\ReservasiController@show');
    Route::post('reservasi', 'Api\ReservasiController@store');
    Route::put('reservasi/{id}', 'Api\ReservasiController@update');
    Route::delete('reservasi/{id}', 'Api\ReservasiController@destroy');

    Route::get('pesanan', 'Api\PesananController@index');
    Route::get('pesanan/{id}', 'Api\PesananController@show');
    Route::post('pesanan', 'Api\PesananController@store');
    Route::put('pesanan/{id}', 'Api\PesananController@update');
    Route::delete('pesanan/{id}', 'Api\PesananController@destroy');
    Route::put('pesanan_lunas/{id}', 'Api\PesananController@updateLunas');
    Route::get('pesananBelumBayar', 'Api\PesananController@pesananBelumBayar');
    

    Route::get('detail_pesanan', 'Api\DetailPesananController@index');
    Route::get('detail_pesanan/{id}', 'Api\DetailPesananController@show');
    Route::put('detail_pesanan/{id}', 'Api\DetailPesananController@update');

    Route::get('pembayaran', 'Api\PembayaranController@index');
    Route::get('pembayaran/{id}', 'Api\PembayaranController@show');
    Route::post('pembayaran', 'Api\PembayaranController@store');
    Route::put('pembayaran/{id}', 'Api\PembayaranController@update');
    Route::delete('pembayaran/{id}', 'Api\PembayaranController@destroy');


    Route::get('info_pembayaran', 'Api\InfoPembayaranController@index');
    Route::get('info_pembayaran/{id}', 'Api\InfoPembayaranController@show');
    Route::post('info_pembayaran', 'Api\InfoPembayaranController@store');
    Route::put('info_pembayaran/{id}', 'Api\InfoPembayaranController@update');
    Route::delete('info_pembayaran/{id}', 'Api\InfoPembayaranController@destroy');

    Route::get('riwayat_stok', 'Api\RiwayatStokController@index');
    Route::get('riwayat_stok/{id}', 'Api\RiwayatStokController@show');
    Route::post('riwayat_stok', 'Api\RiwayatStokController@store');
    Route::put('riwayat_stok/{id}', 'Api\RiwayatStokController@update');
    Route::delete('riwayat_stok/{id}', 'Api\RiwayatStokController@destroy');

    Route::post('printStok', 'Api\LaporanController@printStok');
    Route::post('printPendapatanBulanan', 'Api\LaporanController@printPendapatanBulanan');
    Route::post('printPendapatanTahunan', 'Api\LaporanController@printPendapatanTahunan');

    

});


