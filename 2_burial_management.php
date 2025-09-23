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
    --br:12px; --card:rgba(255,255,255,.8); --line:rgba(102,72,50,.12)
  }
  *{box-sizing:border-box;margin:0;padding:0}
  body{font-family:Montserrat,system-ui,Arial,sans-serif;background:var(--bg);color:var(--ink);min-height:100vh;line-height:1.6}

  /* header */
  .top-header {
  position: fixed;
  inset: 0 0 auto 0;
  height: 70px;
  background: var(--bg);
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 14px 0 18px;
  z-index: 1000;
  box-shadow: 0 2px 10px rgba(102, 72, 50, 0.08);
}

.logo {
  font-family: 'Cormorant Garamond', serif;
  font-size: 28px;
  font-weight: 600;
  color: var(--ink-2);
  text-decoration: none;
}

.logo::before {
  content: "RA";
}

.header-right {
  display: flex;
  gap: 14px;
  align-items: center;
}

.search-container {
  position: relative;
}

.search-box {
  width: min(56vw, 360px);
  padding: 11px 42px 11px 16px;
  border: 2px solid rgba(102, 72, 50, 0.2);
  border-radius: 25px;
  background: rgba(255, 255, 255, 0.7);
  font-size: 14px;
  color: var(--ink-2);
  transition: 0.25s;
}

.search-box:focus {
  outline: none;
  border-color: var(--ink-2);
  background: rgba(255, 255, 255, 0.95);
}

.search-icon {
  position: absolute;
  right: 14px;
  top: 50%;
  transform: translateY(-50%);
}

.notification-btn {
  background: none;
  border: 0;
  font-size: 20px;
  padding: 6px;
  border-radius: 50%;
  cursor: pointer;
  color: var(--ink-2);
}

.user-profile {
  display: flex;
  align-items: center;
  gap: 10px;
  background: var(--brand);
  color: #fff;
  border-radius: 25px;
  padding: 8px 14px;
}

.user-avatar {
  width: 34px;
  height: 34px;
  border-radius: 50%;
  display: grid;
  place-items: center;
  background: linear-gradient(135deg, var(--brand), var(--ink-2));
  font-weight: 700;
}

.hamburger {
  display: none;
  border: 1px solid rgba(102, 72, 50, 0.2);
  background: #fff;
  border-radius: 10px;
  padding: 0.35rem 0.55rem;
  cursor: pointer;
}

/* layout */
.dashboard {
  display: flex;
  min-height: 100vh;
}

.sidebar {
  position: fixed;
  top: 0;
  left: 0;
  height: 100vh;
  width: 280px;
  background: rgba(255, 255, 255, 0.45);
  padding: 88px 0 24px;
  overflow: auto;
  z-index: 900;
  transition: transform 0.25s;
}

.sidebar-header {
  padding: 0 24px 20px;
}

.sidebar-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 24px;
  font-weight: 600;
  color: var(--ink-2);
}

.sidebar-date {
  font-size: 12px;
  color: var(--muted);
}

.sidebar-nav {
  list-style: none;
}

.nav-link {
  display: flex;
  gap: 14px;
  align-items: center;
  padding: 14px 24px;
  color: var(--ink-2);
  text-decoration: none;
  border-radius: 0 22px 22px 0;
  margin-right: 22px;
  transition: 0.2s;
}

.nav-link:hover,
.nav-link.active {
  background: rgba(139, 111, 77, 0.22);
  font-weight: 600;
}

.main {
  flex: 1;
  margin-left: 280px;
  padding: 92px 22px 26px;
}

/* tabs */
.tabs {
  display: flex;
  gap: 0;
  background: rgba(255, 255, 255, 0.6);
  border-radius: 12px;
  padding: 6px;
  box-shadow: 0 2px 10px rgba(102, 72, 50, 0.08);
  margin-bottom: 22px;
}

.tab-btn {
  flex: 1;
  border: 0;
  border-radius: 8px;
  background: none;
  padding: 12px 14px;
  font-weight: 600;
  color: var(--ink-2);
  cursor: pointer;
  transition: 0.2s;
}

.tab-btn:hover {
  background: rgba(139, 111, 77, 0.12);
}

.tab-btn.active {
  background: var(--brand);
  color: #fff;
}

/* sections */
.section {
  display: none;
  background: var(--card);
  border-radius: 14px;
  padding: 22px;
  box-shadow: 0 6px 18px rgba(102, 72, 50, 0.1);
}

.section.active {
  display: block;
}

.page-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 30px;
  font-weight: 600;
  color: var(--ink-2);
  margin-bottom: 6px;
}

.section-description {
  color: var(--muted);
  font-size: 14px;
  margin-bottom: 12px;
}

.controls {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 12px;
  margin: 8px 0 6px;
}

.controls-left {
  display: flex;
  gap: 10px;
  align-items: center;
}

.btn {
  border: 2px solid rgba(102, 72, 50, 0.2);
  background: #fff;
  color: var(--ink-2);
  border-radius: 8px;
  padding: 10px 14px;
  font-weight: 600;
  cursor: pointer;
}

.btn:hover {
  border-color: var(--brand);
  background: rgba(139, 111, 77, 0.08);
}

.btn-primary {
  border: 0;
  background: var(--brand);
  color: #fff;
}

.btn-primary:hover {
  background: var(--ink-2);
}

.search-small {
  padding: 10px 12px;
  border: 2px solid rgba(102, 72, 50, 0.2);
  border-radius: 8px;
  width: 240px;
}

/* table */
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
}

th,
td {
  text-align: left;
  padding: 14px;
  border-bottom: 1px solid var(--line);
}

th {
  background: rgba(139, 111, 77, 0.1);
  text-transform: uppercase;
  letter-spacing: 0.4px;
  font-size: 13px;
  color: var(--ink-2);
}

tbody tr:hover {
  background: rgba(139, 111, 77, 0.06);
}

.link {
  color: var(--brand);
  text-decoration: underline;
  cursor: pointer;
}

/* map */
.map-wrap {
  display: flex;
  gap: 22px;
  height: 600px;
}

.map-view {
  flex: 2;
  background: linear-gradient(135deg, rgba(139, 111, 77, 0.12), rgba(102, 72, 50, 0.06));
  border-radius: 14px;
  display: grid;
  place-items: center;
  overflow: hidden;
}

.plot-grid {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 8px;
  transform: rotate(-15deg);
}

.plot {
  width: 60px;
  height: 80px;
  border-radius: 6px;
  display: grid;
  place-items: center;
  color: #fff;
  font-weight: 700;
  font-size: 10px;
  text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
  cursor: pointer;
  transition: 0.18s;
}

.plot.available {
  background: linear-gradient(135deg, #a8c8a8, #7fb07f);
}

.plot.occupied {
  background: linear-gradient(135deg, #8B6F4D, #664832);
}

.plot.reserved {
  background: linear-gradient(135deg, #d4a574, #b8935f);
}

.plot:hover {
  transform: scale(1.05);
}

.plot.selected {
  transform: scale(1.1);
  box-shadow: 0 6px 16px rgba(102, 72, 50, 0.3);
}

.map-side {
  flex: 1;
  background: #fff;
  border-radius: 14px;
  padding: 22px;
  box-shadow: 0 2px 12px rgba(102, 72, 50, 0.08);
}

.status-dot {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  display: inline-block;
  margin-right: 8px;
}

.status-occupied {
  background: #8B6F4D;
}

.status-available {
  background: #7fb07f;
}

.status-reserved {
  background: #d4a574;
}

/* cards / form */
.grid {
  display: grid;
  gap: 18px;
}

.grid-2 {
  grid-template-columns: 1fr 1fr;
}

.card {
  background: rgba(139, 111, 77, 0.06);
  border: 1px solid rgba(139, 111, 77, 0.12);
  border-radius: 12px;
  padding: 18px;
}

.label {
  font-size: 14px;
  font-weight: 700;
  color: var(--ink-2);
  margin-bottom: 6px;
}

.input,
.select,
.textarea {
  width: 100%;
  padding: 12px 14px;
  border: 2px solid rgba(102, 72, 50, 0.2);
  border-radius: 8px;
  background: #fff;
  color: var(--ink-2);
}

.textarea {
  min-height: 110px;
  resize: vertical;
}

.actions {
  display: flex;
  gap: 12px;
  justify-content: flex-end;
  margin-top: 16px;
  padding-top: 14px;
  border-top: 1px solid var(--line);
}

.badge {
  padding: 6px 12px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 700;
  color: #fff;
}

.badge.occupied {
  background: #8B6F4D;
}

.badge.available {
  background: #7fb07f;
}

.badge.reserved {
  background: #d4a574;
}

/* modal (unchanged style from previous) */
.modal {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.5);
  display: none;
  align-items: center;
  justify-content: center;
  padding: 18px;
  z-index: 1100;
}

.modal.active {
  display: flex;
}

.modal-panel {
  background: #fff;
  border-radius: 18px;
  overflow: auto;
  max-height: 90vh;
  width: min(880px, 96vw);
}

.modal-head {
  background: linear-gradient(135deg, var(--brand), var(--ink-2));
  color: #fff;
  padding: 18px 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.modal-body {
  padding: 18px 20px;
}

.modal-close {
  background: none;
  border: 0;
  color: #fff;
  font-size: 24px;
  cursor: pointer;
}

/* footer */
.footer {
  padding: 20px;
  margin-left: 280px;
}

.footer-grid {
  display: grid;
  grid-template-columns: auto 1fr auto auto;
  gap: 20px;
  align-items: center;
}

.footer-logo {
  font-family: 'Cormorant Garamond', serif;
  color: var(--ink-2);
  font-size: 20px;
  font-weight: 600;
}

.footer-logo::before {
  content: "RA";
}

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
    .map-wrap{flex-direction:column;height:auto}
    .grid-2{grid-template-columns:1fr}
  }
</style>
</head>
<body>
  <!-- header -->
  <header class="top-header">
    <button class="hamburger" id="hamburger">☰</button>
    <a href="#" class="logo"></a>
    <div class="header-right">
      <div class="search-container">
        <input class="search-box" placeholder="Search" />
        <span class="search-icon">🔍</span>
      </div>
      <button class="notification-btn" title="Notifications">🔔</button>
      <div class="user-profile">
        <div class="user-avatar">A</div><span>Admin</span><span>▼</span>
      </div>
    </div>
  </header>

  <div class="dashboard">
    <!-- sidebar -->
    <aside class="sidebar" id="sidebar">
      <div class="sidebar-header">
        <div class="sidebar-title">Burial Plot Management</div>
        <div class="sidebar-date" id="sidebarDate">—</div>
      </div>
      <nav>
                <ul class="sidebar-nav">
                    <li class="nav-item">
                        <a href="admin_dashboard.php" class="nav-link active">
                            <span class="nav-icon">📊</span>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="burial_plot_management.php" class="nav-link">
                            <span class="nav-icon">⚰️</span>
                            Burial Plot Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="manage_records.php" class="nav-link">
                            <span class="nav-icon">👥</span>
                            Manage Customer Records
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="admin_transaction_management.php" class="nav-link">
                            <span class="nav-icon">💳</span>
                            Transaction Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="notification_management.php" class="nav-link">
                            <span class="nav-icon">🔔</span>
                            Notification Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="report_analytics.php" class="nav-link">
                            <span class="nav-icon">📈</span>
                            Report & Analytics
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

    <!-- main -->
    <main class="main">
      <!-- tabs -->
      <div class="tabs" id="tabs">
        <button class="tab-btn active" data-tab="plots">Plots</button>
        <button class="tab-btn" data-tab="map">Map</button>
        <button class="tab-btn" data-tab="burials">Burials</button>
      </div>

      <!-- PLOTS -->
      <section id="plots" class="section active">
        <h2 class="page-title">All plots</h2>
        <p class="section-description">Manage burial plots and track plot occupancy.</p>

        <div class="controls">
          <div class="controls-left">
            <button class="btn" id="btnFilter">🔽 Filter</button>
            <button class="btn" id="btnSort">Sort by ▼</button>
            <input class="search-small" id="searchPlots" placeholder="Search plot / owner / burial"/>
          </div>
          <button class="btn-primary" id="btnAddPlot">➕ Add plot</button>
        </div>

        <table>
          <thead>
            <tr><th>PLOT</th><th>STATUS</th><th>OWNER</th><th>BURIAL</th></tr>
          </thead>
          <tbody id="plotsBody">
            <tr>
              <td><span class="link" data-plot="A/177/1" data-status="Occupied" data-owner="Maria Clara Escobar" data-burial="Juanito Escobar">A/177/1</span></td>
              <td>Occupied</td>
              <td><span class="link" data-plot="A/177/1" data-status="Occupied" data-owner="Maria Clara Escobar" data-burial="Juanito Escobar">Maria Clara Escobar</span></td>
              <td><span class="link" data-plot="A/177/1" data-status="Occupied" data-owner="Maria Clara Escobar" data-burial="Juanito Escobar">Juanito Escobar</span></td>
            </tr>
            <tr>
              <td><span class="link" data-plot="A/178/1" data-status="Available" data-owner="-" data-burial="-">A/178/1</span></td>
              <td>Available</td><td>-</td><td>-</td>
            </tr>
            <tr>
              <td><span class="link" data-plot="B/101/2" data-status="Reserved" data-owner="Juan Dela Cruz" data-burial="-">B/101/2</span></td>
              <td>Reserved</td>
              <td><span class="link" data-plot="B/101/2" data-status="Reserved" data-owner="Juan Dela Cruz" data-burial="-">Juan Dela Cruz</span></td>
              <td>-</td>
            </tr>
            <tr>
              <td><span class="link" data-plot="B/101/1" data-status="Available" data-owner="-" data-burial="-">B/101/1</span></td>
              <td>Available</td><td>-</td><td>-</td>
            </tr>
            <tr>
              <td><span class="link" data-plot="C/150/1" data-status="Occupied" data-owner="Pedro Santos" data-burial="Pedro Santos">C/150/1</span></td>
              <td>Occupied</td>
              <td><span class="link" data-plot="C/150/1" data-status="Occupied" data-owner="Pedro Santos" data-burial="Pedro Santos">Pedro Santos</span></td>
              <td><span class="link" data-plot="C/150/1" data-status="Occupied" data-owner="Pedro Santos" data-burial="Pedro Santos">Pedro Santos</span></td>
            </tr>
            <tr>
              <td><span class="link" data-plot="C/150/2" data-status="Available" data-owner="-" data-burial="-">C/150/2</span></td>
              <td>Available</td><td>-</td><td>-</td>
            </tr>
            <tr>
              <td><span class="link" data-plot="A/200/1" data-status="Occupied" data-owner="Ana Reyes" data-burial="Ana Reyes">A/200/1</span></td>
              <td>Occupied</td>
              <td><span class="link" data-plot="A/200/1" data-status="Occupied" data-owner="Ana Reyes" data-burial="Ana Reyes">Ana Reyes</span></td>
              <td><span class="link" data-plot="A/200/1" data-status="Occupied" data-owner="Ana Reyes" data-burial="Ana Reyes">Ana Reyes</span></td>
            </tr>
          </tbody>
        </table>
      </section>

      <!-- MAP -->
      <section id="map" class="section">
        <div class="map-wrap">
          <div class="map-view">
            <div class="plot-grid" id="plotGrid"></div>
          </div>
          <aside class="map-side">
            <div style="margin-bottom:12px;font-weight:700;color:var(--ink-2)">
              <span class="status-dot status-occupied"></span>Section A / Lot 177 / Grave 1
            </div>
            <div id="mapStatus" style="margin-bottom:14px">Occupied</div>
            <div class="card">
              <div class="label">Owner</div>
              <div id="mapOwner" style="margin-bottom:6px">Maria Clara Escobar</div>
              <a href="#" class="link" id="mapAddOwner">+ Add</a>
            </div>
            <div class="card" style="margin-top:12px">
              <div class="label">Burials</div>
              <div id="mapBurial">Juanito Escobar</div>
              <div id="mapBurialId">A001</div>
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
      <section id="burials" class="section">
        <div class="card" style="margin-bottom:14px;display:flex;justify-content:space-between;align-items:center">
          <div style="display:flex;align-items:center;gap:10px">
            <span>🧑‍💼</span>
            <div>
              <div class="label" style="margin-bottom:0">Juanito Escobar</div>
              <div style="font-size:12px;color:var(--muted)">Burial</div>
            </div>
          </div>
          <button class="btn-primary" id="btnViewOnMap">View on map</button>
        </div>

        <div class="grid grid-2">
          <div class="card">
            <div class="label">Plot</div>
            <div style="display:flex;gap:10px;align-items:center">
              <input class="input" value="A/177/2"/>
              <span class="badge occupied">Occupied</span>
            </div>
          </div>

          <div class="card">
            <div class="label">Burial Information</div>
            <div style="height:120px;display:grid;place-items:center;color:var(--muted)">—</div>
          </div>

          <div class="card">
            <div class="label">Unique Code</div>
            <input class="input" value="D001"/>
          </div>
        </div>
      </section>

      <!-- ADD PLOT (opens from button; not a tab) -->
      <section id="addPlot" class="section">
        <h2 class="page-title">Add New Plot</h2>

        <div class="card" style="margin-top:8px">
          <div class="label">Plot Identification</div>
          <div class="grid grid-2" style="margin-top:10px">
            <div>
              <div class="label">Deceased's name</div>
              <input class="input" placeholder="Enter deceased's name"/>
            </div>
            <div>
              <div class="label">Plot ID/Code</div>
              <input class="input" placeholder="Enter plot code"/>
            </div>
            <div>
              <div class="label">Block no.</div>
              <input class="input" placeholder="Enter block number"/>
            </div>
            <div>
              <div class="label">Section</div>
              <select class="select"><option>Section A</option><option>Section B</option><option>Section C</option></select>
            </div>
            <div>
              <div class="label">Lot</div>
              <select class="select"><option>Lot 1</option><option>Lot 2</option><option>Lot 3</option></select>
            </div>
          </div>
        </div>

        <div class="card" style="margin-top:14px">
          <div class="label">Status Availability</div>
          <div class="grid grid-2" style="margin-top:10px">
            <div>
              <div class="label">Reserve for</div>
              <input class="input" placeholder="Enter name"/>
            </div>
            <div>
              <div class="label">Plot Status</div>
              <select class="select"><option>Available</option><option>Occupied</option><option>Reserved</option></select>
            </div>
            <div>
              <div class="label">Reservation expiry date</div>
              <input type="date" class="input"/>
            </div>
          </div>
          <div class="actions">
            <button class="btn" id="btnCancelAdd">Cancel</button>
            <button class="btn-primary" id="btnSubmitAdd">Add plot</button>
          </div>
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
  <div class="modal" id="plotModal">
    <div class="modal-panel">
      <div class="modal-head">
        <div id="modalTitle">Plot Information</div>
        <button class="modal-close" id="modalClose">&times;</button>
      </div>
      <div class="modal-body">
        <div class="grid grid-2">
          <div class="card">
            <div class="label">Plot ID</div>
            <div id="mPlotId">A/177/1</div>
            <div class="label" style="margin-top:10px">Section</div>
            <input id="mSection" class="input" value="A" readonly>
            <div class="label" style="margin-top:10px">Lot Number</div>
            <input id="mLot" class="input" value="177" readonly>
            <div class="label" style="margin-top:10px">Grave Number</div>
            <input id="mGrave" class="input" value="1" readonly>
            <div class="label" style="margin-top:10px">Status</div>
            <select id="mStatus" class="select" disabled>
              <option>Available</option><option>Occupied</option><option>Reserved</option>
            </select>
          </div>

          <div class="card">
            <div class="label">Owner Name</div>
            <input id="mOwner" class="input" value="Maria Clara Escobar" readonly>
            <div class="label" style="margin-top:10px">Contact Number</div>
            <input id="mContact" class="input" value="+63 912 345 6789" readonly>
            <div class="label" style="margin-top:10px">Email</div>
            <input id="mEmail" class="input" value="maria.escobar@email.com" readonly>
            <div class="label" style="margin-top:10px">Address</div>
            <input id="mAddress" class="input" value="123 Main St, Cebu City" readonly>
            <div class="label" style="margin-top:10px">Purchase Date</div>
            <input id="mPurchase" type="date" class="input" value="2023-05-15" readonly>
          </div>

          <div class="card">
            <div class="label">Deceased Name</div>
            <input id="mDeceased" class="input" value="Juanito Escobar" readonly>
            <div class="grid grid-2" style="margin-top:10px">
              <div>
                <div class="label">Date of Birth</div>
                <input id="mBirth" type="date" class="input" value="1945-03-20" readonly>
              </div>
              <div>
                <div class="label">Date of Death</div>
                <input id="mDeath" type="date" class="input" value="2023-04-10" readonly>
              </div>
              <div>
                <div class="label">Burial Date</div>
                <input id="mBurialDate" type="date" class="input" value="2023-04-15" readonly>
              </div>
              <div>
                <div class="label">Burial ID</div>
                <input id="mBurialId" class="input" value="A001" readonly>
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
                <input id="mAmount" type="number" class="input" value="50000" readonly>
              </div>
              <div>
                <div class="label">Next Payment Due</div>
                <input id="mNextPay" type="date" class="input" value="2024-05-15" readonly>
              </div>
            </div>
            <div class="label" style="margin-top:10px">Payment Plan</div>
            <select id="mPlan" class="select" disabled>
              <option>Full Payment</option><option>Monthly</option><option>Quarterly</option><option>Annually</option>
            </select>
          </div>

          <div class="card" style="grid-column:1/-1">
            <div class="label">Notes & Additional Information</div>
            <textarea id="mNotes" class="textarea" readonly>Plot purchased for family use. Regular maintenance required. Family prefers fresh flowers weekly.</textarea>
          </div>
        </div>
      </div>
    </div>
  </div>

<script>
  // helpers
  const $ = s => document.querySelector(s);
  const $$ = s => document.querySelectorAll(s);

  // sidebar toggle (mobile)
  $('#hamburger').addEventListener('click', ()=> $('#sidebar').classList.toggle('show'));

  // date on sidebar
  (function setDate(){
    const now=new Date();
    $('#sidebarDate').textContent = now.toLocaleDateString('en-US',{weekday:'long',year:'numeric',month:'long',day:'numeric'});
  })();

  // tab switching
  function showSection(id){
    $$('.section').forEach(s=>s.classList.remove('active'));
    if(id) $('#'+id).classList.add('active');
  }
  function activateTab(id){
    $$('.tab-btn').forEach(b=>b.classList.toggle('active', b.dataset.tab===id));
  }
  $$('.tab-btn').forEach(btn=>{
    btn.addEventListener('click', ()=>{
      const tab = btn.dataset.tab;
      activateTab(tab);
      showSection(tab);
      if(tab==='map') ensurePlotsBuilt();
      window.scrollTo({top:0,behavior:'smooth'});
    });
  });

  // Add Plot flow (not a tab)
  $('#btnAddPlot').addEventListener('click', ()=>{
    activateTab(''); // no active tab
    showSection('addPlot');
    window.scrollTo({top:0,behavior:'smooth'});
  });
  $('#btnCancelAdd').addEventListener('click', ()=>{ activateTab('plots'); showSection('plots'); });
  $('#btnSubmitAdd').addEventListener('click', ()=>{
    alert('Plot added successfully!');
    activateTab('plots'); showSection('plots');
  });

  // BURIALS: view on map
  $('#btnViewOnMap').addEventListener('click', ()=>{
    activateTab('map'); showSection('map'); ensurePlotsBuilt();
    // optionally highlight a sample plot
    const first = $('#plotGrid .plot'); if(first){ first.click(); }
  });

  // plots search
  $('#searchPlots').addEventListener('input', (e)=>{
    const q = e.target.value.toLowerCase();
    $$('#plotsBody tr').forEach(row=>{
      const t = row.textContent.toLowerCase();
      row.style.display = t.includes(q)? '' : 'none';
    });
  });

  // filter & sort (simple)
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
    [...body.querySelectorAll('tr')].sort((a,b)=>{
      return a.children[idx].textContent.trim().localeCompare(b.children[idx].textContent.trim());
    }).forEach(tr=>body.appendChild(tr));
  });

  // modal open from table links
  function openModalWith(plotId,status,owner,burial){
    $('#modalTitle').textContent = 'Plot Information - '+plotId;
    $('#mPlotId').textContent = plotId;
    const [sec, lot, grave] = (plotId||'A/177/1').split('/');
    $('#mSection').value = sec||'A'; $('#mLot').value = lot||'177'; $('#mGrave').value = grave||'1';
    $('#mStatus').value = status || 'Available';
    $('#mOwner').value = owner==='-'?'':owner;
    $('#mDeceased').value = burial==='-'?'':burial;

    // tiny dataset (same as your previous)
    if(status==='Occupied' && plotId==='A/177/1'){
      $('#mContact').value = '+63 912 345 6789';
      $('#mEmail').value = 'maria.escobar@email.com';
      $('#mAddress').value='123 Main St, Cebu City';
      $('#mPurchase').value='2023-05-15';
      $('#mBirth').value='1945-03-20';
      $('#mDeath').value='2023-04-10';
      $('#mBurialDate').value='2023-04-15';
      $('#mBurialId').value='A001';
      $('#mPayStatus').value='Paid';
      $('#mAmount').value='50000';
      $('#mNextPay').value='2024-05-15';
      $('#mPlan').value='Full Payment';
      $('#mNotes').value='Plot purchased for family use. Regular maintenance required. Family prefers fresh flowers weekly.';
    } else if(status==='Reserved'){
      $('#mContact').value='+63 917 123 4567';
      $('#mEmail').value='juan.delacruz@email.com';
      $('#mAddress').value='456 Secondary St, Cebu City';
      $('#mPurchase').value='2024-01-10';
      $('#mBirth').value=''; $('#mDeath').value=''; $('#mBurialDate').value=''; $('#mBurialId').value='';
      $('#mPayStatus').value='Pending'; $('#mAmount').value='25000'; $('#mNextPay').value='2024-07-10'; $('#mPlan').value='Monthly';
      $('#mNotes').value='Reserved for future use. Payment plan in progress.';
    } else {
      ['mContact','mEmail','mAddress','mPurchase','mBirth','mDeath','mBurialDate','mBurialId','mAmount','mNextPay'].forEach(id=>$('#'+id).value='');
      $('#mPayStatus').value='Pending'; $('#mPlan').value='Full Payment'; $('#mNotes').value='Available plot ready for purchase.';
    }
    $('#plotModal').classList.add('active'); document.body.style.overflow='hidden';
  }
  $('#plotsBody').addEventListener('click', (e)=>{
    const link = e.target.closest('.link'); if(!link) return;
    const {plot,status,owner,burial} = link.dataset;
    openModalWith(plot,status,owner,burial);
  });
  $('#modalClose').addEventListener('click', ()=>{
    $('#plotModal').classList.remove('active'); document.body.style.overflow='';
  });
  $('#plotModal').addEventListener('click', (e)=>{ if(e.target===e.currentTarget){ $('#modalClose').click(); }});

  // MAP: generate sample plots once
  let built = false;
  function ensurePlotsBuilt(){
    if(built) return;
    const grid = $('#plotGrid');
    const statuses = ['available','occupied','reserved'];
    const sections = ['A','B','C'];
    for(let i=0;i<20;i++){
      const status = statuses[Math.floor(Math.random()*statuses.length)];
      const sec = sections[Math.floor(Math.random()*sections.length)];
      const lot = Math.floor(Math.random()*200)+100;
      const grave = Math.floor(Math.random()*5)+1;
      const el = document.createElement('div');
      el.className = `plot ${status}`;
      el.textContent = `${sec}/${lot}/${grave}`;
      el.addEventListener('click', ()=>{
        $$('#plotGrid .plot').forEach(p=>p.classList.remove('selected'));
        el.classList.add('selected');
        updateMapSide(sec,lot,grave,status);
      });
      grid.appendChild(el);
    }
    built = true;
  }
  function updateMapSide(sec,lot,grave,status){
    const stTxt = status.charAt(0).toUpperCase()+status.slice(1);
    $('.map-side .label').previousElementSibling?.remove; // no-op; keep layout simple
    document.querySelector('.map-side > div').innerHTML = `<span class="status-dot status-${status}"></span>Section ${sec} / Lot ${lot} / Grave ${grave}`;
    $('#mapStatus').textContent = stTxt;
    if(status==='occupied'){ $('#mapOwner').textContent='Maria Clara Escobar'; $('#mapBurial').textContent='Juanito Escobar'; $('#mapBurialId').textContent='A001'; }
    else if(status==='reserved'){ $('#mapOwner').textContent='Juan Dela Cruz'; $('#mapBurial').textContent='-'; $('#mapBurialId').textContent='-'; }
    else { $('#mapOwner').textContent='-'; $('#mapBurial').textContent='-'; $('#mapBurialId').textContent='-'; }
  }

  // initial
  ensurePlotsBuilt(); // build once in case Map is opened first by user
</script>
</body>
</html>
