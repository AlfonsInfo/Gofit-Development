<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\riwayat_aktivitas_member;
use App\Models\booking_gym;
use App\Models\booking_kelas;
use Exception;
use Carbon\Carbon;

class riwayatMemberController extends Controller
{
    
    public static function storeHistory($id_member, $nama_aktivitas, $no_struk = null, $no_booking = null){
        try{
            $historyAktivitas = riwayat_aktivitas_member::create([
                'id_member' => $id_member,
                'nama_aktivitas' => $nama_aktivitas,
                'tanggal' => Carbon::now(),
                'no_struk' => $no_struk,
                'no_booking' => $no_booking,
            ]);
            return true;
        }catch(Exception $e){
            dd($e);
            return $e;
        }
    }

    public function showRiwayatByMember(Request $request){
        $riwayatMember = riwayat_aktivitas_member::where('id_member', $request->id_member)
        ->whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()])
        ->orderBy('created_at', 'desc')
    ->get();

        
        return response([
            'data' => $riwayatMember
        ]);
    }


    public function showRiwayatByMemberGym(Request $request){
        $riwayatMember = booking_gym::where('id_member', $request->id_member)->with(['sesi'])
        ->orderBy('created_at', 'desc')
        ->get();


        return response([
            'data' => $riwayatMember
        ]);
    }
    public function showRiwayatByMemberKelas(Request $request){
        $riwayatMember = booking_kelas::where('id_member', $request->id_member)->with(['jadwal_harian.jadwal_umum.kelas','jadwal_harian.jadwal_umum.instruktur','jadwal_harian.ijin_instruktur'])
        ->orderBy('created_at', 'desc')
        ->get();


        return response([
            'data' => $riwayatMember
        ]);
    }


    //* Dengan Filter

    public function showRiwayatByMemberGymFilter(Request $request){
        

        $tanggal_mulai = Carbon::parse($request->tanggal_mulai)->format('Y-m-d');
        $tanggal_selesai = Carbon::parse($request->tanggal_selesai)->format('Y-m-d');
        
        $riwayatMember = booking_gym::where('id_member', $request->id_member)
        ->whereBetween('tanggal_sesi_gym', [$tanggal_mulai, $tanggal_selesai])
        ->with(['sesi'])
        ->orderBy('created_at', 'desc')
        ->get();


        return response([
            'data' => $riwayatMember
        ]);
    }


    public function showRiwayatByMemberKelasFilter(Request $request){

        $tanggal_mulai = Carbon::parse($request->tanggal_mulai)->format('Y-m-d');
        $tanggal_selesai = Carbon::parse($request->tanggal_selesai)->format('Y-m-d');
        
        $riwayatMember = booking_kelas::where('id_member', $request->id_member)
            ->whereHas('jadwal_harian', function ($query) use ($tanggal_mulai, $tanggal_selesai) {
                $query->whereBetween('tanggal_jadwal_harian', [$tanggal_mulai, $tanggal_selesai]);
            })
            ->with(['jadwal_harian.jadwal_umum.kelas', 'jadwal_harian.jadwal_umum.instruktur', 'jadwal_harian.ijin_instruktur'])
            ->orderBy('created_at', 'desc')
            ->get();
        


        return response([
            'data' => $riwayatMember
        ]);
    }
 
}
