<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\LokasiController;
use App\Http\Controllers\API\PengembalianProduk;
use App\Http\Controllers\API\PerjalananController;
use App\Http\Controllers\API\RuteController;
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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::post('lokasi-awal', [LokasiController::class, 'cek_lokasi']);

Route::controller(PerjalananController::class)->group(function () {

    Route::post('rencana-perjalanan', 'perjalanan');

    Route::get('list-perjalanan-sales/{sales_id}', 'list_perjalanan_sales');

    Route::get('list-customer-tujuan/{sales_id}/{perjalanan_id}', 'list_customer_tujuan');

    Route::get('detail-pesanan-barang-customer/{sales_id}/{perjalanan_id}/{customer_id}', 'detail_pesanan_barang_customer');

    Route::post('kirim-produk', 'kirim_produk');

    Route::get('hutang-customer/{customer_id}', 'list_hutang_customer');

    Route::get('hutang-customer-detail/{customer_id}', 'list_hutang_customer_detail');
});

Route::controller(RuteController::class)->group(function () {

    Route::post('tambah-rute-perjalanan', 'tambah_rute');
});

Route::controller(PengembalianProduk::class)->group(function () {
    Route::post('pengembalian-produk/{perjalanan_id}/{customer_id}/{sales_id}', 'pengembalian_produk');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
