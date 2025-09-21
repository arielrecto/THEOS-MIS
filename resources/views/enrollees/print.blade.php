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
        <a href="/" class="px-4 py-2 font-semibold text-black bg-gray-200 rounded-lg shadow hover:bg-gray-300">
            Back
        </a>
        <button onclick="document.getElementById('no-print').style.display = 'none'; window.print(); document.getElementById('no-print').style.display = 'flex';"
            class="px-4 py-2 font-semibold text-white bg-blue-600 rounded-lg shadow hover:bg-blue-700">
            Print Form
        </button>
    </div>

    <div class="mx-auto max-w-4xl bg-white shadow-lg">
        <div class="p-3 text-xl font-bold text-center text-white bg-blue-900">
            ENROLLMENT FORM
        </div>

        <div class="p-6 border-b">
            <div class="grid grid-cols-1 gap-y-4 gap-x-8 items-end md:grid-cols-5">
                <div class="md:col-span-2">
                    <p class="field-label">School Year:</p>
                    <p class="form-data">{{ $student->school_year ?? '2025-2026' }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="field-label">Grade Level to Enroll:</p>
                    <p class="form-data">{{ $student->grade_level ?? 'Grade 10' }}</p>
                </div>
                <div class="md:col-span-1">
                    <p class="field-label">Learner's Reference Number:</p>
                    <p class="form-data">{{ $student->lrn ?? '&nbsp;' }}</p>
                </div>
            </div>
        </div>

        <div class="p-2 pl-6 font-bold text-white bg-blue-900">
            STUDENT'S INFORMATION
        </div>

        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 gap-y-4 gap-x-6 md:grid-cols-4">
                <div>
                    <p class="form-data">{{ $student->last_name ?? 'Doe' }}</p>
                    <p class="sub-label">Last Name</p>
                </div>
                <div>
                    <p class="form-data">{{ $student->first_name ?? 'John' }}</p>
                    <p class="sub-label">First Name</p>
                </div>
                <div>
                    <p class="form-data">{{ $student->middle_name ?? 'Smith' }}</p>
                    <p class="sub-label">Middle Name</p>
                </div>
                <div>
                    <p class="form-data">{{ $student->extension_name ?? 'N/A' }}</p>
                    <p class="sub-label">Extension Name <span class="italic">(e.g. Jr, III)</span></p>
                </div>
            </div>

            <div>
                <p class="mb-2 field-label">Full Address</p>
                <div class="grid grid-cols-1 gap-y-4 gap-x-6 md:grid-cols-5">
                    <div class="md:col-span-5">
                        <p class="form-data">
                            {{ $student->current_address ?? 'Block 1, Lot 2, Friendly Subdivision, Brgy. San Jose, Tanza, Cavite, Philippines 4108' }}
                        </p>
                        <p class="sub-label">Block/Lot, Street, Subdivision, Barangay, Municipality/City, Province,
                            Country, Zip Code</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-y-4 gap-x-6 items-end md:grid-cols-6">
                <div class="md:col-span-2">
                    <p class="field-label">Date of Birth (DD/MM/YYYY):</p>
                    <p class="form-data">
                        {{ isset($student->date_of_birth) ? date('d / m / Y', strtotime($student->date_of_birth)) : '15 / 01 / 2010' }}
                    </p>
                </div>
                <div class="md:col-span-1">
                    <p class="field-label">Sex:</p>
                    <p class="form-data">{{ $student->sex ?? 'Male' }}</p>
                </div>
                <div class="md:col-span-1">
                    <p class="field-label">Age:</p>
                    <p class="form-data">
                        {{ isset($student->date_of_birth) ? date_diff(date_create($student->date_of_birth), date_create('today'))->y : '15' }}
                    </p>
                </div>
                <div class="md:col-span-2">
                    <p class="field-label">Place of Birth:</p>
                    <p class="form-data">{{ $student->place_of_birth ?? 'Manila, Philippines' }}</p>
                </div>
            </div>
        </div>

        <div class="p-6 border-t">
            <div class="grid grid-cols-1 gap-y-6 gap-x-8 md:grid-cols-3">
                <div class="space-y-4">
                    <p class="font-semibold">Father's Name</p>
                    <div>
                        <p class="form-data">{{ $student->father_last_name ?? '&nbsp;' }}</p>
                        <p class="sub-label">Last Name</p>
                    </div>
                    <div>
                        <p class="form-data">{{ $student->father_first_name ?? '&nbsp;' }}</p>
                        <p class="sub-label">First Name</p>
                    </div>
                    <div>
                        <p class="form-data">{{ $student->father_middle_name ?? '&nbsp;' }}</p>
                        <p class="sub-label">Middle Name</p>
                    </div>
                    <div>
                        <p class="field-label">Contact Number:</p>
                        <p class="form-data">{{ $student->father_contact_number ?? '&nbsp;' }}</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <p class="font-semibold">Mother's Name</p>
                    <div>
                        <p class="form-data">{{ $student->mother_last_name ?? 'Doe' }}</p>
                        <p class="sub-label">Last Name</p>
                    </div>
                    <div>
                        <p class="form-data">{{ $student->mother_first_name ?? 'Jane' }}</p>
                        <p class="sub-label">First Name</p>
                    </div>
                    <div>
                        <p class="form-data">{{ $student->mother_middle_name ?? 'Smith' }}</p>
                        <p class="sub-label">Middle Name</p>
                    </div>
                    <div>
                        <p class="field-label">Contact Number:</p>
                        <p class="form-data">{{ $student->mother_contact_number ?? '0917-123-4567' }}</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <p class="font-semibold">Guardian's Name</p>
                    <div>
                        <p class="form-data">{{ $student->guardian_last_name ?? '&nbsp;' }}</p>
                        <p class="sub-label">Last Name</p>
                    </div>
                    <div>
                        <p class="form-data">{{ $student->guardian_first_name ?? '&nbsp;' }}</p>
                        <p class="sub-label">First Name</p>
                    </div>
                    <div>
                        <p class="form-data">{{ $student->guardian_middle_name ?? '&nbsp;' }}</p>
                        <p class="sub-label">Middle Name</p>
                    </div>
                    <div>
                        <p class="field-label">Contact Number:</p>
                        <p class="form-data">{{ $student->guardian_contact_number ?? '&nbsp;' }}</p>
                    </div>
                </div>
            </div>
        </div>

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

            <div class="grid grid-cols-1 gap-x-12 gap-y-12 mt-12 md:grid-cols-2">
                <div>
                    <div class="w-full h-10 border-b-2 border-black"></div>
                    <p class="mt-1 text-center">Signature of Mother</p>
                </div>
                <div>
                    <div class="w-full h-10 border-b-2 border-black"></div>
                    <p class="mt-1 text-center">Date signed</p>
                </div>
                <div>
                    <div class="w-full h-10 border-b-2 border-black"></div>
                    <p class="mt-1 text-center">Signature of Father</p>
                </div>
                <div>
                    <div class="w-full h-10 border-b-2 border-black"></div>
                    <p class="mt-1 text-center">Date signed</p>
                </div>
                <div>
                    <div class="w-full h-10 border-b-2 border-black"></div>
                    <p class="mt-1 text-center">Signature of Guardian</p>
                </div>
                <div>
                    <div class="w-full h-10 border-b-2 border-black"></div>
                    <p class="mt-1 text-center">Date signed</p>
                </div>
            </div>
        </div>

    </div>

</body>



</html>
