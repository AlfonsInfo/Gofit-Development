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


    public function pegawai(){
        return $this->hasOne(user\pegawai::class,'id_pegawai','id_pegawai');
    }
    public function member(){
        return $this->hasOne(user\member::class,'id_member','id_member');
    }
    public function aktivasi(){
        return $this->belongsTo(transaksi_aktivasi::class,'no_struk_transaksi','no_struk');
    }
    public function deposit_uang(){
        return $this->belongsTo(transaksi_deposit_reguler::class,'no_struk_transaksi','no_struk');
    }
    public function deposit_kelas_paket(){
        return $this->belongsTo(transaksi_deposit_paket::class,'no_struk_transaksi','no_struk');
    }

}
