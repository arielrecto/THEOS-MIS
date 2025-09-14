<x-dashboard.admin.base>
    <x-notification-message />
    <x-dashboard.page-title :back_url="route('admin.strands.index')" :title="_('Grade Level Edit')" />
    <div class="panel flex flex-col gap-2">
        <form action="{{route('admin.strands.update', ['strand' => $strand->id])}}" method="post" class="w-full flex flex-col gap-2 capitalize">
            @csrf
            @method('put')
            <h1 class="form-title">
                Grade Level Edit Form
            </h1>
            <div class="flex flex-col gap-2">
                <label for="" class="input-generic-label">name</label>
                <input type="text" name="name" class="input-generic" placeholder="{{$strand->name}}">
                @if ($errors->has('name'))
                    <p class="text-xs text-error">
                        {{ $errors->first('name') }}
                    </p>
                @endif
            </div>
            <div class="flex flex-col gap-2">
                <label for="" class="input-generic-label">Acronym</label>
                <input type="text" name="acronym" class="input-generic" placeholder="{{$strand->acronym}}">
                @if ($errors->has('acronym'))
                    <p class="text-xs text-error">
                        {{ $errors->first('acronym') }}
                    </p>
                @endif
            </div>

            <div class="flex flex-col gap-2">
                <label for="" class="input-generic-label">Description</label>
                <textarea class="textarea textarea-accent h-32" name="description" placeholder="{{$strand->description}}"></textarea>
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
