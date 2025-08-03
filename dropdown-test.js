// Dropdown functionality
document.addEventListener("DOMContentLoaded", function () {
  const userIcon = document.querySelector(".user-icon");
  const userMenu = document.querySelector(".user-menu");
  const dropdown = document.querySelector(".dropdown");

  if (userIcon && userMenu) {
    userIcon.addEventListener("click", function (e) {
      e.preventDefault();
      e.stopPropagation();

      userMenu.classList.toggle("menu-open");

      // Controlar outros elementos quando dropdown aberto
      if (userMenu.classList.contains("menu-open")) {
        document.body.classList.add("dropdown-open");
      } else {
        document.body.classList.remove("dropdown-open");
      }
    });

    // Fechar ao clicar fora
    document.addEventListener("click", function (e) {
      if (!dropdown.contains(e.target)) {
        userMenu.classList.remove("menu-open");
        document.body.classList.remove("dropdown-open");
      }
    });
  }
});
