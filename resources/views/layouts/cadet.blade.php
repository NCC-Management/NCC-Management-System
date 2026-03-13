<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NCC Cadet Portal – @yield('title', 'Dashboard')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
    /* ── Reset & Base ── */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
        --c-bg:      #060C1A;
        --c-surf:    #0D1627;
        --c-card:    rgba(255,255,255,0.038);
        --c-cardhov: rgba(255,255,255,0.065);
        --c-border:  rgba(255,255,255,0.07);
        --c-bordehi: rgba(255,255,255,0.13);
        --c-blue:    #3B82F6;
        --c-green:   #22C55E;
        --c-rose:    #F43F5E;
        --c-amber:   #F59E0B;
        --c-violet:  #8B5CF6;
        --c-cyan:    #06B6D4;
        --t1: #F1F5F9;
        --t2: #94A3B8;
        --t3: #475569;
        --radius: 14px;
        --sidebar-w: 256px;
        --topbar-h: 64px;
    }

    html, body { height: 100%; }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: var(--c-bg);
        color: var(--t1);
        display: flex;
        min-height: 100vh;
        overflow-x: hidden;
    }

    /* ── SIDEBAR ── */
    .csb {
        width: var(--sidebar-w);
        min-height: 100vh;
        background: var(--c-surf);
        border-right: 1px solid var(--c-border);
        display: flex;
        flex-direction: column;
        position: fixed;
        top: 0; left: 0; bottom: 0;
        z-index: 200;
        transition: transform .3s ease;
    }

    .csb-brand {
        padding: 1.35rem 1.4rem;
        border-bottom: 1px solid var(--c-border);
        display: flex;
        align-items: center;
        gap: .75rem;
        flex-shrink: 0;
    }

    .csb-brand-logo {
        width: 38px; height: 38px; border-radius: 10px;
        background: linear-gradient(135deg, #3B82F6, #1D4ED8);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(59,130,246,0.4);
    }

    .csb-brand-logo svg { width: 20px; height: 20px; color: #fff; }

    .csb-brand-text { line-height: 1.2; }
    .csb-brand-name {
        font-family: 'Space Grotesk', sans-serif;
        font-size: .875rem; font-weight: 700; color: var(--t1);
        letter-spacing: -.02em;
    }
    .csb-brand-sub { font-size: .65rem; color: var(--t3); }

    /* Cadet info strip */
    .csb-cadet {
        padding: 1rem 1.4rem;
        border-bottom: 1px solid var(--c-border);
        display: flex;
        align-items: center;
        gap: .75rem;
        flex-shrink: 0;
    }

    .csb-av {
        width: 36px; height: 36px; border-radius: 9px;
        background: linear-gradient(135deg, #6366F1, #8B5CF6);
        display: flex; align-items: center; justify-content: center;
        font-size: .8rem; font-weight: 700; color: #fff; flex-shrink: 0;
    }

    .csb-cadet-name { font-size: .8rem; font-weight: 600; color: var(--t1); }
    .csb-cadet-enroll { font-size: .65rem; color: var(--t3); margin-top: 1px; }

    /* Navigation */
    .csb-nav {
        flex: 1;
        overflow-y: auto;
        padding: .75rem .75rem;
    }

    .csb-nav::-webkit-scrollbar { width: 3px; }
    .csb-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,.08); border-radius: 99px; }

    .csb-section-label {
        font-size: .57rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .12em; color: var(--t3);
        padding: .5rem .6rem .35rem;
    }

    .csb-link {
        display: flex; align-items: center; gap: .7rem;
        padding: .53rem .75rem;
        border-radius: 9px;
        font-size: .79rem; font-weight: 500; color: var(--t2);
        text-decoration: none;
        transition: all .18s;
        position: relative;
        margin-bottom: 2px;
    }

    .csb-link:hover {
        background: var(--c-card);
        color: var(--t1);
    }

    .csb-link.active {
        background: rgba(59,130,246,.12);
        color: #93C5FD;
        border: 1px solid rgba(59,130,246,.15);
    }

    .csb-link svg { width: 16px; height: 16px; flex-shrink: 0; opacity: .75; }
    .csb-link.active svg { opacity: 1; }

    .csb-badge {
        margin-left: auto;
        background: rgba(244,63,94,.18);
        border: 1px solid rgba(244,63,94,.25);
        color: #FDA4AF;
        font-size: .58rem; font-weight: 700; padding: 1px 7px;
        border-radius: 20px;
    }

    .csb-divider {
        height: 1px; background: var(--c-border); margin: .5rem .6rem;
    }

    /* Logout at bottom */
    .csb-footer {
        padding: .75rem;
        border-top: 1px solid var(--c-border);
        flex-shrink: 0;
    }

    .csb-logout {
        display: flex; align-items: center; gap: .7rem;
        padding: .53rem .75rem;
        border-radius: 9px;
        font-size: .79rem; font-weight: 500; color: var(--t3);
        cursor: pointer; transition: all .18s;
        border: none; background: transparent; width: 100%; text-align: left;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .csb-logout:hover { background: rgba(244,63,94,.08); color: #FDA4AF; }
    .csb-logout svg { width: 16px; height: 16px; flex-shrink: 0; }

    /* ── MAIN AREA ── */
    .cmain {
        margin-left: var(--sidebar-w);
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    /* ── TOPBAR ── */
    .ctop {
        height: var(--topbar-h);
        background: var(--c-surf);
        border-bottom: 1px solid var(--c-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 1.75rem;
        position: sticky; top: 0; z-index: 100;
    }

    .ctop-left { display: flex; align-items: center; gap: .75rem; }

    .csb-toggle {
        display: none; /* shown on mobile */
        width: 34px; height: 34px; border-radius: 8px;
        background: var(--c-card); border: 1px solid var(--c-border);
        align-items: center; justify-content: center;
        cursor: pointer;
    }

    .ctop-page-title {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 1rem; font-weight: 600; color: var(--t1);
        letter-spacing: -.02em;
    }

    .ctop-right { display: flex; align-items: center; gap: .6rem; }

    .ctop-icon-btn {
        width: 36px; height: 36px; border-radius: 9px;
        background: var(--c-card); border: 1px solid var(--c-border);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: all .18s; text-decoration: none;
        color: var(--t2); position: relative;
    }

    .ctop-icon-btn:hover { background: var(--c-cardhov); color: var(--t1); border-color: var(--c-bordehi); }
    .ctop-icon-btn svg { width: 16px; height: 16px; }

    .notif-dot {
        position: absolute; top: 6px; right: 6px;
        width: 7px; height: 7px; border-radius: 50%;
        background: #F43F5E;
        border: 2px solid var(--c-surf);
    }

    .ctop-av {
        width: 34px; height: 34px; border-radius: 9px;
        background: linear-gradient(135deg, #6366F1, #8B5CF6);
        display: flex; align-items: center; justify-content: center;
        font-size: .73rem; font-weight: 700; color: #fff;
        cursor: pointer;
    }

    /* ── PAGE CONTENT ── */
    .cpage {
        flex: 1;
        padding: 1.75rem 2rem 4rem;
    }

    /* ── STATUS PILLS ── */
    .spill {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 10px; border-radius: 20px;
        font-size: .67rem; font-weight: 600;
    }
    .spill-dot { width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
    .spill.pending  { background: rgba(245,158,11,.1); border: 1px solid rgba(245,158,11,.22); color: #FCD34D; }
    .spill.pending .spill-dot { background: #F59E0B; }
    .spill.approved { background: rgba(34,197,94,.1);  border: 1px solid rgba(34,197,94,.22);  color: #86EFAC; }
    .spill.approved .spill-dot { background: #22C55E; }
    .spill.rejected { background: rgba(244,63,94,.1);  border: 1px solid rgba(244,63,94,.22);  color: #FDA4AF; }
    .spill.rejected .spill-dot { background: #F43F5E; }

    /* ── FLASH MESSAGES ── */
    .flash {
        padding: .75rem 1.1rem;
        border-radius: 10px;
        font-size: .82rem; font-weight: 500;
        display: flex; align-items: center; gap: .6rem;
        margin-bottom: 1.25rem;
    }
    .flash-success { background: rgba(34,197,94,.08); border: 1px solid rgba(34,197,94,.2); color: #86EFAC; }
    .flash-error   { background: rgba(244,63,94,.08); border: 1px solid rgba(244,63,94,.2); color: #FDA4AF; }
    .flash-info    { background: rgba(59,130,246,.08); border: 1px solid rgba(59,130,246,.2); color: #93C5FD; }
    .flash svg { width: 16px; height: 16px; flex-shrink: 0; }

    /* ── AMBIENT GLOW ── */
    body::before {
        content: '';
        position: fixed; inset: 0; pointer-events: none; z-index: 0;
        background:
            radial-gradient(ellipse 90% 55% at 10% -5%,  rgba(59,130,246,0.07) 0%, transparent 55%),
            radial-gradient(ellipse 60% 45% at 90% 105%, rgba(139,92,246,0.06) 0%, transparent 55%);
    }
    .cmain { position: relative; z-index: 1; }

    /* ── RESPONSIVE ── */
    @media(max-width: 900px) {
        .csb { transform: translateX(-100%); }
        .csb.open { transform: translateX(0); }
        .cmain { margin-left: 0; }
        .csb-toggle { display: flex; }
        .cpage { padding: 1.25rem 1.1rem 4rem; }
    }
    </style>

    @stack('styles')
</head>
<body>

{{-- ── SIDEBAR ── --}}
<aside class="csb" id="sidebar">
    {{-- Brand --}}
    <div class="csb-brand">
        <div class="csb-brand-logo">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 2L2 7v9c0 5 10 6 10 6s10-1 10-6V7L12 2z"/>
            </svg>
        </div>
        <div class="csb-brand-text">
            <div class="csb-brand-name">NCC Portal</div>
            <div class="csb-brand-sub">Cadet Dashboard</div>
        </div>
    </div>

    {{-- Cadet Info --}}
    @php $cadetUser = auth()->user(); $cadetRec = $cadetUser->cadet; @endphp
    <div class="csb-cadet">
        <div class="csb-av">{{ $cadetUser->initials() }}</div>
        <div>
            <div class="csb-cadet-name">{{ $cadetUser->name }}</div>
            <div class="csb-cadet-enroll">{{ $cadetRec->enrollment_no ?? '—' }}</div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="csb-nav">
        @php $seg = request()->segment(2); @endphp

        <div class="csb-section-label">Main</div>

        <a href="{{ route('cadet.dashboard') }}" class="csb-link {{ $seg === 'dashboard' ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                <rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/>
            </svg>
            Dashboard
        </a>

        @if($cadetRec && $cadetRec->isApproved())
        <div class="csb-section-label" style="margin-top:.5rem;">My Info</div>

        <a href="{{ route('cadet.profile') }}" class="csb-link {{ $seg === 'profile' ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </svg>
            My Profile
        </a>

        <a href="{{ route('cadet.attendance') }}" class="csb-link {{ $seg === 'attendance' ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
            </svg>
            My Attendance
        </a>

        <a href="{{ route('cadet.events') }}" class="csb-link {{ $seg === 'events' ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            My Events
        </a>

        <a href="{{ route('cadet.unit') }}" class="csb-link {{ $seg === 'unit' ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            My Unit
        </a>

        <div class="csb-section-label" style="margin-top:.5rem;">Training</div>

        <a href="{{ route('cadet.training') }}" class="csb-link {{ $seg === 'training' ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                <polyline points="17 6 23 6 23 12"/>
            </svg>
            Training & Performance
        </a>

        <a href="{{ route('cadet.certificates') }}" class="csb-link {{ $seg === 'certificates' ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
            </svg>
            Certificates & Awards
        </a>

        <div class="csb-section-label" style="margin-top:.5rem;">Services</div>

        <a href="{{ route('cadet.leave') }}" class="csb-link {{ $seg === 'leave' ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
            </svg>
            Leave Requests
        </a>

        <a href="{{ route('cadet.notifications') }}" class="csb-link {{ $seg === 'notifications' ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
            </svg>
            Notifications
            @php
                $unread = \App\Models\CadetNotification::where(function($q) use($cadetRec){
                    $q->where('cadet_id', $cadetRec->id)->orWhereNull('cadet_id');
                })->where('is_read', false)->count();
            @endphp
            @if($unread > 0)
                <span class="csb-badge">{{ $unread }}</span>
            @endif
        </a>
        @endif
    </nav>

    {{-- Logout --}}
    <div class="csb-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="csb-logout">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <polyline points="16 17 21 12 16 7"/>
                    <line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
                Logout
            </button>
        </form>
    </div>
</aside>

{{-- Sidebar overlay for mobile --}}
<div id="sbOverlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:199;" onclick="toggleSidebar()"></div>

{{-- ── MAIN ── --}}
<div class="cmain">

    {{-- TOP BAR --}}
    <div class="ctop">
        <div class="ctop-left">
            <button class="csb-toggle" onclick="toggleSidebar()" style="background:var(--c-card);border:1px solid var(--c-border);cursor:pointer;">
                <svg width="18" height="18" fill="none" stroke="var(--t2)" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
            </button>
            <div class="ctop-page-title">@yield('page-title', 'Dashboard')</div>
        </div>
        <div class="ctop-right">
            <a href="{{ route('home') }}" class="ctop-icon-btn" title="Go to Home" style="padding: 0 12px; width: auto; font-size: 0.75rem; font-weight: 600; gap: 6px;">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Home
            </a>
            @if($cadetRec && $cadetRec->isApproved())
            <a href="{{ route('cadet.notifications') }}" class="ctop-icon-btn" title="Notifications">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                </svg>
                @if(isset($unread) && $unread > 0)
                <span class="notif-dot"></span>
                @endif
            </a>
            @endif
            <div class="ctop-av" title="{{ $cadetUser->name }}">{{ $cadetUser->initials() }}</div>
        </div>
    </div>

    {{-- PAGE CONTENT --}}
    <div class="cpage">

        @if(session('success'))
        <div class="flash flash-success">
            <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="flash flash-error">
            <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            {{ session('error') }}
        </div>
        @endif

        @if(session('info'))
        <div class="flash flash-info">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('info') }}
        </div>
        @endif

        @yield('content')
    </div>
</div>

<script>
function toggleSidebar() {
    const sb = document.getElementById('sidebar');
    const ov = document.getElementById('sbOverlay');
    const open = sb.classList.toggle('open');
    ov.style.display = open ? 'block' : 'none';
}
</script>

@stack('scripts')
</body>
</html>