<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use App\Models\Recipient;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            'email' => 'required|email|unique:users,email',
            'id_service' => 'required|exists:services,id',
        ]);
    
        // Vérifie le rôle de l'utilisateur connecté
        $role = auth()->user()->role === 'responsable' ? 'user' : $request->input('role', 'user');
    
        // Crée un mot de passe par défaut
        $defaultPassword = Str::random(12);
    
        // Générer le login basé sur les 3 premières lettres du prénom et du nom
            $login = strtolower(substr($request->input('first_name'), 0, 3) . substr($request->input('last_name'), 0, 3));

            // S'assurer que le login est unique dans la base de données
            $originalLogin = $login;
            $counter = 1;
            while (User::where('login', $login)->exists()) {
                $login = $originalLogin . $counter;
                $counter++;
            }

        // Créer l'utilisateur
        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'login' => $login, 
            'role' => $role,
            'id_service' => $request->input('id_service'),
            'password' => bcrypt($defaultPassword), // Mot de passe temporaire
        ]);
    
        // Envoie un email pour que l'utilisateur définisse un mot de passe
        $user->sendPasswordResetNotification($user->createToken(name: 'password-reset')->plainTextToken);
    
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur ajouté avec succès. Un email a été envoyé à l\'utilisateur pour définir son mot de passe.');
    }
    

    // Mettre à jour un utilisateur existant
    public function update(Request $request, $id)
    {
       
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
            'role' => $request->input('role'),
            'id_service' => $request->input('id_service'),
        ]);

        return redirect()->route('admin.courier.settings', ['tab' => 'users'])->with('success', 'Utilisateur modifié avec succès.');
    }

    public function updateProfile(Request $request, $id)
{
    $user = User::findOrFail($id);

    // Validate the incoming request
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'login' => 'required|string',
    ]);

    // Update user details
    $user->update([
        'first_name' => $request->input('first_name'),
        'last_name' => $request->input('last_name'),
        'email' => $request->input('email'),
        'role' => $request->input('role'),
        'id_service' => $request->input('id_service'),
        'login' => $request->input('login'),
    ]);

    // Redirect to the show page with a success message
    return redirect()->route('admin.profile.show', ['id' => $user->id])
        ->with('success', 'Utilisateur modifié avec succès.');
}

    

    public function show($id)
    {
        $user = User::findOrFail($id)->load('service');
        $services = Service::all();
        return view('admin.profile.show', compact('user', 'services'));
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
    
            // Vérifiez les résultats
            \Log::info($results);
    
            return response()->json($results); // Retourne les données au format JSON
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['error' => 'Une erreur s\'est produite.'], 500);
        }
    }
    

    
    

}
