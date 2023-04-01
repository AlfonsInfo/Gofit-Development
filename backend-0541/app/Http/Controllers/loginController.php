<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User\pengguna;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{

    // public function __invoke()
    // {
    //     return 'mantap';
    // }

    public function __invoke(Request $request)
    {
        //* Get Data
        $loginDataForm = $request->only(['username','password']);
        //* Validasi
        // $validate = Validator::make($loginDataForm,[]);

        //* vaildate fails
        // if($validate->fails())
            // return response()->json($validate->errors(),422);

        //* if without attempt
        if(!Auth::guard('api')->attempt($loginDataForm))
            return response(['message' => 'invalid credentials'],400);

        $user = Auth::user(); //* tetap user
        $token = $user->createToken('Authentication Token')->accessToken;
        
        return response([
            'message' => 'Autenthicated',
            'user' => $user,
            'token_type' => 'Bearer',
            'acces_token' => $token
        ]);
        
    }
}
