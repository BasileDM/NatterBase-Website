export class AbstractModal {
    constructor(modalId, triggerButtonIds) {
        this.modalElement = document.getElementById(modalId);
        this.closeButton = this.modalElement.querySelector('button[id*="close"]');
        this.bindAbstractEvents(triggerButtonIds);
    }
    bindAbstractEvents(triggerButtonIds) {
        // Open buttons
        if (triggerButtonIds) {
            triggerButtonIds.forEach(buttonId => {
                const button = document.getElementById(buttonId);
                if (button) {
                    button.addEventListener('click', () => this.open());
                }
            });
        }
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
        this.modalElement.classList.remove('closing');
    }
    close() {
        this.modalElement.classList.add('closing');
        const handleAnimationEnd = () => {
            this.modalElement.close();
            this.modalElement.classList.remove('closing');
            this.modalElement.removeEventListener('animationend', handleAnimationEnd);
        };
        this.modalElement.addEventListener('animationend', handleAnimationEnd);
    }
}
