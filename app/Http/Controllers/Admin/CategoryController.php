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
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller{
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.couriers.settings')->with('success', 'Catégorie supprimée avec succès.');
    }
}