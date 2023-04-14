<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Validator;


class ValidatorHelper{

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
    
    
}


?>