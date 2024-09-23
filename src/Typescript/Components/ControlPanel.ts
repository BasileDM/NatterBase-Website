import { Bot } from '../Bot/Bot.js';
import { UiUtils } from '../Utils/UiUtils.js';
import { AbstractFormModal } from './Abstract/AbstractFormModal.js';

export class ControlPanel {
  private botProfileSelector: HTMLSelectElement;
  private runBotButton: HTMLElement;
  private bot: Bot | null;

  constructor() {
    new AbstractFormModal(
      'create-bot-profile-modal',
      ['create-bot-profile-btn'],
      'create-bot-profile-form',
    );

    this.botProfileSelector = document.getElementById('bot-profiles-selector') as HTMLSelectElement;
    this.runBotButton = document.getElementById('run-bot-btn') as HTMLElement;
    this.bot = null;
    this.bindEvents();
  }

  private bindEvents() {
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
  }
}
