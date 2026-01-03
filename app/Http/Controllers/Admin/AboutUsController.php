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
            'title' => ['required', 'string', 'max:255'],
            'sub_title' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],

            // NEW: split fields (preferred)
            'vision' => ['nullable', 'string'],
            'mission' => ['nullable', 'string'],

            // Legacy field (optional now)
            'mission_and_vision' => ['nullable', 'string'],

            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'address' => ['nullable', 'string'],
        ]);

        $aboutUs = AboutUs::first() ?? new AboutUs();

        // Normalize mission/vision fallback from legacy field
        $vision = trim((string)($validated['vision'] ?? ''));
        $mission = trim((string)($validated['mission'] ?? ''));
        $legacy = trim((string)($validated['mission_and_vision'] ?? ''));

        if ((!$vision || !$mission) && $legacy) {
            $vision = $vision ?: $legacy;
            $mission = $mission ?: $legacy;
        }

        $data = $validated;
        $data['vision'] = $vision ?: null;
        $data['mission'] = $mission ?: null;

        // Keep legacy synced (optional, helps older pages still using it)
        if (!$legacy && ($data['vision'] || $data['mission'])) {
            $data['mission_and_vision'] = trim(
                "VISION:\n" . ($data['vision'] ?? '—') . "\n\nMISSION:\n" . ($data['mission'] ?? '—')
            );
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($aboutUs->path) {
                Storage::disk('public')->delete($aboutUs->path);
            }
            $data['path'] = $request->file('image')->store('about', 'public');
        }

        unset($data['image']); // never mass-assign the uploaded file object

        $aboutUs->fill($data);
        $aboutUs->save();

        return back()->with('success', 'About Us content updated successfully');
    }
}
