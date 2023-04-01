<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class member extends Model
{
    use HasFactory;
    protected $table = 'member';
    // protected $primaryKey = 'id_pengguna';

    // public const CREATED_AT = 'created_timestamp';
    // public const UPDATED_AT = 'updated_timestamp';
    

public function pengguna()
{
    return $this->hasOne('\pengguna');
}
}
