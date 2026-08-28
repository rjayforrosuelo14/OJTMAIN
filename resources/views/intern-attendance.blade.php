<!DOCTYPE html>
<html>
<head>
    <title>Time In - Mark Attendance</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            max-width: 500px;
            width: 100%;
        }

        .header {
            margin-bottom: 30px;
        }

        .title {
            color: #2d3748;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #718096;
            font-size: 16px;
            line-height: 1.5;
        }

        .time-in-section {
            background: #f7fafc;
            padding: 25px;
            border-radius: 15px;
            border: 2px dashed #e2e8f0;
            margin: 30px 0;
        }

        .current-time {
            background: #4299e1;
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 25px;
            font-size: 24px;
            font-weight: 700;
        }

        .notes-input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            resize: vertical;
            min-height: 80px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .notes-input:focus {
            outline: none;
            border-color: #4299e1;
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
        }

        .time-in-btn {
            background: #48bb78;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }

        .time-in-btn:hover {
            background: #38a169;
            transform: translateY(-2px);
        }

        .time-in-btn:disabled {
            background: #a0aec0;
            cursor: not-allowed;
            transform: none;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            color: #4299e1;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            color: #3182ce;
            transform: translateX(-2px);
        }

        .status-message {
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
            font-weight: 600;
        }

        .status-success {
            background: #c6f6d5;
            color: #22543d;
            border: 1px solid #9ae6b4;
        }

        .status-error {
            background: #fed7d7;
            color: #742a2a;
            border: 1px solid #feb2b2;
        }

        .loading {
            display: none;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin: 20px 0;
        }

        .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid #e2e8f0;
            border-top: 2px solid #4299e1;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .instructions {
            background: #edf2f7;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: left;
        }

        .instructions h4 {
            color: #2d3748;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .instructions ol {
            color: #4a5568;
            padding-left: 20px;
            line-height: 1.6;
        }

        .instructions li {
            margin-bottom: 5px;
        }

        .warning {
            background: #fff5f5;
            border: 1px solid #fed7d7;
            color: #742a2a;
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            
            .title {
                font-size: 24px;
            }
            
            .time-in-section {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="title">⏰ Time In</h1>
            <p class="subtitle">Mark your attendance for today</p>
        </div>

        <div class="instructions">
            <h4>📋 Instructions:</h4>
            <ol>
                <li>Your supervisor has released Time In for today</li>
                <li>Add any notes if needed (optional)</li>
                <li>Click "Time In Now" to mark your attendance</li>
                <li>Time In expires in 5 minutes from when it was released</li>
            </ol>
        </div>

        <div class="warning">
            ⚠️ <strong>Important:</strong> Time In expires in 5 minutes. Make sure to mark your attendance quickly!
        </div>

        <div class="time-in-section">
            <div class="current-time" id="currentTime">
                Loading...
            </div>
            
            <textarea 
                class="notes-input" 
                id="notesInput"
                placeholder="Add any notes about your attendance (optional)..."
                maxlength="500"
            ></textarea>
            
            <button 
                class="time-in-btn" 
                id="timeInBtn"
                onclick="markTimeIn()"
            >
                ⏰ Time In Now
            </button>
        </div>

        <div class="loading" id="loading">
            <div class="spinner"></div>
            <span>Processing Time In...</span>
        </div>

        <div id="statusMessage"></div>

        <a href="{{ route('intern.dashboard') }}" class="back-btn">
            ← Back to Dashboard
        </a>
    </div>

    <script>
        const notesInput = document.getElementById('notesInput');
        const timeInBtn = document.getElementById('timeInBtn');
        const loading = document.getElementById('loading');
        const statusMessage = document.getElementById('statusMessage');
        const currentTimeDiv = document.getElementById('currentTime');

        // Update current time
        function updateCurrentTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-US', {
                hour: 'numeric',
                minute: '2-digit',
                second: '2-digit',
                hour12: true
            });
            currentTimeDiv.textContent = `🕒 ${timeString}`;
        }

        // Update time every second
        setInterval(updateCurrentTime, 1000);
        updateCurrentTime(); // Initial call

        function showStatus(message, type) {
            statusMessage.innerHTML = `<div class="status-${type}">${message}</div>`;
            statusMessage.scrollIntoView({ behavior: 'smooth' });
        }

        function showLoading(show) {
            loading.style.display = show ? 'flex' : 'none';
            timeInBtn.disabled = show;
        }

        function markTimeIn() {
            const notes = notesInput.value.trim();

            showLoading(true);
            statusMessage.innerHTML = '';

            fetch('{{ route("intern.attendance.mark") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({
                    notes: notes
                })
            })
            .then(response => response.json())
            .then(data => {
                showLoading(false);
                
                if (data.success) {
                    showStatus(data.message, 'success');
                    notesInput.value = '';
                    
                    // Redirect to dashboard after 2 seconds
                    setTimeout(() => {
                        window.location.href = '{{ route("intern.dashboard") }}';
                    }, 2000);
                } else {
                    showStatus(data.message, 'error');
                }
            })
            .catch(error => {
                showLoading(false);
                showStatus('An error occurred. Please try again.', 'error');
                console.error('Error:', error);
            });
        }

        // Auto-refresh page every 2 minutes to check for new time in releases
        setInterval(() => {
            location.reload();
        }, 120000);
    </script>
</body>
</html>



