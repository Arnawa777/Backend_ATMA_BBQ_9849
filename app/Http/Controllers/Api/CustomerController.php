<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;  //import library untuk validasi
use App\Customer; //import model Customer
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
     //method untuk menampilkan semua data customer (read)
     public function index(){
        $customer = Customer::all(); //mengambil semua data customer

        if(count($customer) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $customer
            ],200);
        } //return data semua customer dalam bentuk json

        return response([
            'message' => 'Empty',
            'data' => null
        ],404); //return message data customer kosong
    }

    //method untuk menampilkan 1 data customer (search)
    public function show($id){
        $customer = Customer::find($id); //mencari data customer berdasarkan id

        if(!is_null($customer)){
            return response([
                'message' => 'Retrieve Customer Success',
                'data' => $customer
            ],200);
        } //return data customer yang ditemukan dalam bentuk json

        return response([
            'message' => 'Customer Not Found',
            'data' => null
        ],404); //return message saat data customer tidak ditemukan
    }

    //method untuk menambah 1 data customer baru (create)
    public function store(Request $request){
        $storeData = $request->all(); //mengambil semua input dari api client
        $validate = Validator::make($storeData, [
            'nama_customer' => 'required|max:50',
            'telp_customer' => 'required|unique:customer|digits_between:10,13',
            'email_customer' => 'required|email:rfc,dns|unique:customer'
        ]); //membuat rule validasi input

        if($validate->fails())
            return response(['message' => $validate->errors()],460); //return error invalid input

        $customer = Customer::create($storeData); //menambah data customer baru
        return response([
            'message' => 'Add Customer Success',
            'data' => $customer,
        ],200); //return data customer baru dalam bentuk json
    }

    //method untuk menghapus 1 data customer (delete)
    public function destroy($id){
        $customer = Customer::find($id); //mencari data customer berdasarkan id

        if(is_null($customer)){
        return response([
            'message' => 'Customer Not Found',
            'data' => null
        ],404);
        } //return message saat data customer tidak ditemukan

        if($customer->delete()){
            return response([
                'message' => 'Delete Customer Success',
                'data' => $customer,
            ],200);
        } //return message saat berhasil menghapus data customer
        return response([
            'message' => 'Delete Customer Failed',
            'data' => null,
        ],400); //return message saat gagal menghapus data customer
    }

    //method untuk mengubah 1 data customer (update)
    public function update(Request $request, $id){
        $customer = Customer::find($id); //mencari data customer berdasarkan id
        if(is_null($customer)){
            return response([
                'message' => 'Customer Not Found',
                'data' => null
            ],404);
        } //return message saat data customer tidak ditemukan

        $updateData = $request->all(); //mengambil semua input dari api client
        $validate = Validator::make($updateData, [
            'nama_customer' => 'required|max:50',
            'telp_customer' => ['digits_between:10,13', Rule::unique('customer')->ignore($customer)],
            'email_customer' => ['email:rfc,dns', Rule::unique('customer')->ignore($customer)]
        ]); //membuat rule validasi input

        if($validate->fails())
            return response(['message' => $validate->errors()],400); //return error invalid input
        
        $customer->nama_customer = $updateData['nama_customer']; //edit nama_customer
        $customer->telp_customer = $updateData['telp_customer']; //edit telp customer
        $customer->email_customer = $updateData['email_customer']; //edit email customer

        if($customer->save()){
            return response([
                'message' => 'Update Customer Success',
                'data' => $customer,
            ],200);
        } //return data customer yang telah di edit dalam bentuk json
        return response([
            'message' => 'Update Customer Failed',
            'data' => null,
        ],400); //return message saat customer gagal di edit
    }
}
