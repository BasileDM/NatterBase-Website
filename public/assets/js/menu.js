document.addEventListener("DOMContentLoaded", function () {
  const toggleButton = document.getElementById("menu-toggle");
  const sidebar = document.getElementById("sidebar");

  toggleButton.addEventListener("click", function () {
    if (sidebar.classList.contains("hidden")) {
      sidebar.classList.remove("hidden");
      sidebar.classList.add("animate-slideIn");
    } else {
      sidebar.classList.add("hidden");
      sidebar.classList.remove("animate-slideIn");
    }
  });
});
