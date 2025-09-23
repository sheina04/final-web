<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard - Rest Assured</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,500&display=swap" rel="stylesheet"/>

  <style>
    :root{
      --bg: #f1e8df;               /* app background similar to screenshot */
      --panel: #ffffff;
      --panel-soft: #faf6f2;
      --ink: #3E2A1E;
      --ink-2: #6b5546;
      --ink-3: #9b887c;
      --brand-1: #8B6F4D;
      --brand-2: #664832;
      --line: rgba(139,111,77,0.18);
      --shadow: 0 2px 10px rgba(102,72,50,.08);
      --shadow-hi: 0 6px 22px rgba(102,72,50,.12);
      --radius-xl: 16px;
      --radius-lg: 12px;
      --radius-md: 10px;
      --radius-sm: 8px;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Montserrat', sans-serif;
      background: var(--bg);
      color: var(--ink);
      line-height: 1.6;
      min-height: 100vh;
    }

    /* ==== Generic image slot (blank until you add src) ==== */
    .img-slot{ display:inline-flex; align-items:center; justify-content:center; }
    .img-slot img{ width:100%; height:100%; object-fit:contain; display:block; }
    .slot-logo { width:62px; height:28px; }      /* RA mark in sidebar header */
    .slot-logo-footer{ width:70px; height:28px;} /* RA mark in footer */
    .slot-ico-18{ width:18px; height:18px; }
    .slot-ico-16{ width:16px; height:16px; }
    .slot-ico-20{ width:20px; height:20px; }
    .slot-ico-28{ width:28px; height:28px; }
    /* keeps layout even if empty */
    .img-slot img[src=""]{ opacity:0; }

    /* ==== Top header ==== */
    .top-header{
      position: fixed; inset: 0 0 auto 0; height: 72px;
      background: var(--panel-soft);
      display:flex; align-items:center; justify-content:space-between;
      padding: 0 24px;
      box-shadow: var(--shadow);
      z-index: 1000;
    }
    .mobile-menu-toggle{ display:none; background:none; border:0; font-size:22px; color:var(--brand-2); cursor:pointer; }

    /* Search pill centered like screenshot */
    .search-wrap{
      flex: 1 1 auto;
      display:flex; justify-content:center;
    }
    .search{
      position:relative; width:min(880px, 86vw);
    }
    .search input{
      width:100%;
      padding: 12px 16px 12px 44px;
      border: 1.5px solid var(--line);
      background:#fff;
      border-radius: 999px;
      font-size:14px; color:var(--ink-2);
      outline: none;
      transition: .2s border-color, .2s box-shadow;
    }
    .search input::placeholder{ color:#9b8d82; }
    .search input:focus{ border-color: var(--brand-2); box-shadow: 0 0 0 3px rgba(102,72,50,.08); }
    .search .left-ico{
      position:absolute; left:14px; top:50%; transform: translateY(-50%);
      width:18px; height:18px; display:flex; align-items:center; justify-content:center;
      opacity:.7;
    }

    .header-right{ display:flex; align-items:center; gap:18px; }
    .notif{
      width:36px; height:36px; display:inline-flex; align-items:center; justify-content:center;
      border-radius:50%;
      background:#5a4333; /* matches screenshot bell bg */
      color:#fff; box-shadow: var(--shadow);
    }
    .notif .img-slot{ width:18px; height:18px; }
    .user-profile{
      display:flex; align-items:center; gap:10px;
      background:#5a4333;
      color:#fff; padding:8px 14px; border-radius:999px; cursor:pointer;
      box-shadow: var(--shadow);
      position:relative;
    }
    .avatar{
      width:30px; height:30px; border-radius:50%;
      background: #ffffff22; display:flex; align-items:center; justify-content:center;
      font-weight:700;
    }
    .dropdown-menu{
      position:absolute; right:0; top:calc(100% + 8px);
      background:#fff; border:1px solid var(--line); border-radius:10px;
      box-shadow: var(--shadow-hi); padding:6px 0; min-width:160px; display:none; z-index:1001;
    }
    .dropdown-menu.active{ display:block; }
    .dropdown-item{ padding:10px 14px; color:var(--ink-2); text-decoration:none; display:block; font-size:14px; }
    .dropdown-item:hover{ background:#f3ece6; }

    /* ==== Layout ==== */
    .dashboard{ display:flex; min-height:100vh; }
    .sidebar{
      width: 280px; background: #efe6dd;
      position: fixed; inset: 72px auto 0 0; /* under header */
      box-shadow: inset -1px 0 0 var(--line);
      padding: 18px 18px 22px;
      overflow-y:auto;
    }
    .main{
      flex:1; margin-left:280px; padding: 96px 26px 26px;
    }

    /* Sidebar header (RA + date) */
    .brand{ display:flex; align-items:center; gap:12px; margin: 4px 8px 14px; }
    .brand-name{ font-family:'Cormorant Garamond', serif; font-weight:700; font-size:28px; letter-spacing:.5px; color:#5a4333; }
    .side-head{ margin: 8px 8px 14px; }
    .side-title{ font-weight:700; font-size:14px; color:#584536; }
    .side-date{ font-size:12px; color:#8e7c70; margin-top:2px; }

    /* Sidebar nav like screenshot */
    .side-nav{ list-style:none; margin-top: 6px; }
    .side-nav li{ margin: 6px 0; }
    .nav-link{
      display:flex; align-items:center; gap:12px;
      padding: 12px 16px;
      color:#5e4a3b; text-decoration:none; font-weight:600; font-size:14px;
      border-radius: 14px;
    }
    .nav-icon{ width:22px; display:inline-flex; align-items:center; justify-content:center; }
    .nav-link:hover{ background:#efe1d6; }
    .nav-link.active{
      background:#fff; box-shadow: var(--shadow);
      border:1px solid var(--line);
      color:#2f241c;
    }

    /* Sections */
    .section-title{ font-size:14px; font-weight:700; color:#5b4537; margin-bottom:10px; }

    /* Payment statistics – compact chips */
    .chips{ display:grid; grid-template-columns: repeat(3, minmax(220px, 1fr)); gap:12px; }
    .chip{
      background:#fff; border:1px solid var(--line); border-radius: 10px;
      box-shadow: var(--shadow); padding:10px 12px;
    }
    .chip-top{ display:flex; align-items:center; gap:8px; }
    .coin{ width:26px; height:26px; border-radius:50%; background:#f0e7de; display:inline-flex; align-items:center; justify-content:center; }
    .coin .img-slot{ width:18px; height:18px; }
    .chip-main{ font-weight:800; font-size:14px; margin-top:6px; color:#3d2c20; }
    .chip-sub{ font-size:11px; color:#99887d; margin-top:2px; }

    /* 2-col grid like screenshot */
    .grid{
      display:grid; grid-template-columns: 2fr 1fr; gap: 16px; margin-top:14px;
    }

    /* Activities panel */
    .panel{
      background:#fff; border:1px solid var(--line); border-radius: var(--radius-lg);
      box-shadow: var(--shadow); padding:12px;
    }
    .activities-box{ height:240px; border-radius: 10px; background:#f7f2ee; border:1px dashed var(--line); }

    /* Right column stats ("Total number of graves") */
    .right-group .row{
      display:flex; align-items:center; gap:10px;
      background:#fff; border:1px solid var(--line); border-radius:10px;
      padding:10px 12px; box-shadow: var(--shadow);
      margin-bottom:10px;
    }
    .bubble{
      width:40px; height:40px; border-radius:50%;
      background:#fff; border:1px solid var(--line);
      display:flex; align-items:center; justify-content:center;
      font-weight:700; color:#5a4333;
    }
    .row .text-main{ font-size:13px; color:#6a584b; }
    .row small{ display:block; font-size:11px; color:#9a8b7f; }

    /* Calendar + Activity log right column */
    .calendar-card{ background:#fff; border:1px solid var(--line); border-radius:10px; box-shadow:var(--shadow); padding:12px; }
    .calendar-box{ height:270px; background:#f7f2ee; border:1px dashed var(--line); border-radius:10px; }

    /* Notifications row */
    .notifs-grid{ display:grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-top: 12px; }
    .notif-card{ background:#fff; border:1px solid var(--line); border-radius:10px; box-shadow: var(--shadow); height:120px; }

    /* Footer */
    .footer{
      background: var(--panel-soft);
      margin-left:280px; padding:16px 26px; border-top:1px solid var(--line);
    }
    .footer-wrap{
      display:grid; grid-template-columns: auto 1fr auto auto; gap:24px; align-items:center;
    }
    .footer-logo .img-slot{ display:inline-block; }

    /* Responsive */
    @media (max-width: 1100px){
      .grid{ grid-template-columns: 1fr; }
      .notifs-grid{ grid-template-columns: 1fr; }
      .main{ padding: 96px 18px 24px; }
    }
    @media (max-width: 820px){
      .mobile-menu-toggle{ display:block; }
      .sidebar{ transform: translateX(-100%); transition: transform .25s; }
      .sidebar.active{ transform: translateX(0); }
      .main{ margin-left:0; }
      .footer{ margin-left:0; }
      .search{ width: 100%; }
    }
  </style>
</head>
<body>
  <!-- ====== Top Header ====== -->
  <header class="top-header">
    <button class="mobile-menu-toggle" onclick="toggleSidebar()">☰</button>

    <div class="search-wrap">
      <div class="search">
        <span class="left-ico">
          <span class="img-slot slot-ico-18">
            <img src="" alt="Search icon"/>
          </span>
        </span>
        <input type="text" placeholder="Search"/>
      </div>
    </div>

    <div class="header-right">
      <div class="notif" title="Notifications">
        <span class="img-slot slot-ico-18">
          <img src="" alt="Bell"/>
        </span>
      </div>
      <div class="user-profile" onclick="toggleDropdown()">
        <div class="avatar">A</div>
        <div class="name">Admin</div>
        <div class="caret">▾</div>

        <div class="dropdown-menu" id="userDropdown">
          <a href="#" class="dropdown-item">Profile</a>
          <a href="#" class="dropdown-item">Settings</a>
          <a href="#" class="dropdown-item">Logout</a>
        </div>
      </div>
    </div>
  </header>

  <div class="dashboard">
    <!-- ====== Sidebar ====== -->
    <aside class="sidebar" id="sidebar">
      <div class="brand">
        <div class="img-slot slot-logo">
          <!-- RA logo (small) -->
          <img src="" alt="RA logo"/>
        </div>
        <div class="brand-name">RA</div>
      </div>

      <div class="side-head">
        <div class="side-title">Dashboard</div>
        <div class="side-date" id="sideDate">Thursday, 2 May 2025</div>
      </div>

      <ul class="side-nav">
        <li>
          <a href="admin_dashboard.php" class="nav-link active">
            <span class="nav-icon">
              <!-- SIDEBAR ICON SLOT -->
              <span class="img-slot slot-ico-18"><img src="" alt="Dashboard"/></span>
            </span>
            Dashboard
          </a>
        </li>
        <li>
          <a href="burial_plot_management.php" class="nav-link">
            <span class="nav-icon">
              <span class="img-slot slot-ico-18"><img src="" alt="Burial Plot Management"/></span>
            </span>
            Burial Plot Management
          </a>
        </li>
        <li>
          <a href="manage_record.php" class="nav-link">
            <span class="nav-icon">
              <span class="img-slot slot-ico-18"><img src="" alt="Manage Customer Records"/></span>
            </span>
            Manage Customer Records
          </a>
        </li>
        <li>
          <a href="admin_transaction_management.php" class="nav-link">
            <span class="nav-icon">
              <span class="img-slot slot-ico-18"><img src="" alt="Transaction Management"/></span>
            </span>
            Transaction Management
          </a>
        </li>
        <li>
          <a href="notification_management.php" class="nav-link">
            <span class="nav-icon">
              <span class="img-slot slot-ico-18"><img src="" alt="Notification Management"/></span>
            </span>
            Notification Management
          </a>
        </li>
        <li>
          <a href="report_analytics.php" class="nav-link">
            <span class="nav-icon">
              <span class="img-slot slot-ico-18"><img src="" alt="Report &amp; Analytics"/></span>
            </span>
            Report &amp; Analytics
          </a>
        </li>
      </ul>
    </aside>

    <!-- ====== Main ====== -->
    <main class="main">
      <!-- Payment Statistics -->
      <section>
        <h3 class="section-title">Payment Statistics</h3>
        <div class="chips">
          <div class="chip">
            <div class="chip-top">
              <span class="coin">
                <span class="img-slot slot-ico-16"><img src="" alt=""/></span>
              </span>
              <small class="chip-sub">Payments Collected This Month</small>
            </div>
            <div class="chip-main">₱50,000 collected</div>
          </div>

          <div class="chip">
            <div class="chip-top">
              <span class="coin">
                <span class="img-slot slot-ico-16"><img src="" alt=""/></span>
              </span>
              <small class="chip-sub">Pending Payments</small>
            </div>
            <div class="chip-main">₱10,000 pending from 3 clients</div>
          </div>

          <div class="chip">
            <div class="chip-top">
              <span class="coin">
                <span class="img-slot slot-ico-16"><img src="" alt=""/></span>
              </span>
              <small class="chip-sub">Pending Payments</small>
            </div>
            <div class="chip-main">2 payments overdue (₱9,000 total)</div>
          </div>
        </div>
      </section>

      <div class="grid">
        <!-- Left column -->
        <div>
          <section style="margin-top:14px;">
            <h3 class="section-title">Activities</h3>
            <div class="panel">
              <div class="activities-box"></div>
            </div>
          </section>

          <section style="margin-top:14px;">
            <h3 class="section-title">Notifications</h3>
            <div class="notifs-grid">
              <div class="notif-card"></div>
              <div class="notif-card"></div>
              <div class="notif-card"></div>
            </div>
          </section>
        </div>

        <!-- Right column -->
        <div class="right-group">
          <section>
            <h3 class="section-title">Total number of graves</h3>

            <div class="row">
              <div class="bubble">245</div>
              <div class="text">
                <div class="text-main">graves available out of <b>1,000</b> total.</div>
              </div>
            </div>

            <div class="row">
              <div class="bubble">730</div>
              <div class="text">
                <div class="text-main">graves occupied.</div>
              </div>
            </div>

            <div class="row">
              <div class="bubble">730</div>
              <div class="text">
                <div class="text-main">graves pending <b>renewal</b>.</div>
              </div>
            </div>

            <div class="row">
              <div class="bubble">730</div>
              <div class="text">
                <div class="text-main">graves expiring <small>within the next 30 days.</small></div>
              </div>
            </div>
          </section>

          <section style="margin-top:14px;">
            <h3 class="section-title">Calendar</h3>
            <div class="calendar-card">
              <div class="calendar-box"></div>
            </div>
          </section>

          <section style="margin-top:14px;">
            <h3 class="section-title">Activity Log</h3>
            <div class="panel" style="height:90px;"></div>
            <div class="panel" style="height:90px; margin-top:10px;"></div>
            <div class="panel" style="height:90px; margin-top:10px;"></div>
          </section>
        </div>
      </div>
    </main>
  </div>

  <!-- ====== Footer ====== -->
  <footer class="footer">
    <div class="footer-wrap">
      <div class="footer-logo">
        <span class="img-slot slot-logo-footer"><img src="" alt="RA"/></span>
      </div>
      <div class="footer-info">For assistance: <a href="mailto:r.assured@gmail.com">r.assured@gmail.com</a></div>
      <div class="footer-info">09193210292</div>
      <div class="footer-info">© 2024 Rest Assured. All Rights Reserved.</div>
    </div>
  </footer>

  <!-- ====== Scripts ====== -->
  <script>
    function toggleSidebar(){
      document.getElementById('sidebar').classList.toggle('active');
    }
    function toggleDropdown(){
      document.getElementById('userDropdown').classList.toggle('active');
    }
    document.addEventListener('click', (e)=>{
      const profile = document.querySelector('.user-profile');
      const drop = document.getElementById('userDropdown');
      if (drop && !profile.contains(e.target)) drop.classList.remove('active');
    });

    // Set sidebar date like screenshot (you can hardcode if you prefer)
    (function setDate(){
      const el = document.getElementById('sideDate');
      if(!el) return;
      const d = new Date();
      const opt = { weekday:'long', day:'numeric', month:'long', year:'numeric' };
      el.textContent = d.toLocaleDateString(undefined, opt);
    })();

    // Highlight active nav by URL
    (function markActive(){
      const here = location.pathname.split('/').pop();
      document.querySelectorAll('.side-nav .nav-link').forEach(a=>{
        const href = a.getAttribute('href');
        if(href && href === here){ a.classList.add('active'); }
      });
    })();
  </script>
</body>
</html>
