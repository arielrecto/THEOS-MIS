<x-landing-page.base>
    <div class="py-12 min-h-screen bg-gray-50">
        <div class="container px-4 mx-auto">
            <div class="mx-auto max-w-5xl">
                <x-dashboard.page-title :title="__('Student Enrollment Form')" back_url="/" />
                <x-notification-message />

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="p-4 mb-6 bg-red-50 rounded-lg border border-red-200">
                        <h3 class="mb-2 text-sm font-medium text-red-800">Please correct the following errors:</h3>
                        <ul class="space-y-1 list-disc list-inside">
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
                    <div class="p-6 bg-white rounded-lg shadow-lg">
                        <div class="flex gap-2 items-center mb-6 text-lg font-semibold text-gray-800">
                            <i class="fi fi-rr-graduation-cap"></i>
                            <span>Enrollment Details</span>
                        </div>

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="form-control">
                                <label class="label">
                                    <span class="font-medium label-text">School Year</span>
                                </label>
                                <input type="text" class="bg-gray-50 input input-bordered" name="school_year"
                                    value="{{ date('Y', strtotime($academicYear->start_date)) }} - {{ date('Y', strtotime($academicYear->end_date)) }}"
                                    readonly>
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="font-medium label-text">Grade Level to Enroll</span>
                                </label>
                                <select name="grade_level"
                                    class="select select-bordered @error('grade_level') select-error @enderror">
                                    <option value="" disabled selected>Select Grade Level</option>
                                    @foreach ($gradeLevels as $grade)
                                        <option value="{{ $grade->name }}"
                                            {{ old('grade_level') == $grade ? 'selected' : '' }}>
                                            {{ $grade->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-control md:col-span-2">
                                <label class="label">
                                    <span class="font-medium label-text">Returning (Balik-Aral) Learner?</span>
                                </label>
                                <div class="flex gap-6">
                                    <label class="flex gap-2 items-center cursor-pointer">
                                        <input type="radio" name="balik_aral" value="yes"
                                            class="radio radio-accent"
                                            {{ old('balik_aral') == 'yes' ? 'checked' : '' }}>
                                        <span>Yes</span>
                                    </label>
                                    <label class="flex gap-2 items-center cursor-pointer">
                                        <input type="radio" name="balik_aral" value="no"
                                            class="radio radio-accent"
                                            {{ old('balik_aral') == 'no' ? 'checked' : '' }}>
                                        <span>No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Student Information Card -->
                    <div class="p-6 bg-white rounded-lg shadow-lg">
                        <div class="flex gap-2 items-center mb-6 text-lg font-semibold text-gray-800">
                            <i class="fi fi-rr-user"></i>
                            <span>Student Information</span>
                        </div>

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="form-control">
                                <label class="label">
                                    <span class="font-medium label-text">Last Name</span>
                                </label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}"
                                    class="input input-bordered @error('last_name') input-error @enderror" required>
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="font-medium label-text">First Name</span>
                                </label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}"
                                    class="input input-bordered @error('first_name') input-error @enderror" required>
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="font-medium label-text">Middle Name</span>
                                </label>
                                <input type="text" name="middle_name" value="{{ old('middle_name') }}"
                                    class="input input-bordered">
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="font-medium label-text">Extension Name</span>
                                    <span class="text-gray-500 label-text-alt">(Jr., III, etc.)</span>
                                </label>
                                <input type="text" name="extension_name" value="{{ old('extension_name') }}"
                                    class="input input-bordered">
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="font-medium label-text">Date of Birth</span>
                                </label>
                                <input type="date" name="birthdate" value="{{ old('birthdate') }}"
                                    class="input input-bordered @error('birthdate') input-error @enderror" required>
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="font-medium label-text">Place of Birth</span>
                                </label>
                                <input type="text" name="birthplace" value="{{ old('birthplace') }}"
                                    class="input input-bordered @error('birthplace') input-error @enderror" required>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="p-6 bg-white rounded-lg shadow-lg">
                        <div class="flex gap-2 items-center mb-6 text-lg font-semibold text-gray-800">
                            <i class="fi fi-rr-home"></i>
                            <span>Address Information</span>
                        </div>

                        <!-- Current Address -->
                        <h3 class="mb-4 text-sm font-medium text-gray-500">Current Address</h3>
                        <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-3">

                            <div class="flex flex-col gap-2">
                                <input type="text" name="house_no" placeholder="House No."
                                    class="input input-bordered">

                                @if ($errors->has('house_no'))
                                    <span class="text-sm text-red-600">{{ $errors->first('house_no') }}</span>
                                @endif
                            </div>
                            <div class="flex flex-col gap-2">
                                <input type="text" name="street" placeholder="Street"
                                    class="input input-bordered">
                                @if ($errors->has('street'))
                                    <span class="text-sm text-red-600">{{ $errors->first('street') }}</span>
                                @endif
                            </div>
                            <div class="flex flex-col gap-2">
                                <input type="text" name="barangay" placeholder="Barangay"
                                    class="input input-bordered">
                                @if ($errors->has('barangay'))
                                    <span class="text-sm text-red-600">{{ $errors->first('barangay') }}</span>
                                @endif
                            </div>


                            <div>
                                <input type="text" name="city" placeholder="Municipality/City"
                                    class="w-full input input-bordered">
                                @if ($errors->has('city'))
                                    <span class="text-sm text-red-600">{{ $errors->first('city') }}</span>
                                @endif

                            </div>


                            <div>


                                <input type="text" name="province" placeholder="Province"
                                    class="w-full input input-bordered">
                                @if ($errors->has('province'))
                                    <span class="text-sm text-red-600">{{ $errors->first('province') }}</span>
                                @endif

                            </div>



                            <div>

                                <input type="text" name="zip_code" placeholder="Zip Code"
                                    class="w-full input input-bordered">
                                @if ($errors->has('zip_code'))
                                    <span class="text-sm text-red-600">{{ $errors->first('zip_code') }}</span>
                                @endif

                            </div>
                        </div>


                            <!-- Permanent Address -->
                            {{-- <h3 class="mb-4 text-sm font-medium text-gray-500">Permanent Address</h3>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">

                                <div class="flex flex-col gap-2">
                                    <input type="text" name="perm_house_no" placeholder="House No."
                                    class="input input-bordered">

                                    @if($errors->has('perm_house_no'))
                                        <span class="text-sm text-red-600">{{ $errors->first('perm_house_no') }}</span>
                                    @endif
                                </div>

                                <div class="flex flex-col gap-2">
                                    <input type="text" name="perm_street" placeholder="Street"
                                    class="input input-bordered">

                                    @if($errors->has('perm_street'))
                                        <span class="text-sm text-red-600">{{ $errors->first('perm_street') }}</span>
                                    @endif
                                </div>

                                <div class="flex flex-col gap-2">
                                    <input type="text" name="perm_barangay" placeholder="Barangay"
                                    class="input input-bordered">

                                    @if($errors->has('perm_barangay'))
                                        <span class="text-sm text-red-600">{{ $errors->first('perm_barangay') }}</span>
                                    @endif
                                </div>

                                <div class="flex flex-col gap-2">
                                    <input type="text" name="perm_city" placeholder="Municipality/City"
                                    class="input input-bordered">

                                    @if($errors->has('perm_city'))
                                        <span class="text-sm text-red-600">{{ $errors->first('perm_city') }}</span>
                                    @endif
                                </div>
                                <div class="flex flex-col">
                                    <input type="text" name="perm_province" placeholder="Province"
                                    class="input input-bordered">

                                    @if($errors->has('perm_province'))
                                        <span class="text-sm text-red-600">{{ $errors->first('perm_province') }}</span>
                                    @endif
                                </div>



                                <div class="flex flex-col">
                                    <input type="text" name="perm_zip_code" placeholder="Zip Code"
                                    class="input input-bordered">

                                    @if($errors->has('perm_zip_code'))
                                        <span class="text-sm text-red-600">{{ $errors->first('perm_zip_code') }}</span>
                                    @endif
                                </div>
                            </div> --}}
                        </div>

                        <!-- Parent/Guardian Information -->
                        <div class="p-6 bg-white rounded-lg shadow-lg">
                            <div class="flex gap-2 items-center mb-6 text-lg font-semibold text-gray-800">
                                <i class="fi fi-rr-user"></i>
                                <span>Parent/Guardian Information</span>
                            </div>

                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div class="form-control">
                                    <label class="label">
                                        <span class="font-medium label-text">Full Name</span>
                                    </label>
                                    <input type="text" name="parent_name" value="{{ old('parent_name') }}"
                                        class="input input-bordered @error('parent_name') input-error @enderror"
                                        required>
                                </div>

                                <div class="form-control">
                                    <label class="label">
                                        <span class="font-medium label-text">Relationship to Student</span>
                                    </label>
                                    <input type="text" name="relationship" value="{{ old('relationship') }}"
                                        class="input input-bordered @error('relationship') input-error @enderror"
                                        required>
                                </div>

                                <div class="form-control">
                                    <label class="label">
                                        <span class="font-medium label-text">Contact Number</span>
                                    </label>
                                    <input type="text" name="contact_number" value="{{ old('contact_number') }}"
                                        class="input input-bordered @error('contact_number') input-error @enderror"
                                        required>
                                </div>

                                <div class="form-control">
                                    <label class="label">
                                        <span class="font-medium label-text">Occupation</span>
                                    </label>
                                    <input type="text" name="occupation" value="{{ old('occupation') }}"
                                        class="input input-bordered">
                                </div>
                            </div>
                        </div>

                        <!-- Senior High School Preferences -->
                        {{-- <div class="p-6 bg-white rounded-lg shadow-lg">
                        <div class="flex gap-2 items-center mb-6 text-lg font-semibold text-gray-800">
                            <i class="fi fi-rr-graduation-cap"></i>
                            <span>For Learning in Senior High School</span>
                        </div>

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="form-control">
                                <label class="label">
                                    <span class="font-medium label-text">Preferred Track</span>
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
                                    <span class="font-medium label-text">Preferred Strand</span>
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
                        <div class="p-6 bg-white rounded-lg shadow-lg">
                            <div class="flex gap-2 items-center mb-6 text-lg font-semibold text-gray-800">
                                <i class="fi fi-rr-envelope"></i>
                                <span>Contact Information</span>
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="font-medium label-text">Email Address</span>
                                    <span class="text-gray-500 label-text-alt">For verification purposes only</span>
                                </label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="input input-bordered @error('email') input-error @enderror" required>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex gap-4 justify-end">
                            <a href="/" class="btn btn-ghost">Cancel</a>
                            <button type="submit" class="gap-2 btn btn-accent">
                                <i class="fi fi-rr-check"></i>
                                Submit Enrollment
                            </button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</x-landing-page.base>
