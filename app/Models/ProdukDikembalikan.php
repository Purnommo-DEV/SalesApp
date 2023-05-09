<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukDikembalikan extends Model
{
    use HasFactory;
    protected $table = "pengembalian_produk";
    protected $guarded = ["id"];

    public function relasi_customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function relasi_perjalanan()
    {
        return $this->belongsTo(Perjalanan::class, 'perjalanan_id', 'id');
    }

    public function relasi_sales()
    {
        return $this->belongsTo(User::class, 'sales_id', 'id');
    }
}
