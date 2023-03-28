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
use App\Models\jadwal_umum;
use App\Models\jadwal_harian;
use App\Models\kelas_jadwal;
use App\Models\presensi_instruktur;
use App\Models\booking_gym;
use App\Models\booking_kelas;
use App\Models\ijin_instruktur;

// import jadwal;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
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

        function createKelas($params,$foreign)
        {
            kelas::create([
                'jenis_kelas' => $params[0],
                'harga_kelas' => $params[1],
                'deskripsi_kelas' => $params[2],
                'id_instruktur' => $foreign,
        ]);
        }

        function createSesiGym($params){
                sesi_gym::create([
                    'tanggal_sesi_gym' => date("Y/m/d",strtotime("today + {$params[0]}")) ,
                    'waktu_mulai' => date("h:i",strtotime($params[1])),
                    'waktu_selesai' => date("h:i",strtotime($params[2])),
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

        function createAktivasi($jenis,$pegawai,$member,$nostruk)
        {
            createTransaksiMember($jenis, $pegawai, $member);
            transaksi_aktivasi::create([
                'tanggal_aktivasi' => date("Y-m-d H:i:s",strtotime('now')),
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

    
        function presensiInstruktur($mulai,$selesai,$status,$instruktur,$kelasjadwal){
            presensi_instruktur::create([
                'waktu_presensi'=> date("Y-m-d H:i:s",strtotime($mulai)),
                'waktu_selesai' => date("Y-m-d H:i:s",strtotime($selesai)),
                'status_presensi' => $status,
                'id_instruktur' => $instruktur,
                'id_kelas_jadwal' => $kelasjadwal
            ]);

        }

        function createBookingGym($tanggalbooking, $statuskehadiran = false , $sesi, $member, $struk = null)
        {
            booking_gym::create([
                'tanggal_booking' => date("Y-m-d H:i:s",strtotime($tanggalbooking)),
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
        createInstruktur(['Joon','instruktur'],['ins-1','Joon Sitanggang','Yadara Blok 27 Yogya','0828332813213'],7);
        createInstruktur(['JK','instruktur'],['ins-2','JK Bagaskara','Bekasi','+62 894-2212-919'],8);
        createInstruktur(['Lisa','instruktur'],['ins-3','Lisa Blackpink','Amarta no 4Y,Condong Catur, Jogja','+62 874-3379-57385'],9);
        createInstruktur(['Hobby','instruktur'],['ins-4','Hobby Sanjaya','Amarta no 6Y,Condong Catur, Jogja','+62 815-2075-864'],10);
        createInstruktur(['V','instruktur'],['ins-5','Veeee Putra','Amarta no 7Y,Condong Catur, Jogja','+62 853-8762-203'],11);
        createInstruktur(['Jenny','instruktur'],['ins-6','Jenny Mullen','Amarta no 3Y,Condong Catur, Jogja','+62 856-6734-887'],12);
        createInstruktur(['Suga','instruktur'],['ins-7','Suga Yudhistira','Amarta no 1Y,Condong Catur, Jogja','+62 825-8689-211'],13);
        createInstruktur(['Jin','instruktur'],['ins-8','Jin Winoto','Amarta no 42Y,Condong Catur, Jogja','+62 821-7559-145'],14);
        createInstruktur(['Jiso','instruktur'],['ins-9','Kim Ji Soo','Amarta no 41Y,Condong Catur, Jogja','+62 858-436-596'],15);
        createInstruktur(['Jimin','instruktur'],['ins-10','Park Jiminnn','Amarta no 14Y,Condong Catur, Jogja','+62 880-0828-3863'],16);
        createInstruktur(['Lisa','instruktur'],['ins-11','Lisa Lalisa','Amarta no 34Y,Condong Catur, Jogja','+62 893-0244-83650'],17);
        createInstruktur(['JK','instruktur'],['ins-12','JK Rowling','Amarta no 14Y,Condong Catur, Jogja','+62 824-3239-54991'],18);

        //*Detail Data pegawai
        //* id pegawai, nama pegawai, jabatan, tgl lahir, no telp, alamat 
        createPegawai(['admin','pegawai'],['ADM-1','Yusup','Admin','21-03-1995','08123456789','Tambak Bayan no 41 Yogya'],19);
        createPegawai(['admin_ganteng1','pegawai'],['ADM-2','Mamang','Admin','22-01-1996','08213232321','Tambak Bayan no 42 Yogya'],20);
        createPegawai(['mo_ganteng1','pegawai'],['MO-1','Adee','MO','22-01-1998',20,'0811123232321','Tambak Bayan no 41 Yogya'],21);
        createPegawai(['Yunita','pegawai'],['P01','Yunita','kasir','21-01-2000','082132133213','Seturan no 42 Yogya'],22);
        createPegawai(['Putri','pegawai'],['P02','Putri','kasir','23-05-2003','08212121312','Tambak Boyo no 42 Yogya'],23);
        createPegawai(['Yuna','pegawai'],['P03','Yuna','kasir','24-03-2001','085398244443','Sergodadi no 42 Yogya'],24);    


        //! DUMMY PROMO
        //*jenis,minimal,bonus,masa berlaku
        createPromo(['promo_reguler',3000000,300000,null]);
        createPromo(['promo_paket1',5,1,1]);
        createPromo(['promo_paket2',10,3,2]);       

        //! DUMMY SESI GYM
        createSesiGym(["1 days", "7:00","9:00"]);
        createSesiGym(["1 days", "9:00","11:00"]);
        createSesiGym(["1 days", "11:00","13:00"]);
        createSesiGym(["1 days", "13:00","15:00"]);
        createSesiGym(["1 days", "15:00","17:00"]);
        createSesiGym(["1 days", "17:00","19:00"]);
        createSesiGym(["1 days", "19:00","21:00"]);

        //! DUMMY KELAS
        createKelas([
            'SPINE Corrector',
            150000,
            "The Spine Corrector is an essential Pilates tool that can be used to perform exercises that lengthen and strengthen the torso, shoulders, back and legs while correcting or restoring the spine's natural curvature."
        ],'ins-1');
        createKelas([
            'MUAYTHAI',
            150000,
            "Muaythai merupakan suatu belah diri berasal dari Thailand."
        ],'ins-2');
        createKelas([
            'PILATES',
            150000,
            "Pilates biar bisa kayang"
        ],'ins-3');
        createKelas([
            'ASTHANGA',
            150000,
            "Pilates biar bisa kayang"
        ],'ins-4');
        createKelas([
            'Body Combat',
            150000,
            "Pilates biar bisa kayang"
        ],'ins-5');
        //!Badminton
        $this->call([
            jadwal::class
        ]);
        //!Presensi instruktur
        // presensiInstruktur();
        //!Perijinan Instruktur

        //!Data Transaksi
        //* transaksi dan booking
        createAktivasi('transaksi-aktivasi','P01','23.03.001','23.03.001');
        createAktivasi('transaksi-aktivasi','P02','23.03.002','23.03.002');
        createAktivasi('transaksi-aktivasi','P02','23.03.003','23.03.003');
        createAktivasi('transaksi-aktivasi','P02','23.03.004','23.03.004');
        createDepositReguler('transaksi-deposit-reguler','P02','23.03.001',4000000,4300000,1,'23.03.005');
        createDepositReguler('transaksi-deposit-reguler','P01','23.03.001',4000000,4300000,1,'23.03.006');
        createDepositPaket('transaksi-deposit-paket','P03','23.03.002',[6,750000,'next month'],2,'23.03.007',2);
        createAktivasi('transaksi-aktivasi','P03','23.03.004','23.03.008');
        createAktivasi('transaksi-aktivasi','P01','23.03.004','23.03.009');
        //*member 1 melakukan deposit reguler, depos kelas , booking gym dan booking kelas
        // createTransaksiMember(['transaksi-deposit-reguler'],'P02','23.03.001');
        // createTransaksiMember(['transaksi-deposit-kelas'],'P03','23.03.001');
        // createTransaksiMember(['transaksi-booking-gym'],'P01','23.03.001');
        // createTransaksiMember(['transaksi-booking-kelas'],'P01','23.03.001');
        // createTransaksiMember(['transaksi-aktivasi'],'P03','23.03.008');
        // createTransaksiMember(['transaksi-aktivasi'],'P03','23.03.010');
        // createTransaksiMember(['transaksi-aktivasi'],'P03','23.03.011');
        // createTransaksiMember(['transaksi-aktivasi'],'P01','23.03.001');
        //* Masing-masing user melakukan deposit reguler, booing kelas, booking gym
        //!Data Dummy Aktivasi
        // createAktivasi('transaksi-aktivasi','P01','23.03.001','23.03.001');
        // createAktivasi('23.03.002');
        // createAktivasi('23.03.003');
        // createAktivasi('23.03.004');
        // createAktivasi('23.03.005');
        // createAktivasi('23.03.006');
        // createAktivasi('23.03.007');
        // createAktivasi('23.03.008');
        //!Data Dummy Deposit reguler
        // createDepositReguler(['30000000',3300000],1,'23.03.002');
        //!Data Dummy Deposit paket
        // createDepositPaket([6,750000,'next month'],2,'23.03.003',3);
        //!Jadwal Jadwal Umum
       
        //!Presensi instruktur
        presensiInstruktur("03-04-2023 08:00:00","03-04-2023 09:00:00", "hadir","ins-1",1);
        presensiInstruktur("03-04-2023 09:31:00","03-04-2023 09:00:00", "hadir","ins-2",2);
        presensiInstruktur("04-04-2023 08:00:00","04-04-2023 09:00:00", "hadir","ins-3",3);
        presensiInstruktur("04-04-2023 09:32:00","04-04-2023 09:00:00", "hadir","ins-4",4);
        presensiInstruktur("05-04-2023 08:10:00","05-04-2023 09:00:00", "hadir","ins-5",5);
        // presensiInstruktur("06-03-2023 07:00:00","2023-03-27 09:00:00", "hadir","ins-1",5);
        // !Data Booking Kelas
        // createBookingKelas("28-03-2023",TRUE,1,"23.03.001","23.03.005");
        //!Data Instruktur
        
        //!Ijin Instruktur
        
        //!Data Booking Gym
        // createBookingGym("28-03-2023",TRUE,1,"23.03.001","23.03.004");
        
        



    }

}

