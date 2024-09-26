/* eslint-disable @typescript-eslint/no-explicit-any */
import { Bot } from '../Bot/Bot.js';
import { FormValidator } from '../Utils/FormValidator.js';
import { RequestHelper } from '../Utils/RequestHelper.js';
import { UiUtils } from '../Utils/UiUtils.js';
import { FormModal } from './Modals/FormModal.js';
import { Toast } from './Toast.js';
import { UiElements } from '../Utils/UiElements.js';
import { ConfirmationModal } from './Modals/ConfirmationModal.js';
export class ControlPanel {
    constructor() {
        new FormModal('create-bot-profile-modal', ['create-bot-profile-btn'], 'create-bot-profile-form');
        this.bot = null;
        this.bindEvents();
        UiElements.twitchTokenInput.value = sessionStorage.getItem('natterbaseTwitchToken') || '';
        UiElements.openAiKeyInput.value = sessionStorage.getItem('natterbaseOpenAiKey') || '';
        this.confirmationModal = new ConfirmationModal('confirmation-modal');
    }
    bindEvents() {
        // Bot profile selector
        UiElements.botProfileSelector.addEventListener('change', () => {
            UiUtils.updateInterface();
        });
        // Run bot button
        UiElements.runBotButton.addEventListener('click', () => {
            if (this.bot && this.bot.isRunning) {
                this.bot.stop();
                UiElements.runBotButton.innerText = 'Run bot';
            }
            else if (this.bot) {
                this.bot.start();
                UiElements.runBotButton.innerText = 'Stop bot';
            }
            else {
                this.bot = new Bot();
                this.bot.start();
                UiElements.runBotButton.innerText = 'Stop bot';
            }
        });
        // Save bot settings button
        UiElements.saveBotSettingsButton.addEventListener('click', async () => {
            this.submitBotSettings();
        });
        // Delete bot profile button
        UiElements.deleteBotProfileButton.addEventListener('click', async () => {
            this.deleteBotProfile();
        });
        // Local keys
        UiElements.twitchTokenInput.addEventListener('change', () => {
            sessionStorage.setItem('natterbaseTwitchToken', UiElements.twitchTokenInput.value);
            console.log('Twitch token changed:', UiElements.twitchTokenInput.value);
        });
        UiElements.openAiKeyInput.addEventListener('change', () => {
            sessionStorage.setItem('natterbaseOpenAiKey', UiElements.openAiKeyInput.value);
            console.log('OpenAI key changed:', UiElements.openAiKeyInput.value);
        });
        // Save account settings button
        UiElements.saveAccountSettingsButton.addEventListener('click', async () => {
            this.submitAccountSettings();
        });
        // Delete account button
        UiElements.deleteAccountButton.addEventListener('click', async () => {
            this.deleteAccount();
        });
        // Change password button
        UiElements.changePassBtn.addEventListener('click', async () => {
            UiUtils.displayAccountPassInputs();
        });
        // Bot features
        UiElements.botFeaturesForm.addEventListener('submit', async (event) => {
            event.preventDefault();
            this.submitBotFeatures();
        });
    }
    async submitBotSettings() {
        const formData = new FormData(UiElements.botSettingsForm);
        const formObject = Object.fromEntries(formData.entries());
        try {
            const botId = UiElements.botProfileSelector.value;
            const response = await RequestHelper.post(`/updateBotProfile?idBot=${botId}`, formObject);
            const jsonResponseBody = await RequestHelper.handleResponse(response);
            if (!jsonResponseBody) {
                return;
            }
            if (jsonResponseBody.formErrors) {
                new FormValidator('bot-settings-form').displayFormErrors(jsonResponseBody.formErrors);
                return;
            }
            new Toast('success', jsonResponseBody.message);
            UiElements.changePassInputsDiv.classList.add('hidden');
            UiElements.changePassBtn.classList.remove('hidden');
            UiUtils.updateInterface();
        }
        catch (error) {
            console.error('Unexpected error: ', error);
            new Toast('error', 'Failed sending request. Try again later.');
        }
    }
    async deleteBotProfile() {
        this.confirmationModal.open('Are you sure you want to delete this bot profile?', async () => {
            try {
                const botId = UiElements.botProfileSelector.value;
                const response = await RequestHelper.delete(`/deleteBotProfile?idBot=${botId}`);
                const jsonResponseBody = await RequestHelper.handleResponse(response);
                if (!jsonResponseBody) {
                    return;
                }
                new Toast('success', jsonResponseBody.message);
                UiElements.botProfileSelector.selectedIndex = 0;
                UiUtils.updateInterface();
            }
            catch (error) {
                console.error('Unexpected error: ', error);
                new Toast('error', 'Failed sending request. Try again later.');
            }
        });
    }
    async submitAccountSettings() {
        const formData = new FormData(UiElements.accountSettingsForm);
        const formObject = Object.fromEntries(formData.entries());
        try {
            const response = await RequestHelper.post('/api/updateUserData', formObject);
            const jsonResponseBody = await RequestHelper.handleResponse(response);
            if (!jsonResponseBody) {
                return;
            }
            if (jsonResponseBody.formErrors) {
                new FormValidator('account-settings-form').displayFormErrors(jsonResponseBody.formErrors);
                return;
            }
            new Toast('success', 'Account settings updated!');
            UiUtils.updateInterface();
        }
        catch (error) {
            console.error('Unexpected error: ', error);
            new Toast('error', 'Failed sending request. Try again later.');
        }
    }
    async deleteAccount() {
        this.confirmationModal.open('This is permanent! Are you sure you want to delete your account?', async () => {
            try {
                const response = await RequestHelper.delete('/api/deleteUser');
                const jsonResponseBody = await RequestHelper.handleResponse(response);
                if (!jsonResponseBody) {
                    return;
                }
                new Toast('success', jsonResponseBody.message);
                sessionStorage.clear();
                window.location.href = '/logout';
            }
            catch (error) {
                console.error('Unexpected error: ', error);
                new Toast('error', 'Failed sending request. Try again later.');
            }
        });
    }
    async submitBotFeatures() {
        // Initialize an empty object to hold the form data
        const formObject = {};
        // Collect feature data based on data-index attribute
        const featureCards = UiElements.botFeaturesForm.querySelectorAll('.feature-card');
        featureCards.forEach((card) => {
            const featureData = {};
            const index = card.getAttribute('data-index') || '0';
            // Collect inputs within the current feature card
            const inputs = card.querySelectorAll('input, select, textarea');
            inputs.forEach((inputElement) => {
                if (inputElement instanceof HTMLInputElement ||
                    inputElement instanceof HTMLSelectElement ||
                    inputElement instanceof HTMLTextAreaElement) {
                    featureData[inputElement.name] = inputElement.value;
                }
            });
            // Assign the feature data to the formObject using the index as a key
            formObject[index] = featureData;
        });
        try {
            const botId = UiElements.botProfileSelector.value;
            const response = await RequestHelper.post(`/updateBotFeatures?idBot=${botId}`, formObject);
            const jsonResponseBody = await RequestHelper.handleResponse(response);
            if (!jsonResponseBody) {
                return;
            }
            if (jsonResponseBody.formErrors) {
                new FormValidator('bot-features-form').displayFormErrors(jsonResponseBody.formErrors);
                return;
            }
            new Toast('success', 'Bot features updated successfully!');
            UiUtils.updateInterface();
        }
        catch (error) {
            console.error('Unexpected error: ', error);
            new Toast('error', 'Failed to save bot features. Try again later.');
        }
    }
}
