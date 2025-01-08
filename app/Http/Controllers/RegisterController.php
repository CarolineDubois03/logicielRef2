<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\UsersFormRequest;

class RegisterController extends Controller
{
    /**
     * Affiche le formulaire d'inscription.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Gère l'inscription d'un nouvel utilisateur.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        try {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'login' => 'required|string|max:255|unique:users,login',
                'email' => 'required|string|email|max:255|unique:users,email',
                'password' => 'required|string|min:8',
                'password_confirmation' => 'required|string|same:password',
                'id_service' => 'required|integer|exists:services,id',
            ]);
            
            // Assigner les valeurs des champs du formulaire aux variables correspondantes
            $first_name = $request->first_name;
            $last_name = $request->last_name;
            $login = $request->login;
            $email = $request->email;
            $password = Hash::make($request->password);
            $id_service = $request->id_service;
    
            // Créer un nouvel utilisateur avec les données validées
            User::create([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'login' => $login,
                'email' => $email,
                'password' => $password,
                'id_service' => $id_service,
            ]);
            
            
    
            return redirect()->route('login')->with('success', 'Votre compte a été créé avec succès. Veuillez vous connecter.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withInput()->withErrors($e->errors());
        }
    }
    
}
