<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FormController extends Controller
{
    /**
     * Display a listing of all forms
     */
    public function index()
    {
        // For now, returning empty array - you can connect to a Form model later
        $forms = [];
        
        return view('admin.forms.index', [
            'forms' => $forms,
            'total' => 0,
            'pending' => 0,
            'approved' => 0,
            'rejected' => 0,
        ]);
    }

    /**
     * Display approved forms
     */
    public function approved()
    {
        $forms = [];
        
        return view('admin.forms.approved', [
            'forms' => $forms,
            'count' => 0,
        ]);
    }

    /**
     * Display pending forms
     */
    public function pending()
    {
        $forms = [];
        
        return view('admin.forms.pending', [
            'forms' => $forms,
            'count' => 0,
        ]);
    }

    /**
     * Display rejected forms
     */
    public function rejected()
    {
        $forms = [];
        
        return view('admin.forms.rejected', [
            'forms' => $forms,
            'count' => 0,
        ]);
    }

    /**
     * Show the form for creating a new form
     */
    public function create()
    {
        return view('admin.forms.create', [
            'categories' => [
                'attendance' => 'Attendance',
                'leave' => 'Leave Application',
                'training' => 'Training',
                'event' => 'Event',
                'complaint' => 'Complaint',
                'other' => 'Other'
            ],
            'statuses' => [
                'draft' => 'Draft',
                'active' => 'Active',
                'closed' => 'Closed'
            ]
        ]);
    }

    /**
     * Store a newly created form
     */
    public function store(Request $request)
    {
        // Validate incoming form data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'required|in:attendance,leave,training,event,complaint,other',
            'status' => 'required|in:draft,active,closed',
            'visible_to' => 'required|in:all,selected,admin',
            'required_approval' => 'required|boolean',
            'submission_limit' => 'nullable|integer|min:1|max:999',
            'allow_multiple' => 'nullable|boolean',
            'allow_edit_after_submit' => 'nullable|boolean',
            'notify_on_submission' => 'nullable|boolean',
            'collect_attachments' => 'nullable|boolean',
        ]);

        // Add created_by admin ID
        $validated['created_by'] = auth()->id();
        $validated['created_at'] = now();

        // For now, we'll return success message
        // Once Form model is created, uncomment below:
        // $form = Form::create($validated);

        return redirect()
            ->route('admin.forms.index')
            ->with('success', 'Form "' . $validated['title'] . '" created successfully!');
    }

    /**
     * Show the form for editing a form
     */
    public function edit($id)
    {
        // Form edit logic here
        return view('admin.forms.edit');
    }

    /**
     * Update a form
     */
    public function update(Request $request, $id)
    {
        // Form update logic here
        return redirect()->route('admin.forms.index')->with('success', 'Form updated successfully');
    }

    /**
     * Approve a form
     */
    public function approve($id)
    {
        // Form approval logic here
        return redirect()->route('admin.forms.index')->with('success', 'Form approved successfully');
    }

    /**
     * Reject a form
     */
    public function reject($id)
    {
        // Form rejection logic here
        return redirect()->route('admin.forms.index')->with('success', 'Form rejected successfully');
    }

    /**
     * Delete a form
     */
    public function destroy($id)
    {
        // Form deletion logic here
        return redirect()->route('admin.forms.index')->with('success', 'Form deleted successfully');
    }
}
