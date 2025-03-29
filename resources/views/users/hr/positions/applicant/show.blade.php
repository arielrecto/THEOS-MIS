<x-dashboard.hr.base>
    <div class="container mx-auto p-6">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
                <a href="{{ route('hr.dashboard') }}" class="hover:text-accent">Dashboard</a>
                <i class="fi fi-rr-angle-right"></i>
                <a href="{{ route('hr.applicants.index') }}" class="hover:text-accent">Applications</a>
                <i class="fi fi-rr-angle-right"></i>
                <span>{{ $applicant->name }}</span>
            </div>

            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">{{ $applicant->name }}</h1>
                </div>
                <div class="flex items-center gap-2">
                    <button class="btn btn-ghost btn-sm gap-2" onclick="window.print()">
                        <i class="fi fi-rr-print"></i>
                        Print
                    </button>
                    @if($applicant->resume)
                        <a href="#"
                           class="btn btn-ghost btn-sm gap-2">
                            <i class="fi fi-rr-download"></i>
                            Download Resume
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Applicant Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Info Card -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Applicant Information</h2>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm font-medium text-gray-600">Full Name</label>
                            <p class="mt-1">{{ $applicant->name }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Email Address</label>
                            <p class="mt-1">{{ $applicant->email }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Phone Number</label>
                            <p class="mt-1">{{ $applicant->phone }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Applied On</label>
                            <p class="mt-1">{{ $applicant->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                        @if($applicant->linkedin)
                            <div>
                                <label class="text-sm font-medium text-gray-600">LinkedIn Profile</label>
                                <p class="mt-1">
                                    <a href="{{ $applicant->linkedin }}" target="_blank" class="link link-accent">
                                        View Profile <i class="fi fi-rr-arrow-up-right-from-square ml-1"></i>
                                    </a>
                                </p>
                            </div>
                        @endif
                        @if($applicant->portfolio)
                            <div>
                                <label class="text-sm font-medium text-gray-600">Portfolio</label>
                                <p class="mt-1">
                                    <a href="{{ $applicant->portfolio }}" target="_blank" class="link link-accent">
                                        View Portfolio <i class="fi fi-rr-arrow-up-right-from-square ml-1"></i>
                                    </a>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Cover Letter -->
                @if($applicant->cover_letter)
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Cover Letter</h2>
                        <div class="prose max-w-none">
                            {{ $applicant->cover_letter }}
                        </div>
                    </div>
                @endif

                <!-- Application Timeline -->
                {{-- <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Application Timeline</h2>
                    <div class="space-y-4">
                        @foreach($applicant->statusHistory as $history)
                            <div class="flex items-start gap-4">
                                <div class="w-8 h-8 rounded-full bg-accent/10 flex items-center justify-center">
                                    <i class="fi fi-rr-time-forward text-accent"></i>
                                </div>
                                <div>
                                    <p class="font-medium">{{ ucfirst($history->status) }}</p>
                                    <p class="text-sm text-gray-600">{{ $history->created_at->format('M d, Y h:i A') }}</p>
                                    @if($history->notes)
                                        <p class="text-sm text-gray-600 mt-1">{{ $history->notes }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div> --}}
            </div>

            <!-- Application Status -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Status Card -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Application Status</h2>

                    <div class="space-y-6">
                        <div>
                            <label class="text-sm font-medium text-gray-600">Current Stage</label>
                            <div class="mt-2">
                                <span class="badge {{
                                    $applicant->status === 'new' ? 'badge-neutral' :
                                    ($applicant->status === 'screening' ? 'badge-info' :
                                    ($applicant->status === 'interview' ? 'badge-warning' :
                                    ($applicant->status === 'hired' ? 'badge-success' : 'badge-error')))
                                }} badge-lg">
                                    {{ ucfirst($applicant->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="pt-6 border-t">
                            <label class="text-sm font-medium text-gray-600 mb-2 block">Update Status</label>
                            <form action="{{ route('hr.applicants.update-status', $applicant) }}"
                                  method="POST"
                                  class="space-y-4">
                                @csrf
                                @method('PUT')
                                <select name="status" class="select select-bordered w-full">
                                    <option value="new" {{ $applicant->status === 'new' ? 'selected' : '' }}>New</option>
                                    <option value="screening" {{ $applicant->status === 'screening' ? 'selected' : '' }}>Screening</option>
                                    <option value="interview" {{ $applicant->status === 'interview' ? 'selected' : '' }}>Interview</option>
                                    <option value="hired" {{ $applicant->status === 'hired' ? 'selected' : '' }}>Hired</option>
                                    <option value="rejected" {{ $applicant->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>

                                <textarea name="notes"
                                          class="textarea textarea-bordered w-full"
                                          placeholder="Add notes about this status change..."></textarea>

                                <button type="submit" class="btn btn-accent w-full">
                                    Update Status
                                </button>
                            </form>
                        </div>
                    </div>
                </div>


                @dd( $applicant->position)
                <!-- Position Details -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Position Details</h2>

                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-medium text-gray-600">Department</label>
                            <p class="mt-1">{{ $applicant->position->department->name }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Employment Type</label>
                            <p class="mt-1">{{ ucfirst($applicant->position->type) }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Salary Range</label>
                            <p class="mt-1">₱{{ number_format($applicant->position->min_salary) }} - ₱{{ number_format($applicant->position->max_salary) }}</p>
                        </div>

                        <a href="{{ route('hr.positions.show', $applicant->position) }}"
                           class="btn btn-ghost btn-sm w-full">
                            View Full Position Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.hr.base>
