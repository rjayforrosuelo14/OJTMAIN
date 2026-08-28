<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversation - {{ $intern->first_name }} {{ $intern->last_name }}</title>

    <!-- SweetAlert + Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background-color: #f3f6fa;
            margin: 0;
            padding: 0;
        }

        .chat-container {
            width: 100%;
            max-width: 850px;
            height: 90vh;
            margin: 30px auto;
            background: white;
            display: flex;
            flex-direction: column;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .chat-header {
            background-color: #3490dc;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chat-header h2 {
            margin: 0;
            font-size: 18px;
        }

        .chat-header a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            background-color: rgba(255,255,255,0.2);
            padding: 6px 12px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .chat-header a:hover {
            background-color: rgba(255,255,255,0.3);
        }

        .chat-box {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 10px;
            background-color: #f9fbfd;
        }

        .message {
            padding: 10px 15px;
            border-radius: 18px;
            max-width: 75%;
            word-wrap: break-word;
            line-height: 1.4;
            position: relative;
        }

        .message.admin {
            background-color: #3490dc;
            color: white;
            align-self: flex-end;
            border-bottom-right-radius: 4px;
        }

        .message.intern {
            background-color: #e6e6e6;
            color: #333;
            align-self: flex-start;
            border-bottom-left-radius: 4px;
        }

        .message .timestamp {
            font-size: 11px;
            opacity: 0.7;
            margin-top: 3px;
            text-align: right;
        }

        .chat-input {
            padding: 15px;
            background-color: #fff;
            border-top: 1px solid #ddd;
            display: flex;
            gap: 10px;
        }

        .chat-input textarea {
            flex: 1;
            resize: none;
            padding: 10px;
            font-size: 14px;
            border-radius: 6px;
            border: 1px solid #ccc;
            height: 50px;
        }

        .chat-input button {
            background-color: #3490dc;
            border: none;
            color: white;
            padding: 0 20px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .chat-input button:hover {
            background-color: #2779bd;
        }

        /* Scrollbar */
        .chat-box::-webkit-scrollbar {
            width: 6px;
        }
        .chat-box::-webkit-scrollbar-thumb {
            background-color: rgba(0,0,0,0.2);
            border-radius: 3px;
        }
    </style>
</head>
<body>
<div class="chat-container">
    <div class="chat-header">
        <h2>💬 Chat with {{ $intern->first_name }} {{ $intern->last_name }}</h2>
        <a href="{{ url()->previous() }}">⬅ Back</a>
    </div>

    <div class="chat-box" id="chat-box">
        @foreach($messages as $message)
            <div class="message {{ $message->sender_type }}">
                <div>{{ $message->content }}</div>
                <div class="timestamp">{{ $message->created_at->format('M j, Y g:i A') }}</div>
            </div>
        @endforeach
    </div>

    <div class="chat-input">
        <textarea id="message-input" placeholder="Type your message..."></textarea>
        <button id="send-button">Send</button>
    </div>
</div>

<script>
    const chatBox = document.getElementById('chat-box');
    const messageInput = document.getElementById('message-input');
    const sendButton = document.getElementById('send-button');
    const internId = {{ $intern->id }};
    let lastMessageId = {{ $messages->last()->id ?? 0 }};
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // Auto-scroll to bottom
    chatBox.scrollTop = chatBox.scrollHeight;

    // Send message via AJAX
    sendButton.addEventListener('click', sendMessage);
    messageInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    function sendMessage() {
        const content = messageInput.value.trim();
        if (!content) return;

        axios.post("{{ route('messages.send') }}", {
            receiver_id: internId,
            content: content
        }, {
            headers: { 'X-CSRF-TOKEN': csrfToken }
        }).then(response => {
            messageInput.value = '';
            appendMessage(response.data.content, 'admin', response.data.created_at || new Date());
        }).catch(err => {
            Swal.fire({
                icon: 'error',
                title: 'Error sending message',
                text: err.response?.data?.message || 'An error occurred.',
            });
        });
    }

    // Append message visually
    function appendMessage(content, sender, time) {
        const div = document.createElement('div');
        div.classList.add('message', sender);
        div.innerHTML = `
            <div>${content}</div>
            <div class="timestamp">${new Date(time).toLocaleString()}</div>
        `;
        chatBox.appendChild(div);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    // Polling for new messages every 3 seconds
    setInterval(fetchNewMessages, 3000);
    function fetchNewMessages() {
        axios.get(`/messages/${internId}/new?last_message_id=${lastMessageId}`)
            .then(response => {
                const messages = response.data.messages;
                messages.forEach(msg => {
                    appendMessage(msg.content, 'intern', msg.created_at);
                    lastMessageId = msg.id;
                });
            });
    }
</script>

</body>
</html>
