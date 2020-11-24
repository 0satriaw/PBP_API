<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Transaksi;

class TransaksiController extends Controller
{
    //Method untuk menampilkan semua data Transaksasi (read)
    public function index(){
        $transaksis = Transaksi::all();

        if(count($transaksis)>0){
            return response([
                'message'=>'Retrieve All Success',
                'data'=>$transaksis
            ],200);
        }

        return response([
            'message'=>'Empty',
            'data'=>null
        ],404);
    }
    //Search Transaksi
    public function show($id){
        $transaksis = Transaksi::find($id);

        if(!is_null($transaksis)){
            return response([
                'message'=>'Retrieve Transaksi Success',
                'data'=>$transaksis
            ],200);
        }

        return response([
            'message'=>'Transaksi Not Found',
            'data'=>null
        ],404);
    }
    //Add Transaksi
    public function store(Request $request){
        $storeData =$request->all();
        $validate = Validator::make($storeData,[
            'paket' =>'required',
            'harga'=> 'required|numeric',
            'berat'=>'required|integer',
            'total_harga'=>'required',
            'lama_pengerjaan'=>'required|integer',
            'status'=>'required'
        ]);

        if($validate->fails()){
            return response(['message'=>$validate->errors()],400);
        }

        $transaksis = Transaksi::create($storeData);
        return response([
            'message'=>'Add Transaksi Success',
            'data'=>$transaksis,   
        ],200);
    }

    //delete transaksi
    public function destroy($id){
        $transaksis = Transaksi::find($id);

        if(is_null($transaksis)){
            return response([
                'message'=>'Transaksi Not Found',
                'data'=>null
            ],404);
        }//return message saat data transaksi tidak ditemukan

        if($transaksis->delete()){
            return response([
                'message'=>'Delete Transaksi Success',
                'data'=>$transaksis,
            ],200);
        }//return message saat berhasil menghapus data

        return response([
            'message'=>'Delete Transaksi Failed',
            'data'=>null
        ],400);//return message saat gagal menghapus data product
    }

    public function update(Request $request,$id){
        $transaksis = Transaksi::find($id);

        if(is_null($transaksis)){
            return response([
                'message'=>'Transaksi Not Found',
                'data'=>null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,[
            'paket' =>'required|alpha',
            'harga'=> 'required|numeric',
            'berat'=>'required|integer',
            'total_harga'=>'required|numeric',
            'lama_pengerjaan'=>'required|integer',
            'status'=>'required|alpha'
        ]);

        if($validate->fails())
            return response(['message'=>$validate->errors()],404);//return error invalid input

        $transaksis->paket = $updateData['paket'];
        $transaksis->harga = $updateData['harga'];
        $transaksis->berat = $updateData['berat'];
        $transaksis->total_harga = $updateData['total_harga'];
        $transaksis->lama_pengerjaan = $updateData['lama_pengerjaan'];
        $transaksis->status = $updateData['status'];

        if($transaksis->save()){
            return response([
                'message'=>'Update Transaksi Success',
                'data'=>$transaksis,
            ],200);
        }//return Transaksi yg telah diedit

        return response([
            'message'=>'Update Product Failed',
            'data'=>null,
        ],404);//return message saat transaksi gagal diedit
    }
}
