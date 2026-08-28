@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --black: #0a0a0a;
        --black-soft: #171717;
        --charcoal: #262626;
        --red: #dc2626;
        --red-dark: #991b1b;
        --red-light: #f87171;
        --white: #ffffff;
        --off-white: #fafafa;
        --gray-100: #e5e5e5;
        --gray-200: #d4d4d4;
        --gray-400: #a3a3a3;
        --gray-500: #737373;
        --gray-700: #404040;
        --border: #e8e8e8;
        --shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        --shadow-lg: 0 20px 45px rgba(0, 0, 0, 0.12);
        --shadow-red: 0 14px 30px rgba(220, 38, 38, 0.22);

        /* semantic aliases kept so the markup below doesn't need to change */
        --primary: var(--black);
        --secondary: var(--gray-500);
        --success: var(--black);
        --warning: var(--red-light);
        --danger: var(--red);
        --dark: var(--black);
        --light: var(--off-white);
    }

    * { box-sizing: border-box; }

    body { font-family: 'Inter', sans-serif; background-color: var(--off-white); }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(18px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes underlineGrow {
        from { width: 0; }
        to { width: 64px; }
    }

    .supervisors-header {
        position: relative;
        margin-bottom: 32px;
        animation: fadeInUp 0.5s ease both;
    }

    .supervisors-header h1 {
        margin: 0 0 8px 0;
        font-size: 28px;
        font-weight: 800;
        color: var(--black);
        letter-spacing: -0.3px;
    }

    .supervisors-header h1 i { color: var(--red); }

    .supervisors-header p {
        margin: 0;
        color: var(--gray-500);
        font-size: 14px;
    }

    .supervisors-header::after {
        content: '';
        display: block;
        width: 64px;
        height: 3px;
        margin-top: 14px;
        background: linear-gradient(90deg, var(--red), var(--red-light));
        border-radius: 3px;
        animation: underlineGrow 0.8s ease 0.2s both;
    }

    .search-bar {
        background: white;
        padding: 20px;
        border-radius: 14px;
        margin-bottom: 30px;
        box-shadow: var(--shadow);
        animation: fadeInUp 0.5s ease 0.05s both;
    }

    .search-bar input {
        width: 100%;
        padding: 12px 16px;
        border: 1.5px solid var(--gray-100);
        border-radius: 8px;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    .search-bar input:focus {
        outline: none;
        border-color: var(--red);
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
    }

    .tab-navigation {
        display: flex;
        gap: 15px;
        margin-bottom: 30px;
        border-bottom: 2px solid var(--gray-100);
        padding-bottom: 15px;
    }

    .tab-btn {
        background: none;
        border: none;
        padding: 12px 20px;
        font-size: 15px;
        font-weight: 600;
        color: var(--gray-500);
        cursor: pointer;
        transition: all 0.3s ease;
        border-bottom: 3px solid transparent;
        margin-bottom: -15px;
    }

    .tab-btn.active {
        color: var(--black);
        border-bottom-color: var(--red);
    }

    .tab-btn:hover {
        color: var(--red);
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    .supervisors-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 20px;
    }

    .supervisor-card {
        background: white;
        border: 2px solid var(--gray-100);
        border-radius: 14px;
        padding: 25px;
        transition: all 0.3s ease;
        box-shadow: var(--shadow);
        animation: fadeInUp 0.5s ease both;
    }

    .supervisor-card:hover {
        border-color: var(--red);
        box-shadow: var(--shadow-lg);
        transform: translateY(-5px);
    }

    .supervisor-card.pending {
        border-left: 4px solid var(--red-light);
    }

    .supervisor-card.accepted {
        border-left: 4px solid var(--black);
    }

    .supervisor-header {
        margin-bottom: 15px;
    }

    .supervisor-name {
        font-size: 18px;
        font-weight: 700;
        color: var(--black);
        margin-bottom: 5px;
    }

    .supervisor-email {
        font-size: 14px;
        color: var(--gray-500);
        word-break: break-all;
    }

    .supervisor-status {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        margin-top: 10px;
    }

    .status-pending {
        background: rgba(220, 38, 38, 0.1);
        color: var(--red-light);
    }

    .status-accepted {
        background: var(--gray-100);
        color: var(--black);
    }

    .supervisor-interns {
        background: var(--off-white);
        padding: 12px;
        border-radius: 8px;
        margin: 15px 0;
        font-size: 14px;
        color: var(--gray-700);
    }

    .supervisor-interns strong {
        display: block;
        margin-bottom: 5px;
        color: var(--black);
    }

    .supervisor-actions {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }

    .btn-action {
        flex: 1;
        padding: 10px 15px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .btn-accept {
        background: var(--black);
        color: white;
    }

    .btn-accept:hover {
        opacity: 0.9;
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .btn-reject {
        background: var(--red);
        color: white;
    }

    .btn-reject:hover {
        opacity: 0.9;
        transform: translateY(-2px);
        box-shadow: var(--shadow-red);
    }

    .btn-edit {
        background: var(--gray-700);
        color: white;
    }

    .btn-edit:hover {
        opacity: 0.9;
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .btn-delete {
        background: var(--off-white);
        color: var(--red);
        border: 1px solid var(--gray-200);
    }

    .btn-delete:hover {
        background: var(--red);
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 14px;
        border: 2px dashed var(--gray-100);
    }

    .empty-state-icon {
        font-size: 64px;
        margin-bottom: 15px;
        opacity: 0.5;
    }

    .empty-state p {
        color: var(--gray-500);
        margin: 10px 0;
    }

    @media (max-width: 768px) {
        .supervisors-grid {
            grid-template-columns: 1fr;
        }

        .tab-navigation {
            flex-wrap: wrap;
        }
    }
</style>

<div class="container-fluid p-4">
    <div class="supervisors-header">
        <h1></h1>
      
    </div>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Search Bar -->
    <div class="search-bar">
        <form method="GET" action="{{ route('supervisors') }}">
            <input type="text" name="search" placeholder=" Search supervisors by name or email..." value="{{ $search ?? '' }}">
        </form>
    </div>

    <!-- Tab Navigation -->
    <div class="tab-navigation">
        <button class="tab-btn active" onclick="switchTab('pending')">
            <i class="fas fa-hourglass-half"></i> Pending Approval
            <span style="margin-left: 8px; background: var(--warning); color: white; padding: 2px 8px; border-radius: 12px; font-size: 12px;">
                {{ $supervisors->where('is_accepted', false)->count() }}
            </span>
        </button>
        <button class="tab-btn" onclick="switchTab('accepted')">
            <i class="fas fa-check-circle"></i> Approved
            <span style="margin-left: 8px; background: var(--success); color: white; padding: 2px 8px; border-radius: 12px; font-size: 12px;">
                {{ $supervisors->where('is_accepted', true)->count() }}
            </span>
        </button>
    </div>

    <!-- Pending Supervisors Tab -->
    <div id="pending" class="tab-content active">
        @php
            $pendingSupervisors = $supervisors->where('is_accepted', false);
        @endphp

        @if ($pendingSupervisors->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">✓</div>
                <p style="font-size: 16px; font-weight: 600;">All Done!</p>
                <p>No pending supervisor registrations to review.</p>
            </div>
        @else
            <div class="supervisors-grid">
                @foreach ($pendingSupervisors as $supervisor)
                    <div class="supervisor-card pending">
                        <div class="supervisor-header">
                            <div class="supervisor-name">{{ $supervisor->name }}</div>
                            <div class="supervisor-email">{{ $supervisor->email }}</div>
                            <span class="supervisor-status status-pending">
                                <i class="fas fa-clock"></i> Pending Approval
                            </span>
                        </div>

                        <div class="supervisor-interns">
                            <strong><i class="fas fa-chart-bar"></i> Account Status:</strong>
                            Awaiting admin approval
                        </div>

                        <div class="supervisor-actions">
                            <form method="POST" action="{{ route('supervisor.accept', $supervisor->id) }}" style="flex: 1;">
                                @csrf
                                <button type="submit" class="btn-action btn-accept" onclick="return confirm('Approve this supervisor?')">
                                    <i class="fas fa-check"></i> Approve
                                </button>
                            </form>
                            <form method="POST" action="{{ route('supervisor.reject', $supervisor->id) }}" style="flex: 1;">
                                @csrf
                                <button type="submit" class="btn-action btn-reject" onclick="return confirm('Reject this supervisor?')">
                                    <i class="fas fa-times"></i> Reject
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Approved Supervisors Tab -->
    <div id="accepted" class="tab-content">
        @php
            $acceptedSupervisors = $supervisors->where('is_accepted', true);
        @endphp

        @if ($acceptedSupervisors->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">👤</div>
                <p style="font-size: 16px; font-weight: 600;">No Approved Supervisors</p>
                <p>No supervisors have been approved yet.</p>
            </div>
        @else
            <div class="supervisors-grid">
                @foreach ($acceptedSupervisors as $supervisor)
                    @php
                        $internCount = App\Models\Intern::where('supervisor_id', $supervisor->id)
                            ->where('status', 'accepted')
                            ->count();
                    @endphp
                    <div class="supervisor-card accepted">
                        <div class="supervisor-header">
                            <div class="supervisor-name">{{ $supervisor->name }}</div>
                            <div class="supervisor-email">{{ $supervisor->email }}</div>
                            <span class="supervisor-status status-accepted">
                                <i class="fas fa-check-circle"></i> Approved
                            </span>
                        </div>

                        <div class="supervisor-interns">
                            <strong><i class="fas fa-chart-bar"></i> Interns Managed:</strong>
                            {{ $internCount }} intern{{ $internCount !== 1 ? 's' : '' }}
                        </div>

                        <div class="supervisor-actions">
                            <form method="POST" action="{{ route('supervisor.reject', $supervisor->id) }}" style="flex: 1;">
                                @csrf
                                <button type="submit" class="btn-action btn-reject" onclick="return confirm('Revoke this supervisor?')">
                                    <i class="fas fa-times"></i> Revoke
                                </button>
                            </form>
                            <form method="POST" action="{{ route('supervisor.delete', $supervisor->id) }}" style="flex: 1;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" onclick="return confirm('Delete this supervisor permanently?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<script>
    function switchTab(tabName) {
        // Hide all tabs
        document.getElementById('pending').classList.remove('active');
        document.getElementById('accepted').classList.remove('active');

        // Remove active class from all buttons
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));

        // Show selected tab
        document.getElementById(tabName).classList.add('active');

        // Add active class to clicked button
        event.currentTarget.classList.add('active');
    }
</script>
@endsection