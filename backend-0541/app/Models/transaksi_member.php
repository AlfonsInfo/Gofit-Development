<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaksi_member extends Model
{
    use HasFactory;
    protected $table = 'transaksi_member';  
    protected $guarded = ['no_struk_transaksi'];  
    protected $primaryKey = 'no_struk_transaksi';
    
    protected $casts = [
        'no_struk_transaksi' => 'string'
    ];

}
