<x-dashboard.admin.base>
    <x-dashboard.page-title :title="'Employee Profile'" :back_url="route('admin.users.teacher.show', $teacher->id)">
        <x-slot name="other">
            <a href="{{ route('admin.users.teacher.edit', $teacher->id) }}"
               class="btn btn-secondary btn-sm gap-2 text-white">
                <i class="fi fi-rr-edit"></i>
                <span class="hidden sm:inline">Edit</span>
            </a>
            <button onclick="window.print()" class="btn btn-ghost btn-sm gap-2">
                <i class="fi fi-rr-print"></i>
                <span class="hidden sm:inline">Print</span>
            </button>
        </x-slot>
    </x-dashboard.page-title>

    {{-- Print styles --}}
    <style>
        @media print {
            @page { margin: 0; size: A4 portrait; }
            body { padding: 1cm; }
            .no-print { display: none !important; }
            .print-break { page-break-inside: avoid; }
        }
    </style>

    <div class="max-w-4xl mx-auto space-y-6 pb-10">

        {{-- Profile Card --}}
        <div class="bg-base-100 rounded-2xl shadow-lg overflow-hidden print-break">
            {{-- Banner --}}
            <div class="h-24 bg-gradient-to-r from-accent to-primary"></div>

            {{-- Avatar + Name --}}
            <div class="px-6 pb-6">
                <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 -mt-12">
                    <div class="flex items-end gap-4">
                        <div class="avatar placeholder shrink-0">
                            <div class="bg-accent text-white rounded-full w-24 h-24 ring-4 ring-base-100 shadow">
                                <span class="text-4xl font-bold">{{ strtoupper(substr($teacher->name, 0, 1)) }}</span>
                            </div>
                        </div>
                        <div class="pb-1">
                            <h2 class="text-xl sm:text-2xl font-bold text-gray-800 leading-tight">{{ $teacher->name }}</h2>
                            <p class="text-sm text-gray-500">Teacher</p>
                        </div>
                    </div>

                    {{-- Status Badge --}}
                    <div class="pb-1">
                        <span class="badge badge-success badge-lg gap-1 text-white">
                            <i class="fi fi-rr-check"></i> Active
                        </span>
                    </div>
                </div>

                {{-- Grade Level Badges --}}
                @php $grades = $teacher->teacherClassrooms->pluck('strand.name')->unique()->filter()->values(); @endphp
                @if($grades->count())
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach($grades as $grade)
                            <span class="badge badge-accent badge-outline">{{ $grade }}</span>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Stats Row --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 print-break">
            <div class="bg-base-100 rounded-xl shadow p-4 text-center">
                <p class="text-3xl font-bold text-accent">{{ $teacher->teacherClassrooms->count() }}</p>
                <p class="text-xs text-gray-500 mt-1 uppercase tracking-wide">Classrooms</p>
            </div>
            <div class="bg-base-100 rounded-xl shadow p-4 text-center">
                <p class="text-3xl font-bold text-primary">{{ $grades->count() }}</p>
                <p class="text-xs text-gray-500 mt-1 uppercase tracking-wide">Grade Levels</p>
            </div>
            <div class="bg-base-100 rounded-xl shadow p-4 text-center col-span-2 sm:col-span-1">
                <p class="text-3xl font-bold text-secondary">
                    {{ $teacher->teacherClassrooms->pluck('subject.name')->unique()->filter()->count() }}
                </p>
                <p class="text-xs text-gray-500 mt-1 uppercase tracking-wide">Subjects</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Personal Information --}}
            <div class="bg-base-100 rounded-xl shadow p-6 print-break">
                <div class="flex items-center gap-2 mb-5">
                    <span class="p-2 bg-accent/10 rounded-lg">
                        <i class="fi fi-rr-user text-accent"></i>
                    </span>
                    <h3 class="font-bold text-gray-700">Personal Information</h3>
                </div>
                <dl class="space-y-4 text-sm">
                    <div class="flex justify-between border-b border-base-200 pb-3">
                        <dt class="text-gray-500">Full Name</dt>
                        <dd class="font-medium text-gray-800 text-right">
                            @if($teacher->profile)
                                {{ implode(' ', array_filter([
                                    $teacher->profile->first_name,
                                    $teacher->profile->middle_name ? $teacher->profile->middle_name[0].'.' : null,
                                    $teacher->profile->last_name,
                                ])) ?: $teacher->name }}
                            @else
                                {{ $teacher->name }}
                            @endif
                        </dd>
                    </div>
                    <div class="flex justify-between border-b border-base-200 pb-3">
                        <dt class="text-gray-500">Sex</dt>
                        <dd class="font-medium text-gray-800">{{ $teacher->profile->sex ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between border-b border-base-200 pb-3">
                        <dt class="text-gray-500">Contact No.</dt>
                        <dd class="font-medium text-gray-800">{{ $teacher->profile->contact_no ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between border-b border-base-200 pb-3">
                        <dt class="text-gray-500">Address</dt>
                        <dd class="font-medium text-gray-800 text-right max-w-[60%]">{{ $teacher->profile->address ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between border-b border-base-200 pb-3">
                        <dt class="text-gray-500">Email</dt>
                        <dd class="font-medium text-gray-800 break-all text-right max-w-[60%]">{{ $teacher->email }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Member Since</dt>
                        <dd class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($teacher->created_at)->format('M d, Y') }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Employment Information --}}
            <div class="bg-base-100 rounded-xl shadow p-6 print-break">
                <div class="flex items-center gap-2 mb-5">
                    <span class="p-2 bg-primary/10 rounded-lg">
                        <i class="fi fi-rr-briefcase text-primary"></i>
                    </span>
                    <h3 class="font-bold text-gray-700">Employment Information</h3>
                </div>
                <dl class="space-y-4 text-sm">
                    <div class="flex justify-between border-b border-base-200 pb-3">
                        <dt class="text-gray-500">Role</dt>
                        <dd class="font-medium text-gray-800">Teacher</dd>
                    </div>
                    <div class="flex justify-between border-b border-base-200 pb-3">
                        <dt class="text-gray-500">Employee ID</dt>
                        <dd class="font-medium text-gray-800">TCH-{{ str_pad($teacher->id, 4, '0', STR_PAD_LEFT) }}</dd>
                    </div>
                    <div class="flex justify-between border-b border-base-200 pb-3">
                        <dt class="text-gray-500">Date Joined</dt>
                        <dd class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($teacher->created_at)->format('M d, Y') }}</dd>
                    </div>
                    <div class="flex justify-between border-b border-base-200 pb-3">
                        <dt class="text-gray-500">Employment Status</dt>
                        <dd>
                            <span class="badge badge-success text-white badge-sm">Active</span>
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Total Classrooms</dt>
                        <dd class="font-medium text-gray-800">{{ $teacher->teacherClassrooms->count() }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        {{-- Assigned Classrooms --}}
        @if($teacher->teacherClassrooms->count())
        <div class="bg-base-100 rounded-xl shadow p-6 print-break">
            <div class="flex items-center gap-2 mb-5">
                <span class="p-2 bg-secondary/10 rounded-lg">
                    <i class="fi fi-rr-chalkboard-user text-secondary"></i>
                </span>
                <h3 class="font-bold text-gray-700">Assigned Classrooms</h3>
                <span class="badge badge-ghost badge-sm ml-auto">{{ $teacher->teacherClassrooms->count() }}</span>
            </div>

            <div class="overflow-x-auto">
                <table class="table table-zebra w-full text-sm">
                    <thead>
                        <tr class="text-xs uppercase tracking-wide text-gray-500">
                            <th>Classroom</th>
                            <th>Subject</th>
                            <th>Grade Level</th>
                            <th>School Year</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teacher->teacherClassrooms as $classroom)
                        <tr>
                            <td>
                                <p class="font-semibold text-gray-800">{{ $classroom->name }}</p>
                                @if($classroom->class_code)
                                    <p class="text-xs text-gray-400">{{ $classroom->class_code }}</p>
                                @endif
                            </td>
                            <td>{{ $classroom->subject?->name ?? '—' }}</td>
                            <td>
                                @if($classroom->strand)
                                    <span class="badge badge-accent badge-sm">{{ $classroom->strand->name }}</span>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="text-gray-500">{{ $classroom->academicYear?->name ?? '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        {{-- Subjects Summary --}}
        @php $subjects = $teacher->teacherClassrooms->pluck('subject')->unique('id')->filter(); @endphp
        @if($subjects->count())
        <div class="bg-base-100 rounded-xl shadow p-6 print-break">
            <div class="flex items-center gap-2 mb-5">
                <span class="p-2 bg-info/10 rounded-lg">
                    <i class="fi fi-rr-book-alt text-info"></i>
                </span>
                <h3 class="font-bold text-gray-700">Subjects Handled</h3>
            </div>
            <div class="flex flex-wrap gap-2">
                @foreach($subjects as $subject)
                    <span class="badge badge-outline badge-info">{{ $subject->name }}</span>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Footer --}}
        <div class="text-center text-xs text-gray-400 pt-2 no-print">
            <p>Generated on {{ now()->format('F d, Y \a\t h:i A') }} &mdash; {{ config('app.name') }}</p>
        </div>
        <div class="hidden print:block text-center text-xs text-gray-400 pt-4">
            <p>Generated on {{ now()->format('F d, Y \a\t h:i A') }} &mdash; {{ config('app.name') }}</p>
        </div>

    </div>
</x-dashboard.admin.base>
