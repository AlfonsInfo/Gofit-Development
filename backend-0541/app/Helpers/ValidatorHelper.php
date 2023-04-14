<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Validator;


class ValidatorHelper{

    //*Validasi Instruktur
    public static function validateInstruktur($data)
    {
                $validator = Validator::make($data ,[
                    'nama_instruktur' => 'required',
                    'tanggal_lahir_instruktur' => 'required',
                    'alamat_instruktur' => 'required',
                    'no_telp_instruktur' => 'required',
                    'username' => 'required',
                    'password' => 'required'
                ]);
                return $validator; 
    }

    public static function validateJadwalUmum($data)
    {
                $validator = Validator::make($data ,[
                    'hari' => 'required',
                    'id_instruktur' => 'required',
                    'id_kelas' => 'required',
                    'jam_mulai'=> 'required',
                    'jam_selesai' => 'required'
                ]);
                return $validator; 
    }
    
    
}


?>