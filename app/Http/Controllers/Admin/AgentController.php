<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use App\Models\Recipient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AgentController extends Controller  {
    public function index()
    {

        dd('test');
        // Récupérer les agents avec id_service = 2
        $agents = User::where('id_service', 2)->get();

    
        // Récupérer les utilisateurs qui ne sont pas agents
        $nonAgents = User::where('id_service', '!=', 2)
                        ->orWhereNull('id_service')
                        ->get();
    
        dd($agents, $nonAgents); // Décommenter pour déboguer si nécessaire
    
        return view('admin.courier.settings', ['tab' => 'agents'], compact('agents', 'nonAgents'));
    }
    
    

    public function addAgent(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
    ]);

    // Récupérer l'utilisateur
    $user = User::find($request->user_id);

    // Ajouter id_service = 2
    $user->id_service = 2;
    $user->save();

    return redirect()->route('admin.courier.settings', ['tab' => 'agents'])->with('success', 'L\'agent a été ajouté avec succès.');
}


public function removeAgent($id)
{
    $agent = User::findOrFail($id);

    // Vérifier si l'utilisateur est actuellement un agent
    if ($agent->id_service == 2) {
        $agent->id_service = null; // Retirer l'utilisateur des agents
        $agent->save();

        return redirect()->route('admin.courier.settings', ['tab' => 'agents'])->with('success', 'L\'utilisateur a été retiré des agents avec succès.');
    }

    return redirect()->route('admin.courier.settings', ['tab' => 'agents'])->with('error', 'Cet utilisateur n\'est pas un agent.');
}


    

}
