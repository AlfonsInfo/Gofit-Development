<?php

namespace App\Models\User;

use App\Models\jadwal_harian;
use App\Models\jadwal_umum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class instruktur extends Model
{
    use HasFactory;
    protected $table = 'instruktur';
    protected $guarded = ['id_instruktur'];
    protected $primaryKey = 'id_instruktur';

    // public const CREATED_AT = 'created_timestamp';
    // public const UPDATED_AT = 'updated_timestamp';
    protected $casts = [
        'id_instruktur' => 'string'
    ];


    public function pengguna()
    {
        return $this->hasOne(pengguna::class,'id_pengguna','id_pengguna');
    }
    public function jadwalharian()
    {
        return $this->belongsTo(jadwal_umum::class,'id_instruktur','id_instruktur');
    }

}





// <!-- id_instruktur	id_pengguna	nama_instruktur	tanggal_lahir_instruktur	alamat_instruktur	no_telp_instruktur	created_at	updated_at	deleted_at	 -->