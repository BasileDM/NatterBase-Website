import { LoginModal } from './Components/LoginModal.js';
import { Sidebar } from './Components/Sidebar.js';
import { Toast } from './Components/Toast.js';

document.addEventListener('DOMContentLoaded', function() : void {
  new Sidebar();
  new LoginModal('login-modal', ['navbar-login-button', 'sidebar-login-button']);

  // Show toast saved in session storage
  const toastMessage = sessionStorage.getItem('showToast');
  if (toastMessage) {
    new Toast('success', toastMessage);
    sessionStorage.removeItem('showToast');
  }
});