<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function getWeather(Request $request)
    {
        $city = $request->query('city');
        if (!$city) {
            return response()->json(['error' => 'Parametro city mancante'], 400);
        }

        $apiKey = config('services.weather.key');
        if (!$apiKey) {
            return response()->json(['error' => 'API key mancante nel .env'], 500);
        }

    
        $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
            'q' => $city,
            'appid' => $apiKey,
            'units' => 'metric',
            'lang' => 'it'
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'Errore chiamata meteo'], 500);
        }

        return $response->json();
    }
}
