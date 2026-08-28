<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email - OTP</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background:#0b1220 url('{{ asset('logo.png') }}') center center no-repeat fixed; background-size: 240px auto; min-height:100vh; display:flex; align-items:center; justify-content:center; }
        .card { width:100%; max-width:420px; background: rgba(255,255,255,0.12); backdrop-filter: blur(14px); border:1px solid rgba(255,255,255,0.25); border-radius:16px; box-shadow: 0 15px 40px rgba(0,0,0,0.25); padding:28px; color:#fff; }
        h1 { margin:0 0 8px; font-size:22px; }
        p { margin:0 0 16px; color: rgba(255,255,255,0.9); }
        .otp-input { width:100%; padding:14px; border-radius:8px; border:1px solid rgba(255,255,255,0.35); background:rgba(255,255,255,0.15); color:#fff; font-size:20px; letter-spacing:8px; text-align:center; }
        .actions { display:flex; gap:10px; margin-top:16px; }
        .btn { flex:1; padding:12px; border:none; border-radius:8px; cursor:pointer; color:#fff; font-size:14px; }
        .btn-primary { background: linear-gradient(135deg, #457b9d, #1d3557); }
        .btn-secondary { background:#6c757d; }
        .muted { margin-top:12px; font-size:12px; color: rgba(255,255,255,0.8); text-align:center; }
        .error { color:#f87171; background: rgba(239,68,68,0.15); border:1px solid rgba(239,68,68,0.4); padding:10px; border-radius:8px; font-size:14px; margin-bottom:10px; text-align:center; }
        .success { color:#22c55e; background: rgba(34,197,94,0.15); border:1px solid rgba(34,197,94,0.4); padding:10px; border-radius:8px; font-size:14px; margin-bottom:10px; text-align:center; }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="card">
    <h1>Verify your email</h1>
    <p>We sent a 6-digit code to <b>{{ $email }}</b>. Enter it below to verify.</p>

    @if(session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('otp.verify.submit') }}" id="otpForm">
        @csrf
        <input type="hidden" name="email" value="{{ old('email', $email) }}">
        <input class="otp-input" id="otpInput" type="text" name="otp" maxlength="6" pattern="\d{6}" required placeholder="••••••" autocomplete="one-time-code" inputmode="numeric">
        <div class="actions">
            <button type="submit" class="btn btn-primary">Verify</button>
            <button type="button" class="btn btn-secondary" onclick="resendOtp()">Resend</button>
        </div>
    </form>
    <div class="muted">Code expires in 10 minutes.</div>
</div>

<script>
function resendOtp() {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const email = document.querySelector('input[name="email"]').value;
    fetch('{{ route('otp.resend') }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
        body: JSON.stringify({ email })
    }).then(r => r.json()).then(data => {
        if (data.success) {
            Swal.fire('Sent', 'A new code has been emailed to you.', 'success');
        } else {
            Swal.fire('Error', data.message || 'Failed to resend code.', 'error');
        }
    }).catch(() => Swal.fire('Error', 'Failed to resend code.', 'error'));
}

// Enhance OTP input: allow paste, keep only digits, auto-submit on 6 digits
const otpInput = document.getElementById('otpInput');
const otpForm = document.getElementById('otpForm');
if (otpInput && otpForm) {
    otpInput.addEventListener('paste', (e) => {
        e.preventDefault();
        const text = (e.clipboardData || window.clipboardData).getData('text');
        const digits = (text || '').replace(/\D/g, '').slice(0, 6);
        otpInput.value = digits;
        if (digits.length === 6) otpForm.submit();
    });
    otpInput.addEventListener('input', () => {
        otpInput.value = otpInput.value.replace(/\D/g, '').slice(0, 6);
    });
    otpInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && otpInput.value.replace(/\D/g, '').length === 6) {
            e.preventDefault();
            otpForm.submit();
        }
    });
    setTimeout(() => otpInput.focus(), 50);
}
</script>

</body>
</html>


