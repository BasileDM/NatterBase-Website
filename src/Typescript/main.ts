import { LoginModal } from './Components/LoginModal.js';
import { Sidebar } from './Components/Sidebar.js';

document.addEventListener('DOMContentLoaded', function() : void {
  new Sidebar();
  new LoginModal('login-modal', ['navbar-login-button', 'sidebar-login-button']);
});