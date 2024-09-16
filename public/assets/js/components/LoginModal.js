import { RequestHelper } from '../Utils/RequestHelper';
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
                    username: document.getElementById('username').value,
                    password: document.getElementById('password').value,
                };
                const response = await RequestHelper.post('/login', formData);
                if (response) {
                    console.log('successful login');
                    this.close();
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
