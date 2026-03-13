@extends('layouts.admin')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">

<style>
.appr-wrap *, .appr-wrap *::before, .appr-wrap *::after { box-sizing: border-box; }

.appr-wrap {
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
    --c-bordehi: rgba(255,255,255,0.13);
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

.appr-tabs { display:flex; gap:.5rem; margin-bottom:1.5rem; }
.appr-tab {
    padding:.48rem 1.1rem; border-radius:8px;
    font-size:.78rem; font-weight:600;
    border:1px solid var(--c-border); background:var(--c-card);
    color:var(--t2); cursor:pointer; transition:all .18s;
    font-family:'Plus Jakarta Sans',sans-serif;
}
.appr-tab.active { background:rgba(59,130,246,.12); border-color:rgba(59,130,246,.3); color:#93C5FD; }
.appr-tab.amber.active { background:rgba(245,158,11,.1); border-color:rgba(245,158,11,.25); color:#FCD34D; }
.appr-tab.green.active { background:rgba(34,197,94,.1); border-color:rgba(34,197,94,.25); color:#86EFAC; }
.appr-tab.rose.active  { background:rgba(244,63,94,.1); border-color:rgba(244,63,94,.25); color:#FDA4AF; }

.tab-pane { display:none; }
.tab-pane.active { display:block; }

.appr-tbl-panel {
    background:var(--c-card); border:1px solid var(--c-border);
    border-radius:var(--radius); overflow:hidden;
    animation:fadeUp .4s ease both;
}
.appr-tbl-hd { padding:.9rem 1.35rem; border-bottom:1px solid var(--c-border); display:flex; justify-content:space-between; align-items:center; }
.appr-tbl-ttl { font-family:'Space Grotesk',sans-serif; font-size:.9rem; font-weight:600; color:var(--t1); }

.atbl { width:100%; border-collapse:collapse; }
.atbl thead tr { border-bottom:1px solid var(--c-border); }
.atbl thead th { padding:.6rem 1.35rem; font-size:.62rem; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:var(--t3); text-align:left; white-space:nowrap; }
.atbl tbody tr { border-bottom:1px solid rgba(255,255,255,.04); transition:background .18s; }
.atbl tbody tr:last-child { border-bottom:none; }
.atbl tbody tr:hover { background:rgba(255,255,255,.025); }
.atbl tbody td { padding:.8rem 1.35rem; font-size:.8rem; color:var(--t2); }

.td-user { display:flex; align-items:center; gap:9px; }
.td-av {
    width:32px; height:32px; border-radius:8px; flex-shrink:0;
    display:flex; align-items:center; justify-content:center;
    font-size:.69rem; font-weight:700; color:#fff;
}
.td-nm  { font-weight:500; color:var(--t1); }
.td-em  { font-size:.68rem; color:var(--t3); margin-top:1px; }

.pill {
    display:inline-flex; align-items:center; gap:5px;
    padding:3px 10px; border-radius:20px; font-size:.67rem; font-weight:600;
}
.pill-dot { width:5px; height:5px; border-radius:50%; flex-shrink:0; }
.pill.pending  { background:rgba(245,158,11,.1); border:1px solid rgba(245,158,11,.22); color:#FCD34D; }
.pill.pending .pill-dot { background:#F59E0B; }
.pill.approved { background:rgba(34,197,94,.1); border:1px solid rgba(34,197,94,.22); color:#86EFAC; }
.pill.approved .pill-dot { background:#22C55E; }
.pill.rejected { background:rgba(244,63,94,.1); border:1px solid rgba(244,63,94,.22); color:#FDA4AF; }
.pill.rejected .pill-dot { background:#F43F5E; }

.action-btns { display:flex; gap:.4rem; }
.btn-view {
    padding:4px 12px; border-radius:7px; display:inline-flex; align-items:center; justify-content:center;
    background:rgba(59,130,246,.12); border:1px solid rgba(59,130,246,.25);
    color:#93C5FD; font-size:.72rem; font-weight:600; cursor:pointer;
    transition:all .18s; font-family:'Plus Jakarta Sans',sans-serif; text-decoration:none;
}
.btn-view:hover { background:rgba(59,130,246,.2); }
.btn-approve {
    padding:4px 12px; border-radius:7px;
    background:rgba(34,197,94,.12); border:1px solid rgba(34,197,94,.25);
    color:#86EFAC; font-size:.72rem; font-weight:600; cursor:pointer;
    transition:all .18s; font-family:'Plus Jakarta Sans',sans-serif;
}
.btn-approve:hover { background:rgba(34,197,94,.2); }
.btn-reject {
    padding:4px 12px; border-radius:7px;
    background:rgba(244,63,94,.1); border:1px solid rgba(244,63,94,.22);
    color:#FDA4AF; font-size:.72rem; font-weight:600; cursor:pointer;
    transition:all .18s; font-family:'Plus Jakarta Sans',sans-serif;
}
.btn-reject:hover { background:rgba(244,63,94,.18); }

.empty-row td { text-align:center; padding:3rem; color:var(--t3); font-size:.82rem; }

/* Modal */
.modal-bg {
    position:fixed; inset:0; background:rgba(0,0,0,.65); z-index:999;
    display:none; align-items:center; justify-content:center;
}
.modal-bg.open { display:flex; }
.modal-box {
    background:#0D1627; border:1px solid var(--c-border);
    border-radius:16px; padding:1.75rem; width:480px; max-width:90vw;
}
.modal-ttl { font-family:'Space Grotesk',sans-serif; font-size:1rem; font-weight:600; color:var(--t1); margin-bottom:.5rem; }
.modal-sub { font-size:.78rem; color:var(--t2); margin-bottom:1.25rem; }
.modal-input {
    width:100%; background:rgba(255,255,255,.04); border:1px solid var(--c-border);
    border-radius:8px; padding:.58rem .85rem; font-size:.82rem; color:var(--t1);
    font-family:'Plus Jakarta Sans',sans-serif; outline:none; resize:vertical;
    min-height:80px;
}
.modal-input:focus { border-color:rgba(244,63,94,.4); }
.modal-footer { display:flex; gap:.6rem; margin-top:1.1rem; justify-content:flex-end; }
.btn-cancel {
    padding:.55rem 1.1rem; border-radius:8px;
    background:var(--c-card); border:1px solid var(--c-border);
    color:var(--t2); font-size:.8rem; font-weight:500; cursor:pointer;
    font-family:'Plus Jakarta Sans',sans-serif;
}
.btn-cancel:hover { background:var(--c-cardhov); }
.btn-reject-confirm {
    padding:.55rem 1.1rem; border-radius:8px;
    background:rgba(244,63,94,.15); border:1px solid rgba(244,63,94,.3);
    color:#FDA4AF; font-size:.8rem; font-weight:600; cursor:pointer;
    font-family:'Plus Jakarta Sans',sans-serif;
}
.btn-reject-confirm:hover { background:rgba(244,63,94,.25); }
.btn-approve-confirm {
    padding:.55rem 1.1rem; border-radius:8px;
    background:rgba(34,197,94,.15); border:1px solid rgba(34,197,94,.3);
    color:#86EFAC; font-size:.8rem; font-weight:600; cursor:pointer;
    font-family:'Plus Jakarta Sans',sans-serif;
}
.btn-approve-confirm:hover { background:rgba(34,197,94,.25); }

@media(max-width:800px) { .appr-wrap { padding:1.1rem 1rem 4rem; } }
</style>

<div class="appr-wrap">
    <div class="pg-bar">
        <div>
            <div class="pg-title">Cadet Approvals</div>
            <div class="pg-sub">Review and approve / reject cadet enrollment requests</div>
        </div>
        @if($pending->count() > 0)
        <span class="pill pending" style="font-size:.75rem;padding:5px 12px;">
            <span class="pill-dot"></span>
            {{ $pending->count() }} Pending
        </span>
        @endif
    </div>

    {{-- Tabs --}}
    <div class="appr-tabs">
        <button class="appr-tab amber active" data-tab="tab-pending" onclick="showApprTab(this,'tab-pending')">
            Pending ({{ $pending->count() }})
        </button>
        <button class="appr-tab green" data-tab="tab-approved" onclick="showApprTab(this,'tab-approved')">
            Approved ({{ $approved->count() }})
        </button>
        <button class="appr-tab rose" data-tab="tab-rejected" onclick="showApprTab(this,'tab-rejected')">
            Rejected ({{ $rejected->count() }})
        </button>
    </div>

    {{-- PENDING --}}
    <div class="tab-pane active" id="tab-pending">
        <div class="appr-tbl-panel">
            <div class="appr-tbl-hd">
                <div class="appr-tbl-ttl">Pending Approval Requests</div>
            </div>
            <div style="overflow-x:auto;">
                <table class="atbl">
                    <thead>
                        <tr>
                            <th>Cadet</th>
                            <th>Enrollment No</th>
                            <th>Applied</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pending as $cadet)
                        <tr>
                            <td>
                                <div class="td-user">
                                    <div class="td-av" style="background:hsl({{ abs(crc32($cadet->user?->name ?? 'X')) % 280 + 30 }},50%,36%);">
                                        {{ strtoupper(substr($cadet->user?->name ?? 'X', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="td-nm">{{ $cadet->user?->name ?? '—' }}</div>
                                        <div class="td-em">{{ $cadet->user?->email ?? '—' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="font-variant-numeric:tabular-nums;">{{ $cadet->enrollment_no }}</td>
                            <td>{{ $cadet->created_at->format('d M Y') }}</td>
                            <td><span class="pill pending"><span class="pill-dot"></span>Pending</span></td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.cadets.show', $cadet->id) }}" class="btn-view">👁 View Details</a>
                                    <button type="button" class="btn-approve"
                                        onclick="openApproveModal({{ $cadet->id }}, '{{ addslashes($cadet->user?->name) }}')">
                                        ✓ Approve
                                    </button>
                                    <button type="button" class="btn-reject"
                                        onclick="openRejectModal({{ $cadet->id }}, '{{ addslashes($cadet->user?->name) }}')">
                                        ✕ Reject
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr class="empty-row"><td colspan="5">No pending approval requests. 🎉</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- APPROVED --}}
    <div class="tab-pane" id="tab-approved">
        <div class="appr-tbl-panel">
            <div class="appr-tbl-hd">
                <div class="appr-tbl-ttl">Approved Cadets</div>
            </div>
            <div style="overflow-x:auto;">
                <table class="atbl">
                    <thead>
                        <tr><th>Cadet</th><th>Enrollment No</th><th>Approved On</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        @forelse($approved as $cadet)
                        <tr>
                            <td>
                                <div class="td-user">
                                    <div class="td-av" style="background:hsl({{ abs(crc32($cadet->user?->name ?? 'X')) % 280 + 30 }},50%,36%);">
                                        {{ strtoupper(substr($cadet->user?->name ?? 'X', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="td-nm">{{ $cadet->user?->name ?? '—' }}</div>
                                        <div class="td-em">{{ $cadet->user?->email ?? '—' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $cadet->enrollment_no }}</td>
                            <td>{{ $cadet->updated_at->format('d M Y') }}</td>
                            <td><span class="pill approved"><span class="pill-dot"></span>Approved</span></td>
                        </tr>
                        @empty
                        <tr class="empty-row"><td colspan="4">No approved cadets yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- REJECTED --}}
    <div class="tab-pane" id="tab-rejected">
        <div class="appr-tbl-panel">
            <div class="appr-tbl-hd">
                <div class="appr-tbl-ttl">Rejected Applications</div>
            </div>
            <div style="overflow-x:auto;">
                <table class="atbl">
                    <thead>
                        <tr><th>Cadet</th><th>Enrollment No</th><th>Rejected On</th><th>Reason</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        @forelse($rejected as $cadet)
                        <tr>
                            <td>
                                <div class="td-user">
                                    <div class="td-av" style="background:hsl({{ abs(crc32($cadet->user?->name ?? 'X')) % 280 + 30 }},50%,36%);">
                                        {{ strtoupper(substr($cadet->user?->name ?? 'X', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="td-nm">{{ $cadet->user?->name ?? '—' }}</div>
                                        <div class="td-em">{{ $cadet->user?->email ?? '—' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $cadet->enrollment_no }}</td>
                            <td>{{ $cadet->updated_at->format('d M Y') }}</td>
                            <td style="max-width:200px;font-size:.75rem;">{{ $cadet->rejection_reason ?? '—' }}</td>
                            <td><span class="pill rejected"><span class="pill-dot"></span>Rejected</span></td>
                        </tr>
                        @empty
                        <tr class="empty-row"><td colspan="5">No rejected applications.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Approve Modal --}}
<div class="modal-bg" id="approveModal">
    <div class="modal-box">
        <div class="modal-ttl">Approve Cadet Application</div>
        <div class="modal-sub" id="approveModalSub">Are you sure you want to approve this cadet?</div>
        <form method="POST" id="approveForm">
            @csrf
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeApproveModal()">Cancel</button>
                <button type="submit" class="btn-approve-confirm">Confirm Approve</button>
            </div>
        </form>
    </div>
</div>

{{-- Reject Modal --}}
<div class="modal-bg" id="rejectModal">
    <div class="modal-box">
        <div class="modal-ttl">Reject Cadet Application</div>
        <div class="modal-sub" id="rejectModalSub">Provide a reason for rejection.</div>
        <form method="POST" id="rejectForm">
            @csrf
            <textarea name="reason" class="modal-input" placeholder="Reason for rejection (optional)..."></textarea>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeRejectModal()">Cancel</button>
                <button type="submit" class="btn-reject-confirm">Confirm Reject</button>
            </div>
        </form>
    </div>
</div>

<script>
function showApprTab(btn, tabId) {
    document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.appr-tab').forEach(t => t.classList.remove('active'));
    document.getElementById(tabId).classList.add('active');
    btn.classList.add('active');
}

function openApproveModal(id, name) {
    document.getElementById('approveModalSub').textContent = 'Approving application for ' + name + '.';
    document.getElementById('approveForm').action = '/admin/cadets/' + id + '/approve';
    document.getElementById('approveModal').classList.add('open');
}

function closeApproveModal() {
    document.getElementById('approveModal').classList.remove('open');
}

function openRejectModal(id, name) {
    document.getElementById('rejectModalSub').textContent = 'Rejecting application for ' + name + '. Provide a reason (optional).';
    document.getElementById('rejectForm').action = '/admin/cadets/' + id + '/reject';
    document.getElementById('rejectModal').classList.add('open');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.remove('open');
}

// Flash message auto-hide
@if(session('success') || session('error'))
setTimeout(() => {
    document.querySelectorAll('.flash').forEach(f => f.style.opacity = '0');
}, 3500);
@endif
</script>

@endsection
