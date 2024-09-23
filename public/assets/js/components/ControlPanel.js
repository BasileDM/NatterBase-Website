import { Bot } from '../Bot/Bot.js';
import { UiUtils } from '../Utils/UiUtils.js';
import { AbstractFormModal } from './Abstract/AbstractFormModal.js';
export class ControlPanel {
    constructor() {
        this.bot = null;
        new AbstractFormModal('create-bot-profile-modal', ['create-bot-profile-btn'], 'create-bot-profile-form');
        this.botProfileSelector = document.getElementById('bot-profiles-selector');
        this.runBotButton = document.getElementById('run-bot-btn');
        this.bindEvents();
    }
    bindEvents() {
        // Bot profile selector
        this.botProfileSelector.addEventListener('change', () => {
            UiUtils.updateInterface();
        });
        // Run bot button
        this.runBotButton.addEventListener('click', () => {
            if (this.bot?.isRunning) {
                this.bot.stop();
                this.runBotButton.innerText = 'Run bot';
            }
            else {
                this.bot = new Bot();
                this.bot.start();
                this.runBotButton.innerText = 'Stop bot';
            }
        });
    }
    ;
}
