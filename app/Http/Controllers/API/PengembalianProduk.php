<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProdukDikembalikan;
use App\Models\ProdukDikembalikanDetail;
use Illuminate\Http\Request;

class PengembalianProduk extends Controller
{
    public function pengembalian_produk(Request $request, $perjalanan_id, $customer_id, $sales_id)
    {
        $simpan_produk_dikembalikan = ProdukDikembalikan::create([
            'perjalanan_id' => $perjalanan_id,
            'customer_id'   => $customer_id,
            'sales_id'      => $sales_id,
            'alasan_pengembalian' => $request->alasan_pengembalian
        ]);

        ProdukDikembalikanDetail::create([
            'pengembalian_produk_id' => $simpan_produk_dikembalikan->id,
            'produk_id'              => $request->produk_id,
            'kuantitas'              => $request->kuantitas
        ]);

        return response()->json([
            'message' => "Pengembalian produk diproses",
        ]);
    }
}
