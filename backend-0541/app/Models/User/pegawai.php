<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';
    // protected $primaryKey = 'id_pengguna';


    public function pengguna()
    {
        return $this->hasOne('\pengguna');
    }
}
