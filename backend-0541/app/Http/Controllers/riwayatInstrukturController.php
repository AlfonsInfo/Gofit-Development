<?php

namespace App\Http\Controllers;

use App\Models\ijin_instruktur;
use App\Models\jadwal_harian;
use App\Models\presensi_instruktur;
use App\Models\riwayat_aktivitas_instruktur;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;


class riwayatInstrukturController extends Controller
{
    public static function storeHistoryInstruktur($id_instruktur, $nama_aktivitas, $id_jadwal, $no_booking = null){
        try{
            //* atau gabungin data 
            $historyAktivitas = riwayat_aktivitas_instruktur::create([
                'id_instruktur' => $id_instruktur,
                'nama_aktivitas' => $nama_aktivitas,
                'id_jadwal_harian' => $id_jadwal,
            ]);
            return true;
        }catch(Exception $e){
            dd($e);
            return $e;
        }
    }

    public function showRiwayatByInstruktur(Request $request){
        $riwayatInstruktur = riwayat_aktivitas_instruktur::where('id_instruktur', $request->id_instruktur)
        ->whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()])
        ->orderBy('created_at', 'desc')
        ->get();

        return response([
            'data' => $riwayatInstruktur
        ]);
    }


    public function mergeIjinPresensi(Request $request){
    $dataIjin = ijin_instruktur::where('id_instruktur', $request->id_instruktur)
    ->with(['jadwalHarian.jadwal_umum.kelas', 'jadwalHarian.ijin_instruktur'])
    ->get();

    $dataPresensi = presensi_instruktur::where('id_instruktur', $request->id_instruktur)
    ->with(['jadwalHarian.jadwal_umum.kelas'])
    ->get();

    $merge = $dataIjin->merge($dataPresensi);
    $sorted = $merge->sortByDesc('created_at')->values();

    $markedData = $sorted->map(function ($item) {
        if (isset($item['id_presensi'])) {
            $item['jenis_data'] = 'presensi';
        } elseif (isset($item['id_ijin'])) {
            $item['jenis_data'] = 'ijin';
        }

        return $item;
    });

    return response([
        'data' => $markedData,
    ]);
    }


    public function riwayatInstruktur(Request $request){
        
        // $id_instruktur = $request->id_instruktur;
        $id_instruktur = "ins-9";

        // $riwayat = jadwal_harian::with(['jadwal_umum.kelas', 'jadwal_umum.instruktur', 'ijin_instruktur']);

        // $riwayat->where(function ($query) use ($id_instruktur) {
        //     $query->whereHas('jadwal_umum', function($subQuery) use ($id_instruktur) {
        //         $subQuery->where('id_instruktur', $id_instruktur);
        //     })
        //     ->orWhereDoesntHave('ijin_instruktur'){
        //         // ('ijin_instruktur.perijinan_dikonfirmasi)
        //     }
        // });
        
        // $riwayat = $riwayat->get();
        $riwayat = DB::select("
        SELECT 
            jadwal_harian.id_jadwal_harian AS id_jadwal_harian,
            kelas.jenis_kelas AS jenis_kelas,
            ju.jam_mulai AS jam_mulai,
            ju.jam_selesai AS jam_selesai,
            jadwal_harian.jam_mulai AS jam_mulai_sebenarnya,
            jadwal_harian.jam_selesai AS jam_selesai_sebenarnya,
            jadwal_harian.tanggal_jadwal_harian AS tanggal_jadwal_harian,
            ju.hari AS hari,
            kelas.harga_kelas AS harga_kelas,
            (
                SELECT COUNT(no_booking)
                FROM booking_kelas
                WHERE id_jadwal_harian = jadwal_harian.id_jadwal_harian
            ) AS jumlah_peserta
        FROM jadwal_harian
        JOIN jadwal_umum AS ju ON jadwal_harian.id_jadwal_Umum = ju.id_jadwal_umum
        JOIN instruktur AS i ON ju.id_instruktur = i.id_instruktur
        JOIN kelas ON ju.id_kelas = kelas.id_kelas
        LEFT JOIN ijin_instruktur ON jadwal_harian.id_jadwal_harian = ijin_instruktur.id_jadwal_harian
            AND ijin_instruktur.status_ijin = 'Perijinan dikonfirmasi'
            AND ijin_instruktur.id_instruktur_pengganti = '". $id_instruktur ."'
        WHERE (i.id_instruktur = '". $id_instruktur ."'
            OR ijin_instruktur.id_instruktur_pengganti = '". $id_instruktur ."')
            AND jadwal_harian.id_jadwal_harian IS NOT NULL
            AND jadwal_harian.tanggal_jadwal_harian < CURDATE()
        ORDER BY jadwal_harian.id_jadwal_harian DESC
        LIMIT 10
    ");







    
        // $riwayat = DB::select('SELECT * FROM jadwal_harian 
        // JOIN jadwal_umum ON jadwal_harian.id_jadwal_Umum = jadwal_umum.id_jadwal_umum
        // JOIN kelas on jadwal_umum.id_kelas = jadwal_umum.id_kelas
        // LEFT JOIN ijin_instruktur ON jadwal_harian.id_jadwal_harian = ijin_instruktur.id_jadwal_harian
        // ');
        return response([
            'data' => $riwayat
        ]);
    }

}




// $dataIjin = ijin_instruktur::where('id_instruktur',$request->id_instruktur)->with(['jadwalHarian.jadwal_umum.kelas','jadwalHarian.ijin_instruktur'])->get();
// $dataPresensi = presensi_instruktur::where('id_instruktur',$request->id_instruktur)->with(['jadwalHarian.jadwal_umum.kelas', ])->get(); //jadwalHarian.ijin_instruktur
// $merge = $dataIjin->merge($dataPresensi);
// $sorted = $merge->sortByDesc('created_at')->values();

// return response([
//     'data' => $sorted,        
// ]);