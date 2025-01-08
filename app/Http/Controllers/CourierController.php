<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use App\Models\Recipient;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class CourierController extends Controller
{
    /**
     * Affiche la liste des courriers.
     */
    public function index()
    {
        // Charger tous les courriers avec leurs relations
        $couriers = Courier::with(['handlingUser', 'recipients', 'couriersType'])->get();

        return view('couriers.index', compact('couriers'));
    }

    /**
     * Affiche le formulaire pour créer un nouveau courrier.
     */
    public function create()
    {
        $users = User::all(); // Liste des utilisateurs pour les assignations
        $categories = Category::all(); // Liste des catégories
        $recipients = Recipient::all(); // Liste des destinataires existants

        return view('couriers.create', compact('users', 'categories', 'recipients'));
    }

    /**
     * Enregistre un nouveau courrier.
     */
    public function store(Request $request)
    {
        $request->validate([
            'object' => 'required|string|max:255',
            'id_handling_user' => 'required|exists:users,id',
            'category' => 'required|exists:categories,id',
            'copy_to' => 'array',
            'copy_to.*' => 'exists:recipients,id',
            'document_path' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Enregistrer le courrier
        $courier = Courier::create([
            'object' => $request->input('object'),
            'id_handling_user' => $request->input('id_handling_user'),
            'category' => $request->input('category'),
            'document_path' => $request->file('document_path') ? $request->file('document_path')->store('documents') : null,
        ]);

        // Associer les destinataires
        if ($request->has('copy_to')) {
            $courier->recipients()->sync($request->input('copy_to'));
        }

        return redirect()->route('couriers.index')->with('success', 'Courrier créé avec succès.');
    }

    /**
     * Supprime un courrier.
     */
    public function destroy($id)
    {
        $courier = Courier::findOrFail($id);

        // Supprimer le fichier lié s'il existe
        if ($courier->document_path && \Storage::exists($courier->document_path)) {
            \Storage::delete($courier->document_path);
        }

        // Supprimer le courrier
        $courier->delete();

        return redirect()->route('couriers.index')->with('success', 'Courrier supprimé avec succès.');
    }
}
