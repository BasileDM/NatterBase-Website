import { FormValidator } from '../../Utils/FormValidator.js';
import { RequestHelper } from '../../Utils/RequestHelper.js';
import { Toast } from '../Toast.js';
export class AbstractFormModal {
    constructor(modalId, triggerButtonIds, formId) {
        this.formId = formId;
        this.modalElement = document.getElementById(modalId);
        this.form = document.getElementById(formId);
        this.submitRoute = this.form.dataset.route;
        this.closeButton = this.modalElement.querySelector('button[id*="close"]');
        this.submitButton = this.form.querySelector('button[id*="submit"]');
        this.bindEvents(triggerButtonIds);
    }
    bindEvents(triggerButtonIds) {
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
    async handleSubmit() {
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
        }
        catch (error) {
            console.error('Unexpected error: ', error);
            new Toast('error', 'Failed sending request. Try again later.');
        }
    }
    open() {
        this.modalElement.showModal();
    }
    close() {
        this.modalElement.close();
    }
}
