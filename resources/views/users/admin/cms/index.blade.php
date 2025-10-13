<x-dashboard.admin.base>
    <div class="container p-6 mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Content Management</h1>
            <p class="text-gray-600">Manage your website content and appearance</p>
        </div>

        <!-- CMS Options Grid -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            <!-- Logo Management Card -->
            <div class="bg-white rounded-lg shadow-sm transition-shadow hover:shadow-md">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex justify-center items-center w-12 h-12 rounded-lg bg-primary/10">
                            <i class="text-2xl fi fi-rr-picture text-primary"></i>
                        </div>
                        <span class="badge badge-primary">Active</span>
                    </div>
                    <h3 class="mb-2 text-lg font-semibold">Logo Management</h3>
                    <p class="mb-4 text-gray-600">Update and manage your website logos, favicon, and footer logo.</p>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Main Logo</span>
                            @if($mainLogo = \App\Models\Logo::where('type', 'main')->where('is_active', true)->first())
                                <span class="text-success">Set</span>
                            @else
                                <span class="text-error">Not Set</span>
                            @endif
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Favicon</span>
                            @if($favicon = \App\Models\Logo::where('type', 'favicon')->where('is_active', true)->first())
                                <span class="text-success">Set</span>
                            @else
                                <span class="text-error">Not Set</span>
                            @endif
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Footer Logo</span>
                            @if($footerLogo = \App\Models\Logo::where('type', 'footer')->where('is_active', true)->first())
                                <span class="text-success">Set</span>
                            @else
                                <span class="text-error">Not Set</span>
                            @endif
                        </div>
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('admin.CMS.logos.index') }}" class="gap-2 w-full btn btn-primary">
                            <i class="fi fi-rr-edit"></i>
                            Manage Logos
                        </a>
                    </div>
                </div>
            </div>

            <!-- Gallery Management Card -->
            <div class="bg-white rounded-lg shadow-sm transition-shadow hover:shadow-md">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex justify-center items-center w-12 h-12 rounded-lg bg-accent/10">
                            <i class="text-2xl fi fi-rr-images text-accent"></i>
                        </div>
                        <span class="badge badge-accent">{{ \App\Models\Gallery::count() }} Images</span>
                    </div>
                    <h3 class="mb-2 text-lg font-semibold">Gallery Management</h3>
                    <p class="mb-4 text-gray-600">Upload and manage images for the website gallery section.</p>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Active Images</span>
                            <span class="text-success">{{ \App\Models\Gallery::where('is_active', true)->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Inactive Images</span>
                            <span class="text-error">{{ \App\Models\Gallery::where('is_active', false)->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Last Updated</span>
                            <span class="text-gray-500">
                                {{ \App\Models\Gallery::latest()->first()?->updated_at?->diffForHumans() ?? 'Never' }}
                            </span>
                        </div>
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('admin.CMS.gallery.index') }}" class="gap-2 w-full btn btn-accent">
                            <i class="fi fi-rr-edit"></i>
                            Manage Gallery
                        </a>
                    </div>
                </div>
            </div>

            <!-- About Us Management Card -->
            <div class="bg-white rounded-lg shadow-sm transition-shadow hover:shadow-md">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex justify-center items-center w-12 h-12 rounded-lg bg-secondary/10">
                            <i class="text-2xl fi fi-rr-building text-secondary"></i>
                        </div>
                        @if($aboutUs = \App\Models\AboutUs::first())
                            <span class="badge badge-secondary">Last updated {{ $aboutUs->updated_at->diffForHumans() }}</span>
                        @else
                            <span class="badge badge-ghost">Not Set</span>
                        @endif
                    </div>
                    <h3 class="mb-2 text-lg font-semibold">About Us Management</h3>
                    <p class="mb-4 text-gray-600">Update your organization's information, mission, and vision.</p>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Title</span>
                            @if($aboutUs?->title)
                                <span class="text-success">Set</span>
                            @else
                                <span class="text-error">Not Set</span>
                            @endif
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Description</span>
                            @if($aboutUs?->description)
                                <span class="text-success">Set</span>
                            @else
                                <span class="text-error">Not Set</span>
                            @endif
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Mission & Vision</span>
                            @if($aboutUs?->mission_and_vision)
                                <span class="text-success">Set</span>
                            @else
                                <span class="text-error">Not Set</span>
                            @endif
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Featured Image</span>
                            @if($aboutUs?->path)
                                <span class="text-success">Set</span>
                            @else
                                <span class="text-error">Not Set</span>
                            @endif
                        </div>
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('admin.CMS.about-us.index') }}" class="gap-2 w-full btn btn-secondary">
                            <i class="fi fi-rr-edit"></i>
                            Manage About Us
                        </a>
                    </div>
                </div>
            </div>

            <!-- Academic Programs Management Card -->
            <div class="bg-white rounded-lg shadow-sm transition-shadow hover:shadow-md">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex justify-center items-center w-12 h-12 rounded-lg bg-info/10">
                            <i class="text-2xl fi fi-rr-graduation-cap text-info"></i>
                        </div>
                        <span class="badge badge-info">{{ \App\Models\AcademicProgram::count() }} Programs</span>
                    </div>
                    <h3 class="mb-2 text-lg font-semibold">Academic Programs</h3>
                    <p class="mb-4 text-gray-600">Manage educational programs and courses offered.</p>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Active Programs</span>
                            <span class="text-success">
                                {{ \App\Models\AcademicProgram::where('is_active', true)->count() }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Inactive Programs</span>
                            <span class="text-error">
                                {{ \App\Models\AcademicProgram::where('is_active', false)->count() }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Last Updated</span>
                            <span class="text-gray-500">
                                {{ \App\Models\AcademicProgram::latest()->first()?->updated_at?->diffForHumans() ?? 'Never' }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Categories</span>
                            <span class="text-info">
                                {{ \App\Models\AcademicProgram::distinct('category')->count('category') }}
                            </span>
                        </div>
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('admin.CMS.programs.index') }}" class="gap-2 w-full btn btn-info">
                            <i class="fi fi-rr-edit"></i>
                            Manage Programs
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Us Management Card -->
            <div class="bg-white rounded-lg shadow-sm transition-shadow hover:shadow-md">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex justify-center items-center w-12 h-12 rounded-lg bg-success/10">
                            <i class="text-2xl fi fi-rr-address-book text-success"></i>
                        </div>
                        @if($contactInfo = \App\Models\ContactUs::first())
                            <span class="badge badge-success">Last updated {{ $contactInfo->updated_at->diffForHumans() }}</span>
                        @else
                            <span class="badge badge-ghost">Not Set</span>
                        @endif
                    </div>
                    <h3 class="mb-2 text-lg font-semibold">Contact Information</h3>
                    <p class="mb-4 text-gray-600">Manage contact details and information displayed on the website.</p>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Phone Number</span>
                            @if($contactInfo?->phone_number)
                                <span class="text-success">Set</span>
                            @else
                                <span class="text-error">Not Set</span>
                            @endif
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Email Address</span>
                            @if($contactInfo?->email_address)
                                <span class="text-success">Set</span>
                            @else
                                <span class="text-error">Not Set</span>
                            @endif
                        </div>
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('admin.CMS.contact.index') }}" class="gap-2 w-full btn btn-success">
                            <i class="fi fi-rr-edit"></i>
                            Manage Contact Info
                        </a>
                    </div>
                </div>
            </div>

            <!-- Placeholder for other CMS options -->
            {{-- <div class="bg-white rounded-lg shadow-sm opacity-50 transition-shadow hover:shadow-md">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex justify-center items-center w-12 h-12 bg-gray-100 rounded-lg">
                            <i class="text-2xl text-gray-400 fi fi-rr-layout-fluid"></i>
                        </div>
                        <span class="badge">Coming Soon</span>
                    </div>
                    <h3 class="mb-2 text-lg font-semibold">Banner Management</h3>
                    <p class="mb-4 text-gray-600">Manage website banners and hero sections.</p>
                    <div class="mt-6">
                        <button class="w-full btn btn-ghost" disabled>
                            Coming Soon
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm opacity-50 transition-shadow hover:shadow-md">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex justify-center items-center w-12 h-12 bg-gray-100 rounded-lg">
                            <i class="text-2xl text-gray-400 fi fi-rr-text"></i>
                        </div>
                        <span class="badge">Coming Soon</span>
                    </div>
                    <h3 class="mb-2 text-lg font-semibold">Content Blocks</h3>
                    <p class="mb-4 text-gray-600">Manage reusable content blocks and sections.</p>
                    <div class="mt-6">
                        <button class="w-full btn btn-ghost" disabled>
                            Coming Soon
                        </button>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</x-dashboard.admin.base>
