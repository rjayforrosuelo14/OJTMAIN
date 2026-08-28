<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Intern Dashboard - OJT Management System')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        :root {
            --brand-primary: #2563eb;
            --brand-secondary: #6366f1;
            --brand-accent: #0891b2;
            --brand-success: #059669;
            --brand-warning: #f59e0b;
            --brand-danger: #dc2626;
            --brand-dark: #1e293b;
            --brand-light: #f8fafc;
            --gradient-premium: linear-gradient(135deg, #2563eb 0%, #6366f1 50%, #0891b2 100%);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 10px 30px rgba(0, 0, 0, 0.12);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(to bottom, #f8fafc 0%, #e8f0fe 100%);
            color: var(--brand-dark);
        }

        /* ========== TOP NAVIGATION ========== */
        .navbar-intern {
            background: linear-gradient(135deg, #38bdf8 0%, #0284c7 100%);
            box-shadow: 0 8px 20px rgba(2, 132, 199, 0.25);
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 3px solid rgba(0,0,0,0.18);
        }

        .navbar-intern .container-fluid {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 18px;
            display: flex;
            align-items: center;
            gap: 14px;
            min-height: 64px;
        }

        .brand-intern {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            margin: 0;
            line-height: 1;
            padding: 4px 8px;
            border-radius: 10px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.2);
            height: auto;
        }

        .brand-logo {
            width: 140px;
            height: auto;
            display: block;
            object-fit: contain;
            filter: drop-shadow(0 3px 10px rgba(0, 0, 0, 0.15));
        }

        .navbar-intern .nav-actions {
            display: flex;
            gap: 24px;
            align-items: center;
            margin-left: auto;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #ffffff;
            font-weight: 700;
            font-size: 40px;
            line-height: 1;
        }

        .user-avatar {
            width: 42px;
            height: 42px;
            background: rgba(0,0,0,0.18);
            border: 2px solid rgba(255,255,255,0.45);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 16px;
            box-shadow: 0 3px 9px rgba(0,0,0,0.2);
        }

        .logout-btn {
            background: linear-gradient(135deg, rgba(255,255,255,0.18) 0%, rgba(255,255,255,0.08) 100%);
            color: #ffffff;
            padding: 8px 14px;
            border: 1px solid rgba(255,255,255,0.35);
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 16px;
            line-height: 1;
            height: auto;
            box-shadow: 0 4px 10px rgba(0,0,0,0.12);
        }

        .logout-btn:hover {
            background: rgba(0,0,0,0.12);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(0,0,0,0.18);
        }

        /* ========== MAIN CONTENT ========== */
        .main-content-intern {
            min-height: calc(100vh - 80px);
            padding: 40px 0;
        }

        /* ========== UTILITIES ========== */
        .container-lg {
            max-width: 1200px;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        a:hover {
            text-decoration: none;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .navbar-intern .container-fluid {
                padding: 0 16px;
                gap: 16px;
            }

            .navbar-intern .nav-actions {
                gap: 12px;
            }

            .user-info span {
                display: none;
            }

            .brand-intern {
                padding: 4px 8px;
            }

            .brand-logo {
                width: clamp(160px, 48vw, 220px);
            }

            .main-content-intern {
                padding: 20px 0;
            }
        }
    </style>

    @yield('styles')
</head>
<body>
    <!-- Top Navigation -->
    <nav class="navbar-intern">
        <div class="container-fluid">
            <a href="{{ route('intern.dashboard') }}" class="brand-intern" aria-label="Intern Dashboard">
                <img src="{{ asset('images/intern-logo.svg') }}" alt="Intern Management Logo" class="brand-logo">
            </a>

            <div class="nav-actions">
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::guard('intern')->user()?->first_name ?? 'I', 0, 1)) }}
                    </div>
                    <span>{{ Auth::guard('intern')->user()?->first_name ?? 'Intern' }}</span>
                </div>

                <a href="{{ route('intern.logout') }}" class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>

                <form id="logout-form" action="{{ route('intern.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content-intern">
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('scripts')
</body>
</html>
