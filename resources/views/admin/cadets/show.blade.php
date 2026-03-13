@extends('layouts.admin')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">

<style>
.sd-wrap *, .sd-wrap *::before, .sd-wrap *::after { box-sizing: border-box; }

.sd-wrap {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: #060C1A;
    min-height: calc(100vh - 68px);
    color: #F1F5F9;
    padding: 1.75rem 2rem 4rem;
}

:root {
    --c-bg:      #060C1A;
    --c-surf:    #0D1627;
    --c-card:    rgba(255,255,255,0.038);
    --c-cardhov: rgba(255,255,255,0.065);
    --c-border:  rgba(255,255,255,0.07);
    --t1: #F1F5F9; --t2: #94A3B8; --t3: #475569;
    --radius: 14px;
}

@keyframes fadeUp { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:translateY(0)} }

.pg-bar {
    display:flex; align-items:center; justify-content:space-between;
    flex-wrap:wrap; gap:.75rem; margin-bottom:1.75rem;
}
.pg-title {
    font-family:'Space Grotesk',sans-serif;
    font-size:1.45rem; font-weight:700; color:var(--t1); letter-spacing:-.03em;
}
.pg-sub { font-size:.78rem; color:var(--t2); margin-top:2px; }

.btn-back {
    padding:.55rem 1.1rem; border-radius:8px; display:inline-flex; align-items:center; gap:6px;
    background:var(--c-card); border:1px solid var(--c-border); color:var(--t2);
    font-size:.8rem; font-weight:500; text-decoration:none; transition:all .18s;
}
.btn-back:hover { background:var(--c-cardhov); color:var(--t1); }

/* Panels */
.sd-panel {
    background:var(--c-card); border:1px solid var(--c-border);
    border-radius:var(--radius); padding:1.75rem;
    animation:fadeUp .4s ease both;
    margin-bottom: 1.5rem;
}

/* Grid layout */
.sd-grid { display:grid; grid-template-columns:1fr 2fr; gap:2rem; }

/* Profile Column */
.dp-card { text-align:center; padding-right:2rem; border-right:1px solid var(--c-border); }
.dp-img-box {
    width:140px; height:140px; border-radius:18px; margin:0 auto 1.25rem;
    background:var(--c-surf); border:2px solid var(--c-border);
    display:flex; align-items:center; justify-content:center; overflow:hidden;
}
.dp-img-box img { width:100%; height:100%; object-fit:cover; }
.dp-av-fallback { font-size:3rem; font-weight:700; color:#fff; }

.dp-name { font-family:'Space Grotesk',sans-serif; font-size:1.3rem; font-weight:700; color:var(--t1); margin-bottom:.25rem; }
.dp-enroll { font-size:.85rem; color:#FCD34D; font-weight:600; letter-spacing:.05em; margin-bottom:1.25rem; }

.pill {
    display:inline-flex; align-items:center; gap:5px;
    padding:4px 12px; border-radius:20px; font-size:.7rem; font-weight:600;
}
.pill-dot { width:6px; height:6px; border-radius:50%; flex-shrink:0; }
.pill.pending  { background:rgba(245,158,11,.1); border:1px solid rgba(245,158,11,.22); color:#FCD34D; }
.pill.pending .pill-dot { background:#F59E0B; }
.pill.approved { background:rgba(34,197,94,.1); border:1px solid rgba(34,197,94,.22); color:#86EFAC; }
.pill.approved .pill-dot { background:#22C55E; }
.pill.rejected { background:rgba(244,63,94,.1); border:1px solid rgba(244,63,94,.22); color:#FDA4AF; }
.pill.rejected .pill-dot { background:#F43F5E; }

/* Info Column */
.info-row { display:flex; justify-content:space-between; padding:1rem 0; border-bottom:1px solid var(--c-border); }
.info-row:last-child { border-bottom:none; padding-bottom:0; }
.info-lbl { font-size:.8rem; font-weight:600; color:var(--t3); text-transform:uppercase; letter-spacing:.08em; }
.info-val { font-size:.9rem; font-weight:500; color:var(--t1); text-align:right; max-width:60%; }

@media(max-width:900px) {
    .sd-grid { grid-template-columns:1fr; gap:0; }
    .dp-card { border-right:none; border-bottom:1px solid var(--c-border); padding-right:0; padding-bottom:2rem; margin-bottom:2rem; }
    .info-row { flex-direction:column; gap:.4rem; align-items:flex-start; }
    .info-val { text-align:left; max-width:100%; }
}
</style>

<div class="sd-wrap">
    <div class="pg-bar">
        <div>
            <div class="pg-title">Cadet Information</div>
            <div class="pg-sub">Detailed view of cadet's enrollment profile</div>
        </div>
        <a href="{{ route('admin.cadets.approvals') }}" class="btn-back">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to Approvals
        </a>
    </div>

    <div class="sd-panel">
        <div class="sd-grid">
            
            {{-- Left Profile Column --}}
            <div class="dp-card">
                <div class="dp-img-box">
                    @if(isset($cadet->photo) && $cadet->photo)
                        <img src="{{ asset('storage/' . $cadet->photo) }}" alt="Cadet Photo">
                    @else
                        <div class="dp-av-fallback" style="background:hsl({{ abs(crc32($cadet->user?->name ?? 'X')) % 280 + 30 }},50%,36%); width:100%; height:100%; display:flex; align-items:center; justify-content:center;">
                            {{ strtoupper(substr($cadet->user?->name ?? 'X', 0, 1)) }}
                        </div>
                    @endif
                </div>
                
                <div class="dp-name">{{ $cadet->user?->name ?? '—' }}</div>
                <div class="dp-enroll">{{ $cadet->enrollment_no ?? '—' }}</div>
                
                <div style="margin-bottom:1rem;">
                    <span class="pill {{ $cadet->status ?? 'pending' }}">
                        <span class="pill-dot"></span>
                        {{ ucfirst($cadet->status ?? 'Pending') }}
                    </span>
                </div>
                
                @if(isset($cadet->status) && $cadet->status === 'rejected' && $cadet->rejection_reason)
                    <div style="background:rgba(244,63,94,.05); border:1px solid rgba(244,63,94,.15); padding:.8rem; border-radius:8px; text-align:left; margin-top:1rem;">
                        <div style="font-size:.65rem; color:#FDA4AF; text-transform:uppercase; font-weight:700; margin-bottom:.3rem; letter-spacing:.05em;">Rejection Reason</div>
                        <div style="font-size:.8rem; color:var(--t1); line-height:1.4;">{{ $cadet->rejection_reason }}</div>
                    </div>
                @endif
            </div>

            {{-- Right Info Column --}}
            <div>
                <div class="info-row">
                    <div class="info-lbl">Full Name</div>
                    <div class="info-val">{{ $cadet->user?->name ?? '—' }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-lbl">Email Address</div>
                    <div class="info-val">{{ $cadet->user?->email ?? '—' }}</div>
                </div>

                <div class="info-row">
                    <div class="info-lbl">Enrollment Number</div>
                    <div class="info-val">{{ $cadet->enrollment_no ?? '—' }}</div>
                </div>

                <div class="info-row">
                    <div class="info-lbl">Degree / Course</div>
                    <div class="info-val">{{ $cadet->degree ?? current(array_filter([$cadet->course ?? null])) ?: '—' }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-lbl">Date of Birth</div>
                    <div class="info-val">
                        @if(isset($cadet->dob) && $cadet->dob)
                            {{ \Carbon\Carbon::parse($cadet->dob)->format('d M Y') }}
                        @else
                            —
                        @endif
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-lbl">Gender</div>
                    <div class="info-val">{{ isset($cadet->gender) ? ucfirst($cadet->gender) : '—' }}</div>
                </div>

                <div class="info-row">
                    <div class="info-lbl">Phone Number</div>
                    <div class="info-val">{{ $cadet->phone ?? '—' }}</div>
                </div>

                <div class="info-row">
                    <div class="info-lbl">Residential Address</div>
                    <div class="info-val" style="line-height:1.5;">{{ $cadet->address ?? '—' }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-lbl">Applied On</div>
                    <div class="info-val">{{ isset($cadet->created_at) ? $cadet->created_at->format('d M Y') : '—' }}</div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
