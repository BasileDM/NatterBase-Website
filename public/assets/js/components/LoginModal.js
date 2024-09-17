import { FormValidator } from '../Utils/FormValidator.js';
import { RequestHelper } from '../Utils/RequestHelper.js';
import { Toast } from './Toast.js';
export class LoginModal {
    constructor(modalId, triggerButtonIds) {
        this.modalElement = document.getElementById(modalId);
        this.registerForm = document.getElementById('register-form');
        this.loginForm = document.getElementById('login-form');
        this.titleElement = document.getElementById('login-modal-title');
        this.closeButton = document.getElementById('login-modal-close-btn');
        this.submitLoginFormBtn = document.getElementById('login-modal-submit-btn');
        this.submitRegisterFormBtn = document.getElementById('register-modal-submit-btn');
        this.registerButton = document.getElementById('modal-register-btn');
        this.loginButton = document.getElementById('modal-login-btn');
        this.bindEvents(triggerButtonIds);
    }
    bindEvents(triggerButtonIds) {
        // Open buttons
        triggerButtonIds.forEach(buttonId => {
            const button = document.getElementById(buttonId);
            if (button) {
                button.addEventListener('click', () => this.open());
            }
        });
        // Close button
        if (this.closeButton) {
            this.closeButton.addEventListener('click', () => this.close());
        }
        // Close modal when clicking outside
        this.modalElement.addEventListener('click', (event) => {
            if (event.target === this.modalElement) {
                this.close();
            }
        });
        // Display register form
        this.registerButton.addEventListener('click', () => {
            this.registerForm.classList.remove('hidden');
            this.loginForm.classList.add('hidden');
            this.titleElement.textContent = 'Register';
        });
        // Display login form
        this.loginButton.addEventListener('click', () => {
            this.registerForm.classList.add('hidden');
            this.loginForm.classList.remove('hidden');
            this.titleElement.textContent = 'Login';
        });
        // Submit login form button
        if (this.submitLoginFormBtn) {
            this.submitLoginFormBtn.addEventListener('click', async (event) => {
                event.preventDefault();
                const formData = {
                    mail: document.getElementById('mail').value,
                    password: document.getElementById('password').value,
                };
                try {
                    const response = await RequestHelper.post('/login', formData);
                    const responseBody = await response.json();
                    if (!response.ok) {
                        new Toast('error', responseBody.message || 'An error occurred');
                        return;
                    }
                    this.close();
                    sessionStorage.setItem('showToast', 'You are now logged in!');
                    window.location.href = '/app';
                }
                catch {
                    new Toast('error', 'Failed sending request. Try again later.');
                }
            });
        }
        // Submit registration form button
        if (this.submitRegisterFormBtn) {
            this.submitRegisterFormBtn.addEventListener('click', async (event) => {
                event.preventDefault();
                const formData = {
                    mail: document.getElementById('mail-register').value,
                    username: document.getElementById('username').value,
                    password: document.getElementById('password-register').value,
                    confirmPassword: document.getElementById('password-confirm').value,
                    gdpr: document.getElementById('gdpr').checked,
                };
                try {
                    const response = await RequestHelper.post('/register', formData);
                    const responseBody = await response.json();
                    if (responseBody.formErrors) {
                        const formValidator = new FormValidator('register-form');
                        formValidator.displayFormErrors(responseBody.formErrors);
                        return;
                    }
                    this.close();
                    window.location.href = '/home?confirmRegistration=true';
                }
                catch (error) {
                    console.error('Unexpected error: ', error);
                    new Toast('error', '500: Server error. Try again later.');
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
