<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class InfoPembayaran extends Model
{
    public $timestamps = false;
    protected $table = 'info_pembayaran';
    protected $primaryKey = 'id_info_pembayaran';
    protected $fillable = [
        'nama_pemilik_kartu', 'nomor_kartu', 'expired_kartu',
    ];

}
