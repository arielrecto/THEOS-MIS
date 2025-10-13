<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function index()
    {
        $contactInfo = ContactUs::first();
        return view('users.admin.cms.contact.index', compact('contactInfo'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'phone_number' => ['required', 'string', 'max:255'],
            'email_address' => ['required', 'email', 'max:255'],
        ]);

        ContactUs::updateOrCreate(
            ['id' => 1], // We only want one record
            $validated
        );

        return redirect()
            ->route('admin.CMS.contact.index')
            ->with('success', 'Contact information updated successfully.');
    }
}
