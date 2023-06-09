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
    //* Menampilkan member pada kelas tertentu
    public function getMemberKelasByJadwal($jadwal){
        $booking = booking_kelas::where('id_jadwal_harian', $jadwal)->where('is_canceled', 0 )->with(['member','jadwal_harian'])->get();

        return response(['data' => $booking]);
    }

    public function presensiKelas($noBook){
        $bookingKelas = booking_kelas::find($noBook);
        $bookingKelas->status_kehadiran = 1;
        $bookingKelas->waktu_presensi = Carbon::now();
        $bookingKelas->update();
        self::potongDeposit($noBook);
        return response(['message' => 'Berhasil Presensi','data'=>$bookingKelas]);
    }

    public function absenKelas($noBook){
        $bookingKelas = booking_kelas::find($noBook);
        $bookingKelas->status_kehadiran = 0;
        $bookingKelas->update();
        self::potongDeposit($noBook);

        return response(['message' => 'Berhasil Absen','data'=>$bookingKelas]);
    }


    //TODO : Cek Saldo dan Jenis Kelas Saldo
    //* Saat dipresensi (tandai sebagai hadir/tidak hadir deposit dipotong )
    public function potongDeposit($noBook){
        $bookingKelas = booking_kelas::with(['jadwal_harian','jadwal_harian.jadwal_umum','jadwal_harian.jadwal_umum.kelas'])->find($noBook);
        $kelas = $bookingKelas->jadwal_harian->jadwal_umum->kelas;
        $member = member::find($bookingKelas->id_member);
        if($member->total_deposit_paket != null && $member->total_deposit_paket > 0){
            // if($kelas->id_kelas )
            $member->total_deposit_paket -= 1;
        //* tidak perlu cek uang dia lebih dari 200 ?
        }else {
            $member->total_deposit_uang -= $kelas->harga_kelas;
        }
        $member->update();
        //* total deposit uang, total deposit paket
        // if($member->)
    }


    //! ubah konteksnya dari booking gym menajdi booking kelas 
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
             
             return response([
                 'message' => 'Berhasil Booking',
                 'data' => $booking]);
         }catch(Exception $e){
             dd($e);
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
