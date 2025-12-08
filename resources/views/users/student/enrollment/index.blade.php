<x-dashboard.student.base>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold text-gray-800">My Enrollment Forms</h2>
                        {{-- <a href="{{ route('enrollment.create') }}"
                           class="btn btn-accent btn-sm gap-2">
                            <i class="fi fi-rr-plus"></i>
                            New Enrollment
                        </a> --}}
                    </div>


                    <!-- Enrollment List -->
                    <div class="overflow-x-auto">
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th>School Year</th>
                                    <th>Grade Level</th>
                                    <th>Status</th>
                                    <th>Submitted Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($enrollments as $enrollment)
                                    <tr>
                                        <td>{{ $enrollment->school_year }}</td>
                                        <td>{{ $enrollment->grade_level }}</td>
                                        <td>
                                            <span class="badge {{
                                                $enrollment->status === 'pending' ? 'badge-warning' :
                                                ($enrollment->status === 'enrolled' ? 'badge-success' : 'badge-error')
                                            }}">
                                                {{ ucfirst($enrollment->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $enrollment->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <a href="{{ route('student.enrollment.show', $enrollment->id) }}"
                                               class="btn btn-ghost btn-sm">
                                                <i class="fi fi-rr-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-8">
                                            <div class="flex flex-col items-center justify-center text-gray-500">
                                                <i class="fi fi-rr-file-circle-xmark text-3xl mb-2"></i>
                                                <p>No enrollment forms found</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $enrollments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.student.base>
