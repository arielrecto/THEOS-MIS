<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // If 2FA is not enabled, proceed
        if (!$user->is_two_factor_enabled) {
            return $next($request);
        }

        // If 2FA is verified in session, proceed
        if (session()->get('two_factor_verified')) {
            return $next($request);
        }

        // Store intended URL in session
        session()->put('url.intended', url()->current());

        // Redirect to 2FA verification page
        return redirect()->route('two-factor-authentication.show');
    }
}
