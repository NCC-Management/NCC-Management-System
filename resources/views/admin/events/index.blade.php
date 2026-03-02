@extends('layouts.admin')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">

<style>
.ep *, .ep *::before, .ep *::after { box-sizing: border-box; }

:root {
    --bg:      #060C1A;
    --card:    rgba(255,255,255,0.038);
    --cardh:   rgba(255,255,255,0.065);
    --border:  rgba(255,255,255,0.07);
    --bordehi: rgba(255,255,255,0.13);
    --blue:  #3B82F6;
    --green: #22C55E;
    --rose:  #F43F5E;
    --amber: #F59E0B;
    --violet:#8B5CF6;
    --t1: #F1F5F9;
    --t2: #94A3B8;
    --t3: #475569;
    --r: 14px;
}

.ep {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: var(--bg);
    min-height: 100vh;
    color: var(--t1);
    padding: 1.8rem 2rem 5rem;
    position: relative;
    overflow-x: hidden;
}

.ep::before {
    content: '';
    position: fixed; inset: 0; pointer-events: none; z-index: 0;
    background:
        radial-gradient(ellipse 80% 50% at 15% -5%,  rgba(245,158,11,0.07) 0%, transparent 55%),
        radial-gradient(ellipse 55% 45% at 85% 105%, rgba(139,92,246,0.07) 0%, transparent 55%);
}
.ep > * { position: relative; z-index: 1; }

/* ── PAGE BAR ── */
.pg-bar {
    display: flex; align-items: flex-start; justify-content: space-between;
    flex-wrap: wrap; gap: .75rem; margin-bottom: 1.8rem;
}
.pg-title {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 1.55rem; font-weight: 700;
    color: var(--t1); letter-spacing: -.03em; line-height: 1.2;
}
.pg-sub { font-size: .79rem; color: var(--t2); margin-top: 3px; }

.btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 16px; border-radius: 10px;
    font-size: .8rem; font-weight: 600; cursor: pointer;
    transition: all .2s; font-family: 'Plus Jakarta Sans', sans-serif;
    text-decoration: none; border: none; white-space: nowrap;
}
.btn-green {
    background: linear-gradient(135deg, #16A34A, #22C55E);
    border: 1px solid rgba(34,197,94,0.4);
    color: #fff;
    box-shadow: 0 4px 16px rgba(34,197,94,0.22);
}
.btn-green:hover { box-shadow: 0 6px 22px rgba(34,197,94,0.35); transform: translateY(-1px); color: #fff; }

/* ── ALERT ── */
.alert-success {
    display: flex; align-items: center; gap: 10px;
    padding: .85rem 1.2rem;
    background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.25);
    border-radius: 10px; font-size: .82rem; color: #86EFAC;
    margin-bottom: 1.5rem; animation: fadeUp .4s ease both;
}
.alert-success svg { width: 16px; height: 16px; flex-shrink: 0; }

/* ── STATS ROW ── */
.ev-stats {
    display: grid; grid-template-columns: repeat(3, 1fr);
    gap: 1rem; margin-bottom: 1.8rem;
    animation: fadeUp .4s ease .05s both;
}

.ev-stat {
    background: var(--card); border: 1px solid var(--border);
    border-radius: var(--r); padding: 1.1rem 1.3rem;
    display: flex; align-items: center; gap: .9rem;
    transition: all .2s;
    position: relative; overflow: hidden;
}
.ev-stat::before {
    content: ''; position: absolute; top: 0; left: 14%; right: 14%; height: 1px;
}
.ev-stat.s-amber::before { background: linear-gradient(90deg,transparent,#F59E0B,transparent); box-shadow: 0 0 8px rgba(245,158,11,.5); }
.ev-stat.s-blue::before  { background: linear-gradient(90deg,transparent,#3B82F6,transparent); box-shadow: 0 0 8px rgba(59,130,246,.5); }
.ev-stat.s-violet::before{ background: linear-gradient(90deg,transparent,#8B5CF6,transparent); box-shadow: 0 0 8px rgba(139,92,246,.5); }
.ev-stat:hover { background: var(--cardh); border-color: var(--bordehi); }

.ev-stat-ico { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.ev-stat-ico svg { width: 18px; height: 18px; }
.s-amber .ev-stat-ico { background: rgba(245,158,11,.15); color: #FCD34D; }
.s-blue  .ev-stat-ico { background: rgba(59,130,246,.15);  color: #93C5FD; }
.s-violet .ev-stat-ico { background: rgba(139,92,246,.15); color: #C4B5FD; }

.ev-stat-val {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 1.6rem; font-weight: 700; letter-spacing: -.03em; line-height: 1;
}
.s-amber  .ev-stat-val { color: #FDE68A; }
.s-blue   .ev-stat-val { color: #BFDBFE; }
.s-violet .ev-stat-val { color: #DDD6FE; }
.ev-stat-lbl { font-size: .72rem; color: var(--t2); margin-top: 3px; }

/* ── SEARCH / FILTER BAR ── */
.tbl-controls {
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: .6rem; margin-bottom: 1rem;
}

.tbl-search {
    display: flex; align-items: center; gap: 8px;
    background: var(--card); border: 1px solid var(--border);
    border-radius: 9px; padding: 7px 13px; transition: border-color .2s;
}
.tbl-search:focus-within { border-color: var(--bordehi); }
.tbl-search input {
    background: transparent; border: none; outline: none;
    font-size: .79rem; color: var(--t1);
    font-family: 'Plus Jakarta Sans', sans-serif; width: 200px;
}
.tbl-search input::placeholder { color: var(--t3); }
.tbl-search svg { width: 14px; height: 14px; color: var(--t3); flex-shrink: 0; }

.tbl-count { font-size: .74rem; color: var(--t3); }

/* ── TABLE PANEL ── */
.tbl-panel {
    background: var(--card); border: 1px solid var(--border);
    border-radius: var(--r); overflow: hidden;
    animation: fadeUp .4s ease .1s both;
}

.tbl-hd {
    padding: 1rem 1.4rem; border-bottom: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: .5rem;
}
.tbl-ttl { font-family: 'Space Grotesk', sans-serif; font-size: .9rem; font-weight: 600; color: var(--t1); }
.tbl-badge {
    padding: 3px 9px; border-radius: 20px;
    background: rgba(245,158,11,.12); border: 1px solid rgba(245,158,11,.25);
    font-size: .66rem; font-weight: 700; letter-spacing: .07em; text-transform: uppercase; color: #FCD34D;
}

.ev-table { width: 100%; border-collapse: collapse; }
.ev-table thead tr { border-bottom: 1px solid var(--border); }
.ev-table thead th {
    padding: .7rem 1.4rem; font-size: .64rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .09em; color: var(--t3);
    text-align: left; white-space: nowrap;
}
.ev-table tbody tr {
    border-bottom: 1px solid rgba(255,255,255,.04);
    transition: background .18s;
    animation: fadeUp .35s ease both;
}
.ev-table tbody tr:last-child { border-bottom: none; }
.ev-table tbody tr:hover { background: rgba(255,255,255,.028); }
.ev-table tbody td { padding: .95rem 1.4rem; font-size: .81rem; color: var(--t2); vertical-align: middle; }

/* Row stagger */
.ev-table tbody tr:nth-child(1)  { animation-delay: .05s }
.ev-table tbody tr:nth-child(2)  { animation-delay: .08s }
.ev-table tbody tr:nth-child(3)  { animation-delay: .11s }
.ev-table tbody tr:nth-child(4)  { animation-delay: .14s }
.ev-table tbody tr:nth-child(5)  { animation-delay: .17s }
.ev-table tbody tr:nth-child(6)  { animation-delay: .20s }
.ev-table tbody tr:nth-child(7)  { animation-delay: .23s }
.ev-table tbody tr:nth-child(8)  { animation-delay: .26s }

/* Title cell */
.ev-title-cell { display: flex; align-items: center; gap: 10px; }
.ev-icon {
    width: 34px; height: 34px; border-radius: 9px;
    background: rgba(245,158,11,.12);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    color: #FCD34D;
}
.ev-icon svg { width: 15px; height: 15px; }
.ev-title-text { font-weight: 600; color: var(--t1); }
.ev-title-sub { font-size: .69rem; color: var(--t3); margin-top: 1px; }

/* Unit badge */
.unit-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 9px; border-radius: 20px;
    background: rgba(139,92,246,.1); border: 1px solid rgba(139,92,246,.22);
    font-size: .7rem; font-weight: 600; color: #C4B5FD; white-space: nowrap;
}

/* Date badge */
.date-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 9px; border-radius: 7px;
    background: rgba(59,130,246,.1); border: 1px solid rgba(59,130,246,.18);
    font-size: .74rem; font-weight: 500; color: #93C5FD; white-space: nowrap;
    font-family: 'Space Grotesk', sans-serif;
}

/* Description */
.desc-text {
    max-width: 260px;
    overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    font-size: .78rem; color: var(--t3);
}

/* Action buttons */
.act-row { display: flex; align-items: center; gap: .4rem; }

.act-btn {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 5px 11px; border-radius: 7px;
    font-size: .72rem; font-weight: 600; cursor: pointer;
    transition: all .2s; text-decoration: none; border: none;
    font-family: 'Plus Jakarta Sans', sans-serif; white-space: nowrap;
}
.act-btn-edit {
    background: rgba(59,130,246,.12); border: 1px solid rgba(59,130,246,.22);
    color: #93C5FD;
}
.act-btn-edit:hover { background: rgba(59,130,246,.22); border-color: rgba(59,130,246,.4); color: #BFDBFE; }

.act-btn-del {
    background: rgba(244,63,94,.1); border: 1px solid rgba(244,63,94,.2);
    color: #FDA4AF;
}
.act-btn-del:hover { background: rgba(244,63,94,.2); border-color: rgba(244,63,94,.4); color: #FECDD3; }

/* ── EMPTY STATE ── */
.empty-state {
    text-align: center; padding: 4rem 2rem;
    color: var(--t3);
}
.empty-state svg {
    width: 52px; height: 52px;
    margin: 0 auto 1rem; display: block; opacity: .3;
}
.empty-state p { font-size: .9rem; margin-bottom: .4rem; color: var(--t2); }
.empty-state span { font-size: .78rem; color: var(--t3); }

/* ── TABLE FOOTER ── */
.tbl-ft {
    padding: .8rem 1.4rem; border-top: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
    font-size: .7rem; color: var(--t3); flex-wrap: wrap; gap: .5rem;
}

/* ── DELETE CONFIRM MODAL ── */
.modal-overlay {
    position: fixed; inset: 0; z-index: 1000;
    background: rgba(0,0,0,0.7); backdrop-filter: blur(6px);
    display: flex; align-items: center; justify-content: center;
    padding: 1rem;
    opacity: 0; pointer-events: none; transition: opacity .25s;
}
.modal-overlay.open { opacity: 1; pointer-events: all; }

.modal-box {
    background: #0D1627; border: 1px solid var(--bordehi);
    border-radius: 16px; padding: 2rem;
    max-width: 400px; width: 100%;
    transform: scale(.95); transition: transform .25s;
}
.modal-overlay.open .modal-box { transform: scale(1); }

.modal-icon {
    width: 52px; height: 52px; border-radius: 14px;
    background: rgba(244,63,94,.12); border: 1px solid rgba(244,63,94,.25);
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 1.2rem;
}
.modal-icon svg { width: 24px; height: 24px; color: #FDA4AF; }

.modal-title {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 1.1rem; font-weight: 700; color: var(--t1); margin-bottom: .5rem;
}
.modal-body { font-size: .82rem; color: var(--t2); line-height: 1.6; margin-bottom: 1.5rem; }
.modal-event-name { font-weight: 600; color: var(--t1); }

.modal-actions { display: flex; gap: .6rem; justify-content: flex-end; }
.modal-cancel {
    padding: 8px 16px; border-radius: 9px;
    background: var(--card); border: 1px solid var(--border);
    font-size: .8rem; font-weight: 500; color: var(--t2);
    cursor: pointer; transition: all .2s; font-family: 'Plus Jakarta Sans', sans-serif;
}
.modal-cancel:hover { background: var(--cardh); color: var(--t1); }
.modal-confirm {
    padding: 8px 16px; border-radius: 9px;
    background: linear-gradient(135deg, #BE123C, #F43F5E);
    border: 1px solid rgba(244,63,94,.4);
    font-size: .8rem; font-weight: 600; color: #fff;
    cursor: pointer; transition: all .2s; font-family: 'Plus Jakarta Sans', sans-serif;
    box-shadow: 0 4px 14px rgba(244,63,94,.25);
}
.modal-confirm:hover { box-shadow: 0 6px 20px rgba(244,63,94,.4); transform: translateY(-1px); }

/* ── SCROLLBAR ── */
::-webkit-scrollbar { width: 4px; height: 4px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: rgba(255,255,255,.09); border-radius: 99px; }

/* ── ANIMATION ── */
@keyframes fadeUp {
    from { opacity:0; transform:translateY(14px); }
    to   { opacity:1; transform:translateY(0); }
}

/* ── RESPONSIVE ── */
@media(max-width:900px) {
    .ep { padding: 1.2rem 1.1rem 4rem; }
    .ev-stats { grid-template-columns: 1fr 1fr; }
    .tbl-search input { width: 140px; }
    .desc-text { max-width: 150px; }
}
@media(max-width:600px) {
    .ev-stats { grid-template-columns: 1fr; }
    .pg-title { font-size: 1.3rem; }
    .ev-table thead th:nth-child(4),
    .ev-table tbody td:nth-child(4) { display: none; } /* hide description on mobile */
}
</style>

@php
    $total    = $events->count();
    $upcoming = $events->filter(fn($e) => \Carbon\Carbon::parse($e->event_date)->isFuture())->count();
    $past     = $total - $upcoming;
@endphp

<div class="ep">

    {{-- ── DELETE CONFIRM MODAL ── --}}
    <div class="modal-overlay" id="delModal">
        <div class="modal-box">
            <div class="modal-icon">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>
                </svg>
            </div>
            <div class="modal-title">Delete Event</div>
            <div class="modal-body">
                Are you sure you want to delete <span class="modal-event-name" id="delEventName"></span>?
                This action cannot be undone.
            </div>
            <div class="modal-actions">
                <button class="modal-cancel" onclick="closeModal()">Cancel</button>
                <form id="delForm" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="modal-confirm">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>

    {{-- ── PAGE BAR ── --}}
    <div class="pg-bar">
        <div>
            <div class="pg-title">Events Management</div>
            <div class="pg-sub">Manage and schedule NCC cadet events</div>
        </div>
        <a href="{{ route('events.create') }}" class="btn btn-green">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add Event
        </a>
    </div>

    {{-- ── SUCCESS ALERT ── --}}
    @if(session('success'))
    <div class="alert-success">
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- ── STATS ── --}}
    <div class="ev-stats">
        <div class="ev-stat s-amber">
            <div class="ev-stat-ico">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <div class="ev-stat-val">{{ $total }}</div>
                <div class="ev-stat-lbl">Total Events</div>
            </div>
        </div>
        <div class="ev-stat s-blue">
            <div class="ev-stat-ico">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <div class="ev-stat-val">{{ $upcoming }}</div>
                <div class="ev-stat-lbl">Upcoming Events</div>
            </div>
        </div>
        <div class="ev-stat s-violet">
            <div class="ev-stat-ico">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            </div>
            <div>
                <div class="ev-stat-val">{{ $past }}</div>
                <div class="ev-stat-lbl">Completed Events</div>
            </div>
        </div>
    </div>

    {{-- ── SEARCH BAR ── --}}
    <div class="tbl-controls">
        <div class="tbl-search">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" id="evSearch" placeholder="Search events, units…">
        </div>
        <span class="tbl-count" id="evCount">{{ $total }} event{{ $total !== 1 ? 's' : '' }}</span>
    </div>

    {{-- ── TABLE PANEL ── --}}
    <div class="tbl-panel">
        <div class="tbl-hd">
            <div class="tbl-ttl">All Events</div>
            <span class="tbl-badge">{{ $total }} Total</span>
        </div>

        @if($events->count() == 0)
        <div class="empty-state">
            <svg fill="none" stroke="currentColor" stroke-width="1.3" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            <p>No events created yet</p>
            <span>Click "Add Event" to create your first event</span>
        </div>
        @else

        <div style="overflow-x:auto;">
            <table class="ev-table" id="evTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Event</th>
                        <th>Unit</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $i => $event)
                    <tr>
                        <td style="color:var(--t3); font-variant-numeric:tabular-nums; font-size:.75rem;">
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            <div class="ev-title-cell">
                                <div class="ev-icon">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                </div>
                                <div>
                                    <div class="ev-title-text">{{ $event->title }}</div>
                                    <div class="ev-title-sub">ID #{{ $event->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="unit-badge">
                                <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                                {{ $event->unit->unit_name ?? 'N/A' }}
                            </span>
                        </td>
                        <td>
                            <span class="date-badge">
                                {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
                            </span>
                        </td>
                        <td>
                            <div class="desc-text" title="{{ $event->description }}">
                                {{ $event->description ?? '—' }}
                            </div>
                        </td>
                        <td>
                            <div class="act-row">
                                <a href="{{ route('events.edit', $event->id) }}" class="act-btn act-btn-edit">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    Edit
                                </a>
                                <button
                                    class="act-btn act-btn-del"
                                    onclick="openDeleteModal('{{ addslashes($event->title) }}', '{{ route('events.destroy', $event->id) }}')"
                                >
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="tbl-ft">
            <span id="evTableCount">Showing {{ $events->count() }} events</span>
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
                noRes.innerHTML = `<td colspan="6" style="text-align:center;padding:2.5rem;color:var(--t3);font-size:.82rem;">No events matching "<strong style='color:var(--t2)'>${q}</strong>"</td>`;
                document.querySelector('#evTable tbody').appendChild(noRes);
            }
        } else if (noRes) noRes.remove();

        const countEl = document.getElementById('evTableCount');
        const topCount = document.getElementById('evCount');
        if (countEl) countEl.textContent = q ? `Showing ${visible} of ${rows.length} events` : `Showing ${rows.length} events`;
        if (topCount) topCount.textContent = q ? `${visible} result${visible !== 1 ? 's' : ''}` : `${rows.length} event${rows.length !== 1 ? 's' : ''}`;
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

// Close on backdrop click
document.getElementById('delModal').addEventListener('click', function (e) {
    if (e.target === this) closeModal();
});
// make delete modal go full-screen on small viewports
(function () {
    const delModal = document.getElementById('delModal');
    if (!delModal) return;
    const mql = window.matchMedia('(max-width:600px)');

    // inject responsive CSS for modal when in "mobile" mode
    const cssId = 'modal-mobile-css';
    if (!document.getElementById(cssId)) {
        const style = document.createElement('style');
        style.id = cssId;
        style.textContent = `
            /* mobile: full screen modal */
            .modal-overlay.mobile { align-items: flex-end; padding: 0; }
            .modal-overlay.mobile .modal-box {
                width: 100% !important;
                height: 100% !important;
                max-width: none !important;
                border-radius: 0 !important;
                padding: 1rem !important;
                box-sizing: border-box;
                overflow: auto;
                transform: none !important;
            }
            /* ensure modal icon/title spacing works on small screens */
            .modal-overlay.mobile .modal-box .modal-actions { flex-wrap: wrap; gap: .5rem; }
        `;
        document.head.appendChild(style);
    }

    // toggle mobile class based on media query
    function updateMobileState(e) {
        const matches = e.matches ?? mql.matches;
        if (matches) delModal.classList.add('mobile');
        else delModal.classList.remove('mobile');
    }

    // initial sync and listener
    updateMobileState(mql);
    if (mql.addEventListener) mql.addEventListener('change', updateMobileState);
    else if (mql.addListener) mql.addListener(updateMobileState);

    // when modal opens, ensure body doesn't scroll behind on mobile
    const observer = new MutationObserver(() => {
        if (delModal.classList.contains('open')) {
            document.documentElement.style.overflow = 'hidden';
            document.body.style.overflow = 'hidden';
        } else {
            document.documentElement.style.overflow = '';
            document.body.style.overflow = '';
        }
    });
    observer.observe(delModal, { attributes: true, attributeFilter: ['class'] });

    // cleanup on page unload
    window.addEventListener('unload', () => {
        if (mql.removeEventListener) mql.removeEventListener('change', updateMobileState);
        else if (mql.removeListener) mql.removeListener(updateMobileState);
        observer.disconnect();
    });
})();
// Close on Escape
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });
</script>

@endsection