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

                <form action="{{ route('enrollment.store') }}" method="POST" class="space-y-8"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="academic_year_id" value="{{ $academicYear->id }}">
                    <input type="hidden" name="enrollment_id" value="{{ $enrollmentID }}">
                    <input type="hidden" name="user_id" value="{{ auth()->id ?? null }}" />
                    <!-- Enrollment Form Card -->
                    <div class="p-6 bg-white rounded-lg shadow-lg">
                        <div class="flex gap-2 items-center mb-6 text-lg font-semibold text-gray-800 uppercase">
                            <i class="fi fi-rr-document"></i>
                            <span>Enrollment Form</span>
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
                                    class="select select-bordered @error('grade_level') select-error @enderror"
                                    required>
                                    <option value="" disabled selected>Select Grade Level</option>
                                    @foreach ($gradeLevels as $grade)
                                        <option value="{{ $grade->name }}"
                                            {{ old('grade_level') == $grade->name ? 'selected' : '' }}>
                                            {{ $grade->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-control md:col-span-2">
                                <label class="label">
                                    <span class="font-medium label-text">Learner's Reference Number (LRN)</span>
                                </label>
                                <input type="text" name="lrn" value="{{ old('lrn') }}"
                                    class="input input-bordered @error('lrn') input-error @enderror"
                                    placeholder="Enter LRN if available">
                            </div>
                        </div>


                        <div class="flex flex-col gap-2 mt-5">
                            <p class="font-medium label-text">Balik Aral:</p>
                            <select name="balik_aral" class="select select-bordered">
                                <option value="yes" {{ old('balik_aral') == 'yes' ? 'selected' : '' }}>Yes</option>
                                <option value="no" {{ old('balik_aral') == 'no' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>

                        <div class="flex flex-col gap-2 mt-5">
                            <p class="font-medium label-text">Enrollment type:</p>
                            <input type="text" name="type" value="{{ request()->query('type') }}"
                                class="input input-bordered" readonly>
                        </div>
                    </div>

                    <!-- Student Information Card -->
                    <div class="p-6 bg-white rounded-lg shadow-lg">
                        <div class="flex gap-2 items-center mb-6 text-lg font-semibold text-gray-800 uppercase">
                            <i class="fi fi-rr-user"></i>
                            <span>Student's Information</span>
                        </div>

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
                            <!-- Names -->
                            <div class="form-control md:col-span-1">
                                <label class="label">
                                    <span class="font-medium label-text">Last Name</span>
                                </label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}"
                                    class="input input-bordered @error('last_name') input-error @enderror" required>
                            </div>

                            <div class="form-control md:col-span-1">
                                <label class="label">
                                    <span class="font-medium label-text">First Name</span>
                                </label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}"
                                    class="input input-bordered @error('first_name') input-error @enderror" required>
                            </div>

                            <div class="form-control md:col-span-1">
                                <label class="label">
                                    <span class="font-medium label-text">Middle Name</span>
                                </label>
                                <input type="text" name="middle_name" value="{{ old('middle_name') }}"
                                    class="input input-bordered">
                            </div>

                            <div class="form-control md:col-span-1">
                                <label class="label">
                                    <span class="font-medium label-text">Extension Name</span>
                                    <span class="text-gray-500 label-text-alt">(Jr., III, etc.)</span>
                                </label>
                                <input type="text" name="extension_name" value="{{ old('extension_name') }}"
                                    class="input input-bordered">
                            </div>

                            <!-- Birth Info -->
                            <div class="form-control md:col-span-1">
                                <label class="label">
                                    <span class="font-medium label-text">Date of Birth</span>
                                </label>
                                <input type="date" name="birthdate" value="{{ old('birthdate') }}"
                                    class="input input-bordered @error('birthdate') input-error @enderror" required>
                            </div>

                            <div class="form-control md:col-span-1">
                                <label class="label">
                                    <span class="font-medium label-text">Sex</span>
                                </label>
                                <div class="flex gap-6 pt-2">
                                    <label class="flex gap-2 items-center cursor-pointer">
                                        <input type="radio" name="sex" value="Male"
                                            class="radio radio-accent" {{ old('sex') == 'Male' ? 'checked' : '' }}>
                                        <span>Male</span>
                                    </label>
                                    <label class="flex gap-2 items-center cursor-pointer">
                                        <input type="radio" name="sex" value="Female"
                                            class="radio radio-accent" {{ old('sex') == 'Female' ? 'checked' : '' }}>
                                        <span>Female</span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-control md:col-span-1">
                                <label class="label">
                                    <span class="font-medium label-text">Age</span>
                                </label>
                                <input type="number" name="age" value="{{ old('age') }}"
                                    class="input input-bordered @error('age') input-error @enderror" min="0">
                            </div>

                            <div class="form-control md:col-span-1">
                                <label class="label">
                                    <span class="font-medium label-text">Place of Birth</span>
                                </label>
                                <input type="text" name="birthplace" value="{{ old('birthplace') }}"
                                    class="input input-bordered @error('birthplace') input-error @enderror" required>
                            </div>

                            <!-- Full Address -->
                            <h3 class="mt-4 font-medium text-gray-700 md:col-span-4">Full Address</h3>

                            <div class="form-control md:col-span-1">
                                <label class="label">
                                    <span class="font-medium label-text">Block and Lot</span>
                                </label>
                                <input type="text" name="house_no" value="{{ old('house_no') }}"
                                    placeholder="Block and Lot"
                                    class="input input-bordered @error('house_no') input-error @enderror">
                            </div>

                            <div class="form-control md:col-span-1">
                                <label class="label">
                                    <span class="font-medium label-text">Street Name</span>
                                </label>
                                <input type="text" name="street" value="{{ old('street') }}"
                                    placeholder="Street Name"
                                    class="input input-bordered @error('street') input-error @enderror">
                            </div>

                            {{-- <div class="form-control md:col-span-1">
                                <label class="label">
                                    <span class="font-medium label-text">Subdivision</span>
                                </label>
                                <input type="text" name="subdivision" value="{{ old('subdivision') }}"
                                    placeholder="Subdivision"
                                    class="input input-bordered @error('subdivision') input-error @enderror">
                            </div> --}}

                            <div class="form-control md:col-span-1">
                                <label class="label">
                                    <span class="font-medium label-text">Barangay</span>
                                </label>
                                <input type="text" name="barangay" value="{{ old('barangay') }}"
                                    placeholder="Barangay"
                                    class="input input-bordered @error('barangay') input-error @enderror" required>
                            </div>

                            <div class="form-control md:col-span-1">
                                <label class="label">
                                    <span class="font-medium label-text">Municipality/City</span>
                                </label>
                                <input type="text" name="city" value="{{ old('city') }}"
                                    placeholder="Municipality/City"
                                    class="input input-bordered @error('city') input-error @enderror" required>
                            </div>

                            <div class="form-control md:col-span-1">
                                <label class="label">
                                    <span class="font-medium label-text">Province</span>
                                </label>
                                <input type="text" name="province" value="{{ old('province') }}"
                                    placeholder="Province"
                                    class="input input-bordered @error('province') input-error @enderror" required>
                            </div>

                            <div class="form-control md:col-span-1">
                                <label class="label">
                                    <span class="font-medium label-text">Country</span>
                                </label>
                                <input type="text" name="country" value="{{ old('country', 'Philippines') }}"
                                    placeholder="Country"
                                    class="input input-bordered @error('country') input-error @enderror" required>
                            </div>

                            <div class="form-control md:col-span-1">
                                <label class="label">
                                    <span class="font-medium label-text">Zip Code</span>
                                </label>
                                <input type="text" name="zip_code" value="{{ old('zip_code') }}"
                                    placeholder="Zip Code"
                                    class="input input-bordered @error('zip_code') input-error @enderror">
                            </div>
                        </div>
                    </div>

                    <!-- Parent/Guardian Information -->
                    <div class="p-6 bg-white rounded-lg shadow-lg">
                        <div class="flex gap-2 items-center mb-6 text-lg font-semibold text-gray-800 uppercase">
                            <i class="fi fi-rr-users-alt"></i>
                            <span>Parent/Guardian Information</span>
                        </div>

                        <div class="grid grid-cols-1 gap-y-6 gap-x-12 md:grid-cols-2">
                            <!-- Father's Information -->
                            <div class="space-y-4">
                                <h3 class="font-medium text-gray-700">Father's Name</h3>
                                <div class="form-control">
                                    <label class="label">
                                        <span class="font-medium label-text">Last Name</span>
                                    </label>
                                    <input type="text" name="parent_last_name"
                                        value="{{ old('parent_last_name') }}" placeholder="Last Name"
                                        class="input input-bordered @error('parent_last_name') input-error @enderror">
                                </div>
                                <div class="form-control">
                                    <label class="label">
                                        <span class="font-medium label-text">First Name</span>
                                    </label>
                                    <input type="text" name="parent_name" value="{{ old('parent_name') }}"
                                        placeholder="First Name"
                                        class="input input-bordered @error('parent_name') input-error @enderror">
                                </div>
                                <div class="form-control">
                                    <label class="label">
                                        <span class="font-medium label-text">Middle Name</span>
                                    </label>
                                    <input type="text" name="parent_middle_name"
                                        value="{{ old('parent_middle_name') }}" placeholder="Middle Name"
                                        class="input input-bordered @error('parent_middle_name') input-error @enderror">
                                </div>
                                <div class="form-control">
                                    <label class="label">
                                        <span class="font-medium label-text">Contact Number</span>
                                    </label>
                                    <input type="text" name="contact_number" value="{{ old('contact_number') }}"
                                        placeholder="Contact Number" inputmode="numeric" minlength="11"
                                        maxlength="11" pattern="\d{11}"
                                        oninput="this.value = this.value.replace(/\D/g, '').slice(0, 11);"
                                        class="input input-bordered @error('contact_number') input-error @enderror">
                                </div>
                                <div class="form-control">
                                    <label class="label">
                                        <span class="font-medium label-text">Occupation</span>
                                    </label>
                                    <input type="text" name="occupation" value="{{ old('occupation') }}"
                                        placeholder="Occupation"
                                        class="input input-bordered @error('occupation') input-error @enderror">
                                </div>
                            </div>

                            <!-- Mother's Information -->
                            <div class="space-y-4">
                                <h3 class="font-medium text-gray-700">Mother's Name</h3>
                                <div class="form-control">
                                    <label class="label">
                                        <span class="font-medium label-text">Last Name</span>
                                    </label>
                                    <input type="text" name="mother_last_name"
                                        value="{{ old('mother_last_name') }}" placeholder="Last Name"
                                        class="input input-bordered @error('mother_last_name') input-error @enderror">
                                </div>
                                <div class="form-control">
                                    <label class="label">
                                        <span class="font-medium label-text">First Name</span>
                                    </label>
                                    <input type="text" name="mother_name" value="{{ old('mother_name') }}"
                                        placeholder="First Name"
                                        class="input input-bordered @error('mother_name') input-error @enderror">
                                </div>
                                <div class="form-control">
                                    <label class="label">
                                        <span class="font-medium label-text">Middle Name</span>
                                    </label>
                                    <input type="text" name="mother_middle_name"
                                        value="{{ old('mother_middle_name') }}" placeholder="Middle Name"
                                        class="input input-bordered @error('mother_mddle_name') input-error @enderror">
                                </div>
                                <div class="form-control">
                                    <label class="label">
                                        <span class="font-medium label-text">Contact Number</span>
                                    </label>
                                    <input type="text" name="mother_contact_number"
                                        value="{{ old('mother_contact_number') }}" placeholder="Contact Number"
                                        inputmode="numeric" minlength="11" maxlength="11" pattern="\d{11}"
                                        oninput="this.value = this.value.replace(/\D/g, '').slice(0, 11);"
                                        class="input input-bordered @error('mother_contact_number') input-error @enderror">
                                </div>
                                <div class="form-control">
                                    <label class="label">
                                        <span class="font-medium label-text">Occupation</span>
                                    </label>
                                    <input type="text" name="mother_occupation"
                                        value="{{ old('mother_occupation') }}" placeholder="Occupation"
                                        class="input input-bordered @error('mother_occupation') input-error @enderror">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Required Documents -->
                    <div class="p-6 bg-white rounded-lg shadow-lg">
                        <div class="flex gap-2 items-center mb-6 text-lg font-semibold text-gray-800 uppercase">
                            <i class="fi fi-rr-clip"></i>
                            <span>Required Documents</span>
                        </div>

                        <div class="space-y-6">
                            <!-- Document Upload Instructions -->
                            <div class="p-4 bg-blue-50 rounded-lg">
                                <h4 class="flex gap-2 items-center text-sm font-medium text-blue-800">
                                    <i class="fi fi-rr-info"></i>
                                    <span>Document Requirements</span>
                                </h4>
                                <ul class="mt-2 ml-5 text-sm list-disc text-blue-700">
                                    <li>All documents must be clear and readable</li>
                                    <li>Accepted formats: PDF, JPG, PNG (max 5MB per file)</li>
                                    <li>Make sure all pages are properly scanned</li>
                                </ul>
                            </div>

                            <!-- Document Upload Section -->
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <!-- Required Documents -->
                                <div class="space-y-4">
                                    <h4 class="font-medium text-gray-700">Required Documents</h4>
                                    @foreach (['birth_certificate' => 'Birth Certificate (PSA/NSO)', 'form_138' => 'Report Card (Form 138)', 'good_moral' => 'Good Moral Certificate'] as $key => $label)
                                        <div class="form-control">
                                            <label class="label">
                                                <span class="font-medium label-text">{{ $label }}</span>
                                                <span class="text-error label-text-alt">*</span>
                                            </label>
                                            <input type="file" name="attachments[{{ $key }}]"
                                                accept=".pdf,.jpg,.jpeg,.png"
                                                class="file-input file-input-bordered file-input-accent w-full @error('attachments.' . $key) file-input-error @enderror"
                                                required>
                                            @error('attachments.' . $key)
                                                <label class="label">
                                                    <span class="text-error label-text-alt">{{ $message }}</span>
                                                </label>
                                            @enderror
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Additional Documents -->
                                <div class="space-y-4">
                                    <h4 class="font-medium text-gray-700">Additional Documents</h4>
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="font-medium label-text">Additional Files</span>
                                        </label>
                                        <input type="file" name="attachments[additional][]"
                                            accept=".pdf,.jpg,.jpeg,.png"
                                            class="w-full file-input file-input-bordered" multiple>
                                        <label class="label">
                                            <span class="text-gray-500 label-text-alt">You can select multiple
                                                files</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="p-6 bg-white rounded-lg shadow-lg">
                        <p class="font-medium label-text">use for communication only</p>
                        <div class="flex flex-col gap-2 mb-6 text-lg font-semibold text-gray-800 uppercase">
                            <i class="fi fi-rr-file-contract"></i>
                            <span class="font-medium label-text">Email:</span>


                            @if (!(request()->query('type') == 'old'))
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="input input-bordered @error('email') input-error @enderror"
                                    placeholder="Enter Email">
                            @else
                                <p class="text-xs text-gray-500"> Already logged in as {{ Auth::user()->email }} you
                                    have already account</p>
                                <input type="email" name="email" value="{{ Auth::user()->email }}"
                                    class="input input-bordered @error('email') input-error @enderror"
                                    placeholder="Enter Email" readonly>
                            @endif
                        </div>
                        {{-- <div class="max-w-none prose prose-sm">
                            <p>
                                I hereby certify that the above information given are true and correct to the best of my
                                knowledge and I allow Theos Higher Ground Academe to use my child's details to create
                                and/or update his/her learner profile in the Learner Information System. The
                                information herein shall be treated as confidential in compliance with the Data Privacy
                                Act of 2012.
                            </p>
                            <p>
                                By signing, I also hereby certify that I have read and understand the informational
                                materials furnished above and agree/s that our/my child submits to Theos Higher Ground
                                Academe's program, academic and disciplinary regulations and all other requirements
                                indicated by the Administration and carried out by the School Principal and Faculty.
                            </p>
                        </div> --}}

                        {{-- <div class="grid grid-cols-1 gap-6 pt-6 md:grid-cols-2">
                            <div class="space-y-2">
                                <span class="font-medium">Signature of Mother:</span>
                                <div class="w-full h-12 bg-gray-100 rounded-md border border-dashed"></div>
                                <span class="font-medium">Signature of Father:</span>
                                <div class="w-full h-12 bg-gray-100 rounded-md border border-dashed"></div>
                                <span class="font-medium">Signature of Guardian:</span>
                                <div class="w-full h-12 bg-gray-100 rounded-md border border-dashed"></div>
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="font-medium label-text">Date Signed</span>
                                </label>
                                <input type="date" name="date_signed" value="{{ old('date_signed', date('Y-m-d')) }}"
                                    class="input input-bordered @error('date_signed') input-error @enderror" required>
                            </div>
                        </div> --}}
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

    <!-- Add this script at the bottom of your form -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const additionalDocs = document.querySelector('input[name="additional_docs[]"]');
            const previewContainer = document.getElementById('filePreviewContainer');
            const fileList = document.getElementById('fileList');

            additionalDocs.addEventListener('change', function() {
                fileList.innerHTML = '';

                if (this.files.length > 0) {
                    previewContainer.classList.remove('hidden');
                    Array.from(this.files).forEach(file => {
                        const li = document.createElement('li');
                        li.className = 'flex items-center gap-2';
                        li.innerHTML = `
                            <i class="fi fi-rr-document text-accent"></i>
                            <span>${file.name}</span>
                            <span class="text-xs text-gray-500">(${(file.size / (1024 * 1024)).toFixed(2)} MB)</span>
                        `;
                        fileList.appendChild(li);
                    });
                } else {
                    previewContainer.classList.add('hidden');
                }
            });
        });
    </script>
</x-landing-page.base>
