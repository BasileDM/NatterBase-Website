export function initializeModal() {
    const loginModal = document.getElementById('login-modal');
    const navbarLoginButton = document.getElementById('navbar-login-button');
    const sidebarLoginBtn = document.getElementById('sidebar-login-button');
    const closeButton = document.getElementById('modal-close-btn');
    if (!loginModal || !navbarLoginButton || !closeButton || !sidebarLoginBtn) {
        return;
    }
    navbarLoginButton.addEventListener('click', () => {
        loginModal.showModal();
    });
    sidebarLoginBtn.addEventListener('click', () => {
        loginModal.showModal();
    });
    closeButton.addEventListener('click', () => {
        loginModal.close();
    });
    loginModal.addEventListener('click', (event) => {
        if (event.target === loginModal) {
            loginModal.close();
        }
    });
}
