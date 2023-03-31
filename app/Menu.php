<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Menu extends Model
{
    public $timestamps = false;
    protected $table = 'menu';
    protected $primaryKey = 'id_menu';
    protected $fillable = [
        'nama_menu', 'kategori_menu', 'deskripsi_menu', 'unit_menu', 'harga_menu', 'id_bahan',
    ];
    
}
