<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Stevebauman\Location\Facades\Location;

class LokasiController extends Controller
{
    public function cek_lokasi(Request $request)
    {
        // $clientIP = request()->ip();
        $clientIP = "114.5.16.107";
        $position = Location::get($clientIP);

        dd($position);
    }
}
