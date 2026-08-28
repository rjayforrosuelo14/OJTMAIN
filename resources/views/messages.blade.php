@extends('layouts.app')

@section('content')
    <style>
        :root {
            --primary: #dc2626;
            --primary-dark: #991b1b;
            --secondary: #000000;
            --success: #dc2626;
            --warning: #f8fafc;
            --danger: #dc2626;
            --dark: #000000;
            --light: #ffffff;
            --border: #e5e7eb;
            --purple: #dc2626;
            --shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #ffffff; margin: 0; padding: 0; color: var(--dark); }

        .messages-container { max-width: 1400px; margin: 0 auto; background: var(--light); border-radius: 16px; padding: 32px; box-shadow: var(--shadow-lg); }

        .page-header {
            margin-bottom: 32px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--border);
        }

        .page-header h1 {
            font-size: 32px;
            font-weight: 700;
            color: var(--dark);
            margin: 0 0 8px 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .page-header p {
            color: var(--secondary);
            font-size: 14px;
            margin: 0;
        }

        /* Alert Messages */
        .alert {
            padding: 16px 20px;
            border-radius: 10px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-10px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .alert.success {
            background: rgba(220, 38, 38, 0.12);
            color: var(--danger);
            border-left: 4px solid var(--danger);
        }

        .alert.error {
            background: rgba(220, 38, 38, 0.12);
            color: var(--danger);
            border-left: 4px solid var(--danger);
        }

        /* Broadcast Section */
        .broadcast-section {
            background: var(--light);
            padding: 24px;
            border-radius: 12px;
            margin-bottom: 24px;
        }

        .broadcast-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .broadcast-header h3 {
            font-size: 18px;
            font-weight: 600;
            color: var(--dark);
            margin: 0;
        }

        .broadcast-form {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .broadcast-textarea {
            width: 100%;
            padding: 16px;
            border: 2px solid var(--border);
            border-radius: 10px;
            font-size: 14px;
            font-family: inherit;
            resize: vertical;
            min-height: 100px;
            transition: all 0.3s ease;
        }

        .broadcast-textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.12);
        }

        .broadcast-textarea::placeholder {
            color: var(--secondary);
        }

        /* Table Styles */
        .table-container {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        }

        th {
            padding: 16px 20px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: white;
        }

        th:first-child {
            border-radius: 0;
        }

        tbody tr {
            border-bottom: 1px solid var(--border);
            transition: all 0.2s ease;
        }

        tbody tr:hover {
            background: var(--light);
            transform: scale(1.01);
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        td {
            padding: 16px 20px;
            color: var(--dark);
            font-size: 14px;
        }

        td:first-child {
            font-weight: 600;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
            align-items: center;
            justify-content: center;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-chat {
            background: rgba(220, 38, 38, 0.08);
            color: var(--danger);
            border: 1px solid rgba(220, 38, 38, 0.3);
        }

        .btn-chat:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }

        .btn-clear {
            background: rgba(220, 38, 38, 0.08);
            color: #4b0d0d;
            border: 1px solid rgba(127, 29, 29, 0.45);
        }

        .btn-clear:hover {
            background: rgba(220, 38, 38, 0.14);
            color: #2d0808;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(127, 29, 29, 0.18);
        }

        .btn-delete {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
            border: 1px solid var(--danger);
        }

        .btn-delete:hover {
            background: var(--danger);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .btn-broadcast {
            background: rgba(220, 38, 38, 0.08);
            color: var(--danger);
            border: 1px solid rgba(220, 38, 38, 0.3);
            padding: 12px 24px;
            font-size: 14px;
        }

        .btn-broadcast:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }

        /* Unread Badge */
        .unread-badge {
            background: var(--danger);
            color: white;
            border-radius: 12px;
            padding: 2px 8px;
            font-size: 11px;
            font-weight: 700;
            min-width: 20px;
            text-align: center;
            margin-left: 8px;
        }

        /* Email Badge */
        .email-badge {
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            background: rgba(220, 38, 38, 0.08);
            color: var(--dark);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--secondary);
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        .empty-state h3 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--dark);
        }

        .empty-state p {
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .messages-container {
                padding: 20px;
            }

            table {
                font-size: 12px;
            }

            th, td {
                padding: 12px 10px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .broadcast-form {
                gap: 12px;
            }
        }

        /* Loading Animation */
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        .loading {
            animation: pulse 1.5s ease-in-out infinite;
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="messages-container">
        <!-- Page Header -->
        <div class="page-header">
            <h1>
             
            </h1>
          
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert success">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert error">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Broadcast Section -->
        <div class="broadcast-section">
            <div class="broadcast-header">
                <i class="fas fa-bullhorn"></i>
                <h3>Send Message to All Interns</h3>
            </div>
            <form method="POST" action="{{ route('messages.broadcast') }}" class="broadcast-form">
                @csrf
                <textarea 
                    name="content" 
                    class="broadcast-textarea" 
                    placeholder="Write your message to all interns..." 
                    required
                ></textarea>
                <button type="button" class="btn btn-broadcast" onclick="confirmBroadcast()">
                    <i class="fas fa-paper-plane"></i>
                    Send to All Interns
                </button>
            </form>
        </div>

        <!-- Table -->
        @if($interns->count() > 0)
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th><i class="fas fa-user"></i> Full Name</th>
                            <th><i class="fas fa-envelope"></i> Email</th>
                            <th><i class="fas fa-cog"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($interns as $intern)
                            @php
                                $unreadCount = \App\Models\Message::where('sender_id', $intern->id)
                                    ->where('receiver_id', auth()->id())
                                    ->where('sender_type', 'intern')
                                    ->where('receiver_type', 'admin')
                                    ->where('is_read', false)
                                    ->count();
                            @endphp
                            <tr>
                                <td>
                                    <strong>{{ $intern->first_name }} {{ $intern->last_name }}</strong>
                                    @if($unreadCount > 0)
                                        <span class="unread-badge">{{ $unreadCount }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="email-badge">{{ $intern->email }}</span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('messages.conversation', $intern->id) }}" class="btn btn-chat">
                                            <i class="fas fa-comments"></i>
                                            Open Chat
                                        </a>
                                        <form id="clear-form-{{ $intern->id }}" action="{{ route('messages.clear', $intern->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-clear" onclick="confirmClear({{ $intern->id }})">
                                                <i class="fas fa-trash"></i>
                                                Clear
                                            </button>
                                        </form>
                                        <form action="{{ route('intern.destroy', $intern->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-delete" onclick="confirmDelete({{ $intern->id }}, '{{ $intern->first_name }} {{ $intern->last_name }}')">
                                                <i class="fas fa-user-times"></i>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h3>No Interns Found</h3>
                <p>No accepted interns available for messaging at the moment</p>
            </div>
        @endif
    </div>

    <script>
        function confirmClear(internId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete the conversation with this intern.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f59e0b',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, clear it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('clear-form-' + internId).submit();
                }
            });
        }

        function confirmDelete(internId, internName) {
            Swal.fire({
                title: 'Are you absolutely sure?',
                text: `This will permanently delete ${internName} and ALL their data including time logs, journals, grades, messages, and documents. This action cannot be undone!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete permanently!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const deleteForm = document.querySelector(`form[action*="/interns/${internId}"]`);
                    if (deleteForm) {
                        deleteForm.submit();
                    }
                }
            });
        }

        function confirmBroadcast() {
            const textarea = document.querySelector('.broadcast-textarea');
            const message = textarea.value.trim();
            
            if (!message) {
                Swal.fire({
                    icon: 'error',
                    title: 'Message Required',
                    text: 'Please write a message before broadcasting.',
                    confirmButtonColor: '#ef4444',
                });
                return;
            }

            Swal.fire({
                title: 'Send to all interns?',
                text: "Are you sure you want to broadcast this message to all interns?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, send it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.querySelector('.broadcast-form').submit();
                }
            });
        }

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#10b981',
                timer: 3000,
                timerProgressBar: true,
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#ef4444',
            });
        @endif

        @if(session('warning'))
            Swal.fire({
                icon: 'warning',
                title: 'Warning!',
                text: '{{ session('warning') }}',
                confirmButtonColor: '#f59e0b',
            });
        @endif

        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: '<ul style="text-align: left;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                confirmButtonColor: '#ef4444',
            });
        @endif
    </script>
@endsection