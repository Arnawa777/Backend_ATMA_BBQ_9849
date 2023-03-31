<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reservasi extends Model
{
    public $timestamps = false;
    protected $table = 'reservasi';
    protected $primaryKey = 'id_reservasi';
    protected $fillable = [
        'tanggal_reservasi', 'jam_reservasi', 'sesi', 'no_meja', 'id_customer', 'id_karyawan'
    ];

}
