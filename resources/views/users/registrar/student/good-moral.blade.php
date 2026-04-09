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

            .page-break {
                page-break-after: always;
            }

            .header-image {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
        }

        .certificate {
            max-width: 8.5in;
            margin: 0 auto;
            padding: 0.75in 1in;
        }

        .header-image {
            width: 100%;
            max-width: 100%;
            height: auto;
            margin-bottom: 1.5rem;
            display: block;
            mix-blend-mode: multiply; /* or 'darken' */
            background: transparent;
        }

        .certificate-title {
            text-align: center;
            margin: 2rem 0 2rem;
        }

        .certificate-title h2 {
            font-size: 20px;
            font-weight: bold;
            margin: 0;
            letter-spacing: 1px;
        }

        .content {
            text-align: justify;
            margin: 2rem 0;
            line-height: 1.8;
            font-size: 13px;
        }

        .content p {
            margin-bottom: 1.5rem;
            text-indent: 3em;
        }

        .content p:first-child {
            margin-top: 0;
        }

        .to-whom {
            text-align: left;
            font-weight: bold;
            margin-bottom: 1.5rem;
            font-size: 13px;
            text-indent: 0;
        }

        .issue-date {
            margin-top: 2rem;
            text-align: left;
            font-size: 13px;
            text-indent: 3em;
        }

        .signature-section {
            margin-top: 3rem;
            text-align: center;
        }

        .signature-line {
            display: inline-block;
            text-align: center;
        }

        .signature-line p {
            margin: 0;
            font-size: 13px;
        }

        .signature-line .name {
            font-weight: bold;
            margin-bottom: 0.25rem;
            border-bottom: 2px solid #000;
            padding-bottom: 0.25rem;
            min-width: 250px;
            display: inline-block;
        }

        .signature-line .title {
            font-style: italic;
            margin-top: 0.25rem;
        }

        .footer-note {
            margin-top: 2rem;
            text-align: left;
            font-size: 10px;
            font-style: italic;
        }

        strong {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <!-- Print Button -->
    <div class="no-print fixed top-4 right-4 flex gap-2 z-50">
        <a href="{{ route('registrar.students.show', $student->id) }}" class="btn btn-ghost">
            <i class="fi fi-rr-arrow-left mr-2"></i>Back
        </a>
        <button onclick="window.print()" class="btn btn-accent">
            <i class="fi fi-rr-print mr-2"></i>Print Certificate
        </button>
    </div>

    <div class="certificate">
        <!-- Header Image -->
        <div>
            <img src="{{ asset('Gemini_Generated_Image_lovq03lovq03lovq.png') }}"
                 alt="Theos Higher Ground Academe Header"
                 class="header-image">
        </div>

        <!-- Certificate Title -->
        <div class="certificate-title">
            <h2>Certificate of Good Moral Character</h2>
        </div>

        <!-- Content -->
        <div class="to-whom">
            TO WHOM IT MAY CONCERN:
        </div>

        <div class="content">
            <p>This is to certify that <strong>{{ strtoupper($student->name) }}</strong>, with LRN: <strong>{{ $student->studentProfile?->lrn ?? 'N/A' }}</strong> was a bonafide student of THEOS HIGHER GROUND ACADEME INC., school year <strong>{{ $student->studentProfile?->academicRecords->first()?->academicYear?->name ?? '________' }}</strong>. This further certifies that he/she is a law abiding pupil with good moral character and has been seen as record of misconduct.</p>

            <p>This certification is issued for whatever legal purposes it may serve him/her.</p>

            <p>Given on this 15th day of April 2024 at Theos Higher Ground Academe.</p>
        </div>

        <!-- Signature Section -->
        <div class="signature-section">
            <div class="signature-line">
                <p class="name">Ms. Esther Fe O. Rendal, LPT, MAED</p>
                <p class="title">School Principal</p>
            </div>
        </div>

        <!-- Footer Note -->
        <div class="footer-note">
            Not valid without school seal
        </div>
    </div>
</body>

</html>
