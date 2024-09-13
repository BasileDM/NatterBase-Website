import { Modal } from './Components/Modal.js';
import { Sidebar } from './Components/Sidebar.js';

document.addEventListener('DOMContentLoaded', function() : void {
  new Sidebar();
  new Modal('login-modal', ['navbar-login-button', 'sidebar-login-button']);
});