<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class booking_gym extends Model
{
    use HasFactory;
    protected $table = 'booking_gym';
    protected $primaryKey = 'no_booking';
    protected $guarded = [];

    public function sesi()
    {
        return $this->hasOne(sesi_gym::class,'id_sesi','id_sesi');
    }
    public function member()
    {
        return $this->hasOne(user\member::class,'id_member','id_member');
    }
}
