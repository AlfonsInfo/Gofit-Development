<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User\member;
use Illuminate\Validation\Rules\Exists;
use Exception;
use App\Helpers\ValidatorHelper;


class memberController extends Controller
{
    public function index()
    {
        $member = member::with(['pengguna'])->get();

        return response([
            'message'=>'Success Tampil Data',
            'data' => $member
        ],200); 

    }

    public function show($id)
    {
        $member = member::Where('id_member',$id)->with(['pengguna'])->get();
        if($member->isNotEmpty())
        {
            return response([
                'message'=>'Success Tampil Data',
                'data' => $member
            ],200);   
        }else{
            return response([
                'message' => 'Data not found'
            ],404);
        }
    }
    public function store(Request $request)
    {
 //*validasi
 $validator = ValidatorHelper::validateMember($request->all());

 if ($validator->fails()) {
     return response()->json($validator->errors(), 422);
 }

//  * Register Akun Pengguna dan simpan id_pengguna pada variable local untuk dihubungkan
 $idPengguna =   penggunaController::register(['username'=>'-'],['password'=>$request->tgl_lahir_member],'member');

 
 try{
     //* Create Instruktur
        $member = member::create([
            'id_pengguna' => $idPengguna,
            'nama_member' => $request->nama_member,
            'tgl_lahir_member' => $request->tgl_lahir_member,
            'no_telp_member' => $request->no_telp_member,            
            'alamat_member' => $request->alamat_member,            
        ]);

        $find = member::where('id_pengguna',$idPengguna)->first();
        penggunaController::updateUsername($idPengguna,$find->id_member);
    }catch(Exception $e)
    {
        // * Jika instruktur gagal dibuat, data pengguna juga ikut dihapus
        // penggunaController::destroyPenggunaOnly($idPengguna);
        dd($e);
    }
        
    return response([
        'message'=> 'success tambah data member',
        'data' => $member,
 ]);

    }


    public function update(Request $request, $id)
    {
        //* Validasi
        $validator = ValidatorHelper::validateMember($request->all());
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //*Data yang ingin di update
        $member = Member::findOrFail($id);

         //* Update
        $member->nama_member = $request->nama_member;
        $member->tgl_lahir_member = $request->tgl_lahir_member;
        $member->no_telp_member = $request->no_telp_member;
        $member->save();
        return response()->json(['message' => 'Data member berhasil diupdate.'], 200);
    }

    public function destroy($id)
    {
        $member = member::Where('id_member' ,'=', $id)->first();
        // dd($member);

        if($member){
            $idPengguna = $member->id_pengguna;
            $member->delete();
            penggunaController::destroyPenggunaOnly($idPengguna);

            return response()->json([
                'success' => true,
                'message' => 'member Deleted',
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'member Not Found',
            ], 404);
        } 
    }

    public function updateExpireDate($id)
    {
        $member = member::where('id_member', $id)->first();
        if ($member->tgl_kadeluarsa_aktivasi == null) {
            $tgl_aktivasi = date('Y-m-d H:i:s'); // jika kosong, gunakan tanggal hari ini
        } else {
            $tgl_aktivasi = $member->tgl_kadeluarsa_aktivasi; // gunakan tanggal aktivasi yang ada di database
        }
        // tambahkan 1 tahun
        $tgl_kadaluarsa = date('Y-m-d H:i:s', strtotime('+1 year', strtotime($tgl_aktivasi)));
        $member->tgl_kadeluarsa_aktivasi = $tgl_kadaluarsa;
        $member->save();
            return response()->json([
            'success' => true,
            'message' => 'Tanggal Kadaluarsa Member berhasil diupdate',
        ], 200);
    }
}
