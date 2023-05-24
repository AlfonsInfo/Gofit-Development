<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class presensi_instruktur extends Model
{
    use HasFactory;
    protected $table = 'presensi_instruktur'; 
    protected $primaryKey= 'id_presensi';
    protected $guarded= [];

    public function jadwalHarian()
    {
        return $this->hasOne('App\Models\jadwal_harian','id_jadwal_harian' , 'id_jadwal_harian');
    }



}
