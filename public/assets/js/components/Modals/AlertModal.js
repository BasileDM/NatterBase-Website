import { AbstractModal } from './Abstract/AbstractModal.js';
export class AlertModal extends AbstractModal {
    constructor(modalId, triggerButtonIds) {
        super(modalId);
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
    }
}
