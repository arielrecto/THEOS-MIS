<form action="{{ route('teacher.classrooms.unarchive', $classroom) }}" method="POST"
    onsubmit="return confirm('Restore this classroom to your active classrooms?')">
    @csrf
    @method('PUT')
    <button type="submit" class="gap-1 btn btn-ghost btn-sm text-slate-600" title="Unarchive"
        aria-label="Unarchive {{ $classroom->name }}">
        <i class="flex fi fi-rr-undo"></i>
        @if ($labels) Unarchive @endif
    </button>
</form>

<button type="button" class="gap-1 btn btn-ghost btn-sm text-error" title="Delete permanently"
    aria-label="Delete {{ $classroom->name }}"
    onclick="deleteClassroom(@js(route('teacher.classrooms.destroy', $classroom)), @js($classroom->name))">
    <i class="flex fi fi-rr-trash"></i>
    @if ($labels) Delete @endif
</button>
