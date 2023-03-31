<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;  //import library untuk validasi
use App\Meja; //import model Meja
use Illuminate\Validation\Rule;


class MejaController extends Controller
{
    //method untuk menampilkan semua data meja (read)
    public function index(){
        $meja = Meja::all(); //mengambil semua data meja

        if(count($meja) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $meja
            ],200);
        } //return data semua meja dalam bentuk json

        return response([
            'message' => 'Empty',
            'data' => null
        ],404); //return message data meja kosong
    }

    //method untuk menampilkan 1 data meja (search)
    public function show($id){
        $meja = Meja::find($id); //mencari data meja berdasarkan id

        if(!is_null($meja)){
            return response([
                'message' => 'Retrieve Meja Success',
                'data' => $meja
            ],200);
        } //return data meja yang ditemukan dalam bentuk json

        return response([
            'message' => 'Meja Not Found',
            'data' => null
        ],404); //return message saat data meja tidak ditemukan
    }

    //method untuk menambah 1 data meja baru (create)
    public function store(Request $request){
        $storeData = $request->all(); //mengambil semua input dari api client
        $validate = Validator::make($storeData, [
            'no_meja' => 'numeric|unique:meja',
            'kapasitas_meja' => 'required',
            'status_meja' => 'required'
        ]); //membuat rule validasi input

        if($validate->fails())
            return response(['message' => $validate->errors()],460); //return error invalid input

        $meja = Meja::create($storeData); //menambah data meja baru
        return response([
            'message' => 'Add Meja Success',
            'data' => $meja,
        ],200); //return data meja baru dalam bentuk json
    }

    //method untuk menghapus 1 data meja (delete)
    public function destroy($id){
        $meja = Meja::find($id); //mencari data meja berdasarkan id

        if(is_null($meja)){
        return response([
            'message' => 'Meja Not Found',
            'data' => null
        ],404);
        } //return message saat data meja tidak ditemukan

        if($meja->delete()){
            return response([
                'message' => 'Delete Meja Success',
                'data' => $meja,
            ],200);
        } //return message saat berhasil menghapus data meja
        return response([
            'message' => 'Delete Meja Failed',
            'data' => null,
        ],400); //return message saat gagal menghapus data meja
    }

    //method untuk mengubah 1 data meja (update)
    public function update(Request $request, $id){
        $meja = Meja::find($id); //mencari data meja berdasarkan id
        if(is_null($meja)){
            return response([
                'message' => 'Meja Not Found',
                'data' => null
            ],404);
        } //return message saat data meja tidak ditemukan

        $updateData = $request->all(); //mengambil semua input dari api client
        $validate = Validator::make($updateData, [
            'no_meja' => ['numeric', Rule::unique('meja')->ignore($meja)],
            'kapasitas_meja' => 'required',
            'status_meja' => 'required'
        ]); //membuat rule validasi input

        if($validate->fails())
            return response(['message' => $validate->errors()],400); //return error invalid input
        
        $meja->no_meja = $updateData['no_meja']; //edit no_meja
        $meja->kapasitas_meja = $updateData['kapasitas_meja']; //edit kapasitas meja
        $meja->status_meja = $updateData['status_meja'];

        if($meja->save()){
            return response([
                'message' => 'Update Meja Success',
                'data' => $meja,
            ],200);
        } //return data meja yang telah di edit dalam bentuk json
        return response([
            'message' => 'Update Meja Failed',
            'data' => null,
        ],400); //return message saat meja gagal di edit
    }

}
