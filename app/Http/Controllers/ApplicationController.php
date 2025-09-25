<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Registration;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     * Chức năng: Danh sách Application (có filter theo status, payment)
     */
    public function index(Request $request)
    {
        $query = Application::with('registration')->latest();

        // Filter by program
        if ($request->filled('program')) {
            $query->where('program', 'like', '%' . $request->program . '%');
        }

        // Filter by date range
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // Filter by application number
        if ($request->filled('application_no')) {
            $query->where('application_id', 'like', '%' . $request->application_no . '%');
        }

        $applications = $query->paginate(15)->appends($request->query());

        return view('applications.index', compact('applications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $registrations = Registration::whereDoesntHave('applications')->get();
        return view('applications.create', compact('registrations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'registration_id' => 'required|exists:registrations,id',
            'status' => 'required|in:submitted,approved,enrolled,rejected',
            'payment_status' => 'required|in:unpaid,partial,paid'
        ]);

        // Application sẽ tự động sinh application_id, student_name, program từ Registration
        $application = Application::create($validated);

        return redirect()->route('applications.show', $application)
                        ->with('success', 'Application created successfully!');
    }

    /**
     * Display the specified resource.
     * Chức năng: Xem chi tiết Application
     */
    public function show(Application $application)
    {
        $application->load('registration');
        return view('applications.show', compact('application'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Application $application)
    {
        return view('applications.edit', compact('application'));
    }

    /**
     * Update the specified resource in storage.
     * Chức năng: Cập nhật status và payment status
     */
    public function update(Request $request, Application $application)
    {
        $validated = $request->validate([
            'status' => 'required|in:submitted,approved,enrolled,rejected',
            'payment_status' => 'required|in:unpaid,partial,paid'
        ]);

        $application->update($validated);

        return redirect()->route('applications.show', $application)
                        ->with('success', 'Application updated successfully!');
    }

    /**
     * Update only status
     */
    public function updateStatus(Request $request, Application $application)
    {
        $validated = $request->validate([
            'status' => 'required|in:submitted,approved,enrolled,rejected'
        ]);

        $application->update($validated);

        return redirect()->back()->with('success', 'Status updated successfully!');
    }

    /**
     * Update only payment status
     */
    public function updatePaymentStatus(Request $request, Application $application)
    {
        $validated = $request->validate([
            'payment_status' => 'required|in:unpaid,partial,paid'
        ]);

        $application->update($validated);

        return redirect()->back()->with('success', 'Payment status updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        $application->delete();

        return redirect()->route('applications.index')
                        ->with('success', 'Application deleted successfully!');
    }

    /**
     * Create Application from Registration
     */
    public function createFromRegistration(Registration $registration)
    {
        // Check if registration already has application
        if ($registration->applications()->exists()) {
            return redirect()->route('registrations.show', $registration)
                           ->with('error', 'This registration already has an application!');
        }

        $application = Application::createFromRegistration($registration->id);

        return redirect()->route('applications.show', $application)
                        ->with('success', 'Application created from registration successfully!');
    }
}
