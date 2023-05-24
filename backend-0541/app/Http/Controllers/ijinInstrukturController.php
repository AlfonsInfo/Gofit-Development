<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ijin_instruktur;
use App\Models\jadwal_harian;
use Carbon\Carbon;

class ijinInstrukturController extends Controller
{
    //* Tampil / Show / Get Data Izin Instruktur
    public function index()
    {
        $ijin_instruktur = ijin_instruktur::with(['instruktur','instrukturPengganti','jadwalHarian','jadwalHarian.jadwal_umum'])->get();

        return response([
            'message'=>'Success Tampil Data',
            'data' => $ijin_instruktur
        ],200); 
    }

    //* Store Data Ijin
    public function store(Request $request)
    {
        $jadwalharian = jadwal_harian::where('id_jadwal_umum', $request->id_jadwal_umum)->first();

        //* Create Jadwal Umum
        $ijin = ijin_instruktur::create([
            // 'hari' => $request->hari,
            'id_jadwal_harian' => $request->id_jadwal_harian,
            'status_ijin' => 'belum-dikonfirmasi',
            'tanggal_pengajuan' => Carbon::now(),
            'id_instruktur' => $request->id_instruktur,
            'id_instruktur_pengganti' => $request->id_instruktur_pengganti,
            'id_jadwal_harian' => $jadwalharian->id_jadwal_harian
        ]);
        
        //! Store Riwayat Ijin
        //*return response
        return response([
            'message'=> 'success tambah data ijin',
            'data' => $ijin,
        ]);

    }


    //* Tampilin Data Ijin 
    public function indexByInstruktur(Request $request)
    {   
        $ijin_instruktur = ijin_instruktur::where('id_instruktur',$request->id_instruktur)->with(['instruktur','instrukturPengganti','jadwalHarian','jadwalHarian.jadwal_umum'])->get();

        return response([
            'message'=>'Success Tampil Data',
            'data' => $ijin_instruktur
        ],200); 
    }
}
