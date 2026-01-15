<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Good Moral Character</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.24/dist/full.min.css" rel="stylesheet">
    <style>
        @media print {
            body {
                padding: 0;
                margin: 0;
            }

            .no-print {
                display: none;
            }
        }

        .certificate {
            max-width: 8.5in;
            margin: 0 auto;
            padding: 1in;
            text-align: center;
        }

        .school-logo {
            width: 100px;
            height: auto;
            margin-bottom: 1rem;
        }

        .content {
            text-align: justify;
            margin: 2rem 0;
            line-height: 2;
        }

        .signature-line {
            width: 200px;
            border-top: 1px solid #000;
            margin: 3rem auto 0;
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- Print Button -->
    <div class="no-print fixed top-4 right-4 flex gap-2">
        <a href="{{ route('registrar.students.show', $student->id) }}" class="btn btn-ghost">
            <i class="fi fi-rr-arrow-left mr-2"></i>Back
        </a>
        <button onclick="window.print()" class="btn btn-accent">
            <i class="fi fi-rr-print mr-2"></i>Print Certificate
        </button>
    </div>

    <div class="certificate">
        <img src="{{ asset('logo-modified.png') }}" alt="School Logo" class="school-logo">
        <h1 class="text-xl font-bold">Theos Higher Ground Academe</h1>
        <p>Fairgrounds, Imus City,
            Cavite.</p>

        <h2 class="text-2xl font-bold mt-12 mb-8">CERTIFICATE OF GOOD MORAL CHARACTER</h2>

        <div class="content">
            <p>This is to certify that <strong>{{ $student->name }}</strong>, with LRN
                <strong>{{ $student->studentProfile?->lrn ?? 'N\A' }}</strong>,
                has been a student of this institution and has demonstrated GOOD MORAL CHARACTER.
            </p>

            <p>During his/her stay in this school, he/she has not been found guilty of any misconduct nor has been
                subjected
                to any disciplinary action.</p>

            <p>This certification is issued upon the request of the above-named student for whatever legal purpose it
                may serve.</p>

            <p>Issued this {{ $currentDate }} at Theos Higher Ground Academe, Tanza, Cavite.</p>
        </div>

        <div class="signature-line">
            <p class="font-bold">School Principal</p>
        </div>
    </div>
</body>

</html>
