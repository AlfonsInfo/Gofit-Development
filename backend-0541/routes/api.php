<?php

use App\Http\Controllers\instrukturController;
use App\Http\Controllers\kelasController;
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

Route::post('/login', loginController::class);
// Route::post('/sesiGym', [sesiGymController::class, 'index']);
// Route::post('/kelas', [kelasController::class, 'index']);
// Route::post('/promo', [kelasController::class, 'index']);
Route::post('/sesiGym', 'sesiGymController@index');
Route::post('/kelas', [kelasController::class, 'index']);
Route::post('/instruktur', [instrukturController::class, 'index']);
// Route::post('/instruktur', [instrukturController::class, 'index']);
// Route::post('/promo', [kelasController::class, '']);
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
