import { AbstractModal } from './Abstract/AbstractModal.js';

export class AlertModal extends AbstractModal {
  constructor(modalId: string, triggerButtonIds: string[]) {
    super(modalId);
    this.bindEvents(triggerButtonIds);
  }

  private bindEvents(triggerButtonIds: string[]): void {
    // Open buttons
    triggerButtonIds.forEach(buttonId => {
      const button = document.getElementById(buttonId);
      if (button) {
        button.addEventListener('click', () => this.open());
      }
    });
  }
}
