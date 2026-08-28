<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - Intern Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: radial-gradient(circle at top left, rgba(59, 130, 246, 0.15), transparent 28%),
                        linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
            margin: 0;
            padding: 0;
            color: #0f172a;
        }

        /* Header Navigation */
        .header-nav {
            background: #0f172a;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.12);
            padding: 18px 0;
            margin-bottom: 24px;
        }

        .nav-container {
            max-width: 1120px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 24px;
        }

        .nav-brand {
            font-size: 24px;
            font-weight: 700;
            color: #eef2ff;
            letter-spacing: 0.02em;
        }

        .nav-actions {
            display: flex;
            gap: 14px;
            align-items: center;
        }

        .nav-btn,
        .logout-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 999px;
            font-weight: 600;
            transition: transform 0.25s ease, box-shadow 0.25s ease, background-color 0.25s ease;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .nav-btn {
            background: #2563eb;
            color: #ffffff;
            box-shadow: 0 12px 22px rgba(37, 99, 235, 0.18);
        }

        .nav-btn:hover {
            transform: translateY(-2px);
            background: #1d4ed8;
        }

        .logout-btn {
            background: #ef4444;
            color: #ffffff;
            box-shadow: 0 12px 22px rgba(239, 68, 68, 0.18);
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            background: #dc2626;
        }

        .container {
            max-width: 960px;
            margin: 0 auto;
            padding: 0 20px 32px;
        }

        .chat-container {
            background: #ffffff;
            border-radius: 28px;
            box-shadow: 0 24px 50px rgba(15, 23, 42, 0.12);
            overflow: hidden;
            min-height: 680px;
            display: flex;
            flex-direction: column;
            border: 1px solid rgba(148, 163, 184, 0.12);
        }

        .chat-header {
            background: linear-gradient(135deg, #2563eb 0%, #0f172a 100%);
            color: #ffffff;
            padding: 28px 30px;
            text-align: left;
            position: relative;
        }

        .chat-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 30px;
            right: 30px;
            height: 1px;
            background: rgba(255, 255, 255, 0.14);
        }

        .chat-header h2 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.03em;
        }

        .chat-header p {
            margin: 10px 0 0;
            opacity: 0.85;
            font-size: 15px;
            letter-spacing: 0.01em;
            max-width: 540px;
        }

        .messages-container {
            flex: 1;
            overflow-y: auto;
            padding: 30px;
            background: #f8fafc;
        }

        .message {
            margin-bottom: 18px;
            display: flex;
            align-items: flex-end;
            gap: 12px;
        }

        .message.sent {
            flex-direction: row-reverse;
        }

        .message-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 14px;
            flex-shrink: 0;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.12);
        }

        .admin-avatar {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        }

        .intern-avatar {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .message-content {
            max-width: 73%;
            background: #f8fafc;
            padding: 16px 18px;
            border-radius: 24px;
            box-shadow: 0 12px 24px rgba(15, 23, 42, 0.06);
            position: relative;
            border: 1px solid rgba(148, 163, 184, 0.18);
        }

        .message.sent .message-content {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: #f8fafc;
            border-color: transparent;
        }

        .message-text {
            margin: 0;
            line-height: 1.75;
            word-wrap: break-word;
            font-size: 15px;
            letter-spacing: 0.01em;
        }

        .message-time {
            font-size: 12px;
            opacity: 0.72;
            margin-top: 10px;
            text-align: right;
        }

        .message.received .message-time {
            text-align: left;
        }

        .message-form {
            background: #f8fafc;
            padding: 24px 30px;
            border-top: 1px solid rgba(148, 163, 184, 0.16);
        }

        .form-group {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 16px;
            align-items: end;
        }

        .message-input {
            width: 100%;
            padding: 16px 20px;
            border: 1px solid rgba(148, 163, 184, 0.45);
            border-radius: 999px;
            font-size: 15px;
            resize: none;
            min-height: 48px;
            max-height: 140px;
            font-family: inherit;
            transition: border-color 0.25s ease, box-shadow 0.25s ease;
            background: #ffffff;
        }

        .message-input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 5px rgba(37, 99, 235, 0.12);
        }

        .send-btn {
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            color: white;
            border: none;
            border-radius: 50%;
            width: 52px;
            height: 52px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            font-size: 18px;
            box-shadow: 0 18px 30px rgba(16, 185, 129, 0.24);
            animation: float-button 4s ease-in-out infinite;
        }

        .send-btn:hover {
            transform: translateY(-2px) scale(1.04);
            box-shadow: 0 22px 36px rgba(16, 185, 129, 0.28);
        }

        .send-btn:disabled {
            opacity: 0.55;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
            animation: none;
        }

        .no-messages {
            text-align: center;
            color: #475569;
            font-style: italic;
            margin-top: 60px;
            font-size: 15px;
        }

        .typing-indicator {
            display: none;
            padding: 12px 0;
            color: #475569;
            font-style: italic;
            font-size: 14px;
        }

        .chat-header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 18px;
            margin-bottom: 18px;
            flex-wrap: wrap;
        }

        .status-pill,
        .chat-count {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.01em;
            border: 1px solid rgba(255, 255, 255, 0.18);
            background: rgba(255, 255, 255, 0.1);
        }

        .status-pill span {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #34d399;
            box-shadow: 0 0 0 rgba(52, 211, 153, 0.6);
            animation: pulse-ring 2.2s ease-out infinite;
        }

        .message {
            opacity: 0;
            transform: translateY(12px);
            animation: fade-in-up 0.35s ease forwards;
        }

        .message:nth-child(1) { animation-delay: 0.05s; }
        .message:nth-child(2) { animation-delay: 0.1s; }
        .message:nth-child(3) { animation-delay: 0.15s; }
        .message:nth-child(4) { animation-delay: 0.2s; }
        .message:nth-child(5) { animation-delay: 0.25s; }

        @keyframes pulse-ring {
            0% {
                box-shadow: 0 0 0 0 rgba(52, 211, 153, 0.6);
            }
            70% {
                box-shadow: 0 0 0 12px rgba(52, 211, 153, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(52, 211, 153, 0);
            }
        }

        @keyframes fade-in-up {
            0% {
                opacity: 0;
                transform: translateY(16px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float-button {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-3px) scale(1.01);
            }
        }

        .messages-container::-webkit-scrollbar {
            width: 7px;
        }

        .messages-container::-webkit-scrollbar-track {
            background: transparent;
        }

        .messages-container::-webkit-scrollbar-thumb {
            background: rgba(15, 23, 42, 0.16);
            border-radius: 999px;
        }

        .messages-container::-webkit-scrollbar-thumb:hover {
            background: rgba(15, 23, 42, 0.25);
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 12px;
            }

            .chat-container {
                min-height: 560px;
            }

            .message-content {
                max-width: 90%;
            }

            .nav-container {
                padding: 0 15px;
                flex-direction: column;
                align-items: stretch;
                gap: 16px;
            }

            .chat-header {
                text-align: center;
            }

            .form-group {
                grid-template-columns: 1fr auto;
            }

            .chat-header-top {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Header Navigation -->
    <div class="header-nav">
        <div class="nav-container">
            <div class="nav-brand">Intern Portal</div>
            <div class="nav-actions">
                <a href="{{ route('intern.dashboard') }}" class="nav-btn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 10.5L12 3L21 10.5V20.25C21 20.6642 20.6642 21 20.25 21H15.75C15.3358 21 15 20.6642 15 20.25V15H9V20.25C9 20.6642 8.66421 21 8.25 21H3.75C3.33579 21 3 20.6642 3 20.25V10.5Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 21V12H15V21" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Dashboard
                </a>
                <form action="{{ route('intern.logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16 17L21 12L16 7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M21 12H9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 19.5H6.75C6.33579 19.5 6 19.1642 6 18.75V5.25C6 4.83579 6.33579 4.5 6.75 4.5H12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="chat-container">
            <div class="chat-header">
                <div class="chat-header-top">
                    <div class="status-pill"><span></span>Online</div>
                    <div class="chat-count">{{ $messages->count() }} messages</div>
                </div>
                <h2>Messages with Admin</h2>
                <p>Chat directly with your administrator for faster guidance and support.</p>
            </div>

            <div class="messages-container" id="messagesContainer">
                @if($messages->count() > 0)
                    @foreach($messages as $message)
                        <div class="message {{ $message->sender_type === 'intern' ? 'sent' : 'received' }}">
                            <div class="message-avatar {{ $message->sender_type === 'admin' ? 'admin-avatar' : 'intern-avatar' }}">
                                {{ $message->sender_type === 'admin' ? 'A' : 'I' }}
                            </div>
                            <div class="message-content">
                                <p class="message-text">{{ $message->content }}</p>
                                <div class="message-time">
                                    {{ $message->created_at->format('M j, Y g:i A') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="no-messages">
                        <p>No messages yet. Send your first request to the admin to get started.</p>
                    </div>
                @endif
            </div>

            <div class="typing-indicator" id="typingIndicator">
                Admin is typing...
            </div>

            <div class="message-form">
                <form id="messageForm" action="{{ route('intern.messages.send') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <textarea 
                            name="message" 
                            id="messageInput"
                            class="message-input" 
                            placeholder="Type your message here..."
                            required
                            rows="1"
                        ></textarea>
                        <button type="submit" class="send-btn" id="sendBtn" aria-label="Send message">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 12H20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                <path d="M14 6L20 12L14 18" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const messagesContainer = document.getElementById('messagesContainer');
            const messageForm = document.getElementById('messageForm');
            const messageInput = document.getElementById('messageInput');
            const sendBtn = document.getElementById('sendBtn');

            // Auto-scroll to bottom
            function scrollToBottom() {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }

            // Initial scroll to bottom
            scrollToBottom();

            // Auto-resize textarea
            messageInput.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = Math.min(this.scrollHeight, 100) + 'px';
            });

            // Handle Enter key (send message)
            messageInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    messageForm.dispatchEvent(new Event('submit'));
                }
            });

            // Handle form submission
            messageForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const message = messageInput.value.trim();
                if (!message) return;

                // Disable send button
                sendBtn.disabled = true;
                sendBtn.innerHTML = '⏳';

                // Create FormData
                const formData = new FormData(this);

                // Send AJAX request
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Add message to chat
                        addMessageToChat(data.message, true);
                        
                        // Clear input
                        messageInput.value = '';
                        messageInput.style.height = 'auto';
                        
                        // Scroll to bottom
                        scrollToBottom();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to send message. Please try again.');
                })
                .finally(() => {
                    // Re-enable send button
                    sendBtn.disabled = false;
                    sendBtn.innerHTML = '➤';
                });
            });

            // Add message to chat UI
            function addMessageToChat(message, isSent = false) {
                const messageDiv = document.createElement('div');
                messageDiv.className = `message ${isSent ? 'sent' : 'received'}`;
                
                const now = new Date();
                const timeString = now.toLocaleDateString('en-US', { 
                    month: 'short', 
                    day: 'numeric', 
                    year: 'numeric' 
                }) + ' ' + now.toLocaleTimeString('en-US', { 
                    hour: 'numeric', 
                    minute: '2-digit',
                    hour12: true 
                });

                messageDiv.innerHTML = `
                    <div class="message-avatar ${isSent ? 'intern-avatar' : 'admin-avatar'}">
                        ${isSent ? 'I' : 'A'}
                    </div>
                    <div class="message-content">
                        <p class="message-text">${message.content}</p>
                        <div class="message-time">${timeString}</div>
                    </div>
                `;

                // Remove "no messages" placeholder if it exists
                const noMessages = messagesContainer.querySelector('.no-messages');
                if (noMessages) {
                    noMessages.remove();
                }

                messagesContainer.appendChild(messageDiv);
            }

            // Real-time message polling
            let lastMessageId = {{ $messages->max('id') ?? 0 }};
            
            function pollForNewMessages() {
                fetch("{{ route('api.intern.messages.new') }}?last_message_id=" + lastMessageId, {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.messages && data.messages.length > 0) {
                        data.messages.forEach(function(message) {
                            if (message.id > lastMessageId) {
                                // Only add messages from admin (not our own)
                                if (message.sender_type === 'admin') {
                                    addMessageToChat(message, false);
                                }
                                lastMessageId = Math.max(lastMessageId, message.id);
                            }
                        });
                        scrollToBottom();
                    }
                })
                .catch(error => {
                    console.log('Error polling for new messages:', error);
                });
            }

            // Poll every 2 seconds
            setInterval(pollForNewMessages, 2000);
        });
    </script>

    @if(session('success'))
        <script>
            // Show success message if needed
            console.log('{{ session('success') }}');
        </script>
    @endif
</body>
</html>