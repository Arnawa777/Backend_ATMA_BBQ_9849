<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    public $timestamps = false;
    protected $table = 'detail_pesanan';
    protected $primaryKey = 'id_detail_pesanan';
    protected $fillable = [
        'kuantitas', 'harga', 'subtotal', 'status_detail_pesanan', 'id_menu', 'id_pesanan',
    ];

}
