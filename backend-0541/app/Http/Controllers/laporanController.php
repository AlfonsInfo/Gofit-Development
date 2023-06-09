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
        //* Cek Tahun
        $year = Carbon::now()->year;
        $tanggalCetak = Carbon::now();
        if ($request->has('year') && !empty($request->year)) {
            $year = $request->year;
        }
        //*Group Pendapatannya perbulan
        //*Group Tampilan Pertahun -> Request->Year
        //*Group 
        $pendapatanPerTahun = DB::select("
        SELECT
            bulan.nama_bulan,
            COALESCE(SUM(nominal_aktivasi), 0) AS total_pendapatan_aktivasi,
            COALESCE(SUM(pendapatan_reguler + pendapatan_paket), 0) AS total_pendapatan_deposit,
            COALESCE(SUM(nominal_aktivasi + pendapatan_reguler + pendapatan_paket), 0) AS total_pendapatan
        FROM (
            SELECT 1 AS bulan_id, 'January' AS nama_bulan UNION ALL
            SELECT 2 AS bulan_id, 'February' AS nama_bulan UNION ALL
            SELECT 3 AS bulan_id, 'March' AS nama_bulan UNION ALL
            SELECT 4 AS bulan_id, 'April' AS nama_bulan UNION ALL
            SELECT 5 AS bulan_id, 'May' AS nama_bulan UNION ALL
            SELECT 6 AS bulan_id, 'June' AS nama_bulan UNION ALL
            SELECT 7 AS bulan_id, 'July' AS nama_bulan UNION ALL
            SELECT 8 AS bulan_id, 'August' AS nama_bulan UNION ALL
            SELECT 9 AS bulan_id, 'September' AS nama_bulan UNION ALL
            SELECT 10 AS bulan_id, 'October' AS nama_bulan UNION ALL
            SELECT 11 AS bulan_id, 'November' AS nama_bulan UNION ALL
            SELECT 12 AS bulan_id, 'December' AS nama_bulan
        ) AS bulan
        LEFT JOIN (
            SELECT
                MONTH(ta.tanggal_aktivasi) AS bulan_id,
                ta.nominal_aktivasi,
                0 AS pendapatan_reguler,
                0 AS pendapatan_paket
            FROM transaksi_aktivasi AS ta
            WHERE YEAR(ta.tanggal_aktivasi) = $year
            UNION ALL
            SELECT
                MONTH(tdr.tanggal_deposit) AS bulan_id,
                0 AS nominal_aktivasi,
                tdr.nominal_deposit AS pendapatan_reguler,
                tdp.nominal_uang AS pendapatan_paket
            FROM transaksi_deposit_reguler AS tdr
            INNER JOIN transaksi_deposit_paket AS tdp ON tdr.tanggal_deposit = tdp.tanggal_deposit
            WHERE YEAR(tdr.tanggal_deposit) = $year
        ) AS transaksi ON bulan.bulan_id = transaksi.bulan_id
        GROUP BY bulan.bulan_id, bulan.nama_bulan
        ORDER BY bulan.bulan_id
    ");





        return response([
            'data' => $pendapatanPerTahun,
            'tanggal_cetak' => $tanggalCetak,
        ]);
    }

    public function aktivitasKelasBulanan(Request $request)
    {
        $bulan = Carbon::now()->month;
        if ($request->has('month') && !empty($request->month)) {
            $bulan = $request->month;
        }
        // dd($bulan);
        //* Tanggal Cetak
        $tanggalCetak = Carbon::now();
        $aktivitasKelas = DB::select('
            SELECT k.jenis_kelas AS kelas, i.nama_instruktur AS instruktur, COUNT(bk.no_booking) AS jumlah_peserta_kelas, 
                COUNT(CASE WHEN jh.status = "diliburkan" THEN 1 ELSE NULL END) AS jumlah_libur
            FROM booking_kelas AS bk
            JOIN jadwal_harian AS jh ON bk.id_jadwal_harian = jh.id_jadwal_harian
            JOIN jadwal_umum AS ju ON jh.id_jadwal_umum = ju.id_jadwal_umum
            LEFT JOIN instruktur AS i ON ju.id_instruktur = i.id_instruktur
            LEFT JOIN kelas AS k ON ju.id_kelas = k.id_kelas
            WHERE MONTH(jh.tanggal_jadwal_harian) = ?
            GROUP BY k.jenis_kelas, i.nama_instruktur
            ', [$bulan]);
            
        //akumulasi terlambat direset tiap bulan jam mulai tiap bulan - jam selesai bulan 
        
        return response([
            'data' => $aktivitasKelas,
            'tanggal_cetak' => $tanggalCetak,
        ]);
        
    }
    
    public function aktivitasGymBulanan(Request $request){
        //* date
        $bulan = Carbon::now()->month;
        if ($request->has('month') && !empty($request->month)) {
            $bulan = $request->month;
        }


        //* Tanggal Cetak
        $tanggalCetak = Carbon::now();
        $aktivitasGym = booking_gym::where('tanggal_sesi_gym','<',$tanggalCetak)
        ->where('status_kehadiran', 1 )
        ->where('is_canceled', 0)
        ->whereMonth('tanggal_sesi_gym', $bulan) //* lewat parmas
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
    
    public function kinerjaInstrukturBulanan(Request $request)    {
        $bulan = Carbon::now()->month;
        if ($request->has('month') && !empty($request->month)) {
            $bulan = $request->month;
        }
        // dd($bulan);
        //* Tanggal Cetak
        $tanggalCetak = Carbon::now();
        $kinerjaInstruktur = DB::select('
        SELECT i.nama_instruktur,
            SUM(CASE WHEN pi.id_presensi IS NOT NULL THEN 1 ELSE 0 END) AS jumlah_hadir,
            SUM(CASE WHEN iz.id_ijin IS NOT NULL THEN 1 ELSE 0 END) AS jumlah_izin,
            IFNULL(i.akumulasi_terlambat, 0) AS akumulasi_terlambat
        FROM instruktur AS i
        LEFT JOIN presensi_instruktur AS pi ON i.id_instruktur = pi.id_instruktur AND MONTH(pi.created_at) = ?
        LEFT JOIN ijin_instruktur AS iz ON i.id_instruktur = iz.id_instruktur AND MONTH(iz.created_at) = ?
        GROUP BY i.nama_instruktur, i.akumulasi_terlambat
    ', [$bulan, $bulan]);   
        return response([
            'data' => $kinerjaInstruktur,
            'tanggal_cetak' => $tanggalCetak,
        ]);
}

}

