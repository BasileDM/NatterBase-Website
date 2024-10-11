/* eslint-disable @typescript-eslint/no-explicit-any */
export class FormValidator {
  private formElement: HTMLFormElement;
  // eslint-disable-next-line no-undef
  private inputFields: NodeListOf<HTMLInputElement>;

  constructor(formId: string) {
    this.formElement = document.getElementById(formId) as HTMLFormElement;
    this.inputFields = this.formElement.querySelectorAll('input');
  }

  public displayFormErrors(errors: any): void {
    // Clear existing error classes and messages
    const inputFields = this.formElement.querySelectorAll('input, textarea, select');
    inputFields.forEach((input) => {
      const inputElement = input as HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement;
      inputElement.classList.remove('invalid-input');
      const errorSpan = this.formElement.querySelector(`#${inputElement.name}-error-display`);
      if (errorSpan) {
        errorSpan.textContent = '';
      }
    });

    const formErrors = errors.formErrors || errors;

    // Loop through each error key
    for (const key in formErrors) {
      const errorValue = formErrors[key];

      // Check if the key is a number (index)
      if (!isNaN(Number(key))) {
        // It's an index, so process nested errors
        const index = key;
        const nestedErrors = errorValue;

        for (const nestedKey in nestedErrors) {
          const errorMessage = nestedErrors[nestedKey];

          // Find the container with the data-index attribute
          const container = this.formElement.querySelector(`[data-index='${index}']`);
          if (container) {
            // Find the input field inside the container by name
            const input = container.querySelector(`input[name='${nestedKey}'], textarea[name='${nestedKey}'], select[name='${nestedKey}']`) as HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement;
            if (input) {
              input.classList.add('invalid-input');
              const errorSpan = container.querySelector(`#${input.name}-error-display`);
              if (errorSpan) {
                errorSpan.textContent = errorMessage;
              }
            }
          }
        }
      }
      else {
        // It's a regular error key, process normally
        const errorMessage = errorValue;
        const input = this.formElement.querySelector(`input[name='${key}'], textarea[name='${key}'], select[name='${key}']`) as HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement;
        if (input) {
          input.classList.add('invalid-input');
          const errorSpan = this.formElement.querySelector(`#${input.name}-error-display`);
          if (errorSpan) {
            errorSpan.textContent = errorMessage;
          }
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
