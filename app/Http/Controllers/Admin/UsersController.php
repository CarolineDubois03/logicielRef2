<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;


class UsersController extends Controller
{
    public function index()
    {
        // Logique pour afficher la liste des utilisateurs
    }

    /**
     * Affiche le formulaire de création d'un nouvel utilisateur.
     */
    public function create()
    {
        return view('admin.profile.form', ['user' => new User()]);
    }

    /**
     * Stocke un nouvel utilisateur dans la base de données.
     */
    public function store(Request $request)
    {
        // Logique pour stocker un nouvel utilisateur
    }

    /**
     * Affiche les détails d'un utilisateur spécifique.
     */
    public function show()
    {
        return view('admin.profile.show');
    }
    
    /**
     * Affiche le formulaire de modification d'un utilisateur.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('admin.profile.edit', compact('user'));
    }

    /**
     * Met à jour les informations d'un utilisateur dans la base de données.
     */
    public function update(Request $request, $id)
    {
        // Récupérer l'ID de l'utilisateur à partir de la requête
        $userId = $request->input('user_id');
    
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'login' => 'required|string|max:255|unique:users,login,'.$userId,
            'email' => 'required|string|email|max:255|unique:users,email,'.$userId,
        ]);
    
        // Récupérer l'utilisateur à mettre à jour
        $user = User::findOrFail($userId);
    
        // Mettre à jour les informations de l'utilisateur
        $user->update([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'login' => $validatedData['login'],
            'email' => $validatedData['email'],
        ]);
    
        // Rediriger l'utilisateur avec un message de succès
        return redirect()->route('admin.profile.show')->with('success', 'Profil mis à jour avec succès.');
    }
    

    /**
     * Supprime un utilisateur de la base de données.
     */
    public function destroy(string $id)
    {
        // Logique pour supprimer un utilisateur
    }

    /**
     * Affiche le formulaire de changement de mot de passe.
     */
    public function showChangePasswordForm()
    {
        return view('admin.profile.change-password');
    }

    /**
     * Met à jour le mot de passe de l'utilisateur.
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Ancien mot de passe incorrect']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('admin.profile.show')->with('success', 'Mot de passe mis à jour avec succès.');
    }




    public function search(Request $request)
    {
        $query = $request->get('q', '');
        return User::where('first_name', 'LIKE', '%' . $query . '%')
            ->orWhere('last_name', 'LIKE', '%' . $query . '%')
            ->get(['id', 'first_name', 'last_name']);
    }



}
