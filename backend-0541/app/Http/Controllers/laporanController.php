<?php

namespace App\Http\Controllers;

use App\Models\booking_gym;
use App\Models\booking_kelas;
use App\Models\jadwal_harian;
use Illuminate\Http\Request;
use Carbon\Carbon;

class laporanController extends Controller
{
    public function laporanPendapatanPerTahun(Request $request){
        //*Group Pendapatannya perbulan

        //*Group Tampilan Pertahun -> Request->Year

        //*Group 
    }

    public function aktivitasKelasBulanan(){
        //* Tanggal Cetak
        $tanggalCetak = Carbon::now();
        //* Where Request->Bulan
        $aktivitasKelas = booking_kelas::with([
            'jadwal_harian',
            'jadwal_harian.jadwal_umum.kelas',
            'jadwal_harian.jadwal_umum.instruktur',
            'jadwal_harian.ijin_instruktur'])   
        ->where('is_canceled',0)
        ->get();

        // $kelompokInstruktur = $aktivitasKelas->groupBy(function($item){
        //     return $item->jadwal_harian
        // });
        $kelompokKelas = $aktivitasKelas->groupBy(function ($item) {
            return $item->jadwal_harian->jadwal_umum->kelas->jenis_kelas;
        });


        $kelompokInstruktur = $kelompokKelas->groupBy(function ($item)
         {
            foreach($item as $kelas){
                return $kelas->jadwal_harian->jadwal_umum->instruktur->nama_instruktur;
            }
            // return $item->kelas;
        });


        
        return response([
            'data' => $kelompokInstruktur,
            'tanggal_cetak' => $tanggalCetak,
        ]);

    }

    public function aktivitasGymBulanan(Request $request){
        //* Tanggal Cetak
        $tanggalCetak = Carbon::now();
        $aktivitasGym = booking_gym::where('tanggal_sesi_gym','<',$tanggalCetak)
        ->where('status_kehadiran', 1 )
        ->where('is_canceled', 0)
        ->whereMonth('tanggal_sesi_gym', $request->month) //* lewat parmas
        ->get()
        ->groupBy(function ($item) {
            //*group by tanggal
            $carbonDate = Carbon::createFromFormat('Y-m-d', $item->tanggal_sesi_gym);
            return $carbonDate->format('Y-m-d');
        });
        //* Data yang diambil data booking gym yang udah lewat(tanggal sesi gymnya status kehadiran 1) dan tidak dibatalin
        
        
        //* Count 
        $responseData = [];

        foreach ($aktivitasGym as $tanggal => $grup) {
            $count = $grup->count();
            $responseData[] = [
                'tanggal' => $tanggal,
                'count' => $count,
            ];
        }



        return response([
            'data' => $responseData,
            'tanggal_cetak' => $tanggalCetak
        ]);
    }

    public function kinerjaInstrukturBulanan(){

    }
}
