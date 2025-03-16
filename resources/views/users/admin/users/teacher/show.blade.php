<x-dashboard.admin.base>
    <x-dashboard.page-title :back_url="route('admin.users.teacher.index')" :title="_($teacher->name)" />

    <div class="panel flex gap-2 min-h-96">
        <div class="w-1/4 flex flex-col gap-2 items-center h-full p-4">
            <img src="{{ $teacher->profile->image ?? "https://ui-avatars.com/api/?name={$teacher->name}" }}"
                alt="" srcset=""
                class="object-cover object-center w-32 h-32
                rounded-full border-2 border-accent">
            <h1 class="text-accent font-bold text-lg capitalize">
                {{ $teacher->name }}
            </h1>
            <p class="text-sm text-gray-500">
                Email : {{ $teacher->email }}
            </p>
            <p class="text-xs text-gray-500">
                Date Joined : {{ date('F d, Y h:s a', strtotime($teacher->created_at)) }}
            </p>
        </div>
        <div class="grow flex flex-col gap-5">
            <h1 class="w-full bg-gray-100 p-2 font-semibold border-y border-gray-500">
                Profile
            </h1>
            @if ($teacher->profile !== null)
                @php
                    $profile = $teacher->profile;
                @endphp
                <div class="flex flex-col gap-2">
                    <div class="grid grid-cols-3 grid-flow-row gap-5">
                        <div class="flex flex-col gap-2 capitalize">
                            <label for="" class="text-accent text-xs font-bold">Last Name</label>
                            <p>
                                {{ $profile->last_name }}
                            </p>
                        </div>
                        <div class="flex flex-col gap-2 capitalize">
                            <label for="" class="text-accent text-xs font-bold">first Name</label>
                            <p>
                                {{ $profile->first_name }}
                            </p>
                        </div>
                        <div class="flex flex-col gap-2 capitalize">
                            <label for="" class="text-accent text-xs font-bold">middle Name</label>
                            <p>
                                {{ $profile->middle_name ?? 'N\A' }}
                            </p>
                        </div>
                        <div class="flex flex-col gap-2 capitalize">
                            <label for="" class="text-accent text-xs font-bold">Sex</label>
                            <p>
                                {{ $profile->sex }}
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 capitalize">
                        <label for="" class="text-accent text-xs font-bold">Address</label>
                        <p>
                            {{ $profile->address }}
                        </p>
                    </div>
                    <div class="flex flex-col gap-2 capitalize">
                        <label for="" class="text-accent text-xs font-bold">Contact #</label>
                        <p>
                            {{ $profile->contact_no }}
                        </p>
                    </div>
                </div>
            @else
                <div class="h-32 bg-gray-200 rounded-lg flex items-center justify-center">
                    <h1 class="text-xs bg-accent rounded-lg px-4 py-2 text-primary">
                        No Profile
                    </h1>
                </div>
            @endif
            <h1 class="w-full bg-gray-100 p-2 font-semibold border-y border-gray-500">
                Classrooms
            </h1>
            <div class="grid grid-cols-3 grid-flow-row gap-5 h-52 w-full">
                @forelse ($teacher->teacherClassrooms as $classroom)
                    <div class="h-full w-full rounded-lg border border-accent flex flex-col">
                        <a href="#"
                            class="bg-accent h-1/2 rounded-t-lg relative p-2 flex flex-col justify-between">
                            <h1 class="text-lg font-bold text-primary capitalize tracking-wider">
                                {{ $classroom->subject->name }}
                            </h1>

                            <p class="text-sm text-primary tracking-wide capitalize">
                                {{ $classroom->teacher->name }}
                            </p>
                            <img src="{{ $classroom->teacher->profile->image }}" alt="" srcset=""
                                class="absolute z-10 -bottom-5 right-5 h-16 w-16 object-cover rounded-full">
                        </a>
                        <div class="h-1/2 w-full p-2">
                            <h1 class="text-sm uppercase">{{ $classroom->name }} - {{ $classroom->strand->acronym }}
                            </h1>
                        </div>
                    </div>
                @empty
                    <div class="h-full w-full rounded-lg border border-accent flex justify-center items-center">
                        <p class="text-lg font-bold text-accent">
                            No Classrooms
                        </p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</x-dashboard.admin.base>
