<x-dashboard.admin.base>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 p-4 sm:p-6">
        <!-- Header -->
        <div class="mb-4 sm:mb-6">
            <h1 class="text-base sm:text-2xl md:text-3xl font-bold text-gray-800">Content Management</h1>
            <p class="text-xs sm:text-sm text-gray-600 mt-1">Manage your website content and appearance</p>
        </div>

        <!-- Mobile: compact list (visible on xs only) -->
        <div class="space-y-3 sm:hidden">
            @php
                $logoSet = \App\Models\Logo::where('type', 'main')->where('is_active', true)->exists();
                $galleryCount = \App\Models\Gallery::count();
                $aboutSet = \App\Models\AboutUs::exists();
                $programCount = \App\Models\AcademicProgram::count();
                $contactSet = \App\Models\ContactUs::exists();
                $campusCount = \App\Models\Campus::count();
                $founderCount = \App\Models\Founder::count();
                $headerContentCount = \App\Models\HeaderContent::count();
                $activeHeaderContent = \App\Models\HeaderContent::where('is_active', true)->exists();
                $coreValueCount = \App\Models\CoreValue::count();
                $activeCoreValue = \App\Models\CoreValue::where('is_active', true)->exists();
            @endphp

            <!-- Header Content (Mobile) -->
            <a href="{{ route('admin.CMS.header-contents.index') }}"
                class="block bg-white rounded-lg shadow p-3 flex items-center gap-3">
                <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-purple-500/10 flex items-center justify-center">
                    <i class="fi fi-rr-layout-fluid text-xl text-purple-500"></i>
                </div>
                <div class="min-w-0">
                    <div class="font-medium text-sm text-gray-900 truncate">Header Content</div>
                    <div class="text-2xs text-gray-600 mt-0.5 break-words">Hero section and banner content</div>
                </div>
                <div class="ml-auto text-xs text-gray-500">
                    @if ($activeHeaderContent)
                    <span class="text-success">Active</span>@else<span class="text-error">No Active</span>
                    @endif
                </div>
            </a>

            <!-- Core Values (Mobile) -->
            <a href="{{ route('admin.CMS.core-values.index') }}"
                class="block bg-white rounded-lg shadow p-3 flex items-center gap-3">
                <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-indigo-500/10 flex items-center justify-center">
                    <i class="fi fi-rr-star text-xl text-indigo-500"></i>
                </div>
                <div class="min-w-0">
                    <div class="font-medium text-sm text-gray-900 truncate">Core Values</div>
                    <div class="text-2xs text-gray-600 mt-0.5 break-words">Manage core values and items</div>
                </div>
                <div class="ml-auto text-xs text-gray-500">
                    @if ($activeCoreValue)
                    <span class="text-success">Active</span>@else<span class="text-error">No Active</span>
                    @endif
                </div>
            </a>

            <a href="{{ route('admin.CMS.logos.index') }}"
                class="block bg-white rounded-lg shadow p-3 flex items-center gap-3">
                <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center">
                    <i class="fi fi-rr-picture text-xl text-primary"></i>
                </div>
                <div class="min-w-0">
                    <div class="font-medium text-sm text-gray-900 truncate">Logo Management</div>
                    <div class="text-2xs text-gray-600 mt-0.5 break-words">Logos, favicon and footer logo</div>
                </div>
                <div class="ml-auto text-xs text-gray-500">
                    @if ($logoSet)
                    <span class="text-success">Set</span>@else<span class="text-error">Not Set</span>
                    @endif
                </div>
            </a>

            <a href="{{ route('admin.CMS.gallery.index') }}"
                class="block bg-white rounded-lg shadow p-3 flex items-center gap-3">
                <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-accent/10 flex items-center justify-center">
                    <i class="fi fi-rr-images text-xl text-accent"></i>
                </div>
                <div class="min-w-0">
                    <div class="font-medium text-sm text-gray-900 truncate">Gallery Management</div>
                    <div class="text-2xs text-gray-600 mt-0.5 break-words">Upload and manage gallery images</div>
                </div>
                <div class="ml-auto text-xs text-gray-500">{{ $galleryCount }} Images</div>
            </a>

            <a href="{{ route('admin.CMS.about-us.index') }}"
                class="block bg-white rounded-lg shadow p-3 flex items-center gap-3">
                <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-secondary/10 flex items-center justify-center">
                    <i class="fi fi-rr-building text-xl text-secondary"></i>
                </div>
                <div class="min-w-0">
                    <div class="font-medium text-sm text-gray-900 truncate">About Us</div>
                    <div class="text-2xs text-gray-600 mt-0.5 break-words">Organization info, mission & vision</div>
                </div>
                <div class="ml-auto text-xs text-gray-500">
                    @if ($aboutSet)
                    <span class="text-success">Set</span>@else<span class="text-error">Not Set</span>
                    @endif
                </div>
            </a>

            <a href="{{ route('admin.CMS.programs.index') }}"
                class="block bg-white rounded-lg shadow p-3 flex items-center gap-3">
                <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-info/10 flex items-center justify-center">
                    <i class="fi fi-rr-graduation-cap text-xl text-info"></i>
                </div>
                <div class="min-w-0">
                    <div class="font-medium text-sm text-gray-900 truncate">Academic Programs</div>
                    <div class="text-2xs text-gray-600 mt-0.5 break-words">Programs and courses offered</div>
                </div>
                <div class="ml-auto text-xs text-gray-500">{{ $programCount }}</div>
            </a>

            <a href="{{ route('admin.CMS.contact.index') }}"
                class="block bg-white rounded-lg shadow p-3 flex items-center gap-3">
                <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-success/10 flex items-center justify-center">
                    <i class="fi fi-rr-address-book text-xl text-success"></i>
                </div>
                <div class="min-w-0">
                    <div class="font-medium text-sm text-gray-900 truncate">Contact Information</div>
                    <div class="text-2xs text-gray-600 mt-0.5 break-words">Phone, email and contact details</div>
                </div>
                <div class="ml-auto text-xs text-gray-500">
                    @if ($contactSet)
                    <span class="text-success">Set</span>@else<span class="text-error">Not Set</span>
                    @endif
                </div>
            </a>

            <a href="{{ route('admin.CMS.campuses.index') }}"
                class="block bg-white rounded-lg shadow p-3 flex items-center gap-3">
                <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-warning/10 flex items-center justify-center">
                    <i class="fi fi-rr-school text-xl text-warning"></i>
                </div>
                <div class="min-w-0">
                    <div class="font-medium text-sm text-gray-900 truncate">Campus Management</div>
                    <div class="text-2xs text-gray-600 mt-0.5 break-words">Manage campus list and details</div>
                </div>
                <div class="ml-auto text-xs text-gray-500">{{ $campusCount }}</div>
            </a>

            <!-- Founders (Mobile) -->
            <a href="{{ route('admin.CMS.founders.index') }}"
                class="block bg-white rounded-lg shadow p-3 flex items-center gap-3">
                <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-secondary/10 flex items-center justify-center">
                    <i class="fi fi-rr-user text-xl text-secondary"></i>
                </div>
                <div class="min-w-0">
                    <div class="font-medium text-sm text-gray-900 truncate">Founder Management</div>
                    <div class="text-2xs text-gray-600 mt-0.5 break-words">Manage founder profiles and images</div>
                </div>
                <div class="ml-auto text-xs text-gray-500">{{ $founderCount }}</div>
            </a>
        </div>

        <!-- Desktop & Tablet: grid (hidden on xs) -->
        <div class="hidden sm:grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <!-- Header Content Card -->
            <div class="bg-white rounded-lg shadow-sm transition-shadow hover:shadow-md flex flex-col">
                <div class="p-4 sm:p-6 flex-1 flex flex-col">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-4">
                        <div class="flex items-start gap-3 min-w-0">
                            <div
                                class="flex-shrink-0 w-12 h-12 rounded-lg bg-purple-500/10 flex items-center justify-center">
                                <i class="fi fi-rr-layout-fluid text-2xl text-purple-500"></i>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-sm sm:text-base font-semibold text-gray-900 truncate">Header Content
                                </h3>
                                <p class="text-2xs sm:text-xs text-gray-600 mt-1 whitespace-normal sm:truncate">Hero
                                    section and banner content</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-end">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold leading-none whitespace-nowrap bg-purple-500/10 text-purple-500">
                                {{ \App\Models\HeaderContent::count() }} Contents
                            </span>
                        </div>
                    </div>

                    <div class="space-y-2 text-sm text-gray-700 mt-2">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 truncate">Active Content</span>
                            @if ($activeContent = \App\Models\HeaderContent::where('is_active', true)->first())
                                <span class="text-success text-xs">{{ Str::limit($activeContent->title, 20) }}</span>
                            @else
                                <span class="text-error text-xs">None</span>
                            @endif
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 truncate">With Button</span>
                            <span
                                class="text-info text-xs">{{ \App\Models\HeaderContent::where('show_button', true)->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 truncate">Last Updated</span>
                            <span class="text-gray-500 text-xs">
                                {{ \App\Models\HeaderContent::latest()->first()?->updated_at?->diffForHumans() ?? 'Never' }}
                            </span>
                        </div>
                    </div>
                    <div class="mt-4 sm:mt-auto">
                        <a href="{{ route('admin.CMS.header-contents.index') }}"
                            class="btn gap-2 w-full sm:w-auto text-sm"
                            style="background-color: rgb(168 85 247); color: white;">
                            <i class="fi fi-rr-edit"></i>
                            <span class="truncate">Manage Header</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Core Values Card -->
            <div class="bg-white rounded-lg shadow-sm transition-shadow hover:shadow-md flex flex-col">
                <div class="p-4 sm:p-6 flex-1 flex flex-col">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-4">
                        <div class="flex items-start gap-3 min-w-0">
                            <div
                                class="flex-shrink-0 w-12 h-12 rounded-lg bg-indigo-500/10 flex items-center justify-center">
                                <i class="fi fi-rr-star text-2xl text-indigo-500"></i>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-sm sm:text-base font-semibold text-gray-900 truncate">Core Values
                                </h3>
                                <p class="text-2xs sm:text-xs text-gray-600 mt-1 whitespace-normal sm:truncate">
                                    Manage core values and items</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-end">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold leading-none whitespace-nowrap bg-indigo-500/10 text-indigo-500">
                                {{ \App\Models\CoreValue::count() }} Values
                            </span>
                        </div>
                    </div>
                    <div class="space-y-2 text-sm text-gray-700 mt-2">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 truncate">Active Core Value</span>
                            @if ($activeCoreValueData = \App\Models\CoreValue::where('is_active', true)->first())
                                <span
                                    class="text-success text-xs">{{ Str::limit($activeCoreValueData->title, 20) }}</span>
                            @else
                                <span class="text-error text-xs">None</span>
                            @endif
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 truncate">Total Items</span>
                            <span class="text-info text-xs">{{ \App\Models\CoreValueItem::count() }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 truncate">Last Updated</span>
                            <span class="text-gray-500 text-xs">

                                {{ \App\Models\CoreValue::latest()->first()?->updated_at?->diffForHumans() ?? 'Never' }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-4 sm:mt-auto">
                        <a href="{{ route('admin.CMS.core-values.index') }}" +
                            class="btn gap-2 w-full sm:w-auto text-sm" +
                            style="background-color: rgb(99 102 241); color: white;">
                            <i class="fi fi-rr-edit"></i>
                            <span class="truncate">Manage Core Values</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Logo Management Card -->
            <div class="bg-white rounded-lg shadow-sm transition-shadow hover:shadow-md flex flex-col">
                <div class="p-4 sm:p-6 flex-1 flex flex-col">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-4">
                        <div class="flex items-start gap-3 min-w-0">
                            <div
                                class="flex-shrink-0 w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center">
                                <i class="fi fi-rr-picture text-2xl text-primary"></i>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-sm sm:text-base font-semibold text-gray-900 truncate">Logo Management
                                </h3>
                                <p class="text-2xs sm:text-xs text-gray-600 mt-1 whitespace-normal sm:truncate">Logos,
                                    favicon and footer logo</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-end">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold leading-none whitespace-nowrap bg-primary/10 text-primary">
                                Active
                            </span>
                        </div>
                    </div>

                    <div class="space-y-2 text-sm text-gray-700 mt-2">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 truncate">Main Logo</span>
                            @if ($mainLogo = \App\Models\Logo::where('type', 'main')->where('is_active', true)->first())
                                <span class="text-success text-xs">Set</span>
                            @else
                                <span class="text-error text-xs">Not Set</span>
                            @endif
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 truncate">Favicon</span>
                            @if ($favicon = \App\Models\Logo::where('type', 'favicon')->where('is_active', true)->first())
                                <span class="text-success text-xs">Set</span>
                            @else
                                <span class="text-error text-xs">Not Set</span>
                            @endif
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 truncate">Footer Logo</span>
                            @if ($footerLogo = \App\Models\Logo::where('type', 'footer')->where('is_active', true)->first())
                                <span class="text-success text-xs">Set</span>
                            @else
                                <span class="text-error text-xs">Not Set</span>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4 sm:mt-auto">
                        <a href="{{ route('admin.CMS.logos.index') }}"
                            class="btn btn-primary gap-2 w-full sm:w-auto text-sm">
                            <i class="fi fi-rr-edit"></i>
                            <span class="truncate">Manage Logos</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Gallery Card -->
            <div class="bg-white rounded-lg shadow-sm transition-shadow hover:shadow-md flex flex-col">
                <div class="p-4 sm:p-6 flex-1 flex flex-col">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-4">
                        <div class="flex items-start gap-3 min-w-0">
                            <div
                                class="flex-shrink-0 w-12 h-12 rounded-lg bg-accent/10 flex items-center justify-center">
                                <i class="fi fi-rr-images text-2xl text-accent"></i>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-sm sm:text-base font-semibold text-gray-900 truncate">Gallery
                                    Management</h3>
                                <p class="text-2xs sm:text-xs text-gray-600 mt-1 whitespace-normal sm:truncate">Upload
                                    and manage gallery images</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-end">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold leading-none whitespace-nowrap bg-accent/10 text-accent">
                                {{ \App\Models\Gallery::count() }} Images
                            </span>
                        </div>
                    </div>

                    <div class="space-y-2 text-sm text-gray-700 mt-2">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 truncate">Active Images</span>
                            <span
                                class="text-success text-xs">{{ \App\Models\Gallery::where('is_active', true)->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 truncate">Inactive Images</span>
                            <span
                                class="text-error text-xs">{{ \App\Models\Gallery::where('is_active', false)->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 truncate">Last Updated</span>
                            <span class="text-gray-500 text-xs">
                                {{ \App\Models\Gallery::latest()->first()?->updated_at?->diffForHumans() ?? 'Never' }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-4 sm:mt-auto">
                        <a href="{{ route('admin.CMS.gallery.index') }}"
                            class="btn btn-accent gap-2 w-full sm:w-auto text-sm">
                            <i class="fi fi-rr-edit"></i>
                            <span class="truncate">Manage Gallery</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- About Us Card -->
            <div class="bg-white rounded-lg shadow-sm transition-shadow hover:shadow-md flex flex-col">
                <div class="p-4 sm:p-6 flex-1 flex flex-col">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-4">
                        <div class="flex items-start gap-3 min-w-0">
                            <div
                                class="flex-shrink-0 w-12 h-12 rounded-lg bg-secondary/10 flex items-center justify-center">
                                <i class="fi fi-rr-building text-2xl text-secondary"></i>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-sm sm:text-base font-semibold text-gray-900 truncate">About Us
                                    Management</h3>
                                <p class="text-2xs sm:text-xs text-gray-600 mt-1 whitespace-normal sm:truncate">
                                    Organization info, mission & vision</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-end">
                            @if ($aboutUs = \App\Models\AboutUs::first())
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold leading-none whitespace-nowrap bg-secondary/10 text-secondary max-w-[14rem] truncate">
                                    Last updated {{ $aboutUs->updated_at->diffForHumans() }}
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold leading-none whitespace-nowrap bg-gray-100 text-gray-700">
                                    Not Set
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-2 text-sm text-gray-700 mt-2">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 truncate">Title</span>
                            <span
                                class="{{ $aboutUs?->title ? 'text-success' : 'text-error' }} text-xs">{{ $aboutUs?->title ? 'Set' : 'Not Set' }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 truncate">Description</span>
                            <span
                                class="{{ $aboutUs?->description ? 'text-success' : 'text-error' }} text-xs">{{ $aboutUs?->description ? 'Set' : 'Not Set' }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 truncate">Mission & Vision</span>
                            <span
                                class="{{ $aboutUs?->mission_and_vision ? 'text-success' : 'text-error' }} text-xs">{{ $aboutUs?->mission_and_vision ? 'Set' : 'Not Set' }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 truncate">Featured Image</span>
                            <span
                                class="{{ $aboutUs?->path ? 'text-success' : 'text-error' }} text-xs">{{ $aboutUs?->path ? 'Set' : 'Not Set' }}</span>
                        </div>
                    </div>

                    <div class="mt-4 sm:mt-auto">
                        <a href="{{ route('admin.CMS.about-us.index') }}"
                            class="btn btn-secondary gap-2 w-full sm:w-auto text-sm">
                            <i class="fi fi-rr-edit"></i>
                            <span class="truncate">Manage About Us</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Academic Programs Card -->
            <div class="bg-white rounded-lg shadow-sm transition-shadow hover:shadow-md flex flex-col">
                <div class="p-4 sm:p-6 flex-1 flex flex-col">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-4">
                        <div class="flex items-start gap-3 min-w-0">
                            <div
                                class="flex-shrink-0 w-12 h-12 rounded-lg bg-info/10 flex items-center justify-center">
                                <i class="fi fi-rr-graduation-cap text-2xl text-info"></i>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-sm sm:text-base font-semibold text-gray-900 truncate">Academic Programs
                                </h3>
                                <p class="text-2xs sm:text-xs text-gray-600 mt-1 whitespace-normal sm:truncate">
                                    Programs and courses offered</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-end">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold leading-none whitespace-nowrap bg-info/10 text-info">
                                {{ \App\Models\AcademicProgram::count() }} Programs
                            </span>
                        </div>
                    </div>

                    <div class="space-y-2 text-sm text-gray-700 mt-2">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 truncate">Active Programs</span>
                            <span
                                class="text-success text-xs">{{ \App\Models\AcademicProgram::where('is_active', true)->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 truncate">Inactive Programs</span>
                            <span
                                class="text-error text-xs">{{ \App\Models\AcademicProgram::where('is_active', false)->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 truncate">Last Updated</span>
                            <span
                                class="text-gray-500 text-xs">{{ \App\Models\AcademicProgram::latest()->first()?->updated_at?->diffForHumans() ?? 'Never' }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 truncate">Categories</span>
                            <span
                                class="text-info text-xs">{{ \App\Models\AcademicProgram::distinct('category')->count('category') }}</span>
                        </div>
                    </div>

                    <div class="mt-4 sm:mt-auto">
                        <a href="{{ route('admin.CMS.programs.index') }}"
                            class="btn btn-info gap-2 w-full sm:w-auto text-sm">
                            <i class="fi fi-rr-edit"></i>
                            <span class="truncate">Manage Programs</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Card -->
            <div class="bg-white rounded-lg shadow-sm transition-shadow hover:shadow-md flex flex-col">
                <div class="p-4 sm:p-6 flex-1 flex flex-col">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-4">
                        <div class="flex items-start gap-3 min-w-0">
                            <div
                                class="flex-shrink-0 w-12 h-12 rounded-lg bg-success/10 flex items-center justify-center">
                                <i class="fi fi-rr-address-book text-2xl text-success"></i>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-sm sm:text-base font-semibold text-gray-900 truncate">Contact
                                    Information</h3>
                                <p class="text-2xs sm:text-xs text-gray-600 mt-1 whitespace-normal sm:truncate">Phone,
                                    email and contact details</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-end">
                            @if ($contactInfo = \App\Models\ContactUs::first())
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold leading-none whitespace-nowrap bg-success/10 text-success max-w-[14rem] truncate">
                                    Last updated {{ $contactInfo->updated_at->diffForHumans() }}
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold leading-none whitespace-nowrap bg-gray-100 text-gray-700">
                                    Not Set
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-2 text-sm text-gray-700 mt-2">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 truncate">Phone Number</span>
                            <span
                                class="{{ $contactInfo?->phone_number ? 'text-success' : 'text-error' }} text-xs">{{ $contactInfo?->phone_number ? 'Set' : 'Not Set' }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 truncate">Email Address</span>
                            <span
                                class="{{ $contactInfo?->email_address ? 'text-success' : 'text-error' }} text-xs">{{ $contactInfo?->email_address ? 'Set' : 'Not Set' }}</span>
                        </div>
                    </div>

                    <div class="mt-4 sm:mt-auto">
                        <a href="{{ route('admin.CMS.contact.index') }}"
                            class="btn btn-success gap-2 w-full sm:w-auto text-sm">
                            <i class="fi fi-rr-edit"></i>
                            <span class="truncate">Manage Contact Info</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Campuses Card -->
            <div class="bg-white rounded-lg shadow-sm transition-shadow hover:shadow-md flex flex-col">
                <div class="p-4 sm:p-6 flex-1 flex flex-col">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-4">
                        <div class="flex items-start gap-3 min-w-0">
                            <div
                                class="flex-shrink-0 w-12 h-12 rounded-lg bg-warning/10 flex items-center justify-center">
                                <i class="fi fi-rr-school text-2xl text-warning"></i>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-sm sm:text-base font-semibold text-gray-900 truncate">Campus Management
                                </h3>
                                <p class="text-2xs sm:text-xs text-gray-600 mt-1 whitespace-normal sm:truncate">Manage
                                    campus list and details</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-end">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold leading-none whitespace-nowrap bg-warning/10 text-warning">
                                {{ \App\Models\Campus::count() }} Campuses
                            </span>
                        </div>
                    </div>

                    <div class="space-y-2 text-sm text-gray-700 mt-2">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 truncate">With Images</span>
                            <span class="text-success text-xs">
                                {{ \App\Models\Campus::whereHas('image')->count() }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 truncate">Without Images</span>
                            <span class="text-error text-xs">
                                {{ \App\Models\Campus::count() - \App\Models\Campus::whereHas('image')->count() }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 truncate">Last Updated</span>
                            <span class="text-gray-500 text-xs">
                                {{ \App\Models\Campus::latest()->first()?->updated_at?->diffForHumans() ?? 'Never' }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-4 sm:mt-auto">
                        <a href="{{ route('admin.CMS.campuses.index') }}"
                            class="btn btn-warning gap-2 w-full sm:w-auto text-sm">
                            <i class="fi fi-rr-edit"></i>
                            <span class="truncate">Manage Campuses</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Founders Card -->
            <div class="bg-white rounded-lg shadow-sm transition-shadow hover:shadow-md flex flex-col">
                <div class="p-4 sm:p-6 flex-1 flex flex-col">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-4">
                        <div class="flex items-start gap-3 min-w-0">
                            <div
                                class="flex-shrink-0 w-12 h-12 rounded-lg bg-secondary/10 flex items-center justify-center">
                                <i class="fi fi-rr-user text-2xl text-secondary"></i>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-sm sm:text-base font-semibold text-gray-900 truncate">Founder
                                    Management</h3>
                                <p class="text-2xs sm:text-xs text-gray-600 mt-1 whitespace-normal sm:truncate">Manage
                                    founder profiles and images</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-end">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold leading-none whitespace-nowrap bg-secondary/10 text-secondary">
                                {{ \App\Models\Founder::count() }} Founders
                            </span>
                        </div>
                    </div>

                    <div class="space-y-2 text-sm text-gray-700 mt-2">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 truncate">Active</span>
                            <span
                                class="text-success text-xs">{{ \App\Models\Founder::where('is_active', true)->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 truncate">Inactive</span>
                            <span
                                class="text-error text-xs">{{ \App\Models\Founder::where('is_active', false)->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 truncate">Last Updated</span>
                            <span class="text-gray-500 text-xs">
                                {{ \App\Models\Founder::latest()->first()?->updated_at?->diffForHumans() ?? 'Never' }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-4 sm:mt-auto">
                        <a href="{{ route('admin.CMS.founders.index') }}"
                            class="btn btn-secondary gap-2 w-full sm:w-auto text-sm">
                            <i class="fi fi-rr-edit"></i>
                            <span class="truncate">Manage Founders</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.admin.base>
