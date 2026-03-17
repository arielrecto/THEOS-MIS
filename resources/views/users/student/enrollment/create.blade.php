{{-- filepath: e:\Projects\Theos MIS\resources\views\users\student\enrollment\create.blade.php --}}
<x-dashboard.student.base>
    <div class="py-6 sm:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <!-- Header -->
                    <div class="mb-6">
                        <h2 class="text-xl sm:text-2xl font-semibold text-gray-800">
                            {{ $previousEnrollment ? 'Enroll for Next Grade Level' : 'New Enrollment Form' }}
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Fill out the form to submit your enrollment</p>
                    </div>

                    @if($previousEnrollment)
                        <div class="alert alert-info mb-6">
                            <i class="fi fi-rr-info"></i>
                            <span>Form pre-filled from your previous enrollment ({{ $previousEnrollment->school_year }})</span>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-error mb-6">
                            <div>
                                <h3 class="font-bold">Please correct the following errors:</h3>
                                <ul class="list-disc list-inside mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('student.enrollment.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        @if($previousEnrollment)
                            <input type="hidden" name="previous_enrollment_id" value="{{ $previousEnrollment->id }}">
                        @endif

                        <!-- Basic Information -->
                        <div class="border rounded-lg p-4">
                            <h3 class="text-lg font-semibold mb-4">Basic Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="form-control">
                                    <label class="label"><span class="label-text">School Year <span class="text-error">*</span></span></label>
                                    <input type="text" name="school_year" class="input input-bordered"
                                           value="{{ old('school_year', $nextSchoolYear ?? '') }}" required>
                                </div>

                                <div class="form-control">
                                    <label class="label"><span class="label-text">Grade Level <span class="text-error">*</span></span></label>
                                    <select name="grade_level" class="select select-bordered" required>
                                        <option value="">Select Grade Level</option>
                                        <option value="Grade 7" {{ old('grade_level', $nextGradeLevel ?? '') == 'Grade 7' ? 'selected' : '' }}>Grade 7</option>
                                        <option value="Grade 8" {{ old('grade_level', $nextGradeLevel ?? '') == 'Grade 8' ? 'selected' : '' }}>Grade 8</option>
                                        <option value="Grade 9" {{ old('grade_level', $nextGradeLevel ?? '') == 'Grade 9' ? 'selected' : '' }}>Grade 9</option>
                                        <option value="Grade 10" {{ old('grade_level', $nextGradeLevel ?? '') == 'Grade 10' ? 'selected' : '' }}>Grade 10</option>
                                        <option value="Grade 11" {{ old('grade_level', $nextGradeLevel ?? '') == 'Grade 11' ? 'selected' : '' }}>Grade 11</option>
                                        <option value="Grade 12" {{ old('grade_level', $nextGradeLevel ?? '') == 'Grade 12' ? 'selected' : '' }}>Grade 12</option>
                                    </select>
                                </div>

                                <div class="form-control">
                                    <label class="label"><span class="label-text">LRN <span class="text-error">*</span></span></label>
                                    <input type="text" name="lrn" class="input input-bordered"
                                           value="{{ old('lrn', $previousEnrollment->lrn ?? '') }}" required>
                                </div>

                                <div class="form-control">
                                    <label class="label"><span class="label-text">Balik Aral?</span></label>
                                    <select name="balik_aral" class="select select-bordered">
                                        <option value="0" {{ old('balik_aral', $previousEnrollment->balik_aral ?? 0) == 0 ? 'selected' : '' }}>No</option>
                                        <option value="1" {{ old('balik_aral', $previousEnrollment->balik_aral ?? 0) == 1 ? 'selected' : '' }}>Yes</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Personal Information -->
                        <div class="border rounded-lg p-4">
                            <h3 class="text-lg font-semibold mb-4">Personal Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="form-control">
                                    <label class="label"><span class="label-text">Last Name <span class="text-error">*</span></span></label>
                                    <input type="text" name="last_name" class="input input-bordered"
                                           value="{{ old('last_name', $previousEnrollment->last_name ?? '') }}" required>
                                </div>

                                <div class="form-control">
                                    <label class="label"><span class="label-text">First Name <span class="text-error">*</span></span></label>
                                    <input type="text" name="first_name" class="input input-bordered"
                                           value="{{ old('first_name', $previousEnrollment->first_name ?? '') }}" required>
                                </div>

                                <div class="form-control">
                                    <label class="label"><span class="label-text">Middle Name</span></label>
                                    <input type="text" name="middle_name" class="input input-bordered"
                                           value="{{ old('middle_name', $previousEnrollment->middle_name ?? '') }}">
                                </div>

                                <div class="form-control">
                                    <label class="label"><span class="label-text">Extension Name (Jr., III, etc.)</span></label>
                                    <input type="text" name="extension_name" class="input input-bordered"
                                           value="{{ old('extension_name', $previousEnrollment->extension_name ?? '') }}">
                                </div>

                                <div class="form-control">
                                    <label class="label"><span class="label-text">Birthdate <span class="text-error">*</span></span></label>
                                    <input type="date" name="birthdate" class="input input-bordered"
                                           value="{{ old('birthdate', $previousEnrollment->birthdate ?? '') }}" required>
                                </div>

                                <div class="form-control">
                                    <label class="label"><span class="label-text">Birthplace <span class="text-error">*</span></span></label>
                                    <input type="text" name="birthplace" class="input input-bordered"
                                           value="{{ old('birthplace', $previousEnrollment->birthplace ?? '') }}" required>
                                </div>

                                <div class="form-control md:col-span-2">
                                    <label class="label"><span class="label-text">Email <span class="text-error">*</span></span></label>
                                    <input type="email" name="email" class="input input-bordered"
                                           value="{{ old('email', $previousEnrollment->email ?? auth()->user()->email) }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- Current Address -->
                        <div class="border rounded-lg p-4">
                            <h3 class="text-lg font-semibold mb-4">Current Address</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="form-control">
                                    <label class="label"><span class="label-text">House No.</span></label>
                                    <input type="text" name="house_no" class="input input-bordered"
                                           value="{{ old('house_no', $previousEnrollment->house_no ?? '') }}">
                                </div>

                                <div class="form-control">
                                    <label class="label"><span class="label-text">Street</span></label>
                                    <input type="text" name="street" class="input input-bordered"
                                           value="{{ old('street', $previousEnrollment->street ?? '') }}">
                                </div>

                                <div class="form-control">
                                    <label class="label"><span class="label-text">Barangay <span class="text-error">*</span></span></label>
                                    <input type="text" name="barangay" class="input input-bordered"
                                           value="{{ old('barangay', $previousEnrollment->barangay ?? '') }}" required>
                                </div>

                                <div class="form-control">
                                    <label class="label"><span class="label-text">City/Municipality <span class="text-error">*</span></span></label>
                                    <input type="text" name="city" class="input input-bordered"
                                           value="{{ old('city', $previousEnrollment->city ?? '') }}" required>
                                </div>

                                <div class="form-control">
                                    <label class="label"><span class="label-text">Province <span class="text-error">*</span></span></label>
                                    <input type="text" name="province" class="input input-bordered"
                                           value="{{ old('province', $previousEnrollment->province ?? '') }}" required>
                                </div>

                                <div class="form-control">
                                    <label class="label"><span class="label-text">Zip Code</span></label>
                                    <input type="text" name="zip_code" class="input input-bordered"
                                           value="{{ old('zip_code', $previousEnrollment->zip_code ?? '') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Parent/Guardian Information -->
                        <div class="border rounded-lg p-4">
                            <h3 class="text-lg font-semibold mb-4">Father's Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="form-control">
                                    <label class="label"><span class="label-text">First Name</span></label>
                                    <input type="text" name="parent_name" class="input input-bordered"
                                           value="{{ old('parent_name', $previousEnrollment->parent_name ?? '') }}">
                                </div>

                                <div class="form-control">
                                    <label class="label"><span class="label-text">Last Name</span></label>
                                    <input type="text" name="parent_last_name" class="input input-bordered"
                                           value="{{ old('parent_last_name', $previousEnrollment->parent_last_name ?? '') }}">
                                </div>

                                <div class="form-control">
                                    <label class="label"><span class="label-text">Contact Number</span></label>
                                    <input type="text" name="contact_number" class="input input-bordered"
                                           value="{{ old('contact_number', $previousEnrollment->contact_number ?? '') }}">
                                </div>

                                <div class="form-control">
                                    <label class="label"><span class="label-text">Occupation</span></label>
                                    <input type="text" name="occupation" class="input input-bordered"
                                           value="{{ old('occupation', $previousEnrollment->occupation ?? '') }}">
                                </div>
                            </div>
                        </div>

                        <div class="border rounded-lg p-4">
                            <h3 class="text-lg font-semibold mb-4">Mother's Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="form-control">
                                    <label class="label"><span class="label-text">First Name</span></label>
                                    <input type="text" name="mother_name" class="input input-bordered"
                                           value="{{ old('mother_name', $previousEnrollment->mother_name ?? '') }}">
                                </div>

                                <div class="form-control">
                                    <label class="label"><span class="label-text">Last Name</span></label>
                                    <input type="text" name="mother_last_name" class="input input-bordered"
                                           value="{{ old('mother_last_name', $previousEnrollment->mother_last_name ?? '') }}">
                                </div>

                                <div class="form-control">
                                    <label class="label"><span class="label-text">Contact Number</span></label>
                                    <input type="text" name="mother_contact_number" class="input input-bordered"
                                           value="{{ old('mother_contact_number', $previousEnrollment->mother_contact_number ?? '') }}">
                                </div>

                                <div class="form-control">
                                    <label class="label"><span class="label-text">Occupation</span></label>
                                    <input type="text" name="mother_occupation" class="input input-bordered"
                                           value="{{ old('mother_occupation', $previousEnrollment->mother_occupation ?? '') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Required Documents -->
                        <div class="border rounded-lg p-4">
                            <h3 class="text-lg font-semibold mb-4">Required Documents <span class="text-error">*</span></h3>
                            <p class="text-sm text-gray-600 mb-4">Please upload the following documents (PDF, JPG, PNG - Max 5MB each)</p>

                            <div class="space-y-4">
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">Form 138 (Report Card) <span class="text-error">*</span></span>
                                    </label>
                                    <input type="file" name="documents[form_138]" class="file-input file-input-bordered w-full" accept=".pdf,.jpg,.jpeg,.png" required>
                                    <label class="label">
                                        <span class="label-text-alt text-gray-500">Previous school year's report card</span>
                                    </label>
                                </div>

                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">Birth Certificate <span class="text-error">*</span></span>
                                    </label>
                                    <input type="file" name="documents[birth_certificate]" class="file-input file-input-bordered w-full" accept=".pdf,.jpg,.jpeg,.png" required>
                                    <label class="label">
                                        <span class="label-text-alt text-gray-500">PSA or NSO copy</span>
                                    </label>
                                </div>

                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">Good Moral Certificate</span>
                                    </label>
                                    <input type="file" name="documents[good_moral]" class="file-input file-input-bordered w-full" accept=".pdf,.jpg,.jpeg,.png">
                                    <label class="label">
                                        <span class="label-text-alt text-gray-500">From previous school (if applicable)</span>
                                    </label>
                                </div>

                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">2x2 ID Picture <span class="text-error">*</span></span>
                                    </label>
                                    <input type="file" name="documents[id_picture]" class="file-input file-input-bordered w-full" accept=".jpg,.jpeg,.png" required>
                                    <label class="label">
                                        <span class="label-text-alt text-gray-500">Recent photo with white background</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3 justify-end">
                            <a href="{{ route('student.enrollment.index') }}" class="btn btn-ghost w-full sm:w-auto">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary w-full sm:w-auto">
                                <i class="fi fi-rr-paper-plane"></i>
                                Submit Enrollment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.student.base>
