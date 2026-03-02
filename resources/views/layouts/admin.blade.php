<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>NCC Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --sidebar-w: 260px;
            --sidebar-collapsed: 68px;
            --bg-base: #060B18;
            --bg-sidebar: #0A1628;
            --bg-card: rgba(255,255,255,0.04);
            --border: rgba(255,255,255,0.07);
            --border-bright: rgba(255,255,255,0.13);
            --accent: #3B82F6;
            --accent-glow: rgba(59,130,246,0.2);
            --text-1: #F1F5F9;
            --text-2: #94A3B8;
            --text-3: #475569;
            --green: #22C55E;
            --rose: #F43F5E;
            --amber: #F59E0B;
            --violet: #8B5CF6;
            --transition: 280ms cubic-bezier(.4,0,.2,1);
        }

        html, body {
            height: 100%;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-base);
            color: var(--text-1);
            overflow-x: hidden;
        }

        /* ─── LAYOUT ─── */
        .app-layout {
            display: flex;
            min-height: 100vh;
        }

        /* ─── SIDEBAR ─── */
        .sidebar {
            width: var(--sidebar-w);
            height: 100vh;
            position: fixed;
            top: 0; left: 0;
            background: var(--bg-sidebar);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            transition: width var(--transition);
            z-index: 300;
            overflow: hidden;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
        }

        .sidebar.collapsed:hover {
            width: var(--sidebar-w);
            box-shadow: 4px 0 40px rgba(0,0,0,0.5);
        }

        /* ── Brand ── */
        .sb-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 14px;
            height: 68px;
            border-bottom: 1px solid var(--border);
            flex-shrink: 0;
            overflow: hidden;
            white-space: nowrap;
        }

        .sb-logo {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, #3B82F6, #06B6D4);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 0 16px rgba(59,130,246,0.35);
        }
        .sb-logo svg { width: 18px; height: 18px; color: #fff; }

        .sb-brand-name {
            font-family: 'Space Grotesk', sans-serif;
            font-size: .92rem; font-weight: 700;
            color: var(--text-1); letter-spacing: -.01em;
            line-height: 1.2;
        }
        .sb-brand-sub {
            font-size: .62rem; color: var(--text-3);
            text-transform: uppercase; letter-spacing: .07em;
        }

        /* Label fade on collapse */
        .sb-brand-text,
        .nav-item-label,
        .nav-group-label,
        .sb-user-info,
        .sb-item-badge {
            opacity: 1;
            transition: opacity var(--transition);
        }

        .sidebar.collapsed:not(:hover) .sb-brand-text,
        .sidebar.collapsed:not(:hover) .nav-item-label,
        .sidebar.collapsed:not(:hover) .nav-group-label,
        .sidebar.collapsed:not(:hover) .sb-user-info,
        .sidebar.collapsed:not(:hover) .sb-item-badge {
            opacity: 0;
            pointer-events: none;
        }

        /* ── Toggle button ── */
        .sb-toggle {
            position: absolute;
            top: 18px;
            right: -13px;
            width: 26px; height: 26px;
            background: var(--bg-sidebar);
            border: 1px solid var(--border-bright);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            transition: all var(--transition);
            z-index: 10;
        }
        .sb-toggle:hover {
            background: var(--accent);
            border-color: var(--accent);
            box-shadow: 0 0 12px var(--accent-glow);
        }
        .sb-toggle svg {
            width: 12px; height: 12px; color: var(--text-2);
            transition: transform var(--transition), color var(--transition);
        }
        .sb-toggle:hover svg { color: #fff; }
        .sidebar.collapsed .sb-toggle svg { transform: rotate(180deg); }

        /* ── Nav ── */
        .sb-nav {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 12px 0;
        }
        .sb-nav::-webkit-scrollbar { width: 4px; }
        .sb-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.08); border-radius: 99px; }

        .nav-group { margin-bottom: 4px; }

        .nav-group-label {
            font-size: .62rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .1em;
            color: var(--text-3);
            padding: 10px 20px 6px;
            white-space: nowrap;
            overflow: hidden;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 12px;
            height: 44px;
            margin: 2px 8px;
            border-radius: 10px;
            text-decoration: none;
            color: var(--text-2);
            font-size: .84rem;
            font-weight: 500;
            transition: all .2s;
            position: relative;
            white-space: nowrap;
            overflow: hidden;
            cursor: pointer;
        }

        .nav-item:hover {
            background: rgba(255,255,255,0.06);
            color: var(--text-1);
        }

        .nav-item.active {
            background: rgba(59,130,246,0.15);
            color: #93C5FD;
            border: 1px solid rgba(59,130,246,0.2);
        }

        .nav-item.active .nav-icon { color: var(--accent); }

        /* Tooltip when collapsed */
        .nav-item::after {
            content: attr(data-tooltip);
            position: absolute;
            left: calc(var(--sidebar-collapsed) - 8px);
            top: 50%;
            transform: translateY(-50%);
            background: #1E293B;
            color: var(--text-1);
            font-size: .78rem;
            font-weight: 500;
            padding: 5px 10px;
            border-radius: 7px;
            border: 1px solid var(--border-bright);
            white-space: nowrap;
            pointer-events: none;
            opacity: 0;
            transition: opacity .15s;
            z-index: 400;
            box-shadow: 0 4px 16px rgba(0,0,0,0.4);
        }

        .sidebar.collapsed:not(:hover) .nav-item:hover::after {
            opacity: 1;
        }

        .nav-icon {
            width: 36px; height: 36px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 8px;
            flex-shrink: 0;
            transition: all .2s;
        }
        .nav-icon svg { width: 18px; height: 18px; }

        .nav-item:hover .nav-icon { background: rgba(255,255,255,0.08); }
        .nav-item.active .nav-icon { background: rgba(59,130,246,0.2); }

        /* Color variants */
        .nav-item.green.active  { background:rgba(34,197,94,.12); color:#86EFAC; border-color:rgba(34,197,94,.2); }
        .nav-item.green.active .nav-icon { background:rgba(34,197,94,.18); color:#22C55E; }
        .nav-item.rose.active   { background:rgba(244,63,94,.12); color:#FDA4AF; border-color:rgba(244,63,94,.2); }
        .nav-item.rose.active .nav-icon { background:rgba(244,63,94,.18); color:#F43F5E; }
        .nav-item.amber.active  { background:rgba(245,158,11,.12); color:#FCD34D; border-color:rgba(245,158,11,.2); }
        .nav-item.amber.active .nav-icon { background:rgba(245,158,11,.18); color:#F59E0B; }
        .nav-item.violet.active { background:rgba(139,92,246,.12); color:#C4B5FD; border-color:rgba(139,92,246,.2); }
        .nav-item.violet.active .nav-icon { background:rgba(139,92,246,.18); color:#8B5CF6; }

        .sb-item-badge {
            margin-left: auto;
            padding: 2px 7px;
            background: rgba(59,130,246,0.2);
            color: #93C5FD;
            border-radius: 20px;
            font-size: .66rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .sb-divider {
            height: 1px;
            background: var(--border);
            margin: 8px 16px;
        }

        /* ── User footer ── */
        .sb-user {
            border-top: 1px solid var(--border);
            padding: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
            overflow: hidden;
            white-space: nowrap;
        }

        .sb-avatar {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #3B82F6, #8B5CF6);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: .78rem; font-weight: 700; color: #fff;
            flex-shrink: 0;
            border: 1.5px solid rgba(255,255,255,0.1);
        }

        .sb-user-name { font-size: .82rem; font-weight: 600; color: var(--text-1); }
        .sb-user-role { font-size: .68rem; color: var(--text-3); margin-top: 1px; }

        .sb-logout-btn {
            margin-left: auto;
            width: 30px; height: 30px;
            background: rgba(244,63,94,0.1);
            border: 1px solid rgba(244,63,94,0.2);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            transition: all .2s;
            flex-shrink: 0;
        }
        .sb-logout-btn:hover { background: rgba(244,63,94,0.2); border-color: rgba(244,63,94,0.4); }
        .sb-logout-btn svg { width: 14px; height: 14px; color: #FDA4AF; }

        /* ─── TOPBAR (mobile) ─── */
        .topbar {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0;
            height: 60px;
            background: rgba(6,11,24,0.9);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
            z-index: 250;
            align-items: center;
            justify-content: space-between;
            padding: 0 1rem;
        }

        .hamburger {
            width: 36px; height: 36px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
        }
        .hamburger svg { width: 18px; height: 18px; color: var(--text-2); }

        /* Mobile overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.6);
            z-index: 290;
            backdrop-filter: blur(4px);
        }
        .sidebar-overlay.show { display: block; }

        /* ─── MAIN WRAPPER ─── */
        .main-wrapper {
            /* KEY FIX: use margin-left to offset the fixed sidebar,
               and width: calc(100% - sidebar-w) so content fills remaining space */
            margin-left: var(--sidebar-w);
            width: calc(100% - var(--sidebar-w));
            min-height: 100vh;
            transition: margin-left var(--transition), width var(--transition);
            display: flex;
            flex-direction: column;
        }

        .main-wrapper.collapsed {
            margin-left: var(--sidebar-collapsed);
            width: calc(100% - var(--sidebar-collapsed));
        }

        /* ─── DESKTOP TOPBAR ─── */
        .main-topbar {
            height: 68px;
            background: rgba(6,11,24,0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 100;
            /* KEY FIX: full width of its container */
            width: 100%;
        }

        .main-topbar-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .breadcrumb-sep { color: var(--text-3); font-size: .9rem; }
        .breadcrumb-page {
            font-family: 'Space Grotesk', sans-serif;
            font-size: .95rem;
            font-weight: 600;
            color: var(--text-1);
        }
        .breadcrumb-root { font-size: .85rem; color: var(--text-3); }

        .main-topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar-icon-btn {
            width: 36px; height: 36px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            transition: all .2s;
            position: relative;
        }
        .topbar-icon-btn:hover { background: rgba(255,255,255,0.08); border-color: var(--border-bright); }
        .topbar-icon-btn svg { width: 16px; height: 16px; color: var(--text-2); }

        .notif-dot {
            position: absolute;
            top: 6px; right: 6px;
            width: 7px; height: 7px;
            background: var(--accent);
            border-radius: 50%;
            border: 1.5px solid var(--bg-base);
        }

        .topbar-divider { width: 1px; height: 24px; background: var(--border); }

        .live-chip {
            display: flex; align-items: center; gap: 7px;
            padding: 5px 12px;
            background: rgba(34,197,94,0.1);
            border: 1px solid rgba(34,197,94,0.25);
            border-radius: 20px;
            font-size: .7rem; font-weight: 600;
            color: #86EFAC;
        }
        .live-ring {
            width: 7px; height: 7px;
            border-radius: 50%;
            background: #22C55E;
            animation: liveRing 2s ease infinite;
        }
        @keyframes liveRing {
            0%,100%{ opacity:1; box-shadow:0 0 5px #22C55E; }
            50%    { opacity:.4; box-shadow:0 0 12px #22C55E; }
        }

        .topbar-user {
            display: flex; align-items: center; gap: 8px;
            cursor: pointer;
        }
        .topbar-avatar {
            width: 34px; height: 34px;
            background: linear-gradient(135deg, #3B82F6, #8B5CF6);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-size: .76rem; font-weight: 700; color: #fff;
            border: 1.5px solid rgba(255,255,255,0.12);
        }
        .topbar-user-name { font-size: .8rem; font-weight: 600; color: var(--text-1); line-height:1.2; }
        .topbar-user-role { font-size: .68rem; color: var(--text-3); }

        /* ─── PAGE CONTENT ─── */
        .page-content {
            flex: 1;
            /* KEY FIX: default padding for inner pages (cadets, events, etc.) */
            padding: 2rem;
            background: var(--bg-base);
            position: relative;
            width: 100%;          /* always fill the main-wrapper */
            min-width: 0;         /* prevent flex blowout */
        }

        .page-content::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 50% at 20% -10%, rgba(59,130,246,0.1) 0%, transparent 60%),
                radial-gradient(ellipse 50% 40% at 80% 110%, rgba(139,92,246,0.08) 0%, transparent 55%);
            pointer-events: none;
            z-index: 0;
        }

        .page-content > * { position: relative; z-index: 1; }

        /* ── DASHBOARD: remove padding so .adash spans edge-to-edge ── */
        /* KEY FIX: auto-detect via route, applied server-side below */
        .page-content.no-padding {
            padding: 0 !important;
        }

        /* ─── FULL SCREEN (shows pages) ─── */
        body.full-screen .sidebar       { display: none !important; }
        body.full-screen .main-wrapper  { margin-left: 0 !important; width: 100% !important; padding-top: 0; }
        body.full-screen .main-topbar   { display: none !important; }
        body.full-screen .topbar        { display: flex !important; }
        body.full-screen .page-content  { padding: 0 !important; width: 100%; }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 768px) {
            .topbar { display: flex; }
            .main-wrapper {
                margin-left: 0 !important;
                width: 100% !important;
                padding-top: 60px;
            }
            .main-topbar { display: none; }
            .sidebar {
                transform: translateX(-100%);
                transition: transform var(--transition), width var(--transition);
                width: var(--sidebar-w) !important;
            }
            .sidebar.mobile-open { transform: translateX(0); }
            .sb-toggle { display: none; }
            /* Dashboard on mobile: let it scroll naturally */
            .page-content.no-padding {
                padding: 0 !important;
            }
        }
    </style>
</head>

{{-- KEY FIX: add 'full-screen' class only for show routes --}}
<body class="{{ request()->routeIs('shows.*') ? 'full-screen' : '' }}">

<!-- Mobile topbar -->
<div class="topbar" id="mobileTopbar">
    <div class="hamburger" onclick="toggleMobileSidebar()">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <line x1="3" y1="6" x2="21" y2="6"/>
            <line x1="3" y1="12" x2="21" y2="12"/>
            <line x1="3" y1="18" x2="21" y2="18"/>
        </svg>
    </div>
    <div style="display:flex;align-items:center;gap:10px;">
        <div class="sb-logo" style="width:32px;height:32px;">
            <svg fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7v9c0 4.5 4.5 6.5 10 7 5.5-.5 10-2.5 10-7V7L12 2z"/></svg>
        </div>
        <span style="font-family:'Space Grotesk',sans-serif;font-size:.9rem;font-weight:700;color:var(--text-1);">NCC Admin</span>
    </div>
    <div class="topbar-avatar" style="width:32px;height:32px;">
        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
    </div>
</div>

<!-- Mobile overlay -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleMobileSidebar()"></div>

<div class="app-layout">

    <!-- ─── SIDEBAR ─── -->
    <aside class="sidebar" id="sidebar">

        <button class="sb-toggle" id="sidebarToggle" onclick="toggleSidebar()" title="Toggle sidebar">
            <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
        </button>

        <div class="sb-brand">
            <div class="sb-logo">
                <svg fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7v9c0 4.5 4.5 6.5 10 7 5.5-.5 10-2.5 10-7V7L12 2z"/></svg>
            </div>
            <div class="sb-brand-text">
                <div class="sb-brand-name">NCC Admin</div>
                <div class="sb-brand-sub">National Cadet Corps</div>
            </div>
        </div>

        <nav class="sb-nav">

            <div class="nav-group">
                <div class="nav-group-label">Main</div>
                <a href="{{ route('admin.dashboard') }}"
                   data-tooltip="Dashboard"
                   class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="7" height="7" rx="1"/>
                            <rect x="14" y="3" width="7" height="7" rx="1"/>
                            <rect x="3" y="14" width="7" height="7" rx="1"/>
                            <rect x="14" y="14" width="7" height="7" rx="1"/>
                        </svg>
                    </span>
                    <span class="nav-item-label">Dashboard</span>
                </a>
            </div>

            <div class="nav-group">
                <div class="nav-group-label">Management</div>

                <a href="{{ route('cadets.index') }}"
                   data-tooltip="Cadets"
                   class="nav-item green {{ request()->routeIs('cadets.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </span>
                    <span class="nav-item-label">Cadets</span>
                </a>

                <a href="{{ route('units.index') }}"
                   data-tooltip="Units"
                   class="nav-item violet {{ request()->routeIs('units.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                            <polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                    </span>
                    <span class="nav-item-label">Units</span>
                </a>

                <a href="{{ route('events.index') }}"
                   data-tooltip="Events"
                   class="nav-item amber {{ request()->routeIs('events.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                    </span>
                    <span class="nav-item-label">Events</span>
                    <span class="sb-item-badge nav-item-label">3</span>
                </a>

                <a href="{{ route('attendance.index') }}"
                   data-tooltip="Attendance"
                   class="nav-item rose {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="9 11 12 14 22 4"/>
                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                        </svg>
                    </span>
                    <span class="nav-item-label">Attendance</span>
                </a>
            </div>

            <div class="nav-group">
                <div class="nav-group-label">System</div>
                <a href="{{ route('profile.edit') ?? '#' }}"
                   data-tooltip="Settings"
                   class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="3"/>
                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                        </svg>
                    </span>
                    <span class="nav-item-label">Settings</span>
                </a>
            </div>

        </nav>

        <div class="sb-user">
            <div class="sb-avatar">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>
            <div class="sb-user-info">
                <div class="sb-user-name">{{ auth()->user()->name ?? 'Admin' }}</div>
                <div class="sb-user-role">Administrator</div>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="margin-left:auto;flex-shrink:0;">
                @csrf
                <button type="submit" class="sb-logout-btn" title="Logout">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                </button>
            </form>
        </div>

    </aside>

    <!-- ─── MAIN WRAPPER ─── -->
    <div class="main-wrapper" id="mainWrapper">

        <header class="main-topbar">
            <div class="main-topbar-left">
                <span class="breadcrumb-root">NCC</span>
                <span class="breadcrumb-sep">/</span>
                <span class="breadcrumb-page" id="currentPage">Dashboard</span>
            </div>
            <div class="main-topbar-right">
                <div class="live-chip">
                    <span class="live-ring"></span>
                    Live
                </div>
                <div class="topbar-divider"></div>
                <div class="topbar-icon-btn" title="Notifications">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                    <span class="notif-dot"></span>
                </div>
                <div class="topbar-icon-btn" title="Search">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                </div>
                <div class="topbar-divider"></div>
                <div class="topbar-user">
                    <div class="topbar-avatar">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="topbar-user-info">
                        <div class="topbar-user-name">{{ auth()->user()->name ?? 'Admin' }}</div>
                        <div class="topbar-user-role">Administrator</div>
                    </div>
                </div>
            </div>
        </header>

        {{--
            KEY FIX: Add 'no-padding' class ONLY on the dashboard route.
            This removes the 2rem padding so .adash fills edge-to-edge.
            All other pages keep their normal 2rem padding.
        --}}
        <div class="page-content {{ request()->routeIs('admin.dashboard') ? 'no-padding' : '' }}">
            @yield('content')
        </div>

    </div><!-- /main-wrapper -->

</div><!-- /app-layout -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // ── Sidebar collapse (desktop) ──
    const sidebar     = document.getElementById('sidebar');
    const mainWrapper = document.getElementById('mainWrapper');
    let isCollapsed   = false;

    function toggleSidebar() {
        isCollapsed = !isCollapsed;
        sidebar.classList.toggle('collapsed', isCollapsed);
        mainWrapper.classList.toggle('collapsed', isCollapsed);
        localStorage.setItem('sidebarCollapsed', isCollapsed);
    }

    // Restore on load
    if (localStorage.getItem('sidebarCollapsed') === 'true') {
        isCollapsed = true;
        sidebar.classList.add('collapsed');
        mainWrapper.classList.add('collapsed');
    }

    // ── Mobile sidebar ──
    function toggleMobileSidebar() {
        sidebar.classList.toggle('mobile-open');
        document.getElementById('sidebarOverlay').classList.toggle('show');
    }

    // ── Breadcrumb: reflect active nav item ──
    const activeLabel = document.querySelector('.nav-item.active .nav-item-label');
    if (activeLabel) {
        document.getElementById('currentPage').textContent = activeLabel.textContent.trim();
    }
</script>

</body>
</html>