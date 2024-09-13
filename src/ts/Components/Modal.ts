import { UIComponent } from '../Abstracts/UIComponent.js';

export class Modal extends UIComponent {
  private modalElement: HTMLDialogElement;

  constructor(modalId: string) {
    super();
    this.modalElement = document.getElementById(modalId) as HTMLDialogElement;
  }

  open(): void {
    this.modalElement.showModal();
  }

  close(): void {
    this.modalElement.close();
  }
}
