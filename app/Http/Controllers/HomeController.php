<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Helper;

class HomeController extends Controller
{
    public function index(){
        $Auth = Helper::validateToken();

        $user=[];
        $domain=[];
        
        if ($Auth['valid']){
            $user=$Auth['user'];
            $domain=$Auth['domain'];
            
        }

        return view('home', compact('user','domain'));
    }

}
