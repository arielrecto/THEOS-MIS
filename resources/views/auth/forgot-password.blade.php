<x-guest-layout>
    <div class="card w-full max-w-md bg-base-100">
        <div class="card-body">
            <h2 class="card-title text-2xl font-bold text-center mb-2">{{ __('Forgot Password') }}</h2>

            <div class="text-sm text-gray-600 mb-6">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                <!-- Email Address -->
                <div class="form-control w-full">
                    <label for="email" class="label">
                        <span class="label-text">{{ __('Email Address') }}</span>
                    </label>
                    <input type="email"
                           id="email"
                           name="email"
                           class="input input-bordered w-full @error('email') input-error @enderror"
                           value="{{ old('email') }}"
                           required
                           autofocus />
                    @error('email')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <div class="card-actions justify-between items-center mt-6">
                    <a href="{{ route('login') }}"
                       class="link link-hover text-sm text-gray-600">
                        {{ __('Back to Login') }}
                    </a>
                    <button type="submit" class="btn btn-accent">
                        {{ __('Send Reset Link') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
