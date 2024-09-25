import { Bot } from '../Bot/Bot.js';
import { FormValidator } from '../Utils/FormValidator.js';
import { RequestHelper } from '../Utils/RequestHelper.js';
import { UiUtils } from '../Utils/UiUtils.js';
import { AbstractFormModal } from './Abstract/AbstractFormModal.js';
import { Toast } from './Toast.js';
import { UiElements } from '../Utils/UiElements.js';
export class ControlPanel {
    constructor() {
        new AbstractFormModal('create-bot-profile-modal', ['create-bot-profile-btn'], 'create-bot-profile-form');
        this.bot = null;
        this.saveBotSettingsButton = document.getElementById('bot-settings-save-btn');
        this.saveAccountSettingsButton = document.getElementById('account-settings-save-btn');
        this.bindEvents();
        UiElements.twitchTokenInput.value = sessionStorage.getItem('natterbaseTwitchToken') || '';
        UiElements.openAiKeyInput.value = sessionStorage.getItem('natterbaseOpenAiKey') || '';
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
        this.saveBotSettingsButton.addEventListener('click', async () => {
            this.submitBotSetting();
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
        this.saveAccountSettingsButton.addEventListener('click', async () => {
            this.submitAccountSetting();
        });
        // Change password button
        UiElements.changePassBtn.addEventListener('click', async () => {
            UiUtils.displayAccountPassInputs();
        });
    }
    async submitBotSetting() {
        const formData = new FormData(UiElements.botSettingsForm);
        const formObject = Object.fromEntries(formData.entries());
        try {
            const response = await RequestHelper.post('/updateBotProfile?idBot=' + UiElements.botProfileSelector.value, formObject);
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
    async submitAccountSetting() {
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
}
