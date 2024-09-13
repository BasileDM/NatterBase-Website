export abstract class UIComponent {
  abstract open(): void;
  abstract close(): void;

  bindEvents(triggerId: string, closeButtonId: string): void {
    const triggerButton = document.getElementById(triggerId) as HTMLElement | null;
    const closeButton = document.getElementById(closeButtonId) as HTMLElement | null;

    if (triggerButton) {
      triggerButton.addEventListener('click', () => this.open());
    }

    if (closeButton) {
      closeButton.addEventListener('click', () => this.close());
    }
  }
}
