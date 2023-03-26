<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class instruktur extends Model
{
    use HasFactory;
    // protected $guarded = ['id_pengguna'];
    protected $table = 'instruktur';
    // protected $primaryKey = 'id_pengguna';

    // public const CREATED_AT = 'created_timestamp';
    // public const UPDATED_AT = 'updated_timestamp';

    public function pengguna()
    {
        return $this->hasOne('\pengguna');
    }

    public function kelas()
    {
        return $this->hasMany('..\kelas');
    }
}





// <!-- id_instruktur	id_pengguna	nama_instruktur	tanggal_lahir_instruktur	alamat_instruktur	no_telp_instruktur	created_at	updated_at	deleted_at	 -->