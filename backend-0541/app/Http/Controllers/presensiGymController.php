<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\booking_gym;
use App\Models\transaksi_member;
use App\Models\User\member;
use Carbon\Carbon;

class presensiGymController extends Controller
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
        $presensi_gym = booking_gym::where('is_canceled',0)->latest()->get();
        return response([
            'message' => 'success tampil data',
            'data' => $presensi_gym
        ],200);
    }

    public function update(Request $request, $id)
    {
        $presensi_gym = booking_gym::find($id);
        $presensi_gym->status_kehadiran = $request->status_kehadiran; 
        $presensi_gym->waktu_presensi = Carbon::now(); 
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
        $dataBooking = booking_gym::with(['sesi','member'])->find($noBooking);
        // dd($dataBooking);
        // dd($dataLatest->no_struk_transaksi);


        //* Buat transaksi booking utk tabel transaksi-member
        $transaksi_member = transaksi_member::create([
            'jenis_transaksi' => 'transaksi-presensi-gym',
            'id_pegawai' =>  $request->id_pegawai,
            'id_member' => $dataBooking->id_member
        ]);
        $member = member::find($dataBooking->id_member);

        $dataLatest = transaksi_member::latest()->first();
        $no_struk_transaksi = $dataLatest->no_struk_transaksi; 
        $dataBooking->no_struk =  $no_struk_transaksi;
        $dataBooking->update();

        return response(['message' => 'Sukses mencetak struk',
                        'data' => $dataBooking,]);
    }
}
