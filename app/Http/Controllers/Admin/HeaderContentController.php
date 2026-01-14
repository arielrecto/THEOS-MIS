<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeaderContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HeaderContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $headerContents = HeaderContent::latest()->paginate(10);
        return view('users.admin.cms.header-content.index', compact('headerContents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.admin.cms.header-content.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|url|max:255',
            'show_button' => 'boolean',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // If this content is set to active, deactivate all others
        if ($request->boolean('is_active')) {
            HeaderContent::where('is_active', true)->update(['is_active' => false]);
        }

        HeaderContent::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'show_button' => $request->boolean('show_button'),
            'button_text' => $request->button_text,
            'button_url' => $request->button_url,
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()
            ->with('success', 'Header content created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(HeaderContent $headerContent)
    {
        return view('users.admin.cms.header-content.show', compact('headerContent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HeaderContent $headerContent)
    {
        return view('users.admin.cms.header-content.edit', compact('headerContent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HeaderContent $headerContent)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|url|max:255',
            'show_button' => 'boolean',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // If this content is set to active, deactivate all others
        if ($request->boolean('is_active') && !$headerContent->is_active) {
            HeaderContent::where('is_active', true)
                ->where('id', '!=', $headerContent->id)
                ->update(['is_active' => false]);
        }

        $headerContent->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'show_button' => $request->boolean('show_button'),
            'button_text' => $request->button_text,
            'button_url' => $request->button_url,
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()
            ->with('success', 'Header content updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HeaderContent $headerContent)
    {
        $headerContent->delete();

        return redirect()->route('admin.header-contents.index')
            ->with('success', 'Header content deleted successfully.');
    }

    /**
     * Toggle active status
     */
    public function toggleActive(HeaderContent $headerContent)
    {
        // If activating this content, deactivate all others
        if (!$headerContent->is_active) {
            HeaderContent::where('is_active', true)->update(['is_active' => false]);
            $headerContent->update(['is_active' => true]);
            $message = 'Header content activated successfully.';
        } else {
            $headerContent->update(['is_active' => false]);
            $message = 'Header content deactivated successfully.';
        }

        return redirect()->back()->with('success', $message);
    }
}
