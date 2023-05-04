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
    Route::post('login-mobile', 'loginMobileController');
    Route::post('/sesiGym', 'sesiGymController@index');
    // Route::post('/kelas', 'kelasController@index');
    route::apiResource('/kelas', 'kelasController');
    // Route::post('/instruktur', 'instrukturController@index');
    // Route::post('/instruktur/{id}', 'instrukturController@show');
    Route::apiResource('/instruktur', 'instrukturController')->middleware('cors');
    Route::apiResource('/jadwalumum', 'jadwalController');
    Route::apiResource('/jadwalharian', 'jadwalHarianController');
    Route::post('/jadwalharianfind', 'jadwalHarianController@findData');
    Route::get('/jadwalharianlibur/{id}', 'jadwalHarianController@updateLibur');
    Route::apiResource('/promo', 'promoController');
    Route::apiResource('/member', 'memberController');
    Route::apiResource('/pengguna', 'penggunaController');
    Route::apiResource('/ijininstruktur', 'ijinInstrukturController');  
    Route::apiResource('/presensigym', 'presensiGymController');  
    Route::apiResource('/presensikelas', 'presensiKelasController');  

    Route::post('/hitungtransaksi', 'transaksiController@countTransaction');
    Route::get('/transaksihariini' , 'transaksiController@todayTransaction');
    Route::apiResource('/transaksiaktivasi', 'aktivasiController');  
    Route::apiResource('/transaksideposituang', 'depositUangController');  
    Route::apiResource('/transaksidepositpaket', 'depositPaketController');  
    Route::get('/td-deposituang', 'depositUangController@todayTransaction');
    
    Route::get('/updatememberexpired/{id}',  'memberController@updateExpireDate');
    Route::put('/updatedepositbalanceuang/{id}',  'memberController@updateTotalDeposit');
});
