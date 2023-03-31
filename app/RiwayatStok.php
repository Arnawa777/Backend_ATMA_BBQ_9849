<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class RiwayatStok extends Model
{
    public $timestamps = false;
    protected $table = 'riwayat_stok';
    protected $primaryKey = 'id_riwayat_stok';
    protected $fillable = [
        'keterangan', 'stok_masuk', 'stok_keluar', 'jumlah_stok', 'harga_stok_bahan', 'tanggal', 'id_bahan'
    ];

    public function setTotalAttribute()
    {
    $this->attributes['jumlah_stok'] = ($this->attributes['jumlah_stok'] + $this->attributes['stok_masuk']) - $this->attributes['stok_keluar'];
}

}
