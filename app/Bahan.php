<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Bahan extends Model
{
    public $timestamps = false;
    protected $table = 'bahan';
    protected $primaryKey = 'id_bahan';
    protected $fillable = [
        'nama_bahan', 'ukuran_saji', 'unit_saji',
    ];
}