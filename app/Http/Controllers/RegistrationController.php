<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     * Chức năng: Danh sách Registration
     */
    public function index()
    {
        $registrations = Registration::latest()->paginate(10);
        return view('registrations.index', compact('registrations'));
    }

    /**
     * Show the form for creating a new resource.
     * Chức năng: Form để điền thông tin Registration
     */
    public function create()
    {
        $programs = config('programs.programs');
        return view('registrations.create', compact('programs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $programs = config('programs.programs');
        
        $validated = $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:registrations,email',
            'gender' => 'required|in:male,female,other',
            'date_of_birth' => 'required|date',
            'country_of_birth' => 'required|string|max:255', // Bắt buộc
            'nationality' => 'required|string|max:255', // Bắt buộc
            'passport_no' => 'nullable|string|max:255',
            'passport_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'permanent_address' => 'nullable|string',
            'present_address' => 'nullable|string',
            'program' => 'required|in:' . implode(',', $programs)
        ]);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $validated['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        // Handle passport file upload
        if ($request->hasFile('passport_file')) {
            $validated['passport_file'] = $request->file('passport_file')->store('passport_files', 'public');
        }

        $registration = Registration::create($validated);

        // Check if user clicked "Next" button to create application
        if ($request->input('action') === 'save_and_continue') {
            // Create application from this registration
            $application = \App\Models\Application::createFromRegistration($registration->id);
            
            return redirect()->route('applications.show', $application)
                            ->with('success', 'Registration created and Application generated successfully!');
        }

        // Default: go to registration details
        return redirect()->route('registrations.show', $registration)
                        ->with('success', 'Personal Information saved successfully!');
    }

    /**
     * Display the specified resource.
     * Chức năng: Xem chi tiết 1 Registration
     */
    public function show(Registration $registration)
    {
        return view('registrations.show', compact('registration'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Registration $registration)
    {
        return view('registrations.edit', compact('registration'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Registration $registration)
    {
        $programs = config('programs.programs');
        
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:registrations,email,' . $registration->id,
            'phone' => 'required|string|max:20',
            'gender' => 'required|in:male,female,other',
            'date_of_birth' => 'required|date',
            'country_of_birth' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'passport_no' => 'nullable|string|max:255',
            'passport_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'permanent_address' => 'nullable|string',
            'present_address' => 'nullable|string',
            'program' => 'required|in:' . implode(',', $programs)
        ]);

        // Handle file upload
        if ($request->hasFile('passport_file')) {
            // Delete old file if exists
            if ($registration->passport_file) {
                Storage::disk('public')->delete($registration->passport_file);
            }
            $validated['passport_file'] = $request->file('passport_file')->store('passport_files', 'public');
        }

        $registration->update($validated);

        return redirect()->route('registrations.show', $registration)
                        ->with('success', 'Registration updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Registration $registration)
    {
        // Delete associated file
        if ($registration->passport_file) {
            Storage::disk('public')->delete($registration->passport_file);
        }

        $registration->delete();

        return redirect()->route('registrations.index')
                        ->with('success', 'Registration deleted successfully!');
    }
}
