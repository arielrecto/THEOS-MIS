<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.teacher.profile.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'last_name' => 'required',
            'first_name' => 'required',
            'sex' => 'required',
            'address' => 'required'
        ]);


        $user = Auth::user();

        $profile = Profile::create([
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'sex' => $request->sex,
            'address' => $request->address,
            'contact_no' => $request->contact_no,
            'user_id' => $user->id
        ]);


        if ($request->hasFile('image')) {
            $imageName = 'PRFL-' . uniqid() . '.' . $request->image->extension();
            $dir = $request->image->storeAs('/teacher/', $imageName, 'public');

            $profile->update([
                'image' => asset('/storage/' . $dir),
            ]);
        }




        return to_route('teacher.profile.show', ['profile' => $profile->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $teacher = User::whereHas('profile', function($q) use($id){
            $q->whereId($id);
        })->first();



        return view('users.teacher.profile.show', compact(['teacher']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
