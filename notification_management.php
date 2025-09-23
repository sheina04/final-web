<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Notification Management - Rest Assured Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: rgb(255, 242, 225);
            color: #3E2A1E;
            line-height: 1.6;
            min-height: 100vh;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* Header */
        .top-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 70px;
            background-color: rgb(255, 242, 225);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(102, 72, 50, 0.1);
        }

        .logo {
            font-family: 'Cormorant Garamond', serif;
            font-size: 28px;
            font-weight: 600;
            color: #664832;
            text-decoration: none;
        }

        .logo::before {
            content: "RA";
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .search-container {
            position: relative;
        }

        .search-box {
            width: 400px;
            padding: 12px 45px 12px 20px;
            border: 2px solid rgba(102, 72, 50, 0.2);
            border-radius: 25px;
            background-color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            color: #664832;
            transition: all 0.3s ease;
        }

        .search-box::placeholder {
            color: rgba(102, 72, 50, 0.6);
        }

        .search-box:focus {
            outline: none;
            border-color: #664832;
            background-color: rgba(255, 255, 255, 0.9);
        }

        .search-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(102, 72, 50, 0.6);
            font-size: 16px;
            pointer-events: none;
        }

        .notification-btn {
            position: relative;
            background: none;
            border: none;
            color: #664832;
            font-size: 20px;
            cursor: pointer;
            padding: 8px;
            border-radius: 50%;
            transition: background-color 0.3s ease;
        }

        .notification-btn:hover {
            background-color: rgba(102, 72, 50, 0.1);
        }

        .user-profile {
            position: relative;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 8px 15px;
            border-radius: 25px;
            background-color: #8B6F4D;
            color: white;
            transition: all 0.3s ease;
            z-index: 1001;
        }

        .user-profile:hover {
            background-color: #664832;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: linear-gradient(135deg, #8B6F4D, #664832);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }

        .user-name {
            font-weight: 600;
            font-size: 14px;
        }

        .dropdown-arrow {
            font-size: 12px;
            margin-left: 5px;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(102, 72, 50, 0.2);
            padding: 10px 0;
            min-width: 150px;
            z-index: 1002;
            display: none;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .dropdown-menu.active {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .dropdown-item {
            padding: 12px 20px;
            color: #664832;
            text-decoration: none;
            display: block;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .dropdown-item:hover {
            background-color: rgba(139, 111, 77, 0.1);
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background-color: rgba(255, 255, 255, 0.4);
            padding: 90px 0 30px 0;
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            transition: transform 0.3s ease;
            z-index: 999;
        }

        .sidebar-header {
            padding: 0 30px 30px 30px;
        }

        .sidebar-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 24px;
            font-weight: 600;
            color: #664832;
            margin-bottom: 5px;
        }

        .sidebar-date {
            font-size: 12px;
            color: rgba(102, 72, 50, 0.7);
        }

        .sidebar-nav {
            list-style: none;
            padding: 0;
        }

        .nav-item {
            margin-bottom: 5px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 30px;
            color: #664832;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.3s ease;
            border-radius: 0 25px 25px 0;
            margin-right: 30px;
            cursor: pointer;
        }

        .nav-link:hover,
        .nav-link.active {
            background-color: rgba(139, 111, 77, 0.2);
            color: #3E2A1E;
            font-weight: 600;
        }

        .nav-link.active {
            background-color: rgba(139, 111, 77, 0.3);
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            font-size: 16px;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 90px 30px 30px 30px;
            transition: margin-left 0.3s ease;
        }

        .page-header {
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 32px;
            font-weight: 600;
            color: #664832;
            margin-bottom: 10px;
        }

        .page-subtitle {
            font-size: 16px;
            color: rgba(102, 72, 50, 0.7);
        }

        .compose-btn {
            background: linear-gradient(135deg, #8B6F4D, #664832);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .compose-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 72, 50, 0.3);
        }

        /* Statistics Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px 20px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(102, 72, 50, 0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 48px;
            font-weight: 700;
            color: #8B6F4D;
            margin-bottom: 10px;
            font-family: 'Montserrat', sans-serif;
        }

        .stat-label {
            font-size: 14px;
            color: rgba(102, 72, 50, 0.7);
            font-weight: 500;
        }

        /* Notifications Section */
        .notifications-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(102, 72, 50, 0.1);
            margin-bottom: 30px;
        }

        .section-header {
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 24px;
            font-weight: 600;
            color: #664832;
            margin-bottom: 15px;
        }

        /* Tab Navigation */
        .tab-nav {
            display: flex;
            gap: 0;
            margin-bottom: 25px;
            border-bottom: 2px solid rgba(102, 72, 50, 0.1);
        }

        .tab-btn {
            padding: 12px 25px;
            background: none;
            border: none;
            color: rgba(102, 72, 50, 0.6);
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border-bottom: 2px solid transparent;
            position: relative;
        }

        .tab-btn.active {
            color: #8B6F4D;
            border-bottom-color: #8B6F4D;
            font-weight: 600;
        }

        .tab-btn:hover {
            color: #8B6F4D;
        }

        /* Notifications Table */
        .table-container {
            overflow-x: auto;
            border-radius: 10px;
            border: 1px solid rgba(102, 72, 50, 0.1);
            margin-bottom: 30px;
        }

        .notifications-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            min-width: 800px;
        }

        .notifications-table th {
            background-color: rgba(139, 111, 77, 0.1);
            color: #664832;
            font-weight: 600;
            padding: 15px 12px;
            text-align: left;
            font-size: 14px;
            border-bottom: 2px solid rgba(102, 72, 50, 0.1);
        }

        .notifications-table td {
            padding: 15px 12px;
            border-bottom: 1px solid rgba(102, 72, 50, 0.1);
            color: #3E2A1E;
            font-size: 14px;
            vertical-align: middle;
        }

        .notifications-table tr:hover {
            background-color: rgba(139, 111, 77, 0.05);
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
            text-transform: capitalize;
        }

        .status-sent {
            background-color: rgba(34, 197, 94, 0.1);
            color: #059669;
        }

        .status-pending {
            background-color: rgba(251, 191, 36, 0.1);
            color: #d97706;
        }

        .status-urgent {
            background-color: rgba(239, 68, 68, 0.1);
            color: #dc2626;
        }

        .status-overdue {
            background-color: rgba(239, 68, 68, 0.15);
            color: #b91c1c;
        }

        .days-left {
            font-weight: 600;
        }

        .days-critical {
            color: #dc2626;
        }

        .days-warning {
            color: #d97706;
        }

        .days-normal {
            color: #059669;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            padding: 6px 8px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background-color: rgba(59, 130, 246, 0.1);
            color: #2563eb;
        }

        .btn-edit:hover {
            background-color: rgba(59, 130, 246, 0.2);
        }

        .btn-delete {
            background-color: rgba(239, 68, 68, 0.1);
            color: #dc2626;
        }

        .btn-delete:hover {
            background-color: rgba(239, 68, 68, 0.2);
        }

        .btn-send {
            background-color: rgba(34, 197, 94, 0.1);
            color: #059669;
        }

        .btn-send:hover {
            background-color: rgba(34, 197, 94, 0.2);
        }

        /* Footer */
        .footer {
            background-color: rgb(255, 242, 225);
            padding: 20px 30px;
            margin-left: 280px;
            transition: margin-left 0.3s ease;
        }

        .footer-content {
            display: grid;
            grid-template-columns: auto 1fr auto auto;
            gap: 30px;
            align-items: center;
        }

        .footer-logo {
            font-family: 'Cormorant Garamond', serif;
            font-size: 20px;
            font-weight: 600;
            color: #664832;
        }

        .footer-logo::before {
            content: "RA";
        }

        .footer-info {
            font-size: 14px;
            color: #664832;
        }

        .footer-info a {
            color: #664832;
            text-decoration: none;
        }

        .footer-info a:hover {
            text-decoration: underline;
        }

        .footer-copyright {
            font-size: 12px;
            color: #8B6F4D;
            text-align: right;
        }

        /* Mobile Styles */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            color: #664832;
            font-size: 20px;
            cursor: pointer;
            padding: 5px;
            z-index: 1001;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .search-box {
                width: 300px;
            }
        }

        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: block;
            }

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content,
            .footer {
                margin-left: 0;
            }

            .top-header {
                padding: 0 20px;
            }

            .search-container {
                display: none;
            }

            .header-right {
                gap: 15px;
            }

            .main-content {
                padding: 90px 20px 30px 20px;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .stat-number {
                font-size: 36px;
            }

            .notifications-section {
                padding: 20px;
            }

            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 15px;
            }

            .footer-copyright {
                text-align: center;
            }

            .tab-nav {
                flex-wrap: wrap;
            }

            .tab-btn {
                flex: 1;
                min-width: 120px;
            }
        }

        @media (max-width: 480px) {
            .top-header {
                padding: 0 15px;
            }

            .main-content {
                padding: 90px 15px 20px 15px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .notifications-section {
                padding: 15px;
            }

            .user-name {
                display: none;
            }
        }

        /* Overlay for mobile menu */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 998;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .overlay.active {
            display: block;
            opacity: 1;
        }
    </style>
</head>
<body>
  <!-- Top Header -->
  <header class="top-header">
    <button class="mobile-menu-toggle" id="mobileMenuToggle">☰</button>
    <a href="admin_dashboard.php" class="logo"></a>
    <div class="header-right">
      <div class="search-container">
        <input type="text" class="search-box" placeholder="Search notifications...">
        <span class="search-icon">🔍</span>
      </div>
      <button class="notification-btn">🔔</button>
      <div class="user-profile" id="userProfile">
        <div class="user-avatar">A</div>
        <span class="user-name">Admin</span>
        <span class="dropdown-arrow">▼</span>
        <div class="dropdown-menu" id="userDropdown">
          <a href="admin_profile.php" class="dropdown-item">Profile</a>
          <a href="logout.php" class="dropdown-item">Logout</a>
        </div>
      </div>
    </div>
  </header>

  <div class="dashboard-container">
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
      <div class="sidebar-header">
        <h2 class="sidebar-title">Notification Management</h2>
        <p class="sidebar-date">—</p>
      </div>
      <nav>
        <ul class="sidebar-nav">
          <li class="nav-item"><a href="admin_dashboard.php" class="nav-link"><span class="nav-icon">📊</span>Dashboard</a></li>
          <li class="nav-item"><a href="burial_plot_management.php" class="nav-link"><span class="nav-icon">⚰️</span>Burial Plot Management</a></li>
          <li class="nav-item"><a href="manage_record.php" class="nav-link"><span class="nav-icon">👥</span>Manage Customer Records</a></li>
          <li class="nav-item"><a href="admin_transaction_management.php" class="nav-link"><span class="nav-icon">💳</span>Transaction Management</a></li>
          <li class="nav-item"><a href="notification_management.php" class="nav-link active"><span class="nav-icon">🔔</span>Notification Management</a></li>
          <li class="nav-item"><a href="report_analytics.php" class="nav-link"><span class="nav-icon">📈</span>Report & Analytics</a></li>
        </ul>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <!-- Page Header -->
      <div class="page-header">
        <div>
          <h1 class="page-title">Notification Management</h1>
          <p class="page-subtitle">Manage and send notifications to customers</p>
        </div>
        <button class="compose-btn" id="composeBtn">✉️ Compose</button>
      </div>

      <!-- Statistics Cards (default 0; set data-target when you load stats) -->
      <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-number" data-target="0">0</div>
          <div class="stat-label">Total Notifications</div>
        </div>
        <div class="stat-card">
          <div class="stat-number" data-target="0">0</div>
          <div class="stat-label">Sent Today</div>
        </div>
        <div class="stat-card">
          <div class="stat-number" data-target="0">0</div>
          <div class="stat-label">Pending</div>
        </div>
        <div class="stat-card">
          <div class="stat-number" data-target="0">0</div>
          <div class="stat-label">Urgent</div>
        </div>
      </div>

      <!-- Notifications Section -->
      <section class="notifications-section">
        <div class="section-header">
          <h2 class="section-title">Notifications</h2>
          <div class="tab-nav">
            <button class="tab-btn active" data-tab="primary">Primary</button>
            <button class="tab-btn" data-tab="renewal">Renewal</button>
            <button class="tab-btn" data-tab="events">Events</button>
          </div>
        </div>

        <!-- Primary Tab -->
        <div class="tab-content" id="primary">
          <div class="table-container">
            <table class="notifications-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Notification Type</th>
                  <th>Recipient Name</th>
                  <th>Contact</th>
                  <th>Status</th>
                  <th>Sent Date</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="primaryBody">
                <tr><td colspan="7" style="text-align:center;color:#8B7A6E;padding:18px">No primary notifications yet.</td></tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Renewal Tab -->
        <div class="tab-content" id="renewal" style="display:none;">
          <div class="table-container">
            <table class="notifications-table">
              <thead>
                <tr>
                  <th>Customer Name</th>
                  <th>Grave Plot</th>
                  <th>Renewal Expiration</th>
                  <th>Days Left</th>
                  <th>Status</th>
                  <th>Sent</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="renewalBody">
                <tr><td colspan="7" style="text-align:center;color:#8B7A6E;padding:18px">No renewal notifications yet.</td></tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Events Tab -->
        <div class="tab-content" id="events" style="display:none;">
          <div class="table-container">
            <table class="notifications-table">
              <thead>
                <tr>
                  <th>Deceased Name</th>
                  <th>Occasion</th>
                  <th>Plot Number</th>
                  <th>Family Contact</th>
                  <th>Renewal Due</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="eventsBody">
                <tr><td colspan="7" style="text-align:center;color:#8B7A6E;padding:18px">No event notifications yet.</td></tr>
              </tbody>
            </table>
          </div>
        </div>

      </section>
    </main>
  </div>

  <!-- Footer -->
  <footer class="footer">
    <div class="footer-content">
      <div class="footer-logo"></div>
      <div class="footer-info">For assistance: <a href="mailto:r.assured@gmail.com">r.assured@gmail.com</a></div>
      <div class="footer-info">09193210292</div>
      <div class="footer-copyright">© 2024 Rest Assured. All Rights Reserved.</div>
    </div>
  </footer>

  <!-- Mobile Overlay -->
  <div class="overlay" id="overlay"></div>

<script>
// ====================== API endpoints ======================
const API = {
  primary: "api/api_notifications_primary.php",
  renewal: "api/api_notifications_renewal.php",
  events:  "api/api_notifications_events.php"
};

// ====================== DOM refs ======================
const mobileMenuToggle = document.getElementById('mobileMenuToggle');
const sidebar          = document.getElementById('sidebar');
const overlay          = document.getElementById('overlay');
const userProfile      = document.getElementById('userProfile');
const userDropdown     = document.getElementById('userDropdown');
const tabButtons       = document.querySelectorAll('.tab-btn');
const tabContents      = document.querySelectorAll('.tab-content');
const composeBtn       = document.getElementById('composeBtn');

// Stats number elements (make sure your numbers have these IDs)
const statTotal   = document.getElementById('statTotal');
const statToday   = document.getElementById('statToday');
const statPending = document.getElementById('statPending');
const statUrgent  = document.getElementById('statUrgent');

// ====================== Helpers ======================
function updateDate() {
  const now = new Date();
  const dateString = now.toLocaleDateString('en-PH',{
    weekday:'long',year:'numeric',month:'long',day:'numeric'
  });
  const dateEl = document.querySelector('.sidebar-date');
  if (dateEl) dateEl.textContent = dateString;
}

function toggleDropdown(){ userDropdown.classList.toggle('active'); }

function toggleSidebar(){
  sidebar.classList.toggle('active');
  overlay.classList.toggle('active');
  document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : 'auto';
}

function closeSidebar(){
  sidebar.classList.remove('active');
  overlay.classList.remove('active');
  document.body.style.overflow = 'auto';
}

function switchTab(tabId){
  tabContents.forEach(c=>c.style.display='none');
  tabButtons.forEach(b=>b.classList.remove('active'));
  const sel = document.getElementById(tabId);
  if(sel) sel.style.display = 'block';
  const btn = document.querySelector(`[data-tab="${tabId}"]`);
  if(btn) btn.classList.add('active');
}

// Empty table placeholder
function setEmptyState(tbodyId, cols, msg){
  const tb = document.getElementById(tbodyId);
  if(!tb) return;
  tb.innerHTML = `<tr><td colspan="${cols}" style="text-align:center;color:#8B7A6E;padding:18px">${msg}</td></tr>`;
}

// ====================== Formatters ======================
function statusClass(s){
  const k = (s||'').toLowerCase();
  if(k==='sent' || k==='paid') return 'status-sent';
  if(k==='urgent' || k==='overdue') return k==='urgent' ? 'status-urgent' : 'status-overdue';
  return 'status-pending';
}
function labelStatus(s){
  const t = (s||'Pending').toString();
  return t.charAt(0).toUpperCase()+t.slice(1);
}
function daysClass(d){
  if(typeof d==='string' && d.toLowerCase().includes('overdue')) return 'days-critical';
  const n = Number(d);
  if(isFinite(n) && n<=30) return 'days-warning';
  return 'days-normal';
}
function formatDays(d){
  if(d===null||d===undefined||d==='') return '-';
  if(typeof d==='string' && d.toLowerCase().includes('overdue')) return 'Overdue';
  const n = Number(d);
  return isFinite(n) ? `${n} days` : d;
}

// ====================== Renderers ======================
// PRIMARY rows: [{id,type,recipient,contact,status,sent_at}]
function renderPrimary(rows){
  const tb = document.getElementById('primaryBody');
  if(!tb) return;
  if(!rows || !rows.length){ setEmptyState('primaryBody',7,'No primary notifications yet.'); return; }
  tb.innerHTML = rows.map(r=>`
    <tr>
      <td>${r.id ?? ''}</td>
      <td>${r.type ?? ''}</td>
      <td>${r.recipient ?? ''}</td>
      <td>${r.contact ?? ''}</td>
      <td><span class="status-badge ${statusClass(r.status)}">${labelStatus(r.status)}</span></td>
      <td>${r.sent_at ?? '-'}</td>
      <td>
        <div class="action-buttons">
          <button class="action-btn btn-send"   data-id="${r.id}">📤</button>
          <button class="action-btn btn-edit"   data-id="${r.id}">✏️</button>
          <button class="action-btn btn-delete" data-id="${r.id}">🗑️</button>
        </div>
      </td>
    </tr>`).join('');
}

// RENEWAL rows: [{id,customer,plot,expiry,days_left,status,sent_at}]
function renderRenewal(rows){
  const tb = document.getElementById('renewalBody');
  if(!tb) return;
  if(!rows || !rows.length){ setEmptyState('renewalBody',7,'No renewal notifications yet.'); return; }
  tb.innerHTML = rows.map(r=>`
    <tr>
      <td>${r.customer ?? ''}</td>
      <td>${r.plot ?? ''}</td>
      <td>${r.expiry ?? ''}</td>
      <td><span class="days-left ${daysClass(r.days_left)}">${formatDays(r.days_left)}</span></td>
      <td><span class="status-badge ${statusClass(r.status)}">${labelStatus(r.status)}</span></td>
      <td>${r.sent_at ?? 'Not Sent'}</td>
      <td>
        <div class="action-buttons">
          <button class="action-btn btn-send" data-id="${r.id}">📤</button>
          <button class="action-btn btn-edit" data-id="${r.id}">✏️</button>
        </div>
      </td>
    </tr>`).join('');
}

// EVENTS rows: [{id,deceased,occasion,plot,contact_name,contact_phone,renewal_due,status}]
function renderEvents(rows){
  const tb = document.getElementById('eventsBody');
  if(!tb) return;
  if(!rows || !rows.length){ setEmptyState('eventsBody',7,'No event notifications yet.'); return; }
  tb.innerHTML = rows.map(r=>`
    <tr>
      <td>${r.deceased ?? ''}</td>
      <td>${r.occasion ?? ''}</td>
      <td>${r.plot ?? ''}</td>
      <td>${r.contact_name ?? ''}<br><small>${r.contact_phone ?? ''}</small></td>
      <td>${r.renewal_due ?? '-'}</td>
      <td><span class="status-badge ${statusClass(r.status)}">${labelStatus(r.status)}</span></td>
      <td>
        <div class="action-buttons">
          <button class="action-btn btn-send"   data-id="${r.id}">📤</button>
          <button class="action-btn btn-edit"   data-id="${r.id}">✏️</button>
          <button class="action-btn btn-delete" data-id="${r.id}">🗑️</button>
        </div>
      </td>
    </tr>`).join('');
}

// ====================== Loaders ======================
async function safeGet(url){
  try{
    const res = await fetch(url, {credentials:'include'});
    if(!res.ok) return [];
    const data = await res.json();
    return Array.isArray(data) ? data : [];
  }catch(e){
    console.warn('API error', url, e);
    return [];
  }
}

async function loadAll(){
  // placeholders
  setEmptyState('primaryBody',7,'Loading…');
  setEmptyState('renewalBody',7,'Loading…');
  setEmptyState('eventsBody',7,'Loading…');

  const [p, r, e] = await Promise.all([
    safeGet(API.primary),
    safeGet(API.renewal),
    safeGet(API.events)
  ]);

  renderPrimary(p);
  renderRenewal(r);
  renderEvents(e);

  // Stats
  const totalCount = (p?.length||0) + (r?.length||0) + (e?.length||0);
  const todayISO   = new Date().toISOString().slice(0,10);

  if(statTotal)   statTotal.textContent   = totalCount;
  if(statToday)   statToday.textContent   = p.filter(x=>x.sent_at && x.sent_at.startsWith(todayISO)).length;
  if(statPending) statPending.textContent = p.filter(x=>{
    const s=(x.status||'').toLowerCase(); return s==='queued'||s==='pending';
  }).length;
  if(statUrgent)  statUrgent.textContent  = r.filter(x=>Number(x.days_left)<=3).length;
}

// ====================== UI Events ======================
mobileMenuToggle?.addEventListener('click', toggleSidebar);
overlay?.addEventListener('click', closeSidebar);
userProfile?.addEventListener('click', toggleDropdown);

tabButtons.forEach(btn=>{
  btn.addEventListener('click', ()=>{
    switchTab(btn.getAttribute('data-tab'));
  });
});

// Close profile dropdown on outside click
document.addEventListener('click', (e)=>{
  if(userProfile && !userProfile.contains(e.target)){
    userDropdown?.classList.remove('active');
  }
});

// Search in active tab
const searchBox = document.querySelector('.search-box');
if(searchBox){
  searchBox.addEventListener('input', (e)=>{
    const term = e.target.value.toLowerCase();
    const activeTbody = document.querySelector('.tab-content:not([style*="display: none"]) .notifications-table tbody');
    if(!activeTbody) return;
    [...activeTbody.querySelectorAll('tr')].forEach(tr=>{
      const isPlaceholder = tr.children.length===1;
      if(isPlaceholder){ tr.style.display=''; return; }
      tr.style.display = tr.textContent.toLowerCase().includes(term) ? '' : 'none';
    });
  });
}

// Row action buttons (visual demo)
document.addEventListener('click',(e)=>{
  if(e.target.classList.contains('btn-send')){
    const id = e.target.dataset.id || '(no-id)';
    const badge = e.target.closest('tr')?.querySelector('.status-badge');
    if(badge){ badge.textContent='Sent'; badge.className='status-badge status-sent'; }
    alert(`Notification ${id} sent (demo).`);
  }
  if(e.target.classList.contains('btn-edit')){
    const id = e.target.dataset.id || '(no-id)';
    alert(`Edit notification ${id} — implement modal/form`);
  }
  if(e.target.classList.contains('btn-delete')){
    const row = e.target.closest('tr');
    if(confirm('Delete this notification?')) row?.remove();
  }
});

// Keyboard: ESC closes dropdown / sidebar (mobile)
document.addEventListener('keydown',(e)=>{
  if(e.key==='Escape'){
    userDropdown?.classList.remove('active');
    if(sidebar?.classList.contains('active') && window.innerWidth<=768){ closeSidebar(); }
  }
});

// ====================== Boot ======================
document.addEventListener('DOMContentLoaded', ()=>{
  updateDate();
  switchTab('primary'); // default tab
  loadAll();            // fetch & render
});
setInterval(updateDate, 60000);
</script>


</body>
</html>
