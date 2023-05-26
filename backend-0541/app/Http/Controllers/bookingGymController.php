<?php

namespace App\Http\Controllers;

use App\Models\booking_gym;
use App\Models\User\member;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;
use App\Models\transaksi_deposit_paket;

class bookingGymController extends Controller
{

    //* Fungsi Utama Fungsionalitas
    public function store(Request $request)
    {
        //* Cek Status Aktif Member
        if(!self::cekNotKadeluarsa($request->id_member)){
            return Response(['message' => 'Akun Anda Sudah Kadeluarsa'],400);
        }
        //* Cek  Kuota
        if(!self::cekKuotaIsFull($request->tanggal_sesi_gym , $request->id_sesi)){
            return Response(['message' => 'Kuota Telah Penuh'],400);
        }
        
        //* Cek Apakah Booking Sama
        if(self::cekBookingSame($request->tanggal_sesi_gym,$request->id_sesi,$request->id_member)){
            return Response(['message' => 'Anda Telah Melakuakn Booking pada sesi dan tanggal ini'],400);
        }
        //* Apakah Member melakukan Booking pada Hari yang sama (Sama kayak diatas tp tidak perlu sesi)

        try{
            $booking = booking_gym::create([
                'id_member' => $request->id_member,
                'tanggal_booking' => Carbon::now(),
                'tanggal_sesi_gym' => $request->tanggal_sesi_gym,
                'id_sesi' => $request->id_sesi,
            ]);
            
            //! Catat Log Booking
            riwayatMemberController::storeHistory($request->id_member,'Booking Gym Member',null,$booking->no_booking);
            return response([
                'message' => 'Berhasil Booking',
                'data' => $booking]);
        }catch(Exception $e){
            dd($e);
        }   
    }


    //* Fungsi Utama Fungsionalitas
    //* Tampil Data Booking yang tidak dibatalkan (Sesuai member yang login )
    public function showData(Request $request){
        //* 1 Minggu terakhir + 
        $bookingGym = booking_gym::where('id_member', $request->id_member)
        ->where('is_canceled', 0)
        ->whereBetween('tanggal_booking', [Carbon::now()->subWeek(), Carbon::now()])
        ->whereDate('tanggal_sesi_gym', '>=', Carbon::today())
        ->with(['sesi'])->get();

        return(response(['data' => $bookingGym]));
    }

    //* Fungsi Utama Fungsionalitas
    //* Untuk Fungsionalitas Batal Booking
    public function cancelBookingGym($noBook){
        //* Cari Data yang sesuai dengan nomor Booking
        $bookingGym = booking_gym::find($noBook);
        //* Cek minimal cancel h-1 Tanggal_Sesi_Gym - 1 
        $today = Carbon::today();
        $batasCancel = Carbon::parse($bookingGym->tanggal_sesi_gym)->subDay();
        if($batasCancel->greaterThanOrEqualTo($today)){
            //* Ubah is_canceled -> true ( stand for booking gym already canceled)
            $bookingGym->is_canceled =  1;
            $bookingGym->update();
            //* Response
            return response(
                [
                    'message' => 'Berhasil Membatalkan',
                    'data' => $bookingGym
                ]);
        }else{
            return response(['message' => 'Tidak bisa membatalkan, maksimal pembatalan H-1'],400);
        }
    }

    //* Fungsi Validasi-validasi yang digunakan pada Store Data
    //* Fungsi sebelum store
    public function cekNotKadeluarsa($id){
        $member = member::find($id);
        if($member->tgl_kadeluarsa_aktivasi == null || $member->tgl_kadeluarsa_aktivasi < Carbon::now() ){
            return false;
        }
        return true;
    }

    public function cekKuotaIsFull($tanggalSesi , $idSesi){
        $daftarBooking = booking_gym::where('tanggal_sesi_gym', $tanggalSesi )->where('id_sesi',$idSesi)->count();
        if($daftarBooking < 10 ){
            return true;
        }
        return false;
    }

    public function cekBookingSame($tanggalSesi , $idSesi, $idMember){
        $daftarBooking = booking_gym::where('tanggal_sesi_gym', $tanggalSesi )->where('id_sesi',$idSesi)->where('id_member',$idMember)->count();        
        if($daftarBooking == 0 ){
            //* tidak ada yang sama
            return false;
        }
        //* ada yang sama
        return true;
    }

}
