<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Company Account Approved</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            color: #4F46E5;
            font-size: 24px;
            font-weight: bold;
        }
        .content {
            background-color: #f9fafb;
            padding: 30px;
            border-radius: 8px;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4F46E5;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">Jusoor Work</div>
    </div>

    <div class="content">
        <h2>Congratulations!</h2>
        <p>Dear {{ $company->company_name }},</p>
        
        <p>We are pleased to inform you that your company account has been approved on the Jusoor Work platform. You can now start posting job opportunities and connecting with talented Syrian students and graduates.</p>

        <p>To get started, please log in to your account using the button below:</p>

        <div style="text-align: center;">
            <a href="{{ route('login') }}" class="button">Login to Your Account</a>
        </div>

        <p>If you have any questions or need assistance, please don't hesitate to contact our support team.</p>

        <p>Best regards,<br>The Jusoor Work Team</p>
    </div>

    <div class="footer">
        <p>This is an automated message, please do not reply to this email.</p>
        <p>&copy; {{ date('Y') }} Jusoor Work. All rights reserved.</p>
    </div>
</body>
</html> 