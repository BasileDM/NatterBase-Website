import { AbstractModal } from './Abstract/AbstractModal.js';
export class ConfirmationModal extends AbstractModal {
    constructor(modalId) {
        super(modalId);
        this.messageElement = this.modalElement.querySelector('.modal-message');
        this.confirmButton = this.modalElement.querySelector('.confirm-button');
        this.cancelButton = this.modalElement.querySelector('.cancel-button');
        this.bindEvents();
    }
    bindEvents() {
        if (this.confirmButton) {
            this.confirmButton.addEventListener('click', () => this.handleConfirm());
        }
        if (this.cancelButton) {
            this.cancelButton.addEventListener('click', () => this.close());
        }
    }
    open(message, onConfirm) {
        this.messageElement.textContent = message;
        this.onConfirmCallback = onConfirm;
        super.open();
    }
    handleConfirm() {
        this.close();
        if (this.onConfirmCallback) {
            this.onConfirmCallback();
        }
    }
}
