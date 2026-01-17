<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoginContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LoginContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $loginContents = LoginContent::with('backgroundImage')->latest()->paginate(10);

        return view('users.admin.cms.login-content.index', compact('loginContents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.admin.cms.login-content.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validateLoginContent($request);

        DB::transaction(function () use ($validated, $request) {
            // If setting as active, deactivate others
            if ($validated['is_active'] ?? false) {
                LoginContent::where('is_active', true)->update(['is_active' => false]);
            }

            $loginContent = LoginContent::create([
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'is_active' => (bool)($validated['is_active'] ?? false),
            ]);

            if ($request->hasFile('background_image')) {
                $this->upsertBackgroundImage($loginContent, $request->file('background_image'));
            }
        });

        return redirect()
            ->route('admin.CMS.login-contents.index')
            ->with('success', 'Login content created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LoginContent $loginContent)
    {
        $loginContent->load('backgroundImage');


        return view('users.admin.cms.login-content.show', compact('loginContent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LoginContent $loginContent)
    {
        $loginContent->load('backgroundImage');

        return view('users.admin.cms.login-content.edit', compact('loginContent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LoginContent $loginContent)
    {
        $validated = $this->validateLoginContent($request);

        DB::transaction(function () use ($validated, $request, $loginContent) {
            // If setting as active, deactivate others
            if ($validated['is_active'] ?? false) {
                LoginContent::where('id', '!=', $loginContent->id)
                    ->where('is_active', true)
                    ->update(['is_active' => false]);
            }

            $loginContent->update([
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'is_active' => (bool)($validated['is_active'] ?? false),
            ]);

            if ($request->boolean('remove_background_image')) {
                $this->deleteBackgroundImage($loginContent);
            }

            if ($request->hasFile('background_image')) {
                $this->upsertBackgroundImage($loginContent, $request->file('background_image'));
            }
        });

        return redirect()
            ->route('admin.CMS.login-contents.show', $loginContent)
            ->with('success', 'Login content updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LoginContent $loginContent)
    {
        $this->deleteBackgroundImage($loginContent);
        $loginContent->delete();

        return redirect()
            ->route('admin.CMS.login-contents.index')
            ->with('success', 'Login content deleted successfully.');
    }

    private function validateLoginContent(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['nullable', 'boolean'],
            'background_image' => ['nullable', 'image', 'max:5120'], // 5MB
            'remove_background_image' => ['nullable', 'boolean'],
        ]);
    }

    private function upsertBackgroundImage(LoginContent $loginContent, $file): void
    {
        $this->deleteBackgroundImage($loginContent);

        $storedPath = $file->store('login-backgrounds', 'public');
        $publicPath = 'storage/' . $storedPath;

        $loginContent->backgroundImage()->create([
            'file_dir' => $publicPath,
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
        ]);
    }

    private function deleteBackgroundImage(LoginContent $loginContent): void
    {
        $loginContent->loadMissing('backgroundImage');

        if (!$loginContent->backgroundImage) return;

        $fileDir = $loginContent->backgroundImage->file_dir;
        if (is_string($fileDir) && str_starts_with($fileDir, 'storage/')) {
            $diskPath = substr($fileDir, strlen('storage/'));
            Storage::disk('public')->delete($diskPath);
        }

        $loginContent->backgroundImage()->delete();
    }
}
