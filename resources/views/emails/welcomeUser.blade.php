<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Welcome Email</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f7fa;
        margin: 0;
        padding: 0;
        -webkit-text-size-adjust: 100%;
    }
    .email-container {
        max-width: 600px;
        margin: 30px auto;
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        padding: 30px;
        color: #333333;
    }
    h1 {
        color: #2c3e50;
        font-weight: 700;
        font-size: 24px;
        margin-bottom: 10px;
    }
    p {
        font-size: 16px;
        line-height: 1.5;
        margin-top: 0;
        margin-bottom: 20px;
        color: #555555;
    }
    ul {
        list-style-type: none;
        padding: 0;
        margin-bottom: 20px;
    }
    ul li {
        background: #ecf0f1;
        margin-bottom: 8px;
        padding: 10px 15px;
        border-radius: 4px;
        font-weight: 600;
    }
    .footer {
        font-size: 14px;
        color: #999999;
        text-align: center;
        border-top: 1px solid #e1e4e8;
        padding-top: 15px;
        margin-top: 20px;
    }
    .btn {
        display: inline-block;
        padding: 12px 25px;
        background-color: #3498db;
        color: white !important;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 600;
        margin-top: 10px;
    }
    .btn:hover {
        background-color: #2980b9;
    }
</style>
</head>
<body>
<div class="email-container">
    <h1>Welcome to Our Community, {{ $user->email }}!</h1>
    <p>Thank you for joining us. We’re thrilled to have you on board and can’t wait for you to get started.</p>

    <p>Here’s a quick summary of your account details:</p>
    <ul>
        <li><strong>Email:</strong> {{ $user->email }}</li>
        <li><strong>Role:</strong> {{ ucfirst($user->role) }}</li>
    </ul>

    <p>If you have any questions or need assistance, feel free to reach out anytime.</p>

    <a href="{{ url('http://cap-test.com') }}" class="btn">Visit Our Website</a>

    <div class="footer">
        &copy; {{ date('Y') }} Your Company. All rights reserved.
    </div>
</div>
</body>
</html>
