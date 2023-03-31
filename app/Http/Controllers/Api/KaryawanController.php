<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Karyawan;
use App\User;
use Illuminate\Validation\Rule;
use Validator;

class KaryawanController extends Controller
{
    public function create(Request $request){
        $createData = $request->all();

        $validate = Validator::make($createData, [
            'nama_karyawan' => 'required|max:50',
            'role_karyawan' => 'required',
            'jenis_kelamin' => 'required',
            'email_karyawan' => 'required|email:rfc,dns|unique:karyawan',
            'telp_karyawan' => 'required|unique:karyawan|digits_between:10,13',
            'password' => 'required',
            'status_akun' => 'required',
            'tanggal_bergabung' => 'date|required'
        ]); //membuat rule validasi input

        if($validate->fails())
            return response(['message' => $validate->errors()],400); //return error invalid input
        
        $createData['password']= bcrypt($request->password); //enkripsi password
        
        $karyawan = Karyawan::create($createData); //membuat Karyawan baru
        return response([
            'message' => 'Create Success',
            'karyawan' => $karyawan,
        ],200); //return data user dalam bentuk json
    }
     
    public function login(Request $request){
        $loginData = $request->all();
        $validate = Validator::make($loginData, [
            'email_karyawan' => 'required|email:rfc,dns',
            'password' => 'required'
        ]); //membuat rule validasi input

        if($validate->fails())
            return response(['message' => 'Invalid Email Karyawan'],400); //return error invalid input
        
        if(!Auth::attempt($loginData))
            return response(['message' => 'Invalid Credentials'],401); //return error gagal login

        $karyawan = Auth::user();
        if(!$karyawan->status_akun)
            return response(['message' => 'Karyawan Inactive' ],400);

        $token = $karyawan->createToken('Authentication Token')->accessToken; //generate token

        return response([
            'message' => 'Authenticated',
            'karyawan' => $karyawan,
            'token_type' => 'Bearer',
            'access_token' => $token
        ]); //return data user dan token dalam bentuk json
    }
    

    //method untuk menampilkan semua data Karyawan (read)
    public function index(){
        $karyawan = Karyawan::all(); //mengambil semua data karyawan

        if(count($karyawan) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $karyawan
            ],200);
        } //return data semua karyawan dalam bentuk json

        return response([
            'message' => 'Empty',
            'data' => null
        ],404); //return message data karyawan kosong
    }

    //method untuk menampilkan 1 data karyawan (search)
    public function show($id){
        $karyawan = Karyawan::find($id); //mencari data karyawan berdasarkan id

        if(!is_null($karyawan)){
            return response([
                'message' => 'Retrieve Karyawan Success',
                'data' => $karyawan
            ],200);
        } //return data karyawan yang ditemukan dalam bentuk json

        return response([
            'message' => 'Karyawan Not Found',
            'data' => null
        ],404); //return message saat data karyawan tidak ditemukan
    }

    //method untuk menghapus 1 data karyawan (delete)
    public function destroy($id){
        $karyawan = Karyawan::find($id); //mencari data karyawan berdasarkan id

        if(is_null($karyawan)){
        return response([
            'message' => 'Karyawan Not Found',
            'data' => null
        ],404);
        } //return message saat data karyawan tidak ditemukan
        
        $karyawan->status_akun = '0';

        if($karyawan->save()){
            return response([
                'message' => 'Deactivate Karyawan Success',
                'data' => $karyawan,
            ],200);
        } //return data karyawan yang telah di Deactivate dalam bentuk json
        return response([
            'message' => 'Deactivate Karyawan Failed',
            'data' => null,
        ],400); //return message saat karyawan gagal di Deactivate
    }

    //method untuk mengubah 1 data karyawan (update)
    public function update(Request $request, $id){
        $karyawan = Karyawan::find($id); //mencari data karyawan berdasarkan id
        if(is_null($karyawan)){
            return response([
                'message' => 'Karyawan Not Found',
                'data' => null
            ],404);
        } //return message saat data karyawan tidak ditemukan

        $updateData = $request->all(); //mengambil semua input dari api client
        $validate = Validator::make($updateData, [
            'nama_karyawan' => 'required|max:50',
            'role_karyawan' => 'required',
            'jenis_kelamin' => 'required',
            'email_karyawan' => ['email:rfc,dns', Rule::unique('karyawan')->ignore($karyawan)],
            'status_akun' => 'required',
            'telp_karyawan' => ['digits_between:10,13', Rule::unique('karyawan')->ignore($karyawan)],
            'tanggal_bergabung' => 'date|required'
        ]); //membuat rule validasi input

        if($validate->fails())
            return response(['message' => $validate->errors()],400); //return error invalid input
        
        $karyawan->nama_karyawan = $updateData['nama_karyawan']; //edit nama_karyawan
        $karyawan->role_karyawan = $updateData['role_karyawan']; //edit role_karyawan
        $karyawan->jenis_kelamin = $updateData['jenis_kelamin']; //edit jenis kelamin
        $karyawan->email_karyawan = $updateData['email_karyawan']; //edit email
        $karyawan->status_akun = $updateData['status_akun'];
        $karyawan->telp_karyawan = $updateData['telp_karyawan']; //edit telp
        $karyawan->tanggal_bergabung = $updateData['tanggal_bergabung'];

        if($karyawan->save()){
            return response([
                'message' => 'Update Karyawan Success',
                'data' => $karyawan,
            ],200);
        } //return data karyawan yang telah di edit dalam bentuk json
        return response([
            'message' => 'Update Karyawan Failed',
            'data' => null,
        ],400); //return message saat karyawan gagal di edit
    }
}
