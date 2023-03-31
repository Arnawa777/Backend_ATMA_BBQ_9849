<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;  //import library untuk validasi
use App\Bahan; //import model Bahan
use Illuminate\Validation\Rule;

class BahanController extends Controller
{
        //method untuk menampilkan semua data bahan (read)
        public function index(){
            $bahan = Bahan::all(); //mengambil semua data bahan
    
            if(count($bahan) > 0){
                return response([
                    'message' => 'Retrieve All Success',
                    'data' => $bahan
                ],200);
            } //return data semua bahan dalam bentuk json
    
            return response([
                'message' => 'Empty',
                'data' => null
            ],404); //return message data bahan kosong
        }
    
        //method untuk menampilkan 1 data bahan (search)
        public function show($id){
            $bahan = Bahan::find($id); //mencari data bahan berdasarkan id
    
            if(!is_null($bahan)){
                return response([
                    'message' => 'Retrieve Bahan Success',
                    'data' => $bahan
                ],200);
            } //return data bahan yang ditemukan dalam bentuk json
    
            return response([
                'message' => 'Bahan Not Found',
                'data' => null
            ],404); //return message saat data bahan tidak ditemukan
        }
    
        //method untuk menambah 1 data bahan baru (create)
        public function store(Request $request){
            $storeData = $request->all(); //mengambil semua input dari api client
            $validate = Validator::make($storeData, [
                'nama_bahan' => 'required|unique:bahan',
                'ukuran_saji' => 'numeric|required',
                'unit_saji' => 'required'
            ]); //membuat rule validasi input
    
            if($validate->fails())
                return response(['message' => $validate->errors()],460); //return error invalid input
    
            $bahan = Bahan::create($storeData); //menambah data bahan baru
            return response([
                'message' => 'Add Bahan Success',
                'data' => $bahan,
            ],200); //return data bahan baru dalam bentuk json
        }
    
        //method untuk menghapus 1 data bahan (delete)
        public function destroy($id){
            $bahan = Bahan::find($id); //mencari data bahan berdasarkan id
    
            if(is_null($bahan)){
            return response([
                'message' => 'Bahan Not Found',
                'data' => null
            ],404);
            } //return message saat data bahan tidak ditemukan
    
            if($bahan->delete()){
                return response([
                    'message' => 'Delete Bahan Success',
                    'data' => $bahan,
                ],200);
            } //return message saat berhasil menghapus data bahan
            return response([
                'message' => 'Delete Bahan Failed',
                'data' => null,
            ],400); //return message saat gagal menghapus data bahan
        }
    
        //method untuk mengubah 1 data bahan (update)
        public function update(Request $request, $id){
            $bahan = Bahan::find($id); //mencari data bahan berdasarkan id
            if(is_null($bahan)){
                return response([
                    'message' => 'Bahan Not Found',
                    'data' => null
                ],404);
            } //return message saat data bahan tidak ditemukan
    
            $updateData = $request->all(); //mengambil semua input dari api client
            $validate = Validator::make($updateData, [
                'nama_bahan' => ['required', Rule::unique('bahan')->ignore($bahan)],
                'ukuran_saji' => 'numeric|required',
                'unit_saji' => 'required'
            ]); //membuat rule validasi input
    
            if($validate->fails())
                return response(['message' => $validate->errors()],400); //return error invalid input
            
            $bahan->nama_bahan = $updateData['nama_bahan']; //edit nama_bahan
            $bahan->ukuran_saji = $updateData['ukuran_saji']; //edit kapasitas bahan
            $bahan->unit_saji = $updateData['unit_saji'];
    
            if($bahan->save()){
                return response([
                    'message' => 'Update Bahan Success',
                    'data' => $bahan,
                ],200);
            } //return data bahan yang telah di edit dalam bentuk json
            return response([
                'message' => 'Update Bahan Failed',
                'data' => null,
            ],400); //return message saat bahan gagal di edit
        }
    
}
