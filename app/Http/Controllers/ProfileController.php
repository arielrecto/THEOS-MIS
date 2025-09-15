<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {


        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }



        if ($request->hasFile('image')) {


            $request->hasProfile() ? $request->user()->profile()->profilePicture()->updateOrCreate([
                'file_dir' => asset('storage/profile_picture/' . $request->file('image')->getClientOriginalName()),
                'file_name' => $request->file('image')->getClientOriginalName(),
                'file_type' => $request->file('image')->getClientMimeType(),
                'attachable_id' => $request->user()->profile()->id,
                'attachable_type' => Profile::class,
                'file_size' => $request->file('image')->getSize(),
            ]) : $request->user()->profilePicture()->create([
                'file_dir' => asset('storage/profile_picture/' . $request->file('image')->getClientOriginalName()),
                'file_name' => $request->file('image')->getClientOriginalName(),
                'file_type' => $request->file('image')->getClientMimeType(),
                'attachable_id' => $request->user()->id,
                'attachable_type' => User::class,
                'file_size' => $request->file('image')->getSize(),
            ]);


            $request->image->storeAs('profile_picture', $request->file('image')->getClientOriginalName(), 'public');
        }
        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function twoFactor(Request $request): RedirectResponse
    {

        $user = $request->user();
        $user->is_two_factor_enabled = $request->has('is_two_factor_enabled') == 'on' ? true : false;

        if ($user->is_two_factor_enabled && !$user->two_factor_pin) {
            $pin = random_int(100000, 999999);
            $user->two_factor_pin = Hash::make($pin);
            // Here you would typically send the PIN to the user's email or phone number
            $user->notify(new \App\Notifications\TwoFactorNotification($pin));
        } elseif (!$user->is_two_factor_enabled) {
            $user->two_factor_pin = null; // Clear the PIN if 2FA is disabled
        }
        $user->save();

        // Here you would typically send the PIN to the user's email or phone number

        return Redirect::route('profile.edit')->with('status', 'two-factor-enabled');
    }
}
