import { Modal } from './Components/Modal.js';
import { Sidebar } from './Components/Sidebar.js';
document.addEventListener('DOMContentLoaded', function () {
    const sidebar = new Sidebar();
    sidebar.bindEvents();
    const loginModal = new Modal('login-modal');
    loginModal.bindEvents('navbar-login-button', 'modal-close-btn');
});
