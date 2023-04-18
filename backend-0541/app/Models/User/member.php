<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class member extends Model
{
    use HasFactory;
    protected $table = 'member';
    protected $guarded = ['id_member'];
    protected $primaryKey = 'id_member';

    // public const CREATED_AT = 'created_timestamp';
    // public const UPDATED_AT = 'updated_timestamp';

    protected $casts = [
        'id_member' => 'string'
    ];
    

    public function pengguna()
    {
        return $this->hasOne('App\Models\User\Pengguna','id_pengguna','id_pengguna');
    }

    public function latest($column = 'nama_member'){
            return $this->orderBy($column,'desc');
    }

}
