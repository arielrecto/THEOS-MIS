<?php

namespace App\Http\Controllers\Admin;

use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->get();
        return view('users.admin.cms.gallery.index', compact('galleries'));
    }

    public function create()
    {
        return view('users.admin.cms.gallery.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $path = $request->file('image')->store('galleries', 'public');

        Gallery::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'path' => $path,
            'is_active' => false
        ]);

        return redirect()->route('admin.CMS.gallery.index')
            ->with('success', 'Image uploaded successfully');
    }

    public function toggleActive(Gallery $gallery)
    {
        $gallery->update(['is_active' => !$gallery->is_active]);
        return back()->with('success', 'Gallery status updated successfully');
    }

    public function destroy(Gallery $gallery)
    {
        if ($gallery->path) {
            Storage::disk('public')->delete($gallery->path);
        }

        $gallery->delete();
        return back()->with('success', 'Image deleted successfully');
    }
}
