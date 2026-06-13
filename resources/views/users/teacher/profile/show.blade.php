<x-dashboard.teacher.base>
    <x-dashboard.page-title :back_url="route('teacher.dashboard')" :title="$teacher->name">
        <x-slot name="other">
            @if($teacher->profile)
                <a href="{{ route('teacher.profile.edit', $teacher->profile->id) }}"
                   class="btn btn-accent btn-sm gap-2 text-white">
                    <i class="fi fi-rr-edit"></i>
                    <span class="hidden sm:inline">Edit Profile</span>
                </a>
            @endif
        </x-slot>
    </x-dashboard.page-title>

    <x-notification-message />

    <div class="space-y-6">

        {{-- Profile Header --}}
        <div class="bg-base-100 rounded-lg shadow-lg p-6">
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">

                {{-- Avatar --}}
                <div class="shrink-0">
                    <div class="avatar">
                        <div class="w-24 h-24 rounded-full ring-2 ring-accent ring-offset-2 overflow-hidden">
                            @if($teacher->profile?->image)
                                <img src="{{ $teacher->profile->image }}" alt="{{ $teacher->name }}" class="object-cover w-full h-full">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($teacher->name) }}&size=256&background=random"
                                     alt="{{ $teacher->name }}" class="object-cover w-full h-full">
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Identity --}}
                <div class="flex-1 text-center sm:text-left">
                    <h2 class="text-xl font-bold text-gray-800">{{ $teacher->name }}</h2>
                    <p class="text-sm text-gray-500 mt-1">{{ $teacher->email }}</p>
                    <p class="text-xs text-gray-400 mt-1">
                        Joined {{ \Carbon\Carbon::parse($teacher->created_at)->format('F d, Y') }}
                    </p>
                    @php $grades = $classrooms->pluck('strand.name')->unique()->filter()->values(); @endphp
                    @if($grades->count())
                        <div class="mt-3 flex flex-wrap justify-center sm:justify-start gap-2">
                            @foreach($grades as $grade)
                                <span class="badge badge-accent">{{ $grade }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Quick Stats --}}
                <div class="grid grid-cols-2 gap-3 w-full sm:w-auto mt-2 sm:mt-0">
                    <div class="bg-accent/10 rounded-lg p-3 text-center">
                        <p class="text-2xl font-bold text-accent">{{ $classrooms->count() }}</p>
                        <p class="text-xs text-gray-500 mt-1">Classrooms</p>
                    </div>
                    <div class="bg-primary/10 rounded-lg p-3 text-center">
                        <p class="text-2xl font-bold text-accent">{{ $grades->count() }}</p>
                        <p class="text-xs text-gray-500 mt-1">Grade Levels</p>
                    </div>
                </div>

            </div>
        </div>

        {{-- Personal Information --}}
        @if($teacher->profile)
            <div class="bg-base-100 rounded-lg shadow-lg p-6">
                <div class="flex items-center gap-2 mb-4">
                    <i class="fi fi-rr-user text-accent"></i>
                    <h3 class="font-bold text-accent">Personal Information</h3>
                </div>
                <dl class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                    <div>
                        <dt class="text-xs text-gray-500 uppercase tracking-wide">Last Name</dt>
                        <dd class="font-medium text-gray-800 mt-0.5">{{ $teacher->profile->last_name ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500 uppercase tracking-wide">First Name</dt>
                        <dd class="font-medium text-gray-800 mt-0.5">{{ $teacher->profile->first_name ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500 uppercase tracking-wide">Middle Name</dt>
                        <dd class="font-medium text-gray-800 mt-0.5">{{ $teacher->profile->middle_name ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500 uppercase tracking-wide">Sex</dt>
                        <dd class="font-medium text-gray-800 mt-0.5 capitalize">{{ $teacher->profile->sex ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500 uppercase tracking-wide">Contact #</dt>
                        <dd class="font-medium text-gray-800 mt-0.5">{{ $teacher->profile->contact_no ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500 uppercase tracking-wide">Address</dt>
                        <dd class="font-medium text-gray-800 mt-0.5">{{ $teacher->profile->address ?? '—' }}</dd>
                    </div>
                </dl>
            </div>
        @else
            <div class="bg-base-100 rounded-lg shadow-lg p-8 text-center text-gray-400">
                <i class="fi fi-rr-user block text-3xl mb-2"></i>
                <p class="text-sm mb-3">No profile information yet.</p>
                <a href="{{ route('teacher.profile.create') }}" class="btn btn-accent btn-sm gap-2 text-white">
                    <i class="fi fi-rr-plus"></i> Set Up Profile
                </a>
            </div>
        @endif

        {{-- Assigned Classrooms --}}
        <div class="bg-base-100 rounded-lg shadow-lg p-6">
            <div class="flex items-center gap-2 mb-5">
                <i class="fi fi-rr-chalkboard-user text-accent"></i>
                <h3 class="font-bold text-accent">Assigned Classrooms</h3>
                <span class="badge badge-ghost badge-sm ml-auto">{{ $classrooms->count() }}</span>
            </div>

            @if($classrooms->count())
                {{-- Desktop Table --}}
                <div class="hidden sm:block overflow-x-auto rounded-lg border border-base-200">
                    <table class="table table-zebra w-full text-sm">
                        <thead>
                            <tr class="bg-base-200 text-gray-600 uppercase text-xs tracking-wide">
                                <th>Classroom</th>
                                <th>Subject</th>
                                <th>Grade Level</th>
                                <th>School Year</th>
                                <th class="text-right">Students</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($classrooms as $classroom)
                                <tr class="hover">
                                    <td>
                                        <p class="font-semibold text-gray-800">{{ $classroom->name }}</p>
                                        <p class="text-xs text-gray-400">{{ $classroom->class_code ?? '' }}</p>
                                    </td>
                                    <td>{{ $classroom->subject?->name ?? '—' }}</td>
                                    <td>
                                        @if($classroom->strand)
                                            <span class="badge badge-accent badge-sm">{{ $classroom->strand->name }}</span>
                                        @else
                                            <span class="text-gray-400">—</span>
                                        @endif
                                    </td>
                                    <td class="text-xs text-gray-500">{{ $classroom->academicYear?->name ?? '—' }}</td>
                                    <td class="text-right">
                                        <span class="badge badge-ghost badge-sm">{{ $classroom->classroom_students_count }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Mobile Cards --}}
                <div class="block sm:hidden space-y-3">
                    @foreach($classrooms as $classroom)
                        <div class="rounded-lg border border-base-200 p-4 space-y-2">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-semibold text-gray-800 text-sm">{{ $classroom->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $classroom->class_code ?? '' }}</p>
                                </div>
                                @if($classroom->strand)
                                    <span class="badge badge-accent badge-sm">{{ $classroom->strand->name }}</span>
                                @endif
                            </div>
                            <div class="grid grid-cols-2 gap-2 text-xs text-gray-600">
                                <div>
                                    <span class="text-gray-400">Subject</span>
                                    <p class="font-medium">{{ $classroom->subject?->name ?? '—' }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-400">Students</span>
                                    <p class="font-medium">{{ $classroom->classroom_students_count }}</p>
                                </div>
                                <div class="col-span-2">
                                    <span class="text-gray-400">School Year</span>
                                    <p class="font-medium">{{ $classroom->academicYear?->name ?? '—' }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 text-gray-400">
                    <i class="fi fi-rr-chalkboard block text-3xl mb-2"></i>
                    <p class="text-sm">No classrooms assigned yet.</p>
                </div>
            @endif
        </div>

    </div>
</x-dashboard.teacher.base>
