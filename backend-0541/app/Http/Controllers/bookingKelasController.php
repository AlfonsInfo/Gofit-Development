<?php

namespace App\Http\Controllers;

use App\Models\booking_gym;
use App\Models\booking_kelas;
use App\Models\jadwal_harian;
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

        //* Cek Saldo Member
        // dd(self::cekSaldoMember($request->id_member, $request->id_jadwal_harian));
        $deposit = self::cekSaldoMember($request->id_member, $request->id_jadwal_harian);
        if( $deposit == false){
            return Response(['message' => 'Saldo Anda Tidak Cukup'],400);
        }

         //* Cek  Kuota
        if(!self::cekKuotaIsFull($request->id_jadwal_harian )){
            return Response(['message' => 'Kuota Telah Penuh'],400);
        }
    
         //* Cek Apakah Booking Sama
         if(self::cekBookingSame($request->id_jadwal_harian ,$request->id_member)){
             return Response(['message' => 'Anda Telah Melakuakn Booking yang sama '],400);
         }
         //* Apakah Member melakukan Booking pada Hari yang sama (Sama kayak diatas tp tidak perlu sesi)

        try{
            $booking = booking_kelas::create([
                'id_member' => $request->id_member,
                'tanggal_booking' => Carbon::now(),
                'is_canceled' => 0,
                'metode_pembayaran' => $deposit,
                'id_jadwal_harian' => $request->id_jadwal_harian

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

    public function cekKuotaIsFull($idjadwalharian){
        $daftarBooking = booking_kelas::where('id_jadwal_harian',$idjadwalharian )->count();
        if($daftarBooking < 10 ){
            return true;
        }
        return false;
    }

    public function cekSaldoMember($id, $idjadwalharian){
        //* Ambil Data Member dan jadwal harian(kelas)
        $member = member::find($id);
        $jadwalharian = jadwal_harian::where('id_jadwal_harian',$idjadwalharian)->with(['jadwal_umum'])->get();

        //* Cek dia punya saldo depo paket yang sesuai atau tidak, jika ada , masuk ke depo paket (di Member)
        if($member->id_kelas == $jadwalharian[0]->jadwal_umum->kelas->id_kelas){
            $saldoPaket = $member->total_deposit_paket;
            $jumlahSatuanBooking = booking_kelas::where('id_member',$id)
            ->where('metode_pembayaran','Deposit Paket')
            ->where('is_canceled',0)
            ->where('status_kehadiran',0)
            ->count();
            if($saldoPaket > $jumlahSatuanBooking){
                return 'Deposit Paket';
            }
        }else if($member->total_deposit_uang > 0){
            return 'Deposit Reguler';
            $uangMember = $member->total_deposit_uang;
            $jumlahUangBooking = booking_kelas::where('id_member',$id)
            ->where('metode_pembayaran','Deposit Reguler')
            ->where('is_canceled',0)
            ->where('status_kehadiran',0)
            ->get();
            // ->;
        }else{
            return false;
        }
            //* Depo paket -> cek lagi jumlah bookingnya cukup atau engga
            //* Cek Saldo uang 
            //* Cek Sisa Saldonya > foreach booking kelas (is_canceled) * 

    }

    public function cekBookingSame($idjadwalharian , $idMember){
        $daftarBooking = booking_kelas::where('id_jadwal_harian', $idjadwalharian )->where('id_member',$idMember)->count();        
        if($daftarBooking == 0 ){
            //* tidak ada yang sama
            return false;
        }
        //* ada yang sama
        return true;
    }
}   
