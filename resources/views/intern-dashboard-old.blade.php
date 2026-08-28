<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intern Dashboard - OJT Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #1e40af;
            --primary-dark: #1e3a8a;
            --primary-light: #3b82f6;
            --accent: #0891b2;
            --success: #059669;
            --danger: #dc2626;
            --warning: #f59e0b;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --bg-light: #f9fafb;
            --border-light: #e5e7eb;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', sans-serif;
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            color: var(--text-dark);
            min-height: 100vh;
        }

        /* Header Navigation */
        .header-nav {
            background: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 16px 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 32px;
        }

        .nav-brand {
            font-size: 22px;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-actions {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text-dark);
            font-weight: 500;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 18px;
        }

        .logout-btn {
            background: var(--danger);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .logout-btn:hover {
            background: #b91c1c;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }

        .nav-btn {
            background: var(--primary);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .phase-notification {
            animation: pulse 2s infinite;
        }

        .phase-notification {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(245, 158, 11, 0.3);
        }

        .phase-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 12px 30px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .phase-btn:hover {
            background: rgba(255, 255, 255, 0.3) !important;
            border-color: rgba(255, 255, 255, 0.5) !important;
            transform: translateY(-2px);
        }

        .journal-btn:hover {
            background: rgba(255, 255, 255, 0.3) !important;
            border-color: rgba(255, 255, 255, 0.5) !important;
            transform: translateY(-2px);
        }

        .dtr-btn:hover {
            background: rgba(255, 255, 255, 0.3) !important;
            border-color: rgba(255, 255, 255, 0.5) !important;
            transform: translateY(-2px);
        }

        .unread-badge {
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
            position: absolute;
            top: -5px;
            right: -5px;
        }

        .message-card {
            grid-column: span 2;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group textarea {
            font-family: inherit;
            font-size: 14px;
        }

        .dtr-widget {
            grid-column: span 2;
        }

        .current-time {
            font-size: 14px;
            color: #6b7280;
            margin-top: 5px;
        }

        .dtr-status {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .status-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background: #f8fafc;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }

        .status-item .label {
            font-weight: 600;
            color: #374151;
            font-size: 14px;
        }

        .status-item .value {
            font-weight: 700;
            color: #1f2937;
            font-size: 14px;
        }

        .dtr-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .dtr-actions .card-btn {
            flex: 1;
            min-width: 120px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
        }

        h1 {
            margin-bottom: 25px;
            color: #2c3e50;
            font-weight: 600;
            text-align: center;
        }

        /* Attendance Notification */
        .attendance-notification {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }

        .attendance-notification h3 {
            font-size: 24px;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .attendance-notification p {
            font-size: 16px;
            margin-bottom: 20px;
            opacity: 0.9;
        }

        .attendance-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 12px 30px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .attendance-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
        }

        .attendance-status {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-left: 15px;
        }

        .status-present {
            background: #48bb78;
            color: white;
        }

        .status-absent {
            background: #f56565;
            color: white;
        }

        .status-released {
            background: #4299e1;
            color: white;
        }

        .status-not-released {
            background: #a0aec0;
            color: white;
        }

        /* Dashboard Cards */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .dashboard-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }

        .icon-time { background: #4299e1; }
        .icon-journal { background: #48bb78; }
        .icon-messages { background: #ed8936; }
        .icon-documents { background: #9f7aea; }
        .icon-dtr { background: #10b981; } /* Added for DTR widget */

        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: #2d3748;
        }

        .card-content {
            color: #718096;
            line-height: 1.6;
        }

        .card-actions {
            margin-top: 20px;
        }

        .card-btn {
            display: inline-block;
            padding: 10px 20px;
            background: #4299e1;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .card-btn:hover {
            background: #3182ce;
            transform: translateY(-2px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                margin: 20px;
                padding: 20px;
            }
            
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
            
            .attendance-notification {
                padding: 20px;
            }
            
            .attendance-notification h3 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation Header -->
    <div class="header-nav">
        <div class="nav-container">
            <div class="nav-brand">Intern Dashboard</div>
            <div class="nav-actions">
                <div class="user-info">
                    <div class="user-avatar">{{ substr($intern->first_name, 0, 1) }}{{ substr($intern->last_name, 0, 1) }}</div>
                    {{ $intern->first_name }} {{ $intern->last_name }}
                </div>
                <a href="{{ route('intern.phase-submission') }}" class="nav-btn">📋 Phase Submission</a>
                <a href="{{ route('intern.logout') }}" class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    🚪 Logout
                </a>
                <form id="logout-form" action="{{ route('intern.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <h1>👋 Welcome, {{ $intern->first_name }} {{ $intern->last_name }}!</h1>

        <!-- Phase Status Notification -->
        @if(!$intern->hasCompletedAllPhases())
            <div class="phase-notification">
                <h3>📋 Phase Completion Required</h3>
                <p>You need to complete all phases before accessing the full dashboard. Click the button below to submit your phase documents.</p>
                <a href="{{ route('intern.phase-submission') }}" class="phase-btn">
                    📋 Submit Phase Documents
                </a>
            </div>
        @endif

        <!-- Friday Journal Reminder -->
        @if(now()->isFriday() && !$intern->hasSubmittedJournalThisWeek())
            <div class="journal-reminder" style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 25px; border-radius: 15px; margin-bottom: 30px; text-align: center; box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);">
                <h3>📝 Friday Journal Reminder</h3>
                <p>It's Friday! Don't forget to submit your weekly journal entry documenting your learning experiences and tasks completed.</p>
                <a href="{{ route('intern.journal') }}" class="journal-btn" style="background: rgba(255, 255, 255, 0.2); color: white; border: 2px solid rgba(255, 255, 255, 0.3); padding: 12px 30px; border-radius: 25px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; text-decoration: none; display: inline-block;">
                    ✍️ Write Journal Entry
                </a>
            </div>
        @endif

        <!-- End of Month DTR Reminder -->
        @if(now()->endOfMonth()->diffInDays(now()) <= 3)
            <div class="dtr-reminder" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; padding: 25px; border-radius: 15px; margin-bottom: 30px; text-align: center; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.3);">
                <h3>📊 End of Month DTR Reminder</h3>
                <p>The month is ending soon! Make sure your Daily Time Record (DTR) is complete and accurate.</p>
                <a href="{{ route('intern.dtr') }}" class="dtr-btn" style="background: rgba(255, 255, 255, 0.2); color: white; border: 2px solid rgba(255, 255, 255, 0.3); padding: 12px 30px; border-radius: 25px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; text-decoration: none; display: inline-block;">
                    📊 View DTR
                </a>
            </div>
        @endif

        <!-- Attendance Notification -->
        @if($intern->isAttendanceReleased())
            @if($intern->hasAttended())
                <div class="attendance-notification">
                    <h3>✅ Attendance Marked!</h3>
                    <p>You have successfully marked your attendance for today.</p>
                    <span class="attendance-status status-present">Present</span>
                    <p style="margin-top: 15px; font-size: 14px; opacity: 0.8;">
                        Time: {{ $intern->attendance_time->format('g:i A') }}
                        @if($intern->attendance_notes)
                            | Notes: {{ $intern->attendance_notes }}
                        @endif
                    </p>
                </div>
            @elseif($intern->attendance_status === 'absent')
                <div class="attendance-notification" style="background: linear-gradient(135deg, #f56565, #c53030 100%);">
                    <h3>❌ Marked Absent</h3>
                    <p>You have been marked as absent for today.</p>
                    <span class="attendance-status status-absent">Absent</span>
                    @if($intern->attendance_notes)
                        <p style="margin-top: 15px; font-size: 14px; opacity: 0.8;">
                            Notes: {{ $intern->attendance_notes }}
                        </p>
                    @endif
                </div>
            @elseif($intern->shouldReceiveAttendanceNotification())
                <div class="attendance-notification">
                    <h3>⏰ Time In Available!</h3>
                    <p>Your supervisor has released Time In for today. Click the button below to mark your attendance.</p>
                    <span class="attendance-status status-released">Released</span>
                    <br><br>
                    <a href="{{ route('intern.attendance') }}" class="attendance-btn">
                        ⏰ Time In Now
                    </a>
                </div>
            @endif
        @else
            <div class="attendance-notification" style="background: linear-gradient(135deg, #a0aec0, #718096 100%);">
                <h3>⏰ Waiting for Attendance</h3>
                <p>Your supervisor has not released attendance yet. Please wait for the notification.</p>
                <span class="attendance-status status-not-released">Not Released</span>
            </div>
        @endif

        <!-- Dashboard Cards -->
        <div class="dashboard-grid">
      
            <div class="dashboard-card">
                <div class="card-header">
                    <div class="card-icon icon-journal">
                        📝
                    </div>
                    <div>
                        <div class="card-title">Daily Journal</div>
                    </div>
                </div>
                <div class="card-content">
                    Submit your daily journal entries to document your learning experiences and tasks completed.
                </div>
                <div class="card-actions">
                    <a href="{{ route('intern.journal') }}" class="card-btn">Write Journal</a>
                </div>
            </div>

            <div class="dashboard-card">
                <div class="card-header">
                    <div class="card-icon icon-messages">
                        💬
                    </div>
                    <div>
                        <div class="card-title">Messages</div>
                        @if($unreadMessages > 0)
                            <div class="unread-badge">{{ $unreadMessages }}</div>
                        @endif
                    </div>
                </div>
                <div class="card-content">
                    View your conversation with the admin and send messages in real-time.
                </div>
                <div class="card-actions">
                    <a href="{{ route('intern.messages') }}" class="card-btn">Open Admin Chat</a>
                </div>
            </div>

            <div class="dashboard-card">
                <div class="card-header">
                    <div class="card-icon icon-documents">
                        📄
                    </div>
                    <div>
                        <div class="card-title">Documents</div>
                    </div>
                </div>
                <div class="card-content">
                    Upload and manage your required documents including grades and evaluations.
                </div>
                <div class="card-actions">
                    <a href="{{ route('intern.send-data') }}" class="card-btn">Upload Documents</a>
                </div>
            </div>

            

            
            <!-- Real-time DTR Widget -->
            <div class="dashboard-card dtr-widget">
                <div class="card-header">
                    <div class="card-icon icon-dtr">
                        ⏰
                    </div>
                    <div>
                        <div class="card-title">Real-time DTR</div>
                        <div class="current-time" id="currentTime"></div>
                    </div>
                </div>
                <div class="card-content">
                    <div class="dtr-status" id="dtrStatus">
                        <div class="status-item">
                            <span class="label">Today's Status:</span>
                            <span class="value" id="todayStatus">Loading...</span>
                        </div>
                        <div class="status-item">
                            <span class="label">Time In:</span>
                            <span class="value" id="todayTimeIn">-</span>
                        </div>
                        <div class="status-item">
                            <span class="label">Time Out:</span>
                            <span class="value" id="todayTimeOut">-</span>
                        </div>
                        <div class="status-item">
                            <span class="label">Monthly Hours:</span>
                            <span class="value" id="monthlyHours">0</span>
                        </div>
                        <div class="status-item">
                            <span class="label">Progress:</span>
                            <span class="value" id="progressPercent">0%</span>
                        </div>
                    </div>
                    <div class="dtr-actions" style="margin-top: 15px;">
                        <a href="{{ route('intern.dtr') }}" class="card-btn" style="margin-right: 10px;">View Full DTR</a>
                        <button id="timeInBtn" class="card-btn" style="background: #10b981; margin-right: 10px;">Time In</button>
                        <button id="timeOutBtn" class="card-btn" style="background: #f59e0b;">Time Out</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-refresh attendance status every 30 seconds
        setInterval(function() {
            location.reload();
        }, 30000);

        // Quick Message Form Handler
        document.getElementById('quickMessageForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const message = formData.get('message');
            
            if (!message.trim()) {
                alert('Please enter a message');
                return;
            }
            
            // Send message via AJAX
            fetch('{{ route("intern.messages.send") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    message: message,
                    receiver_type: 'admin'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Message sent successfully!');
                    this.reset();
                    // Refresh page to update unread count
                    setTimeout(() => location.reload(), 1000);
                } else {
                    alert('Error sending message: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error sending message. Please try again.');
            });
        });

        // Real-time DTR Functions
        function updateCurrentTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-US', { 
                hour12: true, 
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit' 
            });
            document.getElementById('currentTime').textContent = timeString;
        }

        function updateDTRStatus() {
            fetch('{{ route("intern.dtr.summary") }}')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('todayStatus').textContent = data.today_status.replace('_', ' ').toUpperCase();
                    document.getElementById('todayTimeIn').textContent = data.today_time_in || '-';
                    document.getElementById('todayTimeOut').textContent = data.today_time_out || '-';
                    document.getElementById('monthlyHours').textContent = data.monthly_hours + ' hrs';
                    document.getElementById('progressPercent').textContent = data.progress_percent + '%';
                    
                    // Update button states
                    const timeInBtn = document.getElementById('timeInBtn');
                    const timeOutBtn = document.getElementById('timeOutBtn');
                    
                    if (data.today_status === 'not_started') {
                        timeInBtn.disabled = false;
                        timeOutBtn.disabled = true;
                    } else if (data.today_status === 'working') {
                        timeInBtn.disabled = true;
                        timeOutBtn.disabled = false;
                    } else {
                        timeInBtn.disabled = true;
                        timeOutBtn.disabled = true;
                    }
                })
                .catch(error => {
                    console.error('Error fetching DTR status:', error);
                });
        }

        // Time In/Out Handlers
        document.getElementById('timeInBtn').addEventListener('click', function() {
            fetch('{{ route("intern.timein") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Time In recorded successfully!');
                    updateDTRStatus();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error recording Time In. Please try again.');
            });
        });

        document.getElementById('timeOutBtn').addEventListener('click', function() {
            fetch('{{ route("intern.timeout") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Time Out recorded successfully!');
                    updateDTRStatus();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error recording Time Out. Please try again.');
            });
        });

        // Initialize DTR functionality
        updateCurrentTime();
        updateDTRStatus();
        
        // Update time every second
        setInterval(updateCurrentTime, 1000);
        
        // Update DTR status every 30 seconds
        setInterval(updateDTRStatus, 30000);
    </script>
</body>
</html>