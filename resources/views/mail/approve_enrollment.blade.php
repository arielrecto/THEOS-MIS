<!DOCTYPE html>
<html>
<head>
    <title>Enrollment Approved</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: #4CAF50;
            padding: 15px;
            text-align: center;
            color: #fff;
            font-size: 20px;
            font-weight: bold;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .content {
            padding: 20px;
        }
        .details {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #4CAF50;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
        }
        .btn:hover {
            background: #388E3C;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Enrollment Approved</div>

        <div class="content">
            <p>Dear <strong>{{ $enrollee->first_name }} {{ $enrollee->last_name }}</strong>,</p>
            <p>We are pleased to inform you that your enrollment has been <strong>approved</strong> for the academic year <strong>{{ $enrollee->school_year }}</strong>.</p>

            <div class="details">
                <p><strong>School Year:</strong> {{ $enrollee->school_year }}</p>
                <p><strong>Grade Level:</strong> {{ $enrollee->grade_level }}</p>
                <p><strong>Student ID:</strong> {{ $enrollee->student_id }}</p>
            </div>

            <p class="text-xs">
                Now login using the following credentials:
            </p>
            <div class="details">
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Password:</strong>password</p>
            </div>

            <p>You may now proceed with the next steps of the enrollment process. If you have any questions, feel free to reach out to us.</p>

            <p style="text-align: center;">
                <a href="{{ url('/') }}" class="btn">Visit Dashboard</a>
            </p>
        </div>

        <div class="footer">
            <p>Thank you for choosing our school! We look forward to seeing you soon.</p>
        </div>
    </div>
</body>
</html>
