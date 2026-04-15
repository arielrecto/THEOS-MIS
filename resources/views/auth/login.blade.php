<x-auth.base>
    <!-- Display Login Type Badge -->
    @if(request('type'))
        <div class="mt-4 text-center">
            @if(request('type') === 'student')
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-100 text-blue-700 rounded-lg">
                    <i class="fi fi-rr-graduation-cap"></i>
                    <span class="font-semibold">Student Login</span>
                </div>
            @elseif(request('type') === 'employee')
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-100 text-green-700 rounded-lg">
                    <i class="fi fi-rr-briefcase"></i>
                    <span class="font-semibold">Employee Login</span>
                </div>
            @else
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg">
                    <i class="fi fi-rr-user"></i>
                    <span class="font-semibold">{{ ucfirst(request('type')) }} Login</span>
                </div>
            @endif
        </div>
    @endif

    <form action="{{ route('login') }}" method="post" class="flex flex-col gap-4 mt-4">
        @csrf

        <!-- Hidden field to preserve login type -->
        @if(request('type'))
            <input type="hidden" name="type" value="{{ request('type') }}">
        @endif

        <div class="flex flex-col">
            <label class="text-sm font-semibold text-secondary">Email</label>
            <input type="email" name="email" class="input input-accent bg-base-200 text-accent" required>
        </div>

        <div class="flex flex-col" x-data="{ showPassword: false }">
            <label class="text-sm font-semibold text-secondary">Password</label>
            <div class="relative">
                <input
                    :type="showPassword ? 'text' : 'password'"
                    name="password"
                    class="input input-accent bg-base-200 text-accent w-full pr-10"
                    required
                >
                <button
                    type="button"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center"
                    @click="showPassword = !showPassword"
                >
                    <i class="fi" :class="showPassword ? 'fi-rr-eye-crossed' : 'fi-rr-eye'"></i>
                </button>
            </div>
        </div>

        <div class="flex justify-between items-center mt-2 text-sm">
            <label class="flex gap-2 items-center cursor-pointer">
                <input type="checkbox" name="remember" class="checkbox checkbox-accent">
                <span class="text-secondary">Remember me</span>
            </label>
            <a href="{{ route('password.request') }}" class="text-accent hover:underline">Forgot password?</a>
        </div>

        <button class="mt-4 w-full btn btn-accent">Login</button>
    </form>

    <!-- Back to Login Type Selection -->
    <div class="mt-4 text-center">
        <a href="{{ route('login.type') }}" class="text-sm text-gray-600 hover:text-accent hover:underline inline-flex items-center gap-2">
            <i class="fi fi-rr-arrow-left"></i>
            <span>Choose different login type</span>
        </a>
    </div>
</x-auth.base>
