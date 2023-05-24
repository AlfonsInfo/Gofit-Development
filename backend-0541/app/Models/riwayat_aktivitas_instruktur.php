<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class riwayat_aktivitas_instruktur extends Model
{
    use HasFactory;
    protected $table = 'riwayat_aktivitas_instruktur';
    protected $guarded = [];
    protected $primaryKey = 'id_riwayat';
    
}
