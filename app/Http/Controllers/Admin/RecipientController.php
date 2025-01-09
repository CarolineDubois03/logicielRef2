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
        dd("store");
        $request->validate(['label' => 'required|string|max:255']);
        $recipient = Recipient::create(['label' => $request->input('label')]);
        return response()->json($recipient);
    }

    public function update(Request $request, $id)
{
    $request->validate(['label' => 'required|string|max:255']);

    $recipient = Recipient::findOrFail($id);
    $recipient->label = $request->input('label');
    $recipient->save();

    return redirect()->route('admin.settings')->with('success', 'Destinataire mis à jour avec succès.');
}

    public function destroy($id)
{
    $recipient = Recipient::findOrFail($id);

    // Supprimez le destinataire
    $recipient->delete();

    return redirect()->route('admin.settings')->with('success', 'Destinataire supprimé avec succès.');
}

}
