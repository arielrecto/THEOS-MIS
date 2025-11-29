<x-dashboard.registrar.base>
    <x-dashboard.page-title :title="_('enrollments')" :create_url="route('registrar.enrollments.create')" />

    <div class="flex flex-col gap-2 panel min-h-96">
        <!-- Mobile: stacked cards -->
        <div class="space-y-3 sm:hidden">
            @forelse ($enrollments as $enrollment)
                <div class="bg-white border rounded-lg p-4 shadow-sm">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <h3 class="text-sm font-semibold text-gray-900 truncate">{{ $enrollment->name }}</h3>
                            <p class="text-xs text-gray-500 mt-1 truncate">{{ $enrollment->academicYear->name }}</p>
                        </div>

                        <div class="text-right text-xs">
                            <div class="font-medium text-gray-700">{{ date('M d, Y', strtotime($enrollment->start_date)) }}</div>
                            <div class="text-gray-500">{{ date('M d, Y', strtotime($enrollment->end_date)) }}</div>
                        </div>
                    </div>

                    <div class="mt-3 flex items-center justify-between">
                        <div class="text-xs">
                            <span class="badge badge-sm">{{ $enrollment->status }}</span>
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('registrar.enrollments.show', ['enrollment' => $enrollment->id]) }}"
                               class="btn btn-xs btn-accent">
                                <i class="fi fi-rr-eye"></i>
                            </a>

                            <a href="{{ route('registrar.enrollments.edit', ['enrollment' => $enrollment->id]) }}"
                               class="btn btn-xs btn-primary">
                                <i class="fi fi-rr-edit"></i>
                            </a>

                            <form action="{{ route('registrar.enrollments.destroy', ['enrollment' => $enrollment->id]) }}"
                                  method="post" onsubmit="return confirm('Delete this enrollment?');">
                                @csrf
                                @method('delete')
                                <button class="btn btn-xs btn-error">
                                    <i class="fi fi-rr-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-6">No Enrollments</div>
            @endforelse
        </div>

        <!-- Desktop / Tablet: table -->
        <div class="hidden sm:block overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Academic Year</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($enrollments as $enrollment)
                        <tr class="hover:bg-gray-100 transition-colors">
                            <th></th>
                            <td class="max-w-xs truncate">{{ $enrollment->name }}</td>
                            <td class="max-w-xs truncate">{{ $enrollment->academicYear->name }}</td>
                            <td>{{ date('F d, Y', strtotime($enrollment->start_date)) }}</td>
                            <td>{{ date('F d, Y', strtotime($enrollment->end_date)) }}</td>
                            <td>{{ $enrollment->status }}</td>
                            <td class="flex gap-2 items-center justify-end">
                                <a href="{{ route('registrar.enrollments.show', ['enrollment' => $enrollment->id]) }}"
                                    class="btn btn-xs btn-accent">
                                    <i class="fi fi-rr-eye"></i>
                                </a>

                                <a href="{{ route('registrar.enrollments.edit', ['enrollment' => $enrollment->id]) }}"
                                    class="btn btn-xs btn-primary">
                                    <i class="fi fi-rr-edit"></i>
                                </a>

                                <form
                                    action="{{ route('registrar.enrollments.destroy', ['enrollment' => $enrollment->id]) }}"
                                    method="post" onsubmit="return confirm('Delete this enrollment?');">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-xs btn-error">
                                        <i class="fi fi-rr-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-6 text-center text-gray-500">No Enrollments</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination (works for both views) -->
        <div class="mt-4">
            <nav class="flex justify-center">
                {{ $enrollments->links() }}
            </nav>
        </div>
    </div>
</x-dashboard.registrar.base>
