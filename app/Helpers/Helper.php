<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
class Helper
{   
    public static function validateToken()
    {
        $token = Session::get('auth_token', Cookie::get('auth_token'));
        if (!$token) {
            return [
                'valid' => false,
                'user' => null,
                'message' => 'Token not found'
            ]; 
        }
        $apiUrl = config('app.api_url') . '/token/validate';
        $response = Http::withToken($token)->get($apiUrl);
        if ($response->successful()) {
            $data = $response->json();
            return [
                'valid' => $data['is_valid'],
                'user' => $data['user'],
                'domain' => $data['domain'],
                'message' => 'Token is valid'
            ];
        }
        
        return [
            'valid' => false,
            'user' => null,
            'message' => 'Token is invalid'
        ];
    }

    public function getToken(Request $request){
        $token = session('auth_token');

        if (!$token) {
            $token = $request->cookie('auth_token');
        }
        $Auth = Helper::validateToken();
        return response()->json(['token' => $token, 'user_name'=> $Auth['user']['user_name'], 'domain_name'=> $Auth['domain']['domain_name']]);
    }
}