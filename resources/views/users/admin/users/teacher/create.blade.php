<x-dashboard.admin.base>
    <x-notification-message />
    <x-dashboard.page-title :back_url="route('admin.users.teacher.index')" :title="_('Teacher Create')" />
    <div class="panel flex flex-col gap-2">
        <form action="{{route('admin.users.teacher.store')}}" method="post" class="w-full flex flex-col gap-2 capitalize">
            @csrf
            <h1 class="form-title">
                Teacher Create Form
            </h1>
            <div class="flex flex-col gap-2">
                <label for="" class="input-generic-label">username</label>
                <input type="text" name="name" class="input-generic">
                @if ($errors->has('name'))
                    <p class="text-xs text-error">
                        {{ $errors->first('name') }}
                    </p>
                @endif
            </div>
            <div class="flex flex-col gap-2">
                <label for="" class="input-generic-label">email</label>
                <input type="email" name="email" class="input-generic">
                @if ($errors->has('email'))
                    <p class="text-xs text-error">
                        {{ $errors->first('email') }}
                    </p>
                @endif
            </div>
            <div class="flex flex-col gap-2">
                <label for="" class="input-generic-label">password</label>
                <input type="password" name="password" class="input-generic">
                @if ($errors->has('password'))
                    <p class="text-xs text-error">
                        {{ $errors->first('password') }}
                    </p>
                @endif
            </div>
            <div class="flex flex-col gap-2">
                <label for="" class="input-generic-label">password confirmation</label>
                <input type="password" name="password_confirmation" class="input-generic">
            </div>

            <button class="btn btn-sm btn-accent">
                Submit
            </button>
        </form>
    </div>
</x-dashboard.admin.base>
