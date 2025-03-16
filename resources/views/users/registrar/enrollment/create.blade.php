<x-dashboard.registrar.base>
    <x-notification-message />
    <x-dashboard.page-title :back_url="route('registrar.enrollments.index')" :title="_('Enrollment Create')" />
    <div class="flex flex-col gap-2 panel">
        <form action="{{route('registrar.enrollments.store')}}" method="post" class="flex flex-col gap-2 w-full capitalize">
            @csrf
            <h1 class="form-title">
                Enrollment Create Form
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
                <label for="" class="input-generic-label">Academic Year</label>
                <select name="academic_year_id" class="text-xs input-generic">
                    @foreach ($academic_years as $academic_year)
                        <option value="{{ $academic_year->id }}">{{ $academic_year->name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('academic_year_id'))
                    <p class="text-xs text-error">
                        {{ $errors->first('academic_year_id') }}
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

            <div class="flex flex-col gap-2">
                <label for="" class="input-generic-label">Description</label>
                <textarea name="description" class="h-32 textarea textarea-primary" rows="3"></textarea>
                @if ($errors->has('description'))
                    <p class="text-xs text-error">
                        {{ $errors->first('description') }}
                    </p>
                @endif
            </div>

            <button class="btn btn-sm btn-accent">
                Submit
            </button>
        </form>
    </div>
</x-dashboard.admin.base>
