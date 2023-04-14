<?php

namespace App\Models\User;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
// use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;


class pengguna extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    protected $table = 'pengguna';

    protected $guarded = ['id_pengguna'];
    protected $primaryKey = 'id_pengguna';

    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function getCreatedAttribute()
    {
        if(!is_null($this->attributes['created_at']))
        {
            return Carbon::parse($this->attributes['created_at'])->format('Y-m-d H:i:s');
        }
    }

    public function getUpdatedAtAttribute()
    {
        if(!is_null($this->attributes['updated_at']))
        {
            return Carbon::parse($this->attributes['updated_at'])->format('Y-m-d H:i:s');
        }
    }


}
