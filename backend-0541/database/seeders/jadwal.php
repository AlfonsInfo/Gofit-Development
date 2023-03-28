<?php
    namespace Database\Seeders;

    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;
    use App\Models\jadwal_umum;
    use App\Models\jadwal_harian;
    use App\Models\kelas_jadwal;
    use DateTime;
    use DateInterval;
    use DatePeriod;


    class jadwal extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            function createJadwalUmum($hari,$mulai,$selesai)
            {
                jadwal_umum::create([
                    'hari' => $hari,
                    'jam_mulai' => date("h:i",strtotime($mulai)),
                    'jam_selesai' => date("h:i",strtotime($selesai)),
                ]);
            }

            function createJadwalHarian($tanggal,$jadwalUmum)
            {
                jadwal_harian::create([
                    'tanggal_jadwal_harian' => date("Y/m/d",strtotime($tanggal)), //$tanggal
                    'id_jadwal_umum' =>$jadwalUmum,

                ]);
            }
    // Array of days and times
    $days = array('senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu','minggu');
    $times = array('8:00', '9:30', '17:00', '18:30');

    // Counter for jadwal_umum ID
    $jum_id = 1;

    // Loop through days and times to create jadwal_umum records
    foreach ($days as $day) {
    foreach ($times as $time) {
        if($day != 'minggu'){
            createJadwalUmum($day, $time, date('H:i', strtotime("$time + 1 hour")), $jum_id);
            $jum_id++;
        }else{
            createJadwalUmum($day, "9:00", "10:00",$jum_id);
            $jum_id++;
            break;
        }
    }
    }

    function createJadwal($start,$finish){
        $begin = new DateTime($start);
        $end = new DateTime($finish);
        $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
        $jadwal = 1;
        foreach($daterange as $date){
            for($i = 1 ; $i<=4; $i++)
            {
                if($jadwal > 25)
                {
                    break;
                }
                createJadwalHarian(date($date->format("Y/m/d")) ,$jadwal);
                $jadwal++;
            }
        }
    }

          
                //*create jadwal

                createJadwal('2023-02-27','2023-03-06');
                createJadwal('2023-03-06','2023-03-13');
                createJadwal('2023-03-13','2023-03-20');
            //!kelas_jadwal
            kelas_jadwal::create([
                'status' => 'berjalan',
                'id_kelas' => 1,
                'id_jadwal_harian' => 1
            ]);
            kelas_jadwal::create([
                'status' => 'berjalan',
                'id_kelas' => 2,
                'id_jadwal_harian' => '2'
            ]);
            kelas_jadwal::create([
                'status' => 'berjalan',
                'id_kelas' => 3,
                'id_jadwal_harian' => '3'
            ]);
            kelas_jadwal::create([
                'status' => 'berjalan',
                'id_kelas' => 4,
                'id_jadwal_harian' => '4'
            ]);
            kelas_jadwal::create([
                'status' => 'berjalan',
                'id_kelas' => 5,
                'id_jadwal_harian' => '4'
            ]);
        }
    }



        
            // createJadwalUmum('senin','8:00','9:00');
            // createJadwalUmum('senin','9:30','10:30');
            // createJadwalUmum('selasa','8:00','9:00');
            // createJadwalUmum('selasa','9:30','10:30');
            // createJadwalUmum('rabu','8:00','9:00');
            // createJadwalUmum('rabu','9:30','10:30');
            // createJadwalUmum('kamis','8:00','9:00');
            // createJadwalUmum('kamis','9:30','10:30');
            // createJadwalUmum('jumat','8:00','9:00');
            // createJadwalUmum('jumat','9:30','10:30');
            // createJadwalUmum('sabtu','9:00','10:00');
            // createJadwalUmum('sabtu','9:30','10:30');
            // //*Evening Classes
            // createJadwalUmum('senin','17:00','18:00');
            // createJadwalUmum('senin','18:30','19:30');
            // createJadwalUmum('selasa','17:00','18:00');
            // createJadwalUmum('selasa','18:30','19:30');
            // createJadwalUmum('rabu','17:00','18:00');
            // createJadwalUmum('rabu','18:30','19:30');
            // createJadwalUmum('kamis','17:00','18:00');
            // createJadwalUmum('kamis','18:30','19:30');
            // createJadwalUmum('jumat','17:00','18:00');
            // createJadwalUmum('jumat','18:30','19:30');
            // createJadwalUmum('sabtu','17:00','18:00');
            // createJadwalUmum('sabtu','18:30','19:30');
            // //*Iterasi Pertama
            // createJadwalHarian('27 February 2023','1');     //senin
            // createJadwalHarian('27 February 2023','2');
            // createJadwalHarian('27 February 2023','3');
            // createJadwalHarian('27 February 2023','4');
            // createJadwalHarian('28 February 2023','5'); //selasa
            // createJadwalHarian('28 February 2023','6');
            // createJadwalHarian('28 February 2023','7');
            // createJadwalHarian('28 February 2023','8');
            // createJadwalHarian('1 March 2023','9'); //rabu
            // createJadwalHarian('1 March 2023','10');
            // createJadwalHarian('1 March 2023','11');
            // createJadwalHarian('1 March 2023','12');
            // createJadwalHarian('2 March 2023','13'); // kamis
            // createJadwalHarian('2 March 2023','14');
            // createJadwalHarian('2 March 2023','15');
            // createJadwalHarian('2 March 2023','16');
            // createJadwalHarian('3 March 2023','17'); //jumat
            // createJadwalHarian('3 March 2023','18');
            // createJadwalHarian('3 March 2023','19');
            // createJadwalHarian('3 March 2023','20');
            // createJadwalHarian('4 March 2023','21'); //sabtu
            // createJadwalHarian('4 March 2023','22');
            // createJadwalHarian('4 March 2023','23');
            // createJadwalHarian('4 March 2023','24');
            // createJadwalHarian('5 March 2023','25'); // Minggu