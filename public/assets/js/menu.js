export function toggleMenu() {
  const toggleButton = document.getElementById('menu-toggle');
  const sidebar = document.getElementById('sidebar');

  toggleButton.addEventListener('click', function () {
    sidebar.classList.toggle('hidden');
    sidebar.classList.toggle('animate-slideIn');
  });
}
