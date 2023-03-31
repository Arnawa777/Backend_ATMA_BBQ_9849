<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\InfoPembayaran;

class InfoPembayaranController extends Controller
{
     //method untuk menampilkan semua data info_pembayaran (read)
     public function index(){
        $info_pembayaran = InfoPembayaran::all(); //mengambil semua data info_pembayaran

        if(count($info_pembayaran) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $info_pembayaran
            ],200);
        } //return data semua info_pembayaran dalam bentuk json

        return response([
            'message' => 'Empty',
            'data' => null
        ],404); //return message data info_pembayaran kosong
    }

    //method untuk menampilkan 1 data info_pembayaran (search)
    public function show($id){
        $info_pembayaran = InfoPembayaran::find($id); //mencari data info_pembayaran berdasarkan id

        if(!is_null($info_pembayaran)){
            return response([
                'message' => 'Retrieve InfoPembayaran Success',
                'data' => $info_pembayaran
            ],200);
        } //return data info_pembayaran yang ditemukan dalam bentuk json

        return response([
            'message' => 'InfoPembayaran Not Found',
            'data' => null
        ],404); //return message saat data info_pembayaran tidak ditemukan
    }

    //method untuk menambah 1 data info_pembayaran baru (create)
    public function store(Request $request){
        $storeData = $request->all(); //mengambil semua input dari api client
        $validate = Validator::make($storeData, [
            'nama_pemilik_kartu' => 'required',
            'nomor_kartu' => 'required',
            'expired_kartu' => 'required',
        ]); //membuat rule validasi input

        if($validate->fails())
            return response(['message' => $validate->errors()],460); //return error invalid input

        $info_pembayaran = InfoPembayaran::create($storeData); //menambah data info_pembayaran baru
        return response([
            'message' => 'Add InfoPembayaran Success',
            'data' => $info_pembayaran,
        ],200); //return data info_pembayaran baru dalam bentuk json
    }

    //method untuk menghapus 1 data info_pembayaran (delete)
    public function destroy($id){
        $info_pembayaran = InfoPembayaran::find($id); //mencari data info_pembayaran berdasarkan id

        if(is_null($info_pembayaran)){
        return response([
            'message' => 'InfoPembayaran Not Found',
            'data' => null
        ],404);
        } //return message saat data info_pembayaran tidak ditemukan

        if($info_pembayaran->delete()){
            return response([
                'message' => 'Delete InfoPembayaran Success',
                'data' => $info_pembayaran,
            ],200);
        } //return message saat berhasil menghapus data info_pembayaran
        return response([
            'message' => 'Delete InfoPembayaran Failed',
            'data' => null,
        ],400); //return message saat gagal menghapus data info_pembayaran
    }

    //method untuk mengubah 1 data info_pembayaran (update)
    public function update(Request $request, $id){
        $info_pembayaran = InfoPembayaran::find($id); //mencari data info_pembayaran berdasarkan id
        if(is_null($info_pembayaran)){
            return response([
                'message' => 'InfoPembayaran Not Found',
                'data' => null
            ],404);
        } //return message saat data info_pembayaran tidak ditemukan

        $updateData = $request->all(); //mengambil semua input dari api client
        $validate = Validator::make($updateData, [
            'nama_pemilik_kartu' => 'required',
            'nomor_kartu' => 'required',
            'expired_kartu' => 'required'
        ]); //membuat rule validasi input

        if($validate->fails())
            return response(['message' => $validate->errors()],400); //return error invalid input
        
        $info_pembayaran->nama_pemilik_kartu = $updateData['nama_pemilik_kartu']; //edit nama_pemilik_kartu
        $info_pembayaran->nomor_kartu = $updateData['nomor_kartu']; //edit kapasitas info_pembayaran
        $info_pembayaran->expired_kartu = $updateData['expired_kartu'];

        if($info_pembayaran->save()){
            return response([
                'message' => 'Update InfoPembayaran Success',
                'data' => $info_pembayaran,
            ],200);
        } //return data info_pembayaran yang telah di edit dalam bentuk json
        return response([
            'message' => 'Update InfoPembayaran Failed',
            'data' => null,
        ],400); //return message saat info_pembayaran gagal di edit
    }
}
