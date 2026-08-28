<!DOCTYPE html>
<html>
<head>
    <title>{{ $intern->first_name }} {{ $intern->last_name }} - Journal Entries</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8fafc;
            padding: 40px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin-bottom: 10px;
            color: #2d3748;
        }

        h3 {
            color: #4a5568;
            margin-top: 30px;
        }

        .entry {
            background-color: #f1f5f9;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            white-space: pre-wrap;
            border-left: 5px solid #4299e1;
        }

        .entry-meta {
            font-size: 14px;
            color: #718096;
            margin-bottom: 8px;
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
    <h1>📝 Journal Entries</h1>
    <p><strong>Intern:</strong> {{ $intern->first_name }} {{ $intern->last_name }}</p>
    <p><strong>Company:</strong> {{ $intern->company_name }}</p>

    @if ($journals->isEmpty())
        <p>No journal entries submitted yet.</p>
    @else
        @foreach ($journals as $journal)
            <div class="entry">
                <div class="entry-meta">{{ $journal->day }} • {{ $journal->created_at->format('F j, Y g:i A') }}</div>
                {{ $journal->entry }}
            </div>
        @endforeach
    @endif

    <a href="{{ route('documents') }}" class="back-link">← Back to Documents</a>
</div>
</body>
</html>
