@extends('layouts.app')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #dc2626;
            --primary-dark: #b91c1c;
            --secondary: #111827;
            --success: #dc2626;
            --warning: #f8fafc;
            --danger: #b91c1c;
            --dark: #111827;
            --light: #ffffff;
            --border: rgba(17, 24, 39, 0.12);
            --shadow: 0 12px 30px rgba(17, 24, 39, 0.08);
            --shadow-lg: 0 20px 50px rgba(17, 24, 39, 0.12);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body { font-family: 'Inter', sans-serif; background: #eef2ff; color: #111827; padding: 0; }

        .dashboard-container {
            width: 100%;
            max-width: none;
            margin: 0;
            padding: 28px 24px 44px;
        }

        .dashboard-main {
            width: 100%;
            margin: 0;
            min-height: auto;
        }

        .admin-profile-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            padding: 18px 20px;
            background: linear-gradient(135deg, #ffffff 0%, #fff5f5 100%);
            border: 1px solid rgba(220, 38, 38, 0.12);
            border-radius: 18px;
            box-shadow: var(--shadow);
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .admin-avatar {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 700;
            box-shadow: 0 12px 24px rgba(220, 38, 38, 0.22);
        }

        .admin-meta {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .admin-label {
            font-size: 11px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--secondary);
            font-weight: 700;
        }

        .admin-name {
            font-size: 20px;
            font-weight: 700;
            color: var(--dark);
        }

        .header {
            margin-bottom: 28px;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .header p {
            color: var(--secondary);
            font-size: 14px;
        }

        .datetime-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .datetime-card {
            background: var(--light);
            padding: 22px;
            border-radius: 18px;
            box-shadow: var(--shadow);
            border-left: 4px solid var(--primary);
            opacity: 0;
            transform: translateY(18px);
            animation: fadeInUp 0.8s ease forwards;
            min-height: 112px;
        }

        .datetime-card h3 {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--secondary);
            margin-bottom: 12px;
            font-weight: 600;
        }

        .datetime-card p {
            font-size: 18px;
            font-weight: 600;
            color: var(--dark);
            margin: 0;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--light);
            padding: 24px;
            border-radius: 16px;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            opacity: 0;
            transform: translateY(18px);
            animation: fadeInUp 0.8s ease forwards;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            opacity: 0.1;
            transform: translate(30%, -30%);
        }

        .stat-card.success::before {
            background: var(--success);
        }

        .stat-card.danger::before {
            background: var(--danger);
        }

        .stat-card.primary::before {
            background: var(--primary);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            font-size: 20px;
            animation: iconPulse 1.8s ease-in-out infinite;
        }

        .stat-card.success .stat-icon,
        .stat-card.danger .stat-icon,
        .stat-card.primary .stat-icon {
            background: rgba(220, 38, 38, 0.12);
            color: var(--dark);
        }

        .stat-label {
            font-size: 13px;
            color: var(--secondary);
            margin-bottom: 8px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .stat-change {
            font-size: 12px;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Review Chart - SMALLER */
        .chart-section {
            background: var(--light);
            padding: 20px;
            border-radius: 16px;
            box-shadow: var(--shadow);
            margin-bottom: 32px;
            opacity: 0;
            transform: translateY(18px);
            animation: fadeInUp 0.8s ease forwards;
            animation-delay: 0.25s;
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .chart-header h3 {
            font-size: 15px;
            font-weight: 700;
            color: var(--dark);
        }

        .circular-chart {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px 0;
        }

        .circle-progress {
            position: relative;
            width: 160px;
            height: 160px;
        }

        .circle-progress svg {
            width: 100%;
            height: 100%;
        }

        .circle-bg {
            fill: none;
            stroke: rgba(17, 24, 39, 0.08);
            stroke-width: 8;
        }

        .circle-bar {
            fill: none;
            stroke: var(--danger);
            stroke-width: 8;
            stroke-linecap: round;
            transform: rotate(-90deg);
            transform-origin: center;
            transition: stroke-dashoffset 1s ease;
        }

        .circle-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }

        .circle-text .percentage {
            font-size: 22px;
            font-weight: 700;
            color: var(--dark);
        }

        .circle-text .label {
            font-size: 10px;
            color: var(--secondary);
            margin-top: 2px;
        }

        @keyframes dashboardFadeIn {
            from {
                opacity: 0;
                transform: translateY(16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(18px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Progress Section - SMALLER */
        .progress-section {
            background: var(--light);
            padding: 20px;
            border-radius: 16px;
            box-shadow: var(--shadow);
            opacity: 0;
            transform: translateY(18px);
            animation: fadeInUp 0.8s ease forwards;
            animation-delay: 0.35s;
        }

        .progress-header {
            margin-bottom: 16px;
        }

        .progress-header h3 {
            font-size: 15px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .region-tags {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .region-tag {
            padding: 3px 8px;
            border-radius: 14px;
            font-size: 10px;
            font-weight: 600;
            color: white;
        }

        .region-tag.north { background: var(--primary); }
        .region-tag.west { background: #111827; }
        .region-tag.south { background: #000000; }
        .region-tag.east { background: var(--danger); }

        .progress-item {
            margin-bottom: 16px;
        }

        .progress-item:last-child {
            margin-bottom: 0;
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
        }

        .progress-label span:first-child {
            font-size: 12px;
            font-weight: 600;
            color: var(--dark);
        }

        .progress-label span:last-child {
            font-size: 11px;
            font-weight: 600;
            color: var(--primary);
        }

        .progress-bar-container {
            background: rgba(17, 24, 39, 0.08);
            height: 6px;
            border-radius: 3px;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary) 0%, #f87171 100%);
            border-radius: 3px;
            transition: width 1s ease;
            position: relative;
        }

        .progress-bar-fill::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3));
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        @keyframes iconPulse {
            0%, 100% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.08);
                opacity: 0.85;
            }
        }

        .graphs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
            opacity: 0;
            transform: translateY(18px);
            animation: fadeInUp 0.8s ease forwards;
            animation-delay: 0.4s;
        }

        .graph-card {
            background: var(--light);
            padding: 24px;
            border-radius: 18px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(17, 24, 39, 0.08);
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 18px;
            min-height: 340px;
        }

        .chart-wrapper {
            position: relative;
            width: 100%;
            min-height: 260px;
        }

        .graph-card canvas {
            width: 100% !important;
            height: 100% !important;
            max-height: 100%;
        }

        .graph-card h4 {
            font-size: 15px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 16px;
        }

        .chart-legend {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 18px;
        }

        .chart-legend-item {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(17, 24, 39, 0.05);
            font-size: 12px;
            color: var(--secondary);
        }

        .chart-legend-color {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
        }

        @media (max-width: 980px) {
            .dashboard-container { padding: 24px 18px 36px; }
            .graph-card { min-height: 320px; padding: 20px; }
            .chart-wrapper { min-height: 260px; }
            .circle-progress { width: 140px; height: 140px; }
        }

        @media (max-width: 720px) {
            .dashboard-container { padding: 20px 16px 30px; }
            .datetime-cards,
            .stats-grid,
            .graphs-grid,
            .footer-stats { grid-template-columns: 1fr; }
            .datetime-card,
            .stat-card,
            .chart-section,
            .progress-section,
            .graph-card { width: 100%; }
            .chart-header,
            .progress-header { display: flex; flex-direction: column; align-items: flex-start; gap: 10px; }
            .graph-card { min-height: auto; padding: 18px; }
            .chart-wrapper { min-height: 220px; }
            .footer-stats { gap: 12px; }
            .footer-stat { min-width: unset; padding: 14px 16px; }
            .circle-progress { width: 130px; height: 130px; }
        }

        @media (max-width: 560px) {
            .dashboard-container { padding: 18px 14px 28px; }
            .header h1 { font-size: 24px; }
            .header p { font-size: 13px; }
            .datetime-card { padding: 18px; }
            .datetime-card h3 { font-size: 11px; }
            .datetime-card p { font-size: 16px; }
            .stat-card { padding: 18px; }
            .stat-label { font-size: 11px; }
            .stat-value { font-size: 28px; }
            .chart-wrapper { min-height: 200px; }
            .chart-legend { gap: 8px; }
            .chart-legend-item { padding: 6px 10px; font-size: 11px; }
            .footer-stat { font-size: 13px; gap: 10px; }
        }

        /* Footer Stats */
        .footer-stats {
            display: flex;
            gap: 16px;
            margin-top: 32px;
            flex-wrap: wrap;
            opacity: 0;
            transform: translateY(18px);
            animation: fadeInUp 0.8s ease forwards;
            animation-delay: 0.45s;
        }

        .footer-stat {
            flex: 1;
            min-width: 200px;
            padding: 16px 20px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 600;
        }

        .footer-stat.total {
            background: rgba(220, 38, 38, 0.1);
            color: var(--primary);
        }

        .footer-stat.active {
            background: rgba(17, 24, 39, 0.08);
            color: var(--secondary);
        }

        .footer-stat i {
            font-size: 18px;
        }
    </style>
    <div class="dashboard-container">
        <div class="dashboard-main">
        <div class="header">
          
        </div>

        <!-- Date & Time -->
        <div class="datetime-cards">
            <div class="datetime-card">
                <h3><i class="fas fa-calendar"></i> Date Today</h3>
                <p>{{ \Carbon\Carbon::now()->format('l, F j, Y') }}</p>
            </div>
            <div class="datetime-card">
                <h3><i class="fas fa-clock"></i> Current Time</h3>
                <p>{{ \Carbon\Carbon::now()->format('h:i A') }}</p>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card success">
                <div class="stat-icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stat-label">Total Interns</div>
                <div class="stat-value">{{ $acceptedCount }}</div>
                <div class="stat-change">
                    <i class="fas fa-arrow-up"></i>
                    <span>Active interns</span>
                </div>
            </div>

            <div class="stat-card danger">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-label">Pending Reviews</div>
                <div class="stat-value">{{ $toReview }}</div>
                <div class="stat-change">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>Requires attention</span>
                </div>
            </div>

            <div class="stat-card primary">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-label">Total Students</div>
                <div class="stat-value">{{ $acceptedCount + $pendingCount }}</div>
                <div class="stat-change">
                    <i class="fas fa-info-circle"></i>
                    <span>All registered</span>
                </div>
            </div>

            <div class="stat-card success">
                <div class="stat-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-label">Document Requests</div>
                <div class="stat-value">{{ $documentCount ?? 0 }}</div>
                <div class="stat-change">
                    <i class="fas fa-arrow-up"></i>
                    <span>In review</span>
                </div>
            </div>
        </div>

        <!-- Review Chart -->
        <div class="chart-section">
            <div class="chart-header">
                <h3>Review Status Overview</h3>
            </div>
            <div class="circular-chart">
                <div class="circle-progress">
                    <svg viewBox="0 0 140 140" preserveAspectRatio="xMidYMid meet">
                        <circle class="circle-bg" cx="70" cy="70" r="60"></circle>
                        <circle class="circle-bar" cx="70" cy="70" r="60"
                                stroke-dasharray="{{ 2 * 3.14159 * 60 }}"
                                stroke-dashoffset="{{ 2 * 3.14159 * 60 * (1 - $toReviewPercent / 100) }}">
                        </circle>
                    </svg>
                    <div class="circle-text">
                        <div class="percentage">{{ $toReviewPercent }}%</div>
                        <div class="label">Pending</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Overview -->
        <div class="progress-section">
            <div class="progress-header">
                <h3>Progress Overview</h3>
                <div class="region-tags">
                    <span class="region-tag north">North Region</span>
                    <span class="region-tag west">West Region</span>
                    <span class="region-tag south">South Region</span>
                    <span class="region-tag east">East Region</span>
                </div>
            </div>

            <div class="progress-item">
                <div class="progress-label">
                    <span>Today's Progress</span>
                    <span>{{ $todayProgress }}%</span>
                </div>
                <div class="progress-bar-container">
                    <div class="progress-bar-fill" style="width: {{ $todayProgress }}%;"></div>
                </div>
            </div>

            <div class="progress-item">
                <div class="progress-label">
                    <span>This Week's Progress</span>
                    <span>{{ $weekProgress }}%</span>
                </div>
                <div class="progress-bar-container">
                    <div class="progress-bar-fill" style="width: {{ $weekProgress }}%;"></div>
                </div>
            </div>

            <div class="progress-item">
                <div class="progress-label">
                    <span>This Month's Progress</span>
                    <span>{{ $monthProgress }}%</span>
                </div>
                <div class="progress-bar-container">
                    <div class="progress-bar-fill" style="width: {{ $monthProgress }}%;"></div>
                </div>
            </div>
        </div>

        <div class="graphs-grid">
            <div class="graph-card">
                <h4>Intern Growth (Last 6 Months)</h4>
                <div class="chart-wrapper">
                    <canvas id="internGrowthChart" width="400" height="240"></canvas>
                </div>
            </div>
            <div class="graph-card">
                <h4>Supervisor Distribution</h4>
                <div class="chart-wrapper">
                    <canvas id="supervisorDistributionChart" width="400" height="240"></canvas>
                </div>
                <div class="chart-legend">
                    @foreach($supervisorLabels as $index => $label)
                        <span class="chart-legend-item">
                            <span class="chart-legend-color" style="background: {{ ['#2563eb', '#10b981', '#f59e0b', '#e11d48', '#6b7280'][$index % 5] }}"></span>
                            {{ $label }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Footer Stats -->
        <div class="footer-stats">
            <div class="footer-stat total">
                <i class="fas fa-users"></i>
                <span>Total Students: {{ $acceptedCount + $pendingCount }}</span>
            </div>
            <div class="footer-stat active">
                <i class="fas fa-circle"></i>
                <span>Active Online: {{ $acceptedCount }}</span>
            </div>
        </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
    // Animate progress bars on load
    window.addEventListener('load', function() {
        const progressBars = document.querySelectorAll('.progress-bar-fill');
        progressBars.forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => {
                bar.style.width = width;
            }, 100);
        });

        const growthCtx = document.getElementById('internGrowthChart');
        if (growthCtx) {
            new Chart(growthCtx, {
                type: 'bar',
                data: {
                    labels: @json($monthlyLabels),
                    datasets: [{
                        label: 'New Interns',
                        data: @json($monthlyCounts),
                        backgroundColor: 'rgba(37, 99, 235, 0.8)',
                        borderColor: 'rgba(37, 99, 235, 1)',
                        borderWidth: 1,
                        borderRadius: 12,
                        barThickness: 22,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#111827',
                            titleColor: '#f8fafc',
                            bodyColor: '#f8fafc'
                        }
                    },
                    scales: {
                        x: {
                            ticks: { color: '#475569' },
                            grid: { display: false }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: { color: '#475569', stepSize: 1 },
                            grid: { color: 'rgba(17, 24, 39, 0.08)' }
                        }
                    }
                }
            });
        }

        const supervisorCtx = document.getElementById('supervisorDistributionChart');
        if (supervisorCtx) {
            new Chart(supervisorCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($supervisorLabels),
                    datasets: [{
                        data: @json($supervisorCounts),
                        backgroundColor: ['#2563eb', '#10b981', '#f59e0b', '#e11d48', '#6b7280'],
                        hoverOffset: 12,
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#111827',
                            titleColor: '#f8fafc',
                            bodyColor: '#f8fafc'
                        }
                    }
                }
            });
        }
    });

    // Update time every minute
    setInterval(function() {
        location.reload();
    }, 60000);
    </script>
@endsection