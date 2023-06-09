<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\jadwal_umum;
use App\Helpers\ValidatorHelper;
use Illuminate\Support\Facades\DB;
class jadwalUmumController extends Controller
{

    public function index()
    {
        //* find all data
        // $jadwal_umum = jadwal_umum::latest()->with(['instruktur','kelas'])->get();
        $jadwalPagi = ['Senin' => jadwal_umum::where('hari','senin')->whereTime('jam_mulai', '<', '17:00:00')->with(['instruktur','kelas'])->orderBy('jam_mulai','asc')->get(),
        'Selasa' => jadwal_umum::where('hari','selasa')->whereTime('jam_mulai', '<', '17:00:00')->with(['instruktur','kelas'])->orderBy('jam_mulai','asc')->get(),
        'Rabu' => jadwal_umum::where('hari','rabu')->whereTime('jam_mulai', '<', '17:00:00')->with(['instruktur','kelas'])->orderBy('jam_mulai','asc')->get(),
        'Kamis' => jadwal_umum::where('hari',   'kamis')->whereTime('jam_mulai', '<', '17:00:00')->with(['instruktur','kelas'])->orderBy('jam_mulai','asc')->get(),
        'Jumat' => jadwal_umum::where('hari','jumat')->whereTime('jam_mulai', '<', '17:00:00')->with(['instruktur','kelas'])->orderBy('jam_mulai','asc')->get(),
        'Sabtu' => jadwal_umum::where('hari','sabtu')->whereTime('jam_mulai', '<', '17:00:00')->with(['instruktur','kelas'])->orderBy('jam_mulai','asc')->get(),
        'Minggu' => jadwal_umum::where('hari','minggu')->whereTime('jam_mulai', '<', '17:00:00')->with(['instruktur','kelas'])->orderBy('jam_mulai','asc')->get(),
    ];

    $jadwalSore = ['Senin' => jadwal_umum::where('hari','senin')->whereTime('jam_mulai', '>', '17:00:00')->with(['instruktur','kelas'])->orderBy('jam_mulai','asc')->get(),
        'Selasa' => jadwal_umum::where('hari','selasa')->whereTime('jam_mulai', '>', '17:00:00')->with(['instruktur','kelas'])->orderBy('jam_mulai','asc')->get(),
        'Rabu' => jadwal_umum::where('hari','rabu')->whereTime('jam_mulai', '>', '17:00:00')->with(['instruktur','kelas'])->orderBy('jam_mulai','asc')->get(),
        'Kamis' => jadwal_umum::where('hari','kamis')->whereTime('jam_mulai', '>', '17:00:00')->with(['instruktur','kelas'])->orderBy('jam_mulai','asc')->get(),
        'Jumat' => jadwal_umum::where('hari','jumat')->whereTime('jam_mulai', '>', '17:00:00')->with(['instruktur','kelas'])->orderBy('jam_mulai','asc')->get(),
        'Sabtu' => jadwal_umum::where('hari','sabtu')->whereTime('jam_mulai', '>', '17:00:00')->with(['instruktur','kelas'])->orderBy('jam_mulai','asc')->get(),
        'Minggu' => jadwal_umum::where('hari','minggu')->whereTime('jam_mulai', '>', '17:00:00')->with(['instruktur','kelas'])->orderBy('jam_mulai','asc')->get(),
    ];
        $jadwal = ['pagi' => $jadwalPagi, 'sore' => $jadwalSore]; 
        return response([
        //* return response
            'message'=>'Success Tampil Data',
            'data' => $jadwal
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
        //*Validasi
        $validator = ValidatorHelper::validateJadwalUmum($request->all());
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        //* Create Jadwal Umum
        $jadwal_umum = jadwal_umum::create([
            'hari' => $request->hari,
            'id_instruktur' => $request->id_instruktur,
            'id_kelas' => $request->id_kelas,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);
        
        //*return response
        return response([
            'message'=> 'success tambah data instruktur',
            'data' => $jadwal_umum,
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

    public function JadwalByInstruktur(Request $request){
        // $jadwal = jadwal_umum::get();
        $jadwal = jadwal_umum::where('id_instruktur', $request->id_instruktur)->with(['instruktur','kelas'])->get();
        if($jadwal){
            return response(['data' =>  $jadwal]);
        }else{
            return response([],400);
        }
    }

    public function getJadwalMobile(){
        $jadwal = jadwal_umum::orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")->with(['instruktur','kelas'])->get();
        // $sortedData = DB::table('jadwal_umum')
            // ->orderByRaw("FIELD(hari, 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu')")
            // ->get();

        return response(['data'=>$jadwal]);

    }
}
