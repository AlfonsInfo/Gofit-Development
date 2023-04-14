<?php

namespace App\Http\Controllers;

use App\Models\User\pengguna;
use Illuminate\Http\Request;

class penggunaController extends Controller
{
    public static function register($username, $password, $role)
    {
        $registrationData  = array_merge($username, ($password), ['role' => $role]);
        $registrationData['password'] = bcrypt($registrationData['password']);
        $pengguna = pengguna::create($registrationData);

        return $pengguna['id_pengguna']; //* id untuk dihubungkan ke member,pegawai,instruktur   
    }

    public static function destroyPenggunaOnly($id)
    {
        $pengguna = pengguna::find($id)->first();
        // dd($pengguna);
        if($pengguna){
            $pengguna->delete();
            return response()->json([
                'success' => true,
                'message' => 'pengguna deleted'
            ],200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'pengguna not found'
            ],200);
        }
    }
    // public static function find()
    // {

    // }
}
