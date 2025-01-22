<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Courier;
use App\Models\Recipient;
use App\Models\User;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Exports\CouriersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Psy\Readline\Hoa\Console;

class CourierController extends Controller
{
    /**
     * Affiche la liste des courriers.
     */
    public function index(Request $request)
{
    // Charger les courriers avec leurs relations
    $query = Courier::with(['handlingUser', 'couriersRecipient', 'couriersType', 'copiedUsers']);

    // Filtrer par année si spécifié
    $selectedYear = $request->input('year', date('Y'));
    if ($selectedYear) {
        $query->whereYear('created_at', $selectedYear);
    }

    // Rechercher par objet ou destinataire
    if ($request->has('search') && !empty($request->search)) {
        $search = $request->input('search');
        $query->where('object', 'like', "%$search%")
            ->orWhereHas('couriersRecipient', function ($q) use ($search) {
                $q->where('label', 'like', "%$search%");
            });
    }

    // Nombre de courriers par page (par défaut : 20)
    $perPage = $request->input('perPage', 20);

    // Paginer les résultats
    $couriers = $query->paginate($perPage);

    // Récupérer les années distinctes depuis les courriers
    $years = Courier::selectRaw("strftime('%Y', created_at) as year")->distinct()->orderBy('year', 'desc')->pluck('year');

    // Retourner les courriers et autres données nécessaires à la vue
    return view('admin.couriers.index', compact('couriers', 'years', 'selectedYear', 'perPage'));
}



    /**
     * Affiche le formulaire pour créer un nouveau courrier.
     */
    public function create()
    {
        $users = User::all(); // Liste des utilisateurs pour les assignations
        $categories = Category::all(); // Liste des catégories
        $recipients = Recipient::all(); // Liste des destinataires existants
        $agents =  User::where('id_service', 2)->get();

        return view('admin.couriers.form', ['courier' => new Courier()], compact('users', 'categories', 'recipients', 'agents'));
    }

    /**
     * Enregistre un nouveau courrier.
     */
    public function store(Request $request)
    {
        $request->validate([
            'object' => 'required|string|max:255',
            'recipient' => 'required|exists:recipients,id',
            'category' => 'required|exists:categories,id',
            'id_handling_user' => 'required|exists:users,id',
            'document_path' => 'required|string',
            'copy_to' => 'array',
            'copy_to.*' => 'exists:users,id',
        ]);
    
        if ($request->hasFile('document_path')) {
            $path = $request->file('document_path')->store('couriers', 'public');
            $validated['document_path'] = $path;
        }

        $courier = Courier::create([
            'object' => $request->input('object'),
            'id_handling_user' => $request->input('id_handling_user'),
            'recipient' => $request->input('recipient'),
            'category' => $request->input('category'),
            'document_path' => $request->input('document_path'),
        ]);
     
    
        if ($request->has('copy_to')) {
            $courier->copiedUsers()->sync($request->input('copy_to'));
        }
    
        return redirect()->route('admin.courier.index')->with('success', 'Courrier ajouté avec succès.');
    }

        public function edit($id)
    {
        // Récupérer le courrier avec ses relations
        $courier = Courier::with(['handlingUser', 'couriersRecipient', 'couriersType', 'copiedUsers'])->findOrFail($id);

        // Récupérer la liste des catégories pour la dropdown
        $categories = Category::all();

        // Récupérer les utilisateurs (agents ou utilisateurs) pour les options de copie à
        $users = User::all();

        $agents =  User::where('id_service', 2)->get();


        // Retourner la vue d'édition avec les données nécessaires
        return view('admin.couriers.edit', compact('courier', 'categories', 'users', 'agents'));
    }

    
    public function update(Request $request, $id)
    {
        // Valider les données de la requête
        $validated = $request->validate([
            'object' => 'required|string|max:255',
            'recipient' => 'required|string',
            'id_handling_user' => 'required|integer',
            'category' => 'nullable|integer',
            'document_path' => 'nullable|string', // Stocke le chemin réseau
            'copy_to' => 'nullable|array',
        ]);
    
        // Récupérer le courrier à mettre à jour
        $courier = Courier::findOrFail($id);
        
        // Mettre à jour les données du courrier
        $courier->object = $validated['object'];
        $courier->recipient = $validated['recipient'];
        $courier->id_handling_user = $validated['id_handling_user'];
        $courier->category = $validated['category'] ?? null;
        $courier->document_path = $validated['document_path'] ?? $courier->document_path;
    
        $courier->save();
    
        // Mettre à jour les utilisateurs en copie
        if (isset($validated['copy_to'])) {
            $courier->copiedUsers()->sync($validated['copy_to']);
        }
    
        // Rediriger avec un message de succès
        return redirect()->route('admin.courier.index')->with('success', 'Courrier mis à jour avec succès.');
    }
    

    /**
     * Supprime un courrier.
     */
    public function destroy(Request $request)
    {
        $courierId = $request->input('courier_id');
        dd($courierId);
        $courier = Courier::findOrFail($courierId);

        // Supprimer le fichier lié s'il existe
        if ($courier->document_path && \Storage::exists($courier->document_path)) {
            \Storage::delete($courier->document_path);
        }

        // Supprimer le courrier
        $courier->delete();

        return redirect()->route('admin.couriers.index')->with('success', 'Courrier supprimé avec succès.');
    }

    public function export(Request $request)
    {
        $year = $request->input('year', now()->year); // Année actuelle par défaut
      

        return Excel::download(new CouriersExport($year), "couriers_{$year}.xlsx");
    }
    
    
    public function settings()
    {
        // Récupérez les données nécessaires
        $users = User::all(); // Récupère tous les utilisateurs
        $recipients = Recipient::all(); // Récupère tous les destinataires
        $categories = Category::all(); // Récupère toutes les catégories
        $agents =  $agents = User::where('id_service', 2)->get();

    
        // Récupérer les utilisateurs qui ne sont pas agents
        $nonAgents = User::where('id_service', '!=', 2)
                        ->orWhereNull('id_service')
                        ->get();

        $services = Service::all(); // Récupère tous les services
    
        // Passez les variables à la vue
        return view('admin.couriers.settings', compact('users', 'recipients', 'categories', 'agents', 'nonAgents', 'services'));
    }

    public function destroySelected(Request $request)
{
    $ids = $request->input('ids');

    if (!$ids || !is_array($ids)) {
        return response()->json(['success' => false, 'message' => 'Aucun identifiant fourni.'], 400);
    }

    try {
        Courier::whereIn('id', $ids)->delete();
        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        \Log::error('Erreur lors de la suppression de masse : ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Une erreur s\'est produite.'], 500);
    }
}

    





}
