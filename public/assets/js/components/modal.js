export class Modal {
    constructor(modalId, triggerButtonIds) {
        this.modalElement = document.getElementById(modalId);
        this.closeButtonId = 'modal-close-btn';
        this.bindEvents(triggerButtonIds);
    }
    open() {
        this.modalElement.showModal();
    }
    close() {
        this.modalElement.close();
    }
    bindEvents(triggerButtonIds) {
        triggerButtonIds.forEach(buttonId => {
            const button = document.getElementById(buttonId);
            if (button) {
                button.addEventListener('click', () => this.open());
            }
        });
        const closeButton = document.getElementById(this.closeButtonId);
        if (closeButton) {
            closeButton.addEventListener('click', () => this.close());
        }
        // Close modal when clicking outside
        this.modalElement.addEventListener('click', (event) => {
            if (event.target === this.modalElement) {
                this.close();
            }
        });
    }
}
