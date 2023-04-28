<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\promo;
use Illuminate\Support\Facades\Validator;

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
