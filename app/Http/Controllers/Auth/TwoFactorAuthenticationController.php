<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Notifications\TwoFactorNotification;

class TwoFactorAuthenticationController extends Controller
{
    public function show()
    {

        $user = User::find(auth()->id());

        $pin = random_int(100000, 999999);

        $user->update([
            'two_factor_pin' => Hash::make($pin)
        ]);


        $user->notify(new TwoFactorNotification($pin));

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

    public function resend()
    {
        $user = User::find(auth()->id());
        //` Here you would typically regenerate the PIN and send it via email
        // For now, we'll just use the existing PIN

        $pin = random_int(100000, 999999);

        $user->update([
            'two_factor_pin' => Hash::make($pin)
        ]);

        $user->notify(new TwoFactorNotification($pin));

        return back()->with('status', 'PIN has been resent to your email.');
    }
}
