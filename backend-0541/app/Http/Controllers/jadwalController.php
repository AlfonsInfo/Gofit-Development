<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\jadwal_umum;
use Illuminate\Support\Facades\DB;
class jadwalController extends Controller
{

    public function index()
    {
        $jadwal_umum = jadwal_umum::latest()->with(['instruktur'])->get();
        return response([
            'message'=>'Success Tampil Data',
            'data' => $jadwal_umum
        ],200); 

        //*Debugging
        // dd($jadwal_umum->toSql());
    }

    public function show($id_jadwal_umum)
    {
        $jadwal_umum = jadwal_umum::where('id_jadwal_umum', $id_jadwal_umum)->with(['instruktur'])->first();
        
        //* Debugging SQL
        // dd($jadwal_umum->toSql());
        // DB::enableQueryLog();
        // dd(DB::enableQueryLog());
        // $sql =$jadwal_umum->toSql();
        
        //*Response
        return response([
            'message'=>'Success Tampil Data',
            'data' => $jadwal_umum
        ],200);
    }
    public function store(Request $request)
    {

    }

    public function update(Request $request, $id)
    {

    }
    public function destroy($id)
    {
        //
    }
}
