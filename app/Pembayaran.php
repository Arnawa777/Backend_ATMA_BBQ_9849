<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Pembayaran extends Model
{
    public $timestamps = false;
    protected $table = 'pembayaran';
    protected $primaryKey = 'no_pembayaran';
    protected $fillable = [
        'tipe_pembayaran', 'tanggal_pembayaran', 'layanan','pajak', 'total_pembayaran', 
        'kode_verifikasi_edc', 'id_karyawan', 'id_info_pembayaran', 'id_pesanan',
    ];

    protected $keyType = 'string';

    public function detail_pesanan()
    {
        return $this->hasMany('App\DetailPesanan', 'id_pesanan', 'id_pesanan');
    }

    public function getCreatedAtAttribute(){
        if(!is_null($this->attributes['created_at'])) {
            return Carbon::parse($this->attributes['created_at'])->format('Y-m-d H:i:s');
        }
    } //convert attribute created_at ke format Y-m-d H:i:s

    public function getUpdatedAtAttribute(){
        if(!is_null($this->attributes['updated_at'])) {
            return Carbon::parse($this->attributes['updated_at'])->format('Y-m-d H:i:s');
        }
    } //convert attribute updated_at ke format Y-m-d H:i:s
}
