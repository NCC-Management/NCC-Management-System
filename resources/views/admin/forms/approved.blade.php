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
        radial-gradient(ellipse 80% 50% at 15% -5%,  rgba(31,213,122,0.07) 0%, transparent 55%),
        radial-gradient(ellipse 55% 45% at 85% 105%, rgba(31,213,122,0.07) 0%, transparent 55%);
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
.btn-green {
    background: linear-gradient(135deg, #16A34A, #22C55E);
    border: 1px solid rgba(34,197,94,0.35);
    color: #fff !important;
    box-shadow: 0 4px 16px rgba(34,197,94,0.22);
}
.btn-green:hover { box-shadow: 0 6px 22px rgba(34,197,94,0.35); transform: translateY(-1px); }

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

[data-theme="dark"] .ev-stat.s-green::before { background: linear-gradient(90deg,transparent,#1FD57A,transparent); box-shadow: 0 0 8px rgba(31,213,122,.5); }
[data-theme="light"] .ev-stat.s-green::before { background: var(--green); height: 2px; box-shadow: none; opacity: .6; }

.ev-stat:hover { background: var(--bg-card-hov); border-color: var(--bdr-hi); box-shadow: var(--shadow); }

.ev-stat-ico {
    width: 40px; height: 40px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    transition: background .2s, color .2s;
}
.ev-stat-ico svg { width: 18px; height: 18px; }

[data-theme="dark"] .s-green .ev-stat-ico { background: rgba(31,213,122,.15); color: #86EFAC; }
[data-theme="light"] .s-green .ev-stat-ico { background: rgba(34,197,94,.1);  color: var(--green);  }

.ev-stat-val {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 1.6rem; font-weight: 700; letter-spacing: -.03em; line-height: 1;
    transition: color var(--dur);
}
[data-theme="dark"] .s-green  .ev-stat-val { color: #4ADE80; }
[data-theme="light"] .s-green  .ev-stat-val { color: #15803d; }

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
.tbl-search:focus-within { border-color: var(--green); box-shadow: 0 0 0 3px rgba(31,213,122,.15); }
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
[data-theme="dark"]  .tbl-badge { background: rgba(31,213,122,.12); border: 1px solid rgba(31,213,122,.25); color: #86EFAC; }
[data-theme="light"] .tbl-badge { background: rgba(34,197,94,.08); border: 1px solid rgba(34,197,94,.25); color: var(--green); }

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

.ev-table tbody tr:nth-child(1)  { animation-delay:.05s }
.ev-table tbody tr:nth-child(2)  { animation-delay:.08s }
.ev-table tbody tr:nth-child(3)  { animation-delay:.11s }
.ev-table tbody tr:nth-child(4)  { animation-delay:.14s }
.ev-table tbody tr:nth-child(5)  { animation-delay:.17s }

.ev-title-cell { display: flex; align-items: center; gap: 10px; }
.ev-icon {
    width: 34px; height: 34px; border-radius: 9px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    transition: background .2s, color .2s;
}
[data-theme="dark"]  .ev-icon { background: rgba(31,213,122,.12); color: #86EFAC; }
[data-theme="light"] .ev-icon { background: rgba(34,197,94,.08); color: var(--green); }
.ev-icon svg { width: 15px; height: 15px; }

.ev-title-text {
    font-weight: 600; color: var(--tx1);
    transition: color var(--dur);
}
.ev-title-sub {
    font-size: .69rem; color: var(--tx3); margin-top: 1px;
    transition: color var(--dur);
}

.unit-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 9px; border-radius: 20px;
    font-size: .7rem; font-weight: 600; white-space: nowrap;
    transition: all var(--dur);
}
[data-theme="dark"]  .unit-badge { background: rgba(139,92,246,.1); border: 1px solid rgba(139,92,246,.22); color: #C4B5FD; }
[data-theme="light"] .unit-badge { background: rgba(109,40,217,.08); border: 1px solid rgba(109,40,217,.22); color: var(--violet); }

.date-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 9px; border-radius: 7px;
    font-size: .74rem; font-weight: 500; white-space: nowrap;
    font-family: 'Space Grotesk', sans-serif;
    transition: all var(--dur);
}
[data-theme="dark"]  .date-badge { background: rgba(31,213,122,.1); border: 1px solid rgba(31,213,122,.18); color: #86EFAC; }
[data-theme="light"] .date-badge { background: rgba(34,197,94,.08); border: 1px solid rgba(34,197,94,.2); color: var(--green); }

.empty-state { text-align: center; padding: 4rem 2rem; }
.empty-state svg { width: 52px; height: 52px; margin: 0 auto 1rem; display: block; opacity: .3; color: var(--tx3); }
.empty-state p   { font-size: .9rem; margin-bottom: .4rem; color: var(--tx2); }
.empty-state span { font-size: .78rem; color: var(--tx3); }

.tbl-ft {
    padding: .8rem 1.4rem; border-top: 1px solid var(--bdr);
    display: flex; align-items: center; justify-content: space-between;
    font-size: .7rem; color: var(--tx3); flex-wrap: wrap; gap: .5rem;
    transition: border-color var(--dur), color var(--dur);
}

.act-row { display: flex; align-items: center; gap: .4rem; }
.act-btn {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 5px 11px; border-radius: 7px;
    font-size: .72rem; font-weight: 600; cursor: pointer;
    transition: all .2s; text-decoration: none; border: 1px solid transparent;
    font-family: 'Plus Jakarta Sans', sans-serif; white-space: nowrap;
    background: none;
}

[data-theme="dark"]  .act-btn-edit { background: rgba(31,213,122,.12); border-color: rgba(31,213,122,.22); color: #86EFAC; }
[data-theme="dark"]  .act-btn-edit:hover { background: rgba(31,213,122,.22); border-color: rgba(31,213,122,.4); color: #4ADE80; }
[data-theme="light"] .act-btn-edit { background: rgba(34,197,94,.08); border-color: rgba(34,197,94,.22); color: var(--green); }
[data-theme="light"] .act-btn-edit:hover { background: rgba(34,197,94,.18); border-color: rgba(34,197,94,.4); color: #15803d; }

[data-theme="dark"]  .act-btn-del { background: rgba(244,63,94,.1); border-color: rgba(244,63,94,.2); color: #FDA4AF; }
[data-theme="dark"]  .act-btn-del:hover { background: rgba(244,63,94,.2); border-color: rgba(244,63,94,.4); color: #FECDD3; }
[data-theme="light"] .act-btn-del { background: var(--rose-dim); border-color: rgba(190,18,60,.22); color: var(--rose); }
[data-theme="light"] .act-btn-del:hover { background: rgba(190,18,60,.18); border-color: rgba(190,18,60,.4); color: #881337; }

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
            <div class="pg-title">Approved Forms</div>
            <div class="pg-sub">View all approved forms and applications</div>
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
        <div class="ev-stat s-green">
            <div class="ev-stat-ico">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
            </div>
            <div>
                <div class="ev-stat-val">{{ $count }}</div>
                <div class="ev-stat-lbl">Approved Forms</div>
            </div>
        </div>
        <div class="ev-stat s-green" style="opacity: 0.5;">
            <div class="ev-stat-ico">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 8 12 12 15 15"/>
                </svg>
            </div>
            <div>
                <div class="ev-stat-val">—</div>
                <div class="ev-stat-lbl">Approval Rate</div>
            </div>
        </div>
        <div class="ev-stat s-green" style="opacity: 0.5;">
            <div class="ev-stat-ico">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 12h6m-6 4h6m2-8H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2z"/>
                </svg>
            </div>
            <div>
                <div class="ev-stat-val">—</div>
                <div class="ev-stat-lbl">Total Reviewed</div>
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
            <input type="text" id="evSearch" placeholder="Search approved forms…">
        </div>
        <span class="tbl-count" id="evCount">{{ $count }} form{{ $count !== 1 ? 's' : '' }}</span>
    </div>

    {{-- ── TABLE PANEL ── --}}
    <div class="tbl-panel">
        <div class="tbl-hd">
            <div class="tbl-ttl">Approved Forms</div>
            <span class="tbl-badge">{{ $count }} Total</span>
        </div>

        @if($count == 0)
        <div class="empty-state">
            <svg fill="none" stroke="currentColor" stroke-width="1.3" viewBox="0 0 24 24">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            <p>No approved forms yet</p>
            <span>Approved forms will appear here</span>
        </div>
        @endif
    </div>

</div>

<script>
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

        const countEl  = document.getElementById('evTableCount');
        const topCount = document.getElementById('evCount');
        if (countEl)  countEl.textContent  = q ? `Showing ${visible} of ${rows.length}` : `Showing ${rows.length}`;
        if (topCount) topCount.textContent = q ? `${visible} result${visible !== 1 ? 's' : ''}` : `${rows.length} form${rows.length !== 1 ? 's' : ''}`;
    }, 160);
});
</script>

@endsection
