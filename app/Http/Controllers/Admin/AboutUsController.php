<?php

namespace App\Http\Controllers\Admin;

use App\Models\AboutUs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AboutUsController extends Controller
{
    public function index()
    {
        $aboutUs = AboutUs::first() ?? new AboutUs();
        return view('users.admin.cms.about-us.index', compact('aboutUs'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'sub_title' => 'nullable|string|max:255',
            'description' => 'required|string',
            'mission_and_vision' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'address' => 'nullable'
        ]);

        $aboutUs = AboutUs::first() ?? new AboutUs();

        if ($request->hasFile('image')) {
            if ($aboutUs->path) {
                Storage::disk('public')->delete($aboutUs->path);
            }
            $validated['path'] = $request->file('image')->store('about', 'public');
        }

        $aboutUs->fill($validated);
        $aboutUs->save();

        return back()->with('success', 'About Us content updated successfully');
    }
}
