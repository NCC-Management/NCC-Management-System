@extends('layouts.admin')

@section('content')
{{--
    No wrapper div needed here anymore.
    The layout's .page-content already has padding:0 on dashboard route.
    .adash handles its own full-width layout internally.
--}}

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>

/* ── Reset scoped to dashboard ── */
.adash *, .adash *::before, .adash *::after { box-sizing: border-box; }

:root {
    --c-bg:      #060C1A;
    --c-surf:    #0D1627;
    --c-card:    rgba(255,255,255,0.038);
    --c-cardhov: rgba(255,255,255,0.065);
    --c-border:  rgba(255,255,255,0.07);
    --c-bordehi: rgba(255,255,255,0.13);
    --c-blue:  #3B82F6;
    --c-green: #22C55E;
    --c-rose:  #F43F5E;
    --c-amber: #F59E0B;
    --c-violet:#8B5CF6;
    --c-cyan:  #06B6D4;
    --t1: #F1F5F9;
    --t2: #94A3B8;
    --t3: #475569;
    --t4: #1E293B;
    --radius: 14px;
    --gap: 1.1rem;
}

/* ── Wrapper ── */
.adash {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: var(--c-bg);
    min-height: calc(100vh - 68px); /* subtract topbar height */
    color: var(--t1);
    position: relative;
    overflow-x: hidden;
    width: 100%;   /* KEY: fill the no-padding page-content */
}

/* Ambient glow */
.adash::before {
    content: '';
    position: fixed; inset: 0; pointer-events: none; z-index: 0;
    background:
        radial-gradient(ellipse 90% 55% at 10% -5%,  rgba(59,130,246,0.11) 0%, transparent 55%),
        radial-gradient(ellipse 60% 45% at 90% 105%, rgba(139,92,246,0.09) 0%, transparent 55%),
        radial-gradient(ellipse 45% 55% at 55% 55%,  rgba(6,182,212,0.03)  0%, transparent 65%);
}
.adash > * { position: relative; z-index: 1; }

/* ── TOP PAGE BAR ── */
.pg-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: .75rem;
    padding: 1.6rem 2rem 0;
}

.pg-title {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 1.55rem;
    font-weight: 700;
    color: var(--t1);
    letter-spacing: -.03em;
    line-height: 1.2;
}

.pg-sub {
    font-size: .79rem;
    color: var(--t2);
    margin-top: 3px;
}

.pg-actions { display: flex; gap: .6rem; flex-wrap: wrap; }

.btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 7px 15px;
    border-radius: 9px;
    font-size: .77rem; font-weight: 500;
    cursor: pointer; transition: all .2s;
    font-family: 'Plus Jakarta Sans', sans-serif;
    white-space: nowrap;
    text-decoration: none;
    border: none;
}

.btn-ghost {
    background: var(--c-card);
    border: 1px solid var(--c-border);
    color: var(--t2);
}
.btn-ghost:hover { background: var(--c-cardhov); border-color: var(--c-bordehi); color: var(--t1); }

.btn-primary {
    background: linear-gradient(135deg, #3B82F6, #2563EB);
    border: 1px solid rgba(59,130,246,0.4);
    color: #fff;
    font-weight: 600;
    box-shadow: 0 4px 16px rgba(59,130,246,0.25);
}
.btn-primary:hover { box-shadow: 0 6px 22px rgba(59,130,246,0.4); transform: translateY(-1px); }

/* ── BODY AREA ── */
.pg-body {
    padding: 1.6rem 2rem 4rem;
    display: flex;
    flex-direction: column;
    gap: 1.8rem;
}

/* ── SECTION HEADER ── */
.sec-hd {
    display: flex; align-items: center; gap: 10px;
    margin-bottom: .85rem;
}
.sec-hd-label {
    font-size: .63rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .13em;
    color: var(--t3); white-space: nowrap;
}
.sec-hd::after { content:''; flex:1; height:1px; background: var(--c-border); }

/* ── STAT CARDS ── */
.stat-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: var(--gap);
}

.sc {
    background: var(--c-card);
    border: 1px solid var(--c-border);
    border-radius: var(--radius);
    padding: 1.3rem 1.35rem;
    position: relative; overflow: hidden;
    transition: transform .28s cubic-bezier(.4,0,.2,1),
                box-shadow  .28s cubic-bezier(.4,0,.2,1),
                border-color .28s;
    animation: fadeUp .45s ease both;
}

.sc:hover {
    transform: translateY(-3px);
    border-color: var(--c-bordehi);
}

.sc.blue:hover  { box-shadow: 0 16px 36px rgba(0,0,0,.45), 0 0 0 1px rgba(59,130,246,.2); }
.sc.green:hover { box-shadow: 0 16px 36px rgba(0,0,0,.45), 0 0 0 1px rgba(34,197,94,.2); }
.sc.amber:hover { box-shadow: 0 16px 36px rgba(0,0,0,.45), 0 0 0 1px rgba(245,158,11,.2); }
.sc.rose:hover  { box-shadow: 0 16px 36px rgba(0,0,0,.45), 0 0 0 1px rgba(244,63,94,.2); }

.sc:nth-child(1){animation-delay:.04s}
.sc:nth-child(2){animation-delay:.09s}
.sc:nth-child(3){animation-delay:.14s}
.sc:nth-child(4){animation-delay:.19s}

@keyframes fadeUp {
    from { opacity:0; transform:translateY(16px); }
    to   { opacity:1; transform:translateY(0); }
}

.sc::before {
    content:''; position:absolute;
    top:0; left:14%; right:14%; height:1px;
}
.sc.blue::before  { background:linear-gradient(90deg,transparent,#3B82F6,transparent); box-shadow:0 0 8px rgba(59,130,246,.6); }
.sc.green::before { background:linear-gradient(90deg,transparent,#22C55E,transparent); box-shadow:0 0 8px rgba(34,197,94,.6); }
.sc.amber::before { background:linear-gradient(90deg,transparent,#F59E0B,transparent); box-shadow:0 0 8px rgba(245,158,11,.6); }
.sc.rose::before  { background:linear-gradient(90deg,transparent,#F43F5E,transparent); box-shadow:0 0 8px rgba(244,63,94,.6); }

.sc-top {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: .95rem;
}
.sc-lbl {
    font-size: .63rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .1em; color: var(--t3);
}
.sc-ico {
    width: 34px; height: 34px; border-radius: 9px;
    display: flex; align-items: center; justify-content: center; flex-shrink:0;
}
.sc-ico svg { width: 16px; height: 16px; }

.blue  .sc-ico { background:rgba(59,130,246,.15); color:#93C5FD; }
.green .sc-ico { background:rgba(34,197,94,.15);  color:#86EFAC; }
.amber .sc-ico { background:rgba(245,158,11,.15); color:#FCD34D; }
.rose  .sc-ico { background:rgba(244,63,94,.15);  color:#FDA4AF; }

.sc-val {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 2.4rem; font-weight: 700;
    letter-spacing: -.04em; line-height: 1; margin-bottom: .3rem;
}
.blue  .sc-val { color: #BFDBFE; }
.green .sc-val { color: #BBF7D0; }
.amber .sc-val { color: #FDE68A; }
.rose  .sc-val { color: #FECDD3; }

.sc-desc { font-size:.74rem; color:var(--t3); margin-bottom:.85rem; }

.sc-bar { height:3px; background:rgba(255,255,255,.055); border-radius:99px; overflow:hidden; margin-bottom:.65rem; }
.sc-bar-fill { height:100%; border-radius:99px; transition:width 1.1s cubic-bezier(.4,0,.2,1); }
.blue  .sc-bar-fill { background:linear-gradient(90deg,#1D4ED8,#3B82F6,#60A5FA); }
.green .sc-bar-fill { background:linear-gradient(90deg,#15803D,#22C55E,#4ADE80); }
.amber .sc-bar-fill { background:linear-gradient(90deg,#B45309,#F59E0B,#FCD34D); }
.rose  .sc-bar-fill { background:linear-gradient(90deg,#BE123C,#F43F5E,#FB7185); }

.sc-foot {
    display: flex; align-items: center; justify-content: space-between;
    font-size: .69rem; color: var(--t3);
}
.sc-rate { display:flex; align-items:center; gap:4px; font-weight:600; }
.blue  .sc-rate { color:#60A5FA; }
.green .sc-rate { color:#4ADE80; }
.amber .sc-rate { color:#FCD34D; }
.rose  .sc-rate { color:#FB7185; }

/* ── QUICK INFO TILES ── */
.tile-row {
    display: grid; grid-template-columns: repeat(3,1fr);
    gap: var(--gap);
    animation: fadeUp .45s ease .27s both;
}

.tile {
    background: var(--c-card); border: 1px solid var(--c-border);
    border-radius: var(--radius); padding: 1rem 1.3rem;
    display: flex; align-items: center; gap: .95rem;
    transition: all .22s;
}
.tile:hover { background: var(--c-cardhov); border-color: var(--c-bordehi); }

.tile-ico {
    width: 42px; height: 42px; border-radius: 11px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.tile-ico svg { width: 19px; height: 19px; }
.tile-val {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 1.2rem; font-weight: 700; color: var(--t1); letter-spacing: -.02em;
}
.tile-lbl { font-size: .72rem; color: var(--t2); margin-top: 2px; }

/* ── CHARTS ── */
.charts-row {
    display: grid; grid-template-columns: 1.7fr 1fr;
    gap: var(--gap);
    animation: fadeUp .45s ease .32s both;
}

.panel {
    background: var(--c-card); border: 1px solid var(--c-border);
    border-radius: var(--radius); padding: 1.35rem;
    overflow: hidden;
}

.panel-hd { display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:1.2rem; }
.panel-ttl { font-family:'Space Grotesk',sans-serif; font-size:.92rem; font-weight:600; color:var(--t1); letter-spacing:-.01em; }
.panel-sub { font-size:.7rem; color:var(--t3); margin-top:3px; }
.badge-live {
    padding:3px 9px;
    background:rgba(34,197,94,.1); border:1px solid rgba(34,197,94,.22);
    border-radius:20px; font-size:.63rem; font-weight:700;
    letter-spacing:.07em; text-transform:uppercase; color:#86EFAC;
    display: flex; align-items: center; gap: 5px; flex-shrink: 0;
}
.badge-live-dot {
    width: 5px; height: 5px; border-radius: 50%; background: #22C55E;
    animation: livePulse 2s ease infinite;
}
@keyframes livePulse {
    0%,100%{ opacity:1; } 50%{ opacity:.35; }
}

.chart-box   { position:relative; height:215px; }
.donut-box   { position:relative; height:195px; }
.donut-ctr   {
    position:absolute; top:50%; left:50%;
    transform:translate(-50%,-56%);
    text-align:center; pointer-events:none;
}
.donut-ctr-val { font-family:'Space Grotesk',sans-serif; font-size:1.75rem; font-weight:700; color:var(--t1); line-height:1; }
.donut-ctr-lbl { font-size:.6rem; text-transform:uppercase; letter-spacing:.1em; color:var(--t3); margin-top:2px; }

.chart-leg { display:flex; gap:1.1rem; margin-top:.8rem; flex-wrap:wrap; }
.leg-item { display:flex; align-items:center; gap:6px; font-size:.73rem; color:var(--t2); }
.leg-dot { width:7px; height:7px; border-radius:2px; flex-shrink:0; }

/* ── BOTTOM ROW ── */
.bottom-row {
    display: grid; grid-template-columns: 1fr 340px;
    gap: var(--gap);
    animation: fadeUp .45s ease .37s both;
}

.mini-stat-list { display:flex; flex-direction:column; gap:.6rem; margin-top:.5rem; }
.mini-stat {
    display: flex; align-items: center; justify-content: space-between;
    padding: .75rem 1rem;
    background: rgba(255,255,255,.03); border: 1px solid var(--c-border);
    border-radius: 10px; transition: all .2s;
}
.mini-stat:hover { background: var(--c-cardhov); border-color: var(--c-bordehi); }
.mini-stat-left { display:flex; align-items:center; gap:10px; }
.mini-stat-dot { width:8px; height:8px; border-radius:50%; flex-shrink:0; }
.mini-stat-label { font-size:.8rem; font-weight:500; color:var(--t1); }
.mini-stat-sub   { font-size:.68rem; color:var(--t3); margin-top:1px; }
.mini-stat-val   { font-family:'Space Grotesk',sans-serif; font-size:1.1rem; font-weight:700; }

/* ── TABLE ── */
.tbl-panel {
    background: var(--c-card); border: 1px solid var(--c-border);
    border-radius: var(--radius); overflow: hidden;
    animation: fadeUp .45s ease .42s both;
}
.tbl-hd {
    padding: 1rem 1.4rem; border-bottom: 1px solid var(--c-border);
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: .6rem;
}
.tbl-ttl { font-family:'Space Grotesk',sans-serif; font-size:.9rem; font-weight:600; color:var(--t1); }

.tbl-controls { display:flex; align-items:center; gap:.5rem; }

.tbl-search {
    display:flex; align-items:center; gap:7px;
    background:rgba(255,255,255,.048); border:1px solid var(--c-border);
    border-radius:8px; padding:5px 10px; transition: border-color .2s;
}
.tbl-search:focus-within { border-color: var(--c-bordehi); }
.tbl-search input {
    background:transparent; border:none; outline:none;
    font-size:.76rem; color:var(--t1);
    font-family:'Plus Jakarta Sans',sans-serif; width:145px;
}
.tbl-search input::placeholder { color:var(--t3); }
.tbl-search svg { width:13px; height:13px; color:var(--t3); flex-shrink:0; }

.tbl-filter-btn {
    display:flex; align-items:center; gap:5px;
    padding:5px 10px;
    background:rgba(255,255,255,.04); border:1px solid var(--c-border);
    border-radius:8px; font-size:.74rem; font-weight:500; color:var(--t2);
    cursor:pointer; transition:all .2s;
    font-family:'Plus Jakarta Sans',sans-serif;
}
.tbl-filter-btn:hover { background:var(--c-cardhov); color:var(--t1); }
.tbl-filter-btn svg { width:12px; height:12px; }

.at-table { width:100%; border-collapse:collapse; }
.at-table thead tr { border-bottom:1px solid var(--c-border); }
.at-table thead th {
    padding:.7rem 1.4rem; font-size:.64rem; font-weight:700;
    text-transform:uppercase; letter-spacing:.09em; color:var(--t3); text-align:left;
    white-space:nowrap;
}
.at-table tbody tr { border-bottom:1px solid rgba(255,255,255,.04); transition:background .18s; }
.at-table tbody tr:last-child { border-bottom:none; }
.at-table tbody tr:hover { background:rgba(255,255,255,.028); }
.at-table tbody td { padding:.85rem 1.4rem; font-size:.8rem; color:var(--t2); }

.td-user { display:flex; align-items:center; gap:9px; }
.td-av {
    width:30px; height:30px; border-radius:8px;
    display:flex; align-items:center; justify-content:center;
    font-size:.68rem; font-weight:700; color:#fff; flex-shrink:0;
}
.td-nm { font-weight:500; color:var(--t1); }

.pill {
    display:inline-flex; align-items:center; gap:5px;
    padding:3px 10px; border-radius:20px;
    font-size:.67rem; font-weight:600; white-space:nowrap;
}
.pill.present { background:rgba(34,197,94,.1);  border:1px solid rgba(34,197,94,.22);  color:#86EFAC; }
.pill.absent  { background:rgba(244,63,94,.1);   border:1px solid rgba(244,63,94,.22);   color:#FDA4AF; }
.pill.pending { background:rgba(245,158,11,.1);  border:1px solid rgba(245,158,11,.22); color:#FCD34D; }
.pill-dot { width:5px; height:5px; border-radius:50%; flex-shrink:0; }
.pill.present .pill-dot { background:#22C55E; }
.pill.absent  .pill-dot { background:#F43F5E; }
.pill.pending .pill-dot { background:#F59E0B; }

.tbl-ft {
    padding:.8rem 1.4rem; border-top:1px solid var(--c-border);
    display:flex; align-items:center; justify-content:space-between;
    font-size:.7rem; color:var(--t3); flex-wrap:wrap; gap:.5rem;
}

.tbl-pagination { display:flex; align-items:center; gap:.35rem; }
.pg-btn {
    width:26px; height:26px;
    background:rgba(255,255,255,.04); border:1px solid var(--c-border);
    border-radius:6px; display:flex; align-items:center; justify-content:center;
    cursor:pointer; font-size:.7rem; font-weight:600; color:var(--t2);
    transition:all .18s; font-family:'Plus Jakarta Sans',sans-serif;
}
.pg-btn:hover { background:var(--c-cardhov); color:var(--t1); }
.pg-btn.active { background:rgba(59,130,246,.18); border-color:rgba(59,130,246,.3); color:#93C5FD; }

/* ── SCROLLBAR ── */
::-webkit-scrollbar { width:4px; height:4px; }
::-webkit-scrollbar-track { background:transparent; }
::-webkit-scrollbar-thumb { background:rgba(255,255,255,.09); border-radius:99px; }

/* ── RESPONSIVE ── */
@media(max-width:1200px) {
    .stat-grid { grid-template-columns: repeat(2,1fr); }
    .charts-row { grid-template-columns: 1fr; }
    .bottom-row { grid-template-columns: 1fr; }
}
@media(max-width:900px) {
    .pg-bar { padding: 1.2rem 1.25rem 0; }
    .pg-body { padding: 1.2rem 1.25rem 4rem; }
    .tile-row { grid-template-columns: 1fr; }
}
@media(max-width:640px) {
    .stat-grid { grid-template-columns: 1fr; }
    .pg-title { font-size: 1.3rem; }
}
</style>

@php
    $total      = $totalCadets ?? 0;
    $presentCnt = $present ?? 0;
    $absentCnt  = $absent  ?? 0;
    $eventCnt   = $totalEvents ?? 0;
    $base       = max($presentCnt + $absentCnt, 1);
    $presentPct = round(($presentCnt / $base) * 100);
    $absentPct  = 100 - $presentPct;
    $cadetList  = $cadets ?? collect([]);
@endphp

<div class="adash">

    {{-- PAGE BAR --}}
    <div class="pg-bar">
        <div>
            <div class="pg-title">Dashboard Overview</div>
            <div class="pg-sub">
                {{ now()->format('l, d F Y') }}
                &nbsp;·&nbsp;
                Cadet enrollment &amp; attendance monitoring
            </div>
        </div>
        <div class="pg-actions">
            <button class="btn btn-ghost" onclick="window.print()">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                Print
            </button>
            <button class="btn btn-primary" id="exportBtn">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Export CSV
            </button>
        </div>
    </div>

    <div class="pg-body">

        {{-- STAT CARDS --}}
        <div>
            <div class="sec-hd"><span class="sec-hd-label">Key Metrics</span></div>
            <div class="stat-grid">

                <div class="sc blue">
                    <div class="sc-top">
                        <span class="sc-lbl">Total Enrolled</span>
                        <span class="sc-ico">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </span>
                    </div>
                    <div class="sc-val">{{ $total }}</div>
                    <div class="sc-desc">Total forms submitted</div>
                    <div class="sc-bar"><div class="sc-bar-fill" style="width:100%"></div></div>
                    <div class="sc-foot"><span>Cumulative</span><span class="sc-rate">All time</span></div>
                </div>

                <div class="sc green">
                    <div class="sc-top">
                        <span class="sc-lbl">Present</span>
                        <span class="sc-ico">
                            <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        </span>
                    </div>
                    <div class="sc-val">{{ $presentCnt }}</div>
                    <div class="sc-desc">Cadets present today</div>
                    <div class="sc-bar"><div class="sc-bar-fill" style="width:{{ $presentPct }}%"></div></div>
                    <div class="sc-foot">
                        <span>Attendance rate</span>
                        <span class="sc-rate">
                            <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                            {{ $presentPct }}%
                        </span>
                    </div>
                </div>

                <div class="sc amber">
                    <div class="sc-top">
                        <span class="sc-lbl">Events</span>
                        <span class="sc-ico">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </span>
                    </div>
                    <div class="sc-val">{{ $eventCnt }}</div>
                    <div class="sc-desc">Scheduled events</div>
                    <div class="sc-bar"><div class="sc-bar-fill" style="width:{{ $eventCnt > 0 ? min($eventCnt * 8, 100) : 0 }}%"></div></div>
                    <div class="sc-foot"><span>This period</span><span class="sc-rate">Active</span></div>
                </div>

                <div class="sc rose">
                    <div class="sc-top">
                        <span class="sc-lbl">Absent</span>
                        <span class="sc-ico">
                            <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </span>
                    </div>
                    <div class="sc-val">{{ $absentCnt }}</div>
                    <div class="sc-desc">Cadets absent today</div>
                    <div class="sc-bar"><div class="sc-bar-fill" style="width:{{ $absentPct }}%"></div></div>
                    <div class="sc-foot">
                        <span>Absence rate</span>
                        <span class="sc-rate">
                            <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="23 18 13.5 8.5 8.5 13.5 1 6"/><polyline points="17 18 23 18 23 12"/></svg>
                            {{ $absentPct }}%
                        </span>
                    </div>
                </div>

            </div>
        </div>

        {{-- QUICK TILES --}}
        <div>
            <div class="sec-hd"><span class="sec-hd-label">At a Glance</span></div>
            <div class="tile-row">
                <div class="tile">
                    <div class="tile-ico" style="background:rgba(59,130,246,.12);color:#93C5FD;">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <div>
                        <div class="tile-val">{{ now()->format('d M Y') }}</div>
                        <div class="tile-lbl">Today's date</div>
                    </div>
                </div>
                <div class="tile">
                    <div class="tile-ico" style="background:rgba(34,197,94,.12);color:#86EFAC;">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    </div>
                    <div>
                        <div class="tile-val">{{ $presentPct }}%</div>
                        <div class="tile-lbl">Overall attendance rate</div>
                    </div>
                </div>
                <div class="tile">
                    <div class="tile-ico" style="background:rgba(139,92,246,.12);color:#C4B5FD;">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <div>
                        <div class="tile-val">{{ now()->format('H:i') }}</div>
                        <div class="tile-lbl">Last sync · Live</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CHARTS --}}
        <div>
            <div class="sec-hd"><span class="sec-hd-label">Analytics</span></div>
            <div class="charts-row">

                <div class="panel">
                    <div class="panel-hd">
                        <div>
                            <div class="panel-ttl">Attendance Breakdown</div>
                            <div class="panel-sub">Present vs absent — today's session</div>
                        </div>
                        <div class="badge-live"><span class="badge-live-dot"></span> Live</div>
                    </div>
                    <div class="chart-box">
                        <canvas id="barChart"></canvas>
                    </div>
                    <div class="chart-leg">
                        <div class="leg-item"><div class="leg-dot" style="background:#3B82F6;border-radius:50%;"></div> Present ({{ $presentCnt }})</div>
                        <div class="leg-item"><div class="leg-dot" style="background:#F43F5E;border-radius:50%;"></div> Absent ({{ $absentCnt }})</div>
                    </div>
                </div>

                <div class="panel">
                    <div class="panel-hd">
                        <div>
                            <div class="panel-ttl">Distribution</div>
                            <div class="panel-sub">Present vs absent proportion</div>
                        </div>
                    </div>
                    <div class="donut-box">
                        <canvas id="donutChart"></canvas>
                        <div class="donut-ctr">
                            <div class="donut-ctr-val">{{ $presentPct }}%</div>
                            <div class="donut-ctr-lbl">Present</div>
                        </div>
                    </div>
                    <div class="chart-leg" style="justify-content:center;">
                        <div class="leg-item"><div class="leg-dot" style="background:#22C55E;border-radius:50%;"></div> Present</div>
                        <div class="leg-item"><div class="leg-dot" style="background:#F43F5E;border-radius:50%;"></div> Absent</div>
                    </div>
                </div>

            </div>
        </div>

        {{-- BOTTOM ROW --}}
        <div>
            <div class="sec-hd"><span class="sec-hd-label">Weekly Trend &amp; Summary</span></div>
            <div class="bottom-row">

                <div class="panel">
                    <div class="panel-hd">
                        <div>
                            <div class="panel-ttl">Weekly Attendance Trend</div>
                            <div class="panel-sub">Last 7 days overview</div>
                        </div>
                        <div class="badge-live"><span class="badge-live-dot"></span> Live</div>
                    </div>
                    <div class="chart-box">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>

                <div class="panel">
                    <div class="panel-hd">
                        <div>
                            <div class="panel-ttl">Status Summary</div>
                            <div class="panel-sub">Current session breakdown</div>
                        </div>
                    </div>
                    <div class="mini-stat-list">
                        <div class="mini-stat">
                            <div class="mini-stat-left">
                                <div class="mini-stat-dot" style="background:#3B82F6;"></div>
                                <div><div class="mini-stat-label">Total Cadets</div><div class="mini-stat-sub">Enrolled this session</div></div>
                            </div>
                            <div class="mini-stat-val" style="color:#93C5FD;">{{ $total }}</div>
                        </div>
                        <div class="mini-stat">
                            <div class="mini-stat-left">
                                <div class="mini-stat-dot" style="background:#22C55E;"></div>
                                <div><div class="mini-stat-label">Present Today</div><div class="mini-stat-sub">Attendance confirmed</div></div>
                            </div>
                            <div class="mini-stat-val" style="color:#86EFAC;">{{ $presentCnt }}</div>
                        </div>
                        <div class="mini-stat">
                            <div class="mini-stat-left">
                                <div class="mini-stat-dot" style="background:#F43F5E;"></div>
                                <div><div class="mini-stat-label">Absent Today</div><div class="mini-stat-sub">Not accounted for</div></div>
                            </div>
                            <div class="mini-stat-val" style="color:#FDA4AF;">{{ $absentCnt }}</div>
                        </div>
                        <div class="mini-stat">
                            <div class="mini-stat-left">
                                <div class="mini-stat-dot" style="background:#F59E0B;"></div>
                                <div><div class="mini-stat-label">Events Scheduled</div><div class="mini-stat-sub">Upcoming activities</div></div>
                            </div>
                            <div class="mini-stat-val" style="color:#FCD34D;">{{ $eventCnt }}</div>
                        </div>
                        <div class="mini-stat">
                            <div class="mini-stat-left">
                                <div class="mini-stat-dot" style="background:#22C55E;"></div>
                                <div><div class="mini-stat-label">Attendance Rate</div><div class="mini-stat-sub">Today's percentage</div></div>
                            </div>
                            <div class="mini-stat-val" style="color:#4ADE80;">{{ $presentPct }}%</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- TABLE --}}
        <div>
            <div class="sec-hd"><span class="sec-hd-label">Recent Activity</span></div>
            <div class="tbl-panel">
                <div class="tbl-hd">
                    <div class="tbl-ttl">Cadet Status Log</div>
                    <div class="tbl-controls">
                        <div class="tbl-search">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            <input type="text" id="tblSearch" placeholder="Search cadets…">
                        </div>
                        <div class="tbl-filter-btn">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                            Filter
                        </div>
                    </div>
                </div>

                <div style="overflow-x:auto;">
                    <table class="at-table" id="cadetTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Cadet</th>
                                <th>Roll No.</th>
                                <th>Unit</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cadetList as $i => $cadet)
                            <tr>
                                <td style="color:var(--t3);font-variant-numeric:tabular-nums;">{{ $i + 1 }}</td>
                                <td>
                                    <div class="td-user">
                                        <div class="td-av" style="background:hsl({{ (abs(crc32($cadet->name ?? 'X')) % 280) + 30 }},50%,36%);">
                                            {{ strtoupper(substr($cadet->name ?? 'X', 0, 1)) }}
                                        </div>
                                        <span class="td-nm">{{ $cadet->name ?? '—' }}</span>
                                    </div>
                                </td>
                                <td style="font-variant-numeric:tabular-nums;">{{ $cadet->roll_no ?? '—' }}</td>
                                <td>{{ $cadet->unit ?? '—' }}</td>
                                <td style="white-space:nowrap;">{{ isset($cadet->created_at) ? \Carbon\Carbon::parse($cadet->created_at)->format('d M Y') : now()->format('d M Y') }}</td>
                                <td>
                                    @php $s = $cadet->status ?? 'pending'; @endphp
                                    <span class="pill {{ $s }}">
                                        <span class="pill-dot"></span>
                                        {{ ucfirst($s) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr id="emptyRow">
                                <td colspan="6" style="text-align:center;padding:3rem;color:var(--t3);font-size:.84rem;">
                                    <svg style="width:38px;height:38px;margin:0 auto 10px;display:block;opacity:.3;" fill="none" stroke="currentColor" stroke-width="1.4" viewBox="0 0 24 24"><path d="M12 2L2 7v9c0 5 10 6 10 6s10-1 10-6V7L12 2z"/></svg>
                                    No cadet records found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="tbl-ft">
                    <span id="tblCount">Showing {{ $cadetList->count() }} record{{ $cadetList->count() !== 1 ? 's' : '' }}</span>
                    <span>Last updated · {{ now()->format('H:i:s') }}</span>
                </div>
            </div>
        </div>

    </div>{{-- /pg-body --}}
</div>{{-- /adash --}}

<script>
Chart.defaults.color = '#475569';
Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";

const present = @json($presentCnt);
const absent  = @json($absentCnt);

const tooltipDefaults = {
    backgroundColor: 'rgba(8,15,30,0.96)',
    borderColor: 'rgba(255,255,255,0.07)',
    borderWidth: 1,
    titleColor: '#94A3B8',
    bodyColor: '#F1F5F9',
    padding: 11,
    cornerRadius: 9,
};

new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels: ['Present', 'Absent'],
        datasets: [{
            data: [present, absent],
            backgroundColor: ['rgba(59,130,246,0.72)', 'rgba(244,63,94,0.72)'],
            borderColor: ['#3B82F6', '#F43F5E'],
            borderWidth: 1,
            borderRadius: 8,
            borderSkipped: false,
            barPercentage: 0.42,
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: { ...tooltipDefaults, callbacks: { label: ctx => `  ${ctx.parsed.y} cadets` } }
        },
        scales: {
            x: { grid: { display:false }, border: { display:false }, ticks: { color:'#475569', font:{ size:12, weight:'500' } } },
            y: { beginAtZero:true, border:{ display:false }, grid:{ color:'rgba(255,255,255,0.04)' }, ticks:{ precision:0, color:'#334155', font:{ size:11 } } }
        }
    }
});

new Chart(document.getElementById('donutChart'), {
    type: 'doughnut',
    data: {
        labels: ['Present', 'Absent'],
        datasets: [{
            data: [Math.max(present, 0.001), absent],
            backgroundColor: ['rgba(34,197,94,0.82)', 'rgba(244,63,94,0.82)'],
            borderColor: ['#22C55E', '#F43F5E'],
            borderWidth: 1, hoverOffset: 5
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: false, cutout: '72%',
        plugins: {
            legend: { display: false },
            tooltip: { ...tooltipDefaults, callbacks: { label: ctx => `  ${ctx.parsed} cadets` } }
        }
    }
});

const days = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
const weeklyPresent = {!! json_encode($weeklyPresent ?? [0, 0, 0, 0, 0, 0, $presentCnt]) !!};
const weeklyAbsent  = {!! json_encode($weeklyAbsent  ?? [0, 0, 0, 0, 0, 0, $absentCnt]) !!};

new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
        labels: days,
        datasets: [
            {
                label: 'Present', data: weeklyPresent,
                borderColor: '#3B82F6', backgroundColor: 'rgba(59,130,246,0.08)',
                borderWidth: 2, tension: 0.4, fill: true,
                pointBackgroundColor: '#3B82F6', pointRadius: 4, pointHoverRadius: 6,
            },
            {
                label: 'Absent', data: weeklyAbsent,
                borderColor: '#F43F5E', backgroundColor: 'rgba(244,63,94,0.07)',
                borderWidth: 2, tension: 0.4, fill: true,
                pointBackgroundColor: '#F43F5E', pointRadius: 4, pointHoverRadius: 6,
            }
        ]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: {
            legend: { display: true, position: 'top', labels: { boxWidth: 10, padding: 14, font: { size: 11 }, color: '#94A3B8' } },
            tooltip: { ...tooltipDefaults, mode: 'index', intersect: false }
        },
        scales: {
            x: { grid: { display:false }, border:{ display:false }, ticks:{ color:'#475569', font:{ size:11 } } },
            y: { beginAtZero:true, border:{ display:false }, grid:{ color:'rgba(255,255,255,0.04)' }, ticks:{ precision:0, color:'#334155', font:{ size:11 } } }
        }
    }
});

/* Table search */
const tblSearch = document.getElementById('tblSearch');
const tblCount  = document.getElementById('tblCount');

tblSearch.addEventListener('input', function () {
    clearTimeout(this._t);
    this._t = setTimeout(() => {
        const q = this.value.trim().toLowerCase();
        const rows = document.querySelectorAll('#cadetTable tbody tr:not(#emptyRow):not(#noResultRow)');
        let visible = 0;
        rows.forEach(row => {
            const match = q === '' || row.textContent.toLowerCase().includes(q);
            row.style.display = match ? '' : 'none';
            if (match) visible++;
        });
        let noRes = document.getElementById('noResultRow');
        if (visible === 0 && q) {
            if (!noRes) {
                noRes = document.createElement('tr');
                noRes.id = 'noResultRow';
                noRes.innerHTML = `<td colspan="6" style="text-align:center;padding:2rem;color:var(--t3);font-size:.82rem;">No matching results for "<strong style="color:var(--t2);">${q}</strong>"</td>`;
                document.querySelector('#cadetTable tbody').appendChild(noRes);
            }
        } else if (noRes) { noRes.remove(); }
        tblCount.textContent = q
            ? `Showing ${visible} of ${rows.length} records`
            : `Showing ${rows.length} record${rows.length !== 1 ? 's' : ''}`;
    }, 160);
});

/* CSV Export */
document.getElementById('exportBtn').addEventListener('click', () => {
    const headers = ['#','Name','Roll No','Unit','Date','Status'];
    const rows = Array.from(document.querySelectorAll('#cadetTable tbody tr:not(#emptyRow):not(#noResultRow)'))
        .filter(r => r.style.display !== 'none')
        .map((r, i) => {
            const cells = r.querySelectorAll('td');
            return [
                i + 1,
                cells[1]?.querySelector('.td-nm')?.textContent.trim() ?? '',
                cells[2]?.textContent.trim() ?? '',
                cells[3]?.textContent.trim() ?? '',
                cells[4]?.textContent.trim() ?? '',
                cells[5]?.textContent.trim() ?? '',
            ].map(v => `"${String(v).replace(/"/g,'""')}"`).join(',');
        });
    const csv = [headers.join(','), ...rows].join('\n');
    const a = document.createElement('a');
    a.href = URL.createObjectURL(new Blob([csv], { type: 'text/csv' }));
    a.download = `ncc-cadets-${new Date().toISOString().slice(0,10)}.csv`;
    a.click();
});
</script>

@endsection