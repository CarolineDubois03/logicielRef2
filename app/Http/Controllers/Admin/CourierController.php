<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Courier;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Models\AdditionalColumn;
use App\Models\Service;
use App\Models\AdditionalField;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CourierFormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use App\Exports\CouriersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Psy\Readline\Hoa\Console;


class CourierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $service = $user->id_service;

        $additionalColumns = AdditionalColumn::where('id_service', $service)->get();
        $nameService = Service::where('id', $service)->first()->name;
        $nameUser = $user->first_name . ' ' . $user->last_name;

        $selectedYear = $request->input('year', date('Y'));

        $couriers = Courier::where('year', $selectedYear)
        ->where(function($query) use ($user, $service) {
            $query->where('id_handling_user', $user->id)
                  ->orWhereHas('handlingUser', function($query) use ($service) {
                      $query->where('id_service', $service);
                  });
        })
        ->orderBy('created_at')
        ->paginate(25);

        $additionalFields = [];
        foreach ($couriers as $courier) {
            foreach ($additionalColumns as $column) {
                $additionalField = AdditionalField::where('id_courier', $courier->id)
                    ->where('id_column', $column->id)
                    ->first();
                if ($additionalField) {
                    $additionalFields[$courier->id][$column->name] = $additionalField->label;
                } else {
                    $additionalFields[$courier->id][$column->name] = null;
                }
            }
        }

        $years = Courier::selectRaw('strftime("%Y", created_at) as year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get()
            ->pluck('year');

        return view('admin.couriers.index', compact('couriers', 'service', 'additionalColumns', 'nameService', 'additionalFields', 'nameUser', 'years', 'selectedYear'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Récupérer le service de l'utilisateur connecté
        $service = $user->id_service;

         // Récupérer toutes les catégories
        $categories = Category::all();

        // Récupérer les colonnes supplémentaires spécifiques à ce service
        $additionalColumns = AdditionalColumn::where('id_service', $service)->get();
        $nameUser = $nameUser = $user->first_name . ' ' . $user->last_name;
        return view('admin.couriers.form', ['courier' => new Courier()], compact('additionalColumns', 'nameUser', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourierFormRequest $request)
    {
        //dd($request);
        // Obtenir l'utilisateur actuellement authentifié
        $user = Auth::user();
       


        // Valider les données de la requête avec CourierFormRequest
        $validatedData = $request->validated();
        $additionalFields = $request->input('additional_fields', []);
        try {

            foreach ($additionalFields as $columnName => $value) {
                // Récupérer la colonne supplémentaire correspondante
                $column = AdditionalColumn::where('name', $columnName)->first();
            

                
                
                // Récupérer les champs supplémentaires de la demande
                $additionalFields = $request->input('additional_fields');
                }
                
                // Ajouter l'ID de l'utilisateur à la demande validée
                $validatedData['id_handling_user'] = $user->id;
               
                // Créer le courrier avec les données validées
                $courier = Courier::create($validatedData);
               

                // Parcourir chaque champ supplémentaire
                if ($additionalFields) {
                    foreach ($additionalFields as $columnName => $value) {
                        // Récupérer la colonne correspondante
                        $column = AdditionalColumn::where('name', $columnName)->first();

                        // Vérifier si la colonne existe
                        if ($column && $value) {
                            // Créer le champ supplémentaire dans la table appropriée
                            AdditionalField::create([
                                'id_courier' => $courier->id,
                                'id_column' => $column->id,
                                'label' => $value,
                            ]);
                        }
                    }
                }
                

                
                // Rediriger avec un message de succès
                return redirect()->route('admin.courier.index')->with('success', 'Le courrier a bien été créé');
        } catch (\Exception $e) {
            // Gérer l'exception ici (par exemple, en enregistrant les erreurs dans les journaux)
            // Renvoyer le formulaire avec les données saisies précédemment et un message d'errseur
            return redirect()->back()->withInput()->with(['error' => 'Une erreur s\'est produite lors de la création du courrier. Veuillez réessayer.']);
        }
    }
    




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Récupérer le service de l'utilisateur connecté
        $service = $user->id_service;
        
        // Récupérer les colonnes supplémentaires spécifiques à ce service
        $additionalColumns = AdditionalColumn::where('id_service', $service)->get();
        $nameUser = $user->first_name . ' ' . $user->last_name;
        // Récupérer les additional_fields pour chaque courrier
        $additionalFields = [];
        foreach ($additionalColumns as $column) {
            // Récupérer l'additional_field correspondant à ce courrier et cette colonne supplémentaire
            $additionalField = AdditionalField::where('id_courier', $id)
                ->where('id_column', $column->id)
                ->first();
            // Stocker l'additional_field dans un tableau associatif avec le nom de la colonne comme clé
            if ($additionalField) {
                $additionalFields[$id][$column->name] = $additionalField->label;
            } else {
                $additionalFields[$id][$column->name] = null;
            }
        }
        return view('admin.couriers.show', ['courier' => Courier::findOrFail($id)], compact('additionalColumns', 'nameUser', 'additionalFields'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //dd($id); // Vérifiez si les paramètres sont corrects
        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Récupérer le service de l'utilisateur connecté
        $service = $user->id_service;

        // Récupérer les colonnes supplémentaires spécifiques à ce service
        $additionalColumns = AdditionalColumn::where('id_service', $service)->get();
        $nameUser = $user->first_name . ' ' . $user->last_name;
        // Récupérer toutes les catégories
        $categories = Category::all();
        // Récupérer les additional_fields pour chaque courrier
        $additionalFields = [];
        foreach ($additionalColumns as $column) {
            // Récupérer l'additional_field correspondant à ce courrier et cette colonne supplémentaire
            $additionalField = AdditionalField::where('id_courier', $id)
                ->where('id_column', $column->id)
                ->first();
            // Stocker l'additional_field dans un tableau associatif avec le nom de la colonne comme clé
            if ($additionalField) {
                $additionalFields[$id][$column->name] = $additionalField->label;
            } else {
                $additionalFields[$id][$column->name] = null;
            }
        }
        //dd($additionalFields, $additionalColumns, $nameUser, $user);
        return view('admin.couriers.edit', ['courier' => Courier::findOrFail($id)], compact('additionalColumns', 'nameUser', 'additionalFields', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourierFormRequest $request, string $id)
    {
        // Récupérer le courrier
        $courier = Courier::findOrFail($id);

        // Valider les données du formulaire
        $validatedData = $request->validated();
        try {

            // Mettre à jour le courrier avec les données validées
            $courier->update($validatedData);

            // Mettre à jour les champs supplémentaires associés au courrier
            $additionalFields = $request->input('additional_fields');


            // Mettre à jour les champs supplémentaires associés au courrier
            if ($additionalFields) {
                foreach ($additionalFields as $columnName => $value) {
                    $column = AdditionalColumn::where('name', $columnName)->first();
                    if ($column && $value) {

                        // Créer ou mettre à jour le champ supplémentaire dans la table appropriée
                        AdditionalField::updateOrCreate(
                            ['id_courier' => $courier->id, 'id_column' => $column->id],
                            ['label' => $value]
                        );
                    }
                }
            }
            // Rediriger avec un message de succès
            return redirect()->route('admin.courier.index')->with('success', 'Le courrier a bien été modifié');
        } catch (\Exception $e) {
            // Gérer l'exception ici (par exemple, en enregistrant les erreurs dans les journaux)
            dd($e->getMessage());
            // Renvoyer le formulaire avec les données saisies précédemment et un message d'errseur
            return redirect()->back()->withInput()->with(['error' => 'Une erreur s\'est produite lors de la création du courrier. Veuillez réessayer.']);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
{
    $courierId = $request->input('courier_id'); // Récupérer l'ID depuis le champ caché

    // Vérifier si un ID spécifique est fourni
    if ($courierId !== null) {
        // Supprimer le courrier spécifique avec l'ID fourni
        $courier = Courier::findOrFail($courierId);
        $courier->delete();

        // Rediriger avec un message de succès
        return redirect()->route('admin.courier.index')->with('success', 'Le courrier a été supprimé avec succès.');
    }

    // Vérifier si des courriers ont été sélectionnés
    if (!empty($request->input('couriers'))) {
        // Récupérer la chaîne d'ID

        // Supprimer chaque courrier sélectionné
        foreach ($request->input('couriers') as $ids) {
            $ids = explode(',', $ids);
            foreach ($ids as $id) {
                if (!empty($id)) {
                    $courier = Courier::findOrFail($id);
                    $courier->delete();
                }
            }
        }

        return redirect()->route('admin.courier.index')->with('success', 'Les courriers sélectionnés ont été supprimés avec succès.');
    } else {
        return redirect()->route('admin.courier.index')->with('error', 'Aucun courrier sélectionné pour la suppression.');
    }
}


public function showColumns()
{
    // Récupérer l'utilisateur connecté
    $user = Auth::user();
    // Récupérer le service de l'utilisateur connecté
    $service = $user->id_service;

    // Récupérer les colonnes supplémentaires spécifiques à ce service
    $additionalColumns = AdditionalColumn::where('id_service', $service)->get();
    $nameService = Service::where('id', $service)->first()->name;
   
    //Récupérer tous les services
    $services = Service::all();

    // Récupérer toutes les catégories et ajouter les attributs 'required' et 'editable' par défaut si nécessaire
    $categories = Category::all()->map(function ($category) {
        $category->required = $category->required ?? 0;
        $category->editable = $category->editable ?? false; // Default to false or set as needed
        return $category;
    });

    // Récupérer les agents de ce service et ajouter les attributs 'required' et 'editable' par défaut
    $agents = DB::table('users')->where('id_service', $service)->get()->map(function ($agent) {
        $agent->required = $agent->required ?? 0;
        $agent->editable = $agent->editable ?? false; // Default to false or set as needed
        return $agent;
    });
    

    // Passer les données à la vue
    return view('admin.couriers.additional_columns', compact('service', 'additionalColumns', 'nameService', 'categories', 'agents', 'services'));
}


    public function storeColumns(Request $request)
    {

        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Récupérer le service de l'utilisateur connecté
        $service = $user->id_service;

        // Créer une nouvelle entrée dans la table des colonnes supplémentaires
        $additionalColumn = new AdditionalColumn();
        $additionalColumn->name = $request->name;
        $additionalColumn->required = $request->required ? true : false;
        $additionalColumn->id_service = $service;
        $additionalColumn->save();


        // Rediriger avec un message de succès
        return redirect()->route('admin.courier.showColumns')->with('success', 'Les colonnes supplémentaires ont bien été ajoutées');
    }
    public function editColumn(Request $request, $id)
    {

        $additionalColumn = AdditionalColumn::findOrFail($id);
        $additionalColumn->name = $request->name;
        $additionalColumn->required = $request->required ? true : false;
        $additionalColumn->save();
        return redirect()->route('admin.courier.showColumns')->with('success', 'La colonne supplémentaire a bien été modifiée');
    }





    public function destroyColumn(string $id)
    {
        $additionalColumn = AdditionalColumn::findOrFail($id);
        $additionalColumn->delete();
        return redirect()->route('admin.courier.showColumns')->with('success', 'La colonne supplémentaire a bien été supprimée');
    }

    public function export()
    {
        return Excel::download(new CouriersExport, 'couriers.xlsx');
    }


    public function storeNature(Request $request)
    {
      
        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Récupérer le service de l'utilisateur connecté
        $service = $user->id_service;

        // Créer une nouvelle entrée dans la table des catégories
        $category = new Category();
        $category->name = $request->name;
        $category->id_service = $service;
        $category->save();
        


        // Rediriger avec un message de succès
        return redirect()->route('admin.courier.showColumns')->with('success', 'La nature a bien été ajoutée');
    }
    public function editNature(Request $request, $id)
    {

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->save();
        return redirect()->route('admin.courier.showColumns')->with('success', 'La nature a bien été modifiée');
    }



    public function destroyNature(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.courier.showColumns')->with('success', 'La nature a bien été supprimée');
    }

    public function storeAgent(Request $request)
{
    // Validate the request inputs
    $request->validate([
        'last_name' => 'required|string|max:255',
        'first_name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
    ]);

    // Récupérer l'utilisateur connecté
    $user = Auth::user();

    // Récupérer le service de l'utilisateur connecté
    $service = $user->id_service;

    // Créer une nouvelle entrée dans la table utilisateur pour l'agent
    DB::table('users')->insert([
        'last_name' => $request->last_name,
        'first_name' => $request->first_name,
        'email' => $request->email,
        'id_service' => $service,  // Assign the agent to the same service as the current user
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Rediriger avec un message de succès
    return redirect()->route('admin.courier.showColumns')->with('success', "L'agent a bien été ajouté");
}

    public function editAgent(Request $request, $id)
    {

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->save();
        return redirect()->route('admin.courier.showColumns')->with('success', `L'agent a bien été modifiée`);
    }



    public function destroyAgent(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.courier.showColumns')->with('success', `L'agent a bien été supprimée`);
    }

   
    public function updateSelectedServices(Request $request, User $user)
    {
        // Retrieve the service ID from the request
        $selectedServiceId = $request->input('selected_services');
    
        // Validate the ID to ensure it exists in the Service model
        $validatedServiceId = Service::where('id', $selectedServiceId)->pluck('id')->first();
        if ($validatedServiceId) {
            // Update the user's service by setting the `id_service` field
            $user->id_service = $validatedServiceId;
            $user->save();
    
            return redirect()->route('admin.courier.index')
                             ->with('success', 'Le service sélectionné a été mis à jour avec succès.');
        }
    
        return redirect()->route('admin.courier.index')
                         ->with('error', 'Le service sélectionné est invalide.');
    }
    

}
