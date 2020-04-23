<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jenis;
use Auth;
use DB;
use Illuminate\Support\Facades\Validator;
class JenisController extends Controller
{
    public function index($id)
    {
        if(Auth::user()->level=="admin"){
            $jenis=DB::table('jenis')
            ->where('jenis.id',$id)
            ->get();
            return response()->json($jenis);
        }else{
            return response()->json(['status'=>'anda bukan admin']);
        }
    }
    public function store(Request $req)
    {
        if(Auth::user()->level=="admin"){
        $validator=Validator::make($req->all(),
        [
            'nama_jenis'=>'required',
            'harga'=>'required',
            'stok'=>'required'
        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $simpan=Jenis::create([
            'nama_jenis'=>$req->nama_jenis,
            'harga'=>$req->harga,
            'stok'=>$req->stok
        ]);
        $status=1;
        $message="Jenis Barang Berhasil Ditambahkan";
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
                'nama_jenis'=>'required',
                'harga'=>'required',
                'stok'=>'required'
            ]
        );

        if($validator->fails()){
        return Response()->json($validator->errors());
        }

        $ubah=Jenis::where('id',$id)->update([
            'nama_jenis'=>$request->nama_jenis,
            'harga'=>$request->harga,
            'stok'=>$request->stok
        ]);
        $status=1;
        $message="Jenis Barang Berhasil Diubah";
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
        $hapus=Jenis::where('id',$id)->delete();
        $status=1;
        $message="Jenis Barang Berhasil Dihapus";
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
            $datas = Jenis::get();
            $count = $datas->count();
            $jenis = array();
            $status = 1;
            foreach ($datas as $dt_jn){
                $jenis[] = array(
                    'id' => $dt_jn->id,
                    'nama_jenis' => $dt_jn->nama_jenis,
                    'harga' => $dt_jn->harga,
                    'stok' => $dt_jn->stok
                );
            }
            return Response()->json(compact('count','jenis'));
        } else {
            return Response()->json(['status'=> 'Tidak bisa, anda bukan admin']);
        }
    }
}
