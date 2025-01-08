<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Courier;
use App\Models\Recipient;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Exports\CouriersExport;
use Maatwebsite\Excel\Facades\Excel;

class CourierController extends Controller
{
    /**
     * Affiche la liste des courriers.
     */
        public function index(Request $request)
    {
        // Charger tous les courriers avec leurs relations
        $couriers = Courier::with(['handlingUser', 'recipients', 'couriersType', 'copiedUsers'])->paginate(10);

        // Récupérer les années distinctes depuis les courriers
        $years = Courier::select('year')->distinct()->orderBy('year', 'desc')->pluck('year');
        
        $selectedYear = $request->input('year', date('Y'));

        // Passer les courriers et les années à la vue
        return view('admin.couriers.index', compact('couriers', 'years', 'selectedYear'));
    }


    /**
     * Affiche le formulaire pour créer un nouveau courrier.
     */
    public function create()
    {
        $users = User::all(); // Liste des utilisateurs pour les assignations
        $categories = Category::all(); // Liste des catégories
        $recipients = Recipient::all(); // Liste des destinataires existants

        return view('admin.couriers.form', ['courier' => new Courier()], compact('users', 'categories', 'recipients'));
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

        return redirect()->route('admin.couriers.index')->with('success', 'Courrier créé avec succès.');
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

        return redirect()->route('admin.couriers.index')->with('success', 'Courrier supprimé avec succès.');
    }

    public function export()
    {
        return Excel::download(new CouriersExport, 'couriers.xlsx');
    }

    public function settings()
{
    // Charger les listes actuelles
    $agents = User::all(); // Liste des agents traitants
    $categories = Category::all(); // Liste des catégories
    $recipients = Recipient::all(); // Liste des destinataires

    // Retourner une vue pour gérer ces paramètres
    return view('admin.couriers.settings', compact('agents', 'categories', 'recipients'));
}


}
