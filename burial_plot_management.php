<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Burial Plot Management - Rest Assured</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
  :root{
    --bg:#f5f1ec; --ink:#3E2A1E; --ink-2:#664832; --brand:#8B6F4D; --muted:rgba(102,72,50,.7);
    --br:12px; --card:rgba(255,255,255,.8); --line:rgba(102,72,50,.12);
    --ok:#7fb07f; --warn:#d4a574; --busy:#8B6F4D;
  }
  *{box-sizing:border-box;margin:0;padding:0}
  body{font-family:Montserrat,system-ui,Arial,sans-serif;background:var(--bg);color:var(--ink);min-height:100vh;line-height:1.6}

  /* header */
  .top-header { position: fixed; inset: 0 0 auto 0; height: 70px; background: var(--bg); display: flex; align-items: center; justify-content: space-between; padding: 0 14px 0 18px; z-index: 1000; box-shadow: 0 2px 10px rgba(102, 72, 50, 0.08); }
  .logo { font-family: 'Cormorant Garamond', serif; font-size: 28px; font-weight: 600; color: var(--ink-2); text-decoration: none; }
  .logo::before { content: "RA"; }
  .header-right { display: flex; gap: 14px; align-items: center; }
  .search-container { position: relative; }
  .search-box { width: min(56vw, 360px); padding: 11px 42px 11px 16px; border: 2px solid rgba(102, 72, 50, 0.2); border-radius: 25px; background: rgba(255, 255, 255, 0.7); font-size: 14px; color: var(--ink-2); transition: 0.25s; }
  .search-box:focus { outline: none; border-color: var(--ink-2); background: rgba(255, 255, 255, 0.95); }
  .search-icon { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); }
  .notification-btn { background: none; border: 0; font-size: 20px; padding: 6px; border-radius: 50%; cursor: pointer; color: var(--ink-2); }
  .user-profile { display: flex; align-items: center; gap: 10px; background: var(--brand); color: #fff; border-radius: 25px; padding: 8px 14px; }
  .user-avatar { width: 34px; height: 34px; border-radius: 50%; display: grid; place-items: center; background: linear-gradient(135deg, var(--brand), var(--ink-2)); font-weight: 700; }
  .hamburger { display: none; border: 1px solid rgba(102, 72, 50, 0.2); background: #fff; border-radius: 10px; padding: 0.35rem 0.55rem; cursor: pointer; }

  /* layout */
  .dashboard { display: flex; min-height: 100vh; }
  .sidebar { position: fixed; top: 0; left: 0; height: 100vh; width: 280px; background: rgba(255, 255, 255, 0.45); backdrop-filter: blur(6px); padding: 88px 0 24px; overflow: auto; z-index: 900; transition: transform 0.25s; }
  .sidebar-header { padding: 0 24px 20px; }
  .sidebar-title { font-family: 'Cormorant Garamond', serif; font-size: 24px; font-weight: 600; color: var(--ink-2); }
  .sidebar-date { font-size: 12px; color: var(--muted); }
  .sidebar-nav { list-style: none; }
  .nav-link { display: flex; gap: 14px; align-items: center; padding: 14px 24px; color: var(--ink-2); text-decoration: none; border-radius: 0 22px 22px 0; margin-right: 22px; transition: 0.2s; }
  .nav-link:hover,.nav-link.active { background: rgba(139, 111, 77, 0.22); font-weight: 600; }
  .main { flex: 1; margin-left: 280px; padding: 92px 22px 26px; }

  /* tabs */
  .tabs { display: flex; gap: 0; background: rgba(255, 255, 255, 0.6); border-radius: 12px; padding: 6px; box-shadow: 0 2px 10px rgba(102, 72, 50, 0.08); margin-bottom: 22px; }
  .tab-btn { flex: 1; border: 0; border-radius: 8px; background: none; padding: 12px 14px; font-weight: 600; color: var(--ink-2); cursor: pointer; transition: 0.2s; }
  .tab-btn:hover { background: rgba(139, 111, 77, 0.12); }
  .tab-btn.active { background: var(--brand); color: #fff; }

  /* sections */
  .section { display: none; background: var(--card); border-radius: 14px; padding: 22px; box-shadow: 0 6px 18px rgba(102, 72, 50, 0.1); }
  .section.active { display: block; }
  .page-title { font-family: 'Cormorant Garamond', serif; font-size: 30px; font-weight: 600; color: var(--ink-2); margin-bottom: 6px; }
  .section-description { color: var(--muted); font-size: 14px; margin-bottom: 12px; }
  .controls { display: flex; justify-content: space-between; align-items: center; gap: 12px; margin: 8px 0 6px; }
  .controls-left { display: flex; gap: 10px; align-items: center; }
  .btn { border: 2px solid rgba(102, 72, 50, 0.2); background: #fff; color: var(--ink-2); border-radius: 8px; padding: 10px 14px; font-weight: 600; cursor: pointer; }
  .btn:hover { border-color: var(--brand); background: rgba(139, 111, 77, 0.08); }
  .btn-primary { border: 0; background: var(--brand); color: #fff; }
  .btn-primary:hover { background: var(--ink-2); }
  .search-small { padding: 10px 12px; border: 2px solid rgba(102, 72, 50, 0.2); border-radius: 8px; width: 240px; }

  /* table */
  table { width: 100%; border-collapse: collapse; margin-top: 10px; }
  th, td { text-align: left; padding: 14px; border-bottom: 1px solid var(--line); }
  th { background: rgba(139, 111, 77, 0.1); text-transform: uppercase; letter-spacing: 0.4px; font-size: 13px; color: var(--ink-2); }
  tbody tr:hover { background: rgba(139, 111, 77, 0.06); }
  .link { color: var(--brand); text-decoration: underline; cursor: pointer; }
  .muted { color: var(--muted); }

  /* map */
  .map-wrap { display: flex; gap: 22px; min-height: 420px; }
  .map-view { flex: 2; background: linear-gradient(135deg, rgba(139, 111, 77, 0.12), rgba(102, 72, 50, 0.06)); border-radius: 14px; display: grid; place-items: center; overflow: hidden; }
  .plot-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 8px; transform: rotate(-15deg); padding: 24px; }
  .plot { width: 64px; height: 84px; border-radius: 6px; display: grid; place-items: center; color: #fff; font-weight: 700; font-size: 10px; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3); cursor: pointer; transition: 0.18s; user-select: none; }
  .plot.available { background: linear-gradient(135deg, #a8c8a8, #7fb07f); }
  .plot.occupied { background: linear-gradient(135deg, #8B6F4D, #664832); }
  .plot.reserved { background: linear-gradient(135deg, #d4a574, #b8935f); }
  .plot:hover { transform: scale(1.05); }
  .plot.selected { transform: scale(1.1); box-shadow: 0 6px 16px rgba(102, 72, 50, 0.3); }
  .map-side { flex: 1; background: #fff; border-radius: 14px; padding: 22px; box-shadow: 0 2px 12px rgba(102, 72, 50, 0.08); }
  .status-dot { width: 12px; height: 12px; border-radius: 50%; display: inline-block; margin-right: 8px; }
  .status-occupied { background: var(--busy); }
  .status-available { background: var(--ok); }
  .status-reserved { background: var(--warn); }

  /* cards / form */
  .grid { display: grid; gap: 18px; }
  .grid-2 { grid-template-columns: 1fr 1fr; }
  .card { background: rgba(139, 111, 77, 0.06); border: 1px solid rgba(139, 111, 77, 0.12); border-radius: 12px; padding: 18px; }
  .label { font-size: 14px; font-weight: 700; color: var(--ink-2); margin-bottom: 6px; }
  .input, .select, .textarea { width: 100%; padding: 12px 14px; border: 2px solid rgba(102, 72, 50, 0.2); border-radius: 8px; background: #fff; color: var(--ink-2); }
  .textarea { min-height: 110px; resize: vertical; }
  .actions { display: flex; gap: 12px; justify-content: flex-end; margin-top: 16px; padding-top: 14px; border-top: 1px solid var(--line); }
  .badge { padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; color: #fff; }
  .badge.occupied { background: var(--busy); }
  .badge.available { background: var(--ok); }
  .badge.reserved { background: var(--warn); }

  /* modal */
  .modal { position: fixed; inset: 0; background: rgba(0, 0, 0, 0.5); display: none; align-items: center; justify-content: center; padding: 18px; z-index: 1100; }
  .modal.active { display: flex; }
  .modal-panel { background: #fff; border-radius: 18px; overflow: auto; max-height: 90vh; width: min(880px, 96vw); }
  .modal-head { background: linear-gradient(135deg, var(--brand), var(--ink-2)); color: #fff; padding: 18px 20px; display: flex; justify-content: space-between; align-items: center; }
  .modal-body { padding: 18px 20px; }
  .modal-close { background: none; border: 0; color: #fff; font-size: 24px; cursor: pointer; }

  /* footer */
  .footer { padding: 20px; margin-left: 280px; }
  .footer-grid { display: grid; grid-template-columns: auto 1fr auto auto; gap: 20px; align-items: center; }
  .footer-logo { font-family: 'Cormorant Garamond', serif; color: var(--ink-2); font-size: 20px; font-weight: 600; }
  .footer-logo::before { content: "RA"; }

  /* utility */
  .hidden{ display:none !important; }
  .spinner{ width:18px;height:18px;border:3px solid rgba(0,0,0,.1);border-top-color:var(--brand);border-radius:50%;animation:spin .8s linear infinite;display:inline-block }
  @keyframes spin{ to{ transform:rotate(360deg) } }
  .toast{ position:fixed;right:12px;bottom:12px;background:#fff;border:1px solid var(--line);border-left:4px solid var(--brand);padding:10px 12px;border-radius:10px;color:var(--ink-2);box-shadow:0 8px 20px rgba(102,72,50,.12);z-index:1200 }

  /* responsive */
  @media (max-width: 900px){
    .hamburger{display:block}
    .sidebar{transform:translateX(-100%)}
    .sidebar.show{transform:translateX(0)}
    .main,.footer{margin-left:0}
    .search-box{width:56vw}
    .controls{flex-direction:column;align-items:stretch}
    .controls-left{justify-content:center}
    .search-small{width:100%}
    .map-wrap{flex-direction:column;min-height:unset}
    .grid-2{grid-template-columns:1fr}
  }
</style>
</head>
<body>
  <!-- header -->
  <header class="top-header">
    <button class="hamburger" id="hamburger" aria-label="Toggle menu">☰</button>
    <a href="#" class="logo" aria-label="Rest Assured"></a>
    <div class="header-right">
      <div class="search-container">
        <input class="search-box" id="globalSearch" placeholder="Search" />
        <span class="search-icon" aria-hidden="true">🔍</span>
      </div>
      <button class="notification-btn" title="Notifications" aria-label="Notifications">🔔</button>
      <div class="user-profile" role="button" tabindex="0">
        <div class="user-avatar">A</div><span>Admin</span><span aria-hidden="true">▼</span>
      </div>
    </div>
  </header>

  <div class="dashboard">
    <!-- sidebar -->
    <aside class="sidebar" id="sidebar" aria-label="Sidebar">
      <div class="sidebar-header">
        <div class="sidebar-title">Burial Plot Management</div>
        <div class="sidebar-date" id="sidebarDate">—</div>
      </div>
      <nav>
        <ul class="sidebar-nav">
          <li class="nav-item"><a href="admin_dashboard.php" class="nav-link"><span class="nav-icon">📊</span>Dashboard</a></li>
          <li class="nav-item"><a href="#" class="nav-link active"><span class="nav-icon">⚰️</span>Burial Plot Management</a></li>
          <li class="nav-item"><a href="manage_record.php" class="nav-link"><span class="nav-icon">👥</span>Manage Customer Records</a></li>
          <li class="nav-item"><a href="admin_transaction_management.php" class="nav-link"><span class="nav-icon">💳</span>Transaction Management</a></li>
          <li class="nav-item"><a href="notification_management.php" class="nav-link"><span class="nav-icon">🔔</span>Notification Management</a></li>
          <li class="nav-item"><a href="report_analytics.php" class="nav-link"><span class="nav-icon">📈</span>Report & Analytics</a></li>
        </ul>
      </nav>
    </aside>

    <!-- main -->
    <main class="main">
      <!-- tabs -->
      <div class="tabs" id="tabs" role="tablist">
        <button class="tab-btn active" data-tab="plots" role="tab" aria-selected="true">Plots</button>
        <button class="tab-btn" data-tab="map" role="tab" aria-selected="false">Map</button>
        <button class="tab-btn" data-tab="burials" role="tab" aria-selected="false">Burials</button>
      </div>

      <!-- PLOTS -->
      <section id="plots" class="section active" aria-labelledby="plotsTitle">
        <h2 id="plotsTitle" class="page-title">All plots</h2>
        <p class="section-description">Manage burial plots and track plot occupancy.</p>

        <div class="controls">
          <div class="controls-left">
            <button class="btn" id="btnFilter">🔽 Filter</button>
            <button class="btn" id="btnSort">Sort by ▼</button>
            <input class="search-small" id="searchPlots" placeholder="Search plot / owner / burial"/>
          </div>
          <div style="display:flex;gap:8px;align-items:center">
            <span id="plotsLoading" class="muted hidden"><span class="spinner"></span> Loading…</span>
            <button class="btn-primary" id="btnAddPlot">➕ Add plot</button>
          </div>
        </div>

        <table aria-describedby="plotsHelp">
          <thead>
            <tr><th>PLOT</th><th>STATUS</th><th>OWNER</th><th>BURIAL</th></tr>
          </thead>
          <tbody id="plotsBody"></tbody>
        </table>
        <div id="plotsEmpty" class="muted" style="padding:14px;display:none">No plots yet.</div>
        <p id="plotsHelp" class="muted" style="margin-top:8px">Click a plot code to view full details.</p>
      </section>

      <!-- MAP -->
      <section id="map" class="section" aria-labelledby="mapTitle">
        <h2 id="mapTitle" class="page-title">Cemetery map</h2>
        <div class="map-wrap">
          <div class="map-view">
            <div id="mapLoading" class="muted"><span class="spinner"></span> Loading map…</div>
            <div class="plot-grid hidden" id="plotGrid"></div>
          </div>
          <aside class="map-side">
            <div id="mapHeader" style="margin-bottom:12px;font-weight:700;color:var(--ink-2)">
              <span class="status-dot" style="background:#ccc"></span>Select a plot
            </div>
            <div id="mapStatus" style="margin-bottom:14px;color:var(--muted)">—</div>
            <div class="card">
              <div class="label">Owner</div>
              <div id="mapOwner" style="margin-bottom:6px">—</div>
              <a href="#" class="link" id="mapAddOwner">+ Add</a>
            </div>
            <div class="card" style="margin-top:12px">
              <div class="label">Burials</div>
              <div id="mapBurial">—</div>
              <div id="mapBurialId" class="muted" style="font-size:12px">—</div>
              <a href="#" class="link">+ Add</a>
            </div>
            <div class="card" style="margin-top:12px">
              <div class="label">Notes</div>
              <textarea class="textarea" placeholder="Notes"></textarea>
            </div>
          </aside>
        </div>
      </section>

      <!-- BURIALS -->
      <section id="burials" class="section" aria-labelledby="burialsTitle">
        <h2 id="burialsTitle" class="page-title">Burials quick view</h2>
        <div class="card" style="margin-bottom:14px;display:flex;justify-content:space-between;align-items:center">
          <div style="display:flex;align-items:center;gap:10px">
            <span aria-hidden="true">🧑‍💼</span>
            <div>
              <div class="label" style="margin-bottom:0" id="burialName">—</div>
              <div style="font-size:12px;color:var(--muted)">Burial</div>
            </div>
          </div>
          <button class="btn-primary" id="btnViewOnMap">View on map</button>
        </div>

        <div class="grid grid-2">
          <div class="card">
            <div class="label">Plot</div>
            <div style="display:flex;gap:10px;align-items:center">
              <input class="input" id="burialPlotCode" placeholder="Section/Lot/Grave"/>
              <span class="badge available" id="burialPlotStatus">Status</span>
            </div>
          </div>

          <div class="card">
            <div class="label">Burial Information</div>
            <div style="height:120px;display:grid;place-items:center;color:var(--muted)" id="burialInfo">—</div>
          </div>

          <div class="card">
            <div class="label">Unique Code</div>
            <input class="input" id="burialUniqueCode" placeholder="e.g., D001"/>
          </div>
        </div>
      </section>

      <!-- ADD PLOT (opens from button; not a tab) -->
      <section id="addPlot" class="section" aria-labelledby="addPlotTitle">
        <h2 id="addPlotTitle" class="page-title">Add New Plot</h2>

        <div class="card" style="margin-top:8px">
          <div class="label">Plot Identification</div>
          <div class="grid grid-2" style="margin-top:10px">
            <div>
              <div class="label">Deceased's name</div>
              <input class="input" id="fDeceasedName" placeholder="Enter deceased's name"/>
            </div>
            <div>
              <div class="label">Plot ID/Code</div>
              <input class="input" id="fPlotCode" placeholder="Enter plot code (e.g., A/177/1)"/>
            </div>
            <div>
              <div class="label">Block no.</div>
              <input class="input" id="fBlockNo" placeholder="Enter block number"/>
            </div>
            <div>
              <div class="label">Section</div>
              <select class="select" id="fSection"><option value="">Select section</option><option>A</option><option>B</option><option>C</option></select>
            </div>
            <div>
              <div class="label">Lot</div>
              <input class="input" id="fLot" placeholder="Enter lot number"/>
            </div>
          </div>
        </div>

        <div class="card" style="margin-top:14px">
          <div class="label">Status Availability</div>
          <div class="grid grid-2" style="margin-top:10px">
            <div>
              <div class="label">Reserve for</div>
              <input class="input" id="fReservedFor" placeholder="Enter name"/>
            </div>
            <div>
              <div class="label">Plot Status</div>
              <select class="select" id="fStatus"><option value="available">Available</option><option value="occupied">Occupied</option><option value="reserved">Reserved</option></select>
            </div>
            <div>
              <div class="label">Reservation expiry date</div>
              <input type="date" class="input" id="fExpiry"/>
            </div>
          </div>
        </div>

        <!-- ✅ Owner block moved INSIDE the Add Plot form -->
        <div class="card" style="margin-top:14px">
          <div class="label">Owner (optional)</div>
          <div class="grid grid-2" style="margin-top:10px">
            <div>
              <div class="label">Owner name</div>
              <input class="input" id="fOwnerName" placeholder="e.g., Juan Dela Cruz"/>
            </div>
            <div>
              <div class="label">Contact number</div>
              <input class="input" id="fOwnerContact" placeholder="09xx xxx xxxx"/>
            </div>
            <div>
              <div class="label">Email</div>
              <input class="input" id="fOwnerEmail" placeholder="owner@email.com"/>
            </div>
            <div>
              <div class="label">Address</div>
              <input class="input" id="fOwnerAddress" placeholder="Street, Barangay, City"/>
            </div>
            <div>
              <div class="label">Purchase date</div>
              <input type="date" class="input" id="fPurchaseDate"/>
            </div>
          </div>
        </div>

        <!-- ✅ Actions at the very bottom -->
        <div class="actions" style="margin-top:14px">
          <button class="btn" id="btnCancelAdd">Cancel</button>
          <button class="btn-primary" id="btnSubmitAdd">Add plot</button>
        </div>
      </section>
    </main>
  </div>

  <!-- footer -->
  <footer class="footer">
    <div class="footer-grid">
      <div class="footer-logo"></div>
      <div>For assistance: <a href="mailto:r.assured@gmail.com" style="color:var(--ink-2);text-decoration:none">r.assured@gmail.com</a></div>
      <div>09193210292</div>
      <div style="text-align:right;color:var(--brand);font-size:12px">© 2024 Rest Assured. All Rights Reserved.</div>
    </div>
  </footer>

  <!-- PLOT INFO MODAL -->
  <div class="modal" id="plotModal" aria-modal="true" role="dialog" aria-labelledby="modalTitle">
    <div class="modal-panel">
      <div class="modal-head">
        <div id="modalTitle">Plot Information</div>
        <button class="modal-close" id="modalClose" aria-label="Close">&times;</button>
      </div>
      <div class="modal-body">
        <div class="grid grid-2">
          <div class="card">
            <div class="label">Plot ID</div>
            <div id="mPlotId">—</div>
            <div class="label" style="margin-top:10px">Section</div>
            <input id="mSection" class="input" value="" readonly>
            <div class="label" style="margin-top:10px">Lot Number</div>
            <input id="mLot" class="input" value="" readonly>
            <div class="label" style="margin-top:10px">Grave Number</div>
            <input id="mGrave" class="input" value="" readonly>
            <div class="label" style="margin-top:10px">Status</div>
            <select id="mStatus" class="select" disabled>
              <option>Available</option><option>Occupied</option><option>Reserved</option>
            </select>
          </div>

          <div class="card">
            <div class="label">Owner Name</div>
            <input id="mOwner" class="input" value="" readonly>
            <div class="label" style="margin-top:10px">Contact Number</div>
            <input id="mContact" class="input" value="" readonly>
            <div class="label" style="margin-top:10px">Email</div>
            <input id="mEmail" class="input" value="" readonly>
            <div class="label" style="margin-top:10px">Address</div>
            <input id="mAddress" class="input" value="" readonly>
            <div class="label" style="margin-top:10px">Purchase Date</div>
            <input id="mPurchase" type="date" class="input" value="" readonly>
          </div>

          <div class="card">
            <div class="label">Deceased Name</div>
            <input id="mDeceased" class="input" value="" readonly>
            <div class="grid grid-2" style="margin-top:10px">
              <div>
                <div class="label">Date of Birth</div>
                <input id="mBirth" type="date" class="input" value="" readonly>
              </div>
              <div>
                <div class="label">Date of Death</div>
                <input id="mDeath" type="date" class="input" value="" readonly>
              </div>
              <div>
                <div class="label">Burial Date</div>
                <input id="mBurialDate" type="date" class="input" value="" readonly>
              </div>
              <div>
                <div class="label">Burial ID</div>
                <input id="mBurialId" class="input" value="" readonly>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="label">Payment Status</div>
            <select id="mPayStatus" class="select" disabled>
              <option>Paid</option><option>Pending</option><option>Overdue</option>
            </select>
            <div class="grid grid-2" style="margin-top:10px">
              <div>
                <div class="label">Amount Paid</div>
                <input id="mAmount" type="number" class="input" value="" readonly>
              </div>
              <div>
                <div class="label">Next Payment Due</div>
                <input id="mNextPay" type="date" class="input" value="" readonly>
              </div>
            </div>
            <div class="label" style="margin-top:10px">Payment Plan</div>
            <select id="mPlan" class="select" disabled>
              <option>Full Payment</option><option>Monthly</option><option>Quarterly</option><option>Annually</option>
            </select>
          </div>

          <div class="card" style="grid-column:1/-1">
            <div class="label">Notes & Additional Information</div>
            <textarea id="mNotes" class="textarea" readonly placeholder="—"></textarea>
          </div>
        </div>
      </div>
    </div>
  </div>

<script>
  // ===== CONFIG: change endpoints to your PHP routes =====
const BASE = 'http://localhost:3000/api';
const API = {
  plots: `${BASE}/api_plots.php`,
  plotById: id => `${BASE}/api_plot.php?id=${encodeURIComponent(id)}`,
  map: `${BASE}/api_map_plots.php`,
  burials: `${BASE}/api_burials.php`,
  create: `${BASE}/api_plot_create.php`
};
  // ===== Utils =====
  const $ = s => document.querySelector(s);
  const $$ = s => document.querySelectorAll(s);
  const fmtStatus = s => (s||'').toLowerCase();
  const toast = (msg) => {
    const t = document.createElement('div'); t.className='toast'; t.textContent = msg; document.body.appendChild(t);
    setTimeout(()=>{ t.remove(); }, 2600);
  };
  const debounce = (fn, ms=250)=>{ let id; return (...a)=>{ clearTimeout(id); id=setTimeout(()=>fn(...a), ms); } };

  // sidebar toggle (mobile)
  $('#hamburger').addEventListener('click', ()=> $('#sidebar').classList.toggle('show'));

  // date on sidebar
  (function setDate(){
    const now=new Date();
    $('#sidebarDate').textContent = now.toLocaleDateString('en-US',{weekday:'long',year:'numeric',month:'long',day:'numeric'});
  })();

  // global search (just focuses plots filter for now)
  $('#globalSearch').addEventListener('keydown',(e)=>{ if(e.key==='Enter'){ $('#searchPlots').value=e.target.value; $('#searchPlots').dispatchEvent(new Event('input')); } });

  // ===== Tabs =====
  function showSection(id){ $$('.section').forEach(s=>s.classList.remove('active')); if(id) $('#'+id).classList.add('active'); }
  function activateTab(id){ $$('.tab-btn').forEach(b=>{ const is = b.dataset.tab===id; b.classList.toggle('active', is); b.setAttribute('aria-selected', String(is)); }); }
  $$('.tab-btn').forEach(btn=>{
    btn.addEventListener('click', ()=>{ const tab = btn.dataset.tab; activateTab(tab); showSection(tab); if(tab==='map') ensurePlotsBuilt(); window.scrollTo({top:0,behavior:'smooth'}); });
  });

  // ===== Add Plot flow (client-only; POST optional) =====
  $('#btnAddPlot').addEventListener('click', ()=>{ activateTab(''); showSection('addPlot'); window.scrollTo({top:0,behavior:'smooth'}); });
  $('#btnCancelAdd').addEventListener('click', ()=>{ activateTab('plots'); showSection('plots'); });
  $('#btnSubmitAdd').addEventListener('click', async ()=>{
    const payload = {
    deceased_name: $('#fDeceasedName').value.trim(),
    plot_code: $('#fPlotCode').value.trim(),
    block_no: $('#fBlockNo').value.trim(),
    section: $('#fSection').value,
    lot: $('#fLot').value.trim(),
    reserved_for: $('#fReservedFor').value.trim(),
    status: $('#fStatus').value,
    expiry: $('#fExpiry').value,

    owner_name: $('#fOwnerName').value.trim(),
    owner_phone: $('#fOwnerContact').value.trim(),   // <-- was owner_contact
    owner_email: $('#fOwnerEmail').value.trim(),
    owner_address: $('#fOwnerAddress').value.trim(),
    purchase_date: $('#fPurchaseDate').value
  };
  if(!payload.plot_code){ toast('Plot code is required'); return; }

  try{
    const res = await fetch(API.create, {
      method:'POST',
      headers:{'Content-Type':'application/json'},
      credentials:'include',
      body: JSON.stringify(payload)
    });
    if(!res.ok){
      const txt = await res.text();
      throw new Error(`HTTP ${res.status} – ${txt}`);
    }
    await res.json();
    
    toast('Plot saved');
    activateTab('plots'); 
    showSection('plots');
    await loadPlots();
    mapBuilt = false;  
  }catch(err){
    alert(`Save failed:\n${err.message}`);   // <-- makita nimo ang tunay nga rason (404/500/CORS/DB)
  }
});

  // ===== PLOTS TABLE =====
  const bodyEl = $('#plotsBody');
  const emptyEl = $('#plotsEmpty');
  const plotsLoading = $('#plotsLoading');

  function renderPlotRows(rows){
    bodyEl.innerHTML = '';
    if(!rows || !rows.length){ emptyEl.style.display='block'; return; }
    emptyEl.style.display='none';
    const frag = document.createDocumentFragment();
    rows.forEach(r=>{
      const tr = document.createElement('tr');
      const tdPlot = document.createElement('td');
      const a = document.createElement('span'); a.className='link'; a.textContent=r.plot_code; a.dataset.plot=r.plot_code; a.addEventListener('click', ()=> openModalForPlot(r.plot_code));
      tdPlot.appendChild(a);
      const tdStatus = document.createElement('td'); tdStatus.textContent = (r.status||'-').replace(/^./, c=>c.toUpperCase());
      const tdOwner = document.createElement('td'); tdOwner.textContent = r.owner_name || '-';
      const tdBurial = document.createElement('td'); tdBurial.textContent = r.deceased_name || '-';
      tr.append(tdPlot, tdStatus, tdOwner, tdBurial);
      frag.appendChild(tr);
    });
    bodyEl.appendChild(frag);
  }

  async function loadPlots(){
    try{
      plotsLoading.classList.remove('hidden');
      const res = await fetch(API.plots, {credentials:'include'});
      if(!res.ok) throw new Error('HTTP '+res.status);
      const data = await res.json();
      renderPlotRows(Array.isArray(data)?data:[]);
    }catch(err){
      console.error('Failed to load plots', err);
      bodyEl.innerHTML = '';
      emptyEl.style.display='block';
      emptyEl.textContent = 'Cannot load plots. Connect API.';
    } finally { plotsLoading.classList.add('hidden'); }
  }

  // plots search (debounced)
  $('#searchPlots').addEventListener('input', debounce((e)=>{
    const q = e.target.value.toLowerCase();
    $$('#plotsBody tr').forEach(row=>{ const t = row.textContent.toLowerCase(); row.style.display = t.includes(q)? '' : 'none'; });
  }, 120));

  // filter & sort (simple, client-side)
  $('#btnFilter').addEventListener('click', ()=>{
    const choice = prompt('Filter by status:\nAll\nOccupied\nAvailable\nReserved');
    if(!choice) return;
    $$('#plotsBody tr').forEach(tr=>{
      if(choice==='All') tr.style.display='';
      else tr.style.display = tr.children[1].textContent.trim()===choice ? '' : 'none';
    });
  });
  $('#btnSort').addEventListener('click', ()=>{
    const opt = prompt('Sort by:\nPlot Code\nStatus\nOwner\nBurial');
    const map = { 'Plot Code':0,'Status':1,'Owner':2,'Burial':3 };
    const idx = map[opt]; if(idx==null) return;
    const body = $('#plotsBody');
    [...body.querySelectorAll('tr')]
      .sort((a,b)=> a.children[idx].textContent.trim().localeCompare(b.children[idx].textContent.trim()))
      .forEach(tr=>body.appendChild(tr));
  });

  // ===== MODAL (loads details from API) =====
  function fillModal(d={}){
    $('#modalTitle').textContent = 'Plot Information' + (d.plot_code? ' - '+d.plot_code : '');
    $('#mPlotId').textContent = d.plot_code || '—';
    const [sec='', lot='', grave=''] = (d.plot_code||'//').split('/');
    $('#mSection').value = d.section || sec; 
    $('#mLot').value = d.lot || lot; 
    $('#mGrave').value = d.grave || grave;
    $('#mStatus').value = (d.status||'available').replace(/^./,c=>c.toUpperCase());
    $('#mOwner').value = d.owner_name || '';
    $('#mContact').value = d.owner_contact || '';
    $('#mEmail').value = d.owner_email || '';
    $('#mAddress').value = d.owner_address || '';
    $('#mPurchase').value = d.purchase_date || '';
    $('#mDeceased').value = d.deceased_name || '';
    $('#mBirth').value = d.birth_date || '';
    $('#mDeath').value = d.death_date || '';
    $('#mBurialDate').value = d.burial_date || '';
    $('#mBurialId').value = d.burial_id || '';
    $('#mPayStatus').value = (d.payment_status||'Pending').replace(/^./,c=>c.toUpperCase());
    $('#mAmount').value = d.amount_paid || '';
    $('#mNextPay').value = d.next_payment_due || '';
    $('#mPlan').value = d.payment_plan || 'Full Payment';
    $('#mNotes').value = d.notes || '';
  }

  async function openModalForPlot(plotCode){
    try{
      const res = await fetch(API.plotById(plotCode), {credentials:'include'});
      const data = res.ok ? await res.json() : {};
      fillModal(data||{});
    }catch{ fillModal({ plot_code: plotCode }); }
    $('#plotModal').classList.add('active'); document.body.style.overflow='hidden';
  }
  $('#modalClose').addEventListener('click', ()=>{ $('#plotModal').classList.remove('active'); document.body.style.overflow=''; });
  $('#plotModal').addEventListener('click', (e)=>{ if(e.target===e.currentTarget){ $('#modalClose').click(); }});

  // ===== MAP: render from API =====
  let mapBuilt = false;
  async function ensurePlotsBuilt(){
    if(mapBuilt) return;
    const grid = $('#plotGrid');
    $('#mapLoading').classList.remove('hidden');
    grid.classList.add('hidden');
    grid.innerHTML = '';
    try{
      const res = await fetch(API.map, {credentials:'include'});
      const items = res.ok ? await res.json() : [];
      if(!items.length){ grid.innerHTML = '<div style="transform:rotate(15deg);color:var(--muted)">No map data</div>'; $('#mapLoading').classList.add('hidden'); grid.classList.remove('hidden'); return; }
      items.forEach(p=>{
        const el = document.createElement('div');
        const status = fmtStatus(p.status||'available');
        el.className = `plot ${status}`;
        el.textContent = p.plot_code; // e.g., A/177/1
        el.title = `${p.section||'-'}/${p.lot||'-'}/${p.grave||'-'} – ${status}`;
        el.addEventListener('click', ()=>{
          $$('#plotGrid .plot').forEach(i=>i.classList.remove('selected'));
          el.classList.add('selected');
          updateMapSideFrom(p);
        });
        grid.appendChild(el);
      });
      mapBuilt = true;
    }catch(err){
      console.error('Map load error', err);
      grid.innerHTML = '<div style="transform:rotate(15deg);color:var(--muted)">Connect API for map</div>';
    } finally { $('#mapLoading').classList.add('hidden'); grid.classList.remove('hidden'); }
  }

  function updateMapSideFrom(p){
    const status = fmtStatus(p.status||'available');
    $('#mapHeader').innerHTML = `<span class="status-dot status-${status}"></span>Section ${p.section||'-'} / Lot ${p.lot||'-'} / Grave ${p.grave||'-'}`;
    $('#mapStatus').textContent = (status.charAt(0).toUpperCase()+status.slice(1));
    $('#mapOwner').textContent = p.owner_name || '—';
    $('#mapBurial').textContent = p.deceased_name || '—';
    $('#mapBurialId').textContent = p.burial_id || '—';
  }

  // ===== BURIALS quick view (skeleton) =====
  $('#btnViewOnMap').addEventListener('click', ()=>{ activateTab('map'); showSection('map'); ensurePlotsBuilt(); window.scrollTo({top:0,behavior:'smooth'}); });

  // Initial loads
  (async function init(){
    await loadPlots();
    // optionally: fetch burials and show latest in the quick view
    try{
      const r = await fetch(API.burials, {credentials:'include'});
      if(r.ok){ const list = await r.json(); if(list.length){ const b = list[0]; $('#burialName').textContent = b.deceased_name || '—'; $('#burialPlotCode').value = b.plot_code || ''; $('#burialUniqueCode').value = b.unique_code || ''; }}
    }catch{}
  })();
</script>
</body>
</html>
