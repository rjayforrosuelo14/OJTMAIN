<!DOCTYPE html>
<html>
<head>
    <title>Intern Journal Upload</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f2f5;
            padding: 40px;
            margin: 0;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }

        input[type="file"] {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #ccc;
            margin-bottom: 15px;
        }

        button {
            background-color: #3490dc;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2779bd;
        }

        .alert {
            margin-top: 15px;
            padding: 12px;
            border-radius: 6px;
            font-size: 15px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #3490dc;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>📎 Upload Journal Entry (.docx)</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('intern.journal.submit') }}" enctype="multipart/form-data">
        @csrf

        <label for="journal_file">Attach .docx File:</label>
        <input type="file" name="journal_file" accept=".docx" required>

        <button type="submit">Upload Entry</button>
    </form>

    <a href="{{ route('intern.dashboard') }}" class="back-link">← Back to Dashboard</a>
</div>
</body>
</html>
