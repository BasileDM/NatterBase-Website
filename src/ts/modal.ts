export function initializeModal() : void {
  const loginModal = document.getElementById('login-modal') as HTMLDialogElement | null;
  const navbarLoginButton = document.getElementById('navbar-login-button') as HTMLButtonElement | null;
  const sidebarLoginBtn = document.getElementById('sidebar-login-button') as HTMLButtonElement | null;
  const closeButton = document.getElementById('modal-close-btn') as HTMLButtonElement | null;

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

  loginModal.addEventListener('click', (event: MouseEvent) => {
    if (event.target === loginModal) {
      loginModal.close();
    }
  });
}
