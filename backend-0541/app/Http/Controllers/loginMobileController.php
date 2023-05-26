<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User\pengguna;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\pegawaiController;
use App\Models\User\instruktur;
use App\Models\User\pegawai;
use App\Models\User\member;

class loginMobileController extends Controller
{

    public function __invoke(Request $request)
    {
        //* Get Data
        $loginDataForm = $request->only(['username','password']);
        if(!Auth::guard('api')->attempt($loginDataForm))
            return response(['message' => 'invalid credentials yo bang'],400);

        $user = Auth::user(); //* tetap user
        $token = $user->createToken('Authentication Token')->accessToken;


        //* Role Pegawai (Only MO)
        if($user->role == 'pegawai'){
            $pegawai = pegawai::where('id_pengguna',$user->id_pengguna)->first();
        
            //* Admin dan kasir tidak boleh masuk
            if($pegawai->jabatan_pegawai == 'Admin' || $pegawai->jabatan_pegawai == 'kasir'){
                return response(['message' => 'invalid credentials'],400);
            }

            return response([
                'message' => 'Autenthicated',
                'user' => $user,
                'pegawai' => $pegawai,
                'token_type' => 'Bearer',
                'access_token' => $token
            ]);
        }

        //* Role instruktur
        if($user->role == 'instruktur'){
            $instruktur = instruktur::where('id_pengguna',$user->id_pengguna)->first();

        return response([
            'message' => 'Autenthicated',
            'user' => $user,
            'instruktur' => $instruktur,
            'token_type' => 'Bearer',
            'access_token' => $token
        ]);
        }

        //* Role Member
        if($user->role == 'member'){
            $member = member::where('id_pengguna',$user->id_pengguna)->with(['kelas'])->first();

            return response([
                'message' => 'Autenthicated',
                'user' => $user,
                'member' => $member,
                'token_type' => 'Bearer',
                'access_token' => $token
            ]);
            }
        
}
}
