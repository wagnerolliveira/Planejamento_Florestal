<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Helper;

class HomeController extends Controller
{
    public function index(){
        return view('home');
    }

    public function dashboard(){
        $Auth = Helper::validateToken();

        if ($Auth['valid']){
            $user=$Auth['user'];
            $domain=$Auth['domain'];
            return view('dashboard', compact('user','domain'));
        }
        else{
            return redirect()->route('login');
        }
        
    }
}
