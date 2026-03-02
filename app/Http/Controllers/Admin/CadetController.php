<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Cadet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CadetsExport;
use Barryvdh\DomPDF\Facade\Pdf;

class CadetController extends Controller
{
    /**
     * Display cadet list
     */
    public function index()
    {
        $cadets = Cadet::with('user')->latest()->get();
        return view('admin.cadets.index', compact('cadets'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.cadets.create');
    }

    /**
     * Store cadet
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6',
            'enrollment_no' => 'required|unique:cadets,enrollment_no',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'cadet',
        ]);

        Cadet::create([
            'user_id'        => $user->id,
            'enrollment_no'  => $validated['enrollment_no'],
        ]);

        return redirect()
            ->route('cadets.index')
            ->with('success', 'Cadet created successfully');
    }

    /**
     * Edit cadet
     */
    public function edit(Cadet $cadet)
    {
        $cadet->load('user');
        return view('admin.cadets.edit', compact('cadet'));
    }

    /**
     * Update cadet
     */
    public function update(Request $request, Cadet $cadet)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $cadet->user_id,
        ]);

        $cadet->user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        $cadet->update([
            'enrollment_no' => $request->enrollment_no,
        ]);

        return redirect()->route('cadets.index')->with('success', 'Cadet updated');
    }

    /**
     * Delete cadet
     */
    public function destroy(Cadet $cadet)
    {
        $cadet->user()->delete();
        $cadet->delete();

        return back()->with('success', 'Cadet deleted');
    }

    /* ===========================
       EXPORT FUNCTIONS
    ============================ */

    // CSV Export
    public function exportCsv(): StreamedResponse
    {
        $filename = 'cadets.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Name', 'Email', 'Enrollment No']);

            Cadet::with('user')->chunk(100, function ($cadets) use ($handle) {
                foreach ($cadets as $cadet) {
                    fputcsv($handle, [
                        $cadet->user->name,
                        $cadet->user->email,
                        $cadet->enrollment_no,
                    ]);
                }
            });

            fclose($handle);
        }, $filename);
    }

    // Excel Export
    public function exportExcel()
    {
        return Excel::download(new CadetsExport, 'cadets.xlsx');
    }

    // PDF Export
    public function exportPdf()
    {
        $cadets = Cadet::with('user')->get();
        $pdf = Pdf::loadView('admin.cadets.export-pdf', compact('cadets'));

        return $pdf->download('cadets.pdf');
    }
}