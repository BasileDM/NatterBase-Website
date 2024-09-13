import { Modal } from './Components/Modal.js';
import { Sidebar } from './Components/Sidebar.js';
import { Toast } from './Components/Toast.js';
document.addEventListener('DOMContentLoaded', function () {
    new Sidebar();
    new Modal('login-modal', ['navbar-login-button', 'sidebar-login-button']);
    const toast = new Toast();
    toast.display('success', 'Login Successful');
});
