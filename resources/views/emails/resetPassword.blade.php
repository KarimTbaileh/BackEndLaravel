<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Your Password</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f7f7f7; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <h2 style="color: #333;">Reset Your Password</h2>
        <p>Hi {{ $user->name ?? 'User' }},</p>
        <p>You requested to reset your password. Click the button below to proceed:</p>
        <p style="text-align: center; margin: 30px 0;">
            <a href="{{ $verificationUrl }}" style="background-color: #007bff; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;">
                Reset Password
            </a>
        </p>
        <p>If you did not request this, please ignore this email.</p>
        <hr>
        <p style="color: #777; font-size: 12px;">Thanks,<br>{{ config('app.name') }}</p>
    </div>
</body>
</html>
