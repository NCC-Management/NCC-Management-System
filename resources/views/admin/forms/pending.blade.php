@extends('layouts.admin')

@section('content')

<style>
.fp *, .fp *::before, .fp *::after { box-sizing: border-box; }

.fp {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: var(--bg);
    min-height: 100vh;
    color: var(--tx1);
    padding: 1.8rem 2rem 5rem;
    position: relative;
    overflow-x: hidden;
    transition: background var(--dur) var(--ease), color var(--dur) var(--ease);
}

.fp::before {
    content: '';
    position: fixed; inset: 0; pointer-events: none; z-index: 0;
}
[data-theme="dark"]  .fp::before {
    background:
        radial-gradient(ellipse 80% 50% at 15% -5%,  rgba(245,158,11,0.07) 0%, transparent 55%),
        radial-gradient(ellipse 55% 45% at 85% 105%, rgba(245,158,11,0.07) 0%, transparent 55%);
}
[data-theme="light"] .fp::before { background: none; }

.fp > * { position: relative; z-index: 1; }

.pg-bar {
    display: flex; align-items: flex-start; justify-content: space-between;
    flex-wrap: wrap; gap: .75rem; margin-bottom: 1.8rem;
}
.pg-title {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 1.55rem; font-weight: 700;
    color: var(--tx1); letter-spacing: -.03em; line-height: 1.2;
    transition: color var(--dur);
}
.pg-sub {
    font-size: .79rem; color: var(--tx2); margin-top: 3px;
    transition: color var(--dur);
}

.btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 16px; border-radius: 10px;
    font-size: .8rem; font-weight: 600; cursor: pointer;
    transition: all .2s; font-family: 'Plus Jakarta Sans', sans-serif;
    text-decoration: none; border: none; white-space: nowrap;
}

.alert-success {
    display: flex; align-items: center; gap: 10px;
    padding: .85rem 1.2rem;
    background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.25);
    border-radius: 10px; font-size: .82rem;
    margin-bottom: 1.5rem; animation: fadeUp .4s ease both;
}
[data-theme="dark"]  .alert-success { color: #86EFAC; }
[data-theme="light"] .alert-success { color: #15803D; background: rgba(21,128,61,.08); border-color: rgba(21,128,61,.22); }
.alert-success svg { width: 16px; height: 16px; flex-shrink: 0; }

.ev-stats {
    display: grid; grid-template-columns: repeat(3,1fr);
    gap: 1rem; margin-bottom: 1.8rem;
    animation: fadeUp .4s ease .05s both;
}

.ev-stat {
    background: var(--bg-card);
    border: 1px solid var(--bdr);
    border-radius: 14px; padding: 1.1rem 1.3rem;
    display: flex; align-items: center; gap: .9rem;
    transition: background .2s, border-color .2s, box-shadow .2s;
    position: relative; overflow: hidden;
}
.ev-stat::before {
    content: ''; position: absolute; top: 0; left: 14%; right: 14%; height: 1px;
}

[data-theme="dark"] .ev-stat.s-amber::before { background: linear-gradient(90deg,transparent,#F59E0B,transparent); box-shadow: 0 0 8px rgba(245,158,11,.5); }
[data-theme="light"] .ev-stat.s-amber::before { background: var(--amber); height: 2px; box-shadow: none; opacity: .6; }

.ev-stat:hover { background: var(--bg-card-hov); border-color: var(--bdr-hi); box-shadow: var(--shadow); }

.ev-stat-ico {
    width: 40px; height: 40px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    transition: background .2s, color .2s;
}
.ev-stat-ico svg { width: 18px; height: 18px; }

[data-theme="dark"] .s-amber .ev-stat-ico { background: rgba(245,158,11,.15); color: #FCD34D; }
[data-theme="light"] .s-amber .ev-stat-ico { background: rgba(180,83,9,.1);   color: var(--amber);  }

.ev-stat-val {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 1.6rem; font-weight: 700; letter-spacing: -.03em; line-height: 1;
    transition: color var(--dur);
}
[data-theme="dark"] .s-amber  .ev-stat-val { color: #FDE68A; }
[data-theme="light"] .s-amber  .ev-stat-val { color: #78350f; }

.ev-stat-lbl {
    font-size: .72rem; color: var(--tx2); margin-top: 3px;
    transition: color var(--dur);
}

.tbl-controls {
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: .6rem; margin-bottom: 1rem;
}
.tbl-search {
    display: flex; align-items: center; gap: 8px;
    background: var(--bg-card); border: 1px solid var(--bdr);
    border-radius: 9px; padding: 7px 13px;
    transition: border-color .2s, background .2s;
}
.tbl-search:focus-within { border-color: var(--amber); box-shadow: 0 0 0 3px rgba(245,158,11,.15); }
.tbl-search input {
    background: transparent; border: none; outline: none;
    font-size: .79rem; color: var(--tx1);
    font-family: 'Plus Jakarta Sans', sans-serif; width: 200px;
    transition: color var(--dur);
}
.tbl-search input::placeholder { color: var(--tx3); }
.tbl-search svg { width: 14px; height: 14px; color: var(--tx3); flex-shrink: 0; }

.tbl-count { font-size: .74rem; color: var(--tx3); transition: color var(--dur); }

.tbl-panel {
    background: var(--bg-card); border: 1px solid var(--bdr);
    border-radius: 14px; overflow: hidden;
    animation: fadeUp .4s ease .1s both;
    transition: background var(--dur), border-color var(--dur), box-shadow var(--dur);
    box-shadow: var(--shadow);
}

.tbl-hd {
    padding: 1rem 1.4rem; border-bottom: 1px solid var(--bdr);
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: .5rem;
    transition: border-color var(--dur);
}
.tbl-ttl {
    font-family: 'Space Grotesk', sans-serif;
    font-size: .9rem; font-weight: 600; color: var(--tx1);
    transition: color var(--dur);
}
.tbl-badge {
    padding: 3px 9px; border-radius: 20px;
    font-size: .66rem; font-weight: 700; letter-spacing: .07em; text-transform: uppercase;
    transition: all var(--dur);
}
[data-theme="dark"]  .tbl-badge { background: rgba(245,158,11,.12); border: 1px solid rgba(245,158,11,.25); color: #FCD34D; }
[data-theme="light"] .tbl-badge { background: rgba(180,83,9,.08); border: 1px solid rgba(180,83,9,.25); color: var(--amber); }

.empty-state { text-align: center; padding: 4rem 2rem; }
.empty-state svg { width: 52px; height: 52px; margin: 0 auto 1rem; display: block; opacity: .3; color: var(--tx3); }
.empty-state p   { font-size: .9rem; margin-bottom: .4rem; color: var(--tx2); }
.empty-state span { font-size: .78rem; color: var(--tx3); }

[data-theme="dark"]  .fp ::-webkit-scrollbar-thumb { background: rgba(255,255,255,.09); }
[data-theme="light"] .fp ::-webkit-scrollbar-thumb { background: rgba(15,30,60,.15); }
::-webkit-scrollbar { width: 4px; height: 4px; }
::-webkit-scrollbar-track { background: transparent; }

@keyframes fadeUp {
    from { opacity:0; transform:translateY(14px); }
    to   { opacity:1; transform:translateY(0); }
}

@media(max-width:900px) {
    .fp { padding: 1.2rem 1.1rem 4rem; }
    .ev-stats { grid-template-columns: 1fr 1fr; }
    .tbl-search input { width: 140px; }
}
@media(max-width:600px) {
    .ev-stats { grid-template-columns: 1fr; }
    .pg-title { font-size: 1.3rem; }
}
</style>

@php
    $count = 0;
@endphp

<div class="fp">

    {{-- ── PAGE BAR ── --}}
    <div class="pg-bar">
        <div>
            <div class="pg-title">Pending Forms</div>
            <div class="pg-sub">Review and process pending form submissions</div>
        </div>
        <a href="{{ route('admin.forms.index') }}" class="btn" style="padding:8px 16px;background:transparent;border:1px solid var(--bdr);color:var(--tx2);font-size:0.8rem;text-decoration:none;">
            Back to All Forms
        </a>
    </div>

    {{-- ── SUCCESS ALERT ── --}}
    @if(session('success'))
    <div class="alert-success">
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <polyline points="20 6 9 17 4 12"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- ── STATS ── --}}
    <div class="ev-stats">
        <div class="ev-stat s-amber">
            <div class="ev-stat-ico">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
            <div>
                <div class="ev-stat-val">{{ $count }}</div>
                <div class="ev-stat-lbl">Awaiting Review</div>
            </div>
        </div>
        <div class="ev-stat s-amber" style="opacity: 0.5;">
            <div class="ev-stat-ico">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 8v8m-4-4h8"/>
                </svg>
            </div>
            <div>
                <div class="ev-stat-val">—</div>
                <div class="ev-stat-lbl">Average Time</div>
            </div>
        </div>
        <div class="ev-stat s-amber" style="opacity: 0.5;">
            <div class="ev-stat-ico">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 12h6m-6 4h6m2-8H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2z"/>
                </svg>
            </div>
            <div>
                <div class="ev-stat-val">—</div>
                <div class="ev-stat-lbl">Oldest Pending</div>
            </div>
        </div>
    </div>

    {{-- ── SEARCH BAR ── --}}
    <div class="tbl-controls">
        <div class="tbl-search">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/>
                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="text" id="evSearch" placeholder="Search pending forms…">
        </div>
        <span class="tbl-count" id="evCount">{{ $count }} form{{ $count !== 1 ? 's' : '' }}</span>
    </div>

    {{-- ── TABLE PANEL ── --}}
    <div class="tbl-panel">
        <div class="tbl-hd">
            <div class="tbl-ttl">Pending Forms</div>
            <span class="tbl-badge">{{ $count }} Total</span>
        </div>

        @if($count == 0)
        <div class="empty-state">
            <svg fill="none" stroke="currentColor" stroke-width="1.3" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="12 6 12 12 16 14"/>
            </svg>
            <p>No pending forms</p>
            <span>All forms have been reviewed</span>
        </div>
        @endif
    </div>

</div>

@endsection
