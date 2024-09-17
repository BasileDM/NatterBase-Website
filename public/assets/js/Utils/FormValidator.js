export class FormValidator {
    constructor(formId) {
        this.formElement = document.getElementById(formId);
        this.inputFields = this.formElement.querySelectorAll('input');
    }
    displayFormErrors(errors) {
        console.log(errors);
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
            const input = this.formElement.querySelector(`input[id*='${key}']`);
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
