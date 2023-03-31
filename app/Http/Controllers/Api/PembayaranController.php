<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Pembayaran;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayaran = Pembayaran::all();

        if (count($pembayaran) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $pembayaran
            ], 200);
        } //return data semua pembayaran dalam bentuk json

        return response([
            'message' => 'Pembayaran Tidak ditemukan',
        ], 404); //return message data kosong
    }

    public function show($id)
    {
        $pembayaran = Pembayaran::find($id); //mencari data pembayaran berdasarkan id

        if (!is_null($pembayaran)) {
            $pembayaran = Pembayaran::where('no_pembayaran', $id)->get();
            return response([
                'message' => 'Retrieve Pembayaran Success',
                'data' => $pembayaran,
            ], 200);
        } //return data pembayaran yang ditemukan dalam bentuk json

        return response([
            'message' => 'Pembayaran Not Found',
        ], 404); //return message saat data pembayaran tidak ditemukan
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'tipe_pembayaran' => 'required',
            // 'tanggal_pembayaran' => 'required',
            'layanan' => 'required',
            'pajak' => 'required',
            'total_pembayaran' => 'required',
            'kode_verifikasi_edc' => 'nullable',
            'id_karyawan' => 'required',
            'id_info_pembayaran' => 'nullable',
            // 'id_pesanan' => 'required',
        ]);
        if ($validate->fails())
            return response(['message' => $validate->errors()], 460); //return error invalid input

        $pembayaran = Pembayaran::create($storeData); //menambah data pembayaran baru

        return response([
            'message' => 'Add pembayaran Success',
            'data' => $pembayaran,
        ], 200); //return data pembayaran baru dalam bentuk json
    }

    public function destroy($id)
    {
        $pembayaran = Pembayaran::find($id); //mencari data pembayaran berdasarkan id

        if (is_null($pembayaran)) {
            return response([
                'message' => 'pembayaran Not Found',
            ], 404);
        } //return message saat data pembayaran tidak ditemukan

        if ($pembayaran->delete()) {
            return response([
                'message' => 'Delete pembayaran Success',
                'data' => $pembayaran,
            ], 200);
        } //return message saat berhasil menghapus data pembayaran

        return response([
            'message' => 'Delete pembayaran Failed',
        ], 400); //return message saat gagal menghapus data pembayaran
    }

    public function update(Request $request, $id)
    {
        $pembayaran = Pembayaran::find($id); //mencari data pembayaran berdasarkan id

        if (is_null($pembayaran)) {
            return response([
                'message' => 'pembayaran Not Found',
            ], 404);
        } //return message saat data pembayaran tidak ditemukan

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'tipe_pembayaran' => 'required',
            // 'tanggal_pembayaran' => 'required',
            'layanan' => 'required',
            'pajak' => 'required',
            'total_pembayaran' => 'required',
            'kode_verifikasi_edc' => 'nullable',
            'id_karyawan' => 'required',
            'id_info_pembayaran' => 'nullable',
            // 'id_pesanan' => 'required',
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400); // return error invalid input
            $pembayaran->tipe_pembayaran = $updateData['tipe_pembayaran']; 
            // $pembayaran->tanggal_pembayaran = $updateData['tanggal_pembayaran'];
            $pembayaran->layanan = $updateData['layanan']; 
            $pembayaran->pajak = $updateData['pajak'];
            $pembayaran->total_pembayaran = $updateData['total_pembayaran'];
            $pembayaran->kode_verifikasi_edc = $updateData['kode_verifikasi_edc'];
            $pembayaran->id_pembayaran = $updateData['id_pembayaran'];
            $pembayaran->id_info_pembayaran = $updateData['id_info_pembayaran'];
            // $pembayaran->id_pesanan = $updateData['id_pesanan'];


        if ($pembayaran->save()) {
            return response([
                'message' => 'Update Pembayaran Success',
                'data' => $pembayaran,
            ], 200);
        } // return data pembayaran yang telah di edit dalam bentuk json

        return response([
            'message' => 'Update Pembayaran Failed',
        ], 400); // return message saat pembayaran gagal di edit
    }
}
