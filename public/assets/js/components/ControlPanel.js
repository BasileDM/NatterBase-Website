import { Bot } from '../Bot/Bot.js';
import { UiUtils } from '../Utils/UiUtils.js';
import { AbstractFormModal } from './Abstract/AbstractFormModal.js';
export class ControlPanel {
    constructor() {
        new AbstractFormModal('create-bot-profile-modal', ['create-bot-profile-btn'], 'create-bot-profile-form');
        this.botProfileSelector = document.getElementById('bot-profiles-selector');
        this.runBotButton = document.getElementById('run-bot-btn');
        this.bot = null;
        this.twitchTokenInput = document.getElementById('account-section-twitchToken');
        this.openAiKeyInput = document.getElementById('account-section-openAiKey');
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
        this.twitchTokenInput.addEventListener('change', () => {
            sessionStorage.setItem('natterbaseTwitchToken', this.twitchTokenInput.value);
            console.log('Twitch token changed:', this.twitchTokenInput.value);
        });
        this.openAiKeyInput.addEventListener('change', () => {
            sessionStorage.setItem('natterbaseOpenAiKey', this.openAiKeyInput.value);
            console.log('OpenAI key changed:', this.openAiKeyInput.value);
        });
    }
}
