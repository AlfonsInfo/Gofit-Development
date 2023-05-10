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
        //* Validasi
        // $validate = Validator::make($loginDataForm,[]);
        
        //* vaildate fails
        // dd(Auth::guard('api')->attempt($loginDataForm));
        // if($validate->fails())
            // return response()->json($validate->errors(),422);

        //* if without attempt

        if(!Auth::guard('api')->attempt($loginDataForm))
            return response(['message' => 'invalid credentials'],400);

        $user = Auth::user(); //* tetap user
        $token = $user->createToken('Authentication Token')->accessToken;
        
        // // dd($user->role);
        // if($user->role != 'pegawai'){
        //     return response(['message' => 'invalid credentials'],400);
        // }

        //* Role Pegawai (Only MO)
        if($user->role == 'pegawai'){
            $pegawai = pegawai::where('id_pengguna',$user->id_pengguna)->first();
        // dd($pegawai);
        //* Admin dan kasir tidak boleh masuk
        if($pegawai->jabatan_pegawai == 'Admin' || $pegawai->jabatan_pegawai == 'kasir'){
            return response(['message' => 'invalid credentials'],400);
        }

        return response([
            'message' => 'Autenthicated',
            'user' => $user,
            'pegawai' => $pegawai       ,
            'token_type' => 'Bearer',
            'access_token' => $token
        ]);
        }

        //* Role instruktur
        if($user->role == 'instruktur'){
            $instruktur = instruktur::where('id_pengguna',$user->id_pengguna);

        return response([
            'message' => 'Autenthicated',
            'user' => $user,
            'pegawai' => $instruktur[0],
            'token_type' => 'Bearer',
            'access_token' => $token
        ]);
        }

        //* Role Member
        if($user->role == 'member'){
            $member = member::where('id_pengguna',$user->id_pengguna);

            return response([
                'message' => 'Autenthicated',
                'user' => $user,
                'pegawai' => $member[0],
                'token_type' => 'Bearer',
                'access_token' => $token
            ]);
            }
        
}
}
