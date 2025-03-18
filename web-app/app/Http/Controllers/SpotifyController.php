<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SpotifyController extends Controller
{
    public function getToken()
    {
        $clientId = config('services.spotify.client_id');
        $clientSecret = config('services.spotify.client_secret');

        $response = Http::asForm()
            ->withBasicAuth($clientId, $clientSecret)
            ->post('https://accounts.spotify.com/api/token', [
                'grant_type' => 'client_credentials'
            ]);

        if ($response->ok()) {
            return $response->json();
        } else {
            return response()->json(['error' => 'Impossibile ottenere token'], 400);
        }
    }

    public function searchTrack(Request $request)
    {
        $token = $request->query('token');
        $query = $request->query('q');
        
        if (!$token || !$query) {
            return response()->json(['error' => 'Manca token o query'], 400);
        }

        $url = 'https://api.spotify.com/v1/search';
        $result = Http::withToken($token)->get($url, [
            'q'    => $query,
            'type' => 'track',
            'limit'=> 5
        ]);

        return $result->json();
    }
}
