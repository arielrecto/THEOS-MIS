{{-- Clickable status pill; toggleDepartmentStatus() updates every copy via data-status-toggle. --}}
<button type="button" onclick="toggleDepartmentStatus({{ $department->id }})"
    data-status-toggle="{{ $department->id }}" title="Click to toggle status"
    @class([
        'inline-flex gap-1.5 items-center px-2.5 py-1 text-xs font-medium whitespace-nowrap rounded-full transition shrink-0 hover:opacity-80',
        'bg-emerald-100 text-emerald-700' => $department->is_active,
        'bg-red-100 text-red-700' => !$department->is_active,
    ])>
    <span class="w-1.5 h-1.5 bg-current rounded-full"></span>
    <span data-status-label>{{ $department->is_active ? 'Active' : 'Inactive' }}</span>
</button>
