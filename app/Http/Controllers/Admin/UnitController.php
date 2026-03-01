<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    // ===============================
    // Display All Units
    // ===============================
    public function index()
    {
        $units = Unit::latest()->get();
        return view('admin.units.index', compact('units'));
    }

    // ===============================
    // Show Create Form
    // ===============================
    public function create()
    {
        return view('admin.units.create');
    }

    // ===============================
    // Store New Unit
    // ===============================
   public function store(Request $request)
{
    $request->validate([
        'unit_name' => 'required',
        'battalion' => 'required',
        'state' => 'required'
    ]);

    Unit::create($request->all());

    return redirect()->route('units.index')
        ->with('success','Unit Created Successfully');
}

    // ===============================
    // Show Edit Form
    // ===============================
    public function edit(Unit $unit)
    {
        return view('admin.units.edit', compact('unit'));
    }

    // ===============================
    // Update Unit
    // ===============================
    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:units,code,' . $unit->id,
            'description' => 'nullable|string'
        ]);

        $unit->update([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description
        ]);

        return redirect()
            ->route('units.index')
            ->with('success', 'Unit updated successfully.');
    }

    // ===============================
    // Delete Unit
    // ===============================
    public function destroy(Unit $unit)
    {
        $unit->delete();

        return redirect()
            ->route('units.index')
            ->with('success', 'Unit deleted successfully.');
    }
}