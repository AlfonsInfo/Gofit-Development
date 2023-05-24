<?php

namespace App\Http\Controllers;

use App\Models\presensi_instruktur;
use Illuminate\Http\Request;

use function Database\Seeders\presensiInstruktur;

class presensiInstrukturController extends Controller
{
    public function index()
    {
        //
    }


    //? Di bookingkelas ada langsung
    public function store(Request $request)
    {
        //* belum digunakan
        $storePresensi = presensi_instruktur::create([
            'waktu_presensi' => $request->waktu_presensi,
            'status_presensi' => 'hadir',
            'id_instruktur',
            'id_jadwal_harian',

        ]);
    }
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
