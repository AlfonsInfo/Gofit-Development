<?php

namespace App\Http\Controllers;

use App\Models\booking_gym;
use App\Models\booking_kelas;
use App\Models\jadwal_harian;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
    
        $aktivitasKelas = DB::Select('
            SELECT k.jenis_kelas AS kelas, i.nama_instruktur AS instruktur, COUNT(bk.no_booking) AS jumlah_peserta_kelas, 
            COUNT(CASE WHEN jh.status = "diliburkan" THEN 1 ELSE NULL END) AS jumlah_libur
            FROM booking_kelas AS bk
            JOIN jadwal_harian AS jh ON bk.id_jadwal_harian = jh.id_jadwal_harian
            JOIN jadwal_umum AS ju ON jh.id_jadwal_umum = ju.id_jadwal_umum
            JOIN instruktur AS i ON ju.id_instruktur = i.id_instruktur
            JOIN kelas AS k ON ju.id_kelas = k.id_kelas
            GROUP BY k.jenis_kelas, i.nama_instruktur
        '); 
        
        return response([
            'data' => $aktivitasKelas,
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

// public function aktivitasKelasBulanan(){
//     //* Tanggal Cetak
//     $tanggalCetak = Carbon::now();
//     //* Where Request->Bulan
//     $aktivitasKelas = booking_kelas::with([
//         'jadwal_harian',
//         'jadwal_harian.jadwal_umum.kelas',
//         'jadwal_harian.jadwal_umum.instruktur',
//         'jadwal_harian.ijin_instruktur'])   
//     ->where('is_canceled',0)
//     ->get();

//     $kelompokKelasInstruktur = $aktivitasKelas->groupBy(function ($item) {
//         $kelas = $item->jadwal_harian->jadwal_umum->kelas->jenis_kelas;
//         $instruktur = $item->jadwal_harian->jadwal_umum->instruktur->nama_instruktur;
//         return $kelas . ' - ' . $instruktur;
//     });
    
//     $responseData = [];
    
//     foreach ($kelompokKelasInstruktur as $kelasInstruktur => $kelas) {
//         list($namaKelas, $namaInstruktur) = explode(' - ', $kelasInstruktur);
    
//         $kelasData = [];
//         foreach ($kelas as $dataKelas) {
//             // Mengumpulkan data kelas dalam setiap kelompok
//             $kelasData[] = [
//                 // 'jenis_kelas' => $dataKelas->jadwal_harian->jadwal_umum->kelas->jenis_kelas,
//                 'jenis_kelas' => $dataKelas,
//                 'nama_instruktur' => $dataKelas,
//                 // 'nama_instruktur' => $dataKelas->jadwal_harian->jadwal_umum->instruktur->nama_instruktur,
//                 // Tambahkan data lain yang ingin Anda sertakan dalam respons
//             ];
//         }
    
//         // Menambahkan kelompok kelas dan instruktur ke dalam respons
//         $responseData[] = [
//             'nama_kelas' => $namaKelas,
//             'nama_instruktur' => $namaInstruktur,
//             'kelas' => $kelasData,
//         ];
//     }      $aktivitasKelas = DB::Select('
// SELECT MAX(bk.no_booking) AS no_booking, MAX(bk.tanggal_booking) AS tanggal_booking, k.jenis_kelas, i.nama_instruktur
// FROM booking_kelas AS bk
// JOIN jadwal_harian AS jh ON bk.id_jadwal_harian = jh.id_jadwal_harian
// JOIN jadwal_umum AS ju ON jh.id_jadwal_umum = ju.id_jadwal_umum
// JOIN instruktur AS i ON ju.id_instruktur = i.id_instruktur
// JOIN kelas AS k ON ju.id_kelas = k.id_kelas
// GROUP BY k.jenis_kelas, i.nama_instruktur
// '); 


// $tableData = DB::table('booking_kelas AS bk')
//     ->join('jadwal_harian AS jh', 'bk.id_jadwal_harian', '=', 'jh.id_jadwal_harian')
//     ->join('jadwal_umum AS ju', 'jh.id_jadwal_umum', '=', 'ju.id_jadwal_umum')
//     ->join('instruktur AS i', 'ju.id_instruktur', '=', 'i.id_instruktur')
//     ->join('kelas AS k', 'ju.id_kelas', '=', 'k.id_kelas')
//     ->select('k.jenis_kelas AS kelas', 'i.nama_instruktur AS instruktur', DB::raw('COUNT(bk.no_booking) AS jumlah_peserta_kelas'), DB::raw('COUNT(CASE WHEN jh.status = "diliburkan" THEN 1 ELSE NULL END) AS jumlah_libur'))
//     ->groupBy('k.jenis_kelas', 'i.nama_instruktur')
//     ->get();


//* Perbaiki dlu bagian lain 