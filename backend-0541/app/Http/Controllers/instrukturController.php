<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User\instruktur;
use App\Http\Controllers\penggunaController;
use Exception;
use App\Helpers\ValidatorHelper;
class instrukturController extends Controller
{



    public function index()
    {
        $instruktur = instruktur::latest()->with(['pengguna'])->get();

        return response([
            'message'=>'Success Tampil Data',
            'data' => $instruktur
        ],200); 
    }


    public function store(Request $request)
    {
        //*validasi
        $validator = ValidatorHelper::validateInstruktur($request->all());

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //*akhir dari validasi

        //* Buat Pengguna dan simpan id_pengguna
        $idPengguna =   penggunaController::register($request->all('username'),$request->all('password'),' instruktur');

        try{
            $instruktur = instruktur::create([
                // 'id_instruktur' => req
                'id_pengguna' => $idPengguna,
                'nama_instruktur' => $request->nama_instruktur,
                'tanggal_lahir_instruktur' => $request->tanggal_lahir_instruktur,
                'alamat_instruktur' => $request->alamat_instruktur,
                'no_telp_instruktur' => $request->no_telp_instruktur
            ]);
        }catch(Exception $e)
        {
            //* Jika instruktur gagal dibuat, data pengguna juga ikut dihapus
            penggunaController::destroyPenggunaOnly($idPengguna);
            dd($e);
        }
            
        return response([
            'message'=> 'success tambah data instruktur',
            'data' => $instruktur,
        ]);
    }

    //* specific resource
    public function show($id)
    {
        $instruktur = instruktur::Where('id_instruktur',$id)->with(['pengguna'])->get();
        return response([
            'message'=>'Success Tampil Data',
            'data' => $instruktur
        ],200);     }



     //* Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        //* Validasi
        $validator = ValidatorHelper::validateInstruktur($request->all());
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //*Data yang ingin di update
        $temp = instruktur::Where('id_instruktur',$id)->with(['pengguna'])->get();

        //* Update

        $temp->update([
            'nama_instruktur' => $request->nama_instruktur,
            'tanggal_lahir_instruktur' => $request->tanggal_lahir_instruktur,
            'alamat_instruktur' => $request->alamat_instruktur,
            'no_telp_instruktur' => $request->no_telp_instruktur
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Instruktur Updated',
            'data'    => $temp  
        ], 200);
    }

    //* Remove the specified resource from storage.
    public function destroy($id)
    {
        //
    }
}
