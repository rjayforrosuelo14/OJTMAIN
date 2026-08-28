<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Admin - Intern Management</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
      --gray-300: #d4d4d4;
      --gray-500: #737373;
      --gray-700: #404040;
      --border: #e8e8e8;
      --shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
      --shadow-lg: 0 20px 50px rgba(0, 0, 0, 0.18);
      --shadow-red: 0 10px 24px rgba(220, 38, 38, 0.28);
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    html { margin: 0; padding: 0; }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @keyframes slideInLeft {
      from { opacity: 0; transform: translateX(-14px); }
      to { opacity: 1; transform: translateX(0); }
    }

    @keyframes underlineGrow {
      from { width: 0; }
      to { width: 36px; }
    }

    body {
      font-family: 'Inter', sans-serif;
      background: var(--off-white);
      min-height: 100vh;
      height: auto;
      overflow-x: hidden;
      overflow-y: auto;
      padding: 0; /* remove outer padding so sidebar sits flush to the left */
      margin: 0; /* remove default body margin that creates left gap */
    }

    .dashboard-container {
      max-width: none;
      width: 100%;
      margin: 0;
      display: block;
      background: white;
      border-radius: 0;
      overflow: visible;
      box-shadow: var(--shadow-lg);
      min-height: 100vh;
      height: auto;
      animation: fadeIn 0.4s ease;
    }

    .sidebar {
      width: 280px;
      background: linear-gradient(165deg, var(--black) 0%, var(--black-soft) 60%, var(--charcoal) 100%);
      padding: 32px 20px;
      color: white;
      display: flex;
      flex-direction: column;
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      overflow-y: auto;
      flex-shrink: 0;
      z-index: 10;
    }

    .sidebar::after { content: ''; position: absolute; top: 0; right: 0; width: 1px; height: 100%; background: linear-gradient(180deg, transparent, rgba(220,38,38,0.35), transparent); }

    @media (max-width: 1024px) {
      .dashboard-container {
        flex-direction: column;
        min-height: auto;
      }

      .sidebar {
        width: 100%;
        position: relative;
        height: auto;
        max-height: none;
        overflow: visible;
        padding: 24px 18px;
      }

      .main-content {
        padding: 24px;
        height: auto;
      }
    }

    @media (max-width: 720px) {
      .sidebar {
        padding: 20px 16px;
      }

      .nav-link {
        padding: 12px 14px;
        font-size: 13px;
      }

      .brand h2 {
        font-size: 20px;
      }

      .main-content {
        padding: 18px 14px 24px;
      }
    }

    .brand { position: relative; margin-bottom: 24px; padding-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.08); animation: slideInLeft 0.4s ease both; }
    .brand h2 { color: white; font-size: 24px; font-weight: 800; margin-bottom: 4px; display: flex; align-items: center; gap: 10px; letter-spacing: -0.2px; }
    .brand h2 i { color: var(--red-light); }
    .brand p { color: rgba(255,255,255,0.5); font-size: 13px; margin: 0; }
    .brand::after { content: ''; position: absolute; left: 0; bottom: -1px; width: 36px; height: 2px; background: linear-gradient(90deg, var(--red), var(--red-light)); animation: underlineGrow 0.7s ease 0.2s both; }

    .admin-nav-card {
      display: flex;
      align-items: center;
      gap: 12px;
      background: rgba(255,255,255,0.04);
      border: 1px solid rgba(255,255,255,0.08);
      border-radius: 14px;
      padding: 12px 14px;
      margin-bottom: 18px;
      backdrop-filter: blur(6px);
      box-shadow: inset 0 1px 0 rgba(255,255,255,0.04);
    }

    .admin-nav-avatar {
      width: 42px;
      height: 42px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--red), var(--red-dark));
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 16px;
      font-weight: 700;
      flex-shrink: 0;
      object-fit: cover;
      border: 2px solid rgba(255,255,255,0.12);
    }

    .admin-avatar-form {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 8px;
    }

    .admin-avatar-select {
      display: inline-flex;
      cursor: pointer;
    }

    .admin-avatar-upload {
      display: none;
      border: 0;
      border-radius: 6px;
      padding: 5px 8px;
      background: var(--red);
      color: #fff;
      font-size: 11px;
      font-weight: 600;
      cursor: pointer;
    }

    .admin-avatar-upload.visible {
      display: inline-block;
    }

    .admin-nav-meta {
      display: flex;
      flex-direction: column;
      min-width: 0;
    }

    .admin-nav-label {
      font-size: 10px;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: rgba(255,255,255,0.6);
      font-weight: 700;
    }

    .admin-nav-name {
      font-size: 14px;
      color: white;
      font-weight: 700;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .nav-menu { flex: 1; }
    .nav-item { margin-bottom: 6px; animation: slideInLeft 0.4s ease both; }
    .nav-item:nth-child(1) { animation-delay: 0.04s; }
    .nav-item:nth-child(2) { animation-delay: 0.08s; }
    .nav-item:nth-child(3) { animation-delay: 0.12s; }
    .nav-item:nth-child(4) { animation-delay: 0.16s; }
    .nav-item:nth-child(5) { animation-delay: 0.2s; }
    .nav-link { display: flex; align-items: center; gap: 12px; padding: 14px 16px; color: rgba(255,255,255,0.6); text-decoration: none; border-radius: 10px; transition: all 0.25s ease; position: relative; font-weight: 500; font-size: 14px; border: 1px solid transparent; }
    .nav-link:hover { background: rgba(255,255,255,0.06); color: white; transform: translateX(4px); border-color: rgba(220,38,38,0.25); }
    .nav-link.active { background: var(--red); color: white; box-shadow: var(--shadow-red); }
    .nav-link.active i { color: white; }
    .nav-link i { width: 20px; text-align: center; font-size: 16px; color: var(--red-light); transition: color 0.25s ease; }
    .badge { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: white; color: var(--red-dark); border-radius: 12px; padding: 2px 8px; font-size: 11px; font-weight: 700; }
    .nav-link.active .badge { background: var(--black); color: white; }

    .shortcut-hint { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); font-size: 10px; font-weight: 600; color: rgba(255,255,255,0.35); border: 1px solid rgba(255,255,255,0.15); border-radius: 5px; padding: 2px 6px; letter-spacing: 0.3px; }
    .nav-link.active .shortcut-hint { color: rgba(255,255,255,0.7); border-color: rgba(255,255,255,0.3); }
    .nav-item:has(.badge) .shortcut-hint { display: none; }

    .logout-section { padding-top: 24px; border-top: 1px solid rgba(255,255,255,0.08); }
    .logout-btn { width: 100%; padding: 14px; background: rgba(220,38,38,0.1); border: 1px solid rgba(220,38,38,0.35); color: var(--red-light); border-radius: 10px; font-weight: 600; cursor: pointer; transition: all 0.25s ease; display: flex; align-items: center; justify-content: center; gap: 8px; }
    .logout-btn:hover { background: var(--red); color: white; border-color: var(--red); box-shadow: var(--shadow-red); transform: translateY(-2px); }

    .main-content {
      margin-left: 280px;
      padding: 32px;
      overflow-y: auto;
      min-height: 100vh;
      height: auto;
      background: var(--off-white);
    }

    @media (max-width: 1024px) {
      .main-content {
        margin-left: 0;
      }
    }
  </style>
</head>
<body>

  <div class="dashboard-container">
    <div class="sidebar">
      <div class="brand">
        <h2><i class="fas fa-graduation-cap"></i> Admin</h2>
        <p>Intern Management System</p>
      </div>

      @php
        $adminUser = Auth::user();
        $adminInitial = strtoupper(substr(($adminUser->name ?? 'Admin'), 0, 1));
        $adminAvatar = $adminUser->avatar ?? null;
      @endphp

      <div class="admin-nav-card" aria-label="Admin profile">
        <form method="POST" action="{{ route('admin.profile.avatar') }}" enctype="multipart/form-data" class="admin-avatar-form" id="adminAvatarForm">
          @csrf
          <label for="adminAvatarUpload" class="admin-avatar-select" title="Choose profile image">
            @if($adminAvatar)
              <img
                src="{{ asset('storage/' . $adminAvatar) }}"
                alt="Admin avatar"
                class="admin-nav-avatar"
              >
            @else
              <div class="admin-nav-avatar">{{ $adminInitial }}</div>
            @endif
          </label>
          <input id="adminAvatarUpload" type="file" name="avatar" accept="image/*" hidden>
          <button type="submit" class="admin-avatar-upload" id="adminAvatarUploadButton">
            <i class="fas fa-upload" aria-hidden="true"></i> Upload Photo
          </button>
        </form>
        <div class="admin-nav-meta">
          <span class="admin-nav-label">Admin Profile</span>
          <span class="admin-nav-name">{{ $adminUser->name ?? 'Admin' }}</span>
        </div>
      </div>

      <nav class="nav-menu">
        <div class="nav-item">
          <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-th-large"></i><span>Dashboard</span>
            <span class="shortcut-hint">Ctrl+D</span>
          </a>
        </div>
        <div class="nav-item">
          <a href="{{ route('interns') }}" class="nav-link {{ request()->routeIs('interns') ? 'active' : '' }}">
            <i class="fas fa-users"></i><span>Intern List</span>
            @if(isset($pendingCount) && $pendingCount > 0)
              <span class="badge">{{ $pendingCount }}</span>
            @else
              <span class="shortcut-hint">Ctrl+I</span>
            @endif
          </a>
        </div>
        <div class="nav-item">
          <a href="{{ route('documents') }}" class="nav-link {{ request()->routeIs('documents') ? 'active' : '' }}">
            <i class="fas fa-file-alt"></i><span>Documents</span>
            <span class="shortcut-hint">Ctrl+O</span>
          </a>
        </div>
        <div class="nav-item">
          <a href="{{ route('grades') }}" class="nav-link {{ request()->routeIs('grades') ? 'active' : '' }}">
            <i class="fas fa-chart-bar"></i><span>Grades</span>
            <span class="shortcut-hint">Ctrl+G</span>
          </a>
        </div>
        <div class="nav-item">
          <a href="{{ route('messages') }}" class="nav-link {{ request()->routeIs('messages') ? 'active' : '' }}">
            <i class="fas fa-envelope"></i><span>Messages</span>
            @if(isset($unreadMessagesCount) && $unreadMessagesCount > 0)
              <span class="badge">{{ $unreadMessagesCount }}</span>
            @else
              <span class="shortcut-hint">Ctrl+M</span>
            @endif
          </a>
        </div>
          <div class="nav-item">
          <a href="{{ route('supervisors') }}" class="nav-link {{ request()->routeIs('supervisors') ? 'active' : '' }}">
            <i class="fas fa-users-cog"></i><span>Supervisor</span>
            <span class="shortcut-hint">Ctrl+U</span>
          </a>
        </div>
      </nav>

      <div class="logout-section">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i><span>Logout</span>
          </button>
        </form>
      </div>
    </div>

    <div class="main-content">
      @yield('content')
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const adminAvatarInput = document.getElementById('adminAvatarUpload');
    const adminAvatarUploadButton = document.getElementById('adminAvatarUploadButton');

    if (adminAvatarInput && adminAvatarUploadButton) {
      adminAvatarInput.addEventListener('change', function () {
        adminAvatarUploadButton.classList.toggle('visible', this.files.length > 0);
      });
    }

    const shortcutRoutes = {
      d: "{{ route('dashboard') }}",
      i: "{{ route('interns') }}",
      o: "{{ route('documents') }}",
      g: "{{ route('grades') }}",
      m: "{{ route('messages') }}",
      u: "{{ route('supervisors') }}"
    };

    document.addEventListener('keydown', function (e) {
      const key = e.key.toLowerCase();
      const target = e.target;
      const isTyping = target.tagName === 'INPUT' || target.tagName === 'TEXTAREA' || target.isContentEditable;

      if ((e.ctrlKey || e.metaKey) && !isTyping && shortcutRoutes[key]) {
        e.preventDefault();
        window.location.href = shortcutRoutes[key];
      }
    });
  </script>
  @stack('scripts')
</body>
</html>