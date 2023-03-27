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
        function createMember($params,$foreign)
        {
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

        function createInstruktur($params, $foreign){
            instruktur::create([
                'id_instruktur' => $params[0],
                'id_pengguna' => $foreign,
                'nama_instruktur' => $params[1],
                'alamat_instruktur' => $params[2],
                'no_telp_instruktur' => $params[3],
            ]);
        }
        function createPegawai($params, $foreign){
            //* id pegawai, nama pegawai, jabatan, tgl lahir, no telp, alamat 
        
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
            // $table->string('jenis_promo');
            // $table->double('minimal_deposit');
            // $table->double('bonus_promo');
            // $table->integer('masa_berlaku')->nullable();
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
        
        function createTransaksiMember($params,$pegawai,$member)
        {
            // Schema::create('transaksi_member', function (Blueprint $table) {
            //     $table->string('no_struk_transaksi')->primary();
            //     $table->string('jenis_transaksi');
            //     $table->string('id_pegawai')->index('id_pegawai');
            //     $table->timestamp('created_at')->nullable()->useCurrent();
            //     $table->timestamp('updated_at')->nullable();
            //     $table->softDeletes();
            transaksi_member::create([
                'jenis_transaksi' => $params[0],
                'id_pegawai' => $pegawai,
                'id_member' => $member
            ]);
        }

        function createAktivasi($params)
        {
            transaksi_aktivasi::create([
                'tanggal_aktivasi' => date("Y-m-d H:i:s",strtotime('now')),
                // 'nominal_transaksi' => $params,
                'no_struk' => $params
            ]);
        }

        function createDepositReguler($params,$promo,$struk)
        {
            transaksi_deposit_reguler::create([
                'nominal_deposit'=>$params[0],
                'nominal_total' => $params[1],
                'id_promo' => $promo,
                'no_struk' => $struk
            ]);
        }

    function createDepositPaket($params,$promo,$struk,$kelas)
        {
            // $table->integer('id_deposit_paket', true);
            // $table->timestamp('tanggal_deposit')->useCurrent();
            // $table->double('nominal_deposit_kelas');
            // $table->double('nominal_uang');
            // $table->timestamp('tanggal_kadeluarsa')->nullable();
            // $table->integer('id_promo')->index('id_promo');
            // $table->string('no_struk')->index('no_struk');
            // $table->timestamp('created_at')->useCurrent();
            // $table->timestamp('updated_at')->nullable();
            // $table->softDeletes();
            transaksi_deposit_paket::create([
                'nominal_deposit_kelas'=>$params[0],
                'nominal_uang' => $params[1],
                'tanggal_kadeluarsa' => date("Y-m-d H:i:s",strtotime($params[2])),
                'id_promo' => $promo,
                'no_struk' => $struk,
                'id_kelas' => $kelas
                
            ]);
        }

        //! DUMMY USER
        //*Dummy Pengguna role member
        createPengguna(['alfonsus','member']);
        createPengguna(['ucup_surucup','member']);
        createPengguna(['udin_saprudin','member']);
        createPengguna(['faizah_nugraha','member']);
        createPengguna(['nadya','member']);
        createPengguna(['henri','member']);
        //*Dummy Pengguna role instruktur
        createPengguna(['Joon','instruktur']);
        createPengguna(['JK','instruktur']);
        createPengguna(['Lisa','instruktur']);
        createPengguna(['Hobby','instruktur']);
        createPengguna(['V','instruktur']);
        createPengguna(['Jenny','instruktur']);
        createPengguna(['Suga','instruktur']);
        createPengguna(['Jin','instruktur']);
        createPengguna(['Jiso','instruktur']);
        createPengguna(['Jimin','instruktur']);
        createPengguna(['Lisa','instruktur']);
        createPengguna(['JK','instruktur']);
        //*Dummy Pengguna role pegawai;
        createPengguna(['admin','pegawai']);
        createPengguna(['admin_ganteng1','pegawai']);
        createPengguna(['mo_ganteng1','pegawai']);
        createPengguna(['Yunita','pegawai']);
        createPengguna(['Putri','pegawai']);
        createPengguna(['Yuna','pegawai']);
        // createPengguna(['V','pegawai']);
        // \App\Models\User::factory(10)->create();

        //*Detail Data Member
        //*nama_member,tgl_lahir_member,no_telp_member,tgl_kadeluarsa_aktivasi, total_deposit_uang,total_deposit_paket
        // createPengguna(['alfonsus','member']);
        createMember(['Alfonsus Setiawan Jacub','21-05-2002','082284990864'],1);
        createMember(['Ucup Surucup','21-05-2000','0821232314214'],2);
        createMember(['Udin Saprudin','21-05-2003','0821232314214'],3);
        createMember(['Faizah Nugraha','21-05-2001','082123231111'],4);
        createMember(['Nadya','13-05-2000','082123231111'],5);
        createMember(['Henri Teja','13-05-2002','082123231111'],6);

        //* Detail data instruktur
        createInstruktur(['ins-1','Joon Sitanggang','Yadara Blok 27 Yogya','0828332813213'],6);
        createInstruktur(['ins-2','JK Bagaskara','Bekasi','+62 894-2212-919'],7);
        createInstruktur(['ins-3','Lisa Blackpink','Amarta no 4Y,Condong Catur, Jogja','+62 874-3379-57385'],8);
        createInstruktur(['ins-4','Hobby Sanjaya','Amarta no 6Y,Condong Catur, Jogja','+62 815-2075-864'],9);
        createInstruktur(['ins-5','Veeee Putra','Amarta no 7Y,Condong Catur, Jogja','+62 853-8762-203'],10);
        createInstruktur(['ins-6','Jenny Mullen','Amarta no 3Y,Condong Catur, Jogja','+62 856-6734-887'],11);
        createInstruktur(['ins-7','Suga Yudhistira','Amarta no 1Y,Condong Catur, Jogja','+62 825-8689-211'],12);
        createInstruktur(['ins-8','Jin Winoto','Amarta no 42Y,Condong Catur, Jogja','+62 821-7559-145'],13);
        createInstruktur(['ins-9','Kim Ji Soo','Amarta no 41Y,Condong Catur, Jogja','+62 858-436-596'],14);
        createInstruktur(['ins-10','Park Jiminnn','Amarta no 14Y,Condong Catur, Jogja','+62 880-0828-3863'],15);
        createInstruktur(['ins-11','Lisa Lalisa','Amarta no 34Y,Condong Catur, Jogja','+62 893-0244-83650'],16);
        createInstruktur(['ins-12','JK Rowling','Amarta no 14Y,Condong Catur, Jogja','+62 824-3239-54991'],17);

        //*Detail Data pegawai
        //* id pegawai, nama pegawai, jabatan, tgl lahir, no telp, alamat 
        createPegawai(['ADM-1','Yusup','Admin','21-03-1995','08123456789','Tambak Bayan no 41 Yogya'],18);
        createPegawai(['ADM-2','Mamang','Admin','22-01-1996','08213232321','Tambak Bayan no 42 Yogya'],19);
        createPegawai(['MO-1','Adee','MO','22-01-1998',20,'0811123232321','Tambak Bayan no 41 Yogya'],20);
        createPegawai(['P01','Yunita','kasir','21-01-2000','082132133213','Seturan no 42 Yogya'],21);
        createPegawai(['P02','Putri','kasir','23-05-2003','08212121312','Tambak Boyo no 42 Yogya'],22);
        createPegawai(['P03','Yuna','kasir','24-03-2001','085398244443','Sergodadi no 42 Yogya'],23);    
        //! DUMMY PROMO
        //*jenis,minimal,bonus,masa berlaku
        createPromo(['promo_reguler',3000000,300000,null]);
        createPromo(['promo_paket1',5,1,1]);
        createPromo(['promo_paket2',10,3,2]);       

        //! DUMMY SESI GYM
        // 7-9, 9-11, 11-13, 13-15, 15-17, 17-19, dan 19-21. //*datenya di bookingan ?
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
        //!Data Transaksi
        createTransaksiMember(['transaksi-aktivasi'],'P01','23.03.001');
        createTransaksiMember(['transaksi-deposit-reguler'],'P02','23.03.002');
        createTransaksiMember(['transaksi-deposit-kelas'],'P03','23.03.003');
        //!Data Dummy Aktivasi
        createAktivasi('23.03.001');
        //!Data Dummy Deposit reguler
        createDepositReguler(['30000000',3300000],1,'23.03.002');
        //!Data Dummy Deposit paket
        createDepositPaket([6,750000,'next month'],2,'23.03.003',3);
        // createDepositPaket([6,750000,'next month'],2,'23.03.003',3);
        // createDepositPaket([6,750000,'next month'],2,'23.03.003',3);
        //!Jadwal Jadwal Umum

        //!Jadwal Harian
        //!Data Booking Gym
        
        //!Data Booking Kelas

        //!Data Instruktur

        //!Ijin Instruktur




    }

}

