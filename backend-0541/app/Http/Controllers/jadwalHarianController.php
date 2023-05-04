<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\jadwal_umum;
use App\Helpers\ValidatorHelper;
use App\Models\jadwal_harian;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class jadwalHarianController extends Controller
{

    public function index()
    {
        //* find all data
        $semua = [];
        $start_date = Carbon::now()->startOfWeek(Carbon::SUNDAY);
        $end_date =  Carbon::now()->startOfWeek(Carbon::SUNDAY)->addMonth(1);
        
        for($date = $start_date; $date->lte($end_date); $date->addDays(7)){
            
            $jadwal = ['senin' => jadwal_harian::whereDate('tanggal_jadwal_harian',$date->addDay())->get(),
                'selasa' => jadwal_harian::where('tanggal_jadwal_harian',$date->addDays(2))->get(),
                'rabu' => jadwal_harian::where('tanggal_jadwal_harian',$date->addDays(3))->get(),
                'kamis' => jadwal_harian::where('tanggal_jadwal_harian',   $date->addDays(4))->get(),
                'jumat' => jadwal_harian::where('tanggal_jadwal_harian',$date->addDays(5))->get(),
                'sabtu' => jadwal_harian::where('tanggal_jadwal_harian',$date->addDays(6))->get(),
                'minggu' => jadwal_harian::where('tanggal_jadwal_harian',$date->addDays(7))->get(),
            ];

            array_push($semua,$jadwal); 
        }
        return response([
        //* return response
            'message'=>'Success Tampil Data',
            'data' => $semua
        ],200); 

    }

    public function show($id_jadwal_umum)
    {
        //* find data based on params
        $jadwal_umum = jadwal_umum::where('id_jadwal_umum', $id_jadwal_umum)->with(['instruktur'])->first();
        
        //* not found
        if($jadwal_umum == null)
        {
            return response([
                'Jadwal Umum Not Found'
            ],404);
        }

        //* return response
        return response([
            'message'=>'Success Tampil Data',
            'data' => $jadwal_umum
        ],200);
    }


    public function store(Request $request)
    {
        $start_date = Carbon::now()->startOfWeek(Carbon::SUNDAY)->addDay();
        $end_date =  Carbon::now()->startOfWeek(Carbon::SUNDAY)->addDays(7);
        $mapHari = [
            'monday' => 'senin',
            'tuesday' => 'selasa',
            'wednesday' => 'rabu',
            'thursday' => 'kamis',
            'friday' => 'jumat',
            'saturday' => 'sabtu',
            'sunday' => 'minggu'
        ];
        for($date = $start_date; $date->lte($end_date); $date->addDay()){
            $hari = Carbon::parse($date)->format('l');

            $jadwalUmum = DB::table('jadwal_umum')
            ->where('jadwal_umum.hari', '=', $mapHari[strtolower($hari)])
            ->get();
            // menyimpan data ke tabel jadwal_harian
            foreach ($jadwalUmum as $jadwal) {
                
                DB::table('jadwal_harian')->insert([
                    'tanggal_jadwal_harian' => $date->toDateString(),
                    'status' => 'berjalan',
                    'id_jadwal_umum' => $jadwal->id_jadwal_umum,
                ]);
        }
    }
        // dd($jadwalHarian);
        //* Create Jadwal Umum
        // $jadwal_harian = jadwal_harian::create([            'id_instruktur' => $request->id_instruktur,
        // ]);
        
        //*return response
        return response([
        ]);


    }

    public function update(Request $request, $id)
    {
        //* Validasi
        $validator = ValidatorHelper::validateJadwalUmum($request->all());
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        //* Cari data berdasarkan ID
        $temp = jadwal_umum::where('id_jadwal_umum', $id)->first();
        if (!$temp) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found',
            ], 404);
        }
    
        //* Update data
        jadwal_umum::where('id_jadwal_umum', $id)->update([
            'hari' => $request->hari,
            'id_instruktur' => $request->id_instruktur,
            'id_kelas' => $request->id_kelas,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);
    
        //* Berikan respon sukses
        return response()->json([
            'success' => true,
            'message' => 'Jadwal Umum Updated',
            'data'    => jadwal_umum::find($id),
        ], 200);
    }
    

    public function destroy($id)
    {
        //* Find Data based on params $id
        $jadwal_umum = jadwal_umum::Where('id_jadwal_umum',$id)->first();
        //*found
        if($jadwal_umum){
            $jadwal_umum->delete();

            return response()->json([
                'success' => true,
                'message' => 'jadwal_umum Deleted',
            ], 200);
            
        //*not found
        }else{
            return response()->json([
                'success' => false,
                'message' => 'jadwal_umum Not Found',
            ], 404);
        }   
    }
}
