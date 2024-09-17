export class FormValidator {
  private formElement: HTMLFormElement;
  // eslint-disable-next-line no-undef
  private inputFields: NodeListOf<HTMLInputElement>;

  constructor(formId: string) {
    this.formElement = document.getElementById(formId) as HTMLFormElement;
    this.inputFields = this.formElement.querySelectorAll('input');
  }

  public displayFormErrors(errors: Array<string>): void {
    console.log(errors);
    // Clear any error class or message
    this.inputFields.forEach((input) => {
      input.classList.remove('invalid-input');
      const errorSpan = this.formElement.querySelector(`.${input.id}-error-display`);
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
}
