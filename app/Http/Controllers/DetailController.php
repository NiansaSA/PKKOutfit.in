<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Detail;
use App\Jenis;
use App\Transaksi;
use JWTAuth;
use DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class DetailController extends Controller
{
    public function index($id){
        if(Auth::user()->level=="petugas"){
          $detail=DB::table('detail_transaksi')
          ->join('jenis','jenis.id','detail_transaksi.id_jenis')
          ->join('transaksi','transaksi.id','detail_transaksi.id_transaksi')
          ->select('detail_transaksi.id','jenis.nama_jenis', 'jenis.harga','transaksi.id','detail_transaksi.qty','detail_transaksi.subtotal')
          ->where('detail_transaksi.id',$id)
          ->get();
          return response()->json(compact('detail'));
        }
      }
    
    public function store(Request $request){
    if(Auth::user()->level=="petugas"){
      $validator=Validator::make($request->all(),
        [
          'id_jenis'=>'required',
          'id_transaksi'=>'required',
          'qty'=>'required'
        ]
      );

      if($validator->fails()){
        return Response()->json($validator->errors());
      }
      $id_jenis = $request->id_jenis;
        $harga = DB::table('jenis')->where('id',$id_jenis)->first();
        $harga_total = $harga->harga;
        //var_dump($harga);
        $subtotal = $harga_total*$request->qty;
        //print_r($subtotal);
        
        //print_r($subtotal);
      $simpan=Detail::create([
        'id_jenis'=>$request->id_jenis,
        'id_transaksi'=>$request->id_transaksi,
        'qty'=>$request->qty,
        'subtotal'=>$subtotal
      ]);
      $status=1;
      $message="Detail Transaksi Berhasil Ditambahkan";
      if($simpan){
        return Response()->json(compact('status','message'));
      }else {
        return Response()->json(['status'=>0]);
      }
    }
    else{
        return response()->json(['status'=>'Anda bukan petugas']);
        }
    }

    public function update($id,Request $request){
      if(Auth::user()->level=="petugas"){
      $validator=Validator::make($request->all(),
        [
            'id_jenis'=>'required',
            'id_transaksi'=>'required',
            'qty'=>'required'
        ]
    );

    if($validator->fails()){
      return Response()->json($validator->errors());
    }
    $id_jenis = $request->id_jenis;
    $harga = DB::table('jenis')->where('id',$id_jenis)->first();
    $harga_total = $harga->harga;
    //var_dump($harga);
    $subtotal = $harga_total*$request->qty;
    //print_r($subtotal);
    
    //print_r($subtotal);
    $ubah=Detail::where('id',$id)->update([
        'id_jenis'=>$request->id_jenis,
        'id_transaksi'=>$request->id_transaksi,
        'qty'=>$request->qty,
        'subtotal'=>$subtotal
    ]);
    $status=1;
    $message="Detail Transaksi Berhasil Diubah";
    if($ubah){
      return Response()->json(compact('status','message'));
    }else {
      return Response()->json(['status'=>0]);
    }
  }
    else{
      return response()->json(['status'=>'anda bukan petugas']);
      }
  }
  public function tampil(){
    $detail=DB::table('detail_transaksi')
    ->join('jenis','jenis.id','detail_transaksi.id_jenis')
    ->join('transaksi','transaksi.id','detail_transaksi.id_transaksi')
    ->select('detail_transaksi.id','jenis.nama_jenis','transaksi.tgl_transaksi','detail_transaksi.subtotal')
    ->get();
    $count=$detail->count();
    $status=1;
    return response()->json(compact('detail','status','count'));
  }

  public function destroy($id){ 
    if(Auth::user()->level=="petugas"){
    $hapus=Detail::where('id',$id)->delete();
    $status=1;
    $message="Detail Transaksi Berhasil Dihapus";
    if($hapus){
      return Response()->json(compact('status','message'));
    }else {
      return Response()->json(['status'=>0]);
    }
  }
  else{
    return response()->json(['status'=>'anda bukan petugas']);
  }
}
}