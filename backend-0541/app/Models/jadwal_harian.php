<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jadwal_harian extends Model
{
    use HasFactory;
    protected $table = 'jadwal_harian';
    protected $primaryKey = 'id_jadwal_harian';
    protected $guarded = [];

    public function jadwal_umum(){
        return $this->hasOne(jadwal_umum::class,'id_jadwal_umum','id_jadwal_umum');
    }

    public function ijin_instruktur(){
        return $this->belongsTo(ijin_instruktur::class,'id_jadwal_harian','id_jadwal_harian');
    }

}
