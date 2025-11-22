<x-dashboard.registrar.base>
    <x-dashboard.page-title :title="__('Enrollment Details')" :back_url="route('registrar.enrollments.index')" />
    <x-notification-message />

    <div class="flex flex-col gap-6 p-4 sm:p-6 bg-white rounded-lg shadow-lg panel">
        <!-- Enrollment Header (responsive) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-stretch">
            <div class="col-span-1 md:col-span-2 flex items-center">
                <div class="w-full h-40 md:h-32 lg:h-40 rounded-lg shadow-md bg-accent flex items-center justify-center p-4">
                    <h1 class="text-2xl sm:text-3xl font-semibold text-white text-center break-words">
                        {{ $enrollment->name }}
                    </h1>
                </div>
            </div>

            <!-- Actions block -->
            <div class="col-span-1 flex flex-col items-end gap-2">
                <div class="w-full flex flex-col sm:flex-row sm:justify-end gap-2">
                    <a href="{{route('registrar.enrollments.print', ['id' => $enrollment->id])}}"
                       class="btn btn-ghost btn-sm w-full sm:w-auto gap-2 justify-center">
                        <i class="fi fi-rr-print"></i>
                        <span class="hidden sm:inline">Print</span>
                    </a>

                    @if ($enrollment->status !== 'closed')
                        <form action="{{ route('registrar.enrollments.close', ['enrollment' => $enrollment->id]) }}"
                              method="POST"
                              class="w-full sm:w-auto"
                              onsubmit="return confirm('Are you sure you want to close this enrollment period?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="gap-2 btn btn-error w-full sm:w-auto">
                                <i class="fi fi-rr-lock"></i>
                                <span class="hidden sm:inline">Close Enrollment</span>
                            </button>
                        </form>
                    @else
                        <span class="badge badge-error self-start sm:self-center">Enrollment Closed</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Enrollment Details (responsive grid) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <h2 class="text-base sm:text-lg font-semibold">Academic Year</h2>
                <p class="text-sm text-accent">{{ $enrollment->academicYear->year }}</p>
            </div>

            <div>
                <h2 class="text-base sm:text-lg font-semibold">Status</h2>
                <p class="mt-1">
                    <span class="px-2 py-1 rounded text-white text-sm
                        {{ $enrollment->status === 'active' ? 'bg-green-500' : 'bg-gray-400' }}">
                        {{ ucfirst($enrollment->status) }}
                    </span>
                </p>
            </div>

            <div>
                <h2 class="text-base sm:text-lg font-semibold">Start Date</h2>
                <p class="text-sm text-gray-700">{{ date('F d, Y', strtotime($enrollment->start_date)) }}</p>
            </div>

            <div>
                <h2 class="text-base sm:text-lg font-semibold">End Date</h2>
                <p class="text-sm text-gray-700">{{ date('F d, Y', strtotime($enrollment->end_date)) }}</p>
            </div>
        </div>

        <!-- Tabs -->
        <div x-data="{ activeTab: 'overview' }" class="w-full">
            <div class="flex flex-wrap gap-2 border-b pb-2">
                <button @click="activeTab = 'overview'"
                        :class="activeTab === 'overview' ? 'text-accent border-b-2 border-accent' : 'text-gray-600'"
                        class="px-3 py-2 text-sm">
                    Overview
                </button>
                <button @click="activeTab = 'description'"
                        :class="activeTab === 'description' ? 'text-accent border-b-2 border-accent' : 'text-gray-600'"
                        class="px-3 py-2 text-sm">
                    Description
                </button>
                <button @click="activeTab = 'enrollees'"
                        :class="activeTab === 'enrollees' ? 'text-accent border-b-2 border-accent' : 'text-gray-600'"
                        class="px-3 py-2 text-sm">
                    Enrollees ({{ $enrollees->total() }})
                </button>
            </div>

            <!-- Overview -->
            <div x-show="activeTab === 'overview'" class="mt-4">
                <div class="p-4 bg-gray-50 rounded-md">
                    <h3 class="font-semibold">Enrollment Overview</h3>
                    <p class="text-sm text-gray-700 mt-2">
                        This enrollment is linked to
                        <span class="text-accent font-medium">{{ $enrollment->academicYear->year }}</span>.
                    </p>
                </div>
            </div>

            <!-- Description -->
            <div x-show="activeTab === 'description'" class="mt-4">
                <div class="p-4 bg-gray-50 rounded-md">
                    <h3 class="font-semibold">Description</h3>
                    <p class="text-sm text-gray-700 mt-2">
                        {{ $enrollment->description ?: 'No description available.' }}
                    </p>
                </div>
            </div>

            <!-- Enrollees -->
            <div x-show="activeTab === 'enrollees'" class="mt-4">
                <div class="p-0">
                    <!-- Desktop / Tablet: table -->
                    <div class="hidden md:block">
                        <div class="overflow-x-auto bg-white rounded-md shadow-sm">
                            <table class="table w-full">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Email</th>
                                        <th>Name</th>
                                        <th>Grade Level</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($enrollees as $enrollee)
                                        <tr>
                                            <td></td>
                                            <td class="max-w-xs truncate">{{ $enrollee->email ?? 'N/A' }}</td>
                                            <td class="max-w-xs truncate">{{ $enrollee->last_name . ', ' . $enrollee->first_name . ' ' . $enrollee->middle_name }}</td>
                                            <td class="max-w-[140px] truncate">{{ $enrollee->grade_level }}</td>
                                            <td class="text-right">
                                                <a href="{{ route('registrar.enrollments.showEnrollee', ['id' => $enrollee->id]) }}"
                                                   class="btn btn-xs btn-accent">
                                                    <i class="fi fi-rr-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-6 text-gray-500">No Enrollees</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $enrollees->links() }}
                        </div>
                    </div>

                    <!-- Mobile: cards -->
                    <div class="space-y-3 md:hidden">
                        @forelse ($enrollees as $enrollee)
                            <div class="bg-white shadow-sm rounded-md p-3 flex flex-col sm:flex-row sm:items-center gap-3">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium truncate">{{ $enrollee->last_name . ', ' . $enrollee->first_name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ $enrollee->email ?? 'N/A' }}</p>
                                    <p class="text-xs text-gray-400 mt-1">Grade: {{ $enrollee->grade_level }}</p>
                                </div>

                                <div class="flex items-center gap-2">
                                    <a href="{{ route('registrar.enrollments.showEnrollee', ['id' => $enrollee->id]) }}"
                                       class="btn btn-xs btn-accent">
                                        <i class="fi fi-rr-eye"></i>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="bg-white rounded-md shadow-sm p-4 text-center text-gray-500">
                                No Enrollees
                            </div>
                        @endforelse

                        <div class="pt-2">
                            {{ $enrollees->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.registrar.base>
