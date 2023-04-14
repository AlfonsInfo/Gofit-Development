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

        return $pengguna['id']; //* id untuk dihubungkan ke member,pegawai,instruktur   
    }

    public static function destroyPenggunaOnly($id)
    {
        $pengguna = pengguna::Where('id_pengguna',$id)->get();

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
