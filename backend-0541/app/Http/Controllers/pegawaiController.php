<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User\pegawai;

class pegawaiController extends Controller
{
 
    public function index()
    {
        //
    }


    public function create()
    {

    }


    public function store(Request $request)
    {

    }

    public function show($id)
    {
        
    }

    public static function searchByIdPengguna($idpengguna){
        $pegawai = pegawai::Where('id_pengguna',$idpengguna)->get();
        return $pegawai;
    }


    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {

    }

   
    public function destroy($id)
    {

    }
}
