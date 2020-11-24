<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Pesan;

class PesanController extends Controller
{
      //Method untuk menampilkan semua data Pesan(read)
      public function index(){
        $pesans = Pesan::all();

        if(count($pesans)>0){
            return response([
                'message'=>'Retrieve All Success',
                'data'=>$pesans
            ],200);
        }

        return response([
            'message'=>'Empty',
            'data'=>null
        ],404);
    }
    //Search Pesan
    public function show($id){
        $pesans = Pesan::find($id);

        if(!is_null($pesans)){
            return response([
                'message'=>'Retrieve Pesan Success',
                'data'=>$pesans
            ],200);
        }

        return response([
            'message'=>'Pesan Not Found',
            'data'=>null
        ],404);
    }
    //Add Pesan
    public function store(Request $request){
        $storeData =$request->all();
        $validate = Validator::make($storeData,[
            'judul' =>'required',
            'isi_pesan' =>'required',
            'pengirim' =>'required'
        ]);

        if($validate->fails()){
            return response(['message'=>$validate->errors()],400);
        }

        $pesans = Pesan::create($storeData);
        return response([
            'message'=>'Add Pesan Success',
            'data'=>$pesans,   
        ],200);
    }

    //delete Pesan
    public function destroy($id){
        $pesans = Pesan::find($id);

        if(is_null($pesans)){
            return response([
                'message'=>'Transaksi Not Found',
                'data'=>null
            ],404);
        }//return message saat data pesan tidak ditemukan

        if($pesans->delete()){
            return response([
                'message'=>'Delete Pesan Success',
                'data'=>$pesans,
            ],200);
        }//return message saat berhasil menghapus data

        return response([
            'message'=>'Delete Pesan Failed',
            'data'=>null
        ],400);//return message saat gagal menghapus data product
    }

    public function update(Request $request,$id){
        $pesans = Pesan::find($id);

        if(is_null($pesans)){
            return response([
                'message'=>'Pesan Not Found',
                'data'=>null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,[
            'judul' =>'required',
            'isi_pesan' =>'required',
            'pengirim' =>'required'
        ]);

        if($validate->fails())
            return response(['message'=>$validate->errors()],404);//return error invalid input

        $pesans->judul = $updateData['judul'];
        $pesans->isi_pesan = $updateData['isi_pesan'];
        $pesans->pengirim = $updateData['pengirim'];

        if($pesans->save()){
            return response([
                'message'=>'Update Pesan Success',
                'data'=>$pesans,
            ],200);
        }//return Pesan yg telah diedit

        return response([
            'message'=>'Update Pesan Failed',
            'data'=>null,
        ],404);//return message saat Pesan gagal diedit
    }
}
