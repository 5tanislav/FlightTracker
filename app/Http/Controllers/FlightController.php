<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function index()
    {
        $queryString = http_build_query([
          'api_key' => config('services.key.api'),
          'arr_iata' => 'KBP'
        ]);

        $ch = curl_init(sprintf('%s?%s', 'https://airlabs.co/api/v9/flights', $queryString));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $json = curl_exec($ch);
        curl_close($ch);

        $api_result = json_decode($json, true);
        dd($api_result);
        return ($api_result);
    }
}
