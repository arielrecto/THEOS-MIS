<?php

namespace App\Http\Requests\Auth;

use App\Enums\UserRoles;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        // Validate login type based on user role
        $this->validateLoginType();

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Validate that the user is logging in with the correct login type
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLoginType(): void
    {
        $user = Auth::user();
        $loginType = $this->input('type');
        
        // Get user's role
        $userRole = $user->roles()->first()?->name;

        // If user is a student
        if ($userRole === UserRoles::STUDENT->value) {
            // Student must use student login
            if ($loginType !== 'student') {
                Auth::logout();
                
                throw ValidationException::withMessages([
                    'email' => 'You need to login using the Student Login. Please go back and select Student Login.',
                ]);
            }
        } else {
            // All other roles (employee, admin, teacher, etc.) must use employee login
            if ($loginType === 'student') {
                Auth::logout();
                
                throw ValidationException::withMessages([
                    'email' => 'You need to login using the Employee Login. Please go back and select Employee Login.',
                ]);
            }
        }
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
