<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
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

        return view('zone');
    }
}
