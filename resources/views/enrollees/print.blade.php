@php
    use App\Models\Logo;

    $logo = Logo::where('is_active', true)->first()->path ?? asset('logo-modified.png');

@endphp


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment Form - {{ $student->last_name ?? 'Student' }}, {{ $student->first_name ?? 'Name' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Style for the rendered data to look like an underlined field */
        .form-data {
            border-bottom: 1px solid #333;
            padding-bottom: 2px;
            /* Use a min-height to ensure empty fields are still visible */
            min-height: 1.75rem;
            width: 100%;
            font-weight: 500;
            /* Medium font weight for data */
        }

        .field-label {
            font-size: 0.8rem;
            color: #555;
            font-weight: 500;
        }

        /* Style for the small text below the fields (e.g., "Last Name") */
        .sub-label {
            font-size: 0.7rem;
            color: #666;
            margin-top: 1px;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            /* ADD THIS PART to hide the buttons on the printed paper */
            #no-print {
                display: none;
            }
        }
    </style>
</head>

<body class="p-4 bg-gray-100 sm:p-8">

    <div class="flex fixed top-4 right-4 z-50 gap-3" id="no-print">
        <a href="{{ url()->previous() }}"
            class="px-4 py-2 font-semibold text-black bg-gray-200 rounded-lg shadow hover:bg-gray-300">
            Back
        </a>
        <button
            onclick="document.getElementById('no-print').style.display = 'none'; window.print(); document.getElementById('no-print').style.display = 'flex';"
            class="px-4 py-2 font-semibold text-white bg-blue-600 rounded-lg shadow hover:bg-blue-700">
            Print Form
        </button>
    </div>

    <div class="mx-auto max-w-4xl bg-white shadow-lg">
        <!-- Header -->
        <div class="flex justify-between items-center p-6 border-b">
            <div>
                <h1 class="text-3xl font-bold text-blue-900">THEOS HIGHER GROUND ACADEME</h1>
                <p class="text-lg text-gray-600">SY {{ $student->school_year ?? 'N\A' }}</p>
            </div>
            <div>
                <!-- Using a placeholder for the logo -->
                <img src="{{ $logo }}" alt="School Logo" class="w-24 h-24">
            </div>
        </div>

        <!-- Enrollment Form Section -->
        <div class="p-2 pl-6 font-bold text-white bg-blue-900">
            ENROLLMENT FORM
        </div>

        <div class="p-6 border-b">
            <!-- Added print:grid and print:grid-cols-5 -->
            <div class="grid grid-cols-1 gap-y-4 gap-x-8 items-end md:grid-cols-5 print:grid print:grid-cols-5">
                <!-- Added print:col-span-2 -->
                <div class="md:col-span-2 print:col-span-2">
                    <p class="field-label">School Year:</p>
                    <p class="form-data">{{ $student->school_year ?? 'N\A' }}</p>
                </div>
                <!-- Added print:col-span-2 -->
                <div class="md:col-span-2 print:col-span-2">
                    <p class="field-label">Grade Level to Enroll:</p>
                    <p class="form-data">{{ $student->grade_level ?? 'N\A' }}</p>
                </div>
                <!-- Added print:col-span-1 -->
                <div class="md:col-span-1 print:col-span-1">
                    <p class="field-label">Learner's Reference Number:</p>
                    <p class="form-data">{{ $student->lrn ?? 'N\A' }}</p>
                </div>
            </div>
        </div>

        <!-- Student's Information Section -->
        <div class="p-2 pl-6 font-bold text-white bg-blue-900">
            STUDENT'S INFORMATION
        </div>

        <div class="p-6 space-y-6">
            <!-- Names -->
            <!-- Added print:grid and print:grid-cols-4 -->
            <div class="grid grid-cols-1 gap-y-4 gap-x-6 md:grid-cols-4 print:grid print:grid-cols-4">
                <div>
                    <p class="form-data">{{ $student->last_name ?? 'N\A' }}</p>
                    <p class="sub-label">Last Name</p>
                </div>
                <div>
                    <p class="form-data">{{ $student->first_name ?? 'N\A' }}</p>
                    <p class="sub-label">First Name</p>
                </div>
                <div>
                    <p class="form-data">{{ $student->middle_name ?? 'N\A' }}</p>
                    <p class="sub-label">Middle Name</p>
                </div>
                <div>
                    <p class="form-data">{{ $student->extension_name ?? 'N\A' }}</p>
                    <p class="sub-label">Extension Name <span class="italic">(e.g. Jr, III)</span></p>
                </div>
            </div>

            <!-- Full Address -->
            <div>
                <p class="mb-2 field-label">Full Address</p>
                <!-- Added print:grid and print:grid-cols-4 -->
                <div class="grid grid-cols-1 gap-y-4 gap-x-6 md:grid-cols-4 print:grid print:grid-cols-4">
                    <div>
                        <p class="form-data">{{ $student->house_no ?? 'N\A' }}</p>
                        <p class="sub-label">Block and Lot</p>
                    </div>
                    <div>
                        <p class="form-data">{{ $student->street ?? 'N\A' }}</p>
                        <p class="sub-label">Street Name</p>
                    </div>
                    {{-- <div>
                        <p class="form-data">{{ $student->subdivision ?? 'N\A' }}</p>
                        <p class="sub-label">Subdivision</p>
                    </div> --}}
                    <div>
                        <p class="form-data">{{ $student->barangay ?? 'N\A' }}</p>
                        <p class="sub-label">Barangay</p>
                    </div>
                    <div>
                        <p class="form-data">{{ $student->city ?? 'N\A' }}</p>
                        <p class="sub-label">Municipality/City</p>
                    </div>
                    <div>
                        <p class="form-data">{{ $student->province ?? 'N\A' }}</p>
                        <p class="sub-label">Province</p>
                    </div>
                    <div>
                        <p class="form-data">Philippines</p>
                        <p class="sub-label">Country</p>
                    </div>
                    <div>
                        <p class="form-data">{{ $student->zip_code ?? 'N\A' }}</p>
                        <p class="sub-label">Zip Code</p>
                    </div>
                </div>
            </div>

            <!-- Birth Info -->
            <!-- Added print:grid and print:grid-cols-6 -->
            <div
                class="grid grid-cols-1 gap-y-4 gap-x-6 items-end md:grid-cols-6 print:grid print:grid-cols-6 print:items-end">
                <!-- Added print:col-span-2 -->
                <div class="md:col-span-2 print:col-span-2">
                    <p class="field-label">Date of Birth (DD/MM/YYYY):</p>
                    <p class="form-data">
                        {{ isset($student->birthdate) ? date('d / m / Y', strtotime($student->birthdate)) : 'N\A' }}
                    </p>
                </div>
                <!-- Added print:col-span-1 -->
                <div class="md:col-span-1 print:col-span-1">
                    <p class="field-label">Sex:</p>
                    <p class="form-data">{{ $student->sex ?? 'N\A' }}</p>
                </div>
                <!-- Added print:col-span-1 -->
                <div class="md:col-span-1 print:col-span-1">
                    <p class="field-label">Age:</p>
                    <p class="form-data">{{ $student->age ?? 'N\A' }}</p>
                </div>
                <!-- Added print:col-span-2 -->
                <div class="md:col-span-2 print:col-span-2">
                    <p class="field-label">Place of Birth:</p>
                    <p class="form-data">{{ $student->birthplace ?? 'N\A' }}</p>
                </div>
            </div>
        </div>

        <!-- Parent Info Section -->
        <div class="p-6 border-t">
            <!-- Added print:grid and print:grid-cols-2 -->
            <div class="grid grid-cols-1 gap-y-6 gap-x-8 md:grid-cols-2 print:grid print:grid-cols-2">
                <!-- Father's Info -->
                <div class="space-y-4">
                    <p class="font-semibold">Father's Name</p>
                    <div>
                        <p class="form-data">{{ $student->parent_last_name ?? 'N\A' }}</p>
                        <p class="sub-label">Last Name</p>
                    </div>
                    <div>
                        <p class="form-data">{{ $student->parent_name ?? 'N\A' }}</p>
                        <p class="sub-label">First Name</p>
                    </div>
                    <div>
                        <p class="form-data">{{ $student->parent_middle_name ?? 'N\A' }}</p>
                        <p class="sub-label">Middle Name</p>
                    </div>
                    <div>
                        <p class="field-label">Contact Number:</p>
                        <p class="form-data">{{ $student->contact_number ?? 'N\A' }}</p>
                    </div>
                    <div>
                        <p class="field-label">Occupation:</p>
                        <p class="form-data">{{ $student->occupation ?? 'N\A' }}</p>
                    </div>
                </div>
                <!-- Mother's Info -->
                <div class="space-y-4">
                    <p class="font-semibold">Mother's Name</p>
                    <div>
                        <p class="form-data">{{ $student->mother_last_name ?? 'N\A' }}</p>
                        <p class="sub-label">Last Name</p>
                    </div>
                    <div>
                        <p class="form-data">{{ $student->mother_name ?? 'N\A' }}</p>
                        <p class="sub-label">First Name</p>
                    </div>
                    <div>
                        <p class="form-data">{{ $student->mother_middle_name ?? 'N\A' }}</p>
                        <p class="sub-label">Middle Name</p>
                    </div>
                    <div>
                        <p class="field-label">Contact Number:</p>
                        <p class="form-data">{{ $student->mother_contact_number ?? 'N\A' }}</p>
                    </div>
                    <div>
                        <p class="field-label">Occupation:</p>
                        <p class="form-data">{{ $student->mother_occupation ?? 'N\A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Agreement Section -->
        <div class="p-6 text-sm border-t">
            <p class="mb-4">
                I hereby certify that the above information given are true and correct to the best of my knowledge and I
                allow Theos Higher Ground Academe to use my child's details to create and/or update his/her learner
                profile in the Learner Information System. The information herein shall be treated as confidential in
                compliance with the Data Privacy Act of 2012.
            </p>
            <p>
                By signing, I also hereby certify that I have read and understand the informational materials furnished
                above and agree/s that our/my child submits to Theos Higher Ground Academe's program, academic and
                disciplinary regulations and all other requirements instituted by the Administration and carried out by
                the School Principal and Faculty.
            </p>

            <!-- Added print:grid and print:grid-cols-2 -->
            <div class="grid grid-cols-1 gap-x-12 gap-y-12 mt-12 md:grid-cols-2 print:grid print:grid-cols-2">
                <div>
                    <div class="w-full h-10 border-b-2 border-black"></div>
                    <p class="mt-1 text-center">Signature of Mother</p>
                </div>
                <div class="flex flex-col justify-end">
                    <p class="text-center form-data">
                        {{ isset($student->date_signed) ? date('F j, Y', strtotime($student->date_signed)) : 'N\A' }}
                    </p>
                    <p class="mt-1 text-center sub-label">Date signed</p>
                </div>
                <div>
                    <div class="w-full h-10 border-b-2 border-black"></div>
                    <p class="mt-1 text-center">Signature of Father</p>
                </div>
                <div class="flex flex-col justify-end">
                    <p class="text-center form-data">
                        {{ isset($student->date_signed) ? date('F j, Y', strtotime($student->date_signed)) : 'N\A' }}
                        </s_p>
                    <p class="mt-1 text-center sub-label">Date signed</p>
                </div>
            </div>
        </div>

    </div>

</body>

</html>
