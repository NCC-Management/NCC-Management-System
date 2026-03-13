@extends('layouts.admin')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
<style>
.leave-admin-wrap {
    font-family:'Plus Jakarta Sans',sans-serif;
    background:#060C1A; min-height:calc(100vh - 68px);
    color:#F1F5F9; padding:1.75rem 2rem 4rem;
}
:root {
    --c-card:rgba(255,255,255,0.038); --c-border:rgba(255,255,255,0.07);
    --c-cardhov:rgba(255,255,255,0.065); --c-bordehi:rgba(255,255,255,0.13);
    --t1:#F1F5F9; --t2:#94A3B8; --t3:#475569; --radius:14px;
}
@keyframes fadeUp{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:translateY(0)}}

.pg-title{font-family:'Space Grotesk',sans-serif;font-size:1.45rem;font-weight:700;color:var(--t1);letter-spacing:-.03em;margin-bottom:.3rem;}
.pg-sub{font-size:.78rem;color:var(--t2);margin-bottom:1.75rem;}

.leave-tbl-panel{background:var(--c-card);border:1px solid var(--c-border);border-radius:var(--radius);overflow:hidden;animation:fadeUp .4s ease both;}
.leave-tbl-hd{padding:.9rem 1.35rem;border-bottom:1px solid var(--c-border);display:flex;justify-content:space-between;align-items:center;}
.leave-tbl-ttl{font-family:'Space Grotesk',sans-serif;font-size:.9rem;font-weight:600;color:var(--t1);}

.ltbl{width:100%;border-collapse:collapse;}
.ltbl thead tr{border-bottom:1px solid var(--c-border);}
.ltbl thead th{padding:.6rem 1.35rem;font-size:.62rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--t3);text-align:left;white-space:nowrap;}
.ltbl tbody tr{border-bottom:1px solid rgba(255,255,255,.04);transition:background .18s;}
.ltbl tbody tr:last-child{border-bottom:none;}
.ltbl tbody tr:hover{background:rgba(255,255,255,.025);}
.ltbl tbody td{padding:.8rem 1.35rem;font-size:.8rem;color:var(--t2);}

.pill{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:20px;font-size:.67rem;font-weight:600;}
.pill-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0;}
.pill.pending{background:rgba(245,158,11,.1);border:1px solid rgba(245,158,11,.22);color:#FCD34D;}
.pill.pending .pill-dot{background:#F59E0B;}
.pill.approved{background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.22);color:#86EFAC;}
.pill.approved .pill-dot{background:#22C55E;}
.pill.rejected{background:rgba(244,63,94,.1);border:1px solid rgba(244,63,94,.22);color:#FDA4AF;}
.pill.rejected .pill-dot{background:#F43F5E;}

.act-btns{display:flex;gap:.4rem;}
.ba{padding:4px 12px;border-radius:7px;background:rgba(34,197,94,.12);border:1px solid rgba(34,197,94,.25);color:#86EFAC;font-size:.72rem;font-weight:600;cursor:pointer;transition:all .18s;font-family:'Plus Jakarta Sans',sans-serif;}
.ba:hover{background:rgba(34,197,94,.2);}
.br{padding:4px 12px;border-radius:7px;background:rgba(244,63,94,.1);border:1px solid rgba(244,63,94,.22);color:#FDA4AF;font-size:.72rem;font-weight:600;cursor:pointer;transition:all .18s;font-family:'Plus Jakarta Sans',sans-serif;}
.br:hover{background:rgba(244,63,94,.18);}

.empty-row td{text-align:center;padding:3rem;color:var(--t3);font-size:.82rem;}
</style>

<div class="leave-admin-wrap">
    <div class="pg-title">Leave Requests</div>
    <div class="pg-sub">Manage cadet leave requests — approve or reject submissions</div>

    <div class="leave-tbl-panel">
        <div class="leave-tbl-hd">
            <div class="leave-tbl-ttl">All Leave Requests</div>
            <span class="pill pending" style="font-size:.72rem;">
                <span class="pill-dot"></span>
                {{ $leaves->where('status','pending')->count() }} Pending
            </span>
        </div>
        <div style="overflow-x:auto;">
            <table class="ltbl">
                <thead>
                    <tr>
                        <th>Cadet</th>
                        <th>Enrollment No</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leaves as $leave)
                    <tr>
                        <td style="color:var(--t1);font-weight:500;">{{ $leave->cadet?->user?->name ?? '—' }}</td>
                        <td>{{ $leave->cadet?->enrollment_no ?? '—' }}</td>
                        <td>{{ $leave->from_date->format('d M Y') }}</td>
                        <td>{{ $leave->to_date->format('d M Y') }}</td>
                        <td style="max-width:220px;" title="{{ $leave->reason }}">{{ Str::limit($leave->reason, 45) }}</td>
                        <td><span class="pill {{ $leave->status }}"><span class="pill-dot"></span>{{ ucfirst($leave->status) }}</span></td>
                        <td>
                            @if($leave->status === 'pending')
                            <div class="act-btns">
                                <form method="POST" action="{{ route('admin.leave.approve', $leave) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="ba">✓ Approve</button>
                                </form>
                                <form method="POST" action="{{ route('admin.leave.reject', $leave) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="br">✕ Reject</button>
                                </form>
                            </div>
                            @else
                            <span style="font-size:.72rem;color:var(--t3);">Resolved</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr class="empty-row"><td colspan="7">No leave requests submitted yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
