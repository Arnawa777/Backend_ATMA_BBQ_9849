<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    public $timestamps = false;
    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    protected $fillable = [
        'jumlah_item', 'total_pesanan', 'status_pesanan', 'id_reservasi',
    ];

    public function detail_pesanan()
    {
        return $this->hasMany('App\DetailPesanan', 'id_pesanan', 'id_pesanan');
    }
}
