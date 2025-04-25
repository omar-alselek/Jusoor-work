<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Company Account Application Rejected</title>
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
        .reason {
            background-color: #fff;
            padding: 15px;
            border-left: 4px solid #EF4444;
            margin: 20px 0;
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
        <h2>Application Status Update</h2>
        <p>Dear {{ $company->company_name }},</p>
        
        <p>We regret to inform you that your company account application has been rejected after review by our team.</p>

        <div class="reason">
            <strong>Reason for rejection:</strong>
            <p>{{ $rejectionReason }}</p>
        </div>

        <p>If you believe this decision was made in error or if you would like to address the issues mentioned above, you may submit a new application with the required corrections.</p>

        <p>To submit a new application, please visit our registration page:</p>

        <div style="text-align: center;">
            <a href="{{ route('register') }}" class="button">Submit New Application</a>
        </div>

        <p>If you have any questions or need clarification, please don't hesitate to contact our support team.</p>

        <p>Best regards,<br>The Jusoor Work Team</p>
    </div>

    <div class="footer">
        <p>This is an automated message, please do not reply to this email.</p>
        <p>&copy; {{ date('Y') }} Jusoor Work. All rights reserved.</p>
    </div>
</body>
</html> 