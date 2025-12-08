<x-dashboard.admin.base>
    <div class="w-full">
        <!-- Header -->
        <div class="mb-6 px-4 sm:px-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="min-w-0">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 break-words">Program Details</h1>
                    <p class="text-sm sm:text-base text-gray-600 mt-1">View academic program information</p>
                </div>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 w-full sm:w-auto">
                    <a href="{{ route('admin.CMS.programs.index') }}" class="btn btn-ghost btn-sm sm:btn-md gap-2 w-full sm:w-auto justify-center order-2 sm:order-1">
                        <i class="fi fi-rr-arrow-left"></i>
                        <span class="text-xs sm:text-sm">Back</span>
                    </a>
                    <form action="{{ route('admin.CMS.programs.toggle', $program) }}"
                          method="POST"
                          class="w-full sm:w-auto order-1 sm:order-2">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                class="btn btn-sm sm:btn-md w-full sm:w-auto {{ $program->is_active ? 'btn-success' : 'btn-ghost' }}"
                                title="{{ $program->is_active ? 'Set Inactive' : 'Set Active' }}">
                            <i class="fi fi-rr-{{ $program->is_active ? 'check' : 'circle' }}"></i>
                            <span class="text-xs sm:text-sm">{{ $program->is_active ? 'Active' : 'Inactive' }}</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="mx-4 sm:mx-6 bg-white rounded-lg shadow-sm overflow-hidden">
            <!-- Image -->
            <div class="aspect-video relative w-full bg-gray-100">
                <img src="{{ Storage::url($program->path) }}"
                     alt="{{ $program->title }}"
                     class="w-full h-full object-cover">
            </div>

            <!-- Details -->
            <div class="p-4 sm:p-6 space-y-4">
                <!-- Title & Badge -->
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                    <h2 class="text-xl sm:text-2xl font-bold break-words pr-4">{{ $program->title }}</h2>
                    <span class="badge badge-lg text-xs sm:text-sm self-start flex-shrink-0">{{ $program->category }}</span>
                </div>

                <!-- Description -->
                <div class="border-t pt-4">
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Description</h3>
                    <p class="text-sm sm:text-base text-gray-700 break-words leading-relaxed">{{ $program->description }}</p>
                </div>

                <!-- Meta Information -->
                <div class="border-t pt-4">
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">Information</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                        <div class="flex items-start gap-3 bg-gray-50 p-3 rounded">
                            <i class="fi fi-rr-calendar flex-shrink-0 text-accent mt-0.5"></i>
                            <div class="min-w-0">
                                <p class="text-xs text-gray-500">Created</p>
                                <p class="font-medium text-gray-800 break-words">{{ $program->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 bg-gray-50 p-3 rounded">
                            <i class="fi fi-rr-clock flex-shrink-0 text-accent mt-0.5"></i>
                            <div class="min-w-0">
                                <p class="text-xs text-gray-500">Updated</p>
                                <p class="font-medium text-gray-800 break-words">{{ $program->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="border-t pt-4 flex flex-col sm:flex-row gap-2 w-full">
                    <a href="{{ route('admin.CMS.programs.edit', $program) }}" class="btn btn-accent btn-sm sm:btn-md w-full sm:w-auto justify-center gap-2">
                        <i class="fi fi-rr-edit"></i>
                        <span class="text-xs sm:text-sm">Edit Program</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.admin.base>
