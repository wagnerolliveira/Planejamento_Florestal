<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    public function index(){
        $Auth = Helper::validateToken();
       
        if ($Auth['valid']){
            $user=$Auth['user'];
            $domain=$Auth['domain'];
        }
        else{
            return redirect()->route('login');
        }

        $token = Session::get('auth_token', Cookie::get('auth_token'));
        $apiUrl = config('app.api_url').'/zone/'.$domain['domain_name'].'/list';
        $response = Http::withToken($token)->get($apiUrl);


        if ($response->successful()) {
            $zones = $response->json();
            
        }

        return view('zone', compact('user','domain','zones'));
    }
}
