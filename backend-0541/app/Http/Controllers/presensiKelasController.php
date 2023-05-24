<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\booking_kelas;
use App\Models\jadwal_harian;
use App\Models\transaksi_member;

class presensiKelasController extends Controller
{

    //* Presensi Controller -> ke tabel booking juga,
    //* ambil data yang is_cancelednya false
    //* status kehadiran
    //* id sesi
    //* id member
    //* status cetak struk

    //* Ambil Seluruh Data yang is Canceled False
    public function index()
    {   
        $presensi_gym = booking_kelas::with(['jadwal_harian','jadwal_harian.jadwal_umum'])->where('is_canceled',0)->latest()->get();
        return response([
            'message' => 'success tampil data',
            'data' => $presensi_gym
        ],200);
    }

    public function update(Request $request, $id)
    {
        $presensi_gym = booking_kelas::find($id);
        $presensi_gym->status_kehadiran = $request->status_kehadiran; 
        $presensi_gym->save();  
        return response()->json([
            'success' => true,
            'message' => 'Konfirmasi Kehadiran Berhasil dilakukan'
        ],200);
    }
    /**
     * Show the form for creating a new resource.
     *  
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    
    public function generateStrukTransaksi($noBooking, Request $request){
        //* Cari Data Booking yang telah ada
        $dataBooking = booking_kelas::with(['jadwal_harian','member','jadwal_harian.jadwal_umum.kelas','jadwal_harian.jadwal_umum.instruktur'])->find($noBooking);
        $member = $dataBooking->member;
        $jenisTransaksi = 'transaksi-presensi-kelas';
        if($member->total_deposit_paket != null && $member->total_deposit_paket > 0){
            $jenisTransaksi = 'transaksi-presensi-kelas-paket';
        }
        // dd($dataBooking);
        // dd($dataLatest->no_struk_transaksi);
        //* cek deposit member uang / paket
        // dd($dataBooking->member->);
        //* Buat transaksi booking utk tabel transaksi-member
        $transaksi_member = transaksi_member::create([
            'jenis_transaksi' => $jenisTransaksi,
            'id_pegawai' =>  $request->id_pegawai,
            'id_member' => $dataBooking->id_member
        ]);
        //* update no struk di booking
        $dataLatest = transaksi_member::latest()->first();
        $no_struk_transaksi = $dataLatest->no_struk_transaksi; 
        $dataBooking->no_struk =  $no_struk_transaksi;
        $dataBooking->update();



        return response(['message' => 'Sukses mencetak struk',
                        'data' => $dataBooking,
                        'transaksi' => $transaksi_member]);
    }
}
