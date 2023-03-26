<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pengguna extends Model
{
    use HasFactory;
    // protected $guarded = ['id_pengguna'];
    protected $table = 'pengguna';
    // protected $primaryKey = 'id_pengguna';

    // public const CREATED_AT = 'created_timestamp';
    // public const UPDATED_AT = 'updated_timestamp';


}
