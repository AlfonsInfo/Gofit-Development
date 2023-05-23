<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\jadwal_umum;
use App\Helpers\ValidatorHelper;
use App\Models\ijin_instruktur;
use App\Models\jadwal_harian;
use App\Models\kelas;
use Carbon\Carbon;
use Database\Seeders\jadwal;
use Illuminate\Support\Facades\DB;

class jadwalHarianController extends Controller
{

    //cek apakah sudah generate jadwal harian
    public function cekAutoGenerate(){
        $jadwalHarian = jadwal_harian::where('tanggal_jadwal_harian', '>', Carbon::now()->startOfWeek(Carbon::SUNDAY)->format('Y-m-d'))
            ->first();
        if(is_null($jadwalHarian)){
            return false;
        }else{
            return true;
        }
    }

    public function index()
    {

        //* find all data
        $start_date = Carbon::now()->startOfWeek(Carbon::SUNDAY);

        $jadwal = [$start_date->addDay()->toDateString() => jadwal_harian::whereDate('tanggal_jadwal_harian',$start_date)->with(['jadwal_umum','jadwal_umum.instruktur','jadwal_umum.kelas','ijin_instruktur','ijin_instruktur.instruktur','ijin_instruktur.instrukturPengganti'])->get(),
        $start_date->addDay()->toDateString() => jadwal_harian::whereDate('tanggal_jadwal_harian',$start_date)->with(['jadwal_umum','jadwal_umum.instruktur','jadwal_umum.kelas','ijin_instruktur','ijin_instruktur.instruktur','ijin_instruktur.instrukturPengganti'])->get(),
        $start_date->addDay()->toDateString() => jadwal_harian::whereDate('tanggal_jadwal_harian',$start_date)->with(['jadwal_umum','jadwal_umum.instruktur','jadwal_umum.kelas','ijin_instruktur','ijin_instruktur.instruktur','ijin_instruktur.instrukturPengganti'])->get(),
        $start_date->addDay()->toDateString() => jadwal_harian::whereDate('tanggal_jadwal_harian',$start_date)->with(['jadwal_umum','jadwal_umum.instruktur','jadwal_umum.kelas','ijin_instruktur','ijin_instruktur.instruktur','ijin_instruktur.instrukturPengganti'])->get(),
        $start_date->addDay()->toDateString() => jadwal_harian::whereDate('tanggal_jadwal_harian',$start_date)->with(['jadwal_umum','jadwal_umum.instruktur','jadwal_umum.kelas','ijin_instruktur','ijin_instruktur.instruktur','ijin_instruktur.instrukturPengganti'])->get(),
        $start_date->addDay()->toDateString() => jadwal_harian::whereDate('tanggal_jadwal_harian',$start_date)->with(['jadwal_umum','jadwal_umum.instruktur','jadwal_umum.kelas','ijin_instruktur','ijin_instruktur.instruktur','ijin_instruktur.instrukturPengganti'])->get(),
        $start_date->addDay()->toDateString() => jadwal_harian::whereDate('tanggal_jadwal_harian',$start_date)->with(['jadwal_umum','jadwal_umum.instruktur','jadwal_umum.kelas','ijin_instruktur','ijin_instruktur.instruktur','ijin_instruktur.instrukturPengganti'])->get(),
    ];

        return response([
        //* return response
            'message'=>'Success Tampil Data',
            'data' => $jadwal
        ],200); 

    }

    public function findData(Request $request)
    {
        $start_date = Carbon::now()->startOfWeek(Carbon::SUNDAY)->addDay();
        $end_date =  Carbon::now()->startOfWeek(Carbon::SUNDAY)->addDays(7);
    }
    
    
    public function store()
    {
        
        if(self::cekAutoGenerate()){
            return response()->json([
                'success' => false,
                'message' => 'Jadwal harian minggu ini sudah di generate',
                'data' => null,
            ], 400);
        }
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
                
                $jadwalHarian = DB::table('jadwal_harian')
                ->where('tanggal_jadwal_harian', '=', $date->toDateString())
                ->where('id_jadwal_umum', '=', $jadwal->id_jadwal_umum)
                ->first();
                // jika belum ada, maka dilakukan insert
                if (!$jadwalHarian) {
                    DB::table('jadwal_harian')->insert([
                        'tanggal_jadwal_harian' => $date->toDateString(),
                        'status' => 'berjalan',
                        'id_jadwal_umum' => $jadwal->id_jadwal_umum,
                    ]);
            }
            
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


    public function updateLibur($id){
        $jadwal_harian = jadwal_harian::find($id);
        $jadwal_harian->status = 'diliburkan';
        $jadwal_harian->save();
        return response()->json(['message' => 'Jadwal Harian berhasil diliburkan'], 200);
    }
    
    
    public function todayClasses(){
        
        
        $todayClass = jadwal_harian::whereDate('tanggal_jadwal_harian',Carbon::today())->with(['jadwal_umum','jadwal_umum.instruktur','jadwal_umum.kelas','ijin_instruktur','ijin_instruktur.instruktur','ijin_instruktur.instrukturPengganti'])->get();
        
        return response([
            //* return response
            'message'=>'Success Tampil Data',
            'data' => $todayClass
        ],200); 
        
    }

    public function updateJamMulai($id){
        $selectedClass = jadwal_harian::find($id);
        $selectedClass->jam_mulai = Carbon::now();
        $selectedClass->save();
        //* presensi instruktur piye ?

        //* update akumulasi terlambat

        return response()->json(['message' => 'Jam Mulai Berhasil diupdate'], 200);
    }

    public function updateJamSelesai($id)
    {
        $selectedClass = jadwal_harian::find($id);
        $selectedClass->jam_selesai = Carbon::now();
        $selectedClass->save();
        return response()->json(['message' => 'Jam Selesai Berhasil diupdate'], 200);
    }

    //* fungsi cek ada instruktur izin atau engga
    public function cekInstrukturIjin($kelas,$id_instruktur){
        if($kelas->ijin_instruktur == null){
            return false;
        }
        if($kelas->ijin_instruktur['id_instruktur_pengganti'] == $id_instruktur && $kelas->ijin_instruktur['status_ijin'] == 'dikonfirmasi'){
            return true;
        }else{
            return false;
        }

    }
    

    public function getTodayClassesBaseOnInstructure($idIns)
    {
        //* cek instruktur request ada ngga dijadwal atau sebagai isntruktur pengganti;
        $data = [];
        $kelasToday = jadwal_harian::where('tanggal_jadwal_harian', Carbon::today())->with(['jadwal_umum','ijin_instruktur','jadwal_umum.instruktur','jadwal_umum.kelas','ijin_instruktur.instrukturPengganti'])->get();
        $idInstruktur = $idIns;
        foreach($kelasToday as $kelas){
            //* Cek Kelas Berdasarkan instruktur , kelas instruktur pengganti ?
            if($kelas->jadwal_umum['id_instruktur'] == $idInstruktur || self::cekInstrukturIjin($kelas,$idInstruktur)){
                //*cek jam mulai != null baru ditampilin
                if($kelas->jam_mulai != null){
                    $data[]= $kelas;
                }
            }
        }

        return response(['data' => $data]);
    }
}

                
                // $jadwalHarian = DB::table('jadwal_harian')
                // ->get();
                // dd($jadwalHarian);
                // ->join('jadwal_umum', 'jadwal_harian.id_jadwal_umum', '=', 'jadwal_umum.id_jadwal_umum')
                // ->join('kelas', 'jadwal_umum.id_kelaas', '=', 'kelas.id_kelas')
                // ->join('instruktur', 'jadwal_umum.id_instruktur', '=', 'instruktur.id_instruktur')
                // // ->leftJoin('status_jadwal_harian', 'jadwal_harian.status_id', '=', 'status_jadwal_harian.id')
                // // ->leftJoin('izin_instruktur', function ($join) {
                //     // $join->on('jadwal_umum.id', '=', 'izin_instruktur.jadwal_umum_id')
                //         // ->on('jadwal_harian.tanggal', '=', 'izin_instruktur.tanggal_izin')
                //         // ->where('izin_instruktur.is_confirmed', true);
                // // })
                // ->leftJoin('instruktur as instruktur_penganti', 'izin_instruktur.instruktur_penganti_id', '=', 'instruktur_penganti.id')
                // ->select('jadwal_harian.id', 'jadwal_harian.tanggal', 'jadwal_umum.jam_mulai', 'jadwal_umum.hari' ,'kelas.nama as nama_kelas', 'instruktur.nama as nama_instruktur', DB::raw('IFNULL(status_jadwal_harian.jenis_status, "") as jenis_status'), DB::raw('IFNULL(instruktur_penganti.nama, "") as instruktur_penganti'))
                
                // ->orWhere('jadwal_harian.tanggal', 'like', '%'.$request->data.'%')
                //     ->orWhere('jadwal_umum.jam_mulai', 'like', '%'.$request->data.'%')
                //     ->orWhere('kelas.nama', 'like', '%'.$request->data.'%')
                //     ->orWhere('instruktur.nama', 'like', '%'.$request->data.'%')
                //     ->orWhere('status_jadwal_harian.jenis_status', 'like', '%'.$request->data.'%')
                //     ->orWhere('instruktur_penganti.nama', 'like', '%'.$request->data.'%')
            
                // ->orderBy('jadwal_harian.tanggal', 'asc')
                // ->orderBy('jadwal_umum.jam_mulai')
                // ->get()
                // ->groupBy('tanggal')
                // ->map(function ($items) {
                //     return $items->map(function ($item) {
                //         $item->jam_mulai = date('H:i', strtotime($item->jam_mulai));
                //         return $item;
                //     })->sortBy('jam_mulai');
                // })
                // ->groupBy(function ($items, $key) {
                //     return Carbon::parse($key)->startOfWeek()->format('Y-m-d');
                // }, true);
            
                // return response()->json([
                //     'success' => true,
                //     'message' => 'Daftar Jadwal harian',
                //     'data' => $jadwalHarian
                // ], 200);
                // //* find data based on params
                // $jadwal_umum = jadwal_umum::where('id_jadwal_umum', $id_jadwal_umum)->with(['instruktur'])->first();
                
                // //* not found
                // if($jadwal_umum == null)
                // {
                //     return response([
                //         'Jadwal Umum Not Found'
                //     ],404);
                // }
            
                // //* return response
                // return response([
                //     'message'=>'Success Tampil Data',
                //     'data' => $jadwal_umum
                // ],200);