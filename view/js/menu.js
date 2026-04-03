const toggleBtn = document.querySelector(".menu-toggle");
const sidebar = document.querySelector(".app-sidebar");

toggleBtn.addEventListener("click", () => {
    sidebar.classList.toggle("collapsed");
});