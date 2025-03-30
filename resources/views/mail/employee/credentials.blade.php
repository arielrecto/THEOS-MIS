<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to {{ config('app.name') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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
        .credentials {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Welcome to {{ config('app.name') }}</h2>
        </div>

        <div class="content">
            <p>Dear {{ $user->name }},</p>

            <p>Welcome to the team! Your employee account has been created successfully. Below are your login credentials:</p>

            <div class="credentials">
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Password:</strong> {{ $password }}</p>
            </div>

            <p>For security reasons, we recommend changing your password after your first login.</p>

            <p>To access your account, please visit: <a href="{{ route('login') }}">{{ route('login') }}</a></p>

            <p>If you have any questions or need assistance, please contact the HR department.</p>

            <p>Best regards,<br>HR Team</p>
        </div>

        <div class="footer">
            <p>This email contains confidential information. Please do not share your credentials.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
