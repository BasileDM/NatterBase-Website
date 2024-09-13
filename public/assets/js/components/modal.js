import { UIComponent } from '../Abstracts/UIComponent.js';
export class Modal extends UIComponent {
    constructor(modalId) {
        super();
        this.modalElement = document.getElementById(modalId);
    }
    open() {
        this.modalElement.showModal();
    }
    close() {
        this.modalElement.close();
    }
}
