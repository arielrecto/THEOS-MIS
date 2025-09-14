<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TwoFactorAuthenticationController extends Controller
{
    public function show()
    {
        return view('twoFactorAuthentication');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'pin' => ['required', 'string', 'size:6']
        ]);

        $user = auth()->user();

        if (Hash::check($request->pin, $user->two_factor_pin)) {
            session()->put('two_factor_verified', true);

            return redirect()->intended(route('home'));
        }

        return back()->withErrors(['pin' => 'The provided PIN is incorrect.']);
    }

    // public function resend()
    // {
    //     $user = auth()->user();
        // Here you would typically regenerate the PIN and send it via email
        // For now, we'll just use the existing PIN

    //     return back()->with('status', 'PIN has been resent to your email.');
    // }
}
