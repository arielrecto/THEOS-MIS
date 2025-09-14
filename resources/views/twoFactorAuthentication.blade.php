<x-app-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="mb-4 text-center">
                <h2 class="text-2xl font-bold">Two-Factor Authentication</h2>
                <p class="text-sm text-gray-600 mt-2">Please enter the 6-digit PIN sent to your email</p>
            </div>

            @if ($errors->any())
                <div class="mb-4">
                    <div class="text-sm font-medium text-red-600">
                        {{ __('Whoops! Something went wrong.') }}
                    </div>
                    <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('two-factor-authentication.verify') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="pin" class="block text-sm font-medium text-gray-700">PIN Code</label>
                        <input
                            type="text"
                            name="pin"
                            id="pin"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-accent focus:border-accent sm:text-sm"
                            required
                            autofocus
                            inputmode="numeric"
                            pattern="[0-9]{6}"
                            maxlength="6"
                            autocomplete="off"
                        >
                    </div>

                    <div>
                        <button type="submit" class="w-full btn btn-accent">
                            Verify PIN
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
