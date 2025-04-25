<!DOCTYPE html>
<html>
<head>
    <title>Company Account Approved</title>
</head>
<body>
    <h1>Congratulations!</h1>
    <p>Dear {{ $user->name }},</p>
    <p>Your company account has been approved by our administrators. You can now log in to your account and start using our platform.</p>
    <p>Click the button below to log in:</p>
    <a href="{{ $loginUrl }}" style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Login to Your Account</a>
    <p>If you have any questions, please don't hesitate to contact our support team.</p>
    <p>Best regards,<br>The Jusoor Work Team</p>
</body>
</html> 