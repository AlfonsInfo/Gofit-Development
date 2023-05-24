<?php

namespace App\Http\Controllers;

use App\Models\promo;

class promoController extends Controller {
    
    function index(){
        $promo = promo::latest()->get();
        return response(
            [
                'message' => 'Show Promo Success',
                'promo' => $promo
            ],200
        );
    }

    function show($key)
    {
        $promo = promo::get($key);
        return response(
            [
                'message' => 'Show Sesi Gym Success',
                'sesiGym' => $promo
            ],200
        );
    }
}
