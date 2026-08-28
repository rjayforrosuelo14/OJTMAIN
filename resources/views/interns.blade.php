@extends('layouts.app')

@section('content')
    <style>
        :root {
            --primary: #dc2626;
            --primary-dark: #991b1b;
            --secondary: #111111;
            --success: #dc2626;
            --warning: #000000;
            --danger: #dc2626;
            --dark: #111111;
            --light: #ffffff;
            --border: rgba(17, 17, 17, 0.08);
            --purple: #dc2626;
            --shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 10px 30px rgba(0, 0, 0, 0.12);
        }

        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #111111; margin: 0; padding: 0; color: var(--secondary); }

        .interns-container { max-width: 1400px; margin: 0 auto; background: var(--light); border-radius: 16px; padding: 32px; box-shadow: var(--shadow-lg); }

        .page-header {
            margin-bottom: 32px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--border);
        }

        .page-header h1 {
            font-size: 32px;
            font-weight: 700;
            color: #111111;
            margin: 0 0 8px 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .page-header p {
            color: #333333;
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
            background: rgba(220, 38, 38, 0.1);
            color: var(--danger);
            border-left: 4px solid var(--danger);
        }

        .alert.error {
            background: rgba(220, 38, 38, 0.12);
            color: var(--danger);
            border-left: 4px solid var(--danger);
        }

        /* Filter Section */
        .filter-section {
            background: var(--light);
            padding: 24px;
            border-radius: 12px;
            margin-bottom: 24px;
        }

        .filter-controls {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
        }

        .filter-btn {
            padding: 10px 20px;
            border: 2px solid transparent;
            background: white;
            color: var(--dark);
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            position: relative;
        }

        .filter-btn:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }

        .filter-btn.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary-dark);
        }

        .badge {
            background: var(--danger);
            color: white;
            border-radius: 12px;
            padding: 2px 8px;
            font-size: 11px;
            font-weight: 700;
            min-width: 20px;
            text-align: center;
        }

        /* Phase Filter */
        .phase-filter {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .phase-select {
            padding: 10px 16px;
            border: 2px solid var(--border);
            border-radius: 8px;
            background: white;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .phase-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        /* Phase Indicator Banner */
        .phase-indicator {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 20px 24px;
            border-radius: 12px;
            margin-bottom: 24px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.25);
            animation: slideIn 0.3s ease;
        }

        .phase-indicator h3 {
            margin: 0 0 8px 0;
            font-size: 20px;
            font-weight: 600;
        }

        .phase-indicator p {
            margin: 0 0 16px 0;
            opacity: 0.9;
            font-size: 14px;
        }

        .phase-indicator a {
            display: inline-block;
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .phase-indicator a:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-1px);
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

        /* Section Heading */
        .section-heading {
            background: var(--light);
            font-weight: 600;
            text-align: center;
            padding: 12px;
            color: var(--secondary);
            font-size: 14px;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
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

        .btn-view {
            background: rgba(220, 38, 38, 0.08);
            color: var(--primary);
            border: 1px solid rgba(220, 38, 38, 0.3);
        }

        .btn-view:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }

        .btn-edit {
            background: rgba(17, 17, 17, 0.08);
            color: var(--secondary);
            border: 1px solid rgba(17, 17, 17, 0.2);
        }

        .btn-edit:hover {
            background: var(--secondary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(17, 17, 17, 0.25);
        }

        .btn-accept {
            background: rgba(220, 38, 38, 0.12);
            color: var(--danger);
            border: 1px solid var(--danger);
        }

        .btn-accept:hover {
            background: var(--danger);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
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

        .btn-reject {
            background: rgba(220, 38, 38, 0.1);
            color: var(--danger);
            border: 1px solid var(--danger);
        }

        .btn-reject:hover {
            background: var(--danger);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }

        .btn-invite {
            background: rgba(220, 38, 38, 0.1);
            color: var(--danger);
            border: 1px solid var(--danger);
            padding: 12px 24px;
            font-size: 14px;
        }

        .btn-invite:hover {
            background: var(--danger);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }

        /* Status Labels */
        .status-label {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .status-pending {
            background: rgba(220, 38, 38, 0.08);
            color: var(--danger);
        }

        .status-accepted {
            background: rgba(220, 38, 38, 0.12);
            color: var(--danger);
        }

        .status-rejected {
            background: rgba(17, 17, 17, 0.08);
            color: var(--secondary);
        }

        /* Phase Labels */
        .phase-label {
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .phase-pre-enrollment {
            background: rgba(100, 116, 139, 0.1);
            color: var(--secondary);
        }

        .phase-pre-deployment {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        .phase-mid-deployment {
            background: rgba(37, 99, 235, 0.1);
            color: var(--primary);
        }

        .phase-deployment {
            background: rgba(139, 92, 246, 0.1);
            color: var(--purple);
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
            .interns-container {
                padding: 20px;
            }

            .filter-controls {
                flex-direction: column;
                align-items: stretch;
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

    <div class="interns-container">
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

        <!-- Generate Invitation Link Button -->
        <div style="text-align:center; margin-bottom: 24px;">
            <button type="button" class="btn btn-invite" onclick="generateAndCopyInviteLink()">
                <i class="fas fa-link"></i>
                Generate Invitation Link
            </button>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-controls">
                <!-- Phase Filter -->
                <div class="phase-filter">
                    <form method="GET" action="{{ route('interns') }}" style="display:flex; gap:10px; align-items:center;">
                        <input type="hidden" name="filter" value="{{ request('filter') }}">
                        <select name="phase" onchange="this.form.submit()" class="phase-select">
                            <option value="all" {{ ($phase === 'all' || !$phase) ? 'selected' : '' }}>All Phases</option>
                            <option value="pre_deployment" {{ $phase === 'pre_deployment' ? 'selected' : '' }}>Pre-Deployment</option>
                            <option value="mid_deployment" {{ $phase === 'mid_deployment' ? 'selected' : '' }}>Mid-Deployment</option>
                            <option value="deployment" {{ $phase === 'deployment' ? 'selected' : '' }}>Deployment</option>
                        </select>
                        @if($phase && $phase !== 'all')
                            <a href="{{ route('interns', ['filter' => request('filter')]) }}" class="btn btn-edit">
                                <i class="fas fa-times"></i>
                                Reset Phase
                            </a>
                        @endif
                    </form>
                </div>

                <!-- Section Filter Buttons -->
                @foreach(['North', 'East', 'West', 'South', 'South East', 'Northeast'] as $section)
                    <form method="GET" action="{{ route('interns') }}" style="display: inline;">
                        <input type="hidden" name="filter" value="{{ $section }}">
                        @if($phase && $phase !== 'all')
                            <input type="hidden" name="phase" value="{{ $phase }}">
                        @endif
                        <button type="submit" class="filter-btn {{ request('filter') === $section ? 'active' : '' }}">
                            <i class="fas fa-users"></i>
                            {{ $section }}
                            @if(isset($sectionCounts[$section]) && $sectionCounts[$section] > 0)
                                <span class="badge">{{ $sectionCounts[$section] }}</span>
                            @endif
                        </button>
                    </form>
                @endforeach
            </div>
        </div>

        <!-- Phase Indicator Banner -->
        @if($phase && $phase !== 'all')
            <div class="phase-indicator">
                <h3>
                    <i class="fas fa-clipboard-list"></i>
                    Currently Viewing: {{ ucfirst(str_replace('_', ' ', $phase)) }} Phase
                </h3>
                <p>
                    Showing interns in the {{ ucfirst(str_replace('_', ' ', $phase)) }} phase
                    @if(isset($phaseCounts[$phase]))
                        • {{ $phaseCounts[$phase] }} intern(s) found
                    @endif
                </p>
                <a href="{{ route('interns', ['filter' => request('filter')]) }}">
                    <i class="fas fa-eye"></i>
                    View All Phases
                </a>
            </div>
        @endif

        <!-- Table -->
        @if($interns->count() > 0)
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th><i class="fas fa-user"></i> First Name</th>
                            <th><i class="fas fa-user"></i> Last Name</th>
                            <th><i class="fas fa-graduation-cap"></i> Course</th>
                            <th><i class="fas fa-users"></i> Section</th>
                            <th><i class="fas fa-tasks"></i> Current Phase</th>
                            <th><i class="fas fa-info-circle"></i> Phase Status</th>
                            <th><i class="fas fa-cog"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $currentSection = null; @endphp
                        @foreach($interns as $intern)
                            @if($currentSection !== $intern->section)
                                @php $currentSection = $intern->section; @endphp
                                <tr>
                                    <td colspan="7" class="section-heading">
                                        <i class="fas fa-map-marker-alt"></i>
                                        Section: {{ $currentSection }}
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <td><strong>{{ $intern->first_name }}</strong></td>
                                <td><strong>{{ $intern->last_name }}</strong></td>
                                <td>{{ $intern->course }}</td>
                                <td>{{ $intern->section }}</td>
                                <td>
                                    @switch($intern->current_phase)
                                        @case('pre_enrollment')
                                            <span class="phase-label phase-pre-enrollment">Pre-Enrollment</span>
                                            @break
                                        @case('pre_deployment')
                                            <span class="phase-label phase-pre-deployment">Pre-Deployment</span>
                                            @break
                                        @case('mid_deployment')
                                            <span class="phase-label phase-mid-deployment">Mid-Deployment</span>
                                            @break
                                        @case('deployment')
                                            <span class="phase-label phase-deployment">Deployment</span>
                                            @break
                                        @default
                                            <span class="phase-label phase-pre-enrollment">{{ ucfirst($intern->current_phase) }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    @if($intern->status === 'pending')
                                        <span class="status-label status-pending">Pending</span>
                                    @elseif($intern->status === 'accepted')
                                        <span class="status-label status-accepted">Accepted</span>
                                    @elseif($intern->status === 'rejected')
                                        <span class="status-label status-rejected">Rejected</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('intern.show', $intern->id) }}" class="btn btn-view">
                                            <i class="fas fa-eye"></i>
                                            View
                                        </a>
                                        <a href="{{ route('intern.edit', $intern->id) }}" class="btn btn-edit">
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </a>
                                        
                                        @if($intern->status === 'pending')
                                            <button type="button" class="btn btn-accept" onclick="confirmAccept({{ $intern->id }}, '{{ $intern->first_name }} {{ $intern->last_name }}')">
                                                <i class="fas fa-check"></i>
                                                Accept
                                            </button>
                                            <button type="button" class="btn btn-reject" onclick="confirmReject({{ $intern->id }}, '{{ $intern->first_name }} {{ $intern->last_name }}')">
                                                <i class="fas fa-times"></i>
                                                Reject
                                            </button>
                                        @endif

                                        @if($intern->current_phase === 'pre_deployment' && $intern->pre_deployment_status === 'pending')
                                            <button type="button" class="btn btn-accept" onclick="confirmPhaseAccept({{ $intern->id }}, '{{ $intern->first_name }} {{ $intern->last_name }}', 'pre-deployment')">
                                                <i class="fas fa-check"></i>
                                                Accept Phase
                                            </button>
                                            <button type="button" class="btn btn-reject" onclick="confirmPhaseReject({{ $intern->id }}, '{{ $intern->first_name }} {{ $intern->last_name }}', 'pre-deployment')">
                                                <i class="fas fa-times"></i>
                                                Reject Phase
                                            </button>
                                        @endif

                                        @if($intern->current_phase === 'mid_deployment' && $intern->mid_deployment_status === 'pending')
                                            <button type="button" class="btn btn-accept" onclick="confirmPhaseAccept({{ $intern->id }}, '{{ $intern->first_name }} {{ $intern->last_name }}', 'mid-deployment')">
                                                <i class="fas fa-check"></i>
                                                Accept Phase
                                            </button>
                                            <button type="button" class="btn btn-reject" onclick="confirmPhaseReject({{ $intern->id }}, '{{ $intern->first_name }} {{ $intern->last_name }}', 'mid-deployment')">
                                                <i class="fas fa-times"></i>
                                                Reject Phase
                                            </button>
                                        @endif

                                        @if($intern->current_phase === 'deployment' && $intern->deployment_status === 'pending')
                                            <button type="button" class="btn btn-accept" onclick="confirmPhaseAccept({{ $intern->id }}, '{{ $intern->first_name }} {{ $intern->last_name }}', 'deployment')">
                                                <i class="fas fa-check"></i>
                                                Accept Phase
                                            </button>
                                            <button type="button" class="btn btn-reject" onclick="confirmPhaseReject({{ $intern->id }}, '{{ $intern->first_name }} {{ $intern->last_name }}', 'deployment')">
                                                <i class="fas fa-times"></i>
                                                Reject Phase
                                            </button>
                                        @endif

                                        <button type="button" class="btn btn-delete" onclick="confirmDelete({{ $intern->id }}, '{{ $intern->first_name }} {{ $intern->last_name }}')">
                                            <i class="fas fa-trash"></i>
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-user-slash"></i>
                <h3>No Interns Found</h3>
                <p>No interns match the current filter criteria</p>
            </div>
        @endif
    </div>

    <script>
        // Generate and copy invitation link to clipboard
        async function generateAndCopyInviteLink() {
            try {
                const button = event.target;
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating...';
                button.disabled = true;

                const response = await fetch('{{ route('interns.invite-link') }}', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                });

                if (!response.ok) {
                    throw new Error('Failed to generate invitation link');
                }

                const data = await response.json();
                const inviteLink = data.link;

                await navigator.clipboard.writeText(inviteLink);

                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Invitation link generated and copied to clipboard! You can now paste it anywhere.',
                    confirmButtonColor: '#10b981',
                    timer: 3000,
                    timerProgressBar: true,
                });

                button.innerHTML = originalText;
                button.disabled = false;

            } catch (error) {
                console.error('Error generating invitation link:', error);
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to generate invitation link. Please try again.',
                    confirmButtonColor: '#ef4444',
                });
                
                const button = event.target;
                button.innerHTML = '<i class="fas fa-link"></i> Generate Invitation Link';
                button.disabled = false;
            }
        }

        // Accept intern confirmation
        function confirmAccept(internId, internName) {
            Swal.fire({
                title: 'Accept Intern?',
                text: `Are you sure you want to accept ${internName}? This will allow them to log in and start their internship.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, accept!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `/interns/${internId}/accept`;
                }
            });
        }

        // Reject intern confirmation
        function confirmReject(internId, internName) {
            Swal.fire({
                title: 'Reject Intern?',
                text: `Are you sure you want to reject ${internName}? This will remove them from the intern list.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f59e0b',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, reject!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `/interns/${internId}/reject`;
                }
            });
        }

        // Phase accept confirmation
        function confirmPhaseAccept(internId, internName, phase) {
            Swal.fire({
                title: `Accept ${phase.charAt(0).toUpperCase() + phase.slice(1)} Phase?`,
                text: `Are you sure you want to accept the ${phase} phase for ${internName}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, accept!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    if (phase === 'pre-deployment') {
                        window.location.href = `/interns/${internId}/accept-pre-deployment`;
                    } else if (phase === 'mid-deployment') {
                        window.location.href = `/interns/${internId}/accept-mid-deployment`;
                    } else if (phase === 'deployment') {
                        window.location.href = `/interns/${internId}/accept-deployment`;
                    }
                }
            });
        }

        // Phase reject confirmation
        function confirmPhaseReject(internId, internName, phase) {
            Swal.fire({
                title: `Reject ${phase.charAt(0).toUpperCase() + phase.slice(1)} Phase?`,
                text: `Are you sure you want to reject the ${phase} phase for ${internName}? They will need to resubmit their documents.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f59e0b',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, reject!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    if (phase === 'pre-deployment') {
                        window.location.href = `/interns/${internId}/reject-pre-deployment`;
                    } else if (phase === 'mid-deployment') {
                        window.location.href = `/interns/${internId}/reject-mid-deployment`;
                    } else if (phase === 'deployment') {
                        window.location.href = `/interns/${internId}/reject-deployment`;
                    }
                }
            });
        }

        // Delete intern confirmation
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
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/interns/${internId}`;
                    
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';
                    
                    form.appendChild(csrfToken);
                    form.appendChild(methodField);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Show session messages with SweetAlert
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