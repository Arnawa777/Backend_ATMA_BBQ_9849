<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;  //import library untuk validasi
use App\Pesanan; //import model Pesanan
use Illuminate\Validation\Rule;

class PesananController extends Controller
{
            //method untuk menampilkan semua data pesanan (read)
            public function index(){
                $pesanan = Pesanan::all(); //mengambil semua data pesanan
                $pesanan = $pesanan->load('detail_pesanan');

                if(count($pesanan) > 0){
                    return response([
                        'message' => 'Retrieve All Success',
                        'data' => $pesanan
                    ],200);
                } //return data semua pesanan dalam bentuk json
        
                return response([
                    'message' => 'Empty',
                    'data' => null
                ],404); //return message data pesanan kosong
            }
        
            //method untuk menampilkan 1 data pesanan (search)
            public function show($id){
                $pesanan = Pesanan::find($id); //mencari data pesanan berdasarkan id
                $pesanan = $pesanan->load('detail_pesanan');
                if(!is_null($pesanan)){
                    return response([
                        'message' => 'Retrieve Pesanan Success',
                        'data' => $pesanan
                    ],200);
                } //return data pesanan yang ditemukan dalam bentuk json
        
                return response([
                    'message' => 'Pesanan Not Found',
                    'data' => null
                ],404); //return message saat data pesanan tidak ditemukan
            }
        
            //method untuk menambah 1 data pesanan baru (create)
            public function store(Request $request){
                $storeData = $request->all(); //mengambil semua input dari api client
                $validate = Validator::make($storeData, [
                    'jumlah_item' => 'required',
                    'total_pesanan' => 'required',
                    'status_pesanan' => 'required',
                    'id_reservasi' => 'required'
                ]); //membuat rule validasi input
        
                if($validate->fails())
                    return response(['message' => $validate->errors()],460); //return error invalid input
        
                $pesanan = Pesanan::create($storeData); //menambah data pesanan baru
                return response([
                    'message' => 'Add Pesanan Success',
                    'data' => $pesanan,
                ],200); //return data pesanan baru dalam bentuk json
            }
        
            //method untuk menghapus 1 data pesanan (delete)
            public function destroy($id){
                $pesanan = Pesanan::find($id); //mencari data pesanan berdasarkan id
        
                if(is_null($pesanan)){
                return response([
                    'message' => 'Pesanan Not Found',
                    'data' => null
                ],404);
                } //return message saat data pesanan tidak ditemukan
        
                if($pesanan->delete()){
                    return response([
                        'message' => 'Delete Pesanan Success',
                        'data' => $pesanan,
                    ],200);
                } //return message saat berhasil menghapus data pesanan
                return response([
                    'message' => 'Delete Pesanan Failed',
                    'data' => null,
                ],400); //return message saat gagal menghapus data pesanan
            }
        
            //method untuk mengubah 1 data pesanan (update)
            public function update(Request $request, $id){
                $pesanan = Pesanan::find($id); //mencari data pesanan berdasarkan id
                if(is_null($pesanan)){
                    return response([
                        'message' => 'Pesanan Not Found',
                        'data' => null
                    ],404);
                } //return message saat data pesanan tidak ditemukan
        
                $updateData = $request->all(); //mengambil semua input dari api client
                $validate = Validator::make($updateData, [
                    // 'nama_menu' => 'required',
                    // 'jumlah_item' => 'required',
                    // 'total_pesanan' => 'required',
                    'status_pesanan' => 'required',
                    // 'id_reservasi' => 'required'
                ]); //membuat rule validasi input
        
                if($validate->fails())
                    return response(['message' => $validate->errors()],400); //return error invalid input
                
                // $pesanan->nama_menu = $updateData['nama_menu']; //edit nama_menu
                // $pesanan->jumlah_item = $updateData['jumlah_item']; //edit kapasitas pesanan
                // $pesanan->total_pesanan = $updateData['total_pesanan'];
                $pesanan->status_pesanan = $updateData['status_pesanan'];
                // $pesanan->id_reservasi = $updateData['id_reservasi'];
        
                if($pesanan->save()){
                    return response([
                        'message' => 'Update Pesanan Success',
                        'data' => $pesanan,
                    ],200);
                } //return data pesanan yang telah di edit dalam bentuk json
                return response([
                    'message' => 'Update Pesanan Failed',
                    'data' => null,
                ],400); //return message saat pesanan gagal di edit
            }

            public function updateLunas(Request $request, $id){
                $pesanan = Pesanan::find($id); //mencari data pesanan berdasarkan id
                if(is_null($pesanan)){
                    return response([
                        'message' => 'Pesanan Not Found',
                        'data' => null
                    ],404);
                } //return message saat data pesanan tidak ditemukan
        
                $updateData = $request->all(); //mengambil semua input dari api client
                $validate = Validator::make($updateData, [
                    
                    // 'status_pesanan' => 'nullable',
                ]); //membuat rule validasi input
        
                if($validate->fails())
                    return response(['message' => $validate->errors()],400); //return error invalid input
                
                $pesanan->status_pesanan = 'lunas';
        
                if($pesanan->save()){
                    return response([
                        'message' => 'Update Pesanan Success',
                        'data' => $pesanan,
                    ],200);
                } //return data pesanan yang telah di edit dalam bentuk json
                return response([
                    'message' => 'Update Pesanan Failed',
                    'data' => null,
                ],400); //return message saat pesanan gagal di edit
            }

            
            //method untuk menampilkan semua data pesanan (read)
            public function pesananBelumBayar(){

                $pesanan = Pesanan::where('status_pembayaran', 'belum bayar') -> get(); 
                $pesanan = $pesanan->load('detail_pesanan');
                // ->join('detail_pesanan', 'pesanan.id_pesanan', '=', 'detail_pesanan.id_pesanan') -> get();

                if(count($pesanan) > 0){
                    return response([
                        'message' => 'Retrieve All Success',
                        'data' => $pesanan
                    ],200);
                } //return data semua pesanan dalam bentuk json
        
                return response([
                    'message' => 'Empty',
                    'data' => null
                ],404); //return message data pesanan kosong
            }
            
        
}
