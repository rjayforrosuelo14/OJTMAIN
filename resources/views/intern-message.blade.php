<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Center</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            background-color: #f8f9fa;
        }

        h1 {
            color: #333;
        }

        a.button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3490dc;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        a.button:hover {
            background-color: #2779bd;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            background-color: white;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #3490dc;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .chat-link {
            padding: 6px 12px;
            background-color: #38c172;
            color: white;
            border-radius: 4px;
            text-decoration: none;
            margin-right: 8px;
        }

        .chat-link:hover {
            background-color: #2fa360;
        }

        .clear-button {
            padding: 6px 12px;
            background-color: #e3342f;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .clear-button:hover {
            background-color: #cc1f1a;
        }

        .broadcast-box {
            margin-bottom: 30px;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 0 5px rgba(0,0,0,0.05);
        }

        .broadcast-box h3 {
            margin-top: 0;
        }

        .broadcast-box textarea {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: vertical;
        }

        .broadcast-box button {
            margin-top: 10px;
            padding: 8px 16px;
            background-color: #3490dc;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .broadcast-box button:hover {
            background-color: #2779bd;
        }

        .actions {
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>

    <h1>Message Center</h1>
    <p>Select an intern below to view and send messages.</p>

    <div class="broadcast-box">
        <h3>📢 Send Message to All Interns</h3>
        <form method="POST" action="{{ route('messages.broadcast') }}">
            @csrf
            <textarea name="content" rows="4" placeholder="Write your message to all interns..." required></textarea>
            <br>
            <button type="button" onclick="confirmBroadcast()">Send to All</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($interns as $intern)
                @php
                    $unreadCount = \App\Models\Message::where('sender_id', auth()->id())
                        ->where('receiver_id', $intern->id)
                        ->where('sender_type', 'admin')
                        ->where('receiver_type', 'intern')
                        ->where('is_read', false)
                        ->count();
                @endphp
                <tr>
                    <td>
                        {{ $intern->first_name }} {{ $intern->last_name }}
                        @if($unreadCount > 0)
                            <span style="background: red; color: white; font-size: 12px; padding: 2px 6px; border-radius: 10px; margin-left: 6px;">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </td>
                    <td>{{ $intern->email }}</td>
                    <td class="actions">
                        <a href="{{ route('messages.conversation', $intern->id) }}" class="chat-link">💬 Open Chat</a>

                        <form id="clear-form-{{ $intern->id }}" action="{{ route('messages.clear', $intern->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="clear-button" onclick="confirmClear({{ $intern->id }})">🗑 Clear</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('dashboard') }}" class="button">← Back to Dashboard</a>

    <script>
        function confirmClear(internId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete the conversation with this intern.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('clear-form-' + internId).submit();
                }
            });
        }

        function confirmBroadcast() {
            Swal.fire({
                title: 'Send to all interns?',
                text: "Are you sure you want to broadcast this message?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3490dc',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, send it!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.querySelector('.broadcast-box form').submit();
                }
            });
        }
    </script>

    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6',
            });
        </script>
    @endif

</body>
</html>
