<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class riwayat_aktivitas_member extends Model
{
    use HasFactory;
    protected $table = 'riwayat_aktivitas_member';
    protected $guarded = [];
    protected $primaryKey = 'id_riwayat';
}
