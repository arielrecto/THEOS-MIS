<a href="{{ route('hr.departments.edit', $department->id) }}"
    class="gap-1 btn btn-ghost btn-xs text-slate-600" title="Edit" aria-label="Edit {{ $department->name }}">
    <i class="flex fi fi-rr-edit"></i>
    @if ($labels) Edit @endif
</a>
<form action="{{ route('hr.departments.destroy', $department->id) }}" method="post"
    onsubmit="return confirm('Delete {{ addslashes($department->name) }}?')">
    @csrf
    @method('delete')
    <button class="gap-1 btn btn-ghost btn-xs text-error" title="Delete" aria-label="Delete {{ $department->name }}">
        <i class="flex fi fi-rr-trash"></i>
        @if ($labels) Delete @endif
    </button>
</form>
