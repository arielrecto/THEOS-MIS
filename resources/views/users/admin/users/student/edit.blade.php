<x-dashboard.admin.base>
    <x-notification-message />
    <x-dashboard.page-title :back_url="route('admin.users.students.index')" :title="_('student Edit')" />
    <div class="panel flex flex-col gap-2">
        <form action="{{route('admin.users.students.update', ['student' => $student->id])}}" method="post" class="w-full flex flex-col gap-2 capitalize">
            @csrf
            @method('put')
            <h1 class="form-title">
                student Edit Form
            </h1>
            <div class="flex flex-col gap-2">
                <label for="" class="input-generic-label">username</label>
                <input type="text" name="name" class="input-generic" placeholder="{{$student->name}}">
                @if ($errors->has('name'))
                    <p class="text-xs text-error">
                        {{ $errors->first('name') }}
                    </p>
                @endif
            </div>
            <div class="flex flex-col gap-2">
                <label for="" class="input-generic-label">email</label>
                <input type="email" name="email" class="input-generic" placeholder="{{$student->email}}">
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
