<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi;
use App\Detail;
use App\Pembeli;
use App\Petugas;
use App\Jenis;
use JWTAuth;
use DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class TransaksiController extends Controller
{
public function index($id)
  {
      if(Auth::user()->level=="petugas"){
          $transaksi=DB::table('transaksi')
          ->join('pembeli','pembeli.id', '=', 'transaksi.id_pembeli')
          ->join('petugas','petugas.id', '=', 'transaksi.id_petugas')
          ->select('transaksi.id','petugas.nama_petugas','pembeli.nama_pembeli','pembeli.alamat', 'pembeli.telp','transaksi.tgl_transaksi')
          ->where('transaksi.id',$id)
          ->get();

          $data=array(); $no=0;
          foreach ($transaksi as $t){
              $data[$no]['id'] = $t->id;
              $data[$no]['nama_petugas'] = $t->nama_petugas;
              $data[$no]['nama_pembeli'] = $t->nama_pembeli;
              $data[$no]['alamat'] = $t->alamat;
              $data[$no]['telp'] = $t->telp;
              $data[$no]['tgl_transaksi'] = $t->tgl_transaksi;

              $subtotal=DB::table('detail_transaksi')->where('id_transaksi', $t->id)->groupBy('id_transaksi')
              ->select(DB::raw('sum(subtotal) as grand_total'))->first();

              $data[$no]['grand_total'] = $subtotal->grand_total;
              $detail=DB::table('detail_transaksi')->join('jenis','jenis.id', '=', 'detail_transaksi.id_jenis')
              ->where('id_transaksi', $t->id)->select('jenis.nama_jenis', 'jenis.harga', 'detail_transaksi.qty', 'detail_transaksi.subtotal')->get();

              $data[$no]['detail'] = $detail;

              
          }
          return response()->json($data);
      }else{
          return response()->json(['status'=>'anda bukan petugas']);
      }
  }
    public function store(Request $request){
      if(Auth::user()->level=="petugas"){
      $validator=Validator::make($request->all(),
        [
          'id_petugas'=>'required',
          'id_pembeli'=>'required',
          'tgl_transaksi'=>'required'
        ]
      );

      if($validator->fails()){
        return Response()->json($validator->errors());
      }

      $simpan=Transaksi::create([
        'id_petugas'=>$request->id_petugas,
        'id_pembeli'=>$request->id_pembeli,
        'tgl_transaksi'=>$request->tgl_transaksi
      ]);
      $status=1;
      $message="Data Transaksi Berhasil Ditambahkan";
      if($simpan){
        return Response()->json(compact('status','message'));
      }else {
        return Response()->json(['status'=>0]);
      }
    }
    else {
        return response()->json(['status'=>'anda bukan petugas']);
    }
}

    public function update($id,Request $request){        
    if(Auth::user()->level=="petugas"){
      $validator=Validator::make($request->all(),
        [
            'id_petugas'=>'required',
            'id_pembeli'=>'required',
            'tgl_transaksi'=>'required'
        ]
    );
    if($validator->fails()){
        return Response()->json($validator->errors()->toJson(),400);
    }
      $ubah=Transaksi::where('id',$id)->update([
          'id_petugas'=>$request->id_petugas,
          'id_pembeli'=>$request->id_pembeli,
          'tgl_transaksi'=>$request->tgl_transaksi
        ]);
          $status = 1;
        $message = "Data Transaksi Berhasil Diubah";
        if($ubah){
            return Response()->json(compact('status', 'message'));
        }else {
            return Response()->json(['status'=> 0]);
        }
    }
    else {
        return response()->json(['status'=>'anda bukan petugas']);
    }
  }
  public function tampil(){
    $data=DB::table('transaksi')
    ->join('pembeli','pembeli.id', '=', 'transaksi.id_pembeli')
    ->join('petugas','petugas.id', '=', 'transaksi.id_petugas')
    ->select('transaksi.id','pembeli.nama_pembeli','petugas.nama_petugas','transaksi.tgl_transaksi')
    ->get();
    $count=$data->count();
    $status=1;
    return response()->json(compact('data','status','count'));
  }

  public function destroy($id){
    if(Auth::user()->level=="petugas"){
    $hapus=Transaksi::where('id',$id)->delete();
    $status=1;
    $message="Data Transaksi Berhasil Dihapus";
    if($hapus){
        return Response()->json(compact('status', 'message'));
    }else {
        return Response()->json(['status'=> 0]);
    }
    }
    else {
    return response()->json(['status'=>'anda bukan petugas']);
    }
}
}