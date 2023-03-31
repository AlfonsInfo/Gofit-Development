<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jadwal_umum extends Model
{
    use HasFactory;
    protected $table = 'jadwal_umum';  
    protected $primaryKey = 'id_jadwal_umum';
    
}
