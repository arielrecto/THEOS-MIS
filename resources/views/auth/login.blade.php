<x-auth.base>
    <form action="{{ route('login') }}" method="post" class="flex flex-col gap-4 mt-4">
        @csrf

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
</x-auth.base>
