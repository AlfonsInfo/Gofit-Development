<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User\pengguna;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\pegawaiController;

class loginMobileController extends Controller
{

    public function __invoke(Request $request)
    {
        //* Get Data
        $loginDataForm = $request->only(['username','password']);
        // dd($loginDataForm);
        //* Validasi
        // $validate = Validator::make($loginDataForm,[]);
        
        //* vaildate fails
        // dd(Auth::guard('api')->attempt($loginDataForm));
        // if($validate->fails())
            // return response()->json($validate->errors(),422);

        // dd($loginDataForm);
        //* if without attempt

        if(!Auth::guard('api')->attempt($loginDataForm))
            return response(['message' => 'invalid credentials'],400);

        $user = Auth::user(); //* tetap user
        $token = $user->createToken('Authentication Token')->accessToken;
        
        // dd($user->role);



        // ngambil id 
        //* Pegawai Controller 
        // $pegawai = pegawaiController::searchByIdPengguna($user->id_pengguna);
        // dd($pegawai);

        //* Role Cek backend atau frontend ?
        return response([
            'message' => 'Autenthicated',
            'user' => $user,
            // 'pegawai' => $pegawai[0],
            'token_type' => 'Bearer',
            'access_token' => $token
        ]);
        
    }
}
