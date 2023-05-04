<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\transaksi_deposit_reguler;
use App\Models\transaksi_member;
use App\Models\promo;
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
        //* try dlu disini
        // cek nominalDeposit > promo[where id.promo].minimal.deposit
        $id_promo = null;
        if($request->id_promo != null){
            $promo = promo::findorfail($request->id_promo);
            $minimal_deposit = $promo->minimal_deposit;
            $nominal_deposit = $request->nominal_deposit;
            $total_deposit = $request->nominal_deposit;
            if($minimal_deposit <= $nominal_deposit){
                $id_promo = $request->minimal_deposit;
                // dd($promo->bonus_promo);
                $total_deposit += $promo->bonus_promo;
            }else{
                $id_promo = null;
            }
            
        }else{
            $nominal_deposit = $request->nominal_deposit;
            $total_deposit = $nominal_deposit;
        }
        // dd($total_deposit);              

        //* Create Transaksi Member
        $transaksi_member = transaksi_member::create([
            'jenis_transaksi' => 'transaksi-deposit-reguler',
            'id_pegawai' => $request->id_pegawai,
            'id_member' => $request->id_member,
        ]);
        
        
        
        //* Create Data Transaksi Reguler
        $transaksi_deposit_reguler = transaksi_member::where('jenis_transaksi', '=', 'transaksi-deposit-reguler')
            ->where('id_pegawai', '=', $request->id_pegawai)
            ->where('id_member', '=', $request->id_member)
            ->orderBy('created_at', 'desc')
            ->first();


            $depositreguler = transaksi_deposit_reguler::create([
            'tanggal_deposit' => date('Y-m-d H:i:s', strtotime('now')),
            'nominal_deposit' => $nominal_deposit,
            'nominal_total' =>   $total_deposit,
            'id_promo' => $id_promo,
            'no_struk' => $transaksi_deposit_reguler['no_struk_transaksi']
        ]);
        

        }catch(Exception $e)
        {
            dd($e);
        }
        return response([
            'message'=> 'Berhasil Melakukan Transaksi',
            'data' => ['transaksi_member' => $transaksi_member, 'transaksi_deposit_reguler' => $depositreguler],
            'total' => $total_deposit,
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
