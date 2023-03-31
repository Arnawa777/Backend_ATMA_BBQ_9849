<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('penjualan-item/{tahun}/{bulan}/{id_user}', function ($tahun, $bulan, $id_user) {
    if ($bulan != "ALL") {
        $result = DB::select("SELECT menu.kategori_menu, menu.nama_menu AS nama_menu, menu.unit_menu as unit_menu,
                COALESCE(MAX(A.jumlah_item),0) AS penjualan_harian_tertinggi,
                COALESCE(SUM(A.jumlah_item),0) AS total_penjualan
            FROM menu 
            LEFT JOIN (
                SELECT *
                FROM detail_pesanan
                WHERE MONTH(detail_pesanan.created_at) = {$bulan}
                AND YEAR(detail_pesanan.created_at) = {$tahun}
                OR jumlah_item IS NULL
            ) as A  ON A.id_menu = menu.id_menu
            GROUP BY menu.nama_menu
            ORDER BY  menu.nama_menu ASC");
        $bulan_string = [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember",
        ];
        $bulan = $bulan_string[(int)$bulan - 1];
    } else {
        $result = DB::select("SELECT menu.kategori_menu, menu.nama_menu AS nama_menu, menu.unit_menu as unit_menu,
                COALESCE(MAX(A.jumlah_item),0) AS penjualan_harian_tertinggi,
                COALESCE(SUM(A.jumlah_item),0) AS total_penjualan
            FROM menu 
            LEFT JOIN (
                SELECT *
                FROM detail_pesanan
                WHERE YEAR(detail_pesanan.created_at) = {$tahun}
                OR jumlah_item IS NULL
            ) as A  ON A.id_menu = menu.id_menu
            GROUP BY menu.nama_menu
            ORDER BY menu.nama_menu ASC");
    }

    // $user = User::find($id_user);
    return view(
        'penjualan',
        [
            "result" => $result,
            // "user" => $user,
            "tahun" => $tahun,
            "bulan" => $bulan,
            "tipe" => "TAHUNAN"
        ]
    );
});
Route::get('pendapatan-item/{tahun}/{bulan}/{id_user}', function ($tahun, $bulan, $id_user) {
    if ($bulan != "ALL") {
        $result = DB::select("SELECT menu.kategori_menu, menu.nama_menu AS nama_menu, menu.unit_menu as unit_menu,
                COALESCE(MAX(A.jumlah_item),0) AS pendapatan_harian_tertinggi,
                COALESCE(SUM(A.jumlah_item),0) AS total_pendapatan
            FROM menu 
            LEFT JOIN (
                SELECT *
                FROM detail_pesanan
                WHERE MONTH(detail_pesanan.created_at) = {$bulan}
                AND YEAR(detail_pesanan.created_at) = {$tahun}
                OR jumlah_item IS NULL
            ) as A  ON A.id_menu = menu.id_menu
            GROUP BY menu.nama_menu
            ORDER BY  menu.nama_menu ASC");
        $bulan_string = [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember",
        ];
        $bulan = $bulan_string[(int)$bulan - 1];
    } else {
        $result = DB::select("SELECT menu.kategori_menu, menu.nama_menu AS nama_menu, menu.unit_menu as unit_menu,
                COALESCE(MAX(A.jumlah_item),0) AS pendapatan_harian_tertinggi,
                COALESCE(SUM(A.jumlah_item),0) AS total_pendapatan
            FROM menu 
            LEFT JOIN (
                SELECT *
                FROM detail_pesanan
                WHERE YEAR(detail_pesanan.created_at) = {$tahun}
                OR jumlah_item IS NULL
            ) as A  ON A.id_menu = menu.id_menu
            GROUP BY menu.nama_menu
            ORDER BY menu.nama_menu ASC");
    }

    // $user = User::find($id_user);
    return view(
        'pendapatan',
        [
            "result" => $result,
            // "user" => $user,
            "tahun" => $tahun,
            "bulan" => $bulan,
            "tipe" => "TAHUNAN"
        ]
    );
});
