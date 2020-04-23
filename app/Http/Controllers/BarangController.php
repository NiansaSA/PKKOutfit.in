<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barang;
use App\Jenis;
use Auth;
use DB;
use Illuminate\Support\Facades\Validator;
class BarangController extends Controller
{
    public function index($id)
    {
        if(Auth::user()->level=="admin"){
            $barang=DB::table('barang')
            ->join('jenis','jenis.id','=','barang.id_jenis')
            ->select('barang.id','barang.merk','jenis.nama_jenis','barang.ukuran',
                    'barang.foto','barang.keterangan')
            ->where('barang.id',$id)
            ->get();
            
            return response()->json($barang);
        }else{
            return response()->json(['status'=>'anda bukan admin']);
        }
    }
    public function store(Request $req)
    {
        if(Auth::user()->level=="admin"){
        $validator=Validator::make($req->all(),
        [
            'id_jenis'=>'required',
            'merk'=>'required',
            'ukuran'=>'required',
            'foto'=>'required',
            'keterangan'=>'required'
        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $simpan=barang::create([
            'id_jenis'=>$req->id_jenis,
            'merk'=>$req->merk,
            'ukuran'=>$req->ukuran,
            'foto'=>$req->foto,
            'keterangan'=>$req->keterangan
        ]);
        $status=1;
        $message="Barang Berhasil Ditambahkan";
        if($simpan){
          return Response()->json(compact('status','message'));
        }else {
          return Response()->json(['status'=>0]);
        }
      }
      else {
          return response()->json(['status'=>'anda bukan admin']);
      }
  }
    public function update($id,Request $request){
        if(Auth::user()->level=="admin"){
        $validator=Validator::make($request->all(),
            [
                'id_jenis'=>'required',
                'merk'=>'required',
                'ukuran'=>'required',
                'foto'=>'required',
                'keterangan'=>'required'
            ]
        );

        if($validator->fails()){
        return Response()->json($validator->errors());
        }

        $ubah=Barang::where('id',$id)->update([
            'id_jenis'=>$request->id_jenis,
            'merk'=>$request->merk,
            'ukuran'=>$request->ukuran,
            'foto'=>$request->foto,
            'keterangan'=>$request->keterangan
        ]);
        $status=1;
        $message="Barang Berhasil Diubah";
        if($ubah){
        return Response()->json(compact('status','message'));
        }else {
        return Response()->json(['status'=>0]);
        }
        }
    else {
    return response()->json(['status'=>'anda bukan admin']);
    }
}
    public function destroy($id){
        if(Auth::user()->level=="admin"){
        $hapus=Barang::where('id',$id)->delete();
        $status=1;
        $message="Barang Berhasil Dihapus";
        if($hapus){
        return Response()->json(compact('status','message'));
        }else {
        return Response()->json(['status'=>0]);
        }
    }
    else {
        return response()->json(['status'=>'anda bukan admin']);
        }
    }
  
    public function tampil(){
        if(Auth::user()->level=="admin"){
            $barang=DB::table('barang')
            ->join('jenis','jenis.id','=','barang.id_jenis')
            ->select('barang.id','barang.merk','jenis.nama_jenis','barang.ukuran',
                    'barang.foto','barang.keterangan')
            ->get();
            $count=$barang->count();
            return response()->json(compact('count','barang'));
        } else {
            return Response()->json(['status'=> 'Tidak bisa, anda bukan admin']);
        }
    }
}
