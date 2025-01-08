<?php
namespace App\Http\Controllers;

use App\Models\Year;
use Illuminate\Http\Request;

class YearController extends Controller
{
    public function index()
    {
        $years = Year::all();
        return view('years.index', compact('years'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|integer',
        ]);

        Year::create($request->all());

        return redirect()->route('years.index')->with('success', 'Year created successfully.');
    }
}
