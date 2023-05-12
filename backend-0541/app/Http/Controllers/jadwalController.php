<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\jadwal_umum;
use App\Helpers\ValidatorHelper;
class jadwalController extends Controller
{

    public function index()
    {
        //* find all data
        // $jadwal_umum = jadwal_umum::latest()->with(['instruktur','kelas'])->get();
        $jadwalPagi = ['senin' => jadwal_umum::where('hari','senin')->whereTime('jam_mulai', '<', '17:00:00')->with(['instruktur','kelas'])->get(),
        'selasa' => jadwal_umum::where('hari','selasa')->whereTime('jam_mulai', '<', '17:00:00')->with(['instruktur','kelas'])->get(),
        'rabu' => jadwal_umum::where('hari','rabu')->whereTime('jam_mulai', '<', '17:00:00')->with(['instruktur','kelas'])->get(),
        'kamis' => jadwal_umum::where('hari',   'kamis')->whereTime('jam_mulai', '<', '17:00:00')->with(['instruktur','kelas'])->get(),
        'jumat' => jadwal_umum::where('hari','jumat')->whereTime('jam_mulai', '<', '17:00:00')->with(['instruktur','kelas'])->get(),
        'sabtu' => jadwal_umum::where('hari','sabtu')->whereTime('jam_mulai', '<', '17:00:00')->with(['instruktur','kelas'])->get(),
        'minggu' => jadwal_umum::where('hari','minggu')->whereTime('jam_mulai', '<', '17:00:00')->with(['instruktur','kelas'])->get(),
    ];
    $jadwalSore = ['senin' => jadwal_umum::where('hari','senin')->whereTime('jam_mulai', '>', '17:00:00')->with(['instruktur','kelas'])->get(),
        'selasa' => jadwal_umum::where('hari','selasa')->whereTime('jam_mulai', '>', '17:00:00')->with(['instruktur','kelas'])->get(),
        'rabu' => jadwal_umum::where('hari','rabu')->whereTime('jam_mulai', '>', '17:00:00')->with(['instruktur','kelas'])->get(),
        'kamis' => jadwal_umum::where('hari','kamis')->whereTime('jam_mulai', '>', '17:00:00')->with(['instruktur','kelas'])->get(),
        'jumat' => jadwal_umum::where('hari','jumat')->whereTime('jam_mulai', '>', '17:00:00')->with(['instruktur','kelas'])->get(),
        'sabtu' => jadwal_umum::where('hari','sabtu')->whereTime('jam_mulai', '>', '17:00:00')->with(['instruktur','kelas'])->get(),
        'minggu' => jadwal_umum::where('hari','minggu')->whereTime('jam_mulai', '>', '17:00:00')->with(['instruktur','kelas'])->get(),
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
        $jadwal = jadwal_umum::where('id_instruktur', $request->id_instruktur)->get();

        return response(['data' =>  $jadwal]);
    }
}
