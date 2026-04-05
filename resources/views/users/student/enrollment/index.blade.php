<x-dashboard.student.base>
    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <!-- Header -->
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
                        <h2 class="text-lg sm:text-xl font-semibold text-gray-800">My Enrollment Forms</h2>
                        <a href="{{ route('student.enrollment.create') }}"
                           class="btn btn-accent btn-sm gap-2 w-full sm:w-auto justify-center">
                            <i class="fi fi-rr-plus"></i>
                            <span>New Enrollment</span>
                        </a>
                    </div>

                    <!-- Mobile Cards -->
                    <div class="md:hidden space-y-4">
                        @forelse($enrollments as $enrollment)
                            <article class="border rounded-lg p-4 bg-gray-50">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h3 class="font-semibold text-gray-900">{{ $enrollment->school_year }}</h3>
                                        <p class="text-sm text-gray-600">{{ $enrollment->grade_level }}</p>
                                    </div>
                                    <span class="badge badge-sm {{
                                        $enrollment->status === 'pending' ? 'badge-warning' :
                                        ($enrollment->status === 'enrolled' ? 'badge-success' : 'badge-error')
                                    }}">
                                        {{ ucfirst($enrollment->status) }}
                                    </span>
                                </div>

                                <div class="text-xs text-gray-500 mb-3">
                                    <i class="fi fi-rr-calendar"></i>
                                    {{ $enrollment->created_at->format('M d, Y') }}
                                </div>

                                <div class="flex gap-2">
                                    <a href="{{ route('student.enrollment.show', $enrollment->id) }}"
                                       class="btn btn-ghost btn-sm flex-1">
                                        <i class="fi fi-rr-eye"></i> View
                                    </a>
                                    @if($enrollment->status === 'enrolled')
                                        <a href="{{ route('student.enrollment.create', ['previous' => $enrollment->id]) }}"
                                           class="btn btn-accent btn-sm flex-1">
                                            <i class="fi fi-rr-arrow-up hidden"></i>
                                            <span class="">Enroll Next</span>
                                        </a>
                                    @endif
                                </div>
                            </article>
                        @empty
                            <div class="text-center py-12">
                                <i class="fi fi-rr-file-circle-xmark text-4xl text-gray-400 mb-3 block"></i>
                                <p class="text-gray-500 mb-4">No enrollment forms found</p>
                                <a href="{{ route('student.enrollment.create') }}"
                                   class="btn btn-accent btn-sm">
                                    <i class="fi fi-rr-plus"></i> Create First Enrollment
                                </a>
                            </div>
                        @endforelse
                    </div>

                    <!-- Desktop Table -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th>School Year</th>
                                    <th>Grade Level</th>
                                    <th>Status</th>
                                    <th>Submitted Date</th>
                                    <th class="text-right">Actions</th>
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
                                            <div class="flex gap-2 justify-end">
                                                <a href="{{ route('student.enrollment.show', $enrollment->id) }}"
                                                   class="btn btn-ghost btn-sm">
                                                    <i class="fi fi-rr-eye"></i>
                                                </a>
                                                @if($enrollment->status === 'enrolled')
                                                    <a href="{{ route('student.enrollment.create', ['previous' => $enrollment->id]) }}"
                                                       class="btn btn-accent btn-sm"
                                                       title="Enroll for next grade level">
                                                        <i class="fi fi-rr-arrow-up"></i>
                                                    </a>
                                                @endif
                                            </div>
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
                    @if($enrollments->hasPages())
                        <div class="mt-6">
                            {{ $enrollments->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-dashboard.student.base>
