<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\transaksi_member;
use Carbon\Carbon;

//*Transaksi in general 
class transaksiController extends Controller
{

    public function countTransaction()
    {
        $count= transaksi_member::count();
        return $count;
    }

    public function todayTransaction()
    {
        $created = Carbon::today()->toDateString();
        $transaksi_member = transaksi_member::whereDate('created_at',$created)->with(['member','pegawai','aktivasi','deposit_uang.promo','deposit_kelas_paket.kelas', 'deposit_kelas_paket.promo'])->get();
        return response([
            'message'=>'Success Tampil Data',
            'data' => $transaksi_member
        ],200); 
    }

    public function index()
    {
        $transaksi = transaksi_member::get();
        return response([
            'message'=>'Success Tampil Data',
            'data' => $transaksi
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
    public function update(Request $request, $id)
    {
        //
    }

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
}
