{{-- resources/views/qr.blade.php --}}
@extends('layouts.app')

@section('content')
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .intern-registration {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9fafb;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .intern-registration .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .intern-registration h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #2d3748;
        }

        .intern-registration .info-box {
            background: #e6fffa;
            border: 1px solid #81e6d9;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }

        .intern-registration .btn {
            background-color: #3182ce;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin: 10px;
        }

        .intern-registration .btn:hover {
            background-color: #2b6cb0;
        }
    </style>

    <div class="intern-registration">
        <div class="container">
            <h1>Intern Registration</h1>
            
            <div class="info-box">
                <h3>📋 New Registration Process</h3>
                <p>Intern registration is now available through the Intern Login page with a step-by-step modal system.</p>
                <p>Please go to the Intern Login page to register with the new phase-based system.</p>
            </div>

            <a href="{{ route('intern.login') }}" class="btn">Go to Intern Login</a>
            <a href="{{ route('login') }}" class="btn">Back to Main Login</a>
        </div>
    </div>
@endsection
