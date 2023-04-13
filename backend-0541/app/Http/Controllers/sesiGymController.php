<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\sesi_gym;

class sesiGymController extends Controller
{

    //* Read Semua Data
    public function index()
    {
        $sesiGym = sesi_gym::latest()->get();
        return response(
            [
                'message' => 'Show Sesi Gym Success',
                'sesiGym' => $sesiGym
            ],200
        );
    }


    //* Create Data Sesi Gym
    public function create()
    { }

    //* Menyimpan Data Store
    public function store(Request $request)
    {
        //* Validator
        $validator = Validator::make($request->all(),[

        ]);
        //* Validator fails
        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        //* Simpan Data
        $sesiGym = sesi_gym::make($request->all(),[]);
        
        //* return response
        // return new 
    }


    public function show($id)
    {
        $sesiGym = sesi_gym::find($id);
        return response(
            [
                'message' => 'Show Sesi Gym Success',
                'sesiGym' => $sesiGym
            ],200
        );
    }

    public function edit($id)
    {    }

    public function update(Request $request, $id)
    {    }
    public function destroy($id)
    {    }
}
