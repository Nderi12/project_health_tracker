<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class APIKeyController extends Controller
{
    public function mapsApiKey()
    {
        $googleMapsApiKey = \env('GOOGLE_MAPS_API_KEY');

        return $googleMapsApiKey;
    }
}
