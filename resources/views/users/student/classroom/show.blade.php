<x-dashboard.student.classroom.base :classroom="$classroom" :url="route('student.classrooms.show', ['classroom' => $classroom->id])">
    <div class="flex flex-col gap-2">
        <x-dashboard.student.classroom.tab.stream :announcements="$classroom->announcements"/>
        <x-dashboard.student.classroom.tab.tasks :tasks="$tasks"/>
        <x-dashboard.student.classroom.tab.people :classroom="$classroom"/>
    </div>
</x-dashboard.student.classroom.base>
