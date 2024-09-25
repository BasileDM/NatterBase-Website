export class FormValidator {
  private formElement: HTMLFormElement;
  // eslint-disable-next-line no-undef
  private inputFields: NodeListOf<HTMLInputElement>;

  constructor(formId: string) {
    this.formElement = document.getElementById(formId) as HTMLFormElement;
    this.inputFields = this.formElement.querySelectorAll('input');
  }

  public displayFormErrors(errors: Array<string>): void {
    // Clear any error class or message
    this.inputFields.forEach((input) => {
      input.classList.remove('invalid-input');
      const errorSpan = this.formElement.querySelector(`#${input.id}-error-display`);
      if (errorSpan) {
        errorSpan.textContent = '';
      }
    });

    // Apply new error messages and classes
    for (const key in errors) {
      // Find the input field that has an id that contains the key
      const input = this.formElement.querySelector(`input[id*='${key}']`) as HTMLInputElement;
      if (input) {
        input.classList.add('invalid-input');
        const errorSpan = this.formElement.querySelector(`#${input.id}-error-display`);
        if (errorSpan) {
          errorSpan.textContent = errors[key];
        }
      }
    }
  }

  public static removeFormErrors(formId: string): void {
    const form = document.getElementById(formId) as HTMLFormElement;
    const inputFields = form.querySelectorAll('input');
    inputFields.forEach((input) => {
      input.classList.remove('invalid-input');
    });
    const errorMessages = form.querySelectorAll('.text-red-500');
    errorMessages.forEach((message) => {
      message.textContent = '';
    });
  }
}
