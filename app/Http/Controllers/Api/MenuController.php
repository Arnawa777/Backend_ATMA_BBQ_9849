<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;  //import library untuk validasi
use App\Menu; //import model Menu
use Illuminate\Validation\Rule;


class MenuController extends Controller
{
        //method untuk menampilkan semua data menu (read)
        public function index(){
            $menu = Menu::all(); //mengambil semua data menu
    
            if(count($menu) > 0){
                return response([
                    'message' => 'Retrieve All Success',
                    'data' => $menu
                ],200);
            } //return data semua menu dalam bentuk json
    
            return response([
                'message' => 'Empty',
                'data' => null
            ],404); //return message data menu kosong
        }
    
        //method untuk menampilkan 1 data menu (search)
        public function show($id){
            $menu = Menu::find($id); //mencari data menu berdasarkan id
    
            if(!is_null($menu)){
                return response([
                    'message' => 'Retrieve Menu Success',
                    'data' => $menu
                ],200);
            } //return data menu yang ditemukan dalam bentuk json
    
            return response([
                'message' => 'Menu Not Found',
                'data' => null
            ],404); //return message saat data menu tidak ditemukan
        }
    
        //method untuk menambah 1 data menu baru (create)
        public function store(Request $request){
            $storeData = $request->all(); //mengambil semua input dari api client
            $validate = Validator::make($storeData, [
                'nama_menu' => 'required|unique:menu',
                'kategori_menu' => 'required',
                'deskripsi_menu' => 'required',
                'unit_menu' => 'required',
                'harga_menu' => 'required',
                'id_bahan' => 'required'
            ]); //membuat rule validasi input
    
            if($validate->fails())
                return response(['message' => $validate->errors()],460); //return error invalid input
    
            $menu = Menu::create($storeData); //menambah data menu baru
            return response([
                'message' => 'Add Menu Success',
                'data' => $menu,
            ],200); //return data menu baru dalam bentuk json
        }
    
        //method untuk menghapus 1 data menu (delete)
        public function destroy($id){
            $menu = Menu::find($id); //mencari data menu berdasarkan id
    
            if(is_null($menu)){
            return response([
                'message' => 'Menu Not Found',
                'data' => null
            ],404);
            } //return message saat data menu tidak ditemukan
    
            if($menu->delete()){
                return response([
                    'message' => 'Delete Menu Success',
                    'data' => $menu,
                ],200);
            } //return message saat berhasil menghapus data menu
            return response([
                'message' => 'Delete Menu Failed',
                'data' => null,
            ],400); //return message saat gagal menghapus data menu
        }
    
        //method untuk mengubah 1 data menu (update)
        public function update(Request $request, $id){
            $menu = Menu::find($id); //mencari data menu berdasarkan id
            if(is_null($menu)){
                return response([
                    'message' => 'Menu Not Found',
                    'data' => null
                ],404);
            } //return message saat data menu tidak ditemukan
    
            $updateData = $request->all(); //mengambil semua input dari api client
            $validate = Validator::make($updateData, [
                'nama_menu' => [Rule::unique('menu')->ignore($menu)],
                'kategori_menu' => 'required',
                'deskripsi_menu' => 'required',
                'unit_menu' => 'required',
                'harga_menu' => 'required',
                'id_bahan' => 'required'
            ]); //membuat rule validasi input
    
            if($validate->fails())
                return response(['message' => $validate->errors()],400); //return error invalid input
            
            $menu->nama_menu = $updateData['nama_menu']; //edit nama_menu
            $menu->kategori_menu = $updateData['kategori_menu']; //edit kapasitas menu
            $menu->deskripsi_menu = $updateData['deskripsi_menu'];
            $menu->unit_menu = $updateData['unit_menu'];
            $menu->harga_menu = $updateData['harga_menu'];
            $menu->id_bahan = $updateData['id_bahan'];
    
            if($menu->save()){
                return response([
                    'message' => 'Update Menu Success',
                    'data' => $menu,
                ],200);
            } //return data menu yang telah di edit dalam bentuk json
            return response([
                'message' => 'Update Menu Failed',
                'data' => null,
            ],400); //return message saat menu gagal di edit
        }
    
}
