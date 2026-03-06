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
    public function index(Request $request)
    {
        $query = Unit::query();

        if ($q = $request->query('q')) {
            // table uses "unit_name" column
            $query->where('unit_name', 'like', "%{$q}%");
        }

        // Return a paginator so ->total() and ->links() work in the view
        $units = $query->orderBy('created_at', 'desc')->paginate(15);

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

        return redirect()->route('admin.units.index')
            ->with('success', 'Unit Created Successfully');
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
        // Validate fields that actually exist on units table
        $request->validate([
            'unit_name' => 'required|string|max:255',
            'battalion' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
        ]);

        $unit->update([
            'unit_name' => $request->unit_name,
            'battalion' => $request->battalion,
            'state' => $request->state,
        ]);

        return redirect()->route('admin.units.index')->with('success', 'Unit updated successfully.');
    }

    // ===============================
    // Delete Unit
    // ===============================
    public function destroy(Unit $unit)
    {
        $unit->delete();

        return redirect()->route('admin.units.index')->with('success', 'Unit deleted successfully.');
    }
}