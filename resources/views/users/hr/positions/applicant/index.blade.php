<x-dashboard.hr.base>
    <div class="w-full p-4 sm:p-6 lg:p-8">
        <!-- Header -->
        <div class="mb-8">
            <!-- Breadcrumb -->
            <div class="flex items-center gap-2 text-xs sm:text-sm text-gray-500 mb-3 flex-wrap">
                <a href="{{ route('hr.dashboard') }}" class="hover:text-accent transition-colors truncate">Dashboard</a>
                <i class="fi fi-rr-angle-right flex-shrink-0 text-gray-400"></i>
                <span class="text-gray-700 font-medium truncate">Job Applications</span>
            </div>

            <!-- Title Section -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <div class="min-w-0">
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 truncate">Job Applications</h1>
                    <p class="text-sm sm:text-base text-gray-600 mt-2">Manage and track candidate applications through
                        the hiring pipeline</p>
                </div>

                <!-- View Toggle -->
                {{-- <div class="flex items-center gap-2">
                    <div class="join border border-gray-200 rounded-lg">
                        <button class="btn join-item btn-sm gap-2 btn-active text-xs sm:text-sm px-3 sm:px-4">
                            <i class="fi fi-rr-layout-kanban text-base"></i>
                            <span class="hidden sm:inline font-medium">Kanban</span>
                        </button>
                        <div class="divider divider-horizontal m-0"></div>
                        <button class="btn join-item btn-sm gap-2 text-xs sm:text-sm px-3 sm:px-4">
                            <i class="fi fi-rr-list text-base"></i>
                            <span class="hidden sm:inline font-medium">List</span>
                        </button>
                    </div>
                </div> --}}
            </div>
        </div>

        <!-- Filters Section -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm mb-8">
            <div class="p-4 sm:p-6 border-b border-gray-100">
                <form class="flex flex-col md:flex-row md:items-end gap-4">
                    <!-- Search Input -->
                    <div class="form-control flex-1 min-w-0">
                        <label class="label pb-2">
                            <span class="label-text text-sm font-semibold text-gray-700">Search Applicants</span>
                        </label>
                        <div class="input-group">
                            <span class="btn btn-square btn-ghost btn-sm bg-gray-50">
                                <i class="fi fi-rr-search text-gray-600"></i>
                            </span>
                            <input type="text" name="search"
                                class="input input-bordered input-sm w-full text-sm focus:outline-none focus:ring-2 focus:ring-accent/20"
                                placeholder="Search by name, email..." value="{{ request('search') }}">
                        </div>
                    </div>

                    <!-- Position Filter -->
                    <div class="form-control w-full md:w-56">
                        <label class="label pb-2">
                            <span class="label-text text-sm font-semibold text-gray-700">Position</span>
                        </label>
                        <select name="position"
                            class="select select-bordered select-sm w-full text-sm focus:outline-none focus:ring-2 focus:ring-accent/20">
                            <option value="">All Positions</option>
                            @foreach ($positions as $position)
                                <option value="{{ $position->id }}"
                                    {{ request('position') == $position->id ? 'selected' : '' }}>
                                    {{ $position->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Apply Button -->
                    <button type="submit" class="btn btn-accent btn-sm text-sm font-medium px-6">
                        <i class="fi fi-rr-search"></i>
                        Apply Filters
                    </button>
                </form>
            </div>
        </div>

        <!-- Kanban Board -->
        <div x-data="applicantKanban">
            <!-- Mobile: Stacked Columns (professional, vertical flow) -->
            <div class="md:hidden space-y-6">
                @php
                    $columns = [
                        'new' => 'New Applications',
                        'screening' => 'Screening',
                        'interview' => 'Interview',
                        'hired' => 'Hired',
                    ];
                @endphp

                @foreach ($columns as $key => $label)
                    <section class="bg-white border border-gray-200 rounded-lg shadow-sm">
                        <header class="px-4 py-3 flex items-center justify-between">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-2.5 h-2.5 rounded-full bg-gray-400/80"></div>
                                <h3 class="text-sm font-semibold text-gray-900 truncate">{{ $label }}</h3>
                            </div>
                            <span
                                class="text-xs text-gray-600 px-2 py-0.5 bg-gray-100 rounded">{{ $applicants->where('status', $key)->count() }}</span>
                        </header>

                        <div class="p-3 space-y-3">
                            @forelse($applicants->where('status', $key) as $applicant)
                                <article class="flex items-start gap-3 bg-gray-50 p-3 rounded-lg">
                                    <div class="min-w-0 flex-1">
                                        <h4 class="text-sm font-medium text-gray-900 break-words">{{ $applicant->name }}
                                        </h4>
                                        <div class="mt-1 text-xs text-gray-500 space-y-1">
                                            @if ($key === 'new')
                                                <div class="flex items-center gap-2"><i
                                                        class="fi fi-rr-calendar"></i><span class="break-words">Applied
                                                        {{ $applicant->created_at->format('M d, Y') }}</span></div>
                                                <div class="flex items-center gap-2"><i
                                                        class="fi fi-rr-briefcase"></i><span
                                                        class="break-words">{{ $applicant->position->name ?? 'Position TBD' }}</span>
                                                </div>
                                            @elseif($key === 'screening')
                                                <div class="flex items-center gap-2"><i
                                                        class="fi fi-rr-envelope"></i><span
                                                        class="break-words">{{ $applicant->email }}</span></div>
                                            @elseif($key === 'interview')
                                                <div class="flex items-center gap-2"><i
                                                        class="fi fi-rr-phone-call"></i><span
                                                        class="break-words">{{ $applicant->phone ?? 'N/A' }}</span>
                                                </div>
                                            @else
                                                <div
                                                    class="inline-block px-2 py-1 bg-success/10 text-success text-xs font-semibold rounded">
                                                    Ready to Onboard</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex-shrink-0">
                                        <div class="dropdown dropdown-end">
                                            <button class="btn btn-ghost btn-xs" tabindex="0"
                                                aria-label="More actions">
                                                <i class="fi fi-rr-menu-dots-vertical text-lg"></i>
                                            </button>
                                            <ul
                                                class="dropdown-content z-[1] menu p-2 shadow-lg bg-white rounded-lg border border-gray-200 w-44 text-xs">
                                                <li><a href="{{ route('hr.applicants.show', $applicant) }}"
                                                        class="hover:bg-accent/10">View Full Profile</a></li>
                                                @if ($key === 'new')
                                                    <li><a href="#"
                                                            :class="isLoadingAction({{ $applicant->id }}, 'screening') ?
                                                                'opacity-50 cursor-not-allowed' : ''"
                                                            @click.prevent="moveApplicant({{ $applicant->id }}, 'screening')">Move
                                                            to Screening</a></li>
                                                @elseif($key === 'screening')
                                                    <li><a href="#"
                                                            :class="isLoadingAction({{ $applicant->id }}, 'interview') ?
                                                                'opacity-50 cursor-not-allowed' : ''"
                                                            @click.prevent="moveApplicant({{ $applicant->id }}, 'interview')">Move
                                                            to Interview</a></li>
                                                @elseif($key === 'interview')
                                                    <li><a href="#"
                                                            :class="isLoadingAction({{ $applicant->id }}, 'hired') ?
                                                                'opacity-50 cursor-not-allowed' : ''"
                                                            @click.prevent="moveApplicant({{ $applicant->id }}, 'hired')">Move
                                                            to Hired</a></li>
                                                @endif
                                                <li><a href="#" class="text-error hover:bg-error/10"
                                                        :class="isLoadingAction({{ $applicant->id }}, 'rejected') ?
                                                            'opacity-50 cursor-not-allowed' : ''"
                                                        @click.prevent="rejectApplicant({{ $applicant->id }})">Reject</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </article>
                            @empty
                                <div class="py-6 text-center text-sm text-gray-500">
                                    <i class="fi fi-rr-inbox text-2xl mb-2 block"></i>
                                    <div>No {{ strtolower($label) }}</div>
                                </div>
                            @endforelse
                        </div>
                    </section>
                @endforeach
            </div>

            <!-- Desktop: Kanban Grid -->
            <div class="hidden md:grid md:grid-cols-4 gap-6">
                <!-- Column: New -->
                <div class="flex flex-col h-full">
                    <div
                        class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200 px-6 py-4 rounded-t-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 rounded-full bg-gray-400"></div>
                                <h3 class="font-bold text-gray-900">New Applications</h3>
                            </div>
                            <span class="px-3 py-1 bg-gray-200 text-gray-800 rounded-full text-xs font-semibold">
                                {{ $applicants->where('status', 'new')->count() }}
                            </span>
                        </div>
                    </div>
                    <div class="bg-gray-50/50 flex-1 p-5 rounded-b-lg space-y-4 overflow-y-auto max-h-[600px]">
                        @forelse($applicants->where('status', 'new') as $applicant)
                            <div
                                class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md hover:border-gray-300 transition-all p-4">
                                <div class="flex items-start justify-between gap-3 mb-3">
                                    <h4 class="font-semibold text-sm text-gray-900 truncate flex-1">
                                        {{ $applicant->name }}</h4>
                                    <div class="dropdown dropdown-end flex-shrink-0">
                                        <button class="btn btn-ghost btn-xs btn-circle" tabindex="0">
                                            <i class="fi fi-rr-menu-dots-vertical"></i>
                                        </button>
                                        <ul
                                            class="dropdown-content z-[1] menu p-2 shadow-lg bg-white rounded-lg border border-gray-200 w-56 text-sm">
                                            <li><a href="{{ route('hr.applicants.show', $applicant) }}"
                                                    class="hover:bg-accent/10">View Full Profile</a></li>
                                            <li><a href="#"
                                                    :class="isLoadingAction({{ $applicant->id }}, 'screening') ?
                                                        'opacity-50 cursor-not-allowed' : 'hover:bg-accent/10'"
                                                    @click.prevent="moveApplicant({{ $applicant->id }}, 'screening'))">Move
                                                    to Screening</a></li>
                                            <li><a href="#" class="text-error hover:bg-error/10"
                                                    :class="isLoadingAction({{ $applicant->id }}, 'rejected') ?
                                                        'opacity-50 cursor-not-allowed' : ''"
                                                    @click.prevent="rejectApplicant({{ $applicant->id }})">Reject</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="space-y-2 text-xs text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <i class="fi fi-rr-calendar flex-shrink-0 text-gray-400"></i>
                                        <span>{{ $applicant->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="flex flex-col items-center justify-center py-12">
                                <i class="fi fi-rr-inbox text-4xl text-gray-200 mb-3"></i>
                                <p class="text-xs text-gray-500 text-center">No new applications</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Column: Screening -->
                <div class="flex flex-col h-full">
                    <div
                        class="bg-gradient-to-r from-info/5 to-info/10 border-b border-info/20 px-6 py-4 rounded-t-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 rounded-full bg-info"></div>
                                <h3 class="font-bold text-gray-900">Screening</h3>
                            </div>
                            <span class="px-3 py-1 bg-info/20 text-info rounded-full text-xs font-semibold">
                                {{ $applicants->where('status', 'screening')->count() }}
                            </span>
                        </div>
                    </div>
                    <div class="bg-info/5 flex-1 p-5 rounded-b-lg space-y-4 overflow-y-auto max-h-[600px]">
                        @forelse($applicants->where('status', 'screening') as $applicant)
                            <div
                                class="bg-white border border-info/30 rounded-lg shadow-sm hover:shadow-md hover:border-info/50 transition-all p-4">
                                <div class="flex items-start justify-between gap-3 mb-3">
                                    <h4 class="font-semibold text-sm text-gray-900 truncate flex-1">
                                        {{ $applicant->name }}</h4>
                                    <div class="dropdown dropdown-end flex-shrink-0">
                                        <button class="btn btn-ghost btn-xs btn-circle" tabindex="0">
                                            <i class="fi fi-rr-menu-dots-vertical"></i>
                                        </button>
                                        <ul
                                            class="dropdown-content z-[1] menu p-2 shadow-lg bg-white rounded-lg border border-gray-200 w-56 text-sm">
                                            <li><a href="{{ route('hr.applicants.show', $applicant) }}"
                                                    class="hover:bg-accent/10">View Full Profile</a></li>
                                            <li><a href="#"
                                                    :class="isLoadingAction({{ $applicant->id }}, 'interview') ?
                                                        'opacity-50 cursor-not-allowed' : 'hover:bg-accent/10'"
                                                    @click.prevent="moveApplicant({{ $applicant->id }}, 'interview'))">Move
                                                    to Interview</a></li>
                                            <li><a href="#" class="text-error hover:bg-error/10"
                                                    :class="isLoadingAction({{ $applicant->id }}, 'rejected') ?
                                                        'opacity-50 cursor-not-allowed' : ''"
                                                    @click.prevent="rejectApplicant({{ $applicant->id }})">Reject</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="space-y-2 text-xs text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <i class="fi fi-rr-calendar flex-shrink-0 text-gray-400"></i>
                                        <span>{{ $applicant->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i class="fi fi-rr-envelope flex-shrink-0 text-gray-400"></i>
                                        <span class="truncate">{{ $applicant->email }}</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="flex flex-col items-center justify-center py-12">
                                <i class="fi fi-rr-inbox text-4xl text-gray-200 mb-3"></i>
                                <p class="text-xs text-gray-500 text-center">No applicants in screening</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Column: Interview -->
                <div class="flex flex-col h-full">
                    <div
                        class="bg-gradient-to-r from-warning/5 to-warning/10 border-b border-warning/20 px-6 py-4 rounded-t-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 rounded-full bg-warning"></div>
                                <h3 class="font-bold text-gray-900">Interview</h3>
                            </div>
                            <span class="px-3 py-1 bg-warning/20 text-warning rounded-full text-xs font-semibold">
                                {{ $applicants->where('status', 'interview')->count() }}
                            </span>
                        </div>
                    </div>
                    <div class="bg-warning/5 flex-1 p-5 rounded-b-lg space-y-4 overflow-y-auto max-h-[600px]">
                        @forelse($applicants->where('status', 'interview') as $applicant)
                            <div
                                class="bg-white border border-warning/30 rounded-lg shadow-sm hover:shadow-md hover:border-warning/50 transition-all p-4">
                                <div class="flex items-start justify-between gap-3 mb-3">
                                    <h4 class="font-semibold text-sm text-gray-900 truncate flex-1">
                                        {{ $applicant->name }}</h4>
                                    <div class="dropdown dropdown-end flex-shrink-0">
                                        <button class="btn btn-ghost btn-xs btn-circle" tabindex="0">
                                            <i class="fi fi-rr-menu-dots-vertical"></i>
                                        </button>
                                        <ul
                                            class="dropdown-content z-[1] menu p-2 shadow-lg bg-white rounded-lg border border-gray-200 w-56 text-sm">
                                            <li><a href="{{ route('hr.applicants.show', $applicant) }}"
                                                    class="hover:bg-accent/10">View Full Profile</a></li>
                                            <li><a href="#"
                                                    :class="isLoadingAction({{ $applicant->id }}, 'hired') ?
                                                        'opacity-50 cursor-not-allowed' : 'hover:bg-accent/10'"
                                                    @click.prevent="moveApplicant({{ $applicant->id }}, 'hired')"
                                                    class="rounded">
                                                    <div class="flex items-center gap-2">
                                                        <i class="fi fi-rr-arrow-right"></i>
                                                        <span>Move to Hired</span>
                                                        <template
                                                            x-if="isLoadingAction({{ $applicant->id }}, 'hired')">
                                                            <span class="loading loading-spinner loading-xs"></span>
                                                        </template>
                                                    </div>
                                                </a>
                                            </li>
                                            <li><a href="#" class="text-error hover:bg-error/10 rounded"
                                                    :class="isLoadingAction({{ $applicant->id }}, 'rejected') ?
                                                        'opacity-50 cursor-not-allowed' : ''"
                                                    @click.prevent="rejectApplicant({{ $applicant->id }})">
                                                    <div class="flex items-center gap-2">
                                                        <i class="fi fi-rr-cross"></i>
                                                        <span>Reject Application</span>
                                                        <template
                                                            x-if="isLoadingAction({{ $applicant->id }}, 'rejected')">
                                                            <span class="loading loading-spinner loading-xs"></span>
                                                        </template>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="space-y-2 text-xs text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <i class="fi fi-rr-calendar flex-shrink-0 text-gray-400"></i>
                                        <span>{{ $applicant->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i class="fi fi-rr-phone-call flex-shrink-0 text-gray-400"></i>
                                        <span class="truncate">{{ $applicant->phone ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="flex flex-col items-center justify-center py-12">
                                <i class="fi fi-rr-inbox text-4xl text-gray-200 mb-3"></i>
                                <p class="text-xs text-gray-500 text-center">No applicants in interview</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Column: Hired -->
                <div class="flex flex-col h-full">
                    <div
                        class="bg-gradient-to-r from-success/5 to-success/10 border-b border-success/20 px-6 py-4 rounded-t-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 rounded-full bg-success"></div>
                                <h3 class="font-bold text-gray-900">Hired</h3>
                            </div>
                            <span class="px-3 py-1 bg-success/20 text-success rounded-full text-xs font-semibold">
                                {{ $applicants->where('status', 'hired')->count() }}
                            </span>
                        </div>
                    </div>
                    <div class="bg-success/5 flex-1 p-5 rounded-b-lg space-y-4 overflow-y-auto max-h-[600px]">
                        @forelse($applicants->where('status', 'hired') as $applicant)
                            <div
                                class="bg-white border border-success/30 rounded-lg shadow-sm hover:shadow-md hover:border-success/50 transition-all p-4">
                                <div class="flex items-start justify-between gap-3 mb-3">
                                    <h4 class="font-semibold text-sm text-gray-900 truncate flex-1">
                                        {{ $applicant->name }}</h4>
                                    <div class="dropdown dropdown-end flex-shrink-0">
                                        <button class="btn btn-ghost btn-xs btn-circle" tabindex="0">
                                            <i class="fi fi-rr-menu-dots-vertical"></i>
                                        </button>
                                        <ul
                                            class="dropdown-content z-[1] menu p-2 shadow-lg bg-white rounded-lg border border-gray-200 w-56 text-sm">
                                            <li><a href="{{ route('hr.applicants.show', $applicant) }}"
                                                    class="hover:bg-accent/10">View Full Profile</a></li>
                                            <li><a href="{{ route('hr.employees.create', ['applicant' => $applicant->id]) }}"
                                                    class="hover:bg-accent/10">
                                                    <div class="flex items-center gap-2">
                                                        <i class="fi fi-rr-user-add"></i>
                                                        <span>Create Employee Record</span>
                                                    </div>
                                                </a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <div
                                        class="inline-block px-3 py-1.5 bg-success/15 text-success rounded-lg text-xs font-semibold">
                                        ✓ Ready to Onboard
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="flex flex-col items-center justify-center py-12">
                                <i class="fi fi-rr-inbox text-4xl text-gray-200 mb-3"></i>
                                <p class="text-xs text-gray-500 text-center">No hired applicants yet</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-dashboard.hr.base>
