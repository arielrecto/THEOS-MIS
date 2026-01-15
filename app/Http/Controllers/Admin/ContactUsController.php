<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    /**
     * Display the contact information form.
     */
    public function index()
    {
        $contactInfo = ContactUs::first();
        return view('users.admin.cms.contact.index', compact('contactInfo'));
    }

    /**
     * Store or update contact information.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'content_label' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:255', 'regex:/^[0-9]{11}$/'],
            'email_address' => ['required', 'email', 'max:255'],
        ], [
            'content_label.required' => 'The content label field is required.',
            'phone_number.required' => 'The phone number field is required.',
            'phone_number.regex' => 'The phone number must be exactly 11 digits.',
            'email_address.required' => 'The email address field is required.',
            'email_address.email' => 'Please enter a valid email address.',
        ]);

        try {
            ContactUs::updateOrCreate(
                ['id' => 1], // We only want one record
                [
                    'content_label' => $validated['content_label'],
                    'phone_number' => $validated['phone_number'],
                    'email_address' => $validated['email_address'],
                ]
            );

            return redirect()
                ->route('admin.CMS.contact.index')
                ->with('success', 'Contact information updated successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to update contact information: ' . $e->getMessage())
                ->withInput();
        }
    }
}
