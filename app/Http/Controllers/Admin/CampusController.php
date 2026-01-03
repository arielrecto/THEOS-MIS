<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CampusController extends Controller
{
    public function index()
    {
        $campuses = Campus::with('image')->latest()->paginate(10);

        return view('users.admin.cms.campus.index', compact('campuses'));
    }

    public function create()
    {
        return view('users.admin.cms.campus.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateCampus($request);

        $campus = Campus::create([
            'name' => $validated['name'],
            'address' => $validated['address'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);

        if ($request->hasFile('image')) {
            $this->upsertCampusImage($campus, $request->file('image'));
        }

        return redirect()
            ->route('admin.CMS.campuses.index')
            ->with('success', 'Campus created successfully.');
    }

    public function show(Campus $campus)
    {
        $campus->load('image');

        return view('users.admin.cms.campus.show', compact('campus'));
    }

    public function edit(Campus $campus)
    {
        $campus->load('image');

        return view('users.admin.cms.campus.edit', compact('campus'));
    }

    public function update(Request $request, Campus $campus)
    {
        $validated = $this->validateCampus($request, $campus->id);

        $campus->update([
            'name' => $validated['name'],
            'address' => $validated['address'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);

        if ($request->boolean('remove_image')) {
            $this->deleteCampusImage($campus);
        }

        if ($request->hasFile('image')) {
            $this->upsertCampusImage($campus, $request->file('image'));
        }

        return redirect()
            ->route('admin.CMS.campuses.show', $campus)
            ->with('success', 'Campus updated successfully.');
    }

    public function destroy(Campus $campus)
    {
        $this->deleteCampusImage($campus);
        $campus->delete();

        return redirect()
            ->route('admin.CMS.campuses.index')
            ->with('success', 'Campus deleted successfully.');
    }

    private function validateCampus(Request $request, ?int $campusId = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'image' => ['nullable', 'image', 'max:5120'], // 5MB
            'remove_image' => ['nullable', 'boolean'],
        ]);
    }

    private function upsertCampusImage(Campus $campus, $file): void
    {
        // delete existing
        $this->deleteCampusImage($campus);

        // store new
        $storedPath = $file->store('campuses', 'public'); // e.g. campuses/abc.jpg
        $publicPath = 'storage/' . $storedPath;           // for asset()

        // Attachment model columns: file_dir, file_name, file_type, file_size, attachable_id, attachable_type
        $campus->image()->create([
            'file_dir'  => $publicPath,
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
        ]);
    }

    private function deleteCampusImage(Campus $campus): void
    {
        $campus->loadMissing('image');

        if (!$campus->image) return;

        $fileDir = $campus->image->file_dir; // e.g. storage/campuses/abc.jpg
        if (is_string($fileDir) && str_starts_with($fileDir, 'storage/')) {
            $diskPath = substr($fileDir, strlen('storage/')); // campuses/abc.jpg
            Storage::disk('public')->delete($diskPath);
        }

        $campus->image()->delete();
    }
}
