import { Bot } from '../Bot/Bot.js';
import { FormValidator } from '../Utils/FormValidator.js';
import { RequestHelper } from '../Utils/RequestHelper.js';
import { UiUtils } from '../Utils/UiUtils.js';
import { AbstractFormModal } from './Abstract/AbstractFormModal.js';
import { Toast } from './Toast.js';
export class ControlPanel {
    constructor() {
        new AbstractFormModal('create-bot-profile-modal', ['create-bot-profile-btn'], 'create-bot-profile-form');
        this.botProfileSelector = document.getElementById('bot-profiles-selector');
        this.runBotButton = document.getElementById('run-bot-btn');
        this.bot = null;
        this.twitchTokenInput = document.getElementById('account-section-twitchToken');
        this.openAiKeyInput = document.getElementById('account-section-openAiKey');
        this.saveBotSettingsButton = document.getElementById('bot-settings-save-btn');
        this.bindEvents();
        this.twitchTokenInput.value = sessionStorage.getItem('natterbaseTwitchToken') || '';
        this.openAiKeyInput.value = sessionStorage.getItem('natterbaseOpenAiKey') || '';
    }
    bindEvents() {
        // Bot profile selector
        this.botProfileSelector.addEventListener('change', () => {
            UiUtils.updateInterface();
        });
        // Run bot button
        this.runBotButton.addEventListener('click', () => {
            if (this.bot && this.bot.isRunning) {
                this.bot.stop();
                this.runBotButton.innerText = 'Run bot';
            }
            else if (this.bot) {
                this.bot.start();
                this.runBotButton.innerText = 'Stop bot';
            }
            else {
                this.bot = new Bot();
                this.bot.start();
                this.runBotButton.innerText = 'Stop bot';
            }
        });
        // Save bot settings button
        this.saveBotSettingsButton.addEventListener('click', async () => {
            this.submitBotSetting();
        });
        // Local keys
        this.twitchTokenInput.addEventListener('change', () => {
            sessionStorage.setItem('natterbaseTwitchToken', this.twitchTokenInput.value);
            console.log('Twitch token changed:', this.twitchTokenInput.value);
        });
        this.openAiKeyInput.addEventListener('change', () => {
            sessionStorage.setItem('natterbaseOpenAiKey', this.openAiKeyInput.value);
            console.log('OpenAI key changed:', this.openAiKeyInput.value);
        });
    }
    async submitBotSetting() {
        const formData = new FormData(document.getElementById('bot-settings-form'));
        const formObject = Object.fromEntries(formData.entries());
        try {
            const response = await RequestHelper.post('/updateBotProfile?idBot=' + this.botProfileSelector.value, formObject);
            const jsonResponseBody = await RequestHelper.handleResponse(response);
            if (!jsonResponseBody) {
                return;
            }
            if (jsonResponseBody.formErrors) {
                new FormValidator('bot-settings-form').displayFormErrors(jsonResponseBody.formErrors);
                return;
            }
            new Toast('success', jsonResponseBody.message);
            UiUtils.updateInterface();
        }
        catch (error) {
            console.error('Unexpected error: ', error);
            new Toast('error', 'Failed sending request. Try again later.');
        }
    }
}
