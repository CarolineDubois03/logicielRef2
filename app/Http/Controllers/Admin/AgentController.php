<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Recipient;
use App\Models\Agent;
use Illuminate\Http\Request;

use App\Models\Agents;

class AgentController extends Controller
{

    public function store(Request $request)
    {
        $request->validate(['label' => 'required|string|max:255']);
    
        // Vérifier si le destinataire existe déjà
        $existingRecipient = Recipient::where('label', $request->input('label'))->first();
        if ($existingRecipient) {
            return response()->json(['errors' => ['label' => 'Ce destinataire existe déjà.']], 422);
        }
    
        // Créer le destinataire
        $recipient = Recipient::create(['label' => $request->input('label')]);
    
        return redirect()->route('admin.courier.settings', ['tab' => 'recipients'])->with('success', 'Destinataire créé avec succès.');
    }
    


    public function update(Request $request, $id)
    {
        $request->validate(['label' => 'required|string|max:255']);
        $recipient = Recipient::findOrFail($id);
        $recipient->label = $request->input('label');
        $recipient->save();
    
        return redirect()->route('admin.courier.settings', ['tab' => 'recipients'])->with('success', 'Destinataire mis à jour avec succès.');
    }
    
    public function destroy($id)
{
    $recipient = Recipient::findOrFail($id);

    // Supprimez le destinataire
    $recipient->delete();

    return redirect()->route('admin.courier.settings')->with('success', 'Destinataire supprimé avec succès.');
}
public function search(Request $request)
    {
        try {
            $query = $request->get('q', '');
            $users = Agent::where('first_name', 'like', "%{$query}%")
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
