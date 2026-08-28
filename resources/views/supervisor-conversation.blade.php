@extends('layouts.supervisor')

@section('content')
<div class="container-fluid mt-4 mb-5" style="max-width: 800px;">
    <!-- Header Section -->
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="card-body text-white" style="padding: 1.5rem;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">
                        <i class="fas fa-user-circle"></i> {{ $intern->first_name }} {{ $intern->last_name }}
                    </h4>
                    <small class="opacity-75">{{ $intern->email }}</small>
                </div>
                <div class="text-right">
                    <small class="opacity-75">
                        <i class="fas fa-building"></i> {{ $intern->company_name ?? 'N/A' }}
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Messages Container -->
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px; min-height: 400px; max-height: 500px; overflow-y: auto;">
        <div class="card-body" id="messagesContainer" style="padding: 1.5rem;">
            @forelse($messages as $message)
                <div class="mb-3 d-flex @if($message->sender_type === 'supervisor') justify-content-end @else justify-content-start @endif">
                    @if($message->sender_type === 'intern')
                        <div class="message-group">
                            <div class="badge badge-info mb-2" style="font-size: 0.75rem; background-color: #0891b2;">
                                {{ $intern->first_name }}
                            </div>
                            <div class="message-bubble" style="background-color: #f0f4f8; border-radius: 12px; padding: 12px 16px; max-width: 70%; word-wrap: break-word;">
                                <p class="mb-0" style="color: #333;">{{ $message->content }}</p>
                                <small class="text-muted" style="font-size: 0.75rem;">
                                    {{ $message->created_at->format('M d, Y g:i A') }}
                                </small>
                            </div>
                        </div>
                    @else
                        <div class="message-group text-right">
                            <div class="badge badge-primary mb-2" style="font-size: 0.75rem; background-color: #667eea;">
                                You
                            </div>
                            <div class="message-bubble" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 12px; padding: 12px 16px; max-width: 70%; word-wrap: break-word;">
                                <p class="mb-0">{{ $message->content }}</p>
                                <small class="opacity-75" style="font-size: 0.75rem;">
                                    {{ $message->created_at->format('M d, Y g:i A') }}
                                </small>
                            </div>
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-5">
                    <div style="font-size: 2rem; color: #d1d5db; margin-bottom: 15px;">
                        <i class="fas fa-comments"></i>
                    </div>
                    <p class="text-muted">No messages yet. Start the conversation!</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Message Input Section -->
    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-body" style="padding: 1.5rem;">
            <form id="messageForm" method="POST" action="{{ route('supervisor.messages.send') }}">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $intern->id }}">
                
                <div class="input-group">
                    <textarea 
                        class="form-control" 
                        id="messageInput"
                        name="content" 
                        placeholder="Type your message..."
                        rows="3"
                        style="border-radius: 12px 0 0 12px; border: 2px solid #e9ecef; resize: none;"
                        required></textarea>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit" style="border-radius: 0 12px 12px 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                            <i class="fas fa-paper-plane"></i> Send
                        </button>
                    </div>
                </div>
                
                @error('content')
                    <div class="alert alert-danger mt-2" style="border-radius: 8px;">
                        {{ $message }}
                    </div>
                @enderror
            </form>
        </div>
    </div>

    <!-- Back Button -->
    <div class="mt-4">
        <a href="{{ route('supervisor.messages') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back to Messages
        </a>
    </div>
</div>

<script>
    // Auto-scroll to bottom of messages
    function scrollToBottom() {
        const container = document.getElementById('messagesContainer');
        if (container) {
            setTimeout(() => {
                container.scrollTop = container.scrollHeight;
            }, 50);
        }
    }

    document.addEventListener('DOMContentLoaded', scrollToBottom);

    let lastMessageId = {{ $messages->count() > 0 ? $messages->last()->id : 0 }};

    // Function to refresh messages manually
    function refreshMessages() {
        fetch('{{ route("api.supervisor.messages.new", $intern->id) }}?last_message_id=' + lastMessageId)
            .then(response => response.json())
            .then(data => {
                if (data.messages && data.messages.length > 0) {
                    const container = document.getElementById('messagesContainer');
                    data.messages.forEach(message => {
                        lastMessageId = Math.max(lastMessageId, message.id);
                        const msgHtml = `
                            <div class="mb-3 d-flex justify-content-start">
                                <div class="message-group">
                                    <div class="badge badge-info mb-2" style="font-size: 0.75rem; background-color: #0891b2;">
                                        ${message.sender_name}
                                    </div>
                                    <div class="message-bubble" style="background-color: #f0f4f8; border-radius: 12px; padding: 12px 16px; max-width: 70%; word-wrap: break-word;">
                                        <p class="mb-0" style="color: #333;">${message.content}</p>
                                        <small class="text-muted" style="font-size: 0.75rem;">
                                            ${new Date().toLocaleTimeString()}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        `;
                        container.insertAdjacentHTML('beforeend', msgHtml);
                    });
                    scrollToBottom();
                }
            })
            .catch(error => console.error('Error fetching messages:', error));
    }

    // Auto-refresh messages every 1 second for faster communication
    const messagePoller = setInterval(function() {
        refreshMessages();
    }, 1000);

    // Form submission with improved feedback
    const messageForm = document.getElementById('messageForm');
    const messageInput = document.getElementById('messageInput');
    const submitBtn = messageForm.querySelector('button[type="submit"]');
    
    function sendMessage() {
        const content = messageInput.value.trim();
        if (!content) return;

        // Show optimistic UI - add message immediately
        const container = document.getElementById('messagesContainer');
        const msgHtml = `
            <div class="mb-3 d-flex justify-content-end">
                <div class="message-group text-right">
                    <div class="badge badge-primary mb-2" style="font-size: 0.75rem; background-color: #667eea;">
                        You
                    </div>
                    <div class="message-bubble" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 12px; padding: 12px 16px; max-width: 70%; word-wrap: break-word;">
                        <p class="mb-0">${content}</p>
                        <small class="opacity-75" style="font-size: 0.75rem;">
                            ${new Date().toLocaleTimeString()}
                        </small>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', msgHtml);
        scrollToBottom();

        // Disable button and show loading
        submitBtn.disabled = true;
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
        
        const formData = new FormData(messageForm);
        
        fetch('{{ route("supervisor.messages.send") }}', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                messageInput.value = '';
                messageInput.focus();
                // Message will appear via polling within 1 second
            } else {
                alert('Error sending message: ' + (data.message || 'Unknown error'));
                // Refresh messages to show current state
                setTimeout(refreshMessages, 500);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error sending message');
            // Refresh messages to show current state
            setTimeout(refreshMessages, 500);
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    }

    messageForm.addEventListener('submit', function(e) {
        e.preventDefault();
        sendMessage();
    });

    // Enter key to send (Shift+Enter for new line)
    messageInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });
</script>

<style>
    .message-group {
        margin-bottom: 1rem;
    }

    .message-bubble {
        display: inline-block;
        word-break: break-word;
        word-wrap: break-word;
    }

    #messagesContainer {
        background-color: #f9fafb;
    }

    .form-control:focus {
        border-color: #667eea !important;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25) !important;
    }

    @media (max-width: 768px) {
        #messagesContainer {
            max-height: 300px;
        }

        .message-bubble {
            max-width: 85% !important;
        }
    }
</style>
@endsection
