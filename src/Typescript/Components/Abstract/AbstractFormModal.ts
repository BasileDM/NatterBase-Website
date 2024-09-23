import { FormValidator } from '../../Utils/FormValidator.js';
import { RequestHelper } from '../../Utils/RequestHelper.js';
import { UiUtils } from '../../Utils/UiUtils.js';
import { Toast } from '../Toast.js';

export class AbstractFormModal {
  private modalElement: HTMLDialogElement;
  private form: HTMLFormElement;
  private submitRoute: string;
  private closeButton: HTMLElement;
  public submitButton: HTMLElement;

  constructor(modalId: string, triggerButtonIds: string[], private formId: string) {
    this.modalElement = document.getElementById(modalId) as HTMLDialogElement;
    this.form = document.getElementById(formId) as HTMLFormElement;
    this.submitRoute = this.form.dataset.route as string;
    this.closeButton = this.modalElement.querySelector('button[id*="close"]') as HTMLElement;
    this.submitButton = this.form.querySelector('button[id*="submit"]') as HTMLElement;

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

    // Submit form button
    if (this.submitButton) {
      this.submitButton.addEventListener('click', async (event) => {
        event.preventDefault();
        await this.handleSubmit();
      });
    }
  }

  private async handleSubmit(): Promise<void> {
    // Get form data
    const formData = new FormData(this.form);
    const formObject = Object.fromEntries(formData.entries());

    try {
      const response = await RequestHelper.post(`/${this.submitRoute}`, formObject)
        .then(RequestHelper.handleResponse);

      if (!response) {
        return;
      }

      if (response.formErrors) {
        new FormValidator(this.formId).displayFormErrors(response.formErrors);
        return;
      }

      this.close();
      new Toast('success', response.message);
      UiUtils.updateInterface();
    }
    catch (error) {
      console.error('Unexpected error: ', error);
      new Toast('error', 'Failed sending request. Try again later.');
    }
  }

  private open(): void {
    this.modalElement.showModal();
  }

  private close(): void {
    this.modalElement.close();
  }
}
