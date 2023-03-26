<?php
use App\Models\Pengguna;
$users = Pengguna::all();

?>


@foreach ($users as $user)
    {{ $user->username }}
@endforeach
