<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pembeli;
use Auth;
use DB;
use Illuminate\Support\Facades\Validator;
class PembeliController extends Controller
{
    public function index($id)
    {
        if(Auth::user()->level=="admin"){
            $pembeli=DB::table('pembeli')
            ->where('pembeli.id',$id)
            ->get();
            return response()->json($pembeli);
        }else{
            return response()->json(['status'=>'anda bukan admin']);
        }
    }
    public function store(Request $req)
    {
        if(Auth::user()->level=="admin"){
        $validator=Validator::make($req->all(),
        [
            'nama_pembeli'=>'required',
            'alamat'=>'required',
            'telp'=>'required',
            'username'=>'required',
            'foto'=>'required'
        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $simpan=Pembeli::create([
            'nama_pembeli'=>$req->nama_pembeli,
            'alamat'=>$req->alamat,
            'telp'=>$req->telp,
            'username'=>$req->username,
            'foto'=>$req->foto
        ]);
        $status=1;
        $message="Pembeli Berhasil Ditambahkan";
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
                'nama_pembeli'=>'required',
                'alamat'=>'required',
                'telp'=>'required',
                'username'=>'required',
                'foto'=>'required'
            ]
        );

        if($validator->fails()){
        return Response()->json($validator->errors());
        }

        $ubah=Pembeli::where('id',$id)->update([
            'nama_pembeli'=>$request->nama_pembeli,
            'alamat'=>$request->alamat,
            'telp'=>$request->telp,
            'username'=>$request->username,
            'foto'=>$request->foto
        ]);
        $status=1;
        $message="Pembeli Berhasil Diubah";
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
        $hapus=Pembeli::where('id',$id)->delete();
        $status=1;
        $message="Pembeli Berhasil Dihapus";
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
            $datas = Pembeli::get();
            $count = $datas->count();
            $pembeli = array();
            $status = 1;
            foreach ($datas as $dt_pm){
                $pembeli[] = array(
                    'id' => $dt_pm->id,
                    'nama_pembeli' => $dt_pm->nama_pembeli,
                    'alamat' => $dt_pm->alamat,
                    'telp' => $dt_pm->telp,
                    'username' => $dt_pm->username,
                    'foto' => $dt_pm->foto
                );
            }
            return Response()->json(compact('count','pembeli'));
        } else {
            return Response()->json(['status'=> 'Tidak bisa, anda bukan admin']);
        }
    }
}
