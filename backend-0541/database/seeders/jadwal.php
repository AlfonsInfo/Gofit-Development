<?php
    namespace Database\Seeders;

    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;
    use App\Models\jadwal_umum;
    use App\Models\jadwal_harian;
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
            function createJadwalUmum($hari,$mulai,$selesai,$instruktur,$kelas)
            {
                jadwal_umum::create([
                    'hari' => $hari,
                    'jam_mulai' => $mulai,//date("h:i",strtotime($mulai)),
                    'jam_selesai' => $selesai,//date("h:i",strtotime($selesai)),
                    'id_instruktur'=> $instruktur,
                    'id_kelas' => $kelas
                ]);
            }

            function createJadwalHarian($jadwalUmum,$tanggal,$index, $true = false, $statusKelas = "Berjalan")
            {
                if($true == true)
                {
                    createJadwalUmum($jadwalUmum[0],$jadwalUmum[1],$jadwalUmum[1],$jadwalUmum[3],$jadwalUmum[4]);
                }
                jadwal_harian::create([
                    'tanggal_jadwal_harian' => date("Y/m/d",strtotime($tanggal)), //$tanggal
                    'id_jadwal_umum' =>$index,
                    'status' => $statusKelas
                ]);
            }
            
            // function createJadwal($start,$finish){
                // $begin = new DateTime($start);
                // $end = new DateTime($finish);
                // $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
                // $jadwal = 1;
                // foreach($daterange as $date){
                //     for($i = 1 ; $i<=4; $i++)
                //     {
                //         if($jadwal > 25)
                //         {
                //             break;
                //         }
                //         createJadwalHarian(date($date->format("Y/m/d")) ,$jadwal);
                //         $jadwal++;
                //     }
                // }
            // }


            // Array of days and times
            // $days = array('senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu','minggu');
            // $times = array('8:00', '9:30', '17:00', '18:30');
        
            // // Counter for jadwal_umum ID
            // $jum_id = 1;
        
            // // Loop through days and times to create jadwal_umum records
            // foreach ($days as $day) {
            //     foreach ($times as $time) {
            //         if($day != 'minggu'){
            //             createJadwalUmum($day, $time, date('H:i', strtotime("$time + 1 hour")), $jum_id);
            //             $jum_id++;
            //         }else{
            //             createJadwalUmum($day, "9:00", "10:00",$jum_id);
            //             $jum_id++;
            //             break;
            //         }
            //     }
            // }
            //*create jadwal
            // createJadwal('2023-02-27','2023-03-06');
            // createJadwal('2023-03-06','2023-03-13');
            // createJadwal('2023-03-13','2023-03-20');
            //!kelas_jadwal
            // function generateJadwalHarian($start,$finish){
            //     $begin = new DateTime($start);
            //     $end = new DateTime($finish);
            //     $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
            //     $jadwal = 1;
            //     foreach($daterange as $date){
            //         for($i = 1 ; $i<=4; $i++)
            //         {
            //             if($jadwal > 25)
            //             {
            //                 break;
            //             }
            //             createJadwalHarian(date($date->format("Y/m/d")) ,$jadwal);
            //             $jadwal++;
            //         }
            //     }

            // }
            createJadwalHarian(['senin','8:00','9:00','ins-1',1],"27-02-2023",1,true);
            createJadwalHarian(['senin','9:30','10:30','ins-2',2],"27-02-2023",2,true);
            createJadwalHarian(['selasa','8:00','9:00','ins-3',3],"28-03-2023",3,true);
            createJadwalHarian(['selasa','9:30','10:30','ins-4',4],"28-03-2023",4,true);
            createJadwalHarian(['rabu','8:00','9:00','ins-5',5],"01-03-2023",5,true);
            createJadwalHarian(['rabu','8:00','9:00','ins-6','6'],"01-03-2023",6,true);
            createJadwalHarian(['rabu','9:30','10:30','ins-7',10],"01-03-2023",7,true);
            createJadwalHarian(['kamis','8:00','9:00','ins-11',8],"02-03-2023",8,true);
            createJadwalHarian(['kamis','9:30','10:30','ins-8',9],"02-03-2023",9,true);
            createJadwalHarian(['jumat','8:00','9:00','ins-9',10],"03-03-2023",10,true);
            createJadwalHarian(['jumat','9:30','10:30','ins-9',11],"03-03-2023",11,true);
            createJadwalHarian(['sabtu','8:00','10:00','ins-10',12],"04-03-2023",12,true);
            createJadwalHarian(['sabtu','9:30','10:30','ins-3',13],"04-03-2023",13,true);
            createJadwalHarian(['sabtu','9:30','10:30','ins-2',14],"04-03-2023",14,true);
            createJadwalHarian(['minggu','9:00','10:00','ins-1',15],"05-03-2023",15,true);
            // // //*Evening Classes
            createJadwalHarian(['senin','17:00','18:00','ins-9',11],"27-02-2023",16,true);
            createJadwalHarian(['senin','18:30','19:30','ins-4',16],"27-02-2023",17,true);
            createJadwalHarian(['selasa','17:00','18:00','ins-1',15],"28-02-2023",18,true);
            createJadwalHarian(['selasa','17:00','18:00','ins-7',1],"28-02-2023",19,true);
            createJadwalHarian(['selasa','18:00','19:30','ins-11',17],"28-02-2023",20,true);
            createJadwalHarian(['rabu','18:30','19:30','ins-12',18],"01-03-2023",21,true); //* Yoga for kids workout rose
            createJadwalHarian(['rabu','17:00','18:00','ins-8',8],"01-03-2023",22,true);
            createJadwalHarian(['rabu','18:30','19:30','ins-10',12],"01-03-2023",23,true);
            createJadwalHarian(['kamis','17:00','18:00','ins-6',20],"02-03-2023",24,true); //* Abs Pilates
            createJadwalHarian(['kamis','18:30','19:30','ins-5',5],"02-03-2023",25,true);
            createJadwalHarian(['jumat','17:00','18:00','ins-6',6],"03-03-2023",26,true);
            createJadwalHarian(['jumat','18:30','19:30','ins-2',2],"03-03-2023",27,true);
            createJadwalHarian(['sabtu','17:00','18:00','ins-12',19],"04-03-2023",28,true); 
            createJadwalHarian(['sabtu','17:00','18:00','ins-10',12],"04-03-2023",29,true);
            createJadwalHarian(['sabtu','18:30','19:30','ins-11',17],"05-03-2023",30,true);
            //* literasi 2
            createJadwalHarian(['senin','8:00','9:00','ins-1',1],"06-03-2023",1);
            createJadwalHarian(['senin','9:30','10:30','ins-2',2],"06-03-2023",2);
            createJadwalHarian(['selasa','8:00','9:00','ins-3',3],"07-03-2023",3);
            createJadwalHarian(['selasa','9:30','10:30','ins-4',4],"07-03-2023",4,true,"Instruktur Pengganti");
            createJadwalHarian(['rabu','8:00','9:00','ins-5',5],"08-03-2023",5);
            createJadwalHarian(['rabu','8:00','9:00','ins-6','6'],"08-03-2023",6);
            createJadwalHarian(['rabu','9:30','10:30','ins-7',10],"08-03-2023",7);
            createJadwalHarian(['kamis','8:00','9:00','ins-11',8],"09-03-2023",8,true,"Instruktur Pengganti");
            createJadwalHarian(['kamis','9:30','10:30','ins-8',9],"09-03-2023",9);
            createJadwalHarian(['jumat','8:00','9:00','ins-9',10],"10-03-2023",10,true,"Instruktur Pengganti");
            createJadwalHarian(['jumat','9:30','10:30','ins-9',11],"10-03-2023",11);
            createJadwalHarian(['sabtu','8:00','10:00','ins-10',12],"11-03-2023",12);
            createJadwalHarian(['sabtu','9:30','10:30','ins-3',13],"11-03-2023",13);
            createJadwalHarian(['sabtu','9:30','10:30','ins-2',14],"11-03-2023",14,true,"Diliburkan");
            createJadwalHarian(['minggu','9:00','10:00','ins-1',15],"12-03-2023",15);
            // // //*Evening Classes
            createJadwalHarian(['senin','17:00','18:00','ins-9',11],"06-03-2023",16);
            createJadwalHarian(['senin','18:30','19:30','ins-4',16],"06-03-2023",17);
            createJadwalHarian(['selasa','17:00','18:00','ins-1',15],"07-03-2023",18,TRUE,"Diliburkan");
            createJadwalHarian(['selasa','17:00','18:00','ins-7',1],"07-03-2023",19);
            createJadwalHarian(['selasa','18:00','19:30','ins-11',17],"07-03-2023",20);
            createJadwalHarian(['rabu','18:30','19:30','ins-12',18],"08-03-2023",21); //* Yoga for kids workout rose
            createJadwalHarian(['rabu','17:00','18:00','ins-8',8],"08-03-2023",22);
            createJadwalHarian(['rabu','18:30','19:30','ins-10',12],"08-03-2023",23);
            createJadwalHarian(['kamis','17:00','18:00','ins-6',20],"09-03-2023",24); //* Abs Pilates
            createJadwalHarian(['kamis','18:30','19:30','ins-5',5],"09-03-2023",25);
            createJadwalHarian(['jumat','17:00','18:00','ins-6',6],"10-03-2023",26);
            createJadwalHarian(['jumat','18:30','19:30','ins-2',2],"10-03-2023",27);
            createJadwalHarian(['sabtu','17:00','18:00','ins-12',19],"11-03-2023",28,TRUE,"Diliburkan"); 
            createJadwalHarian(['sabtu','17:00','18:00','ins-10',12],"11-03-2023",29);
            createJadwalHarian(['sabtu','18:30','19:30','ins-11',17],"11-03-2023",30);
            //* literasi 3
            createJadwalHarian(['senin','8:00','9:00','ins-1',1],"13-03-2023",1);
            createJadwalHarian(['senin','9:30','10:30','ins-2',2],"13-03-2023",2);
            createJadwalHarian(['selasa','8:00','9:00','ins-3',3],"14-03-2023",3);
            createJadwalHarian(['selasa','9:30','10:30','ins-4',4],"14-03-2023",4,TRUE,"Instruktur Pengganti");
            createJadwalHarian(['rabu','8:00','9:00','ins-5',5],"15-03-2023",5);
            createJadwalHarian(['rabu','8:00','9:00','ins-6','6'],"15-03-2023",6);
            createJadwalHarian(['rabu','9:30','10:30','ins-7',10],"15-03-2023",7,true,false);
            createJadwalHarian(['kamis','8:00','9:00','ins-11',8],"16-03-2023",8);
            createJadwalHarian(['kamis','9:30','10:30','ins-8',9],"16-03-2023",9);
            createJadwalHarian(['jumat','8:00','9:00','ins-9',10],"17-03-2023",10);
            createJadwalHarian(['jumat','9:30','10:30','ins-9',11],"17-03-2023",11,true,false);
            createJadwalHarian(['sabtu','8:00','10:00','ins-10',12],"18-03-2023",12);
            createJadwalHarian(['sabtu','9:30','10:30','ins-3',13],"18-03-2023",13);
            createJadwalHarian(['sabtu','9:30','10:30','ins-2',14],"18-03-2023",14);
            createJadwalHarian(['minggu','9:00','10:00','ins-1',15],"19-03-2023",15);
            // // //*Evening Classes
            createJadwalHarian(['senin','17:00','18:00','ins-9',11],"13-03-2023",16);
            createJadwalHarian(['senin','18:30','19:30','ins-4',16],"13-03-2023",17);
            createJadwalHarian(['selasa','17:00','18:00','ins-1',15],"14-03-2023",18);
            createJadwalHarian(['selasa','17:00','18:00','ins-7',1],"14-03-2023",19);
            createJadwalHarian(['selasa','18:00','19:30','ins-11',17],"14-03-2023",20);
            createJadwalHarian(['rabu','18:30','19:30','ins-12',18],"15-03-2023",21); //* Yoga for kids workout rose
            createJadwalHarian(['rabu','17:00','18:00','ins-8',8],"15-03-2023",22);
            createJadwalHarian(['rabu','18:30','19:30','ins-10',12],"15-03-2023",23);
            createJadwalHarian(['kamis','17:00','18:00','ins-6',20],"16-03-2023",24); //* Abs Pilates
            createJadwalHarian(['kamis','18:30','19:30','ins-5',5],"16-03-2023",25);
            createJadwalHarian(['jumat','17:00','18:00','ins-6',6],"17-03-2023",26);
            createJadwalHarian(['jumat','18:30','19:30','ins-2',2],"17-03-2023",27);
            createJadwalHarian(['sabtu','17:00','18:00','ins-12',19],"18-03-2023",28); 
            createJadwalHarian(['sabtu','17:00','18:00','ins-10',12],"18-03-2023",29);
            createJadwalHarian(['sabtu','18:30','19:30','ins-11',17],"18-03-2023",30);
            //* literasi 4
            createJadwalHarian(['senin','8:00','9:00','ins-1',1],"20-03-2023",1);
            createJadwalHarian(['senin','9:30','10:30','ins-2',2],"20-03-2023",2);
            createJadwalHarian(['selasa','8:00','9:00','ins-3',3],"21-03-2023",3);
            createJadwalHarian(['selasa','9:30','10:30','ins-4',4],"21-03-2023",4);
            createJadwalHarian(['rabu','8:00','9:00','ins-5',5],"22-03-2023",5);
            createJadwalHarian(['rabu','8:00','9:00','ins-6','6'],"22-03-2023",6);
            createJadwalHarian(['rabu','9:30','10:30','ins-7',10],"22-03-2023",7);
            createJadwalHarian(['kamis','8:00','9:00','ins-11',8],"23-03-2023",8);
            createJadwalHarian(['kamis','9:30','10:30','ins-8',9],"23-03-2023",9);
            createJadwalHarian(['jumat','8:00','9:00','ins-9',10],"24-03-2023",10);
            createJadwalHarian(['jumat','9:30','10:30','ins-9',11],"24-03-2023",11);
            createJadwalHarian(['sabtu','8:00','10:00','ins-10',12],"25-03-2023",12);
            createJadwalHarian(['sabtu','9:30','10:30','ins-3',13],"25-03-2023",13);
            createJadwalHarian(['sabtu','9:30','10:30','ins-2',14],"25-03-2023",14);
            createJadwalHarian(['minggu','9:00','10:00','ins-1',15],"26-03-2023",15);
            // // //*Evening Classes
            createJadwalHarian(['senin','17:00','18:00','ins-9',11],"20-03-2023",16);
            createJadwalHarian(['senin','18:30','19:30','ins-4',16],"20-03-2023",17);
            createJadwalHarian(['selasa','17:00','18:00','ins-1',15],"21-03-2023",18);
            createJadwalHarian(['selasa','17:00','18:00','ins-7',1],"21-03-2023",19);
            createJadwalHarian(['selasa','18:00','19:30','ins-11',17],"21-03-2023",20);
            createJadwalHarian(['rabu','18:30','19:30','ins-12',18],"22-03-2023",21); //* Yoga for kids workout rose
            createJadwalHarian(['rabu','17:00','18:00','ins-8',8],"22-03-2023",22);
            createJadwalHarian(['rabu','18:30','19:30','ins-10',12],"22-03-2023",23);
            createJadwalHarian(['kamis','17:00','18:00','ins-6',20],"23-03-2023",24); //* Abs Pilates
            createJadwalHarian(['kamis','18:30','19:30','ins-5',5],"23-03-2023",25);
            createJadwalHarian(['jumat','17:00','18:00','ins-6',6],"24-03-2023",26);
            createJadwalHarian(['jumat','18:30','19:30','ins-2',2],"24-03-2023",27);
            createJadwalHarian(['sabtu','17:00','18:00','ins-12',19],"25-03-2023",28); 
            createJadwalHarian(['sabtu','17:00','18:00','ins-10',12],"25-03-2023",29);
            createJadwalHarian(['sabtu','18:30','19:30','ins-11',17],"25-03-2023",30);
            //* literasi 5
            createJadwalHarian(['senin','8:00','9:00','ins-1',1],"27-03-2023",1);
            createJadwalHarian(['senin','9:30','10:30','ins-2',2],"27-03-2023",2);
            createJadwalHarian(['selasa','8:00','9:00','ins-3',3],"28-03-2023",3);
            createJadwalHarian(['selasa','9:30','10:30','ins-4',4],"28-03-2023",4);
            createJadwalHarian(['rabu','8:00','9:00','ins-5',5],"29-03-2023",5);
            createJadwalHarian(['rabu','8:00','9:00','ins-6','6'],"29-03-2023",6);
            createJadwalHarian(['rabu','9:30','10:30','ins-7',10],"29-03-2023",7);
            createJadwalHarian(['kamis','8:00','9:00','ins-11',8],"30-03-2023",8);
            createJadwalHarian(['kamis','9:30','10:30','ins-8',9],"30-03-2023",9);
            createJadwalHarian(['jumat','8:00','9:00','ins-9',10],"30-03-2023",10);
            createJadwalHarian(['jumat','9:30','10:30','ins-9',11],"31-03-2023",11);
            createJadwalHarian(['sabtu','8:00','10:00','ins-10',12],"01-04-2023",12);
            createJadwalHarian(['sabtu','9:30','10:30','ins-3',13],"01-04-2023",13);
            createJadwalHarian(['sabtu','9:30','10:30','ins-2',14],"01-04-2023",14);
            createJadwalHarian(['minggu','9:00','10:00','ins-1',15],"02-04-2023",15);
            // // //*Evening Classes
            createJadwalHarian(['senin','17:00','18:00','ins-9',11],"27-03-2023",16);
            createJadwalHarian(['senin','18:30','19:30','ins-4',16],"27-03-2023",17);
            createJadwalHarian(['selasa','17:00','18:00','ins-1',15],"28-03-2023",18);
            createJadwalHarian(['selasa','17:00','18:00','ins-7',1],"28-03-2023",19);
            createJadwalHarian(['selasa','18:00','19:30','ins-11',17],"28-03-2023",20);
            createJadwalHarian(['rabu','18:30','19:30','ins-12',18],"29-03-2023",21); //* Yoga for kids workout rose
            createJadwalHarian(['rabu','17:00','18:00','ins-8',8],"29-03-2023",22);
            createJadwalHarian(['rabu','18:30','19:30','ins-10',12],"29-03-2023",23);
            createJadwalHarian(['kamis','17:00','18:00','ins-6',20],"30-03-2023",24); //* Abs Pilates
            createJadwalHarian(['kamis','18:30','19:30','ins-5',5],"30-03-2023",25);
            createJadwalHarian(['jumat','17:00','18:00','ins-6',6],"31-03-2023",26);
            createJadwalHarian(['jumat','18:30','19:30','ins-2',2],"31-03-2023",27);
            createJadwalHarian(['sabtu','17:00','18:00','ins-12',19],"01-04-2023",28); 
            createJadwalHarian(['sabtu','17:00','18:00','ins-10',12],"01-04-2023",29);
            createJadwalHarian(['sabtu','18:30','19:30','ins-11',17],"01-04-2023",30);
        }
    }






    
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