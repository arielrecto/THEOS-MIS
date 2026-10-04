<div class="flex flex-col items-center px-4 py-10 text-center text-slate-500">
    <i class="mb-2 text-3xl fi fi-rr-building"></i>
    <p class="text-sm">No departments found</p>
    @if (request('search') || request('status'))
        <a href="{{ route('hr.departments.index') }}" class="mt-2 text-sm link link-accent">Clear filters</a>
    @endif
</div>
