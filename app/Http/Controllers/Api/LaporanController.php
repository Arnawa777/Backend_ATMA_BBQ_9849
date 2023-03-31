<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use  Illuminate\Support\Facades\DB;
class LaporanController extends Controller
{
    public function printStok(Request $request){
        $reqData = $request->all();
        $start = $reqData['start'];
        $end = $reqData['end'];
        $dataStok = DB::select( DB::raw("
        SELECT BAHAN.NAMA_BAHAN, BAHAN.UNIT_SAJI as 'UNIT', MENU.KATEGORI_MENU,
        COALESCE(SUM(RIWAYAT_STOK.STOK_KELUAR), 0) as 'WASTE_STOK',
        COALESCE(SUM(RIWAYAT_STOK.STOK_MASUK), 0) as 'INCOMING_STOK',
        COALESCE(SUM(RIWAYAT_STOK.JUMLAH_STOK), 0) as 'REMAINING_STOK'
        FROM BAHAN
        LEFT JOIN RIWAYAT_STOK ON RIWAYAT_STOK.ID_BAHAN=BAHAN.ID_BAHAN AND TANGGAL BETWEEN '$start' AND '$end'
        JOIN MENU ON BAHAN.ID_BAHAN= MENU.ID_BAHAN 
        GROUP BY BAHAN.ID_BAHAN, BAHAN.NAMA_BAHAN, BAHAN.UNIT_SAJI, MENU.KATEGORI_MENU
        "));

        // return response(['data'=>$dataStok]);
        // return view('laporanStok',compact('dataStok','start','end'));
        $pdf = PDF::loadview('laporanStok',compact('dataStok','start','end'))->setPaper('A4','potrait');
        return $pdf->download();
    }

    public function printPendapatanBulanan(Request $request){
        $data = $request->all();
        $tahun = $data['tahun'];
        
        $dataPendapatan = DB::select( DB::raw("
        SELECT MONTH(RESERVASI.TANGGAL_RESERVASI) AS bulan,
        SUM(CASE WHEN MENU.KATEGORI_MENU = 'Utama' then PESANAN.TOTAL_PESANAN ELSE 0 END) AS makanan,
        SUM(CASE WHEN MENU.KATEGORI_MENU = 'Side Dish' then PESANAN.TOTAL_PESANAN ELSE 0 END) AS side_dish,
        SUM(CASE WHEN MENU.KATEGORI_MENU = 'Minuman' then PESANAN.TOTAL_PESANAN ELSE 0 END) AS minuman,
        SUM(PESANAN.TOTAL_PESANAN) AS total_pendapatan
        FROM PESANAN 
        LEFT JOIN RESERVASI ON RESERVASI.ID_RESERVASI = PESANAN.ID_RESERVASI
        JOIN detail_pesanan ON detail_pesanan.id_pesanan = PESANAN.id_pesanan
        JOIN MENU ON MENU.ID_MENU = detail_pesanan.ID_MENU
        WHERE YEAR (TANGGAL_RESERVASI)= '$tahun'
        GROUP BY RESERVASI.TANGGAL_RESERVASI
        "));

        if(count($dataPendapatan) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $dataPendapatan
            ],200);
        } //return data semua karyawan dalam bentuk json

        return response([
            'message' => 'Empty',
            'data' => null
        ],404); //return message data karyawan kosong
    }

    public function printPendapatanTahunan(Request $request){
        $data = $request->all();
        $start_year = $data['start_year'];
        $end_year = $data['end_year'];
        
        $dataPendapatan = DB::select( DB::raw("
        SELECT YEAR(RESERVASI.TANGGAL_RESERVASI) AS tahun,
        SUM(CASE WHEN MENU.KATEGORI_MENU = 'Utama' then PESANAN.TOTAL_PESANAN ELSE 0 END) AS makanan,
        SUM(CASE WHEN MENU.KATEGORI_MENU = 'Side Dish' then PESANAN.TOTAL_PESANAN ELSE 0 END) AS side_dish,
        SUM(CASE WHEN MENU.KATEGORI_MENU = 'Minuman' then PESANAN.TOTAL_PESANAN ELSE 0 END) AS minuman,
        SUM(PESANAN.TOTAL_PESANAN) AS total_pendapatan
        FROM PESANAN 
        LEFT JOIN RESERVASI ON RESERVASI.ID_RESERVASI = PESANAN.ID_RESERVASI
        JOIN detail_pesanan ON detail_pesanan.id_pesanan = PESANAN.id_pesanan
        JOIN MENU ON MENU.ID_MENU = detail_pesanan.ID_MENU
        WHERE YEAR (TANGGAL_RESERVASI) BETWEEN '$start_year' AND '$end_year'
        GROUP BY RESERVASI.TANGGAL_RESERVASI
        "));

        if(count($dataPendapatan) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $dataPendapatan
            ],200);
        } //return data semua karyawan dalam bentuk json

        return response([
            'message' => 'Empty',
            'data' => null
        ],404); //return message data karyawan kosong
    }
}
