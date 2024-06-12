<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Helper;


class LoginController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function login(Request $request){   
        $remember = $request->input('remember');
        $remember = $remember ? true : false;

        
    //    $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required|string',
    //         'remember' => 'boolean'
    //     ]);
        
        $data = [
            'user_email' => $request->email,
            'user_password' => $request->password,
            'token_type' => 'DEFAULT', 
            'seconds_to_expire' => 86400 
        ];
        
        $apiUrl = config('app.api_url') . '/token/generate';

        $response = Http::withToken(config('app.token_ADMIN'))->post($apiUrl, $data);

        if ($response->successful()) {
            $tokenData = $response->json();
            $tokenId = $tokenData['token_id'];

            if ($request->remember) {
                Cookie::queue('auth_token', $tokenId, 60 * 24); 
            } else {
                Session::put('auth_token', $tokenId);
            }
            return redirect('dashboard');
        } else {
            $errors = ['invalid' => 'Email ou senha inválidos.'];
            return redirect('login')->withInput()->withErrors($errors);
        }
    }

    public function logout(Request $request)
    {
        // Auth::logout();

        // $request->session()->invalidate();

        // $request->session()->regenerateToken();

        return redirect('/');
    }
}
