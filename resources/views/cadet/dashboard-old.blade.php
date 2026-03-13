@extends('layouts.cadet')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<style>
.db-pending {
    background: rgba(245,158,11,.06);
    border: 1px solid rgba(245,158,11,.2);
    border-radius: var(--radius);
    padding: 2.5rem 2rem;
    text-align: center;
    max-width: 640px;
    margin: 4rem auto;
}
.db-pending-icon {
    width: 68px; height: 68px; border-radius: 18px;
    background: rgba(245,158,11,.1);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1.25rem;
}
.db-pending-icon svg { width: 34px; height: 34px; color: #FCD34D; }
.db-pending h2 {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 1.3rem; font-weight: 700; color: var(--t1);
    letter-spacing: -.02em; margin-bottom: .6rem;
}
.db-pending p { font-size: .85rem; color: var(--t2); line-height: 1.65; }

.db-rejected { border-color: rgba(244,63,94,.2); background: rgba(244,63,94,.05); }
.db-rejected .db-pending-icon { background: rgba(244,63,94,.1); }
.db-rejected .db-pending-icon svg { color: #FDA4AF; }

/* Dashboard cards */
.dstat-grid {
    display: grid;
    grid-template-columns: repeat(4,1fr);
    gap: 1.1rem;
    margin-bottom: 1.8rem;
}
.dsc {
    background: var(--c-card);
    border: 1px solid var(--c-border);
    border-radius: var(--radius);
    padding: 1.3rem 1.35rem;
    position: relative; overflow: hidden;
    transition: transform .28s, box-shadow .28s, border-color .28s;
    animation: fadeUp .4s ease both;
}
.dsc:hover { transform: translateY(-3px); border-color: var(--c-bordehi); }
.dsc::before {
    content:''; position:absolute;
    top:0; left:14%; right:14%; height:1px;
}
.dsc.blue::before  { background:linear-gradient(90deg,transparent,#3B82F6,transparent); box-shadow:0 0 8px rgba(59,130,246,.6); }
.dsc.green::before { background:linear-gradient(90deg,transparent,#22C55E,transparent); box-shadow:0 0 8px rgba(34,197,94,.6); }
.dsc.amber::before { background:linear-gradient(90deg,transparent,#F59E0B,transparent); box-shadow:0 0 8px rgba(245,158,11,.6); }
.dsc.violet::before{ background:linear-gradient(90deg,transparent,#8B5CF6,transparent); box-shadow:0 0 8px rgba(139,92,246,.6); }
.dsc.cyan::before  { background:linear-gradient(90deg,transparent,#06B6D4,transparent); box-shadow:0 0 8px rgba(6,182,212,.6); }

.dsc-label { font-size:.62rem; font-weight:700; text-transform:uppercase; letter-spacing:.1em; color:var(--t3); margin-bottom:.9rem; }
.dsc-val {
    font-family:'Space Grotesk',sans-serif;
    font-size:2rem; font-weight:700; letter-spacing:-.04em;
    line-height:1; margin-bottom:.35rem;
}
.blue .dsc-val  { color:#BFDBFE; }
.green .dsc-val { color:#BBF7D0; }
.amber .dsc-val { color:#FDE68A; }
.violet .dsc-val{ color:#DDD6FE; }
.cyan .dsc-val  { color:#A5F3FC; }
.dsc-sub { font-size:.72rem; color:var(--t3); }

@keyframes fadeUp {
    from { opacity:0; transform: translateY(14px); }
    to   { opacity:1; transform: translateY(0); }
}
.dsc:nth-child(1){animation-delay:.04s}
.dsc:nth-child(2){animation-delay:.09s}
.dsc:nth-child(3){animation-delay:.14s}
.dsc:nth-child(4){animation-delay:.19s}
.dsc:nth-child(5){animation-delay:.24s}

/* 2-pane grid */
.db-grid2 { display:grid; grid-template-columns:1.4fr 1fr; gap:1.1rem; margin-bottom:1.8rem; }
.db-grid3 { display:grid; grid-template-columns:1fr 1fr 1.1fr; gap:1.1rem; }

.sec-hd {
    display:flex; align-items:center; gap:10px; margin-bottom:.85rem;
}
.sec-hd-label {
    font-size:.62rem; font-weight:700; text-transform:uppercase;
    letter-spacing:.12em; color:var(--t3); white-space:nowrap;
}
.sec-hd::after { content:''; flex:1; height:1px; background:var(--c-border); }

.panel {
    background:var(--c-card); border:1px solid var(--c-border);
    border-radius:var(--radius); padding:1.25rem;
    animation:fadeUp .4s ease .28s both;
}
.panel-ttl { font-family:'Space Grotesk',sans-serif; font-size:.9rem; font-weight:600; color:var(--t1); letter-spacing:-.01em; }
.panel-sub { font-size:.7rem; color:var(--t3); margin-top:2px; margin-bottom:1.1rem; }

/* Events list */
.ev-item {
    display:flex; align-items:center; gap:.75rem;
    padding:.65rem .5rem;
    border-bottom:1px solid var(--c-border);
    transition: background .18s;
    border-radius: 8px;
}
.ev-item:last-child { border-bottom:none; }
.ev-item:hover { background:var(--c-card); }
.ev-dot {
    width:36px; height:36px; border-radius:9px; flex-shrink:0;
    background:rgba(59,130,246,.12);
    display:flex; align-items:center; justify-content:center;
}
.ev-dot svg { width:16px; height:16px; color:#93C5FD; }
.ev-name { font-size:.8rem; font-weight:500; color:var(--t1); }
.ev-date { font-size:.69rem; color:var(--t3); margin-top:1px; }
.ev-empty { font-size:.8rem; color:var(--t3); text-align:center; padding:1.5rem; }

/* Activity table */
.act-table { width:100%; border-collapse:collapse; }
.act-table thead tr { border-bottom:1px solid var(--c-border); }
.act-table thead th { padding:.55rem .8rem; font-size:.62rem; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:var(--t3); text-align:left; white-space:nowrap; }
.act-table tbody tr { border-bottom:1px solid rgba(255,255,255,.04); transition:background .18s; }
.act-table tbody tr:last-child { border-bottom:none; }
.act-table tbody tr:hover { background:rgba(255,255,255,.025); }
.act-table tbody td { padding:.7rem .8rem; font-size:.79rem; color:var(--t2); }

@media(max-width:1200px) {
    .dstat-grid { grid-template-columns:repeat(2,1fr); }
    .db-grid2, .db-grid3 { grid-template-columns:1fr; }
}
@media(max-width:640px) {
    .dstat-grid { grid-template-columns:1fr; }
}
</style>
@endpush

@section('content')

{{-- ─── PENDING STATE ─────────────────────────────────────────────────── --}}
@if($cadet->isPending())
<div class="db-pending" style="animation:fadeUp .5s ease both;">
    <div class="db-pending-icon">
        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"/>
            <polyline points="12 6 12 12 16 14"/>
        </svg>
    </div>
    <h2>Enrollment Under Review</h2>
    <p>
        Your NCC enrollment request has been submitted successfully.<br>
        Please wait for admin approval to access full dashboard features.<br><br>
        <strong style="color:var(--t1);">Enrollment No:</strong>
        <span style="color:#FCD34D;">{{ $cadet->enrollment_no }}</span>
    </p>
    <div style="margin-top:1.5rem;">
        <span class="spill pending"><span class="spill-dot"></span> Pending Approval</span>
    </div>
</div>

{{-- ─── REJECTED STATE ──────────────────────────────────────────────────── --}}
@elseif($cadet->isRejected())
<div class="db-pending db-rejected" style="animation:fadeUp .5s ease both;">
    <div class="db-pending-icon">
        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"/>
            <line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
        </svg>
    </div>
    <h2>Application Rejected</h2>
    <p>
        Unfortunately, your NCC enrollment has been rejected by the admin.<br>
        @if($cadet->rejection_reason)
            <br><strong style="color:var(--t1);">Reason:</strong>
            <span style="color:#FDA4AF;">{{ $cadet->rejection_reason }}</span>
        @endif
        <br><br>
        Please contact your NCC unit officer for more information.
    </p>
    <div style="margin-top:1.5rem;">
        <span class="spill rejected"><span class="spill-dot"></span> Application Rejected</span>
    </div>
</div>

{{-- ─── APPROVED / FULL DASHBOARD ──────────────────────────────────────── --}}
@else
@php
    $totalEvents   = $stats['totalEvents'] ?? 0;
    $attended      = $stats['attended'] ?? 0;
    $attendancePct = $stats['attendancePct'] ?? 0;
    $upcoming      = $stats['upcomingEvents'] ?? collect();
    $activity      = $stats['recentActivity'] ?? collect();
@endphp

{{-- Stat Cards --}}
<div class="sec-hd"><span class="sec-hd-label">Overview</span></div>
<div class="dstat-grid">

    <div class="dsc blue">
        <div class="dsc-label">Total Events</div>
        <div class="dsc-val">{{ $totalEvents }}</div>
        <div class="dsc-sub">Scheduled events</div>
    </div>

    <div class="dsc green">
        <div class="dsc-label">Events Attended</div>
        <div class="dsc-val">{{ $attended }}</div>
        <div class="dsc-sub">Confirmed attendance</div>
    </div>

    <div class="dsc amber">
        <div class="dsc-label">Attendance %</div>
        <div class="dsc-val">{{ $attendancePct }}%</div>
        <div class="dsc-sub">Overall rate</div>
    </div>

    <div class="dsc violet">
        <div class="dsc-label">Assigned Unit</div>
        <div class="dsc-val" style="font-size:1.1rem;margin-top:.25rem;">{{ $cadet->unit?->unit_name ?? '—' }}</div>
        <div class="dsc-sub">{{ $cadet->unit?->battalion ?? 'Not assigned' }}</div>
    </div>

    <div class="dsc cyan" style="grid-column:span 4 / span 4;">
        <div class="dsc-label">Upcoming Training Events</div>
        <div class="dsc-val">{{ $upcoming->count() }}</div>
        <div class="dsc-sub">Events in the pipeline</div>
    </div>

</div>

{{-- Upcoming Events + Recent Activity --}}
<div class="sec-hd"><span class="sec-hd-label">At a Glance</span></div>
<div class="db-grid2">

    {{-- Upcoming Events --}}
    <div class="panel">
        <div class="panel-ttl">Upcoming Events</div>
        <div class="panel-sub">Next scheduled activities</div>
        @forelse($upcoming as $ev)
        <div class="ev-item">
            <div class="ev-dot">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
            </div>
            <div>
                <div class="ev-name">{{ $ev->title }}</div>
                <div class="ev-date">{{ $ev->event_date->format('d M Y') }}</div>
            </div>
        </div>
        @empty
        <div class="ev-empty">No upcoming events right now.</div>
        @endforelse
    </div>

    {{-- Cadet Info Summary --}}
    <div class="panel">
        <div class="panel-ttl">My Info</div>
        <div class="panel-sub">Quick profile summary</div>
        @php
            $rows = [
                ['Rank',  $cadet->rank ?? '—', '#93C5FD'],
                ['Unit',  $cadet->unit?->unit_name ?? '—', '#86EFAC'],
                ['Course',$cadet->course ?? '—', '#FCD34D'],
                ['Gender',ucfirst($cadet->gender ?? '—'), '#C4B5FD'],
            ];
        @endphp
        @foreach($rows as [$label, $value, $color])
        <div style="display:flex;justify-content:space-between;align-items:center;padding:.55rem 0;border-bottom:1px solid var(--c-border);">
            <span style="font-size:.77rem;color:var(--t3);">{{ $label }}</span>
            <span style="font-size:.79rem;font-weight:600;color:{{ $color }};">{{ $value }}</span>
        </div>
        @endforeach
        <a href="{{ route('cadet.profile') }}" style="display:inline-flex;align-items:center;gap:5px;margin-top:1rem;font-size:.75rem;color:#93C5FD;text-decoration:none;font-weight:600;">
            View Full Profile
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
    </div>

</div>

{{-- Recent Attendance Activity --}}
<div class="sec-hd"><span class="sec-hd-label">Recent Activity</span></div>
<div class="panel">
    <div class="panel-ttl">Latest Attendance Records</div>
    <div class="panel-sub">Your last 5 event attendances</div>
    <div style="overflow-x:auto;">
        <table class="act-table">
            <thead>
                <tr>
                    <th>Event</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activity as $rec)
                <tr>
                    <td style="color:var(--t1);font-weight:500;">{{ $rec->event?->title ?? '—' }}</td>
                    <td>{{ $rec->event?->event_date ? \Carbon\Carbon::parse($rec->event->event_date)->format('d M Y') : '—' }}</td>
                    <td>
                        <span class="spill {{ $rec->status }}">
                            <span class="spill-dot"></span>
                            {{ ucfirst($rec->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="text-align:center;padding:2rem;color:var(--t3);font-size:.8rem;">No attendance records yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endif

@endsection