<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        return view('users.teacher.profile.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'last_name'  => 'required',
            'first_name' => 'required',
            'sex'        => 'required',
            'address'    => 'required',
        ]);

        $user = Auth::user();

        $profile = Profile::create([
            'last_name'  => $request->last_name,
            'first_name' => $request->first_name,
            'middle_name'=> $request->middle_name,
            'sex'        => $request->sex,
            'address'    => $request->address,
            'contact_no' => $request->contact_no,
            'user_id'    => $user->id,
        ]);

        if ($request->hasFile('image')) {
            $imageName = 'PRFL-' . uniqid() . '.' . $request->image->extension();
            $dir = $request->image->storeAs('/teacher/', $imageName, 'public');
            $profile->update(['image' => asset('/storage/' . $dir)]);
        }

        return to_route('teacher.profile.show', ['profile' => $profile->id]);
    }

    public function show($id)
    {
        $teacher = User::with(['profile', 'roles'])
            ->whereHas('profile', fn($q) => $q->where('id', $id))
            ->firstOrFail();

        $classrooms = Classroom::where('teacher_id', $teacher->id)
            ->with(['subject', 'strand', 'academicYear'])
            ->withCount('classroomStudents')
            ->latest()
            ->get();

        return view('users.teacher.profile.show', compact('teacher', 'classrooms'));
    }

    public function edit(string $id)
    {
        $profile = Profile::with('user')->findOrFail($id);
        $teacher = $profile->user;

        $classrooms = Classroom::where('teacher_id', $teacher->id)
            ->with(['subject', 'strand', 'academicYear'])
            ->withCount('classroomStudents')
            ->latest()
            ->get();

        return view('users.teacher.profile.edit', compact('teacher', 'profile', 'classrooms'));
    }

    public function update(Request $request, string $id)
    {
        $profile = Profile::with('user')->findOrFail($id);
        $teacher = $profile->user;

        $request->validate([
            'first_name'  => 'required|string|max:255',
            'last_name'   => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'sex'         => 'required|in:male,female',
            'address'     => 'required|string|max:500',
            'contact_no'  => 'nullable|string|max:11',
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $teacher->id,
            'password'    => 'nullable|confirmed|min:8',
            'image'       => 'nullable|image|max:2048',
        ]);

        // Update profile
        $profile->update([
            'first_name'  => $request->first_name,
            'last_name'   => $request->last_name,
            'middle_name' => $request->middle_name,
            'sex'         => $request->sex,
            'address'     => $request->address,
            'contact_no'  => $request->contact_no,
        ]);

        // Update profile picture
        if ($request->hasFile('image')) {
            $imageName = 'PRFL-' . uniqid() . '.' . $request->image->extension();
            $dir = $request->image->storeAs('/teacher/', $imageName, 'public');
            $profile->update(['image' => asset('/storage/' . $dir)]);
        }

        // Update account info
        $accountData = [
            'name'  => $request->name,
            'email' => $request->email,
        ];
        if ($request->filled('password')) {
            $accountData['password'] = Hash::make($request->password);
        }
        $teacher->update($accountData);

        return redirect()
            ->route('teacher.profile.show', ['profile' => $profile->id])
            ->with('success', 'Profile updated successfully.');
    }

    public function destroy(string $id)
    {
        //
    }
}
