<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Recipient;
use Illuminate\Http\Request;

class RecipientController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        return Recipient::where('label', 'LIKE', '%' . $query . '%')->get();
    }
    public function store(Request $request)
    {
        try {
            $request->validate(['label' => 'required|string|max:255']);
    
            // Vérifier si le destinataire existe déjà
            $existingRecipient = Recipient::where('label', $request->input('label'))->first();
            if ($existingRecipient) {
                return response()->json(['id' => $existingRecipient->id, 'label' => $existingRecipient->label]);
            }
    
            // Création du destinataire
            $recipient = Recipient::create(['label' => $request->input('label')]);
    
            \Log::info("Destinataire créé avec succès : ", ['id' => $recipient->id, 'label' => $recipient->label]);
    
            return response()->json([
                'id' => $recipient->id,
                'label' => $recipient->label
            ]);
    
        } catch (\Exception $e) {
            \Log::error("Erreur lors de l'ajout du destinataire : " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
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

}
