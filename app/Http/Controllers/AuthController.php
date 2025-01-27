<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest; // Add missing import statement
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {

        return view('auth.login');
    }

    public function doLogin(LoginRequest $request)
    {
        $credentials = $request->validated();

        // Lower case on email
        $credentials['email'] = strtolower($credentials['email']);
        
        $user = User::where('email', $credentials['email'])->first();
        
        if (!$user) {
            return back()->withErrors([
                
                'email' => 'Utilisateur non trouvé',
                ])->onlyInput('email');
            }

        if ( Auth::attempt($credentials)) {
            // Auth user
            Auth::login($user);
            return redirect()->route('admin.courier.index');
        }

        return back()->withErrors([
            'email' => 'Identifiants incorrects',
        ])->onlyInput('email');
    }


    public function logout()
    {
        Auth::logout();

        return redirect()->route('login')->with('success', 'Vous êtes déconnecté.');
    }
}
