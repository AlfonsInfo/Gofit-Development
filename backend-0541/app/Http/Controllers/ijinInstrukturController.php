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
        //* store ijin sesudah hari ini
        $today = date('Y-m-d');
        // $jadwalharian = jadwal_harian::where('id_jadwal_umum', $request->id_jadwal_umum)->first();
        $jadwalharian_terakhir = jadwal_harian::where('id_jadwal_umum', $request->id_jadwal_umum)
        ->whereDate('tanggal_jadwal_harian', '>', $today)
        ->orderByDesc('tanggal_jadwal_harian')
        ->first();

        if($jadwalharian_terakhir == null){
            return response(['message' => 'Gagal Melakukan perijinan, MO belum melakukan generate Jadwal']);
        }

        //* Create Jadwal Umum
        $ijin = ijin_instruktur::create([
            'status_ijin' => 'Belum dikonfirmasi',
            'tanggal_pengajuan' => Carbon::now(),
            'id_instruktur' => $request->id_instruktur,
            'id_instruktur_pengganti' => $request->id_instruktur_pengganti,
            'id_jadwal_harian' => $jadwalharian_terakhir->id_jadwal_harian
        ]);
        
        //! Store Riwayat Ijin
        //*return response
        return response([
            'message'=> 'success tambah data ijin',
            'data' => $ijin,
        ]);

    }
    public function getOnlyBeforePermit(Request $request)
    {
        $ijin_instruktur = ijin_instruktur::where('status_ijin','Belum dikonfirmasi')->with(['instruktur','instrukturPengganti','jadwalHarian','jadwalHarian.jadwal_umum'])->get();

        return response([
            'message'=>'Success Tampil Data',
            'data' => $ijin_instruktur
        ],200); 

    }

    function update(Request $request, $id){
        $ijin = ijin_instruktur::where('id_ijin', $id)->first();
        $ijin->status_ijin  = $request->status_ijin;
        // dd($id,$ijin, $request->status_ijin);
        $ijin->save();  

        return response([
            'message'=>'Sukses Konfirmasi Ijin',
            'data' => $ijin
        ],200); 
    }


    //* Tampilin Data Ijin 
    public function indexByInstruktur(Request $request)
    {   
        $ijin_instruktur = ijin_instruktur::where('id_instruktur',$request->id_instruktur)->with(['instruktur','instrukturPengganti','jadwalHarian','jadwalHarian.jadwal_umum.kelas'])->get();

        return response([
            'message'=>'Success Tampil Data',
            'data' => $ijin_instruktur
        ],200); 
    }
}
