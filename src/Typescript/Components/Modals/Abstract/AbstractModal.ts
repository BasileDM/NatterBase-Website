export abstract class AbstractModal {
  protected modalElement: HTMLDialogElement;
  protected closeButton: HTMLElement;

  constructor(modalId: string, triggerButtonIds?: string[]) {
    this.modalElement = document.getElementById(modalId) as HTMLDialogElement;
    this.closeButton = this.modalElement.querySelector('button[id*="close"]') as HTMLElement;

    this.bindAbstractEvents(triggerButtonIds);
  }

  protected bindAbstractEvents(triggerButtonIds?: string[]): void {
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

  public open(): void {
    this.modalElement.showModal();
  }

  public close(): void {
    this.modalElement.close();
  }
}
