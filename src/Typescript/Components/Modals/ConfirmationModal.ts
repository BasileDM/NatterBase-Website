import { AbstractModal } from './Abstract/AbstractModal.js';

export class ConfirmationModal extends AbstractModal {
  private messageElement: HTMLElement;
  private confirmButton: HTMLElement;
  private cancelButton: HTMLElement;
  private onConfirm?: () => void;

  constructor(modalId: string) {
    super(modalId);

    this.messageElement = this.modalElement.querySelector('.modal-message') as HTMLElement;
    this.confirmButton = this.modalElement.querySelector('.confirm-button') as HTMLElement;
    this.cancelButton = this.modalElement.querySelector('.cancel-button') as HTMLElement;

    this.bindEvents();
  }

  private bindEvents(): void {
    if (this.confirmButton) {
      this.confirmButton.addEventListener('click', () => this.handleConfirm());
    }

    if (this.cancelButton) {
      this.cancelButton.addEventListener('click', () => this.close());
    }
  }

  public open(message?: string, onConfirm?: () => void): void {
    if (!message || !onConfirm) {
      throw new Error('message and onConfirm are required');
    }
    this.messageElement.textContent = message;
    this.onConfirm = onConfirm;
    super.open();
  }

  private handleConfirm(): void {
    this.close();
    if (this.onConfirm) {
      this.onConfirm();
    }
  }
}
