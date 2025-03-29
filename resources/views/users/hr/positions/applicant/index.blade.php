<x-dashboard.hr.base>
    <div class="w-full p-6">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
                <a href="{{ route('hr.dashboard') }}" class="hover:text-accent">Dashboard</a>
                <i class="fi fi-rr-angle-right"></i>
                <span>Job Applications</span>
            </div>

            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Job Applications</h1>
                    <p class="text-gray-600 mt-1">Track and manage candidate applications</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="join">
                        <button class="btn join-item btn-sm gap-2 btn-active">
                            <i class="fi fi-rr-layout-kanban"></i>
                            Kanban
                        </button>
                        <button class="btn join-item btn-sm gap-2">
                            <i class="fi fi-rr-list"></i>
                            List
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm mb-6">
            <div class="p-4 border-b">
                <form class="flex flex-wrap items-center gap-4">
                    <div class="form-control flex-1">
                        <div class="input-group">
                            <span class="btn btn-square btn-ghost">
                                <i class="fi fi-rr-search"></i>
                            </span>
                            <input type="text"
                                   name="search"
                                   class="input input-bordered w-full"
                                   placeholder="Search applicants..."
                                   value="{{ request('search') }}">
                        </div>
                    </div>
                    <select name="position" class="select select-bordered">
                        <option value="">All Positions</option>
                        @foreach($positions as $position)
                            <option value="{{ $position->id }}"
                                    {{ request('position') == $position->id ? 'selected' : '' }}>
                                {{ $position->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-sm">Apply Filters</button>
                </form>
            </div>
        </div>

        <!-- Applicant Details Modal -->


        <!-- Kanban Board -->
        <div x-data="applicantKanban">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Initial Application -->
                <div class="flex flex-col h-full">
                    <div class="bg-base-200 px-4 py-3 rounded-t-lg flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="font-medium">New</span>
                            <div class="badge badge-neutral">{{ $applicants->where('status', 'new')->count() }}</div>
                        </div>
                    </div>
                    <div class="bg-base-200/50 flex-1 p-4 rounded-b-lg space-y-4">
                        @foreach($applicants->where('status', 'new') as $applicant)
                            <div class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h3 class="font-medium">{{ $applicant->name }}</h3>
                                    </div>
                                    <div class="dropdown dropdown-end">
                                        <button class="btn btn-ghost btn-xs">
                                            <i class="fi fi-rr-menu-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                            <li><a href="#">View Details</a></li>
                                            <li><a href="#" @click.prevent="moveApplicant({{ $applicant->id }}, 'screening')">
                                                Move to Screening
                                            </a></li>
                                            <li><a href="#" class="text-error" @click.prevent="rejectApplicant({{ $applicant->id }})">
                                                Reject
                                            </a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="mt-3 flex items-center gap-4 text-sm text-gray-600">
                                    <div class="flex items-center gap-1">
                                        <i class="fi fi-rr-clock"></i>
                                        <span>{{ $applicant->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Screening -->
                <div class="flex flex-col h-full">
                    <div class="bg-info/10 px-4 py-3 rounded-t-lg flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="font-medium">Screening</span>
                            <div class="badge badge-info">{{ $applicants->where('status', 'screening')->count() }}</div>
                        </div>
                    </div>
                    <div class="bg-info/5 flex-1 p-4 rounded-b-lg space-y-4">
                        @foreach($applicants->where('status', 'screening') as $applicant)
                            <div class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h3 class="font-medium">{{ $applicant->name }}</h3>

                                    </div>
                                    <div class="dropdown dropdown-end">
                                        <button class="btn btn-ghost btn-xs">
                                            <i class="fi fi-rr-menu-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                            <li><a href="{{ route('hr.applicants.show', $applicant) }}">View Details</a></li>
                                            <li><a href="#" @click.prevent="moveApplicant({{ $applicant->id }}, 'interview')">
                                                Move to Interview
                                            </a></li>
                                            <li><a href="#" class="text-error" @click.prevent="rejectApplicant({{ $applicant->id }})">
                                                Reject
                                            </a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="mt-3 flex flex-wrap items-center gap-4 text-sm text-gray-600">
                                    <div class="flex items-center gap-1">
                                        <i class="fi fi-rr-clock"></i>
                                        <span>{{ $applicant->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <i class="fi fi-rr-envelope"></i>
                                        <span>{{ $applicant->email }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Interview -->
                <div class="flex flex-col h-full">
                    <div class="bg-warning/10 px-4 py-3 rounded-t-lg flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="font-medium">Interview</span>
                            <div class="badge badge-warning">{{ $applicants->where('status', 'interview')->count() }}</div>
                        </div>
                    </div>
                    <div class="bg-warning/5 flex-1 p-4 rounded-b-lg space-y-4">
                        @foreach($applicants->where('status', 'interview') as $applicant)
                            <div class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h3 class="font-medium">{{ $applicant->name }}</h3>

                                    </div>
                                    <div class="dropdown dropdown-end">
                                        <button class="btn btn-ghost btn-xs">
                                            <i class="fi fi-rr-menu-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                            <li><a href="{{ route('hr.applicants.show', $applicant) }}">View Details</a></li>
                                            <li><a href="#" @click.prevent="moveApplicant({{ $applicant->id }}, 'hired')">
                                                Move to Hired
                                            </a></li>
                                            <li><a href="#" class="text-error" @click.prevent="rejectApplicant({{ $applicant->id }})">
                                                Reject
                                            </a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="mt-3 flex flex-wrap items-center gap-4 text-sm text-gray-600">
                                    <div class="flex items-center gap-1">
                                        <i class="fi fi-rr-clock"></i>
                                        <span>{{ $applicant->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <i class="fi fi-rr-phone-call"></i>
                                        <span>{{ $applicant->phone }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Hired -->
                <div class="flex flex-col h-full">
                    <div class="bg-success/10 px-4 py-3 rounded-t-lg flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="font-medium">Hired</span>
                            <div class="badge badge-success">{{ $applicants->where('status', 'hired')->count() }}</div>
                        </div>
                    </div>
                    <div class="bg-success/5 flex-1 p-4 rounded-b-lg space-y-4">
                        @foreach($applicants->where('status', 'hired') as $applicant)
                            <div class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h3 class="font-medium">{{ $applicant->name }}</h3>

                                    </div>
                                    <div class="dropdown dropdown-end">
                                        <button class="btn btn-ghost btn-xs">
                                            <i class="fi fi-rr-menu-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                            <li><a href="{{ route('hr.applicants.show', $applicant) }}">View Details</a></li>
                                            <li><a href="{{ route('hr.employees.create', ['applicant' => $applicant->id]) }}">
                                                Create Employee
                                            </a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="mt-3 flex flex-wrap items-center gap-4 text-sm text-gray-600">
                                    <div class="flex items-center gap-1">
                                        <i class="fi fi-rr-clock"></i>
                                        <span>{{ $applicant->updated_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <i class="fi fi-rr-briefcase"></i>
                                        <span>Ready to onboard</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-dashboard.hr.base>
