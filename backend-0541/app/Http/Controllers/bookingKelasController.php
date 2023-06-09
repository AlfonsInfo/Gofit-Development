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
}   
