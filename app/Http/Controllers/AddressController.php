<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AddressController extends Controller
{
    public function autocomplete(Request $request)
    {
        $query = $request->input('query');
        $url = 'https://nominatim.openstreetmap.org/search';

        try {
            $response = Http::get($url, [
                'q' => $query,
                'format' => 'json',
                'addressdetails' => 1,
                'limit' => 5
            ]);

            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                return response()->json([
                    'error' => 'API request failed',
                    'status_code' => $response->status(),
                    'body' => $response->body()
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

}
