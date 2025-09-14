<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Enrollment Form - {{ $student->last_name ?? 'Student' }}, {{ $student->first_name ?? 'Name' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.24/dist/full.min.css" rel="stylesheet">
    <style>
        @media print {
            body { 
                padding: 0; 
                margin: 0; 
                background-color: #fff;
            }
            .no-print { 
                display: none; 
            }
            @page {
                margin: 0;
                size: A4;
            }
        }
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            line-height: 1.6;
            color: #111827;
        }
        .print-container {
            max-width: 21cm;
            margin: 0 auto;
            padding: 2cm;
            background-color: #fff;
        }
        .school-logo {
            width: 100px;
            height: auto;
            margin-bottom: 1rem;
        }
        .section-title {
            padding-bottom: 0.5rem;
            margin: 2rem 0 1rem;
            border-bottom: 2px solid #e5e7eb;
            font-size: 1.125rem;
            font-weight: 600;
            color: #1f2937;
        }
        .data-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .data-field {
            margin-bottom: 1rem;
        }
        .data-label {
            color: #6b7280;
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
        }
        .data-value {
            color: #111827;
            font-weight: 500;
        }
        .signature-line {
            width: 300px;
            border-top: 1px solid #000;
            margin: 4rem auto 0;
            text-align: center;
            padding-top: 0.5rem;
        }
        .footer-note {
            margin-top: 2rem;
            padding: 1rem;
            background-color: #f9fafb;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            color: #4b5563;
        }
    </style>
</head>
<body>
    <!-- Print Button -->
    <div class="flex fixed top-4 right-4 gap-2 no-print">
        <a href="/" class="btn btn-ghost">
            <i class="mr-2 fi fi-rr-arrow-left"></i>Back
        </a>
        <button onclick="window.print()" class="btn btn-accent">
            <i class="mr-2 fi fi-rr-print"></i>Print Form
        </button>
    </div>

    <div class="print-container">
        <!-- Header -->
        <header class="mb-8 text-center">
            <img src="{{ asset('logo-modified.png') }}" alt="School Logo" class="mx-auto school-logo">
            <h1 class="text-2xl font-bold">Theos Higher Ground Academe</h1>
            <p class="text-gray-600">Daang Amaya III, Tanza, Cavite</p>
            <h2 class="mt-6 text-3xl font-bold">Student Enrollment Form</h2>
            <p class="text-gray-500">Academic Year {{ date('Y') }} - {{ date('Y') + 1 }}</p>
        </header>

        <main>
            <!-- Enrollment Details -->
            <section>
                <h3 class="section-title">Enrollment Details</h3>
                <div class="data-grid">
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

            <!-- Student Information -->
            <section>
                <h3 class="section-title">Student Information</h3>
                <div class="data-grid">
                    <div class="data-field">
                        <p class="data-label">Last Name</p>
                        <p class="data-value">{{ $student->last_name ?? 'Doe' }}</p>
                    </div>
                    <div class="data-field">
                        <p class="data-label">First Name</p>
                        <p class="data-value">{{ $student->first_name ?? 'John' }}</p>
                    </div>
                    <div class="data-field">
                        <p class="data-label">Middle Name</p>
                        <p class="data-value">{{ $student->middle_name ?? 'Smith' }}</p>
                    </div>
                    <div class="data-field">
                        <p class="data-label">Extension Name</p>
                        <p class="data-value">{{ $student->extension_name ?? 'N/A' }}</p>
                    </div>
                    <div class="data-field">
                        <p class="data-label">Date of Birth</p>
                        <p class="data-value">{{ $student->date_of_birth ?? '01/15/2010' }}</p>
                    </div>
                    <div class="data-field">
                        <p class="data-label">Place of Birth</p>
                        <p class="data-value">{{ $student->place_of_birth ?? 'Manila, Philippines' }}</p>
                    </div>
                </div>
            </section>

            <!-- Address Information -->
            <section>
                <h3 class="section-title">Address Information</h3>
                <div class="data-grid">
                    <div class="data-field">
                        <p class="data-label">Current Address</p>
                        <p class="data-value">{{ $student->current_address ?? '123 Rizal St., Brgy. San Juan, Pasig City, Metro Manila, 1600' }}</p>
                    </div>
                    <div class="data-field">
                        <p class="data-label">Permanent Address</p>
                        <p class="data-value">{{ $student->permanent_address ?? '123 Rizal St., Brgy. San Juan, Pasig City, Metro Manila, 1600' }}</p>
                    </div>
                </div>
            </section>

            <!-- Parent/Guardian Information -->
            <section>
                <h3 class="section-title">Parent/Guardian Information</h3>
                <div class="data-grid">
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
                        <p class="data-label">Email Address</p>
                        <p class="data-value">{{ $student->guardian->email ?? 'jane.doe@example.com' }}</p>
                    </div>
                    <div class="data-field">
                        <p class="data-label">Occupation</p>
                        <p class="data-value">{{ $student->guardian->occupation ?? 'Accountant' }}</p>
                    </div>
                </div>
            </section>

            <!-- Contact Information -->
            <section class="mt-6">
                <h3 class="section-title">
                    {{-- <svg class="mr-2 w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> --}}
                    Contact Information
                </h3>
                <div class="data-field">
                    <p class="data-label">Email Address (for verification purposes only)</p>
                    <p class="data-value">{{ $student->guardian->email ?? 'jane.doe@example.com' }}</p>
                </div>
            </section>
        </main>

        <!-- Signature Section -->
        <div class="mt-12">
            <div class="footer-note">
                I hereby certify that all information provided in this form is complete, true, and correct to the best of my knowledge.
                I understand that any false information may result in the denial of admission or dismissal from the school.
            </div>

            <div class="flex justify-between mt-8">
                <div class="signature-line">
                    <p class="font-medium">Parent's/Guardian's Signature</p>
                    <p class="text-sm text-gray-600">Over Printed Name</p>
                </div>
                <div class="signature-line">
                    <p class="font-medium">Date</p>
                    <p class="text-sm text-gray-600">MM/DD/YYYY</p>
                </div>
            </div>

            <!-- Official Use Section -->
            <div class="p-6 mt-16 bg-gray-50 rounded-lg">
                <p class="mb-4 text-sm font-medium text-gray-700">FOR OFFICIAL USE ONLY</p>
                <div class="flex justify-between">
                    <div class="signature-line">
                        <p class="font-medium">Registrar's Signature</p>
                        <p class="text-sm text-gray-600">Over Printed Name</p>
                    </div>
                    <div class="signature-line">
                        <p class="font-medium">Date Processed</p>
                        <p class="text-sm text-gray-600">MM/DD/YYYY</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 text-sm text-center text-gray-500">
            &copy; {{ date('Y') }} Theos Higher Ground Academe. All rights reserved.
        </div>
    </div>
</body>
</html>
