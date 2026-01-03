<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Foundation;
use App\Models\Founder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FounderController extends Controller
{
    public function index()
    {
        $founders = Founder::with('image')->latest()->paginate(10);

        return view('users.admin.cms.founder.index', compact('founders'));
    }

    public function create()
    {
        return view('users.admin.cms.founder.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateFounder($request);

        $founder = Founder::create([
            'name' => $validated['name'],
            'bio' => $validated['bio'] ?? null,
            'is_active' => (bool)($validated['is_active'] ?? false),
        ]);

        if ($request->hasFile('image')) {
            $this->upsertFounderImage($founder, $request->file('image'));
        }

        return redirect()
            ->route('admin.CMS.founders.index')
            ->with('success', 'Founder created successfully.');
    }

    public function show(Founder $founder)
    {
        $founder->load('image');

        return view('users.admin.cms.founder.show', compact('founder'));
    }

    public function edit(Founder $founder)
    {
        $founder->load('image');

        return view('users.admin.cms.founder.edit', compact('founder'));
    }

    public function update(Request $request, Founder $founder)
    {
        $validated = $this->validateFounder($request);

        $founder->update([
            'name' => $validated['name'],
            'bio' => $validated['bio'] ?? null,
            'is_active' => (bool)($validated['is_active'] ?? false),
        ]);

        if ($request->boolean('remove_image')) {
            $this->deleteFounderImage($founder);
        }

        if ($request->hasFile('image')) {
            $this->upsertFounderImage($founder, $request->file('image'));
        }

        return redirect()
            ->route('admin.CMS.founders.show', $founder)
            ->with('success', 'Founder updated successfully.');
    }

    public function destroy(Founder $founder)
    {
        $this->deleteFounderImage($founder);
        $founder->delete();

        return redirect()
            ->route('admin.CMS.founders.index')
            ->with('success', 'Founder deleted successfully.');
    }

    private function validateFounder(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:5000'],
            'is_active' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'max:5120'], // 5MB
            'remove_image' => ['nullable', 'boolean'],
        ]);
    }

    private function upsertFounderImage(Founder $founder, $file): void
    {
        $this->deleteFounderImage($founder);

        $storedPath = $file->store('founders', 'public'); // founders/abc.jpg
        $publicPath = 'storage/' . $storedPath;

        // Attachment fillable: file_dir, file_name, file_type, file_size, attachable_id, attachable_type
        $founder->image()->create([
            'file_dir'  => $publicPath,
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
        ]);
    }

    private function deleteFounderImage(Founder $founder): void
    {
        $founder->loadMissing('image');

        if (!$founder->image) return;

        $fileDir = $founder->image->file_dir; // storage/founders/abc.jpg
        if (is_string($fileDir) && str_starts_with($fileDir, 'storage/')) {
            $diskPath = substr($fileDir, strlen('storage/')); // founders/abc.jpg
            Storage::disk('public')->delete($diskPath);
        }

        $founder->image()->delete();
    }
}
