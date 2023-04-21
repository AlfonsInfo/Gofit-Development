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

    public static function updateUsername($key,$username)
    {
        // dd($key,$username);
        $temp = pengguna::where('id_pengguna',$key)->first();
        // dd($temp);
        $temp->update([
            'username' => $username,
        ]);
    }

    public function update(Request $request, $id)
    {
        $pengguna = pengguna::find($id);
        // dd($request->tgl_lahir_member);
        $newPassword = bcrypt($request->tgl_lahir_member);
        $pengguna->password = $newPassword; 
        $pengguna->save();
        return response()->json([
            'success' => true,
            'message' => 'Password Berhasil Direset'
        ],200);
    }

    public static function destroyPenggunaOnly($id)
    {
        $pengguna = pengguna::find($id);
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
