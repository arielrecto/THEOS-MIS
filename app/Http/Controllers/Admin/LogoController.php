<?php

namespace App\Http\Controllers\Admin;

use App\Models\Logo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class LogoController extends Controller
{
    public function index()
    {
        $logos = Logo::latest()->get();
        return view('users.admin.cms.logo.index', compact('logos'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'required|in:main,favicon,footer'
        ]);

        $path = $request->file('logo')->store('logos', 'public');

        Logo::create([
            'name' => $request->name,
            'path' => $path,
            'type' => $request->type,
            'is_active' => false
        ]);

        return back()->with('success', 'Logo uploaded successfully');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function toggleActive(Logo $logo)
    {
        if ($logo->is_active) {
            $logo->update(['is_active' => false]);
            return back()->with('success', 'Logo set to inactive.');
        }

        // When activating: deactivate other logos of same type first
        Logo::where('type', $logo->type)
            ->where('id', '!=', $logo->id)
            ->update(['is_active' => false]);

        $logo->update(['is_active' => true]);

        return back()->with('success', 'Logo set to active.');
    }

    public function destroy(Logo $logo)
    {
        if ($logo->path) {
            Storage::disk('public')->delete($logo->path);
        }

        $logo->delete();

        return back()->with('success', 'Logo deleted successfully');
    }
}
