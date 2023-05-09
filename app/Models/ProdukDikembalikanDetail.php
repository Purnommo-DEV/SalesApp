<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukDikembalikanDetail extends Model
{
    use HasFactory;
    protected $table = "pengembalian_produk_detail";
    protected $guarded = ["id"];

    public function relasi_produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }
}
