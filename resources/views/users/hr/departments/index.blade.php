@php
    $total = (int) $stats->total;
    $active = (int) $stats->active;
    $withHead = (int) $stats->with_head;
    $noHead = $total - $withHead;
    $inactive = $total - $active;
@endphp

<x-dashboard.hr.base>
    <x-notification-message />

    <div class="flex flex-col gap-6">
        <!-- Summary cards -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="flex gap-4 items-center p-4 bg-white rounded-2xl border shadow-md border-slate-100">
                <span class="flex justify-center items-center w-12 h-12 text-xl text-white bg-blue-500 rounded-full shrink-0">
                    <i class="flex fi fi-rr-layers"></i>
                </span>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-slate-800">Total Departments</p>
                    <p class="text-2xl font-bold leading-tight text-slate-900">{{ $total }}</p>
                    <p class="text-xs text-slate-500">Across all units</p>
                </div>
            </div>

            <div class="flex gap-4 items-center p-4 bg-white rounded-2xl border shadow-md border-slate-100">
                <span class="flex justify-center items-center w-12 h-12 text-xl text-white bg-emerald-500 rounded-full shrink-0">
                    <i class="flex fi fi-rr-check"></i>
                </span>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-slate-800">Active</p>
                    <p class="text-2xl font-bold leading-tight text-slate-900" data-active-count>{{ $active }}</p>
                    <p class="text-xs text-slate-500" data-active-note>
                        {{ $inactive === 0 ? 'All active' : $inactive . ' inactive' }}
                    </p>
                </div>
            </div>

            <div class="flex gap-4 items-center p-4 bg-white rounded-2xl border shadow-md border-slate-100">
                <span class="flex justify-center items-center w-12 h-12 text-xl text-white bg-orange-400 rounded-full shrink-0">
                    <i class="flex fi fi-rr-user"></i>
                </span>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-slate-800">With Head Assigned</p>
                    <p class="text-2xl font-bold leading-tight text-slate-900">{{ $withHead }}</p>
                    <p class="text-xs text-slate-500">{{ $withHead }} of {{ $total }} {{ Str::plural('department', $total) }}</p>
                </div>
            </div>

            <div class="flex gap-4 items-center p-4 bg-white rounded-2xl border shadow-md border-slate-100">
                <span class="flex justify-center items-center w-12 h-12 text-xl text-white rounded-full bg-slate-400 shrink-0">
                    <i class="flex fi fi-rr-exclamation"></i>
                </span>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-slate-800">No Head Assigned</p>
                    <p class="text-2xl font-bold leading-tight text-slate-900">{{ $noHead }}</p>
                    <p class="text-xs {{ $noHead > 0 ? 'text-orange-600' : 'text-slate-500' }}">
                        {{ $noHead > 0 ? 'Needs attention' : 'All departments covered' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Departments panel over background -->
        <!-- bg6 shows through everywhere except the table / cards, which sit on white -->
        <div class="overflow-hidden px-4 py-5 bg-center bg-no-repeat bg-cover rounded-2xl border shadow-lg sm:p-6 lg:p-8 border-slate-100"
            style="background-image: url('{{ asset('bg6.JPEG') }}')">
            <div>
                <!-- Header -->
                <div class="flex flex-col gap-4 sm:flex-row sm:justify-between sm:items-start">
                    <div class="min-w-0">
                        <h1 class="text-2xl font-bold text-slate-800 sm:text-3xl">Departments</h1>
                        <p class="mt-1 text-sm text-slate-600">Manage school departments and their details</p>
                    </div>

                    <div class="flex gap-2 items-center">
                        <div class="hidden bg-white rounded-lg border md:flex border-slate-200">
                            <button type="button" class="px-2.5 h-8 rounded-l-lg"
                                :class="$store.deptView === 'list' ? 'bg-slate-100 text-slate-800' : 'text-slate-500'"
                                title="List view" aria-label="List view" @click="$store.deptView = 'list'">
                                <i class="flex fi fi-rr-list"></i>
                            </button>
                            <button type="button" class="px-2.5 h-8 rounded-r-lg border-l border-slate-200"
                                :class="$store.deptView === 'card' ? 'bg-slate-100 text-slate-800' : 'text-slate-500'"
                                title="Card view" aria-label="Card view" @click="$store.deptView = 'card'">
                                <i class="flex fi fi-rr-apps"></i>
                            </button>
                        </div>

                        <a href="{{ route('hr.departments.create') }}"
                            class="flex-1 gap-2 h-9 min-h-0 text-white whitespace-nowrap btn btn-sm btn-accent sm:flex-none">
                            <i class="flex fi fi-rr-plus"></i>
                            Add Department
                        </a>
                    </div>
                </div>

                <!-- Search & filter -->
                <form method="GET" action="{{ route('hr.departments.index') }}"
                    class="flex flex-col gap-3 mt-5 sm:flex-row sm:items-center">
                    <div class="flex flex-1 items-center bg-white rounded-lg border sm:max-w-sm border-slate-200 focus-within:ring-2 focus-within:ring-accent/30">
                        <input type="search" name="search" value="{{ $search }}" placeholder="Search departments..."
                            class="flex-1 px-3 py-2 min-w-0 text-sm bg-transparent border-0 focus:ring-0"
                            aria-label="Search departments">
                        <button type="submit" class="px-3 text-slate-500 hover:text-slate-800" aria-label="Search">
                            <i class="flex fi fi-rr-search"></i>
                        </button>
                    </div>

                    <div class="flex gap-3 justify-between items-center sm:ml-auto">
                        <select name="status" onchange="this.form.submit()"
                            class="h-9 min-h-0 text-sm bg-white select select-bordered select-sm border-slate-200 sm:w-36"
                            aria-label="Filter by status">
                            <option value="" @selected(!$status)>All Status</option>
                            <option value="active" @selected($status === 'active')>Active</option>
                            <option value="inactive" @selected($status === 'inactive')>Inactive</option>
                        </select>
                        <span class="text-sm whitespace-nowrap text-slate-500">
                            Showing <span class="font-semibold text-slate-700">{{ $departments->count() }}</span>
                            of <span class="font-semibold text-slate-700">{{ $departments->total() }}</span>
                        </span>
                    </div>
                </form>

                <!-- Mobile: cards -->
                <div class="flex flex-col gap-3 mt-5 md:hidden">
                    @forelse ($departments as $department)
                        <article class="p-4 bg-white rounded-xl border shadow-sm border-slate-100">
                            <div class="flex gap-3 justify-between items-start">
                                <a href="{{ route('hr.departments.show', $department->id) }}"
                                    class="font-semibold break-words text-slate-800 hover:text-accent">{{ $department->name }}</a>
                                @include('users.hr.departments.partials.status-toggle', ['department' => $department])
                            </div>
                            <div class="flex flex-col gap-1.5 mt-2 text-sm text-slate-600">
                                <span class="flex gap-2 items-center">
                                    <i class="flex fi fi-rr-user text-slate-400"></i>
                                    @if ($department->headUser)
                                        <span class="font-medium capitalize text-slate-700">{{ $department->headUser->name }}</span>
                                    @else
                                        <span class="text-slate-400">No head assigned</span>
                                    @endif
                                </span>
                                <span class="flex gap-2 items-center">
                                    <i class="flex fi fi-rr-users text-slate-400"></i>
                                    {{ $department->employees_count }} {{ Str::plural('member', $department->employees_count) }}
                                </span>
                            </div>
                            <div class="flex gap-2 justify-end pt-3 mt-3 border-t border-slate-100">
                                @include('users.hr.departments.partials.actions', ['department' => $department, 'labels' => true])
                            </div>
                        </article>
                    @empty
                        @include('users.hr.departments.partials.empty')
                    @endforelse
                </div>

                <!-- Desktop: table -->
                <div class="hidden overflow-x-auto mt-5 bg-white rounded-xl border shadow-md md:block border-slate-100"
                    x-show="$store.deptView === 'list'">
                    <table class="table w-full">
                        <thead>
                            <tr class="text-sm border-b border-slate-100 text-slate-600">
                                <th class="pl-5">Name</th>
                                <th>Head</th>
                                <th>Employees</th>
                                <th>Status</th>
                                <th class="pr-5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($departments as $department)
                                <tr class="border-slate-100 hover:bg-slate-50/70">
                                    <td class="pl-5">
                                        <a href="{{ route('hr.departments.show', $department->id) }}"
                                            class="font-medium text-slate-800 hover:text-accent">{{ $department->name }}</a>
                                    </td>
                                    <td>
                                        @if ($department->headUser)
                                            <div class="flex gap-2 items-center">
                                                <span class="flex justify-center items-center w-7 h-7 text-xs font-semibold text-blue-600 uppercase bg-blue-50 rounded-full shrink-0">
                                                    {{ substr($department->headUser->name, 0, 1) }}
                                                </span>
                                                <span class="font-medium capitalize text-slate-700">{{ $department->headUser->name }}</span>
                                            </div>
                                        @else
                                            <span class="text-sm text-slate-400">No head assigned</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-slate-100 text-slate-600">
                                            {{ $department->employees_count }} {{ Str::plural('member', $department->employees_count) }}
                                        </span>
                                    </td>
                                    <td>@include('users.hr.departments.partials.status-toggle', ['department' => $department])</td>
                                    <td class="pr-5">
                                        <div class="flex gap-1 justify-end">
                                            @include('users.hr.departments.partials.actions', ['department' => $department, 'labels' => false])
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">@include('users.hr.departments.partials.empty')</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Desktop: card grid -->
                <div class="hidden grid-cols-2 gap-4 mt-5 md:grid lg:grid-cols-3 xl:grid-cols-4"
                    x-show="$store.deptView === 'card'" x-cloak>
                    @forelse ($departments as $department)
                        <div class="flex flex-col gap-3 p-5 bg-white rounded-xl border shadow-sm transition-shadow border-slate-100 hover:shadow-md">
                            <div class="flex gap-2 justify-between items-start">
                                <a href="{{ route('hr.departments.show', $department->id) }}"
                                    class="font-semibold truncate text-slate-800 hover:text-accent">{{ $department->name }}</a>
                                @include('users.hr.departments.partials.status-toggle', ['department' => $department])
                            </div>
                            <div class="space-y-1.5 text-sm text-slate-600">
                                <div class="flex gap-2 items-center">
                                    <i class="flex fi fi-rr-user text-slate-400"></i>
                                    <span class="truncate capitalize">{{ $department->headUser?->name ?? 'No head assigned' }}</span>
                                </div>
                                <div class="flex gap-2 items-center">
                                    <i class="flex fi fi-rr-users text-slate-400"></i>
                                    {{ $department->employees_count }} {{ Str::plural('member', $department->employees_count) }}
                                </div>
                            </div>
                            <div class="flex gap-2 justify-end pt-3 mt-auto border-t border-slate-100">
                                @include('users.hr.departments.partials.actions', ['department' => $department, 'labels' => true])
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full">@include('users.hr.departments.partials.empty')</div>
                    @endforelse
                </div>

                @if ($departments->hasPages())
                    <div class="mt-5">{{ $departments->links() }}</div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.store('deptView', 'list');
            });

            async function toggleDepartmentStatus(id) {
                try {
                    const response = await fetch(`{{ url('hr/departments') }}/${id}/toggle-status`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                    });
                    const data = await response.json();
                    if (!data.success) throw new Error(data.message);

                    // The same department appears in the mobile, table and card views.
                    document.querySelectorAll(`[data-status-toggle="${id}"]`).forEach((badge) => {
                        badge.classList.toggle('bg-emerald-100', data.is_active);
                        badge.classList.toggle('text-emerald-700', data.is_active);
                        badge.classList.toggle('bg-red-100', !data.is_active);
                        badge.classList.toggle('text-red-700', !data.is_active);
                        badge.querySelector('[data-status-label]').textContent = data.is_active ? 'Active' : 'Inactive';
                    });

                    const count = document.querySelector('[data-active-count]');
                    const active = Number(count.textContent) + (data.is_active ? 1 : -1);
                    const inactive = {{ $total }} - active;
                    count.textContent = active;
                    document.querySelector('[data-active-note]').textContent = inactive === 0 ? 'All active' : `${inactive} inactive`;

                    showDepartmentToast(data.message, 'success');
                } catch (error) {
                    console.error(error);
                    showDepartmentToast('Failed to update department status', 'error');
                }
            }

            function showDepartmentToast(message, type) {
                const toast = document.createElement('div');
                toast.className = 'toast toast-end z-50';
                toast.innerHTML = `<div class="alert alert-${type}"><span></span></div>`;
                toast.querySelector('span').textContent = message;
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 3000);
            }
        </script>
    @endpush
</x-dashboard.hr.base>
