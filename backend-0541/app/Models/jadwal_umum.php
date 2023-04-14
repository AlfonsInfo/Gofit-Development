<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User\instruktur;

class jadwal_umum extends Model
{
    use HasFactory;
    protected $table = 'jadwal_umum';  
    protected $primaryKey = 'id_jadwal_umum';
    

    public function instruktur()
    {
        return $this->hasOne('App\Models\User\instruktur','id_instruktur','id_instruktur');
    }
}
