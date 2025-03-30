<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Status Update</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 0 0 5px 5px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #6c757d;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 14px;
            font-weight: 600;
            margin: 10px 0;
        }
        .status-screening { background-color: #e3f2fd; color: #1976d2; }
        .status-interview { background-color: #fff3e0; color: #f57c00; }
        .status-hired { background-color: #e8f5e9; color: #2e7d32; }
        .status-rejected { background-color: #ffebee; color: #c62828; }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4f46e5;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>{{ config('app.name') }}</h2>
        </div>

        <div class="content">
            <h3>Dear {{ $applicant->name }},</h3>

            @switch($newStatus)
                @case('screening')
                    <p>We are pleased to inform you that your application for the position of <strong>{{ $applicant->position->name }}</strong> has been shortlisted for further consideration.</p>
                    <p>Our HR team will be reviewing your application in detail and will contact you soon regarding the next steps.</p>
                    <div class="status-badge status-screening">Application Shortlisted</div>
                    @break

                @case('interview')
                    <p>Following our initial review, we would like to invite you for an interview for the position of <strong>{{ $applicant->position->name }}</strong>.</p>
                    <p>Our HR team will contact you shortly to schedule the interview at a convenient time.</p>
                    <p>Please prepare the following documents:</p>
                    <ul>
                        <li>Updated Resume</li>
                        <li>Valid ID</li>
                        <li>Portfolio (if applicable)</li>
                    </ul>
                    <div class="status-badge status-interview">Interview Stage</div>
                    @break

                @case('hired')
                    <p>Congratulations! We are delighted to inform you that you have been selected for the position of <strong>{{ $applicant->position->name }}</strong>.</p>
                    <p>You will receive a formal offer letter shortly with detailed information about your employment terms and next steps.</p>
                    <div class="status-badge status-hired">Hired</div>
                    @break

                @case('rejected')
                    <p>Thank you for your interest in the position of <strong>{{ $applicant->position->name }}</strong> and for taking the time to go through our recruitment process.</p>
                    <p>After careful consideration, we regret to inform you that we have decided to move forward with other candidates whose qualifications more closely match our current needs.</p>
                    <div class="status-badge status-rejected">Application Closed</div>
                    @break

                @default
                    <p>Your application status has been updated for the position of <strong>{{ $applicant->position->name }}</strong>.</p>
                    <p>Current Status: {{ ucfirst($newStatus) }}</p>
            @endswitch

            {{-- @if($notes)
                <p><strong>Additional Notes:</strong></p>
                <p>{{ $notes }}</p>
            @endif --}}

            {{-- <a href="{{ route('careers.status', $applicant->tracking_code) }}" class="button">View Application Status</a> --}}
        </div>

        <div class="footer">
            <p>This is an automated message, please do not reply to this email.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
