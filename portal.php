<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eICT Desk Portal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/mermaid/dist/mermaid.min.js"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scrollbar-width: none; -ms-overflow-style: none; }
        html::-webkit-scrollbar { display: none; width: 0; height: 0; }
        body { scrollbar-width: none; -ms-overflow-style: none; }
        body::-webkit-scrollbar { display: none; width: 0; height: 0; }
        .portal-modal-content, .hist-table-wrap, .flow-card, #portalActivityList { scrollbar-width: none; -ms-overflow-style: none; }
        .portal-modal-content::-webkit-scrollbar, .hist-table-wrap::-webkit-scrollbar, .flow-card::-webkit-scrollbar, #portalActivityList::-webkit-scrollbar { display: none; width: 0; height: 0; }
        html { height: 100%; }
        body { font-family: "Outfit", sans-serif; height: 100vh; min-height: 100vh; display: flex; align-items: flex-start; justify-content: center; padding: 5rem 1rem 1rem; position: relative; overflow-y: hidden; overflow-x: hidden; background:
                radial-gradient(circle at 78% 14%, rgba(220,38,38,0.12), transparent 12%),
                radial-gradient(circle at 18% 86%, rgba(37,99,235,0.12), transparent 14%),
                linear-gradient(135deg, #fff 0%, #eef2ff 48%, #fee2e2 100%); }
        .bg-image { position: fixed; inset: 0; background: url("assets/images/bangunan-mpm.jpg") center/cover no-repeat; filter: blur(4px) brightness(0.88) saturate(0.95); transform: scale(1.08); z-index: 0; opacity: 0.24; }
        .bg-overlay { position: fixed; inset: 0; background: linear-gradient(135deg,rgba(255,255,255,.55),rgba(219,234,254,.22)); z-index: 1; }
        .top-logo { position: fixed; top: 1.3rem; left: 50%; transform: translateX(-50%); z-index: 20; display: flex; align-items: center; gap: .7rem; }
        .top-logo img { height: 42px; filter: drop-shadow(0 2px 8px rgba(0,0,0,.4)); }
        .top-logo-text { font-size: 1.2rem; font-weight: 800; color: #24324b; text-shadow: 0 2px 10px rgba(0,0,0,.14); }
        .top-logo-text span { color: #dc2626; }
        .portal-layout { position: relative; z-index: 10; width: min(1180px, calc(100vw - 1rem)); display: flex; align-items: flex-start; gap: 1rem; justify-content: center; overflow: visible; }
        .card-shell { position: relative; z-index: 10; width: min(430px, 100%); max-width: 430px; flex: 0 0 430px; }
        .wide-content { position: relative; z-index: 10; width: min(980px, 100%); max-width: 980px; flex: 0 0 980px; display: none; }
        .wide-content.active { display: block; }
        .dashboard-side-view { position: relative; z-index: 10; width: min(720px, 100%); max-width: 720px; flex: 1 1 620px; display: none; }
        .dashboard-side-view.active { display: block; }
        .dashboard-side-card { width: 140px; min-width: 140px; background: linear-gradient(160deg, rgba(255,255,255,.96), rgba(248,250,252,.92)); border: 1px solid rgba(37,99,235,.24); border-radius: 22px; padding: .6rem; box-shadow: 0 16px 40px rgba(0,0,0,.12), inset 0 0 0 1px rgba(255,255,255,.86); display: flex; flex-direction: column; align-items: flex-start; justify-content: center; gap: .45rem; }
        .dashboard-side-card-title { color: #dc2626; font-size: .70rem; font-weight: 900; letter-spacing: .14em; text-transform: uppercase; }
        .dashboard-side-card-name { color: #24324b; font-size: .95rem; font-weight: 800; }
        .dashboard-side-card-copy { color: #66768c; font-size: .70rem; line-height: 1.30; }
        .dashboard-side-card-button { width: 100%; padding: .55rem .75rem; background: linear-gradient(135deg, #2563eb, #dc2626); color: #fff; border: none; border-radius: 12px; font-family: "Outfit",sans-serif; font-size: .72rem; font-weight: 800; cursor: pointer; transition: transform .2s ease, box-shadow .2s ease; box-shadow: 0 8px 20px rgba(37,99,235,.14); }
        .dashboard-side-card-button:hover { transform: translateY(-2px); box-shadow: 0 10px 26px rgba(220,38,38,.16); }
        .view { display: none; flex-direction: column; max-height: calc(100vh - 6.5rem); width: 100%; background: rgba(255,255,255,.78); backdrop-filter: blur(14px) saturate(180%); -webkit-backdrop-filter: blur(14px) saturate(180%); border: 1px solid rgba(255,255,255,.88); border-radius: 22px; padding: 1.5rem 1.8rem; box-shadow: 0 24px 70px rgba(0,0,0,.12), inset 0 1px 0 rgba(255,255,255,.9); animation: fadeUp .4s cubic-bezier(.22,1,.36,1) both; color: #24324b; overflow: hidden; transform: translateZ(0); }
        .view.active { display: flex; }
        @keyframes fadeUp { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
        .back-btn { display: inline-flex; align-self: flex-start; align-items: center; gap: .4rem; background: rgba(255,255,255,.78); border: 1px solid rgba(37,99,235,.22); border-radius: 20px; color: #24324b; font-family: "Outfit",sans-serif; font-size: .78rem; font-weight: 800; padding: .4rem 1rem; cursor: pointer; margin-bottom: 1.5rem; transition: all .2s; }
        .back-btn:hover { background: rgba(37,99,235,.12); color: #24324b; }
        .view-heading { font-size: 1.5rem; font-weight: 800; color: #24324b; margin-bottom: 1.5rem; }
        .view-subheading { font-size: .78rem; color: #66768c; letter-spacing: .12em; text-transform: uppercase; margin-bottom: .3rem; }
        .home-grid { display: flex; flex-direction: column; flex: 1; min-height: 0; width: 100%; gap: 1.5rem; align-items: center; justify-content: flex-start; overflow-y: auto; padding-right: 4px; padding-bottom: 1rem; }
        .home-grid::-webkit-scrollbar { width: 4px; }
        .home-grid::-webkit-scrollbar-thumb { background: rgba(37,99,235,.2); border-radius: 4px; }
        .user-section { display: flex; flex-direction: column; align-items: center; gap: 1rem; }
        .avatar-wrapper { position: relative; width: 148px; height: 148px; display: flex; align-items: center; justify-content: center; }
        .avatar-ring { position: absolute; inset: 0; border-radius: 50%; background: conic-gradient(from 0deg,#dc2626,#2563eb,#dbeafe,#dc2626); animation: spinRing 4s linear infinite; }
        @keyframes spinRing { to { transform: rotate(360deg); } }
        .avatar-inner { width: 140px; height: 140px; border-radius: 50%; overflow: hidden; position: relative; z-index: 1; background: linear-gradient(135deg,#2563eb,#dc2626); display: flex; align-items: center; justify-content: center; border: 4px solid rgba(255,255,255,.8); }
        .avatar-inner img { width: 100%; height: 100%; object-fit: cover; }
        .avatar-placeholder { font-size: 3.5rem; font-weight: 800; color: rgba(255,255,255,.9); user-select: none; }
        .user-name { font-size: 1.1rem; font-weight: 700; color: #24324b; text-align: center; text-shadow: 0 2px 8px rgba(0,0,0,.08); }
        .user-jawatan { font-size: .8rem; color: #66768c; text-align: center; }
        .user-dept { font-size: .75rem; color: #dc2626; text-align: center; font-weight: 700; background: #fee2e2; padding: .25rem .9rem; border-radius: 20px; border: 1px solid rgba(37,99,235,.22); }
        .user-actions { display: flex; gap: .6rem; }
        .btn-action { display: flex; align-items: center; gap: .4rem; padding: .45rem 1rem; border-radius: 20px; font-family: "Outfit",sans-serif; font-size: .76rem; font-weight: 700; cursor: pointer; transition: all .2s; text-decoration: none; border: none; }
        .btn-edit { background: rgba(37,99,235,.08); color: #24324b; border: 1px solid rgba(37,99,235,.22); }
        .btn-edit:hover { background: rgba(37,99,235,.16); transform: translateY(-1px); }
        .btn-dashboard { background: rgba(37,99,235,.08); color: #2563eb; border: 1px solid rgba(37,99,235,.22); }
        .btn-dashboard:hover { background: rgba(37,99,235,.16); transform: translateY(-1px); }
        .btn-logout { background: rgba(220,38,38,.08); color: #dc2626; border: 1px solid rgba(220,38,38,.22); }
        .btn-logout:hover { background: rgba(220,38,38,.16); transform: translateY(-1px); }
        .portal-grid { display: flex; flex-direction: column; gap: .65rem; align-items: stretch; width: min(290px, 100%); }
        .portal-btn { display: flex; align-items: center; gap: 1rem; padding: .85rem 1.2rem; background: rgba(255,255,255,.76); border: 1px solid rgba(37,99,235,.22); border-radius: 14px; color: #24324b; font-family: "Outfit",sans-serif; font-size: .84rem; font-weight: 700; cursor: pointer; text-decoration: none; transition: background .25s cubic-bezier(.22,1,.36,1), border-color .25s cubic-bezier(.22,1,.36,1), box-shadow .25s cubic-bezier(.22,1,.36,1); position: relative; overflow: hidden; width: 100%; isolation: isolate; }
        .portal-btn:hover { background: rgba(37,99,235,.08); border-color: rgba(220,38,38,.3); box-shadow: 0 8px 24px rgba(0,0,0,.1); }
        .portal-btn-icon { width: 34px; height: 34px; border-radius: 9px; display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0; }
        .icon-blue { background: rgba(37,99,235,.12); color: #2563eb; } .icon-purple { background: rgba(167,139,250,.14); color: #dc2626; } .icon-cyan { background: rgba(6,182,212,.10); color: #2563eb; } .icon-amber { background: rgba(245,158,11,.10); color: #dc2626; } .icon-rose { background: rgba(244,63,94,.10); color: #dc2626; }
        .portal-btn-label { flex: 1; }
        .portal-btn-arrow { font-size: 1.1rem; opacity: .4; transition: opacity .2s; }
        .portal-btn:hover .portal-btn-arrow { opacity: 1; }
        .portal-static-scroll .portal-btn-arrow { display: inline; }
        button:disabled { opacity: .62; cursor: default; }
        button:disabled:hover { transform: none; box-shadow: none; }
        .portal-static-note { display: block; margin-top: .18rem; color: #66768c; font-size: .68rem; font-weight: 600; line-height: 1.25; }
        .portal-static-scroll { max-height: none; min-height: auto; overflow: visible; padding-right: 0; }
        .admin-only { display: none; }
        .portal-divider { height: 1px; background: rgba(37,99,235,.12); margin: .6rem 0; }
        .settings-link { display: flex; align-items: center; gap: .45rem; color: #66768c; font-size: .77rem; font-weight: 700; text-decoration: none; transition: color .2s; cursor: pointer; background: none; border: none; font-family: "Outfit",sans-serif; letter-spacing: .04em; padding: .2rem 0; }
        .settings-link:hover { color: #dc2626; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .form-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; }
        .form-grid-3 .form-group.full { grid-column: 1 / -1; }
        .form-grid-3 .form-group.span2 { grid-column: span 2; }
        .form-group { display: flex; flex-direction: column; gap: .4rem; }
        .form-group.full { grid-column: 1 / -1; }
        .form-label { font-size: .75rem; font-weight: 700; color: #66768c; letter-spacing: .08em; text-transform: uppercase; }
        .form-input, .form-select, .form-textarea { background: rgba(255,255,255,.86); border: 1px solid rgba(37,99,235,.22); border-radius: 10px; padding: .7rem 1rem; color: #24324b; font-family: "Outfit",sans-serif; font-size: .88rem; font-weight: 500; outline: none; transition: border-color .2s,background .2s; width: 100%; }
        .form-input::placeholder { color: #66768c; }
        .form-input:focus, .form-select:focus, .form-textarea:focus { border-color: #2563eb; background: rgba(255,255,255,1); box-shadow: 0 0 0 3px rgba(37,99,235,.08); }
        .form-select option { background: #fff; color: #24324b; }
        .form-textarea { resize: vertical; min-height: 90px; }
        .avatar-upload-area { display: flex; align-items: center; gap: 1.5rem; margin-bottom: 1.5rem; }
        .avatar-preview { width: 80px; height: 80px; border-radius: 50%; overflow: hidden; background: linear-gradient(135deg,#2563eb,#dc2626); display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 800; color: rgba(255,255,255,.9); border: 3px solid rgba(255,255,255,.8); flex-shrink: 0; }
        .avatar-preview img { width: 100%; height: 100%; object-fit: cover; }
        .avatar-upload-btn { display: inline-flex; align-items: center; gap: .5rem; background: rgba(37,99,235,.08); border: 1px solid rgba(37,99,235,.22); border-radius: 20px; color: #2563eb; font-family: "Outfit",sans-serif; font-size: .78rem; font-weight: 700; padding: .45rem 1rem; cursor: pointer; transition: all .2s; }
        .avatar-upload-btn:hover { background: rgba(37,99,235,.14); }
        .btn-primary { background: linear-gradient(135deg, #2563eb, #dc2626); border: none; border-radius: 12px; color: #fff; font-family: "Outfit",sans-serif; font-size: .88rem; font-weight: 800; padding: .75rem 1.5rem; cursor: pointer; transition: all .2s; box-shadow: 0 4px 15px rgba(37,99,235,.14); }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 8px 25px rgba(220,38,38,.16); }
        .btn-ghost { background: rgba(255,255,255,.74); border: 1px solid rgba(37,99,235,.22); border-radius: 12px; color: #24324b; font-family: "Outfit",sans-serif; font-size: .88rem; font-weight: 700; padding: .75rem 1.5rem; cursor: pointer; transition: all .2s; }
        .btn-ghost:hover { background: rgba(37,99,235,.08); }
        .alert { padding: .7rem 1rem; border-radius: 10px; font-size: .82rem; font-weight: 600; margin-bottom: 1rem; display: none; }
        .alert-success { background: rgba(16,185,129,.12); color: #16a34a; border: 1px solid rgba(16,185,129,.2); }
        .alert-error { background: rgba(239,68,68,.12); color: #dc2626; border: 1px solid rgba(239,68,68,.2); }
        .view-scroll { flex: 1; min-height: 0; overflow-y: auto; overflow-x: visible; overscroll-behavior: contain; padding-right: 4px; }
        .view-scroll::-webkit-scrollbar { width: 4px; }
        .view-scroll::-webkit-scrollbar-thumb { background: rgba(37,99,235,.2); border-radius: 4px; }
        .strength-bar { height: 4px; border-radius: 4px; background: rgba(37,99,235,.08); margin-top: .4rem; overflow: hidden; }
        .strength-fill { height: 100%; border-radius: 4px; transition: width .3s,background .3s; width: 0%; }
        .pw-info-wrap { position: relative; display: inline-flex; align-items: center; margin-left: .35rem; }
        .pw-info-icon { width: 16px; height: 16px; border-radius: 50%; background: rgba(37,99,235,.12); color: #2563eb; font-size: .65rem; font-weight: 800; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; line-height: 1; }
        .pw-info-tooltip { display: none; position: fixed; background: rgba(255,255,255,.97); border: 1px solid rgba(37,99,235,.18); border-radius: 12px; padding: .75rem 1rem; box-shadow: 0 8px 24px rgba(0,0,0,.12); width: 260px; z-index: 9999; font-size: .72rem; color: #24324b; text-transform: none; letter-spacing: normal; font-weight: 500; }
        .pw-info-tooltip::after { content: ''; position: absolute; top: 100%; left: 50%; transform: translateX(-50%); border: 6px solid transparent; border-top-color: rgba(37,99,235,.18); }
        .pw-info-tooltip.active { display: block; }
        .info-row { display: flex; justify-content: space-between; font-size: .83rem; padding: .3rem 0; border-bottom: 1px solid rgba(37,99,235,.10); }
        .info-row:last-child { border-bottom: none; }

        .dashboard-banner { background: linear-gradient(135deg, #2563eb, #dc2626); color: #fff; border-radius: 16px; padding: 1.8rem; box-shadow: 0 12px 30px rgba(37,99,235,.14); margin-bottom: 1rem; }
        .dashboard-banner-title { font-size: 1.6rem; font-weight: 800; margin-bottom: .6rem; color: #fff; }
        .dashboard-banner-text { color: rgba(255,255,255,.86); font-size: .88rem; line-height: 1.6; max-width: 620px; }
        .dashboard-banner-actions { display: flex; gap: .75rem; flex-wrap: wrap; margin-top: 1rem; }
        .dashboard-banner-actions .btn-primary { background: #fff; color: #24324b; box-shadow: none; }
        .dashboard-banner-actions .btn-ghost { background: rgba(255,255,255,.12); color: #fff; border-color: rgba(255,255,255,.4); }

        .dashboard-summary { display: grid; grid-template-columns: repeat(3, minmax(170px, 1fr)); gap: 1rem; margin: 1.2rem 0 1rem; }
        .dashboard-stat { display: flex; align-items: center; gap: .9rem; background: rgba(255,255,255,.84); border: 1px solid rgba(37,99,235,.2); border-radius: 14px; padding: 1rem; }
        .dashboard-stat-icon { width: 42px; height: 42px; border-radius: 10px; background: #dbeafe; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0; }
        .dashboard-stat-label { font-size: .76rem; font-weight: 700; color: #66768c; text-transform: uppercase; letter-spacing: .05em; }
        .dashboard-stat-value { font-size: 1.65rem; font-weight: 800; color: #24324b; margin-top: .1rem; }

        .dashboard-list { background: rgba(255,255,255,.76); border: 1px solid rgba(37,99,235,.2); border-radius: 14px; padding: 1.2rem; margin-top: 1rem; }
        .dashboard-list-title { font-size: .84rem; font-weight: 800; color: #24324b; text-transform: uppercase; letter-spacing: .04em; margin-bottom: .9rem; }
        .dashboard-list-row { display: flex; align-items: center; gap: .7rem; padding: .75rem 0; border-top: 1px solid rgba(37,99,235,.1); color: #66768c; }
        .dashboard-list-status-dot { width: 8px; height: 8px; border-radius: 50%; background: #dc2626; box-shadow: 0 0 0 3px rgba(220,38,38,.08); }
        .dashboard-list-copy { font-size: .84rem; color: #24324b; font-weight: 700; }
        .flow-card { background: rgba(255,255,255,.88); border: 1px solid rgba(37,99,235,.2); border-radius: 14px; padding: 1.2rem; overflow: auto; text-align: center; }
        .flow-card svg { max-width: 100%; height: auto; }
        .flow-toggle-head { display: flex; justify-content: space-between; align-items: center; gap: .75rem; flex-wrap: wrap; }
        .flow-toggle-btn { font-size: .75rem; color: #2563eb; background: rgba(37,99,235,.08); border: 1px solid rgba(37,99,235,.18); border-radius: 999px; cursor: pointer; font-weight: 800; font-family: Outfit,sans-serif; padding: .4rem .75rem; }
        .flow-toggle-btn:hover { background: rgba(37,99,235,.14); }

        .hist-filter-bar { display: flex; gap: .85rem; margin-bottom: .9rem; flex-wrap: wrap; align-items: flex-start; background: rgba(0,0,0,.015); padding: 1rem 1.1rem; border-radius: 14px; border: 1px solid rgba(37,99,235,.14); }
        .hist-filter-row { display: flex; align-items: center; gap: .55rem; }
        .hist-legend { margin-left: auto; display: flex; flex-direction: column; gap: .35rem; font-size: .72rem; font-weight: 600; background: #fff; padding: .7rem 1rem; border-radius: 12px; border: 1px solid rgba(37,99,235,.16); }
        .hist-legend-title { color: #66768c; border-bottom: 1px solid rgba(37,99,235,.12); padding-bottom: .2rem; margin-bottom: .15rem; }
        .hist-legend-grid { display: flex; gap: 1rem; flex-wrap: wrap; align-items: center; }
        .hist-legend-item { display: flex; align-items: center; gap: .45rem; color: #24324b; }
        .hist-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
        .hist-table-wrap { overflow-x: auto; min-height: 220px; }
        .hist-table { width: 100%; border-collapse: collapse; min-width: 720px; }
        .hist-table th { text-align: left; padding: .75rem .55rem; color: #66768c; font-size: .68rem; text-transform: uppercase; letter-spacing: .04em; border-bottom: 2px solid rgba(37,99,235,.14); white-space: nowrap; }
        .hist-table td { padding: .75rem .55rem; border-bottom: 1px solid rgba(37,99,235,.1); color: #24324b; font-size: .78rem; vertical-align: middle; }
        .hist-table tr:last-child td { border-bottom: none; }
        .hist-pager { display: flex; align-items: center; justify-content: space-between; padding: .9rem .2rem 0; border-top: 1px solid rgba(37,99,235,.1); flex-wrap: wrap; gap: .7rem; margin-top: .4rem; }
        .btn-lihat { background: linear-gradient(135deg, #2563eb, #dc2626); color: #fff; border: none; border-radius: 8px; padding: .4rem .75rem; font-family: "Outfit",sans-serif; font-size: .72rem; font-weight: 700; cursor: pointer; }
        .portal-modal { display: none; position: fixed; inset: 0; z-index: 80; background: rgba(15,23,42,.45); backdrop-filter: blur(8px); align-items: center; justify-content: center; padding: 1rem; }
        .portal-modal.active { display: flex; }
        .portal-modal-content { background: #fff; border-radius: 20px; max-width: 860px; width: 100%; max-height: 90vh; overflow-y: auto; padding: 1.5rem 1.8rem; box-shadow: 0 24px 70px rgba(0,0,0,.2); color: #24324b; }
        .portal-modal-content h2 { font-size: 1.2rem; margin-bottom: .2rem; }
        .portal-modal-content h4 { color: #2563eb; margin: 1.1rem 0 .7rem; padding-bottom: .4rem; border-bottom: 1px solid rgba(37,99,235,.14); font-size: .88rem; }
        .modal-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .85rem; }
        .modal-close { background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #66768c; line-height: 1; }

        /* ── Stylings for Aset Saya ── */
        .asset-view-header { display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; flex-wrap: wrap; margin-bottom: 1.2rem; }
        .asset-tab-pill { padding: .45rem 1rem; border-radius: 20px; font-size: .8rem; font-weight: 700; border: 1px solid rgba(37,99,235,.2); background: rgba(255,255,255,.7); color: #24324b; cursor: pointer; transition: all .2s; }
        .asset-tab-pill:hover { background: rgba(37,99,235,.1); }
        .asset-tab-pill.active { background: linear-gradient(135deg, #2563eb, #dc2626); color: #fff; border-color: transparent; box-shadow: 0 4px 12px rgba(37,99,235,.2); }
        .asset-card { background: rgba(255,255,255,.88); border: 1px solid rgba(37,99,235,.18); border-radius: 16px; padding: 1.3rem; margin-bottom: 1rem; box-shadow: 0 4px 20px rgba(0,0,0,.03); transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease; position: relative; }
        .asset-card:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(37,99,235,.12); border-color: rgba(37,99,235,.35); }
        .asset-card-top { display: flex; justify-content: space-between; align-items: center; gap: .75rem; flex-wrap: wrap; margin-bottom: .75rem; }
        .asset-card-badges { display: flex; align-items: center; gap: .5rem; flex-wrap: wrap; }
        .asset-badge { font-size: .72rem; font-weight: 800; padding: .25rem .65rem; border-radius: 20px; letter-spacing: .02em; display: inline-flex; align-items: center; gap: .35rem; }
        .asset-badge-type { background: #dbeafe; color: #1d4ed8; border: 1px solid rgba(37,99,235,.2); }
        .asset-badge-admin { background: #dcfce7; color: #15803d; border: 1px solid rgba(34,197,94,.25); }
        .asset-badge-sn { font-family: monospace; font-size: .82rem; font-weight: 700; background: #f1f5f9; color: #1e293b; padding: .25rem .6rem; border-radius: 6px; border: 1px solid #cbd5e1; }
        .asset-card-title { font-size: 1.2rem; font-weight: 800; color: #1e293b; display: flex; align-items: center; gap: .5rem; }
        .asset-specs-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: .65rem; margin: .9rem 0; background: rgba(248,250,252,.85); border: 1px solid rgba(226,232,240,.9); border-radius: 12px; padding: .85rem 1rem; }
        .asset-spec-item { display: flex; flex-direction: column; gap: 2px; }
        .asset-spec-label { font-size: .68rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: .05em; }
        .asset-spec-value { font-size: .84rem; font-weight: 700; color: #1e293b; word-break: break-word; }
        .asset-thumb-strip { display: flex; gap: .5rem; margin: .75rem 0; align-items: center; }
        .asset-thumb { width: 52px; height: 52px; border-radius: 8px; object-fit: cover; border: 1px solid rgba(37,99,235,.2); cursor: pointer; transition: transform .2s; }
        .asset-thumb:hover { transform: scale(1.08); }
        .asset-card-actions { display: flex; align-items: center; gap: .5rem; flex-wrap: wrap; margin-top: .85rem; padding-top: .85rem; border-top: 1px solid rgba(37,99,235,.12); }
        .btn-asset-report { background: linear-gradient(135deg, #2563eb, #dc2626); color: #fff; border: none; border-radius: 10px; font-weight: 700; font-size: .78rem; padding: .45rem .95rem; cursor: pointer; display: inline-flex; align-items: center; gap: .35rem; transition: all .2s; }
        .btn-asset-report:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(220,38,38,.25); }
        .btn-asset-action { background: rgba(255,255,255,.9); color: #24324b; border: 1px solid rgba(37,99,235,.22); border-radius: 10px; font-weight: 700; font-size: .78rem; padding: .45rem .85rem; cursor: pointer; display: inline-flex; align-items: center; gap: .35rem; transition: all .2s; }
        .btn-asset-action:hover { background: rgba(37,99,235,.08); color: #2563eb; }

        @media(max-width:768px) { body { overflow:auto; } .portal-layout { flex-direction: column; max-height: none; overflow: visible; } .card-shell, .dashboard-side-view { flex: 0 0 auto; max-width: 100%; width: 100%; } .home-grid { grid-template-columns: 1fr; gap: 2rem; } .form-grid, .form-grid-3, .modal-grid { grid-template-columns: 1fr; } .view { padding: 1.8rem 1.4rem; } .dashboard-summary { grid-template-columns: 1fr; } .card-shell.wide-borang { flex: 0 0 100%; max-width: 100%; } .hist-legend { margin-left: 0; width: 100%; } .portal-static-scroll { max-height: none; } }
    </style>
</head>
<body>
<div class="bg-image"></div>
<div class="bg-overlay"></div>
<div class="top-logo">
    <img src="assets/images/logo-mpm.png" alt="MPM">
    <span class="top-logo-text">eICT <span>Desk</span></span>
</div>

<div class="portal-layout">
<div class="card-shell">

<!-- VIEW: HOME -->
<div class="view active" id="view-home">
    <div class="home-grid">
        <div class="user-section">
            <div class="avatar-wrapper">
                <div class="avatar-ring"></div>
                <div class="avatar-inner">
                    <img id="homeAvatar" src="" alt="" style="display:none;">
                    <span class="avatar-placeholder" id="homeInitial">?</span>
                </div>
            </div>
            <div style="text-align:center;">
                <div class="user-name" id="homeName">Memuatkan...</div>
                <div class="user-jawatan" id="homeJawatan"></div>
            </div>
            <div class="user-dept" id="homeDept" style="display:none;"></div>
            <div class="user-actions">
                <button class="btn-action btn-edit" type="button" onclick="goEditProfile()">✏️ Edit Profil</button>
                <button class="btn-action btn-logout" onclick="handleLogout()">🚪 Log Keluar</button>
            </div>
        </div>
        <div>
            <div class="view-heading" style="margin-bottom:1.2rem;">Pilih Portal</div>
            <div class="portal-grid portal-static-scroll">
                <div class="portal-btn" role="button" tabindex="0" aria-label="Dashboard MPM" onclick="window.location.href='#'" onkeydown="handlePortalKey(event, null, '#')">
                    <div class="portal-btn-icon icon-purple">📊</div>
                    <span class="portal-btn-label">Dashboard MPM</span>
                    <span class="portal-btn-arrow">›</span>
                </div>
                <div class="portal-btn" role="button" tabindex="0" aria-label="Tempahan Bilik Mesyuarat" onclick="window.location.href='#'" onkeydown="handlePortalKey(event, null, '#')">
                    <div class="portal-btn-icon icon-amber">📅</div>
                    <span class="portal-btn-label">Tempahan Bilik Mesyuarat</span>
                    <span class="portal-btn-arrow">›</span>
                </div>
                <div class="portal-btn" role="button" tabindex="0" aria-label="Borang Aduan KEW.PA-9" onclick="showView('view-borang')" onkeydown="handlePortalKey(event, 'view-borang')">
                    <div class="portal-btn-icon icon-blue">📋</div>
                    <span class="portal-btn-label">Borang Aduan KEW.PA-9</span>
                    <span class="portal-btn-arrow">›</span>
                </div>
                <div class="portal-btn" role="button" tabindex="0" aria-label="Aset Saya" onclick="showView('view-aset')" onkeydown="handlePortalKey(event, 'view-aset')">
                    <div class="portal-btn-icon icon-cyan">💻</div>
                    <span class="portal-btn-label">Aset Saya</span>
                    <span class="portal-btn-arrow">›</span>
                </div>
                <div class="portal-btn admin-only" role="button" tabindex="0" aria-label="Inventori Aset" onclick="window.location.href='staff/assets.php'" onkeydown="handlePortalKey(event, null, 'staff/assets.php')">
                    <div class="portal-btn-icon icon-cyan">🖥️</div>
                    <span class="portal-btn-label">Inventori Aset</span>
                    <span class="portal-btn-arrow">›</span>
                </div>
                <div class="portal-btn admin-only" role="button" tabindex="0" aria-label="Pengurusan Laporan" onclick="window.location.href='admin/dashboard.php'" onkeydown="handlePortalKey(event, null, 'admin/dashboard.php')">
                    <div class="portal-btn-icon icon-amber">📝</div>
                    <span class="portal-btn-label">Pengurusan Laporan</span>
                    <span class="portal-btn-arrow">›</span>
                </div>
                <div class="portal-btn admin-only" role="button" tabindex="0" aria-label="Sejarah Laporan" onclick="window.location.href='admin/history_reports.php'" onkeydown="handlePortalKey(event, null, 'admin/history_reports.php')">
                    <div class="portal-btn-icon icon-rose">📜</div>
                    <span class="portal-btn-label">Sejarah Laporan</span>
                    <span class="portal-btn-arrow">›</span>
                </div>
            </div>
            <div class="portal-divider"></div>
            <button class="settings-link" type="button" onclick="showView('view-settings')">⚙️ Tetapan Profil</button>
        </div>
    </div>
</div>

</div><!-- card-shell -->

<!-- WIDE CONTENT: all non-home views -->
<div class="wide-content" id="wide-content-container">

<!-- VIEW: EDIT PROFIL -->
<div class="view" id="view-profile">
    <button class="back-btn" onclick="showView('view-home')">‹ Kembali</button>
    <div class="view-subheading">Akaun Saya</div>
    <div class="view-heading">Edit Profil</div>
    <div class="view-scroll">
        <div id="profileAlert" class="alert"></div>
        <div class="avatar-upload-area">
            <div class="avatar-preview" id="profileAvatarPreview">
                <img id="profileAvatarImg" src="" alt="" style="display:none;">
                <span id="profileAvatarInitial">?</span>
            </div>
            <div>
                <label class="avatar-upload-btn" for="profilePicInput">📷 Tukar Gambar</label>
                <input type="file" id="profilePicInput" accept="image/*" style="display:none;" onchange="previewAvatar(this)">
                <div style="font-size:.73rem;color:#66768c;margin-top:.4rem;">JPG, PNG, GIF · Maks 5MB</div>
            </div>
        </div>
        <form id="profileForm">
            <div class="form-grid-3">
                <div class="form-group">
                    <label class="form-label">Nama Penuh</label>
                    <input type="text" id="pf_name" class="form-input" placeholder="Nama penuh..." required>
                </div>
                <div class="form-group">
                    <label class="form-label">Jawatan</label>
                    <input type="text" id="pf_jawatan" class="form-input" placeholder="Jawatan...">
                </div>
                <div class="form-group">
                    <label class="form-label">Jabatan / Unit</label>
                    <select id="pf_dept" class="form-select">
                        <option value="">-- Pilih Jabatan / Unit --</option>
                        <option>Jabatan Bangunan</option>
                        <option>Jabatan Kejuruteraan</option>
                        <option>Jabatan Kesihatan dan Pelesenan</option>
                        <option>Jabatan Kewangan</option>
                        <option>Jabatan Khidmat Pengurusan</option>
                        <option>Jabatan Komunikasi Koprat dan Kemasyarakatan</option>
                        <option>Jabatan Penguatkuasaan</option>
                        <option>Jabatan Penilaian dan Pengurusan Harta</option>
                        <option>Jabatan Perancangan dan Pembangunan Landskap</option>
                        <option>Kaunter Hasil</option>
                        <option>Pejabat Setiausaha</option>
                        <option>Pejabat YDP</option>
                        <option>Unit Audit Dalaman</option>
                        <option>Unit Perolehan dan Pengurusan Kontrak</option>
                        <option>Unit Persuruhjaya Bangunan</option>
                        <option>Unit Pusat Setempat</option>
                        <option>Unit Teknologi Maklumat</option>
                        <option>Unit Undang-Undang</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">No. Telefon</label>
                    <input type="text" id="pf_phone" class="form-input" placeholder="No. telefon...">
                </div>
                <div class="form-group">
                    <label class="form-label">No. Pejabat</label>
                    <input type="text" id="pf_office" class="form-input" placeholder="No. pejabat...">
                </div>
            </div>
            <div style="display:flex;gap:.75rem;margin-top:1.5rem;">
                <button type="submit" class="btn-primary">💾 Simpan Perubahan</button>
                <button type="button" class="btn-ghost" onclick="showView('view-home')">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- VIEW: TETAPAN -->
<div class="view" id="view-settings">
    <button class="back-btn" onclick="showView('view-home')">‹ Kembali</button>
    <div class="view-subheading">Akaun</div>
    <div class="view-heading">Tetapan Profil</div>
    <div class="view-scroll">
        <div id="settingsAlert" class="alert"></div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">
            <div style="background:rgba(255,255,255,.84);border:1px solid rgba(37,99,235,.22);border-radius:16px;padding:1.5rem;box-shadow:0 8px 20px rgba(30,41,59,.06);">
                <div style="font-size:.85rem;font-weight:800;color:#24324b;margin-bottom:1rem;">🔒 Tukar Kata Laluan</div>
                <form id="pwForm">
                    <div style="display:flex;flex-direction:column;gap:.85rem;">
                        <div class="form-group">
                            <label class="form-label">Kata Laluan Semasa</label>
                            <input type="password" id="pw_current" class="form-input" placeholder="Masukkan kata laluan semasa">
                        </div>
                        <div class="form-group">
                            <label class="form-label" style="display:flex;align-items:center;">Kata Laluan Baru
                                <span class="pw-info-wrap">
                                    <span class="pw-info-icon" onmouseenter="showPwTooltip(this)" onmouseleave="hidePwTooltip(this)">i</span>
                                    <span class="pw-info-tooltip">
                                        <strong style="display:block;margin-bottom:.5rem;color:#1e293b;">Syarat Kata Laluan:</strong>
                                        <div style="display:flex;align-items:flex-start;gap:.4rem;margin-bottom:.4rem;line-height:1.35;color:#334155;">
                                            <span style="display:inline-flex;align-items:center;justify-content:center;width:14px;height:14px;background:#22c55e;border-radius:3px;color:white;font-size:10px;font-weight:bold;flex-shrink:0;margin-top:2px;">✓</span>
                                            <span>Sekurang-kurangnya 8 aksara</span>
                                        </div>
                                        <div style="display:flex;align-items:flex-start;gap:.4rem;margin-bottom:.4rem;line-height:1.35;color:#334155;">
                                            <span style="display:inline-flex;align-items:center;justify-content:center;width:14px;height:14px;background:#22c55e;border-radius:3px;color:white;font-size:10px;font-weight:bold;flex-shrink:0;margin-top:2px;">✓</span>
                                            <span>Mengandungi huruf besar & kecil</span>
                                        </div>
                                        <div style="display:flex;align-items:flex-start;gap:.4rem;margin-bottom:.4rem;line-height:1.35;color:#334155;">
                                            <span style="display:inline-flex;align-items:center;justify-content:center;width:14px;height:14px;background:#22c55e;border-radius:3px;color:white;font-size:10px;font-weight:bold;flex-shrink:0;margin-top:2px;">✓</span>
                                            <span>Mengandungi sekurang-kurangnya 1 nombor</span>
                                        </div>
                                        <div style="display:flex;align-items:flex-start;gap:.4rem;line-height:1.35;color:#334155;">
                                            <span style="display:inline-flex;align-items:center;justify-content:center;width:14px;height:14px;background:#22c55e;border-radius:3px;color:white;font-size:10px;font-weight:bold;flex-shrink:0;margin-top:2px;">✓</span>
                                            <span>Mengandungi 1 simbol khas (e.g. @, #, $, !)</span>
                                        </div>
                                    </span>
                                </span>
                            </label>
                            <input type="password" id="pw_new" class="form-input" placeholder="Min 8 aksara" oninput="checkStrength(this.value)">
                            <div class="strength-bar"><div class="strength-fill" id="strengthFill"></div></div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Sahkan Kata Laluan Baru</label>
                            <input type="password" id="pw_confirm" class="form-input" placeholder="Ulang kata laluan baru">
                        </div>
                    </div>
                    <button type="submit" class="btn-primary" style="margin-top:1.2rem;">🔑 Kemaskini Kata Laluan</button>
                </form>
            </div>
            <div style="background:rgba(255,255,255,.84);border:1px solid rgba(37,99,235,.22);border-radius:16px;padding:1.5rem;box-shadow:0 8px 20px rgba(30,41,59,.06);">
                <div style="font-size:.85rem;font-weight:800;color:#24324b;margin-bottom:.8rem;">ℹ️ Maklumat Akaun</div>
                <div class="info-row"><span style="color:#66768c;">Nama</span><span style="color:#24324b;font-weight:700;" id="infoName">—</span></div>
                <div class="info-row"><span style="color:#66768c;">Peranan</span><span style="color:#dc2626;font-weight:700;" id="infoRole">—</span></div>
                <div class="info-row"><span style="color:#66768c;">Jabatan</span><span style="color:#24324b;font-weight:700;" id="infoDept">—</span></div>
            </div>
        </div>
    </div>
</div>

<!-- VIEW: BORANG ADUAN -->
<div class="view" id="view-borang">
    <button class="back-btn" onclick="showView('view-home')">‹ Kembali</button>
    <div class="view-subheading">KEW.PA-9</div>
    <div class="view-heading">Borang Aduan Kerosakan Aset</div>
    <div class="view-scroll">
        <div id="borangAlert" class="alert"></div>
        <form id="borangForm">
            <div class="form-grid-3">
                <div class="form-group">
                    <label class="form-label">Jenis Aset</label>
                    <select id="b_jenis" class="form-select" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option>Laptop/NoteBook</option><option>Desktop PC</option><option>Lain-lain</option>
                    </select>
                </div>
                <div class="form-group span2">
                    <label class="form-label">No. Siri Pendaftaran</label>
                    <input type="text" id="b_siri" class="form-input" placeholder="MPM/KEW/..." required>
                </div>
                <div class="form-group">
                    <label class="form-label">Pengguna Terakhir</label>
                    <input type="text" id="b_pengguna" class="form-input" placeholder="Ahmad bin Ali..." required>
                </div>
                <div class="form-group">
                    <label class="form-label">Tarikh Kerosakan</label>
                    <input type="date" id="b_tarikh" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Lokasi</label>
                    <input type="text" id="b_lokasi" class="form-input" placeholder="Jabatan/Unit..." required>
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Pelapor</label>
                    <input type="text" id="b_nama" class="form-input" placeholder="Abu bin Ahmad..." required>
                </div>
                <div class="form-group">
                    <label class="form-label">Jawatan Pelapor</label>
                    <input type="text" id="b_jawatan_pelapor" class="form-input" placeholder="Pembantu Tadbir Gred..." required>
                </div>
                <div class="form-group">
                    <label class="form-label">Gambar Bukti (pilihan)</label>
                    <input type="file" id="b_gambar" accept="image/*" multiple style="font-size:.82rem;">
                </div>
                <div class="form-group full">
                    <label class="form-label">Perihal Kerosakan</label>
                    <textarea id="b_perihal" class="form-textarea" placeholder="Huraikan kerosakan dengan jelas..." required></textarea>
                </div>
            </div>
            <div style="display:flex;gap:.75rem;margin-top:1.5rem;">
                <button type="submit" class="btn-primary">📤 Hantar Aduan</button>
                <button type="button" class="btn-ghost" onclick="showView('view-home')">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- VIEW: ASET SAYA (PAPARAN STAF - BACA SAHAJA) -->
<div class="view" id="view-aset">
    <button class="back-btn" onclick="showView('view-home')">‹ Kembali</button>
    
    <div class="asset-view-header">
        <div>
            <div class="view-subheading">Portal Staf</div>
            <div class="view-heading" style="margin-bottom:.3rem;">Aset Saya</div>
            <p style="font-size:.82rem;color:#66768c;">Senarai peralatan ICT dan komputer yang didaftarkan oleh Pentadbir ICT MPM untuk kegunaan anda.</p>
        </div>
        <div style="background:rgba(37,99,235,.08);color:#2563eb;font-weight:700;font-size:.82rem;padding:.45rem 1.1rem;border-radius:20px;border:1px solid rgba(37,99,235,.2);display:inline-flex;align-items:center;gap:.4rem;">
            📋 Jumlah Aset: <span id="assetCountBadge" style="font-weight:800;color:#1e40af;">0</span>
        </div>
    </div>

    <div class="view-scroll">
        <div id="asetAlert" class="alert"></div>

        <!-- SENARAI ASET SAYA -->
        <div id="assetListView">
            <!-- Search & Status Bar -->
            <div style="display:flex;gap:.75rem;align-items:center;margin-bottom:1.1rem;flex-wrap:wrap;">
                <div style="position:relative;flex:1;min-width:240px;">
                    <input type="text" id="assetSearchInput" class="form-input" placeholder="🔍 Cari model komputer, no. siri, atau spesifikasi..." oninput="filterUserAssets(this.value)">
                </div>
                <div style="font-size:.78rem;color:#66768c;background:rgba(255,255,255,.75);padding:.6rem 1rem;border-radius:12px;border:1px solid rgba(37,99,235,.15);font-weight:600;display:flex;align-items:center;gap:.4rem;">
                    <span>Status Rekod:</span> <span style="color:#15803d;font-weight:800;">● Aktif</span>
                </div>
            </div>

            <!-- List Cards Container -->
            <div id="assetCardsContainer">
                <div style="text-align:center;padding:3rem 1rem;color:#66768c;">
                    ⏳ Memuatkan senarai aset anda...
                </div>
            </div>
        </div>
    </div>
</div>

<!-- VIEW: CARTA ALIR -->
<div class="view" id="view-carta">
    <button class="back-btn" onclick="showView('view-dashboard')">‹ Kembali</button>
    <div class="view-subheading">KEW.PA-9</div>
    <div class="view-heading">Carta Alir Proses KEW.PA-9</div>
    <div class="view-scroll">
        <div class="flow-card">
            <div id="portalMermaid"></div>
        </div>
    </div>
</div>

<!-- VIEW: LAPORAN SAYA -->
<div class="view" id="view-laporan">
    <button class="back-btn" onclick="showView('view-dashboard')">‹ Kembali</button>
    <div class="view-subheading">Staff Portal</div>
    <div class="view-heading">Laporan Saya</div>
    <div class="view-scroll">
        <div class="dashboard-list" id="portalLaporanSaya" style="margin-top:.25rem;">
            <div style="font-size:1.15rem;font-weight:800;color:#24324b;margin-bottom:.2rem;">Sejarah Penghantaran</div>
            <p style="font-size:.82rem;color:#66768c;margin-bottom:1rem;">Menjejaki semua laporan KEW.PA-9 anda.</p>

            <div class="hist-filter-bar">
                <div style="display: flex; flex-direction: column; gap: .5rem;">
                    <div class="hist-filter-row">
                        <label for="filterYear" class="form-label" style="margin:0;">Tahun:</label>
                        <select id="filterYear" class="form-select" style="min-width:130px;padding:.5rem .9rem;" onchange="filterHistory()">
                            <option value="">Semua Tahun</option>
                        </select>
                    </div>
                    <div class="hist-filter-row">
                        <label for="filterMonth" class="form-label" style="margin:0;">Bulan:</label>
                        <select id="filterMonth" class="form-select" style="min-width:150px;padding:.5rem .9rem;" onchange="filterHistory()">
                            <option value="">Semua Bulan</option>
                            <option value="0">Januari</option>
                            <option value="1">Februari</option>
                            <option value="2">Mac</option>
                            <option value="3">April</option>
                            <option value="4">Mei</option>
                            <option value="5">Jun</option>
                            <option value="6">Julai</option>
                            <option value="7">Ogos</option>
                            <option value="8">September</option>
                            <option value="9">Oktober</option>
                            <option value="10">November</option>
                            <option value="11">Disember</option>
                        </select>
                    </div>
                </div>
                <div class="hist-legend">
                    <span class="hist-legend-title">Petunjuk Proses/Keputusan:</span>
                    <div class="hist-legend-grid">
                        <span class="hist-legend-item"><span class="hist-dot" style="background:#f59e0b;"></span> Baru / Dalam Proses</span>
                        <span class="hist-legend-item"><span class="hist-dot" style="background:#10b981;"></span> Selesai / Diluluskan</span>
                        <span class="hist-legend-item"><span class="hist-dot" style="background:#ef4444;"></span> Ditolak / Tidak Diluluskan</span>
                        <span class="hist-legend-item"><span class="hist-dot" style="background:#64748b;"></span> Syor Dilupuskan</span>
                    </div>
                </div>
            </div>

            <div class="hist-table-wrap">
                <table class="hist-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Jenis Aset</th>
                            <th>Tarikh Dihantar</th>
                            <th>Tarikh Siap</th>
                            <th>Pematuhan ISO</th>
                            <th>Proses</th>
                            <th>Keputusan</th>
                            <th style="text-align:center;">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody id="historyTableBody">
                        <tr><td colspan="8" style="padding:2rem;text-align:center;color:#66768c;">Memuatkan laporan...</td></tr>
                    </tbody>
                </table>
            </div>
            <div id="paginationControls" class="hist-pager" style="display:none;">
                <div id="paginationInfo" style="font-size:.8rem;color:#66768c;font-weight:600;"></div>
                <div style="display:flex;align-items:center;gap:.4rem;">
                    <button type="button" id="btnPrev" onclick="changePage(currentPage - 1)" class="btn-ghost" style="padding:.4rem .8rem;font-size:.78rem;">← Sebelum</button>
                    <div id="pageNumbers" style="display:flex;gap:.3rem;"></div>
                    <button type="button" id="btnNext" onclick="changePage(currentPage + 1)" class="btn-ghost" style="padding:.4rem .8rem;font-size:.78rem;">Seterus →</button>
                </div>
            </div>
        </div>
    </div>
</div>

</div><!-- wide-content -->

<!-- DASHBOARD: beside card-shell (always visible alongside home) -->
<div class="dashboard-side-view active" id="dashboard-side-container">
<div class="view active" id="view-dashboard">
    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:.75rem;flex-wrap:wrap;margin-bottom:.4rem;">
        <div>
            <div class="view-subheading">Papan Pemuka</div>
            <div class="view-heading" style="margin-bottom:.15rem;">Ringkasan Papan Pemuka</div>
        </div>
        <div id="portalHistDate" style="background:rgba(255,255,255,.9);padding:.45rem 1rem;border-radius:20px;box-shadow:0 4px 12px rgba(0,0,0,.05);font-weight:600;color:#24324b;font-size:.82rem;"></div>
    </div>
    <div class="view-scroll">

        <!-- Stats -->
        <div class="dashboard-summary">
            <div class="dashboard-stat">
                <span class="dashboard-stat-icon">📝</span>
                <div>
                    <div class="dashboard-stat-label">Jumlah Laporan Belum Selesai</div>
                    <div class="dashboard-stat-value" id="dashPendingCount">—</div>
                </div>
            </div>
            <div class="dashboard-stat">
                <span class="dashboard-stat-icon">📜</span>
                <div>
                    <div class="dashboard-stat-label" id="dashYearLabel">Jumlah Laporan Tahun Ini</div>
                    <div class="dashboard-stat-value" id="dashYearCount">—</div>
                </div>
            </div>
            <div class="dashboard-stat">
                <span class="dashboard-stat-icon">📅</span>
                <div>
                    <div class="dashboard-stat-label">Jumlah Laporan Keseluruhan</div>
                    <div class="dashboard-stat-value" id="dashTotalCount">—</div>
                </div>
            </div>
        </div>

        <!-- Real-Time Status Tracking -->
        <div class="dashboard-list" style="margin-top:1rem;border-left:3px solid #3b82f6;padding-left:.75rem;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.75rem;">
                <div class="dashboard-list-title" style="margin:0;">📡 Status Semasa Laporan KEW.PA-9</div>
                <button type="button" onclick="showView('view-laporan')" style="font-size:.75rem;color:#66768c;background:none;border:none;cursor:pointer;font-weight:700;font-family:Outfit,sans-serif;">Lihat Semua &rarr;</button>
            </div>
            <div id="portalLiveTracking">
                <p style="font-size:.82rem;color:#66768c;text-align:center;padding:.5rem;">Memuatkan status...</p>
            </div>
        </div>

        <!-- Carta Alir Proses -->
        <div class="dashboard-list" style="margin-top:1rem;">
            <div class="dashboard-list-title">📊 Carta Alir Proses KEW.PA-9</div>
            <div style="display:flex;justify-content:flex-end;margin-top:-2rem;">
                <button type="button" class="flow-toggle-btn" onclick="showView('view-carta')">Papar Carta</button>
            </div>
        </div>

        <!-- Aktiviti Terkini -->
        <div class="dashboard-list" style="margin-top:1rem;">
            <div class="dashboard-list-title">🔔 Aktiviti Terkini</div>
            <div id="portalActivityList" style="max-height: 160px; overflow-y: auto; padding-right: 5px;">
                <p style="font-size:.82rem;color:#66768c;text-align:center;padding:.5rem;">Memuatkan aktiviti...</p>
            </div>
        </div>

    </div>
</div>
</div><!-- dashboard-side-view -->

<!-- Detail Modal -->
<div id="detailModal" class="portal-modal" onclick="if(event.target===this)closeModal()">
    <div class="portal-modal-content">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
            <h2>Butiran Laporan KEW.PA-9</h2>
            <button type="button" class="modal-close" onclick="closeModal()">&times;</button>
        </div>
        <h4>Bahagian I: Maklumat Pengadu</h4>
        <div class="modal-grid">
            <div class="form-group"><label class="form-label">Jenis Aset</label><input type="text" id="d_jenis" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">No. Siri Pendaftaran</label><input type="text" id="d_siri" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Pengguna Terakhir</label><input type="text" id="d_pengguna" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Tarikh Kerosakan</label><input type="text" id="d_tarikh_rosak" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Nama Pelapor &amp; Jawatan</label><input type="text" id="d_nama_jawatan" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Lokasi</label><input type="text" id="d_lokasi" class="form-input" readonly></div>
        </div>
        <div class="form-group" style="margin-top:.85rem;"><label class="form-label">Perihal Kerosakan</label><textarea id="d_perihal" class="form-textarea" rows="3" readonly></textarea></div>
        <div class="form-group" style="margin-top:.85rem;"><label class="form-label">Tarikh Aduan</label><input type="text" id="d_created_at" class="form-input" readonly></div>

        <h4>Bahagian II: Penemuan Teknikal</h4>
        <div class="modal-grid">
            <div class="form-group"><label class="form-label">Kos Penyelenggaraan Terdahulu (RM)</label><input type="text" id="d_kos_dahulu" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Anggaran Kos Penyelenggaraan (RM)</label><input type="text" id="d_anggaran_kos" class="form-input" readonly></div>
        </div>
        <div class="form-group" style="margin-top:.85rem;"><label class="form-label">Syor Dan Ulasan</label><textarea id="d_syor" class="form-textarea" rows="3" readonly></textarea></div>
        <div class="form-group" style="margin-top:.85rem;"><label class="form-label">Nama Pegawai Teknikal</label><input type="text" id="d_admin_nama" class="form-input" readonly></div>
        <div class="form-group" style="margin-top:.85rem;"><label class="form-label">Jawatan Pegawai Teknikal</label><input type="text" id="d_admin_jawatan" class="form-input" readonly></div>
        <div class="form-group" style="margin-top:.85rem;"><label class="form-label">Tarikh Siap (Admin ICT)</label><input type="text" id="d_admin_tarikh" class="form-input" readonly></div>

        <div style="background:linear-gradient(135deg,rgba(99,102,241,.05),rgba(168,85,247,.05));border:1px solid rgba(99,102,241,.2);border-radius:12px;padding:1rem;margin-top:1rem;">
            <h4 style="color:#6366f1;margin:0 0 .6rem;border:none;padding:0;display:flex;align-items:center;gap:.45rem;font-size:.9rem;">
                🔄 Proses Semasa <span style="font-size:.68rem;background:#6366f1;color:#fff;padding:.15rem .5rem;border-radius:20px;font-weight:600;">WEB SAHAJA</span>
            </h4>
            <div id="d_proses_semasa">—</div>
        </div>

        <h4>Bahagian III: Keputusan</h4>
        <div class="modal-grid">
            <div class="form-group"><label class="form-label">Keputusan</label><input type="text" id="d_keputusan" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Nama Ketua</label><input type="text" id="d_kep_nama" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Tarikh Keputusan</label><input type="text" id="d_kep_tarikh" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Pematuhan ISO (&lt;14 hari)</label><div id="d_iso_badge" style="padding-top:.4rem;"></div></div>
        </div>

        <h4>Gambar Lampiran</h4>
        <div id="d_images"></div>
        <div style="margin-top:1.2rem;">
            <button type="button" onclick="closeModal()" class="btn-ghost" style="width:100%;">Tutup</button>
        </div>
    </div>
</div>

<!-- Asset Detail Modal -->
<div id="assetDetailModal" class="portal-modal" onclick="if(event.target===this)closeAssetModal()">
    <div class="portal-modal-content">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
            <div>
                <span style="font-size:.72rem;font-weight:800;color:#2563eb;text-transform:uppercase;letter-spacing:.06em;">Maklumat Lengkap Aset</span>
                <h2 id="adm_title" style="margin-top:.2rem;">Butiran Aset ICT</h2>
            </div>
            <button type="button" class="modal-close" onclick="closeAssetModal()">&times;</button>
        </div>

        <div style="display:flex;gap:.5rem;margin-bottom:1rem;flex-wrap:wrap;">
            <span id="adm_badge_type" class="asset-badge asset-badge-type">Desktop PC</span>
            <span class="asset-badge asset-badge-admin">🛡️ Didaftarkan Melalui Admin</span>
            <span id="adm_badge_sn" class="asset-badge asset-badge-sn">S/N: -</span>
        </div>

        <h4>Bahagian A: Maklumat Pemohon / Staf</h4>
        <div class="modal-grid">
            <div class="form-group"><label class="form-label">Nama Pemohon</label><input type="text" id="adm_nama" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Jawatan</label><input type="text" id="adm_jawatan" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Bahagian / Unit</label><input type="text" id="adm_dept" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Tarikh Pendaftaran</label><input type="text" id="adm_tarikh" class="form-input" readonly></div>
        </div>

        <h4>Bahagian B: Maklumat Komputer &amp; Perkakasan</h4>
        <div class="modal-grid">
            <div class="form-group"><label class="form-label">Model Komputer / Laptop</label><input type="text" id="adm_model_comp" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">No. Siri CPU / Laptop</label><input type="text" id="adm_serial_comp" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Model Monitor</label><input type="text" id="adm_model_mon" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">No. Siri Monitor</label><input type="text" id="adm_serial_mon" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Sistem Operasi (OS)</label><input type="text" id="adm_os" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Pemproses (CPU)</label><input type="text" id="adm_proc" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">RAM</label><input type="text" id="adm_ram" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Cakera Keras (Storage)</label><input type="text" id="adm_disk" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Alamat IP</label><input type="text" id="adm_ip" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Pencetak (Printer)</label><input type="text" id="adm_printer" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Tetikus &amp; Papan Kekunci</label><input type="text" id="adm_accessories" class="form-input" readonly></div>
            <div class="form-group"><label class="form-label">Microsoft Office &amp; Antivirus</label><input type="text" id="adm_software" class="form-input" readonly></div>
        </div>
        <div class="form-group" style="margin-top:.85rem;">
            <label class="form-label">Perisian Lain</label>
            <textarea id="adm_perisian_lain" class="form-textarea" rows="2" readonly></textarea>
        </div>

        <h4>Bahagian C: Gambar Lampiran Aset</h4>
        <div id="adm_images" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(130px,1fr));gap:1rem;margin-top:.5rem;"></div>

        <div style="display:flex;gap:.75rem;margin-top:1.5rem;justify-content:flex-end;">
            <button type="button" id="adm_btn_report" class="btn-asset-report" style="padding:.6rem 1.2rem;font-size:.85rem;">📤 Lapor Kerosakan (KEW.PA-9)</button>
            <button type="button" onclick="closeAssetModal()" class="btn-ghost" style="padding:.6rem 1.2rem;font-size:.85rem;">Tutup</button>
        </div>
    </div>
</div>

</div><!-- portal-layout -->

<script>
    let currentUser = null, isAdmin = false;

    function handlePortalKey(event, viewId, url) {
        if (event.key !== 'Enter' && event.key !== ' ') return;
        event.preventDefault();
        if (url) {
            window.location.href = url;
            return;
        }
        if (viewId) showView(viewId);
    }

    function showView(id) {
        const isHome      = (id === 'view-home');
        const isDashboard = (id === 'view-dashboard');
        const isWide      = !isHome && !isDashboard; // profile, settings, borang, laporan

        const shell      = document.querySelector('.card-shell');
        const wideEl     = document.getElementById('wide-content-container');
        const dashEl     = document.getElementById('dashboard-side-container');

        // card-shell: visible for home AND dashboard (side-by-side)
        if (shell) shell.style.display = isWide ? 'none' : '';
        // wide-content: only for profile/settings/borang
        if (wideEl) wideEl.classList.toggle('active', isWide);
        // dashboard panel: visible for home AND dashboard (always beside card-shell)
        if (dashEl) dashEl.classList.toggle('active', !isWide);

        // Activate correct view inside wide-content
        document.querySelectorAll('#wide-content-container .view').forEach(v => v.classList.remove('active'));
        if (isWide) {
            const el = document.getElementById(id);
            if (el) el.classList.add('active');
        }

        // For home: make sure view-home is active in card-shell
        const homeView = document.getElementById('view-home');
        if (homeView) homeView.classList.toggle('active', isHome || isDashboard);

        window.scrollTo({top:0,behavior:'smooth'});
        if (id === 'view-profile')  populateProfileForm();
        if (id === 'view-borang')   populateBorangDefaults();
        if (id === 'view-aset')     populateAssetView();
        if (id === 'view-settings') populateSettings();
        if (id === 'view-laporan' && reportsData.length) filterHistory();
        if (id === 'view-carta')    renderCartaAlir();
    }

    async function handleLogout() {
        try { await fetch("api/logout.php"); } catch(e) {}
        sessionStorage.clear();
        window.location.replace('login.php');
    }

    function goDashboard() {
        showView('view-dashboard');
    }

    function goEditProfile() {
        const raw = sessionStorage.getItem('user');
        if (!raw) {
            window.location.replace('login.php');
            return;
        }
        showView('view-profile');
    }

    document.addEventListener('DOMContentLoaded', () => {
        const raw = sessionStorage.getItem('user');
        if (!raw) { window.location.replace('login.php'); return; }
        currentUser = JSON.parse(raw);
        isAdmin = ['admin','super admin','superadmin'].includes((currentUser.role||'').toLowerCase());
        const name = currentUser.full_name || currentUser.name || 'Pengguna';
        document.getElementById('homeName').textContent = name;
        if (currentUser.jawatan) document.getElementById('homeJawatan').textContent = currentUser.jawatan;
        if (currentUser.department) { const d=document.getElementById('homeDept'); d.textContent=currentUser.department; d.style.display='block'; }
        document.getElementById('homeInitial').textContent = name.trim().charAt(0).toUpperCase();
        if (currentUser.profile_picture) { const i=document.getElementById('homeAvatar'); i.src='uploads/'+currentUser.profile_picture; i.style.display='block'; document.getElementById('homeInitial').style.display='none'; }
        if (isAdmin) { document.querySelectorAll('.admin-only').forEach(el=>el.style.display='flex'); const dashLabel=document.getElementById('dashLabel'); if(dashLabel) dashLabel.textContent='Papan Pemuka Admin'; }
        const histDate = document.getElementById('portalHistDate');
        if (histDate) histDate.textContent = new Date().toLocaleDateString('ms-MY', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
        // Auto-show dashboard beside home on login
        showView('view-dashboard');
        // Load dashboard live data
        loadPortalDashboard();
    });

    /* ── Profile ── */
    function populateProfileForm() {
        if (!currentUser) return;
        document.getElementById('pf_name').value    = currentUser.full_name || '';
        document.getElementById('pf_jawatan').value = currentUser.jawatan || '';
        document.getElementById('pf_dept').value    = currentUser.department || '';
        document.getElementById('pf_phone').value   = currentUser.phone || '';
        document.getElementById('pf_office').value  = currentUser.office || '';
        const name = currentUser.full_name || '?';
        document.getElementById('profileAvatarInitial').textContent = name.trim().charAt(0).toUpperCase();
        if (currentUser.profile_picture) { const i=document.getElementById('profileAvatarImg'); i.src='uploads/'+currentUser.profile_picture; i.style.display='block'; document.getElementById('profileAvatarInitial').style.display='none'; } else { document.getElementById('profileAvatarImg').style.display='none'; document.getElementById('profileAvatarInitial').style.display=''; }
        document.getElementById('profileAlert').style.display='none';
    }
    function previewAvatar(input) {
        if (!input.files||!input.files[0]) return;
        const reader=new FileReader();
        reader.onload=e=>{ const i=document.getElementById('profileAvatarImg'); i.src=e.target.result; i.style.display='block'; document.getElementById('profileAvatarInitial').style.display='none'; };
        reader.readAsDataURL(input.files[0]);
    }
    document.getElementById('profileForm').addEventListener('submit', async e => {
        e.preventDefault();
        const alertEl=document.getElementById('profileAlert');
        const fd=new FormData();
        fd.append('full_name', document.getElementById('pf_name').value);
        fd.append('jawatan', document.getElementById('pf_jawatan').value);
        fd.append('department', document.getElementById('pf_dept').value);
        fd.append('phone', document.getElementById('pf_phone').value);
        fd.append('office', document.getElementById('pf_office').value);
        const pic=document.getElementById('profilePicInput').files[0];
        if (pic) fd.append('profile_picture',pic);
        const url = isAdmin ? 'api/admin/admin_update_profile.php' : 'api/staff/staff_update_profile.php';
        try {
            const res=await fetch(url,{method:'POST',body:fd});
            const data=await res.json();
            if (data.status==='success') {
                currentUser.full_name=document.getElementById('pf_name').value;
                currentUser.jawatan=document.getElementById('pf_jawatan').value;
                currentUser.department=document.getElementById('pf_dept').value;
                sessionStorage.setItem('user',JSON.stringify(currentUser));
                document.getElementById('homeName').textContent=currentUser.full_name;
                document.getElementById('homeJawatan').textContent=currentUser.jawatan;
                const d=document.getElementById('homeDept'); d.textContent=currentUser.department; d.style.display=currentUser.department?'block':'none';
                showAlert(alertEl,'✅ Profil berjaya dikemaskini!','success');
            } else { showAlert(alertEl,'❌ '+(data.message||'Ralat.'),'error'); }
        } catch(err) { showAlert(alertEl,'❌ Ralat sambungan.','error'); }
    });

    /* ── Borang ── */
    function populateBorangDefaults() {
        if (!currentUser) return;
        document.getElementById('b_nama').value = currentUser.full_name || '';
        document.getElementById('b_jawatan_pelapor').value = currentUser.jawatan || '';
        document.getElementById('b_tarikh').value = new Date().toISOString().split('T')[0];
    }
    document.getElementById('borangForm').addEventListener('submit', async e => {
        e.preventDefault();
        const alertEl=document.getElementById('borangAlert');
        const fd=new FormData();
        fd.append('jenis_aset', document.getElementById('b_jenis').value);
        fd.append('nombor_siri', document.getElementById('b_siri').value);
        fd.append('pengguna_terakhir', document.getElementById('b_pengguna').value);
        fd.append('tarikh_kerosakan', document.getElementById('b_tarikh').value);
        fd.append('nama_pelapor', document.getElementById('b_nama').value);
        fd.append('jawatan_pelapor', document.getElementById('b_jawatan_pelapor').value);
        fd.append('location', document.getElementById('b_lokasi').value);
        fd.append('perihal_kerosakan', document.getElementById('b_perihal').value);
        const files=document.getElementById('b_gambar').files;
        for (let i=0;i<files.length;i++) fd.append('images[]',files[i]);
        try {
            const res=await fetch('api/staff/staff_submit_report.php',{method:'POST',body:fd});
            const data=await res.json();
            if (data.status==='success') { showAlert(alertEl,'✅ Aduan berjaya dihantar! ID: #'+(data.report_id||''),'success'); document.getElementById('borangForm').reset(); populateBorangDefaults(); loadPortalDashboard(); }
            else { showAlert(alertEl,'❌ '+(data.message||'Ralat.'),'error'); }
        } catch(err) { showAlert(alertEl,'❌ Ralat sambungan.','error'); }
    });

    /* ── Aset Saya (Staf Read-Only) ── */
    let userAssetsList = [];

    async function populateAssetView() {
        await loadAssetData();
    }

    async function loadAssetData() {
        const container = document.getElementById('assetCardsContainer');
        if (!container) return;
        container.innerHTML = '<div style="text-align:center;padding:3rem 1rem;color:#66768c;">⏳ Memuatkan rekod aset anda...</div>';

        try {
            const response = await fetch('api/staff/staff_get_assets.php?_t=' + Date.now());
            const result = await response.json();
            if (result.status !== 'success') {
                container.innerHTML = `<div style="text-align:center;padding:2.5rem;color:#dc2626;">❌ ${result.message || 'Gagal memuatkan data aset.'}</div>`;
                return;
            }

            userAssetsList = result.data || [];
            const badge = document.getElementById('assetCountBadge');
            if (badge) badge.textContent = userAssetsList.length;

            renderAssetList(userAssetsList);
        } catch (err) {
            console.error('loadAssetData error:', err);
            container.innerHTML = `<div style="text-align:center;padding:2.5rem;color:#dc2626;">❌ Ralat sambungan memuatkan aset: ${err.message}</div>`;
        }
    }

    function renderAssetList(assets) {
        const container = document.getElementById('assetCardsContainer');
        if (!container) return;

        if (!assets || assets.length === 0) {
            container.innerHTML = `
                <div style="background:rgba(255,255,255,.8);border:2px dashed rgba(37,99,235,.2);border-radius:18px;padding:3rem 1.5rem;text-align:center;margin-top:.5rem;">
                    <div style="width:64px;height:64px;background:#e0f2fe;color:#0284c7;border-radius:18px;display:flex;align-items:center;justify-content:center;font-size:2rem;margin:0 auto 1rem;">💻</div>
                    <h3 style="font-size:1.15rem;font-weight:800;color:#24324b;margin-bottom:.35rem;">Tiada Aset Didaftarkan</h3>
                    <p style="font-size:.84rem;color:#66768c;max-width:480px;margin:0 auto;line-height:1.5;">
                        Belum ada aset komputer atau perkakasan ICT yang didaftarkan untuk akaun anda oleh Pentadbir ICT MPM. Sila hubungi Admin untuk pendaftaran dan penetapan aset bagi akaun anda.
                    </p>
                </div>
            `;
            return;
        }

        container.innerHTML = assets.map(a => {
            const typeLower = (a.asset_type || '').toLowerCase();
            let icon = '💻';
            if (typeLower.includes('desktop') || typeLower.includes('pc')) icon = '🖥️';
            else if (typeLower.includes('laptop') || typeLower.includes('notebook')) icon = '💻';
            else if (typeLower.includes('printer') || typeLower.includes('cetak')) icon = '🖨️';
            else if (typeLower.includes('monitor')) icon = '🖥️';
            else icon = '📟';

            const assetTypeDisplay = a.asset_type || 'Desktop PC';
            const model = a.model_komputer || 'Model Tidak Dinyatakan';
            const serial = a.serial_number || 'N/A';
            const regDate = a.created_at ? new Date(a.created_at).toLocaleDateString('ms-MY', { day: 'numeric', month: 'short', year: 'numeric' }) : '-';

            // Image thumbnails
            let imagesHtml = '';
            if (a.images && a.images.length > 0) {
                imagesHtml = `
                    <div class="asset-thumb-strip">
                        <span style="font-size:.7rem;font-weight:700;color:#64748b;margin-right:.25rem;">Gambar:</span>
                        ${a.images.map(img => `<img src="${img.image_path}" class="asset-thumb" title="Klik untuk lihat butiran" onclick="openAssetDetail(${a.id})">`).join('')}
                    </div>
                `;
            }

            return `
                <div class="asset-card">
                    <div class="asset-card-top">
                        <div class="asset-card-badges">
                            <span class="asset-badge asset-badge-type">${icon} ${assetTypeDisplay}</span>
                            <span class="asset-badge asset-badge-admin">🛡️ Didaftarkan Melalui Admin</span>
                            <span class="asset-badge asset-badge-sn">S/N: ${serial}</span>
                        </div>
                        <div style="font-size:.74rem;color:#64748b;font-weight:600;">
                            📅 Didaftar: ${regDate}
                        </div>
                    </div>

                    <div class="asset-card-title">
                        <div>
                            <span>${model}</span>
                            ${a.no_siri_pendaftaran ? `<span style="font-size:.75rem;font-weight:600;color:#64748b;margin-left:.5rem;">(No. Pendaftaran: <strong>${a.no_siri_pendaftaran}</strong>)</span>` : ''}
                        </div>
                    </div>

                    <div class="asset-specs-grid">
                        <div class="asset-spec-item">
                            <span class="asset-spec-label">🖥️ Monitor</span>
                            <span class="asset-spec-value">${a.model_monitor ? a.model_monitor + (a.serial_monitor ? ' (' + a.serial_monitor + ')' : '') : 'Tiada / Bersepadu'}</span>
                        </div>
                        <div class="asset-spec-item">
                            <span class="asset-spec-label">⚙️ OS &amp; Pemproses</span>
                            <span class="asset-spec-value">${(a.os || '-') + ' / ' + (a.processor || '-')}</span>
                        </div>
                        <div class="asset-spec-item">
                            <span class="asset-spec-label">💾 RAM &amp; Storan</span>
                            <span class="asset-spec-value">${(a.ram || '-') + ' / ' + (a.hard_disk || '-')}</span>
                        </div>
                        <div class="asset-spec-item">
                            <span class="asset-spec-label">🌐 Alamat IP</span>
                            <span class="asset-spec-value">${a.ip_address || '-'}</span>
                        </div>
                        <div class="asset-spec-item">
                            <span class="asset-spec-label">🖨️ Pencetak</span>
                            <span class="asset-spec-value">${a.printer || 'Tiada'}</span>
                        </div>
                        <div class="asset-spec-item">
                            <span class="asset-spec-label">📄 Perisian Office</span>
                            <span class="asset-spec-value">${(a.ms_office ? 'Office ' + a.ms_office : '-') + (a.antivirus ? ' | ' + a.antivirus : '')}</span>
                        </div>
                    </div>

                    ${imagesHtml}

                    <div class="asset-card-actions">
                        <button type="button" class="btn-asset-report" onclick="quickReportAsset(${a.id})" title="Hantar borang aduan KEW.PA-9 dengan maklumat aset ini">
                            📤 Lapor Kerosakan (KEW.PA-9)
                        </button>
                        <button type="button" class="btn-asset-action" onclick="openAssetDetail(${a.id})">
                            👁️ Butiran Penuh
                        </button>
                    </div>
                </div>
            `;
        }).join('');
    }

    function filterUserAssets(term) {
        const query = (term || '').toLowerCase().trim();
        if (!query) {
            renderAssetList(userAssetsList);
            return;
        }

        const filtered = userAssetsList.filter(a => {
            const m = (a.model_komputer || '').toLowerCase();
            const s = (a.serial_number || '').toLowerCase();
            const t = (a.asset_type || '').toLowerCase();
            const mon = (a.model_monitor || '').toLowerCase();
            const os = (a.os || '').toLowerCase();
            const ip = (a.ip_address || '').toLowerCase();
            const reg = (a.no_siri_pendaftaran || '').toLowerCase();
            return m.includes(query) || s.includes(query) || t.includes(query) || mon.includes(query) || os.includes(query) || ip.includes(query) || reg.includes(query);
        });

        renderAssetList(filtered);
    }

    function openAssetDetail(assetId) {
        const a = userAssetsList.find(item => item.id == assetId);
        if (!a) return;

        document.getElementById('adm_title').textContent = a.model_komputer || 'Butiran Aset ICT';
        document.getElementById('adm_badge_type').textContent = a.asset_type || 'Desktop PC';
        document.getElementById('adm_badge_sn').textContent = 'S/N: ' + (a.serial_number || '-');

        document.getElementById('adm_nama').value = a.display_name || a.nama_pegawai || (currentUser ? currentUser.full_name : '-');
        document.getElementById('adm_jawatan').value = a.display_jawatan || a.jawatan || (currentUser ? currentUser.jawatan : '-');
        document.getElementById('adm_dept').value = a.display_dept || a.jabatan_unit || (currentUser ? currentUser.department : '-');
        document.getElementById('adm_tarikh').value = a.created_at ? new Date(a.created_at).toLocaleString('ms-MY') : '-';

        document.getElementById('adm_model_comp').value = a.model_komputer || '-';
        document.getElementById('adm_serial_comp').value = a.serial_number || '-';
        document.getElementById('adm_model_mon').value = a.model_monitor || '-';
        document.getElementById('adm_serial_mon').value = a.serial_monitor || '-';
        document.getElementById('adm_os').value = a.os || '-';
        document.getElementById('adm_proc').value = a.processor || '-';
        document.getElementById('adm_ram').value = a.ram || '-';
        document.getElementById('adm_disk').value = a.hard_disk || '-';
        document.getElementById('adm_ip').value = a.ip_address || '-';
        document.getElementById('adm_printer').value = a.printer || 'Tiada';
        document.getElementById('adm_accessories').value = 'Tetikus: ' + (a.mouse || '-') + ' | Papan Kekunci: ' + (a.keyboard || '-');
        document.getElementById('adm_software').value = 'Office: ' + (a.ms_office || '-') + ' | Antivirus: ' + (a.antivirus || '-');
        document.getElementById('adm_perisian_lain').value = a.perisian_lain || 'Tiada';

        // Images preview
        const imgContainer = document.getElementById('adm_images');
        imgContainer.innerHTML = '';
        if (a.images && a.images.length > 0) {
            a.images.forEach(img => {
                const div = document.createElement('div');
                div.style.cssText = 'aspect-ratio:1;border-radius:10px;overflow:hidden;border:1px solid rgba(37,99,235,.2);box-shadow:0 4px 10px rgba(0,0,0,.06);';
                div.innerHTML = `<a href="${img.image_path}" target="_blank" title="Buka gambar saiz penuh"><img src="${img.image_path}" style="width:100%;height:100%;object-fit:cover;cursor:pointer;"></a>`;
                imgContainer.appendChild(div);
            });
        } else {
            imgContainer.innerHTML = '<p style="color:#64748b;font-size:.82rem;">Tiada gambar lampiran dimuat naik.</p>';
        }

        // Setup report button inside modal
        const repBtn = document.getElementById('adm_btn_report');
        if (repBtn) {
            repBtn.onclick = () => {
                closeAssetModal();
                quickReportAsset(a.id);
            };
        }

        document.getElementById('assetDetailModal').classList.add('active');
    }

    function closeAssetModal() {
        const modal = document.getElementById('assetDetailModal');
        if (modal) modal.classList.remove('active');
    }

    function quickReportAsset(assetId) {
        const a = userAssetsList.find(item => item.id == assetId);
        if (!a) return;

        showView('view-borang');

        // Map asset type
        const t = (a.asset_type || '').toLowerCase();
        let jenisOption = 'Desktop PC';
        if (t.includes('laptop') || t.includes('notebook')) {
            jenisOption = 'Laptop/NoteBook';
        } else if (t.includes('desktop') || t.includes('pc')) {
            jenisOption = 'Desktop PC';
        } else {
            jenisOption = 'Lain-lain';
        }

        const bJenis = document.getElementById('b_jenis');
        if (bJenis) bJenis.value = jenisOption;

        const bSiri = document.getElementById('b_siri');
        if (bSiri) bSiri.value = a.serial_number || a.no_siri_pendaftaran || '';

        if (currentUser) {
            const bPengguna = document.getElementById('b_pengguna');
            if (bPengguna && !bPengguna.value) bPengguna.value = currentUser.full_name || '';

            const bLokasi = document.getElementById('b_lokasi');
            if (bLokasi && !bLokasi.value) bLokasi.value = currentUser.department || '';
        }

        const alertEl = document.getElementById('borangAlert');
        if (alertEl) {
            showAlert(alertEl, `ℹ️ Maklumat aset (${a.model_komputer || 'Aset'}) telah diisi secara automatik. Sila huraikan perihal kerosakan.`, 'success');
        }

        const perihalEl = document.getElementById('b_perihal');
        if (perihalEl) perihalEl.focus();
    }

    /* ── Settings ── */
    function populateSettings() {
        if (!currentUser) return;
        document.getElementById('infoName').textContent=currentUser.full_name||'—';
        document.getElementById('infoRole').textContent=currentUser.role||'—';
        document.getElementById('infoDept').textContent=currentUser.department||'—';
        document.getElementById('settingsAlert').style.display='none';
    }
    function checkStrength(val) {
        const fill=document.getElementById('strengthFill');
        let s=0;
        if(val.length>=8)s++; if(/[A-Z]/.test(val))s++; if(/[0-9]/.test(val))s++; if(/[^A-Za-z0-9]/.test(val))s++;
        fill.style.width=(s*25)+'%';
        fill.style.background=['#ef4444','#f97316','#eab308','#22c55e'][s-1]||'#ef4444';
    }
    document.getElementById('pwForm').addEventListener('submit', async e => {
        e.preventDefault();
        const alertEl=document.getElementById('settingsAlert');
        const nw=document.getElementById('pw_new').value, cf=document.getElementById('pw_confirm').value;
        if(nw!==cf){showAlert(alertEl,'❌ Kata laluan tidak sepadan.','error');return;}
        if(nw.length<8){showAlert(alertEl,'❌ Minimum 8 aksara.','error');return;}
        const fd=new FormData();
        fd.append('current_password',document.getElementById('pw_current').value);
        fd.append('new_password',nw);
        const url=isAdmin?'api/admin/admin_change_password.php':'api/staff/staff_change_password.php';
        try {
            const res=await fetch(url,{method:'POST',body:fd});
            const data=await res.json();
            if(data.status==='success'){showAlert(alertEl,'✅ Kata laluan berjaya ditukar!','success');document.getElementById('pwForm').reset();document.getElementById('strengthFill').style.width='0%';}
            else{showAlert(alertEl,'❌ '+(data.message||'Ralat.'),'error');}
        } catch(err){showAlert(alertEl,'❌ Ralat sambungan.','error');}
    });

    function showAlert(el,msg,type) { el.textContent=msg; el.className='alert alert-'+type; el.style.display='block'; setTimeout(()=>{el.style.display='none';},5000); }

    /* ── Dashboard Data ── */
    let cartaRendered = {};

    function renderCartaAlir() {
        const targets = [
            { id: 'portalMermaid', svgId: 'cartaSvg' }
        ];
        const graph = `flowchart TD
    classDef default fill:#ffffff,stroke:#3b82f6,stroke-width:2px,color:#1e40af,font-weight:600;
    classDef diamond fill:#ffffff,stroke:#3b82f6,stroke-width:2px,color:#1e40af,font-weight:600;
    A([Mula]) --> B[Isi Maklumat Laporan]
    B --> C[Hantar Laporan]
    C --> D[Semak Laporan]
    D --> E[Ambil Aset Rosak]
    E --> F[Kenal Pasti Masalah]
    F --> G{Boleh Dibaikpulih?}
    G -- Ya --> I[Ganti Komponen]
    G -- Tidak --> H[Hantar ke Panel]
    H --> J[Pembaikian Selesai]
    I --> J
    J --> K{Berjaya Dibaiki?}
    K -- Ya --> M[Kembalikan Aset]
    K -- Tidak --> L[Lupuskan Aset]
    L --> N[Kemaskini Keputusan]
    M --> N
    N --> O[Jana Laporan]
    O --> P[Tandatangan]
    P --> Q([Tamat])
    class G,K diamond;`;
        mermaid.initialize({ startOnLoad: false, theme: 'base', themeVariables: { primaryColor: '#dbeafe', primaryTextColor: '#1e40af', primaryBorderColor: '#3b82f6', lineColor: '#3b82f6', fontSize: '13px' } });
        targets.forEach(target => {
            const el = document.getElementById(target.id);
            if (!el || cartaRendered[target.id]) return;
            cartaRendered[target.id] = true;
            mermaid.render(target.svgId, graph).then(({ svg }) => { el.innerHTML = svg; });
        });
    }

    async function loadPortalDashboard() {
        try {
            const res = await fetch('api/staff/staff_get_history.php');
            const data = await res.json();
            if (data.status === 'success') {
                const reports = data.data;
                const currentYear = new Date().getFullYear();
                document.getElementById('dashTotalCount').textContent   = reports.length;
                document.getElementById('dashPendingCount').textContent = reports.filter(r => r.status === 'Pending').length;
                document.getElementById('dashYearLabel').textContent    = 'JUMLAH LAPORAN TAHUN ' + currentYear;
                document.getElementById('dashYearCount').textContent    = reports.filter(r => new Date(r.created_at).getFullYear() === currentYear).length;

                // Live Tracking
                const container = document.getElementById('portalLiveTracking');
                const active = reports.filter(r => r.status === 'Pending' || r.status === 'In Progress').slice(0, 3);
                if (active.length > 0) {
                    container.innerHTML = active.map(report => {
                        let sColor = '#b45309', sBg = '#fef3c7', sIcon = '🕒', sLabel = 'Belum Selesai';
                        if (report.status === 'In Progress') { sColor = '#1d4ed8'; sBg = '#dbeafe'; sIcon = '🔄'; sLabel = 'Dalam Proses'; }
                        const dateStr = new Date(report.created_at).toLocaleDateString('ms-MY', { day: 'numeric', month: 'short', year: 'numeric' });
                        const prosesColors = { 'Diterima': ['#e0f2fe','#0369a1'], 'Sedang Dibaikpulih': ['#fef9c3','#854d0e'], 'Tunggu Panel / Alat Ganti': ['#ffedd5','#9a3412'], 'Dihantar ke Panel Lantikan': ['#ede9fe','#6d28d9'], 'Siap - Sedia Diambil': ['#dcfce7','#166534'] };
                        let prosesHTML = '';
                        if (report.proses_semasa) {
                            const pc = prosesColors[report.proses_semasa] || ['#f1f5f9','#475569'];
                            prosesHTML = `<div style="margin-top:.35rem;display:inline-flex;align-items:center;gap:.3rem;background:${pc[0]};color:${pc[1]};padding:.2rem .65rem;border-radius:20px;font-size:.74rem;font-weight:700;">🔄 ${report.proses_semasa}</div>`;
                        } else {
                            prosesHTML = `<div style="margin-top:.3rem;font-size:.74rem;color:#66768c;">⏳ Menunggu tindakan admin...</div>`;
                        }
                        return `<div style="display:flex;align-items:center;justify-content:space-between;padding:.85rem 1rem;border:1px solid rgba(37,99,235,.15);border-radius:10px;background:#f8fafc;gap:.75rem;margin-bottom:.5rem;">
                            <div style="display:flex;align-items:center;gap:.75rem;flex:1;">
                                <div style="width:38px;height:38px;border-radius:50%;background:${sBg};display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0;">${sIcon}</div>
                                <div style="flex:1;">
                                    <div style="font-weight:700;color:#24324b;font-size:.88rem;">${report.jenis_aset}</div>
                                    <div style="color:#66768c;font-size:.76rem;">S/N: ${report.nombor_siri || '—'} &bull; ${dateStr}</div>
                                    ${prosesHTML}
                                </div>
                            </div>
                            <div style="background:${sBg};color:${sColor};padding:.3rem .75rem;border-radius:20px;font-weight:700;font-size:.74rem;white-space:nowrap;">${sLabel}</div>
                        </div>`;
                    }).join('');
                } else {
                    container.innerHTML = '<p style="font-size:.82rem;color:#66768c;text-align:center;padding:.5rem;">Tiada laporan aktif pada masa ini. ✅</p>';
                }

                reportsData = reports;
                const years = [...new Set(reports.map(r => new Date(r.created_at).getFullYear()))].sort((a, b) => b - a);
                const yearSelect = document.getElementById('filterYear');
                const prevYear = yearSelect.value;
                yearSelect.innerHTML = '<option value="">Semua Tahun</option>';
                years.forEach(yr => {
                    if (!isNaN(yr)) {
                        const opt = document.createElement('option');
                        opt.value = yr;
                        opt.textContent = yr;
                        yearSelect.appendChild(opt);
                    }
                });
                if (prevYear) yearSelect.value = prevYear;
                filterHistory();
            }
        } catch(e) { console.error('Dashboard fetch error:', e); }

        // Activity
        try {
            const aRes = await fetch('api/staff/staff_get_activity.php');
            const aData = await aRes.json();
            const aList = document.getElementById('portalActivityList');
            if (aData.status === 'success' && aData.data.length > 0) {
                const iconMap = { 'Profile': ['👤','#eff6ff','#1e40af'], 'Asset': ['🖥️','#f0f9ff','#0369a1'], 'Report': ['📝','#fff7ed','#9a3412'] };
                aList.innerHTML = aData.data.slice(0, 5).map(a => {
                    const key = Object.keys(iconMap).find(k => a.activity_type.includes(k)) || 'Report';
                    const [icon, bg, color] = iconMap[key];
                    const dateStr = new Date(a.created_at).toLocaleDateString('ms-MY', { day: 'numeric', month: 'short' });
                    return `<div style="display:flex;align-items:center;gap:.75rem;padding:.75rem;background:rgba(0,0,0,.02);border-radius:10px;border:1px solid rgba(37,99,235,.1);margin-bottom:.4rem;">
                        <div style="background:${bg};color:${color};width:34px;height:34px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:1rem;flex-shrink:0;">${icon}</div>
                        <div style="flex:1;">
                            <div style="font-weight:700;font-size:.84rem;color:#24324b;">${a.activity_type}</div>
                            <div style="color:#66768c;font-size:.76rem;">${a.description}</div>
                        </div>
                        <div style="font-size:.72rem;color:#66768c;font-weight:600;white-space:nowrap;">${dateStr}</div>
                    </div>`;
                }).join('');
            } else {
                aList.innerHTML = '<p style="font-size:.82rem;color:#66768c;text-align:center;padding:.5rem;">Tiada aktiviti terkini.</p>';
            }
        } catch(e) { document.getElementById('portalActivityList').innerHTML = '<p style="font-size:.82rem;color:#66768c;text-align:center;padding:.5rem;">Tiada aktiviti terkini.</p>'; }
    }

    /* ── Laporan Saya (Sejarah Penghantaran) ── */
    let reportsData = [];
    let filteredData = [];
    let currentPage = 1;
    const PAGE_SIZE = 5;
    let currentReport = null;

    function calcIsoDays(createdAt, completedAt) {
        if (!completedAt) return null;
        return Math.round((new Date(completedAt) - new Date(createdAt)) / (1000 * 60 * 60 * 24));
    }

    function isobadge(r) {
        const isCompleted = r.status === 'Completed' || r.status === 'Resolved' || r.status === 'Rejected';
        if (!isCompleted || !r.admin_tarikh) return '<span style="color:#66768c;font-size:.78rem;">—</span>';
        const days = calcIsoDays(r.created_at, r.admin_tarikh);
        if (days === null) return '<span style="color:#66768c;font-size:.78rem;">—</span>';
        const pass = days <= 14;
        return `<span style="display:inline-flex;align-items:center;gap:.3rem;padding:.25rem .65rem;border-radius:20px;font-size:.7rem;font-weight:700;background:${pass ? 'rgba(16,185,129,.12)' : 'rgba(239,68,68,.12)'};color:${pass ? '#059669' : '#dc2626'};border:1px solid ${pass ? 'rgba(16,185,129,.3)' : 'rgba(239,68,68,.3)'};">${pass ? '✅' : '⚠️'} ${days} hari</span>`;
    }

    function filterHistory() {
        const selectedYear = document.getElementById('filterYear').value;
        const selectedMonth = document.getElementById('filterMonth').value;
        filteredData = reportsData.filter(r => {
            const date = new Date(r.created_at);
            const matchYear = !selectedYear || date.getFullYear().toString() === selectedYear;
            const matchMonth = !selectedMonth || date.getMonth().toString() === selectedMonth;
            return matchYear && matchMonth;
        });
        currentPage = 1;
        renderPage();
    }

    function changePage(page) {
        currentPage = page;
        renderPage();
        const el = document.getElementById('portalLaporanSaya');
        if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function renderPage() {
        const totalItems = filteredData.length;
        const totalPages = Math.max(1, Math.ceil(totalItems / PAGE_SIZE));
        currentPage = Math.min(Math.max(1, currentPage), totalPages);
        const start = (currentPage - 1) * PAGE_SIZE;
        const pageData = filteredData.slice(start, start + PAGE_SIZE);
        const tbody = document.getElementById('historyTableBody');
        tbody.innerHTML = pageData.map(r => {
            const isCompleted = r.status === 'Completed' || r.status === 'Resolved' || r.status === 'Rejected';
            const tarikhSiap = (isCompleted && r.admin_tarikh)
                ? new Date(r.admin_tarikh).toLocaleDateString('ms-MY', { day: 'numeric', month: 'short', year: 'numeric' })
                : '<span style="color:#66768c;font-size:.78rem;">Belum Diproses</span>';
            const kepColor = r.keputusan === 'Diluluskan' ? '#15803d' : r.keputusan === 'Tidak Diluluskan' ? '#b91c1c' : r.keputusan === 'Syor Dilupuskan' ? '#475569' : '#66768c';
            const safeJson = JSON.stringify(r).replace(/'/g, '&apos;').replace(/</g, '&lt;');
            return `<tr>
                <td style="font-weight:700;color:#2563eb;">#${r.id}</td>
                <td style="font-weight:600;">${r.jenis_aset || '—'}</td>
                <td style="color:#66768c;">${new Date(r.created_at).toLocaleDateString('ms-MY', { day: 'numeric', month: 'short', year: 'numeric' })}</td>
                <td>${tarikhSiap}</td>
                <td>${isobadge(r)}</td>
                <td>${r.proses_semasa
                    ? `<span style="display:inline-flex;padding:.25rem .65rem;border-radius:20px;font-size:.7rem;font-weight:700;background:#f1f5f9;color:#475569;">${r.proses_semasa}</span>`
                    : '<span style="color:#66768c;">—</span>'}</td>
                <td><span style="font-weight:700;font-size:.78rem;color:${kepColor};">${r.keputusan || 'Menunggu'}</span></td>
                <td style="text-align:center;"><button type="button" class="btn-lihat" onclick='viewDetails(${safeJson})'>🔍 Lihat</button></td>
            </tr>`;
        }).join('') || '<tr><td colspan="8" style="padding:2.2rem;text-align:center;color:#66768c;">Tiada laporan dijumpai.</td></tr>';

        const from = totalItems === 0 ? 0 : start + 1;
        const to = Math.min(start + PAGE_SIZE, totalItems);
        document.getElementById('paginationInfo').textContent = `Menunjukkan ${from}–${to} daripada ${totalItems} laporan`;
        document.getElementById('btnPrev').disabled = currentPage <= 1;
        document.getElementById('btnNext').disabled = currentPage >= totalPages;

        const pageNums = document.getElementById('pageNumbers');
        pageNums.innerHTML = '';
        let startP = Math.max(1, currentPage - 2);
        let endP = Math.min(totalPages, startP + 4);
        if (endP - startP < 4) startP = Math.max(1, endP - 4);
        for (let p = startP; p <= endP; p++) {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.textContent = p;
            btn.onclick = () => changePage(p);
            btn.style.cssText = `width:32px;height:32px;border-radius:8px;border:1px solid rgba(37,99,235,.22);font-weight:700;font-size:.78rem;cursor:pointer;font-family:Outfit,sans-serif;background:${p === currentPage ? '#2563eb' : '#fff'};color:${p === currentPage ? '#fff' : '#24324b'};`;
            pageNums.appendChild(btn);
        }
        document.getElementById('paginationControls').style.display = totalPages <= 1 ? 'none' : 'flex';
    }

    function viewDetails(r) {
        currentReport = r;
        const isCompleted = r.status === 'Completed' || r.status === 'Resolved' || r.status === 'Rejected';
        document.getElementById('d_jenis').value = r.jenis_aset || '-';
        document.getElementById('d_siri').value = r.nombor_siri || '-';
        document.getElementById('d_pengguna').value = r.pengguna_terakhir || '-';
        document.getElementById('d_tarikh_rosak').value = r.tarikh_kerosakan ? new Date(r.tarikh_kerosakan).toLocaleDateString('ms-MY') : '-';
        document.getElementById('d_nama_jawatan').value = (r.nama_pelapor || '-') + ' / ' + (r.jawatan_pelapor || '-');
        document.getElementById('d_lokasi').value = r.location || '-';
        document.getElementById('d_perihal').value = r.perihal_kerosakan || '-';
        document.getElementById('d_created_at').value = r.created_at ? new Date(r.created_at).toLocaleDateString('ms-MY') : '-';
        const kos = parseFloat(r.kos_penyelenggaraan_dahulu) || 0;
        const anggaran = parseFloat(r.anggaran_kos) || 0;
        document.getElementById('d_kos_dahulu').value = kos > 0 ? 'RM ' + kos.toFixed(2) : '-';
        document.getElementById('d_anggaran_kos').value = anggaran > 0 ? 'RM ' + anggaran.toFixed(2) : '-';
        document.getElementById('d_syor').value = r.syor_ulasan || '-';
        document.getElementById('d_admin_nama').value = r.admin_name_jawatan || '-';
        document.getElementById('d_admin_jawatan').value = r.admin_jawatan || '-';
        document.getElementById('d_admin_tarikh').value = (isCompleted && r.admin_tarikh)
            ? new Date(r.admin_tarikh).toLocaleDateString('ms-MY', { day: 'numeric', month: 'long', year: 'numeric' })
            : 'Belum Diproses';
        document.getElementById('d_keputusan').value = r.keputusan || '-';
        document.getElementById('d_kep_nama').value = r.keputusan_nama || '-';
        document.getElementById('d_kep_tarikh').value = r.keputusan_tarikh ? new Date(r.keputusan_tarikh).toLocaleDateString('ms-MY') : '-';

        const prosesEl = document.getElementById('d_proses_semasa');
        if (r.proses_semasa) {
            const prosesColors = {
                'Diterima': { bg: '#e0f2fe', color: '#0369a1' },
                'Sedang Dibaikpulih': { bg: '#fef9c3', color: '#854d0e' },
                'Tunggu Panel / Alat Ganti': { bg: '#ffedd5', color: '#9a3412' },
                'Dihantar ke Panel Lantikan': { bg: '#ede9fe', color: '#6d28d9' },
                'Siap - Sedia Diambil': { bg: '#dcfce7', color: '#166534' },
            };
            const pc = prosesColors[r.proses_semasa] || { bg: '#f1f5f9', color: '#475569' };
            prosesEl.innerHTML = `<span style="display:inline-flex;padding:.45rem .9rem;border-radius:20px;font-size:.82rem;font-weight:700;background:${pc.bg};color:${pc.color};">${r.proses_semasa}</span>`;
        } else {
            prosesEl.innerHTML = '<span style="color:#66768c;font-size:.85rem;">⏳ Menunggu tindakan admin...</span>';
        }

        const modalDays = (isCompleted && r.admin_tarikh) ? calcIsoDays(r.created_at, r.admin_tarikh) : null;
        const isoEl = document.getElementById('d_iso_badge');
        if (modalDays !== null) {
            const pass = modalDays <= 14;
            isoEl.innerHTML = `<span style="display:inline-flex;padding:.35rem .85rem;border-radius:20px;font-size:.78rem;font-weight:700;background:${pass ? 'rgba(16,185,129,.12)' : 'rgba(239,68,68,.12)'};color:${pass ? '#059669' : '#dc2626'};border:1px solid ${pass ? 'rgba(16,185,129,.3)' : 'rgba(239,68,68,.3)'};">${pass ? '✅ Memenuhi ISO' : '⚠️ Melebihi ISO'} (${modalDays} hari)</span>`;
        } else {
            isoEl.innerHTML = '<span style="color:#66768c;font-size:.82rem;">—</span>';
        }

        const imgEl = document.getElementById('d_images');
        if (r.images && r.images.length > 0) {
            imgEl.innerHTML = `<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:.75rem;">
                ${r.images.map(img => `<div style="aspect-ratio:1;border-radius:8px;overflow:hidden;border:1px solid rgba(37,99,235,.16);"><img src="${img.image_path}" style="width:100%;height:100%;object-fit:cover;"></div>`).join('')}
            </div>`;
        } else {
            imgEl.innerHTML = '<p style="color:#66768c;font-size:.82rem;">Tiada gambar dilampirkan.</p>';
        }
        document.getElementById('detailModal').classList.add('active');
    }

    function closeModal() {
        document.getElementById('detailModal').classList.remove('active');
    }
    function showPwTooltip(icon) {
        const tooltip = icon.nextElementSibling;
        if (!tooltip) return;
        tooltip.classList.add('active');
        const rect = icon.getBoundingClientRect();
        const tooltipW = tooltip.offsetWidth;
        const tooltipH = tooltip.offsetHeight;
        // Always show above the icon
        let top = rect.top - tooltipH - 10;
        if (top < 8) top = rect.bottom + 10; // fallback below if not enough space above
        // Prefer right-aligned to the icon, but clamp to viewport
        let left = rect.right - tooltipW;
        if (left < 8) left = 8;
        if (left + tooltipW > window.innerWidth - 8) left = window.innerWidth - tooltipW - 8;
        tooltip.style.left = left + 'px';
        tooltip.style.top = top + 'px';
    }

    function hidePwTooltip(icon) {
        const tooltip = icon.nextElementSibling;
        if (tooltip) tooltip.classList.remove('active');
    }
</script>
</body>
</html>