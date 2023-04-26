<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaksi_aktivasi extends Model
{
    use HasFactory;

    protected $table = 'transaksi_aktivasi';  
    protected $guarded = ['id_aktivasi'];
    protected $primaryKey = 'id_aktivasi';
      

}
