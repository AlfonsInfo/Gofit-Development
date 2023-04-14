<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User\instruktur;

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
        //
    }

    //* specific resource
    public function show($id)
    {
        $instruktur = instruktur::find($id)->with(['pengguna'])->get();
        return response([
            'message'=>'Success Tampil Data',
            'data' => $instruktur
        ],200);     }



     //* Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        //
    }

    //* Remove the specified resource from storage.
    public function destroy($id)
    {
        //
    }
}
