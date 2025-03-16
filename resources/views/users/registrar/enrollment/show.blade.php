<x-dashboard.registrar.base>
    <x-dashboard.page-title
        :title="__('Enrollment Details')"
        :back_url="route('registrar.enrollments.index')"
    />
    <x-notification-message />

    <div class="flex flex-col gap-6 p-6 bg-white rounded-lg shadow-lg panel">
        <!-- Enrollment Header -->
        <div class="flex justify-center items-center w-full h-40 rounded-lg shadow-md bg-accent">
            <h1 class="text-3xl font-semibold text-white capitalize">
                {{ $enrollment->name }}
            </h1>
        </div>

        <!-- Enrollment Details -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div>
                <h1 class="text-lg font-semibold">Academic Year:
                    <span class="text-accent">{{ $enrollment->academicYear->year }}</span>
                </h1>
            </div>
            <div>
                <h1 class="text-lg font-semibold">Status:
                    <span class="px-2 py-1 rounded text-white
                        {{ $enrollment->status === 'active' ? 'bg-green-500' : 'bg-gray-400' }}">
                        {{ ucfirst($enrollment->status) }}
                    </span>
                </h1>
            </div>
            <div>
                <h1 class="text-lg font-semibold">Start Date:
                    <span class="text-gray-700">{{ date('F d, Y', strtotime($enrollment->start_date)) }}</span>
                </h1>
            </div>
            <div>
                <h1 class="text-lg font-semibold">End Date:
                    <span class="text-gray-700">{{ date('F d, Y', strtotime($enrollment->end_date)) }}</span>
                </h1>
            </div>
        </div>

        <!-- Tab Component -->
        <div x-data="{ activeTab: 'overview', description: 'description', enrollees: 'enrollees' }">
            <div class="flex pb-2 space-x-4 border-b">
                <button @click="activeTab = 'overview'"
                    :class="{'text-accent border-b-2 border-accent': activeTab === 'overview'}"
                    class="px-4 py-2">
                    Overview
                </button>
                <button @click="activeTab = 'description'"
                    :class="{'text-accent border-b-2 border-accent': activeTab === 'description'}"
                    class="px-4 py-2">
                    Description
                </button>
                <button @click="activeTab = 'enrollees'"
                    :class="{'text-accent border-b-2 border-accent': activeTab === 'enrollees'}"
                    class="px-4 py-2">
                    Enrollees
                </button>
            </div>

            <!-- Overview Tab -->
            <div x-show="activeTab === 'overview'">
                <div class="p-4 bg-gray-100 rounded-lg">
                    <h2 class="text-lg font-semibold">Enrollment Overview</h2>
                    <p class="text-gray-700">This enrollment is linked to
                        <span class="text-accent">{{ $enrollment->academicYear->year }}</span>.
                    </p>
                </div>
            </div>

            <!-- Description Tab -->
            <div x-show="activeTab === 'description'">
                <div class="p-4 bg-gray-100 rounded-lg">
                    <h2 class="text-lg font-semibold">Description</h2>
                    <p class="text-gray-700">
                        {{ $enrollment->description ?: 'No description available.' }}
                    </p>
                </div>
            </div>

            <!-- Enrollees Tab -->
            <div x-show="activeTab === 'enrollees'">
                <div class="p-4 bg-gray-100 rounded-lg">
                    <h2 class="text-lg font-semibold">Enrollees</h2>
                    <table class="table">
                        <!-- head -->
                        <thead>
                            <tr>
                                <th></th>
                                <th>Email</th>
                                <th>Name</th>
                                <th>Grade Level</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>


                            @forelse ($enrollees as $enrollee)
                                <!-- row 1 -->
                                <tr>
                                    <th></th>
                                    <td>{{ $enrollee->email ?? 'N/A' }}</td>
                                    <td>{{ $enrollee->last_name . ', ' . $enrollee->first_name . ' ' . $enrollee->middle_name }}</td>
                                    <td>{{ $enrollee->grade_level }}</td>
                                    <td class="flex gap-5 items-center">
                                        <a href="{{route('registrar.enrollments.showEnrollee', ['id' => $enrollee->id])}}"
                                            class="btn btn-xs btn-accent">
                                            <i class="fi fi-rr-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <!-- row 1 -->
                                <tr>
                                    <th>No Enrollees</th>

                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $enrollees->links() }}
                </div>
            </div>
        </div>
    </div>
</x-dashboard.teacher.base>
