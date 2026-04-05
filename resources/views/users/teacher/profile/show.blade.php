<x-dashboard.teacher.base>
    <x-dashboard.page-title :back_url="route('teacher.dashboard')" :title="_($teacher->name)"/>

    <div class="panel flex flex-col lg:flex-row gap-4 lg:gap-2 min-h-96">
        <!-- Profile Sidebar - Full width on mobile, 1/4 on desktop -->
        <div class="w-full lg:w-1/4 flex flex-col gap-2 items-center p-4 bg-base-50 lg:bg-transparent rounded-lg lg:rounded-none">
            <img src="{{$teacher->profile->image ?? "https://ui-avatars.com/api/?name={$teacher->name}"}}"
                alt="{{ $teacher->name }}"
                class="object-cover object-center w-24 h-24 sm:w-32 sm:h-32 rounded-full border-2 border-accent">

            <h1 class="text-accent font-bold text-base sm:text-lg capitalize text-center">
                {{$teacher->name}}
            </h1>

            <div class="w-full flex flex-col gap-1 text-center">
                <p class="text-xs sm:text-sm text-gray-500">
                    <span class="font-semibold">Email:</span> {{$teacher->email}}
                </p>
                <p class="text-xs text-gray-500">
                    <span class="font-semibold">Date Joined:</span>
                    {{date('F d, Y', strtotime($teacher->created_at))}}
                </p>
            </div>

            <!-- Edit Button - Show on mobile -->
            <div class="w-full mt-3 lg:hidden">
                <a href="{{ route('teacher.profile.edit', $teacher->id) }}"
                   class="btn btn-sm btn-accent btn-block">
                    <i class="fi fi-rr-edit"></i>
                    Edit Profile
                </a>
            </div>
        </div>

        <!-- Main Content - Full width on mobile, grow on desktop -->
        <div class="grow flex flex-col gap-4 lg:gap-5 px-2 sm:px-0">
            <!-- Profile Section -->
            <div class="flex items-center justify-between bg-gray-100 p-2 sm:p-3 font-semibold border-y border-gray-500">
                <h1 class="text-sm sm:text-base">Profile Information</h1>
                <!-- Edit Button - Show on desktop -->
                <a href="{{ route('teacher.profile.edit', $teacher->id) }}"
                   class="hidden lg:inline-flex btn btn-xs btn-ghost gap-1">
                    <i class="fi fi-rr-edit"></i>
                    Edit
                </a>
            </div>

            @if($teacher->profile !== null)
                @php
                    $profile = $teacher->profile;
                @endphp
                <div class="flex flex-col gap-3 sm:gap-4 px-2 sm:px-0">
                    <!-- Name Fields Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-5">
                        <div class="flex flex-col gap-1 sm:gap-2 capitalize">
                            <label class="text-accent text-xs font-bold">Last Name</label>
                            <p class="text-sm sm:text-base p-2 bg-base-100 rounded border border-base-300">
                                {{$profile->last_name}}
                            </p>
                        </div>
                        <div class="flex flex-col gap-1 sm:gap-2 capitalize">
                            <label class="text-accent text-xs font-bold">First Name</label>
                            <p class="text-sm sm:text-base p-2 bg-base-100 rounded border border-base-300">
                                {{$profile->first_name}}
                            </p>
                        </div>
                        <div class="flex flex-col gap-1 sm:gap-2 capitalize">
                            <label class="text-accent text-xs font-bold">Middle Name</label>
                            <p class="text-sm sm:text-base p-2 bg-base-100 rounded border border-base-300">
                                {{$profile->middle_name ?? 'N/A'}}
                            </p>
                        </div>
                    </div>

                    <!-- Additional Fields -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-5">
                        <div class="flex flex-col gap-1 sm:gap-2 capitalize">
                            <label class="text-accent text-xs font-bold">Sex</label>
                            <p class="text-sm sm:text-base p-2 bg-base-100 rounded border border-base-300">
                                {{$profile->sex}}
                            </p>
                        </div>
                        <div class="flex flex-col gap-1 sm:gap-2 capitalize">
                            <label class="text-accent text-xs font-bold">Contact Number</label>
                            <p class="text-sm sm:text-base p-2 bg-base-100 rounded border border-base-300">
                                {{$profile->contact_no}}
                            </p>
                        </div>
                    </div>

                    <!-- Address - Full Width -->
                    <div class="flex flex-col gap-1 sm:gap-2 capitalize">
                        <label class="text-accent text-xs font-bold">Address</label>
                        <p class="text-sm sm:text-base p-2 bg-base-100 rounded border border-base-300">
                            {{$profile->address}}
                        </p>
                    </div>
                </div>
            @else
                <div class="h-32 bg-gray-200 rounded-lg flex items-center justify-center mx-2 sm:mx-0">
                    <div class="text-center">
                        <i class="fi fi-rr-user text-3xl text-gray-400 mb-2"></i>
                        <h1 class="text-xs sm:text-sm bg-accent rounded-lg px-4 py-2 text-white inline-block">
                            No Profile Information
                        </h1>
                        <p class="text-xs text-gray-500 mt-2">
                            <a href="{{ route('teacher.profile.edit', $teacher->id) }}"
                               class="text-accent underline">
                                Click here to add profile
                            </a>
                        </p>
                    </div>
                </div>
            @endif

            <!-- Classrooms Section -->
            <div class="bg-gray-100 p-2 sm:p-3 font-semibold border-y border-gray-500">
                <h1 class="text-sm sm:text-base">Assigned Classrooms</h1>
            </div>

            <!-- Classrooms List -->
            <div class="px-2 sm:px-0 pb-4">
                @if(isset($classrooms) && $classrooms->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                        @foreach($classrooms as $classroom)
                            <a href="{{ route('teacher.classrooms.show', $classroom->id) }}"
                               class="card bg-base-100 border border-base-300 hover:shadow-lg hover:border-accent transition-all">
                                <div class="card-body p-4">
                                    <h3 class="font-semibold text-sm sm:text-base text-accent truncate">
                                        {{ $classroom->subject->name ?? 'N/A' }}
                                    </h3>
                                    <p class="text-xs text-gray-600">
                                        {{ $classroom->section->name ?? 'N/A' }}
                                        @if($classroom->section && $classroom->section->strand)
                                            <span class="badge badge-xs badge-ghost ml-1">
                                                {{ $classroom->section->strand->acronym }}
                                            </span>
                                        @endif
                                    </p>
                                    <div class="flex items-center justify-between mt-2">
                                        <span class="badge badge-sm badge-accent">
                                            {{ $classroom->students_count ?? 0 }} Students
                                        </span>
                                        <i class="fi fi-rr-arrow-right text-gray-400"></i>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 bg-base-100 rounded-lg border border-dashed border-base-300">
                        <i class="fi fi-rr-chalkboard text-4xl text-gray-300 mb-3"></i>
                        <p class="text-sm text-gray-500">No classrooms assigned yet</p>
                        <a href="{{ route('teacher.classrooms.index') }}"
                           class="btn btn-sm btn-accent mt-3">
                            View Available Classrooms
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-dashboard.teacher.base>
