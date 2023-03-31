<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\RiwayatStok;

class RiwayatStokController extends Controller
{
    public function index()
    {
        $riwayat_stok = RiwayatStok::all();
        // $riwayat_stok['jumlah_stok'] = ($request->jumlah_stok + $request->stok_masuk ) - $request->stok_keluar; 
        
        if (count($riwayat_stok) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $riwayat_stok
            ], 200);
        } //return data semua riwayat_stok dalam bentuk json

        return response([
            'message' => 'Riwayat Stok Tidak ditemukan',
        ], 404); //return message data kosong
    }

    public function show($id)
    {
        $riwayat_stok = RiwayatStok::find($id); //mencari data riwayat_stok berdasarkan id

        if (!is_null($riwayat_stok)) {
            $riwayat_stok = RiwayatStok::find($id);
            return response([
                'message' => 'Retrieve Riwayat Stok Success',
                'data' => $riwayat_stok,
            ], 200);
        } //return data riwayat_stok yang ditemukan dalam bentuk json

        return response([
            'message' => 'RiwayatStok Not Found',
        ], 404); //return message saat data riwayat_stok tidak ditemukan
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'keterangan' => 'required',
            // 'tanggal_pembayaran' => 'required',
            'stok_masuk' => 'required',
            'stok_keluar' => 'nullable',
            'total_pembayaran' => 'nullable',
            'jumlah_stok' => 'nullable',
            'harga_stok_bahan' => 'required',
            'tanggal' => 'required',
            'id_bahan' => 'required',
        ]);
        if ($validate->fails())
            return response(['message' => $validate->errors()], 460); //return error invalid input

        $riwayat_stok = RiwayatStok::create($storeData); //menambah data riwayat_stok baru

        return response([
            'message' => 'Add riwayat_stok Success',
            'data' => $riwayat_stok,
        ], 200); //return data riwayat_stok baru dalam bentuk json
    }

    public function destroy($id)
    {
        $riwayat_stok = RiwayatStok::find($id); //mencari data riwayat_stok berdasarkan id

        if (is_null($riwayat_stok)) {
            return response([
                'message' => 'riwayat_stok Not Found',
            ], 404);
        } //return message saat data riwayat_stok tidak ditemukan

        if ($riwayat_stok->delete()) {
            return response([
                'message' => 'Delete riwayat_stok Success',
                'data' => $riwayat_stok,
            ], 200);
        } //return message saat berhasil menghapus data riwayat_stok

        return response([
            'message' => 'Delete riwayat_stok Failed',
        ], 400); //return message saat gagal menghapus data riwayat_stok
    }

    public function update(Request $request, $id)
    {
        $riwayat_stok = RiwayatStok::find($id); //mencari data riwayat_stok berdasarkan id

        if (is_null($riwayat_stok)) {
            return response([
                'message' => 'riwayat_stok Not Found',
            ], 404);
        } //return message saat data riwayat_stok tidak ditemukan

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'keterangan' => 'required',
            // 'tanggal_pembayaran' => 'required',
            'stok_masuk' => 'required',
            'stok_keluar' => 'required',
            'total_pembayaran' => 'required',
            'jumlah_stok' => 'nullable',
            'harga_stok_bahan' => 'required',
            'tanggal' => 'nullable',
             'id_bahan' => 'required',
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400); // return error invalid input
            $riwayat_stok->keterangan = $updateData['keterangan']; 
            // $riwayat_stok->tanggal_pembayaran = $updateData['tanggal_pembayaran'];
            $riwayat_stok->stok_masuk = $updateData['stok_masuk']; 
            $riwayat_stok->stok_keluar = $updateData['stok_keluar'];
            $riwayat_stok->total_pembayaran = $updateData['total_pembayaran'];
            $riwayat_stok->jumlah_stok = $updateData['jumlah_stok'];
            $riwayat_stok->id_pembayaran = $updateData['id_pembayaran'];
            $riwayat_stok->tanggal = $updateData['tanggal'];
            $riwayat_stok->id_bahan = $updateData['id_bahan'];


        if ($riwayat_stok->save()) {
            return response([
                'message' => 'Update RiwayatStok Success',
                'data' => $riwayat_stok,
            ], 200);
        } // return data riwayat_stok yang telah di edit dalam bentuk json

        return response([
            'message' => 'Update RiwayatStok Failed',
        ], 400); // return message saat riwayat_stok gagal di edit
    }
}
