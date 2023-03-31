<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public $timestamps = false;
    protected $table = 'customer';
    protected $primaryKey = 'id_customer';
    protected $fillable = [
        'nama_customer', 'telp_customer', 'email_customer',
    ];

}
