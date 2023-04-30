<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\transaksi_deposit_reguler;
use App\Models\transaksi_member;
use Exception;

class depositUangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaksi_deposit_reguler = transaksi_deposit_reguler::with(['transaksi_member'])->get();
        return response([
            'message'=>'Success Tampil Data',
            'data' => $transaksi_deposit_reguler
        ],200); 
    }

    public function todayTransaction()
    {
        $transaksi_deposit_reguler = transaksi_deposit_reguler::with(['transaksi_member'])
        ->whereDate('tanggal_deposit', now()->format('Y-m-d'))
        ->get();
        return response([
            'message'=>'Success Tampil Data',
            'data' => $transaksi_deposit_reguler
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
    try{
         //* Create Instruktur
            $transaksi_member = transaksi_member::create([
                'jenis_transaksi' => 'transaksi-aktivasi',
                'id_pegawai' => $request->id_pegawai,
                'id_member' => $request->id_member,
            ]);
            $transaksi_deposit_reguler = transaksi_member::where('jenis_transaksi', '=', 'transaksi-deposit-reguler')
                ->where('id_pegawai', '=', $request->id_pegawai)
                ->where('id_member', '=', $request->id_member)
                ->orderBy('created_at', 'desc')
                ->first();
            // dd($transaksi_deposit_reguler->no_struk_transaksi);
            $aktivasi = transaksi_deposit_reguler::create([
                'tanggal_aktivasi' => date('Y-m-d H:i:s', strtotime('now')),
                'nominal_aktivasi' => '300000',
                'no_struk' => $transaksi_deposit_reguler['no_struk_transaksi']
            ]);
                                    

        }catch(Exception $e)
        {
            dd($e);
        }
        return response([
            'message'=> 'success tambah data transaksi aktivasi',
            'data' => ['transaksi-member' => $transaksi_member, 'transaksi-aktivasi' => $aktivasi],
        ]);
    
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
