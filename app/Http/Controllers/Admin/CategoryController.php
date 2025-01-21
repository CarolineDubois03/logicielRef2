<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Liste les catégories
    public function index()
    {
        $categories = Category::all();
        return redirect()->route('admin.courier.settings')->with('categories', $categories);
    }

    // Stocker une nouvelle catégorie
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Category::create(['name' => $request->input('name')]);

        return redirect()->route('admin.courier.settings', ['tab' => 'categories'])
            ->with('success', 'Catégorie ajoutée avec succès.');
    }

    // Met à jour une catégorie existante
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $request->validate(['name' => 'required|string|max:255']);
        $category->update(['name' => $request->input('name')]);

        return redirect()->route('admin.courier.settings', ['tab' => 'categories'])
            ->with('success', 'Catégorie modifiée avec succès.');
    }

    // Supprimer une catégorie
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.courier.settings')
            ->with('success', 'Catégorie supprimée avec succès.');
    }
}
