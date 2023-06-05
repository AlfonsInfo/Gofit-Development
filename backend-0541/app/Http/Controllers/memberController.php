<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User\member;
use Illuminate\Validation\Rules\Exists;
use Exception;
use App\Helpers\ValidatorHelper;
use Carbon\Carbon;
use App\Http\Controllers\riwayatMemberController;
use App\Models\riwayat_aktivitas_member;

class memberController extends Controller
{
    //* Tampil Data Member
    public function index()
    {
        $member = member::with(['pengguna'])->get();

        return response([
            'message'=>'Success Tampil Data',
            'data' => $member
        ],200); 
    }

    //* Show ID tertentu
    public function show($id)
    {
        $member = member::Where('id_member',$id)->with(['pengguna'])->get();
        if($member->isNotEmpty())
        {
            return response([
                'message'=>'Success Tampil Data',
                'data' => $member
            ],200);   
        }else{
            return response([
                'message' => 'Data not found'
            ],404);
        }
    }


    public function store(Request $request)
    {
    //*validasi
    $validator = ValidatorHelper::validateMember($request->all());

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    //* Register Akun Pengguna dan simpan id_pengguna pada variable local untuk dihubungkan (Nilai Default dlu)
    $password = self::formatDate($request->tgl_lahir_member);
    $idPengguna =   penggunaController::register(['username'=>'-'],['password'=>$password],'member');
    try{
        //* Create Instruktur
        $member = member::create([
            'id_pengguna' => $idPengguna,
            'nama_member' => $request->nama_member,
            'tgl_lahir_member' => $request->tgl_lahir_member,
            'no_telp_member' => $request->no_telp_member,            
            'alamat_member' => $request->alamat_member,            
        ]);
        
        //* Update data di pengguna
        $find = member::where('id_pengguna',$idPengguna)->first();
        penggunaController::updateUsername($idPengguna,$find->id_member);


        if(!riwayatMemberController::storeHistory($find->id_member,'Registrasi Akun')){
            return response(['gagal mencatat riwayat']);
        }

        }catch(Exception $e)
        {
            // * Jika instruktur gagal dibuat, data pengguna juga ikut dihapus
            // penggunaController::destroyPenggunaOnly($idPengguna);
            dd($e);
        }
            
        return response([
            'message'=> 'success tambah data member',
            'data' => $member,
    ]);

    }


    //* Update Data Member in general   
    public function update(Request $request, $id) 
    {
        //* Validasi
        $validator = ValidatorHelper::validateMember($request->all());
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //*Data yang ingin di update
        $member = Member::findOrFail($id);

         //* Update
        $member->nama_member = $request->nama_member;
        $member->tgl_lahir_member = $request->tgl_lahir_member;
        $member->no_telp_member = $request->no_telp_member;
        $member->save();
        return response()->json(['message' => 'Data member berhasil diupdate.'], 200);
    }

    //*Hapus Data Member
    public function destroy($id)
    {
        $member = member::Where('id_member' ,'=', $id)->first();
        // dd($member);

        if($member){
            $idPengguna = $member->id_pengguna;
            $member->delete();
            penggunaController::destroyPenggunaOnly($idPengguna);

            return response()->json([
                'success' => true,
                'message' => 'Member Deleted',
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'member Not Found',
            ], 404);
        } 
    }

    //*Update Tanggal Kadeluarsa
    public function updateExpireDate($id)
    {
        $member = member::where('id_member', $id)->first();
        if ($member->tgl_kadeluarsa_aktivasi == null) {
            $tgl_aktivasi = date('Y-m-d H:i:s'); // jika kosong, gunakan tanggal hari ini
        } else {
            $tgl_aktivasi = $member->tgl_kadeluarsa_aktivasi; // gunakan tanggal aktivasi yang ada di database
        }
        // tambahkan 1 tahun
        $tgl_kadaluarsa = date('Y-m-d H:i:s', strtotime('+1 year', strtotime($tgl_aktivasi)));
        $member->tgl_kadeluarsa_aktivasi = $tgl_kadaluarsa;
        $member->save();
            return response()->json([
            'success' => true,
            'message' => 'Tanggal Kadaluarsa Member berhasil diupdate',
            'tgl_kadaluarsa' => $tgl_kadaluarsa,
        ], 200);
    }


    //*Update Total Deposit
    public function updateTotalDeposit($id, Request $request)
    {   
        $member = member::where('id_member', $id)->first();
        // dd($member);
        $total_deposit = $member->total_deposit_uang;
        $total_deposit +=  $request->total_deposit; 
        $member->total_deposit_uang = $total_deposit;
        $member->save();
        return response()->json([
            'success' => true,
            'message' => 'Deposit Member berhasil diupdate',
        ], 200);
    }


    //*Update Member Kadeluarsa
    public function memberKadeluarsa()
                {
        $today = Carbon::today();

        $members = Member::where('tgl_kadeluarsa_aktivasi', '<', $today)
                        ->with(['pengguna'])
                        ->get();
        return response([   
            'message'=>'Success Tampil Data',
            'data' => $members
        ],200); 

    }

    //* Fungsionalitas Sistem
    //* Nampilin Data kadeluarsa / hari
    public function depositkadeluarsa()
    {
        $today = Carbon::today();

        $members = Member::where('tgl_kadeluarsa_paket', '<', $today)
                        ->get();
        return response([
            'message'=>'Success Tampil Data',
            'data' => $members
        ],200); 

    }


    //* Melakukan deaktivasi
    public function memberDeaktivasi()
    {
        $today = Carbon::today();

        $members = Member::where('tgl_kadeluarsa_aktivasi', '<', $today)
                        ->with(['pengguna'])
                        ->get();


        foreach ($members as $member) {
        $member->fill([
                'tgl_kadeluarsa_aktivasi' => null,
                'total_deposit_uang' => 0,
                'tgl_kadeluarsa_paket' => null,
                // add more attributes to reset to 0 as necessary
                
        ]);
        $member->save();
    }
    return response([
        'message'=>'Success Deaktivasi Member',
        'data' => $members
    ],200); 
    }

    //* Melakukan Reset Deposit Kadeluarsa
    public function resetDeposit()
    {
        $today = Carbon::today();

        $members = Member::where('tgl_kadeluarsa_paket', '<', $today)
        ->get();


        foreach ($members as $member) {
        $member->fill([
                'total_deposit_paket' => 0,
                'tgl_kadeluarsa_paket' => null,
            ]);
        $member->save();
    }
    return response([
        'message'=>'Success Reset Deposit Member',
        'data' => $members
    ],200); 
    }


    //! Fungsionalitas Pendukung Utama
    //* Simpan password dengna Format dd/mm/yyyy
    public function formatDate($date){
        $formattedDate = Carbon::parse($date)->format('d/m/Y');
        return $formattedDate;
    }
    }
