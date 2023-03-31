<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;  //import library untuk validasi
use App\Reservasi; //import model Reservasi
use Illuminate\Validation\Rule;


class ReservasiController extends Controller
{
     //method untuk menampilkan semua data reservasi (read)
     public function index(){
        $reservasi = Reservasi::all(); //mengambil semua data reservasi

        if(count($reservasi) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $reservasi
            ],200);
        } //return data semua reservasi dalam bentuk json

        return response([
            'message' => 'Empty',
            'data' => null
        ],404); //return message data reservasi kosong
    }

    //method untuk menampilkan 1 data reservasi (search)
    public function show($id){
        $reservasi = Reservasi::find($id); //mencari data reservasi berdasarkan id

        if(!is_null($reservasi)){
            return response([
                'message' => 'Retrieve Reservasi Success',
                'data' => $reservasi
            ],200);
        } //return data reservasi yang ditemukan dalam bentuk json

        return response([
            'message' => 'Reservasi Not Found',
            'data' => null
        ],404); //return message saat data reservasi tidak ditemukan
    }

    //method untuk menambah 1 data reservasi baru (create)
    public function store(Request $request){
        $storeData = $request->all(); //mengambil semua input dari api client
        $validate = Validator::make($storeData, [
            'tanggal_reservasi' => 'required',
            'jam_reservasi' => 'required',
            'sesi' => 'required',
            'no_meja' => 'required',
            'id_customer' => 'required',
            'id_karyawan' => 'required'
        ]); //membuat rule validasi input

        if($validate->fails())
            return response(['message' => $validate->errors()],460); //return error invalid input

        $reservasi = Reservasi::create($storeData); //menambah data reservasi baru
        return response([
            'message' => 'Add Reservasi Success',
            'data' => $reservasi,
        ],200); //return data reservasi baru dalam bentuk json
    }

    //method untuk menghapus 1 data reservasi (delete)
    public function destroy($id){
        $reservasi = Reservasi::find($id); //mencari data reservasi berdasarkan id

        if(is_null($reservasi)){
        return response([
            'message' => 'Reservasi Not Found',
            'data' => null
        ],404);
        } //return message saat data reservasi tidak ditemukan

        if($reservasi->delete()){
            return response([
                'message' => 'Delete Reservasi Success',
                'data' => $reservasi,
            ],200);
        } //return message saat berhasil menghapus data reservasi
        return response([
            'message' => 'Delete Reservasi Failed',
            'data' => null,
        ],400); //return message saat gagal menghapus data reservasi
    }

    //method untuk mengubah 1 data reservasi (update)
    public function update(Request $request, $id){
        $reservasi = Reservasi::find($id); //mencari data reservasi berdasarkan id
        if(is_null($reservasi)){
            return response([
                'message' => 'Reservasi Not Found',
                'data' => null
            ],404);
        } //return message saat data reservasi tidak ditemukan

        $updateData = $request->all(); //mengambil semua input dari api client
        $validate = Validator::make($updateData, [
            'tanggal_reservasi' => 'required',
            'jam_reservasi' => 'required',
            'sesi' => 'required',
            'no_meja' => 'required',
            'id_customer' => 'required',
            'id_karyawan' => 'required'
        ]); //membuat rule validasi input

        if($validate->fails())
            return response(['message' => $validate->errors()],400); //return error invalid input
        
        $reservasi->tanggal_reservasi = $updateData['tanggal_reservasi']; //edit no_meja
        $reservasi->jam_reservasi = $updateData['jam_reservasi']; //edit kapasitas reservasi
        $reservasi->sesi = $updateData['sesi'];
        $reservasi->no_meja = $updateData['no_meja'];
        $reservasi->id_customer = $updateData['id_customer'];
        $reservasi->id_karyawan = $updateData['id_karyawan'];

        if($reservasi->save()){
            return response([
                'message' => 'Update Reservasi Success',
                'data' => $reservasi,
            ],200);
        } //return data reservasi yang telah di edit dalam bentuk json
        return response([
            'message' => 'Update Reservasi Failed',
            'data' => null,
        ],400); //return message saat reservasi gagal di edit
    }
}
