import { LoginModal } from './Components/LoginModal.js';
import { Sidebar } from './Components/Sidebar.js';
import { Toast } from './Components/Toast.js';

document.addEventListener('DOMContentLoaded', function() : void {
  new Sidebar();
  new LoginModal('login-modal', ['navbar-login-button', 'sidebar-login-button']);
  const toast = new Toast();
  toast.display('success', 'You are now logged in !');
});