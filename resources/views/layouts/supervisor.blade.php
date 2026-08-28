<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Supervisor Dashboard - OJT Management</title>
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

    * { margin: 0; padding: 0; box-sizing: border-box; }

    html { margin: 0; padding: 0; }
    
    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
      background: #f4f6f9;
      min-height: 100vh;
      color: var(--brand-dark);
    }

    .container-full {
      max-width: none;
      width: 100%;
      margin: 0;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /* AdminLTE-style top navigation */
    .supervisor-navbar {
      height: 60px;
      padding: 0;
      background: #0069d9;
      box-shadow: 0 1px 2px rgba(0, 0, 0, 0.16);
      color: #fff;
    }

    .navbar-content {
      display: flex;
      align-items: center;
      height: 100%;
  
    }

    .brand-supervisor {
      width: 142px;
      height: 36px;
      padding: 0 38px;
      font-size: 20px;
      font-weight: 700;
      color: #fff;
      display: flex;
      align-items: center;
      gap: 7px;
      text-decoration: none;
      white-space: nowrap;
    }

    .brand-supervisor i {
      display: inline-block;
      font-size: 14px;
      color: #fff;
    }

    .brand-supervisor img {
      width: 34px;
      height: 34px;
      border-radius: 50%;
      object-fit: cover;
      background: #fff;
      flex-shrink: 0;
    }

    .supervisor-actions {
      display: flex;
      gap: 0;
      align-items: center;
      margin-left: auto;
      height: 100%;
    }

    .supervisor-user {
      display: flex;
      align-items: center;
      gap: 6px;
      height: 100%;
      padding: 0 10px 0 6px;
      color: rgba(255, 255, 255, 0.92);
      font-weight: 500;
      font-size: 9px;
    }

    .user-avatar {
      width: 40px;
      height: 40px;
      background: #d5d9dc;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #53606b;
      font-size: 40px;
      overflow: hidden;
    }

    .logout-link {
      color: transparent;
      width: 0;
      padding: 0;
      border: 0;
      overflow: hidden;
      pointer-events: none;
    }

    .notification-link {
      width: 38px;
      height: 36px;
      color: rgba(255, 255, 255, 0.9);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      text-decoration: none;
      font-size: 20px;
      transition: background-color 0.2s ease;
    }

    .notification-link:hover {
      background: rgba(255, 255, 255, 0.1);
      color: #fff;
    }

    .main-content { 
      flex: 1;
      padding: 28px 32px;
      overflow-y: auto;
    }

    /* Custom Scrollbar */
    .main-content::-webkit-scrollbar {
      width: 8px;
    }

    .main-content::-webkit-scrollbar-track {
      background: rgba(0, 0, 0, 0.05);
      border-radius: 10px;
    }

    .main-content::-webkit-scrollbar-thumb {
      background: var(--gradient-premium);
      border-radius: 10px;
    }

    .main-content::-webkit-scrollbar-thumb:hover {
      background: var(--brand-primary);
    }

    /* Responsive */
    @media (max-width: 768px) {
      .supervisor-navbar {
        height: 36px;
      }

      .brand-supervisor {
        width: 142px;
        padding-left: 38px;
        padding-right: 0;
      }

      .supervisor-user span {
        display: inline;
      }

      .main-content {
        padding: 20px 16px;
      }

      .brand-supervisor {
        font-size: 18px;
      }
    }
  </style>
</head>
<body>
  <div class="container-full">
    <!-- Top Navigation -->
    <nav class="supervisor-navbar">
      <div class="navbar-content">
        <a href="{{ route('supervisor.dashboard') }}" class="brand-supervisor">
          <img src="{{ asset('ojt-logo.jpg') }}" alt="OJT logo"> OJT
        </a>

        <div class="supervisor-actions">
          <a href="{{ route('supervisor.messages') }}" class="notification-link" aria-label="Notifications" title="Notifications">
            <i class="fas fa-bell"></i>
          </a>
          <div class="supervisor-user">
            <div class="user-avatar">
                @php
                    $sup = Auth::guard('supervisor')->user();
                    $img = null;
                    $exts = ['png','jpg','jpeg','gif','webp'];
                    if ($sup) {
                        $base = public_path('storage/supervisor profile/supervisor_' . $sup->id);
                        foreach ($exts as $e) {
                          if (file_exists($base . '.' . $e)) {
                                $img = asset('storage/supervisor profile/supervisor_' . $sup->id . '.' . $e);
                            break;
                          }
                        }
                    }
                @endphp

                @if ($img)
                  <a href="{{ route('supervisor.profile') }}" title="Profile">
                    <img src="{{ $img }}" alt="Profile" style="width:40px; height:40px; border-radius:50%; object-fit:cover; display:block;">
                  </a>
                @else
                  <a href="{{ route('supervisor.profile') }}" title="Profile">
                    <i class="fas fa-user-circle"></i>
                  </a>
                @endif
              </div>
            <span>{{ Auth::guard('supervisor')->user()?->name ?? 'Supervisor' }}</span>
          </div>

          <a href="{{ route('supervisor.logout') }}" class="logout-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> Logout
          </a>

          <form id="logout-form" action="{{ route('supervisor.logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
      @yield('content')
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>
</html>
