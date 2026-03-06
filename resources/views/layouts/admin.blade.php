<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">
<head>
    <title>NCC Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=Syne:wght@600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --sb-rail: 64px;
            --sb-full: 256px;
            --bar-h:   62px;
            --dur:     260ms;
            --ease:    cubic-bezier(.4,0,.2,1);
        }

        /* ─── DARK ─── */
        [data-theme="dark"] {
            --bg:          #07111F;
            --bg-sb:       #040D19;
            --bg-bar:      rgba(4,13,25,.94);
            --bg-card:     rgba(255,255,255,.040);
            --bg-card-hov: rgba(255,255,255,.068);
            --surf:        rgba(255,255,255,.042);
            --surf-hov:    rgba(255,255,255,.075);
            --bdr:         rgba(255,255,255,.068);
            --bdr-hi:      rgba(255,255,255,.14);
            --tx1: #E8EFFF; --tx2: #6D83A0; --tx3: #2E4159; --tx-muted:#4A6078;
            --blue:   #3D7EFF; --blue-dim:   rgba(61,126,255,.15); --blue-glow: rgba(61,126,255,.35);
            --green:  #1FD57A; --green-dim:  rgba(31,213,122,.12);
            --amber:  #F5A623; --amber-dim:  rgba(245,166,35,.12);
            --rose:   #F0455A; --rose-dim:   rgba(240,69,90,.12);
            --violet: #9B6DFF; --violet-dim: rgba(155,109,255,.12);
            --cyan:   #0CC9E8; --cyan-dim: rgba(12,201,232,.13);
            --shadow:    0 4px 20px rgba(0,0,0,.45);
            --shadow-sb: 6px 0 48px rgba(0,0,0,.6);
            --val-blue:#BFDBFE; --val-green:#BBF7D0; --val-amber:#FDE68A; --val-rose:#FECDD3;
            --bar-blue:linear-gradient(90deg,#1D4ED8,#3B82F6,#60A5FA);
            --bar-green:linear-gradient(90deg,#15803D,#22C55E,#4ADE80);
            --bar-amber:linear-gradient(90deg,#B45309,#F59E0B,#FCD34D);
            --bar-rose:linear-gradient(90deg,#BE123C,#F43F5E,#FB7185);
            --sub-bg: rgba(255,255,255,.025);
        }

        /* ─── LIGHT ─── */
        [data-theme="light"] {
            --bg:          #EEF2F9;
            --bg-sb:       #FFFFFF;
            --bg-bar:      rgba(255,255,255,.97);
            --bg-card:     rgba(255,255,255,.95);
            --bg-card-hov: #FFFFFF;
            --surf:        rgba(15,30,60,.055);
            --surf-hov:    rgba(15,30,60,.095);
            --bdr:         rgba(15,30,60,.09);
            --bdr-hi:      rgba(15,30,60,.18);
            --tx1: #0D1B2E; --tx2: #3D546E; --tx3: #7A94B0; --tx-muted:#6A8299;
            --blue:   #1D4ED8; --blue-dim:   rgba(29,78,216,.10); --blue-glow: rgba(29,78,216,.22);
            --green:  #15803D; --green-dim:  rgba(21,128,61,.10);
            --amber:  #B45309; --amber-dim:  rgba(180,83,9,.10);
            --rose:   #BE123C; --rose-dim:   rgba(190,18,60,.10);
            --violet: #6D28D9; --violet-dim: rgba(109,40,217,.10);
            --cyan:   #0891B2; --cyan-dim: rgba(8,145,178,.10);
            --shadow:    0 2px 14px rgba(15,30,60,.10), 0 1px 4px rgba(15,30,60,.06);
            --shadow-sb: 4px 0 32px rgba(15,30,60,.13);
            --val-blue:#1e3a8a; --val-green:#14532d; --val-amber:#78350f; --val-rose:#881337;
            --bar-blue:linear-gradient(90deg,#1e40af,#2563eb,#60a5fa);
            --bar-green:linear-gradient(90deg,#166534,#16a34a,#4ade80);
            --bar-amber:linear-gradient(90deg,#92400e,#d97706,#fcd34d);
            --bar-rose:linear-gradient(90deg,#9f1239,#e11d48,#fb7185);
            --sub-bg: rgba(15,30,60,.03);
        }

        html, body {
            height:100%; font-family:'DM Sans',sans-serif;
            background:var(--bg); color:var(--tx1); overflow-x:hidden;
            transition:background var(--dur) var(--ease), color var(--dur) var(--ease);
        }
        .app-shell { display:flex; min-height:100vh; }

        /* ══════════════════════════════════════
           SIDEBAR
        ══════════════════════════════════════ */
        .sidebar {
            position:fixed; top:0; left:0; height:100vh;
            width:var(--sb-rail);
            background:var(--bg-sb); border-right:1px solid var(--bdr);
            display:flex; flex-direction:column; z-index:400; overflow:hidden;
            transition:width var(--dur) var(--ease), box-shadow var(--dur) var(--ease),
                        background var(--dur) var(--ease), border-color var(--dur) var(--ease);
        }
        .sidebar:hover, .sidebar.pinned { width:var(--sb-full); box-shadow:var(--shadow-sb); }

        /* ── Brand ── */
        .sb-brand {
            display:flex; align-items:center; gap:11px;
            height:var(--bar-h); padding:0 14px;
            border-bottom:1px solid var(--bdr);
            flex-shrink:0; overflow:hidden; white-space:nowrap; position:relative;
            transition:border-color var(--dur);
        }
        .sb-brand::before {
            content:''; position:absolute; top:0; left:0; right:0; height:2px;
            background:linear-gradient(90deg,var(--blue) 0%,var(--cyan) 65%,transparent 100%);
            opacity:.75;
        }
        .sb-logo-wrap {
            width:36px; height:36px; border-radius:10px; flex-shrink:0;
            background:linear-gradient(135deg,var(--blue) 0%,var(--cyan) 100%);
            display:flex; align-items:center; justify-content:center;
            box-shadow:0 0 0 1px rgba(61,126,255,.25), 0 4px 14px var(--blue-glow);
            position:relative; overflow:hidden;
        }
        .sb-logo-wrap::after { content:''; position:absolute; inset:0; background:linear-gradient(135deg,rgba(255,255,255,.22) 0%,transparent 55%); }
        .sb-logo-wrap svg { width:18px; height:18px; color:#fff; position:relative; z-index:1; }
        .sb-brand-text { opacity:0; transform:translateX(-7px); transition:opacity var(--dur) var(--ease),transform var(--dur) var(--ease); pointer-events:none; white-space:nowrap; overflow:hidden; }
        .sidebar:hover .sb-brand-text,.sidebar.pinned .sb-brand-text { opacity:1; transform:none; }
        .sb-brand-name { font-family:'Syne',sans-serif; font-size:.85rem; font-weight:800; color:var(--tx1); letter-spacing:.05em; text-transform:uppercase; line-height:1.2; transition:color var(--dur); }
        .sb-brand-sub  { font-size:.57rem; font-weight:500; color:var(--tx3); letter-spacing:.08em; text-transform:uppercase; white-space:nowrap; transition:color var(--dur); }

        /* ── Pin ── */
        .sb-pin { position:absolute; right:9px; top:50%; transform:translateY(-50%); width:24px; height:24px; border-radius:6px; background:transparent; border:1px solid transparent; display:flex; align-items:center; justify-content:center; cursor:pointer; opacity:0; pointer-events:none; transition:opacity .18s,background .18s,border-color .18s; }
        .sb-pin svg { width:12px; height:12px; color:var(--tx3); transition:color .18s; }
        .sidebar:hover .sb-pin { opacity:1; pointer-events:auto; }
        .sb-pin:hover { background:var(--surf-hov); border-color:var(--bdr-hi); }
        .sb-pin:hover svg { color:var(--tx1); }
        .sidebar.pinned .sb-pin { opacity:1; pointer-events:auto; }
        .sidebar.pinned .sb-pin svg { color:var(--blue); }

        /* ── Nav scroll ── */
        .sb-nav { flex:1; overflow-y:auto; overflow-x:hidden; padding:8px 0 4px; }
        .sb-nav::-webkit-scrollbar { width:3px; }
        .sb-nav::-webkit-scrollbar-thumb { background:var(--bdr); border-radius:99px; }

        /* ── Section label ── */
        .sb-sec { display:flex; align-items:center; gap:8px; padding:12px 0 4px 20px; overflow:hidden; white-space:nowrap; }
        .sb-sec-line { height:1px; width:10px; background:var(--tx3); flex-shrink:0; border-radius:1px; }
        .sb-sec-txt { font-size:.57rem; font-weight:700; text-transform:uppercase; letter-spacing:.14em; color:var(--tx3); opacity:0; transform:translateX(-4px); transition:opacity var(--dur) var(--ease),transform var(--dur) var(--ease),color var(--dur); white-space:nowrap; }
        .sidebar:hover .sb-sec-txt,.sidebar.pinned .sb-sec-txt { opacity:1; transform:none; }

        /* ══════════════════════════════════════
           PARENT NAV ITEM
        ══════════════════════════════════════ */
        .sb-item {
            display:flex; align-items:center; height:42px; margin:1px 6px; border-radius:10px;
            text-decoration:none !important; color:var(--tx2);
            font-size:.82rem; font-weight:500;
            position:relative; overflow:hidden; cursor:pointer;
            transition:background .18s,color .18s; white-space:nowrap;
        }
        .sb-item:hover { background:var(--surf-hov); color:var(--tx1); }
        .sb-item.is-blue   { background:var(--blue-dim);   color:var(--blue);   }
        .sb-item.is-green  { background:var(--green-dim);  color:var(--green);  }
        .sb-item.is-amber  { background:var(--amber-dim);  color:var(--amber);  }
        .sb-item.is-rose   { background:var(--rose-dim);   color:var(--rose);   }
        .sb-item.is-violet { background:var(--violet-dim); color:var(--violet); }

        .sb-item.is-cyan   { background:var(--cyan-dim);   color:var(--cyan);   }

        /* Active left accent bar */
        .sb-item.is-blue::before,.sb-item.is-green::before,.sb-item.is-amber::before,
        .sb-item.is-rose::before,.sb-item.is-violet::before,.sb-item.is-cyan::before {
            content:''; position:absolute; left:0; top:22%; bottom:22%; width:3px; border-radius:0 3px 3px 0;
        }
        .sb-item.is-blue::before   { background:var(--blue);   box-shadow:0 0 8px var(--blue); }
        .sb-item.is-green::before  { background:var(--green);  box-shadow:0 0 8px var(--green); }
        .sb-item.is-amber::before  { background:var(--amber);  box-shadow:0 0 8px var(--amber); }
        .sb-item.is-rose::before   { background:var(--rose);   box-shadow:0 0 8px var(--rose); }
        .sb-item.is-violet::before { background:var(--violet); box-shadow:0 0 8px var(--violet); }
        .sb-item.is-cyan::before   { background:var(--cyan);   box-shadow:0 0 8px var(--cyan); }
        [data-theme="light"] .sb-item[class*="is-"]::before { box-shadow:none; }

        .sb-ico { width:var(--sb-rail); min-width:var(--sb-rail); height:100%; display:flex; align-items:center; justify-content:center; flex-shrink:0; color:inherit; }
        .sb-ico svg { width:18px; height:18px; }

        .sb-lbl { flex:1; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; font-size:.82rem; font-weight:500; color:inherit; opacity:0; transform:translateX(-5px); transition:opacity var(--dur) var(--ease),transform var(--dur) var(--ease); }
        .sidebar:hover .sb-lbl,.sidebar.pinned .sb-lbl { opacity:1; transform:none; }

        /* Chevron */
        .sb-chev { margin-right:10px; flex-shrink:0; opacity:0; transform:translateX(-3px); transition:opacity var(--dur) var(--ease),transform var(--dur) var(--ease); }
        .sb-chev svg { width:11px; height:11px; color:var(--tx3); display:block; transition:transform .22s var(--ease),color .18s; }
        .sidebar:hover .sb-chev,.sidebar.pinned .sb-chev { opacity:1; transform:none; }
        .sb-group.open > .sb-item .sb-chev svg { transform:rotate(90deg); color:var(--tx2); }

        /* Badge */
        .sb-bdg { margin-right:4px; padding:2px 6px; border-radius:20px; font-size:.61rem; font-weight:700; flex-shrink:0; opacity:0; transform:translateX(-3px); transition:opacity var(--dur) var(--ease),transform var(--dur) var(--ease); }
        .sb-bdg.a { background:var(--amber-dim); color:var(--amber); }
        .sidebar:hover .sb-bdg,.sidebar.pinned .sb-bdg { opacity:1; transform:none; }

        /* Tooltip — only in collapsed rail */
        .sb-tip { position:absolute; left:calc(var(--sb-rail) + 9px); top:50%; transform:translateY(-50%) scale(.9); background:var(--bg-sb); border:1px solid var(--bdr-hi); color:var(--tx1); font-size:.74rem; font-weight:500; padding:5px 11px; border-radius:8px; white-space:nowrap; pointer-events:none; opacity:0; z-index:500; box-shadow:var(--shadow); transition:opacity .12s,transform .12s; }
        .sidebar:not(:hover):not(.pinned) .sb-item:hover .sb-tip { opacity:1; transform:translateY(-50%) scale(1); }

        /* ══════════════════════════════════════
           INLINE ACCORDION SUBMENU
        ══════════════════════════════════════ */
        .sb-sub {
            overflow:hidden;
            max-height:0;
            opacity:0;
            transition:max-height .3s var(--ease), opacity .2s var(--ease);
        }
        /* Only show when parent group is open AND sidebar is expanded */
        .sb-group.open .sb-sub { max-height:600px; opacity:1; }
        /* Collapse immediately when sidebar shrinks to rail */
        .sidebar:not(:hover):not(.pinned) .sb-sub { max-height:0 !important; opacity:0 !important; transition:none !important; }

        /* Indented inner container with vertical guide line */
        .sb-sub-inner {
            padding:2px 6px 6px 0;
            margin-left:32px;
            border-left:1.5px solid var(--bdr);
            padding-left:0;
        }

        /* Sub-divider */
        .sub-div { height:1px; background:var(--bdr); margin:4px 8px 4px 14px; }

        /* Sub section label */
        .sub-lbl { font-size:.56rem; font-weight:700; text-transform:uppercase; letter-spacing:.12em; color:var(--tx3); padding:5px 8px 2px 14px; transition:color var(--dur); }

        /* Sub-item row */
        .sb-sub-item {
            display:flex; align-items:center; gap:9px;
            padding:7px 10px 7px 14px;
            margin:1px 6px 1px 0;
            border-radius:0 9px 9px 0;
            text-decoration:none !important; color:var(--tx2);
            font-size:.78rem; font-weight:500; cursor:pointer; white-space:nowrap;
            transition:background .15s,color .15s;
            position:relative;
        }
        .sb-sub-item:hover { background:var(--surf-hov); color:var(--tx1); }
        .sb-sub-item.active { background:var(--surf); color:var(--tx1); font-weight:600; }

        /* Dot on the guide line */
        .sb-sub-item::before {
            content:'';
            position:absolute; left:-1px; top:50%; transform:translateY(-50%);
            width:7px; height:7px; border-radius:50%;
            background:var(--bdr); border:1.5px solid var(--bg-sb);
            transition:background .15s;
        }
        .sb-sub-item:hover::before,.sb-sub-item.active::before { background:var(--bdr-hi); }

        /* Colour dot accent for active group */
        .sb-group.grp-blue.open   .sb-sub-item.active::before { background:var(--blue); }
        .sb-group.grp-green.open  .sb-sub-item.active::before { background:var(--green); }
        .sb-group.grp-amber.open  .sb-sub-item.active::before { background:var(--amber); }
        .sb-group.grp-rose.open   .sb-sub-item.active::before { background:var(--rose); }
        .sb-group.grp-violet.open .sb-sub-item.active::before { background:var(--violet); }
        .sb-group.grp-cyan.open   .sb-sub-item.active::before { background:var(--cyan); }

        /* Sub icon */
        .sub-ico { width:26px; height:26px; border-radius:7px; display:flex; align-items:center; justify-content:center; flex-shrink:0; background:var(--surf); transition:background .15s; }
        .sub-ico svg { width:12px; height:12px; }
        .sb-sub-item:hover .sub-ico { background:var(--surf-hov); }

        /* Icon colour per group */
        .sb-group.grp-blue   .sub-ico { color:var(--blue);   }
        .sb-group.grp-green  .sub-ico { color:var(--green);  }
        .sb-group.grp-amber  .sub-ico { color:var(--amber);  }
        .sb-group.grp-rose   .sub-ico { color:var(--rose);   }
        .sb-group.grp-violet .sub-ico { color:var(--violet); }
        .sb-group.grp-cyan   .sub-ico { color:var(--cyan);   }

        .sub-name { font-size:.78rem; font-weight:500; color:inherit; line-height:1.2; }
        .sub-desc { font-size:.61rem; color:var(--tx3); margin-top:1px; transition:color var(--dur); }

        /* ── Footer ── */
        .sb-foot { border-top:1px solid var(--bdr); padding:9px 0; display:flex; align-items:center; overflow:hidden; white-space:nowrap; flex-shrink:0; transition:border-color var(--dur); }
        .sb-av-wrap { width:var(--sb-rail); min-width:var(--sb-rail); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .sb-av { width:32px; height:32px; border-radius:9px; background:linear-gradient(135deg,var(--blue),var(--violet)); display:flex; align-items:center; justify-content:center; font-family:'Syne',sans-serif; font-size:.75rem; font-weight:700; color:#fff; box-shadow:0 2px 10px var(--blue-glow); }
        .sb-user-txt { flex:1; overflow:hidden; min-width:0; opacity:0; transform:translateX(-5px); transition:opacity var(--dur) var(--ease),transform var(--dur) var(--ease); }
        .sidebar:hover .sb-user-txt,.sidebar.pinned .sb-user-txt { opacity:1; transform:none; }
        .sb-uname { font-size:.8rem; font-weight:600; color:var(--tx1); line-height:1.3; overflow:hidden; text-overflow:ellipsis; transition:color var(--dur); }
        .sb-urole { font-size:.63rem; color:var(--tx3); transition:color var(--dur); }
        .sb-logout-btn { width:28px; height:28px; border-radius:7px; background:rgba(240,69,90,.08); border:1px solid rgba(240,69,90,.16); display:flex; align-items:center; justify-content:center; cursor:pointer; flex-shrink:0; margin-right:7px; opacity:0; transition:opacity var(--dur) var(--ease),background .18s,border-color .18s; }
        .sb-logout-btn svg { width:13px; height:13px; color:#FF8090; }
        [data-theme="light"] .sb-logout-btn svg { color:var(--rose); }
        .sb-logout-btn:hover { background:rgba(240,69,90,.2); border-color:rgba(240,69,90,.35); }
        .sidebar:hover .sb-logout-btn,.sidebar.pinned .sb-logout-btn { opacity:1; }

        /* ══════════════════════════════════════
           MOBILE BAR
        ══════════════════════════════════════ */
        .mob-bar { display:none; position:fixed; top:0; left:0; right:0; height:56px; background:var(--bg-bar); backdrop-filter:blur(16px); border-bottom:1px solid var(--bdr); z-index:350; align-items:center; justify-content:space-between; padding:0 1rem; transition:background var(--dur),border-color var(--dur); }
        .mob-ham { width:32px; height:32px; background:var(--surf); border:1px solid var(--bdr); border-radius:8px; display:flex; align-items:center; justify-content:center; cursor:pointer; }
        .mob-ham svg { width:16px; height:16px; color:var(--tx2); }
        .mob-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.6); z-index:390; backdrop-filter:blur(3px); }
        .mob-overlay.show { display:block; }

        /* ══════════════════════════════════════
           MAIN WRAPPER
        ══════════════════════════════════════ */
        .main-wrap { margin-left:var(--sb-rail); width:calc(100% - var(--sb-rail)); min-height:100vh; display:flex; flex-direction:column; transition:margin-left var(--dur) var(--ease),width var(--dur) var(--ease); min-width:0; }
        .main-wrap.pinned { margin-left:var(--sb-full); width:calc(100% - var(--sb-full)); }

        .desk-bar { height:var(--bar-h); background:var(--bg-bar); backdrop-filter:blur(20px); border-bottom:1px solid var(--bdr); display:flex; align-items:center; justify-content:space-between; padding:0 1.6rem; position:sticky; top:0; z-index:200; width:100%; flex-shrink:0; transition:background var(--dur),border-color var(--dur); }
        .dbar-l { display:flex; align-items:center; gap:10px; }
        .tb-ncc-logo { display:flex; align-items:center; gap:9px; padding:6px 12px; border-radius:9px; border:1px solid var(--bdr); background:var(--surf); text-decoration:none !important; transition:background .18s,border-color .18s; }
        .tb-ncc-logo:hover { background:var(--surf-hov); border-color:var(--bdr-hi); }
        .tb-ncc-badge { width:26px; height:26px; border-radius:7px; background:linear-gradient(135deg,var(--blue) 0%,var(--cyan) 100%); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .tb-ncc-badge svg { width:13px; height:13px; color:#fff; }
        .tb-ncc-name { font-family:'Syne',sans-serif; font-size:.82rem; font-weight:800; color:var(--tx1); letter-spacing:.06em; text-transform:uppercase; line-height:1.1; transition:color var(--dur); }
        .tb-ncc-sub  { font-size:.56rem; color:var(--tx3); text-transform:uppercase; letter-spacing:.07em; line-height:1; margin-top:2px; transition:color var(--dur); }
        .dbar-sep  { color:var(--tx3); font-size:.85rem; opacity:.45; }
        .dbar-page { font-family:'Syne',sans-serif; font-size:.88rem; font-weight:700; color:var(--tx1); letter-spacing:.01em; transition:color var(--dur); }
        .dbar-r { display:flex; align-items:center; gap:7px; }
        .live-pill { display:flex; align-items:center; gap:6px; padding:4px 11px; background:var(--green-dim); border:1px solid rgba(31,213,122,.2); border-radius:20px; font-size:.67rem; font-weight:600; color:var(--green); }
        [data-theme="light"] .live-pill { border-color:rgba(21,128,61,.25); }
        .live-dot { width:6px; height:6px; border-radius:50%; background:var(--green); animation:lv 2.2s ease infinite; }
        @keyframes lv { 0%,100%{ opacity:1; box-shadow:0 0 5px var(--green); } 50%{ opacity:.3; box-shadow:none; } }
        [data-theme="light"] .live-dot { animation:none; }
        .dbar-line { width:1px; height:22px; background:var(--bdr); }
        .dbar-btn { width:34px; height:34px; background:var(--surf); border:1px solid var(--bdr); border-radius:9px; display:flex; align-items:center; justify-content:center; cursor:pointer; position:relative; transition:background .18s,border-color .18s; }
        .dbar-btn:hover { background:var(--surf-hov); border-color:var(--bdr-hi); }
        .dbar-btn svg { width:15px; height:15px; color:var(--tx2); transition:color .18s; }
        .dbar-btn:hover svg { color:var(--tx1); }
        .notif-dot { position:absolute; top:7px; right:7px; width:6px; height:6px; border-radius:50%; background:var(--blue); border:1.5px solid var(--bg); }
        .theme-toggle { width:34px; height:34px; background:var(--surf); border:1px solid var(--bdr); border-radius:9px; display:flex; align-items:center; justify-content:center; cursor:pointer; overflow:hidden; position:relative; transition:background .18s,border-color .18s,box-shadow .22s; }
        .theme-toggle:hover { background:var(--surf-hov); border-color:var(--bdr-hi); box-shadow:0 0 14px var(--blue-glow); }
        .ico-sun  { position:absolute; width:16px; height:16px; transition:transform .38s var(--ease),opacity .28s; }
        .ico-moon { position:absolute; width:15px; height:15px; transition:transform .38s var(--ease),opacity .28s; }
        [data-theme="dark"]  .ico-sun  { transform:rotate(90deg) scale(0); opacity:0; }
        [data-theme="dark"]  .ico-moon { transform:rotate(0) scale(1); opacity:1; color:#93BBFF; }
        [data-theme="light"] .ico-sun  { transform:rotate(0) scale(1); opacity:1; color:#D97706; }
        [data-theme="light"] .ico-moon { transform:rotate(-90deg) scale(0); opacity:0; }
        .dbar-user { display:flex; align-items:center; gap:8px; padding:4px 8px; border-radius:10px; cursor:pointer; transition:background .18s; }
        .dbar-user:hover { background:var(--surf); }
        .dbar-uav { width:30px; height:30px; border-radius:8px; background:linear-gradient(135deg,var(--blue),var(--violet)); display:flex; align-items:center; justify-content:center; font-family:'Syne',sans-serif; font-size:.7rem; font-weight:700; color:#fff; }
        .dbar-uname { font-size:.78rem; font-weight:600; color:var(--tx1); line-height:1.3; transition:color var(--dur); }
        .dbar-urole { font-size:.63rem; color:var(--tx3); transition:color var(--dur); }

        .page-wrap { flex:1; padding:2rem; background:var(--bg); position:relative; width:100%; min-width:0; transition:background var(--dur) var(--ease); }
        .page-wrap::before { content:''; position:fixed; inset:0; pointer-events:none; z-index:0; }
        [data-theme="dark"]  .page-wrap::before { background:radial-gradient(ellipse 70% 45% at 15% -5%,rgba(61,126,255,.09) 0%,transparent 55%),radial-gradient(ellipse 50% 40% at 85% 110%,rgba(155,109,255,.07) 0%,transparent 55%); }
        [data-theme="light"] .page-wrap::before { background:radial-gradient(ellipse 70% 45% at 15% -5%,rgba(29,78,216,.04) 0%,transparent 55%),radial-gradient(ellipse 50% 40% at 85% 110%,rgba(109,40,217,.03) 0%,transparent 55%); }
        .page-wrap > * { position:relative; z-index:1; }
        .page-wrap.flush { padding:0 !important; }

        /* ══════════════════════════════════════
           LIGHT MODE OVERRIDES
        ══════════════════════════════════════ */
        [data-theme="light"] .adash { background:var(--bg) !important; }
        [data-theme="light"] .pg-title { color:var(--tx1) !important; }
        [data-theme="light"] .pg-sub   { color:var(--tx2) !important; }
        [data-theme="light"] .btn-ghost { background:var(--surf) !important; border-color:var(--bdr) !important; color:var(--tx2) !important; }
        [data-theme="light"] .btn-ghost:hover { background:var(--surf-hov) !important; color:var(--tx1) !important; }
        [data-theme="light"] .sec-hd-label  { color:var(--tx3) !important; }
        [data-theme="light"] .sc { background:var(--bg-card) !important; border-color:var(--bdr) !important; box-shadow:var(--shadow) !important; }
        [data-theme="light"] .sc-lbl  { color:var(--tx3) !important; }
        [data-theme="light"] .sc-desc { color:var(--tx-muted) !important; }
        [data-theme="light"] .sc-foot { color:var(--tx3) !important; }
        [data-theme="light"] .sc-bar  { background:rgba(15,30,60,.08) !important; }
        [data-theme="light"] .blue  .sc-val { color:var(--val-blue)  !important; }
        [data-theme="light"] .green .sc-val { color:var(--val-green) !important; }
        [data-theme="light"] .amber .sc-val { color:var(--val-amber) !important; }
        [data-theme="light"] .rose  .sc-val { color:var(--val-rose)  !important; }
        [data-theme="light"] .blue  .sc-rate { color:var(--blue)  !important; }
        [data-theme="light"] .green .sc-rate { color:var(--green) !important; }
        [data-theme="light"] .amber .sc-rate { color:var(--amber) !important; }
        [data-theme="light"] .rose  .sc-rate { color:var(--rose)  !important; }
        [data-theme="light"] .blue  .sc-bar-fill { background:var(--bar-blue)  !important; }
        [data-theme="light"] .green .sc-bar-fill { background:var(--bar-green) !important; }
        [data-theme="light"] .amber .sc-bar-fill { background:var(--bar-amber) !important; }
        [data-theme="light"] .rose  .sc-bar-fill { background:var(--bar-rose)  !important; }
        [data-theme="light"] .blue  .sc-ico { background:rgba(29,78,216,.1)  !important; color:var(--blue)   !important; }
        [data-theme="light"] .green .sc-ico { background:rgba(21,128,61,.1)  !important; color:var(--green)  !important; }
        [data-theme="light"] .amber .sc-ico { background:rgba(180,83,9,.1)   !important; color:var(--amber)  !important; }
        [data-theme="light"] .rose  .sc-ico { background:rgba(190,18,60,.1)  !important; color:var(--rose)   !important; }
        [data-theme="light"] .tile { background:var(--bg-card) !important; border-color:var(--bdr) !important; box-shadow:var(--shadow) !important; }
        [data-theme="light"] .tile-val { color:var(--tx1) !important; }
        [data-theme="light"] .tile-lbl { color:var(--tx2) !important; }
        [data-theme="light"] .panel { background:var(--bg-card) !important; border-color:var(--bdr) !important; box-shadow:var(--shadow) !important; }
        [data-theme="light"] .panel-ttl { color:var(--tx1) !important; }
        [data-theme="light"] .panel-sub { color:var(--tx2) !important; }
        [data-theme="light"] .leg-item  { color:var(--tx2) !important; }
        [data-theme="light"] .badge-live { background:rgba(21,128,61,.08) !important; border-color:rgba(21,128,61,.22) !important; color:var(--green) !important; }
        [data-theme="light"] .donut-ctr-val { color:var(--tx1) !important; }
        [data-theme="light"] .donut-ctr-lbl { color:var(--tx3) !important; }
        [data-theme="light"] .mini-stat { background:var(--surf) !important; border-color:var(--bdr) !important; }
        [data-theme="light"] .mini-stat-label { color:var(--tx1) !important; }
        [data-theme="light"] .mini-stat-sub   { color:var(--tx3) !important; }
        [data-theme="light"] .tbl-panel { background:var(--bg-card) !important; border-color:var(--bdr) !important; box-shadow:var(--shadow) !important; }
        [data-theme="light"] .tbl-ttl   { color:var(--tx1) !important; }
        [data-theme="light"] .at-table thead th { color:var(--tx3) !important; }
        [data-theme="light"] .at-table tbody td { color:var(--tx2) !important; }
        [data-theme="light"] .td-nm { color:var(--tx1) !important; }
        [data-theme="light"] .tbl-search { background:var(--surf) !important; border-color:var(--bdr) !important; }
        [data-theme="light"] .tbl-search input { color:var(--tx1) !important; }
        [data-theme="light"] .tbl-filter-btn { background:var(--surf) !important; border-color:var(--bdr) !important; color:var(--tx2) !important; }
        [data-theme="light"] .pill.present { background:rgba(21,128,61,.1) !important; border-color:rgba(21,128,61,.28) !important; color:#15803D !important; }
        [data-theme="light"] .pill.absent  { background:rgba(190,18,60,.1) !important; border-color:rgba(190,18,60,.28) !important; color:#BE123C !important; }
        [data-theme="light"] .pill.pending { background:rgba(180,83,9,.1)  !important; border-color:rgba(180,83,9,.28)  !important; color:#B45309 !important; }
        [data-theme="light"] .pill.present .pill-dot { background:#15803D !important; }
        [data-theme="light"] .pill.absent  .pill-dot { background:#BE123C !important; }
        [data-theme="light"] .pill.pending .pill-dot { background:#B45309 !important; }
        /* dot border fix for light */
        [data-theme="light"] .sb-sub-item::before { border-color:var(--bg-sb); }

        body.full-screen .sidebar   { display:none !important; }
        body.full-screen .main-wrap { margin-left:0 !important; width:100% !important; }
        body.full-screen .desk-bar  { display:none !important; }
        body.full-screen .mob-bar   { display:flex !important; }
        body.full-screen .page-wrap { padding:0 !important; }

        @media (max-width:768px) {
            .mob-bar  { display:flex; }
            .desk-bar { display:none; }
            .main-wrap { margin-left:0 !important; width:100% !important; padding-top:56px; }
            .sidebar { transform:translateX(-100%); width:var(--sb-full) !important; overflow-y:auto; transition:transform var(--dur) var(--ease); }
            .sidebar.mob-open { transform:translateX(0); }
            .sb-brand-text,.sb-lbl,.sb-user-txt,.sb-logout-btn,.sb-sec-txt,.sb-bdg,.sb-chev { opacity:1 !important; transform:none !important; }
            .sb-pin { opacity:0 !important; pointer-events:none !important; }
            /* On mobile the sidebar is always "expanded" so submenus behave normally */
            .sidebar .sb-sub { transition:max-height .3s var(--ease),opacity .2s var(--ease) !important; }
        }
    </style>
</head>

<body class="{{ request()->routeIs('shows.*') ? 'full-screen' : '' }}">

<script>
// URL Masking - Hide actual routes and show clean appearance
(function() {
    // Mask the URL on page load - show only page name or #
    const currentUrl = window.location.href;
    const pathname = window.location.pathname;
    
    // Extract the last segment of the path (page name)
    const segments = pathname.split('/').filter(s => s);
    const pageName = segments[segments.length - 1] || 'dashboard';
    
    // Only mask admin routes
    if (pathname.includes('/admin/')) {
        // Replace history to show clean URL without exposing routes
        // Show domain + # instead of full admin route
        const baseUrl = window.location.origin + '/'; // e.g., http://127.0.0.1:8000/
        window.history.replaceState(
            { originalPath: pathname },
            document.title,
            baseUrl + '#' // Show just the hash, hiding the admin route
        );
    }
})();
</script>

{{-- Mobile top bar --}}
<div class="mob-bar" id="mobBar">
    <div class="mob-ham" onclick="toggleMob()">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
    </div>
    <div style="display:flex;align-items:center;gap:8px;">
        <div style="width:28px;height:28px;border-radius:7px;background:linear-gradient(135deg,var(--blue),var(--cyan));display:flex;align-items:center;justify-content:center;">
            <svg fill="currentColor" viewBox="0 0 24 24" style="width:14px;height:14px;color:#fff;"><path d="M12 2L2 7v9c0 4.5 4.5 6.5 10 7 5.5-.5 10-2.5 10-7V7L12 2z"/></svg>
        </div>
        <span style="font-family:'Syne',sans-serif;font-size:.85rem;font-weight:800;color:var(--tx1);letter-spacing:.05em;">NCC</span>
    </div>
    <div style="display:flex;align-items:center;gap:6px;">
        <div class="theme-toggle" onclick="toggleTheme()">
            <svg class="ico-sun" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
            <svg class="ico-moon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
        </div>
        <div class="dbar-uav" style="width:28px;height:28px;font-size:.68rem;">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
    </div>
</div>
<div class="mob-overlay" id="mobOverlay" onclick="toggleMob()"></div>

<div class="app-shell">

{{-- ════════════ SIDEBAR ════════════ --}}
<aside class="sidebar" id="sidebar">

    <div class="sb-brand">
        <div class="sb-logo-wrap">
            <svg fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7v9c0 4.5 4.5 6.5 10 7 5.5-.5 10-2.5 10-7V7L12 2z"/></svg>
        </div>
        <div class="sb-brand-text">
            <div class="sb-brand-name">NCC</div>
            <div class="sb-brand-sub">National Cadet Corps</div>
        </div>
        <button class="sb-pin" id="sbPin" onclick="togglePin(event)" title="Pin sidebar">
            <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        </button>
    </div>

    <nav class="sb-nav" id="sbNav">

        {{-- ── MAIN ── --}}
        <div class="sb-sec"><div class="sb-sec-line"></div><span class="sb-sec-txt">Main</span></div>

        {{-- Dashboard --}}
        <div class="sb-group grp-blue" data-key="dashboard" data-route="{{ route('admin.dashboard') }}">
            <a href="#"
               class="sb-item {{ request()->routeIs('admin.dashboard') ? 'is-blue' : '' }}"
               onclick="navigateTo(event, '{{ route('admin.dashboard') }}', 'dashboard')">
                <span class="sb-ico"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg></span>
                <span class="sb-lbl">Dashboard</span>
                <span class="sb-chev"><svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                <span class="sb-tip">Dashboard</span>
            </a>
            <div class="sb-sub">
                <div class="sb-sub-inner">
                    <a href="#" class="sb-sub-item {{ request()->is('admin/dashboard') ? 'active':'' }}" onclick="navigateTo(event, '{{ route('admin.dashboard') }}')">
                        <div class="sub-ico"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg></div>
                        <div><div class="sub-name">Overview</div><div class="sub-desc">Key metrics at a glance</div></div>
                    </a>
                    <a href="#" class="sb-sub-item" onclick="navigateTo(event, '{{ route('admin.dashboard') }}')">
                        <div class="sub-ico"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
                        <div><div class="sub-name">Live Activity</div><div class="sub-desc">Real-time feed</div></div>
                    </a>
                    <a href="#" class="sb-sub-item" onclick="navigateTo(event, '{{ route('admin.dashboard') }}')">
                        <div class="sub-ico"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></div>
                        <div><div class="sub-name">Analytics</div><div class="sub-desc">Charts & trends</div></div>
                    </a>
                </div>
            </div>
        </div>

        {{-- ── MANAGEMENT ── --}}
        <div class="sb-sec" style="margin-top:4px;"><div class="sb-sec-line"></div><span class="sb-sec-txt">Management</span></div>

        {{-- Cadets --}}
        <div class="sb-group grp-green" data-key="cadets" data-route="{{ route('admin.cadets.index') }}">
            <a href="#"
               class="sb-item {{ request()->routeIs('admin.cadets.*') ? 'is-green' : '' }}"
               onclick="navigateTo(event, '{{ route('admin.cadets.index') }}', 'cadets')">
                <span class="sb-ico"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></span>
                <span class="sb-lbl">Cadets</span>
                <span class="sb-chev"><svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                <span class="sb-tip">Cadets</span>
            </a>
            <div class="sb-sub">
                <div class="sb-sub-inner">
                    <a href="#" class="sb-sub-item {{ request()->routeIs('admin.cadets.index') ? 'active':'' }}" onclick="navigateTo(event, '{{ route('admin.cadets.index') }}')">
                        <div class="sub-ico"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
                        <div><div class="sub-name">All Cadets</div><div class="sub-desc">View & search</div></div>
                    </a>
                    <a href="#" class="sb-sub-item {{ request()->routeIs('admin.cadets.create') ? 'active':'' }}" onclick="navigateTo(event, '{{ route('admin.cadets.create') }}')">
                        <div class="sub-ico"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg></div>
                        <div><div class="sub-name">Enrol Cadet</div><div class="sub-desc">Add new record</div></div>
                    </a>
                    <div class="sub-div"></div>
                    <a href="#" class="sb-sub-item" onclick="navigateTo(event, '{{ route('admin.attendance.index') }}')">
                        <div class="sub-ico"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg></div>
                        <div><div class="sub-name">Attendance</div><div class="sub-desc">Mark & view</div></div>
                    </a>
                    <a href="#" class="sb-sub-item" onclick="navigateTo(event, '{{ route('admin.cadets.index') }}')">
                        <div class="sub-ico"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                        <div><div class="sub-name">Cadet Reports</div><div class="sub-desc">Export & print</div></div>
                    </a>
                    <a href="#" class="sb-sub-item" onclick="navigateTo(event, '{{ route('admin.cadets.index') }}')">
                        <div class="sub-ico"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg></div>
                        <div><div class="sub-name">B/C Certificate</div><div class="sub-desc">Exam & results</div></div>
                    </a>
                </div>
            </div>
        </div>

        {{-- Units --}}
        <div class="sb-group grp-violet" data-key="units" data-route="{{ route('admin.units.index') }}">
            <a href="#"
               class="sb-item {{ request()->routeIs('admin.units.*') ? 'is-violet' : '' }}"
               onclick="navigateTo(event, '{{ route('admin.units.index') }}', 'units')">
                <span class="sb-ico"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></span>
                <span class="sb-lbl">Units</span>
                <span class="sb-chev"><svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                <span class="sb-tip">Units</span>
            </a>
            <div class="sb-sub">
                <div class="sb-sub-inner">
                    <a href="#" class="sb-sub-item {{ request()->routeIs('admin.units.index') ? 'active':'' }}" onclick="navigateTo(event, '{{ route('admin.units.index') }}')">
                        <div class="sub-ico"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg></div>
                        <div><div class="sub-name">All Units</div><div class="sub-desc">Browse units</div></div>
                    </a>
                    <a href="#" class="sb-sub-item {{ request()->routeIs('admin.units.create') ? 'active':'' }}" onclick="navigateTo(event, '{{ route('admin.units.create') }}')">
                        <div class="sub-ico"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></div>
                        <div><div class="sub-name">Create Unit</div><div class="sub-desc">Add a new unit</div></div>
                    </a>
                    <div class="sub-div"></div>
                    <a href="#" class="sb-sub-item" onclick="navigateTo(event, '{{ route('admin.units.index') }}')">
                        <div class="sub-ico"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg></div>
                        <div><div class="sub-name">Wings / Branches</div><div class="sub-desc">Army · Navy · Air</div></div>
                    </a>
                    <a href="#" class="sb-sub-item" onclick="navigateTo(event, '{{ route('admin.units.index') }}')">
                        <div class="sub-ico"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
                        <div><div class="sub-name">Officers (ANO)</div><div class="sub-desc">Staff roster</div></div>
                    </a>
                    <a href="#" class="sb-sub-item" onclick="navigateTo(event, '{{ route('admin.units.index') }}')">
                        <div class="sub-ico"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></div>
                        <div><div class="sub-name">Unit Strength</div><div class="sub-desc">Cadet count</div></div>
                    </a>
                </div>
            </div>
        </div>

        {{-- Events --}}
        <div class="sb-group grp-amber" data-key="events" data-route="{{ route('admin.events.index') }}">
            <a href="#"
               class="sb-item {{ request()->routeIs('admin.events.*') ? 'is-amber' : '' }}"
               onclick="navigateTo(event, '{{ route('admin.events.index') }}', 'events')">
                <span class="sb-ico"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></span>
                <span class="sb-lbl">Events</span>
                <span class="sb-bdg a">3</span>
                <span class="sb-chev"><svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                <span class="sb-tip">Events</span>
            </a>
            <div class="sb-sub">
                <div class="sb-sub-inner">
                    <a href="#" class="sb-sub-item {{ request()->routeIs('admin.events.index') ? 'active':'' }}" onclick="navigateTo(event, '{{ route('admin.events.index') }}')">
                        <div class="sub-ico"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
                        <div><div class="sub-name">All Events</div><div class="sub-desc">View scheduled</div></div>
                    </a>
                    <a href="#" class="sb-sub-item {{ request()->routeIs('admin.events.create') ? 'active':'' }}" onclick="navigateTo(event, '{{ route('admin.events.create') }}')">
                        <div class="sub-ico"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></div>
                        <div><div class="sub-name">Schedule Event</div><div class="sub-desc">Create new</div></div>
                    </a>
                    <div class="sub-div"></div>
                    <a href="#" class="sb-sub-item" onclick="navigateTo(event, '{{ route('admin.events.index') }}')">
                        <div class="sub-ico"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
                        <div><div class="sub-name">Camps & Training</div><div class="sub-desc">ATC · RDC · CATC</div></div>
                    </a>
                    <a href="#" class="sb-sub-item" onclick="navigateTo(event, '{{ route('admin.events.index') }}')">
                        <div class="sub-ico"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg></div>
                        <div><div class="sub-name">Parades</div><div class="sub-desc">Republic Day etc.</div></div>
                    </a>
                    <a href="#" class="sb-sub-item" onclick="navigateTo(event, '{{ route('admin.events.index') }}')">
                        <div class="sub-ico"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></div>
                        <div><div class="sub-name">Event Reports</div><div class="sub-desc">Participation data</div></div>
                    </a>
                </div>
            </div>
        </div>

        {{-- Attendance --}}
        <div class="sb-group grp-rose" data-key="attendance" data-route="{{ route('admin.attendance.index') }}">
            <a href="#"
               class="sb-item {{ request()->routeIs('admin.attendance.*') ? 'is-rose' : '' }}"
               onclick="navigateTo(event, '{{ route('admin.attendance.index') }}', 'attendance')">
                <span class="sb-ico"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg></span>
                <span class="sb-lbl">Attendance</span>
                <span class="sb-chev"><svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                <span class="sb-tip">Attendance</span>
            </a>
            <div class="sb-sub">
                <div class="sb-sub-inner">
                    <a href="#" class="sb-sub-item {{ request()->routeIs('admin.attendance.index') ? 'active':'' }}" onclick="navigateTo(event, '{{ route('admin.attendance.index') }}')">
                        <div class="sub-ico"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg></div>
                        <div><div class="sub-name">Today's Register</div><div class="sub-desc">Mark present/absent</div></div>
                    </a>
                    <a href="#" class="sb-sub-item" onclick="navigateTo(event, '{{ route('admin.attendance.index') }}')">
                        <div class="sub-ico"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
                        <div><div class="sub-name">Monthly Register</div><div class="sub-desc">Full month view</div></div>
                    </a>
                    <div class="sub-div"></div>
                    <a href="#" class="sb-sub-item" onclick="navigateTo(event, '{{ route('admin.attendance.index') }}')">
                        <div class="sub-ico"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></div>
                        <div><div class="sub-name">Attendance Stats</div><div class="sub-desc">Rates & trends</div></div>
                    </a>
                    <a href="#" class="sb-sub-item" onclick="navigateTo(event, '{{ route('admin.attendance.index') }}')">
                        <div class="sub-ico"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></div>
                        <div><div class="sub-name">Absentee Alerts</div><div class="sub-desc">Low attendance</div></div>
                    </a>
                    <a href="#" class="sb-sub-item" onclick="navigateTo(event, '{{ route('admin.attendance.index') }}')">
                        <div class="sub-ico"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg></div>
                        <div><div class="sub-name">Export Register</div><div class="sub-desc">CSV / PDF</div></div>
                    </a>
                </div>
            </div>
        </div>

        {{-- ── NCC ACTIVITIES ── --}}
        <div class="sb-sec" style="margin-top:4px;"><div class="sb-sec-line"></div><span class="sb-sec-txt">NCC Activities</span></div>

        {{-- Training --}}
        <div class="sb-group grp-blue" data-key="training">
            <a href="#" class="sb-item" onclick="handleGroupClick(event,'training')">
                <span class="sb-ico"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></span>
                <span class="sb-lbl">Training</span>
                <span class="sb-chev"><svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                <span class="sb-tip">Training</span>
            </a>
            <div class="sb-sub">
                <div class="sb-sub-inner">
                    <a href="#" class="sb-sub-item">
                        <div class="sub-ico"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
                        <div><div class="sub-name">Training Schedule</div><div class="sub-desc">Weekly drill plan</div></div>
                    </a>
                    <a href="#" class="sb-sub-item">
                        <div class="sub-ico"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
                        <div><div class="sub-name">Annual Camp (ATC)</div><div class="sub-desc">Planning & records</div></div>
                    </a>
                    <a href="#" class="sb-sub-item">
                        <div class="sub-ico"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg></div>
                        <div><div class="sub-name">B/C Cert Exam</div><div class="sub-desc">Prep & grades</div></div>
                    </a>
                    <a href="#" class="sb-sub-item">
                        <div class="sub-ico"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg></div>
                        <div><div class="sub-name">NCC Awards</div><div class="sub-desc">Medals & honours</div></div>
                    </a>
                </div>
            </div>
        </div>

        {{-- Forms --}}
        <div class="sb-group grp-cyan" data-key="forms" data-route="{{ Route::has('admin.forms.index') ? route('admin.forms.index') : '#' }}">
            <a href="#"
               class="sb-item {{ request()->routeIs('admin.forms.*') ? 'is-cyan' : '' }}"
               onclick="navigateTo(event, '{{ Route::has('admin.forms.index') ? route('admin.forms.index') : '#' }}', 'forms')">
                <span class="sb-ico"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg></span>
                <span class="sb-lbl">Forms</span>
                <span class="sb-chev"><svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                <span class="sb-tip">Forms</span>
            </a>
            <div class="sb-sub">
                <div class="sb-sub-inner">
                    <a href="#" class="sb-sub-item {{ request()->routeIs('admin.forms.index') ? 'active':'' }}" onclick="navigateTo(event, '{{ Route::has('admin.forms.index') ? route('admin.forms.index') : '#' }}')">
                        <div class="sub-ico"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                        <div><div class="sub-name">All Forms</div><div class="sub-desc">All submissions</div></div>
                    </a>
                    <div class="sub-div"></div>
                    <a href="#" class="sb-sub-item {{ request()->routeIs('admin.forms.approved') ? 'active':'' }}" onclick="navigateTo(event, '{{ Route::has('admin.forms.approved') ? route('admin.forms.approved') : '#' }}')">
                        <div class="sub-ico"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
                        <div><div class="sub-name">Approved</div><div class="sub-desc">Cleared forms</div></div>
                    </a>
                    <a href="#" class="sb-sub-item {{ request()->routeIs('admin.forms.pending') ? 'active':'' }}" onclick="navigateTo(event, '{{ Route::has('admin.forms.pending') ? route('admin.forms.pending') : '#' }}')">
                        <div class="sub-ico"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                        <div><div class="sub-name">Pending</div><div class="sub-desc">Awaiting review</div></div>
                    </a>
                    <a href="#" class="sb-sub-item {{ request()->routeIs('admin.forms.rejected') ? 'active':'' }}" onclick="navigateTo(event, '{{ Route::has('admin.forms.rejected') ? route('admin.forms.rejected') : '#' }}')">
                        <div class="sub-ico"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg></div>
                        <div><div class="sub-name">Rejected</div><div class="sub-desc">Declined forms</div></div>
                    </a>
                </div>
            </div>
        </div>

        {{-- ── SYSTEM ── --}}
        <div class="sb-sec" style="margin-top:4px;"><div class="sb-sec-line"></div><span class="sb-sec-txt">System</span></div>

        {{-- Settings --}}
        <div class="sb-group grp-blue" data-key="settings" data-route="{{ route('admin.profile.edit') }}">
            <a href="#"
               class="sb-item {{ request()->routeIs('admin.profile.*') ? 'is-blue' : '' }}"
               onclick="navigateTo(event, '{{ route('admin.profile.edit') }}', 'settings')">
                <span class="sb-ico"><svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg></span>
                <span class="sb-lbl">Settings</span>
                <span class="sb-chev"><svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                <span class="sb-tip">Settings</span>
            </a>
            <div class="sb-sub">
                <div class="sb-sub-inner">
                    <a href="#" class="sb-sub-item {{ request()->routeIs('admin.profile.edit') ? 'active':'' }}" onclick="navigateTo(event, '{{ route('admin.profile.edit') }}')">
                        <div class="sub-ico"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
                        <div><div class="sub-name">My Profile</div><div class="sub-desc">Account info</div></div>
                    </a>
                    <a href="#" class="sb-sub-item">
                        <div class="sub-ico"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div>
                        <div><div class="sub-name">Security</div><div class="sub-desc">Password & 2FA</div></div>
                    </a>
                    <a href="#" class="sb-sub-item">
                        <div class="sub-ico"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg></div>
                        <div><div class="sub-name">Notifications</div><div class="sub-desc">Alerts & prefs</div></div>
                    </a>
                    <a href="#" class="sb-sub-item">
                        <div class="sub-ico"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></div>
                        <div><div class="sub-name">System Logs</div><div class="sub-desc">Audit trail</div></div>
                    </a>
                </div>
            </div>
        </div>

    </nav>

    <div class="sb-foot">
        <div class="sb-av-wrap"><div class="sb-av">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div></div>
        <div class="sb-user-txt">
            <div class="sb-uname">{{ auth()->user()->name ?? 'Admin' }}</div>
            <div class="sb-urole">Administrator</div>
        </div>
        <form method="POST" action="{{ route('logout') }}" style="flex-shrink:0;">
            @csrf
            <button type="submit" class="sb-logout-btn" title="Logout">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            </button>
        </form>
    </div>

</aside>

{{-- ════════════ MAIN CONTENT ════════════ --}}
<div class="main-wrap" id="mainWrap">
    <header class="desk-bar">
        <div class="dbar-l">
            <a href="{{ route('admin.dashboard') }}" class="tb-ncc-logo">
                <div class="tb-ncc-badge"><svg fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7v9c0 4.5 4.5 6.5 10 7 5.5-.5 10-2.5 10-7V7L12 2z"/></svg></div>
                <div><div class="tb-ncc-name">NCC</div><div class="tb-ncc-sub">Admin Panel</div></div>
            </a>
            <span class="dbar-sep">/</span>
            <span class="dbar-page" id="currentPage">Dashboard</span>
        </div>
        <div class="dbar-r">
            <div class="live-pill"><span class="live-dot"></span>Live</div>
            <div class="dbar-line"></div>
            <div class="theme-toggle" onclick="toggleTheme()" title="Toggle light / dark">
                <svg class="ico-sun" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
                <svg class="ico-moon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
            </div>
            <div class="dbar-btn" title="Notifications">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                <span class="notif-dot"></span>
            </div>
            <div class="dbar-btn" title="Search">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </div>
            <div class="dbar-line"></div>
            <div class="dbar-user">
                <div class="dbar-uav">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
                <div>
                    <div class="dbar-uname">{{ auth()->user()->name ?? 'Admin' }}</div>
                    <div class="dbar-urole">Administrator</div>
                </div>
            </div>
        </div>
    </header>

    <div class="page-wrap {{ request()->routeIs('admin.dashboard') ? 'flush' : '' }}">
        @yield('content')
    </div>
</div>

</div>{{-- /.app-shell --}}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
const html      = document.documentElement;
const sidebar   = document.getElementById('sidebar');
const mainWrap  = document.getElementById('mainWrap');

/* ── Theme ── */
function applyTheme(t) {
    html.setAttribute('data-theme', t);
    localStorage.setItem('ncc-theme', t);
    if (window.Chart) {
        const isLight = t === 'light';
        Chart.defaults.color = isLight ? '#3D546E' : '#475569';
        const gc = isLight ? 'rgba(15,30,60,0.07)' : 'rgba(255,255,255,0.04)';
        Object.values(Chart.instances || {}).forEach(c => {
            if (c.options.scales) Object.values(c.options.scales).forEach(s => {
                if (s.ticks) s.ticks.color = isLight ? '#3D546E' : '#475569';
                if (s.grid)  s.grid.color  = gc;
            });
            c.update('none');
        });
    }
}
(function(){ applyTheme(localStorage.getItem('ncc-theme') === 'light' ? 'light' : 'dark'); })();
function toggleTheme(){ applyTheme(html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark'); }

/* ── Sidebar pin ── */
let pinned = localStorage.getItem('ncc-sb-pinned') === 'true';
function applyPin() { sidebar.classList.toggle('pinned', pinned); mainWrap.classList.toggle('pinned', pinned); }
applyPin();
function togglePin(e) { e.stopPropagation(); pinned = !pinned; localStorage.setItem('ncc-sb-pinned', pinned); applyPin(); }

/* ── Mobile ── */
function toggleMob() { sidebar.classList.toggle('mob-open'); document.getElementById('mobOverlay').classList.toggle('show'); }

/* ── Breadcrumb ── */
document.querySelectorAll('.sb-item').forEach(item => {
    if (['is-blue','is-green','is-amber','is-rose','is-violet'].some(c => item.classList.contains(c))) {
        const lbl = item.querySelector('.sb-lbl');
        if (lbl) document.getElementById('currentPage').textContent = lbl.textContent.trim();
    }
});

/* ══════════════════════════════════════
   ACCORDION LOGIC
   ─ Clicking a collapsed group HEADER:
     • If sidebar is rail (collapsed) → navigate normally (no submenu shown)
     • If sidebar is expanded → open submenu (prevent nav only on first click)
   ─ Clicking an already-open group HEADER → navigate to its href
   ─ Only one group open at a time
══════════════════════════════════════ */
function isSidebarExpanded() {
    return sidebar.matches(':hover') || sidebar.classList.contains('pinned') || sidebar.classList.contains('mob-open');
}

function openGroup(key) {
    document.querySelectorAll('.sb-group').forEach(g => {
        g.classList.toggle('open', g.dataset.key === key);
    });
    sessionStorage.setItem('ncc-open-group', key);
}

function closeAll() {
    document.querySelectorAll('.sb-group').forEach(g => g.classList.remove('open'));
    sessionStorage.removeItem('ncc-open-group');
}

/* ══════════════════════════════════════
   NAVIGATION WITH HIDDEN ROUTES
   ─ Shows clean URL in address bar
   ─ Actual routes are masked from view
══════════════════════════════════════ */
function navigateTo(e, actualRoute, groupKey) {
    e.preventDefault();
    e.stopPropagation();

    if (!actualRoute || actualRoute === '#') return;

    // Expand the group if sidebar is expanded
    if (isSidebarExpanded() && groupKey) {
        openGroup(groupKey);
    }

    // Simply navigate to the actual route
    // URL masking happens via JavaScript on page load
    window.location.href = actualRoute;
}

function handleGroupClick(e, key) {
    /* Sidebar is collapsed to icon rail — let the link navigate normally */
    if (!isSidebarExpanded()) return;

    const group  = document.querySelector(`.sb-group[data-key="${key}"]`);
    if (!group) return;

    const link = group.querySelector('.sb-item');
    const href = link ? link.getAttribute('href') : null;
    
    /* If href is '#' or no valid route, just toggle the menu */
    if (!href || href === '#') {
        e.preventDefault();
        if (!group.classList.contains('open')) {
            openGroup(key);
        }
        return;
    }

    /* If already open — let the click navigate to the page */
    if (group.classList.contains('open')) {
        return; /* Allow natural navigation */
    }

    /* First click while expanded — open the submenu instead of navigating */
    e.preventDefault();
    openGroup(key);
}

/* Auto-open the active section on page load */
(function () {
    // Try to restore from session
    const saved = sessionStorage.getItem('ncc-open-group');

    // Find whichever group has an active item
    let activeKey = null;
    document.querySelectorAll('.sb-group').forEach(g => {
        if (g.querySelector('.sb-item.is-blue,.sb-item.is-green,.sb-item.is-amber,.sb-item.is-rose,.sb-item.is-violet')) {
            activeKey = g.dataset.key;
        }
    });

    const keyToOpen = activeKey || saved;
    if (keyToOpen) {
        // Use a tick so CSS transition fires correctly
        requestAnimationFrame(() => openGroup(keyToOpen));
    }
})();

/* Close submenus when sidebar collapses back to rail */
sidebar.addEventListener('mouseleave', () => {
    if (!pinned) {
        /* Small delay so the transition looks clean */
        setTimeout(() => {
            if (!sidebar.matches(':hover') && !pinned) closeAll();
        }, 50);
    }
});

/* Re-open active group when sidebar expands again */
sidebar.addEventListener('mouseenter', () => {
    const saved = sessionStorage.getItem('ncc-open-group');
    if (saved) openGroup(saved);
});
</script>
</body>
</html>