<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Quản lý Booking — CinemaX</title>
  <link rel="stylesheet" href="../css/menu.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body { background:#0D1424; color:#e8e8f0; font-family:'Times New Roman',serif; }
    .app-content { margin-top:60px; margin-left:220px; padding:24px; transition:.3s; }
    .app-content.collapsed { margin-left:70px; }

    .page-title { font-size:1.5rem; font-weight:bold; margin-bottom:4px; color:#e8b84b; }
    .page-desc  { color:#7070a0; font-size:0.85rem; margin-bottom:20px; }

    /* STATS */
    .stats { display:grid; grid-template-columns:repeat(4,1fr); gap:12px; margin-bottom:24px; }
    .stat  { background:#1c1c38; border-radius:10px; padding:16px 20px; border-left:3px solid; }
    .stat:nth-child(1){border-left-color:#e8b84b;}
    .stat:nth-child(2){border-left-color:#3ddc84;}
    .stat:nth-child(3){border-left-color:#5b8dee;}
    .stat:nth-child(4){border-left-color:#ff5c5c;}
    .stat .val { font-size:1.8rem; font-weight:bold; line-height:1; }
    .stat .lbl { font-size:0.72rem; color:#7070a0; margin-top:4px; text-transform:uppercase; }

    /* CARD */
    .card { background:#1c1c38; border-radius:10px; padding:20px; margin-bottom:16px; border:1px solid #252545; }
    .card h3 { font-size:0.85rem; font-weight:700; color:#7070a0; text-transform:uppercase;
               letter-spacing:.5px; margin-bottom:16px; border-bottom:1px solid #252545; padding-bottom:10px; }

    /* FILTER */
    .filter-bar { display:flex; gap:10px; margin-bottom:16px; flex-wrap:wrap; }
    .filter-bar input, .filter-bar select {
      padding:8px 12px; border:1px solid #252545; border-radius:6px; font-size:0.875rem;
      background:#0D1424; color:#e8e8f0; outline:none; font-family:inherit; }
    .filter-bar input { flex:1; min-width:180px; }
    .filter-bar input:focus, .filter-bar select:focus { border-color:#e8b84b; }
    .filter-bar select option { background:#1c1c38; }

    /* BUTTONS */
    .btn { padding:8px 16px; border-radius:6px; cursor:pointer; font-size:0.875rem;
           font-weight:600; border:1px solid; transition:.15s; font-family:inherit; }
    .btn-primary   { background:#e8b84b; color:#0D1424; border-color:#e8b84b; }
    .btn-primary:hover { background:#c9992e; }
    .btn-primary:disabled { opacity:.4; cursor:not-allowed; }
    .btn-secondary { background:transparent; color:#e8e8f0; border-color:#252545; }
    .btn-secondary:hover { border-color:#e8b84b; color:#e8b84b; }
    .btn-danger    { background:transparent; color:#ff5c5c; border-color:rgba(255,92,92,.3); }
    .btn-danger:hover { background:rgba(255,92,92,.1); }
    .btn-sm { padding:5px 10px; font-size:0.75rem; }

    /* TABLE */
    .table-wrap { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; font-size:0.875rem; }
    thead th { background:#252545; padding:10px 14px; text-align:left; font-size:0.72rem;
               font-weight:700; color:#7070a0; text-transform:uppercase; letter-spacing:.4px; }
    tbody td { padding:12px 14px; border-bottom:1px solid #1c1c38; vertical-align:middle; }
    tbody tr:hover { background:rgba(232,184,75,.04); }
    .ticket-id { color:#e8b84b; font-weight:700; }
    .badge { display:inline-block; padding:3px 8px; border-radius:20px; font-size:0.68rem; font-weight:700; }
    .badge-vip    { background:rgba(232,184,75,.15); color:#e8b84b; }
    .badge-normal { background:rgba(255,255,255,.07); color:#7070a0; }
    .badge-couple { background:rgba(255,92,92,.12); color:#ff5c5c; }
    .actions { display:flex; gap:6px; }

    /* FORM */
    .form-group { margin-bottom:14px; }
    .form-group label { display:block; font-size:0.72rem; font-weight:700; color:#7070a0;
                        text-transform:uppercase; letter-spacing:.4px; margin-bottom:5px; }
    .form-group input { width:100%; padding:9px 12px; border:1px solid #252545; border-radius:6px;
                        font-size:0.9rem; outline:none; background:#0D1424; color:#e8e8f0;
                        transition:border .2s; font-family:inherit; }
    .form-group input:focus { border-color:#e8b84b; }

    /* SEAT MAP */
    .screen { background:linear-gradient(180deg,rgba(232,184,75,.2),transparent);
              border-top:3px solid #e8b84b; text-align:center; padding:8px;
              font-size:0.68rem; letter-spacing:6px; color:#e8b84b; font-weight:700;
              margin-bottom:20px; border-radius:0 0 4px 4px; }
    .rows { display:flex; flex-direction:column; gap:6px; align-items:center; }
    .srow { display:flex; gap:5px; align-items:center; }
    .row-lbl { width:18px; font-size:0.65rem; color:#7070a0; text-align:center; flex-shrink:0; }
    .seat { width:38px; height:34px; border-radius:5px 5px 3px 3px; border:1px solid;
            cursor:pointer; font-size:0.62rem; font-weight:700;
            display:flex; align-items:center; justify-content:center; transition:.1s; }
    .seat.av { background:rgba(61,220,132,.08); border-color:rgba(61,220,132,.4); color:#3ddc84; }
    .seat.av:hover { transform:scale(1.1); background:rgba(61,220,132,.18); }
    .seat.bk { background:rgba(255,92,92,.08); border-color:rgba(255,92,92,.3); color:#ff5c5c; cursor:not-allowed; opacity:.7; }
    .seat.sl { background:rgba(232,184,75,.2); border-color:#e8b84b; color:#e8b84b; transform:scale(1.1); }
    .legend { display:flex; gap:18px; margin-top:12px; flex-wrap:wrap; }
    .legend-item { display:flex; align-items:center; gap:6px; font-size:0.75rem; color:#7070a0; }
    .leg-sq { width:14px; height:12px; border-radius:3px; border:1px solid; }
    .leg-sq.av { background:rgba(61,220,132,.08); border-color:rgba(61,220,132,.4); }
    .leg-sq.bk { background:rgba(255,92,92,.08); border-color:rgba(255,92,92,.3); }
    .leg-sq.sl { background:rgba(232,184,75,.2); border-color:#e8b84b; }

    /* CONFIRM BOX */
    .confirm-grid { display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:16px; }
    .ci { background:#0D1424; border-radius:8px; padding:10px 13px; border:1px solid #252545; }
    .ci .lbl { font-size:0.68rem; color:#7070a0; text-transform:uppercase; margin-bottom:3px; }
    .ci .val { font-size:0.875rem; font-weight:700; }

    /* TABS */
    .tabs { display:flex; gap:4px; margin-bottom:20px; }
    .tab-btn { padding:9px 18px; border-radius:8px; cursor:pointer; font-size:0.85rem;
               font-weight:600; border:1px solid #252545; background:transparent;
               color:#7070a0; transition:.15s; font-family:inherit; }
    .tab-btn:hover { color:#e8e8f0; border-color:#e8b84b; }
    .tab-btn.active { background:rgba(232,184,75,.15); color:#e8b84b; border-color:#e8b84b; }
    .tab { display:none; }
    .tab.active { display:block; }

    /* ALERT */
    .alert { padding:10px 14px; border-radius:6px; margin-bottom:14px; font-size:0.875rem; display:none; }
    .alert.show { display:flex; align-items:center; gap:8px; }
    .alert.success { background:rgba(61,220,132,.1); border:1px solid rgba(61,220,132,.3); color:#3ddc84; }
    .alert.error   { background:rgba(255,92,92,.1); border:1px solid rgba(255,92,92,.3); color:#ff5c5c; }

    /* LOADING */
    .loading,.empty { text-align:center; padding:40px; color:#7070a0; font-size:0.9rem; }
    .spin { width:28px; height:28px; border:2px solid #252545; border-top-color:#e8b84b;
            border-radius:50%; animation:spin .8s linear infinite; margin:0 auto 10px; }
    @keyframes spin { to { transform:rotate(360deg); } }

    /* TWO COL */
    .two-col { display:grid; grid-template-columns:320px 1fr; gap:20px; align-items:start; }

    /* HISTORY */
    .history-wrap { display:grid; grid-template-columns:260px 1fr; gap:20px; align-items:start; }
    .history-sidebar { background:#1c1c38; border-radius:10px; padding:20px; border:1px solid #252545; }
    .history-sidebar h3 { font-size:0.85rem; font-weight:700; color:#7070a0; text-transform:uppercase; letter-spacing:.4px; margin-bottom:14px; }
    .history-result { display:grid; grid-template-columns:repeat(auto-fill,minmax(260px,1fr)); gap:12px; }
    .ticket-card { background:#1c1c38; border-radius:10px; padding:14px;
                   border:1px solid #252545; border-left:3px solid #e8b84b; }
    .ticket-card .tc-movie { font-weight:700; margin-bottom:8px; }
    .ticket-card .tc-grid  { display:grid; grid-template-columns:1fr 1fr; gap:5px; margin-bottom:10px; }
    .ticket-card .tc-item .lbl { font-size:0.65rem; color:#7070a0; display:block; text-transform:uppercase; }
    .ticket-card .tc-item .val { font-size:0.82rem; font-weight:600; }
    .tc-actions { display:flex; gap:6px; }

    /* MODAL */
    .modal-overlay { position:fixed; inset:0; background:rgba(0,0,0,.7); z-index:9999;
                     display:none; align-items:center; justify-content:center; padding:16px; }
    .modal-overlay.show { display:flex; }
    .modal { background:#1c1c38; border-radius:14px; padding:26px; max-width:500px; width:100%;
             max-height:90vh; overflow-y:auto; border:1px solid #252545; }
    .modal h3 { font-size:1.05rem; font-weight:700; margin-bottom:6px; }
    .modal p  { color:#7070a0; font-size:0.875rem; margin-bottom:20px; line-height:1.6; }
    .modal-info { background:#0D1424; border-radius:10px; padding:16px; margin-bottom:18px;
                  display:grid; grid-template-columns:1fr 1fr; gap:10px; border:1px solid #252545; }
    .modal-info .mi .lbl { font-size:0.65rem; color:#7070a0; text-transform:uppercase; margin-bottom:3px; }
    .modal-info .mi .val { font-size:0.875rem; font-weight:600; }
    .modal-btns { display:flex; gap:10px; }
    .modal-btns button { flex:1; }

    @media(max-width:900px){ .stats{grid-template-columns:1fr 1fr;} .two-col{grid-template-columns:1fr;} .history-wrap{grid-template-columns:1fr;} }
  </style>
</head>
<body>
<?php include "../component/header.php"; ?>

<script>
// Kiểm tra đăng nhập và quyền admin trước khi hiển thị trang
(function() {
  const raw = localStorage.getItem('cinemax_user');
  if (!raw) {
    alert('Vui lòng đăng nhập trước!');
    window.location.href = '/qlrcp/view/pages/user.php';
    return;
  }
  try {
    const user = JSON.parse(raw);
    if (!user || !user.user_id) throw new Error();
    if (user.role === 'customer') {
      alert('Bạn không có quyền truy cập trang này!');
      window.location.href = '/qlrcp/view/pages/user.php';
    }
  } catch(e) {
    localStorage.removeItem('cinemax_user');
    window.location.href = '/qlrcp/view/pages/user.php';
  }
})();
</script>

<div class="app-content" id="appContent">

  <div class="page-title">🎟 Quản lý Booking</div>
  <div class="page-desc">Đặt vé, xem danh sách và lịch sử booking</div>

  <!-- TABS -->
  <div class="tabs">
    <button class="tab-btn active" onclick="switchTab('dashboard',this)">📊 Dashboard</button>
    <button class="tab-btn" onclick="switchTab('all',this)">🎟 Tất cả vé</button>
    <button class="tab-btn" onclick="switchTab('book',this)">🎬 Đặt vé</button>
    <button class="tab-btn" onclick="switchTab('history',this)">👤 Lịch sử</button>
  </div>

  <!-- TAB: DASHBOARD -->
  <div id="tab-dashboard" class="tab active">
    <div class="stats">
      <div class="stat"><div class="val" id="s-total">—</div><div class="lbl">🎟 Tổng vé</div></div>
      <div class="stat"><div class="val" id="s-today">—</div><div class="lbl">✅ Hôm nay</div></div>
      <div class="stat"><div class="val" id="s-users">—</div><div class="lbl">👥 Khách hàng</div></div>
      <div class="stat"><div class="val" id="s-revenue">—</div><div class="lbl">💰 Doanh thu (đ)</div></div>
    </div>
    <div class="card">
      <h3>🕐 Vé đặt gần đây</h3>
      <div id="dash-recent"><div class="loading"><div class="spin"></div>Đang tải...</div></div>
    </div>
  </div>

  <!-- TAB: TẤT CẢ VÉ -->
  <div id="tab-all" class="tab">
    <div id="alert-all" class="alert"></div>
    <div class="card">
      <div class="filter-bar">
        <input type="text" id="f-search" placeholder="🔍 Tìm theo phim, khách hàng, ghế..." oninput="filterTickets()"/>
        <select id="f-type" onchange="filterTickets()">
          <option value="">Tất cả loại ghế</option>
          <option value="VIP">VIP</option>
          <option value="normal">Thường</option>
          <option value="couple">Couple</option>
        </select>
        <button class="btn btn-secondary" onclick="loadAllTickets()">🔄 Làm mới</button>
      </div>
      <div class="table-wrap">
        <table>
          <thead><tr>
            <th>#ID</th><th>Phim</th><th>Khách hàng</th><th>Ghế</th>
            <th>Ngày chiếu</th><th>Giờ</th><th>Rạp</th><th>Thao tác</th>
          </tr></thead>
          <tbody id="tbl-body"></tbody>
        </table>
        <div id="tbl-state"><div class="loading"><div class="spin"></div>Đang tải...</div></div>
      </div>
    </div>
  </div>

  <!-- TAB: ĐẶT VÉ -->
  <div id="tab-book" class="tab">
    <div id="alert-book" class="alert"></div>
    <div class="two-col">
      <div>
        <div class="card">
          <h3>Thông tin đặt vé</h3>
          <div class="form-group"><label>User ID *</label><input type="number" id="b-uid" placeholder="Ví dụ: 1" min="1"/></div>
          <div class="form-group"><label>Showtime ID *</label><input type="number" id="b-sid" placeholder="Ví dụ: 1" min="1"/></div>
          <button class="btn btn-secondary" style="width:100%" onclick="loadSeats()">🗺 Xem sơ đồ ghế</button>
        </div>
        <div class="card" id="confirm-box" style="display:none">
          <h3>✅ Xác nhận đặt vé</h3>
          <div class="confirm-grid">
            <div class="ci"><div class="lbl">User ID</div><div class="val" id="c-uid">—</div></div>
            <div class="ci"><div class="lbl">Showtime ID</div><div class="val" id="c-sid">—</div></div>
            <div class="ci"><div class="lbl">Ghế đã chọn</div><div class="val" id="c-seat">—</div></div>
            <div class="ci"><div class="lbl">Loại — Giá</div><div class="val" id="c-type">—</div></div>
          </div>
          <button class="btn btn-primary" style="width:100%" id="btn-book" onclick="doBook()" disabled>🎟 Xác nhận đặt vé</button>
        </div>
      </div>
      <div class="card" id="seat-card" style="display:none">
        <h3>Sơ đồ ghế — Showtime <span id="sm-sid" style="color:#e8b84b"></span></h3>
        <div class="screen">✦ MÀN HÌNH ✦</div>
        <div class="rows" id="seat-rows"></div>
        <div class="legend">
          <div class="legend-item"><div class="leg-sq av"></div>Còn trống</div>
          <div class="legend-item"><div class="leg-sq bk"></div>Đã đặt</div>
          <div class="legend-item"><div class="leg-sq sl"></div>Đang chọn</div>
        </div>
      </div>
    </div>
  </div>

  <!-- TAB: LỊCH SỬ -->
  <div id="tab-history" class="tab">
    <div class="history-wrap">
      <div class="history-sidebar">
        <h3>Tra cứu theo User</h3>
        <div class="form-group">
          <label>User ID</label>
          <input type="number" id="h-uid" placeholder="Ví dụ: 1" min="1" onkeydown="if(event.key==='Enter')doHistory()"/>
        </div>
        <button class="btn btn-primary" style="width:100%" onclick="doHistory()">Tra cứu</button>
        <div id="alert-history" class="alert" style="margin-top:12px"></div>
        <div id="h-summary" style="display:none;margin-top:12px;padding:10px;background:rgba(232,184,75,.1);border-radius:6px;font-size:0.82rem;border:1px solid rgba(232,184,75,.2)">
          Tìm thấy <strong style="color:#e8b84b" id="h-count">0</strong> vé
        </div>
      </div>
      <div>
        <div id="h-result"><div class="empty">Nhập User ID để tra cứu</div></div>
      </div>
    </div>
  </div>

</div><!-- end app-content -->

<!-- MODAL CHI TIẾT -->
<div class="modal-overlay" id="m-detail">
  <div class="modal">
    <h3>🎟 Chi tiết vé #<span id="md-id"></span></h3>
    <p>Thông tin đầy đủ về vé đặt này</p>
    <div class="modal-info" id="md-info"></div>
    <div class="modal-btns">
      <button class="btn btn-secondary" onclick="closeModal('m-detail')">Đóng</button>
      <button class="btn btn-danger" onclick="closeModal('m-detail');openDelModal(curDetailId)">🗑 Hủy vé</button>
    </div>
  </div>
</div>

<!-- MODAL HỦY VÉ -->
<div class="modal-overlay" id="m-delete">
  <div class="modal">
    <h3>⚠️ Xác nhận hủy vé</h3>
    <p>Bạn có chắc muốn hủy vé <strong style="color:#ff5c5c">#<span id="del-id"></span></strong>?<br/>Hành động này <strong>không thể hoàn tác</strong>.</p>
    <div class="modal-btns">
      <button class="btn btn-secondary" onclick="closeModal('m-delete')">Không, giữ lại</button>
      <button class="btn btn-danger" onclick="doDelete()">✓ Xác nhận hủy</button>
    </div>
  </div>
</div>

<script>
const API = 'http://localhost/qlrcp/controllers/bookingController.php';
let allTickets = [], selectedSeatId = null, selectedSeatNum = '', selectedSeatType = '', selectedSeatPrice = 0;
let delTicketId = null, curDetailId = null;

function switchTab(name, btn) {
  document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  document.getElementById('tab-' + name).classList.add('active');
  btn.classList.add('active');
  if (name === 'dashboard') loadDashboard();
  if (name === 'all') loadAllTickets();
}
function showAlert(id, msg, type) {
  const el = document.getElementById(id);
  el.innerHTML = (type === 'success' ? '✅ ' : '❌ ') + msg;
  el.className = 'alert ' + type + ' show';
  setTimeout(() => el.classList.remove('show'), 5000);
}
async function apiFetch(url, opts = {}) { return (await fetch(url, opts)).json(); }

// DASHBOARD
async function loadDashboard() {
  document.getElementById('dash-recent').innerHTML = '<div class="loading"><div class="spin"></div>Đang tải...</div>';
  try {
    const data = await apiFetch(API);
    const tickets = data.tickets || [];
    allTickets = tickets;
    document.getElementById('s-total').textContent = tickets.length;
    const today = new Date().toISOString().slice(0,10);
    document.getElementById('s-today').textContent = tickets.filter(t=>(t.booking_time||'').startsWith(today)).length;
    document.getElementById('s-users').textContent = new Set(tickets.map(t=>t.user_id)).size;
    const rev = tickets.reduce((s,t)=>s+Number(t.seat_price||0),0);
    document.getElementById('s-revenue').textContent = rev.toLocaleString();
    const recent = tickets.slice(0,5);
    if (!recent.length) { document.getElementById('dash-recent').innerHTML='<div class="empty">Chưa có vé nào</div>'; return; }
    document.getElementById('dash-recent').innerHTML = `<div class="table-wrap"><table>
      <thead><tr><th>#ID</th><th>Phim</th><th>Khách hàng</th><th>Ghế</th><th>Thời gian đặt</th></tr></thead>
      <tbody>${recent.map(t=>`<tr>
        <td class="ticket-id">#${t.ticket_id}</td><td><strong>${t.movie_title||'N/A'}</strong></td>
        <td>${t.username||'—'}</td><td>${t.seat_number||'—'}</td>
        <td style="color:#7070a0;font-size:.82rem">${(t.booking_time||'—').slice(0,16)}</td>
      </tr>`).join('')}</tbody></table></div>`;
  } catch(e) { document.getElementById('dash-recent').innerHTML='<div class="empty">❌ Không kết nối được API</div>'; }
}

// ALL TICKETS
async function loadAllTickets() {
  document.getElementById('tbl-body').innerHTML='';
  document.getElementById('tbl-state').innerHTML='<div class="loading"><div class="spin"></div>Đang tải...</div>';
  document.getElementById('tbl-state').style.display='block';
  try {
    const data = await apiFetch(API);
    allTickets = data.tickets || [];
    renderTable(allTickets);
  } catch(e) { document.getElementById('tbl-state').innerHTML='<div class="empty">❌ Không kết nối được API</div>'; }
}
function renderTable(list) {
  const tbody = document.getElementById('tbl-body'), state = document.getElementById('tbl-state');
  if (!list.length) { tbody.innerHTML=''; state.innerHTML='<div class="empty">Không tìm thấy vé nào</div>'; state.style.display='block'; return; }
  state.style.display='none';
  tbody.innerHTML = list.map(t=>`<tr id="row-${t.ticket_id}">
    <td class="ticket-id">#${t.ticket_id}</td>
    <td><strong>${t.movie_title||'N/A'}</strong></td>
    <td>${t.username||'—'}</td>
    <td>${t.seat_number||'—'} <span class="badge badge-${(t.seat_type||'normal').toLowerCase()}">${t.seat_type||'—'}</span></td>
    <td>${t.show_date||'—'}</td><td>${t.start_time||'—'}</td><td>${t.cinema_name||'—'}</td>
    <td><div class="actions">
      <button class="btn btn-sm btn-secondary" onclick="openDetailModal(${t.ticket_id})">👁</button>
      <button class="btn btn-sm btn-danger" onclick="openDelModal(${t.ticket_id})">🗑</button>
    </div></td></tr>`).join('');
}
function filterTickets() {
  const q=document.getElementById('f-search').value.toLowerCase(), type=document.getElementById('f-type').value.toLowerCase();
  renderTable(allTickets.filter(t=>{
    const mq=!q||(t.movie_title||'').toLowerCase().includes(q)||(t.username||'').toLowerCase().includes(q)||(t.seat_number||'').toLowerCase().includes(q);
    const mt=!type||(t.seat_type||'').toLowerCase()===type;
    return mq&&mt;
  }));
}

// BOOK
async function loadSeats() {
  const sid=document.getElementById('b-sid').value;
  if(!sid){showAlert('alert-book','Vui lòng nhập Showtime ID!','error');return;}
  const card=document.getElementById('seat-card'), rows=document.getElementById('seat-rows');
  card.style.display='block'; document.getElementById('sm-sid').textContent=sid;
  rows.innerHTML='<div class="loading"><div class="spin"></div>Đang tải...</div>';
  document.getElementById('confirm-box').style.display='none'; selectedSeatId=null;
  try {
    const data=await apiFetch(`${API}?showtime_id=${sid}`);
    if(!data.status){showAlert('alert-book',data.message,'error');card.style.display='none';return;}
    buildSeats(data.seats);
  } catch(e){showAlert('alert-book','Không kết nối được API!','error');card.style.display='none';}
}
function buildSeats(seats) {
  const rows={};
  seats.forEach(s=>{const r=s.seat_number[0];if(!rows[r])rows[r]=[];rows[r].push(s);});
  document.getElementById('seat-rows').innerHTML=Object.keys(rows).sort().map(r=>`
    <div class="srow"><div class="row-lbl">${r}</div>
    ${rows[r].map(s=>`<div class="seat ${s.status==='booked'?'bk':'av'}" id="s-${s.seat_id}"
      title="${s.seat_number} — ${s.seat_type} — ${Number(s.price||0).toLocaleString()}đ"
      onclick="pickSeat(${s.seat_id},'${s.seat_number}','${s.seat_type}',${s.price},'${s.status}')">
      ${s.seat_number.slice(1)}</div>`).join('')}
    </div>`).join('');
}
function pickSeat(id,num,type,price,status) {
  if(status==='booked')return;
  if(selectedSeatId){const p=document.getElementById('s-'+selectedSeatId);if(p)p.className=p.className.replace('sl','av');}
  selectedSeatId=id;selectedSeatNum=num;selectedSeatType=type;selectedSeatPrice=price;
  document.getElementById('s-'+id).className=document.getElementById('s-'+id).className.replace('av','sl');
  document.getElementById('c-uid').textContent=document.getElementById('b-uid').value||'—';
  document.getElementById('c-sid').textContent=document.getElementById('b-sid').value||'—';
  document.getElementById('c-seat').textContent=num;
  document.getElementById('c-type').textContent=type+' — '+Number(price).toLocaleString()+'đ';
  document.getElementById('confirm-box').style.display='block';
  document.getElementById('btn-book').disabled=false;
}
async function doBook() {
  const uid=document.getElementById('b-uid').value, sid=document.getElementById('b-sid').value;
  if(!uid){showAlert('alert-book','Vui lòng nhập User ID!','error');return;}
  if(!selectedSeatId){showAlert('alert-book','Vui lòng chọn ghế!','error');return;}
  const btn=document.getElementById('btn-book');
  btn.disabled=true; btn.textContent='⏳ Đang xử lý...';
  try {
    const data=await apiFetch(API,{method:'POST',headers:{'Content-Type':'application/json'},
      body:JSON.stringify({showtime_id:parseInt(sid),seat_id:selectedSeatId,user_id:parseInt(uid)})});
    if(data.status){
      showAlert('alert-book',`Đặt vé thành công! Ticket #${data.ticket.ticket_id}`,'success');
      const el=document.getElementById('s-'+selectedSeatId);
      if(el){el.className=el.className.replace('sl','bk');el.onclick=null;}
      selectedSeatId=null; document.getElementById('confirm-box').style.display='none';
    } else showAlert('alert-book',data.message,'error');
  } catch(e){showAlert('alert-book','Lỗi kết nối API!','error');}
  btn.textContent='🎟 Xác nhận đặt vé'; btn.disabled=false;
}

// HISTORY
async function doHistory() {
  const uid=document.getElementById('h-uid').value;
  if(!uid){showAlert('alert-history','Vui lòng nhập User ID!','error');return;}
  document.getElementById('h-result').innerHTML='<div class="loading"><div class="spin"></div>Đang tải...</div>';
  document.getElementById('h-summary').style.display='none';
  try {
    const data=await apiFetch(`${API}?user_id=${uid}`);
    if(!data.status){document.getElementById('h-result').innerHTML=`<div class="empty">⚠️ ${data.message}</div>`;return;}
    document.getElementById('h-summary').style.display='block';
    document.getElementById('h-count').textContent=data.count;
    if(!data.count){document.getElementById('h-result').innerHTML='<div class="empty">User này chưa đặt vé nào</div>';return;}
    document.getElementById('h-result').innerHTML=`<div class="history-result">${(data.tickets||[]).map(t=>`
      <div class="ticket-card">
        <div class="tc-movie">${t.movie_title||'N/A'}</div>
        <div class="tc-grid">
          <div class="tc-item"><span class="lbl">Ghế</span><span class="val">${t.seat_number||'—'} (${t.seat_type||'—'})</span></div>
          <div class="tc-item"><span class="lbl">Giá</span><span class="val" style="color:#e8b84b">${Number(t.seat_price||0).toLocaleString()}đ</span></div>
          <div class="tc-item"><span class="lbl">Ngày chiếu</span><span class="val">${t.show_date||'—'}</span></div>
          <div class="tc-item"><span class="lbl">Giờ chiếu</span><span class="val">${t.start_time||'—'}</span></div>
          <div class="tc-item"><span class="lbl">Rạp</span><span class="val">${t.cinema_name||'—'}</span></div>
          <div class="tc-item"><span class="lbl">Ticket</span><span class="val" style="color:#e8b84b">#${t.ticket_id}</span></div>
        </div>
        <div class="tc-actions">
          <button class="btn btn-sm btn-secondary" style="flex:1" onclick="openDetailModal(${t.ticket_id})">👁 Chi tiết</button>
          <button class="btn btn-sm btn-danger" onclick="openDelModal(${t.ticket_id})">🗑 Hủy</button>
        </div>
      </div>`).join('')}</div>`;
  } catch(e){document.getElementById('h-result').innerHTML='<div class="empty">❌ Lỗi kết nối API</div>';}
}

// MODALS
async function openDetailModal(id) {
  curDetailId=id; document.getElementById('md-id').textContent=id;
  document.getElementById('md-info').innerHTML='<div style="text-align:center;padding:12px;color:#7070a0">Đang tải...</div>';
  document.getElementById('m-detail').classList.add('show');
  try {
    const data=await apiFetch(`${API}?ticket_id=${id}`);
    if(!data.status){document.getElementById('md-info').innerHTML='<div style="color:#ff5c5c">Không tìm thấy vé</div>';return;}
    const t=data.ticket;
    document.getElementById('md-info').innerHTML=[
      ['Ticket ID','#'+t.ticket_id],['Khách hàng',t.username||'—'],
      ['Email',t.email||'—'],['SĐT',t.phone||'—'],
      ['Phim',t.movie_title||'—'],['Thể loại',t.genre||'—'],
      ['Ngày chiếu',t.show_date||'—'],['Giờ chiếu',t.start_time||'—'],
      ['Ghế',t.seat_number||'—'],['Loại ghế',t.seat_type||'—'],
      ['Giá vé',Number(t.seat_price||0).toLocaleString()+'đ'],['Phòng',t.theater_name||'—'],
      ['Rạp',t.cinema_name||'—'],['Địa điểm',t.cinema_location||'—'],
    ].map(([l,v])=>`<div class="mi"><div class="lbl">${l}</div><div class="val">${v}</div></div>`).join('');
  } catch(e){document.getElementById('md-info').innerHTML='<div style="color:#ff5c5c">Lỗi kết nối</div>';}
}
function openDelModal(id){delTicketId=id;document.getElementById('del-id').textContent=id;document.getElementById('m-delete').classList.add('show');}
function closeModal(id){document.getElementById(id).classList.remove('show');}
async function doDelete() {
  if(!delTicketId)return;
  closeModal('m-delete');
  try {
    const data=await apiFetch(API,{method:'DELETE',headers:{'Content-Type':'application/json'},body:JSON.stringify({ticket_id:delTicketId})});
    if(data.status){
      showAlert('alert-all',`Hủy vé #${delTicketId} thành công!`,'success');
      const el=document.getElementById('row-'+delTicketId);
      if(el){el.style.opacity='0';el.style.transition='.3s';setTimeout(()=>el.remove(),300);}
      allTickets=allTickets.filter(t=>t.ticket_id!=delTicketId);
      document.getElementById('s-total').textContent=allTickets.length;
    } else showAlert('alert-all',data.message,'error');
  } catch(e){showAlert('alert-all','Lỗi kết nối API!','error');}
  delTicketId=null;
}

loadDashboard();
</script>
</body>
</html>
