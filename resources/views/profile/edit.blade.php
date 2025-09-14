<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <a href="/home" class="flex items-center gap-2 mb-4 text-blue-600 hover:underline">
                        <i class="fi fi-rr-home"></i>
                        <span>Home</span>
                    </a>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <div class="mb-4">
                        <h2 class="text-lg font-medium text-gray-900">Two-Factor Authentication (2FA)</h2>
                        <p class="mt-1 text-sm text-gray-600">Enhance the security of your account by enabling
                            two-factor authentication.</p>
                    </div>

                    <div>
                        @if (Auth::user()->is_two_factor_enabled)
                            <form action="{{ route('profile.two-factor') }}" method="POST" class="flex flex-col gap-2 py-5">
                                @csrf
                                <div class="flex items-center">
                                    <input type="checkbox" name="is_two_factor_enabled" checked class="mb-2">
                                    <label for="is_two_factor_enabled" class="ml-2">Enable Two-Factor Authentication</label>
                                </div>
                                <input type="password"
                                       name="two_factor_pin"
                                       placeholder="Enter your 6-digit 2FA PIN"
                                       class="mb-2 p-2 border border-gray-300 rounded"
                                       minlength="6"
                                       maxlength="6"
                                       pattern="\d{6}"
                                       oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                       >
                                <button type="submit" class="btn btn-danger">Save</button>
                            </form>
                        @else
                            <form action="{{ route('profile.two-factor') }}" method="POST" class="flex flex-col gap-2 py-5">
                                @csrf

                                <div class="flex items-center">
                                    <input type="checkbox" name="is_two_factor_enabled" class="mb-2">
                                    <label for="is_two_factor_enabled" class="ml-2">Enable Two-Factor Authentication</label>
                                </div>
                                <button type="submit" class="btn btn-primary">Enable 2FA</button>
                            </form>
                        @endif
                    </div>

                </div>
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>

            </div>
        </div>
</x-app-layout>
