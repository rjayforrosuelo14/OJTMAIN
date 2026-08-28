<!DOCTYPE html>
<html>
<head>
    <title>Send Grades</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f8;
            padding: 30px;
        }

        .container {
            max-width: 520px;
            margin: auto;
            background: #ffffff;
            padding: 35px;
            border-radius: 18px;
            border: 1px solid rgba(15, 23, 42, 0.08);
            box-shadow: 0 24px 68px rgba(15, 23, 42, 0.08);
        }

        h2 {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            color: #102a43;
            margin-bottom: 28px;
            font-size: 26px;
            letter-spacing: 0.01em;
        }

        .header-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            border-radius: 16px;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            box-shadow: 0 14px 30px rgba(37, 99, 235, 0.25);
            animation: icon-pop 1.8s ease-in-out infinite;
        }

        .header-icon svg {
            width: 22px;
            height: 22px;
            fill: white;
        }

        label {
            display: block;
            margin: 12px 0 6px;
            font-weight: bold;
            color: #333;
        }

        input[type="file"], select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        input[type="file"], select {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid #d9e2ec;
            border-radius: 12px;
            background: #f8fafc;
            color: #102a43;
            font-size: 14px;
            transition: border-color 0.25s ease, box-shadow 0.25s ease;
        }

        input[type="file"]:focus, select:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.12);
        }

        button {
            margin-top: 24px;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: #ffffff;
            border: none;
            padding: 16px 18px;
            font-size: 16px;
            border-radius: 14px;
            cursor: pointer;
            width: 100%;
            font-weight: 700;
            letter-spacing: 0.02em;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            box-shadow: 0 16px 28px rgba(37, 99, 235, 0.18);
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 32px rgba(37, 99, 235, 0.22);
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            margin-top: 22px;
            color: #475569;
            text-decoration: none;
            font-weight: 600;
        }

        .back-link:hover {
            color: #1d4ed8;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .success-message, .error-message {
            text-align: center;
            font-weight: 700;
            margin-bottom: 18px;
            padding: 16px 18px;
            border-radius: 12px;
            background: rgba(16, 148, 91, 0.08);
            border: 1px solid rgba(16, 148, 91, 0.18);
            color: #0f766e;
        }

        .error-message {
            background: rgba(220, 38, 38, 0.08);
            border-color: rgba(220, 38, 38, 0.18);
            color: #b91c1c;
        }

        .request-list {
            margin-top: 24px;
            background: #f1f5f9;
            padding: 20px;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            font-size: 14px;
            color: #334155;
        }

        .request-list ul {
            padding-left: 20px;
            margin: 10px 0 0;
            list-style: disc;
        }

        .request-list strong {
            display: block;
            margin-bottom: 10px;
            font-size: 15px;
            color: #0f172a;
        }

        .request-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #e0f2fe;
            color: #0369a1;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 13px;
            margin-bottom: 8px;
        }

        @keyframes icon-pop {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            45% {
                transform: translateY(-4px) scale(1.05);
            }
            60% {
                transform: translateY(-2px) scale(1.03);
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>
        <span class="header-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M12 1.75a9.75 9.75 0 1 0 9.75 9.75A9.761 9.761 0 0 0 12 1.75Zm.75 5.5a.75.75 0 0 1 1.5 0V12a.75.75 0 0 1-.39.66l-2.5 1.5a.75.75 0 1 1-.72-1.32l2.11-1.27V7.25Zm-2.5 10.5a7.983 7.983 0 0 1-4.779-1.553.75.75 0 1 1 .858-1.22A6.5 6.5 0 1 0 13.5 4.5a.75.75 0 0 1 0 1.5 5 5 0 1 1-5 5 .75.75 0 1 1-1.5 0 6.5 6.5 0 0 0 5.776 6.446.75.75 0 0 1-.094 1.492Z"/>
            </svg>
        </span>
        Send Grades
    </h2>

    @if(session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="error-message">{{ session('error') }}</div>
    @endif

    <form action="{{ route('intern.uploadDocx') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="grade_doc">Upload .doc or .docx file:</label>
        <input type="file" name="grade_doc" accept=".doc,.docx" required>

        <label for="semester">Select Document Type:</label>
        <select name="semester" required>
            <option value="">-- Choose --</option>
            <option value="3rd">Certificate</option>
            <option value="4th">Evaluation Form</option>
        </select>

        <button type="submit"> Submit Data</button>
    </form>

    @if(!empty($requests))
        <div class="request-list">
            <strong>📢 Pending Document Requests:</strong>
            <ul>
                @foreach($requests as $req)
                    <li>{{ ucfirst($req) }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <a href="{{ route('intern.dashboard') }}" class="back-link">← Back to Dashboard</a>
</div>

</body>
</html>
