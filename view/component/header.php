<header class="app-header">
  <div class="header-left">
    <button class="menu-toggle">
      <i class="fa-solid fa-bars"></i>
    </button>
    <span class="logo">CINEMA</span>
  </div>

  <div class="header-right">
    <input type="text" placeholder="Tìm kiếm..." />

</header>

<aside class="app-sidebar" id="sidebar">
  <ul class="nav-ul">
    <li class="nav-li">
        <div class="nav-item">
            <i class="fa-solid fa-user"></i>
            <span>Tài khoản</span>

        </div>
        <div class="submenu">
            <a href="#">Thông tin tài khoản</a>
            <a href="#">Đổi mật khẩu</a>
    </li>
    <li class="nav-li">
      <div class="nav-item">
        <i class="fa-solid fa-briefcase"></i>
        <span>Dashboard</span>
      </div>
      <div class="submenu">
        <a href="#">Submenu 1</a>
        <a href="#">Submenu 2</a>
        <a href="#">Submenu 3</a>
      </div>
    </li>

    <li class="nav-li">
      <a href="#" class="nav-item">
        <i class="fa-solid fa-masks-theater"></i>
        <span>Phim</span>
      </a>
    </li>
  </ul>
</aside>
<script>
  const toggleBtn = document.querySelector(".menu-toggle");
  const sidebar = document.querySelector(".app-sidebar");
  const content = document.querySelector(".app-content");

  toggleBtn.addEventListener("click", () => {
    sidebar.classList.toggle("collapsed");
    content.classList.toggle("collapsed");
  });

</script>