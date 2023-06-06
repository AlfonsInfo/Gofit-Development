<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\transaksi_deposit_reguler;
use App\Http\Controllers\riwayatMemberController;
use App\Models\transaksi_member;
use App\Models\User\member;
use App\Models\promo;
use Exception;

class depositUangController extends Controller
{
    //* Get All Data Transaksi Deposit Reguler
    public function index()
    {
        $transaksi_deposit_reguler = transaksi_deposit_reguler::with(['transaksi_member'])->get();
        return response([
            'message'=>'Success Tampil Data',
            'data' => $transaksi_deposit_reguler
        ],200); 
    }

    //* Get Transaksi Hari ini incase mau dibatasin yang ditampilin dikasir
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

    public function store(Request $request)
    {
    try{
        //* Diawali dengan pengecekan promo layak atau tidak
        //* try dlu disini
        // cek nominalDeposit > promo[where id.promo].minimal.deposit
        $id_promo = null;
        $member_sebelum = member::findOrFail($request->id_member);
        if($request->id_promo != null){
            $promo = promo::findorfail($request->id_promo);
            $minimal_deposit = $promo->minimal_deposit;
            $nominal_deposit = $request->nominal_deposit;
            $total_deposit = $request->nominal_deposit;
            if($minimal_deposit <= $nominal_deposit){
                $id_promo = $request->id_promo;
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
            //* nominal total awal : deposit + bonus ->  jadi merepresentasikan saldo sesudah deposit
            'sisa_deposit' =>   $member_sebelum->total_deposit_uang,
            'nominal_total' =>   $total_deposit,
            'id_promo' => $id_promo,
            'no_struk' => $transaksi_deposit_reguler['no_struk_transaksi']
        ]);
        $member_sesudah = member::findOrFail($request->id_member);
        $depositreguler->nominal_total = $member_sesudah->total_deposit_uang;
        $depositreguler->save();

        $promo = promo::find($id_promo);
        
        //! Store Riwayat 
        riwayatMemberController::storeHistory($request->id_member,'Transaksi Deposit Uang',$depositreguler->no_struk);

        }catch(Exception $e)
        {
            dd($e);
        }
        return response([
            'message'=> 'Berhasil Melakukan Transaksi',
            'data' => ['transaksi_member' => $transaksi_member, 'transaksi_deposit_reguler' => $depositreguler, 'member_sebelum' => $member_sebelum , 'member_sesudah' => $member_sesudah, 'promo' => $promo],
            'total' => $total_deposit,
        ]);
    }
}
