import { Modal } from './Components/Modal.js';
import { toggleMenu } from './Components/SideBar.js';
document.addEventListener('DOMContentLoaded', function () {
    toggleMenu();
    const loginModal = new Modal('login-modal');
    loginModal.bindEvents('navbar-login-button', 'modal-close-btn');
});
