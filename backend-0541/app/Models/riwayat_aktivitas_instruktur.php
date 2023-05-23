<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class member extends Model
{
    use HasFactory;
    // use SoftDeletes;
    protected $table = 'riwayat_aktivitas_member';
    protected $guarded = [];
    protected $primaryKey = 'id_riwayat';
    // protected $dates = ['deleted_at'];

    // public const CREATED_AT = 'created_timestamp';
    // public const UPDATED_AT = 'updated_timestamp';

    // protected $casts = [
    //     'id_member' => 'string'
    // ];
    

    public function member()
    {
        return $this->hasOne('App\Models\User\member','id_member','id_member');
    }

    // public function latest($column = 'nama_member'){
    //         return $this->orderBy($column,'desc');
    // }

}
