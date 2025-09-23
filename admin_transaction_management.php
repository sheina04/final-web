<?php /* admin_transaction_management.php */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Transaction Management - RA Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600&family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:'Montserrat',sans-serif;background:#fff2e1;color:#3E2A1E;line-height:1.6;min-height:100vh}
    .dashboard-container{display:flex;min-height:100vh}
    .top-header{position:fixed;top:0;left:0;right:0;height:70px;background:#fff2e1;display:flex;justify-content:space-between;align-items:center;padding:0 30px;z-index:1000;box-shadow:0 2px 10px rgba(102,72,50,.1)}
    .logo{font-family:'Cormorant Garamond',serif;font-size:28px;font-weight:600;color:#664832;text-decoration:none}
    .logo::before{content:'RA'}
    .header-right{display:flex;align-items:center;gap:20px}
    .search-container{position:relative}
    .search-box{width:360px;padding:12px 45px 12px 20px;border:2px solid rgba(102,72,50,.2);border-radius:25px;background:rgba(255,255,255,.7);font-size:14px;color:#664832}
    .search-icon{position:absolute;right:15px;top:50%;transform:translateY(-50%)}
    .notification-btn{background:none;border:0;font-size:20px;cursor:pointer;padding:8px;border-radius:50%}
    .user-profile{position:relative;display:flex;align-items:center;gap:10px;cursor:pointer;padding:8px 15px;border-radius:25px;background:#8B6F4D;color:#fff}
    .user-avatar{width:35px;height:35px;border-radius:50%;background:linear-gradient(135deg,#8B6F4D,#664832);display:flex;align-items:center;justify-content:center;font-weight:700}
    .dropdown-menu{position:absolute;top:100%;right:0;background:#fff;border-radius:10px;box-shadow:0 5px 20px rgba(102,72,50,.2);padding:10px 0;min-width:150px;display:none;z-index:1001}
    .dropdown-menu.active{display:block}
    .dropdown-item{padding:12px 20px;color:#664832;text-decoration:none;display:block}
    .sidebar{width:280px;background:rgba(255,255,255,.4);padding:90px 0 30px;position:fixed;left:0;top:0;height:100vh;overflow:auto;z-index:999}
    .sidebar-header{padding:0 30px 30px}
    .sidebar-title{font-family:'Cormorant Garamond',serif;font-size:24px;font-weight:600;color:#664832}
    .sidebar-date{font-size:12px;color:rgba(102,72,50,.7)}
    .nav-link{display:flex;align-items:center;gap:15px;padding:15px 30px;color:#664832;text-decoration:none;border-radius:0 25px 25px 0;margin-right:30px}
    .nav-link.active,.nav-link:hover{background:rgba(139,111,77,.2);font-weight:600}
    .main-content{flex:1;margin-left:280px;padding:90px 30px 30px}
    .page-title{font-family:'Cormorant Garamond',serif;font-size:32px;font-weight:600;color:#664832;margin-bottom:10px}
    .transaction-section{background:#fff;border-radius:15px;padding:30px;box-shadow:0 5px 20px rgba(102,72,50,.1)}
    .section-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:25px}
    .section-title{font-size:24px;font-weight:600;color:#664832}
    .add-transaction-btn{background:linear-gradient(135deg,#8B6F4D,#664832);color:#fff;border:0;padding:12px 25px;border-radius:25px;font-weight:700;cursor:pointer}
    .table-container{overflow-x:auto;border:1px solid rgba(102,72,50,.1);border-radius:10px}
    .transaction-table{width:100%;border-collapse:collapse;min-width:1100px}
    .transaction-table th{background:rgba(139,111,77,.1);padding:14px 12px;text-align:left;font-size:14px}
    .transaction-table td{padding:14px 12px;border-bottom:1px solid rgba(102,72,50,.1)}
    .status-badge{padding:5px 12px;border-radius:15px;font-size:12px;font-weight:700;text-transform:capitalize}
    .status-paid{background:rgba(34,197,94,.1);color:#059669}
    .status-pending{background:rgba(251,191,36,.1);color:#d97706}
    .status-failed{background:rgba(239,68,68,.1);color:#dc2626}
    .service-badge{padding:4px 10px;border-radius:12px;font-size:12px;background:rgba(139,111,77,.1);color:#664832}
    .modal{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:2000}
    .modal.active{display:flex;align-items:center;justify-content:center}
    .modal-content{background:#fff;padding:26px;border-radius:15px;width:90%;max-width:720px;max-height:90vh;overflow:auto}
    .form-row{display:grid;grid-template-columns:1fr 1fr;gap:18px}
    .form-group{margin-bottom:18px}
    .form-label{display:block;margin-bottom:8px;color:#664832;font-weight:600}
    .form-input,.form-select{width:100%;padding:12px 15px;border:2px solid rgba(102,72,50,.2);border-radius:8px}
    .file-upload-label{display:flex;align-items:center;justify-content:center;padding:16px;background:rgba(139,111,77,.1);border:2px dashed rgba(102,72,50,.3);border-radius:8px;cursor:pointer}
    .modal-buttons{display:flex;gap:12px;margin-top:18px}
    .btn{padding:12px 20px;border-radius:8px;font-weight:700;border:0;cursor:pointer}
    .btn-cancel{background:rgba(102,72,50,.1);color:#664832}
    .btn-submit{background:linear-gradient(135deg,#8B6F4D,#664832);color:#fff}
    .success{position:fixed;top:20px;right:20px;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;padding:12px 16px;border-radius:10px;box-shadow:0 5px 15px rgba(34,197,94,.3);display:none;z-index:3000}
    @media(max-width:768px){.sidebar{transform:translateX(-100%)}.sidebar.active{transform:translateX(0)}.main-content{margin-left:0}.form-row{grid-template-columns:1fr}}
  </style>
</head>
<body>
  <header class="top-header">
    <button class="mobile-menu-toggle" id="mobileMenuToggle">☰</button>
    <a href="admin_dashboard.php" class="logo"></a>
    <div class="header-right">
      <div class="search-container">
        <input type="text" class="search-box" id="searchInput" placeholder="Search transactions">
        <span class="search-icon">🔍</span>
      </div>
      <button class="notification-btn">🔔</button>
      <div class="user-profile" id="userProfile">
        <div class="user-avatar">A</div><span class="user-name">Admin</span><span class="dropdown-arrow">▼</span>
        <div class="dropdown-menu" id="userDropdown">
          <a class="dropdown-item" href="admin_profile.php">Profile</a>
          <a class="dropdown-item" href="logout.php">Logout</a>
        </div>
      </div>
    </div>
  </header>

  <div class="dashboard-container">
    <aside class="sidebar" id="sidebar">
      <div class="sidebar-header">
        <h2 class="sidebar-title">Transaction Management</h2>
        <p class="sidebar-date" id="sidebarDate">—</p>
      </div>
      <nav>
        <ul class="sidebar-nav">
          <li><a href="admin_dashboard.php" class="nav-link"><span>📊</span>Dashboard</a></li>
          <li><a href="burial_plot_management.php" class="nav-link"><span>⚰️</span>Burial Plot Management</a></li>
          <li><a href="manage_record.php" class="nav-link"><span>👥</span>Manage Customer Records</a></li>
          <li><a href="admin_transaction_management.php" class="nav-link active"><span>💳</span>Transaction Management</a></li>
          <li><a href="notification_management.php" class="nav-link"><span>🔔</span>Notification Management</a></li>
          <li><a href="report_analytics.php" class="nav-link"><span>📈</span>Report & Analytics</a></li>
        </ul>
      </nav>
    </aside>

    <main class="main-content">
      <div class="page-header">
        <h1 class="page-title">Transaction Management</h1>
        <p class="page-subtitle">Manage customer payments and transactions</p>
      </div>

      <section class="transaction-section">
        <div class="section-header">
          <h2 class="section-title">Transactions</h2>
          <button class="add-transaction-btn" id="addTransactionBtn">⊕ Add new transaction</button>
        </div>

        <div class="table-container">
          <table class="transaction-table">
            <thead>
              <tr>
                <th>Transaction ID</th>
                <th>Customer name</th>
                <th>Deceased name</th>
                <th>Plot #</th>
                <th>Service type</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Payment date</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody id="transactionTableBody"></tbody>
          </table>
        </div>
        <div id="txEmpty" style="padding:14px;color:rgba(102,72,50,.6);display:none">No transactions yet.</div>
      </section>
    </main>
  </div>

  <div class="success" id="successToast">Transaction added successfully!</div>

  <!-- Add Transaction Modal -->
  <div class="modal" id="transactionModal" aria-hidden="true">
    <div class="modal-content">
      <div class="modal-header"><h2 class="modal-title">Add New Transaction</h2></div>
      <form id="transactionForm">
        <div class="form-group">
          <label class="form-label">Service type <span style="color:#dc2626">*</span></label>
          <select class="form-select" id="serviceType" required>
            <option value="">Select</option>
            <option value="renewal">Renewal (existing)</option>
            <option value="maintenance">Maintenance (existing)</option>
            <option value="service_fee">Service Fee (existing)</option>
            <option value="transfer">Transfer (existing)</option>
            <option value="burial">Burial (NEW customer)</option>
          </select>
        </div>

        <div id="existingCustomerBlock" style="display:none">
          <div class="form-group">
            <label class="form-label">Select customer (existing) <span style="color:#dc2626">*</span></label>
            <select class="form-select" id="existingCustomerSelect">
              <option value="">Loading…</option>
            </select>
          </div>
        </div>

        <div id="newCustomerBlock" style="display:none">
          <div class="form-group">
            <label class="form-label">Customer full name <span style="color:#dc2626">*</span></label>
            <input type="text" class="form-input" id="custName" placeholder="e.g., Maria Clara Escobar">
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Email</label>
              <input type="email" class="form-input" id="custEmail" placeholder="name@email.com">
            </div>
            <div class="form-group">
              <label class="form-label">Phone</label>
              <input type="text" class="form-input" id="custPhone" placeholder="+63 9xx xxx xxxx">
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Address</label>
            <input type="text" class="form-input" id="custAddress" placeholder="Street, City, ZIP">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Deceased name <span style="color:#dc2626">*</span></label>
            <input type="text" class="form-input" id="deceasedName" required>
          </div>
          <div class="form-group">
            <label class="form-label">Plot number <span style="color:#dc2626">*</span></label>
            <input type="text" class="form-input" id="plotNumber" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Amount paid <span style="color:#dc2626">*</span></label>
            <input type="number" class="form-input" id="amountPaid" step="0.01" required>
          </div>
          <div class="form-group">
            <label class="form-label">Payment date <span style="color:#dc2626">*</span></label>
            <input type="date" class="form-input" id="paymentDate" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Payment method <span style="color:#dc2626">*</span></label>
            <select class="form-select" id="paymentMethod1" required>
              <option value="">Select</option>
              <option value="gcash">GCash</option>
              <option value="bank_transfer">Bank Transfer</option>
              <option value="cash">Cash</option>
              <option value="credit_card">Credit Card</option>
              <option value="debit_card">Debit Card</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Payment method type <span style="color:#dc2626">*</span></label>
            <select class="form-select" id="paymentMethod2" required>
              <option value="">Select</option>
              <option value="online">Online</option>
              <option value="offline">Offline</option>
              <option value="installment">Installment</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Upload receipt</label>
          <label class="file-upload-label" for="receiptFile">📄 Click to upload or drop file</label>
          <input type="file" id="receiptFile" accept="image/*,.pdf" style="display:none"/>
          <div class="file-info" id="fileInfo" style="font-size:12px;color:rgba(102,72,50,.6)">No file chosen</div>
        </div>

        <div class="modal-buttons">
          <button type="button" class="btn btn-cancel" id="cancelBtn">Cancel</button>
          <button type="submit" class="btn btn-submit">Submit</button>
        </div>
      </form>
    </div>
  </div>

<script>
/* ---------- API ROUTES (relative sa site root) ---------- */
const API = {
  list:       '/api/api_transaction_list.php',
  create:     '/api/api_transaction_create.php',
  customers:  '/api/api_customers.php',
  customer:   (id) => `/api/api_customer.php?id=${encodeURIComponent(id)}`
};

/* ---------- Small helpers ---------- */
const $  = (s) => document.querySelector(s);
const $$ = (s) => document.querySelectorAll(s);
const peso   = n => '₱' + (Number(n||0)).toLocaleString('en-PH',{minimumFractionDigits:2,maximumFractionDigits:2});
const fmtISO = d => d ? new Date(d).toISOString().slice(0,10) : '';
const serviceLabel = s => ({renewal:'Renewal',maintenance:'Maintenance',service_fee:'Service Fee',burial:'Burial',transfer:'Transfer'})[s] || (s||'-');
const badge = s => {
  const k=(s||'pending').toLowerCase();
  const cls = k==='paid'?'status-paid':(k==='overdue'?'status-failed':'status-pending');
  return `<span class="status-badge ${cls}">${k}</span>`;
};

/* ---------- Table loader ---------- */
async function loadTransactions(query=''){
  const tbody = $('#transactionTableBody');
  const empty = $('#txEmpty');
  tbody.innerHTML = `<tr><td colspan="9" style="padding:14px;color:#8B7A6E">Loading…</td></tr>`;
  empty.style.display='none';

  try{
    const url = API.list + (query?`?q=${encodeURIComponent(query)}`:'');
    const res = await fetch(url,{credentials:'include'});
    const ok  = res.ok;
    const data = ok ? await res.json() : null;

    if(!ok){
      const msg = data && data.error ? data.error : `HTTP ${res.status}`;
      tbody.innerHTML = `<tr><td colspan="9" style="padding:14px;color:#dc2626">Failed to load. Check API (${msg}).</td></tr>`;
      return;
    }
    if(!Array.isArray(data) || data.length===0){
      tbody.innerHTML = '';
      empty.style.display='block';
      return;
    }

    tbody.innerHTML = data.map(r=>`
      <tr>
        <td>${r.txn_id || r.id || '-'}</td>
        <td><a href="#" class="clickable-name" data-customer-id="${r.customer_id||''}">${r.customer_name||'-'}</a></td>
        <td>${r.deceased_name||'-'}</td>
        <td>${r.plot_code||'-'}</td>
        <td><span class="service-badge">${serviceLabel(r.service_type)}</span></td>
        <td>${peso(r.amount)}</td>
        <td>${r.method_display||r.method||'-'}</td>
        <td>${fmtISO(r.payment_date)||'-'}</td>
        <td>${badge(r.status)}</td>
      </tr>
    `).join('');

    // show quick customer sheet
    $$('#transactionTableBody .clickable-name').forEach(a=>{
      a.addEventListener('click', async (e)=>{
        e.preventDefault();
        const id = a.dataset.customerId;
        if(!id) return;
        const r = await fetch(API.customer(id), {credentials:'include'});
        if(r.ok){
          const c = await r.json();
          alert(`${c.name}\n${c.email||''}\n${c.phone||''}\n${c.address||''}`);
        }
      });
    });

  }catch(err){
    console.error(err);
    tbody.innerHTML = `<tr><td colspan="9" style="padding:14px;color:#dc2626">Failed to load. Check API/Network.</td></tr>`;
  }
}

/* ---------- Customers select (for modal) ---------- */
async function loadCustomersIntoSelect(){
  const sel = $('#existingCustomerSelect');
  sel.innerHTML = `<option value="">Loading…</option>`;
  try{
    const r = await fetch(API.customers,{credentials:'include'});
    const list = r.ok ? await r.json() : [];
    if(!list.length){ sel.innerHTML = `<option value="">No customers found</option>`; return;}
    sel.innerHTML = `<option value="">Select customer</option>` + list.map(c=>`
      <option value="${c.id}" data-deceased="${c.deceased_name||''}" data-plot="${c.plot_code||''}">
        ${c.name} — ${c.deceased_name||'-'} (${c.plot_code||'-'})
      </option>`).join('');
  }catch{ sel.innerHTML = `<option value="">Failed to load</option>`; }
}

/* ---------- Modal open/close + toggles ---------- */
const modal = $('#transactionModal');
$('#addTransactionBtn')?.addEventListener('click', ()=>{
  modal.classList.add('active'); document.body.style.overflow='hidden';
  $('#transactionForm').reset();
  $('#paymentDate').value = fmtISO(new Date());
  $('#existingCustomerBlock').style.display='none';
  $('#newCustomerBlock').style.display='none';
  $('#fileInfo').textContent='No file chosen';
});
$('#cancelBtn')?.addEventListener('click', ()=>{ modal.classList.remove('active'); document.body.style.overflow='auto'; });

$('#serviceType')?.addEventListener('change', async (e)=>{
  const v = e.target.value;
  const isBurial = (v==='burial');
  $('#newCustomerBlock').style.display = isBurial ? 'block' : 'none';
  $('#existingCustomerBlock').style.display = (!isBurial && v!=='') ? 'block' : 'none';
  $('#custName').required = isBurial;
  $('#existingCustomerSelect').required = (!isBurial && v!=='');
  if(!isBurial && v!==''){ await loadCustomersIntoSelect(); }
});

document.addEventListener('change',(e)=>{
  if(e.target && e.target.id==='existingCustomerSelect'){
    const opt = e.target.selectedOptions[0];
    if(opt){
      $('#deceasedName').value = opt.getAttribute('data-deceased')||'';
      $('#plotNumber').value   = opt.getAttribute('data-plot')||'';
    }
  }
});
$('#receiptFile')?.addEventListener('change', ()=>{
  const f = $('#receiptFile').files[0];
  $('#fileInfo').textContent = f? f.name : 'No file chosen';
});

/* ---------- Submit ---------- */
$('#transactionForm')?.addEventListener('submit', async (e)=>{
  e.preventDefault();
  const serviceType = $('#serviceType').value;
  if(!serviceType){ alert('Please choose a service type.'); return; }
  const isBurial = serviceType==='burial';

  const deceasedName = $('#deceasedName').value.trim();
  const plotNumber   = $('#plotNumber').value.trim();
  const amountPaid   = $('#amountPaid').value;
  const paymentDate  = $('#paymentDate').value;
  const method       = $('#paymentMethod1').value;
  const methodType   = $('#paymentMethod2').value;
  if(!deceasedName || !plotNumber || !amountPaid || !paymentDate || !method || !methodType){
    alert('Please fill in all required fields.'); return;
  }

  const fd = new FormData();
  fd.append('service_type', serviceType);
  fd.append('deceased_name', deceasedName);
  fd.append('plot_code', plotNumber);
  fd.append('amount', amountPaid);
  fd.append('payment_date', paymentDate);
  fd.append('method', method);
  fd.append('method_type', methodType);

  if(isBurial){
    const custName = $('#custName').value.trim();
    if(!custName){ alert('Customer full name is required for Burial.'); return; }
    fd.append('new_customer_name', custName);
    fd.append('new_customer_email', $('#custEmail').value.trim());
    fd.append('new_customer_phone', $('#custPhone').value.trim());
    fd.append('new_customer_address', $('#custAddress').value.trim());
    fd.append('new_customer_deceased_name', deceasedName);
    fd.append('new_customer_plot_code', plotNumber);
  }else{
    const cid = $('#existingCustomerSelect').value;
    if(!cid){ alert('Please select an existing customer.'); return; }
    fd.append('customer_id', cid);
  }
  if($('#receiptFile').files[0]) fd.append('receipt', $('#receiptFile').files[0]);

  try{
    const res = await fetch(API.create,{method:'POST',body:fd,credentials:'include'});
    const out = res.ok ? await res.json() : null;
    if(!out || !(out.ok||out.id)){ alert(out && out.error ? out.error : `HTTP ${res.status}`); return; }
    modal.classList.remove('active'); document.body.style.overflow='auto';
    await loadTransactions($('#searchInput').value.trim());
    const t = $('#successToast'); if(t){ t.style.display='block'; setTimeout(()=>t.style.display='none',1800); }
  }catch(err){ console.error(err); alert('Network error.'); }
});

/* ---------- Search + boot ---------- */
$('#searchInput')?.addEventListener('input', e=> loadTransactions(e.target.value.trim()));
(async function boot(){
  await loadTransactions();
})();
</script>


</body>
</html>
