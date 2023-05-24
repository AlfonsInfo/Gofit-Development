<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\transaksi_member;
use App\Models\transaksi_aktivasi;
use App\Http\Controllers\riwayatMemberController;
use Exception;

class aktivasiController extends Controller
{
    //* Hitung JUmlah Transaksi Member) Untuk Generate Next Nomor Transaksi
    public function index()
    {
        $count= transaksi_member::count();
        return $count;
    }


    //* Fungsi Utama Fungsionalitas
    //* Aktivasi
    public function store(Request $request)
    {
    try{
         //* Create Transaksi Member (Tabel transaksi_member)
        $transaksi_member = transaksi_member::create([
            'jenis_transaksi' => 'transaksi-aktivasi',
            'id_pegawai' => $request->id_pegawai,
        'id_member' => $request->id_member,
        ]);

        //* Dapatkan data transaksi yang baru saja dibuat diatas
        $transaksi_aktivasi = transaksi_member::where('jenis_transaksi', '=', 'transaksi-aktivasi')
            ->where('id_pegawai', '=', $request->id_pegawai)
            ->where('id_member', '=', $request->id_member)
            ->orderBy('created_at', 'desc')
        ->first();

        //* Simpan di tabel transaksi aktivasi
        $aktivasi = transaksi_aktivasi::create([
            'tanggal_aktivasi' => date('Y-m-d H:i:s', strtotime('now')),
            'nominal_aktivasi' => '3000000',
            'no_struk' => $transaksi_aktivasi['no_struk_transaksi']
        ]);

        //* Simpan di tabel riwayat
        //! Fungsi createHistory()                                    
        riwayatMemberController::storeHistory($request->id_member,'Aktivasi Member',$transaksi_aktivasi['no_struk_transaksi']);
        }catch(Exception $e)
        {
            dd($e);
        }
        return response([
            'message'=> 'success tambah data transaksi aktivasi',
            'data' => ['transaksi_member' => $transaksi_member, 'transaksi_aktivasi' => $aktivasi],
        ]);
    
    }
}
