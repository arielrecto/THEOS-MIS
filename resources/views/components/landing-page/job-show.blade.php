<x-landing-page.base>
    <!-- Job Details Section -->
    <x-notification-message/>
    <div class="py-16 bg-accent/5">
        <div class="container px-6 mx-auto">
            <div class="max-w-3xl">
                <div class="flex gap-2 items-center mb-4 text-sm text-gray-600">
                    <a href="{{ route('job-opportunities') }}" class="hover:text-accent">Careers</a>
                    <i class="fi fi-rr-angle-right"></i>
                    <span>{{ $position->name }}</span>
                </div>
                <h1 class="mb-4 text-4xl font-bold text-gray-900">{{ $position->name }}</h1>
                <div class="flex gap-4 items-center text-gray-600">
                    <div class="flex gap-2 items-center">
                        <i class="fi fi-rr-building"></i>
                        <span>{{ $position->department->name }}</span>
                    </div>
                    <div class="flex gap-2 items-center">
                        <i class="fi fi-rr-briefcase"></i>
                        <span>{{ ucfirst($position->type) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container px-6 py-12 mx-auto bg-gray-100 rounded-lg">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            <!-- Job Description -->
            <div class="space-y-8 lg:col-span-2">
                <div class="max-w-none prose">
                    <h2 class="text-2xl font-semibold text-gray-800">Job Description</h2>
                    <div class="mt-4 whitespace-pre-line">{{ $position->description }}</div>
                </div>

                <!-- Salary Range -->
                <div>
                    <h2 class="mb-4 text-2xl font-semibold text-gray-800">Salary Range</h2>
                    <div class="p-6 rounded-lg bg-accent/5">
                        <p class="text-2xl font-bold text-accent">
                            ₱{{ number_format($position->min_salary) }} - ₱{{ number_format($position->max_salary) }}
                        </p>
                        <p class="mt-1 text-gray-600">Per month</p>
                    </div>
                </div>
            </div>

            <!-- Application Form -->
            <div class="lg:col-span-1">
                <div class="sticky top-6 p-6 bg-white rounded-lg shadow-sm">
                    <h2 class="mb-6 text-xl font-semibold text-gray-800">Apply for this Position</h2>

                    <form action="{{ route('job-opportunities.apply', $position) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-4">
                            <!-- Name -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Full Name</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <input type="text"
                                       name="name"
                                       class="input input-bordered @error('name') input-error @enderror"
                                       value="{{ old('name') }}"
                                       required>
                                @error('name')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Email Address</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <input type="email"
                                       name="email"
                                       class="input input-bordered @error('email') input-error @enderror"
                                       value="{{ old('email') }}"
                                       required>
                                @error('email')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Phone Number</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <input type="tel"
                                       name="phone"
                                       class="input input-bordered @error('phone') input-error @enderror"
                                       value="{{ old('phone') }}"
                                       pattern="[0-9]{11}"
                                       title="Please enter exactly 11 digits (e.g., 09123456789)"
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11);"
                                       required>
                                @error('phone')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <!-- LinkedIn -->
                            {{-- <div class="form-control">
                                <label class="label">
                                    <span class="label-text">LinkedIn Profile</span>
                                </label>
                                <input type="url"
                                       name="linkedin"
                                       class="input input-bordered @error('linkedin') input-error @enderror"
                                       value="{{ old('linkedin') }}">
                                @error('linkedin')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div> --}}

                            <!-- Portfolio -->
                            {{-- <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Portfolio URL</span>
                                </label>
                                <input type="url"
                                       name="portfolio"
                                       class="input input-bordered @error('portfolio') input-error @enderror"
                                       value="{{ old('portfolio') }}">
                                @error('portfolio')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div> --}}

                            <!-- Resume -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Resume/CV</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <input type="file"
                                       name="resume"
                                       class="file-input file-input-bordered w-full @error('resume') input-error @enderror"
                                       accept=".pdf,.doc,.docx"
                                       required>
                                @error('resume')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <!-- Cover Letter -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Cover Letter</span>
                                </label>
                                <textarea name="cover_letter"
                                          class="textarea textarea-bordered h-32 @error('cover_letter') textarea-error @enderror"
                                          placeholder="Tell us why you're interested in this position...">{{ old('cover_letter') }}</textarea>
                                @error('cover_letter')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <button type="submit" class="w-full btn btn-accent">
                                Submit Application
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-landing-page.base>
