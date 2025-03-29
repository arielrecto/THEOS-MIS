<x-landing-page.base>
    <!-- Hero Section -->
    <div class="bg-accent/5 py-16">
        <div class="container mx-auto px-6">
            <div class="max-w-3xl">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Career Opportunities</h1>
                <p class="text-lg text-gray-600">Join our team and make a difference in shaping the future of education. Explore exciting opportunities that await you.</p>
            </div>
        </div>
    </div>

    <!-- Search & Filter Section -->
    <div class="border-b bg-white sticky top-0 z-10">
        <div class="container mx-auto px-6 py-4">
            <form class="space-y-4 md:space-y-0 md:flex md:items-center md:gap-4">
                <!-- Search Bar -->
                <div class="form-control flex-1">
                    <div class="flex items-center gap-2">
                        <span class="btn btn-square btn-ghost">
                            <i class="fi fi-rr-search text-gray-500"></i>
                        </span>
                        <input type="text"
                               name="search"
                               class="input input-bordered w-full focus:outline-none"
                               placeholder="Search by position title or keywords..."
                               value="{{ request('search') }}">
                    </div>
                </div>

                <!-- Filters -->
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                    <!-- Department Filter -->
                    <div class="form-control">
                        <div class="join">
                            <span class="btn join-item btn-ghost">
                                <i class="fi fi-rr-building text-gray-500"></i>
                            </span>
                            <select name="department"
                                    class="select select-bordered join-item min-w-[200px]">
                                <option value="">All Departments</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}"
                                            {{ request('department') == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Employment Type Filter -->
                    <div class="form-control">
                        <div class="join">
                            <span class="btn join-item btn-ghost">
                                <i class="fi fi-rr-briefcase text-gray-500"></i>
                            </span>
                            <select name="type"
                                    class="select select-bordered join-item min-w-[180px]">
                                <option value="">All Types</option>
                                <option value="full-time" {{ request('type') === 'full-time' ? 'selected' : '' }}>
                                    Full Time
                                </option>
                                <option value="part-time" {{ request('type') === 'part-time' ? 'selected' : '' }}>
                                    Part Time
                                </option>
                                <option value="contract" {{ request('type') === 'contract' ? 'selected' : '' }}>
                                    Contract
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Filter Button -->
                    <button type="submit"
                            class="btn btn-accent w-full sm:w-auto">
                        <i class="fi fi-rr-filter mr-2"></i>
                        Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Job Listings -->
    <div class="container mx-auto px-6 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @forelse($jobs as $job)
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow border p-6">
                    <div class="flex items-start justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">{{ $job->name }}</h2>
                            <p class="text-gray-600">{{ $job->department->name }}</p>
                        </div>
                        <span class="badge badge-accent">{{ ucfirst($job->type) }}</span>
                    </div>

                    <div class="mt-4 space-y-2">
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <i class="fi fi-rr-marker"></i>
                            <span>On-site</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <i class="fi fi-rr-coins"></i>
                            <span>₱{{ number_format($job->min_salary) }} - ₱{{ number_format($job->max_salary) }}</span>
                        </div>
                    </div>

                    @if($job->description)
                        <p class="mt-4 text-sm text-gray-600">
                            {{ Str::limit($job->description, 150) }}
                        </p>
                    @endif

                    <div class="mt-6 pt-4 border-t flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            Posted {{ $job->created_at->diffForHumans() }}
                        </div>
                        <a href="{{route('job-opportunities.show', ['position' => $job->id])}}"
                           class="btn btn-accent btn-sm">
                            View Details
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="text-center py-12">
                        <div class="flex flex-col items-center justify-center text-gray-500">
                            <i class="fi fi-rr-briefcase text-4xl mb-3"></i>
                            <h3 class="text-xl font-medium mb-2">No Open Positions</h3>
                            <p class="text-gray-500">
                                We don't have any open positions right now. Please check back later.
                            </p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $jobs->links() }}
        </div>
    </div>
</x-landing-page.base>
