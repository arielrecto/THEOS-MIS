<x-dashboard.admin.base>
    <x-notification-message />
    <x-dashboard.page-title :back_url="route('admin.academic-year.index')" :title="_('Academic Year Create')" />
    <div class="flex flex-col gap-2 panel">
        <form action="{{route('admin.academic-year.store')}}" method="post" class="flex flex-col gap-2 w-full capitalize">
            @csrf
            <h1 class="form-title">
                Academic Year Create Form
            </h1>
            <div class="flex flex-col gap-2">
                <label for="" class="input-generic-label">name</label>
                <input type="text" name="name" class="input-generic">
                @if ($errors->has('name'))
                    <p class="text-xs text-error">
                        {{ $errors->first('name') }}
                    </p>
                @endif
            </div>
            <div class="flex flex-col gap-2">
                <label for="" class="input-generic-label">Start Date</label>
                <input type="date" name="start_date" class="input-generic">
                @if ($errors->has('start_date'))
                    <p class="text-xs text-error">
                        {{ $errors->first('start_date') }}
                    </p>
                @endif
            </div>
            <div class="flex flex-col gap-2">
                <label for="" class="input-generic-label">End Date</label>
                <input type="date" name="end_date" class="input-generic">
                @if ($errors->has('end_date'))
                    <p class="text-xs text-error">
                        {{ $errors->first('end_date') }}
                    </p>
                @endif
            </div>
          
            <button class="btn btn-sm btn-accent">
                Submit
            </button>
        </form>
    </div>
</x-dashboard.admin.base>
