<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;  //import library untuk validasi
use App\DetailPesanan; //import model DetailPesanan
use Illuminate\Validation\Rule;

class DetailPesananController extends Controller
{
            //method untuk menampilkan semua data detail_pesanan (read)
            public function index(){
                $detail_pesanan = DetailPesanan::join('menu', 'detail_pesanan.id_menu', '=', 'menu.id_menu')
                // ->join ('bahan', 'menu.id_bahan', '=', 'bahan.id_bahan')
                -> get(["detail_pesanan.*", "menu.harga_menu", "menu.nama_menu"]);
        
                if(count($detail_pesanan) > 0){
                    return response([
                        'message' => 'Retrieve All Success',
                        'data' => $detail_pesanan
                    ],200);
                } //return data semua detail_pesanan dalam bentuk json
        
                return response([
                    'message' => 'Empty',
                    'data' => null
                ],404); //return message data detail_pesanan kosong
            }
        
            //method untuk menampilkan 1 data detail_pesanan (search)
            public function show($id){
                $detail_pesanan = DetailPesanan::where("id_pesanan", "$id")->get();; //mencari data detail_pesanan berdasarkan id
                // DetailPesanan::where("id_pesanan", "$id")->get();
        
                if(!is_null($detail_pesanan)){
                    return response([
                        'message' => 'Retrieve DetailPesanan Success',
                        'data' => $detail_pesanan
                    ],200);
                } //return data detail_pesanan yang ditemukan dalam bentuk json
        
                return response([
                    'message' => 'DetailPesanan Not Found',
                    'data' => null
                ],404); //return message saat data detail_pesanan tidak ditemukan
            }

            public function update(Request $request, $id){
                $detail_pesanan = DetailPesanan::find($id); //mencari data detail_pesanan berdasarkan id
                if(is_null($detail_pesanan)){
                    return response([
                        'message' => 'Pesanan Not Found',
                        'data' => null
                    ],404);
                } //return message saat data detail_pesanan tidak ditemukan
        
                $updateData = $request->all(); //mengambil semua input dari api client
                $validate = Validator::make($updateData, [
                    // 'nama_menu' => 'required',
                    // 'jumlah_item' => 'required',
                    // 'total_pesanan' => 'required',
                    'status_detail_pesanan' => 'required',
                    // 'id_reservasi' => 'required'
                ]); //membuat rule validasi input
        
                if($validate->fails())
                    return response(['message' => $validate->errors()],400); //return error invalid input
                
                // $detail_pesanan->nama_menu = $updateData['nama_menu']; //edit nama_menu
                // $detail_pesanan->jumlah_item = $updateData['jumlah_item']; //edit kapasitas detail_pesanan
                // $detail_pesanan->total_pesanan = $updateData['total_pesanan'];
                $detail_pesanan->status_detail_pesanan = $updateData['status_detail_pesanan'];
                // $detail_pesanan->id_reservasi = $updateData['id_reservasi'];
        
                if($detail_pesanan->save()){
                    return response([
                        'message' => 'Update Pesanan Success',
                        'data' => $detail_pesanan,
                    ],200);
                } //return data detail_pesanan yang telah di edit dalam bentuk json
                return response([
                    'message' => 'Update Pesanan Failed',
                    'data' => null,
                ],400); //return message saat detail_pesanan gagal di edit
            }
        
}
