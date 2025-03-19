<x-dashboard.student.base>
    <x-notification-message />

    <x-tab.tab :tabs="['Classrooms', 'My Classrooms']" :active="0" />

    @if (request()->get('activeTab') == 1)
        <div>
            <div class="grid grid-cols-4 grid-flow-row gap-5 w-full h-52">

                @forelse ($myClassrooms as $myClassroom)
                    <div class="flex flex-col w-full h-full rounded-lg border border-accent">
                        <a href="{{ route('student.classrooms.show', ['classroom' => $myClassroom->id]) }}"
                            class="flex relative flex-col justify-between p-2 h-1/2 rounded-t-lg bg-accent">
                            <h1 class="text-lg font-bold tracking-wider capitalize text-primary">
                                {{ $myClassroom->subject->name }}
                            </h1>
                            <p class="text-sm tracking-wide capitalize text-primary">
                                {{ $myClassroom->teacher->name }}
                            </p>
                            <img src="{{ $myClassroom->teacher->profile->image }}" alt="" srcset=""
                                class="object-cover absolute right-5 -bottom-5 z-10 w-16 h-16 rounded-full">
                        </a>
                        <div class="p-2 w-full h-1/2">
                            <h1 class="text-sm uppercase">{{ $myClassroom->name }} - {{ $myClassroom->strand->acronym }}
                            </h1>
                        </div>
                        <p class="p-2 text-sm tracking-wide capitalize text-accent">
                            {{ $myClassroom->academicYear->name }}
                        </p>
                    </div>
                @empty
                    <div class="flex justify-center items-center w-full h-full rounded-lg border border-accent">
                        <p class="text-lg font-bold text-accent">
                            No Classrooms
                        </p>
                    </div>
                @endforelse
            </div>
            {!! $myClassrooms->links() !!}
        </div>
    @endif

    @if (request()->get('activeTab') == 0)
        <div>
            <div class="grid grid-cols-4 grid-flow-row gap-5 w-full h-52">

                @forelse ($classrooms as $classroom)
                    <div class="flex flex-col w-full h-full rounded-lg border border-accent">
                        <a href="{{ route('student.classrooms.show', ['classroom' => $classroom->id]) }}"
                            class="flex relative flex-col justify-between p-2 h-1/2 rounded-t-lg bg-accent">
                            <h1 class="text-lg font-bold tracking-wider capitalize text-primary">
                                {{ $classroom->subject->name }}
                            </h1>
                            <p class="text-sm tracking-wide capitalize text-primary">
                                {{ $classroom->teacher->name }}
                            </p>
                            <img src="{{ $classroom->teacher->profile->image }}" alt="" srcset=""
                                class="object-cover absolute right-5 -bottom-5 z-10 w-16 h-16 rounded-full">
                        </a>
                        <div class="p-2 w-full h-1/2">
                            <h1 class="text-sm uppercase">{{ $classroom->name }} - {{ $classroom->strand->acronym }}
                            </h1>
                        </div>

                        <div class="flex justify-between items-center p-2">
                            <p class="text-sm tracking-wide capitalize text-accent">
                                {{ $classroom->academicYear->name }}
                            </p>

                            <!-- You can open the modal using ID.showModal() method -->

                            @if (!$classroom->classroomStudents()->where('student_id', Auth::user()->id)->exists())
                                <button class="text-white btn btn-sm btn-accent"
                                    onclick="enroll_{{ $classroom->id }}.showModal()">Join</button>
                                <dialog id="enroll_{{ $classroom->id }}" class="modal">
                                    <div class="modal-box">
                                        <form method="dialog">
                                            <button
                                                class="absolute top-2 right-2 btn btn-sm btn-circle btn-ghost">✕</button>
                                        </form>
                                        <form
                                            action="{{ route('student.classrooms.join', ['classroom' => $classroom->id]) }}"
                                            method="post" class="flex flex-col gap-2">
                                            @csrf
                                            @method('POST')
                                            <label for="class_code" class="label">
                                                <span class="label-text">Class Code</span>
                                            </label>
                                            <input type="text" name="class_code" id="class_code"
                                                class="w-full input input-sm input-accent input-bordered" placeholder="Class Code">
                                            <button class="btn btn-sm btn-accent">Join</button>
                                        </form>
                                    </div>
                                </dialog>
                            @else
                                <button class="btn btn-sm btn-accent">Joined</button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="flex justify-center items-center w-full h-full rounded-lg border border-accent">
                        <p class="text-lg font-bold text-accent">
                            No Classrooms
                        </p>
                    </div>
                @endforelse
            </div>
            {!! $classrooms->links() !!}
        </div>
    @endIf



</x-dashboard.student.base>
