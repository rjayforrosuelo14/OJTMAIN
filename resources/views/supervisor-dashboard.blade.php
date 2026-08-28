@extends('layouts.supervisor')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #0f172a;
            --ink-soft: #334155;
            --red: #ef4444;
            --red-dark: #b91c1c;
            --red-mist: rgba(59, 130, 246, 0.08);
            --paper: #f3f8ff;
            --card: #ffffff;
            --line: #dfeafc;
            --line-soft: #edf4ff;
            --muted: #64748b;
            --muted-soft: #94a3b8;
            --blue: #2563eb;
            --blue-soft: #eff6ff;
            --blue-deep: #1d4ed8;
            --green: #22c55e;
            --amber: #f59e0b;

            --shadow-xs: 0 1px 2px rgba(37, 99, 235, 0.05);
            --shadow-sm: 0 6px 18px rgba(37, 99, 235, 0.08);
            --shadow-md: 0 10px 28px rgba(37, 99, 235, 0.10);
            --shadow-red: 0 8px 20px rgba(37, 99, 235, 0.16);

            /* legacy aliases so existing markup keeps working */
            --black: var(--ink);
            --black-soft: var(--ink-soft);
            --red-light: var(--red);
            --white: var(--card);
            --off-white: var(--paper);
            --gray-100: var(--line);
            --gray-200: var(--line);
            --gray-500: var(--muted);
            --gray-700: var(--ink-soft);
            --border: var(--line);
            --shadow: var(--shadow-xs);
            --shadow-lg: var(--shadow-md);
            --primary: var(--blue);
            --secondary: var(--muted);
            --success: var(--green);
            --warning: var(--amber);
            --danger: var(--red);
            --dark: var(--ink);
            --light: var(--paper);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--paper);
            -webkit-font-smoothing: antialiased;
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.001ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.001ms !important;
            }
        }

        /* ---------- restrained, professional motion ---------- */
        @keyframes riseIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes railGrow {
            from { width: 0; }
            to { width: 40px; }
        }

        @keyframes barFill {
            from { width: 0; }
        }

        @keyframes softPulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.45; }
        }

        @keyframes floatCard {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-3px); }
        }

        @keyframes shimmer {
            0% { background-position: 0% 50%; }
            100% { background-position: 100% 50%; }
        }

        /* ---------- header ---------- */
        .supervisor-header {
            position: relative;
            margin-bottom: 28px;
            animation: riseIn 0.45s ease both;
        }

        .supervisor-header h1 {
            margin: 0 0 6px 0;
            font-size: 24px;
            font-weight: 700;
            color: var(--ink);
            letter-spacing: -0.2px;
        }

        .supervisor-header p {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
        }

        .supervisor-header::after {
            content: '';
            display: block;
            width: 40px;
            height: 2px;
            margin-top: 12px;
            background: var(--red);
            border-radius: 2px;
            animation: railGrow 0.6s ease 0.15s both;
        }

        .header-btn {
            border-radius: 8px;
            padding: 9px 16px;
            background: var(--card);
            color: var(--ink);
            border: 1px solid var(--line);
            font-weight: 600;
            font-size: 13px;
            transition: border-color 0.2s ease, color 0.2s ease, background-color 0.2s ease;
        }

        .header-btn:hover {
            border-color: var(--ink);
            background: var(--ink);
            color: var(--card);
        }

        .header-btn.danger {
            color: var(--red);
            border-color: var(--line);
        }

        .header-btn.danger:hover {
            background: var(--red);
            border-color: var(--red);
            color: var(--card);
        }

        /* ---------- stat cards ---------- */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 26px;
        }

        .stat-card {
            background: #edf7ff;
            padding: 18px 20px;
            border-radius: 14px;
            box-shadow: inset 0 0 0 1px rgba(148, 163, 184, 0.12);
            border: 1px solid rgba(148, 163, 184, 0.18);
            transition: box-shadow 0.25s ease, transform 0.25s ease, border-color 0.25s ease;
            animation: riseIn 0.45s ease both;
            display: flex;
            align-items: center;
            gap: 14px;
            position: relative;
            overflow: hidden;
            min-height: 110px;
        }

        /* White-and-blue card palette */
        .stats-grid .stat-card:nth-child(1) { background: #eaf6ff; }
        .stats-grid .stat-card:nth-child(2) { background: #edfdf3; }
        .stats-grid .stat-card:nth-child(3) { background: #fff1f2; }
        .stats-grid .stat-card:nth-child(4) { background: #f7f8ff; }

        .stats-grid .stat-card:nth-child(1) { animation-delay: 0.02s; }
        .stats-grid .stat-card:nth-child(2) { animation-delay: 0.08s; }
        .stats-grid .stat-card:nth-child(3) { animation-delay: 0.14s; }
        .stats-grid .stat-card:nth-child(4) { animation-delay: 0.2s; }

        .stat-card:hover {
            box-shadow: var(--shadow-sm);
            transform: translateY(-2px);
            border-color: var(--muted-soft);
        }

        .stat-icon {
            flex-shrink: 0;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            background: rgba(255,255,255,0.9);
            color: var(--blue-deep);
            border: 1px solid rgba(37, 99, 235, 0.14);
            position: relative;
            z-index: 1;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.06);
        }

        .stat-card.present .stat-icon {
            color: #16a34a;
            background: rgba(255,255,255,0.9);
            border-color: rgba(34, 197, 94, 0.18);
        }

        .stat-card.absent .stat-icon {
            color: var(--red);
            background: rgba(255,255,255,0.9);
            border-color: rgba(239, 68, 68, 0.18);
        }

        .stat-card.not-released .stat-icon {
            color: #2563eb;
            background: rgba(255,255,255,0.9);
            border-color: rgba(37, 99, 235, 0.18);
        }

        .stat-body { flex: 1; min-width: 0; }

        .stat-label {
            color: #475569;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 8px;
            line-height: 1.2;
        }

        .stat-value {
            font-size: 27px;
            font-weight: 800;
            color: var(--ink);
            letter-spacing: -0.4px;
            line-height: 1;
        }

        .stat-card.absent .stat-value,
        .stat-card.not-released .stat-value { color: var(--ink); }

        .stats-grid .stat-card:nth-child(1) .stat-value { color: #1d4ed8; }
        .stats-grid .stat-card:nth-child(2) .stat-value { color: #16a34a; }
        .stats-grid .stat-card:nth-child(3) .stat-value { color: #ef4444; }
        .stats-grid .stat-card:nth-child(4) .stat-value { color: #1d4ed8; }

        /* ---------- main section ---------- */
        .interns-section {
            background: linear-gradient(180deg, #ffffff, #f9fbff);
            padding: 26px 28px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.06);
            border: 1px solid var(--line);
            animation: riseIn 0.45s ease 0.06s both;
        }

        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 9px;
            letter-spacing: -0.1px;
        }

        .section-title .title-icon {
            width: 28px;
            height: 28px;
            border-radius: 7px;
            background: var(--red-mist);
            color: var(--red);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        .time-in-btn {
            background: #007bff;
            color: #fff;
            border: none;
            padding: 10px 18px;
            border-radius: 999px;
            cursor: pointer;
            font-weight: 600;
            font-size: 13px;
            transition: background-color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
            margin-bottom: 18px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.18);
        }

        .time-in-btn:hover { background: #0069d9; transform: translateY(-1px); }

        .time-in-btn:disabled {
            background: var(--muted-soft);
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .active-session-banner {
            background: var(--card);
            border: 1px solid var(--line);
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 18px;
            box-shadow: var(--shadow-xs);
            display: flex;
            align-items: center;
            gap: 13px;
            animation: fadeIn 0.4s ease both;
        }

        .active-session-banner .session-icon {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--ink);
            color: var(--card);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 12px;
        }

        .active-session-banner .session-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--red);
            display: inline-block;
            margin-right: 6px;
            animation: softPulse 1.8s ease-in-out infinite;
        }

        .active-session-banner strong {
            color: var(--ink);
            font-size: 13.5px;
            display: flex;
            align-items: center;
        }

        .active-session-banner p {
            margin: 3px 0 0 0;
            color: var(--muted);
            font-size: 12.5px;
        }

        /* ---------- table ---------- */
        .interns-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            overflow: hidden;
            border-radius: 12px;
            background: linear-gradient(180deg, rgba(17,17,19,0.02), rgba(17,17,19,0.005));
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.65);
        }

        .interns-table thead {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.10), rgba(96, 165, 250, 0.08), rgba(148, 163, 184, 0.08));
        }

        .interns-table th {
            padding: 13px 14px;
            text-align: left;
            font-weight: 700;
            color: var(--ink);
            border-bottom: 1px solid var(--line);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            background: linear-gradient(90deg, rgba(59,130,246,0.06), rgba(34,197,94,0.05), rgba(234,179,8,0.05), rgba(220,38,38,0.05));
        }

        .interns-table td {
            padding: 15px 14px;
            border-bottom: 1px solid var(--line-soft);
            font-size: 13.5px;
            color: var(--ink-soft);
            vertical-align: middle;
            background: linear-gradient(90deg, rgba(255,255,255,0.78), rgba(247,247,248,0.96));
        }

        .interns-table tbody tr {
            animation: fadeIn 0.4s ease both;
            transition: background-color 0.18s ease, transform 0.18s ease, box-shadow 0.18s ease;
            position: relative;
        }

        .interns-table tbody tr:nth-child(odd) td {
            background: linear-gradient(90deg, rgba(59,130,246,0.05), rgba(255,255,255,0.88), rgba(34,197,94,0.04));
        }

        .interns-table tbody tr:nth-child(even) td {
            background: linear-gradient(90deg, rgba(234,179,8,0.05), rgba(255,255,255,0.9), rgba(220,38,38,0.04));
        }

        .interns-table tbody tr:hover {
            background: linear-gradient(90deg, rgba(59,130,246,0.09), rgba(34,197,94,0.07), rgba(234,179,8,0.06), rgba(220,38,38,0.08));
            transform: translateY(-1px);
            box-shadow: inset 0 0 0 1px rgba(200,30,58,0.08);
        }

        .interns-table tbody tr:last-child td {
            border-bottom: none;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 600;
        }

        .status-present {
            background-color: var(--paper);
            color: var(--ink);
            border: 1px solid var(--line);
        }

        .status-absent {
            background-color: var(--red-mist);
            color: var(--red);
            border: 1px solid rgba(200, 30, 58, 0.15);
        }

        .status-not-released {
            background-color: var(--paper);
            color: var(--muted);
            border: 1px solid var(--line);
        }

        .progress-track {
            background: #f1f5f9;
            height: 14px;
            border-radius: 999px;
            overflow: hidden;
            min-width: 120px;
        }

        .progress-fill {
            background: #111827;
            height: 100%;
            display: block;
            border-radius: 999px;
            transition: width 0.6s ease;
        }

        .progress-fill.is-complete {
            background: var(--red);
        }

        .empty-state {
            text-align: center;
            padding: 36px;
            color: var(--muted);
            animation: fadeIn 0.4s ease both;
        }

        .empty-state-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: var(--paper);
            border: 1px solid var(--line);
            color: var(--muted-soft);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            margin: 0 auto 14px auto;
        }

        .btn-action {
            padding: 7px 11px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12.5px;
            font-weight: 600;
            transition: background-color 0.2s ease, color 0.2s ease, transform 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-present {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid rgba(6,95,70,0.12);
        }

        .btn-present:hover {
            background: #10b981;
            color: #fff;
            border-color: #10b981;
        }

        .btn-absent {
            background: #fff1f2;
            color: #b91c1c;
            border: 1px solid rgba(185,28,28,0.12);
        }

        .btn-absent:hover {
            background: #ef4444;
            color: #fff;
            border-color: #ef4444;
        }

        .completed-pill {
            background: var(--paper);
            color: var(--muted);
            padding: 7px 11px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1px solid var(--line);
        }

        /* ---------- incoming intern cards ---------- */
        .incoming-card {
            background: #ffffff;
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 18px;
            box-shadow: var(--shadow-xs);
            transition: box-shadow 0.25s ease, transform 0.25s ease, border-color 0.25s ease;
            animation: riseIn 0.4s ease both;
            position: relative;
            overflow: hidden;
        }

        .incoming-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                repeating-linear-gradient(135deg, rgba(17,17,19,0.035) 0 2px, transparent 2px 10px);
            opacity: 0.28;
            pointer-events: none;
        }

        .incoming-card::after {
            content: '';
            position: absolute;
            width: 140px;
            height: 140px;
            right: -50px;
            top: -55px;
            border-radius: 50%;
            background: rgba(17,17,19,0.05);
            opacity: 0.7;
            pointer-events: none;
        }

        .incoming-card:hover {
            box-shadow: var(--shadow-sm);
            transform: translateY(-2px);
            border-color: var(--muted-soft);
            animation: floatCard 4s ease-in-out infinite;
        }

        .incoming-card h4 {
            margin: 0 0 4px 0;
            color: var(--ink);
            font-weight: 700;
            font-size: 14.5px;
            display: flex;
            align-items: center;
            gap: 7px;
            position: relative;
            z-index: 1;
        }

        .incoming-card .avatar-dot {
            width: 22px;
            height: 22px;
            border-radius: 6px;
            background: var(--paper);
            border: 1px solid var(--line);
            color: var(--muted);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            flex-shrink: 0;
        }

        .incoming-card .meta-line {
            margin: 4px 0;
            font-size: 12.5px;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 6px;
            position: relative;
            z-index: 1;
        }

        .incoming-card .info-box {
            background:
                linear-gradient(180deg, rgba(255,255,255,0.96), rgba(247,247,248,0.92));
            padding: 10px 11px;
            border-radius: 10px;
            margin: 13px 0;
            font-size: 12.5px;
            border: 1px solid var(--line-soft);
            position: relative;
            z-index: 1;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.8);
        }

        .incoming-card .info-box p {
            margin: 5px 0;
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--ink-soft);
        }

        /* incoming interns table design */
        .incoming-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 14px;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid #dfeafc;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.04);
        }

        .incoming-table thead {
            background: #eaf6ff;
        }

        .incoming-table th {
            padding: 14px 16px;
            text-align: left;
            font-weight: 700;
            color: #475569;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            border-bottom: 1px solid #dfeafc;
        }

        .incoming-table td {
            padding: 16px;
            border-bottom: 1px solid #edf4ff;
            font-size: 14px;
            color: #1f2937;
            vertical-align: middle;
            background: #ffffff;
        }

        .incoming-table tbody tr:last-child td {
            border-bottom: none;
        }

        .incoming-table tbody tr:hover td {
            background: #f8fbff;
        }

        .incoming-table .action-cell { text-align: right; }

        .select-inline-btn {
            padding: 10px 18px;
            border-radius: 10px;
            background: #ffffff;
            border: 1px solid rgba(37, 99, 235, 0.2);
            font-weight: 700;
            color: #1d4ed8;
            cursor: pointer;
            transition: all 0.18s ease;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.05);
        }

        .select-inline-btn:hover {
            background: #eff6ff;
            border-color: rgba(37, 99, 235, 0.3);
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.08);
        }

        .incoming-card .info-box strong {
            color: var(--muted);
            font-weight: 600;
        }

        .select-intern-btn {
            width: 100%;
            padding: 9px;
            background: linear-gradient(135deg, var(--blue), var(--blue-deep));
            color: var(--card);
            border: none;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            position: relative;
            z-index: 1;
            background-size: 140% 140%;
            animation: shimmer 7s linear infinite;
        }

        .select-intern-btn:hover {
            background: linear-gradient(135deg, var(--blue-deep), var(--blue));
            transform: translateY(-1px);
            box-shadow: var(--shadow-red);
        }

        .more-available-banner {
            margin-top: 18px;
            text-align: center;
            padding: 12px;
            background: var(--red-mist);
            border-radius: 8px;
            color: var(--red-dark);
            font-size: 13px;
            border: 1px solid rgba(200, 30, 58, 0.15);
            animation: fadeIn 0.5s ease both;
        }

        /* ---------- logout footer ---------- */
        .logout-container {
            margin-top: 36px;
            padding-top: 26px;
            border-top: 1px solid var(--line);
            display: flex;
            justify-content: center;
        }

        .logout-btn {
            padding: 10px 26px;
            background: #ffffff;
            border: 1px solid rgba(37, 99, 235, 0.2);
            color: var(--blue-deep);
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease, border-color 0.2s ease, color 0.2s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.08);
        }

        .logout-btn:hover {
            background: linear-gradient(135deg, var(--blue), var(--blue-deep));
            border-color: var(--blue);
            color: var(--card);
        }
    </style>

    

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <div class="stat-body">
                <div class="stat-label">Total Connected Interns</div>
                <div class="stat-value">{{ $totalInterns }}</div>
            </div>
        </div>
        <div class="stat-card present">
            <div class="stat-icon"><i class="fas fa-user-check"></i></div>
            <div class="stat-body">
                <div class="stat-label">Present Today</div>
                <div class="stat-value">{{ $presentCount }}</div>
            </div>
        </div>
        <div class="stat-card absent">
            <div class="stat-icon"><i class="fas fa-user-times"></i></div>
            <div class="stat-body">
                <div class="stat-label">Absent Today</div>
                <div class="stat-value">{{ $absentCount }}</div>
            </div>
        </div>
        <div class="stat-card not-released">
            <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
            <div class="stat-body">
                <div class="stat-label">Not Time In Yet</div>
                <div class="stat-value">{{ $notNoticedCount }}</div>
            </div>
        </div>
    </div>

    <div class="interns-section">
        <div class="section-title"><span class="title-icon"><i class="fas fa-clock"></i></span> Attendance Management</div>

        @if ($activeAttendance)
            <div class="active-session-banner">
                <div class="session-icon"><i class="fas fa-check"></i></div>
                <div>
                    <strong><span class="session-dot"></span>Attendance Session Active</strong>
                    <p>Interns can time in until {{ $activeAttendance->created_at->addMinutes(5)->format('h:i A') }}</p>
                </div>
            </div>
        @else
            <button class="time-in-btn" onclick="releaseTimeIn()">
                <i class="fas fa-clock"></i> Release Time In (5 min window)
            </button>
        @endif

        <div style="margin-bottom: 18px;">
            <h3 style="margin-bottom: 14px; color: var(--ink); font-size: 15px; font-weight: 700;">Connected Interns</h3>

            @if ($interns->isEmpty())
                <div class="empty-state">
                    <div class="empty-state-icon"><i class="fas fa-users"></i></div>
                    <p>No interns are connected to you yet.</p>
                    <p style="font-size: 13px; margin-top: 8px;">
                        Interns will appear here once they select you as their supervisor.
                    </p>
                </div>
            @else
                <table class="interns-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Hours Tracked</th>
                            <th>Progress</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($interns as $intern)
                            @php
                                // Calculate total hours for this intern
                                $logs = App\Models\TimeLog::where('intern_id', $intern->id)->get();
                                $totalSeconds = 0;
                                foreach ($logs as $log) {
                                    $in = $log->time_in ? \Carbon\Carbon::parse($log->date . ' ' . $log->time_in) : null;
                                    $out = $log->time_out ? \Carbon\Carbon::parse($log->date . ' ' . $log->time_out) : null;
                                    if ($in && !$out) {
                                        $out = \Carbon\Carbon::parse($log->date . ' 17:00:00');
                                    }
                                    if ($in && $out) {
                                        $totalSeconds += $in->diffInSeconds($out);
                                    }
                                }
                                $totalHours = round($totalSeconds / 3600, 1);
                                $remainingHours = max(0, 486 - $totalHours);
                                $progressPercent = min(100, ($totalHours / 486) * 100);
                                $isCompleted = $totalHours >= 486;
                            @endphp
                            <tr style="animation-delay: {{ $loop->index * 0.04 }}s;">
                                <td style="font-weight: 700; color: #2563eb; background: linear-gradient(90deg, rgba(59,130,246,0.08), rgba(255,255,255,0.92));">{{ $intern->first_name }} {{ $intern->last_name }}</td>
                                <td style="color: #16a34a; font-weight: 600;">{{ $intern->email }}</td>
                                <td style="font-weight: 700; color: #ca8a04;">{{ $totalHours }}h / 486h</td>
                                <td style="background: linear-gradient(90deg, rgba(234,179,8,0.08), rgba(255,255,255,0.9));">
                                    <div class="progress-track">
                                        <div class="progress-fill {{ $isCompleted ? 'is-complete' : '' }}" style="width: {{ $progressPercent }}%;">
                                            {{ number_format($progressPercent, 0) }}%
                                        </div>
                                    </div>
                                </td>
                                <td style="background: linear-gradient(90deg, rgba(34,197,94,0.08), rgba(255,255,255,0.9));">
                                    @if ($isCompleted)
                                        <span class="status-badge status-present"><i class="fas fa-check-circle"></i> Completed</span>
                                    @elseif ($intern->attendance_status === 'present')
                                        <span class="status-badge status-present"><i class="fas fa-check-circle"></i> Present</span>
                                    @elseif ($intern->attendance_status === 'absent')
                                        <span class="status-badge status-absent"><i class="fas fa-times-circle"></i> Absent</span>
                                    @else
                                        <span class="status-badge status-not-released"><i class="fas fa-hourglass-half"></i> Pending</span>
                                    @endif
                                </td>
                                <td style="background: linear-gradient(90deg, rgba(220,38,38,0.08), rgba(255,255,255,0.9));">
                                    @if (!$isCompleted)
                                        <form method="POST" action="{{ route('supervisor.markAttendance', $intern->id) }}" style="display: inline-block; margin-right: 5px;">
                                            @csrf
                                            <input type="hidden" name="status" value="present">
                                            <button type="submit" class="btn-action btn-present" title="Mark as Present">
                                                <i class="fas fa-check"></i> Present
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('supervisor.markAttendance', $intern->id) }}" style="display: inline-block;">
                                            @csrf
                                            <input type="hidden" name="status" value="absent">
                                            <button type="submit" class="btn-action btn-absent" title="Mark as Absent">
                                                <i class="fas fa-times"></i> Absent
                                            </button>
                                        </form>
                                    @else
                                        <span class="completed-pill">
                                            <i class="fas fa-check-circle"></i> Completed
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <div style="margin-top: 36px; padding-top: 26px; border-top: 1px solid var(--line);">
            <h3 style="margin-bottom: 18px; color: var(--ink); font-size: 15px; font-weight: 700; display: flex; align-items: center; gap: 10px;">
                <span style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:8px;background:#eaf6ff;color:#2563eb;border:1px solid #dbeafe;font-size:12px;">
                    <i class="fas fa-inbox"></i>
                </span>
                Incoming Interns Available to Select
            </h3>

            @if ($incomingInterns->isEmpty())
                <div class="empty-state">
                    <div class="empty-state-icon"><i class="fas fa-clipboard-list"></i></div>
                    <p>No incoming interns available right now.</p>
                    <p style="font-size: 13px; margin-top: 8px;">
                        Check back later for new interns to manage.
                    </p>
                </div>
            @else
                <table class="incoming-table" role="table" aria-label="Incoming interns">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Company</th>
                            <th>Course / Section</th>
                            <th class="action-cell">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($incomingInterns as $incoming)
                            <tr style="animation-delay: {{ $loop->index * 0.04 }}s;">
                                <td style="font-weight:700; color:#0ea5e9;">{{ $incoming->first_name }} {{ $incoming->last_name }}</td>
                                <td style="color:#0f766e; font-weight:600;">{{ $incoming->email }}</td>
                                <td>{{ $incoming->company_name ?? 'N/A' }}</td>
                                <td>{{ ($incoming->course ?? 'N/A') }} / {{ ($incoming->section ?? 'N/A') }}</td>
                                <td class="action-cell">
                                    <form method="POST" action="{{ route('supervisor.selectIncoming', $incoming->id) }}" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="select-inline-btn">Select Intern</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if (Illuminate\Support\Facades\DB::table('interns')->whereNull('supervisor_id')->where('status', 'accepted')->count() > 10)
                    <div class="more-available-banner">
                        <i class="fas fa-info-circle"></i> Showing 10 of {{ Illuminate\Support\Facades\DB::table('interns')->whereNull('supervisor_id')->where('status', 'accepted')->count() }} available interns
                    </div>
                @endif
            @endif
        </div>
    </div>

    <script>
        function releaseTimeIn() {
            if (confirm('This will open a 5-minute window for interns to time in. Continue?')) {
                // You would implement the AJAX call here to trigger the release
                alert('Time In window release   d!');
            }
        }r
    </script>

    <div class="logout-container">
        <form method="POST" action="{{ route('logout') }}" style="width: 100%; display: flex; justify-content: center;">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i><span>Logout</span>
            </button>
        </form>
    </div>
@endsection