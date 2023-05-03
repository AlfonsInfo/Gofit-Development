<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User\pengguna;
use App\Models\User\instruktur;
use App\Models\User\pegawai;
use App\Models\User\member;
use App\Models\promo;
use App\Models\sesi_gym;
use App\Models\kelas;
use App\Models\transaksi_member;
use App\Models\transaksi_aktivasi;
use App\Models\transaksi_deposit_reguler;
use App\Models\transaksi_deposit_paket;
use App\Models\jadwal_harian;
use App\Models\presensi_instruktur;
use App\Models\booking_gym;
use App\Models\booking_kelas;
use App\Models\ijin_instruktur;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// import jadwal;

class DatabaseSeeder extends Seeder
{
    public function run()
    {

        function createPengguna($params)
        {
            pengguna::create([
                'username' => $params[0],
                'password' => bcrypt('0541'),
                'role' => $params[1]
            ]);

        }

        //*id_member,nama_member,tgl_lahir_member,no_telp_member,tgl_kadeluarsa_aktivasi, total_deposit_uang,total_deposit_paket
        function createMember($pengguna,$params,$foreign)
        {
            createPengguna([$pengguna[0],$pengguna[1]]);
            member::create([
                'nama_member' => $params[0],
                'id_pengguna' => $foreign,
                'tgl_lahir_member' => date("Y-m-d H:i:s",strtotime($params[1])),
                'no_telp_member' => $params[2],
                'tgl_kadeluarsa_aktivasi' => date("Y-m-d H:i:s",strtotime('+1 year')),
                // 'total_deposit_uang' => 0,
                // 'total_deposit_paket' => 0,
            ]);
        }

        function createInstruktur($pengguna,$params, $foreign){
            createPengguna([$pengguna[0],$pengguna[1]]);
            instruktur::create([
                'id_instruktur' => $params[0],
                'id_pengguna' => $foreign,
                'nama_instruktur' => $params[1],
                'alamat_instruktur' => $params[2],
                'no_telp_instruktur' => $params[3],
            ]);
        }
        function createPegawai($pengguna,$params, $foreign){
            //* id pegawai, nama pegawai, jabatan, tgl lahir, no telp, alamat 
            createPengguna([$pengguna[0],$pengguna[1]]);
            Pegawai::create([
                'id_pegawai' => $params[0],
                'id_pengguna' => $foreign,
                'nama_pegawai' => $params[1],
                'jabatan_pegawai' => $params[2],
                'tgl_lahir_pegawai' => date("Y-m-d H:i:s",strtotime($params[3])),
                'no_telp_pegawai' => $params[4],
                'alamat_pegawai' => $params[5],
            ]);
        }

        function createPromo($params){
            promo::create([
                'jenis_promo' => $params[0],
                'minimal_deposit' => $params[1],
                'bonus_promo' => $params[2],
                'masa_berlaku' => $params[3],
            ]);
        }

        function createKelas($params)
        {
            kelas::create([
                'jenis_kelas' => $params[0],
                'harga_kelas' => $params[1],
                'deskripsi_kelas' => $params[2],
        ]);
        }

        function createSesiGym($params){
                sesi_gym::create([
                    'waktu_mulai' => $params[0],//date("h:i",strtotime($params[1])),
                    'waktu_selesai' => $params[1]//date("h:i",strtotime($params[2])),
                ]);
        }
        
        function createTransaksiMember($jenis,$pegawai,$member)
        {
            transaksi_member::create([
                'jenis_transaksi' => $jenis,
                'id_pegawai' => $pegawai,
                'id_member' => $member
            ]);
        }

        function createAktivasi($jenis,$pegawai,$member,$nostruk,$tanggalAktivasi)
        {
            createTransaksiMember($jenis, $pegawai, $member);
            // $randomstringMonth = rand(0,1) ? '2 month ago' : '3 month ago';
            transaksi_aktivasi::create([
                'tanggal_aktivasi' => date("Y-m-d H:i:s",strtotime($tanggalAktivasi)),
                // 'nominal_transaksi' => $params,
                'no_struk' => $nostruk
            ]);
        }

        function createDepositReguler($jenis,$pegawai, $member, $nominalDeposit,$nominalTotal,$promo,$struk)
        {
            createTransaksiMember($jenis, $pegawai, $member);
            transaksi_deposit_reguler::create([
                'nominal_deposit'=>$nominalDeposit,
                'nominal_total' => $nominalTotal,
                'id_promo' => $promo,
                'no_struk' => $struk
            ]);
        }

        function createDepositPaket($jenis,$pegawai,$member,$params,$promo,$struk,$kelas)
        {
            createTransaksiMember($jenis,$pegawai,$member);
            transaksi_deposit_paket::create([
                'nominal_deposit_kelas'=>$params[0],
                'nominal_uang' => $params[1],
                'tanggal_kadeluarsa' => date("Y-m-d H:i:s",strtotime($params[2])),
                'id_promo' => $promo,
                'no_struk' => $struk,
                'id_kelas' => $kelas
                
            ]);
        }

    
        function presensiInstruktur($mulai,$selesai,$status,$instruktur,$jadwalharian){
            presensi_instruktur::create([
                'waktu_presensi'=> date("Y-m-d H:i:s",strtotime($mulai)),
                'waktu_selesai' => date("Y-m-d H:i:s",strtotime($selesai)),
                'status_presensi' => $status,
                'id_instruktur' => $instruktur,
                'id_jadwal_harian' => $jadwalharian
            ]);

        }

        function createBookingGym($tanggalbooking, $statuskehadiran = false , $sesi, $member, $struk = null,$tanggalSesiGym)
        {
            booking_gym::create([
                'tanggal_booking' => date("Y-m-d H:i:s",strtotime($tanggalbooking)),
                'tanggal_sesi_gym' => date("Y/m/d",strtotime($tanggalSesiGym)) ,
                'status_kehadiran' => $statuskehadiran,
                'id_sesi' => $sesi,
                'id_member' => $member,
                'no_struk' => $struk  
            ]);
        }
        function createBookingKelas($tanggalbooking, $statuskehadiran = false, $kelasjadwal, $member, $struk = null)
        {
            booking_kelas::create([
                'tanggal_booking' => date("Y-m-d H:i:s",strtotime($tanggalbooking)),
                'status_kehadiran' => $statuskehadiran,
                'id_kelas_jadwal' => $kelasjadwal,
                'id_member' => $member,
                'no_struk' => $struk  
            ]);
        }

        function createIjin($status,$tanggal,$instruktur,$instrukturPengganti,$kelasjadwal)
        {
            ijin_instruktur::create([
                'status_ijin' => $status,
                'tanggal' => date("Y/m/d",strtotime($tanggal)),
                'id_instruktur' => $instruktur,
                'id_instruktur_pengganti' => $instrukturPengganti,
                'id_kelas_jadwal' => $kelasjadwal
            ]);
        }


        //*Detail Data Member
        //*nama_member,tgl_lahir_member,no_telp_member,tgl_kadeluarsa_aktivasi, total_deposit_uang,total_deposit_paket
        createMember(['alfonsus','member'],['Alfonsus Setiawan Jacub','21-05-2002','082284990864'],1);
        createMember(['ucup_surucup','member'],['Ucup Surucup','21-05-2000','0821232314214'],2);
        createMember(['udin_saprudin','member'],['Udin Saprudin','21-05-2003','0821232314214'],3);
        createMember(['faizah_nugraha','member'],['Faizah Nugraha','21-05-2001','082123231111'],4);
        createMember(['nadya','member'],['Nadya','13-05-2000','082123231111'],5);
        createMember(['henry','member'],['Henri Teja','13-05-2002','0821231311/11'],6);

        //* Detail data instruktur
        createInstruktur(['Alfonsus','instruktur'],['ins-1','Alfonsus Setiawan J - Instruktur','Yadara Blok 27 Yogya','0828332813213'],7);
        createInstruktur(['JK','instruktur'],['ins-2','JK Bagaskara','Bekasi','+62 894-2212-919'],8);
        createInstruktur(['Lisa','instruktur'],['ins-3','Lisa Blackpink','Amarta no 4Y,Condong Catur, Jogja','+62 874-3379-57385'],9);
        createInstruktur(['Hobby','instruktur'],['ins-4','Hobby Sanjaya','Amarta no 6Y,Condong Catur, Jogja','+62 815-2075-864'],10);
        createInstruktur(['V','instruktur'],['ins-5','Veeee Putra','Amarta no 7Y,Condong Catur, Jogja','+62 853-8762-203'],11);
        createInstruktur(['Jenny','instruktur'],['ins-6','Jenny Mullen','Amarta no 3Y,Condong Catur, Jogja','+62 856-6734-887'],12);
        createInstruktur(['Suga','instruktur'],['ins-7','Suga Yudhistira','Amarta no 1Y,Condong Catur, Jogja','+62 825-8689-211'],13);
        createInstruktur(['Jin','instruktur'],['ins-8','Jin Winoto','Amarta no 42Y,Condong Catur, Jogja','+62 821-7559-145'],14);
        createInstruktur(['Jiso','instruktur'],['ins-9','Kim Ji Soo','Amarta no 41Y,Condong Catur, Jogja','+62 858-436-596'],15);
        createInstruktur(['Jimin','instruktur'],['ins-10','Park Jiminnn','Amarta no 14Y,Condong Catur, Jogja','+62 880-0828-3863'],16);
        createInstruktur(['Rose','instruktur'],['ins-11','Rosieee Rose','Amarta no 21Y,Condong Catur, Jogja','+62 880-021-0002'],17);
        createInstruktur(['Jessi','instruktur'],['ins-12','Jessii','Amarta no 21Y,Condong Catur, Jogja','+62 880-021-0002'],18);
        // createInstruktur(['Lisa','instruktur'],['ins-11','Lisa Lalisa','Amarta no 34Y,Condong Catur, Jogja','+62 893-0244-83650'],17);
        // createInstruktur(['JK','instruktur'],['ins-12','JK Rowling','Amarta no 14Y,Condong Catur, Jogja','+62 824-3239-54991'],18);

        //*Detail Data pegawai
        //* id pegawai, nama pegawai, jabatan, tgl lahir, no telp, alamat 
        createPegawai(['admin','pegawai'],['P01','Alfonsus Setiawan J - Pegawai','Admin','21-03-1995','08123456789','Tambak Bayan no 41 Yogya'],19);
        createPegawai(['admin_ganteng1','pegawai'],['P02','Mamang','Admin','22-01-1996','08213232321','Tambak Bayan no 42 Yogya'],20);
        createPegawai(['mo_ganteng1','pegawai'],['P03','Adee','MO','22-01-1998',20,'0811123232321','Tambak Bayan no 41 Yogya'],21);
        createPegawai(['Yunita','pegawai'],['P04','Yunita','kasir','21-01-2000','082132133213','Seturan no 42 Yogya'],22);
        createPegawai(['Putri','pegawai'],['P05','Putri','kasir','23-05-2003','08212121312','Tambak Boyo no 42 Yogya'],23);
        createPegawai(['Yuna','pegawai'],['P06','Yuna','kasir','24-03-2001','085398244443','Sergodadi no 42 Yogya'],24);    
        createMember(['Bambang','member'],['Bambang Teja','13-05-2002','0821231311/11'],25);
        createMember(['Tono','member'],['Tono Teja','13-05-2002','0821231311/11'],26);
        createMember(['Adi','member'],['Adi Teja','13-05-2002','0821231311/11'],26);


        //! DUMMY PROMO
        //*jenis,minimal,bonus,masa berlaku
        createPromo(['promo_reguler',3000000,300000,null]);
        createPromo(['promo_paket1',5,1,1]);
        createPromo(['promo_paket2',10,3,2]);       

        //! DUMMY SESI GYM
        createSesiGym([ "7:00","9:00"]);
        createSesiGym([ "9:00","11:00"]);
        createSesiGym([ "11:00","13:00"]);
        createSesiGym([ "13:00","15:00"]);
        createSesiGym([ "15:00","17:00"]);
        createSesiGym([ "17:00","19:00"]);
        createSesiGym([ "19:00","21:00"]);

        //! DUMMY KELAS
        //* Dummy kelas pagi
        createKelas(['SPINE Corrector',150000,"-"]); //* Kelas Joon
        createKelas(['MUAYTHAI',150000,"-"]); //* Kelas JK
        createKelas(['PILATES',150000, "-"]); //* Kelas Lisa
        createKelas(['ASTHANGA',150000,"-"]); //* Kelas Hobby
        createKelas(['Body Combat',150000,"-"]); //*Kelas Vee Putra
        createKelas(['Zumba',150000,"-"]); //*Kelas Jenny Mullen
        createKelas(['Suga',150000,"-"]); //*Kelas Suga
        createKelas(['Wall Swing',150000,"-"]); //*Rosiee
        createKelas(['Basic Swing',150000,"-"]); //*Jin
        createKelas(['HATHA',150000,"-"]); //*Kelas Jin
        createKelas(['Bellydance',150000,"-"]); //*Kelas Jisoo
        createKelas(['BUNGEE',200000,"-"]); //*Kelas jimin
        createKelas(['Yogalates',150000,"-"]); //*Kelas jimin
        createKelas(['BOXING',150000,"-"]); //*Kelas jimin
        createKelas(['Calistenic',150000,"-"]); //*Kelas joon
        //* Dummy kelas malam
        createKelas(['Pound Fit',150000,"-"]);
        createKelas(['Trampoline Workout',200000,"-"]);
        createKelas(['Yoga For Kids',150000,"-"]);
        createKelas(['ABS Pilates',150000,"-"]);
        createKelas(['Swing For Kids',150000,"-"]);
        // createKelas(['Bellydance',150000,"-"],'ins-9');
        // createKelas(['Calisthenic',150000,"-"],'ins-1');
        
        //!Badminton
        $this->call([
            jadwal::class
        ]);

        //* transaksi dan booking
        createAktivasi('transaksi-aktivasi','P01','23.04.001','23.04.001','2 month ago');
        createAktivasi('transaksi-aktivasi','P02','23.04.002','23.04.002','2 month ago');
        createAktivasi('transaksi-aktivasi','P02','23.04.003','23.04.003','2 month ago');
        createAktivasi('transaksi-aktivasi','P02','23.04.004','23.04.004','2 month ago');
        createDepositReguler('transaksi-deposit-reguler','P02','23.04.001',4000000,4300000,1,'23.04.005');
        createDepositReguler('transaksi-deposit-reguler','P01','23.04.001',4000000,4300000,1,'23.04.006');
        createDepositPaket('transaksi-deposit-paket','P03','23.04.002',[6,750000,'next month'],2,'23.04.007',2);
        createDepositPaket('transaksi-deposit-paket','P03','23.04.003',[6,750000,'next month'],2,'23.04.008',2);
        createDepositPaket('transaksi-deposit-paket','P03','23.04.004',[6,750000,'next month'],2,'23.04.009',2);
        createDepositPaket('transaksi-deposit-paket','P03','23.04.005',[6,750000,'next month'],2,'23.04.010',2);
        createAktivasi('transaksi-aktivasi','P03','23.04.005','23.04.011','1 week ago');
        createAktivasi('transaksi-aktivasi','P01','23.04.006','23.04.012','1 week ago');
        createTransaksiMember('transaksi-booking-gym','P03','23.04.001'); //23.04.013
        createTransaksiMember('transaksi-booking-gym','P03','23.04.002'); //23.04.014
        createTransaksiMember('transaksi-booking-gym','P03','23.04.003'); //23.04.015
        createTransaksiMember('transaksi-booking-gym','P03','23.04.005'); //23.04.016
        createTransaksiMember('transaksi-booking-gym','P03','23.04.006'); //23.04.017
        createTransaksiMember('transaksi-booking-gym','P03','23.04.001'); //23.04.018
        createTransaksiMember('transaksi-booking-gym','P03','23.04.002'); //23.04.019
        createTransaksiMember('transaksi-booking-gym','P03','23.04.003'); //23.04.020
        // createTransaksiMember('transaksi-booking-gym','P03','23.04.004'); //23.04.018
        // createAktivasi('transaksi-aktivasi','P04','23.04.007',);
        createAktivasi('transaksi-aktivasi','P03','23.04.007','23.04.021','3 days ago');
        createAktivasi('transaksi-aktivasi','P01','23.04.008','23.04.022', '3 days ago');
        createDepositReguler('transaksi-deposit-reguler','P02','23.04.007',4000000,4300000,1,'23.04.023');
        createDepositReguler('transaksi-deposit-reguler','P01','23.04.008',4000000,4300000,1,'23.04.024');
        //*Transaksi booking sesi
        createTransaksiMember('transaksi-booking-kelas','P01','23.04.001');
        createTransaksiMember('transaksi-booking-kelas','P01','23.04.002');
        createTransaksiMember('transaksi-booking-kelas','P01','23.04.003');
        createTransaksiMember('transaksi-booking-kelas','P01','23.04.004');
        createTransaksiMember('transaksi-booking-kelas','P01','23.04.005');
        createTransaksiMember('transaksi-booking-kelas','P01','23.04.006');
        //*30
        createTransaksiMember('transaksi-booking-kelas','P01','23.04.001');
        createTransaksiMember('transaksi-booking-kelas','P01','23.04.001');
        booking_gym::create([
            'tanggal_booking' => date("2023-03-02"),
            'tanggal_sesi_gym' =>  date("2023-03-05"),
            'status_kehadiran' => true,
            'id_sesi' => 1,
            'id_member' => "23.04.001",
            'no_struk' => "23.04.013"
        ]);
        booking_gym::create([
            'tanggal_booking' => date("2023-03-02"),
            'tanggal_sesi_gym' =>  date("2023-03-05"),
            'status_kehadiran' => true,
            'id_sesi' => 1,
            'id_member' => "23.04.002",
            'no_struk' => "23.04.014"
        ]);
        booking_gym::create([
            'tanggal_booking' => date("2023-03-02"),
            'tanggal_sesi_gym' =>  date("2023-03-05"),
            'status_kehadiran' => true,
            'id_sesi' => 1,
            'id_member' => "23.04.003",
            'no_struk' => "23.04.015"
        ]);
        booking_gym::create([
            'tanggal_booking' => date("2023-03-03"),
            'tanggal_sesi_gym' =>  date("2023-03-05"),
            'status_kehadiran' => false,
            'id_sesi' => 1,
            'id_member' => "23.04.004",
            'no_struk' => null
        ]);
        booking_gym::create([
            'tanggal_booking' => date("2023-03-03"),
            'tanggal_sesi_gym' =>  date("2023-03-05"),
            'status_kehadiran' => false,
            'id_sesi' => 1,
            'id_member' => "23.04.005",
            'no_struk' => null
        ]);
        booking_gym::create([
            'tanggal_booking' => date("2023-03-04"),
            'tanggal_sesi_gym' =>  date("2023-03-05"),
            'status_kehadiran' => true,
            'id_sesi' => 1,
            'id_member' => "23.04.006",
            'no_struk' => "23.04.016"
        ]);
        //* booking lain
        booking_gym::create([
            'tanggal_booking' => date("2023-03-05"),
            'tanggal_sesi_gym' =>  date("2023-03-10"),
            'status_kehadiran' => true,
            'id_sesi' => 3,
            'id_member' => "23.04.001",
            'no_struk' => "23.04.017"
        ]);
        booking_gym::create([
            'tanggal_booking' => date("2023-03-05"),
            'tanggal_sesi_gym' =>  date("2023-03-10"),
            'status_kehadiran' => true,
            'id_sesi' => 3,
            'id_member' => "23.04.002",
            'no_struk' => "23.04.018"
        ]);
        booking_gym::create([
            'tanggal_booking' => date("2023-03-05"),
            'tanggal_sesi_gym' =>  date("2023-03-10"),
            'status_kehadiran' => true,
            'id_sesi' => 3,
            'id_member' => "23.04.003",
            'no_struk' => "23.04.019"
        ]);
        booking_gym::create([
            'tanggal_booking' => date("2023-03-05"),
            'tanggal_sesi_gym' =>  date("2023-03-10"),
            'status_kehadiran' => false,
            'id_sesi' => 3,
            'id_member' => "23.04.004",
            'no_struk' => null
        ]);
        booking_gym::create([
            'tanggal_booking' => date("2023-03-05"),
            'tanggal_sesi_gym' =>  date("2023-03-10"),
            'status_kehadiran' => false,
            'id_sesi' => 3,
            'id_member' => "23.04.005",
            'no_struk' => null
        ]);
        booking_gym::create([
            'tanggal_booking' => date("2023-03-05"),
            'tanggal_sesi_gym' =>  date("2023-03-10"),
            'status_kehadiran' => false,
            'id_sesi' => 3,
            'id_member' => "23.04.006",
            'no_struk' => null
        ]);
        //*25
        booking_kelas::create([
            'tanggal_booking' => date("2023-02-02"),
            'status_kehadiran' => true,
            'id_jadwal_harian' => 1,
            'id_member' => "23.04.001",
            'no_struk' => '23.04.025'  
        ]);
        booking_kelas::create([
            'tanggal_booking' => date("2023-02-02"),
            'status_kehadiran' => true,
            'id_jadwal_harian' => 1,
            'id_member' => "23.04.002",
            'no_struk' => '23.04.026'  
        ]);
        booking_kelas::create([
            'tanggal_booking' => date("2023-02-02"),
            'status_kehadiran' => true,
            'id_jadwal_harian' => 1,
            'id_member' => "23.04.003",
            'no_struk' => '23.04.027'  
        ]);
        booking_kelas::create([
            'tanggal_booking' => date("2023-02-28"),
            'status_kehadiran' => true,
            'id_jadwal_harian' => 1,
            'id_member' => "23.04.004",
            'no_struk' => '23.04.028'  
        ]);
        booking_kelas::create([
            'tanggal_booking' => date("2023-02-02"),
            'status_kehadiran' => true,
            'id_jadwal_harian' => 1,
            'id_member' => "23.04.005",
            'no_struk' => '23.04.029'  
        ]);
        booking_kelas::create([
            'tanggal_booking' => date("2023-02-02"),
            'status_kehadiran' => true,
            'id_jadwal_harian' => 1,
            'id_member' => "23.04.006",
            'no_struk' => '23.04.030'  
        ]);
        booking_kelas::create([
            'tanggal_booking' => date("2023-02-02"),
            'status_kehadiran' => true,
            'id_jadwal_harian' => 2,
            'id_member' => "23.04.006",
            'no_struk' => '23.04.030'  
        ]);
        booking_kelas::create([
            'tanggal_booking' => date("2023-02-02"),
            'status_kehadiran' => true,
            'id_jadwal_harian' => 3,
            'id_member' => "23.04.006",
            'no_struk' => '23.04.030'  
        ]);
        booking_kelas::create([
            'tanggal_booking' => date("2023-02-02"),
            'status_kehadiran' => true,
            'id_jadwal_harian' => 5,
            'id_member' => "23.04.006",
            'no_struk' => '23.04.030'  
        ]);
        booking_kelas::create([
            'tanggal_booking' => date("2023-02-02"),
            'status_kehadiran' => true,
            'id_jadwal_harian' => 6,
            'id_member' => "23.04.006",
            'no_struk' => '23.04.030'  
        ]);
        //* jadwal lain

        //!
        for($jadwalharian_id = 1 ; $jadwalharian_id<150;$jadwalharian_id++)
        {
            $jadwalharian = jadwal_harian::latest()
            ->where('id_jadwal_harian',$jadwalharian_id)
            ->with(['jadwal_umum'])
            ->get()
            ->first();
        // system("echo ".$jadwalharian->jadwal_umum->id_instruktur);

            if($jadwalharian->status == "Instruktur Pengganti"){
                $instrukturId = $jadwalharian->jadwal_umum->id_instruktur;
                $tanggalPengajuan = $jadwalharian->tanggal_jadwal_harian;
                        system("echo ".$tanggalPengajuan);

                ijin_instruktur::create([
                    "id_jadwal_harian" => $jadwalharian->id_jadwal_harian,
                    "status_ijin" => "dikonfirmasi",
                    "tanggal_pengajuan" => date('Y-m-d', strtotime('-2 days', strtotime($tanggalPengajuan))),
                    "id_instruktur" => $instrukturId,
                    "id_instruktur_pengganti" => 'ins-1'
                ]);
                // system("echo ".$instrukturId);               
            }
        }
       
    //!Presensi instruktur
        //Presensi
        for($presensiInstruktur_id = 1;$presensiInstruktur_id<=150;$presensiInstruktur_id++){
            $jadwalharian = DB::table('jadwal_harian')->where('id_jadwal_harian',$presensiInstruktur_id)->get()->first();
            // system("echo ".$jadwalharian->status);
            if($jadwalharian->status == "Diliburkan"){
                continue;
            }
            $jadwalUmum = DB::table('jadwal_umum')->where('id_jadwal_umum', $jadwalharian->id_jadwal_umum)->get()->first();
            $instruktur = $jadwalUmum->id_instruktur;
        
            if($jadwalharian->status == "Instruktur Pengganti")
            {
                $izinInstruktur = DB::table('ijin_instruktur')->where('id_jadwal_harian',$presensiInstruktur_id)->get()->first();
                $instruktur = $izinInstruktur->id_instruktur_pengganti;
            }
            $rand = rand(1,10);
            if($rand <= 7){
                $controlledRandMasukTime = rand(-15,0);
            }else{
                $controlledRandMasukTime = rand(1,30);
            }

            $masukTime = Carbon::parse($jadwalUmum->jam_mulai)->subMinutes($controlledRandMasukTime);
            $selesaiTime = Carbon::parse($jadwalUmum->jam_mulai)->addHours(2)->subMinutes(rand(-30, 15));

            
            DB::table('presensi_instruktur')->insert([[
                'id_instruktur' => $instruktur,
                'id_jadwal_harian' => $presensiInstruktur_id,
                'status_presensi' => 'hadir',
                'waktu_presensi' => $masukTime, //$masukTime,
                'waktu_selesai' => $selesaiTime ]//, $selesaiTime ],
                ]);
            }
            
            // $jadwalharian->
        // / presensiInstruktur("27-02-2023 08:00:00","27-02-2023 09:00:00", "hadir","ins-1",1);
        // presensiInstruktur("27-02-2023 09:31:00","27-02-2023 09:00:00", "hadir","ins-2",2);
        // presensiInstruktur("28-02-2023 08:00:00","28-02-2023 09:00:00", "hadir","ins-3",3);
        // presensiInstruktur("28-02-2023 09:32:00","28-02-2023 09:00:00", "hadir","ins-4",4);
        // presensiInstruktur("01-03-2023 08:10:00","01-03-2023 09:00:00", "hadir","ins-5",5);
        // presensiInstruktur("01-03-2023 07:00:00","01-03-2023 09:00:00", "hadir","ins-6",6);
        // presensiInstruktur("02-03-2023 08:20:00","2023-03-02 09:00:00", "hadir", "ins-11",8);
        // presensiInstruktur("02-03-2023 9:20:00","2023-03-02 09:00:00", "hadir", "ins-8",9);
        // //*literasi 2
        // presensiInstruktur("06-03-2023 08:00:00","06-03-2023 09:00:00", "hadir","ins-1",1);
        // presensiInstruktur("06-03-2023 09:31:00","06-03-2023 09:00:00", "hadir","ins-2",2);
        // presensiInstruktur("07-03-2023 08:00:00","07-03-2023 09:00:00", "hadir","ins-3",3);
        // presensiInstruktur("07-03-2023 09:32:00","28-02-2023 09:00:00", "hadir","ins-4",4);
        // presensiInstruktur("08-03-2023 08:10:00","08-03-2023 09:00:00", "hadir","ins-5",5);
        // presensiInstruktur("08-03-2023 07:00:00","01-03-2023 09:00:00", "hadir","ins-6",6);
        // presensiInstruktur("02-03-2023 08:20:00","2023-03-02 09:00:00", "hadir", "ins-11",8);
        // presensiInstruktur("02-03-2023 9:20:00","2023-03-02 09:00:00", "hadir", "ins-8",9);
        // createJadwalHarian(['kamis','8:00','9:00','ins-11',8],"02-03-2023",8,true);
        // createJadwalHarian(['kamis','9:30','10:30','ins-8',9],"02-03-2023",9,true);
        // createJadwalHarian(['jumat','8:00','9:00','ins-9',10],"03-03-2023",10,true);
        // createJadwalHarian(['jumat','9:30','10:30','ins-9',11],"03-03-2023",11,true);
        // createJadwalHarian(['sabtu','8:00','10:00','ins-10',12],"04-03-2023",12,true);
        // createJadwalHarian(['sabtu','9:30','10:30','ins-3',13],"04-03-2023",13,true);
        // createJadwalHarian(['sabtu','9:30','10:30','ins-2',14],"04-03-2023",14,true);
        // createJadwalHarian(['minggu','9:00','10:00','ins-1',15],"05-03-2023",15,true);
        
        
        // createBookingGym("28-03-2023",TRUE,1,"23.04.001","23.04.004");
        
        



        }

}

