<?php

namespace App\Http\Controllers;

use App\Models\booking_gym;
use App\Models\booking_kelas;
use App\Models\User\member;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;

class bookingKelasController extends Controller
{

    public function getMemberKelasByJadwal($jadwal){
        $booking = booking_kelas::where('id_jadwal_harian', $jadwal)->where('is_canceled', 0 )->with(['member','jadwal_harian'])->get();

        return response(['data' => $booking]);
    }

    public function potongDeposit($noBook){
        $bookingKelas = booking_kelas::with(['jadwal_harian','jadwal_harian.jadwal_umum','jadwal_harian.jadwal_umum.kelas'])->find($noBook);
        $kelas = $bookingKelas->jadwal_harian->jadwal_umum->kelas;
        $member = member::find($bookingKelas->id_member);
        if($member->total_deposit_paket != null && $member->total_deposit_paket > 0){
            $member->total_deposit_paket -= 1;
        //* tidak perlu cek uang dia lebih dari 200 ?
        }else {
            $member->total_deposit_uang -= $kelas->harga_kelas;
        }
        $member->update();
        //* total deposit uang, total deposit paket
        // if($member->)
    }

    public function presensiKelas($noBook){
        $bookingKelas = booking_kelas::find($noBook);
        $bookingKelas->status_kehadiran = 1;
        $bookingKelas->update();
        self::potongDeposit($noBook);
        return response(['message' => 'Berhasil Presensi','data'=>$bookingKelas]);
    }

    public function absenKelas($noBook, Request $request){
        $bookingKelas = booking_kelas::find($noBook);
        $bookingKelas->status_kehadiran = 0;
        $bookingKelas->update();
        self::potongDeposit($noBook);

        return response(['message' => 'Berhasil Absen','data'=>$bookingKelas]);
    }

}   

// //* Fungsi sebelum store
// public function cekNotKadeluarsa($id){
//     $member = member::find($id);
//     if($member->tgl_kadeluarsa_aktivasi == null || $member->tgl_kadeluarsa_aktivasi < Carbon::now() ){
//         return false;
//     }
//     return true;
// }

// public function cekAlreadyBookingToday($tanggalBooking, $member){
//     // dd($tanggalBooking);
//     $daftarBooking = booking_gym::where('tanggal_booking', $tanggalBooking )->where('id_member',$member)->count();
//     if($daftarBooking == 0){
//         return false;
//     }
//     return true;
// }

// public function cekKuotaIsFull($tanggalSesi , $idSesi){
//     $daftarBooking = booking_gym::where('tanggal_sesi_gym', $tanggalSesi )->where('id_sesi',$idSesi)->count();
//     // $request->tanggal_sesi_gym
//     if($daftarBooking <= 10 ){
//         return true;
//     }
//     return false;
// }

// public function cekBookingSame($tanggalSesi , $idSesi, $idMember){
//     $daftarBooking = booking_gym::where('tanggal_sesi_gym', $tanggalSesi )->where('id_sesi',$idSesi)->where('id_member',$idMember)->count();
    
//     //*Debugging
//     // dd($tanggalSesi,$idSesi, $idMember, $daftarBooking);
    
//     if($daftarBooking == 0 ){
//         //* tidak ada yang sama
//         return false;
//     }
//     //* ada yang sama
//     return true;
// }

// public function index()
// {
//     //
// }
// public function create()
// {
//     //
// }

// public function store(Request $request)
// {
//     //* Cek Status Aktif Member
//     if(!self::cekNotKadeluarsa($request->id_member)){
//         return Response(['message' => 'Akun Anda Sudah Kadeluarsa'],400);
//     }
//     //* Cek  Kuota
//     if(!self::cekKuotaIsFull($request->tanggal_sesi_gym , $request->id_sesi)){
//         return Response(['message' => 'Kuota Telah Penuh'],400);
//     }
//     // self::cekBookingSame(Carbon::today(),1,$request->id_member);
//     //* Cek Apakah Member sudah pernah melakukan booking pada hari yang sama
//     if(self::cekAlreadyBookingToday(Carbon::today(),$request->id_member)){
//         return Response(['message' => 'Anda Telah Melakukan Booking Untuk Hari ini'],400);
//     }
//     //* Cek Apakah Booking Sama
//     if(self::cekBookingSame($request->tanggal_sesi_gym,$request->id_sesi,$request->id_member)){
//         return Response(['message' => 'Anda Telah Melakuakn Booking pada sesi dan tanggal ini'],400);
//     }
//     //* Apakah Member melakukan Booking pada Hari yang sama (Sama kayak diatas tp tidak perlu sesi)

//     try{
//         $booking = booking_gym::create([
//             'id_member' => $request->id_member,
//             'tanggal_booking' => Carbon::now(),
//             'tanggal_sesi_gym' => $request->tanggal_sesi_gym,
//             'id_sesi' => $request->id_sesi,
//         ]);
        
//         return response([
//             'message' => 'Berhasil Booking',
//             'data' => $booking]);
//     }catch(Exception $e){
//         dd($e);
//     }   
// }

// /**
//  * Display the specified resource.
//  *
//  * @param  int  $id
//  * @return \Illuminate\Http\Response
//  */
// public function show($id)
// {
//     //
// }

// /**
//  * Show the form for editing the specified resource.
//  *
//  * @param  int  $id
//  * @return \Illuminate\Http\Response
//  */
// public function edit($id)
// {
//     //
// }

// /**
//  * Update the specified resource in storage.
//  *
//  * @param  \Illuminate\Http\Request  $request
//  * @param  int  $id
//  * @return \Illuminate\Http\Response
//  */
// public function update(Request $request, $id)
// {
//     //
// }

// /**
//  * Remove the specified resource from storage.
//  *
//  * @param  int  $id
//  * @return \Illuminate\Http\Response
//  */
// public function destroy($id)
// {
//     //
// }


// public function showData(Request $request){
//     $bookingGym = booking_gym::where('id_member', $request->id_member)->where('is_canceled', 0)->with(['sesi'])->get();

//     return(response(['data' => $bookingGym]));
// }



// public function cancelBookingGym($noBook){
//     //* Cari Data yang sesuai dengan nomor Booking
//     $bookingGym = booking_gym::find($noBook);
//     //* Cek minimal cancel h-1 Tanggal_Sesi_Gym - 1 
//     $today = Carbon::today();
//     $batasCancel = Carbon::parse($bookingGym->tanggal_sesi_gym)->subDay();
//     if($batasCancel->greaterThanOrEqualTo($today)){
//         // dd($today->toDateString(), $batasCancel->toDateString());
//         // dd($today->gte());
//         //* Ubah is_canceled -> true
//         $bookingGym->is_canceled =  1;
//         $bookingGym->update();
//         //* Response
//         return response(
//             [
//                 'message' => 'Berhasil Membatalkan',
//                 'data' => $bookingGym
//             ]);
//     }else{
//         return response(['message' => 'Tidak bisa membatalkan, maksimal pembatalan H-1'],400);
//     }
// }