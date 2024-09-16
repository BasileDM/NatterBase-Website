import { RequestHelper } from '../Utils/RequestHelper';
import { Toast } from './Toast';

export class LoginModal {
  private modalElement: HTMLDialogElement;
  private closeButton: HTMLElement;
  private submitButton: HTMLElement;

  constructor(modalId: string, triggerButtonIds: string[]) {
    this.modalElement = document.getElementById(modalId) as HTMLDialogElement;
    this.closeButton = document.getElementById('login-modal-close-btn') as HTMLElement;
    this.submitButton = document.getElementById('login-modal-submit-btn') as HTMLElement;
    this.bindEvents(triggerButtonIds);
  }

  private bindEvents(triggerButtonIds: string[]): void {
    triggerButtonIds.forEach(buttonId => {
      const button = document.getElementById(buttonId);
      if (button) {
        button.addEventListener('click', () => this.open());
      }
    });

    if (this.closeButton) {
      this.closeButton.addEventListener('click', () => this.close());
    }

    // Close modal when clicking outside
    this.modalElement.addEventListener('click', (event) => {
      if (event.target === this.modalElement) {
        this.close();
      }
    });

    // Submit button
    if (this.submitButton) {
      this.submitButton.addEventListener('click', async (event) => {
        event.preventDefault();
        const formData = {
          mail: (document.getElementById('mail') as HTMLInputElement).value,
          password: (document.getElementById('password') as HTMLInputElement).value,
        };
        const response = await RequestHelper.post('/login', formData);
        if (response) {
          console.log('successful login');
          window.location.href = '/app';
          new Toast('success', 'You are now logged in !');
          this.close();
        }
      });
    }
  }

  private open(): void {
    this.modalElement.showModal();
  }

  private close(): void {
    this.modalElement.close();
  }
}
