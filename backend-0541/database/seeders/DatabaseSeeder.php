<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User\pengguna;
use App\Models\User\instruktur;
use App\Models\User\pegawai;
use App\Models\User\member;

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
        //*Dummy Pengguna role member
        createPengguna(['alfonsus','member']);
        createPengguna(['ucup_surucup','member']);
        createPengguna(['udin_saprudin','member']);
        createPengguna(['faizah_nugraha','member']);
        createPengguna(['nadya','member']);
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
    }
}
