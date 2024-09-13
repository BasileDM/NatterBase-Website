export function toggleMenu() {
    const toggleButton = document.getElementById('menu-toggle');
    const sidebar = document.getElementById('sidebar');
    if (!toggleButton || !sidebar) {
        console.error('Menu toggle or sidebar element not found');
        return;
    }
    // Burger button toggle
    toggleButton.addEventListener('click', function () {
        if (sidebar.classList.contains('hidden')) {
            sidebar.classList.remove('hidden');
            sidebar.classList.remove('animate-slideOut');
            sidebar.classList.add('animate-slideIn');
        }
        else {
            sidebar.classList.remove('animate-slideIn');
            sidebar.classList.add('animate-slideOut');
            setTimeout(() => {
                sidebar.classList.add('hidden');
            }, 450);
        }
    });
    // Close sidebar when clicking outside of it
    document.addEventListener('click', function (event) {
        if (!sidebar.contains(event.target) && !toggleButton.contains(event.target)) {
            sidebar.classList.remove('animate-slideIn');
            sidebar.classList.add('animate-slideOut');
            setTimeout(() => {
                sidebar.classList.add('hidden');
            }, 450);
        }
    });
}
