const body = document.body;
  const menuButton = document.querySelector(".header_mobile i.bi-list"); // Ícone do menu hambúrguer
  const sidebar = document.querySelector(".sidebar");

  if (menuButton && sidebar) {
    menuButton.addEventListener("click", () => {
      // Alterna a classe que abre ou fecha a sidebar
      body.classList.toggle("sidebar-open");
    });
  }

  // Fecha a sidebar ao clicar fora dela (opcional)
  document.addEventListener("click", (e) => {
    if (
      body.classList.contains("sidebar-open") &&
      !sidebar.contains(e.target) &&
      !menuButton.contains(e.target)
    ) {
      body.classList.remove("sidebar-open");
    }
  });