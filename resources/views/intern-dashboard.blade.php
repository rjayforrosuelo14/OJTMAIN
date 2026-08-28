<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intern Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
        }

        /* Header Navigation */
        .header-nav {
            background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
            box-shadow: 0 2px 10px rgba(185, 28, 28, 0.3);
            padding: 15px 0;
            margin-bottom: 30px;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 25px;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 24px;
            font-weight: 700;
            color: #2c3e50;
        }

        .nav-logo {
            width: 48px;
            height: 48px;
            object-fit: contain;
            border-radius: 50%;
            background: white;
        }

        .nav-actions {
            display: flex;
            gap: 15px;
            align-items: center;
            margin-left: auto;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #4a5568;
            font-weight: 500;
        }

        .user-avatar {
            position: relative;
            padding: 0;
            overflow: hidden;
            width: 35px;
            height: 35px;
            border: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-upload {
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .profile-upload:hover,
        .profile-upload:focus-visible {
            transform: scale(1.08);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.75);
            outline: none;
        }

        .logout-btn {
            background: #f56565;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .logout-btn:hover {
            background: #e53e3e;
            transform: translateY(-1px);
        }

        .nav-btn {
            background: #4299e1;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-btn:hover {
            background: #3182ce;
            transform: translateY(-1px);
        }

        .phase-notification {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
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
            align-items: center;
        }

        .dtr-actions .card-btn {
            flex: 1;
            min-width: 120px;
        }

        .dtr-action-message {
            width: 100%;
            font-size: 13px;
            margin-top: 8px;
            min-height: 18px;
            font-weight: 500;
        }

        .dtr-action-message.success {
            color: #059669;
        }

        .dtr-action-message.error {
            color: #dc2626;
        }

        .card-btn:disabled {
            opacity: 0.55;
            cursor: not-allowed;
            transform: none !important;
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
            <div class="nav-brand">
                <img src="{{ asset('images/intern-logo.svg') }}" alt="Information Technology Department logo" class="nav-logo">
                <span>Intern Dashboard</span>
            </div>
            <div class="nav-actions">
                <div class="user-info">
                    <form id="profile-upload-form" action="{{ route('intern.profile.avatar') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input id="profile-image-input" type="file" name="avatar" accept="image/*" hidden>
                        <button type="button" class="user-avatar profile-upload" aria-label="Change profile picture" title="Change profile picture" onclick="document.getElementById('profile-image-input').click()">
                            @if($intern->avatar)
                                <img src="{{ asset('storage/' . $intern->avatar) }}" alt="Profile picture">
                            @else
                                {{ substr($intern->first_name, 0, 1) }}{{ substr($intern->last_name, 0, 1) }}
                            @endif
                        </button>
                    </form>
                    {{ $intern->first_name }} {{ $intern->last_name }}
                </div>
                <a href="{{ route('intern.phase-submission') }}" class="nav-btn"><i class="fas fa-file-upload" aria-hidden="true"></i> Phase Submission</a>
                <a href="{{ route('intern.logout') }}" class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-right-from-bracket" aria-hidden="true"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('intern.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Phase Status Notification -->
        @if(!$intern->hasCompletedAllPhases())
            <div class="phase-notification">
                <h3><i class="fas fa-file-circle-check" aria-hidden="true"></i> Phase Completion Required</h3>
                <p>You need to complete all phases before accessing the full dashboard. Click the button below to submit your phase documents.</p>
                <a href="{{ route('intern.phase-submission') }}" class="phase-btn">
                    <i class="fas fa-file-arrow-up" aria-hidden="true"></i> Submit Phase Documents
                </a>
            </div>
        @endif

        <!-- Friday Journal Reminder -->
        @if(now()->isFriday() && !$intern->hasSubmittedJournalThisWeek())
            <div class="journal-reminder" style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 25px; border-radius: 15px; margin-bottom: 30px; text-align: center; box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);">
                <h3><i class="fas fa-book-open" aria-hidden="true"></i> Friday Journal Reminder</h3>
                <p>It's Friday! Don't forget to submit your weekly journal entry documenting your learning experiences and tasks completed.</p>
                <a href="{{ route('intern.journal') }}" class="journal-btn" style="background: rgba(255, 255, 255, 0.2); color: white; border: 2px solid rgba(255, 255, 255, 0.3); padding: 12px 30px; border-radius: 25px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; text-decoration: none; display: inline-block;">
                    <i class="fas fa-pen-to-square" aria-hidden="true"></i> Write Journal Entry
                </a>
            </div>
        @endif

        <!-- End of Month DTR Reminder -->
        @if(now()->endOfMonth()->diffInDays(now()) <= 3)
            <div class="dtr-reminder" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; padding: 25px; border-radius: 15px; margin-bottom: 30px; text-align: center; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.3);">
                <h3><i class="fas fa-calendar-days" aria-hidden="true"></i> End of Month DTR Reminder</h3>
                <p>The month is ending soon! Make sure your Daily Time Record (DTR) is complete and accurate.</p>
                <a href="{{ route('intern.dtr') }}" class="dtr-btn" style="background: rgba(255, 255, 255, 0.2); color: white; border: 2px solid rgba(255, 255, 255, 0.3); padding: 12px 30px; border-radius: 25px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; text-decoration: none; display: inline-block;">
                    <i class="fas fa-calendar-check" aria-hidden="true"></i> View DTR
                </a>
            </div>
        @endif

        <!-- Attendance Notification -->
        @if($intern->isAttendanceReleased())
            @if($intern->hasAttended())
                <div class="attendance-notification notice-banner">
                    <h3><i class="fas fa-circle-check" aria-hidden="true"></i> Attendance Marked!</h3>
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
                    <h3><i class="fas fa-circle-xmark" aria-hidden="true"></i> Marked Absent</h3>
                    <p>You have been marked as absent for today.</p>
                    <span class="attendance-status status-absent">Absent</span>
                    @if($intern->attendance_notes)
                        <p style="margin-top: 15px; font-size: 14px; opacity: 0.8;">
                            Notes: {{ $intern->attendance_notes }}
                        </p>
                    @endif
                </div>
            @elseif($intern->shouldReceiveAttendanceNotification())
                <div class="attendance-notification notice-banner">
                    <h3><i class="fas fa-user-clock" aria-hidden="true"></i> Time In Available!</h3>
                    <p>Your supervisor has released Time In for today. Click the button below to mark your attendance.</p>
                    <span class="attendance-status status-released">Released</span>
                    <br><br>
                    <a href="{{ route('intern.attendance') }}" class="attendance-btn">
                        <i class="fas fa-clock" aria-hidden="true"></i> Time In Now
                    </a>
                </div>
            @endif
        @else
            <div class="attendance-notification" style="background: linear-gradient(135deg, #a0aec0, #718096 100%);">
                <h3><i class="fas fa-hourglass-half" aria-hidden="true"></i> Waiting for attendance</h3>
                <p>Your supervisor has not released attendance yet. Please wait for the notification.</p>
                <span class="attendance-status status-not-released">Not Released</span>
            </div>
        @endif

        <!-- Dashboard Cards -->
        <div class="dashboard-grid">
      
            <div class="dashboard-card">
                <div class="card-header">
                    <div class="card-icon icon-journal">
                        <i class="fas fa-book" aria-hidden="true"></i>
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
                        <i class="fas fa-comments" aria-hidden="true"></i>
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
                        <i class="fas fa-folder-open" aria-hidden="true"></i>
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
                        <i class="fas fa-clock" aria-hidden="true"></i>
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
                        <div class="status-item">
                            <span class="label">Total Under Time:</span>
                            <span class="value" id="totalUnderTime">0h</span>
                        </div>
                    </div>
                    <div class="dtr-actions" style="margin-top: 15px;">
                        <a href="{{ route('intern.dtr') }}" class="card-btn" style="margin-right: 10px;">View Full DTR</a>
                        <button id="timeInBtn" class="card-btn" style="background: #10b981; margin-right: 10px;">Time In</button>
                        <button id="timeOutBtn" class="card-btn" style="background: #f59e0b;">Time Out</button>
                        <div class="dtr-action-message" id="dtrActionMessage"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('profile-image-input').addEventListener('change', function () {
            if (this.files.length && this.files[0].type.startsWith('image/')) {
                document.getElementById('profile-upload-form').submit();
            }
        });

        // ---------------------------------------------------------------
        // Manila time formatting helper
        // ---------------------------------------------------------------
        // The DTR summary endpoint sends either a full timestamp
        // ("2026-08-04T08:37:28.000000Z", which IS in UTC and needs
        // converting) or a bare time string ("08:37:28"). Bare time
        // strings from this backend are already Manila wall-clock time
        // (Laravel formatted them with the app's local timezone) - they
        // just need AM/PM added, NOT another timezone shift. Shifting
        // them again was the bug that turned an 8:37 AM time-in into
        // 4:37 PM.
        function formatToManilaTime(value) {
            if (!value) return '-';
            value = String(value).trim();

            // Bare time string like "08:37:28" or "08:37" - already
            // Manila local time, just needs 12-hour/AM-PM formatting.
            var bareTimeMatch = value.match(/^(\d{1,2}):(\d{2})(?::(\d{2}))?$/);
            if (bareTimeMatch) {
                var hours = parseInt(bareTimeMatch[1], 10);
                var minutes = bareTimeMatch[2];
                var seconds = bareTimeMatch[3] || '00';
                var period = hours >= 12 ? 'PM' : 'AM';
                var hour12 = hours % 12;
                if (hour12 === 0) hour12 = 12;
                return hour12 + ':' + minutes + ':' + seconds + ' ' + period;
            }

            // Full timestamp - this DOES carry real timezone info (e.g.
            // trailing "Z" for UTC), so converting to Asia/Manila here
            // is correct.
            if (/^\d{4}-\d{2}-\d{2}/.test(value)) {
                var date = new Date(value);
                if (isNaN(date.getTime())) return value;
                return new Intl.DateTimeFormat('en-US', {
                    timeZone: 'Asia/Manila',
                    hour: 'numeric',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: true
                }).format(date);
            }

            return value;
        }

        // Turns a raw decimal like 1.4930555555555556 into "1h 30m"
        // instead of dumping the full float on screen.
        function formatHoursMinutes(decimalHours) {
            var total = Number(decimalHours) || 0;
            var hours = Math.floor(total);
            var minutes = Math.round((total - hours) * 60);
            if (minutes === 60) {
                hours += 1;
                minutes = 0;
            }
            return hours + 'h ' + minutes + 'm';
        }

        // ---------------------------------------------------------------
        // Live clock (Philippines time)
        // ---------------------------------------------------------------
        function updateCurrentTime() {
            const now = new Date();
            const timeString = new Intl.DateTimeFormat('en-US', {
                timeZone: 'Asia/Manila',
                hour: 'numeric',
                minute: '2-digit',
                second: '2-digit',
                hour12: true
            }).format(now);
            document.getElementById('currentTime').textContent = timeString + ' (PH Time)';
        }

        // ---------------------------------------------------------------
        // DTR status polling
        // ---------------------------------------------------------------
        var timeInBtn = document.getElementById('timeInBtn');
        var timeOutBtn = document.getElementById('timeOutBtn');
        var actionMessage = document.getElementById('dtrActionMessage');
        var actionInFlight = false;

        // Cooldown: after a Time In/Time Out click, block further clicks
        // for this many seconds so the buttons can't be spammed.
        var COOLDOWN_SECONDS = 10;
        var cooldownRemaining = 0;
        var cooldownTimer = null;

        function setActionMessage(text, type) {
            actionMessage.textContent = text || '';
            actionMessage.className = 'dtr-action-message' + (type ? ' ' + type : '');
        }

        function startCooldown() {
            cooldownRemaining = COOLDOWN_SECONDS;
            timeInBtn.disabled = true;
            timeOutBtn.disabled = true;

            if (cooldownTimer) clearInterval(cooldownTimer);
            cooldownTimer = setInterval(function () {
                cooldownRemaining -= 1;
                if (cooldownRemaining > 0) {
                    setActionMessage('You can time in/out again in ' + cooldownRemaining + 's…');
                } else {
                    clearInterval(cooldownTimer);
                    cooldownTimer = null;
                    setActionMessage('');
                    updateDTRStatus();
                }
            }, 1000);
        }

        function updateDTRStatus() {
            fetch('{{ route("intern.dtr.summary") }}', {
                headers: { 'Accept': 'application/json' }
            })
                .then(function (response) {
                    if (!response.ok) throw new Error('Request failed with status ' + response.status);
                    return response.json();
                })
                .then(function (data) {
                    var rawStatus = data.today_status;
                    var normalizedStatus = (rawStatus || '').toString().trim().toLowerCase();

                    document.getElementById('todayStatus').textContent = (rawStatus || 'unknown').replace(/_/g, ' ').toUpperCase();
                    document.getElementById('todayTimeIn').textContent = formatToManilaTime(data.today_time_in);
                    document.getElementById('todayTimeOut').textContent = formatToManilaTime(data.today_time_out);
                    document.getElementById('monthlyHours').textContent = formatHoursMinutes(data.monthly_hours);
                    document.getElementById('progressPercent').textContent = (data.progress_percent ?? 0) + '%';
                        document.getElementById('totalUnderTime').textContent = formatHoursMinutes(data.total_under_time_hours);

                    if (normalizedStatus === 'not_started' || normalizedStatus === '' || normalizedStatus === 'null' || normalizedStatus === 'ready_for_next_session') {
                        timeInBtn.disabled = false;
                        timeOutBtn.disabled = true;
                    } else if (normalizedStatus === 'working' || normalizedStatus === 'in_progress' || normalizedStatus === 'timed_in') {
                        timeInBtn.disabled = true;
                        timeOutBtn.disabled = false;
                    } else if (normalizedStatus === 'completed' || normalizedStatus === 'done' || normalizedStatus === 'timed_out') {
                        timeInBtn.disabled = true;
                        timeOutBtn.disabled = true;
                    } else {
                        // Unrecognized status string - don't just silently
                        // lock both buttons with no explanation. Surface it
                        // so it's obvious this is a backend/frontend
                        // mismatch rather than "the buttons don't work".
                        timeInBtn.disabled = true;
                        timeOutBtn.disabled = true;
                        setActionMessage('Unrecognized attendance status from server: "' + rawStatus + '". Check the intern.dtr.summary response.', 'error');
                    }
                })
                .catch(function (error) {
                    console.error('Error fetching DTR status:', error);
                    setActionMessage('Could not refresh DTR status. Retrying shortly…', 'error');
                });
        }

        // ---------------------------------------------------------------
        // Time In / Time Out actions
        // ---------------------------------------------------------------
        function submitAttendanceAction(url, button, successVerb) {
            if (actionInFlight) return;
            if (cooldownRemaining > 0) {
                setActionMessage('Please wait ' + cooldownRemaining + 's before trying again.', 'error');
                return;
            }
            actionInFlight = true;

            timeInBtn.disabled = true;
            timeOutBtn.disabled = true;
            var originalLabel = button.textContent;
            button.textContent = 'Please wait…';
            setActionMessage('');

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
                .then(function (response) {
                    if (response.status === 419) {
                        throw new Error('Your session expired. Please refresh the page and try again.');
                    }
                    return response.json().then(function (data) {
                        if (!response.ok) {
                            throw new Error(data.message || 'Request failed with status ' + response.status);
                        }
                        return data;
                    });
                })
                .then(function (data) {
                    if (data.success) {
                        setActionMessage(successVerb + ' recorded successfully at ' + (formatToManilaTime(data.time) !== '-' ? formatToManilaTime(data.time) : 'this moment') + '.', 'success');
                        updateDTRStatus();
                    } else {
                        setActionMessage(data.message || (successVerb + ' could not be recorded.'), 'error');
                    }
                })
                .catch(function (error) {
                    console.error('Error:', error);
                    setActionMessage(error.message || ('Error recording ' + successVerb + '. Please try again.'), 'error');
                })
                .finally(function () {
                    actionInFlight = false;
                    button.textContent = originalLabel;
                    startCooldown();
                });
        }

        timeInBtn.addEventListener('click', function () {
            submitAttendanceAction('{{ route("intern.timein") }}', timeInBtn, 'Time In');
        });

        timeOutBtn.addEventListener('click', function () {
            submitAttendanceAction('{{ route("intern.timeout") }}', timeOutBtn, 'Time Out');
        });

        // ---------------------------------------------------------------
        // Init
        // ---------------------------------------------------------------
        updateCurrentTime();
        updateDTRStatus();

        setInterval(updateCurrentTime, 1000);
        setInterval(updateDTRStatus, 10000);

        // NOTE: the old `setInterval(() => location.reload(), 30000)` was
        // removed. It was reloading the entire page every 30 seconds,
        // which could interrupt a Time In/Time Out click mid-request and
        // make the buttons feel broken. The DTR widget and attendance
        // notification already refresh themselves via updateDTRStatus()
        // above, so a full reload isn't needed for that. If you still
        // want the phase/journal/messages notifications elsewhere on the
        // page to refresh periodically, that should be its own lighter
        // fetch-based refresh rather than a full page reload.
    </script>
</body>
</html> 