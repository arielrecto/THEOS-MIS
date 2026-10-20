<x-dashboard.teacher.base>
    <x-notification-message />

    {{-- Wallpaper and footer come from the shared dashboard layout --}}
    <div>

        <!-- Summary cards -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 lg:gap-6">
            <div class="flex justify-between items-center p-5 rounded-2xl border shadow-lg backdrop-blur-sm border-white/80 bg-white/85">
                <div class="min-w-0">
                    <p class="font-semibold text-slate-700">Total Archived</p>
                    <p class="mt-1 text-4xl font-bold text-slate-900">{{ $stats['total_archived'] }}</p>
                </div>
                <x-illustrations.archive-folders class="w-20 h-16 shrink-0" />
            </div>

            <div class="flex justify-between items-center p-5 rounded-2xl border shadow-lg backdrop-blur-sm border-white/80 bg-white/85">
                <div class="min-w-0">
                    <p class="font-semibold text-slate-700">Total Students</p>
                    <p class="mt-1 text-4xl font-bold text-slate-900">{{ $stats['total_students'] }}</p>
                </div>
                <x-illustrations.student-avatar class="w-16 h-16 shrink-0" />
            </div>

            <div class="flex justify-between items-center p-5 rounded-2xl border shadow-lg backdrop-blur-sm border-white/80 bg-white/85">
                <div class="min-w-0">
                    <p class="font-semibold text-slate-700">Last Archived</p>
                    <p class="mt-1 text-2xl font-bold text-slate-900 lg:text-3xl">
                        {{ $stats['last_archived'] ? \Illuminate\Support\Carbon::parse($stats['last_archived'])->format('M d, Y') : '—' }}
                    </p>
                </div>
                <x-illustrations.calendar class="w-14 h-14 shrink-0" />
            </div>
        </div>

        <!-- Archived classrooms -->
        <div class="p-4 mt-6 bg-white rounded-2xl shadow-xl sm:p-6 lg:mt-8">
            <div class="flex flex-col gap-3 sm:flex-row sm:justify-between sm:items-start">
                <div class="min-w-0">
                    <h2 class="text-xl font-bold text-slate-800 sm:text-2xl">Archived Classrooms</h2>
                    <p class="mt-1 text-sm text-slate-500">View and manage your archived classrooms</p>
                </div>
                <a href="{{ route('teacher.classrooms.index') }}"
                    class="inline-flex gap-2 items-center text-sm font-medium text-blue-600 whitespace-nowrap hover:underline">
                    <i class="flex fi fi-rr-arrow-left"></i>
                    Back to Classrooms
                </a>
            </div>

            <!-- Mobile: cards -->
            <div class="flex flex-col gap-3 mt-5 md:hidden">
                @forelse ($archivedClassrooms as $classroom)
                    <article class="p-4 rounded-xl border border-slate-100 bg-slate-50/60">
                        <div class="flex gap-3 justify-between items-start">
                            <div class="min-w-0">
                                <p class="font-semibold truncate text-slate-800">{{ $classroom->name }}</p>
                                <p class="text-sm truncate text-slate-500">{{ $classroom->subject->name ?? 'N/A' }}</p>
                            </div>
                            <span class="px-2.5 py-1 text-xs font-medium whitespace-nowrap rounded-full bg-slate-200/70 text-slate-600">
                                {{ $classroom->classroom_students_count }} {{ Str::plural('student', $classroom->classroom_students_count) }}
                            </span>
                        </div>
                        <div class="flex flex-wrap gap-x-4 gap-y-1 mt-2 text-xs text-slate-500">
                            <span>{{ $classroom->strand->name ?? 'N/A' }}</span>
                            <span>Archived {{ $classroom->archived_at?->format('M d, Y') ?? '—' }}</span>
                        </div>
                        <div class="flex gap-2 justify-end pt-3 mt-3 border-t border-slate-100">
                            @include('users.teacher.archived.partials.actions', ['classroom' => $classroom, 'labels' => true])
                        </div>
                    </article>
                @empty
                    @include('users.teacher.archived.partials.empty')
                @endforelse
            </div>

            <!-- Desktop: table -->
            <div class="hidden overflow-x-auto mt-5 md:block">
                <table class="table w-full">
                    <thead>
                        <tr class="text-sm border-b border-slate-100 text-slate-600">
                            <th>Classroom</th>
                            <th>Subject</th>
                            <th>Grade Level</th>
                            <th class="text-center">Students</th>
                            <th>Archived Date</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($archivedClassrooms as $classroom)
                            <tr class="border-slate-100 hover:bg-slate-50/70">
                                <td class="font-semibold text-slate-800">{{ $classroom->name }}</td>
                                <td class="text-slate-700">{{ $classroom->subject->name ?? 'N/A' }}</td>
                                <td class="text-slate-700">{{ $classroom->strand->name ?? 'N/A' }}</td>
                                <td class="text-center">
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-slate-100 text-slate-600">
                                        {{ $classroom->classroom_students_count }} {{ Str::plural('student', $classroom->classroom_students_count) }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap text-slate-700">{{ $classroom->archived_at?->format('M d, Y') ?? '—' }}</td>
                                <td>
                                    <div class="flex gap-1 justify-end">
                                        @include('users.teacher.archived.partials.actions', ['classroom' => $classroom, 'labels' => false])
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">@include('users.teacher.archived.partials.empty')</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($archivedClassrooms->hasPages())
                <div class="pt-4 mt-4 border-t border-slate-100">{{ $archivedClassrooms->links() }}</div>
            @endif
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <dialog id="delete_modal" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Delete Classroom Permanently</h3>
            <p class="flex gap-3 items-start py-4">
                <i class="text-xl fi fi-rr-exclamation text-warning"></i>
                <span class="text-sm">Are you sure you want to permanently delete
                    <strong id="delete_name"></strong>? This action cannot be undone.</span>
            </p>

            <div class="mt-2 alert alert-warning">
                <i class="fi fi-rr-info"></i>
                <span class="text-sm">The classroom must have no enrolled students to be deleted.</span>
            </div>

            <div class="modal-action">
                <form method="dialog">
                    <button class="btn">Cancel</button>
                </form>
                <form id="delete_form" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error">Delete Permanently</button>
                </form>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    @push('scripts')
        <script>
            function deleteClassroom(url, name) {
                document.getElementById('delete_form').action = url;
                document.getElementById('delete_name').textContent = name;
                document.getElementById('delete_modal').showModal();
            }
        </script>
    @endpush
</x-dashboard.teacher.base>
