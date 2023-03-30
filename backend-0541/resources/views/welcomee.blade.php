<?php
use Illuminate\Support\Facades\DB;
// use App\Models\Pengguna;
// $users = Pengguna::all();
$data = 1;
$jadwalharian = DB::table('jadwal_harian')->where('id_jadwal_harian',$data)->get();
?>


@foreach ($jadwalharian as $jadwal)
<p>test</p>
    {{ var_dump($jadwal) }}
@endforeach
