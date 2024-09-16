import { RequestHelper } from '../Utils/RequestHelper.js';
export class LoginModal {
    constructor(modalId, triggerButtonIds) {
        this.modalElement = document.getElementById(modalId);
        this.closeButton = document.getElementById('login-modal-close-btn');
        this.submitButton = document.getElementById('login-modal-submit-btn');
        this.bindEvents(triggerButtonIds);
    }
    bindEvents(triggerButtonIds) {
        triggerButtonIds.forEach(buttonId => {
            const button = document.getElementById(buttonId);
            if (button) {
                button.addEventListener('click', () => this.open());
            }
        });
        if (this.closeButton) {
            this.closeButton.addEventListener('click', () => this.close());
        }
        // Close modal when clicking outside
        this.modalElement.addEventListener('click', (event) => {
            if (event.target === this.modalElement) {
                this.close();
            }
        });
        // Submit button
        if (this.submitButton) {
            this.submitButton.addEventListener('click', async (event) => {
                event.preventDefault();
                const formData = {
                    mail: document.getElementById('mail').value,
                    password: document.getElementById('password').value,
                };
                const response = await RequestHelper.post('/login', formData);
                if (response) {
                    this.close();
                    sessionStorage.setItem('showToast', 'You are now logged in!');
                    window.location.href = '/app';
                }
            });
        }
    }
    open() {
        this.modalElement.showModal();
    }
    close() {
        this.modalElement.close();
    }
}
