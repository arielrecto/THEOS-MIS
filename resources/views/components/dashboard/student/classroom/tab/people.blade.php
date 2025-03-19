@props(['classroom'])

<x-slot name="people">
    <div class="grid grid-cols-1 gap-6">
        <!-- Teacher Section -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-accent px-6 py-4">
                <h2 class="text-lg font-semibold text-white">Teacher</h2>
            </div>
            <div class="p-6">
                <div class="flex items-center space-x-4">
                    <div class="avatar">
                        <div class="w-12 h-12 rounded-full">
                            <img src="{{ $classroom->teacher->profile->image ?? 'https://ui-avatars.com/api/?name=' . urlencode($classroom->teacher->name) }}"
                                 alt="Teacher Profile">
                        </div>
                    </div>
                    <div>
                        <h3 class="font-medium">{{ $classroom->teacher->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $classroom->teacher->email }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Students Section -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-accent px-6 py-4 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-white">Students</h2>
                <span class="badge badge-ghost text-white">
                    {{ $classroom->classroomStudents->count() }} Students
                </span>
            </div>
            <div class="p-6">
                <div class="divide-y">
                    @foreach($classroom->classroomStudents as $classroomStudent)
                        <div class="flex items-center justify-between py-4 first:pt-0 last:pb-0">
                            <div class="flex items-center space-x-4">
                                <div class="avatar">
                                    <div class="w-10 h-10 rounded-full">
                                        <img src="{{ $classroomStudent->student->profile->image ?? 'https://ui-avatars.com/api/?name=' . urlencode($classroomStudent->student->name) }}"
                                             alt="Student Profile">
                                    </div>
                                </div>
                                <div>
                                    <h3 class="font-medium">{{ $classroomStudent->student->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $classroomStudent->student->email }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-slot>
