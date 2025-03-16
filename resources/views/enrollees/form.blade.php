<x-landing-page.base>
    <section class="mx-auto w-5/6">
        <x-dashboard.page-title :title="__('Enrollment Form')" back_url="/" />
        <x-notification-message />


        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <p class="text-xs text-red-500">{{ $error }}</p>
            @endforeach
        @endif


        <form action="{{ route('enrollment.store') }}" method="POST"
            class="flex flex-col gap-6 p-6 bg-white rounded-lg shadow-lg panel">
            @csrf



            <!-- School Year and Grade Level -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="school_year" class="block font-semibold">School Year</label>
                    <input type="text" id="school_year" name="school_year" class="input-text"
                        value="{{ date('Y', strtotime($academicYear->start_date)) . ' - ' . date('Y', strtotime($academicYear->end_date)) }}"
                        required>
                </div>
                <input type="text" name="academic_year_id" value="{{ $academicYear->id }}" hidden>
                <input type="text" name="enrollment_id" value="{{ $enrollmentID }}" hidden>
                <div>
                    <label for="grade_level" class="block font-semibold">Grade Level to Enroll</label>
                    <select name="grade_level" id="grade_level" class="select select-accent">
                        <option value="" disabled selected>Select Grade Level</option>
                        <option value="1">Grade 1</option>
                        <option value="2">Grade 2</option>
                        <option value="3">Grade 3</option>
                        <option value="4">Grade 4</option>
                        <option value="5">Grade 5</option>
                        <option value="6">Grade 6</option>
                        <option value="7">Grade 7</option>
                        <option value="8">Grade 8</option>
                        <option value="9">Grade 9</option>
                        <option value="10">Grade 10</option>
                        <option value="11">Grade 11</option>
                        <option value="12">Grade 12</option>
                    </select>
                </div>
            </div>

            <!-- Returning Learner -->
            <div>
                <label class="block font-semibold">Returning (Balik-Aral) Learner?</label>
                <div class="flex gap-4">
                    <label><input type="radio" name="balik_aral" value="yes"> Yes</label>
                    <label><input type="radio" name="balik_aral" value="no"> No</label>
                </div>
            </div>

            <!-- Learner Information -->
            <h2 class="text-lg font-bold">Learner Information</h2>
            <div class="grid grid-cols-2 gap-4">
                <input type="text" name="last_name" placeholder="Last Name" class="input-text" required>
                <input type="text" name="first_name" placeholder="First Name" class="input-text" required>
                <input type="text" name="middle_name" placeholder="Middle Name" class="input-text">
                <input type="text" name="extension_name" placeholder="Extension Name (Jr., III, etc.)"
                    class="input-text">
            </div>

            <!-- Birth and Contact Info -->
            <div class="grid grid-cols-2 gap-4">
                <input type="date" name="birthdate" class="input-text" required>
                <input type="text" name="birthplace" placeholder="Place of Birth" class="input-text" required>
            </div>

            <!-- Address Section -->
            <h2 class="text-lg font-bold">Current Address</h2>
            <div class="grid grid-cols-3 gap-4">
                <input type="text" name="house_no" placeholder="House No." class="input-text">
                <input type="text" name="street" placeholder="Street" class="input-text">
                <input type="text" name="barangay" placeholder="Barangay" class="input-text">
                <input type="text" name="city" placeholder="Municipality/City" class="input-text">
                <input type="text" name="province" placeholder="Province" class="input-text">
                <input type="text" name="zip_code" placeholder="Zip Code" class="input-text">
            </div>

            <h2 class="text-lg font-bold">Permanent Address (If different from Current Address)</h2>
            <div class="grid grid-cols-3 gap-4">
                <input type="text" name="perm_house_no" placeholder="House No." class="input-text">
                <input type="text" name="perm_street" placeholder="Street" class="input-text">
                <input type="text" name="perm_barangay" placeholder="Barangay" class="input-text">
                <input type="text" name="perm_city" placeholder="Municipality/City" class="input-text">
                <input type="text" name="perm_province" placeholder="Province" class="input-text">
                <input type="text" name="perm_zip_code" placeholder="Zip Code" class="input-text">
            </div>

            <!-- Parent/Guardian Information -->
            <h2 class="text-lg font-bold">Parent/Guardian Information</h2>
            <div class="grid grid-cols-2 gap-4">
                <input type="text" name="parent_name" placeholder="Full Name" class="input-text" required>
                <input type="text" name="relationship" placeholder="Relationship to Student" class="input-text"
                    required>
                <input type="text" name="contact_number" placeholder="Contact Number" class="input-text"
                    required>
                <input type="text" name="occupation" placeholder="Occupation" class="input-text">
            </div>

            <!-- Senior High School Preferences -->
            <h2 class="text-lg font-bold">For Learning in Senior High School</h2>
            <div class="grid grid-cols-2 gap-4">
                <select name="preferred_track" class="select select-accent">
                    <option value="" disabled selected>Select Track</option>
                    <option value="academic">Academic </option>
                    <option value="technical and vocational and livelihood">Technical-Vocational-Livelihood (TVL)
                    </option>
                    <option value="arts and design">Arts and Design</option>
                    <option value="sports">Sports</option>
                </select>
                <select name="preferred_strand" id="" class="select select-accent">
                    <option value="" disabled selected>Select Strand</option>
                    <option value="general academic">General Academic</option>
                    <option value="science, technology, engineering, and mathematics">Science, Technology, Engineering,
                        and Mathematics (STEM)</option>
                    <option value="accountancy, business, and management">Accountancy, Business, and Management (ABM)
                    </option>
                    <option value="information and communication technology">Information and Communication Technology
                        (ICT)</option>
                </select>
            </div>

            <!-- Distance Learning Modalities -->
            <h2 class="text-lg font-bold">Preferred Distance Learning Modality</h2>
            <div class="grid grid-cols-3 gap-4">
                <label><input type="checkbox" name="modality[]" value="modular"> Modular (Print/Digital)</label>
                <label><input type="checkbox" name="modality[]" value="online"> Online Learning</label>
                <label><input type="checkbox" name="modality[]" value="blended"> Blended Learning</label>
                <label><input type="checkbox" name="modality[]" value="tv"> TV-Based Instruction</label>
                <label><input type="checkbox" name="modality[]" value="radio"> Radio-Based Instruction</label>
            </div>

            <div class="flex flex-col gap-2">
                <label for="email" class="block font-semibold">Email</label>
                <p class="text-xs text-gray-600"> Note : This is used for verification purposes only</p>
                <input type="email" name="email" placeholder="Email" class="input-text">
            </div>

            <div class="flex justify-end">
                <button type="submit" class="btn-primary">Submit Enrollment</button>
            </div>
        </form>
    </section>


</x-landing-page.base>
