export class UIComponent {
    bindEvents(triggerId, closeButtonId) {
        const triggerButton = document.getElementById(triggerId);
        const closeButton = document.getElementById(closeButtonId);
        if (triggerButton) {
            triggerButton.addEventListener('click', () => this.open());
        }
        if (closeButton) {
            closeButton.addEventListener('click', () => this.close());
        }
    }
}
