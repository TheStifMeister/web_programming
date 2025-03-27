<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SpotifyController extends Controller
{
    public function searchTrack(Request $request)
    {
        $query = $request->query('q');

        if (!$query) {
            return response()->json(['error' => 'Manca il parametro ?q=...'], 400);
        }
        $clientId = config('services.spotify.client_id');
        $clientSecret = config('services.spotify.client_secret');

        $tokenResponse = Http::asForm()
            ->withBasicAuth($clientId, $clientSecret)
            ->post('https://accounts.spotify.com/api/token', [
                'grant_type' => 'client_credentials'
            ]);

        if ($tokenResponse->failed()) {
            return response()->json(['error' => 'Impossibile ottenere token Spotify'], 500);
        }

        $tokenData = $tokenResponse->json();
        if (!isset($tokenData['access_token'])) {
            return response()->json(['error' => 'Token non presente nella risposta'], 500);
        }

        $accessToken = $tokenData['access_token'];

        $result = Http::withToken($accessToken)->get('https://api.spotify.com/v1/search', [
            'q'    => $query,
            'type' => 'track',
            'limit'=> 5
        ]);

        if ($result->failed()) {
            return response()->json(['error' => 'Chiamata a Spotify fallita'], 500);
        }
        
        return $result->json();
    }
}
