<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaksi_deposit_paket extends Model
{
    use HasFactory;
    protected $table = 'transaksi_deposit_paket';
    protected $guarded = ['id_deposit_paket'];  
    protected $primaryKey = 'id_deposit_paket';

    public function promo()
    {
        return $this->hasOne('App\Models\promo','id_promo','id_promo');
    }
    public function transaksi_member()
    {
        return $this->hasOne('App\Models\transaksi_member','no_struk_transaksi','no_struk');
    }
    public function kelas()
    {
        return $this->hasOne('App\Models\kelas','id_kelas','id_kelas');
    }

}
