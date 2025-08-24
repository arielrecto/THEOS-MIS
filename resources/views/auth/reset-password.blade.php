<x-guest-layout>
    <div class="card w-full max-w-md bg-base-100 ">
        <div class="card-body">
            <h2 class="card-title text-2xl font-bold text-center mb-6">{{ __('Reset Password') }}</h2>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div class="form-control w-full">
                    <label for="email" class="label">
                        <span class="label-text">{{ __('Email Address') }}</span>
                    </label>
                    <input type="email"
                           id="email"
                           name="email"
                           class="input input-bordered w-full @error('email') input-error @enderror"
                           value="{{ old('email', $request->email) }}"
                           required
                           autofocus />
                    @error('email')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-control w-full">
                    <label for="password" class="label">
                        <span class="label-text">{{ __('New Password') }}</span>
                    </label>
                    <input type="password"
                           id="password"
                           name="password"
                           class="input input-bordered w-full @error('password') input-error @enderror"
                           required
                           autocomplete="new-password" />
                    @error('password')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-control w-full">
                    <label for="password_confirmation" class="label">
                        <span class="label-text">{{ __('Confirm Password') }}</span>
                    </label>
                    <input type="password"
                           id="password_confirmation"
                           name="password_confirmation"
                           class="input input-bordered w-full @error('password_confirmation') input-error @enderror"
                           required
                           autocomplete="new-password" />
                    @error('password_confirmation')
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
                        {{ __('Reset Password') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
