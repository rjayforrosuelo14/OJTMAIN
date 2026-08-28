@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
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
    }

    .dashboard-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 32px 20px;
    }

    /* Welcome Header */
    .welcome-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
        color: white;
        padding: 32px;
        border-radius: 16px;
        margin-bottom: 32px;
        box-shadow: 0 10px 30px rgba(30, 64, 175, 0.2);
    }

    .welcome-header h1 {
        font-size: 32px;
        margin-bottom: 8px;
    }

    .welcome-header p {
        font-size: 16px;
        opacity: 0.9;
        margin: 0;
    }

    /* Quick Actions Bar */
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 16px;
        margin-bottom: 32px;
    }

    .action-btn {
        background: white;
        padding: 16px;
        border-radius: 12px;
        text-align: center;
        text-decoration: none;
        color: var(--primary);
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        border: 2px solid var(--border-light);
    }

    .action-btn:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(30, 64, 175, 0.15);
        border-color: var(--primary);
    }

    .action-btn i {
        display: block;
        font-size: 24px;
        margin-bottom: 8px;
    }

    /* Status Cards Grid */
    .status-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }

    .status-card {
        background: white;
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        border-left: 4px solid;
        transition: all 0.3s ease;
    }

    .status-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .status-card.info { border-left-color: var(--primary); }
    .status-card.success { border-left-color: var(--success); }
    .status-card.warning { border-left-color: var(--warning); }
    .status-card.danger { border-left-color: var(--danger); }

    .status-card h3 {
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-light);
        margin-bottom: 8px;
        font-weight: 600;
    }

    .status-card .value {
        font-size: 28px;
        font-weight: 700;
        color: var(--text-dark);
    }

    .status-card .detail {
        font-size: 12px;
        color: var(--text-light);
        margin-top: 8px;
    }

    /* Notifications */
    .notification-banner {
        background: linear-gradient(135deg, var(--warning) 0%, #d97706 100%);
        color: white;
        padding: 24px;
        border-radius: 12px;
        margin-bottom: 32px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 8px 24px rgba(245, 158, 11, 0.2);
    }

    .notification-banner h3 {
        margin-bottom: 8px;
        font-size: 18px;
    }

    .notification-banner p {
        margin: 0;
        font-size: 14px;
        opacity: 0.95;
    }

    .notification-banner a {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .notification-banner a:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }

    /* Cards Grid */
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }

    .card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
        color: white;
        padding: 24px;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .card-icon {
        width: 56px;
        height: 56px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
    }

    .card-title {
        font-size: 20px;
        font-weight: 700;
    }

    .card-body {
        padding: 24px;
    }

    .card-body p {
        color: var(--text-light);
        line-height: 1.6;
        margin-bottom: 16px;
    }

    .card-actions {
        display: flex;
        gap: 12px;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary {
        background: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: var(--bg-light);
        color: var(--primary);
        border: 2px solid var(--primary);
    }

    .btn-secondary:hover {
        background: var(--primary);
        color: white;
    }

    /* Phase Status */
    .phase-status {
        background: white;
        padding: 24px;
        border-radius: 12px;
        margin-bottom: 32px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .phase-timeline {
        display: flex;
        justify-content: space-between;
        position: relative;
    }

    .phase-timeline::before {
        content: '';
        position: absolute;
        top: 24px;
        left: 0;
        right: 0;
        height: 2px;
        background: var(--border-light);
        z-index: 0;
    }

    .phase-item {
        flex: 1;
        text-align: center;
        position: relative;
        z-index: 1;
    }

    .phase-dot {
        width: 48px;
        height: 48px;
        background: white;
        border: 3px solid var(--border-light);
        border-radius: 50%;
        margin: 0 auto 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: var(--text-light);
        transition: all 0.3s ease;
    }

    .phase-item.completed .phase-dot {
        background: var(--success);
        border-color: var(--success);
        color: white;
    }

    .phase-item.active .phase-dot {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
        transform: scale(1.1);
    }

    .phase-label {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-dark);
    }

    .phase-status-text {
        font-size: 12px;
        color: var(--text-light);
        margin-top: 4px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-container {
            padding: 16px;
        }

        .quick-actions {
            grid-template-columns: repeat(2, 1fr);
        }

        .cards-grid {
            grid-template-columns: 1fr;
        }

        .notification-banner {
            flex-direction: column;
            text-align: center;
            gap: 12px;
        }

        .phase-timeline {
            flex-direction: column;
        }

        .phase-timeline::before {
            display: none;
        }
    }
</style>

<div class="dashboard-container">
    <!-- Welcome Header -->
    <div class="welcome-header">
        <h1><i class="fas fa-graduation-cap"></i> Welcome, {{ $intern->first_name }}!</h1>
        <p>You're doing great! Keep track of your internship progress below.</p>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <a href="{{ route('intern.journal') }}" class="action-btn">
            <i class="fas fa-pen-fancy"></i>
            Journal
        </a>
        <a href="{{ route('intern.dtr') }}" class="action-btn">
            <i class="fas fa-clock"></i>
            DTR
        </a>
        <a href="{{ route('intern.messages') }}" class="action-btn">
            <i class="fas fa-envelope"></i>
            Messages
        </a>
        <a href="{{ route('intern.send-data') }}" class="action-btn">
            <i class="fas fa-file-upload"></i>
            Upload
        </a>
    </div>

    <!-- Status Overview -->
    <div class="status-grid">
        <div class="status-card info">
            <h3>Current Phase</h3>
            <div class="value">{{ $intern->current_phase ? str_replace('_', ' ', ucfirst($intern->current_phase)) : 'N/A' }}</div>
            <div class="detail">{{ $intern->pre_enrollment_status ? ucfirst($intern->pre_enrollment_status) : 'Pending' }}</div>
        </div>

        <div class="status-card success">
            <h3>Attendance Status</h3>
            <div class="value">{{ $intern->isAttendanceReleased() ? 'Released' : 'Pending' }}</div>
            <div class="detail">{{ $intern->attendance_status ? ucfirst($intern->attendance_status) : 'Not Marked' }}</div>
        </div>

        <div class="status-card warning">
            <h3>Monthly Hours</h3>
            <div class="value">{{ $intern->getTotalMonthlyHours() ?? 0 }}h</div>
            <div class="detail">Required: 160 hours</div>
        </div>

        <div class="status-card info">
            <h3>Documents</h3>
            <div class="value">{{ $intern->documents->count() }}</div>
            <div class="detail">Submitted documents</div>
        </div>
    </div>

    <!-- Notifications -->
    @if($intern->isAttendanceReleased() && !$intern->hasAttended())
        <div class="notification-banner">
            <div>
                <h3><i class="fas fa-bell"></i> Attendance Released!</h3>
                <p>Your supervisor has released attendance. Mark your time in now to record your presence.</p>
            </div>
            <a href="{{ route('intern.attendance') }}">Mark Attendance</a>
        </div>
    @endif

    @if(now()->isFriday() && !$intern->hasSubmittedJournalThisWeek())
        <div class="notification-banner" style="background: linear-gradient(135deg, #10b981, #059669);">
            <div>
                <h3><i class="fas fa-book"></i> Friday Reminder</h3>
                <p>Don't forget to submit your weekly journal entry documenting your learning this week.</p>
            </div>
            <a href="{{ route('intern.journal') }}">Write Journal</a>
        </div>
    @endif

    <!-- Main Cards -->
    <div class="cards-grid">
        <!-- Journal Card -->
        <div class="card">
            <div class="card-header">
                <div class="card-icon"><i class="fas fa-book"></i></div>
                <div class="card-title">Daily Journal</div>
            </div>
            <div class="card-body">
                <p>Document your learning experiences, tasks completed, and reflections from each day of your internship.</p>
                <div class="card-actions">
                    <a href="{{ route('intern.journal') }}" class="btn btn-primary">
                        <i class="fas fa-pen"></i> Write Entry
                    </a>
                </div>
            </div>
        </div>

        <!-- DTR Card -->
        <div class="card">
            <div class="card-header">
                <div class="card-icon"><i class="fas fa-clock"></i></div>
                <div class="card-title">Time Records</div>
            </div>
            <div class="card-body">
                <p>Track your daily time in and out, monitor monthly hours, and ensure accurate attendance records.</p>
                <div class="card-actions">
                    <a href="{{ route('intern.dtr') }}" class="btn btn-primary">
                        <i class="fas fa-chart-bar"></i> View DTR
                    </a>
                </div>
            </div>
        </div>

        <!-- Messages Card -->
        <div class="card">
            <div class="card-header">
                <div class="card-icon"><i class="fas fa-envelope"></i></div>
                <div class="card-title">Messages</div>
            </div>
            <div class="card-body">
                <p>Communicate with your admin, ask questions, and get updates about your internship progress in real-time.</p>
                <div class="card-actions">
                    <a href="{{ route('intern.messages') }}" class="btn btn-primary">
                        <i class="fas fa-comment"></i> Chat with Admin
                    </a>
                </div>
            </div>
        </div>

        <!-- Documents Card -->
        <div class="card">
            <div class="card-header">
                <div class="card-icon"><i class="fas fa-file"></i></div>
                <div class="card-title">Documents</div>
            </div>
            <div class="card-body">
                <p>Upload and manage your required documents including applications, recommendations, and grade reports.</p>
                <div class="card-actions">
                    <a href="{{ route('intern.send-data') }}" class="btn btn-primary">
                        <i class="fas fa-upload"></i> Upload Files
                    </a>
                </div>
            </div>
        </div>

        <!-- Phase Status Card -->
        <div class="card">
            <div class="card-header">
                <div class="card-icon"><i class="fas fa-tasks"></i></div>
                <div class="card-title">Phase Status</div>
            </div>
            <div class="card-body">
                <p>Track your progress through each internship phase and submit required documents as needed.</p>
                <div class="card-actions">
                    <a href="{{ route('intern.phase-submission') }}" class="btn btn-primary">
                        <i class="fas fa-forward"></i> View Phases
                    </a>
                </div>
            </div>
        </div>

        <!-- Support Card -->
        <div class="card">
            <div class="card-header">
                <div class="card-icon"><i class="fas fa-question-circle"></i></div>
                <div class="card-title">Support</div>
            </div>
            <div class="card-body">
                <p>Need help? Contact your admin or supervisor for any questions about your internship journey.</p>
                <div class="card-actions">
                    <a href="{{ route('intern.messages') }}" class="btn btn-secondary">
                        <i class="fas fa-phone"></i> Contact Admin
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Phase Progress -->
    <div class="phase-status">
        <h3 style="margin-bottom: 24px;"><i class="fas fa-road"></i> Internship Progress</h3>
        <div class="phase-timeline">
            <div class="phase-item {{ $intern->pre_enrollment_status === 'accepted' ? 'completed' : ($intern->current_phase === 'pre_enrollment' ? 'active' : '') }}">
                <div class="phase-dot"><i class="fas fa-check"></i></div>
                <div class="phase-label">Pre-Enrollment</div>
                <div class="phase-status-text">{{ $intern->pre_enrollment_status ? ucfirst($intern->pre_enrollment_status) : 'Pending' }}</div>
            </div>

            <div class="phase-item {{ $intern->pre_deployment_status === 'accepted' ? 'completed' : ($intern->current_phase === 'pre_deployment' ? 'active' : '') }}">
                <div class="phase-dot"><i class="fas fa-check"></i></div>
                <div class="phase-label">Pre-Deployment</div>
                <div class="phase-status-text">{{ $intern->pre_deployment_status ? ucfirst($intern->pre_deployment_status) : 'Pending' }}</div>
            </div>

            <div class="phase-item {{ $intern->mid_deployment_status === 'accepted' ? 'completed' : ($intern->current_phase === 'mid_deployment' ? 'active' : '') }}">
                <div class="phase-dot"><i class="fas fa-check"></i></div>
                <div class="phase-label">Mid-Deployment</div>
                <div class="phase-status-text">{{ $intern->mid_deployment_status ? ucfirst($intern->mid_deployment_status) : 'Pending' }}</div>
            </div>

            <div class="phase-item {{ $intern->deployment_status === 'accepted' ? 'completed' : ($intern->current_phase === 'deployment' ? 'active' : '') }}">
                <div class="phase-dot"><i class="fas fa-check"></i></div>
                <div class="phase-label">Deployment</div>
                <div class="phase-status-text">{{ $intern->deployment_status ? ucfirst($intern->deployment_status) : 'Pending' }}</div>
            </div>

            <div class="phase-item {{ $intern->current_phase === 'completed' ? 'completed' : '' }}">
                <div class="phase-dot"><i class="fas fa-star"></i></div>
                <div class="phase-label">Completed</div>
                <div class="phase-status-text">{{ $intern->hasCompletedAllPhases() ? 'Done' : 'In Progress' }}</div>
            </div>
        </div>
    </div>
</div>

@endsection
