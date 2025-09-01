<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Enrollment Form - {{ $student->last_name ?? 'Student' }}, {{ $student->first_name ?? 'Name' }}</title>
    {{-- Tailwind CSS CDN for styling --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Base styles for a professional print document */
        body {
            font-family: 'Inter', sans-serif;
            -webkit-print-color-adjust: exact; /* Ensures colors and backgrounds print correctly in WebKit browsers */
            print-color-adjust: exact;
        }

        /* Styles specifically for printing */
        @media print {
            body {
                margin: 0;
                padding: 0;
                background-color: #fff;
            }
            /* Hide the print button when printing */
            .no-print {
                display: none;
            }
            /* Ensure the main content uses the full page width */
            .print-container {
                box-shadow: none;
                margin: 0;
                max-width: 100%;
                border: none;
                padding: 0;
            }
        }

        /* Helper class for section titles */
        .section-title {
            @apply text-lg font-semibold text-gray-800 border-b pb-2 mb-4 flex items-center;
        }

        /* Helper class for data fields */
        .data-field {
            @apply mb-4;
        }
        .data-label {
            @apply text-sm text-gray-500;
        }
        .data-value {
            @apply text-base font-medium text-gray-900;
        }
    </style>
</head>
<body class="bg-gray-100 p-8">

    {{-- This button will be hidden when the user prints the document --}}
    <div class="no-print mb-8 text-center">
        <button onclick="window.print()" class="bg-blue-600 text-white font-bold py-2 px-6 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
            Print Document
        </button>
    </div>

    {{-- Main container for the print document, styled to look like a sheet of paper --}}
    <div id="print-area" class="print-container max-w-4xl mx-auto bg-white p-10 rounded-lg shadow-lg border border-gray-200">

        {{-- 1. Header Section --}}
        <header class="flex justify-between items-center pb-6 border-b">
            <div class="flex items-center gap-4">
                {{-- You can replace this with your school's actual logo --}}
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v11.494m-9-5.747h18"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18a6 6 0 100-12 6 6 0 000 12z"></path></svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Theos Higher Ground Academe</h1>
                    <p class="text-sm text-gray-500">Nurturing minds, shaping the future.</p>
                </div>
            </div>
            <div class="text-right">
                <h2 class="text-3xl font-bold text-gray-800">Student Enrollment Form</h2>
                <p class="text-sm text-gray-500">Official School Record</p>
            </div>
        </header>

        <main class="mt-8">

            {{-- 2. Enrollment Details --}}
            <section>
                <h3 class="section-title">
                     <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Enrollment Details
                </h3>
                <div class="grid grid-cols-3 gap-6">
                    <div class="data-field">
                        <p class="data-label">School Year</p>
                        <p class="data-value">{{ $student->school_year ?? '2025 - 2026' }}</p>
                    </div>
                    <div class="data-field">
                        <p class="data-label">Grade Level to Enroll</p>
                        <p class="data-value">{{ $student->grade_level ?? 'Grade 10' }}</p>
                    </div>
                    <div class="data-field">
                        <p class="data-label">Returning (Balik-Aral) Learner?</p>
                        <p class="data-value">{{ $student->is_returning ?? 'Yes' }}</p>
                    </div>
                </div>
            </section>

            {{-- 3. Student Information --}}
            <section class="mt-6">
                <h3 class="section-title">
                    <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Student Information
                </h3>
                <div class="grid grid-cols-4 gap-6">
                    <div class="data-field col-span-2">
                        <p class="data-label">Last Name</p>
                        <p class="data-value">{{ $student->last_name ?? 'Doe' }}</p>
                    </div>
                    <div class="data-field col-span-2">
                        <p class="data-label">First Name</p>
                        <p class="data-value">{{ $student->first_name ?? 'John' }}</p>
                    </div>
                     <div class="data-field col-span-2">
                        <p class="data-label">Middle Name</p>
                        <p class="data-value">{{ $student->middle_name ?? 'Smith' }}</p>
                    </div>
                     <div class="data-field col-span-2">
                        <p class="data-label">Extension Name (e.g., Jr., III)</p>
                        <p class="data-value">{{ $student->extension_name ?? 'N/A' }}</p>
                    </div>
                    <div class="data-field col-span-2">
                        <p class="data-label">Date of Birth</p>
                        <p class="data-value">{{ $student->date_of_birth ?? '01/15/2010' }}</p>
                    </div>
                    <div class="data-field col-span-2">
                        <p class="data-label">Place of Birth</p>
                        <p class="data-value">{{ $student->place_of_birth ?? 'Manila, Philippines' }}</p>
                    </div>
                </div>
            </section>

            {{-- 4. Address Information --}}
            <section class="mt-6">
                 <h3 class="section-title">
                     <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Address Information
                </h3>
                <div class="grid grid-cols-2 gap-x-12">
                    <div>
                        <h4 class="font-semibold text-gray-700 mb-2">Current Address</h4>
                        <p class="data-value">{{ $student->current_address ?? '123 Rizal St., Brgy. San Juan, Pasig City, Metro Manila, 1600' }}</p>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-700 mb-2">Permanent Address</h4>
                        <p class="data-value">{{ $student->permanent_address ?? '123 Rizal St., Brgy. San Juan, Pasig City, Metro Manila, 1600' }}</p>
                    </div>
                </div>
            </section>

            {{-- 5. Parent/Guardian Information --}}
            <section class="mt-6">
                 <h3 class="section-title">
                    <svg class="w-5 h-5 mr-2 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m-7.5-2.962a3.75 3.75 0 015.25 0m-5.25 0a3.75 3.75 0 00-5.25 0M12 15v.01M12 12v.01M12 9v.01M12 6v.01M3 9h18a1.5 1.5 0 000-3H3a1.5 1.5 0 000 3zm-1.5 9a1.5 1.5 0 011.5-1.5h15a1.5 1.5 0 011.5 1.5v2.25a1.5 1.5 0 01-1.5 1.5h-15a1.5 1.5 0 01-1.5-1.5V18z" /></svg>
                    Parent/Guardian Information
                </h3>
                <div class="grid grid-cols-2 gap-6">
                    <div class="data-field">
                        <p class="data-label">Full Name</p>
                        <p class="data-value">{{ $student->guardian->name ?? 'Jane S. Doe' }}</p>
                    </div>
                    <div class="data-field">
                        <p class="data-label">Relationship to Student</p>
                        <p class="data-value">{{ $student->guardian->relationship ?? 'Mother' }}</p>
                    </div>
                    <div class="data-field">
                        <p class="data-label">Contact Number</p>
                        <p class="data-value">{{ $student->guardian->contact_number ?? '0917-123-4567' }}</p>
                    </div>
                    <div class="data-field">
                        <p class="data-label">Occupation</p>
                        <p class="data-value">{{ $student->guardian->occupation ?? 'Accountant' }}</p>
                    </div>
                </div>
            </section>
             <section class="mt-6">
                 <h3 class="section-title">
                    <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Contact Information
                </h3>
                <div class="data-field">
                    <p class="data-label">Email Address (for verification purposes only)</p>
                    <p class="data-value">{{ $student->guardian->email ?? 'jane.doe@example.com' }}</p>
                </div>
            </section>

        </main>

        {{-- 6. Footer & Signature Section --}}
        <footer class="mt-12 pt-8 border-t-2 border-dashed">
             <p class="text-sm text-gray-600 mb-8">
                I hereby certify that all information provided in this form is complete, true, and correct to the best of my knowledge.
            </p>
            <div class="grid grid-cols-2 gap-12">
                <div>
                    <div class="border-t-2 border-gray-400 pt-2">
                        <p class="font-semibold text-center">Parent's / Guardian's Signature Over Printed Name</p>
                    </div>
                </div>
                 <div>
                    <div class="border-t-2 border-gray-400 pt-2">
                        <p class="font-semibold text-center">Date</p>
                    </div>
                </div>
            </div>
            <div class="mt-12 text-center text-xs text-gray-400">
                &copy; {{ date('Y') }} Theos Higher Ground Academe. All rights reserved.
            </div>
        </footer>

    </div>

</body>
</html>
