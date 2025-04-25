<!DOCTYPE html>
<html>
<head>
    <title>Company Account Rejected</title>
</head>
<body>
    <h1>Account Application Update</h1>
    <p>Dear {{ $user->name }},</p>
    <p>We regret to inform you that your company account application has been rejected by our administrators.</p>
    <p><strong>Reason for rejection:</strong></p>
    <p>{{ $reason }}</p>
    <p>If you believe this decision was made in error or if you have additional information to provide, please contact our support team.</p>
    <p>Best regards,<br>The Jusoor Work Team</p>
</body>
</html> 