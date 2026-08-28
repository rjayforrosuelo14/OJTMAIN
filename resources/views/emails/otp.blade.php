<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>OJT Verification Code</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f6f8fb; padding:24px; }
        .card { max-width:560px; margin:0 auto; background:#ffffff; border:1px solid #eee; border-radius:8px; padding:24px; }
        .code { font-size:32px; letter-spacing:6px; font-weight:700; text-align:center; padding:16px; border:1px dashed #ccd; border-radius:8px; background:#f9fbff; }
        .muted { color:#667085; font-size:14px; }
        h1 { margin:0 0 12px; font-size:20px; }
    </style>
    </head>
<body>
    <div class="card">
        <h1>Your verification code</h1>
        <p>Use the code below to verify your email for OJT Management System:</p>
        <div class="code">{{ $otpCode }}</div>
        <p class="muted">This code expires in 10 minutes. If you didn’t request this, you can safely ignore this email.</p>
    </div>
</body>
</html>














