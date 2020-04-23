<?php

use Illuminate\Http\Request;

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

Route::post('register', 'PetugasController@register');
Route::post('login', 'PetugasController@login');
Route::get('/', function(){
    return Auth::user()->level;
})->middleware('jwt.verify');

#petugas
Route::put('/ubah_petugas/{id}', 'PetugasController@update')->middleware('jwt.verify');
Route::get('/tampil_petugas', 'PetugasController@tampil')->middleware('jwt.verify');
//Route::get('/index_petugas/{id}', 'PetugasController@index')->middleware('jwt.verify');
Route::delete('/hapus_petugas/{id}', 'PetugasController@destroy')->middleware('jwt.verify');

Route::get('user', 'PetugasController@getAuthenticatedUser')->middleware('jwt.verify');

#pembeli
Route::post('/simpan_pembeli', 'PembeliController@store')->middleware('jwt.verify');
Route::put('/ubah_pembeli/{id}', 'PembeliController@update')->middleware('jwt.verify');
Route::get('/tampil_pembeli', 'PembeliController@tampil')->middleware('jwt.verify');
Route::get('/index_pembeli/{id}', 'PembeliController@index')->middleware('jwt.verify');
Route::delete('/hapus_pembeli/{id}', 'PembeliController@destroy')->middleware('jwt.verify');

#jenis
Route::post('/simpan_jenis', 'JenisController@store')->middleware('jwt.verify');
Route::put('/ubah_jenis/{id}', 'JenisController@update')->middleware('jwt.verify');
Route::get('/tampil_jenis', 'JenisController@tampil')->middleware('jwt.verify');
Route::get('/index_jenis/{id}', 'JenisController@index')->middleware('jwt.verify');
Route::delete('/hapus_jenis/{id}', 'JenisController@destroy')->middleware('jwt.verify');

#mobil
Route::post('/simpan_barang', 'BarangController@store')->middleware('jwt.verify');
Route::put('/ubah_barang/{id}', 'BarangController@update')->middleware('jwt.verify');
Route::get('/tampil_barang', 'BarangController@tampil')->middleware('jwt.verify');
Route::get('/index_barang/{id}', 'BarangController@index')->middleware('jwt.verify');
Route::delete('/hapus_barang/{id}', 'BarangController@destroy')->middleware('jwt.verify');

#transaksi
Route::post('/simpan_transaksi', 'TransaksiController@store')->middleware('jwt.verify');
Route::put('/ubah_transaksi/{id}', 'TransaksiController@update')->middleware('jwt.verify');
Route::get('/tampil_transaksi', 'TransaksiController@tampil')->middleware('jwt.verify');
Route::get('/index_transaksi/{id}', 'TransaksiController@index')->middleware('jwt.verify');
Route::delete('/hapus_transaksi/{id}', 'TransaksiController@destroy')->middleware('jwt.verify');

#detail_transaksi
Route::post('/simpan_detail', 'DetailController@store')->middleware('jwt.verify');
Route::put('/ubah_detail/{id}', 'DetailController@update')->middleware('jwt.verify');
Route::get('/tampil_detail', 'DetailController@tampil')->middleware('jwt.verify');
Route::get('/index_detail/{id}', 'DetailController@index')->middleware('jwt.verify');
Route::delete('/hapus_detail/{id}', 'DetailController@destroy')->middleware('jwt.verify');
