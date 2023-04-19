<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ijin_instruktur extends Model
{   
    use HasFactory;
    protected $table = 'ijin_instruktur';
    
    
    public function instruktur()
    {
        return $this->hasOne('App\Models\User\instruktur','id_instruktur','id_instruktur');
    }
    public function instrukturPengganti()
    {
        return $this->hasOne('App\Models\User\instruktur','id_instruktur','id_instruktur_pengganti');
    }

}
