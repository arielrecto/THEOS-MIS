<x-landing-page.base>
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto">
                <x-dashboard.page-title :title="__('Student Enrollment Form')" back_url="/" />
                <x-notification-message />

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <h3 class="text-sm font-medium text-red-800 mb-2">Please correct the following errors:</h3>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="text-sm text-red-600">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('enrollment.store') }}" method="POST" class="space-y-8">
                    @csrf
                    <input type="hidden" name="academic_year_id" value="{{ $academicYear->id }}">
                    <input type="hidden" name="enrollment_id" value="{{ $enrollmentID }}">

                    <!-- Enrollment Details Card -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <div class="flex items-center gap-2 text-lg font-semibold text-gray-800 mb-6">
                            <i class="fi fi-rr-graduation-cap"></i>
                            <span>Enrollment Details</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">School Year</span>
                                </label>
                                <input type="text"
                                       class="input input-bordered bg-gray-50"
                                       name="school_year"
                                       value="{{ date('Y', strtotime($academicYear->start_date)) }} - {{ date('Y', strtotime($academicYear->end_date)) }}"
                                       readonly>
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Grade Level to Enroll</span>
                                </label>
                                <select name="grade_level" class="select select-bordered @error('grade_level') select-error @enderror">
                                    <option value="" disabled selected>Select Grade Level</option>
                                    @foreach(range(1, 12) as $grade)
                                        <option value="{{ $grade }}" {{ old('grade_level') == $grade ? 'selected' : '' }}>
                                            Grade {{ $grade }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-control md:col-span-2">
                                <label class="label">
                                    <span class="label-text font-medium">Returning (Balik-Aral) Learner?</span>
                                </label>
                                <div class="flex gap-6">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="balik_aral" value="yes" class="radio radio-accent" {{ old('balik_aral') == 'yes' ? 'checked' : '' }}>
                                        <span>Yes</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="balik_aral" value="no" class="radio radio-accent" {{ old('balik_aral') == 'no' ? 'checked' : '' }}>
                                        <span>No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Student Information Card -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <div class="flex items-center gap-2 text-lg font-semibold text-gray-800 mb-6">
                            <i class="fi fi-rr-user"></i>
                            <span>Student Information</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Last Name</span>
                                </label>
                                <input type="text"
                                       name="last_name"
                                       value="{{ old('last_name') }}"
                                       class="input input-bordered @error('last_name') input-error @enderror"
                                       required>
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">First Name</span>
                                </label>
                                <input type="text"
                                       name="first_name"
                                       value="{{ old('first_name') }}"
                                       class="input input-bordered @error('first_name') input-error @enderror"
                                       required>
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Middle Name</span>
                                </label>
                                <input type="text"
                                       name="middle_name"
                                       value="{{ old('middle_name') }}"
                                       class="input input-bordered">
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Extension Name</span>
                                    <span class="label-text-alt text-gray-500">(Jr., III, etc.)</span>
                                </label>
                                <input type="text"
                                       name="extension_name"
                                       value="{{ old('extension_name') }}"
                                       class="input input-bordered">
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Date of Birth</span>
                                </label>
                                <input type="date"
                                       name="birthdate"
                                       value="{{ old('birthdate') }}"
                                       class="input input-bordered @error('birthdate') input-error @enderror"
                                       required>
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Place of Birth</span>
                                </label>
                                <input type="text"
                                       name="birthplace"
                                       value="{{ old('birthplace') }}"
                                       class="input input-bordered @error('birthplace') input-error @enderror"
                                       required>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <div class="flex items-center gap-2 text-lg font-semibold text-gray-800 mb-6">
                            <i class="fi fi-rr-home"></i>
                            <span>Address Information</span>
                        </div>

                        <!-- Current Address -->
                        <h3 class="text-sm font-medium text-gray-500 mb-4">Current Address</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <input type="text" name="house_no" placeholder="House No." class="input input-bordered">
                            <input type="text" name="street" placeholder="Street" class="input input-bordered">
                            <input type="text" name="barangay" placeholder="Barangay" class="input input-bordered">
                            <input type="text" name="city" placeholder="Municipality/City" class="input input-bordered">
                            <input type="text" name="province" placeholder="Province" class="input input-bordered">
                            <input type="text" name="zip_code" placeholder="Zip Code" class="input input-bordered">
                        </div>

                        <!-- Permanent Address -->
                        <h3 class="text-sm font-medium text-gray-500 mb-4">Permanent Address</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <input type="text" name="perm_house_no" placeholder="House No." class="input input-bordered">
                            <input type="text" name="perm_street" placeholder="Street" class="input input-bordered">
                            <input type="text" name="perm_barangay" placeholder="Barangay" class="input input-bordered">
                            <input type="text" name="perm_city" placeholder="Municipality/City" class="input input-bordered">
                            <input type="text" name="perm_province" placeholder="Province" class="input input-bordered">
                            <input type="text" name="perm_zip_code" placeholder="Zip Code" class="input input-bordered">
                        </div>
                    </div>

                    <!-- Parent/Guardian Information -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <div class="flex items-center gap-2 text-lg font-semibold text-gray-800 mb-6">
                            <i class="fi fi-rr-user"></i>
                            <span>Parent/Guardian Information</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Full Name</span>
                                </label>
                                <input type="text"
                                       name="parent_name"
                                       value="{{ old('parent_name') }}"
                                       class="input input-bordered @error('parent_name') input-error @enderror"
                                       required>
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Relationship to Student</span>
                                </label>
                                <input type="text"
                                       name="relationship"
                                       value="{{ old('relationship') }}"
                                       class="input input-bordered @error('relationship') input-error @enderror"
                                       required>
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Contact Number</span>
                                </label>
                                <input type="text"
                                       name="contact_number"
                                       value="{{ old('contact_number') }}"
                                       class="input input-bordered @error('contact_number') input-error @enderror"
                                       required>
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Occupation</span>
                                </label>
                                <input type="text"
                                       name="occupation"
                                       value="{{ old('occupation') }}"
                                       class="input input-bordered">
                            </div>
                        </div>
                    </div>

                    <!-- Senior High School Preferences -->
                    {{-- <div class="bg-white rounded-lg shadow-lg p-6">
                        <div class="flex items-center gap-2 text-lg font-semibold text-gray-800 mb-6">
                            <i class="fi fi-rr-graduation-cap"></i>
                            <span>For Learning in Senior High School</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Preferred Track</span>
                                </label>
                                <select name="preferred_track" class="select select-bordered @error('preferred_track') select-error @enderror">
                                    <option value="" disabled selected>Select Track</option>
                                    <option value="academic" {{ old('preferred_track') == 'academic' ? 'selected' : '' }}>Academic</option>
                                    <option value="technical and vocational and livelihood" {{ old('preferred_track') == 'technical and vocational and livelihood' ? 'selected' : '' }}>Technical-Vocational-Livelihood (TVL)</option>
                                    <option value="arts and design" {{ old('preferred_track') == 'arts and design' ? 'selected' : '' }}>Arts and Design</option>
                                    <option value="sports" {{ old('preferred_track') == 'sports' ? 'selected' : '' }}>Sports</option>
                                </select>
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Preferred Strand</span>
                                </label>
                                <select name="preferred_strand" class="select select-bordered @error('preferred_strand') select-error @enderror">
                                    <option value="" disabled selected>Select Strand</option>
                                    <option value="general academic" {{ old('preferred_strand') == 'general academic' ? 'selected' : '' }}>General Academic</option>
                                    <option value="science, technology, engineering, and mathematics" {{ old('preferred_strand') == 'science, technology, engineering, and mathematics' ? 'selected' : '' }}>Science, Technology, Engineering, and Mathematics (STEM)</option>
                                    <option value="accountancy, business, and management" {{ old('preferred_strand') == 'accountancy, business, and management' ? 'selected' : '' }}>Accountancy, Business, and Management (ABM)</option>
                                    <option value="information and communication technology" {{ old('preferred_strand') == 'information and communication technology' ? 'selected' : '' }}>Information and Communication Technology (ICT)</option>
                                </select>
                            </div>
                        </div>
                    </div> --}}

                    <!-- Contact Information -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <div class="flex items-center gap-2 text-lg font-semibold text-gray-800 mb-6">
                            <i class="fi fi-rr-envelope"></i>
                            <span>Contact Information</span>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Email Address</span>
                                <span class="label-text-alt text-gray-500">For verification purposes only</span>
                            </label>
                            <input type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   class="input input-bordered @error('email') input-error @enderror"
                                   required>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4">
                        <a href="/" class="btn btn-ghost">Cancel</a>
                        <button type="submit" class="btn btn-accent gap-2">
                            <i class="fi fi-rr-check"></i>
                            Submit Enrollment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-landing-page.base>
