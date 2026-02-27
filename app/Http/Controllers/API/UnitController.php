<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        return response()->json(Unit::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'unit_name' => 'required',
            'battalion' => 'required',
            'state' => 'required'
        ]);

        $unit = Unit::create($request->all());

        return response()->json([
            'message' => 'Unit created',
            'unit' => $unit
        ], 201);
    }
}