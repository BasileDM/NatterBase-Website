export class Modal {
  private modalElement: HTMLDialogElement;
  private closeButtonId: string;

  constructor(modalId: string, triggerButtonIds: string[]) {
    this.modalElement = document.getElementById(modalId) as HTMLDialogElement;
    this.closeButtonId = 'modal-close-btn';
    this.bindEvents(triggerButtonIds);
  }

  open(): void {
    this.modalElement.showModal();
  }

  close(): void {
    this.modalElement.close();
  }

  bindEvents(triggerButtonIds: string[]): void {
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
