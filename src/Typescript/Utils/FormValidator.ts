/* eslint-disable @typescript-eslint/no-explicit-any */
export class FormValidator {
  private formElement: HTMLFormElement;
  // eslint-disable-next-line no-undef
  private inputFields: NodeListOf<HTMLInputElement>;

  constructor(formId: string) {
    this.formElement = document.getElementById(formId) as HTMLFormElement;
    this.inputFields = this.formElement.querySelectorAll('input, textarea, select');
  }

  public displayFormErrors(errors: any): void {
    // Clear existing error classes and messages
    this.inputFields.forEach((input) => {
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

  public validateForm(): { formErrors: { [key: string]: string } } | null {
    const errors: { [key: string]: string } = {};

    this.inputFields.forEach((inputElement) => {
      const input = inputElement as HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement;
      const value = input.value.trim();
      const name = input.name;

      // Validate each field with name
      if (name === 'mail') {
        if (!value) {
          errors[name] = 'Email is required';
        }
        else if (!this.isValidEmail(value)) {
          errors[name] = 'Invalid email address';
        }
      }
      else if (name === 'username') {
        if (!value) {
          errors[name] = 'Username is required';
        }
        else if (value.length < 3 || value.length > 80) {
          errors[name] = 'Username must be between 3 and 80 characters';
        }
      }
      else if (name === 'password') {
        if (!value) {
          errors[name] = 'Password is required';
        }
        else if (value.length < 8) {
          errors[name] = 'Password must be at least 8 characters long';
        }
      }
      else if (name === 'confirmPassword') {
        const passwordValue = (this.formElement.querySelector('input[name="password"]') as HTMLInputElement).value;
        if (value !== passwordValue) {
          errors[name] = 'Passwords do not match';
        }
      }
      else if (name === 'gdpr') {
        const checked = (input as HTMLInputElement).checked;
        if (!checked) {
          errors[name] = 'You must accept the GDPR';
        }
      }
    });

    return Object.keys(errors).length > 0 ? { formErrors: errors } : null;
  }

  private isValidEmail(email: string): boolean {
    const emailRegex = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;
    return emailRegex.test(email);
  }
}
