<x-dashboard.teacher.base>
    <x-dashboard.page-title :title="_('Edit Classroom')" :back_url="route('teacher.classrooms.index')" />
    <x-notification-message />

    <div class="w-full ">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <form method="POST" action="{{ route('teacher.classrooms.update', $classroom->id) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Academic Year -->
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700">Academic Year</label>
                    <select name="academic_year_id" class="select select-bordered w-full @error('academic_year_id') select-error @enderror">
                        @foreach($academicYears as $year)
                            <option value="{{ $year->id }}" {{ old('academic_year_id', $classroom->academic_year_id) == $year->id ? 'selected' : '' }}>
                                {{ $year->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('academic_year_id')
                        <p class="text-error text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Classroom Name -->
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700">Classroom Name</label>
                    <input type="text" name="name"
                           value="{{ old('name', $classroom->name) }}"
                           class="input input-bordered w-full @error('name') input-error @enderror"
                           placeholder="Enter classroom name">
                    @error('name')
                        <p class="text-error text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Subject -->
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700">Subject</label>
                    <select name="subject_id" class="select select-bordered w-full @error('subject_id') select-error @enderror">
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id', $classroom->subject_id) == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('subject_id')
                        <p class="text-error text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Strand -->
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700">Strand</label>
                    <select name="strand_id" class="select select-bordered w-full @error('strand_id') select-error @enderror">
                        @foreach($strands as $strand)
                            <option value="{{ $strand->id }}" {{ old('strand_id', $classroom->strand_id) == $strand->id ? 'selected' : '' }}>
                                {{ $strand->name }} ({{ $strand->acronym }})
                            </option>
                        @endforeach
                    </select>
                    @error('strand_id')
                        <p class="text-error text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Schedule -->
                {{-- <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700">Schedule</label>
                    <input type="text" name="schedule"
                           value="{{ old('schedule', $classroom->schedule) }}"
                           class="input input-bordered w-full @error('schedule') input-error @enderror"
                           placeholder="Enter class schedule">
                    @error('schedule')
                        <p class="text-error text-sm">{{ $message }}</p>
                    @enderror
                </div> --}}

                <!-- Actions -->
                <div class="flex justify-end space-x-2">
                    <a href="{{ route('teacher.classrooms.index') }}" class="btn btn-ghost">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-accent">
                        Update Classroom
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-dashboard.teacher.base>
