<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens; //edit ini

    protected $table = 'karyawan';
    protected $primaryKey = 'id_karyawan';
    protected $fillable = [
        'nama_karyawan', 'role_karyawan', 'jenis_kelamin',
        'email_karyawan', 'telp_karyawan', 'password', 'tanggal_bergabung',
    ];

    protected $attribute = [
        'status_akun' => true,
    ];
    protected $hidden = [
        'password', 
    ];
}
