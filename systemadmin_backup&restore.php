<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>System Backup and Restore — Rest Assured</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root{
      --bg:#F1EAE1; --shell:#F6EFE6; --card:#FFFFFF;
      --ink:#3E2A1E; --soft:#6B5647; --muted:#8B7A6E;
      --accent:#7C563E; --border:#E6D6C7; --thead:#F3EAE1;
      --shadow:0 2px 10px rgba(102,72,50,.12);
      --radius:14px;
    }
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:Montserrat,system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial;background:var(--bg);color:var(--ink)}

    /* Topbar */
    .topbar{
      position:sticky; top:0; z-index:40;
      display:grid; grid-template-columns:auto 1fr auto; align-items:center; column-gap:18px;
      padding:12px 18px; background:var(--shell); border-bottom:1px solid var(--border);
    }
    .brand-inline{display:flex; align-items:center; gap:12px}
    #menuToggle{display:none; border:1px solid var(--border); background:#fff; border-radius:10px; padding:.35rem .6rem; cursor:pointer}
    .ra{font-family:"Cormorant Garamond",serif; font-weight:600; font-size:38px; letter-spacing:2px; color:#5b3b2a; line-height:1}

    .search-wrap{display:flex; justify-content:center}
    .search{position:relative; width:min(760px,92%)}
    .search input{
      width:100%; height:46px; border-radius:24px; background:#fff;
      border:1px solid #D8C9BA; padding:0 14px 0 42px; font-size:14px; color:#6B5647;
      box-shadow:0 2px 0 rgba(0,0,0,.08);
    }
    .search .icon{position:absolute; left:14px; top:50%; transform:translateY(-50%)}

    .top-right{display:flex; align-items:center; gap:14px}
    .bell{width:22px; height:22px; border-radius:50%; background:#fff; opacity:.35}
    .user-pill{display:flex; align-items:center; gap:8px; background:#5C3B2B; color:#fff; padding:7px 12px; border-radius:24px; box-shadow:var(--shadow)}
    .avatar{width:26px; height:26px; border-radius:50%; background:#fff; opacity:.35}

    /* Title under logo */
    .underlogo{padding:6px 18px 10px}
    .u-title{font-size:16px; font-weight:700}
    .u-date{font-size:12px; color:var(--muted); margin-top:2px}

    /* Shell */
    .wrap{display:flex; min-height:calc(100vh - 74px)}
    .sidebar{
      width:300px; background:var(--shell); border-right:1px solid var(--border);
      padding:18px 14px; position:sticky; top:74px; height:calc(100vh - 74px);
    }
    .menu{display:flex; flex-direction:column; gap:18px; margin-top:6px}
    .menu a{
      display:flex; align-items:center; gap:14px; background:#fff; border:1px solid #D8C9BA;
      padding:12px 18px; border-radius:999px; box-shadow:var(--shadow); text-decoration:none; color:#3E2A1E; font-weight:700;
    }
    .menu a.active{background:#FFF8F1; border-color:var(--accent)}
    .ico{width:28px; height:28px; border:1px dashed #CDB8A7; border-radius:8px} /* blank icon slot */

    .content{flex:1; padding:18px}

    /* Board */
    .board{
      background:#fff; border:1px solid var(--border); border-radius:18px; box-shadow:var(--shadow);
      padding:18px;
    }

    /* Buttons */
    .actions{display:flex; align-items:center; gap:10px; flex-wrap:wrap}
    .btn{
      background:#fff; border:1px solid #D8C9BA; padding:9px 14px; border-radius:10px;
      font-weight:600; color:#5b3b2a; cursor:pointer; box-shadow:var(--shadow);
    }
    .btn:hover{filter:brightness(.98)}
    .btn-primary{background:#EFE7DE}
    .btn-ghost{background:#fff}

    /* Table */
    .table-wrap{margin-top:12px; border:1px solid #E8D6C7; border-radius:10px; overflow:auto}
    table{width:100%; border-collapse:separate; border-spacing:0}
    thead th{position:sticky; top:0; background:var(--thead); color:#6B5647; text-align:left; padding:10px 12px; font-size:12px; border-bottom:1px solid #EAD8C9}
    tbody td{padding:12px; border-bottom:1px solid #F0E3D8; vertical-align:middle}
    .download-btn{border:1px solid #D8C9BA; background:#fff; padding:8px 12px; border-radius:10px; font-weight:600; color:#6B5647; cursor:pointer; box-shadow:var(--shadow)}

    /* Modal (Restore) */
    .modal-backdrop{
      position:fixed; inset:0; background:rgba(0,0,0,.4); display:none; align-items:center; justify-content:center; z-index:60;
    }
    .modal{width:min(680px,92vw); background:#fff; border:1px solid var(--border); border-radius:16px; box-shadow:var(--shadow); padding:16px}
    .modal-head{display:flex; align-items:center; justify-content:space-between; margin-bottom:10px}
    .modal-title{font-weight:700}
    .close{border:1px solid #E0D0C2; background:#fff; border-radius:8px; padding:6px 10px; cursor:pointer}
    .drop{
      border:2px dashed #D8C9BA; border-radius:12px; padding:18px; text-align:center; color:#6B5647; background:#FFFDF9;
    }
    .drop.drag{background:#FFF8F1}
    .progress{
      height:10px; border-radius:999px; background:#F1EAE1; overflow:hidden; border:1px solid #E8D6C7; margin-top:10px;
      display:none;
    }
    .bar{height:100%; width:0%; background:#7C563E}
    .status{font-size:12px; color:#6B5647; margin-top:6px; display:none}

    /* Toast */
    .toast{
      position:fixed; right:16px; bottom:16px; background:#fff; border:1px solid #D8C9BA; border-radius:12px; box-shadow:var(--shadow);
      padding:10px 14px; display:none; z-index:70; color:#3E2A1E; font-weight:600;
    }

    /* Responsive */
    @media (max-width:1100px){
      #menuToggle{display:inline-flex}
      .sidebar{position:fixed; left:0; top:74px; transform:translateX(-100%); transition:.25s ease; z-index:50}
      .sidebar.open{transform:none}
    }
    @media (max-width:720px){
      .content{padding:14px}
      .board{padding:14px}
    }
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
          <!-- the ONLY filled icon -->
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="11" cy="11" r="7.5" stroke="#7c563e" stroke-width="2"/>
            <path d="M21 21L16.65 16.65" stroke="#7c563e" stroke-width="2" stroke-linecap="round"/>
          </svg>
        </span>
        <input type="search" placeholder="Search"/>
      </div>
    </div>

    <div class="top-right">
      <div class="bell" title="notifications placeholder"></div>
      <div class="user-pill"><div class="avatar"></div><span>System Admin</span></div>
    </div>
  </header>

  <!-- Title under logo -->
  <div class="underlogo">
    <div class="u-title">System Backup and Restore</div>
    <div class="u-date" id="uDate">—</div>
  </div>

  <div class="wrap">
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
      <nav class="menu">
        <a href="systemadmin_usermanagement.php"><span class="ico"></span><span>User Management Panel</span></a>
        <a class="active" href="systemadmin_backup&restore.php"><span class="ico"></span><span>System Backup and Restore</span></a>
        <a href="systemadmin_auditlogs.php"><span class="ico"></span><span>Audit Logs</span></a>
      </nav>
    </aside>

    <!-- Content -->
    <main class="content">
      <section class="board">
        <div class="actions">
          <button id="backupBtn" class="btn btn-primary">Backup Now</button>
          <button id="restoreOpen" class="btn btn-ghost">Restore</button>
        </div>

        <div class="table-wrap">
          <table>
            <thead>
              <tr>
                <th>Backup file</th>
                <th>Created</th>
                <th>Size</th>
                <th style="width:140px; text-align:right;">Action</th>
              </tr>
            </thead>
            <tbody id="rows">
              <!-- JS will render rows -->
            </tbody>
          </table>
        </div>
      </section>
    </main>
  </div>

  <footer style="display:flex;align-items:center;justify-content:space-between;padding:16px 20px;color:#6B5647;font-size:14px">
    <div style="display:flex;align-items:center;gap:12px">
      <div style="width:44px;height:44px;border-radius:10px;background:#fff;opacity:.35"></div>
      <div>For assistance:</div>
    </div>
    <div>r.assured@gmail.com</div>
    <div>09193210292</div>
    <div>© 2024 Rest Assured. All Rights Reserved.</div>
  </footer>

  <!-- Restore Modal -->
  <div class="modal-backdrop" id="restoreModal">
    <div class="modal" role="dialog" aria-modal="true" aria-labelledby="restoreTitle">
      <div class="modal-head">
        <div class="modal-title" id="restoreTitle">Restore Backup</div>
        <button class="close" id="restoreClose">✕</button>
      </div>

      <div class="drop" id="dropzone">
        <strong>Drag & drop</strong> your backup (.zip) here or
        <label style="text-decoration:underline; cursor:pointer;">
          choose file
          <input id="fileInput" type="file" accept=".zip" style="display:none">
        </label>
        <div id="picked" style="margin-top:8px; font-size:13px; color:#6B5647;"></div>
      </div>

      <div class="progress" id="progress"><div class="bar" id="bar"></div></div>
      <div class="status" id="status">Preparing…</div>

      <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:12px">
        <button class="btn" id="startRestore" disabled>Start Restore</button>
      </div>
    </div>
  </div>

  <!-- Toast -->
  <div class="toast" id="toast">✅ Restore completed successfully.</div>

  <script>
    // Sidebar toggle
    const menuToggle=document.getElementById('menuToggle');
    const sidebar=document.getElementById('sidebar');
    menuToggle?.addEventListener('click', ()=> sidebar.classList.toggle('open'));

    // Date under logo
    function todayTxt(){
      const d=new Date();
      return d.toLocaleDateString(undefined,{weekday:'long',month:'long',day:'numeric',year:'numeric'});
    }
    document.getElementById('uDate').textContent=todayTxt();

    // Sample data
    const backups=[
      {file:'backup_2025-05-01_1200.zip', created:'May 1, 2025 12:00', size:'120 MB'},
      {file:'backup_2025-04-15_0900.zip', created:'Apr 15, 2025 09:00', size:'118 MB'},
    ];
    const rows=document.getElementById('rows');
    backups.forEach(b=>{
      const tr=document.createElement('tr');
      tr.innerHTML=`
        <td>${b.file}</td>
        <td>${b.created}</td>
        <td>${b.size}</td>
        <td style="text-align:right">
          <button class="download-btn" onclick="alert('Downloading ${b.file}…')">Download</button>
        </td>`;
      rows.appendChild(tr);
    });

    // Backup Now (demo)
    document.getElementById('backupBtn').addEventListener('click', ()=>{
      const btn = document.getElementById('backupBtn');
      const old = btn.textContent;
      btn.textContent = 'Backing up…';
      btn.disabled = true;
      setTimeout(()=>{
        btn.textContent = old;
        btn.disabled = false;
        showToast('✅ Backup created successfully.');
      }, 1400);
    });

    // Restore modal logic
    const modal = document.getElementById('restoreModal');
    const openBtn = document.getElementById('restoreOpen');
    const closeBtn = document.getElementById('restoreClose');
    const startBtn = document.getElementById('startRestore');
    const drop = document.getElementById('dropzone');
    const input = document.getElementById('fileInput');
    const picked = document.getElementById('picked');
    const progress = document.getElementById('progress');
    const bar = document.getElementById('bar');
    const statusEl = document.getElementById('status');

    let file = null;

    function openModal(){ modal.style.display='flex'; }
    function closeModal(){
      modal.style.display='none';
      // reset
      file=null; picked.textContent='';
      startBtn.disabled=true;
      progress.style.display='none'; bar.style.width='0%';
      statusEl.style.display='none'; statusEl.textContent='Preparing…';
      drop.classList.remove('drag');
    }

    openBtn.addEventListener('click', openModal);
    closeBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', (e)=>{ if(e.target===modal) closeModal(); });

    // Pick file
    input.addEventListener('change', (e)=>{
      file = e.target.files[0] || null;
      picked.textContent = file ? `Selected: ${file.name}` : '';
      startBtn.disabled = !file;
    });

    // Drag & drop
    ;['dragenter','dragover'].forEach(evt=>
      drop.addEventListener(evt, (e)=>{ e.preventDefault(); drop.classList.add('drag'); })
    );
    ;['dragleave','drop'].forEach(evt=>
      drop.addEventListener(evt, (e)=>{ e.preventDefault(); drop.classList.remove('drag'); })
    );
    drop.addEventListener('drop', (e)=>{
      const f = e.dataTransfer.files?.[0];
      if(!f) return;
      if(!f.name.toLowerCase().endsWith('.zip')){ alert('Please select a .zip backup file.'); return; }
      file = f;
      picked.textContent = `Selected: ${file.name}`;
      startBtn.disabled = false;
    });

    // Start Restore (simulated nice flow)
    startBtn.addEventListener('click', ()=>{
      if(!file){ return; }
      startBtn.disabled=true;
      progress.style.display='block';
      statusEl.style.display='block';

      const steps = [
        'Validating backup file…',
        'Uploading to server…',
        'Verifying checksum…',
        'Restoring database…',
        'Restoring files…',
        'Finalizing…'
      ];
      let i = 0, pct = 0;

      const tick = setInterval(()=>{
        pct = Math.min(100, pct + Math.floor(Math.random()*12)+6);
        bar.style.width = pct+'%';
        statusEl.textContent = steps[Math.min(i, steps.length-1)];
        if(pct >= (i+1)*(100/steps.length)) i++;
        if(pct >= 100){
          clearInterval(tick);
          setTimeout(()=>{
            closeModal();
            showToast('✅ Restore completed successfully.');
          }, 300);
        }
      }, 220);
    });

    // Toast
    const toast = document.getElementById('toast');
    function showToast(msg){
      toast.textContent = msg;
      toast.style.display='block';
      setTimeout(()=> toast.style.display='none', 2200);
    }
  </script>
</body>
</html>
