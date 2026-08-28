<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - Intern Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            overflow: hidden;
        }

        .messaging-container {
            display: flex;
            flex-direction: column;
            height: 100vh;
            max-width: 900px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        /* Header */
        .header {
            background: #4299e1;
            color: white;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .back-button {
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            padding: 8px 12px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .back-button:hover {
            background: rgba(255,255,255,0.3);
            color: white;
            text-decoration: none;
        }

        .header-title {
            flex: 1;
        }

        .header-title h1 {
            font-size: 20px;
            font-weight: 600;
            margin: 0;
        }

        .header-title p {
            font-size: 12px;
            opacity: 0.8;
            margin: 2px 0 0 0;
        }

        .online-status {
            background: #48bb78;
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 500;
        }

        /* Messages Area */
        .messages-area {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            background: #f7fafc;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .message-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .message {
            display: flex;
            gap: 12px;
            max-width: 75%;
            animation: slideIn 0.3s ease;
        }

        .message.sent {
            align-self: flex-end;
            flex-direction: row-reverse;
        }

        .message.received {
            align-self: flex-start;
        }

        .message-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
            color: white;
            flex-shrink: 0;
        }

        .message.sent .message-avatar {
            background: #4299e1;
        }

        .message.received .message-avatar {
            background: #e53e3e;
        }

        .message-content {
            background: white;
            padding: 12px 16px;
            border-radius: 18px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: relative;
            word-wrap: break-word;
        }

        .message.sent .message-content {
            background: #4299e1;
            color: white;
        }

        .message.received .message-content {
            background: white;
            color: #2d3748;
            border: 1px solid #e2e8f0;
        }

        .message-text {
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 4px;
        }

        .message-time {
            font-size: 11px;
            opacity: 0.7;
            text-align: right;
        }

        .message.received .message-time {
            text-align: left;
        }

        /* Broadcast Messages */
        .broadcast-message {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 20px;
            border-radius: 12px;
            margin: 10px 0;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border-left: 4px solid #ffd700;
        }

        .broadcast-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 13px;
        }

        .broadcast-content {
            font-size: 14px;
            line-height: 1.5;
        }

        .broadcast-time {
            font-size: 11px;
            opacity: 0.8;
            margin-top: 8px;
            text-align: right;
        }

        /* Input Area */
        .input-area {
            padding: 20px;
            background: white;
            border-top: 1px solid #e2e8f0;
            display: flex;
            gap: 12px;
            align-items: flex-end;
        }

        .message-input {
            flex: 1;
            border: 2px solid #e2e8f0;
            border-radius: 20px;
            padding: 12px 16px;
            font-size: 14px;
            resize: none;
            outline: none;
            max-height: 120px;
            min-height: 44px;
            font-family: inherit;
            transition: border-color 0.3s ease;
        }

        .message-input:focus {
            border-color: #4299e1;
        }

        .send-button {
            background: #4299e1;
            border: none;
            border-radius: 50%;
            width: 44px;
            height: 44px;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .send-button:hover {
            background: #3182ce;
            transform: scale(1.05);
        }

        .send-button:disabled {
            background: #a0aec0;
            cursor: not-allowed;
            transform: none;
        }

        .send-button svg {
            width: 18px;
            height: 18px;
        }

        /* Typing Indicator */
        .typing-indicator {
            display: none;
            padding: 10px 20px;
            font-size: 12px;
            color: #718096;
            font-style: italic;
            background: #f7fafc;
        }

        /* No Messages */
        .no-messages {
            text-align: center;
            color: #718096;
            font-style: italic;
            margin-top: 50px;
            padding: 20px;
        }

        .no-messages-icon {
            font-size: 48px;
            margin-bottom: 10px;
        }

        /* Message Stats */
        .message-stats {
            background: white;
            padding: 15px 20px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            color: #718096;
        }

        .stats-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Animations */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .messaging-container {
                height: 100vh;
                max-width: 100%;
            }
            
            .message {
                max-width: 85%;
            }

            .header {
                padding: 12px 15px;
            }

            .messages-area {
                padding: 15px;
            }

            .input-area {
                padding: 15px;
            }
        }

        /* Scrollbar Styling */
        .messages-area::-webkit-scrollbar {
            width: 6px;
        }

        .messages-area::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .messages-area::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .messages-area::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>
</head>
<body>
    <div class="messaging-container">
        <!-- Header -->
        <div class="header">
            <a href="{{ route('intern.dashboard') }}" class="back-button">
                ← Back to Dashboard
            </a>
            <div class="header-title">
                <h1>💬 Messages with Admin</h1>
                <p>{{ auth()->guard('intern')->user()->first_name }} {{ auth()->guard('intern')->user()->last_name }}</p>
            </div>
            <div class="online-status">
                ● Online
            </div>
        </div>

        <!-- Message Stats -->
        <div class="message-stats">
            <div class="stats-item">
                <span>📨</span>
                <span>Total Messages: {{ $messages->count() }}</span>
            </div>
            <div class="stats-item">
                <span>🔔</span>
                <span>Unread: {{ $unreadCount }}</span>
            </div>
            <div class="stats-item">
                <span>📅</span>
                <span>Last Activity: {{ $lastActivity ?? 'No messages yet' }}</span>
            </div>
        </div>

        <!-- Messages Area -->
        <div class="messages-area" id="messages-area">
            @if($messages->count() > 0)
                @foreach($messages as $message)
                    @if($message->receiver_type === 'all')
                        <!-- Broadcast Message -->
                        <div class="broadcast-message">
                            <div class="broadcast-header">
                                📢 Broadcast Message from Admin
                            </div>
                            <div class="broadcast-content">
                                {{ $message->content }}
                            </div>
                            <div class="broadcast-time">
                                {{ $message->created_at->format('M j, Y g:i A') }}
                            </div>
                        </div>
                    @else
                        <!-- Regular Message -->
                        @php
                            $isSent = $message->sender_type === 'intern';
                            $senderName = $message->sender_type === 'admin' 
                                ? 'Admin'
                                : auth()->guard('intern')->user()->first_name;
                        @endphp
                        <div class="message {{ $isSent ? 'sent' : 'received' }}">
                            <div class="message-avatar">
                                {{ $isSent ? substr(auth()->guard('intern')->user()->first_name, 0, 1) : 'A' }}
                            </div>
                            <div class="message-content">
                                <div class="message-text">{{ $message->content }}</div>
                                <div class="message-time">{{ $message->created_at->format('M j, g:i A') }}</div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <div class="no-messages">
                    <div class="no-messages-icon">💬</div>
                    <h3>No messages yet</h3>
                    <p>Start a conversation with the admin!</p>
                </div>
            @endif
        </div>

        <!-- Typing Indicator -->
        <div class="typing-indicator" id="typing-indicator">
            Admin is typing...
        </div>

        <!-- Input Area -->
        <div class="input-area">
            <textarea 
                class="message-input" 
                id="message-input"
                placeholder="Type your message to admin..."
                rows="1"
            ></textarea>
            <button class="send-button" id="send-button" type="button">
                <svg fill="currentColor" viewBox="0 0 24 24">
                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            const messageInput = $('#message-input');
            const sendButton = $('#send-button');
            const messagesArea = $('#messages-area');
            const typingIndicator = $('#typing-indicator');
            
            // Auto-resize textarea
            messageInput.on('input', function() {
                this.style.height = 'auto';
                this.style.height = Math.min(this.scrollHeight, 120) + 'px';
            });

            // Send message on Enter (Shift+Enter for new line)
            messageInput.on('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    sendMessage();
                }
            });

            // Send button click
            sendButton.on('click', sendMessage);

            function sendMessage() {
                const content = messageInput.val().trim();
                if (!content) return;

                // Show typing indicator briefly
                typingIndicator.show();
                
                // Add message to chat immediately (optimistic UI)
                const messageHtml = `
                    <div class="message sent">
                        <div class="message-avatar">{{ substr(auth()->guard('intern')->user()->first_name, 0, 1) }}</div>
                        <div class="message-content">
                            <div class="message-text">${content}</div>
                            <div class="message-time">${new Date().toLocaleTimeString('en-US', {hour: 'numeric', minute: '2-digit'})}</div>
                        </div>
                    </div>
                `;
                messagesArea.append(messageHtml);
                
                // Clear input and reset height
                messageInput.val('').height('auto');
                
                // Scroll to bottom
                messagesArea.scrollTop(messagesArea[0].scrollHeight);
                
                // Hide typing indicator
                setTimeout(() => typingIndicator.hide(), 1000);

                // Send to server
                $.ajax({
                    url: "{{ route('intern.messages.send') }}",
                    method: "POST",
                    data: {
                        message: content,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log('Message sent successfully');
                        // Update message stats
                        updateMessageStats();
                    },
                    error: function() {
                        alert('Failed to send message. Please try again.');
                        // Remove the optimistic message on error
                        messagesArea.find('.message.sent').last().remove();
                    }
                });
            }

            // Scroll to bottom on load
            messagesArea.scrollTop(messagesArea[0].scrollHeight);
            
            // Focus input on load
            messageInput.focus();

            // Real-time message polling
            let lastMessageId = {{ $messages->max('id') ?? 0 }};
            
            function pollForNewMessages() {
                $.ajax({
                    url: "{{ route('api.intern.messages.new') }}",
                    method: "GET",
                    data: { last_message_id: lastMessageId },
                    success: function(response) {
                        if (response.messages && response.messages.length > 0) {
                            response.messages.forEach(function(message) {
                                if (message.id > lastMessageId) {
                                    // Only add messages from admin (not our own)
                                    if (message.sender_type === 'admin') {
                                        let messageHtml;
                                        
                                        if (message.receiver_type === 'all') {
                                            // Broadcast message
                                            messageHtml = `
                                                <div class="broadcast-message">
                                                    <div class="broadcast-header">
                                                        📢 Broadcast Message from Admin
                                                    </div>
                                                    <div class="broadcast-content">
                                                        ${message.content}
                                                    </div>
                                                    <div class="broadcast-time">
                                                        ${new Date(message.created_at).toLocaleString()}
                                                    </div>
                                                </div>
                                            `;
                                        } else {
                                            // Regular message
                                            messageHtml = `
                                                <div class="message received">
                                                    <div class="message-avatar">A</div>
                                                    <div class="message-content">
                                                        <div class="message-text">${message.content}</div>
                                                        <div class="message-time">${new Date(message.created_at).toLocaleTimeString('en-US', {hour: 'numeric', minute: '2-digit'})}</div>
                                                    </div>
                                                </div>
                                            `;
                                        }
                                        
                                        messagesArea.append(messageHtml);
                                        messagesArea.scrollTop(messagesArea[0].scrollHeight);
                                    }
                                    lastMessageId = Math.max(lastMessageId, message.id);
                                }
                            });
                            
                            // Update message stats
                            updateMessageStats();
                        }
                    },
                    error: function() {
                        console.log('Error polling for new messages');
                    }
                });
            }

            function updateMessageStats() {
                // Update the stats in the header
                $.ajax({
                    url: "{{ route('api.intern.message.stats') }}",
                    method: "GET",
                    success: function(response) {
                        if (response.stats) {
                            $('.message-stats').html(`
                                <div class="stats-item">
                                    <span>📨</span>
                                    <span>Total Messages: ${response.stats.total}</span>
                                </div>
                                <div class="stats-item">
                                    <span>🔔</span>
                                    <span>Unread: ${response.stats.unread}</span>
                                </div>
                                <div class="stats-item">
                                    <span>📅</span>
                                    <span>Last Activity: ${response.stats.lastActivity}</span>
                                </div>
                            `);
                        }
                    }
                });
            }

            // Poll every 3 seconds
            setInterval(pollForNewMessages, 3000);
        });
    </script>
</body>
</html>