<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KirimProduk extends Model
{
    use HasFactory;
    protected $table = "kirim_produk";
    protected $guarded = ["id"];

    public function relasi_customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function relasi_perjalanan()
    {
        return $this->belongsTo(Perjalanan::class, 'perjalanan_id', 'id');
    }

    public function relasi_produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }
}
