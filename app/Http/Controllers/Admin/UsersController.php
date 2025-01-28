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
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeUserMail;


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
    
        $role = auth()->user()->role === 'responsable' ? 'user' : $request->input('role', 'user');
        
        $temporaryPassword = Str::random(12);
        
        // Générer un login unique
        $login = strtolower(substr($request->input('first_name'), 0, 3) . substr($request->input('last_name'), 0, 3));
        $originalLogin = $login;
        $counter = 1;
        while (User::where('login', $login)->exists()) {
            $login = $originalLogin . $counter;
            $counter++;
        }
    
        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'login' => $login,
            'role' => $role,
            'id_service' => $request->input('id_service'),
            'password' => bcrypt($temporaryPassword),
        ]);
    
        // ENVOI DU MAIL DE BIENVENUE
        Mail::to($user->email)->send(new WelcomeUserMail($user, $temporaryPassword));
    
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur ajouté avec succès. Un email a été envoyé.');
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
    

    public function sendResetPasswordEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return redirect()->back()->with('error', 'Utilisateur non trouvé.');
        }
    
        $resetToken = Str::random(60);
        $user->update(['remember_token' => $resetToken]);
    
        $resetUrl = route('password.reset', ['token' => $resetToken]);
    
        Mail::to($user->email)->send(new ResetPasswordMail($user, $resetUrl));
    
        return redirect()->back()->with('success', 'Email de réinitialisation envoyé.');
    }
    public function showResetPasswordForm(Request $request, $token)
    {
        return view('auth.password-reset', ['token' => $token, 'email' => $request->email]);
    }
    

}
