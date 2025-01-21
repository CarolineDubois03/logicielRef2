<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use App\Models\Recipient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    // Afficher la liste des utilisateurs
    public function index()
    {
        $users = User::all();
        return view('admin.settings', compact('users'));
    }

    // Enregistrer un nouvel utilisateur
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed', // Ajouté pour confirmation du mot de passe si besoin
        ]);

        User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')), // Hachage du mot de passe
        ]);

        return redirect()->route('admin.courier.settings', ['tab' => 'users'])->with('success', 'Utilisateur ajouté avec succès.');
    }

    // Mettre à jour un utilisateur existant
    public function update(Request $request, $id)
    {
        dd($request->all());
        $user = User::findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
        ]);

        return redirect()->route('admin.courier.settings', ['tab' => 'users'])->with('success', 'Utilisateur modifié avec succès.');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    // Supprimer un utilisateur
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.courier.settings', ['tab' => 'users'])->with('success', 'Utilisateur supprimé avec succès.');
    }

    public function search(Request $request)
    {
        try {
            $query = $request->get('q'); // Terme de recherche
            $users = User::where('first_name', 'like', "%{$query}%")
                         ->orWhere('last_name', 'like', "%{$query}%")
                         ->limit(10)
                         ->get();
    
            $results = $users->map(function ($user) {
                return [
                    'id' => $user->id,
                    'text' => $user->first_name . ' ' . $user->last_name,
                ];
            });
    
            return response()->json($results); // Retourne les données au format JSON
        } catch (\Exception $e) {
            // Log l'erreur pour la diagnostiquer
            \Log::error($e->getMessage());
            return response()->json(['error' => 'Une erreur s\'est produite.'], 500);
        }
    }


    
    

}
