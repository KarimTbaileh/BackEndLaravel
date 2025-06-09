<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Account Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f7;
            color: #51545e;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 2rem auto;
            background: #ffffff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .btn {
            display: inline-block;
            background: #22bc66;
            color: white !important;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
        }
        h1 {
            color: #333333;
        }
        p {
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Hello {{ $user->email }}!</h1>
        <p>Thank you for registering with us. Please click the button below to verify your account:</p>
        <p>
            <a href="{{ $verificationUrl }}" class="btn">Verify Account</a>
        </p>
        <p>If you did not register, you can safely ignore this email.</p>
        <p>Best regards,<br>The Support Team</p>
    </div>
</body>
</html>
