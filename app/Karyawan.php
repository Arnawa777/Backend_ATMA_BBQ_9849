<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens; //tambahkan ini
use Carbon\Carbon; //import library time

class Karyawan extends Model
{
    use Notifiable, HasApiTokens; //edit ini

    public $timestamps = false;
    protected $table = 'karyawan';
    protected $primaryKey = 'id_karyawan';
    protected $fillable = [
        'nama_karyawan', 'role_karyawan', 'jenis_kelamin',
        'email_karyawan', 'telp_karyawan', 'password', 'status_akun', 'tanggal_bergabung',
    ];

    protected $casts = [
        'status_akun' => 'boolean',
    ];

    protected $attributes = [
        'status_akun' => true,
    ];
    protected $hidden = [
        'password', 
    ];
}
    
