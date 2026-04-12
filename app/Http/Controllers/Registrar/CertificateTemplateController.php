<?php

namespace App\Http\Controllers\Registrar;

use App\Http\Controllers\Controller;
use App\Models\CertificateTemplate;
use Illuminate\Http\Request;

class CertificateTemplateController extends Controller
{
    public function index()
    {
        $templates = CertificateTemplate::all();
        return view('users.registrar.certificate-templates.index', compact('templates'));
    }

    public function edit(CertificateTemplate $certificateTemplate)
    {
        $placeholders = CertificateTemplate::getAvailablePlaceholders();
        return view('users.registrar.certificate-templates.edit', [
            'template' => $certificateTemplate,
            'placeholders' => $placeholders
        ]);
    }

    public function update(Request $request, CertificateTemplate $certificateTemplate)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string',
            'content' => 'required|string',
            'footer' => 'nullable|string',
            'signatory_name' => 'required|string|max:255',
            'signatory_title' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $certificateTemplate->update($validated);

        return redirect()
            ->route('registrar.certificate-templates.index')
            ->with('success', 'Template updated successfully!');
    }
}
