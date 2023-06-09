<?php

use App\Http\Controllers\instrukturController;
use App\Http\Controllers\kelasController;
use App\Http\Controllers\loginWebController;
use App\Http\Controllers\sesiGymController;
use App\Models\kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\FlareClient\Api;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| 
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['middleware' => ['cors','customCors']], function () {
    // ->middleware('cors');
    // Route::post('login', loginWebController::class)->middleware('cors');
    Route::post('login', 'loginWebController');
    Route::apiResource('/sesiGym', 'sesiGymController');
    Route::post('login-mobile', 'loginMobileController');
    // Route::post('/kelas', 'kelasController@index');
    route::apiResource('/kelas', 'kelasController');
    // Route::post('/instruktur', 'instrukturController@index');
    // Route::post('/instruktur/{id}', 'instrukturController@show');
    Route::apiResource('/instruktur', 'instrukturController')->middleware('cors');
    Route::apiResource('/jadwalumum', 'jadwalUmumController');
    Route::apiResource('/jadwalharian', 'jadwalHarianController');
    Route::get('/classlist', 'jadwalHarianController@ClassList');
    Route::post('/jadwalharianfind', 'jadwalHarianController@findData');
    Route::get('/jadwalharianlibur/{id}', 'jadwalHarianController@updateLibur');
    Route::apiResource('/promo', 'promoController');
    Route::apiResource('/member', 'memberController');
    Route::apiResource('/pengguna', 'penggunaController');
    Route::apiResource('/ijininstruktur', 'ijinInstrukturController');  
    Route::get('/ijininstrukturforconfirm', 'ijinInstrukturController@getOnlyBeforePermit');  
    Route::post('/selectijin', 'ijinInstrukturController@indexByInstruktur');  
    Route::apiResource('/presensigym', 'presensiGymController');  
    Route::apiResource('/presensikelas', 'presensiKelasController');  
    Route::apiResource('/bookinggym', 'bookingGymController');  
    Route::apiResource('/bookingkelas', 'bookingKelasController');  
    Route::apiResource('/transaksibooking', 'bookingKelasController@');  
    
    //*History Aktivitas
    Route::apiResource('/riwayatmember', 'riwayatMemberController');  
    Route::apiResource('/riwayatinstruktur', 'riwayatInstrukturController');  
    
    Route::apiResource('/transaksi', 'transaksiController');  
    Route::post('/hitungtransaksi', 'transaksiController@countTransaction');
    Route::get('/transaksihariini' , 'transaksiController@todayTransaction');
    Route::apiResource('/transaksiaktivasi', 'aktivasiController');  
    Route::post('/aktivasi', 'aktivasiController@store2');  
    Route::apiResource('/transaksideposituang', 'depositUangController');  
    Route::apiResource('/transaksidepositpaket', 'depositPaketController');  
    Route::get('/td-deposituang', 'depositUangController@todayTransaction');
    
    Route::get('/updatememberexpired/{id}',  'memberController@updateExpireDate');
    Route::put('/updatedepositbalanceuang/{id}',  'memberController@updateTotalDeposit');
    
    Route::post('/resetbyuser', 'penggunaController@ResetPassword');
    Route::post('/jadwalbyinstruktur', 'jadwalUmumController@JadwalByInstruktur');
    
    Route::get('/showmemberdeaktif', 'memberController@memberKadeluarsa');
    Route::get('/deaktivasimember', 'memberController@memberDeaktivasi');
    
    Route::get('/depositkadeluarsa', 'memberController@depositkadeluarsa');
    Route::get('/resetdeposit', 'memberController@resetDeposit');
    Route::get('/resetterlambat', 'instrukturController@resetTerlambat');


    //* Coding 4
    Route::post('/tampilbookinggym', 'bookingGymController@showData');
    Route::put('/cancelbookinggym/{noBook}', 'bookingGymController@cancelBookingGym');
    Route::get('/todayclasses', 'jadwalHarianController@todayClasses');
    Route::put('/updatemulai/{id}', 'jadwalHarianController@updateJamMulai');
    Route::put('/updateselesai/{id}', 'jadwalHarianController@updateJamSelesai');
    Route::get('/todayclassesinstructure/{idIns}', 'jadwalHarianController@getTodayClassesBaseOnInstructure');
    
    Route::get('/memberkelasbyjadwal/{jadwal}', 'bookingKelasController@getMemberKelasByJadwal');
    Route::put('/kehadirankelas/{noBook}', 'bookingKelasController@presensiKelas');
    Route::put('/absenkelas/{noBook}', 'bookingKelasController@absenKelas');
    
    Route::post('/cetakstrukgym/{noBooking}', 'presensiGymController@generateStrukTransaksi');  
    Route::post('/cetakstrukkelas/{noBooking}', 'presensiKelasController@generateStrukTransaksi');  
    
    //* Jadwal umum mobile;
    Route::get('/jadwalumummobile', 'jadwalUmumController@getJadwalMobile');

    //* History     
    Route::get('/riwayataktivitasmember', 'riwayatMemberController@showRiwayatByMember');
    Route::get('/riwayataktivitasinstruktur', 'riwayatInstrukturController@riwayatInstruktur');
    
    //*History2
    Route::get('/riwayataktivitasmembergym', 'riwayatMemberController@showRiwayatByMemberGym');
    Route::get('/riwayataktivitasmemberkelas', 'riwayatMemberController@showRiwayatByMemberKelas');
    // Route::get('/riwayataktivitasinstruktur2', 'riwayatInstrukturController@showRiwayatByInstruktur');
    Route::get('/riwayataktivitasmembergymfilter', 'riwayatMemberController@showRiwayatByMemberGymFilter');
    Route::get('/riwayataktivitasmemberkelasfilter', 'riwayatMemberController@showRiwayatByMemberKelasFilter');
    
    //* History by merge presensi dan ijin
    Route::get('/riwayataktivitasinstrukturmerge', 'riwayatInstrukturController@mergeIjinPresensi');

    
    //* Laporan Ges
    Route::get('laporanaktivitasgym','laporanController@aktivitasGymBulanan');
    Route::get('laporanaktivitaskelas','laporanController@aktivitasKelasBulanan');
    Route::get('laporankinerjainstruktur','laporanController@kinerjaInstrukturBulanan');
    Route::get('laporanpendapatantahunan','laporanController@laporanPendapatanPerTahun');

});
