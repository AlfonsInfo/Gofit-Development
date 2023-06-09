<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\jadwal_umum;
use App\Helpers\ValidatorHelper;
use App\Models\ijin_instruktur;
use App\Models\jadwal_harian;
use App\Models\booking_kelas;
use App\Models\kelas;
use App\Models\presensi_instruktur;
use Carbon\Carbon;
use Database\Seeders\jadwal;
use Exception;
use Illuminate\Support\Facades\DB;
class jadwalHarianController extends Controller
{

    //* Cek Auto Generate Seminggu 1x
    public function cekAutoGenerate(){
        $jadwalHarian = jadwal_harian::where('tanggal_jadwal_harian', '>', Carbon::now()->startOfWeek(Carbon::SUNDAY)->format('Y-m-d'))
            ->first();
        if(is_null($jadwalHarian)){
            return false;
        }else{
            return true;
        }
    }

    //* Untuk Nampilin Data Jadwal harian untuk Website
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

    //* Generate JadwalHarian 1 minggu
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
            'monday' => 'Senin',
            'tuesday' => 'Selasa',
            'wednesday' => 'Rabu',
            'thursday' => 'Kamis',
            'friday' => 'Jumat',
            'saturday' => 'Sabtu',
            'sunday' => 'Minggu'
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
        //*return response
        return response([
        ]);
    }

    //*! */ Update // (KOK MASIH JADWAL UMUM WKWKWK)
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

    //* UPDATE LIBUR
    public function updateLibur($id){
        $jadwal_harian = jadwal_harian::find($id);
        $jadwal_harian->status = 'diliburkan';
        $jadwal_harian->save();
        return response()->json(['message' => 'Jadwal Harian berhasil diliburkan'], 200);
    }
    
    //* UNTUK MOBILE APPS (TAMPILIN TODAY CLASSES DI LOGIN SEBAGAI MO)    
    public function todayClasses(){
        $todayClass = jadwal_harian::whereDate('tanggal_jadwal_harian',Carbon::today())->with(['jadwal_umum','jadwal_umum.instruktur','jadwal_umum.kelas','ijin_instruktur','ijin_instruktur.instruktur','ijin_instruktur.instrukturPengganti'])->get();
        return response([
            //* return response
            'message'=>'Success Tampil Data',
            'data' => $todayClass
        ],200); 
        
    }

    //* Update Jam Mulai ( Pada jadwal harian dan presensi instruktur)
    public function updateJamMulai($id, Request $request){
        $waktu_sekarang = Carbon::now();

        // return response([$request->id_instruktur]);
        // dd($request->id_instruktur);

        $selectedClass = jadwal_harian::find($id);
        $selectedClass->jam_mulai = $waktu_sekarang;
        $selectedClass->save();
        //* presensi instruktur piye ?

        //* Simpan ke tabel presensi instruktur
        $storepresensiInstruktur = presensi_instruktur::create([
            'waktu_presensi' => $waktu_sekarang,
            'status_presensi' => 'hadir',
            'id_instruktur' => $request->id_instruktur,
            'id_jadwal_harian' => $id
        ]);
        //* update akumulasi terlambat

        return response()->json([
            'message' => 'Jam Mulai Berhasil diupdate',
            'data_presensi' => $storepresensiInstruktur],200);
    }

    //* Update Jam Selesai (Pada Jadwal harian dan presensi isntruktur)
        public function updateJamSelesai($id, Request $request)
        {
            try{
                $waktu_sekarang = Carbon::now();
                //* Table Jadwal Harian
                $selectedClass = jadwal_harian::find($id);
                $selectedClass->jam_selesai = $waktu_sekarang;
                $selectedClass->save();
                

                
                return response()->json(['message' => 'Jam Selesai Berhasil diupdate'], 200);
            }catch(Exception $e){
                return response([
                    'data' => 'Gagal',
                    'exception' => $e]);
            }
        }

    //* Cek Adakah Data di Ijin instruktur
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
    
    //* Untuk Nampilin Data Login Sebagai Instruktur
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


    public function ClassList(){

        $today = Carbon::now();
        $class = jadwal_harian::whereDate('tanggal_jadwal_harian', '>', $today)
        ->with(['jadwal_umum', 'jadwal_umum.instruktur', 'jadwal_umum.kelas', 'ijin_instruktur', 'ijin_instruktur.instruktur', 'ijin_instruktur.instrukturPengganti'])
        ->get();

        
        foreach ($class as $jadwal) {
            $jumlah_booking_kelas = booking_kelas::where('id_jadwal_harian', $jadwal->id_jadwal_harian)->where('is_canceled', 0)->count();
            $jadwal->jumlah_peserta_kelas = $jumlah_booking_kelas;
        }
        
        return response(['data'=> $class]);
    }

}

