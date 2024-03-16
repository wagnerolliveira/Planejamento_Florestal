<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateUserFormRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function showRegistrationForm(Request $request)
    {
        return view('auth.register');
    }

    public function register(StoreUpdateUserFormRequest $request)
    {
        $data=$request->all();
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);
        
        $request->session()->regenerate();
        return redirect()->route('home');
    }
}
