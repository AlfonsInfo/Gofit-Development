<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class member extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'member';
    protected $guarded = [];
    protected $primaryKey = 'id_member';
    protected $dates = ['deleted_at'];

    // public const CREATED_AT = 'created_timestamp';
    // public const UPDATED_AT = 'updated_timestamp';

    protected $casts = [
        'id_member' => 'string'
    ];
    

    public function pengguna()  
    {
        return $this->hasOne('App\Models\User\Pengguna','id_pengguna','id_pengguna');
    }

    public function kelas()
    {
        return $this->hasOne('App\Models\kelas','id_kelas','id_kelas');
    }

    public function latest($column = 'nama_member'){
            return $this->orderBy($column,'desc');
    }

}
