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
        $member = member::latest()->with(['pengguna'])->get();

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
        $temp = member::Where('id_member',$id)->with(['pengguna'])->get();

        //* Update

        $temp->update([
            'nama_member' => $request->nama_member,
            'tgl_lahir_member' => $request->tgl_lahir_member,
            'no_telp_member' => $request->no_telp_member,  
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Member Updated',
            'data'    => $temp  
        ], 200);
    }

    public function destroy($id)
    {
        $member = member::Where('id_member',$id)->first();

        if($member){
            $idPengguna = $member->pluck('id_pengguna');
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
}
