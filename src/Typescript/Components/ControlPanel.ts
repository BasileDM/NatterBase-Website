import { Bot } from '../Bot/Bot.js';
import { FormValidator } from '../Utils/FormValidator.js';
import { RequestHelper } from '../Utils/RequestHelper.js';
import { UiUtils } from '../Utils/UiUtils.js';
import { AbstractFormModal } from './Abstract/AbstractFormModal.js';
import { Toast } from './Toast.js';

export class ControlPanel {
  private botProfileSelector: HTMLSelectElement;
  private runBotButton: HTMLElement;
  private bot: Bot | null;
  private twitchTokenInput: HTMLInputElement;
  private openAiKeyInput: HTMLInputElement;
  private saveBotSettingsButton: HTMLElement;
  private saveAccountSettingsButton: HTMLElement;
  private changePasswordButton: HTMLElement;

  constructor() {
    new AbstractFormModal(
      'create-bot-profile-modal',
      ['create-bot-profile-btn'],
      'create-bot-profile-form',
    );

    this.botProfileSelector = document.getElementById('bot-profiles-selector') as HTMLSelectElement;
    this.runBotButton = document.getElementById('run-bot-btn') as HTMLElement;
    this.bot = null;
    this.twitchTokenInput = document.getElementById('account-section-twitchToken') as HTMLInputElement;
    this.openAiKeyInput = document.getElementById('account-section-openAiKey') as HTMLInputElement;
    this.saveBotSettingsButton = document.getElementById('bot-settings-save-btn') as HTMLElement;
    this.saveAccountSettingsButton = document.getElementById('account-settings-save-btn') as HTMLElement;
    this.changePasswordButton = document.getElementById('account-settings-password-btn') as HTMLElement;
    this.bindEvents();

    this.twitchTokenInput.value = sessionStorage.getItem('natterbaseTwitchToken') || '';
    this.openAiKeyInput.value = sessionStorage.getItem('natterbaseOpenAiKey') || '';
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

    // Save account settings button
    this.saveAccountSettingsButton.addEventListener('click', async () => {
      this.submitAccountSetting();
    });

    // Change password button
    this.changePasswordButton.addEventListener('click', async () => {
      UiUtils.displayAccountPassInputs();
    });
  }

  private async submitBotSetting() {
    const formData = new FormData(document.getElementById('bot-settings-form') as HTMLFormElement);
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
      const changePassInputs = document.getElementById('account-settings-password-inputs');
      changePassInputs?.classList.add('hidden');
      this.changePasswordButton.classList.remove('hidden');
      UiUtils.updateInterface();
    }
    catch (error) {
      console.error('Unexpected error: ', error);
      new Toast('error', 'Failed sending request. Try again later.');
    }
  }

  private async submitAccountSetting() {
    const formData = new FormData(document.getElementById('account-settings-form') as HTMLFormElement);
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
