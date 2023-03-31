<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Meja extends Model
{
    public $timestamps = false;
    protected $table = 'meja';
    protected $primaryKey = 'no_meja';
    protected $fillable = [
        'no_meja', 'kapasitas_meja', 'status_meja',
    ];

    protected $casts = [
        'status_meja' => 'boolean',
    ];

    protected $attributes = [
        'status_meja' => true,
    ];

}
