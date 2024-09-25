// AbstractModal.ts
export class AbstractModal {
    constructor(modalId) {
        this.modalElement = document.getElementById(modalId);
        this.closeButton = this.modalElement.querySelector('button[id*="close"]');
        this.bindCommonEvents();
    }
    bindCommonEvents() {
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
    }
    open() {
        this.modalElement.showModal();
    }
    close() {
        this.modalElement.close();
    }
}
