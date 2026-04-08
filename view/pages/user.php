<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>CinemaX — Đặt vé phim</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;600;700&display=swap');
*{margin:0;padding:0;box-sizing:border-box;}
:root{
  --gold:#e8b84b;--gold-dk:#c9992e;--bg:#0d0d1a;--surface:#141428;
  --card:#1c1c38;--border:#252545;--text:#e8e8f0;--muted:#7070a0;
  --green:#3ddc84;--red:#ff5c5c;--blue:#5b8dee;--pink:#ec4899;
}
body{font-family:'DM Sans',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;}

/* ── AUTH ── */
.auth-screen{min-height:100vh;background:radial-gradient(ellipse at 30% 50%,rgba(232,184,75,.07),transparent 60%),var(--bg);
  display:flex;align-items:center;justify-content:center;padding:16px;}
.auth-box{background:var(--card);border-radius:16px;padding:36px 32px;width:100%;max-width:400px;
  border:1px solid var(--border);box-shadow:0 30px 80px rgba(0,0,0,.4);}
.auth-logo{text-align:center;margin-bottom:28px;}
.auth-logo .name{font-family:'Bebas Neue',cursive;font-size:2.2rem;color:var(--gold);letter-spacing:3px;}
.auth-logo .name span{color:var(--text);}
.auth-logo .sub{font-size:0.72rem;color:var(--muted);letter-spacing:4px;margin-top:4px;}
.auth-tabs{display:flex;background:var(--bg);border-radius:8px;padding:3px;margin-bottom:24px;border:1px solid var(--border);}
.auth-tab{flex:1;padding:9px;border:none;background:none;color:var(--muted);font-size:0.875rem;
  font-weight:600;border-radius:6px;cursor:pointer;transition:.2s;font-family:'DM Sans',sans-serif;}
.auth-tab.active{background:var(--gold);color:#0d0d1a;}
.auth-form{display:none;}
.auth-form.active{display:block;}
.form-group{margin-bottom:14px;}
.form-group label{display:block;font-size:0.72rem;font-weight:700;color:var(--muted);
  text-transform:uppercase;letter-spacing:.4px;margin-bottom:6px;}
.form-group input{width:100%;padding:10px 13px;background:var(--bg);border:1px solid var(--border);
  color:var(--text);border-radius:8px;font-size:0.9rem;outline:none;transition:border .2s;font-family:'DM Sans',sans-serif;}
.form-group input:focus{border-color:var(--gold);}
.form-group input::placeholder{color:var(--muted);}
.btn-auth{width:100%;padding:12px;background:var(--gold);color:#0d0d1a;border:none;border-radius:8px;
  font-size:0.95rem;font-weight:700;cursor:pointer;margin-top:4px;transition:.2s;font-family:'DM Sans',sans-serif;}
.btn-auth:hover{background:var(--gold-dk);}
.auth-alert{padding:9px 13px;border-radius:8px;font-size:0.83rem;margin-bottom:12px;display:none;}
.auth-alert.show{display:block;}
.auth-alert.err{background:rgba(255,92,92,.1);border:1px solid rgba(255,92,92,.3);color:var(--red);}
.auth-alert.ok{background:rgba(61,220,132,.1);border:1px solid rgba(61,220,132,.3);color:var(--green);}

/* ── APP ── */
.auth-screen.hide{display:none;}
.app{display:none;}
.app.show{display:block;}

/* ── HEADER ── */
.header{background:var(--surface);border-bottom:1px solid var(--border);
  padding:0 28px;height:58px;display:flex;align-items:center;justify-content:space-between;
  position:sticky;top:0;z-index:100;}
.logo{font-family:'Bebas Neue',cursive;font-size:1.5rem;letter-spacing:2px;color:var(--gold);}
.logo span{color:var(--text);}
.header-nav{display:flex;align-items:center;gap:8px;}
.header-nav button{background:none;border:none;color:var(--muted);padding:7px 14px;border-radius:8px;
  cursor:pointer;font-size:0.85rem;font-weight:600;transition:.15s;font-family:'DM Sans',sans-serif;}
.header-nav button:hover{background:rgba(255,255,255,.07);color:var(--text);}
.header-nav button.active{background:rgba(232,184,75,.15);color:var(--gold);}
.user-info{display:flex;align-items:center;gap:10px;}
.user-avatar{width:32px;height:32px;border-radius:50%;background:var(--gold);
  display:flex;align-items:center;justify-content:center;font-size:0.8rem;font-weight:bold;color:#0d0d1a;}
.user-name{font-size:0.85rem;color:var(--muted);}
.btn-logout{background:none;border:1px solid var(--border);color:var(--muted);padding:5px 12px;
  border-radius:6px;cursor:pointer;font-size:0.8rem;transition:.15s;font-family:'DM Sans',sans-serif;}
.btn-logout:hover{border-color:var(--gold);color:var(--gold);}

/* ── PAGES ── */
.page{display:none;padding:28px 24px;max-width:1200px;margin:0 auto;}
.page.active{display:block;}

/* ── STEP BAR ── */
.step-bar{display:flex;align-items:center;margin-bottom:32px;background:var(--card);
  border-radius:12px;padding:16px 22px;border:1px solid var(--border);overflow-x:auto;gap:0;}
.step-item{display:flex;align-items:center;gap:8px;flex-shrink:0;}
.step-circle{width:28px;height:28px;border-radius:50%;border:2px solid var(--border);
  display:flex;align-items:center;justify-content:center;font-size:0.72rem;font-weight:bold;
  color:var(--muted);background:var(--bg);transition:.2s;}
.step-circle.done{background:var(--gold);border-color:var(--gold);color:#0d0d1a;}
.step-circle.active{border-color:var(--gold);color:var(--gold);}
.step-label{font-size:0.78rem;color:var(--muted);white-space:nowrap;}
.step-label.active{color:var(--gold);font-weight:700;}
.step-label.done{color:var(--text);}
.step-arrow{color:var(--border);margin:0 8px;font-size:0.8rem;}

/* ── SECTION TITLE ── */
.sec-title{font-family:'Bebas Neue',cursive;font-size:1.6rem;letter-spacing:1px;color:var(--text);margin-bottom:18px;}
.sec-title span{color:var(--gold);}

/* ── BUTTONS ── */
.btn{padding:10px 20px;border-radius:8px;cursor:pointer;font-size:0.875rem;font-weight:600;
  border:1px solid;transition:.15s;font-family:'DM Sans',sans-serif;}
.btn-primary{background:var(--gold);color:#0d0d1a;border-color:var(--gold);}
.btn-primary:hover{background:var(--gold-dk);}
.btn-primary:disabled{opacity:.4;cursor:not-allowed;}
.btn-secondary{background:transparent;color:var(--text);border-color:var(--border);}
.btn-secondary:hover{border-color:var(--gold);color:var(--gold);}
.btn-danger{background:transparent;color:var(--red);border-color:rgba(255,92,92,.3);}
.btn-danger:hover{background:rgba(255,92,92,.1);}
.btn-sm{padding:5px 11px;font-size:0.75rem;}

/* ── MOVIE GRID ── */
.movie-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:16px;margin-bottom:24px;}
.movie-card{background:var(--card);border-radius:12px;overflow:hidden;cursor:pointer;
  border:2px solid var(--border);transition:.2s;}
.movie-card:hover{transform:translateY(-4px);border-color:rgba(232,184,75,.4);}
.movie-card.selected{border-color:var(--gold);}
.movie-poster-placeholder{width:100%;height:220px;background:linear-gradient(135deg,var(--surface),var(--card));
  display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;}
.movie-poster-placeholder .icon{font-size:2.5rem;}
.movie-poster-placeholder .genre{font-size:0.68rem;color:var(--muted);text-transform:uppercase;letter-spacing:1px;}
.movie-poster-real{width:100%;height:220px;object-fit:cover;}
.movie-info{padding:12px;}
.movie-title{font-size:0.875rem;font-weight:700;color:var(--text);margin-bottom:6px;line-height:1.3;}
.movie-meta{display:flex;gap:5px;flex-wrap:wrap;}
.tag{font-size:0.65rem;padding:2px 7px;border-radius:20px;font-weight:600;}
.tag-genre{background:rgba(255,255,255,.07);color:var(--muted);}
.tag-lang{background:rgba(91,141,238,.15);color:var(--blue);}
.tag-dur{background:rgba(61,220,132,.1);color:var(--green);}
.movie-rating{font-size:0.75rem;color:var(--gold);font-weight:700;margin-top:5px;}

/* ── CINEMA LIST ── */
.cinema-list{display:flex;flex-direction:column;gap:10px;margin-bottom:24px;}
.cinema-card{background:var(--card);border-radius:12px;padding:16px 18px;cursor:pointer;
  border:2px solid var(--border);display:flex;align-items:center;gap:14px;transition:.15s;}
.cinema-card:hover,.cinema-card.selected{border-color:var(--gold);background:rgba(232,184,75,.05);}
.cinema-icon{width:44px;height:44px;background:var(--surface);border-radius:10px;border:1px solid var(--border);
  display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0;}
.cinema-name{font-size:0.95rem;font-weight:700;}
.cinema-location{font-size:0.8rem;color:var(--muted);margin-top:2px;}

/* ── SHOWTIME ── */
.showtime-dates{display:flex;gap:8px;margin-bottom:16px;flex-wrap:wrap;}
.date-btn{padding:7px 14px;border-radius:8px;border:1px solid var(--border);background:var(--card);
  font-size:0.82rem;cursor:pointer;font-weight:600;color:var(--muted);transition:.15s;font-family:'DM Sans',sans-serif;}
.date-btn:hover{border-color:var(--gold);color:var(--gold);}
.date-btn.active{background:var(--gold);border-color:var(--gold);color:#0d0d1a;}
.showtime-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:12px;margin-bottom:24px;}
.showtime-card{background:var(--card);border-radius:12px;padding:14px 16px;cursor:pointer;
  border:2px solid var(--border);transition:.15s;}
.showtime-card:hover,.showtime-card.selected{border-color:var(--gold);background:rgba(232,184,75,.05);}
.st-time{font-family:'Bebas Neue',cursive;font-size:1.8rem;color:var(--text);letter-spacing:.5px;}
.st-room{font-size:0.8rem;color:var(--muted);margin-top:3px;}
.st-type{display:inline-block;font-size:0.65rem;padding:2px 7px;border-radius:20px;font-weight:700;margin-top:5px;}
.st-type.t2d{background:rgba(91,141,238,.15);color:var(--blue);}
.st-type.t3d{background:rgba(61,220,132,.1);color:var(--green);}
.st-type.timax{background:rgba(232,184,75,.15);color:var(--gold);}
.st-type.t4dx{background:rgba(236,72,153,.1);color:var(--pink);}
.st-price{font-size:0.82rem;color:var(--gold);font-weight:700;margin-top:5px;}

/* ── SEAT MAP ── */
.seat-section{background:var(--card);border-radius:12px;padding:22px;border:1px solid var(--border);margin-bottom:20px;}
.screen-wrap{text-align:center;margin-bottom:24px;}
.screen{display:inline-block;padding:7px 80px;border-top:3px solid var(--gold);
  background:linear-gradient(180deg,rgba(232,184,75,.15),transparent);
  font-size:0.68rem;letter-spacing:6px;color:var(--gold);font-weight:700;border-radius:0 0 50% 50%;}
.seat-legend{display:flex;gap:18px;flex-wrap:wrap;margin-bottom:20px;justify-content:center;}
.leg-item{display:flex;align-items:center;gap:6px;font-size:0.75rem;color:var(--muted);}
.leg-box{width:22px;height:18px;border-radius:4px 4px 2px 2px;border:1px solid;
  display:flex;align-items:center;justify-content:center;font-size:0.58rem;font-weight:bold;}
.leg-box.vip{background:rgba(232,184,75,.15);border-color:var(--gold);color:var(--gold);}
.leg-box.normal{background:rgba(61,220,132,.1);border-color:rgba(61,220,132,.5);color:var(--green);}
.leg-box.couple{background:rgba(236,72,153,.1);border-color:rgba(236,72,153,.4);color:var(--pink);}
.leg-box.booked{background:rgba(255,255,255,.04);border-color:var(--border);color:var(--muted);}
.leg-box.selected{background:rgba(232,184,75,.2);border-color:var(--gold);color:var(--gold);}
.seat-rows{display:flex;flex-direction:column;gap:6px;align-items:center;margin-bottom:16px;}
.seat-row{display:flex;gap:5px;align-items:center;}
.row-lbl{width:18px;text-align:center;font-size:0.65rem;color:var(--muted);font-weight:700;flex-shrink:0;}
.seat{width:38px;height:34px;border-radius:6px 6px 3px 3px;border:1px solid;cursor:pointer;
  font-size:0.62rem;font-weight:700;display:flex;align-items:center;justify-content:center;transition:.12s;}
.seat.vip.av{background:rgba(232,184,75,.1);border-color:rgba(232,184,75,.4);color:var(--gold);}
.seat.normal.av{background:rgba(61,220,132,.08);border-color:rgba(61,220,132,.35);color:var(--green);}
.seat.couple.av{background:rgba(236,72,153,.08);border-color:rgba(236,72,153,.35);color:var(--pink);min-width:60px;}
.seat.av:hover{transform:scale(1.12);}
.seat.bk{background:rgba(255,255,255,.03);border-color:var(--border);color:var(--muted);cursor:not-allowed;opacity:.5;}
.seat.selected{background:rgba(232,184,75,.25);border-color:var(--gold);color:var(--gold);transform:scale(1.1);}

/* ── ORDER SUMMARY ── */
.order-summary{background:var(--bg);border-radius:10px;padding:16px;border:1px solid var(--border);margin-top:16px;}
.order-summary h4{font-size:0.82rem;color:var(--muted);text-transform:uppercase;letter-spacing:.4px;margin-bottom:12px;}
.seat-tags{display:flex;flex-wrap:wrap;gap:6px;margin-bottom:12px;}
.seat-tag{background:rgba(232,184,75,.15);color:var(--gold);padding:4px 10px;border-radius:20px;
  font-size:0.75rem;font-weight:700;border:1px solid rgba(232,184,75,.3);}
.order-total{font-size:1.1rem;font-weight:700;color:var(--gold);}

/* ── CONFIRM PAGE ── */
.confirm-card{background:var(--card);border-radius:12px;padding:22px;border:1px solid var(--border);max-width:600px;}
.confirm-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:20px;}
.ci{background:var(--bg);border-radius:8px;padding:11px 14px;border:1px solid var(--border);}
.ci .lbl{font-size:0.65rem;color:var(--muted);text-transform:uppercase;letter-spacing:.3px;margin-bottom:3px;}
.ci .val{font-size:0.875rem;font-weight:700;}
.ci.full{grid-column:span 2;}
.cf-total{font-family:'Bebas Neue',cursive;font-size:1.8rem;color:var(--gold);margin-bottom:16px;}

/* ── SUCCESS ── */
.success-screen{text-align:center;padding:40px 20px;}
.success-icon{font-size:4rem;margin-bottom:16px;}
.success-title{font-family:'Bebas Neue',cursive;font-size:2.5rem;color:var(--green);letter-spacing:2px;margin-bottom:8px;}
.success-sub{color:var(--muted);font-size:0.9rem;margin-bottom:28px;}
.success-card{background:var(--card);border-radius:14px;padding:22px;max-width:500px;
  margin:0 auto 28px;border:1px solid var(--border);border-top:3px solid var(--gold);}
.success-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;text-align:left;}
.success-grid .si .lbl{font-size:0.65rem;color:var(--muted);text-transform:uppercase;letter-spacing:.3px;margin-bottom:3px;}
.success-grid .si .val{font-size:0.875rem;font-weight:700;}
.success-grid .si .val.gold{color:var(--gold);}

/* ── MY TICKETS ── */
.ticket-list{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:14px;}
.ticket-card{background:var(--card);border-radius:12px;padding:16px;border:1px solid var(--border);border-left:3px solid var(--gold);}
.tc-id{font-family:'Bebas Neue',cursive;font-size:1rem;color:var(--gold);margin-bottom:6px;}
.tc-movie{font-weight:700;font-size:0.95rem;margin-bottom:10px;}
.tc-grid{display:grid;grid-template-columns:1fr 1fr;gap:6px;margin-bottom:12px;}
.tc-item .lbl{font-size:0.65rem;color:var(--muted);display:block;text-transform:uppercase;letter-spacing:.3px;}
.tc-item .val{font-size:0.82rem;font-weight:600;}
.badge{display:inline-block;padding:2px 7px;border-radius:20px;font-size:0.65rem;font-weight:700;}
.badge-vip{background:rgba(232,184,75,.15);color:var(--gold);}
.badge-normal{background:rgba(255,255,255,.07);color:var(--muted);}
.badge-couple{background:rgba(236,72,153,.1);color:var(--pink);}

/* ── MISC ── */
.alert{padding:10px 14px;border-radius:8px;margin-bottom:14px;font-size:0.875rem;display:none;}
.alert.show{display:flex;align-items:center;gap:8px;}
.alert.success{background:rgba(61,220,132,.1);border:1px solid rgba(61,220,132,.3);color:var(--green);}
.alert.error{background:rgba(255,92,92,.1);border:1px solid rgba(255,92,92,.3);color:var(--red);}
.loading,.empty-state{text-align:center;padding:40px;color:var(--muted);font-size:0.9rem;}
.spin{width:28px;height:28px;border:2px solid var(--border);border-top-color:var(--gold);
  border-radius:50%;animation:spin .8s linear infinite;margin:0 auto 10px;}
@keyframes spin{to{transform:rotate(360deg)}}

@media(max-width:768px){.movie-grid{grid-template-columns:repeat(auto-fill,minmax(150px,1fr));}
  .confirm-grid{grid-template-columns:1fr;} .ci.full{grid-column:span 1;}}

    /* ── FOOD STEP ── */
    .food-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:14px;margin-bottom:20px;}
    .food-card{background:var(--card);border-radius:12px;padding:16px;border:2px solid var(--border);
      cursor:pointer;transition:.15s;position:relative;}
    .food-card:hover{border-color:rgba(232,184,75,.4);}
    .food-card.selected{border-color:var(--gold);background:rgba(232,184,75,.06);}
    .food-icon{font-size:2.2rem;margin-bottom:8px;text-align:center;}
    .food-name{font-size:0.9rem;font-weight:700;margin-bottom:4px;}
    .food-desc{font-size:0.72rem;color:var(--muted);margin-bottom:8px;line-height:1.4;}
    .food-price{font-size:0.9rem;font-weight:700;color:var(--gold);}
    .food-cat{font-size:0.62rem;padding:2px 7px;border-radius:20px;font-weight:700;display:inline-block;margin-bottom:6px;}
    .food-cat.popcorn{background:rgba(251,191,36,.15);color:#fbbf24;}
    .food-cat.drink{background:rgba(59,130,246,.15);color:#3b82f6;}
    .food-cat.combo{background:rgba(232,184,75,.15);color:var(--gold);}
    .qty-ctrl{display:flex;align-items:center;gap:8px;margin-top:10px;justify-content:center;}
    .qty-btn{width:28px;height:28px;border-radius:50%;border:1px solid var(--border);background:var(--bg);
      color:var(--text);cursor:pointer;font-size:1rem;display:flex;align-items:center;justify-content:center;transition:.15s;}
    .qty-btn:hover{border-color:var(--gold);color:var(--gold);}
    .qty-num{font-size:0.9rem;font-weight:700;min-width:20px;text-align:center;}
    .food-summary{background:var(--bg);border-radius:10px;padding:14px;border:1px solid var(--border);margin-top:16px;}
    .food-summary h4{font-size:0.78rem;color:var(--muted);text-transform:uppercase;letter-spacing:.4px;margin-bottom:10px;}
    .food-summary-row{display:flex;justify-content:space-between;font-size:0.82rem;padding:4px 0;border-bottom:1px solid var(--border);}
    .food-summary-row:last-child{border-bottom:none;font-weight:700;color:var(--gold);font-size:0.9rem;}
    .food-tabs{display:flex;gap:8px;margin-bottom:16px;flex-wrap:wrap;}
    .food-tab-btn{padding:6px 14px;border-radius:20px;border:1px solid var(--border);background:transparent;
      color:var(--muted);font-size:0.78rem;font-weight:600;cursor:pointer;transition:.15s;font-family:inherit;}
    .food-tab-btn.active{background:var(--gold);border-color:var(--gold);color:#0d0d1a;}

  </style>
  <link rel="stylesheet" href="../css/menu.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    .app-content-user{margin-top:60px;margin-left:220px;transition:.3s;}
    .app-content-user.collapsed{margin-left:70px;}
    .auth-screen{margin-top:60px;margin-left:220px;}
  
    /* ── FOOD STEP ── */
    .food-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:14px;margin-bottom:20px;}
    .food-card{background:var(--card);border-radius:12px;padding:16px;border:2px solid var(--border);
      cursor:pointer;transition:.15s;position:relative;}
    .food-card:hover{border-color:rgba(232,184,75,.4);}
    .food-card.selected{border-color:var(--gold);background:rgba(232,184,75,.06);}
    .food-icon{font-size:2.2rem;margin-bottom:8px;text-align:center;}
    .food-name{font-size:0.9rem;font-weight:700;margin-bottom:4px;}
    .food-desc{font-size:0.72rem;color:var(--muted);margin-bottom:8px;line-height:1.4;}
    .food-price{font-size:0.9rem;font-weight:700;color:var(--gold);}
    .food-cat{font-size:0.62rem;padding:2px 7px;border-radius:20px;font-weight:700;display:inline-block;margin-bottom:6px;}
    .food-cat.popcorn{background:rgba(251,191,36,.15);color:#fbbf24;}
    .food-cat.drink{background:rgba(59,130,246,.15);color:#3b82f6;}
    .food-cat.combo{background:rgba(232,184,75,.15);color:var(--gold);}
    .qty-ctrl{display:flex;align-items:center;gap:8px;margin-top:10px;justify-content:center;}
    .qty-btn{width:28px;height:28px;border-radius:50%;border:1px solid var(--border);background:var(--bg);
      color:var(--text);cursor:pointer;font-size:1rem;display:flex;align-items:center;justify-content:center;transition:.15s;}
    .qty-btn:hover{border-color:var(--gold);color:var(--gold);}
    .qty-num{font-size:0.9rem;font-weight:700;min-width:20px;text-align:center;}
    .food-summary{background:var(--bg);border-radius:10px;padding:14px;border:1px solid var(--border);margin-top:16px;}
    .food-summary h4{font-size:0.78rem;color:var(--muted);text-transform:uppercase;letter-spacing:.4px;margin-bottom:10px;}
    .food-summary-row{display:flex;justify-content:space-between;font-size:0.82rem;padding:4px 0;border-bottom:1px solid var(--border);}
    .food-summary-row:last-child{border-bottom:none;font-weight:700;color:var(--gold);font-size:0.9rem;}
    .food-tabs{display:flex;gap:8px;margin-bottom:16px;flex-wrap:wrap;}
    .food-tab-btn{padding:6px 14px;border-radius:20px;border:1px solid var(--border);background:transparent;
      color:var(--muted);font-size:0.78rem;font-weight:600;cursor:pointer;transition:.15s;font-family:inherit;}
    .food-tab-btn.active{background:var(--gold);border-color:var(--gold);color:#0d0d1a;}

  </style>
</head>
<body>
<?php include "../component/header.php"; ?>

<!-- AUTH SCREEN -->
<div style="margin-top:60px;margin-left:220px;transition:.3s" id="main-wrap"><div class="auth-screen" id="auth-screen">
  <div class="auth-box">
    <div class="auth-logo">
      <div class="name">CINEMA<span>X</span></div>
      <div class="sub">ĐẶT VÉ PHIM TRỰC TUYẾN</div>
    </div>
    <div class="auth-tabs">
      <button class="auth-tab active" onclick="switchAuth('login',this)">Đăng nhập</button>
      <button class="auth-tab" onclick="switchAuth('register',this)">Đăng ký</button>
    </div>
    <div id="auth-alert" class="auth-alert"></div>

    <!-- Login -->
    <div id="form-login" class="auth-form active">
      <div class="form-group"><label>Tên đăng nhập</label><input type="text" id="l-username" placeholder="username"/></div>
      <div class="form-group"><label>Mật khẩu</label><input type="password" id="l-password" placeholder="••••••••"/></div>
      <button class="btn-auth" onclick="doLogin()">Đăng nhập</button>
    </div>
    <!-- Register -->
    <div id="form-register" class="auth-form">
      <div class="form-group"><label>Tên đăng nhập</label><input type="text" id="r-username" placeholder="username"/></div>
      <div class="form-group"><label>Mật khẩu</label><input type="password" id="r-password" placeholder="••••••••"/></div>
      <div class="form-group"><label>Email</label><input type="email" id="r-email" placeholder="email@example.com"/></div>
      <div class="form-group"><label>Số điện thoại</label><input type="text" id="r-phone" placeholder="0123456789"/></div>
      <button class="btn-auth" onclick="doRegister()">Đăng ký</button>
    </div>
  </div>
</div>

<!-- APP (sau khi đăng nhập) -->
<div class="app" id="app">
  <div class="header">
    <div class="logo">CINEMA<span>X</span></div>
    <div class="header-nav">
      <button class="active" onclick="switchPage('booking',this)">🎬 Đặt vé</button>
      <button onclick="switchPage('my-tickets',this)">🎟 Vé của tôi</button>
    </div>
    <div class="user-info">
      <div class="user-avatar" id="uav">?</div>
      <span class="user-name" id="uname">—</span>
      <button class="btn-logout" onclick="doLogout()">Đăng xuất</button>
    </div>
  </div>

  <!-- PAGE: ĐẶT VÉ -->
  <div class="page active" id="page-booking">

    <!-- Step Bar -->
    <div class="step-bar" id="step-bar">
      <div class="step-item"><div class="step-circle active" id="sc1">1</div><span class="step-label active" id="sl1">Chọn phim</span></div>
      <div class="step-arrow">›</div>
      <div class="step-item"><div class="step-circle" id="sc2">2</div><span class="step-label" id="sl2">Chọn rạp</span></div>
      <div class="step-arrow">›</div>
      <div class="step-item"><div class="step-circle" id="sc3">3</div><span class="step-label" id="sl3">Suất chiếu</span></div>
      <div class="step-arrow">›</div>
      <div class="step-item"><div class="step-circle" id="sc4">4</div><span class="step-label" id="sl4">Chọn ghế</span></div>
      <div class="step-arrow">›</div>
      <div class="step-item"><div class="step-circle" id="sc5">5</div><span class="step-label" id="sl5">Đồ ăn</span></div>
      <div class="step-arrow">›</div>
      <div class="step-item"><div class="step-circle" id="sc6">6</div><span class="step-label" id="sl6">Xác nhận</span></div>
    </div>

    <!-- STEP 1: Chọn phim -->
    <div id="step-1">
      <div class="sec-title">Chọn <span>phim</span></div>
      <div id="movie-list"><div class="loading"><div class="spin"></div>Đang tải danh sách phim...</div></div>
    </div>

    <!-- STEP 2: Chọn rạp -->
    <div id="step-2" style="display:none">
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px">
        <button class="btn btn-secondary btn-sm" onclick="showStep(1)">← Quay lại</button>
        <div class="sec-title" style="margin:0">Chọn <span>rạp chiếu</span></div>
      </div>
      <div id="cinema-list"><div class="loading"><div class="spin"></div>Đang tải...</div></div>
    </div>

    <!-- STEP 3: Suất chiếu -->
    <div id="step-3" style="display:none">
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px">
        <button class="btn btn-secondary btn-sm" onclick="showStep(2)">← Quay lại</button>
        <div class="sec-title" style="margin:0">Chọn <span>suất chiếu</span></div>
      </div>
      <div class="showtime-dates" id="date-tabs"></div>
      <div id="showtime-list"><div class="loading"><div class="spin"></div>Đang tải...</div></div>
    </div>

    <!-- STEP 4: Chọn ghế -->
    <div id="step-4" style="display:none">
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px">
        <button class="btn btn-secondary btn-sm" onclick="showStep(3)">← Quay lại</button>
        <div class="sec-title" style="margin:0">Chọn <span>ghế ngồi</span></div>
      </div>
      <div class="seat-section">
        <div class="screen-wrap"><div class="screen">✦ MÀN HÌNH ✦</div></div>
        <div class="seat-legend">
          <div class="leg-item"><div class="leg-box vip">V</div>VIP</div>
          <div class="leg-item"><div class="leg-box normal">N</div>Thường</div>
          <div class="leg-item"><div class="leg-box couple">C</div>Couple</div>
          <div class="leg-item"><div class="leg-box booked">✕</div>Đã đặt</div>
          <div class="leg-item"><div class="leg-box selected">✓</div>Đang chọn</div>
        </div>
        <div class="seat-rows" id="seat-map"></div>
      </div>
      <div id="order-summary" class="order-summary" style="display:none">
        <h4>Ghế đã chọn</h4>
        <div class="seat-tags" id="selected-seat-tags"></div>
        <div class="order-total">Tổng: <span id="os-total-price">0đ</span></div>
      </div>
      <div id="alert-seats" class="alert" style="margin-top:14px"></div>
      <div style="margin-top:16px">
        <button class="btn btn-primary" id="btn-to-confirm" onclick="goToFood()" disabled>Tiếp tục → Chọn đồ ăn</button>
      </div>
    </div>

    <!-- STEP 5: Chọn đồ ăn -->
    <div id="step-5" style="display:none">
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px">
        <button class="btn btn-secondary btn-sm" onclick="showStep(4)">← Quay lại</button>
        <div class="sec-title" style="margin:0">Chọn <span>đồ ăn & thức uống</span></div>
        <span style="font-size:0.78rem;color:var(--muted);margin-left:4px">(không bắt buộc)</span>
      </div>

      <div class="food-tabs">
        <button class="food-tab-btn active" onclick="filterFood('all',this)">Tất cả</button>
        <button class="food-tab-btn" onclick="filterFood('combo',this)">🎁 Combo</button>
        <button class="food-tab-btn" onclick="filterFood('popcorn',this)">🍿 Bắp rang</button>
        <button class="food-tab-btn" onclick="filterFood('drink',this)">🥤 Nước uống</button>
      </div>

      <div id="food-list" class="food-grid">
        <div class="loading"><div class="spin"></div>Đang tải...</div>
      </div>

      <div class="food-summary" id="food-summary" style="display:none">
        <h4>🛒 Đồ ăn đã chọn</h4>
        <div id="food-summary-rows"></div>
        <div class="food-summary-row"><span>Tổng đồ ăn</span><span id="food-total-price">0đ</span></div>
      </div>

      <div id="alert-food" class="alert" style="margin-top:14px"></div>
      <div style="display:flex;gap:10px;margin-top:16px">
        <button class="btn btn-secondary" onclick="skipFood()">Bỏ qua, không chọn đồ ăn</button>
        <button class="btn btn-primary" onclick="goToConfirm()">Tiếp tục → Xác nhận</button>
      </div>
    </div>

    <!-- STEP 6: Xác nhận -->
    <div id="step-6" style="display:none">
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px">
        <button class="btn btn-secondary btn-sm" onclick="showStep(5)">← Quay lại</button>
        <div class="sec-title" style="margin:0">Xác nhận <span>đặt vé</span></div>
      </div>
      <div class="confirm-card">
        <div class="confirm-grid">
          <div class="ci full"><div class="lbl">Phim</div><div class="val" id="cf-movie">—</div></div>
          <div class="ci"><div class="lbl">Rạp</div><div class="val" id="cf-cinema">—</div></div>
          <div class="ci"><div class="lbl">Phòng</div><div class="val" id="cf-room">—</div></div>
          <div class="ci"><div class="lbl">Ngày chiếu</div><div class="val" id="cf-date">—</div></div>
          <div class="ci"><div class="lbl">Giờ chiếu</div><div class="val" id="cf-time">—</div></div>
          <div class="ci"><div class="lbl">Khách hàng</div><div class="val" id="cf-user">—</div></div>
          <div class="ci full"><div class="lbl">Ghế đã chọn</div><div class="seat-tags" id="cf-seat-tags" style="margin-top:6px"></div></div>
          <div class="ci full"><div class="lbl">Đồ ăn & thức uống</div><div class="seat-tags" id="cf-food-tags" style="margin-top:6px"></div></div>
          <div class="ci"><div class="lbl">Tiền đồ ăn</div><div class="val" id="cf-food-total">0đ</div></div>
        </div>
        <div class="cf-total">Tổng tiền: <span id="cf-total">—</span></div>
        <div id="alert-confirm" class="alert"></div>
        <button class="btn btn-primary" id="btn-book-final" onclick="doBookAll()" style="width:100%">🎟 Đặt vé ngay</button>
      </div>
    </div>

    <!-- SUCCESS -->
    <div id="step-success" style="display:none">
      <div class="success-screen">
        <div class="success-icon">🎉</div>
        <div class="success-title">ĐẶT VÉ THÀNH CÔNG!</div>
        <div class="success-sub">Cảm ơn bạn đã đặt vé tại CinemaX. Chúc bạn xem phim vui vẻ!</div>
        <div class="success-card">
          <div id="success-ticket-info"></div>
        </div>
        <div style="display:flex;gap:12px;justify-content:center">
          <button class="btn btn-secondary" onclick="switchPage('my-tickets',document.querySelector('.header-nav button:nth-child(2)'))">🎟 Xem vé của tôi</button>
          <button class="btn btn-primary" onclick="resetBooking()">🎬 Đặt vé tiếp</button>
        </div>
      </div>
    </div>

  </div><!-- end page-booking -->

  <!-- PAGE: VÉ CỦA TÔI -->
  <div class="page" id="page-my-tickets">
    <div class="sec-title">Vé của <span>tôi</span></div>
    <div id="my-tickets-list"><div class="loading"><div class="spin"></div>Đang tải vé của bạn...</div></div>
  </div>

</div><!-- end app --></div><!-- end main-wrap -->

<script>
// ─── CONFIG ───────────────────────────────────────────────────────────────
const BOOKING_API  = 'http://localhost/qlrcp/controllers/bookingController.php';
const USER_API     = 'http://localhost/qlrcp/controllers/userController.php';
const CINEMA_API   = 'http://localhost/qlrcp/controllers/cinemaController.php';
const ROOM_API     = 'http://localhost/qlrcp/controllers/roomController.php';

// ─── STATE ────────────────────────────────────────────────────────────────
let currentUser  = null;
let selMovie     = null, selCinema = null, selShowtime = null;
let selectedSeats = [], bookedTicketIds = [];
let allShowtimes  = [], allDates = [];
let allFood = [], selectedFood = []; // food state

// ─── AUTO LOGIN từ localStorage ──────────────────────────────────────────
(function() {
  const raw = localStorage.getItem('cinemax_user');
  if (!raw) return; // chưa đăng nhập → header.php đã hideSidebar rồi
  try {
    const saved = JSON.parse(raw);
    if (!saved || !saved.user_id) throw new Error();
    currentUser = saved;
    // Đợi DOM xong mới thao tác UI
    document.addEventListener('DOMContentLoaded', () => {
      updateSidebarByRole(currentUser);
      document.getElementById('auth-screen').classList.add('hide');
      document.getElementById('app').classList.add('show');
      document.getElementById('uname').textContent = currentUser.username;
      document.getElementById('uav').textContent   = currentUser.username[0].toUpperCase();
      loadMovies();
    });
  } catch(e) {
    localStorage.removeItem('cinemax_user');
  }
})();

// ─── AUTH ─────────────────────────────────────────────────────────────────
function switchAuth(tab, btn) {
  document.querySelectorAll('.auth-tab').forEach(b => b.classList.remove('active'));
  document.querySelectorAll('.auth-form').forEach(f => f.classList.remove('active'));
  btn.classList.add('active');
  document.getElementById('form-' + tab).classList.add('active');
}

async function doLogin() {
  const username = document.getElementById('l-username').value.trim();
  const password = document.getElementById('l-password').value;
  if (!username || !password) { authAlert('Vui lòng nhập đầy đủ thông tin!', 'err'); return; }
  try {
    const uRes = await fetch(
      `http://localhost/qlrcp/controllers/userController.php?action=login&username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`
    ).then(r => r.json());
    if (uRes && uRes.status) {
      currentUser = { user_id: uRes.user_id, username: uRes.username, email: uRes.email, phone: uRes.phone, role: uRes.role || 'customer' };
      enterApp();
    } else {
      authAlert(uRes.message || 'Đăng nhập thất bại!', 'err');
    }
  } catch(e) { authAlert('Lỗi kết nối server!', 'err'); }
}

async function doRegister() {
  const username = document.getElementById('r-username').value.trim();
  const password = document.getElementById('r-password').value;
  const email    = document.getElementById('r-email').value.trim();
  const phone    = document.getElementById('r-phone').value.trim();
  if (!username || !password) { authAlert('Vui lòng nhập username và mật khẩu!', 'err'); return; }
  try {
    const data = await fetch('http://localhost/qlrcp/controllers/userController.php', {
      method:'POST', headers:{'Content-Type':'application/json'},
      body: JSON.stringify({ username, password, email, phone, role:'customer' })
    }).then(r => r.json());
    if (data.status) {
      authAlert('Đăng ký thành công! Vui lòng đăng nhập.', 'ok');
      setTimeout(() => switchAuth('login', document.querySelector('.auth-tab')), 1500);
    } else { authAlert(data.message || 'Đăng ký thất bại!', 'err'); }
  } catch(e) { authAlert('Lỗi kết nối server!', 'err'); }
}

function authAlert(msg, type) {
  const el = document.getElementById('auth-alert');
  el.textContent = msg;
  el.className = 'auth-alert show ' + type;
  setTimeout(() => el.classList.remove('show'), 4000);
}

function enterApp() {
  localStorage.setItem('cinemax_user', JSON.stringify(currentUser));
  updateSidebarByRole(currentUser);
  document.getElementById('auth-screen').classList.add('hide');
  document.getElementById('app').classList.add('show');
  document.getElementById('uname').textContent = currentUser.username;
  document.getElementById('uav').textContent   = currentUser.username[0].toUpperCase();
  loadMovies();
}

function doLogout() {
  localStorage.removeItem('cinemax_user');
  currentUser = null; selMovie = null; selCinema = null; selShowtime = null;
  selectedSeats = []; selectedFood = [];
  hideSidebar();
  document.getElementById('app').classList.remove('show');
  document.getElementById('auth-screen').classList.remove('hide');
}

// ─── NAV ──────────────────────────────────────────────────────────────────
function switchPage(name, btn) {
  document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.header-nav button').forEach(b => b.classList.remove('active'));
  document.getElementById('page-' + name).classList.add('active');
  btn.classList.add('active');
  if (name === 'my-tickets') loadMyTickets();
}

// ─── STEP BAR ─────────────────────────────────────────────────────────────
function updateStepBar(active) {
  for (let i = 1; i <= 6; i++) {
    const c = document.getElementById('sc' + i);
    const l = document.getElementById('sl' + i);
    if (!c) continue;
    c.className = 'step-circle ' + (i < active ? 'done' : i === active ? 'active' : '');
    l.className = 'step-label ' + (i < active ? 'done' : i === active ? 'active' : '');
  }
}
function showStep(n) {
  for (let i = 1; i <= 6; i++) {
    const el = document.getElementById('step-' + i);
    if (el) el.style.display = 'none';
  }
  document.getElementById('step-success').style.display = 'none';
  document.getElementById('step-' + n).style.display = 'block';
  updateStepBar(n);
}

// ─── STEP 1: PHIM ─────────────────────────────────────────────────────────
async function loadMovies() {
  showStep(1);
  document.getElementById('movie-list').innerHTML = '<div class="loading"><div class="spin"></div>Đang tải...</div>';
  try {
    const data = await fetch('http://localhost/qlrcp/controllers/bookingController.php?action=movies').then(r => r.json());
    const movies = data.movies || data.data || [];
    if (movies.length === 0) {
      document.getElementById('movie-list').innerHTML = '<div class="empty-state">Chưa có phim nào</div>';
      return;
    }
    document.getElementById('movie-list').innerHTML = `<div class="movie-grid">${movies.map(m => `
      <div class="movie-card" onclick="selectMovie(${JSON.stringify(m).replace(/"/g,'&quot;')})">
        ${m.poster_url
          ? `<img class="movie-poster-real" src="${m.poster_url}" onerror="this.style.display='none';this.nextSibling.style.display='flex'" alt="${m.title}"/><div class="movie-poster-placeholder" style="display:none"><div class="icon">🎬</div><div class="genre">${m.genre||''}</div></div>`
          : `<div class="movie-poster-placeholder"><div class="icon">🎬</div><div class="genre">${m.genre||''}</div></div>`}
        <div class="movie-info">
          <div class="movie-title">${m.title}</div>
          <div class="movie-meta">
            ${m.genre?`<span class="tag tag-genre">${m.genre}</span>`:''}
            ${m.language?`<span class="tag tag-lang">${m.language}</span>`:''}
            ${m.duration?`<span class="tag tag-dur">${m.duration} phút</span>`:''}
          </div>
          ${m.rating?`<div class="movie-rating">⭐ ${m.rating}</div>`:''}
        </div>
      </div>`).join('')}</div>`;
  } catch(e) {
    document.getElementById('movie-list').innerHTML = '<div class="empty-state">❌ Không kết nối được API</div>';
  }
}

function selectMovie(m) {
  selMovie = m;
  document.querySelectorAll('.movie-card').forEach(c => c.classList.remove('selected'));
  event.currentTarget.classList.add('selected');
  setTimeout(() => loadCinemas(), 200);
}

// ─── STEP 2: RẠP ──────────────────────────────────────────────────────────
async function loadCinemas() {
  showStep(2);
  document.getElementById('cinema-list').innerHTML = '<div class="loading"><div class="spin"></div>Đang tải...</div>';
  try {
    const data = await fetch(`http://localhost/qlrcp/controllers/cinemaController.php?movie_id=${selMovie.movie_id}`).then(r => r.json());
    const cinemas = data.cinemas || data.data || (Array.isArray(data) ? data : []);
    if (cinemas.length === 0) {
      document.getElementById('cinema-list').innerHTML = '<div class="empty-state">Không có rạp nào đang chiếu phim này</div>';
      return;
    }
    document.getElementById('cinema-list').innerHTML = `<div class="cinema-list">${cinemas.map(c => `
      <div class="cinema-card" onclick="selectCinema(${JSON.stringify(c).replace(/"/g,'&quot;')},this)">
        <div class="cinema-icon">🎭</div>
        <div>
          <div class="cinema-name">${c.name}</div>
          <div class="cinema-location">${c.location||''}</div>
        </div>
      </div>`).join('')}</div>`;
  } catch(e) {
    document.getElementById('cinema-list').innerHTML = '<div class="empty-state">❌ Lỗi kết nối API</div>';
  }
}

function selectCinema(c, el) {
  selCinema = c;
  document.querySelectorAll('.cinema-card').forEach(x => x.classList.remove('selected'));
  el.classList.add('selected');
  setTimeout(() => loadShowtimes(), 200);
}

// ─── STEP 3: SUẤT CHIẾU ───────────────────────────────────────────────────
async function loadShowtimes() {
  showStep(3);
  document.getElementById('showtime-list').innerHTML = '<div class="loading"><div class="spin"></div>Đang tải...</div>';
  document.getElementById('date-tabs').innerHTML = '';
  try {
    const data = await fetch(`http://localhost/qlrcp/controllers/bookingController.php?action=showtimes&movie_id=${selMovie.movie_id}&cinema_id=${selCinema.cinema_id}`).then(r => r.json());
    allShowtimes = data.showtimes || [];
    if (allShowtimes.length === 0) {
      document.getElementById('showtime-list').innerHTML = '<div class="empty-state">Không có suất chiếu nào</div>';
      return;
    }
    allDates = [...new Set(allShowtimes.map(s => s.show_date))].sort();
    document.getElementById('date-tabs').innerHTML = allDates.map((d, i) =>
      `<button class="date-btn${i===0?' active':''}" onclick="filterByDate('${d}',this)">${formatDate(d)}</button>`
    ).join('');
    filterByDate(allDates[0]);
  } catch(e) {
    document.getElementById('showtime-list').innerHTML = '<div class="empty-state">❌ Lỗi kết nối API</div>';
  }
}

function filterByDate(date, btn) {
  document.querySelectorAll('.date-btn').forEach(b => b.classList.remove('active'));
  if (btn) btn.classList.add('active');
  const filtered = allShowtimes.filter(s => s.show_date === date);
  renderShowtimes(filtered);
}

function renderShowtimes(list) {
  const types = {'2D':'t2d','3D':'t3d','IMAX':'timax','4DX':'t4dx'};
  document.getElementById('showtime-list').innerHTML = `<div class="showtime-grid">${list.map(s => `
    <div class="showtime-card" onclick="selectShowtime(${JSON.stringify(s).replace(/"/g,'&quot;')},this)">
      <div class="st-time">${s.start_time ? s.start_time.slice(0,5) : '—'}</div>
      <div class="st-room">🎭 ${s.theater_name||'—'}</div>
      <span class="st-type ${types[s.room_type]||'t2d'}">${s.room_type||'2D'}</span>
      <div class="st-price">${Number(s.price||s.showtime_price||0).toLocaleString()}đ / vé</div>
    </div>`).join('')}</div>`;
}

function selectShowtime(s, el) {
  selShowtime = s;
  document.querySelectorAll('.showtime-card').forEach(x => x.classList.remove('selected'));
  el.classList.add('selected');
  setTimeout(() => loadSeatMap(), 200);
}

// ─── STEP 4: GHẾ ──────────────────────────────────────────────────────────
async function loadSeatMap() {
  showStep(4);
  selectedSeats = [];
  document.getElementById('order-summary').style.display = 'none';
  document.getElementById('btn-to-confirm').disabled = true;
  document.getElementById('seat-map').innerHTML = '<div class="loading"><div class="spin"></div>Đang tải sơ đồ ghế...</div>';
  try {
    const data = await fetch(`http://localhost/qlrcp/controllers/bookingController.php?showtime_id=${selShowtime.showtime_id}`).then(r => r.json());
    if (!data.status) { showAlert('alert-seats', data.message, 'error'); return; }
    renderSeatMap(data.seats);
  } catch(e) { showAlert('alert-seats', 'Lỗi kết nối API!', 'error'); }
}

function renderSeatMap(seats) {
  const rows = {};
  seats.forEach(s => { const r = s.seat_number[0]; if (!rows[r]) rows[r] = []; rows[r].push(s); });
  document.getElementById('seat-map').innerHTML = Object.keys(rows).sort().map(r => `
    <div class="seat-row">
      <div class="row-lbl">${r}</div>
      ${rows[r].map(s => {
        const cls = s.status === 'booked' ? 'bk' : s.seat_type.toLowerCase();
        const couple = s.seat_type === 'couple' ? ' style="min-width:60px"' : '';
        return `<div class="seat ${cls} av" id="seat-${s.seat_id}"
          title="${s.seat_number} — ${s.seat_type} — Ghế: ${Number(s.price||0)>0?Number(s.price).toLocaleString()+'đ':'Miễn phí'} + Vé: ${Number(selShowtime?.price||0).toLocaleString()}đ"
          onclick="toggleSeat(${s.seat_id},'${s.seat_number}','${s.seat_type}',${s.price},'${s.status}')"${couple}>
          ${s.seat_number.slice(1)}
        </div>`;
      }).join('')}
    </div>`).join('');
}

function toggleSeat(id, num, type, price, status) {
  if (status === 'booked') return;
  const idx = selectedSeats.findIndex(s => s.seat_id == id);
  const el  = document.getElementById('seat-' + id);
  // Tổng giá 1 ghế = giá ghế + giá vé showtime
  const showtimePrice = Number(selShowtime?.price || 0);
  const totalSeatPrice = Number(price) + showtimePrice;
  if (idx >= 0) {
    selectedSeats.splice(idx, 1);
    if (el) el.classList.remove('selected');
  } else {
    selectedSeats.push({ seat_id: id, seat_number: num, seat_type: type, price: totalSeatPrice, seat_price: Number(price), showtime_price: showtimePrice });
    if (el) el.classList.add('selected');
  }
  updateOrderSummary();
}

function updateOrderSummary() {
  if (selectedSeats.length === 0) {
    document.getElementById('order-summary').style.display = 'none';
    document.getElementById('btn-to-confirm').disabled = true;
    return;
  }
  document.getElementById('order-summary').style.display = 'block';
  document.getElementById('btn-to-confirm').disabled = false;
  const total = selectedSeats.reduce((s, x) => s + x.price, 0);
  document.getElementById('selected-seat-tags').innerHTML = selectedSeats.map(s =>
    `<span class="seat-tag">${s.seat_number}</span>`).join('');
  document.getElementById('os-total-price').textContent = total.toLocaleString() + 'đ';
}


// ─── STEP 5: ĐỒ ĂN ──────────────────────────────────────────────────────────
function goToFood() {
  if (selectedSeats.length === 0) return;
  selectedFood = [];
  showStep(5);
  loadFood();
}

async function loadFood() {
  document.getElementById('food-list').innerHTML = '<div class="loading"><div class="spin"></div>Đang tải...</div>';
  try {
    const data = await fetch('http://localhost/qlrcp/controllers/foodController.php').then(r => r.json());
    allFood = data.data || data.food || [];
    renderFood(allFood);
  } catch(e) {
    document.getElementById('food-list').innerHTML = '<div class="empty-state" style="color:var(--muted)">❌ Lỗi tải danh sách đồ ăn</div>';
  }
}

const foodIcons = { popcorn: '🍿', drink: '🥤', combo: '🎁' };

function renderFood(list) {
  if (!list.length) { document.getElementById('food-list').innerHTML = '<div class="empty-state" style="color:var(--muted)">Không có đồ ăn</div>'; return; }
  document.getElementById('food-list').innerHTML = list.map(f => `
    <div class="food-card" id="fc-${f.food_id}">
      <div class="food-icon">${foodIcons[f.category] || '🍽'}</div>
      <span class="food-cat ${f.category}">${f.category === 'popcorn' ? 'Bắp rang' : f.category === 'drink' ? 'Nước uống' : 'Combo'}</span>
      <div class="food-name">${f.name}</div>
      <div class="food-desc">${f.description || ''}</div>
      <div class="food-price">${Number(f.price).toLocaleString()}đ</div>
      <div class="qty-ctrl">
        <button class="qty-btn" onclick="changeQty(${f.food_id},-1,event)">−</button>
        <span class="qty-num" id="qty-${f.food_id}">0</span>
        <button class="qty-btn" onclick="changeQty(${f.food_id},1,event)">+</button>
      </div>
    </div>`).join('');
}

function filterFood(cat, btn) {
  document.querySelectorAll('.food-tab-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  // fooditems không có category → chỉ filter all hoạt động
  renderFood(cat === 'all' ? allFood : allFood.filter(f => (f.category||'') === cat));
  // Restore qty values after re-render
  selectedFood.forEach(sf => {
    const el = document.getElementById('qty-' + sf.food_id);
    if (el) el.textContent = sf.quantity;
    const card = document.getElementById('fc-' + sf.food_id);
    if (card) card.classList.add('selected');
  });
}

function changeQty(food_id, delta, e) {
  e.stopPropagation();
  const food = allFood.find(f => f.food_id == food_id);
  if (!food) return;
  const idx = selectedFood.findIndex(f => f.food_id == food_id);
  let qty = idx >= 0 ? selectedFood[idx].quantity : 0;
  qty = Math.max(0, qty + delta);
  const qtyEl = document.getElementById('qty-' + food_id);
  if (qtyEl) qtyEl.textContent = qty;
  const card = document.getElementById('fc-' + food_id);
  if (qty > 0) {
    if (idx >= 0) selectedFood[idx].quantity = qty;
    else selectedFood.push({ food_id: food.food_id, name: food.name, quantity: qty, unit_price: Number(food.price) });
    if (card) card.classList.add('selected');
  } else {
    if (idx >= 0) selectedFood.splice(idx, 1);
    if (card) card.classList.remove('selected');
  }
  updateFoodSummary();
}

function updateFoodSummary() {
  const summary = document.getElementById('food-summary');
  if (!selectedFood.length) { summary.style.display = 'none'; return; }
  summary.style.display = 'block';
  const total = selectedFood.reduce((s, f) => s + f.unit_price * f.quantity, 0);
  document.getElementById('food-summary-rows').innerHTML = selectedFood.map(f => `
    <div class="food-summary-row">
      <span>${foodIcons[allFood.find(x=>x.food_id==f.food_id)?.category]||'🍽'} ${f.name} x${f.quantity}</span>
      <span>${(f.unit_price * f.quantity).toLocaleString()}đ</span>
    </div>`).join('');
  document.getElementById('food-total-price').textContent = total.toLocaleString() + 'đ';
}

function skipFood() {
  selectedFood = [];
  goToConfirm();
}

// ─── STEP 6: XÁC NHẬN ─────────────────────────────────────────────────────
function goToConfirm() {
  if (selectedSeats.length === 0) return;
  document.getElementById('cf-movie').textContent   = selMovie.title;
  document.getElementById('cf-cinema').textContent  = selCinema.name + ' — ' + (selCinema.location||'');
  document.getElementById('cf-room').textContent    = (selShowtime.theater_name||'—') + ' (' + (selShowtime.room_type||'—') + ')';
  document.getElementById('cf-date').textContent    = formatDate(selShowtime.show_date);
  document.getElementById('cf-time').textContent    = selShowtime.start_time ? selShowtime.start_time.slice(0,5) : '—';
  document.getElementById('cf-user').textContent    = currentUser.username;
  document.getElementById('cf-seat-tags').innerHTML = selectedSeats.map(s =>
    `<span class="seat-tag">${s.seat_number} (${s.seat_type})</span>`).join('');

  // Hiện đồ ăn đã chọn trong trang xác nhận
  const foodTotal = selectedFood.reduce((s, x) => s + x.unit_price * x.quantity, 0);
  const seatTotal = selectedSeats.reduce((s, x) => s + x.price, 0);
  document.getElementById('cf-food-tags').innerHTML = selectedFood.length > 0
    ? selectedFood.map(f => `<span class="seat-tag">🍿 ${f.name} x${f.quantity}</span>`).join('')
    : '<span style="color:var(--muted);font-size:0.8rem">Không chọn đồ ăn</span>';
  document.getElementById('cf-food-total').textContent = foodTotal > 0 ? foodTotal.toLocaleString() + 'đ' : '0đ';
  document.getElementById('cf-total').textContent = (seatTotal + foodTotal).toLocaleString() + 'đ';
  showStep(6);
}

async function doBookAll() {
  const btn = document.getElementById('btn-book-final');
  btn.disabled = true; btn.textContent = '⏳ Đang đặt vé...';
  bookedTicketIds = [];
  let hasError = false;
  for (const seat of selectedSeats) {
    try {
      const data = await fetch('http://localhost/qlrcp/controllers/bookingController.php', {
        method:'POST', headers:{'Content-Type':'application/json'},
        body: JSON.stringify({ showtime_id: parseInt(selShowtime.showtime_id), seat_id: seat.seat_id, user_id: currentUser.user_id })
      }).then(r => r.json());
      if (data.status) {
        bookedTicketIds.push(data.ticket.ticket_id);
      } else {
        showAlert('alert-confirm', `Ghế ${seat.seat_number}: ${data.message}`, 'error');
        hasError = true; break;
      }
    } catch(e) {
      showAlert('alert-confirm', 'Lỗi kết nối API!', 'error');
      hasError = true; break;
    }
  }
  btn.disabled = false; btn.textContent = '🎟 Đặt vé ngay';
  if (!hasError) {
    // Nếu có chọn đồ ăn → gửi thêm foodorder đến orderController
    if (selectedFood.length > 0 && bookedTicketIds.length > 0) {
      try {
        await fetch('http://localhost/qlrcp/controllers/orderController.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            user_id:     currentUser.user_id,
            showtime_id: parseInt(selShowtime.showtime_id),
            items: selectedFood.map(f => ({ food_id: f.food_id, quantity: f.quantity }))
          })
        });
      } catch(e) { console.log('Lỗi gửi food order:', e); }
    }
    showSuccessScreen();
  }
}

function showSuccessScreen() {
  const total = selectedSeats.reduce((s, x) => s + x.price, 0);
  document.getElementById('success-ticket-info').innerHTML = `
    <div class="success-grid">
      <div class="si"><div class="lbl">Phim</div><div class="val">${selMovie.title}</div></div>
      <div class="si"><div class="lbl">Rạp</div><div class="val">${selCinema.name}</div></div>
      <div class="si"><div class="lbl">Ngày chiếu</div><div class="val">${formatDate(selShowtime.show_date)}</div></div>
      <div class="si"><div class="lbl">Giờ chiếu</div><div class="val gold">${selShowtime.start_time?selShowtime.start_time.slice(0,5):'—'}</div></div>
      <div class="si"><div class="lbl">Ghế</div><div class="val gold">${selectedSeats.map(s=>s.seat_number).join(', ')}</div></div>
      <div class="si"><div class="lbl">Đồ ăn</div><div class="val">${selectedFood.length>0?selectedFood.map(f=>f.name+' x'+f.quantity).join(', '):'Không chọn'}</div></div>
      <div class="si"><div class="lbl">Tổng tiền</div><div class="val gold">${(total+selectedFood.reduce((s,f)=>s+f.unit_price*f.quantity,0)).toLocaleString()}đ</div></div>
    </div>`;
  for (let i = 1; i <= 5; i++) document.getElementById('step-' + i).style.display = 'none';
  document.getElementById('step-success').style.display = 'block';
  updateStepBar(6);
}

function resetBooking() {
  selMovie = null; selCinema = null; selShowtime = null; selectedSeats = []; bookedTicketIds = [];
  loadMovies();
}

// ─── MY TICKETS ───────────────────────────────────────────────────────────
async function loadMyTickets() {
  document.getElementById('my-tickets-list').innerHTML = '<div class="loading"><div class="spin"></div>Đang tải vé của bạn...</div>';
  try {
    const data = await fetch(`http://localhost/qlrcp/controllers/bookingController.php?user_id=${currentUser.user_id}`).then(r => r.json());
    const tickets = data.tickets || [];
    if (tickets.length === 0) {
      document.getElementById('my-tickets-list').innerHTML = '<div class="empty-state" style="background:var(--card);border-radius:12px;padding:40px;border:1px solid var(--border)">Bạn chưa đặt vé nào</div>';
      return;
    }
    document.getElementById('my-tickets-list').innerHTML = `<div class="ticket-list">${tickets.map(t => `
      <div class="ticket-card">
        <div class="tc-id">#${t.ticket_id}</div>
        <div class="tc-movie">${t.movie_title||'N/A'}</div>
        <div class="tc-grid">
          <div class="tc-item"><span class="lbl">Ghế</span><span class="val">${t.seat_number||'—'} <span class="badge badge-${(t.seat_type||'normal').toLowerCase()}">${t.seat_type||'—'}</span></span></div>
          <div class="tc-item"><span class="lbl">Giá</span><span class="val" style="color:var(--gold)">${Number(t.seat_price||0).toLocaleString()}đ</span></div>
          <div class="tc-item"><span class="lbl">Ngày chiếu</span><span class="val">${t.show_date||'—'}</span></div>
          <div class="tc-item"><span class="lbl">Giờ chiếu</span><span class="val">${t.start_time||'—'}</span></div>
          <div class="tc-item"><span class="lbl">Rạp</span><span class="val">${t.cinema_name||'—'}</span></div>
          <div class="tc-item"><span class="lbl">Phòng</span><span class="val">${t.theater_name||'—'}</span></div>
        </div>
      </div>`).join('')}</div>`;
  } catch(e) {
    document.getElementById('my-tickets-list').innerHTML = '<div class="empty-state">❌ Lỗi kết nối API</div>';
  }
}

// ─── HELPERS ──────────────────────────────────────────────────────────────
function showAlert(id, msg, type) {
  const el = document.getElementById(id);
  el.innerHTML = (type === 'success' ? '✅ ' : '❌ ') + msg;
  el.className = 'alert ' + type + ' show';
  setTimeout(() => el.classList.remove('show'), 6000);
}
function formatDate(d) {
  if (!d) return '—';
  const [y, m, day] = d.split('-');
  return `${day}/${m}/${y}`;
}
</script>
</body>
</html>
