<?php

namespace App\Http\Controllers\API;

use App\Models\Perjalanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Hutang;
use App\Models\KirimProduk;
use App\Models\Rute;
use Stevebauman\Location\Facades\Location;

class PerjalananController extends Controller
{
    public function perjalanan(Request $request)
    {
        $clientIP = "114.5.16.107";
        $position = Location::get($clientIP);

        $perjalanan = Perjalanan::create([
            // 'km_awal'       => $position->countryName . ',' . $position->cityName . ',' . $position->latitude . ',' . $position->longitude,
            'user_sales_id' => $request->user_sales_id,
            'km_awal'       => $request->km_awal,
            'km_akhir'      => $request->km_akhir,
            'kendaraan_id'  => $request->kendaraan_id,
            'list_rute'     => json_encode($request->list_rute),
        ]);

        return response()->json([
            'success'   => true,
            'message'   => "Data Perjalanan Berhasil ditambahkan",
            'perjalanan' => $perjalanan->id
        ]);
    }
    /**
     * @OA\Post(
     * path= "/api/rencana-perjalanan",
     * operationId="Pencatatan KM Awal",
     * tags={"Pencatatan KM Awal"},
     * summary="Pencatatan KM Awal",
     * description="Pencatatan KM Awal",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"user_sales_id", "km_awal"},
     *               @OA\Property(property="user_sales_id", type="user_sales_id"),
     *               @OA\Property(property="km_awal", type="km_awal")
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=201,
     *          description="Berhasil merekam KM Awal",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Berhasil merekam KM Awal",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Terjadi kesalahan",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=500,
     *          description="Pengguna tidak ditemukan",
     *          @OA\JsonContent()
     *       ),
     * )
     */



    public function list_customer_tujuan($sales_id, $perjalanan_id)
    {
        $data_perjalanan = Perjalanan::where('user_sales_id', $sales_id)->where('id', $perjalanan_id)->first();
        $customer_tujuan = Rute::with('relasi_customer')->where('perjalanan_id', $data_perjalanan->id)->get();

        return response()->json([
            'customer_tujuan' => $customer_tujuan,
            'data_perjalanan' => $data_perjalanan
        ]);
    }

    /**
     * @OA\Get(
     *     path= "/api/list-customer-tujuan/{sales_id}/{perjalanan_id}",
     *     tags={"Customer Tujuan"},
     *     description="Menampilkan List Perjalanan Sales",
     *     operationId="SalesIDPerjalananID",
     *      @OA\Parameter(
     *          name="sales_id",
     *          description="Sales Id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="perjalanan_id",
     *          description="Perjalanan Id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */


    public function list_perjalanan_sales($sales_id)
    {
        $list_perjalanan = Perjalanan::where('user_sales_id', $sales_id)->get();

        return response()->json([
            'data' => $list_perjalanan,
        ]);
    }

    /**
     * @OA\Get(
     *     path= "/api/list-perjalanan-sales/{sales_id}",
     *     tags={"List Perjalanan"},
     *     description="Menampilkan List Perjalanan Sales",
     *     operationId="getOrderById",
     *      @OA\Parameter(
     *          name="sales_id",
     *          description="Sales Id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */


    public function kirim_produk(Request $request)
    {
        KirimProduk::create([
            'perjalanan_id' => $request->perjalanan_id,
            'customer_id'   => $request->customer_id,
            'produk_id'     => $request->produk_id,
            'kuantitas'     => $request->kuantitas,
            'total_harga'   => $request->total_harga
        ]);

        return response()->json([
            'success' => true,
            'message' => "Data Produk Berhasil ditambahkan",
        ]);
    }
    /**
     * @OA\Post(
     * path= "/api/kirim-produk/",
     * operationId="Pengiriman Produk",
     * tags={"Pengiriman Produk"},
     * summary="Pengiriman Produk",
     * description="Pengiriman Produk",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"perjalanan_id", "customer_id", "produk_id", "kuantitas", "total_harga"},
     *               @OA\Property(property="perjalanan_id", type="Integer"),
     *               @OA\Property(property="customer_id", type="Integer"),
     *               @OA\Property(property="produk_id", type="Integer"),
     *               @OA\Property(property="kuantitas", type="Integer"),
     *               @OA\Property(property="total_harga", type="String"),
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=201,
     *          description="Berhasil merekam KM Awal",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Berhasil merekam KM Awal",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Terjadi kesalahan",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=500,
     *          description="Pengguna tidak ditemukan",
     *          @OA\JsonContent()
     *       ),
     * )
     */


    public function list_rute_perjalanan()
    {
    }

    /**
     * @OA\Post(
     * path= "/api/tambah-rute-perjalanan",
     * operationId="Tambah Rute Perjalanan",
     * tags={"Tambah Rute Perjalanan"},
     * summary="Tambah Rute Perjalanan",
     * description="Proses Menambah Data Rute Perjalanan",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"perjalanan_id", "customer_id"},
     *               @OA\Property(property="perjalanan_id", type="customer_id"),
     *               @OA\Property(property="customer_id", type="customer_id")
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=201,
     *          description="Berhasil Menambahkan Rute",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Berhasil Menambahkan Rute",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Terjadi kesalahan",
     *          @OA\JsonContent()
     *       ),
     
     * )
     */

    public function detail_pesanan_barang_customer($sales_id, $perjalanan_id, $customer_id)
    {
        $data_perjalanan = Perjalanan::where('user_sales_id', $sales_id)->where('id', $perjalanan_id)->first();
        $produk_pesanan  = KirimProduk::with('relasi_produk', 'relasi_perjalanan', 'relasi_customer')
            ->where('perjalanan_id', $data_perjalanan->id)
            ->where('customer_id', $customer_id)
            ->get();

        return response()->json([
            'data' => $produk_pesanan,
        ]);
    }

    /**
     * @OA\Get(
     *     path= "/api/detail-pesanan-barang-customer/{sales_id}/{perjalanan_id}/{customer_id}",
     *     tags={"Detail Pengiriman Barang Ke Customer"},
     *     description="Detail Pengiriman Barang Ke Customer",
     *     operationId="getSalesPerjalananCustomer",
     *  @OA\Parameter(
     *          name="sales_id",
     *          description="Sales Id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *  @OA\Parameter(
     *          name="perjalanan_id",
     *          description="Perjalanan Id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *  @OA\Parameter(
     *          name="customer_id",
     *          description="Customer Id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */

    public function list_hutang_customer($customer_id)
    {
        $list_hutang = Hutang::where('customer_id', $customer_id)->get();

        return response()->json([
            'data' => $list_hutang,
        ]);
    }




    public function list_hutang_customer_detail($customer_id)
    {
        $hutang_customer = Hutang::where('customer_id', $customer_id)->get();

        return response()->json([
            'data' => $hutang_customer,
        ]);
    }
}
