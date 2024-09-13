export class Modal {
    constructor(modalId, triggerButtonIds) {
        this.closeButtonId = 'modal-close-btn';
        this.modalElement = document.getElementById(modalId);
        this.bindEvents(triggerButtonIds);
    }
    open() {
        this.modalElement.showModal();
    }
    close() {
        this.modalElement.close();
    }
    bindEvents(triggerButtonIds) {
        // Bind open events to trigger buttons
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
        // Close modal when clicking outside the modal content
        this.modalElement.addEventListener('click', (event) => {
            if (event.target === this.modalElement) {
                this.close();
            }
        });
    }
}
