@extends('layouts.admin')

@section('content')

<style>
/* ════════════════════════════════════════════
   FORMS PAGE — inherits ALL tokens from
   the layout's [data-theme] variables.
   NO hardcoded colours here.
════════════════════════════════════════════ */
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

/* Ambient glow — subtle in dark, near-invisible in light */
.fp::before {
    content: '';
    position: fixed; inset: 0; pointer-events: none; z-index: 0;
}
[data-theme="dark"]  .fp::before {
    background:
        radial-gradient(ellipse 80% 50% at 15% -5%,  rgba(12,201,232,0.07) 0%, transparent 55%),
        radial-gradient(ellipse 55% 45% at 85% 105%, rgba(12,201,232,0.07) 0%, transparent 55%);
}
[data-theme="light"] .fp::before { background: none; }

.fp > * { position: relative; z-index: 1; }

/* ── PAGE BAR ── */
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
.btn-green {
    background: linear-gradient(135deg, #16A34A, #22C55E);
    border: 1px solid rgba(34,197,94,0.35);
    color: #fff !important;
    box-shadow: 0 4px 16px rgba(34,197,94,0.22);
}
.btn-green:hover { box-shadow: 0 6px 22px rgba(34,197,94,0.35); transform: translateY(-1px); }

/* ── ALERT ── */
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

/* ── STATS ROW ── */
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

/* Dark mode glows */
[data-theme="dark"] .ev-stat.s-amber::before { background: linear-gradient(90deg,transparent,#F59E0B,transparent); box-shadow: 0 0 8px rgba(245,158,11,.5); }
[data-theme="dark"] .ev-stat.s-blue::before  { background: linear-gradient(90deg,transparent,#3B82F6,transparent); box-shadow: 0 0 8px rgba(59,130,246,.5); }
[data-theme="dark"] .ev-stat.s-cyan::before  { background: linear-gradient(90deg,transparent,#0CC9E8,transparent); box-shadow: 0 0 8px rgba(12,201,232,.5); }
[data-theme="dark"] .ev-stat.s-green::before { background: linear-gradient(90deg,transparent,#1FD57A,transparent); box-shadow: 0 0 8px rgba(31,213,122,.5); }
[data-theme="dark"] .ev-stat.s-violet::before{ background: linear-gradient(90deg,transparent,#8B5CF6,transparent); box-shadow: 0 0 8px rgba(139,92,246,.5); }

/* Light mode top lines — solid, visible */
[data-theme="light"] .ev-stat.s-amber::before { background: var(--amber); height: 2px; box-shadow: none; opacity: .6; }
[data-theme="light"] .ev-stat.s-blue::before  { background: var(--blue);  height: 2px; box-shadow: none; opacity: .6; }
[data-theme="light"] .ev-stat.s-cyan::before  { background: var(--cyan);  height: 2px; box-shadow: none; opacity: .6; }
[data-theme="light"] .ev-stat.s-green::before { background: var(--green); height: 2px; box-shadow: none; opacity: .6; }
[data-theme="light"] .ev-stat.s-violet::before{ background: var(--violet);height: 2px; box-shadow: none; opacity: .6; }

.ev-stat:hover { background: var(--bg-card-hov); border-color: var(--bdr-hi); box-shadow: var(--shadow); }

/* Stat icons */
.ev-stat-ico {
    width: 40px; height: 40px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    transition: background .2s, color .2s;
}
.ev-stat-ico svg { width: 18px; height: 18px; }

[data-theme="dark"] .s-amber .ev-stat-ico { background: rgba(245,158,11,.15); color: #FCD34D; }
[data-theme="dark"] .s-blue  .ev-stat-ico { background: rgba(59,130,246,.15);  color: #93C5FD; }
[data-theme="dark"] .s-cyan  .ev-stat-ico { background: rgba(12,201,232,.15);  color: #22D3EE; }
[data-theme="dark"] .s-green .ev-stat-ico { background: rgba(31,213,122,.15); color: #86EFAC; }
[data-theme="dark"] .s-violet .ev-stat-ico { background: rgba(139,92,246,.15); color: #C4B5FD; }

[data-theme="light"] .s-amber .ev-stat-ico { background: rgba(180,83,9,.1);   color: var(--amber);  }
[data-theme="light"] .s-blue  .ev-stat-ico { background: rgba(29,78,216,.1);  color: var(--blue);   }
[data-theme="light"] .s-cyan  .ev-stat-ico { background: rgba(6,182,212,.1);  color: var(--cyan);   }
[data-theme="light"] .s-green .ev-stat-ico { background: rgba(34,197,94,.1);  color: var(--green);  }
[data-theme="light"] .s-violet .ev-stat-ico { background: rgba(109,40,217,.1); color: var(--violet); }

/* Stat values */
.ev-stat-val {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 1.6rem; font-weight: 700; letter-spacing: -.03em; line-height: 1;
    transition: color var(--dur);
}
[data-theme="dark"] .s-amber  .ev-stat-val { color: #FDE68A; }
[data-theme="dark"] .s-blue   .ev-stat-val { color: #BFDBFE; }
[data-theme="dark"] .s-cyan   .ev-stat-val { color: #06B6D4; }
[data-theme="dark"] .s-green  .ev-stat-val { color: #4ADE80; }
[data-theme="dark"] .s-violet .ev-stat-val { color: #DDD6FE; }

[data-theme="light"] .s-amber  .ev-stat-val { color: #78350f; }
[data-theme="light"] .s-blue   .ev-stat-val { color: #1e3a8a; }
[data-theme="light"] .s-cyan   .ev-stat-val { color: #0e7490; }
[data-theme="light"] .s-green  .ev-stat-val { color: #15803d; }
[data-theme="light"] .s-violet .ev-stat-val { color: #4c1d95; }

.ev-stat-lbl {
    font-size: .72rem; color: var(--tx2); margin-top: 3px;
    transition: color var(--dur);
}

/* ── SEARCH / FILTER BAR ── */
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
.tbl-search:focus-within { border-color: var(--blue); box-shadow: 0 0 0 3px var(--blue-dim); }
.tbl-search input {
    background: transparent; border: none; outline: none;
    font-size: .79rem; color: var(--tx1);
    font-family: 'Plus Jakarta Sans', sans-serif; width: 200px;
    transition: color var(--dur);
}
.tbl-search input::placeholder { color: var(--tx3); }
.tbl-search svg { width: 14px; height: 14px; color: var(--tx3); flex-shrink: 0; }

.tbl-count { font-size: .74rem; color: var(--tx3); transition: color var(--dur); }

/* ── TABLE PANEL ── */
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
[data-theme="light"] .tbl-badge { background: var(--amber-dim); border: 1px solid rgba(180,83,9,.25); color: var(--amber); }

/* ── Table ── */
.ev-table { width: 100%; border-collapse: collapse; }

.ev-table thead tr { border-bottom: 1px solid var(--bdr); transition: border-color var(--dur); }
.ev-table thead th {
    padding: .7rem 1.4rem; font-size: .64rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .09em; color: var(--tx3);
    text-align: left; white-space: nowrap; transition: color var(--dur);
}

.ev-table tbody tr {
    border-bottom: 1px solid var(--bdr);
    transition: background .18s;
    animation: fadeUp .35s ease both;
}
.ev-table tbody tr:last-child { border-bottom: none; }
[data-theme="dark"]  .ev-table tbody tr:hover { background: rgba(255,255,255,.028); }
[data-theme="light"] .ev-table tbody tr:hover { background: rgba(15,30,60,.035); }

.ev-table tbody td {
    padding: .95rem 1.4rem; font-size: .81rem; color: var(--tx2);
    vertical-align: middle; transition: color var(--dur);
}

/* Row stagger */
.ev-table tbody tr:nth-child(1)  { animation-delay:.05s }
.ev-table tbody tr:nth-child(2)  { animation-delay:.08s }
.ev-table tbody tr:nth-child(3)  { animation-delay:.11s }
.ev-table tbody tr:nth-child(4)  { animation-delay:.14s }
.ev-table tbody tr:nth-child(5)  { animation-delay:.17s }
.ev-table tbody tr:nth-child(6)  { animation-delay:.20s }
.ev-table tbody tr:nth-child(7)  { animation-delay:.23s }
.ev-table tbody tr:nth-child(8)  { animation-delay:.26s }

/* Title cell */
.ev-title-cell { display: flex; align-items: center; gap: 10px; }
.ev-icon {
    width: 34px; height: 34px; border-radius: 9px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    transition: background .2s, color .2s;
}
[data-theme="dark"]  .ev-icon { background: rgba(245,158,11,.12); color: #FCD34D; }
[data-theme="light"] .ev-icon { background: var(--amber-dim); color: var(--amber); }
.ev-icon svg { width: 15px; height: 15px; }

.ev-title-text {
    font-weight: 600; color: var(--tx1);
    transition: color var(--dur);
}
.ev-title-sub {
    font-size: .69rem; color: var(--tx3); margin-top: 1px;
    transition: color var(--dur);
}

/* Unit badge */
.unit-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 9px; border-radius: 20px;
    font-size: .7rem; font-weight: 600; white-space: nowrap;
    transition: all var(--dur);
}
[data-theme="dark"]  .unit-badge { background: rgba(139,92,246,.1); border: 1px solid rgba(139,92,246,.22); color: #C4B5FD; }
[data-theme="light"] .unit-badge { background: var(--violet-dim); border: 1px solid rgba(109,40,217,.22); color: var(--violet); }

/* Date badge */
.date-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 9px; border-radius: 7px;
    font-size: .74rem; font-weight: 500; white-space: nowrap;
    font-family: 'Space Grotesk', sans-serif;
    transition: all var(--dur);
}
[data-theme="dark"]  .date-badge { background: rgba(59,130,246,.1); border: 1px solid rgba(59,130,246,.18); color: #93C5FD; }
[data-theme="light"] .date-badge { background: var(--blue-dim); border: 1px solid rgba(29,78,216,.2); color: var(--blue); }

/* Description */
.desc-text {
    max-width: 260px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    font-size: .78rem; color: var(--tx3);
    transition: color var(--dur);
}

/* ── Action buttons ── */
.act-row { display: flex; align-items: center; gap: .4rem; }
.act-btn {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 5px 11px; border-radius: 7px;
    font-size: .72rem; font-weight: 600; cursor: pointer;
    transition: all .2s; text-decoration: none; border: 1px solid transparent;
    font-family: 'Plus Jakarta Sans', sans-serif; white-space: nowrap;
    background: none;
}

/* Edit */
[data-theme="dark"]  .act-btn-edit { background: rgba(59,130,246,.12); border-color: rgba(59,130,246,.22); color: #93C5FD; }
[data-theme="dark"]  .act-btn-edit:hover { background: rgba(59,130,246,.22); border-color: rgba(59,130,246,.4); color: #BFDBFE; }
[data-theme="light"] .act-btn-edit { background: var(--blue-dim); border-color: rgba(29,78,216,.22); color: var(--blue); }
[data-theme="light"] .act-btn-edit:hover { background: rgba(29,78,216,.18); border-color: rgba(29,78,216,.4); color: #1e3a8a; }

/* Delete */
[data-theme="dark"]  .act-btn-del { background: rgba(244,63,94,.1); border-color: rgba(244,63,94,.2); color: #FDA4AF; }
[data-theme="dark"]  .act-btn-del:hover { background: rgba(244,63,94,.2); border-color: rgba(244,63,94,.4); color: #FECDD3; }
[data-theme="light"] .act-btn-del { background: var(--rose-dim); border-color: rgba(190,18,60,.22); color: var(--rose); }
[data-theme="light"] .act-btn-del:hover { background: rgba(190,18,60,.18); border-color: rgba(190,18,60,.4); color: #881337; }

/* ── Empty state ── */
.empty-state { text-align: center; padding: 4rem 2rem; }
.empty-state svg { width: 52px; height: 52px; margin: 0 auto 1rem; display: block; opacity: .3; color: var(--tx3); }
.empty-state p   { font-size: .9rem; margin-bottom: .4rem; color: var(--tx2); }
.empty-state span { font-size: .78rem; color: var(--tx3); }

/* ── Table footer ── */
.tbl-ft {
    padding: .8rem 1.4rem; border-top: 1px solid var(--bdr);
    display: flex; align-items: center; justify-content: space-between;
    font-size: .7rem; color: var(--tx3); flex-wrap: wrap; gap: .5rem;
    transition: border-color var(--dur), color var(--dur);
}

/* ── Delete modal ── */
.modal-overlay {
    position: fixed; inset: 0; z-index: 1000;
    background: rgba(0,0,0,0.65); backdrop-filter: blur(6px);
    display: flex; align-items: center; justify-content: center; padding: 1rem;
    opacity: 0; pointer-events: none; transition: opacity .25s;
}
.modal-overlay.open { opacity: 1; pointer-events: all; }

.modal-box {
    border: 1px solid var(--bdr-hi); border-radius: 16px; padding: 2rem;
    max-width: 400px; width: 100%;
    transform: scale(.95); transition: transform .25s, background var(--dur), border-color var(--dur);
}
[data-theme="dark"]  .modal-box { background: #0D1627; }
[data-theme="light"] .modal-box { background: #FFFFFF; box-shadow: 0 20px 60px rgba(15,30,60,.18); }
.modal-overlay.open .modal-box { transform: scale(1); }

.modal-icon {
    width: 52px; height: 52px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center; margin-bottom: 1.2rem;
    transition: all var(--dur);
}
[data-theme="dark"]  .modal-icon { background: rgba(244,63,94,.12); border: 1px solid rgba(244,63,94,.25); }
[data-theme="light"] .modal-icon { background: var(--rose-dim); border: 1px solid rgba(190,18,60,.25); }
.modal-icon svg { width: 24px; height: 24px; color: var(--rose); }

.modal-title {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 1.1rem; font-weight: 700; color: var(--tx1); margin-bottom: .5rem;
    transition: color var(--dur);
}
.modal-body { font-size: .82rem; color: var(--tx2); line-height: 1.6; margin-bottom: 1.5rem; transition: color var(--dur); }
.modal-event-name { font-weight: 600; color: var(--tx1); }

.modal-actions { display: flex; gap: .6rem; justify-content: flex-end; }

.modal-cancel {
    padding: 8px 16px; border-radius: 9px;
    background: var(--surf); border: 1px solid var(--bdr);
    font-size: .8rem; font-weight: 500; color: var(--tx2);
    cursor: pointer; transition: all .2s; font-family: 'Plus Jakarta Sans', sans-serif;
}
.modal-cancel:hover { background: var(--surf-hov); color: var(--tx1); }

.modal-confirm {
    padding: 8px 16px; border-radius: 9px;
    background: linear-gradient(135deg, #BE123C, #F43F5E);
    border: 1px solid rgba(244,63,94,.4);
    font-size: .8rem; font-weight: 600; color: #fff;
    cursor: pointer; transition: all .2s; font-family: 'Plus Jakarta Sans', sans-serif;
    box-shadow: 0 4px 14px rgba(244,63,94,.25);
}
.modal-confirm:hover { box-shadow: 0 6px 20px rgba(244,63,94,.4); transform: translateY(-1px); }

/* ── Scrollbar ── */
[data-theme="dark"]  .fp ::-webkit-scrollbar-thumb { background: rgba(255,255,255,.09); }
[data-theme="light"] .fp ::-webkit-scrollbar-thumb { background: rgba(15,30,60,.15); }
::-webkit-scrollbar { width: 4px; height: 4px; }
::-webkit-scrollbar-track { background: transparent; }

/* ── Animation ── */
@keyframes fadeUp {
    from { opacity:0; transform:translateY(14px); }
    to   { opacity:1; transform:translateY(0); }
}

/* ── Responsive ── */
@media(max-width:900px) {
    .fp { padding: 1.2rem 1.1rem 4rem; }
    .ev-stats { grid-template-columns: 1fr 1fr; }
    .tbl-search input { width: 140px; }
    .desc-text { max-width: 150px; }
}
@media(max-width:600px) {
    .ev-stats { grid-template-columns: 1fr; }
    .pg-title { font-size: 1.3rem; }
    .ev-table thead th:nth-child(4),
    .ev-table tbody td:nth-child(4) { display: none; }
}
</style>

@php
    $total    = 0; // count($forms) when connected to database
    $pending  = 0;
    $approved = 0;
    $rejected = 0;
@endphp

<div class="fp">

    {{-- ── DELETE CONFIRM MODAL ── --}}
    <div class="modal-overlay" id="delModal">
        <div class="modal-box">
            <div class="modal-icon">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                    <path d="M10 11v6"/><path d="M14 11v6"/>
                    <path d="M9 6V4h6v2"/>
                </svg>
            </div>
            <div class="modal-title">Delete Form</div>
            <div class="modal-body">
                Are you sure you want to delete
                <span class="modal-event-name" id="delEventName"></span>?
                This action cannot be undone.
            </div>
            <div class="modal-actions">
                <button class="modal-cancel" onclick="closeModal()">Cancel</button>
                <form id="delForm" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="modal-confirm">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>

    {{-- ── PAGE BAR ── --}}
    <div class="pg-bar">
        <div>
            <div class="pg-title">Forms Management</div>
            <div class="pg-sub">Manage and review cadet forms and applications</div>
        </div>
        <a href="{{ route('admin.forms.create') }}" class="btn btn-green">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Add Form
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
        <div class="ev-stat s-cyan">
            <div class="ev-stat-ico">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 12h6m-6 4h6m2-8H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2z"/>
                </svg>
            </div>
            <div>
                <div class="ev-stat-val">{{ $total }}</div>
                <div class="ev-stat-lbl">Total Forms</div>
            </div>
        </div>
        <div class="ev-stat s-green">
            <div class="ev-stat-ico">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
            </div>
            <div>
                <div class="ev-stat-val">{{ $approved }}</div>
                <div class="ev-stat-lbl">Approved</div>
            </div>
        </div>
        <div class="ev-stat s-amber">
            <div class="ev-stat-ico">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
            <div>
                <div class="ev-stat-val">{{ $pending }}</div>
                <div class="ev-stat-lbl">Pending Review</div>
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
            <input type="text" id="evSearch" placeholder="Search forms, cadets…">
        </div>
        <span class="tbl-count" id="evCount">{{ $total }} form{{ $total !== 1 ? 's' : '' }}</span>
    </div>

    {{-- ── FILTER TABS ── --}}
    <div style="display:flex;gap:0.5rem;margin-bottom:1rem;flex-wrap:wrap;">
        <a href="{{ route('admin.forms.index') }}" class="btn" style="padding:7px 13px;background:var(--blue);border:1px solid var(--blue);color:#fff;font-size:0.75rem;text-decoration:none;">
            All Forms ({{ $total }})
        </a>
        <a href="{{ route('admin.forms.pending') }}" class="btn" style="padding:7px 13px;background:transparent;border:1px solid var(--bdr);color:var(--tx2);font-size:0.75rem;text-decoration:none;">
            Pending ({{ $pending }})
        </a>
        <a href="{{ route('admin.forms.approved') }}" class="btn" style="padding:7px 13px;background:transparent;border:1px solid var(--bdr);color:var(--tx2);font-size:0.75rem;text-decoration:none;">
            Approved ({{ $approved }})
        </a>
        <a href="{{ route('admin.forms.rejected') }}" class="btn" style="padding:7px 13px;background:transparent;border:1px solid var(--bdr);color:var(--tx2);font-size:0.75rem;text-decoration:none;">
            Rejected ({{ $rejected }})
        </a>
    </div>

    {{-- ── TABLE PANEL ── --}}
    <div class="tbl-panel">
        <div class="tbl-hd">
            <div class="tbl-ttl">All Forms</div>
            <span class="tbl-badge">{{ $total }} Total</span>
        </div>

        @if($total == 0)
        <div class="empty-state">
            <svg fill="none" stroke="currentColor" stroke-width="1.3" viewBox="0 0 24 24">
                <path d="M9 12h6m-6 4h6m2-8H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2z"/>
            </svg>
            <p>No forms submitted yet</p>
            <span>Forms submitted by cadets will appear here</span>
        </div>
        @else

        <div style="overflow-x:auto;">
            <table class="ev-table" id="evTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Form Title</th>
                        <th>Submitted By</th>
                        <th>Status</th>
                        <th>Date Submitted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Sample row - replace with actual data -->
                    <tr style="display:none;">
                        <td style="color:var(--tx3); font-variant-numeric:tabular-nums; font-size:.75rem;">1</td>
                        <td>
                            <div class="ev-title-cell">
                                <div class="ev-icon">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M9 12h6m-6 4h6m2-8H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="ev-title-text">Sample Form</div>
                                    <div class="ev-title-sub">ID #1</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="unit-badge">
                                <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"/><polyline points="12 8 12 12 15 15"/>
                                </svg>
                                Cadet Name
                            </span>
                        </td>
                        <td>
                            <span style="display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:6px;font-size:.7rem;font-weight:600;background:rgba(31,213,122,.1);border:1px solid rgba(31,213,122,.22);color:#86EFAC;">
                                Approved
                            </span>
                        </td>
                        <td>
                            <span class="date-badge">15 Feb 2025</span>
                        </td>
                        <td>
                            <div class="act-row">
                                <a href="#" class="act-btn act-btn-edit">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                    </svg>
                                    View
                                </a>
                                <button class="act-btn act-btn-del" onclick="openDeleteModal('Sample Form', '#')">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <polyline points="3 6 5 6 21 6"/>
                                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                    </svg>
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
        </div>

        <div class="tbl-ft">
            <span id="evTableCount">Showing {{ $total }} form{{ $total !== 1 ? 's' : '' }}</span>
            <span>Last updated · {{ now()->format('H:i:s') }}</span>
        </div>
        @endif
    </div>

</div>

<script>
/* ── Search ── */
document.getElementById('evSearch').addEventListener('input', function () {
    clearTimeout(this._t);
    this._t = setTimeout(() => {
        const q = this.value.trim().toLowerCase();
        const rows = document.querySelectorAll('#evTable tbody tr');
        let visible = 0;

        rows.forEach(row => {
            const match = q === '' || row.textContent.toLowerCase().includes(q);
            row.style.display = match ? '' : 'none';
            if (match) visible++;
        });

        let noRes = document.getElementById('noEvRow');
        if (visible === 0 && q) {
            if (!noRes) {
                noRes = document.createElement('tr');
                noRes.id = 'noEvRow';
                noRes.innerHTML = `<td colspan="6" style="text-align:center;padding:2.5rem;color:var(--tx3);font-size:.82rem;">No forms matching "<strong style='color:var(--tx2)'>${q}</strong>"</td>`;
                document.querySelector('#evTable tbody').appendChild(noRes);
            }
        } else if (noRes) noRes.remove();

        const countEl  = document.getElementById('evTableCount');
        const topCount = document.getElementById('evCount');
        if (countEl)  countEl.textContent  = q ? `Showing ${visible} of ${rows.length} form${rows.length !== 1 ? 's' : ''}` : `Showing ${rows.length} form${rows.length !== 1 ? 's' : ''}`;
        if (topCount) topCount.textContent = q ? `${visible} result${visible !== 1 ? 's' : ''}` : `${rows.length} form${rows.length !== 1 ? 's' : ''}`;
    }, 160);
});

/* ── Delete Modal ── */
function openDeleteModal(name, action) {
    document.getElementById('delEventName').textContent = `"${name}"`;
    document.getElementById('delForm').action = action;
    document.getElementById('delModal').classList.add('open');
}
function closeModal() {
    document.getElementById('delModal').classList.remove('open');
}
document.getElementById('delModal').addEventListener('click', function(e) { if (e.target === this) closeModal(); });
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

/* ── Mobile modal full-screen ── */
(function() {
    const modal = document.getElementById('delModal');
    if (!modal) return;
    const style = document.createElement('style');
    style.textContent = `
        @media(max-width:600px) {
            .modal-overlay { align-items: flex-end; padding: 0; }
            .modal-box { width:100%!important; max-width:none!important; border-radius:16px 16px 0 0!important; }
        }
    `;
    document.head.appendChild(style);

    const observer = new MutationObserver(() => {
        document.documentElement.style.overflow = modal.classList.contains('open') ? 'hidden' : '';
        document.body.style.overflow = modal.classList.contains('open') ? 'hidden' : '';
    });
    observer.observe(modal, { attributes: true, attributeFilter: ['class'] });
})();
</script>

@endsection