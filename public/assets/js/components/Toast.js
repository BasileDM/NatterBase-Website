export class Toast {
    constructor(type, message) {
        this.toastElement = document.getElementById('toast');
        this.closeButton = document.getElementById('toast-close-btn');
        this.showAnimationClass = 'animate-toastSlideIn';
        this.closeAnimationClass = 'animate-toastSlideOut';
        this.messageElement = document.getElementById('toast-message');
        this.iconElement = document.getElementById('toast-icon');
        this.bindEvents();
        this.display(type, message);
    }
    bindEvents() {
        this.closeButton.addEventListener('click', () => {
            this.close();
        });
    }
    show() {
        this.toastElement.classList.remove('hidden', this.closeAnimationClass);
        this.toastElement.classList.add(this.showAnimationClass);
        setTimeout(() => {
            this.close();
        }, 3000);
    }
    close() {
        this.toastElement.classList.remove(this.showAnimationClass);
        this.toastElement.classList.add(this.closeAnimationClass);
        setTimeout(() => {
            this.toastElement.classList.add('hidden');
        }, 450);
    }
    display(type, message) {
        this.messageElement.textContent = message;
        // Apply different styles based on the type
        if (type === 'success') {
            this.toastElement.classList.remove('toast-error');
            this.toastElement.classList.add('toast-success');
            this.iconElement.textContent = '✔️';
        }
        else if (type === 'error') {
            this.toastElement.classList.remove('toast-success');
            this.toastElement.classList.add('toast-error');
            this.iconElement.textContent = '❌';
        }
        this.show();
    }
}
