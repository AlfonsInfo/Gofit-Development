<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\kelas;
use Illuminate\Support\Facades\Validator;

class kelasController extends Controller
{
 
    public function index()
    {
        $kelas = kelas::latest()->get();
        return response(
            [
                'message' => 'Show Sesi Gym Success',
                'kelas' => $kelas
            ],200
        );
    }

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
        $kelas = kelas::make($request->all(),[]);
        
        //* return response
        // return new 
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kelas = kelas::find($id);
        return response(
            [
                'message' => 'Show Sesi Gym Success',
                'kelas' => $kelas
            ],200
        );

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
