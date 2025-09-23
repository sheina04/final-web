<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>User Management Panel — Rest Assured</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root{
      --bg:#F1EAE1; --shell:#F6EFE6; --card:#FFFFFF; --ink:#3E2A1E; --muted:#8B7A6E;
      --brown:#7C563E; --border:#E6D6C7; --thead:#F3EAE1; --shadow:0 2px 10px rgba(102,72,50,.12); --radius:14px;
    }
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:Montserrat,system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial;color:var(--ink);background:var(--bg)}
    .topbar{position:sticky;top:0;z-index:40;display:grid;grid-template-columns:auto 1fr auto;align-items:center;column-gap:18px;background:var(--shell);border-bottom:1px solid var(--border);padding:12px 18px}
    .brand-inline{display:flex;align-items:center;gap:12px}
    #menuToggle{display:none;border:1px solid var(--border);background:#fff;border-radius:10px;padding:.35rem .6rem;cursor:pointer}
    .ra{font-family:"Cormorant Garamond",serif;font-weight:600;font-size:38px;letter-spacing:2px;color:#5b3b2a;line-height:1}
    .search-wrap{display:flex;justify-content:center}
    .search{position:relative;width:min(760px,92%)}
    .search input{width:100%;height:46px;border-radius:24px;background:#fff;border:1px solid #D8C9BA;padding:0 14px 0 42px;font-size:14px;color:#6B5647;box-shadow:0 2px 0 rgba(0,0,0,.08)}
    .search input::placeholder{color:#9C8C82}
    .search .icon{position:absolute;left:14px;top:50%;transform:translateY(-50%)}
    .top-right{display:flex;align-items:center;gap:14px}
    .bell{width:22px;height:22px;border-radius:50%;background:#fff;opacity:.35}
    .user-pill{display:flex;align-items:center;gap:8px;background:#5C3B2B;color:#fff;padding:7px 12px;border-radius:24px;box-shadow:var(--shadow)}
    .avatar{width:26px;height:26px;border-radius:50%;background:#fff;opacity:.35}
    .caret{width:10px;height:10px;border:1px dashed rgba(255,255,255,.65);border-radius:2px}
    .underlogo{padding:6px 18px 10px}.u-title{font-size:16px;font-weight:700}.u-date{font-size:12px;color:var(--muted);margin-top:2px}
    .wrap{display:flex;min-height:calc(100vh - 74px)}
    .sidebar{width:300px;background:var(--shell);border-right:1px solid var(--border);padding:18px 14px;position:sticky;top:74px;height:calc(100vh - 74px)}
    .nav{display:flex;flex-direction:column;gap:18px;margin-top:6px}
    .nav-item{display:flex;align-items:center;gap:14px;font-weight:700;color:#3E2A1E;text-decoration:none;padding:12px 18px;border-radius:999px}
    .nav-item .ico{width:28px;height:28px;border:1px dashed #CDB8A7;border-radius:8px}
    .nav-item.active{background:#fff;box-shadow:var(--shadow);border:1px solid #D8C9BA}
    .content{flex:1;padding:18px;overflow:auto}
    .board{background:#fff;border:1px solid var(--border);border-radius:18px;box-shadow:var(--shadow);padding:18px}
    .board-tools{display:flex;align-items:center;gap:12px;margin-bottom:12px}
    .mini-search{position:relative;flex:1;max-width:520px}
    .mini-search input{width:100%;height:42px;border:1px solid #D8C9BA;border-radius:10px;padding:0 12px 0 38px}
    .mini-search .icon{position:absolute;left:10px;top:50%;transform:translateY(-50%)}
    .filter{display:inline-flex;align-items:center;gap:8px;height:42px;padding:0 16px;border:1px solid #D8C9BA;border-radius:8px;background:#EFE7DE;color:#6B5647;cursor:pointer}
    .filter .slot{width:12px;height:8px;border:1px dashed #CDB8A7;border-radius:2px}
    .add-btn{margin-left:auto;display:inline-flex;align-items:center;gap:8px;height:42px;padding:0 14px;background:#EFE7DE;border:1px solid #D8C9BA;border-radius:8px;cursor:pointer}
    .add-btn .slot{width:16px;height:16px;border:1px dashed #CDB8A7;border-radius:50%}
    .table-wrap{border:1px solid #E8D6C7;border-radius:10px;overflow:auto}
    table{width:100%;border-collapse:separate;border-spacing:0}
    thead th{background:var(--thead);color:#6B5647;text-align:left;font-size:12px;padding:10px 12px;border-bottom:1px solid #EAD8C9;position:sticky;top:0}
    tbody td{padding:12px;border-bottom:1px solid #F0E3D8;vertical-align:middle}
    .link{color:#3a3a3a;text-decoration:underline}
    .status-active{color:#2ecc71;font-weight:600}
    .actions{display:flex;align-items:center;gap:16px;justify-content:flex-end}
    .a-link{color:#7C563E;text-decoration:underline;font-weight:600}
    footer{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;color:#6B5647;font-size:14px}
    .ra{display:flex;align-items:center;gap:12px}.ra-mark{width:44px;height:44px;border-radius:10px;background:#fff;opacity:.35}
    @media (max-width:1100px){#menuToggle{display:inline-flex}.sidebar{position:fixed;left:0;top:74px;transform:translateX(-100%);transition:.25s ease;z-index:50}.sidebar.open{transform:none}}
    @media (max-width:720px){.content{padding:14px}.board{padding:14px}.board-tools{gap:8px;flex-wrap:wrap}.mini-search{flex:1 1 100%}.add-btn{margin-left:0}}
  </style>
</head>
<body>
  <!-- Topbar -->
  <header class="topbar">
    <div class="brand-inline">
      <button id="menuToggle" aria-label="Toggle menu">☰</button>
      <div class="ra">RA</div>
    </div>
    <div class="search-wrap">
      <div class="search">
        <span class="icon" aria-hidden="true">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7.5" stroke="#7c563e" stroke-width="2"/><path d="M21 21L16.65 16.65" stroke="#7c563e" stroke-width="2" stroke-linecap="round"/></svg>
        </span>
        <input type="search" placeholder="Search"/>
      </div>
    </div>
    <div class="top-right"><div class="bell"></div><div class="user-pill"><div class="avatar"></div><span>System Admin</span><div class="caret"></div></div></div>
  </header>

  <!-- Title under logo -->
  <div class="underlogo"><div class="u-title">User Management Panel</div><div class="u-date" id="dateText">—</div></div>

  <div class="wrap">
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
      <nav class="nav">
        <!-- hrefs are linked to these pages -->
        <a class="nav-item active" href="systemadmin_usermanagement.php"><span class="ico"></span><span>User Management Panel</span></a>
        <a class="nav-item" href="systemadmin_backup%26restore.php"><span class="ico"></span><span>System Backup and Restore</span></a>
        <a class="nav-item" href="systemadmin_auditlogs.php"><span class="ico"></span><span>Audit Logs</span></a>
      </nav>
    </aside>

    <!-- Main content -->
    <main class="content">
      <section class="board">
        <div class="board-tools">
          <div class="mini-search">
            <span class="icon" aria-hidden="true">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7.5" stroke="#7c563e" stroke-width="2"/><path d="M21 21L16.65 16.65" stroke="#7c563e" stroke-width="2" stroke-linecap="round"/></svg>
            </span>
            <input type="text" placeholder="Search users"/>
          </div>
          <button class="filter" type="button"><span>All roles</span><span class="slot" aria-hidden="true"></span></button>
          <button class="add-btn" type="button"><span class="slot" aria-hidden="true"></span><span>Add new user</span></button>
        </div>

        <div class="table-wrap">
          <table>
            <thead>
              <tr>
                <th style="width:120px">User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th style="width:140px">Role</th>
                <th style="width:120px">Status</th>
                <th style="width:160px;text-align:right;">Actions</th>
              </tr>
            </thead>
            <tbody id="userRows"></tbody>
          </table>
        </div>
      </section>
    </main>
  </div>

  <footer>
    <div class="ra"><div class="ra-mark"></div><div>For assistance:</div></div>
    <div>r.assured@gmail.com</div><div>09193210292</div><div>© 2024 Rest Assured. All Rights Reserved.</div>
  </footer>

  <script>
    const menuToggle=document.getElementById('menuToggle'); const sidebar=document.getElementById('sidebar');
    menuToggle?.addEventListener('click',()=>sidebar.classList.toggle('open'));
    function today(){const d=new Date();const wd=d.toLocaleDateString(undefined,{weekday:'long'});const dt=d.toLocaleDateString(undefined,{day:'numeric',month:'long',year:'numeric'});return `${wd}, ${dt}`;}
    document.getElementById('dateText').textContent=today();

    // sample data
    const data=[{ id:'U001', name:'Bogart', email:'admin@gmail.com', role:'Admin', status:'Active'}];
    const tbody=document.getElementById('userRows');
    function renderRows(){
      tbody.innerHTML='';
      data.forEach(u=>{
        const tr=document.createElement('tr');
        tr.innerHTML=`<td>${u.id}</td>
          <td>${u.name}</td>
          <td><a class="link" href="mailto:${u.email}">${u.email}</a></td>
          <td>${u.role}</td>
          <td class="status-active">${u.status}</td>
          <td><div class="actions"><a href="#" class="a-link">Edit</a><a href="#" class="a-link">Deactivate</a></div></td>`;
        tbody.appendChild(tr);
      });
    }
    renderRows();
  </script>
</body>
</html>
