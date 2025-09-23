<?php
/* Manage Customer Records — FINAL (rest_assured)
   Uses tables: burials, plots, owners
   - Search via ?q=  (matches deceased_name, plot_code, owner name)
   - Detail via ?view=123  OR ?view=D20240520_001 (unique_code)
*/

const APP_DEBUG = false; // set true while debugging
if (APP_DEBUG) { ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL); }

$self = htmlspecialchars($_SERVER['PHP_SELF'] ?? 'manage_record.php', ENT_QUOTES, 'UTF-8');

/* ---- DB CONNECT (edit if your creds differ) ---- */
$DB_HOST='127.0.0.1';
$DB_PORT='3306';
$DB_NAME='rest_assured';
$DB_USER='root';
$DB_PASS='Janelle12345';
$DB_CHARSET='utf8mb4';

try {
  $pdo = new PDO(
    "mysql:host=$DB_HOST;port=$DB_PORT;dbname=$DB_NAME;charset=$DB_CHARSET",
    $DB_USER,$DB_PASS,
    [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]
  );
} catch (Throwable $e) {
  if (APP_DEBUG) die("DB error: ".$e->getMessage());
  $pdo = null;
}

/* ---- LIST DATA ---- */
$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$where = '';
$params = [];
if ($q !== '') {
  $where = "WHERE (b.deceased_name LIKE :kw OR p.plot_code LIKE :kw OR o.name LIKE :kw)";
  $params[':kw'] = "%$q%";
}

$records = [];
$detail = null;

if ($pdo) {
  $sql = "
    SELECT
      b.id,
      b.deceased_name,
      b.death_date,
      b.plot_code,
      o.contact   AS owner_contact,
      COALESCE(p.status,'pending') AS plot_status
    FROM burials b
    LEFT JOIN plots p   ON p.plot_code = b.plot_code
    LEFT JOIN owners o  ON o.id = p.owner_id
    $where
    ORDER BY b.id DESC
    LIMIT 300
  ";
  $stmt = $pdo->prepare($sql);
  $stmt->execute($params);
  $rows = $stmt->fetchAll();

  $records = array_map(function($r){
    return [
      'id'            => (int)$r['id'],
      'code'          => 'DEC-'.str_pad((string)$r['id'], 6, '0', STR_PAD_LEFT),
      'name'          => $r['deceased_name'] ?? '',
      'date_of_death' => $r['death_date'] ?? '',
      'plot_id'       => $r['plot_code'] ?? '',
      'contact'       => $r['owner_contact'] ?? '',
      'status'        => ucfirst($r['plot_status'] ?? 'Pending'),
    ];
  }, $rows);

  /* ---- DETAIL (?view=...) ---- */
  $view = isset($_GET['view']) ? trim($_GET['view']) : '';
  if ($view !== '') {
    // accept numeric id or unique_code
    $byId = ctype_digit($view) ? (int)$view : null;

    $q2 = "
      SELECT
        b.id,
        b.unique_code,
        b.deceased_name,
        b.birth_date,
        b.death_date,
        b.burial_date,
        b.plot_code,
        p.section, p.lot, p.grave, p.status AS plot_status,
        o.name AS owner_name, o.contact AS owner_contact, o.email AS owner_email, o.address AS owner_address
      FROM burials b
      LEFT JOIN plots p  ON p.plot_code = b.plot_code
      LEFT JOIN owners o ON o.id = p.owner_id
      WHERE ".($byId !== null ? "b.id = :val" : "b.unique_code = :val")."
      LIMIT 1
    ";
    $st = $pdo->prepare($q2);
    $st->execute([':val' => $byId !== null ? $byId : $view]);
    if ($r = $st->fetch()) {
      $detail = [
        'id'           => (int)$r['id'],
        'code'         => 'DEC-'.str_pad((string)$r['id'], 6, '0', STR_PAD_LEFT),
        'unique_code'  => $r['unique_code'] ?? '',
        'full_name'    => $r['deceased_name'] ?? '',
        'dob'          => $r['birth_date'] ?? '',
        'dod'          => $r['death_date'] ?? '',
        'burial_date'  => $r['burial_date'] ?? '',
        'plot_id'      => $r['plot_code'] ?? '',
        'section'      => $r['section'] ?? '',
        'lot'          => $r['lot'] ?? '',
        'grave'        => $r['grave'] ?? '',
        'plot_status'  => ucfirst($r['plot_status'] ?? 'Pending'),
        'owner_name'   => $r['owner_name'] ?? '',
        'owner_contact'=> $r['owner_contact'] ?? '',
        'owner_email'  => $r['owner_email'] ?? '',
        'owner_address'=> $r['owner_address'] ?? '',
      ];
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Manage Customer Records - Rest Assured</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
/* (same styles as before) */
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Montserrat',sans-serif;background:rgb(255,242,225);color:#3E2A1E;line-height:1.6;min-height:100vh}
.dashboard-container{display:flex;min-height:100vh}
.top-header{position:fixed;top:0;left:0;right:0;height:70px;background:rgb(255,242,225);display:flex;justify-content:space-between;align-items:center;padding:0 30px;z-index:1000;box-shadow:0 2px 10px rgba(102,72,50,.1)}
.mobile-menu-toggle{display:none;background:none;border:none;color:#664832;font-size:20px;cursor:pointer}
.logo{font-family:'Cormorant Garamond',serif;font-size:28px;font-weight:600;color:#664832;text-decoration:none}
.logo::before{content:"RA"}
.header-right{display:flex;align-items:center;gap:20px}
.search-container{position:relative}
.search-box{width:400px;padding:12px 45px 12px 20px;border:2px solid rgba(102,72,50,.2);border-radius:25px;background:#fff7;font-size:14px;color:#664832;transition:.3s}
.search-box::placeholder{color:rgba(102,72,50,.6)}
.search-box:focus{outline:none;border-color:#664832;background:#fff9}
.search-icon{position:absolute;right:15px;top:50%;transform:translateY(-50%);color:rgba(102,72,50,.6);font-size:16px}
.notification-icon{position:relative;color:#664832;font-size:20px;cursor:pointer;padding:8px;border-radius:50%;transition:.3s}
.notification-icon:hover{background:rgba(139,111,77,.1)}
.user-profile{position:relative;display:flex;align-items:center;gap:10px;cursor:pointer;padding:8px 15px;border-radius:25px;background:#8B6F4D;color:#fff;transition:.3s}
.user-profile:hover{background:#664832}
.user-avatar{width:35px;height:35px;border-radius:50%;background:linear-gradient(135deg,#8B6F4D,#664832);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:600;font-size:14px}
.user-name{font-weight:600;font-size:14px}
.dropdown-arrow{font-size:12px;margin-left:5px}
.dropdown-menu{position:absolute;top:100%;right:0;background:#fff;border-radius:10px;box-shadow:0 5px 20px rgba(102,72,50,.2);padding:10px 0;min-width:150px;z-index:1001;display:none}
.dropdown-menu.active{display:block}
.dropdown-item{padding:12px 20px;color:#664832;text-decoration:none;display:block;font-size:14px;transition:.2s}
.dropdown-item:hover{background:rgba(139,111,77,.1)}
.sidebar{width:280px;background:rgba(255,255,255,.4);padding:90px 0 30px 0;position:fixed;left:0;top:0;height:100vh;overflow-y:auto;transition:transform .3s;z-index:999}
.sidebar-header{padding:0 30px 30px}
.sidebar-title{font-family:'Cormorant Garamond',serif;font-size:24px;font-weight:600;color:#664832;margin-bottom:5px}
.sidebar-date{font-size:12px;color:rgba(102,72,50,.7)}
.sidebar-nav{list-style:none;padding:0}
.nav-item{margin-bottom:5px}
.nav-link{display:flex;align-items:center;gap:15px;padding:15px 30px;color:#664832;text-decoration:none;font-size:15px;font-weight:500;transition:.3s;border-radius:0 25px 25px 0;margin-right:30px}
.nav-link:hover,.nav-link.active{background:rgba(139,111,77,.2);color:#3E2A1E;font-weight:600}
.nav-link.active{background:rgba(139,111,77,.3)}
.nav-icon{width:20px;height:20px;font-size:16px}
.main-content{flex:1;margin-left:280px;padding:90px 30px 30px;transition:margin-left .3s}
.section-title{font-size:18px;color:#664832;margin-bottom:12px;font-weight:600}
.page-subtitle{font-size:12px;color:rgba(102,72,50,.7);margin-bottom:18px}
.card{background:#fff;border-radius:15px;padding:0;box-shadow:0 5px 15px rgba(102,72,50,.1);border:1px solid rgba(139,111,77,.1);overflow:hidden}
.card-header{display:flex;align-items:center;justify-content:space-between;padding:18px 20px;border-bottom:1px solid rgba(139,111,77,.15)}
.card-title{font-weight:600;color:#664832}
.toolbar{display:flex;gap:10px}
.btn{border:1px solid rgba(139,111,77,.3);background:#fff;border-radius:10px;padding:8px 12px;font-size:13px;color:#664832;cursor:pointer}
.btn:hover{background:rgba(139,111,77,.08)}
.btn.primary{background:#8B6F4D;color:#fff;border-color:#8B6F4D}
.btn.primary:hover{background:#664832}
.search-small{min-width:220px;padding:9px 36px 9px 12px;border:1px solid rgba(139,111,77,.3);border-radius:10px;background:#fff}
.table-wrap{width:100%;overflow:auto}
table{width:100%;border-collapse:collapse}
thead th{background:rgb(255,242,225);color:#664832;font-weight:600;font-size:13px;text-align:left;padding:14px 16px;border-bottom:1px solid rgba(139,111,77,.2)}
tbody td{padding:14px 16px;font-size:14px;color:#3E2A1E;border-bottom:1px solid rgba(139,111,77,.12)}
tbody tr:hover{background:rgba(139,111,77,.05)}
.status-badge{display:inline-block;padding:6px 10px;font-size:12px;border-radius:999px;background:#e6f0ff;color:#1f3a93;border:1px solid rgba(31,58,147,.15)}
.actions{display:flex;gap:10px;align-items:center}
.icon-btn{background:none;border:none;cursor:pointer;padding:6px;border-radius:8px}
.icon-btn:hover{background:rgba(139,111,77,.12)}
.muted{color:rgba(102,72,50,.7);font-size:12px}
.empty{color:rgba(102,72,50,.7);font-style:italic}
.view-shell{background:#fff;border-radius:16px;box-shadow:0 5px 15px rgba(102,72,50,.1);border:1px solid rgba(139,111,77,.15);padding:0;overflow:hidden}
.view-header{display:flex;align-items:center;gap:8px;padding:10px 14px}
.back-pill{width:28px;height:28px;border-radius:999px;border:1px solid rgba(139,111,77,.3);display:flex;align-items:center;justify-content:center;cursor:pointer;background:#fff}
.tabs{display:flex;gap:8px;padding:0 14px}
.tab{padding:12px 18px;border-radius:12px;background:#efe5d9;color:#3E2A1E;font-weight:600;cursor:pointer}
.tab.active{background:#e5d6c6;box-shadow:inset 0 0 0 2px rgba(139,111,77,.25)}
.tab-panels{padding:18px}
.inner-card{border:1px solid rgba(139,111,77,.35);border-radius:12px;padding:18px 16px}
.form-grid{display:grid;grid-template-columns:repeat(12,1fr);gap:16px}
.field{grid-column:span 12}
.field.half{grid-column:span 6}
.field.third{grid-column:span 4}
.label{font-size:12px;color:rgba(102,72,50,.8);margin-bottom:6px}
.input,.select,.fake-input{width:100%;padding:10px 12px;border:1.5px solid rgba(139,111,77,.45);border-radius:8px;background:#fff;font-size:14px;color:#3E2A1E;outline:none}
.input[readonly],.select[disabled],.fake-input{background:#fff;border-color:rgba(139,111,77,.45);box-shadow:0 1px 0 rgba(0,0,0,.02)}
.row-actions{display:flex;gap:10px;margin-top:6px}
.footer{background:rgb(255,242,225);padding:20px 30px;margin-left:280px;transition:margin-left .3s}
.footer-content{display:grid;grid-template-columns:auto 1fr auto auto;gap:30px;align-items:center}
.footer-logo{font-family:'Cormorant Garamond',serif;font-size:20px;font-weight:600;color:#664832}
.footer-logo::before{content:"RA"}
.footer-info{font-size:14px;color:#664832}
.footer-info a{color:#664832;text-decoration:none}
.footer-info a:hover{text-decoration:underline}
.footer-copyright{font-size:12px;color:#8B6F4D;text-align:right}
.overlay{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.5);z-index:998}
.overlay.active{display:block}
@media (max-width:1024px){.search-box{width:300px}}
@media (max-width:768px){
  .mobile-menu-toggle{display:block}
  .sidebar{transform:translateX(-100%)}
  .sidebar.active{transform:translateX(0)}
  .main-content,.footer{margin-left:0}
  .top-header{padding:0 20px}
  .search-container{display:none}
  .header-right{gap:15px}
  .main-content{padding:90px 20px 30px}
  .footer-content{grid-template-columns:1fr;text-align:center;gap:15px}
  .footer-copyright{text-align:center}
}
@media (max-width:640px){.form-grid .half,.form-grid .third{grid-column:span 12}.tabs{flex-wrap:wrap}}
@media (max-width:480px){
  .top-header{padding:0 15px}
  .main-content{padding:90px 15px 20px}
  .user-name{display:none}
  .search-small{min-width:unset;width:100%}
  thead th,tbody td{white-space:nowrap}
}
</style>
</head>
<body>

<header class="top-header">
  <button class="mobile-menu-toggle" onclick="toggleSidebar()">☰</button>
  <a href="#" class="logo"></a>
  <div class="header-right">
    <div class="search-container">
      <input id="globalSearch" type="text" class="search-box" placeholder="Search">
      <span class="search-icon">🔍</span>
    </div>
    <div class="notification-icon">🔔</div>
    <div class="user-profile" onclick="toggleDropdown()">
      <div class="user-avatar">A</div>
      <span class="user-name">Admin</span>
      <span class="dropdown-arrow">▼</span>
      <div class="dropdown-menu" id="userDropdown">
        <a href="#" class="dropdown-item">Profile</a>
        <a href="#" class="dropdown-item">Settings</a>
        <a href="#" class="dropdown-item">Logout</a>
      </div>
    </div>
  </div>
</header>

<div class="dashboard-container">
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <h2 class="sidebar-title">Manage Customer Records</h2>
      <p class="sidebar-date" id="todayText"></p>
    </div>
    <nav>
      <ul class="sidebar-nav">
        <li class="nav-item"><a href="admin_dashboard.php" class="nav-link"><span class="nav-icon">📊</span>Dashboard</a></li>
        <li class="nav-item"><a href="burial_plot_management.php" class="nav-link"><span class="nav-icon">⚰️</span>Burial Plot Management</a></li>
        <li class="nav-item"><a href="manage_record.php" class="nav-link active"><span class="nav-icon">👥</span>Manage Customer Records</a></li>
        <li class="nav-item"><a href="admin_transaction_management.php" class="nav-link"><span class="nav-icon">💳</span>Transaction Management</a></li>
        <li class="nav-item"><a href="notification_management.php" class="nav-link"><span class="nav-icon">🔔</span>Notification Management</a></li>
        <li class="nav-item"><a href="report_analytics.php" class="nav-link"><span class="nav-icon">📈</span>Report & Analytics</a></li>
      </ul>
    </nav>
  </aside>

  <main class="main-content">

    <?php if(!$detail): ?>
    <!-- LIST VIEW -->
    <h2 class="section-title">Manage Customer Records</h2>
    <div class="page-subtitle"><span id="dateSmall"></span></div>

    <div class="card">
      <div class="card-header">
        <div class="card-title">Customer Records</div>
        <div class="toolbar">
          <input id="tableSearch" type="text" class="search-small" placeholder="Search in table…">
          <button class="btn" onclick="alert('Add new record (not implemented)');">＋ New</button>
        </div>
      </div>

      <div class="table-wrap">
        <table id="recordsTable">
          <thead>
            <tr>
              <th style="width:100px;">Code</th>
              <th>Deceased Name</th>
              <th>Date of Death</th>
              <th>Plot ID</th>
              <th>Family Contact</th>
              <th style="width:120px;">Status</th>
              <th style="width:120px;text-align:center;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if(!empty($records)): ?>
              <?php foreach($records as $r): ?>
                <tr>
                  <td><?= htmlspecialchars($r['code']) ?></td>
                  <td><?= htmlspecialchars($r['name']) ?></td>
                  <td><?= htmlspecialchars($r['date_of_death']) ?></td>
                  <td><?= htmlspecialchars($r['plot_id']) ?></td>
                  <td><?= htmlspecialchars($r['contact']) ?></td>
                  <td><span class="status-badge"><?= htmlspecialchars($r['status']) ?></span></td>
                  <td>
                    <div class="actions">
                      <a class="icon-btn" title="View" href="<?= $self ?>?view=<?= urlencode($r['id']) ?>">👁️</a>
                      <button class="icon-btn" title="Edit" onclick="editRecord('<?= htmlspecialchars($r['code']) ?>')">✏️</button>
                      <button class="icon-btn" title="Delete" onclick="deleteRecord('<?= htmlspecialchars($r['code']) ?>')">🗑️</button>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="7" class="empty" style="text-align:center;padding:24px;">No records yet.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <div style="padding:12px 16px;background:#fff;">
        <span class="muted">Showing <?= count($records) ?> record(s)</span>
      </div>
    </div>

    <?php else: ?>
    <!-- DETAIL VIEW -->
    <h2 class="section-title">Deceased Information</h2>
    <div class="page-subtitle"><span id="dateSmall"></span></div>

    <div class="view-shell">
      <div class="view-header">
        <a class="back-pill" href="<?= $self ?>" title="Back">↶</a>
        <div class="tabs" role="tablist">
          <button class="tab active" data-tab="dec">Deceased Information</button>
          <button class="tab" data-tab="plot">Plot / Owner</button>
        </div>
      </div>

      <section class="tab-panels">
        <div class="panel" id="panel-dec">
          <div class="inner-card">
            <div class="form-grid">
              <div class="field half">
                <div class="label">FULL NAME</div>
                <input class="input" id="dec_full_name" type="text" value="<?= htmlspecialchars($detail['full_name']) ?>" readonly>
              </div>
              <div class="field third">
                <div class="label">Date of Birth</div>
                <input class="input" id="dec_dob" type="date" value="<?= htmlspecialchars($detail['dob']) ?>" readonly>
              </div>
              <div class="field third">
                <div class="label">Date of Death</div>
                <input class="input" id="dec_dod" type="date" value="<?= htmlspecialchars($detail['dod']) ?>" readonly>
              </div>
              <div class="field third">
                <div class="label">Burial Date</div>
                <input class="input" id="dec_burial" type="date" value="<?= htmlspecialchars($detail['burial_date']) ?>" readonly>
              </div>

              <div class="field third">
                <div class="label">Assigned Plot ID</div>
                <input class="input" id="dec_plot" value="<?= htmlspecialchars($detail['plot_id']) ?>" readonly>
              </div>
              <div class="field third">
                <div class="label">Record Code</div>
                <input class="input" id="dec_code" value="<?= htmlspecialchars($detail['code']) ?>" readonly>
              </div>
              <div class="field third">
                <div class="label">Unique Code</div>
                <input class="input" id="dec_unique" value="<?= htmlspecialchars($detail['unique_code']) ?>" readonly>
                <input type="hidden" id="dec_id" value="<?= (int)$detail['id'] ?>">
              </div>

              <div class="field half">
                <div class="label">Upload document</div>
                <div class="row-actions">
                  <label class="btn" for="uploader">📤 Upload</label>
                  <input id="uploader" type="file" style="display:none" />
                  <button class="btn" type="button" onclick="viewDocs()">View Documents</button>
                </div>
              </div>
            </div>

            <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:18px">
              <button class="btn" id="btnEdit">Edit</button>
              <button class="btn primary" id="btnSave" style="display:none">Save</button>
            </div>
          </div>
        </div>

        <div class="panel" id="panel-plot" style="display:none;">
          <div class="inner-card" style="min-height:260px;">
            <div class="form-grid">
              <div class="field third">
                <div class="label">Plot Code</div>
                <input class="input" value="<?= htmlspecialchars($detail['plot_id']) ?>" readonly>
              </div>
              <div class="field third">
                <div class="label">Section / Lot / Grave</div>
                <input class="input" value="<?= htmlspecialchars($detail['section'].' / '.$detail['lot'].' / '.$detail['grave']) ?>" readonly>
              </div>
              <div class="field third">
                <div class="label">Plot Status</div>
                <input class="input" value="<?= htmlspecialchars($detail['plot_status']) ?>" readonly>
              </div>

              <div class="field half">
                <div class="label">Owner (Customer)</div>
                <input class="input" value="<?= htmlspecialchars($detail['owner_name']) ?>" readonly>
              </div>
              <div class="field third">
                <div class="label">Contact</div>
                <input class="input" value="<?= htmlspecialchars($detail['owner_contact']) ?>" readonly>
              </div>
              <div class="field third">
                <div class="label">Email</div>
                <input class="input" value="<?= htmlspecialchars($detail['owner_email']) ?>" readonly>
              </div>
              <div class="field half">
                <div class="label">Address</div>
                <input class="input" value="<?= htmlspecialchars($detail['owner_address']) ?>" readonly>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <?php endif; ?>

  </main>
</div>

<footer class="footer">
  <div class="footer-content">
    <div class="footer-logo"></div>
    <div class="footer-info">For assistance: <a href="mailto:r.assured@gmail.com">r.assured@gmail.com</a></div>
    <div class="footer-info">09193210292</div>
    <div class="footer-copyright">© 2024 Rest Assured. All Rights Reserved.</div>
  </div>
</footer>

<div class="overlay" id="overlay" onclick="closeSidebar()"></div>

<script>
// dates
function formatLongDate(d){return d.toLocaleDateString('en-PH',{year:'numeric',month:'long',day:'numeric'});}
function updateDates(){
  const now=new Date();
  const t=document.getElementById('todayText'); if(t) t.textContent=now.toLocaleDateString('en-PH',{weekday:'long',year:'numeric',month:'long',day:'numeric'});
  const s=document.getElementById('dateSmall'); if(s) s.textContent=formatLongDate(now);
}
// dropdown
function toggleDropdown(){document.getElementById('userDropdown').classList.toggle('active');}
document.addEventListener('click',(e)=>{const prof=document.querySelector('.user-profile');const dd=document.getElementById('userDropdown');if(prof&&!prof.contains(e.target)) dd.classList.remove('active');});
// sidebar
function toggleSidebar(){document.getElementById('sidebar').classList.toggle('active');document.getElementById('overlay').classList.toggle('active');}
function closeSidebar(){document.getElementById('sidebar').classList.remove('active');document.getElementById('overlay').classList.remove('active');}
window.addEventListener('resize',()=>{ if(window.innerWidth>768) closeSidebar(); });
// init
document.addEventListener('DOMContentLoaded',()=>{updateDates();const current=window.location.pathname.split('/').pop();document.querySelectorAll('.nav-link').forEach(a=>{if(a.getAttribute('href')===current) a.classList.add('active');});});
// client filter
const tableSearch=document.getElementById('tableSearch');
if(tableSearch){
  tableSearch.addEventListener('input',()=>{
    const q=tableSearch.value.toLowerCase();
    document.querySelectorAll('#recordsTable tbody tr').forEach(row=>{
      if(row.querySelector('.empty')) return;
      row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
  });
}
// demo actions
function editRecord(code){ alert('Edit record '+code+' (open detail then click Edit)'); }
function deleteRecord(code){ if(confirm('Delete record '+code+'?')) alert('Deleted (demo)'); }
document.getElementById('uploader')?.addEventListener('change',e=>{ if(e.target.files.length){ alert('Selected: '+e.target.files[0].name+' (demo)'); }});
function viewDocs(){ alert('Open documents list (demo)'); }

// tabs
const tabs=document.querySelectorAll('.tab');
tabs.forEach(t=>t.addEventListener('click',()=>{tabs.forEach(x=>x.classList.remove('active'));t.classList.add('active');document.querySelectorAll('.panel').forEach(p=>p.style.display='none');document.getElementById('panel-'+t.dataset.tab).style.display='block';}));

/* ===== EDIT + SAVE to API ===== */
const API_UPDATE = 'http://127.0.0.1:8000/api_burial_update.php'; // adjust if your PHP host differs

function setReadonly(on){
  ['dec_full_name','dec_dob','dec_dod','dec_burial','dec_plot'].forEach(id=>{
    const el = document.getElementById(id);
    if (!el) return;
    // inputs: toggle readOnly; for type=date we keep enabled but still toggle readOnly for consistency
    el.readOnly = on;
    if (!on) el.classList.add('editing'); else el.classList.remove('editing');
  });
}

document.getElementById('btnEdit')?.addEventListener('click', ()=>{
  setReadonly(false);
  document.getElementById('btnEdit').style.display='none';
  document.getElementById('btnSave').style.display='inline-block';
});

document.getElementById('btnSave')?.addEventListener('click', async ()=>{
  const payload = {
    id: document.getElementById('dec_id')?.value || null,
    unique_code: document.getElementById('dec_unique')?.value || '',
    deceased_name: document.getElementById('dec_full_name')?.value.trim(),
    birth_date:  (document.getElementById('dec_dob')?.value || '').trim() || null,
    death_date:  (document.getElementById('dec_dod')?.value || '').trim() || null,
    burial_date: (document.getElementById('dec_burial')?.value || '').trim() || null,
    plot_code:   (document.getElementById('dec_plot')?.value || '').trim()
  };

  try{
    const res = await fetch(API_UPDATE, {
      method:'POST',
      headers:{'Content-Type':'application/json'},
      credentials:'include',
      body: JSON.stringify(payload)
    });
    const data = await res.json();
    if(!res.ok || data.error){ throw new Error(data.error||('HTTP '+res.status)); }

    alert('Saved! (Burial record updated)');
    setReadonly(true);
    document.getElementById('btnEdit').style.display='inline-block';
    document.getElementById('btnSave').style.display='none';
  }catch(err){
    alert('Save failed: '+err.message);
  }
});
</script>
</body>
</html>
