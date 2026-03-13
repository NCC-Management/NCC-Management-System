@extends('layouts.cadet-new')

@section('title', 'Events')
@section('page-title', 'My Events')

@push('styles')
<style>
.ev-tabs { display:flex; gap:.5rem; margin-bottom:1.5rem; }
.ev-tab {
    padding:.5rem 1.1rem; border-radius:8px;
    font-size:.78rem; font-weight:600;
    border:1px solid var(--c-border); background:var(--c-card);
    color:var(--t2); cursor:pointer; transition:all .18s;
    font-family:'Plus Jakarta Sans',sans-serif;
}
.ev-tab.active { background:rgba(59,130,246,.12); border-color:rgba(59,130,246,.3); color:#93C5FD; }

.ev-pane { display:none; }
.ev-pane.active { display:grid; grid-template-columns:repeat(auto-fill,minmax(290px,1fr)); gap:1.1rem; }

.ev-card {
    background:var(--c-card); border:1px solid var(--c-border);
    border-radius:var(--radius); padding:1.3rem;
    transition:all .22s; animation:fadeUp .4s ease both;
}
.ev-card:hover { border-color:var(--c-bordehi); transform:translateY(-2px); }

.ev-card-header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:.85rem; }
.ev-card-date {
    font-size:.65rem; font-weight:700; text-transform:uppercase;
    letter-spacing:.1em; color:var(--t3);
    background:rgba(255,255,255,.06); border:1px solid var(--c-border);
    padding:3px 8px; border-radius:6px;
}
.ev-card-title {
    font-family:'Space Grotesk',sans-serif;
    font-size:.95rem; font-weight:600; color:var(--t1);
    margin-bottom:.45rem; letter-spacing:-.01em;
}
.ev-card-desc { font-size:.78rem; color:var(--t2); line-height:1.55; }

.ev-empty {
    background:var(--c-card); border:1px solid var(--c-border);
    border-radius:var(--radius); padding:3rem; text-align:center;
    color:var(--t3); font-size:.82rem;
    grid-column: 1 / -1;
}
</style>
@endpush

@push('scripts')
<script>
function showTab(tabId) {
    document.querySelectorAll('.ev-pane').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.ev-tab').forEach(t => t.classList.remove('active'));
    document.getElementById(tabId).classList.add('active');
    document.querySelector('[data-tab="'+tabId+'"]').classList.add('active');
}
</script>
@endpush

@section('content')

<div class="ev-tabs">
    <button class="ev-tab active" data-tab="upcoming" onclick="showTab('upcoming')">Upcoming Events</button>
    <button class="ev-tab" data-tab="past" onclick="showTab('past')">Past Events</button>
</div>

{{-- Upcoming --}}
<div class="ev-pane active" id="upcoming">
    @forelse($upcomingEvents as $i => $ev)
    <div class="ev-card" style="animation-delay:{{ $i * 0.06 }}s;">
        <div class="ev-card-header">
            <span class="spill approved"><span class="spill-dot"></span>Upcoming</span>
            <span class="ev-card-date">{{ $ev->event_date->format('d M Y') }}</span>
        </div>
        <div class="ev-card-title">{{ $ev->title }}</div>
        <div class="ev-card-desc">{{ $ev->description ?: 'No description provided.' }}</div>
        @if(in_array($ev->id, $attendedIds))
        <div style="margin-top:.85rem;">
            <span class="spill approved"><span class="spill-dot"></span>Attended</span>
        </div>
        @endif
    </div>
    @empty
    <div class="ev-empty">No upcoming events scheduled.</div>
    @endforelse
</div>

{{-- Past --}}
<div class="ev-pane" id="past">
    @forelse($pastEvents as $i => $ev)
    <div class="ev-card" style="animation-delay:{{ $i * 0.06 }}s;">
        <div class="ev-card-header">
            <span class="spill {{ in_array($ev->id, $attendedIds) ? 'approved' : 'rejected' }}">
                <span class="spill-dot"></span>{{ in_array($ev->id, $attendedIds) ? 'Attended' : 'Missed' }}
            </span>
            <span class="ev-card-date">{{ $ev->event_date->format('d M Y') }}</span>
        </div>
        <div class="ev-card-title">{{ $ev->title }}</div>
        <div class="ev-card-desc">{{ $ev->description ?: 'No description provided.' }}</div>
    </div>
    @empty
    <div class="ev-empty">No past events yet.</div>
    @endforelse
</div>

@endsection
