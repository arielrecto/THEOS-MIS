<x-dashboard.admin.base>
    <x-dashboard.page-title :back_url="route('admin.users.teacher.index')" :title="_($teacher->name)" />

    <div class="panel flex flex-col sm:flex-row gap-4">
        <!-- Left: profile (full width on mobile, column on sm+) -->
        <aside class="w-full sm:w-1/3 bg-white rounded-lg border p-4 flex flex-col items-center gap-3">
            <img
                src="{{ $teacher->profile->image ?? "https://ui-avatars.com/api/?name={$teacher->name}" }}"
                alt="{{ $teacher->name }}"
                class="object-cover object-center w-24 h-24 sm:w-32 sm:h-32 rounded-full border-2 border-accent shadow-sm" />

            <h1 class="text-lg sm:text-xl font-semibold text-accent text-center break-words">
                {{ $teacher->name }}
            </h1>

            <p class="text-sm text-gray-500 text-center break-words">Email: {{ $teacher->email }}</p>
            <p class="text-xs text-gray-500 text-center break-words">
                Date Joined: {{ date('F d, Y h:i a', strtotime($teacher->created_at)) }}
            </p>

            <div class="w-full mt-3 grid grid-cols-2 gap-2">
                <div class="p-3 rounded-lg bg-accent/10 text-center">
                    <div class="text-xs text-gray-600">Classrooms</div>
                    <div class="text-lg font-bold text-accent">{{ $teacher->teacherClassrooms->count() }}</div>
                </div>
                <div class="p-3 rounded-lg bg-accent/10 text-center">
                    <div class="text-xs text-gray-600">Joined</div>
                    <div class="text-sm text-gray-700 break-words">{{ date('M d, Y', strtotime($teacher->created_at)) }}</div>
                </div>
            </div>
        </aside>

        <!-- Right: profile details & classrooms (stacked under on mobile) -->
        <div class="w-full flex flex-col gap-5">
            <section class="bg-white rounded-lg border p-4">
                <h2 class="text-base sm:text-lg font-semibold text-gray-800 mb-3">Profile</h2>

                @if ($teacher->profile !== null)
                    @php $profile = $teacher->profile; @endphp
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm text-gray-700">
                        <div class="flex flex-col gap-1">
                            <label class="text-accent text-xs font-bold">Last Name</label>
                            <p class="break-words">{{ $profile->last_name }}</p>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label class="text-accent text-xs font-bold">First Name</label>
                            <p class="break-words">{{ $profile->first_name }}</p>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label class="text-accent text-xs font-bold">Middle Name</label>
                            <p class="break-words">{{ $profile->middle_name ?? 'N/A' }}</p>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label class="text-accent text-xs font-bold">Sex</label>
                            <p class="break-words">{{ $profile->sex }}</p>
                        </div>

                        <div class="sm:col-span-2 flex flex-col gap-1">
                            <label class="text-accent text-xs font-bold">Address</label>
                            <p class="break-words">{{ $profile->address }}</p>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label class="text-accent text-xs font-bold">Contact #</label>
                            <p class="break-words">{{ $profile->contact_no }}</p>
                        </div>
                    </div>
                @else
                    <div class="h-24 sm:h-32 bg-gray-100 rounded-lg flex items-center justify-center">
                        <span class="text-sm text-gray-600">No Profile Available</span>
                    </div>
                @endif
            </section>

            <section>
                <h2 class="text-base sm:text-lg font-semibold text-gray-800 mb-3">Classrooms</h2>

                <!-- Mobile: stacked cards (1 column) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse ($teacher->teacherClassrooms as $classroom)
                        <div class="bg-white rounded-lg border shadow-sm overflow-hidden flex flex-col">
                            <a href="#"
                               class="flex items-center justify-between gap-3 p-3 bg-accent/10">
                                <div class="min-w-0">
                                    <h3 class="text-sm font-semibold leading-tight truncate">{{ $classroom->subject->name }}</h3>
                                    <p class="text-xs mt-1 truncate">{{ $classroom->teacher->name }}</p>
                                </div>

                                <img src="{{ optional($classroom->teacher->profile)->image ?? 'https://ui-avatars.com/api/?name='.urlencode($classroom->teacher->name).'&size=128' }}"
                                     alt="{{ $classroom->teacher->name }}"
                                     class="w-12 h-12 rounded-full object-cover flex-shrink-0" />
                            </a>

                            <div class="p-3">
                                <div class="text-sm uppercase text-gray-700 truncate">{{ $classroom->name }} - {{ $classroom->strand->acronym ?? '' }}</div>
                                <div class="text-xs text-gray-500 mt-2 break-words">{{ $classroom->class_code ?? '' }}</div>

                                <div class="mt-3 flex items-center gap-2">
                                    <a href="#" class="btn btn-ghost btn-sm text-xs">View</a>
                                    <a href="#" class="btn btn-ghost btn-sm text-xs">Manage</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full bg-white rounded-lg shadow-sm p-6 text-center text-gray-500">
                            <i class="fi fi-rr-book text-2xl mb-2"></i>
                            <p class="text-sm">No Classrooms</p>
                        </div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</x-dashboard.admin.base>
