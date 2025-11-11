<x-dashboard.admin.base>
    <x-notification-message />
    <x-dashboard.page-title :back_url="route('admin.subjects.index')" :title="_('Edit Subject')" />
    <div class="flex flex-col gap-2 panel">
        <form action="{{route('admin.subjects.update', $subject)}}" method="post" class="flex flex-col gap-2 w-full capitalize">
            @csrf
            @method('PUT')
            <h1 class="form-title">
                Edit Subject Form
            </h1>
            <div class="flex flex-col gap-2">
                <label for="" class="input-generic-label">name</label>
                <input type="text"
                       name="name"
                       class="input-generic"
                       value="{{ old('name', $subject->name) }}">
                @if ($errors->has('name'))
                    <p class="text-xs text-error">
                        {{ $errors->first('name') }}
                    </p>
                @endif
            </div>
            <div class="flex flex-col gap-2">
                <label for="" class="input-generic-label">Subject Code</label>
                <input type="text"
                       name="subject_code"
                       class="input-generic"
                       value="{{ old('subject_code', $subject->subject_code) }}">
                @if ($errors->has('subject_code'))
                    <p class="text-xs text-error">
                        {{ $errors->first('subject_code') }}
                    </p>
                @endif
            </div>

            <div class="flex flex-col gap-2">
                <label for="" class="input-generic-label">Description</label>
                <textarea class="h-32 textarea textarea-accent"
                          name="description"
                          placeholder="description">{{ old('description', $subject->description) }}</textarea>
                @if ($errors->has('description'))
                    <p class="text-xs text-error">
                        {{ $errors->first('description') }}
                    </p>
                @endif
            </div>

            <div class="flex flex-col gap-2">
                <label class="input-generic-label">Strands</label>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($strands as $strand)


                        <label class="flex gap-2 items-center p-3 rounded-lg border hover:bg-gray-50">
                            <input type="checkbox"
                                   name="strands[]"
                                   value="{{ $strand->id }}"
                                   class="checkbox checkbox-accent"
                                   {{ in_array($strand->id, old('strands', $subject->gradeLevels->pluck('id')->toArray())) ? 'checked' : '' }}>
                            <div>
                                <p class="font-medium">{{ $strand->name }}</p>
                                <p class="text-sm text-gray-500">{{ $strand->acronym }}</p>
                            </div>
                        </label>
                    @endforeach
                </div>
                @if ($errors->has('strands'))
                    <p class="text-xs text-error">
                        {{ $errors->first('strands') }}
                    </p>
                @endif
            </div>

            <button class="btn btn-sm btn-accent">
                Update
            </button>
        </form>
    </div>
</x-dashboard.admin.base>
