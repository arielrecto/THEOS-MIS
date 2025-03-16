<x-dashboard.admin.base>
    <x-notification-message />
    <x-dashboard.page-title :back_url="route('admin.subjects.index')" :title="_('Subject Create')" />
    <div class="panel flex flex-col gap-2">
        <form action="{{route('admin.subjects.store')}}" method="post" class="w-full flex flex-col gap-2 capitalize">
            @csrf
            <h1 class="form-title">
                Subject Create Form
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
                <label for="" class="input-generic-label">Subject Code</label>
                <input type="text" name="subject_code" class="input-generic">
                @if ($errors->has('subject_code'))
                    <p class="text-xs text-error">
                        {{ $errors->first('subject_code') }}
                    </p>
                @endif
            </div>

            <div class="flex flex-col gap-2">
                <label for="" class="input-generic-label">Description</label>
                <textarea class="textarea textarea-accent h-32" name="description" placeholder="description"></textarea>
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
